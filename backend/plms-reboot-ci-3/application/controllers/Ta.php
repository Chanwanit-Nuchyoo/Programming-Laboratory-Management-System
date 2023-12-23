<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));

class Ta extends MY_Controller {
	protected $access = "ta";

	public function __construct()	{
		parent::__construct();		
	}
	
	public function index()	{
		//update student information
		//echo "<h1>supervisor page index </h1>";
		//$this->show_constants();
		
		$this->createLogFile(__METHOD__);
		$this->update_last_seen();
		$this->logout_after_time_limit();
		
		//update supervisor information as necessary
		$this->load->model('ta_model');
		$this->load->model('lab_model');
		$this->ta_model->update_supervisor_profile();
		//$this->show_constants();

		//$this->load->view('supervisor/head');
		//$this->load->view('supervisor/template_edit');
		$class_schedule = $this->supervisor_model->get_class_schedule();
		echo '<!-- class_schedule : <pre>'; print_r($class_schedule); echo '</pre> -->';
		for($i=0; $i<sizeof($class_schedule); $i++) {
			$group_id = $class_schedule[$i]['group_id'];
			$students_in_group = $this->lab_model->get_count_of_students($group_id);
			$class_schedule[$i]['num_students'] = $students_in_group;
		}

		$data = array('class_schedule'=>$class_schedule);
		$this->load->view('ta/head');
		$this->load->view('ta/nav_fixtop');
		$this->load->view('ta/nav_sideleft');
		$this->load->view('ta/home',$data);
		$this->load->view('ta/footer');
		
		
		

		//$this->load->view('test_webpage3');
		
	}//public function index()
	
	/*
	*	Add new row into lab_exercise table
	*	then, go to exercise_edit
	*/
	public function exercise_add() {
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		// insert new record into lab_exercise table
		// and update $_SESSION['lab_2b_edit']
		$this->load->model('lab_model');
		$exercise_id = $this->lab_model->exercise_add();
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";

		$_POST = array();
		$_POST['exercise_id']= $exercise_id;
		$this->exercise_edit();

	}

	public function exercise_add_chapter_item() {
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST :</h3><pre>"; print_r($_POST); echo "</pre>";
		$chapter = $_POST['lab_no'];
		$level = $_POST['level'];
		$created_by = $_POST['user_id'];
		// insert new record into lab_exercise table
		// and update $_SESSION['lab_2b_edit']
		$this->load->model('lab_model');
		$exercise_id = $this->lab_model->exercise_add_chapter_item($chapter,$level,$created_by);
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";

		$_POST = array();
		$_POST['exercise_id']= $exercise_id;
		$this->exercise_edit();
		

	}
	public function exercise_add_chapter_item_python() {
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST :</h3><pre>"; print_r($_POST); echo "</pre>";
		$chapter = $_POST['lab_no'];
		$level = $_POST['level'];
		$created_by = $_POST['user_id'];
		// insert new record into lab_exercise table
		// and update $_SESSION['lab_2b_edit']
		$this->load->model('lab_model');
		$exercise_id = $this->lab_model->exercise_add_chapter_item_python($chapter,$level,$created_by);
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";

		$_POST = array();
		$_POST['exercise_id']= $exercise_id;
		$this->exercise_edit();
		

	}

	public function exercise_edit_part1() {
		//echo "<h2>". __METHOD__ ." : _SESSION :</h2><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST : size = ". sizeof($_POST)."</h3><pre>"; print_r($_POST); echo "</pre>";
		
		//update table lab_exercise
		$data = $_POST;
		$exercise_id = $_POST['exercise_id'];
		$this->load->model("lab_model");
		$this->lab_model->update_lab_exercise_part1($data);
		//reset $_POST
		$_POST = array();
		$_POST['exercise_id'] = $exercise_id;
		$this->exercise_edit();

	}
	
	//update lab_content
	public function exercise_edit_part2() {
		//echo "<h2>". __METHOD__ ." : _SESSION :</h2><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST : size = ". sizeof($_POST)."</h3><pre>"; print_r($_POST); echo "</pre>";
		$exercise_id = $_POST['exercise_id'];
		$lab_content = $_POST ['lab_content'];
		
		$data = array (
						'exercise_id'	=> $_POST['exercise_id'],
						 'lab_content'	=> htmlspecialchars($lab_content)
				);
		$exercise_id = $_POST['exercise_id'];
		
		//update table lab_exercise
		$this->load->model("lab_model");
		$this->lab_model->update_lab_exercise_part2($data);
		//reset $_POST
		$_POST = array();
		$_POST = array('exercise_id' => $exercise_id);
		$this->exercise_edit();

	}
	
	//update sourcecode_content overwrite the old one
	public function exercise_edit_part3() {
		//echo "<h2>". __METHOD__ ." : _SESSION :</h2><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST : size = ". sizeof($_POST)."</h3><pre>"; print_r($_POST); echo "</pre>";
		//update table lab_exercise
		$data = $_POST;
		$exercise_id = $data['exercise_id'];
		$sourcecode_filename = $data['sourcecode_filename'];
		//echo "<h1>$sourcecode_filename</h1>";
		//exit();
		$sourcecode_content = $data['sourcecode_content'];
		if (strlen($sourcecode_content) > 10 ) {
			//	write content to harddisk
			if (strlen($sourcecode_content) > 10) {
				file_put_contents(SUPERVISOR_CFILES_FOLDER.$sourcecode_filename,$sourcecode_content);
			}

			/*
			//	mode is to choose where to keep .exe file  --> 'student' or 'supervisor'
			//	generate $sourcecode_output
			require_once 'Exercise_test.php';
			$exercise_test = new exercise_test();
			$mode = $_SESSION['role'];
			$sourcecode_output = $exercise_test->get_result_noinput($sourcecode_filename,$mode);
			$sourcecode_output = $exercise_test->unify_whitespace($sourcecode_output);
			$sourcecode_output = $exercise_test->insert_newline($sourcecode_output);
			$_SESSION['sourcecode_output']  = $sourcecode_output;
			$_SESSION['sourcecode_content']  = $sourcecode_content;
			*/
		};
		//reset $_POST
		$_POST= array();
		$_POST['exercise_id'] = $exercise_id;
		$this->exercise_edit();

	}

	public function exercise_testcase_add() {
		//echo "<pre>",print_r($_POST),"</pre>";
		$exercise_id = $_POST['exercise_id'];
		$this->load->model('lab_model');
		$this->lab_model->exercise_testcase_add($exercise_id);
		$_POST=array();
		$_POST['exercise_id'] = $exercise_id;
		$this->exercise_edit();
	}

	// update only one testcase: content,note, output
	// and rerun the testcase to get output
	public function exercise_testcase_update() {
		//echo '<pre>',print_r($_POST),'</pre>';
		$testcase = $_POST;
		$exercise_id = $testcase['exercise_id'];
		$testcase_id = $testcase['testcase_id'];
		$testcase_content = $testcase['testcase_content'];
		if(strlen($testcase_content) <=0) {
			$this->show_message("You must put some data for Testcase content.");
			return ;
		}

		// update only one testcase
		require_once 'Exercise_test.php';
		$exercise_test = new exercise_test();
		$this->load->model('lab_model');
		$sourcecode_filename = $this->lab_model->get_sourcecode_filename($testcase['exercise_id']);
		$testcase['testcase_output'] = $exercise_test->get_exercise_output($sourcecode_filename,$testcase['testcase_content']);

		$this->load->model('lab_model');
		$this->lab_model->exercise_testcase_update($testcase);

		$_POST=array();
		$_POST['exercise_id'] = $exercise_id;
		$this->exercise_edit();
	}

