<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));
require_once(APPPATH . "/controllers/MY_RestController.php");

class Supervisor_rest extends MY_RestController
{
	protected $access = "supervisor";

	public function __construct()
	{
		parent::__construct();
		header('Content-Type: application/json; charset=utf-8');
		$this->protected();

		if ($this->session->userdata('role') != 'supervisor') {
			$this->response([
				'status' => FALSE,
				'message' => 'You are not allowed to access this page',
			], RestController::HTTP_FORBIDDEN);
		}

		$this->load->model('lab_model_rest');
		$this->load->model('supervisor_model_rest');
		$this->load->model('student_model_rest');
	}

	public function getAllAvailableGroups_get()
	{
		$this->logout_after_time_limit();
		$this->update_last_seen();
		$year = $this->query('year');

		$class_schedule = $this->supervisor_model_rest->get_class_schedule($year);
		for ($i = 0; $i < sizeof($class_schedule); $i++) {
			$group_id = $class_schedule[$i]['group_id'];
			$lecturer_id = $class_schedule[$i]['lecturer'];
			$students_in_group = $this->lab_model_rest->get_count_of_students($group_id);
			$lecturer = $this->supervisor_model_rest->get_supervisor_fullname_by_id($lecturer_id);
			$class_schedule[$i]['num_students'] = $students_in_group;
			$class_schedule[$i]['lecturer_name'] = $lecturer;
		}
		$data = $class_schedule;

		return $this->response([
			'status' => TRUE,
			'message' => 'successfully fetch available groups',
			'payload' => $data,
		], RestController::HTTP_OK);
	}

	public function getGroupListById_get()
	{
		$this->logout_after_time_limit();
		$this->update_last_seen();

		$user_id = $_SESSION['id'];
		$year = $this->query('year');

		$supervised_groups_sem1 = $this->lab_model_rest->get_supervise_group($user_id, $year, 1);
		$supervised_groups_sem2 = $this->lab_model_rest->get_supervise_group($user_id, $year, 2);
		$assisted_groups = $this->lab_model_rest->get_staff_group($user_id);
		$groups = array_merge($supervised_groups_sem1, $supervised_groups_sem2, $assisted_groups);

		$group_list = array();
		for ($i = 0; $i < sizeof($groups); $i++) {
			if (!empty($groups[$i]['class_id'])) {
				$group_id = $groups[$i]['class_id'];
			} else {
				$group_id = $groups[$i]['group_id'];
			}

			$group_list[$i] = $this->lab_model_rest->get_class_schedule_by_group_id($group_id);
			$students_in_group = $this->lab_model_rest->get_count_of_students($group_id);
			$group_list[$i]['students_in_group'] = $students_in_group;
		}

		$data = array(
			'group_list'	=>	$group_list,
		);

		$this->response([
			'status' => TRUE,
			'message' => 'successfully fetch supervisor group list',
			'payload' => $data,
		], RestController::HTTP_OK);
	}

	private function set_default_for_group_permission($group_id)
	{
		$class_schedule = $this->lab_model_rest->get_class_schedule_by_group_id($group_id);
		$group_permission = $this->lab_model_rest->get_group_permission($group_id);
		$lab_info = $this->lab_model_rest->get_lab_info();
		$number_of_chapters = sizeof($lab_info);
		$this->lab_model_rest->set_default_for_group_permission($group_id, $number_of_chapters, $class_schedule);
	}

