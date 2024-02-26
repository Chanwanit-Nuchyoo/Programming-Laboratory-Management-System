import fs from 'fs';
import tmp from 'tmp';
import { AppError, ERROR_NAME, runPythonScript, runPythonScriptWithoutTestcase } from "./utils.js";

async function updateSubmission(db_pool, submission_data) {
  const { submission_id, status, marking, result, error_message } = submission_data;

  const sql = `UPDATE exercise_submission SET 
  status = ?, 
  marking = ?, 
  result = ?,
  error_message = ?
  WHERE submission_id = ?;`

  const values = [status, marking, result, error_message, submission_id]

  return new Promise((resolve, reject) => {
    db_pool.getConnection((err, connection) => {
      if (err) {
        reject(new AppError(ERROR_NAME.DATABASE_ERROR, "Failed to connect to the database."));
      }
      connection.beginTransaction(err => {
        if (err) {
          connection.release(); // Release the connection here
          reject(new AppError(ERROR_NAME.DATABASE_ERROR, err.message));
        } else {
          connection.query(sql, values, (err, result) => {
            if (err) {
              connection.rollback(() => {
                connection.release(); // And here
                reject(new AppError(ERROR_NAME.DATABASE_ERROR, err.message));
              });
            } else {
              connection.commit(err => {
                if (err) {
                  connection.rollback(() => {
                    connection.release(); // And here
                    reject(new AppError(ERROR_NAME.DATABASE_ERROR, err.message));
                  });
                } else {
                  connection.release(); // And finally here
                  resolve(result);
                }
              });
            }
          });
        }
      });
    });
  })
}

export async function runSubmission(channel, db_pool, msg, msg_body, redisClient) {
  const { submission_id, sourcecode, testcase_list, job_id } = msg_body;

  const publisher = redisClient.duplicate();
  await publisher.connect();

  const tmpFile = tmp.fileSync({ postfix: '.py' });
  const tmpFile2 = tmp.fileSync({ postfix: '.json' });

  fs.writeFileSync(tmpFile.name, sourcecode);

  const testcase_result = [];
  try {
    if (testcase_list.length > 0) {
      for (let i = 0; i < testcase_list.length; i++) {
        let result;
        try {
          result = await runPythonScript(testcase_list[i], tmpFile.name);

          const passed = result.output.trimEnd() === testcase_list[i].testcase_output.trimEnd();

          console.log(`Testcase ${i + 1}: ${passed ? "PASSED" : "FAILED"}`);
          console.log(`Output: `);
          console.log(result.output.trimEnd())

          testcase_result.push({
            testcase_no: i + 1,
            is_passed: passed,
            expected: testcase_list[i].testcase_output.trimEnd(),
            actual: result.output.trimEnd(),
          });

        } catch (error) {
          console.log(`Testcase ${i + 1}: FAILED`);
          console.log(`Error: `);
          throw error;
        }
      }

      const is_passed_all_testcase = testcase_result.every(testcase => testcase.is_passed);
      const student_marking = is_passed_all_testcase ? 2 : 0;

      const submission = {
        submission_id: submission_id,
        status: student_marking === 2 ? "accepted" : "wrong_answer",
        marking: student_marking,
        result: JSON.stringify(testcase_result),
        error_message: null
      }

      await updateSubmission(db_pool, submission).catch(err => {
        throw err;
      });
    } else {
      const result = await runPythonScriptWithoutTestcase(tmpFile.name);

      console.log("Output: ");
      console.log(result.output.trimEnd())

      const submission = {
        submission_id: submission_id,
        status: "accepted",
        marking: 2,
        result: JSON.stringify(result.output.trimEnd()),
        error_message: null
      }

      await updateSubmission(db_pool, submission).catch(err => {
        throw err;
      });
    }

    console.log(testcase_list.length > 0 ? "\n" + "FINISHED TESTCASE".padStart(30, '-').padEnd(60, '-') : "\n" + "FINISHED RUNNING".padStart(30, '-').padEnd(60, '-'));
    console.log("\n");

    console.log(`${"=".repeat(60)}\n`);
    channel.ack(msg);
  } catch (err) {
    console.error(err)

    if (err instanceof AppError && err.name === ERROR_NAME.DATABASE_ERROR) {
      channel.nack(msg);
    } else {
      const submission = {
        submission_id: submission_id,
        status: "error",
        marking: 0,
        result: err.stdout ? JSON.stringify(err.stdout) : JSON.stringify([]),
        error_message: err.message
      }

      try {
        await updateSubmission(db_pool, submission);
        channel.ack(msg);
      } catch (err) {
        console.error(err)
        channel.nack(msg);
      }
    }

  } finally {
    // publish message
    await publisher.publish(`submission-result:${job_id}`, "done");
    publisher.quit();
    tmpFile.removeCallback();
    tmpFile2.removeCallback();
  }
}