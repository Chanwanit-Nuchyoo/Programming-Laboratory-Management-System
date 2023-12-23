<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));

class Exercise_view extends MY_Controller {

    // developed from lab_exercise_action_v3
    // 
    public function lab_exercise_view($chapter_id,$item_id) {
		$role = $_SESSION['role'];
        return;
		$stu_id = $_SESSION['stu_id'];
		$group_id = $_SESSION['stu_group'];
		
		//echo "<h3>stu_group : $group_id - stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  </h3>" ;
		$lab_data = $this->_lab_data; // all lab information that belong to this student
		//echo '<h4><pre>';print_r($lab_data);echo '</pre><h4/>';

		//exit();
		$exercise_id = $lab_data[$chapter_id][$item_id]['stu_lab']['exercise_id'];
		
		$this->load->model('lab_model');
		$latest_submission = $this->lab_model->get_latest_record_from_exercise_submission($stu_id,$exercise_id);
		//echo '<h4>999999latest_submission<pre>';print_r($latest_submission);echo '</pre></h4>';
		//$exercise_id = $latest_submission['exercise_id'];
		//echo "<h4>exercise_id=$exercise_id</h4>";
		$submission_id = !empty($latest_submission) ? $latest_submission['submission_id'] : -1;
		//echo "<h4>submission_id = $submission_id</h4>";

		//echo "<!--<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>-->";
		//echo '<!--<pre>';print_r($lab_data);echo '</pre>-->';
		//exit();


		// if student does not have exercise then assign one
		if (empty($exercise_id)) {
			//assign exercise to student from $lab_data[$chapter_id][$item_id]['exercise_id_list']
			$exercise_list = unserialize($lab_data[$chapter_id][$item_id]['exercise_id_list']);
			//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_list : " ;
			//print_r($exercise_list); echo "</h2>";
			shuffle($exercise_list);
			if( isset($exercise_list[0]) ) {
				$exercise_id = $exercise_list[0];
			} else {
				echo "Lab : $chapter_id level : $item_id is NOT available.\n";
				return ;
			}
			//echo "<h2>". "  exercise_id : ".$exercise_id."</h2>";

			
			// update student table
			
			$this->lab_model->update_student_exericse($stu_id,$chapter_id,$item_id,$exercise_id);
			$this->update_student_data();
			$lab_data = $this->_lab_data;
		}
		//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";
		//echo "<h4>exercise_id=$exercise_id</h4>";

		

		$lab_content = $this->lab_model->get_lab_content($exercise_id);
		$sourcecode_content ='';

		$number_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		
		//echo '<h3>$lab_content : </h3><pre> testcase nubmer: ',$number_of_testcase,"<br>"; print_r($lab_content); echo "</pre>"; 
		$submitted_count = $this->student_model->get_student_submission_times($stu_id,$exercise_id);
		
		// infinite loop verification
		/*
		$sequence = $submitted_count;
		$this->load->model('lab_model');
		$infinite_loop_check = $this->lab_model->get_infinite_loop($stu_id,$chapter_id,$item_id,$sequence);
		if($infinite_loop_check==NULL) {
			$infinite_loop_check = "NO";
		} else {
			$infinite_loop_check = "YES";
		}
		*/




		require_once 'Exercise_test.php';
		$exercise_test = new Exercise_test();
		$output = '';
		$marking = 0;

		if($number_of_testcase <=0 && $submitted_count <= 0) { //newly exploring item with no testcase
			// supervisor data
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			$output_supervisor = $exercise_test->get_result_noinput($sourcecode_filename,'supervisor'); // raw output 			
			$output_supervisor = $exercise_test->unify_whitespace($output_supervisor);	// change TAB and NEWLINE to single space	
			$output_supervisor = $exercise_test->insert_newline($output_supervisor); //insert newline after 80th character of each line				
			$lab_name = $this->get_lab_name($exercise_id);
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);


		} else if($number_of_testcase <=0 && $submitted_count > 0) { 	// the exercise has no testcase and there is at least one submission

			$latest_submission = $this->lab_model->get_latest_record_from_exercise_submission($stu_id,$exercise_id);	
			

			// supervisor data
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			$output_supervisor = $exercise_test->get_result_noinput($sourcecode_filename,'supervisor'); // raw output 			
			$output_supervisor = $exercise_test->unify_whitespace($output_supervisor);	// change TAB and NEWLINE to single space	
			$output_supervisor = $exercise_test->insert_newline($output_supervisor); //insert newline after 80th character of each line				
			$lab_name = $this->get_lab_name($exercise_id);
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			//$marking = $this->get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			$marking = $latest_submission['marking'];
	
			$_SESSION['lab_item']=$item_id;
			
			// the exercise has no testcase and there are some submissions
			// take last_submit and do marking ==> update to exercise_submission table
			$last_submit = $this->student_model->get_student_last_submission_record($stu_id,$exercise_id);
			$submission_id = $last_submit['submission_id'];
			$sourcecode_filename = $last_submit['sourcecode_filename'];  // ของนักศึกษา
			$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);

