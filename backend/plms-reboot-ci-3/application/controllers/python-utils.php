<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function run_python($sourcecode_filename, $testcase_content, $role)
{
  if ($role == "supervisor") {
    $directory = SUPERVISOR_CFILES_FOLDER;
  } else if ($role == "student") {
    $directory = STUDENT_CFILES_FOLDER;
  }

  $testcase_content = rtrim($testcase_content);
  $infile = $directory . $sourcecode_filename . '.input';
  file_put_contents($infile, $testcase_content);
  $outfile = $directory . $sourcecode_filename . '.outfile';
  if (file_exists($outfile)) {
    exec('rm ' . $outfile);
    return [
      "status" => 0,
      "message" => "outfile already exists",
    ];
  }
  $command = "python3.12 " . $directory . $sourcecode_filename . ' < ' . " $infile > $outfile ";
  $timelimit =  "timelimit -S 9 -T 1 -t 2 ";
  $command = $timelimit . $command;
  shell_exec("ulimit -Sf 100 ");
  shell_exec("ulimit -St 3 ");
  $result = shell_exec("$command");


  exec('rm ' . $infile);

  if (file_exists($outfile)) {
    $output_content = file_get_contents($outfile);
    exec('rm ' . $outfile);
    $result = $output_content;
    $first_colon = strpos($result, ":");
    $output = substr($result, 0, $first_colon + 2);
    $output .= rtrim($testcase_content) . "\n";
    $output .= substr($result, $first_colon + 2, strlen($result) - $first_colon);

    return $output;
  } else {
    $method =  __METHOD__;
    echo "<h1>$method <br/>NO output detected !!!</h1>";
    exit();
  }
}