	/*
	*	1. call from exercise_show, only $exercise_id is posted.
	*	2. call from exercise_show/add exercise only  $exercise_id is posted and no other info in database
	*	3. call from exercise_edit, will have all 
	*/	
	public function exercise_edit() {
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST : size = ". sizeof($_POST)."</h3><pre>"; print_r($_POST); echo "</pre>";
		$this->load->model('lab_model');
		if (sizeof($_POST)==1)  {
			//echo "<h3>". __METHOD__ ." : _POST : size = ". sizeof($_POST)." 1st cond.</h3><pre>"; print_r($_POST); echo "</pre>";
			$exercise_id	= $_POST['exercise_id'] ;
			$user_id = $_SESSION['id'];
			$lab = $this->lab_model-> get_lab_exercise_by_id($exercise_id);
			//echo "<h3>". __METHOD__ .' : $lab : </h3><pre>'; print_r($lab); echo "</pre>";

			//return;
			if ( !($user_id == $lab['created_by'] || $_SESSION['username'] == 'kanut')) {
				$this->show_message("You are not allow to edit this exercise.");
				return;
			}


			// get lab content from database
			// updating $_SESSION
			$this->load->model('lab_model');
			$this->lab_model->get_lab_content($exercise_id);
			//echo '<h3> Updating $_SESSION[lab_2b_edit] : _SESSION :</h3><pre>'; print_r($_SESSION); echo "</pre>";
			$lab_chapter	= $this->lab_model->get_lab_chapter($exercise_id);
			$lab_level		= $this->lab_model->get_lab_level($exercise_id);
			$lab_name		= $this->lab_model->get_lab_name($exercise_id);
			$lab_content	= $this->lab_model->get_lab_content($exercise_id);
			$full_mark		= $this->lab_model->get_lab_full_mark($exercise_id);
			// check whether there are any testcase
			$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
			//$testcase		= $_SESSION['lab_2b_edit']['testcase'];
			//$sourcecode		= $_SESSION['lab_2b_edit']['sourcecode'];
			//$full_mark		= $_SESSION['lab_2b_edit']['full_mark'];
			//$added_date		= $_SESSION['lab_2b_edit']['added_date'];
			//$added_by		= $_SESSION['lab_2b_edit']['added_by'];
			//$lab_constrain	= $_SESSION['lab_2b_edit']['lab_constrain'];
			
			// sourcecode name is not available, then assign name
			$sourcecode_filename = $this->lab_model->get_sourcecode_filename($exercise_id);
			if (strlen($sourcecode_filename) < 3) {
				$sourcecode_filename = ''.$exercise_id;
				while (strlen($sourcecode_filename) < 5)
					$sourcecode_filename = '0'.$sourcecode_filename;
				$sourcecode_filename = 'exercise_'.$sourcecode_filename.'.py';
			

				//update database
				// $sourcecode_filename only
				$this->load->model('lab_model');
				$this->lab_model->update_sourcecode($exercise_id,$sourcecode_filename);
			}
			 					
			//get sourcecode_content file from harddisk
			if (file_exists(SUPERVISOR_CFILES_FOLDER.$sourcecode_filename)) {
				$sourcecode_content = file_get_contents (SUPERVISOR_CFILES_FOLDER.$sourcecode_filename);
				//$_SESSION['sourcecode_content'] =  $sourcecode_content;
					/*			
				//	mode is to choose where to keep .exe file  --> 'student' or 'supervisor'
				//	generate $sourcecode_output
				require_once 'exercise_test.php';
				$exercise_test = new exercise_test();
				$mode = $_SESSION['role'];
				if ($num_of_testcase <= 0 ) {

					$sourcecode_output = $exercise_test->get_result_noinput($sourcecode_filename,$mode);
					$sourcecode_output = $exercise_test->unify_whitespace($sourcecode_output);
					$sourcecode_output = $exercise_test->insert_newline($sourcecode_output);
					$_SESSION['sourcecode_output']  = $sourcecode_output;
				}
				*/
			} else {
				$sourcecode_content = "#include<stdio.h>".NEWLINE.'int main() {'.NEWLINE.TAB.'return 0;'.NEWLINE.'}'; 
			}

			
		} else {
		//if (sizeof($_POST) > 1) {
			//echo "<h3>". __METHOD__ ." : _POST : size = ". sizeof($_POST)." 2nd cond.</h3><pre>"; print_r($_POST); echo "</pre>";
			$exercise_id = $_POST['exercise_id'];
			$lab_chapter	= $_POST['lab_chapter'];
			$lab_level		= $_POST['lab_level']; 
			$lab_name		= $_POST['lab_name'];
			$lab_content	= $_POST['lab_content'];
			$testcase		= $_POST['testcase'];
			$sourcecode		= $_SESSION['lab_2b_edit']['sourcecode'];
			//$full_mark		= $_POST['full_mark'];
			//$added_date		= $_POST['added_date'];
			//$added_by		= $_POST['added_by'];
			$lab_constrain	= $_POST['lab_constrain'];
			$sourcecode_content = $_POST['sourcecode_content'];

			$data = array( 
						'lab_chapter' => $lab_chapter,
						'lab_level'		=> "$lab_level",
						'lab_name'		=> $lab_name,
						'lab_content'	=> $lab_content,
						'testcase'		=> $testcase,
						//'sourcecode'	=> $sourcecode,
						'lab_constrain'	=> $lab_constrain
				);

			//update database
			$this->load->model('lab_model');
			$this->lab_model->update_lab_exercise($exercise_id,$data);
			$sourcecode_filename = $sourcecode;
			if (strlen($sourcecode_content) > 10 ) {
				//	write content to harddisk
				if (strlen($sourcecode_content) > 10) {
					file_put_contents(SUPERVISOR_CFILES_FOLDER.$sourcecode_filename,$sourcecode_content);
				}

				/*
				//	mode is to choose where to keep .exe file  --> 'student' or 'supervisor'
				//	generate $sourcecode_output
				require_once 'exercise_test.php';
				$exercise_test = new exercise_test();
				$mode = $_SESSION['role'];
				$sourcecode_output = $exercise_test->get_result_noinput($sourcecode_filename,$mode);
				$sourcecode_output = $exercise_test->unify_whitespace($sourcecode_output);
				$sourcecode_output = $exercise_test->insert_newline($sourcecode_output);
				$_SESSION['sourcecode_output']  = $sourcecode_output;
				$_SESSION['sourcecode_content']  = $sourcecode_content;
				*/
			}
			$this->lab_model->get_lab_content($exercise_id);
			 

		} 
		
			
		// check whether there are any testcase
		$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		$testcase_array = $this->lab_model->get_testcase_array($exercise_id);
		
		
		$data_testcase = array(
								'exercise_id'		=>	$exercise_id,
								'num_of_testcase'	=> $num_of_testcase,
								'testcase_array'	=> $testcase_array
								);

		//echo "<pre>"; print_r($_SESSION); echo "</pre>";
		
		$data =  array( 
						'exercise_id'			=>	$exercise_id,
						'lab_chapter'			=>	$lab_chapter,
						'lab_level'				=>	$lab_level,
						'lab_name'				=>	$lab_name,
						'lab_content'			=>	$lab_content,
						'sourcecode_filename'	=>	$sourcecode_filename,
						'sourcecode_content'	=>	$sourcecode_content,
						'full_mark'				=>	$full_mark	
						//'sourcecode_output'		=>  $sourcecode_output
							);
		//echo "<pre>"; print_r($data); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";

		
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/exercise_edit_v2',$data);
		if($num_of_testcase == 0) {
			require_once 'Exercise_test.php';
			$exercise_test = new exercise_test();
			$sourcecode_output = $exercise_test->get_result_noinput($sourcecode_filename,'supervisor');
			$sourcecode_output = $exercise_test->unify_whitespace($sourcecode_output);
			$sourcecode_output = $exercise_test->insert_newline($sourcecode_output);
			$data_output = array ('sourcecode_output' => $sourcecode_output);
		
			$this->load->view('supervisor/exercise_edit_output',$data_output);
		} else {
			$this->load->view('supervisor/exercise_edit_testcase',$data_testcase);
		}
		$this->load->view('supervisor/add_exercise_footer');
		
		
	} // function exercise_edit()

	// add output to all testcases stored in testcase_array
	public function add_output_testcases($excercise_id, $testcase_array) {
		//echo "number of testcase : ",sizeof($testcase_array),"<br>";
		foreach ($testcase_array as $key => $testcase) {
			$testcase = $this->add_output_testcase($excercise_id, $testcase); 
			$testcase_array[$key] = $testcase;
			print_r($testcase); echo "<br>";
		}
		return $testcase_array;
	}

	// add output to a testcase stored in $testcase
	public function add_output_testcase($testcase) {
		$testcase['testcase_output']="this is output ".$exercise_id."-".$testcase['testcase_id']."<br>";
		require_once 'exercise_test.php';
		$exercise_test = new exercise_test();
		
		$sourcecode_filename = $this->lab_model->get_sourcecode_filename($testcase['exercise_id']);
		$testcase['testcase_output'] = $exercise_test->get_exercise_output($sourcecode_filename,$testcase['testcase_content']);
		return $testcase;
	}


	public function exercise_testing() {
		/*
		echo "<h2>MY_CONTROLLER : ".MY_CONTROLLER."</h2>";
		echo '<h2>BASEPATH = '. BASEPATH .'</h2>';
		echo '<h2>FCPATH = '. FCPATH .'</h2>';
		echo '<h2>APPPATH = '. APPPATH .'</h2>';
		echo '<h2>__FILE__ = '. __FILE__ .'</h2>';
		echo '<h2>__DIR__ = '. __DIR__ .'</h2>';
		echo '<h2>__FUNCTION__ = '. __FUNCTION__ .'</h2>';
		echo '<h2>__CLASS__ = '. __CLASS__ .'</h2>';
		echo '<h2>__TRAIT__ = '. __TRAIT__ .'</h2>';
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		echo '<h2>__NAMESPACE__ = '. __NAMESPACE__ .'</h2>';
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		*/

		//get lab content from database
		$exercise_id = $_POST['exercise_id'];
		$this->load->model('lab_model');
		$this->lab_model->get_lab_content($exercise_id);
		echo '<h1>'.__METHOD__.'</h1> <h2>$_POST :</h2><pre>'; print_r($_POST); echo "</pre>";
		echo '<h2> $_SESSION : </h2><pre>'; print_r($_SESSION); echo "</pre>";
		/*
		$lab_id = $exercise['lab_id'];
		if ($lab_id == 4) //this is special case for chapter 1
		{
			echo "lab_id=4";
		} else if($exercise['testcase']=="no_input") {
			echo "NO INPUT exercise";
		} else {
			echo "other";
		}
		$data = array('exercise'=> $exercise);

		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/exercise_test',$data);
		$this->load->view('supervisor/add_exercise_footer');
		*/


	}//function exercise_test()

	public function exercise_remove() {
		echo "<h1> You have to be the creater of this exercise </h1>";
	}
	
	public function add_exercise_form() {
		//echo "This is add_exercise page";
		//$this->load->view('supervisor/head');
		//
		//
		//$this->load->view('supervisor/add_exercise');
		//$this->load->view('supervisor/footer');

		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/add_exercise');
		$this->load->view('supervisor/add_exercise_footer');
	}

	public function add_exercise_action() {
		//echo "This is add_exercise Action";
		//echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		//echo 'count($_POST [lab_content]) : '.count_chars($_POST['summernote-text'])."<br>";
		$this->load->model('lab_model');
		$this->lab_model->add_lab($_POST);

		$this->show_lab_exercise();
		//$this->load->view('supervisor/head');
		//$this->load->view('supervisor/nav_fixtop');
		//$this->load->view('supervisor/nav_sideleft');
		//$this->load->view('supervisor/add_exercise');
		//$this->load->view('supervisor/footer');
		//$this->load->view('test_summernote-02');
	}