	public function getGroupDataById_get()
	{
		$this->logout_after_time_limit();
		$this->update_last_seen();

		$group_id = $this->query('group_id');

		$this->set_default_for_group_permission($group_id);

		$class_schedule = $this->lab_model_rest->get_class_schedule_by_group_id($group_id);
		$students_data = $this->lab_model_rest->get_students_by_group_id($group_id); // array
		// $assigned_group_item = $this->lab_model_rest->assign_group_item($group_id); // array
		$midterm_scores = $this->lab_model_rest->get_midterm_score($group_id);
		$_SESSION['mid_score'] = $midterm_scores;

		//create placeholder for selected exercise for the group in group_assigned_exercise table
		$this->lab_model_rest->create_selected_exercise_for_group($group_id);


		// create placeholder to store marking for each chapter for each student
		// $number_of_chapters = $this->lab_model_rest->get_number_of_chapters();
		// for ($i = 0; $i < sizeof($students_data); $i++) {
		// 	for ($chapter = 1; $chapter <= $number_of_chapters; $chapter++) {
		// 		$students_data[$i][$chapter] = 0;
		// 	}
		// }

		$marking_data = $this->lab_model_rest->get_group_data($group_id);

		// add lab marking to $students_data		
		// for ($i = 0, $m = 0; $m < sizeof($marking_data); $m++) {
		// 	for ($i = 0; $i < sizeof($students_data); $i++) {
		// 		if ($marking_data[$m]['stu_id'] == $students_data[$i]['stu_id']) {
		// 			$ch_id = $marking_data[$m]['chapter_id'];
		// 			$students_data[$i][$ch_id] += $marking_data[$m]['max_marking'];
		// 		}
		// 	}
		// }

		// $lab_info = $this->lab_model_rest->get_lab_info();
		$group_permission = $this->lab_model_rest->get_group_permission($group_id);

		$class_schedule['student_no'] = sizeof($students_data);

		$data = array(
			'class_schedule'	=>	$class_schedule,
			// 'lab_info'			=>	$lab_info,
			// 'assigned_group_item'	=>	$assigned_group_item,
			'group_permission'	=> $group_permission
		);

		$this->response([
			'status' => TRUE,
			'message' => 'successfully fetch group data',
			'payload' => $data,
		], RestController::HTTP_OK);
	}

	public function getStudentListInGroupWithLabScore_get()
	{
		$this->logout_after_time_limit();
		$this->update_last_seen();

		$group_id = $this->query('group_id');

		$this->set_default_for_group_permission($group_id);

		$this->load->model('student_model');
		$this->load->model('lab_model_rest');
		$group_no = $this->lab_model_rest->get_group_no($group_id);
		$students_data = $this->lab_model_rest->get_students_by_group_id($group_id);

		// Get the number of chapters
		$number_of_chapters = $this->lab_model_rest->get_number_of_chapters();

		// Initialize chapter scores for each student
		foreach ($students_data as &$student) {
			$student['chapter_score'] = array_fill(1, $number_of_chapters, 0);
		}

		// Get the lab marking data
		$marking_data = $this->lab_model_rest->get_group_data($group_id);

		// Add lab marking to $students_data
		foreach ($marking_data as $mark) {
			foreach ($students_data as &$student) {
				if ($mark['stu_id'] == $student['stu_id']) {
					$student['chapter_score'][$mark['chapter_id']] += $mark['max_marking'];
				}
			}
		}

		$lab_info = $this->lab_model_rest->get_lab_info();

		$data = array(
			'group_no'			=>	$group_no,
			'lab_info'			=>	$lab_info,
			'student_list'	=> $students_data,
		);

		$this->response([
			'status' => TRUE,
			'message' => 'successfully fetch student list data',
			'payload' => $data,
		], RestController::HTTP_OK);
	}

	public function getLabChapterInfo_get()
	{
		$group_id = $this->query('group_id');
		$chapter_id = $this->query('lab_no');

		$group_exercise_chapter = $this->lab_model_rest->get_group_exercise_chapter($group_id, $chapter_id);
		$group_no = $this->lab_model_rest->get_group_no($group_id);
		$group_lab_list = array();
		foreach ($group_exercise_chapter as $row) {
			$item = $row['item_id'];
			$exercises = $row['exercise_id_list'];
			for ($i = 1; $i <= sizeof($exercises); $i++) {
				$group_lab_list[$item][$i] = $exercises[$i - 1];
			}
		}

		$lab_exercise = $this->lab_model_rest->get_lab_exercise_by_chapter($chapter_id);

		$lab_list = array();
		$level_index = array();
		foreach ($lab_exercise as $exercise) {
			$level = $exercise['lab_level'];
			if (!isset($level_index[$level])) {
				$level_index[$level] = 0;
				$lab_list[$level] = array();
			}
			$lab_list[$level][] = array(
				'group_no' => $group_no,
				'exercise_id' => $exercise['exercise_id'],
				'lab_chapter' => $exercise['lab_chapter'],
				'lab_level' => $exercise['lab_level'],
				'lab_name' => $exercise['lab_name'],
				'full_mark' => $exercise['full_mark']
			);
			$level_index[$level]++;
		}

		$chapter_permission = $this->lab_model_rest->get_group_permission($group_id);
		$chapter_permission = $chapter_permission[$chapter_id];

		$data = array(
			'group_id'					=>	$group_id,
			'group_no' 					=> $group_no,
			'chapter_id'					=>	$chapter_id,
			'chapter_name'				=>	$chapter_permission['chapter_name'],
			'group_selected_labs' =>	$group_lab_list,
			'lab_list'					=>	$lab_list,
		);

		$this->response([
			'status' => TRUE,
			'message' => 'successfully fetch lab chapter info',
			'payload' => $data,
		], RestController::HTTP_OK);
	}

