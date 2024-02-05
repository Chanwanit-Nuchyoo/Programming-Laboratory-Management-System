<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for (all) non logged in users
 */
class Exercise_test extends CI_Controller
{
	public $compiler = 'gcc ';
	private $exercise_id = -1; //unintialize
	private $num_testcase = -1; //uninitialze

	public function __construct()
	{
		//parent::__construct();
		//echo __METHOD__."<br>";
		//echo "<pre>";

		//echo "</pre>";
		//echo "<pre>";
		//print_r($_SESSION);
		//echo "</pre>";

	}


	public function index()
	{
		echo __METHOD__;
		$command = "gcc helloworld.c -o helloworld";
		//exec($command);
		$output = shell_exec("/opt/lampp/htdocs/compro17s1/application/controllers/helloworld");
		echo "output : " . $output . "<br>";
	}
	//	mode is to choose where to keep .exe file  --> 'student' or 'supervisor'

	public function get_result_noinput($sourcecode, $mode)
	{
		//echo "<h2>".__METHOD__." : ".SUPERVISOR_CFILES_FOLDER.$sourcecode."</h2>";
		$ext = substr(strrchr($sourcecode, '.'), 1);
		//echo "<h2> filename = $sourcecode </h2>";
		//echo "<h2> extension = $ext </h2>";
		//echo "<h2> mode = $mode </h2>";



		if ($ext == "c") {
			return $this->get_result_noinput_c($sourcecode, $mode);
		} else if ($ext == "py") {
			return $this->get_result_noinput_py($sourcecode, $mode);
		} else {
			return "Invalid file type";
		}
	}


	//	mode is to choose where to keep .exe file  --> 'student' or 'supervisor'

	public function get_result_noinput_c($sourcecode, $mode)
	{

		//set compiler
		$compiler = $this->compiler;

		//set sourcecode to be compiled
		$source = "";
		$filename = "";
		$output_file = "";

		if ($mode == "supervisor") {
			$source = realpath(SUPERVISOR_CFILES_FOLDER . $sourcecode);
			$filename = pathinfo($source, PATHINFO_FILENAME);
			$output_file = FCPATH . SUPERVISOR_EXE_FOLDER . $filename . ".exe";
		} else {
			$source = realpath(STUDENT_CFILES_FOLDER . $sourcecode);
			$filename = pathinfo($source, PATHINFO_FILENAME);
			$output_file = FCPATH . STUDENT_EXE_FOLDER . $filename . ".exe";
			$output_cmd = "-o " . $output_file;
		}

		//echo "<h3>source file : "	.$source."</h3>";
		//echo "<h3>filename : "		.$filename. "</h3>";
		//echo "<h3>output file1 : "	.$output_file."</h3>"; 


		//echo "<h1>Compiling fil22e : ".$source."</h1>"; 
		$output_result = exec("$compiler $source -o $output_file");

		//echo "<h1>output_result33 : ".$output_result."</h1>"; 		
		$output_result = shell_exec($output_file);
		$output = $this->unify_whitespace($output_result);
		//echo "<h3>output_result55 : "	.$output_result."</h3>"; 

		return ($output_result);
	}

	//	mode is to choose where to keep .exe file  --> 'student' or 'supervisor'