	public function exercise_show()	{
		$this->update_last_seen();
		$this->load->model('lab_model');
		$query = $this->lab_model->show_lab_exercise();
		/*
		foreach ($query->result() as $row)
		{
			echo $row->lab_id .' : '.$row->lab_chapter. ' : '.$row->lab_level.' : '. $row->lab_content."<br>";
		}
		*/
		$lab_info = $this->lab_model->get_lab_info();
		$data = array(	'query'		=>	$query,
						'lab_info'	=>	$lab_info
			);

		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/exercise_show',$data);
		$this->load->view('supervisor/footer');
	}

	public function show_all_students()	{
		$this->show_constants();
		$this->load->model('student_model');
		$query = $this->student_model->get_all_active_students();
	}
	

	public function edit_profile_form() {
		$this->load->model('supervisor_model');
		$data = array(
					'supervisor_data'	=> $this->supervisor_model->get_supervisor_data()
					);

		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft',$data);
		$this->load->view('supervisor/edit_profile',$data);
		$this->load->view('supervisor/footer');
	}

	public function edit_profile_action() {
		$this->createLogFile(__METHOD__ );
		$current_password = md5($_POST['current_password']);
		$database_password =  $this->get_password();
		$new_password = $_POST['password_new'];
		$confirm_password = $_POST['password_confirm'];
		
		//check current password if not correct return to edit_profile_form
		if($current_password != $database_password)
		{
			//echo "<h4>Password incorrect !!!</h4>";
			$this->session->set_flashdata("error", "Password is incorrect !!!");
			$this->createLogFile(" Password is incorrect !!! => ".$_POST['current_password']);
			return $this->edit_profile_form();
		} 
		//else {
		//	echo "<h4>Password correct</h4>";
		//}

		//if (isset($new_password))
		//	echo "isset($new_password) : true";
		//else
		//	echo "isset($new_password) : false";

		//update name username
		$this->load->model('supervisor_model');

		$supervisor_tel = "";
		if(!empty($_POST['supervisor_tel'])) {
			$supervisor_tel = $_POST['supervisor_tel'];
		}
		$supervisor_dob = "";
		if(!empty($_POST['supervisor_dob'])) {
			$supervisor_dob = $_POST['supervisor_dob'];
		}
		$supervisor_email = "";
		if(!empty($_POST['supervisor_email'])) {
			$supervisor_email = $_POST['supervisor_email'];
		}
		$supervisor_record = array(
						'supervisor_gender'			=> $_POST['supervisor_gender'],
						'supervisor_firstname'		=> $_POST['supervisor_firstname'],
						'supervisor_lastname'		=> $_POST['supervisor_lastname'],
						'supervisor_nickname'		=> $_POST['supervisor_nickname'],
						'supervisor_dob'			=> $supervisor_dob,		
						'supervisor_email'			=> $supervisor_email,
						'supervisor_tel'			=> $supervisor_tel,
						'supervisor_department'		=> $_POST['supervisor_department']
					);
		

		$this->supervisor_model->update_supervisor_record($supervisor_record);
		
		//update $_SESSION		
		$_SESSION['supervisor_gender']		= $_POST['supervisor_gender'];
		$_SESSION['supervisor_firstname']	= $_POST['supervisor_firstname'];
		$_SESSION['supervisor_lastname']	= $_POST['supervisor_lastname'];
		$_SESSION['supervisor_nickname']	= $_POST['supervisor_nickname'];
		$_SESSION['supervisor_dob']			= $supervisor_dob;		
		$_SESSION['supervisor_email']		= $supervisor_email;
		$_SESSION['supervisor_tel']			= $supervisor_tel;
		$_SESSION['supervisor_department']	= $_POST['supervisor_department'];
		
		
		//update password
		if (strlen($new_password) >= 4 && $new_password==$confirm_password)		
		{
			
			//echo "<h2>Changing password to : ".$new_password."</h2>";
			$this->load->model('supervisor_model');
			$this->student_model->update_supervisor_password(md5($new_password));
			$this->session->set_flashdata("status", "Password has been changed.");
			$this->createLogFile(" Change password to : ".$new_password);
		} else {
			//echo "<h2>New password DONOT change : ".$new_password."</h2>";
		}
		/*
		if(!isset($_POST['stu_avatar'] )) {
			echo "impage is loaded : ".$_FILES['stu_avatar']['name']."<br>";
		}
		else {
			echo "image is loaded<br>";
		}
		*/				
					
		

		//upload impage
		if(!isset($_FILE['supervisor_avatar'])  ) {

			$imageupload =  $_FILES['supervisor_avatar']['tmp_name'] ;
			$imageupload_name = $_FILES['supervisor_avatar']['name'] ;
			$ext = strtolower(pathinfo($_FILES['supervisor_avatar']['name'],PATHINFO_EXTENSION));
			$upload_filename = pathinfo($_FILES['supervisor_avatar']['name'],PATHINFO_FILENAME);
			$saved_filename = "image_".$_SESSION['username'].'_'.uniqid().".".$ext;//ชื่อไฟล์
			
			//echo "Orignal filename : ".$imageupload_name."<br>";
			//echo "New filename : $saved_filename<br>";
			//echo "upload_filename : $upload_filename<br>";
			//echo  "upoad_folder : ".$upload_path."<br>";
			

			//create directory if not exist
			//if(!is_dir($upload_path)) {
			//	mkdir ($upload_path);
			//}

			//check file type
			if (!($ext =="jpg" || $ext =="jpeg" || $ext =="png" || $ext =="gif") ) {
				$this->session->set_flashdata("error", "file type is not supported : $ext");
				//echo "file type sinot supported : $ext";
				echo "<script>alert('File type must be jpg , jpeg , png or gif')</script>";
				return $this->edit_profile_form();
			}
				
			
			// Check file size
			if ($_FILES["supervisor_avatar"]["size"] > 500000) {
				$this->session->set_flashdata("error", "Image file is too large (>500k).");
				//echo "Sorry, your file is too large.";
				return $this->edit_profile_form();				
			}

			//echo $_SERVER['DOCUMENT_ROOT']."<br>";
			//echo __FILE__."<br>";
			//echo APPPATH.STUDENT_AVATAR_FOLDER."<br>";

			
			//save image file to harddisk
			move_uploaded_file ( $imageupload ,  SUPERVISOR_AVATAR_FOLDER.$saved_filename );
			
			//update user_student table field only filename
			$this->load->model('supervisor_model');
			$this->supervisor_model->update_image($saved_filename);

			//inform user
			$this->session->set_flashdata("status", "Image file is updated.");
			$_SESSION['supervisor_avatar']=$saved_filename;

			
		}

		//echo "End now<br>";
		

		$this->session->set_flashdata("status", "Successfully Update.");		
		$this->edit_profile_form();

	}

	//
	private function get_password() {
		
		$this->load->model('supervisor_model');		
		return $this->supervisor_model->get_password();
	
	}

	private function show_constants()	{
		echo "<h2>MY_CONTROLLER : ".MY_CONTROLLER."</h2>";
		echo '<h2>BASEPATH = '. BASEPATH .'</h2>';
		echo '<h2>FCPATH = '. FCPATH .'</h2>';
		echo '<h2>APPPATH = '. APPPATH .'</h2>';
		echo '<h2>__FILE__ = '. __FILE__ .'</h2>';
		echo '<h2>__DIR__ = '. __DIR__ .'</h2>';
		echo '<h2>__FUNCTION__ = '. __FUNCTION__ .'</h2>';
		echo '<h2>__CLASS__ = '. __CLASS__ .'</h2>';
		echo '<h2>__TRAIT__ = '. __TRAIT__ .'</h2>';
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		echo '<h2>__NAMESPACE__ = '. __NAMESPACE__ .'</h2>';
		echo '<h3>$_SESSION Super global variable </h3>';
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		echo "<br>";
		echo '<h3>$_SERVER Super global variable </h3>';
		echo "<pre>";
		print_r($_SERVER);
		echo "</pre>";
	}

	public function student_add($group_id) {
		/*
		echo '<h3>BASEPATH = '. BASEPATH .'</h3>';
		echo '<h3>FCPATH = '. FCPATH .'</h3>';
		echo '<h3>APPPATH = '. APPPATH .'</h3>';
		echo '<h3>__FILE__ = '. __FILE__ .'</h3>';
		echo '<h3>__DIR__ = '. __DIR__ .'</h3>';
		echo '<h3>__FUNCTION__ = '. __FUNCTION__ .'</h3>';
		echo '<h3>__CLASS__ = '. __CLASS__ .'</h3>';
		echo '<h3>__TRAIT__ = '. __TRAIT__ .'</h3>';
		echo '<h3>__METHOD__ = '. __METHOD__ .'</h3>';
		echo '<h3>__NAMESPACE__ = '. __NAMESPACE__ .'</h3>';
		echo 'group id : ',$group_id;
		*/

	
		$this->load->model('lab_model');
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
		$data = array('class_schedule' => $class_schedule);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/student_add',$data);
		$this->load->view('supervisor/footer');

	}//public function student_add()
	
