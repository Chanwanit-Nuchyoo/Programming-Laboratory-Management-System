import fs from 'fs';
import { exec } from 'child_process';
import tmp from 'tmp';

// Script configuration
const TIME_LIMIT = 3;

async function runPythonScript(testcase, scriptFileName) {
  // Create a unique temporary file for the input
  const tmpInputFile = tmp.fileSync({ postfix: '.txt' });

  // Write the testcase content to the file
  fs.writeFileSync(tmpInputFile.name, testcase.testcase_content);

  const command = `timeout ${TIME_LIMIT} python3.12 runner.py ${scriptFileName} ${tmpInputFile.name}`;

  return new Promise((resolve, reject) => {
    exec(command, (error, stdout, stderr) => {
      let result = {
        output: null,
        error: null,
      };

      if (stderr) {
        result.error = stderr;
      } else if (error) {
        if (error && error.code === 124) {
          result.error = "Time limit exceeded";
        } else if (error) {
          console.log(error);
          result.error = error.message || "An error occurred while executing the script";
        } else if (!stdout.trimEnd()) {
          result.error = "The script didn't produce any output";
        } else {
          result.output = stdout.trimEnd();
        }
      } else {
        const MAX_OUTPUT_SIZE = 1024 * 1024;  // 1MB in bytes

        // Convert string to bytes
        const byteSize = Buffer.byteLength(stdout, 'utf8');

        if (byteSize > MAX_OUTPUT_SIZE) {
          result.error = 'Output exceeds 1MB limit';
        } else {
          result.output = stdout.trimEnd();
        }
      }

      // Remove the temporary input file
      tmpInputFile.removeCallback();

      resolve(result);
    });
  });
}

async function updateTestcase(db_connection, exercise_id, testcase) {
  const sql = `UPDATE exercise_testcase SET testcase_id = ?, exercise_id = ?, testcase_content = ?, is_ready = ?,active = ?, show_to_student = ?,  testcase_note = ?, testcase_output = ?, testcase_error = ? WHERE testcase_id = ? AND exercise_id = ?;`

  const values = [testcase.testcase_id, exercise_id, testcase.testcase_content, 'yes', testcase.active, testcase.show_to_student, testcase.testcase_note, testcase.testcase_output, testcase.testcase_error, testcase.testcase_id, exercise_id]

  return new Promise((resolve, reject) => {
    db_connection.beginTransaction(err => {
      if (err) {
        console.log(err);
        reject(err);
      } else {
        db_connection.query(sql, values, (err, result) => {
          if (err) {
            console.log(err);
            db_connection.rollback(() => {
              reject(err);
            });
          } else {
            db_connection.commit(err => {
              if (err) {
                console.log(err);
                db_connection.rollback(() => {
                  reject(err);
                });
              } else {
                console.log("Number of records inserted: " + result.affectedRows);
                resolve(result);
              }
            });
          }
        });
      }
    });
  });
}

export async function addAndUpdateTestcase(channel, db_connection, msg, msg_body) {
  const { exercise_id, sourcecode, testcase_list } = msg_body;

  // Create a unique temporary file
  const tmpFile = tmp.fileSync({ postfix: '.py' });

  // Write the source code to the file
  fs.writeFileSync(tmpFile.name, sourcecode);

  try {
    // Run the script for each testcase
    console.log("=".repeat(60));

    let i = 1;
    for (const testcase of testcase_list) {
      const result = await runPythonScript(testcase, tmpFile.name);

      console.log(`Testcase ${i}`)
      console.log(`${JSON.stringify(result)}`)
      i++

      // Check if there was an error and if it's one of the expected errors
      if (result.error && ["Time limit exceeded", "stderr maxBuffer exceeded"].includes(result.error.trimEnd())) {
        // Update the testcase error with the message
        testcase.testcase_error = result.error.trimEnd();

        // Update the remaining testcases with the same error
        for (const remainingTestcase of testcase_list.slice(testcase_list.indexOf(testcase))) {
          remainingTestcase.testcase_error = result.error.trimEnd();
          await updateTestcase(db_connection, exercise_id, remainingTestcase);
          console.log(`Testcase ${i}`)
          console.log(`${JSON.stringify(result)}`)
          i++
        }

        // Break the loop
        break;
      } else {
        // Update the testcase with the output and error
        testcase.testcase_output = result.output;
        testcase.testcase_error = result.error;
      }

      // Update the testcase in the database
      await updateTestcase(db_connection, exercise_id, testcase);
    }
    console.log("=".repeat(60));

    // Acknowledge the message
    channel.ack(msg);
  } catch (err) {
    console.log(err);
  } finally {
    // Remove the temporary file
    tmpFile.removeCallback();
  }
}