	public function get_result_noinput_py($sourcecode, $mode)
	{
		//set compiler
		$compiler = "python3.12 ";

		//set sourcecode to be compiled
		$source = "";
		$filename = "";
		$output_file = "";

		if ($mode == "supervisor") {
			$source = realpath(SUPERVISOR_CFILES_FOLDER . $sourcecode);
			$filename = pathinfo($source, PATHINFO_FILENAME);
			$output_file = FCPATH . SUPERVISOR_EXE_FOLDER . $filename . ".output";
		} else {
			$source = realpath(STUDENT_CFILES_FOLDER . $sourcecode);
			$filename = pathinfo($source, PATHINFO_FILENAME);
			$output_file = FCPATH . STUDENT_EXE_FOLDER . $filename . ".output";
			//$output_cmd = "-o ".$output_file;
		}

		//echo "<h3>source file : "	.$source."</h3>";
		//echo "<h3>filename : "		.$filename. "</h3>";
		//echo "<h3>output file : "	.$output_file."</h3>"; 


		//echo "<h1>Compiling file : ".$source."</h1>"; 
		$output_result = exec("$compiler $source > $output_file");
		if (file_exists($output_file)) {
			$output_result = rtrim(file_get_contents($output_file));
			exec("rm $output_file");
		} else {
			$output = "NO OUTPUT!!!";
		}
		//echo "<h1>output_file : ".$output_file."</h1>"; 

		//echo "<h1>output_result : --".$output_result."--</h1>"; 
		/*
		$returnval='';
		$output_result = shell_exec($output_file);
		echo "<h2>temp : $temp </h2>";
		echo "<h2>returnval : $returnval </h2>";
		$output = $this->unify_whitespace($output_result);
		echo "<h3>$output_result : "	.$output_result."</h3>"; 
		*/
		//exit();

		return ($output_result);
	}



	//change white space \t \n to single space
	// and  add padding until the end of line
	//	ord(space) = 32
	//	ord(newline) = 10
	//	ord(tab) = 9
	public function unify_whitespace($input)
	{
		//echo "<h2>".__METHOD__." : ".$input."</h2>";
		$length_input = strlen($input);
		$count_chars = count_chars($input);
		defined('SPACE1') or define('SPACE1', ' ');
		$single_space_string = ''; //placeholder
		for ($index = 0; $index < strlen($input); $index++) {

			if (ord($input[$index]) == 9) {							// TAB character
				// add space 1 to 8
				// defined by strlen($single_space_string) % 80
				$position = strlen($single_space_string) % 8;
				$added_space = 8 - $position;
				//echo "--> $added_space space";

				//for($j=0;$j<strlen($single_space_string)%8;$j++)
				$j = 1;
				do {
					$single_space_string = $single_space_string . SPACE1;
					$j++;
				} while ($j <= $added_space);
			} else if (ord($input[$index]) == 10) {					// newline character

				//add space until end of line
				//defined by strlen($single_space_string) % 80
				$position = (strlen($single_space_string)) % 80;
				$added_space = 80 - $position;
				//echo "<p> ****** single_space_string : add $added_space space</p>";
				//echo "--> $added_space space";
				for ($j = 0; $j < $added_space; $j++) {
					$single_space_string = $single_space_string . SPACE1;
				}
			} else {
				$single_space_string = $single_space_string . $input[$index];
			}
		}
		/*
		echo "<br>";
		$input_length = strlen($input);
		echo "<code>input : $input    length : $input_length</code><br>";
		echo '<code><textarea style="width:595px;height:300px";>'.$input."</textarea></code>";
		$input_length = strlen($single_space_string);
		echo "<code><p>single_space_string : $single_space_string    length : $input_length</p><code>"; 
		echo '<code><textarea style="width:595px;height:300px";>'.$single_space_string."</textarea></code>";
		*/
		return $single_space_string;
	}

	//	insert \n every 80th character
	public function insert_newline($input)
	{
		$output = '';
		for ($index = 0; $index < strlen($input); $index++) {
			$output = $output . $input[$index];
			if (($index + 1) % 80 == 0) {
				$output = $output . chr(10);
			}
		}
		return $output;
	}

