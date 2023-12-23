<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for (all) non logged in users
 */
class Process_protection extends CI_Controller {
	public $compiler ='gcc ';
	private $exercise_id = -1; //unintialize
	private $num_testcase = -1; //uninitialze
	
	public function __construct() {
		//parent::__construct();
		//echo __METHOD__."<br>";
		//echo "<pre>";
		
		//echo "</pre>";
		//echo "<pre>";
		//print_r($_SESSION);
		//echo "</pre>";
		
	}

	

	public function process_get($sourcecode_filename,$mode){
		echo "<h1>".__METHOD__."<br></h1>";
		
		$filename = "99010001_03_02_0001.py";
		$processes = shell_exec("ps -aux | grep 'python3' | grep '".$filename."' | grep -v 'ps -aux' ");
		$processes = $this->process_to_array($processes);
		//echo "<h4>".nl2br($processes)."</h4>";
		
		
		
		$wait_time = 1;
		echo "<h4>Waiting for ...".$wait_time." seconds</h4>";
		sleep($wait_time);
		echo "<h4>".nl2br($processes)."</h4>";
		echo "<pre>";print_r($process);echo "</pre>";
		/*
		foreach ($process as $line) {
			echo $line."<br/>";
		}
		/*
		echo "<h4><pre>".$process."</pre></h4>";
		/*
		foreach($processes as $line) {
			// check whether the process exists
			echo "<h3>$line</h3>";
			$now_process = shell_exec("ps -aux | grep '".$line."' ");
			if(!empty($now_process)) {
				echo $now_process."<br/>";
			}

		}
		*/

		exit();
		return $process;
		
	}

	private function process_to_array($processes) {
		echo "<h1>".__METHOD__."<br></h1>";
		if (strlen($processes)<10)
			return '';
		$line_no = 0;
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $processes) as $line) {
			$line_no++;
			if (strlen($line)<5)
				break;
			//echo "<h4 style='color:blue;'>".nl2br($line)."</h4>";
			$user = strtok($line, " \n\t");
			$pid = strtok(" \n\t");
			$cpu = strtok(" \n\t");
			$mem = strtok(" \n\t");
			$vsz = strtok(" \n\t");
			$rss = strtok(" \n\t");
			$tty = strtok(" \n\t");
			$stat = strtok(" \n\t");
			$start = strtok(" \n\t");
			$time = strtok(" \n\t");
			$command = strtok(" \n\t");
			if ($line_no > 0) {
				$process_array[$line_no]['user']=$user;
				$process_array[$line_no]['pid']=$pid;
				$process_array[$line_no]['cpu']=$cpu;
				$process_array[$line_no]['mem']=$mem;
				$process_array[$line_no]['vsz']=$vsz;
				$process_array[$line_no]['rss']=$rss;
				$process_array[$line_no]['tty']=$tty;
				$process_array[$line_no]['stat']=$stat;
				$process_array[$line_no]['start']=$start;
				$process_array[$line_no]['time']=$time;
				$process_array[$line_no]['command']=$command;
				$process_array[$line_no]['parameter']=$command;
				
			}
			
			echo $line_no.' : user='.$user.' : pid='.$pid.' : command='.$command.'<br/>';

		}
		return $process_array;
	}

	public function process_get_student() {
		$processes = shell_exec("ps -aux | grep 'student' ");
		$line_no = 0;
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $processes) as $line) {
			$user = strtok($line, " \n\t");
			$pid = strtok(" \n\t");
			$cpu = strtok(" \n\t");
			$mem = strtok(" \n\t");
			$vsz = strtok(" \n\t");
			$rss = strtok(" \n\t");
			$tty = strtok(" \n\t");
			$stat = strtok(" \n\t");
			$start = strtok(" \n\t");
			$time = strtok(" \n\t");
			$command = strtok(" \n\t");
			//if ($line_no > 0) {
				$process[$line_no]['user']=$user;
				$process[$line_no]['pid']=$pid;
				$process[$line_no]['cpu']=$cpu;
				$process[$line_no]['mem']=$mem;
				$process[$line_no]['vsz']=$vsz;
				$process[$line_no]['rss']=$rss;
				$process[$line_no]['tty']=$tty;
				$process[$line_no]['stat']=$stat;
				$process[$line_no]['start']=$start;
				$process[$line_no]['time']=$time;
				$process[$line_no]['command']=$command;
				$filename = $command;

			//}
			$line_no++;
			//echo $line_no.' : '.$user.' : '.$pid.' : '.$command.'<br/>';

		}
		return $process;
	}

	public function comment_all_line_python_format($content){
		$first_line = 'print("This file has been commented. !!!")'."\r\n";
		$add_comment = '';
		$i=1;
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $content) as $line){
			if(strlen($line)>0) {
				if($i==1 && $line!= $first_line) {
					$add_comment = $first_line."# ".$line;
					$i=0;
				} else if ($line[0]=="#") {
					$add_comment .= $line."\r\n";
				} else {
					$add_comment .= '# '.$line."\r\n";
				}
			}


		}
		//echo "<h3>$add_comment</h3>";

		return $add_comment;
	}

	public function get_python3_process_in_system(){
		echo "<h1>".__METHOD__."<br></h1>";		
		
		$processes = shell_exec("ps -aux | grep 'python3 '  | grep -v 'ps -aux' | grep -v 'root' | grep -v 'grep' ");
		echo "<h2>$processes</h2>";
		$processes = $this->process_to_array($processes);
		
		echo "<pre>";print_r($processes);echo "</pre>";
		exit();
		
		return $processes;
		
	}

	

	
}