async function checkKeywordConstraints(keyword_constraints, sourcecode) {
  const command = `python3.12 kw_checker.py ${sourcecode} ${keyword_constraints}`;

  return new Promise((resolve, reject) => {
    exec(command, (error, stdout, stderr) => {
      if (error) {
        reject("Error : " + error.message);
      } else if (stderr) {
        reject("Error : " + stderr);
      }

      resolve(stdout);
    });
  })
}

async function updateSubmission(db_connection, submission_data) {
  const sql = `UPDATE exercise_submission SET 
  is_ready = ?, 
  con_passed = ?, 
  marking = ?,
  result = ?
  WHERE submission_id = ?;`

  const values = ['yes', submission_data.con_passed, submission_data.marking, submission_data.result, submission_data.submission_id]

  return new Promise((resolve, reject) => {
    db_connection.beginTransaction(err => {
      if (err) {
        reject(err);
      } else {
        db_connection.query(sql, values, (err, result) => {
          if (err) {
            db_connection.rollback(() => {
              reject(err);
            });
          } else {
            db_connection.commit(err => {
              if (err) {
                db_connection.rollback(() => {
                  reject(err);
                });
              } else {
                resolve(result);
              }
            });
          }
        });
      }
    });
  })
}

export async function runSubmission(channel, db_connection, msg, msg_body) {
  const { submission_id, sourcecode, testcase_list, keyword_constraints } = msg_body;

  const tmpFile = tmp.fileSync({ postfix: '.py' });
  const tmpFile2 = tmp.fileSync({ postfix: '.json' });

  fs.writeFileSync(tmpFile.name, sourcecode);

  try {
    console.log("\n\n");
    console.log("=".repeat(60));
    console.log(`SUBMISSION ID : ${submission_id}`);
    console.log("=".repeat(60));
    console.log("\n\n");

    console.log("-".padEnd(60, '-'));
    let is_con_passed = true;
    if (keyword_constraints) {
      fs.writeFileSync(tmpFile2.name, JSON.stringify(JSON.parse(keyword_constraints)));

      const result = await checkKeywordConstraints(tmpFile2.name, tmpFile.name);
      if (result.trimEnd() !== "true") {
        is_con_passed = false;
      }
    }

    console.log((is_con_passed ? "CONSTRAINTS PASSED" : "CONSTRAINTS FAILED"));
    console.log("-".padEnd(60, '-'));
    console.log("\n");

    if (is_con_passed) {
      console.log("RUNNING TESTCASE".padStart(30, '-').padEnd(60, '-'));
      console.log("\n");

      const testcase_result = await Promise.all(testcase_list.map(async (testcase, i) => {
        const result = await runPythonScript(testcase, tmpFile.name);

        const passed = !result.error && result.output && result.output.trimEnd() === testcase.testcase_output.trimEnd();

        console.log(`Testcase ${i + 1}: ${passed ? "PASSED" : "FAILED"}`);
        if (result.error) {
          console.log(`Error: `);
          console.log(result.error);
        } else {
          console.log(`Output: `);
          console.log(result.output.trimEnd())
        }
        console.log("\n");

        return {
          testcase_no: i + 1,
          is_passed: passed,
          expected: testcase.testcase_output.trimEnd(),
          actual: result.output,
          error: result.error,
        }
      }));

      const is_passed_all_testcase = testcase_result.every(testcase => testcase.is_passed);
      const student_marking = is_passed_all_testcase ? "2" : "0";

      const submission_data = {
        submission_id: submission_id,
        con_passed: "yes",
        marking: student_marking,
        result: JSON.stringify(testcase_result),
      }

      await updateSubmission(db_connection, submission_data);

      console.log("FINISHED TESTCASE".padStart(30, '-').padEnd(60, '-'));
      console.log("\n");
    } else {
      const submission_data = {
        submission_id: submission_id,
        con_passed: "no",
        marking: "0",
        result: "[]",
      }

      await updateSubmission(db_connection, submission_data);
    }

    console.log(`${"=".repeat(60)}\n`);
    channel.ack(msg);
  } catch (err) {
    console.log(err);
  } finally {
    tmpFile.removeCallback();
    tmpFile2.removeCallback();
  }
}