			//run and get output
			$output_student = $last_submit['output'];

			$sample_filename = $this->lab_model->get_lab_exercise_sourcecode_filename($exercise_id);
			$output_sample = $exercise_test->get_result_noinput($sample_filename,'supervisor');
			$output_sample = $exercise_test->unify_whitespace($output_sample);

			

			$last_submit['sourcecode_content']	= $sourcecode_content;
			$last_submit['sourcecode_output']	= $output_student;			
			$last_submit['submitted_count']	= $submitted_count;

			//for icon displayed at top-right panel
			if ($full_mark == $marking)
				$last_submit['status']='passed';
			else 
				$last_submit['status']='error';


			//echo '<h3>$last submit : </h3><pre>'; print_r($last_submit); echo "</pre>"; 
			
			
		} else {

			//*
			//*
			//*	there are testcases because !($number_of_testcase <=0 )
			//*
			//*
			$latest_submission = $this->lab_model->get_latest_record_from_exercise_submission($stu_id,$exercise_id);
			//$this->exercise_submission_show($latest_submission['exercise_id']);
			$testcase_array = $this->lab_model->get_testcase_array($exercise_id); // from supervisor

			//echo '<h3>testcase_array : </h3><pre>'; print_r($testcase_array); echo "</pre>"; 
			$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
			//echo "<h3>num_of_testcase = $num_of_testcase</h3>"; 
			//exit();
			
			


			$output_supervisor = ''; //reset output (no testcase)
			$status ="first_enter";
			//first time to do this exercise
			if(empty($latest_submission)) {  // never submit

				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
				$sourcecode_filename='';
				$sourcecode_content='';
			
			} else {  // there are testcases and submissions
				//echo "<h1>666</h1>";	//exit();
				//there is last submit so run it and do marking
				// from exercise_submission table
				$last_submit = $this->lab_model->get_latest_record_from_exercise_submission($stu_id,$exercise_id);
				//echo '<h2>last_submission : </h2><pre>'; print_r($last_submit); echo "</pre></h2>";
				//$this->exercise_submission_show($last_submit['submission_id']);
				$output = unserialize($last_submit['output']);
				//echo '<h2>output : '.sizeof($output).'</h2><pre>'; print_r($output); echo "</pre>";
				//exit();
				


				$submission_id = $last_submit['submission_id'];
				$marking = $last_submit['marking'];
				//echo "<h2>last_submit=<pre>";print_r($last_submit);"<pre/></h2>";
				if ( !is_null($last_submit['output']) )
					$output = unserialize($last_submit['output']);				
				$sourcecode_filename = $last_submit['sourcecode_filename'];

				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
				
				//run each testcase and compare result
				
				// $chapter_pass = 'yes';
				// each time testcase passes, $chapter_pass will be decreased.
				// if all testcases pass, $chater_pass will be zero
				$chapter_pass = sizeof($data_testcase);
				$testcase_pass = 0;
				for ($i=0; $i<sizeof($output); $i++) {
					$data_testcase["$i"]['item_pass'] = 'yes';
					$testcase_content = $data_testcase["$i"]['testcase_content'];
					//run output and store in $data_testcase


					// check process with the same name before running the new one
					//$process_in_system = $this->check_and_kill_process($sourcecode_filename);
					//$this->exercise_submission_show($submission_id);

					//echo "<h2>output<pre>";print_r($output); echo "</pre></h2>";
					//echo "<h2>output[$i]<pre>";print_r($output[$i]); echo "</pre></h2>";
					$output_student_original = $output[$i]['testcase'];
					//echo "<h2>222last_submit=</h2>";
					//echo "<h2>output_student_original=".strlen($output_student_original)."</h2>";
					$output_length = strlen($output_student_original);
					//exit();
					$data_testcase["$i"]['output_to_show']=$output_student_original;


					$data_testcase["$i"]['testcase_student'] = $output_student_original;//$output_student;

					$output_sample = $data_testcase["$i"]['testcase_output'];
					$output_sample = $exercise_test->unify_whitespace($output_sample);
					//echo "<h2>444</h2>";


					//calculate marking of testcase and put into $data_testcase
					if ($output[$i]['status']=='PASS') {
						$item_pass='yes';
						$testcase_pass++;
					} else {
						$item_pass='no';
					}
					//exit();
					$data_testcase["$i"]['output_to_show']=$output_student_original;
					$data_testcase["$i"]['item_pass']=$item_pass;
				}


				//$status ="not_pass";
				$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
				$marking = $last_submit['marking'];

				//for icon displayed at top-right panel
				$status ='';
				if ($full_mark == $marking)
					$status='passed';
				else 
					$status='error';


				
				
				if($testcase_pass==sizeof($data_testcase)) {
					$status = "passed";
				} 
				
			}
			$testcase_array = $data_testcase;
			$data_for_testcase['exercise_id'] = $exercise_id;
			$data_for_testcase['num_of_testcase'] = $num_of_testcase;
			$data_for_testcase['testcase_array'] = $testcase_array;
			//$data_for_testcase['infinite_loop_check'] = $infinite_loop_check;
			if(isset($last_submit))
				$data_for_testcase['last_submit'] = $last_submit;
			$data_for_testcase['status'] = $status;
			//echo '000000  '.STUDENT_CFILES_FOLDER.$sourcecode_filename;
			if ( strlen($sourcecode_filename)>5 && file_exists(STUDENT_CFILES_FOLDER.$sourcecode_filename) )
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);
			else
				$sourcecode_content = '';

		}



		$data= array(	
					"lab_content"	=> $lab_content,
					"output"		=> $output_supervisor,
					'lab_chapter'	=> $chapter_id,
					'lab_item'		=> $item_id,
					'exercise_id'	=> $exercise_id,
					'lab_name'		=> $this->lab_model->get_lab_name($exercise_id),
					'full_mark'		=> $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id),
					'marking'				=> $marking,
					'submitted_count'		=> $submitted_count,
					'sourcecode_content' 	=> $sourcecode_content,
					'output_to_show'		=> array('1'=>'nothing'),
					'group_permission'		=> $this->_group_permission
				);

		
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/exercise_submission_header',$data);

		if($number_of_testcase <= 0 && $submitted_count <=0) {
			// do nothing	ยังไม่เคยส่ง ไม่มีอินพุท		
		} else if($number_of_testcase <= 0 && $submitted_count > 0) {
			// ไม่มีอินพุท เคยส่งแล้ว แสดงผล การส่งครั้งล่าสุด
			$this->load->view('student/exercise_testrun',$last_submit);
		} else if($number_of_testcase > 0 && $submitted_count <= 0) {
			// มีอินพุท ไม่เคยส่ง
			$this->load->view('student/exercise_output_testcase',$data_for_testcase);
		} else {
			// มีอินพุท เคยส่งแล้ว แสดงผล การส่งครั้งล่าสุด
			$this->load->view('student/exercise_output_testcase_student',$data_for_testcase);
		}

		$this->load->view('student/stu_footer');

		
	}//public function lab_exercise_v3($chapter_id,$item_id)

}