	public function student_add_action() {
		//echo "<pre>"; print_r($_POST); echo "</pre>";
		$stu_data = $_POST['student_data'];
		$stu_group_id = $_POST['group_id'];
				
		$string = $stu_data;

		$tok = strtok($string, " \n\t");
		$count=0;
		$student_data = array();
		while ($tok !== false) {			
			$stu_no = $tok;
			$tok = strtok(" \n\t");
			$stu_id = $tok;
			$tok = strtok(" \n\t");
			$stu_name = $tok;
			$tok = strtok(" \n\t");
			$stu_surname = $tok;
			$tok = strtok(" \n\t");
			//echo $stu_no." ".$stu_id." ".$stu_name." ".$stu_surname."<br />";
			$row['stu_no']=$stu_no;
			$row['stu_id']=$stu_id;
			$row['stu_name']=$stu_name;
			$row['stu_surname']=$stu_surname;
			$student_data[$count]=$row;
			$count++;
		}
		$this->load->model('student_model');
		foreach($student_data as $row) {
			$stu_id = $row['stu_id'];
			$stu_name = $row['stu_name'];
			$stu_surname = $row['stu_surname'];
			echo $row['stu_no']." ".$row['stu_id']." ".$row['stu_name']." ".$row['stu_surname']."<br />";
			if ( strlen($row['stu_id']) == 8) {
				echo "add will be performed.<br />";
				$message = $this->student_model->check_or_add_student_to_user($stu_id);
				if ($message=='OK') {
					$this->createLogfile(__METHOD__." : $stu_id is added to user table. ==> ".$message);
					echo " ==> Added.<br />";
					$stu_gender = 'other';
					if(substr($stu_name,0,9) == 'นาย') {
						$stu_gender = 'male';
						$stu_firstname = substr($stu_name,9,strlen($stu_name));
						$stu_lastname = $stu_surname;
					} else if(substr($stu_name,0,18) == 'นางสาว') {
						$stu_gender = 'female';
						$stu_firstname = substr($stu_name,18,strlen($stu_name));
						$stu_lastname = $stu_surname;
					} else {
						$stu_gender = 'other';
						$stu_firstname = $stu_name;
						$stu_lastname = $stu_surname;
					}
					
					$student_data = array( 'stu_id'	=> $stu_id,
											'stu_firstname'	=> $stu_firstname,
											'stu_lastname'	=> $stu_lastname,
											'stu_group'		=> $stu_group_id,
											'stu_gender'	=> $stu_gender
						);
					$message = $this->student_model->check_or_add_student_to_user_student($student_data);
					if($message == 'OK') {
						$this->createLogfile(__METHOD__." : $stu_id added to user table. ==> ".$message);
					} else {
						echo " --> ".$message."<br />";
					}

				} else {
					echo " --> cannot add to user table<br />";
				}
				

			} else {
				echo "incorrect data ...<br />";
			}

		}
		echo "<br /> Total students : $count<br />";


		$this->student_show($stu_group_id);


	}

	public function student_add_inset_2_database() {
		echo '<h3>__METHOD__ = '. __METHOD__ .'</h3>';

	}

	private function set_default_for_group_permission($group_id) {
		$this->load->model('lab_model');
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
		$group_permission = $this->lab_model->get_group_permission($group_id);
		$lab_info = $this->lab_model->get_lab_info();
		$number_of_chapters = sizeof($lab_info);
		$this->lab_model->set_default_for_group_permission($group_id,$number_of_chapters,$class_schedule);
		
	}

	public function student_show($stu_group_id) {
		/*
		echo '<h2>BASEPATH = '. BASEPATH .'</h2>';
		echo '<h2>FCPATH = '. FCPATH .'</h2>';
		echo '<h2>APPPATH = '. APPPATH .'</h2>';
		echo '<h2>__FILE__ = '. __FILE__ .'</h2>';
		echo '<h2>__DIR__ = '. __DIR__ .'</h2>';
		echo '<h2>__FUNCTION__ = '. __FUNCTION__ .'</h2>';
		echo '<h2>__CLASS__ = '. __CLASS__ .'</h2>';
		echo '<h2>__TRAIT__ = '. __TRAIT__ .'</h2>';
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		echo '<h2>__NAMESPACE__ = '. __NAMESPACE__ .'</h2>';
		echo "_SESSION:<br /><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "_POST:<br /><pre>"; print_r($_POST); echo "</pre>";
		echo "stu_group : $stu_group_id";
		*/
		$this->set_default_for_group_permission($stu_group_id);

		$this->load->model('student_model');
		$this->load->model('lab_model');
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($stu_group_id);
		$students_data = $this->lab_model->get_students_by_group_id($stu_group_id); // array
		$assigned_group_item = $this->lab_model->assign_group_item($stu_group_id); // array

		//create placeholder for selected exercise for the group in group_assigned_exercise table
		$this->lab_model->create_selected_exercise_for_group($stu_group_id);

		
		// create placeholder to store marking for each chapter for each student
		$number_of_chapters = $this->lab_model->get_number_of_chapters();
		for($i=0; $i<sizeof($students_data); $i++) {
			for($chapter = 1; $chapter <= $number_of_chapters; $chapter++) {
				$students_data[$i][$chapter]=0;
			}
		}
		
		//for($i=0; $i<sizeof($students_data); $i++) {
		//	print_r($students_data[$i]);	echo "<br>";
		//}
		
		
		
		$marking_data = $this->lab_model->get_group_data($stu_group_id);
		// $marking_data has stu_id, chapter_id, item_id, exercise_id and marking
		// order by stu_id + chapter_id + item_id
		
		// add lab marking to $students_data		
		for ($i=0,$m=0; $m<sizeof($marking_data); $m++) {		
			//echo $marking_data[$m]['stu_id'],' ',$marking_data[$m]['chapter_id'],' ',$marking_data[$m]['item_id'],' ',$marking_data[$m]['max_marking'];	echo "<br>";
			for($i=0;$i<sizeof($students_data);$i++) {
				if($marking_data[$m]['stu_id'] == $students_data[$i]['stu_id'] ){
					$ch_id = $marking_data[$m]['chapter_id'];
					$students_data[$i][$ch_id] += $marking_data[$m]['max_marking'];
				} 	
			}
		}

		//display updated data
		
		//for($i=0; $i<sizeof($students_data); $i++) {
		//	echo $students_data[$i]['stu_id'],' ',$students_data[$i]['stu_gender'],' ',$students_data[$i]['stu_firstname'],' //',$students_data[$i]['stu_lastname'],' ';
		//	echo $students_data[$i]['stu_nickname'],' ',$students_data[$i]['stu_dob'],' ',$students_data[$i]['stu_avatar'],' //',$students_data[$i]['stu_email'],' ';
		//	echo $students_data[$i]['stu_tel'],' ',$students_data[$i]['stu_department'],' ',$students_data[$i]['stu_group'],' ';
		//	for($c=1;$c<=$number_of_chapters;$c++)
		//		echo $students_data[$i][$c].' ';
		//	echo "<br>";
		//}
		

		$lab_info = $this->lab_model->get_lab_info();
		$group_permission = $this->lab_model->get_group_permission($stu_group_id);
		
		$data = array(	'students_data'		=>	$students_data, 
						'class_schedule'	=>	$class_schedule, 
						'lab_info'			=>	$lab_info,
						'assigned_group_item'	=>	$assigned_group_item,
						'group_permission'	=> $group_permission
					);

		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/student_show',$data);
		$this->load->view('supervisor/footer');
		

	}

	public function browse_exercise() {
		/*
		echo '<h2>BASEPATH = '. BASEPATH .'</h2>';
		echo '<h2>FCPATH = '. FCPATH .'</h2>';
		echo '<h2>APPPATH = '. APPPATH .'</h2>';
		echo '<h2>__FILE__ = '. __FILE__ .'</h2>';
		echo '<h2>__DIR__ = '. __DIR__ .'</h2>';
		echo '<h2>__FUNCTION__ = '. __FUNCTION__ .'</h2>';
		echo '<h2>__CLASS__ = '. __CLASS__ .'</h2>';
		echo '<h2>__TRAIT__ = '. __TRAIT__ .'</h2>';
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		echo '<h2>__NAMESPACE__ = '. __NAMESPACE__ .'</h2>';
		echo "_SESSION:<br /><pre>"; print_r($_SESSION); echo "</pre>";
		echo "_POST:<br /><pre>"; print_r($_POST); echo "</pre>";
		*/
		$allow_access = $_POST['browse_exercise'];
		$chapter_id = $_POST['chapter_id'];
		$class_id = $_POST['group_id'];
		$this->load->model('lab_model');
		$this->lab_model->set_allow_access($class_id,$chapter_id,$allow_access);

		$this->student_show($class_id);

		
		

	}

	public function allow_access_class_chapter() {
		
		$allow_access = $_POST['allow_access'];
		$chapter_id = $_POST['chapter_id'];
		$class_id = $_POST['class_id'];
		$this->load->model('lab_model');
		$this->lab_model->set_allow_access($class_id,$chapter_id,$allow_access);

		$this->student_show($class_id);

	}

	public function allow_access_class_chapter_v2() {
		
		$allow_access = $_POST['allow_access'];
		$chapter_id = $_POST['chapter_id'];
		$class_id = $_POST['class_id'];
		$this->load->model('lab_model');
		$this->lab_model->set_allow_access($class_id,$chapter_id,$allow_access);
		
		$_POST['group_id'] = $class_id;
		$_POST['lab_no'] = $chapter_id;
		$this->select_exercise_for_group();

	}

	public function allow_class_login() {
		//print_r($_POST);
		$allow_login = $_POST['allow_login'];
		$lecture = $_POST['lecturer'];
		$group_id = $_POST['group_id'];
		$this->load->model('lab_model');
		$this->lab_model->set_allow_class_login($group_id,$allow_login);

		$this->student_show($group_id);

	}

	public function allow_upload_pic() {
		//print_r($_POST);
		$allow_upload_pic = $_POST['allow_upload_pic'];
		$lecture = $_POST['lecturer'];
		$group_id = $_POST['group_id'];
		$this->load->model('lab_model');
		$this->lab_model->set_allow_class_upload_pic($group_id,$allow_upload_pic);

		$this->student_show($group_id);

	}