	public function setChapterPermission_post()
	{
		$postdata = $this->post();

		// Check if necessary data is present
		if (!isset($postdata['class_id'], $postdata['chapter_id'], $postdata['prefix'])) {
			// Send an error response
			$this->response(array(
				'message' => 'Missing required data',
			), RestController::HTTP_BAD_REQUEST);
			return;
		}

		$class_id = $postdata['class_id'];
		$chapter_id = $postdata['chapter_id'];
		$prefix = $postdata['prefix'];

		// Validate the type
		$type = $postdata['allow_' . $prefix . '_type'];
		if (!in_array($type, ['always', 'deny', 'timer', 'timer-paused', 'datetime'])) {
			// Send an error response
			$this->response(array(
				'message' => 'Invalid type',
			), RestController::HTTP_BAD_REQUEST);
			return;
		}

		$permission = array();
		$permission['allow_' . $prefix . "_type"] = $type;


		if ($type == 'always' || $type == 'deny') {
			$permission[$prefix . '_time_start'] = null;
			$permission[$prefix . '_time_end'] = null;
		} else if ($type == 'timer-paused') {
			if (!isset($postdata[$prefix . '_time_start'])) {
				// Send an error response
				$this->response(array(
					'message' => 'Missing start or end date',
				), RestController::HTTP_BAD_REQUEST);
				return;
			}

			$permission[$prefix . '_time_start'] = $postdata[$prefix . '_time_start'];
		} else {
			// Validate the dates
			if (!isset($postdata[$prefix . '_time_start'], $postdata[$prefix . '_time_end'])) {
				// Send an error response
				$this->response(array(
					'message' => 'Missing start or end date',
				), RestController::HTTP_BAD_REQUEST);
				return;
			}

			$permission[$prefix . '_time_start'] = $postdata[$prefix . '_time_start'];
			$permission[$prefix . '_time_end'] = $postdata[$prefix . '_time_end'];
		}

		$update_row = $this->lab_model_rest->set_chapter_permission($class_id, $chapter_id, $permission);
		$this->response(array(
			'message' => 'permission updated successfully',
			'update_row' => $update_row,
		), RestController::HTTP_OK);
	}

	public function setAllowGroupLogin_post()
	{
		$group_id = $this->post('group_id');
		$allow_login = $this->post('allow_login');
		$user_id = $this->session->userdata('id');

		if (!in_array($allow_login, ['yes', 'no'])) {
			// Send an error response
			$this->response(array(
				'message' => 'Invalid data provided.',
			), RestController::HTTP_BAD_REQUEST);
			return;
		}

		// Validate the data
		if (!isset($group_id, $allow_login, $user_id)) {
			$this->response(['message' => 'Invalid data provided.'], RestController::HTTP_BAD_REQUEST);
			return;
		}

		$staff_id_list = $this->lab_model_rest->get_group_staffs($group_id);

		// Check if the user_id is in the staff_id_list
		if (!in_array($user_id, $staff_id_list)) {
			$this->response(['message' => 'You are not allowed to change this setting.'], RestController::HTTP_FORBIDDEN);
			return;
		}

		$this->lab_model_rest->set_allow_class_login($group_id, $allow_login);

		$this->response(['message' => 'Setting updated successfully.'], RestController::HTTP_OK);
	}

