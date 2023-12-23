<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/* 
 | 
 | Use for Auth system
 |
 |
*/
defined('ERR_NONE')					OR define('ERR_NONE', 0);
defined('ERR_INVALID_USERNAME')		OR define('ERR_INVALID_USERNAME', 1);
defined('ERR_INVALID_PASSWORD')		OR define('ERR_INVALID_PASSWORD', 2);
defined('ERR_REPEAT_LOGIN')			OR define('ERR_REPEAT_LOGIN', 3);
defined('ERR_UNMATCH_SESSION')		OR define('ERR_UNMATCH_SESSION', 4);
defined('ERR_CLASS_LOGIN_NOT_ALLOW')		OR define('ERR_CLASS_LOGIN_NOT_ALLOW', 5);

/* 
 | 
 | Use for PLMS system
 |
 |
*/
defined('STUDENT_AVATAR_FOLDER')	OR define('STUDENT_AVATAR_FOLDER', 'student_data/avatar/');
defined('STUDENT_CFILES_FOLDER')	OR define('STUDENT_CFILES_FOLDER', 'student_data/c_files/');
defined('STUDENT_PYFILES_FOLDER')	OR define('STUDENT_PYFILES_FOLDER', 'student_data/py_files/');
defined('STUDENT_EXE_FOLDER')		OR define('STUDENT_EXE_FOLDER', 'student_data/exe_files/');
defined('STU_SUBMIT_OUTPUT_FOLDER')		OR define('STU_SUBMIT_OUTPUT_FOLDER', 'student_data/submission_output/');
//defined('STUDENT_LOGFILES_FOLDER')	OR define('STUDENT_LOGFILES_FOLDER', 'logfilesstudent_data/c_files');
defined('SUPERVISOR_AVATAR_FOLDER')	OR define('SUPERVISOR_AVATAR_FOLDER', 'supervisor_data/avatar/');
defined('SUPERVISOR_CFILES_FOLDER')	OR define('SUPERVISOR_CFILES_FOLDER', 'supervisor_data/c_files/');
defined('SUPERVISOR_EXE_FOLDER')	OR define('SUPERVISOR_EXE_FOLDER', 'supervisor_data/exe_files/');


defined('ADMIN_DATA_FOLDER')		OR define('ADMIN_DATA_FOLDER', 'admin_data/');
defined('COMPILER')					OR define('COMPILER', 'C:\TinyC\tiny_c/');

defined('TAB')						OR define('TAB',chr(9));
defined('NEWLINE')					OR define('NEWLINE',chr(10));
//time limit = 60 minutes
defined('TIME_LIMIT_IN_MINUTE')		OR define('TIME_LIMIT_IN_MINUTE',120);
defined('MAX_RUN_TIME_IN_SECOND')	OR define('MAX_RUN_TIME_IN_SECOND',60);
defined('MAX_OUTPUT_LENGTH_PER_TESTCASE')		OR define('MAX_OUTPUT_LENGTHPER_TESTCASE',2048);
defined('MAX_OUTPUT_LENGTH_PER_ITEM')		OR define('MAX_OUTPUT_LENGTH_PER_ITEM',16384);
defined('TESTCASE_STRING')			OR define('TESTCASE_STRING', 'testcase_no__');