import fs from 'fs';
import { exec } from 'child_process';
import tmp from 'tmp';

// Script configuration
const TIME_LIMIT = 3;

export async function runPythonScript(testcase, scriptFileName) {
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
        } else if (!stdout) {
          result.error = "The script didn't produce any output";
        } else {
          result.output = stdout;
        }
      } else {
        if (stdout.length < 4096) {
          result.output = stdout;
        } else {
          result.error = "Output exceeds 4096 characters"
        }
      }

      // Remove the temporary input file
      tmpInputFile.removeCallback();

      resolve(result);
    });
  });
}

export async function updateTestcase(db_connection, exercise_id, testcase) {
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
    for (const testcase of testcase_list) {
      const result = await runPythonScript(testcase, tmpFile.name);

      console.log(result);

      // Update the testcase with the output and error
      testcase.testcase_output = result.output;
      testcase.testcase_error = result.error;

      // Update the testcase in the database
      await updateTestcase(db_connection, exercise_id, testcase);
      console.log(`Updated testcase ${testcase.testcase_id}`);
    }

    // Acknowledge the message
    channel.ack(msg);
  } catch (err) {
    console.log(err);
  } finally {
    // Remove the temporary file
    tmpFile.removeCallback();
  }
}