	public function setAllowGroupUploadPicture_post()
	{
		$group_id = $this->post('group_id');
		$allow_upload_pic = $this->post('allow_upload_pic');
		$user_id = $this->session->userdata('id');

		if (!in_array($allow_upload_pic, ['yes', 'no'])) {
			// Send an error response
			$this->response(array(
				'message' => 'Invalid data provided.',
			), RestController::HTTP_BAD_REQUEST);
			return;
		}

		// Validate the data
		if (!isset($group_id, $allow_upload_pic, $user_id)) {
			$this->response(['message' => 'Invalid data provided.'], RestController::HTTP_BAD_REQUEST);
			return;
		}

		$staff_id_list = $this->lab_model_rest->get_group_staffs($group_id);

		// Check if the user_id is in the staff_id_list
		if (!in_array($user_id, $staff_id_list)) {
			$this->response(['message' => 'You are not allowed to change this setting.'], RestController::HTTP_FORBIDDEN);
			return;
		}

		$this->lab_model_rest->set_allow_class_upload_pic($group_id, $allow_upload_pic);

		$this->response(['message' => 'Setting updated successfully.'], RestController::HTTP_OK);
	}
	public function exercise_add_chapter_item_python()
	{
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST :</h3><pre>"; print_r($_POST); echo "</pre>";
		$chapter = $_POST['lab_no'];
		$level = $_POST['level'];
		$created_by = $_POST['user_id'];
		// insert new record into lab_exercise table
		// and update $_SESSION['lab_2b_edit']
		$exercise_id = $this->lab_model_rest->exercise_add_chapter_item_python($chapter, $level, $created_by);
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";

		$_POST = array();
		$_POST['exercise_id'] = $exercise_id;
		$this->exercise_edit();
	}

	public function update_selected_exercise_post()
	{
		$group_id = $this->post('group_id');
		$user_id = $this->post('user_id');
		$chapter = $this->post('chapter');
		$level = $this->post('level');


		$postData = $this->post();
		unset($postData['group_id']);
		unset($postData['user_id']);
		unset($postData['chapter']);
		unset($postData['level']);

		if (empty($postData)) {
			$this->response(['message' => 'You must select at least ONE.'], REST_Controller::HTTP_BAD_REQUEST);
			return;
		}

		// Check permission here (implement your own logic)
		$class_schedule = $this->lab_model_rest->get_class_schedule_by_group_id($group_id);
		$previledge = $this->check_previledge($group_id);

		if ($previledge == "none") {
			$this->response(['message' => "You are not allowed to select Exercises for student group: " . $class_schedule['group_no']], REST_Controller::HTTP_FORBIDDEN);
			return;
		}

		$list = array_values($postData);
		sort($list);

		// Call your model's update method here
		$this->lab_model_rest->update_lab_class_item($group_id, $chapter, $level, $list);

		$response_data = [
			'message' => 'Exercise selection updated successfully',
			'group_id' => $group_id,
			'lab_no' => $chapter
		];

		$this->response($response_data, RestController::HTTP_OK);
	}
	private function check_previledge($group_id)
	{
		$user_id = $_SESSION['id'];
		$class_schedule = $this->lab_model_rest->get_class_schedule_by_group_id($group_id);
		$previledge = "none";
		if ($user_id == $class_schedule['lecturer']) {
			//this user is lecturer of the group
			$previledge = "lecturer";
		} else {
			foreach ($class_schedule['lab_staff'] as $staff) {
				//echo '$staff<pre>'; print_r($staff) ; echo '</pre>';
				if ($staff['staff_id'] == $user_id) {
					//this user is staff of this group
					$previledge = "staff";
				}
			}
		}
		//echo '$previledge : '.$previledge.'<br/>';
		return $previledge;
	}