	public function allow_submit_class_chapter() {
		
		$allow_submit = $_POST['allow_submit'];
		$chapter_id = $_POST['chapter_id'];
		$class_id = $_POST['class_id'];
		$this->load->model('lab_model');
		$this->lab_model->set_allow_submit_class_chapter($class_id,$chapter_id,$allow_submit);

		$this->student_show($class_id);
	}

	public function allow_submit_class_chapter_v2() {
		
		$allow_submit = $_POST['allow_submit'];
		$chapter_id = $_POST['chapter_id'];
		$class_id = $_POST['class_id'];
		$this->load->model('lab_model');
		$this->lab_model->set_allow_submit_class_chapter($class_id,$chapter_id,$allow_submit);
		$_POST['group_id'] = $class_id;
		$_POST['lab_no'] = $chapter_id;
		$this->select_exercise_for_group();
	}


	public function student_password_reset() {
		$stu_id = $_POST['stu_id'];
		$stu_group = $_POST['stu_group'];
		echo 'stu_group : '.$stu_group.' stu_id :'.$stu_id;
		$this->load->model('student_model');
		$this->student_model->student_reset_password($stu_id);
		$this->createLogfile(__METHOD__ ." stu_id : $stu_id");

		$this->student_show($stu_group);
		
	}

	public function group_management() {
		$this->update_last_seen();
		//echo "<h2>". __METHOD__ ." : _SESSION :</h2><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST : size = ". sizeof($_POST)."</h3><pre>"; print_r($_POST); echo "</pre>";
		$user_id = $_SESSION['id'];
		
		//echo "Supervisor id : ".$lecturer_id."<br>";
		$this->load->model('lab_model');
		$supervised_groups = $this->lab_model->get_supervise_group($user_id,2020,1); // return array of group_id
		echo "<!-- supervised_groups <pre>"; print_r($supervised_groups); echo "</pre> -->";
		$assisted_groups = $this->lab_model->get_staff_group($user_id);		// return array of group_id
		echo "<!-- assisted_groups <pre>"; print_r($assisted_groups); echo "</pre> -->";
		$groups = array_merge($supervised_groups,$assisted_groups);
		echo "<!-- groups <pre>"; print_r($groups); echo "</pre> -->";
		//arsort($groups);
		//echo "<!-- groups <pre>"; print_r($groups); echo "</pre> -->";

		$group_list = array();
		for($i=0; $i<sizeof($groups); $i++) {
			if (!empty($groups[$i]['class_id'])) {
				$group_id = $groups[$i]['class_id'];
			} else {
				$group_id = $groups[$i]['group_id'];
			}

			$group_list[$i] = $this->lab_model->get_class_schedule_by_group_id($group_id);
			$students_in_group = $this->lab_model->get_count_of_students($group_id);
			$group_list[$i]['students_in_group'] = $students_in_group;
			
		}
		//echo "<!-- group_list <pre>"; print_r($group_list); echo "</pre> -->";
		
		
		

		$data = array(
					'group_list'	=>	$group_list,
						
					);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/group_management',$data);
		$this->load->view('supervisor/footer');
		

	}

	public function exercise_test_input() {
		require_once 'exercise_test.php';
		$exercise_test = new exercise_test();
		$exercise_test->exercise_test_input('supervisor','exercise_00041.c','15');
	}

	public function set_group_status() {
		//echo "<h2>". __METHOD__ ." : _SESSION :</h2><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST : size = ". sizeof($_POST)."</h3><pre>"; print_r($_POST); echo "</pre>";
		$stu_group_id = $_POST['group_id'];
		$lab_no = $_POST['lab_no'];
		$status = $_POST['status'];
		$supervisor_id = $_SESSION['id'];
		$this->load->model('lab_model');

		switch($status) {
			case 'closed':
				// ยังไม่มีโจทย์ให้นักศึกษาทำ
				echo "Lab is not Available!";
				$this->select_group_exercises($stu_group_id,$lab_no);
				break;
			case 'open':
				// เปลี่ยนเป็น stop
				echo "set group : $stu_group_id  lab : $lab_no to stop!";
				$this->lab_model->set_group_status_stop($supervisor_id,$stu_group_id,$lab_no);
				$this->student_show($stu_group_id);
				break;
			case 'ready':
				// เปลี่ยนเป็น open
				echo "set group : $stu_group_id  lab : $lab_no to open!";
				$this->lab_model->set_group_status_open($supervisor_id,$stu_group_id,$lab_no);
				$this->student_show($stu_group_id);
				break;
			case 'stop':
				// เปลี่ยนเป็น open
				echo "set group : $stu_group_id  lab : $lab_no to open!";
				$this->lab_model->set_group_status_open($supervisor_id,$stu_group_id,$lab_no);
				$this->student_show($stu_group_id);
				break;
		} 
		/**/
	}

	public function select_group_exercises($group_id,$lab_no) {
		echo "Lab is not Available!";
		$this->load->model('lab_model');
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
		$level_1 = $this->lab_model->get_exercise_list_chapter_level($lab_no,1);
		$level_2 = $this->lab_model->get_exercise_list_chapter_level($lab_no,2);
		$level_3 = $this->lab_model->get_exercise_list_chapter_level($lab_no,3);
		$level_4 = $this->lab_model->get_exercise_list_chapter_level($lab_no,4);
		$level_5 = $this->lab_model->get_exercise_list_chapter_level($lab_no,5);
		$exercise_list = $this->lab_model->get_group_exercises($group_id, $lab_no); 

		$data = array(
					'class_schedule'	=> $class_schedule,
					'level_1'			=> $level_1,
					'level_2'			=> $level_2,
					'level_3'			=> $level_3,
					'level_4'			=> $level_4,
					'level_5'			=> $level_5,
					'exercise_list'		=> $exercise_list,
					'lab_no'			=>	$lab_no
					);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/select_group_exercises',$data);
		$this->load->view('supervisor/footer');
	}

	public function close_lab_group() {
		//print_r($_POST);
		$group_id = $_POST['group_id'];
		$this->load->model('lab_model');
		$this->lab_model->not_allow_submit_for_group($group_id);

		$this->group_management() ;
		

	}

	public function show_message($message) {

		$data = array("message" => $message);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/show_message',$data);
		$this->load->view('supervisor/footer');
	}
		

	public function select_exercise_for_group() {
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST :</h3><pre>"; print_r($_POST); echo "</pre>";
		$group_id = $_POST['group_id'];
		$chapter_id = $_POST['lab_no'];
		
		$this->load->model('lab_model');
		$group_exercise_chapter = $this->lab_model->get_group_exercise_chapter($group_id,$chapter_id);
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
		$students_data = $this->lab_model->get_students_by_group_id($group_id); // array
		$group_lab_list = array();
		foreach($group_exercise_chapter as $row) {
			$item = $row['item_id'];
			$exercises = unserialize($row['exercise_id_list']);
			for($i=1; $i<=sizeof($exercises); $i++) {
				$group_lab_list[$item][$i]=$exercises[$i-1];
			}
		}

		$lab_exercise = $this->lab_model->get_lab_exercise_by_chapter($chapter_id);
		//echo '<h4>$lab_exercise <pre>'; print_r($lab_exercise); echo "</pre>";

		$lab_list = array();
		for ($i=0,$count=1; $i<sizeof($lab_exercise); $i++,$count++) {
			$level = $lab_exercise[$i]['lab_level'];			;
			$lab_list[$level][$count] = $lab_exercise[$i];
			if (!empty($lab_exercise[$i+1]) && $level < $lab_exercise[$i+1]['lab_level'])
				$count = 0;
			
		}
		//echo '<h4>$lab_list <pre>'; print_r($lab_list); echo "</pre>";

		



		//echo '<h4>$group_exercise_chapter <pre>'; print_r($group_exercise_chapter); echo "</pre>";
		//echo '<h4>$lab_exercise <pre>'; print_r($lab_exercise); echo "</pre>";
		$chapter_permission = $this->lab_model->get_group_permission($group_id);
		$chapter_permission = $chapter_permission[$chapter_id];



		$data = array(	
					'group_exercise_chapter'	=>	$group_exercise_chapter,
					'group_id'					=>	$group_id,
					'lab_no'					=>	$chapter_id,
					'group_lab_list'			=>	$group_lab_list,
					'lab_list'					=>	$lab_list,
					'class_schedule'			=>	$class_schedule,
					'chapter_permission'		=>	$chapter_permission,
					'students_data'				=>	$students_data
					
				);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/select_exercise_for_group',$data);
		$this->load->view('supervisor/footer');
		/* */
		
	}

	public function exercise_view1() {
		$this->exercise_view($_POST['exercise_id']);
	}

	public function exercise_view($exercise_id) {
		//echo '<pre>';print_r($_POST);echo '</pre>';
		$this->load->model('lab_model');
		$lab_exercise = $this->lab_model->get_lab_exercise_by_id($exercise_id);
		$sourcecode_filename = $lab_exercise['sourcecode'];
		//get sourcecode_content file from harddisk
		if (file_exists(SUPERVISOR_CFILES_FOLDER.$sourcecode_filename)) {
			$sourcecode_content = file_get_contents (SUPERVISOR_CFILES_FOLDER.$sourcecode_filename);
			$lab_exercise['sourcecode_content'] = $sourcecode_content;
		} else {
			$lab_exercise['sourcecode_content'] = "Cannot find the file . . .";
		}
		$lab_exercise['sourcecode_output'] = $this->get_sourcecode_output_no_testcase($exercise_id);
		$testcase_array = $this->lab_model->get_testcase_array($exercise_id);
		$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		

		$data = array( 'lab_exercise'	=>	$lab_exercise);

		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/exercise_view',$data);
		$this->load->view('supervisor/footer');

	}

