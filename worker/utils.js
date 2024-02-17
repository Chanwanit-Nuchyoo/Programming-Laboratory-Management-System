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
  PUBLISH_ERROR: "PublishError",
}

export class AppError extends Error {
  constructor(name, message, stdout = '') {
    super(message);
    this.name = name;
    this.stdout = stdout;
    Error.captureStackTrace(this, this.constructor);
  }
}

// Script configuration
export const TIME_LIMIT = 3;
export const MAX_OUTPUT_SIZE = 1024 * 1024; // 1 MB

function getStdOutBeforeError(stdout) {
  const lines = stdout.split('\n');
  let stdout_before_error = "";

  if (lines.length > 50) {
    const first50Lines = lines.slice(0, 50).join('\n');
    stdout_before_error = first50Lines + `\n... and ${lines.length - 50} more lines`;
  } else {
    stdout_before_error = lines.join('\n');
  }

  return stdout_before_error;
}

function processStdout(stdout) {
  // Convert string to bytes
  const byteSize = Buffer.byteLength(stdout, 'utf8');

  if (byteSize > MAX_OUTPUT_SIZE) {
    throw new AppError(ERROR_NAME.OUTPUT_LIMIT_EXCEEDED, "Output limit exceeded");
  }

  if (!stdout) {
    throw new AppError(ERROR_NAME.NO_OUTPUT_PRODUCED, "No output produced");
  }

  return stdout;
}

function handleExecError(error, stdout) {
  const stdout_before_error = getStdOutBeforeError(stdout);

  switch (error.code) {
    case 124:
      throw new AppError(ERROR_NAME.TIMEOUT_ERROR, "Time limit exceeded", stdout_before_error);
    case 137:
      throw new AppError(ERROR_NAME.MEMORY_LIMIT_EXCEEDED, "Memory limit exceeded", stdout_before_error);
    default:
      if (error instanceof RangeError && error.code === 'ERR_CHILD_PROCESS_STDIO_MAXBUFFER') {
        throw new AppError(ERROR_NAME.OUTPUT_LIMIT_EXCEEDED, "Output limit exceeded", stdout_before_error);
      } else if (error.message.includes("MemoryError")) {
        throw new AppError(ERROR_NAME.MEMORY_LIMIT_EXCEEDED, "Memory limit exceeded", stdout_before_error);
      }
      else {
        throw new AppError(ERROR_NAME.RUNTIME_ERROR, error.message || "An error occurred while executing the script", stdout_before_error);
      }
  }
}

function executeCommand(command) {
  return new Promise((resolve, reject) => {
    exec(command, (error, stdout, stderr) => {
      if (error) {
        try {
          handleExecError(error, stdout);
        } catch (err) {
          reject(err);
        }
      }

      if (stderr) {
        const stdout_before_error = getStdOutBeforeError(stdout);
        reject(new AppError(ERROR_NAME.RUNTIME_ERROR, stderr, stdout_before_error));
      }

      try {
        const output = processStdout(stdout);
        resolve({ output });
      } catch (err) {
        reject(err);
      }
    });
  });
}

export async function runPythonScript(testcase, scriptFileName) {
  // Create a unique temporary file for the input
  const tmpInputFile = tmp.fileSync({ postfix: '.txt' });

  // Write the testcase content to the file
  fs.writeFileSync(tmpInputFile.name, testcase.testcase_content);

  const command = `timeout -k 10 ${TIME_LIMIT}s python3.12 runner.py ${scriptFileName} ${tmpInputFile.name}`;

  return executeCommand(command)
    .finally(() => tmpInputFile.removeCallback());
}

export async function runPythonScriptWithoutTestcase(scriptFileName) {
  const command = `timeout -k 10 ${TIME_LIMIT}s python3.12 runner.py ${scriptFileName}`;

  return executeCommand(command);
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