	public function updateGroupAssignedChapterItem_post()
	{
		$group_id = $this->post('group_id');
		$chapter_id = $this->post('chapter_id');
		$item_id = $this->post('item_id');
		$exercise_id_list = $this->post('exercise_id_list');

		if (!isset($group_id, $chapter_id, $item_id, $exercise_id_list)) {
			$this->response(['message' => 'Invalid data provided.'], RestController::HTTP_BAD_REQUEST);
			return;
		}

		$previledge = $this->check_previledge($group_id);

		if ($previledge == "none") {
			$this->response(['message' => "You are not allowed to select Exercises for student group: "], RestController::HTTP_FORBIDDEN);
			return;
		}

		$strval_exercise_id_list = array_map('strval', $exercise_id_list);

		$this->lab_model_rest->update_lab_class_item($group_id, $chapter_id, $item_id, $strval_exercise_id_list);

		$this->response([
			'message' => 'Exercise selection updated successfully',
		], RestController::HTTP_OK);
	}

	// V HERE V
	public function getEditExercisePageInfo_get()
	{
		$exercise_id = $this->query("exercise_id");
		$chapter_id = $this->query("chapter_id");
		$group_id = $this->query("group_id");

		$group_no = $this->lab_model_rest->get_group_no($group_id);
		$lab_exercise = $this->lab_model_rest->get_lab_exercise_by_id($exercise_id);
		$chapter_name = $this->lab_model_rest->get_chapter_name($chapter_id);
		$sourcecode_filename = $lab_exercise['sourcecode'];

		// Get sourcecode_content file from harddisk
		if (file_exists(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename)) {
			$sourcecode_content = file_get_contents(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename);

			// Remove BOM if it exists
			$sourcecode_content = preg_replace('/\x{FEFF}/u', '', $sourcecode_content);

			$lab_exercise['sourcecode_content'] = $sourcecode_content;
		} else {
			$lab_exercise['sourcecode_content'] = "Cannot find the file . . .";
		}

		$lab_exercise['sourcecode_output'] = $this->get_sourcecode_output_no_testcase($exercise_id);
		$testcase_array = $this->lab_model_rest->get_testcase_array($exercise_id);
		$num_of_testcase = $this->lab_model_rest->get_num_testcase($exercise_id);

		$data = array(
			'group_no' => $group_no,
			'chapter_name' => $chapter_name,
			'lab_exercise' => $lab_exercise,
		);

		$this->response($data, RestController::HTTP_OK);
	}

	public function getExerciseTestcases_get()
	{
		$exercise_id = $this->query("exercise_id");

		if (!isset($exercise_id)) {
			$this->response(['message' => 'Invalid data provided.'], RestController::HTTP_BAD_REQUEST);
			return;
		}

		$testcase_array = $this->lab_model_rest->get_testcase_array($exercise_id);

		$this->response($testcase_array, RestController::HTTP_OK);
	}

	public function get_sourcecode_output_no_testcase($exercise_id)
	{
		$this->load->model('lab_model');
		$lab_exercise = $this->lab_model_rest->get_lab_exercise_by_id($exercise_id);
		$sourcecode_filename = $lab_exercise['sourcecode'];
		$sourcecode_output = "Not Available";

		if ($lab_exercise['testcase'] == "no_input") {
			//ไม่มี testcase 
			require_once 'Exercise_test.php';
			$exercise_test = new exercise_test();
			$sourcecode_output = $exercise_test->get_result_noinput($sourcecode_filename, 'supervisor');
			$sourcecode_output = $exercise_test->unify_whitespace($sourcecode_output);
			$sourcecode_output = $exercise_test->insert_newline($sourcecode_output);
		}
		return $sourcecode_output;
	}

	public function prepare_constraints($exercise_id)
	{
		$kw_con =  $this->lab_model_rest->get_exercise_constraint($exercise_id);

		$suggested_constraints = array(
			'reserved_words' => array(),
			'functions' => array(),
			'methods' => array(),
			'variables'	=> array(),
			'imports' => array(),
			'classes' => array(),
		);
		$user_defined_constraints = array(
			'reserved_words' => array(),
			'functions' => array(),
			'methods' => array(),
			'variables'	=> array(),
			'imports' => array(),
			'classes' => array(),
		);

		for ($i = 0; $i < sizeof($kw_con); $i++) {
			$constraint = $kw_con[$i];

			$new_constraint = array(
				'keyword' => $constraint['keyword'],
				'type' => $constraint['type'],
				'limit' => $constraint['limit'],
			);
			if ($constraint['constraint_group'] == 'suggested_constraints') {
				array_push($suggested_constraints[$constraint['category']], $new_constraint);
			} else {
				array_push($user_defined_constraints[$constraint['category']], $new_constraint);
			}
		}

		return array(
			'suggested_constraints' => $suggested_constraints,
			'user_defined_constraints' => $user_defined_constraints,
		);
	}