	public function get_sourcecode_output_no_testcase($exercise_id) {
		$this->load->model('lab_model');
		$lab_exercise = $this->lab_model->get_lab_exercise_by_id($exercise_id);
		$sourcecode_filename = $lab_exercise['sourcecode'];
		$sourcecode_output = "Not Available";

		if ($lab_exercise['testcase'] == "no_input") {
			//ไม่มี testcase 
			require_once 'Exercise_test.php';
			$exercise_test = new exercise_test();
			$sourcecode_output = $exercise_test->get_result_noinput($sourcecode_filename,'supervisor');
			$sourcecode_output = $exercise_test->unify_whitespace($sourcecode_output);
			$sourcecode_output = $exercise_test->insert_newline($sourcecode_output);
		}
		return $sourcecode_output;
	}

	public function update_selected_exercise() {
		//echo '_POST : <pre>'; print_r($_POST); echo '</pre>';
		//	$_POST Array (    [user_id] => 900001    [group_id] => 17010010    [chapter] => 5;    [level] => 1    
		//	[selected_id_1] => 47   [selected_id_2] => 64)
		$group_id = $_POST['group_id'];		unset($_POST['group_id']);
		$user_id = $_POST['user_id'];		unset($_POST['user_id']);
		$chapter = $_POST['chapter'];		unset($_POST['chapter']);
		$level = $_POST['level'];			unset($_POST['level']);
		if(sizeof($_POST) <= 0 ) {
			$this->show_message("You must select at least ONE." );
			return;
		}

		//ตรวจสอบสิทธิ ในการแก้ไข
		$this->load->model('lab_model');
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
	
		//echo '<pre>'; print_r($class_schedule) ; echo '</pre>';
		$previledge = $this->check_previledge($group_id);
		if ($previledge == "none") {
			$this->show_message("You are not allow to select Exercises for student group : ".$class_schedule['group_no']);
		} else {
			//set selected exercise
			//echo "updating . . . \n";
			//echo '<pre>'; print_r($_POST); echo '</pre>';
			$list = $_POST;
			$this->lab_model->update_lab_class_item($group_id,$chapter,$level,$list);
		}
		$_POST['group_id'] = $group_id;
		$_POST['lab_no'] = $chapter;
		$this->select_exercise_for_group();

	}

	private function check_previledge($group_id) {
		$user_id = $_SESSION['id'];
		$this->load->model('lab_model');
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
			/* $class_schedule
		Array
		(
			[group_id] => 17010010
			[group_no] => 10
			[group_name] => อังคาร บ่าย
			[department] => 13
			[lecturer] => 900001
			[day_of_week] => Tuesday
			[time_start] => 13:00:00
			[time_end] => 15:00:00
			[year] => 2017
			[semester] => 1
			[allow_upload_pic] => no
			[allow_submit] => yes
			[allow_login] => yes
			[allow_exercise] => yes
			[supervisor_id] => 900001
			[supervisor_firstname] => คณัฐ
			[supervisor_lastname] => ตังติสานนท์
			[supervisor_nickname] => ยู้
			[supervisor_gender] => male
			[supervisor_dob] => 1967-09-03
			[supervisor_avatar] => 
			[supervisor_email] => kanut.ta@kmitl.ac.th
			[supervisor_tel] => 0866101013
			[supervisor_department] => วิศวกรรมคอมพิวเตอร์
			[dept_id] => 13
			[dept_name] => วิศวกรรมระบบควบคุม
			[lab_staff] => Array
				(
					[0] => Array
						(
							[class_id] => 17010010
							[staff_id] => 900003
							[supervisor_id] => 900003
							[supervisor_firstname] => เกียรติณรงค์
							[supervisor_lastname] => ทองประเสริฐ
							[supervisor_nickname] => อุ้ย
							[supervisor_gender] => male
							[supervisor_dob] => 
							[supervisor_avatar] => 
							[supervisor_email] => 
							[supervisor_tel] => 
							[supervisor_department] => 
						)

					[1] => Array
						(
							[class_id] => 17010010
							[staff_id] => 900009
							[supervisor_id] => 900009
							[supervisor_firstname] => kanut2
							[supervisor_lastname] => staff
							[supervisor_nickname] => 
							[supervisor_gender] => male
							[supervisor_dob] => 
							[supervisor_avatar] => image_kanut2_599abe2beaf62.jpg
							[supervisor_email] => 
							[supervisor_tel] => 
							[supervisor_department] => วิศวกรรมคอมพิวเตอร์
						)

				)
			*/
		//echo '<pre>'; print_r($class_schedule) ; echo '</pre>';
		//echo 'user_id : '.$user_id.'<br/>';
		$previledge = "none";
		if ($user_id == $class_schedule['lecturer']) {
			//this user is lecturer of the group
			$previledge = "lecturer";
		} else {
			foreach ( $class_schedule['lab_staff'] as $staff) {
				//echo '$staff<pre>'; print_r($staff) ; echo '</pre>';
				if($staff['staff_id'] == $user_id) {
					//this user is staff of this group
					$previledge = "staff";
				}
			}
		}
		//echo '$previledge : '.$previledge.'<br/>';
		return $previledge;
	}

	public function exercise_add_v2() {
		print_r($_POST);
	}

	

	

	

	private function reset_student_exercise($stu_id,$chapter,$item) {
		//check if this supervisor has previledge to reset student data

		$this->load->model('lab_model');
		$this->lab_model->reset_student_exercise($stu_id,$chapter,$item);
		echo "$stu_id , $chapter , $item DELETED.";
		$this->createLogFile(__METHOD__ ." [ $stu_id - $chapter - $item ]");
	}

	public function student_info() {
		if (isset( $_POST['stu_id'])) {
			$stu_id = $_POST['stu_id'];
		}else {
			$stu_id =  '60000001';
		}
		if (isset($_POST['stu_group'])) {
			$stu_group = $_POST['stu_group'];
		} else {
			$stu_group = '17010001';
		}
		/*
		if ($stu_id == '') {
			$this->show_message("Cannot find $stu_id . . . ");
			return;
		}*/
		$this->load->model('lab_model');
		$this->load->model('student_model');

		$lab_data = $this->lab_model->setup_student_lab_data($stu_id,$stu_group);
		$student_marking_all_items = $this->lab_model->get_a_student_marking_for_all_submitted_items($stu_id) ;
		//echo '<!--<h3>$student_marking_all_items = </h3> <pre>'; print_r($student_marking_all_items); echo "</pre><br>-->";
		foreach ($student_marking_all_items as $row) {
			$marking = 0;
			if(!empty($row['max_marking'])) {
				$marking = $row['max_marking'];
			}
			$chapter_id = $row['chapter_id'];
			$item_id = $row['item_id'];
			$lab_data[$chapter_id][$item_id]['stu_lab']['marking'] = $marking;
		}
		//echo '<!--<h3>$this->_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>-->";

		$data = array (	'lab_classinfo'		=>	$this->lab_model->get_lab_info(),
						'lab_data'			=>	$lab_data,
						'class_info'		=>	$this->student_model->get_class_info($stu_id),
						'group_permission'	=>	$this->lab_model->get_group_permission($stu_group),					
						'student_data'		=>	$this->student_model->retrieve_student_record($stu_id)
					);

		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/student_info',$data);
		//$this->load->view('student/stu_exercise',$data);
		$this->load->view('supervisor/footer');

	}

	public function student_exercise_view($stu_id,$chapter,$item) {		

		$this->load->model('lab_model');
		$exercise_id = $this->lab_model->get_student_exercise($stu_id, $chapter, $item);

		$lab_exercise = $this->lab_model->get_lab_exercise_by_id($exercise_id);
		//echo "<h1>".__METHOD__."</h1>";
		//echo "<h2>lab_exercise = <pre>";print_r($lab_exercise);echo "</pre></h2>"; 
		if ($lab_exercise['testcase']=='no_input')
			$number_of_testcase = 0;



		//$number_of_testcase = isset($lab_exercise['testcase']) ? sizeof($lab_exercise['testcase']) : -1 ;
		$stu_submit = $this->lab_model->get_student_submission($stu_id,$exercise_id);
		$submitted_count = sizeof($stu_submit);
		//echo "<h2>stu_submit = <pre>";print_r($stu_submit);echo "</pre></h2>";  
		$data_for_testcase = $this->get_data_for_testcase($stu_id,$exercise_id);
		//echo "<h2>data_for_testcase = <pre>";print_r($data_for_testcase);echo "</pre></h2>";  
		$this->load->model('student_model');
		$student_data = $this->student_model->retrieve_student_record($stu_id);
		//echo "<h2>student_data = <pre>";print_r($student_data);echo "</pre></h2>";  //exit();
		if ($lab_exercise['testcase']=='no_input') {
			$number_of_testcase = 0;
			$last_submit = $data_for_testcase;
			$last_submit['sourcecode_output']=$stu_submit[sizeof($stu_submit)-1]['output'];
			//echo "<h2>last_submit2 = <pre>";print_r($last_submit);echo "</pre></h2>";  //exit();

		}
		

		$data_ = array( 'lab_exercise'	=>	$lab_exercise,
						'student_data'	=>	$student_data,
						'stu_id'		=>	$stu_id,
						'chapter'		=>	$chapter,
						'item'			=>	$item,
						'exercise_id'	=>	$exercise_id,
						'stu_submit'	=>	$stu_submit
			);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/student_exercise_view',$data_);
		
		// copy from student controller
		
		$data_for_student_view = $this->get_data_for_student_view($stu_id,$chapter,$item);
		$this->load->view('student/exercise_submission_header',$data_for_student_view);
		
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
		
		
		
		$this->load->view('supervisor/footer');
		/* */


	}