	public function output_compare($output_sample, $output_student)
	{
		//echo "<h3>output1 : $output_supervisor</h3>"; 
		$output_sample = $this->unify_whitespace($output_sample);	// change TAB and NEWLINE to single space	
		$output_sample = $this->insert_newline($output_sample);		//insert newline after 80th character of each line
		$output_sample = rtrim($output_sample);						//remove trailing spaces
		//echo "<h3>output3 : $output_supervisor</h3>"; 

		$output_student = $this->unify_whitespace($output_student);	// change TAB and NEWLINE to single space	
		$output_student = $this->insert_newline($output_student);	//insert newline after 80th character of each line
		$output_student = rtrim($output_student);					//remove trailing spaces

		$output_sample = rtrim($output_sample);
		$output_student = rtrim($output_student);
		//echo 'output_sample '.strlen($output_sample).'<br><pre>'.$output_sample.'</pre><br>';
		//echo 'output_student '.strlen($output_student).'<br><pre>'.$output_student.'</pre><br>';
		$i = 0;
		//make both of them to have the same length
		if (strlen($output_sample) > strlen($output_student)) {

			// add trailing space to $output_student
			while (strlen($output_student) < strlen($output_sample))
				$output_student = $output_student . ' ';
		} else if (strlen($output_sample) < strlen($output_student)) {

			// add trailing space to $output_sample
			while (strlen($output_student) > strlen($output_sample))
				$output_sample = $output_sample . ' ';
		}

		$end = strlen($output_student);

		for ($i = 0; $i < $end; $i++) {
			//echo $i." $output_sample[$i] (".ord($output_sample[$i]).")  <--> $output_student[$i] (".ord($output_student[$i]).")<br/>";

			if ($output_student[$i] == $output_sample[$i]) {
				//echo $output_student[$i];
			} else {
				break;
			}
		}
		$unmatched_position = $i;
		//exit();


		if ($unmatched_position >= $end) {

			return -1;
		} else {

			$error_position = $unmatched_position;
			$error_line = floor($unmatched_position / 80);
			$error_column = $unmatched_position % 80;

			$data = array(
				'error_position'	=> $error_position,
				'error_line'		=> $error_line,
				'error_column'		=> $error_column
			);
			return $data;
		}
		//exit();


	} //public function output_compare

	public function dispaly_error_in_output($output, $error_position)
	{

		$error_position = $error_position;
		$error_line		= floor($error_position / 80);
		$error_column	= $error_position % 80;
		$output_length	= strlen($output);
		$left_length	= 80 * ($error_line + 1);
		$right_length	= $output_length - $left_length;
		$modified_output = substr($output, 0, $left_length) . $this->error_line($error_column) . substr($output, $left_length, $right_length);
		$modified_output = $this->insert_newline($modified_output);
		/*
		echo '<textarea cols="80" rows="20">',$modified_output,'</textarea>';
		for ($i=0;$i<255;$i++)
			echo 'i:',$i,' : ',ord($i),' : ',chr($i),'<br>';
		*/
		return $modified_output;
	}

	public function error_line($error_column)
	{
		$line_add = '';
		for ($i = 0; $i < 80; $i++) {
			if ($i == $error_column) {
				$line_add .= chr(94);
			} else {
				$line_add .= ' ';
			}
		}
		return $line_add;
	}

	// $mode = 'supervisor' or 'student'
	// $sourcecode_filename, ie. exercise_00041.c
	// $input: string
	public function exercise_test_input($mode, $sourcecode_filename, $input)
	{
		$compiler = $this->compiler;

		//set sourcecode to be compiled
		$source = "";
		$filename = $sourcecode_filename;
		$output_file = "";

		if ($mode == "supervisor") {
			$source = realpath(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename);
			$filename = pathinfo($source, PATHINFO_FILENAME);
			$output_file = FCPATH . SUPERVISOR_EXE_FOLDER . $filename . ".exe";
		} else {
			$source = realpath(STUDENT_CFILES_FOLDER . $sourcecode);
			$filename = pathinfo($source, PATHINFO_FILENAME);
			$output_file = FCPATH . STUDENT_EXE_FOLDER . $filename . ".exe";
			$output_cmd = "-o " . $output_file;
		}
		//echo "source : ",$source,"<br>";
		//echo "filename : ",$filename,"<br>";
		//echo "output file : ",$output_file,"<br>";
		//echo "testcase file : ",$testcase_file,"<br>";

		$output_result = exec("$compiler $source -o $output_file");

		//echo "<h1>output_result : ".$output_result."</h1>"; 
		$returnval = '';
		$output_result = shell_exec($output_file);
		//echo '<code><textarea cols="80" rows="20">',$output_result,'</textarea></code>';


	}