	public function getExerciseFormData_get()
	{
		$exercise_id = $this->query("exercise_id");
		$formdata = $this->lab_model_rest->get_exercise_form($exercise_id);

		$sourcecode_filename = $formdata['sourcecode'];

		// Get sourcecode_content file from harddisk
		if (file_exists(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename)) {
			$sourcecode_content = file_get_contents(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename);

			// Remove BOM if it exists
			$sourcecode_content = preg_replace('/\x{FEFF}/u', '', $sourcecode_content);

			$formdata['sourcecode_content'] = $sourcecode_content;
		} else {
			$formdata['sourcecode_content'] = "Cannot find the file . . .";
		}

		$default_constraints = array(
			'reserved_words' => array(),
			'functions' => array(),
			'methods' => array(),
			'variables'	=> array(),
			'imports' => array(),
			'classes' => array(),
		);

		$data = array(
			'lab_name' => $formdata['lab_name'],
			'lab_content' => $formdata['lab_content'],
			'sourcecode_content' => $formdata['sourcecode_content'],
			'keyword_constraints' => array(
				'suggested_constraints' => $formdata['suggested_constraints'] == null ? $default_constraints : json_decode($formdata['suggested_constraints'], true),
				'user_defined_constraints' => $formdata['user_defined_constraints'] == null ? $default_constraints : json_decode($formdata['user_defined_constraints'], true),
			)
		);

		$this->response($data, RestController::HTTP_OK);
	}

	public function getTestcases_get()
	{
		$exercise_id = $this->query("exercise_id");
		$testcases = $this->lab_model_rest->get_testcase_array($exercise_id);
		$this->response($testcases, RestController::HTTP_OK);
	}

	public function updateExercise_post()
	{
		$updated_data = $this->post();
		$exercise_id = $updated_data['exercise_id'];
		unset($updated_data['exercise_id']);
		$user_id = $this->session->userdata('id');

		$lab = $this->lab_model_rest->get_lab_exercise_by_id($exercise_id);

		if (!($user_id == $lab['created_by'] || $this->session->userdata('username') == 'kanut')) {
			$this->response(['message' => 'You are not allowed to edit this exercise.'], 403);
		}

		$updated_data['user_defined_constraints'] = json_encode($updated_data['keyword_constraints']['user_defined_constraints']);
		$updated_data['suggested_constraints'] = json_encode($updated_data['keyword_constraints']['suggested_constraints']);

		unset($updated_data['keyword_constraints']);

		$sourcecode_content = $updated_data['sourcecode_content'];
		$sourcecode_filename = $lab['sourcecode'];

		// Write content to the hard disk
		file_put_contents(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename, $sourcecode_content);

		$updated_data['sourcecode'] = $sourcecode_filename;
		unset($updated_data['sourcecode_content']);

		// update the exercise and return the updated exercise
		$updated_exercise = $this->lab_model_rest->update_exercise($exercise_id, $updated_data);

		$this->response($updated_exercise, RestController::HTTP_OK);
	}

	public function createConstraintRows($constraints, $constraint_group, $exercise_id)
	{
		$constraint_rows = array();
		foreach ($constraints as $category => $constraints) {
			for ($i = 0; $i < sizeof($constraints); $i++) {
				$constraint = $constraints[$i];
				$new_row = array(
					'exercise_id' => (int) $exercise_id,
					'constraint_group' => $constraint_group,
					'category' => $category,
					'keyword' => $constraint['keyword'],
					'type' => $constraint['type'],
					'limit' => (int) $constraint['limit'],
				);
				array_push($constraint_rows, $new_row);
			}
		}
		return $constraint_rows;
	}