	private function get_data_for_student_view($stu_id,$chapter,$item){
		$this->load->model('lab_model');
		$exercise_id = $this->lab_model->get_student_exercise($stu_id, $chapter, $item);
		$lab_exercise = $this->lab_model->get_lab_exercise_by_id($exercise_id);
		$stu_submit = $this->lab_model->get_student_submission($stu_id,$exercise_id);
		$submitted_count = sizeof($stu_submit);
		$stu_group = $this->lab_model->get_student_group($stu_id);
		$group_permission = $this->lab_model->get_group_permission($stu_group);
		$num_of_testcase = -1 ;
		if ($lab_exercise['testcase'] == 'no_input')
			$num_of_testcase = 0 ;
		elseif (is_array($lab_exercise['testcase']))
			$num_of_testcase = sizeof($lab_exercise['testcase']) ;
		$output = "Not Avialable";
		if ($lab_exercise['testcase']=='no_input') {
			
			require_once 'Exercise_test.php';
			$exercise_test = new Exercise_test();
			$sourcecode_filename = $this->lab_model->get_sourcecode_filename($exercise_id);
			$output = $exercise_test->get_result_noinput($sourcecode_filename,'supervisor'); // raw output 	
		}

		$data= array(	
					'stu_id'		=> $stu_id,
					"lab_content"	=> $lab_exercise['lab_content'],
					"output"		=> $output,
					'lab_chapter'	=> $lab_exercise['lab_chapter'],
					'lab_item'		=> $lab_exercise['lab_level'],
					'exercise_id'	=> $exercise_id,
					'lab_name'		=> $lab_exercise['lab_name'],
					'full_mark'		=> $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter,$item,$exercise_id),
					'marking'		=> $this->lab_model->get_max_marking_from_exercise_submission($stu_id,$exercise_id),
					'submitted_count'	=> $submitted_count,
					//'sourcecode_content' => $sourcecode_content,

					'group_permission'	=> $group_permission
				);
		return $data;
	}

	private function get_data_for_testcase($stu_id,$exercise_id) {
		$this->load->model('lab_model');
		$lab_exercise = $this->lab_model->get_lab_exercise_by_id($exercise_id);
		$num_of_testcase = -1 ;
		if ($lab_exercise['testcase'] == 'no_input')
			$num_of_testcase = 0 ;
		elseif (is_array($lab_exercise['testcase']))
			$num_of_testcase = sizeof($lab_exercise['testcase']) ;

		$stu_submit = $this->lab_model->get_student_submission($stu_id,$exercise_id);
		$submitted_count = sizeof($stu_submit);
		$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
		$status ="not_pass";
		if($submitted_count>0) {
		
			//there is last submit so run it and do marking
			// from exercise_submission table
			$last_submit = $stu_submit[$submitted_count-1];
			$submission_id = $last_submit['submission_id'];
			$marking = $last_submit['marking'];
		
			$sourcecode_filename = $last_submit['sourcecode_filename'];
			if(file_exists(STUDENT_CFILES_FOLDER.$sourcecode_filename)) {
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);
			} else {
				$sourcecode_content = 'File unavialable!!!';
			}

			require_once 'Exercise_test.php';
			$exercise_test = new Exercise_test();
			//run each testcase and compare result
			
			// $chapter_pass = 'yes';
			// each time testcase passes, $chapter_pass will be decreased.
			// if all testcases pass, $chater_pass will be zero
			$chapter_pass = sizeof($data_testcase);
			$testcase_pass = 0;
			for ($i=0; $i<sizeof($data_testcase); $i++) {
				$data_testcase["$i"]['item_pass'] = 'yes';
				$testcase_content = $data_testcase["$i"]['testcase_content'];
				//run output and store in $data_testcase
				$output_student_original = $exercise_test->get_result_student_testcase($sourcecode_filename, $testcase_content );
				$output_student = $exercise_test->unify_whitespace($output_student_original);
				$data_testcase["$i"]['testcase_student'] = $output_student;

				$output_sample = $data_testcase["$i"]['testcase_output'];
				$output_sample = $exercise_test->unify_whitespace($output_sample);

				//compare to exercise sample
				$output_result = $exercise_test->output_compare($output_student,$output_sample);

				//calculate marking of testcase and put into $data_testcase
				$item_pass='yes';
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
					$output_student = $exercise_test->dispaly_error_in_output($output_student,$error_position);
					$item_pass='no';
					$data_testcase["$i"]['error_line'] = $error_line;
					$data_testcase["$i"]['error_column'] = $error_column;
					$data_testcase["$i"]['error_position'] = $error_position;


					
				}
				$data_testcase["$i"]['output_to_show']=$output_student_original;
				$data_testcase["$i"]['item_pass']=$item_pass;
			}
			$status ="not_pass";
			if($testcase_pass==sizeof($data_testcase)) {
				//$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
				//$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking); 
				$status = "passed";
			}
		}
		$testcase_array = $data_testcase;
		$data_for_testcase['exercise_id'] = $exercise_id;
		$data_for_testcase['num_of_testcase'] = $num_of_testcase;
		$data_for_testcase['testcase_array'] = $testcase_array;
		if(isset($last_submit))
			$data_for_testcase['last_submit'] = $last_submit;
		$data_for_testcase['status'] = $status;
		if($submitted_count>0)
			$data_for_testcase['sourcecode_content'] = $sourcecode_content;
		else
			$data_for_testcase['sourcecode_content'] = 'Not Available';


		return $data_for_testcase;
	}

	private function student_activity($log_date) {
		$log_folder = APPPATH.'logs'.DIRECTORY_SEPARATOR;
		//$log_date = date('Y-m-d');	
		$filename = 'student_'. $log_date.'.log';
		$message = "Unavailable...";
		if(file_exists(APPPATH.'logs'.DIRECTORY_SEPARATOR.$filename)) {
			$message = file_get_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.$filename);			
			// Order of replacement
			$str     = $message;		// "Line 1\nLine 2\rLine 3\r\nLine 4\n";
			$order   = array("\r\n", "\n", "\r");
			$replace = '<br />';

			// Processes \r\n's first so they aren't converted twice.
			$message = str_replace($order, $replace, $str);
		}
		$data = array('message'	=> $message, 'log_date' => $log_date);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/student_activity',$data);
		$this->load->view('supervisor/footer');
	}

	public function student_activity_show($para) {
		//echo $para;
		$this->student_activity($para);

	}
	public function student_activity_previous($para) {
		echo $para;

	}
	public function student_activity_next($para) {
		echo $para;

	}

	public function remove_last_submission() {
		//if($_SESSION['username'] != "kanut") {
		//	$this->show_message("Under Construction . . .");
		//	return;
		//}
		//echo '<pre>';print_r($_POST);echo '</pre>';
		$this->createLogfile(__METHOD__.serialize($_POST));
		$chapter = $_POST['chapter'];
		$stu_id = $_POST['stu_id'];
		$item = $_POST['item'];
		$exercise_id = $_POST['exercise_id'];
		$submission_id = $_POST['submission_id'];
		$first_line = 'print("This file has been commented. !!!\ninput : "';

		// verify access control student must belong to a group supervised by this supervisor

		//remove a record from table exercise_submission
		//reset marking in table student_assigned_chapter_item
		$this->load->model('lab_model');
		$this->lab_model->reset_student_marking($submission_id);
		$stu_filename = $this->lab_model->get_stu_src_filename($submission_id);
		//echo "<h2>student=$stu_id - $chapter - $item - $exercise_id - $submission_id - $stu_filename</h2>";
		$stu_filename = STUDENT_CFILES_FOLDER.$stu_filename;
		if(file_exists($stu_filename)) {
			//echo "<h1>$stu_filename has been FOUND!!!</h1>";
			$content = file_get_contents($stu_filename);
			//echo "<h3>".nl2br($content)."</h3";
			$content = $this->comment_all_line_python_format($content);
			file_put_contents($stu_filename,$content);


		} else {
			echo "<h1>$stu_filename NOT FOUND!!!</h1>";
			exit();
		}
		$this->student_exercise_view($stu_id,$chapter,$item);

		
	}

	

	public function test_ldap() {
		$url = "https://myauthapi.kmitl.ac.th/authenLDAP.php";
		$post_data = array(
						"login_"		=> 'ka*',
						"key_"			=>	'',
						"action_"		=>	"search",
						"operatorLog_"	=>	"myfirstacc.se",
						"operatorKey_"	=>	"yGTHJYpm",
						"ldapMode_"		=>	"MSAD"
					);
		
		$ch = curl_init();
		// URL to send the requerst to
		curl_setopt($ch, CURLOPT_URL, $url);

		// Return instead of outputting directly
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//whether to include the header in the outpu. Set to false here
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

		$output = curl_exec($ch);

		if ($output === FALSE) {
			echo "cURL Error: ".curl_error($ch);
		}

		curl_close($ch);

		print_r($output);
		/*
		<html>
    <header> <title> MyTestLDAP </title> </header>
    
    <body>
        
       <table border="1">
           <tr>
               <td>column 1:</td>
               <td>column 2:</td>
           </tr>
           
            <form method="post" action="https://myauthapi.kmitl.ac.th/authenLDAP.php"> <!-----action="authenLDAP.php, adauthen.php"----->
	       <!-- <form method="post" action="https://161.246.52.34/authenLDAP.php"> -->
               <tr>
                   <td>Name:</td>
                   <td><input name="login_" type="text"  value="" placeholder="Username> "></td>
               </tr>

               <tr>
                   <td>Password:</td>
                   <td><input name="key_" type="password" value="" placeholder="Password "></td>
               </tr>
               
               <tr>
                   <td>Action:
			<select name="action_" id="action_" style="height:0.8cm;">
                        	<option value="authen">Authen</option>
                                <option value="search">Search</option>
                              	<option value="count">Count</option>
			</select>
		   </td>
                   <td><input name="clear" type="reset"  value="Clear"><input name="commit" type="submit"  value="OK"></td>
               </tr>
	       <input name="operatorLog_" type="hidden" value="myfirstacc.se">
	       <input name="operatorKey_" type="hidden" value="yGTHJYpm">
	       <input name="ldapMode_"    type="hidden" value="MSAD">
           </form>
          
           
       </table>
        
    </body>
</html>*/

	}

	


	public function process_show() {
		require_once 'Process_protection.php';
		$process = new process_protection();
		$process = $process->get_python3_process_in_system();
		
		//$process = $this->process_get();
		

		$data = array("process" => $process);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/show_process',$data);
		$this->load->view('supervisor/footer');
		

	}

	
	public function process_kill() {
		/*
		if($_SESSION['username'] != 'kanut') {
			$this->show_message('Access dinied . . .');
			return;
		}
		*/
		//print_r($_POST);
		
		if(isset($_POST['pid'])) {
			$pid = $_POST['pid'];
		} else {
				$this->process_show();
				return;
		}
		$command = '';
		$process = $this->process_get();

		//find command			
		foreach ($process as $p) {
			if($p['pid']==$pid) {
				$command = $p['command'];
				//เปลี่ยนชื่อ  sourcefile
				$filename = $this->process_get_filename($command);
				$sourcefile = STUDENT_CFILES_FOLDER.$filename.'.c';

				// instead of rename the file to .bak,
				// make content to commment.
				$newname = $sourcefile.'.bak';
				echo "Rename $sourcefile ==> $newname <br/>";
				if ( file_exists($sourcefile) ) {

					/*
					$newname = $sourcefile.".bak";
					//exec("chmod 777 $filename  ");
					//exec("mv $filename $newname ");
					rename($sourcefile, $newname);
					if ( file_exists($newname) ) {
						echo "Done... rename sourcefile<br/>";
					} else if ( file_exists($sourcefile) ){
						echo "NOT done... cannot rename $sourcefile ==> $newname <br/>";
					} else {
						echo "Something went wrong <br/>";
					}
					*/
					$file_content = file_get_contents($sourcefile);
					$file_content_new = "// *** Please check the contents *** \\n";

					foreach(preg_split("/((\r?\n)|(\r\n?))/", $file_content) as $line){
						$file_content_new .= "// ".$line."\r\n";  // make every line to comment						
					} 
					file_put_contents($sourcefile, $file_content_new);



				}
		

				//kill process
				shell_exec("kill -9 $pid ");

				//ลบ exe file
				$exe_file = STUDENT_EXE_FOLDER.$filename.".exe";
				echo "Deleting . . . $exe_file <br/>";
				if ( file_exists($exe_file) ) {
					exec("rm $exe_file ");
					echo "Deleting . . . $exe_file ==> Done. <br/>";
				} else {
					echo "Deleting . . . $exe_file dose NOT exist.  <br/>";

				}

				break;
			}
		}

		

		//kill all peocesses that have the same command
		foreach ($process as $p) {
			if($p['command']==$command) {
				$pid = $p['pid'];
				shell_exec("kill -9 $pid ");
			}
		}
		sleep(1);
		//$this->process_show();

	}

	public function process_get_filename($command) {
		//$command = "student_data/exe_files/60010216_05_01_0002.exe";
		//echo "command : ".$command.'<br/>';
		$f = explode('.',$command);
		$ff = explode('/',$f[0]);
		//print_r( $ff);
		$filename = $ff[2];
		//echo '<br/>'.$filename;
		return $filename;
	}

	

	public function demo_sse() {

		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');

		$time = date('r');
		echo "data: The server time is: {$time}\n\n";
		flush();


	}

	public function proc_open_test() {
		$time_limit = 5;	//second
		// descriptor array
		$desc = array(
			0 => array('pipe', 'r'), // 0 is STDIN for process
			1 => array('pipe', 'w'), // 1 is STDOUT for process
			2 => array('file', '/tmp/error-output.txt', 'a') // 2 is STDERR for process
		);

		// command to invoke markup engine
		$cmd = "/tmp/input1.exe ";
		$cmd = "ping www.ce.kmitl.ac.th ";

		// spawn the process
		$process = proc_open($cmd, $desc, $pipes);
		$time_start = time();
		$proc_status = proc_get_status($process);
		echo 'proc_status : <pre>';print_r($proc_status); echo '</pre><br/>';
		if (!is_resource($process)) {
			$this->show_message("Cannot start $cmd\n");
			return ;
		}
		$time_now = time();
		$count = 1;
		while ( ($time_now - $time_start) <= $time_limit) {
			echo $count." : time_now - time_start = ";
			echo $time_now." - ".$time_start." = ";
			echo ($time_now - $time_start)."<br/>";
			
			
			$arg = $count.'\n';
			fwrite($pipes[0], $arg);
			$return_message = fgets($pipes[1], 1024);
			echo $return_message.'<br />';
			while( ! feof($pipes[1]))
			{
				$return_message = fgets($pipes[1], 1024);
				if (strlen($return_message) == 0) break;

				echo time()." : ".$return_message.'<br />';
				ob_flush();
				flush();
			}
			
			if (strlen($return_message) == 0) break;
			sleep(1);
			$count++;
			$time_now = time();
			
		}
		print_r($pipes);echo "<br/>";
		if (is_resource($pipes[0])) {
				ob_flush();
				flush();
				fclose($pipes[0]);
				echo "Close pipes0 <br/>";
		}
		if (is_resource($pipes[1])) {
			ob_flush();
			flush();
			fclose($pipes[1]);
			echo "Close pipes1 <br/>";
		}	
		/*
		if (is_resource($pipes[2])) {
			ob_flush();
			flush();
			fclose($pipes[2]);
			echo "Close pipes2 <br/>";
		}	
		*/
		if (is_resource($process)) {
			proc_terminate($process);
			echo "Close process <br/>";
			
		}

		//donot use proc_terminate
		/*

		$status = proc_get_status($process);
		if($status['running'] == true) { //process ran too long, kill it
			//close all pipes that are still open
			fclose($pipes[1]); //stdout
			fclose($pipes[2]); //stderr
			//get the parent pid of the process we want to kill
			$ppid = $status['pid'];
			//use ps to get all the children of this process, and kill them
			$pids = preg_split('/\s+/', `ps -o pid --no-heading --ppid $ppid`);
			foreach($pids as $pid) {
				if(is_numeric($pid)) {
					echo "Killing $pid\n";
					posix_kill($pid, 9); //9 is the SIGKILL signal
				}
			}
				
			proc_close($process);
		}
		
		*/
	}

	public function rename_file() {
		$sourcefile = "60010715_05_01_0006.c.bak"; 
		$sourcefile = STUDENT_CFILES_FOLDER.$sourcefile;
		$newname = $sourcefile.'.bak';
		exec("mv $sourcefile $newname");
	}

	/*
	https://stackoverflow.com/questions/16351302/reading-from-stdin-pipe-when-using-proc-open
	*/
	public function test_process() {
		//starting subprocess
		$cmd = 'stdbuf -o0 ./a.out 2>&1';

		// what pipes should be used for STDIN, STDOUT and STDERR of the child
		$descriptorspec = array (
			0 => array("pipe", "r"),
			1 => array("pipe", "w"),
			2 => array("pipe", "w")
		 );

		// open the child
		$proc = proc_open (
			$cmd, $descriptorspec, $pipes, getcwd()
		);

		// set all streams to non blockin mode
		stream_set_blocking($pipes[1], 0);
		stream_set_blocking($pipes[2], 0);
		stream_set_blocking(STDIN, 0);

		// check if opening has succeed
		if($proc === FALSE){
			throw new Exception('Cannot execute child process');
		}

		// get PID via get_status call
		$status = proc_get_status($proc);
		if($status === FALSE) {
			throw new Exception (sprintf(
				'Failed to obtain status information '
			));
		}
		$pid = $status['pid'];

		// now, poll for childs termination
		while(true) {
			// detect if the child has terminated - the php way
			$status = proc_get_status($proc);
			// check retval
			if($status === FALSE) {
				throw new Exception ("Failed to obtain status information for $pid");
			}
			if($status['running'] === FALSE) {
				$exitcode = $status['exitcode'];
				$pid = -1;
				echo "child exited with code: $exitcode\n";
				exit($exitcode);
			}

			// read from childs stdout and stderr
			// avoid *forever* blocking through using a time out (50000usec)
			foreach(array(1, 2) as $desc) {
				// check stdout for data
				$read = array($pipes[$desc]);
				$write = NULL;
				$except = NULL;
				$tv = 0;
				$utv = 50000;

				$n = stream_select($read, $write, $except, $tv, $utv);
				if($n > 0) {
					do {
						$data = fread($pipes[$desc], 8092);
						fwrite(STDOUT, $data);
					} while (strlen($data) > 0);
				}
			}


			$read = array(STDIN);
			$n = stream_select($read, $write, $except, $tv, $utv);
			if($n > 0) {
				$input = fread(STDIN, 8092);
				// inpput to program
				fwrite($pipes[0], $input);
			}
		}
	}

	public function process_get() {
		//$sourcecode_filename ="99010001_03_02_0001.py";
		require_once 'Process_protection.php';
		$proc_pro = new process_protection();
		$process = $proc_pro->process_get_python3($sourcecode_filename,"supervisor");
		

	}

}//class Supervisor
?>