	public function get_exercise_output($sourcecode_filename, $testcase_content)
	{
		//echo "<h1>1$sourcecode_filename</h1>";
		$ext = substr(strrchr($sourcecode_filename, '.'), 1);
		//echo "<h1>2$sourcecode_filename   $ext</h1>";

		if (strtolower(trim($ext)) == 'py') {
			//echo "<h1>666$sourcecode_filename   $ext</h1>";
			return $this->get_exercise_output_python($sourcecode_filename, $testcase_content);
		} else {

			return $this->get_exercise_output_c($sourcecode_filename, $testcase_content);
		}
	}

	public function get_exercise_output_no_testcase_python($sourcecode_filename, $mode)
	{
		//echo "<h1>".__METHOD__." $sourcecode_filename $mode 555</h1>";

		if ($mode == 'student') {
			$path = STUDENT_CFILES_FOLDER;
		} else if ($mode == 'supervisor') {
			$path = SUPERVISOR_CFILES_FOLDER;
		}
		$outfile = $path . $sourcecode_filename . '.outfile';
		$command = "python3.12 " . $path . $sourcecode_filename . " > $outfile ";
		//echo "<h2>command = $command</h2>";
		$result = shell_exec("$command");
		//echo "<h2>result = $result</h2>";
		$output_content = '';
		if (file_exists($outfile)) {
			$output_content = file_get_contents($outfile);
			exec('rm ' . $outfile);
		} else {
			echo "<h2>Cannot find output !!!</h2>";
			exit();
		}
		//echo "<h2>output_content = $output_content</h2>"; 
		return $output_content;
	}


	public function get_exercise_output_python($sourcecode_filename, $testcase_content)
	{
		//echo "<h1>999666 $sourcecode_filename</h1>";
		$testcase_content = rtrim($testcase_content);
		$infile = SUPERVISOR_CFILES_FOLDER . $sourcecode_filename . '.input';
		file_put_contents($infile, $testcase_content);
		$outfile = SUPERVISOR_CFILES_FOLDER . $sourcecode_filename . '.outfile';
		$command = "python3.12 " . SUPERVISOR_CFILES_FOLDER . $sourcecode_filename . ' < ' . " $infile > $outfile ";
		//echo "<h2>command = $command</h2>";
		// It should verify that the process with the same name is not currently running
		// - check the process whether the same name is not running
		// - if it doesn't have, safe to run
		// - if it is available then
		//				wait for a second
		//				check again
		//				if it's still exist then kill it
		//				check again until it does not exist
		// - now we can run it safely

		$result = shell_exec("$command");

		//echo "<h2>result = $result</h2>";
		//exit();

		// limit length of $result
		$max_length = 16384;
		if (strlen($result) >= $max_length) {
			$result = substr($result, $max_length);
		}

		if (file_exists($outfile)) {
			$output_content = file_get_contents($outfile);
			//echo "<h2>output = $output_content</h2>";
			exec('rm ' . $outfile);
			//return rtrim($output_content);


			$result = $output_content;
			//echo "result => <pre>".$result."</pre><br>";

			//add $testcase_content to $result
			$first_colon = strpos($result, ":");

			$output = substr($result, 0, $first_colon + 2);
			//echo "output2 ==> <pre>".$output."</pre><br>";
			$output .= rtrim($testcase_content) . "\n";
			//echo "output3 ==> <pre>".$output."</pre><br>";
			$output .= substr($result, $first_colon + 2, strlen($result) - $first_colon);
			//echo "output4 ==> <pre>".$output."</pre><br>";
			//exit();
			return $output;
		} else {
			echo "<h1>NO output detected !!!</h1>";
			exit();
		}
	}


