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

export async function addAndUpdateTestcase(channel, db_connection, msg, msg_body) {
  const { exercise_id, sourcecode, testcase_list } = msg_body;

  // Create a unique temporary file
  const tmpFile = tmp.fileSync({ postfix: '.py' });

  // Write the source code to the file
  fs.writeFileSync(tmpFile.name, sourcecode);

  console.log("=".repeat(60))

  console.log("\n")
  console.log('Run testcase for exercise: ' + exercise_id);
  console.log("\n")

  const testcase_result = [];
  try {
    for (let i = 0; i < testcase_list.length; i++) {
      let result;
      try {
        result = await runPythonScript(testcase_list[i], tmpFile.name);

        console.log(`Testcase ${i + 1}`)
        console.log(`Output: `);
        console.log(result.output.trimEnd())

        testcase_result.push({
          ...testcase_list[i],
          testcase_output: result.output.trimEnd(),
          testcase_error: null
        });
      } catch (err) {

        if (err instanceof AppError) {

          if ([ERROR_NAME.TIMEOUT_ERROR, ERROR_NAME.MEMORY_LIMIT_EXCEEDED, ERROR_NAME.OUTPUT_LIMIT_EXCEEDED, ERROR_NAME.DATABASE_ERROR].includes(err.name)) {
            testcase_result.push({
              ...testcase_list[i],
              testcase_output: null,
              testcase_error: err.message
            });
            throw err
          }
        }

        testcase_result.push({
          ...testcase_list[i],
          testcase_output: null,
          testcase_error: err.message
        });
      }
    }

    // Update the testcase in the database
    for (const testcase of testcase_result) {
      await updateTestcase(db_connection, exercise_id, testcase).catch(err => {
        throw err;
      });
    }

    // Acknowledge the message
    channel.ack(msg);
  } catch (err) {
    if (err instanceof AppError && err.name === ERROR_NAME.DATABASE_ERROR) {
      channel.nack(msg);
    } else {
      try {
        const index_before_error = testcase_result.length

        const testcase_list_after_error = testcase_list.slice(index_before_error)

        const result = [...testcase_result]

        for (const testcase of testcase_list_after_error) {
          result.push({
            ...testcase,
            testcase_output: null,
            testcase_error: "Error occurred before this testcase"
          })
        }

        for (const testcase of result) {
          await updateTestcase(db_connection, exercise_id, testcase)
        }

        channel.ack(msg);
      } catch (err) {
        console.error(err)
        channel.nack(msg);
      }
    }
  } finally {
    // Remove the temporary file
    tmpFile.removeCallback();
    console.log("\n")
    console.log("=".repeat(60))
    console.log("\n")
  }
}