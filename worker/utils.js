import fs from 'fs';
import { exec } from 'child_process';
import tmp from 'tmp';

export const ERROR_NAME = {
  RUNTIME_ERROR: "RuntimeError",
  TIMEOUT_ERROR: "TimeoutError",
  OUTPUT_LIMIT_EXCEEDED: "OutputLimitExceeded",
  MEMORY_LIMIT_EXCEEDED: "MemoryLimitExceeded",
  DATABASE_ERROR: "DatabaseError",
  RABBITMQ_ERROR: "RabbitMQError",
  SERVER_ERROR: "ServerError",
  NO_OUTPUT_PRODUCED: "NoOutputProduced",
}

export class AppError extends Error {
  constructor(name, message) {
    super(message);
    this.name = name;
  }
}

// Script configuration
export const TIME_LIMIT = 3;
export const MAX_OUTPUT_SIZE = 1024 * 1024; // 1 MB

export async function runPythonScript(testcase, scriptFileName) {
  // Create a unique temporary file for the input
  const tmpInputFile = tmp.fileSync({ postfix: '.txt' });

  // Write the testcase content to the file
  fs.writeFileSync(tmpInputFile.name, testcase.testcase_content);

  const command = `timeout -k 10 ${TIME_LIMIT}s python3.12 runner.py ${scriptFileName} ${tmpInputFile.name}`;

  return new Promise((resolve, reject) => {
    exec(command, (error, stdout, stderr) => {
      let result = {
        output: null,
      };

      if (error) {
        switch (error.code) {
          case 124:
            reject(new AppError(ERROR_NAME.TIMEOUT_ERROR, "Time limit exceeded"));
          case 137:
            reject(new AppError(ERROR_NAME.MEMORY_LIMIT_EXCEEDED, "Memory limit exceeded"));
          default:
            if (error instanceof RangeError && error.code === 'ERR_CHILD_PROCESS_STDIO_MAXBUFFER') {
              reject(new AppError(ERROR_NAME.OUTPUT_LIMIT_EXCEEDED, "Output limit exceeded"));
            } else if (error.message.includes("MemoryError")) {
              reject(new AppError(ERROR_NAME.MEMORY_LIMIT_EXCEEDED, "Memory limit exceeded"));
            }
            else {
              reject(new AppError(ERROR_NAME.RUNTIME_ERROR, error.message || "An error occurred while executing the script"));
            }
        }
      }

      if (stderr) {
        reject(new AppError(ERROR_NAME.RUNTIME_ERROR, stderr));
      }

      if (stdout) {
        // Convert string to bytes
        const byteSize = Buffer.byteLength(stdout, 'utf8');

        if (byteSize > MAX_OUTPUT_SIZE) {
          reject(new AppError(ERROR_NAME.OUTPUT_LIMIT_EXCEEDED, "Output limit exceeded"));
        }

        result.output = stdout;
      } else {
        reject(new AppError(ERROR_NAME.NO_OUTPUT_PRODUCED, "No output produced"));
      }

      tmpInputFile.removeCallback();

      resolve(result);
    });
  });
}

export async function runPythonScriptWithoutTestcase(scriptFileName) {
  const command = `timeout -k 10 ${TIME_LIMIT}s python3.12 runner.py ${scriptFileName}`;

  return new Promise((resolve, reject) => {
    exec(command, (error, stdout, stderr) => {
      let result = {
        output: null,
      };

      if (error) {
        switch (error.code) {
          case 124:
            reject(new AppError(ERROR_NAME.TIMEOUT_ERROR, "Time limit exceeded"));
          case 137:
            reject(new AppError(ERROR_NAME.MEMORY_LIMIT_EXCEEDED, "Memory limit exceeded"));
          default:
            if (error instanceof RangeError && error.code === 'ERR_CHILD_PROCESS_STDIO_MAXBUFFER') {
              reject(new AppError(ERROR_NAME.OUTPUT_LIMIT_EXCEEDED, "Output limit exceeded"));
            } else if (error.message.includes("MemoryError")) {
              reject(new AppError(ERROR_NAME.MEMORY_LIMIT_EXCEEDED, "Memory limit exceeded"));
            }
            else {
              reject(new AppError(ERROR_NAME.RUNTIME_ERROR, error.message || "An error occurred while executing the script"));
            }
        }
      }

      if (stderr) {
        reject(new AppError(ERROR_NAME.RUNTIME_ERROR, stderr));
      }

      if (stdout) {
        // Convert string to bytes
        const byteSize = Buffer.byteLength(stdout, 'utf8');

        if (byteSize > MAX_OUTPUT_SIZE) {
          reject(new AppError(ERROR_NAME.OUTPUT_LIMIT_EXCEEDED, "Output limit exceeded"));
        }

        result.output = stdout;
      } else {
        reject(new AppError(ERROR_NAME.NO_OUTPUT_PRODUCED, "No output produced"));
      }

      resolve(result);
    });
  });
}

// async function checkKeywordConstraints(keyword_constraints, sourcecode) {
//   const command = `python3.12 kw_checker.py ${sourcecode} ${keyword_constraints}`;

//   return new Promise((resolve, reject) => {
//     exec(command, (error, stdout, stderr) => {
//       if (error) {
//         reject("Error : " + error.message);
//       } else if (stderr) {
//         reject("Error : " + stderr);
//       }

//       resolve(stdout);
//     });
//   })
// }