	public function get_exercise_output_c($sourcecode_filename, $testcase_content)
	{
		//echo '$sourcecode_filename : '.$sourcecode_filename.'<br>';
		//echo '$sourcecode_filename : '.substr($sourcecode_filename,0,strlen($sourcecode_filename)-2).'<br>';
		//echo '$testcase_content : '.$testcase_content.'<br>';
		$outfile = SUPERVISOR_EXE_FOLDER . substr($sourcecode_filename, 0, strlen($sourcecode_filename) - 2) . '.exe';
		$infile = SUPERVISOR_CFILES_FOLDER . $sourcecode_filename;
		//echo '$infile : '.$infile.'<br>';
		//echo '$outfile : '.$outfile.'<br>';


		$testcase_content = rtrim($testcase_content);
		$cmd = $this->compiler;
		$cmd .= " $infile -o $outfile";

		//echo "cmd : $cmd<br/>";
		$result = shell_exec("$cmd");
		//echo "result => <pre>".$result."</pre><br>";
		if (file_exists($outfile)) {
			//echo "$outfile exists<br/>";
			//$cmd = "$outfile";
			//$result = exec($outfile  );
			//echo "result1 => $result <br>";
			$result = shell_exec("echo '$testcase_content' | " . $outfile . " 2>&1");
			//sleep(5);
			echo "result2 => $result <br>";
			//$result = shell_exec("echo $testcase_content | $outfile  2>&1");
			//sleep(5);
			//echo "result3 => $result <br>";
		} else {
			echo "$outfile NOT exists<br/>";
		}


		//return ;
		//add $testcase_content to $result
		$first_colon = strpos($result, ":");
		$output = substr($result, 0, $first_colon + 2);
		$output .= rtrim($testcase_content) . "\n";
		$output .= substr($result, $first_colon + 2, strlen($result) - $first_colon);

		//echo "output ==> <pre>".$output."</pre><br>";
		return $output;
	}
	public function fileExtension($sourcecode_filename)
	{
		return end(explode('.', $sourcecode_filename));
	}
	public function get_result_student_testcase($sourcecode_filename, $testcase_content)
	{
		//echo "<h1>1$sourcecode_filename</h1>";
		$ext = substr(strrchr($sourcecode_filename, '.'), 1);
		//echo "<h1>2$sourcecode_filename   $ext</h1>";

		if (strtolower(trim($ext)) == 'py') {
			//echo "<h1>666$sourcecode_filename   $ext</h1>";
			return $this->get_result_student_testcase_python($sourcecode_filename, $testcase_content);
		} else {

			return $this->get_result_student_testcase_c($sourcecode_filename, $testcase_content);
		}
	}

	public function get_result_student_testcase_python($sourcecode_filename, $testcase_content)
	{
		return $this->get_result_testcase_python($sourcecode_filename, $testcase_content, "student");
	}


	// this function will be used commonly between student and supervisor
	// by $mode variable
	// $mode is either "student" or "supervisor"
	// under development as of 05 Feb 2020
	public function get_result_testcase_python($sourcecode_filename, $testcase_content, $mode)
	{
		//echo "<h1 style='color:blue;''>".__METHOD__."</h1>";
		//echo "<h2>sourcecode_filename= $sourcecode_filename testcase_content=$testcase_content mode=$mode</h2>";
		if ($mode == "supervisor") {
			$directory = SUPERVISOR_CFILES_FOLDER;
		} else if ($mode == "student") {
			$directory = STUDENT_CFILES_FOLDER;
		} else {
			$method =  __METHOD__;
			echo "<h1>$method <br/>mode is unknown ==> $mode</h1>";
			exit();
		}

		$testcase_content = rtrim($testcase_content);
		$infile = $directory . $sourcecode_filename . '.input';
		file_put_contents($infile, $testcase_content);
		$outfile = $directory . $sourcecode_filename . '.outfile';
		if (file_exists($outfile)) {
			exec('rm ' . $outfile);
			return "Something went wrong !!!";
		}
		$command = "python3.12 " . $directory . $sourcecode_filename . ' < ' . " $infile > $outfile ";
		$timelimit =  "timelimit -S 9 -T 1 -t 2 ";
		$command = $timelimit . $command;
		//echo "<h2>command = $command</h2>";
		shell_exec("ulimit -Sf 100 ");
		shell_exec("ulimit -St 3 ");
		$result = shell_exec("$command");
		//echo "<h2>result = $result</h2>";


		exec('rm ' . $infile);

		if (file_exists($outfile)) {
			$output_content = file_get_contents($outfile);
			//echo "<h2>output = $output_content</h2>";
			exec('rm ' . $outfile);
			//return rtrim($output_content);

			$result = $output_content;
			//echo "result => <pre>".$result."</pre><br>";

			//add $testcase_content to $result
			$first_colon = strpos($result, ":");
			$output = substr($result, 0, $first_colon + 2);
			//echo "outut2 ==> <pre>".$output."</pre><br>";
			$output .= rtrim($testcase_content) . "\n";
			//echo "output3 ==> <pre>".$output."</pre><br>";
			$output .= substr($result, $first_colon + 2, strlen($result) - $first_colon);
			//echo "output4 ==> <pre>".$output."</pre><br>";
			//exit();

			return $output;
		} else {
			$method =  __METHOD__;
			echo "<h1>$method <br/>NO output detected !!!</h1>";
			exit();
		}
	}