	public function createExercise_post()
	{
		try {
			$this->db->trans_start();
			$postData = $this->post();
			$exerciseData = array(
				'lab_chapter' => (int)$postData['lab_chapter'],
				'lab_level' => $postData['lab_level'],
				'lab_name' => $postData['lab_name'],
				'lab_content' => $postData['lab_content'],
				'testcase' =>  'no_input',
				'full_mark' => (int) $postData['full_mark'],
				'added_date' => date("Y-m-d H:i:s"),
				'last_update' => date("Y-m-d H:i:s"),
				'user_defined_constraints' => json_encode($postData['keyword_constraints']['user_defined_constraints']),
				'suggested_constraints' => json_encode($postData['keyword_constraints']['suggested_constraints']),
				'added_by' => $this->session->userdata('username'),
				'created_by' => (int)$this->session->userdata('id'),
			);
			$exercise_id = $this->lab_model_rest->create_exercise($exerciseData);

			// create sourcecode file
			$sourcecode_filename =  'exercise_' . $exercise_id . '.py';
			file_put_contents(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename, $postData['sourcecode_content']);
			$this->lab_model_rest->update_sourcecode_filename($exercise_id, $sourcecode_filename);

			// update constraint in the exercise_constraint table
			// $user_defined_constraints = $postData['keyword_constraints']['user_defined_constraints'];
			// $suggested_constraints = $postData['keyword_constraints']['suggested_constraints'];

			/* $constraint_rows = array_merge(
				$this->createConstraintRows($user_defined_constraints, 'user_defined_constraints', $exercise_id),
				$this->createConstraintRows($suggested_constraints, 'suggested_constraints', $exercise_id)
			);

			$this->lab_model_rest->insert_multiple_exercise_constraint($constraint_rows); */

			$exerciseData['sourcecode'] = $sourcecode_filename;

			$created_exercise = $this->db->select('*')
				->from('lab_exercise')
				->where('lab_exercise.exercise_id', $exercise_id)
				->get()
				->first_row();

			// $keyword_constraints = $this->prepare_constraints($exercise_id);

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				// if the transaction has failed, delete the file
				unlink(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename);
				throw new Exception('Transaction failed');
			} else {
				$this->response(
					$created_exercise,
					// 'keyword_constraints' => $keyword_constraints,
					RestController::HTTP_OK
				);
			}
		} catch (Exception $e) {
			$this->response(['message' => $e->getMessage()], RestController::HTTP_BAD_REQUEST);
		}
	}

	public function getAddExercisePageInfo_get()
	{
		$chapter_id = $this->query("chapter_id");
		$group_id = $this->query("group_id");

		$group_no = $this->lab_model_rest->get_group_no($group_id);
		$chapter_name = $this->lab_model_rest->get_chapter_name($chapter_id);

		$data = array(
			'group_no' => $group_no,
			'chapter_name' => $chapter_name,
		);

		$this->response($data, RestController::HTTP_OK);
	}

	public function logoutAllStudentInGroup_post()
	{
		$group_id = $this->post('group_id');
		$user_id = $this->session->userdata('id');

		// Validate the data
		if (!isset($group_id, $user_id)) {
			$this->response(['message' => 'Invalid data provided.'], RestController::HTTP_BAD_REQUEST);
			return;
		}

		$stu_list = $this->lab_model_rest->get_students_by_group_id($group_id);
		// echo json_encode($stu_list);

		$count = 0;
		$stu_logout = [];
		foreach ($stu_list as $stu) {
			if (intval($stu['ci_session']) > 0 && $stu['status'] == "online") {
				$stu_id = intval($stu['stu_id']);
				$this->lab_model_rest->logout_student($stu_id);
				$count++;
				array_push($stu_logout, $stu);
			}
		}

		$this->response([
			'message' => 'Logout ' . $count . ' students successfully',
			'payload' => $stu_logout,
		], RestController::HTTP_OK);
	}

	public function runTestcase_post()
	{
		//echo '<pre>',print_r($_POST),'</pre>';
		$testcase = $this->post();
		$exercise_id = $testcase['exercise_id'];
		$testcase_content = $testcase['testcase_content'];
		if (strlen($testcase_content) <= 0) {
			$this->response(['message' => 'Testcase content is empty.'], RestController::HTTP_BAD_REQUEST);
		}

		// update only one testcase
		require_once 'Exercise_test.php';
		$sourcecode_filename = $this->lab_model->get_sourcecode_filename($testcase['exercise_id']);
	}
}
