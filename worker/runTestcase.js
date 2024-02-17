import fs from 'fs';
import tmp from 'tmp';
import { AppError, ERROR_NAME, runPythonScript } from './utils.js';


async function updateTestcase(db_connection, exercise_id, testcase) {
  const sql = `UPDATE exercise_testcase 
  SET testcase_id = ?, 
  exercise_id = ?, 
  testcase_content = ?, 
  is_ready = ?,
  active = ?, 
  show_to_student = ?, 
  testcase_note = ?, 
  testcase_output = ?, 
  testcase_error = ? 
  WHERE testcase_id = ? AND exercise_id = ?;`

  const values = [testcase.testcase_id, exercise_id, testcase.testcase_content, 'yes', testcase.active, testcase.show_to_student, testcase.testcase_note, testcase.testcase_output, testcase.testcase_error, testcase.testcase_id, exercise_id]

  return new Promise((resolve, reject) => {
    db_connection.beginTransaction(err => {
      if (err) {
        console.log(err);
        reject(new AppError(ERROR_NAME.DATABASE_ERROR, err.message));
      } else {
        db_connection.query(sql, values, (err, result) => {
          if (err) {
            console.log(err);
            db_connection.rollback(() => {
              reject(new AppError(ERROR_NAME.DATABASE_ERROR, err.message));
            });
          } else {
            db_connection.commit(err => {
              if (err) {
                console.log(err);
                db_connection.rollback(() => {
                  reject(new AppError(ERROR_NAME.DATABASE_ERROR, err.message));
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

export async function addAndUpdateTestcase(channel, db_connection, msg, msg_body, redisClient) {
  const { exercise_id, sourcecode, testcase_list, job_id } = msg_body;

  const publisher = redisClient.duplicate();
  await publisher.connect();

  // Create a unique temporary file
  const tmpFile = tmp.fileSync({ postfix: '.py' });

  // Write the source code to the file
  fs.writeFileSync(tmpFile.name, sourcecode);

  printMessage('Run testcase for exercise: ' + exercise_id);

  try {
    for (let i = 0; i < testcase_list.length; i++) {
      let result;
      try {
        result = await runPythonScript(testcase_list[i], tmpFile.name);

        printMessage(`Testcase ${i + 1}`);
        printMessage(`Output: `);
        printMessage(result.output.trimEnd());

        await updateTestcase(db_connection, exercise_id, {
          ...testcase_list[i],
          testcase_output: result.output.trimEnd(),
          testcase_error: null
        });
      } catch (err) {
        printMessage(`Error in testcase ${i + 1}: ${err.message}`);

        // Update the failed testcase with the error message
        await updateTestcase(db_connection, exercise_id, {
          ...testcase_list[i],
          testcase_output: err instanceof AppError ? err.stdout : null,
          testcase_error: err.message
        });

        // Update the remaining testcases with a message indicating they did not run
        for (let j = i + 1; j < testcase_list.length; j++) {
          await updateTestcase(db_connection, exercise_id, {
            ...testcase_list[j],
            testcase_output: null,
            testcase_error: "Error occurred before this testcase"
          });
        }

        // Acknowledge the message and stop processing
        channel.ack(msg);
        return;
      }
    }

    // Acknowledge the message
    channel.ack(msg);
  } catch (err) {
    console.error(err);
    channel.nack(msg);
  } finally {
    // Publish the error message
    await publisher.publish(`testcase-result:${job_id}`, "done");
    publisher.quit();
    // Remove the temporary file
    tmpFile.removeCallback();
    printMessage();
  }
}

function printMessage(message = '') {
  console.log("=".repeat(60));
  console.log("\n");
  console.log(message);
  console.log("\n");
}