	public function get_result_student_testcase_c($sourcecode_filename, $testcase_content)
	{

		$testcase_content = rtrim($testcase_content);

		/*$cmd = $this->compiler ;
		$cmd .= STUDENT_CFILES_FOLDER.$sourcecode_filename;
		$option = ' -run ';
		$result = shell_exec("echo $testcase_content | $cmd $option 2>&1");
		//echo "result => <pre>".$result."</pre><br>";
		//add $testcase_content to $result
		*/

		// new version for linux
		$outfile = STUDENT_EXE_FOLDER . substr($sourcecode_filename, 0, strlen($sourcecode_filename) - 2) . '.exe';
		$infile = STUDENT_CFILES_FOLDER . $sourcecode_filename;
		//echo '$infile : '.$infile.'<br>';
		//echo '$outfile : '.$outfile.'<br>';


		$testcase_content = rtrim($testcase_content);
		$cmd = $this->compiler;
		$cmd .= " $infile -o $outfile";

		//echo "cmd : $cmd<br/>";
		$result = shell_exec("$cmd");
		//echo "result => <pre>".$result."</pre><br>";
		if (file_exists($outfile)) {
			//echo "$outfile exists<br/>";
			//$cmd = "$outfile";
			//$result = exec($outfile  );
			//echo "result1 => $result <br>";
			$result = shell_exec("echo '$testcase_content' | " . $outfile . " 2>&1");
			//sleep(5);
			//echo "result2 => $result <br>";
			//$result = shell_exec("echo $testcase_content | $outfile  2>&1");
			//sleep(5);
			//echo "result3 => $result <br>";
			exec('rm ' . $outfile);
		} else {
			//echo "$outfile NOT exists<br/>";
		}
		$first_colon = strpos($result, ":");
		$output = substr($result, 0, $first_colon + 2);
		$output .= rtrim($testcase_content) . "\n";
		$output .= substr($result, $first_colon + 2, strlen($result) - $first_colon);

		//echo "output ==> <pre>".$output."</pre><br>";
		return $output;
	}
	public function suspend_file_python($sourcecode_filename)
	{
		$file_content = '';
		if (file_exists(STUDENT_CFILES_FOLDER . $sourcecode_filename)) {
			$file_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);
		} else {
			$file_content = STUDENT_CFILES_FOLDER . $sourcecode_filename . ' is not available.';
		}

		//echo "<h1>sourcecode_filename=$sourcecode_filename</h1>";
		//echo "<h1>file_content=$file_content</h1>";
		$new_file_content = 'This file has been suspened ! ! !\r\n';
		foreach (preg_split("/((\r?\n)|(\r\n?))/", $file_content) as $line) {
			if (strlen($line) > 0) {
				if ($line[0] != '#') {
					$new_file_content .= '#' . $line[0] . '\r\n';
				} else {
					$new_file_content .= $line[0] . '\r\n';
				}
			}
		}
		//exit();

		return $new_file_content;
	}
}
