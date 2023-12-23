<?php
defined('BASEPATH') or exit('No direct script access allowed');
define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));

class Student extends MY_Controller
{
	protected $access = "student";
	private $_student_data = array(); // ข้อมูลส่วนตัวต่าง ๆ ของนักศึกษา จาก user_student + class_schedule + department
	private $_class_info = array();
	private $_lab_data = array();		// รายละเอียดแต่ละแลปของนักศึกษา
	private $_group_permission = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('lab_model');
		$_SESSION['stu_id'] = $_SESSION['username'];
		//$user1 = $this->lab_model->get_user($_SESSION['ci_session']);
		$user = $this->lab_model->get_user_by_username($_SESSION['username']);
		if ($user['ci_session'] <= 0 || $user['status'] == 'offline') {
			session_destroy();
			redirect(base_url());
		}
		//unset($_SESSION['username']);
		//$this->createLogFile(" --> ".__METHOD__);
		// $this->update_student_data();
		//echo "<h2> _student_data3 = <pre>";print_r($this->$_student_data);echo "</pre></h2>";
		//echo "<h2> _class_info = <pre>";print_r($this->$_class_info);echo "</pre></h2>";
		//echo "<h2> _lab_data = <pre>";print_r($this->$_lab_data);echo "</pre></h2>";
		//echo "<h2> _group_permission = <pre>";print_r($this->$_group_permission);echo "</pre></h2>";
		//exit();





	}

	public function index()
	{
		$_SESSION['selected_menu'] = 'home';
		$_SESSION['page_name'] = 'home';
		$this->createLogFile(__METHOD__);
		$this->checkForInfiniteLoop();
		//$this->createLogFile(__METHOD__);	
		// $this->update_student_data();
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		//echo '<h3>$_student_data = </h3> <pre>'; print_r($this->_student_data); echo "</pre><br>";
		//echo '<h3>$_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>";


		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/stu_home');
		$this->load->view('student/stu_footer');
		// $this->show_to_console($_SESSION);

	} //public function index()

	public function update_student_data()
	{
		$this->update_last_seen();
		// return;
		$student_id = $_SESSION['id'];
		//update student information as necessary
		$this->load->model('student_model');
		//$this->load->model('lab_model');
		$this->student_model->update_student_profile();
		$this->_student_data = $this->student_model->retrieve_student_record($student_id);



		//echo '<h3>$this->_student_data = </h3> <pre>'; print_r($this->_student_data); echo "</pre><br>";
		//retrieve info from student_asigned_chapter_item table
		$this->load->model('lab_model');

		$this->_lab_data = $this->lab_model->setup_student_lab_data($_SESSION['stu_id'], $_SESSION['stu_group']);
		//echo '<!--<h3>$this->_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>-->";
		$student_marking_all_items = $this->lab_model->get_a_student_marking_for_all_submitted_items($student_id);
		//echo '<!--<h3>$student_marking_all_items = </h3> <pre>'; print_r($student_marking_all_items); echo "</pre><br>-->";
		foreach ($student_marking_all_items as $row) {
			$marking = 0;
			if (!empty($row['max_marking'])) {
				$marking = $row['max_marking'];
			}
			$chapter_id = $row['chapter_id'];
			$item_id = $row['item_id'];
			$this->_lab_data[$chapter_id][$item_id]['stu_lab']['marking'] = $marking;
		}
		//echo '<!--<h3>$this->_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>-->";

		$this->_group_permission = $this->lab_model->get_group_permission($_SESSION['stu_group']);
		//$this->lab_data_show();
		//echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		//$data = $_SESSION['lab_data'];
		//echo '<h3>$lab_data = </h3> <pre>'; print_r(array_keys($data)); echo "</pre><br>";		
		$this->_class_info = $this->student_model->get_class_info($_SESSION['stu_id']);
	}



	public function show_message($message)
	{
		//$this->createLogFile(__METHOD__);	
		$data = array('message' => $message);

		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/show_message', $data);
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');
		//break();

	} //public function show_message

	public function nav_sideleft()
	{
		$this->update_student_data();
		$this->load->model('student_model');
		$data = array(

			'class_info'	=>	$this->_class_info,
			'lab_data'		=>	$this->_lab_data,
			'student_data'	=>	$this->_student_data

		);

		$this->load->view('student/nav_sideleft', $data);
	}

	private function showSESSION()
	{
		echo '<h1>$_SESSION : </h1>', '<pre>', print_r($_SESSION), '</pre>';
	}


	public function lab_data_show()
	{
		$lab_data = $_SESSION['lab_data'];
		//$this->load->model('student_model');
		/*echo 'lab_xx    : item_xx    : exercise_id : fullmark : marking : start - end <br>";
		foreach ($lab_data as $row) {
			//echo $row['exercise_id']." : ".$row['full_mark']." : ".$row['marking']." : ".$row['time_start']." - ".$row['time_end']." <br>"; 
		}
		
		echo "<pre>";print_r($_SESSION);"</pre>";
		*/
	}



	public function exercise_home()
	{
		$this->show_to_console();
		$_SESSION['selected_menu'] = 'exercise';
		$_SESSION['page_name'] = 'exercise_home';
		$this->checkForInfiniteLoop();
		$this->update_student_data();
		$stu_id = $_SESSION['stu_id'];
		$this->load->model('lab_model');
		$lab_classinfo = $this->lab_model->get_lab_info(); //return array


		$data = array(
			'lab_classinfo'		=>	$lab_classinfo,
			'class_info'		=>	$this->_class_info,
			'group_permission'	=>	$this->_group_permission,
			'lab_data'			=>	$this->_lab_data,
			'student_data'		=>	$this->_student_data
		);

		$this->show_to_console($data);

		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/stu_exercise', $data);
		$this->load->view('student/stu_footer');
		/**/
	} // public function exercise_home()






	public function test_path()
	{
		echo '<h2>BASEPATH = ' . BASEPATH . '</h2>';
		echo '<h2>FCPATH = ' . FCPATH . '</h2>';
		echo '<h2>APPPATH = ' . APPPATH . '</h2>';
		echo '<h2>__FILE__ = ' . __FILE__ . '</h2>';
		echo '<h2>__DIR__ = ' . __DIR__ . '</h2>';
		echo '<h2>__FUNCTION__ = ' . __FUNCTION__ . '</h2>';
		echo '<h2>__CLASS__ = ' . __CLASS__ . '</h2>';
		echo '<h2>__TRAIT__ = ' . __TRAIT__ . '</h2>';
		echo '<h2>__METHOD__ = ' . __METHOD__ . '</h2>';
		echo '<h2>__NAMESPACE__ = ' . __NAMESPACE__ . '</h2>';
	}

	public function edit_profile_form()
	{
		$_SESSION['selected_menu'] = 'edit_profile';
		$_SESSION['page_name'] = 'edit_profile';
		$this->update_student_data();
		$this->load->model('student_model');
		$departments = $this->student_model->get_department_list();


		//$this->load->model('lab_model');
		//$class_info = $this->student_model->get_class_info($_SESSION['stu_id']);
		$class_schedule = $this->student_model->get_class_schedule($_SESSION['stu_id']);

		$data1 = array(
			'departments'		=>		$departments,
			//'class_info'		=>		$this->_class_info,
			'lab_data'			=>		$this->_lab_data,
			'student_data'		=>		$this->_student_data,
			'class_schedule'	=>		$class_schedule

		);

		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/edit_profile', $data1);
		$this->load->view('student/stu_footer');
	}

	public function edit_profile_action()
	{
		$_SESSION['page_name'] = 'edit_profile_action';
		$current_password = md5($_POST['current_password']);
		$database_password =  $this->get_password($_POST['stu_id']);
		$new_password = $_POST['password_new'];
		$confirm_password = $_POST['password_confirm'];
		// $this->show_to_console($_POST);

		//check current password if not correct return to edit_profile_form
		if ($current_password != $database_password) {
			//echo "<h4>Password incorrect !!!</h4> input password : ";
			//echo $current_password. " : ". $_POST['current_password'] . ' database : '.$database_password    ;
			$this->session->set_flashdata("error", "Password is incorrect !!!");
			$this->createLogFile(" Password is incorrect !!! => " . $_POST['current_password']);
			$this->createLogFile(__METHOD__ . " : incorrect password : " . $_POST['current_password'] . " db : " . $database_password . " input : " . $current_password);
			return $this->edit_profile_form();
		}

		//update name surname
		$this->load->model('student_model');
		$this->student_model->update_student_record();

		//update password
		if (strlen($new_password) >= 4 && $new_password == $confirm_password) {

			//echo "<h2>Changing password to : ".$new_password."</h2>";
			$this->load->model('student_model');
			$this->student_model->update_student_password($_POST['stu_id'], md5($new_password));
			$this->session->set_flashdata("status", "Password has been changed.");
			$this->createLogFile(" Change password to : " . $new_password);
		} else {
			//echo "<h2>New password DONOT change : ".$new_password."</h2>";
		}


		//upload impage
		if (!empty($_FILES['stu_avatar']) && isset($_FILES['stu_avatar']) && strlen($_FILES['stu_avatar']['name']) > 2) {

			$imageupload =  $_FILES['stu_avatar']['tmp_name'];
			$imageupload_name = $_FILES['stu_avatar']['name'];
			$ext = strtolower(pathinfo($_FILES['stu_avatar']['name'], PATHINFO_EXTENSION));
			$upload_filename = pathinfo($_FILES['stu_avatar']['name'], PATHINFO_FILENAME);
			$saved_filename = "image_" . $_SESSION['stu_id'] . '_' . uniqid() . "." . $ext; //ชื่อไฟล์

			$upload_path = APPPATH . STUDENT_AVATAR_FOLDER;
			echo "Orignal filename : " . $imageupload_name . "<br>";
			echo "New filename : $saved_filename<br>";
			echo "upload_filename : $upload_filename<br>";
			echo  "upoad_folder : " . $upload_path . "<br>";


			//create directory if not exist
			//if(!is_dir($upload_path)) {
			//	mkdir ($upload_path);
			//}

			//check file type
			if (!($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif")) {
				$this->session->set_flashdata("error", "file type is not supported : $ext");
				//echo "file type sinot supported : $ext";
				echo "<script>alert('File type must be jpg , jpeg , png or gif')</script>";
				return $this->edit_profile_form();
			}


			// Check file size
			if ($_FILES["stu_avatar"]["size"] > 500000) {
				$this->session->set_flashdata("error", "Image file is too large (>500k).");
				//echo "Sorry, your file is too large.";
				return $this->edit_profile_form();
			}

			//echo $_SERVER['DOCUMENT_ROOT']."<br>";
			//echo __FILE__."<br>";
			//echo APPPATH.STUDENT_AVATAR_FOLDER."<br>";


			//save image file to harddisk
			move_uploaded_file($imageupload,  STUDENT_AVATAR_FOLDER . $saved_filename);

			//update user_student table field only filename
			$this->load->model('student_model');
			$this->student_model->update_image($saved_filename);

			//inform user
			$this->session->set_flashdata("status", "Image file is updated.");
			$_SESSION['stu_avatar'] = $saved_filename;
		}

		//echo "End now<br>";
		$this->update_student_data();



		$this->session->set_flashdata("status", "Successfully Update.");
		$this->edit_profile_form();
	} //public function edit_profile_action() 

	public function get_password($student_id)
	{
		$this->load->model('auth_model');
		return $this->auth_model->get_password($student_id);
	}

	public function lab_exercise($chapter_id, $item_id)
	{
		$_SESSION['page_name'] = 'lab_exercise';
		$this->createLogFile(__METHOD__ . " chapter:$chapter_id item:$item_id");
		//$this->checkForInfiniteLoop();
		$this->update_student_data();
		$stu_id = $_SESSION['stu_id'];

		//ตรวจสอบ การห้ามทำแลป จากตาราง class_schedule
		if ($stu_id == '99091234') {
			$this->lab_exercise_action_v2($chapter_id, $item_id);
		} else if ($this->_group_permission[$chapter_id]['allow_access'] == 'no') {
			$this->show_message("You are not allowed to do exercise.");
		} else {
			$this->lab_exercise_action_v3($chapter_id, $item_id);
		}
	}

	//*****************	11 Febuary 2020 *********************
	//
	// 		This function would not run any into infinite loop
	// 		all testcases of student are stored on exercise_submission table
	//		sample testcases are stored on 
	//  
	//*******************************************************
	private function lab_exercise_action_v3($chapter_id, $item_id)
	{
		//echo "<h1>".__METHOD__ . "<h1/>";

		$stu_id = $_SESSION['stu_id'];
		$group_id = $_SESSION['stu_group'];

		//echo "<h3>stu_group : $group_id - stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  </h3>" ;
		$lab_data = $this->_lab_data; // all lab information that belong to this student
		//echo '<h4><pre>';print_r($lab_data);echo '</pre><h4/>';

		//exit();
		$exercise_id = $lab_data[$chapter_id][$item_id]['stu_lab']['exercise_id'];

		$this->load->model('lab_model');
		$latest_submission = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
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
			if (isset($exercise_list[0])) {
				$exercise_id = $exercise_list[0];
			} else {
				echo "Lab : $chapter_id level : $item_id is NOT available.\n";
				return;
			}
			//echo "<h2>". "  exercise_id : ".$exercise_id."</h2>";


			// update student table

			$this->lab_model->update_student_exericse($stu_id, $chapter_id, $item_id, $exercise_id);
			$this->update_student_data();
			$lab_data = $this->_lab_data;
		}
		//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";
		//echo "<h4>exercise_id=$exercise_id</h4>";



		$lab_content = $this->lab_model->get_lab_content($exercise_id);
		$sourcecode_content = '';

		$number_of_testcase = $this->lab_model->get_num_testcase($exercise_id);

		//echo '<h3>$lab_content : </h3><pre> testcase nubmer: ',$number_of_testcase,"<br>"; print_r($lab_content); echo "</pre>"; 
		$submitted_count = $this->student_model->get_student_submission_times($stu_id, $exercise_id);

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

		if ($number_of_testcase <= 0 && $submitted_count <= 0) { //newly exploring item with no testcase
			// supervisor data
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			$output_supervisor = $exercise_test->get_result_noinput($sourcecode_filename, 'supervisor'); // raw output 			
			$output_supervisor = $exercise_test->unify_whitespace($output_supervisor);	// change TAB and NEWLINE to single space	
			$output_supervisor = $exercise_test->insert_newline($output_supervisor); //insert newline after 80th character of each line				
			$lab_name = $this->get_lab_name($exercise_id);
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
		} else if ($number_of_testcase <= 0 && $submitted_count > 0) { 	// the exercise has no testcase and there is at least one submission

			$latest_submission = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);


			// supervisor data
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			$output_supervisor = $exercise_test->get_result_noinput($sourcecode_filename, 'supervisor'); // raw output 			
			$output_supervisor = $exercise_test->unify_whitespace($output_supervisor);	// change TAB and NEWLINE to single space	
			$output_supervisor = $exercise_test->insert_newline($output_supervisor); //insert newline after 80th character of each line				
			$lab_name = $this->get_lab_name($exercise_id);
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
			//$marking = $this->get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			$marking = $latest_submission['marking'];

			$_SESSION['lab_item'] = $item_id;

			// the exercise has no testcase and there are some submissions
			// take last_submit and do marking ==> update to exercise_submission table
			$last_submit = $this->student_model->get_student_last_submission_record($stu_id, $exercise_id);
			$submission_id = $last_submit['submission_id'];
			$sourcecode_filename = $last_submit['sourcecode_filename'];  // ของนักศึกษา
			$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);

			//run and get output
			$output_student = $last_submit['output'];

			$sample_filename = $this->lab_model->get_lab_exercise_sourcecode_filename($exercise_id);
			$output_sample = $exercise_test->get_result_noinput($sample_filename, 'supervisor');
			$output_sample = $exercise_test->unify_whitespace($output_sample);



			$last_submit['sourcecode_content']	= $sourcecode_content;
			$last_submit['sourcecode_output']	= $output_student;
			$last_submit['submitted_count']	= $submitted_count;

			//for icon displayed at top-right panel
			if ($full_mark == $marking)
				$last_submit['status'] = 'passed';
			else
				$last_submit['status'] = 'error';


			//echo '<h3>$last submit : </h3><pre>'; print_r($last_submit); echo "</pre>"; 


		} else {

			//*
			//*
			//*	there are testcases because !($number_of_testcase <=0 )
			//*
			//*
			$latest_submission = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
			//$this->exercise_submission_show($latest_submission['exercise_id']);
			$testcase_array = $this->lab_model->get_testcase_array($exercise_id); // from supervisor

			//echo '<h3>testcase_array : </h3><pre>'; print_r($testcase_array); echo "</pre>"; 
			$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
			//echo "<h3>num_of_testcase = $num_of_testcase</h3>"; 
			//exit();




			$output_supervisor = ''; //reset output (no testcase)
			$status = "first_enter";
			//first time to do this exercise
			if (empty($latest_submission)) {  // never submit

				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
				$sourcecode_filename = '';
				$sourcecode_content = '';
			} else {  // there are testcases and submissions
				//echo "<h1>666</h1>";	//exit();
				//there is last submit so run it and do marking
				// from exercise_submission table
				$last_submit = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
				//echo '<h2>last_submission : </h2><pre>'; print_r($last_submit); echo "</pre></h2>";
				//$this->exercise_submission_show($last_submit['submission_id']);
				$output = unserialize($last_submit['output']);
				//echo '<h2>output : '.sizeof($output).'</h2><pre>'; print_r($output); echo "</pre>";
				//exit();



				$submission_id = $last_submit['submission_id'];
				$marking = $last_submit['marking'];
				//echo "<h2>last_submit=<pre>";print_r($last_submit);"<pre/></h2>";
				if (!is_null($last_submit['output']))
					$output = unserialize($last_submit['output']);
				$sourcecode_filename = $last_submit['sourcecode_filename'];

				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);

				//run each testcase and compare result

				// $chapter_pass = 'yes';
				// each time testcase passes, $chapter_pass will be decreased.
				// if all testcases pass, $chater_pass will be zero
				$chapter_pass = sizeof($data_testcase);
				$testcase_pass = 0;
				for ($i = 0; $i < sizeof($output); $i++) {
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
					$data_testcase["$i"]['output_to_show'] = $output_student_original;


					$data_testcase["$i"]['testcase_student'] = $output_student_original; //$output_student;

					$output_sample = $data_testcase["$i"]['testcase_output'];
					$output_sample = $exercise_test->unify_whitespace($output_sample);
					//echo "<h2>444</h2>";


					//calculate marking of testcase and put into $data_testcase
					if ($output[$i]['status'] == 'PASS') {
						$item_pass = 'yes';
						$testcase_pass++;
					} else {
						$item_pass = 'no';
					}
					//exit();
					$data_testcase["$i"]['output_to_show'] = $output_student_original;
					$data_testcase["$i"]['item_pass'] = $item_pass;
				}


				//$status ="not_pass";
				$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
				$marking = $last_submit['marking'];

				//for icon displayed at top-right panel
				$status = '';
				if ($full_mark == $marking)
					$status = 'passed';
				else
					$status = 'error';




				if ($testcase_pass == sizeof($data_testcase)) {
					$status = "passed";
				}
			}
			$testcase_array = $data_testcase;
			$data_for_testcase['exercise_id'] = $exercise_id;
			$data_for_testcase['num_of_testcase'] = $num_of_testcase;
			$data_for_testcase['testcase_array'] = $testcase_array;
			//$data_for_testcase['infinite_loop_check'] = $infinite_loop_check;
			if (isset($last_submit))
				$data_for_testcase['last_submit'] = $last_submit;
			$data_for_testcase['status'] = $status;
			//echo '000000  '.STUDENT_CFILES_FOLDER.$sourcecode_filename;
			if (strlen($sourcecode_filename) > 5 && file_exists(STUDENT_CFILES_FOLDER . $sourcecode_filename))
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);
			else
				$sourcecode_content = '';
		}



		$data = array(
			"lab_content"	=> $lab_content,
			"output"		=> $output_supervisor,
			'lab_chapter'	=> $chapter_id,
			'lab_item'		=> $item_id,
			'exercise_id'	=> $exercise_id,
			'lab_name'		=> $this->lab_model->get_lab_name($exercise_id),
			'full_mark'		=> $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id),
			'marking'				=> $marking,
			'submitted_count'		=> $submitted_count,
			'sourcecode_content' 	=> $sourcecode_content,
			'output_to_show'		=> array('1' => 'nothing'),
			'group_permission'		=> $this->_group_permission
			//'infinite_loop_check' => $infinite_loop_check
		);


		//echo "<h2><pre>"; print_r($data); echo "</pre></h2>";
		//exit();

		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/exercise_submission_header', $data);

		if ($number_of_testcase <= 0 && $submitted_count <= 0) {
			// do nothing	ยังไม่เคยส่ง ไม่มีอินพุท		
		} else if ($number_of_testcase <= 0 && $submitted_count > 0) {
			// ไม่มีอินพุท เคยส่งแล้ว แสดงผล การส่งครั้งล่าสุด
			$this->load->view('student/exercise_testrun', $last_submit);
		} else if ($number_of_testcase > 0 && $submitted_count <= 0) {
			// มีอินพุท ไม่เคยส่ง
			$this->load->view('student/exercise_output_testcase', $data_for_testcase);
		} else {
			// มีอินพุท เคยส่งแล้ว แสดงผล การส่งครั้งล่าสุด
			$this->load->view('student/exercise_output_testcase_student', $data_for_testcase);
		}

		$this->load->view('student/stu_footer');
	} //public function lab_exercise_v3($chapter_id,$item_id)


	//private function lab_exercise_action_v2($chapter_id,$item_id) {
	public function lab_exercise_action_v2($chapter_id, $item_id)
	{

		$stu_id = $_SESSION['stu_id'];
		$group_id = $_SESSION['stu_group'];
		//echo "<h1>".__METHOD__ . "<h1/>";
		//echo "<h3>stu_group : $group_id - stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  </h3>" ;
		$lab_data = $this->_lab_data; // all lab information that belong to this student
		//echo '<h4><pre>';print_r($lab_data[1]);echo '</pre><h4/>';

		//exit();
		$exercise_id = $lab_data[$chapter_id][$item_id]['stu_lab']['exercise_id'];
		$this->load->model('lab_model');
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
			if (isset($exercise_list[0])) {
				$exercise_id = $exercise_list[0];
			} else {
				echo "Lab : $chapter_id level : $item_id is NOT available.\n";
				return;
			}
			//echo "<h2>". "  exercise_id : ".$exercise_id."</h2>";


			// update student table

			$this->lab_model->update_student_exericse($stu_id, $chapter_id, $item_id, $exercise_id);
			$this->update_student_data();
			$lab_data = $this->_lab_data;
		}
		//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";



		$lab_content = $this->lab_model->get_lab_content($exercise_id);
		$sourcecode_content = '';

		$number_of_testcase = $this->lab_model->get_num_testcase($exercise_id);

		//echo '<h3>$lab_content : </h3><pre> testcase nubmer: ',$number_of_testcase,"<br>"; print_r($lab_content); echo "</pre>"; 
		$submitted_count = $this->student_model->get_student_submission_times($stu_id, $exercise_id);

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

		if ($number_of_testcase <= 0) {
			// the exercise has no testcase

			// run output from sample sourcecode for display and compare
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			//echo "<h3>sourcecode_filename99 : $sourcecode_filename</h3>";
			//echo "<h3>sourcecode_filename99 : $sourcecode_filename</h3>";
			//echo "<h3>sourcecode_filename99 : $sourcecode_filename</h3>";
			//echo "<h3>sourcecode_filename99 : $sourcecode_filename</h3>";
			//echo "<h3>sourcecode_filename99 : $sourcecode_filename</h3>";
			$output = $exercise_test->get_result_noinput($sourcecode_filename, 'supervisor'); // raw output 	
			//echo "<h3>output1 : $output</h3>"; 
			$output = $exercise_test->unify_whitespace($output);	// change TAB and NEWLINE to single space	
			//echo "<h3>output2 : $output</h3>"; 
			$output = $exercise_test->insert_newline($output); //insert newline after 80th character of each line
			$output = rtrim($output);				//remove trailing spaces
			//echo "<h3>output3 : $output</h3>"; 
			$lab_name = $this->get_lab_name($exercise_id);
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
			//$marking = $this->get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			$marking = $this->lab_model->get_max_marking_from_exercise_submission($stu_id, $exercise_id);

			$_SESSION['lab_item'] = $item_id;
			//echo '<h3>$_SESSION : </h3><pre>'; print_r($_SESSION); echo "</pre>"; 
			//echo '<h3>$output123 : </h3><pre>'; print_r($output); echo "</pre>"; 
			//return ;
			if ($submitted_count > 0) {
				// the exercise has no testcase and there are some submissions
				// take last_submit and do marking ==> update to exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id, $exercise_id);
				$submission_id = $last_submit['submission_id'];
				$sourcecode_filename = $last_submit['sourcecode_filename'];  // ของนักศึกษา
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);

				//run and get output
				$output_student = $exercise_test->get_result_noinput($sourcecode_filename, 'student');
				$output_student = $exercise_test->unify_whitespace($output_student);

				$sample_filename = $this->lab_model->get_lab_exercise_sourcecode_filename($exercise_id);
				$output_sample = $exercise_test->get_result_noinput($sample_filename, 'supervisor');
				$output_sample = $exercise_test->unify_whitespace($output_sample);

				//compare to exercise sample
				$output_result = $exercise_test->output_compare($output_student, $output_sample);
				if ($output_result == -1) {		// -1 means OK.
					$output_student = $exercise_test->insert_newline($output_student);
					//echo '<h2 style="color:red;">OK: </h2>';
					$marking = $full_mark;
					$this->lab_model->update_marking_exercise_submission($stu_id, $submission_id, $marking);
				} else {

					$error_line = $output_result['error_line'];
					$error_column = $output_result['error_column'];
					$error_position = $output_result['error_position'];
					echo '<h2 style="color:red;">unmatched_position : ', $error_position, "    line : ", $error_line, "    column : ", $error_column, "</h2>";

					//	add a line to output showing where the first error occurs.
					$output_student = $exercise_test->dispaly_error_in_output($output_student, $error_position);  // insert newline is embedded inside the function
				}

				$last_submit['sourcecode_content']	= $sourcecode_content;
				$last_submit['sourcecode_output']	= $output_student;
				$last_submit['submitted_count']	= $submitted_count;

				//for icon displayed at top-right panel
				if ($full_mark == $marking)
					$last_submit['status'] = 'passed';
				else
					$last_submit['status'] = 'error';


				//echo '<h3>$last submit : </h3><pre>'; print_r($last_submit); echo "</pre>"; 
			}
		} else { //if($infinite_loop_check=="NO"){ 
			/*
			*
			*	there are testcases because !($number_of_testcase <=0 )
			*
			*/
			//echo "<h1>551235</h1>";	//exit();
			$testcase_array = $this->lab_model->get_testcase_array($exercise_id);
			$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
			$output = ''; //reset output (no testcase)
			$status = "first_enter";
			//first time to do this exercise
			if ($submitted_count <= 0) {
				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
			} else {
				//echo "<h1>666</h1>";	//exit();
				//there is last submit so run it and do marking
				// from exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id, $exercise_id);

				$submission_id = $last_submit['submission_id'];
				$marking = $last_submit['marking'];
				//echo "<h2>last_submit=<pre>";print_r($last_submit);"<pre/></h2>";
				if (!is_null($last_submit['output']))
					$output = unserialize($last_submit['output']);
				$sourcecode_filename = $last_submit['sourcecode_filename'];
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);

				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);

				//run each testcase and compare result

				// $chapter_pass = 'yes';
				// each time testcase passes, $chapter_pass will be decreased.
				// if all testcases pass, $chater_pass will be zero
				$chapter_pass = sizeof($data_testcase);
				$testcase_pass = 0;
				for ($i = 0; $i < sizeof($data_testcase); $i++) {
					$data_testcase["$i"]['item_pass'] = 'yes';
					$testcase_content = $data_testcase["$i"]['testcase_content'];
					//run output and store in $data_testcase


					// check process with the same name before running the new one
					//$process_in_system = $this->check_and_kill_process($sourcecode_filename);

					//echo "<h2>111last_submit=</h2>";
					$output_student_original = $exercise_test->get_result_student_testcase($sourcecode_filename, $testcase_content);
					//echo "<h2>222last_submit=</h2>";
					//echo "<h2>output_student_original=".strlen($output_student_original)."</h2>";
					$output_length = strlen($output_student_original);
					//exit();
					$data_testcase["$i"]['output_to_show'] = $output_student_original;




					if ($output_length < MAX_OUTPUT_LENGTH) {
						$output_student = $exercise_test->unify_whitespace($output_student_original);
					} else {
						// suspend this file --> make all line commented
						// make log information
						// 
						$this->createLogFile($sourcecode_filename . " has suspended.");
						$file_content = $exercise_test->suspend_file_python($sourcecode_filename);
						$write = file_put_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename, $file_content);
						$output_student = substr($output_student_original, 0, MAX_OUTPUT_LENGTH / 4) . "\nToo long output . . .";
						//break;
					}
					//echo "<h2>333</h2>";
					$data_testcase["$i"]['testcase_student'] = $output_student;

					$output_sample = $data_testcase["$i"]['testcase_output'];
					$output_sample = $exercise_test->unify_whitespace($output_sample);
					//echo "<h2>444</h2>";

					//compare to exercise sample
					$output_result = $exercise_test->output_compare($output_student, $output_sample);
					echo "<h2>output_sample = $output_sample</h2>";
					echo "<h2>output_student = $$output_student</h2>";
					echo "<h2>output_result = $output_result </h2>";
					exit();

					//calculate marking of testcase and put into $data_testcase
					$item_pass = 'yes';
					if ($output_result == -1) {		// -1 means OK.
						//echo __METHOD__,'<h2 style="color:blue;"> your code is OK!</h2>';
						//update fullmark to exercise_submission
						//$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
						//$this->update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking);
						//$this->update_marking_exercise_submission($submission_id,$marking);
						//$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);
						$testcase_pass++;
					} else {

						$error_line = $output_result['error_line'];
						$error_column = $output_result['error_column'];
						$error_position = $output_result['error_position'];
						//echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";

						//	add a line to output showing where the first error occurs.
						$output_student = $exercise_test->dispaly_error_in_output($output_student, $error_position);
						$item_pass = 'no';
						$data_testcase["$i"]['error_line'] = $error_line;
						$data_testcase["$i"]['error_column'] = $error_column;
						$data_testcase["$i"]['error_position'] = $error_position;
					}
					$data_testcase["$i"]['output_to_show'] = $output_student_original;
					$data_testcase["$i"]['item_pass'] = $item_pass;
				}
				$status = "not_pass";


				if ($testcase_pass == sizeof($data_testcase)) {
					$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
					$this->lab_model->update_marking_exercise_submission($stu_id, $submission_id, $marking);
					$status = "passed";
				} else {
					$marking = 0;
					$this->lab_model->update_marking_exercise_submission($stu_id, $submission_id, $marking);
				}
			}
			$testcase_array = $data_testcase;
			$data_for_testcase['exercise_id'] = $exercise_id;
			$data_for_testcase['num_of_testcase'] = $num_of_testcase;
			$data_for_testcase['testcase_array'] = $testcase_array;
			//$data_for_testcase['infinite_loop_check'] = $infinite_loop_check;
			if (isset($last_submit))
				$data_for_testcase['last_submit'] = $last_submit;
			$data_for_testcase['status'] = $status;

			//echo "<pre>";print_r($data_testcase);echo "</pre>";
			//echo "<pre>";print_r($data_testcase2);echo "</pre>";


		}



		$data = array(
			"lab_content"	=> $lab_content,
			"output"		=> $output,
			'lab_chapter'	=> $chapter_id,
			'lab_item'		=> $item_id,
			'exercise_id'	=> $exercise_id,
			'lab_name'		=> $this->lab_model->get_lab_name($exercise_id),
			'full_mark'		=> $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id),
			'marking'		=> $this->lab_model->get_latest_marking_from_exercise_submission($stu_id, $exercise_id),
			'submitted_count'	=> $submitted_count,
			'sourcecode_content' => $sourcecode_content,
			'group_permission'	=> $this->_group_permission
			//'infinite_loop_check' => $infinite_loop_check
		);

		//$data['marking']=0;

		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/exercise_submission_header', $data);

		if ($number_of_testcase <= 0 && $submitted_count <= 0) {
			// do nothing	ยังไม่เคยส่ง ไม่มีอินพุท		
		} else if ($number_of_testcase <= 0 && $submitted_count > 0) {
			// ไม่มีอินพุท เคยส่งแล้ว แสดงผล การส่งครั้งล่าสุด
			$this->load->view('student/exercise_testrun', $last_submit);
		} else if ($number_of_testcase > 0 && $submitted_count <= 0) {
			// มีอินพุท ไม่เคยส่ง
			$this->load->view('student/exercise_output_testcase', $data_for_testcase);
		} else {
			// มีอินพุท เคยส่งแล้ว แสดงผล การส่งครั้งล่าสุด
			$this->load->view('student/exercise_output_testcase_student', $data_for_testcase);
		}

		$this->load->view('student/stu_footer');
	} //public function lab_exercise_v2($chapter_id,$item_id)


	private function lab_exercise_action_v1($chapter_id, $item_id)
	{
		$stu_id = $_SESSION['stu_id'];
		$group_id = $_SESSION['stu_group'];
		$exercise_id = "";
		//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";
		//echo '<h3>$_SESSION : </h3><pre>'; print_r($_SESSION); echo "</pre>"; 

		// setup exercise_id for student
		// 1. query from student_assigned_chapter_item
		// 2. if not available, get a new one from 
		//		- find all exercise from lab_exercise table  ==> all selected will be in $exercise_list
		//		- put $exercise_list into group_assigned_chapter_item
		//		- ramdomly select an exercise from $exercise_list ==> $exercise_id
		//		- put the exercise_id into student_assigned_chapter_item

		// $exercise_id equals -1 if not available
		$exercise_id = $this->student_model->get_exercise_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id);
		echo "<h2>" . __METHOD__ . " stu_id : " . $stu_id . "  chapter : " .  $chapter_id . "  item : " . $item_id . "  exercise_id : " . $exercise_id . "</h2>";
		if ($exercise_id < 0) {
			//	check for group status and list of exerccises 
			//	from group_assigned_chapter_item
			//	and update status of corresponding chapter/item
			$exercise_list = $this->lab_model->get_exercise_list($group_id, $chapter_id, $item_id);
			if (sizeof($exercise_list) <= 0)
				$this->show_message('lab_not_available');

			$exercise_id = $this->get_exercise_for_student($exercise_list); // randomly select from $exercise_list

			// update student table
			$this->load->model('lab_model');

			$this->lab_model->assign_student_exericse($stu_id, $chapter_id, $item_id, $exercise_id);
		}

		if ($exercise_id <= 0) {
			$this->show_message("lab_not_avialable");
		}

		echo "<h2>" . __METHOD__ . " stu_id : " . $stu_id . "  chapter : " .  $chapter_id . "  item : " . $item_id . "  exercise_id : " . $exercise_id . "</h2>";
		$lab_content = $this->lab_model->get_lab_content($exercise_id);
		$sourcecode_content = '';



		$number_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		//echo '<h3>$lab_content : </h3><pre> testcase nubmer: ',$number_of_testcase,"<br>"; print_r($lab_content); echo "</pre>"; 
		$submitted_count = $this->student_model->get_student_submission_times($stu_id, $exercise_id);
		require_once 'Exercise_test.php';
		$exercise_test = new Exercise_test();

		if ($number_of_testcase <= 0) {
			// the exercise has no testcase

			// run output from sample sourcecode for display and compare
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			$output = $exercise_test->get_result_noinput($sourcecode_filename, 'supervisor'); // raw output 				
			$output = $exercise_test->unify_whitespace($output);	// change TAB and NEWLINE to single space				
			$output = $exercise_test->insert_newline($output); //insert newline after 80th character of each line
			$output = rtrim($output);				//remove trailing spaces
			$lab_name = $this->get_lab_name($exercise_id);
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
			//$marking = $this->get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			$marking = $this->lab_model->get_max_marking_from_exercise_submission($stu_id, $exercise_id);

			$_SESSION['lab_item'] = $item_id;
			//echo '<h3>$_SESSION : </h3><pre>'; print_r($_SESSION); echo "</pre>"; 
			//echo '<h3>$data : </h3><pre>'; print_r($data); echo "</pre>"; 
			if ($submitted_count > 0) {
				// the exercise has no testcase and there are some submissions
				// take last_submit and do marking ==> update to exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id, $exercise_id);
				$submission_id = $last_submit['submission_id'];
				$sourcecode_filename = $last_submit['sourcecode_filename'];  // ของนักศึกษา
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);

				//run and get output
				$output_student = $exercise_test->get_result_noinput($sourcecode_filename, 'student');
				$output_student = $exercise_test->unify_whitespace($output_student);

				$sample_filename = $this->lab_model->get_lab_exercise_sourcecode_filename($exercise_id);
				$output_sample = $exercise_test->get_result_noinput($sample_filename, 'supervisor');
				$output_sample = $exercise_test->unify_whitespace($output_sample);

				//compare to exercise sample
				$output_result = $exercise_test->output_compare($output_student, $output_sample);
				if ($output_result == -1) {		// -1 means OK.
					$output_student = $exercise_test->insert_newline($output_student);
					//echo '<h2 style="color:red;">OK: </h2>';
					$marking = $full_mark;
					$this->lab_model->update_marking_exercise_submission($stu_id, $submission_id, $marking);
				} else {

					$error_line = $output_result['error_line'];
					$error_column = $output_result['error_column'];
					$error_position = $output_result['error_position'];
					echo '<h2 style="color:red;">unmatched_position : ', $error_position, "    line : ", $error_line, "    column : ", $error_column, "</h2>";

					//	add a line to output showing where the first error occurs.
					$output_student = $exercise_test->dispaly_error_in_output($output_student, $error_position);  // insert newline is embedded inside the function
				}

				$last_submit['sourcecode_content']	= $sourcecode_content;
				$last_submit['sourcecode_output']	= $output_student;
				$last_submit['submitted_count']	= $submitted_count;

				//for icon displayed at top-right panel
				if ($full_mark == $marking)
					$last_submit['status'] = 'passed';
				else
					$last_submit['status'] = 'error';


				//echo '<h3>$last submit : </h3><pre>'; print_r($last_submit); echo "</pre>"; 
			}
		} else {
			/*
			*
			*	there are testcases because !($number_of_testcase <=0 )
			*
			*/

			$testcase_array = $this->lab_model->get_testcase_array($exercise_id);
			$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
			$output = ''; //reset output (no testcase)
			//first time to do this exercise
			if ($submitted_count <= 0) {
				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
			} else {
				//there is last submit so run it and do marking
				// from exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id, $exercise_id);
				$submission_id = $last_submit['submission_id'];
				$marking = $last_submit['marking'];
				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
				$sourcecode_filename = $last_submit['sourcecode_filename'];
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);

				//run each testcase and compare result

				//$chapter_pass = 'yes';
				// each time testcase passes, $chapter_pass will be decreased.
				// if all testcases pass, $chater_pass will be zero
				$chapter_pass = sizeof($data_testcase);
				$testcase_pass = 0;
				for ($i = 0; $i < sizeof($data_testcase); $i++) {
					$data_testcase["$i"]['item_pass'] = 'yes';
					$testcase_content = $data_testcase["$i"]['testcase_content'];
					//run output and store in $data_testcase
					$output_student = $exercise_test->get_result_student_testcase($sourcecode_filename, $testcase_content);
					$output_student = $exercise_test->unify_whitespace($output_student);
					$data_testcase["$i"]['testcase_student'] = $output_student;

					$output_sample = $data_testcase["$i"]['testcase_output'];
					$output_sample = $exercise_test->unify_whitespace($output_sample);

					//compare to exercise sample
					$output_result = $exercise_test->output_compare($output_student, $output_sample);

					//calculate marking of testcase and put into $data_testcase
					$item_pass = 'yes';
					if ($output_result == -1) {		// -1 means OK.
						//echo __METHOD__,'<h2 style="color:blue;"> your code is OK!</h2>';
						//update fullmark to exercise_submission
						//$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
						//$this->update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking);
						//$this->update_marking_exercise_submission($submission_id,$marking);
						//$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);
						$testcase_pass++;
					} else {

						$error_line = $output_result['error_line'];
						$error_column = $output_result['error_column'];
						$error_position = $output_result['error_position'];
						//echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";

						//	add a line to output showing where the first error occurs.
						$output_student = $exercise_test->dispaly_error_in_output($output_student, $error_position);
						$item_pass = 'no';
					}
					$data_testcase["$i"]['output_to_show'] = $output_student;
					$data_testcase["$i"]['item_pass'] = $item_pass;
				}
				if ($testcase_pass == sizeof($data_testcase)) {
					$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
					$this->lab_model->update_marking_exercise_submission($stu_id, $submission_id, $marking);
				} else {
					$marking = 0;
					$this->lab_model->update_marking_exercise_submission($stu_id, $submission_id, $marking);
				}
			}
			$testcase_array = $data_testcase;
			$data_for_testcase['exercise_id'] = $exercise_id;
			$data_for_testcase['num_of_testcase'] = $num_of_testcase;
			$data_for_testcase['testcase_array'] = $testcase_array;
		}

		$data = array(
			"lab_content"	=> $lab_content,
			"output"		=> $output,
			'lab_chapter'	=> $chapter_id,
			'lab_item'		=> $item_id,
			'exercise_id'	=> $exercise_id,
			'lab_name'		=> $this->lab_model->get_lab_name($exercise_id),
			'full_mark'		=> $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id),
			'marking'		=> $this->lab_model->get_max_marking_from_exercise_submission($stu_id, $exercise_id),
			'submitted_count'	=> $submitted_count,
			'sourcecode_content' => $sourcecode_content,
			'group_permission'	=> $this->_group_permission
		);



		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/exercise_submission_header', $data);

		if ($number_of_testcase <= 0 && $submitted_count <= 0) {
			// do nothing			
		} else if ($number_of_testcase <= 0 && $submitted_count > 0) {
			$this->load->view('student/exercise_testrun', $last_submit);
		} else if ($number_of_testcase > 0 && $submitted_count <= 0) {
			$this->load->view('student/exercise_output_testcase', $data_for_testcase);
		} else {
			$this->load->view('student/exercise_output_testcase_student', $data_for_testcase);
		}

		$this->load->view('student/stu_footer');
	} //public function lab_exercise($chapter_id,$item_id)



	private function check_and_kill_process($sourcecode_filename)
	{
		require_once 'Process_protection.php';
		$proc_pro = new Process_protection();
		$process = $proc_pro->process_get($sourcecode_filename);
	}








	public function get_sourcecode_filename($exercise_id)
	{
		$this->load->model('lab_model');
		$sourcecode_filename = $this->lab_model->get_sourcecode_filename($exercise_id);
		return $sourcecode_filename;
	}

	public function get_lab_name($exercise_id)
	{
		$this->load->model('lab_model');
		$lab_name = $this->lab_model->get_lab_name($exercise_id);
		return $lab_name;
	}

	public function get_exercise_list($stu_id, $chapter_id, $item_id)
	{
		$this->load->model('lab_model');
		return $this->lab_model->get_exercise_list($stu_id, $chapter_id, $item_id);
	}

	public function get_exercise_for_student($exercise_list)
	{

		shuffle($exercise_list);
		$exercise_id = $exercise_list[0];

		return $exercise_id;
	}





	// store submitted file in harddisk 
	// and update exercise_submission file name
	// this is also an entry function
	public function exercise_submission()
	{
		// echo "<h1>".__METHOD__."</h1>\n";
		$_SESSION['show_to_console'] = __METHOD__;
		// $this->show_to_console("test");
		$this->update_student_data();
		//ตรวจสอบ การห้ามทำแลป จากตาราง class_schedule
		$_SESSION['page_name'] = 'exercise_submit';


		//echo "<h1>. . .   Under Construction   . . .</h1>";
		//check table student_assigned_chapter_item
		//echo '<h2>$_POST</h2>',"<pre>",print_r($_POST),"</pre>";
		//echo '<pre>',print_r($_FILES),'</pre>';
		//echo "<pre>",print_r($_SESSION),"</pre>";
		$stu_id = $_SESSION['stu_id'];
		$chapter_id = $_POST['chapter_id'];
		$item_id = $_POST['item_id'];
		$exercise_id = $_POST['exercise_id'];
		$saved_filename = '';
		// $_SESSION['page_name'] .= " chapter:$chapter_id item:$item_id";
		if ($this->_group_permission[$chapter_id]['allow_submit'] == 'no') {

			$this->show_message("You are not allowed to submit exercise.");
		} else {
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
			$marking = $this->lab_model->get_max_marking_from_exercise_submission($stu_id, $exercise_id);
			//echo $stu_id,' | ', $chapter_id,' | ', $item_id,' | ', $exercise_id,' | ', $marking ,' | ',$full_mark ,'<br>';
			//echo '$_FILES[submitted_file] : ',$_FILES["submitted_file"]["name"],'<br>';
			/*
			if( $marking == $full_mark ) {
				//$this->set_flashdata('456549879');
				$this->exercise_show();
			}
			*/

			// TO DO Check for duplicate content with previous submissions

			//store file and detail in database
			if (!empty($_FILES['submitted_file'])) {
				$fileupload =  $_FILES['submitted_file']['tmp_name'];
				$fileupload_name = $_FILES['submitted_file']['name'];
				$ext = strtolower(pathinfo($_FILES['submitted_file']['name'], PATHINFO_EXTENSION));
				$upload_filename = pathinfo($_FILES['submitted_file']['name'], PATHINFO_FILENAME);

				// set filename format likes 59112233_01_02_0001
				$saved_filename = '' . $_SESSION['stu_id'];
				$lab_chapter = '' . $_POST['chapter_id'];
				while (strlen($lab_chapter) < 2)
					$lab_chapter = '0' . $lab_chapter;
				$saved_filename = $saved_filename . '_' . $lab_chapter;
				$lab_item = '' . $_POST['item_id'];
				while (strlen($lab_item) < 2)
					$lab_item = '0' . $lab_item;
				$saved_filename = $saved_filename . '_' . $lab_item;

				// submitted_round คือ ส่งมาแล้วกี่ครั้ง
				// submit_round คือ ครั้งนี้เป็นการส่งคร้งที่เท่าไหร่
				$submitted_round = $this->student_model->get_student_submission_times($stu_id, $exercise_id);
				$submit_round = '' . ($submitted_round + 1);
				while (strlen($submit_round) < 4)
					$submit_round = '0' . $submit_round;
				$saved_filename = $saved_filename . '_' . $submit_round . ".py";

				//echo "filename : ".$fileupload_name .' newname : '.$saved_filename."<br>";
				//echo "content : <br>";
				//echo $fileupload."<br>";
				$file_content = file_get_contents($fileupload);
				//echo $file_content."<br>";
				//echo "<pre>".$file_content."</pre>";
				$now_time = time();
				$assigned_time = $this->lab_model->get_assigned_time($stu_id, $chapter_id, $item_id);
				$elapsed_time = (int) (($now_time - $assigned_time) / 60);
				$heading = "'''" . PHP_EOL;
				$heading .= " * กลุ่มที่  : " . $_SESSION['stu_group'] . PHP_EOL;
				$heading .= " * " . $_SESSION['stu_id'] . " " . $_SESSION['stu_firstname'] . " " . $_SESSION['stu_lastname'] . PHP_EOL;
				$heading .= " * chapter : " . $_POST['chapter_id'] . chr(9) . "item : " . $_POST['item_id'] .  chr(9) . "ครั้งที่ : " . $submit_round . PHP_EOL;
				$heading .= " * Assigned : " . date('l jS \of F Y h:i:s A', $assigned_time) . " --> Submission : " . date('l jS \of F Y h:i:s A') . chr(9) . PHP_EOL;
				$heading .= " * Elapsed time : " . $elapsed_time . " minutes." . PHP_EOL;
				$heading .= " * filename : " . $fileupload_name . PHP_EOL;


				$heading .= "'''" . PHP_EOL;
				$file_content_submission = $heading . $file_content;
				//echo "<pre>".$file_content_submission."</pre>";
				//write to harddisk
				try {
					$write = file_put_contents(STUDENT_CFILES_FOLDER . $saved_filename, $file_content_submission);
				} catch (Exception $e) {
					$this->show_message($e->getMessage());
					return;
				}
				//finally {
				//	return;
				//}
				//echo "write : $write <br>";

				//add submission detail to file
				// เก็บชื่อไฟล์ลงดาต้าเบส  exercise_submission
				$sourcecode_filename = $saved_filename;
				$data = array(
					'stu_id'				=> $stu_id,
					'exercise_id'			=> $exercise_id,
					'sourcecode_filename'	=> $sourcecode_filename,
					'marking'				=> 0,
					'inf_loop'				=> 'Yes',
					'output'				=> ''
				);

				$submission_data = $this->lab_model->exercise_submission_add($data);
				// $submission_data example
				//Array
				//	(
				//		[submission_id] => 1151
				//		[stu_id] => 99010001
				//		[exercise_id] => 1
				//		[sourcecode_filename] => 99010001_01_01_0004.py
				//		[marking] => 0
				//		[time_submit] => 2020-02-11 08:57:35
				//		[inf_loop] => Yes
				//		[output] => 
				//	)



			}
			// echo "12346\n";
			$submission_data['chapter_id'] = $chapter_id;
			$submission_data['item_id'] = $item_id;
			$stu_group = $_SESSION['stu_group'];
			$message = " group=$stu_group Submitting_id=" . $submission_data['submission_id'] . " : " . $saved_filename;
			$this->createLogFile($message);
			// echo "abc\n";
			$latest_submission = $this->execute_submission($submission_data);
			$submission_data['output'] = $latest_submission['output'];
			$submission_data['inf_loop'] = $latest_submission['inf_loop'];
			$this->createLogFile(__METHOD__ . " " . $message . " execute_submission . . . Done ");
			// echo "def\n";

			$latest_submission = $this->execute_marking($submission_data);
			$message .= " marking : " . $latest_submission['marking'];
			$this->createLogFile(__METHOD__ . " " . $message);
			// echo "ghi\n";
			$latest_submission = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
			//echo '<h4>latest_submission<pre>';print_r($latest_submission);echo '</pre><h4/>';

			//exit();
			// echo "789\n";
			$this->lab_exercise($chapter_id, $item_id);
		}
	} //public function exercise_submission()

	// execute the submission
	// and store output on table "exercise submission"
	// 		case 1: no testcase
	//		case 2: some testcases
	//		indentified by number of testcase
	private function execute_submission($submission)
	{
		//echo "<h1>".__METHOD__."</h1>";
		//echo "<h3>submission <pre>"; print_r($submission); echo "</pre></h3>";
		//	$submission
		//		Array
		//		(
		//			[submission_id] => 1156
		//			[stu_id] => 99010001
		//			[exercise_id] => 1
		//			[sourcecode_filename] => 99010001_01_01_0009.py
		//			[marking] => 0
		//			[time_submit] => 2020-02-11 09:28:33
		//			[inf_loop] => Yes
		//			[output] => 
		//			[chapter_id] => 1
		//			[item_id] => 1
		//		)
		$stu_group = $_SESSION['stu_group'];
		$this->load->model('lab_model');
		$stu_id = $submission['stu_id'];
		$exercise_id = $submission['exercise_id'];
		$sourcecode_filename = $submission['sourcecode_filename'];
		$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
		$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);
		//echo "<h2>".__METHOD__." num_of_testcase = $num_of_testcase</h2>";

		require_once 'Exercise_test.php';
		$exercise_test = new Exercise_test();


		if ($num_of_testcase <= 0) {
			$submission['output'] = rtrim($exercise_test->get_exercise_output_no_testcase_python($sourcecode_filename, "student"));
			$submission['inf_loop'] = "No";
			$result = $this->lab_model->exercise_submission_update($submission);
			//echo "<h1>".__METHOD__."111 <pre>"; print_r($result);echo "</pre></h1";
			//exit();

		} else {

			//**************************************************************
			//
			//	there are testcases because $number_of_testcase > 0 
			//			and also some testcases
			//
			//***************************************************************

			$submission_id = $submission['submission_id'];
			$marking = $submission['marking'];
			$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
			$sourcecode_filename = $submission['sourcecode_filename'];
			$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER . $sourcecode_filename);
			//echo "<h1>".__METHOD__."<br/>data_testcase <pre>"; print_r($data_testcase);echo "</pre></h1>";
			$output_testcase = array();

			$submission_latest = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
			//echo "<h3>submission_latest 000 <pre>"; print_r($submission_latest);echo "</pre></h3>";	
			//run each testcase and store them to exercise submission field output
			for ($i = 0; $i < sizeof($data_testcase); $i++) {
				//echo '<h1 style="color:red;"> --- '.$i.'</h1>';
				//$this->exercise_submission_show($submission_latest['submission_id']);
				//echo '<h1 style="color:red;">'.$i.' ---  </h1>';

				$testcase_no =   sprintf("%03d", $i); 		// make $testcase_no to be 3 digits
				$testcase_content = $data_testcase[$i]['testcase_content'];
				$mode = "student";
				$output_latest = $submission_latest['output'];
				// if ($stu_id = 90015678) {
				// 	echo $stu_id." i=$i \n";
				// 	echo "sourcecode_filename: $sourcecode_filename\n";
				// 	echo "testcase_input=$testcase_content\n";
				// 	echo "output-> ".$output_latest."==\n";
				// }
				//run output and store in $data_testcase
				$output_student_original = $exercise_test->get_result_testcase_python($sourcecode_filename, $testcase_content, $mode);

				if ($_SESSION['stu_id'] == 65991234) {
					// echo "<pre> step 1 => output lenght ",strlen($output_student_original),"<pre>";
					// echo "<pre> step 1 => output lenght ",$output_student_original,"<pre>";
				}
				$max_length = 1024;
				if (strlen($output_student_original) < 5) {
					$output_student_original = serialize("No OUTPUT !!!!!");
				}
				if (strlen($output_student_original) >= $max_length) {
					$output_student_original = substr($output_student_original, 0, $max_length);
				}

				if ($_SESSION['stu_id'] == 65991234) {
					// $output_student_original = substr($output_student_original,0,$max_length);
					// echo "<pre> step 222 => output lenght ",strlen($output_student_original),"<pre>";
					// exit;
				}

				$output_testcase[$i] = array();
				$output_testcase[$i]['status'] = "FAIL";
				$output_testcase[$i]['testcase'] = $output_student_original;
				$submission_latest['output'] = serialize($output_testcase);
				$this->lab_model->exercise_submission_update($submission_latest);

				//$output[$i] = TESTCASE_STRING.$testcase_no." ".$output_student_original;
				//echo $output;
				//echo nl2br($output_student_original);
				//$submission['output'] .= $output;
				//$this->lab_model->exercise_testcase_update($submission);
				//echo "<h4>".__METHOD__."<br/>submission <pre>"; print_r($submission);echo "</pre></h4>";
				//$this->exercise_submission_show($submission_latest['submission_id']);
				//echo '<h1 style="color:red;">'.$i.' ---  </h1>';
				if (strlen($output_student_original) >= $max_length) {
					break;
				}
			}


			//echo "<h1>".__METHOD__."<br/>submission <pre>"; print_r($submission);echo "</pre></h1>";
			$submission_latest = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
			//echo "<h1>".__METHOD__."<br/>submission_latest1 <pre>"; print_r($submission_latest);echo "</pre></h1>";
			$submission_latest['inf_loop'] = "No";
			$this->lab_model->exercise_submission_update($submission_latest);
			$submission_latest = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
			//echo "<h1>".__METHOD__."<br/>submission_latest2 <pre>"; print_r($submission_latest);echo "</pre></h1>";	


		}
		//echo "<h1>".__METHOD__."</h1>";
		//$this->exercise_submission_show($submission_id);
		//exit();

		return $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
	} // private function execute_submission($submission)



	// store marking on exercise_submission table
	//		case 1: no testcase
	//		case 2: some testcases
	// 		identified by number of testcase
	//		and also store the status
	// 			finally ==> update marking
	private function execute_marking($latest_submission)
	{
		// echo "strart  ".__METHOD__." \n";
		//echo "<h1>".__METHOD__."<h3><pre>"; print_r($latest_submission);echo "</pre></h3></h1>";
		//$this->exercise_submission_show($latest_submission['submission_id']);
		// $latest_submission Array
		//	(
		//		[submission_id] => 1184
		//		[stu_id] => 99010001
		//		[exercise_id] => 1
		//		[sourcecode_filename] => 99010001_01_01_0037.py
		//		[marking] => 0
		//		[time_submit] => 2020-02-11 11:33:01
		//		[inf_loop] => No
		//		[output] => Hello, World!
		//		[chapter_id] => 1
		//		[item_id] => 1
		//	)

		$stu_id = $latest_submission['stu_id'];
		$exercise_id =	$latest_submission['exercise_id'];
		$inf_loop =	$latest_submission['inf_loop'];
		$output_student = $latest_submission['output'];
		$chapter_id = $latest_submission['chapter_id'];
		$item_id = $latest_submission['item_id'];
		$submission_id = $latest_submission['submission_id'];

		require_once 'Exercise_test.php';
		$this->load->model('lab_model');
		$exercise_test = new Exercise_test();
		$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		//echo "<h2>".__METHOD__." num_of_testcase = $num_of_testcase</h2>";
		//exit();
		if ($inf_loop != 'No') {
			echo "<h1 style='color:red;'> Check your code again </h1>";
			echo "<h1 style='color:red;'> It may contain infinite loop !!! </h1>";
			exit();
		}
		// echo "strart 2 ".__METHOD__." \n";
		if ($num_of_testcase <= 0) { // the exercise has no testcase


			// run output from sample sourcecode for display and compare
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			//echo "<h3>sourcecode_filename99 : $sourcecode_filename</h3>";
			$output_supervisor = $exercise_test->get_result_noinput($sourcecode_filename, 'supervisor'); // raw output 	

			$lab_name = $this->get_lab_name($exercise_id);

			//return -1 for ok OR $data = array ( 'error_position'	=> $error_position,'error_line'	=> $error_line,'error_column'=> $error_column);
			$result = $exercise_test->output_compare($output_supervisor, $output_student);
			//if (is_array($result)) {
			//	echo "<h3>result : <pre>";print_r($result); echo "</pre></h3>"; 
			//} else {
			//	echo "<h3>result : $result</h3>"; 
			//}
			//echo " latest_submission<pre>";print_r($latest_submission); echo "</pre> ";

			if ($result == -1) { // -1 means OK
				$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
				//echo "<h1>full_mark : $full_mark</h1>"; 
				$latest_submission['marking'] = $full_mark;
				$latest_submission['status'] = 'PASS';
			} else {
				$latest_submission['status'] = 'FAIL';
			}
			//echo " latest_submission<pre>";print_r($latest_submission); echo "</pre> ";
			$this->lab_model->exercise_submission_update($latest_submission);
		} else { // there are testcases and at least a summission

			//**************************************************************
			//*
			//*		there are testcases because ($number_of_testcase > 0 )
			//*
			//***************************************************************/

			$testcase_array = $this->lab_model->get_testcase_array($exercise_id);
			//echo "<h2>".__METHOD__." testcase_array <pre>"; print_r($testcase_array);echo "</pre></h2>";
			// if ($_SESSION['stu_id']==65991234) {
			// 	echo $latest_submission['output'];
			// 	//exit;
			// }
			$testcase_student = unserialize($latest_submission['output']);

			//echo "<h2 style='color:blue;'>".__METHOD__." testcase_student <pre>"; print_r($testcase_student);echo "</pre></h2>";

			$result = 0;
			$result_sum = 0;
			for ($i = 0; $i < $num_of_testcase; $i++) {
				$output_sample = $testcase_array["$i"]['testcase_output'];
				$output_student = $testcase_student["$i"]['testcase'];
				$result = $exercise_test->output_compare($output_sample, $output_student); 	// return -1 on OK
				if (!is_array($result)) {
					//echo "<pre>";print_r($result); echo "</pre>";
					$result_sum += $result;
					//echo "testcase:$i ->".$result."<br/>";
					if ($result == -1) {
						$testcase_student[$i]['status'] = 'PASS';
					}
				}
				//echo "<h2 style='color:BlueViolet;'>"." testcase_student <pre>"; print_r($testcase_student);echo "</pre></h2>";
				$latest_submission['output'] = serialize($testcase_student);
				$this->lab_model->exercise_submission_update($latest_submission);
				if (sizeof($testcase_student) - $i <= 1) {
					break;
				}
			}

			if ($result_sum == -1 * $num_of_testcase) { // -1 means OK
				$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
				//echo "<h1>full_mark : $full_mark</h1>"; 
				$marking = $full_mark;
				$this->lab_model->update_marking_exercise_submission($stu_id, $submission_id, $marking);
			}
		}
		$latest_submission = $this->lab_model->get_latest_record_from_exercise_submission($stu_id, $exercise_id);
		//$this->exercise_submission_show($latest_submission['submission_id']);
		//exit();
		// echo "End  ".__METHOD__." \n";
		return $latest_submission;
	}

	private function exercise_submission_show($submission_id)
	{
		$ex = $this->lab_model->get_exercise_submission($submission_id);
		if (empty($ex)) {
			echo "<h1>function exercise_submission_show($submission_id) --> empty</h1>";
			return;
		}
		echo "<h2>555<pre>";
		print_r($ex);
		echo "</pre></h2>";
		echo "<h2>submission " . $ex['submission_id'] . " " . $ex['stu_id'] . " " . $ex['exercise_id'] . " " . $ex['sourcecode_filename'] . " <h2>";
		echo "<h2>marking = " . $ex['marking'] . " time_submit = " . $ex['time_submit'] . " inf_loop = " . $ex['inf_loop'] . " <h2>";
		echo "<h2>output = " . $ex['output'] . "<br/> size = " . strlen($ex['output']) . " bytes<h2>";
		$output_testcase = $ex['output'];
		$output_testcase = unserialize($output_testcase);



		$num_of_testcase = $this->lab_model->get_num_testcase($ex['exercise_id']);
		echo "<h2>num_of_testcase = " . $num_of_testcase . " <h2>";
		if ($num_of_testcase > 0 && is_array($output_testcase)) {
			$end = sizeof($output_testcase);

			for ($i = 0; $i < $end; $i++) {
				$line = $output_testcase[$i];
				if (isset($line['status']) && isset($line['testcase'])) {
					echo "<h3>" . " $i " . $output_testcase[$i]['status'] . "</h3>";
					echo "<h3>" . " $i " . $output_testcase[$i]['testcase'] . "</h3>";
				} else {
					echo "<h3>$i ==> $line<h3/>";
				}
			}
		}

		//echo "<h3>submission_latest['output'] : ".sizeof($output_testcase)."</h3>";	

		//exit();
	}


	public function get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id)
	{
		$this->load->model('lab_model');
		$full_mark = $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
		return $full_mark;
	}

	public function get_marking_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id)
	{
		$this->load->model('lab_model');
		$full_mark = $this->lab_model->get_marking_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
		return $full_mark;
	}

	public function update_marking_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $marking)
	{
		$this->load->model('lab_model');
		$this->lab_model->update_marking_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $marking);
	}

	public function update_marking_exercise_submission($submission_id, $marking)
	{
	}

	public function checkForInfiniteLoop()
	{

		//$stu_id = $_SESSION['stu_id'];
		// get process from system command
		$process = $this->process_get_student();
		//echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';
		//echo '<br/> <pre>';print_r($process); echo '</pre><br/>';


		if (sizeof($process) <= 0) {
			return;
		}
		// processing infinite loop
		//	1. add to database
		//	2. kill the process
		//	3. add information to sourcecode such as this is infinite loop
		//	4. band for 5 minutes

		foreach ($process as $line) {

			// check whether the process is running more than the time 
			$str_time = $line['time'];
			sscanf($str_time, "%d:%d", $minutes, $seconds);
			$time_in_second = 60 * $minutes + $seconds;

			if ($time_in_second < MAX_RUN_TIME_IN_SECOND) {
				continue; //skip this process
			}

			$filename_infinite_loop = $line['filename_infinite_loop'];

			//echo 'inf proc_status : <pre>';print_r($line); echo '</pre><br/>';
			$pid = $line['pid'];
			//echo '<br/>'; echo $pid;
			//add to database
			$this->load->model('lab_model');
			$this->lab_model->update_student_infinite_loop($line);

			//add information to sourcecode such as this is infinite loop
			$sourcefile = STUDENT_CFILES_FOLDER . $line['filename_infinite_loop'] . '.py';
			//echo '<br/>';echo $sourcefile;
			if (file_exists($sourcefile)) {

				$file_content = file_get_contents($sourcefile);
				$file_content_new = "# *** Please check the contents *** \\n";

				foreach (preg_split("/((\r?\n)|(\r\n?))/", $file_content) as $line) {
					if (substr($line, 0, 1) != '#') {
						$file_content_new .= "# " . $line . "\r\n";  // make every line to comment	
					}
				}
				$file_content_new .= 'print("This file makes system crashed")' . "\r\n";
				$file_content_new .= 'print("0.1 คะแนน จะถูกหักออกจากคะแนนที่ได้")' . "\r\n";



				file_put_contents($sourcefile, $file_content_new);
				$this->$this->createLogFile("Infinite loop --> " . $sourcefile . ' commented !!!');
			}

			$outfile = STUDENT_CFILES_FOLDER . $line['filename_infinite_loop'] . '.outfile';
			if (file_exists($outfile)) {
				exec("rm $outfile ");
				$this->$this->createLogFile("Remove output file --> " . $outfile);
			}

			//kill the process//kill process
			shell_exec("kill -9 $pid ");


			//band for 5 minutes


		}
	}


	public function process_get_student()
	{
		$processes = shell_exec("ps -aux | grep 'student_data' ");
		//echo '<br/---->';print_r($processes);
		/*if(strlen($processes)<20) {
			return NULL;
		}
		*/
		$process = array();
		$line_no = 0;
		foreach (preg_split("/((\r?\n)|(\r\n?))/", $processes) as $line) {
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
			if (strlen($command) > 20) {
				$process[$line_no]['user'] = $user;
				$process[$line_no]['pid'] = $pid;
				$process[$line_no]['cpu'] = $cpu;
				$process[$line_no]['mem'] = $mem;
				$process[$line_no]['vsz'] = $vsz;
				$process[$line_no]['rss'] = $rss;
				$process[$line_no]['tty'] = $tty;
				$process[$line_no]['stat'] = $stat;
				$process[$line_no]['start'] = $start;
				$process[$line_no]['time'] = $time;
				$process[$line_no]['command'] = $command;
				$process[$line_no]['filename_infinite_loop'] = substr($command, 23, 19);
				$process[$line_no]['stu_id'] = substr($command, 23, 8);
				$process[$line_no]['chapter'] = (int)substr($command, 32, 2);
				$process[$line_no]['item'] = (int)substr($command, 35, 2);
				$process[$line_no]['sequence'] = (int)substr($command, 38, 4);

				$line_no++;
			}
			//echo $line_no.' : '.$user.' : '.$pid.' : '.$command.'<br/>';

		}
		return $process;
	}

	public function test_file_reader()
	{
		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/test_file_reader');


		$this->load->view('student/stu_footer');
	}


	// 29-8-2565
	// codemirror test
	public function test_codemirror()
	{
		$this->load->view('student/test_codemirror');
	}
	// 2565-09-02 kanut
	public function instruction()
	{
		$_SESSION['selected_menu'] = 'instruction';
		$_SESSION['page_name'] = 'instruction';
		$this->createLogFile(__METHOD__);
		$this->update_student_data();

		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('instruction');
		//$this->load->view('student/stu_home_utf8');
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');

	} //public function instruction()

	// 2565-09-07 kanut
	public function about()
	{
		$_SESSION['selected_menu'] = 'about';
		$_SESSION['page_name'] = 'about';
		$this->createLogFile(__METHOD__);
		$this->update_student_data();

		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('about');
		//$this->load->view('student/stu_home_utf8');
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');

	} //public function about()

	// 2565-09-02 kanut
	public function faq()
	{
		$_SESSION['selected_menu'] = 'faq';
		$_SESSION['page_name'] = 'faq';
		$this->createLogFile(__METHOD__);
		$this->update_student_data();

		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('faq');
		//$this->load->view('student/stu_home_utf8');
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');

	} //public function  faqx()

	// 2565-09-02 kanut
	public function practice_exam()
	{
		$_SESSION['selected_menu'] = 'practice_exam';
		$_SESSION['page_name'] = 'practice_exam';
		$this->createLogFile(__METHOD__);
		$this->update_student_data();

		// $this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('practice_exam');
		//$this->load->view('student/stu_home_utf8');
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');

	} //public function practice_exam()




} //class Student
