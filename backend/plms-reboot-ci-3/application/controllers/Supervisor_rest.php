<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));
require_once(APPPATH . "/controllers/MY_RestController.php");

class Supervisor_rest extends MY_RestController
{
	protected $access = "supervisor";
	private $redis;

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
		$this->load->model('auth_model_rest');
		$this->auth_model_rest->update_last_seen($this->session->userdata('id'));

		$this->load->model('lab_model_rest');
		$this->load->model('supervisor_model_rest');
		$this->load->model('student_model_rest');
	}

	public function getAllAvailableGroups_get()
	{
		try {
			if (!empty($cache)) {
				$data = json_decode($cache, true);
				return $this->response([
					'status' => TRUE,
					'message' => 'Successfully fetched available groups',
					'payload' => $data,
				], RestController::HTTP_OK);
			}

			$this->update_last_seen();
			$year = $this->query('year');
			$class_schedule = $this->supervisor_model_rest->get_class_schedule();

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
				'message' => 'Successfully fetched available groups',
				'payload' => $data,
			], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function getGroupListById_get()
	{
		try {
			$this->logout_after_time_limit();
			$this->update_last_seen();
			$user_id = $_SESSION['id'];
			$supervised_groups_sem1 = $this->lab_model_rest->get_supervise_group($user_id, 1);
			$supervised_groups_sem2 = $this->lab_model_rest->get_supervise_group($user_id, 2);
			$assisted_groups = $this->lab_model_rest->get_staff_group($user_id);

			// Merge the arrays
			$merged_groups = array_merge($supervised_groups_sem1, $supervised_groups_sem2, $assisted_groups);

			// Remove duplicates
			$groups = array();
			foreach ($merged_groups as $group) {
				if (!in_array($group, $groups, true)) {
					$groups[] = $group;
				}
			}

			$group_list = array();
			foreach ($groups as $i => $group) {
				$group_id = !empty($group['class_id']) ? $group['class_id'] : $group['group_id'];

				$group_list[$i] = $this->lab_model_rest->get_class_schedule_by_group_id($group_id);
				$students_in_group = $this->lab_model_rest->get_count_of_students($group_id);
				$group_list[$i]['students_in_group'] = $students_in_group;
			}

			$data = array(
				'group_list' => $group_list,
			);

			$this->response([
				'status' => TRUE,
				'message' => 'Successfully fetch supervisor group list',
				'payload' => $data,
			], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}


	private function set_default_for_group_permission($group_id)
	{
		try {
			$class_schedule = $this->lab_model_rest->get_class_schedule_by_group_id($group_id);
			$group_permission = $this->lab_model_rest->get_group_permission($group_id);
			$lab_info = $this->lab_model_rest->get_lab_info();
			$number_of_chapters = sizeof($lab_info);
			$this->lab_model_rest->set_default_for_group_permission($group_id, $number_of_chapters, $class_schedule);
		} catch (Exception $e) {
			throw $e;
		}
	}

	// TODO: Get number of online student and send it with group data
	public function getGroupDataById_get()
	{
		try {
			$this->logout_after_time_limit();
			$this->update_last_seen();

			$group_id = $this->query('group_id');
			$class_schedule = $this->lab_model_rest->get_class_schedule_by_group_id($group_id);
			$students_data = $this->lab_model_rest->get_students_by_group_id($group_id);

			$midterm_scores = $this->lab_model_rest->get_midterm_score($group_id);
			$_SESSION['mid_score'] = $midterm_scores;

			// Create a placeholder for selected exercise for the group in group_assigned_exercise table
			$this->lab_model_rest->create_selected_exercise_for_group($group_id);

			$marking_data = $this->lab_model_rest->get_group_data($group_id);

			$class_schedule['student_no'] = sizeof($students_data);

			$data = array(
				'class_schedule' => $class_schedule,
			);

			$this->response([
				'status' => TRUE,
				'message' => 'Successfully fetch group data',
				'payload' => $data,
			], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function getNumberOfOnlineStudents()
	{
		try {
			$group_id = $this->query('group_id');
			$online_students = sizeof($this->lab_model_rest->get_online_students($group_id));

			$data = [
				'online_students' => $online_students,
			];

			$this->response($data, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function getGroupChapterPermission_get()
	{
		try {
			$group_id = $this->query('group_id');

			// Check if the group_id is valid or exists
			$group_permission = $this->lab_model_rest->get_group_permission($group_id);

			if (empty($group_permission)) {
				$this->set_default_for_group_permission($group_id);
				$this->lab_model_rest->assign_group_item($group_id);
				$group_permission = $this->lab_model_rest->get_group_permission($group_id);
			}

			$this->response($group_permission, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function getLabChapterInfo_get()
	//ทำ config มีโอกาสพัง
	{
		try {
			$group_id = $this->query('group_id');
			$chapter_id = $this->query('lab_no');

			$group_exercise_chapter = $this->lab_model_rest->get_group_exercise_chapter($group_id, $chapter_id);
			$group_no = $this->lab_model_rest->get_group_no($group_id);
			$group_lab_list = array();
			foreach ($group_exercise_chapter as $row) {
				$item = $row['item_id'];
				$exercises = $row['exercise_id_list'];
				$group_lab_list[$item] = array();
				for ($i = 0; $i < sizeof($exercises); $i++) {
					array_push($group_lab_list[$item], $exercises[$i]);
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
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function setChapterPermission_post()
	{
		try {
			$postdata = $this->post();

			// Check if necessary data is present
			if (!isset($postdata['class_id'], $postdata['chapter_id'], $postdata['prefix'])) {
				throw new Exception('Missing required data', RestController::HTTP_BAD_REQUEST);
			}

			$class_id = $postdata['class_id'];
			$chapter_id = $postdata['chapter_id'];
			$prefix = $postdata['prefix'];
			$sync = $postdata['sync'];

			$other_prefix = $prefix == 'submit' ? 'access' : 'submit';

			// Validate the type
			$type = $postdata['allow_' . $prefix . '_type'];
			if (!in_array($type, ['always', 'deny', 'timer', 'timer-paused', 'datetime'])) {
				throw new Exception('Invalid type', RestController::HTTP_BAD_REQUEST);
			}

			$permission = array();
			$permission['allow_' . $prefix . "_type"] = $type;
			if ($sync) {
				$permission['allow_' . $other_prefix . "_type"] = $type;
			}

			if ($type == 'always' || $type == 'deny') {
				$permission[$prefix . '_time_start'] = null;
				$permission[$prefix . '_time_end'] = null;

				if ($sync) {
					$permission[$other_prefix . '_time_start'] = null;
					$permission[$other_prefix . '_time_end'] = null;
				}
			} else if ($type == 'timer-paused') {
				if (!isset($postdata[$prefix . '_time_start'])) {
					throw new Exception('Missing' . $prefix . ' start date or' . $prefix . 'end date', RestController::HTTP_BAD_REQUEST);
				}
				$permission[$prefix . '_time_start'] = $postdata[$prefix . '_time_start'];

				if ($sync) {
					$permission[$other_prefix . '_time_start'] = $postdata[$prefix . '_time_start'];
				}
			} else {
				// Validate the dates
				if (!isset($postdata[$prefix . '_time_start'], $postdata[$prefix . '_time_end'])) {
					throw new Exception('Missing' . $prefix . ' start date or' . $prefix . 'end date', RestController::HTTP_BAD_REQUEST);
				}
				$permission[$prefix . '_time_start'] = $postdata[$prefix . '_time_start'];
				$permission[$prefix . '_time_end'] = $postdata[$prefix . '_time_end'];

				if ($sync) {
					$permission[$other_prefix . '_time_start'] = $postdata[$prefix . '_time_start'];
					$permission[$other_prefix . '_time_end'] = $postdata[$prefix . '_time_end'];
				}
			}

			$update_row = $this->lab_model_rest->set_chapter_permission($class_id, $chapter_id, $permission);

			$redis = $this->get_redis_instance();

			$redis->publish("chapter-permission:$class_id:chap-$chapter_id", "permission updated");

			$redis->close();

			$this->response(array(
				'message' => 'permission updated successfully',
				'update_row' => $update_row,
			), RestController::HTTP_OK);
		} catch (Exception $e) {
			echo $e->getMessage();
			return $this->handleError($e);
		}
	}

	public function setAllowGroupLogin_post()
	{
		try {
			$group_id = $this->post('group_id');
			$allow_login = $this->post('allow_login');
			$user_id = $this->session->userdata('id');

			if (!in_array($allow_login, ['yes', 'no'])) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			// Validate the data
			if (!isset($group_id, $allow_login, $user_id)) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			$staff_id_list = $this->lab_model_rest->get_group_staffs($group_id);

			// Check if the user_id is in the staff_id_list
			if (!in_array($user_id, $staff_id_list)) {
				throw new Exception('You are not allowed to change this setting.', RestController::HTTP_FORBIDDEN);
			}

			$this->lab_model_rest->set_allow_class_login($group_id, $allow_login);

			return $this->response(['message' => 'Setting updated successfully.'], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function setAllowGroupUploadPicture_post()
	{
		try {
			$group_id = $this->post('group_id');
			$allow_upload_pic = $this->post('allow_upload_pic');
			$user_id = $this->session->userdata('id');

			if (!in_array($allow_upload_pic, ['yes', 'no'])) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			// Validate the data
			if (!isset($group_id, $allow_upload_pic, $user_id)) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			$staff_id_list = $this->lab_model_rest->get_group_staffs($group_id);

			// Check if the user_id is in the staff_id_list
			if (!in_array($user_id, $staff_id_list)) {
				throw new Exception('You are not allowed to change this setting.', RestController::HTTP_FORBIDDEN);
			}

			$this->lab_model_rest->set_allow_class_upload_pic($group_id, $allow_upload_pic);

			return $this->response(['message' => 'Setting updated successfully.'], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
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
		try {
			$group_id = $this->post('group_id');
			$chapter_id = $this->post('chapter_id');
			$item_id = $this->post('item_id');
			$exercise_id_list = $this->post('exercise_id_list');

			if (!isset($group_id, $chapter_id, $item_id, $exercise_id_list)) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			$previledge = $this->check_previledge($group_id);

			if ($previledge == "none") {
				throw new Exception("You are not allowed to select Exercises for student group:", RestController::HTTP_FORBIDDEN);
			}

			$strval_exercise_id_list = array_map('strval', $exercise_id_list);

			$this->lab_model_rest->update_lab_class_item($group_id, $chapter_id, $item_id, $strval_exercise_id_list);

			return $this->response([
				'message' => 'Exercise selection updated successfully',
			], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function updateAllGroupAssignedChapterItem_post()
	{
		try {
			$group_id = $this->post('group_id');
			$chapter_id = $this->post('chapter_id');
			$pools_list = $this->post('pools_list');
			$previledge = $this->check_previledge($group_id);

			if ($previledge == "none") {
				throw new Exception("You are not allowed to select Exercises for student group:", RestController::HTTP_FORBIDDEN);
			}

			// start transaction
			$this->db->trans_start();

			// iterate through array and get $key and $value
			foreach ($pools_list as $key => $value) {
				$item_id = $key;
				$exercise_id_list = $value;
				$strval_exercise_id_list = array_map('strval', $exercise_id_list);
				$this->lab_model_rest->update_lab_class_item($group_id, $chapter_id, $item_id, $strval_exercise_id_list);
			}

			// commit transaction
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return $this->handleError($e);
		}
	}

	public function getEditExercisePageInfo_get()
	{
		try {
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

			return $this->response($data, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function getExerciseTestcases_get()
	{
		try {
			$exercise_id = $this->query("exercise_id");

			if (!isset($exercise_id)) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			if (!empty($cache)) {
				$data = json_decode($cache, true);
				return $this->response($data, RestController::HTTP_OK);
			}

			$testcase_array = $this->lab_model_rest->get_testcase_array($exercise_id);

			return $this->response($testcase_array, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
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
		try {
			$exercise_id = $this->query("exercise_id");

			if (!empty($cache)) {
				$data = json_decode($cache, true);
				return $this->response($data, RestController::HTTP_OK);
			}

			$formdata = $this->lab_model_rest->get_exercise_form($exercise_id);

			if (!$formdata) {
				throw new Exception('Exercise form data not found.', RestController::HTTP_NOT_FOUND);
			}

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

			return $this->response($data, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function getTestcases_get()
	{
		try {
			$exercise_id = $this->query("exercise_id");
			$testcases = $this->lab_model_rest->get_testcase_array($exercise_id);
			$this->response($testcases, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function updateExercise_post()
	{
		try {
			$updated_data = $this->post();
			$exercise_id = $updated_data['exercise_id'];
			unset($updated_data['exercise_id']);
			$user_id = $this->session->userdata('id');

			$lab = $this->lab_model_rest->get_lab_exercise_by_id($exercise_id);

			/* if (!($user_id == $lab['created_by'] || $this->session->userdata('username') == 'kanut')) {
				throw new Exception('You are not allowed to edit this exercise.', 403);
			} */

			$updated_data['user_defined_constraints'] = json_encode($updated_data['keyword_constraints']['user_defined_constraints']);
			$updated_data['suggested_constraints'] = json_encode($updated_data['keyword_constraints']['suggested_constraints']);

			unset($updated_data['keyword_constraints']);

			$sourcecode_content = $updated_data['sourcecode_content'];
			$sourcecode_filename = $lab['sourcecode'];

			// Write content to the hard disk
			if (file_put_contents(SUPERVISOR_CFILES_FOLDER . $sourcecode_filename, $sourcecode_content) === false) {
				throw new Exception('Failed to write source code content to disk.', RestController::HTTP_BAD_REQUEST);
			}

			$updated_data['sourcecode'] = $sourcecode_filename;
			unset($updated_data['sourcecode_content']);

			// update the exercise and return the updated exercise
			$updated_exercise = $this->lab_model_rest->update_exercise($exercise_id, $updated_data);

			if (!$updated_exercise) {
				throw new Exception('Failed to update exercise.', RestController::HTTP_BAD_REQUEST);
			}

			return $this->response($updated_exercise, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
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
		try {
			$chapter_id = $this->query("chapter_id");
			$group_id = $this->query("group_id");

			if (empty($chapter_id) || empty($group_id)) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			$group_no = $this->lab_model_rest->get_group_no($group_id);
			$chapter_name = $this->lab_model_rest->get_chapter_name($chapter_id);

			$data = array(
				'group_no' => $group_no,
				'chapter_name' => $chapter_name,
			);

			$this->response($data, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function logoutAllStudentInGroup_post()
	{
		try {
			$group_id = $this->post('group_id');
			$user_id = $this->session->userdata('id');

			// Validate the data
			if (empty($group_id) || empty($user_id)) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
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
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	// TODO : Implement upload pic
	public function uploadExerciseContentPic_post()
	{
		// check if $_FILES is empty or not
		if (empty($_FILES)) {
			$this->response(['message' => 'No file uploaded.'], RestController::HTTP_BAD_REQUEST);
			return;
		}

		// check if the file is uploaded successfully
	}

	public function studentInfoCard_get()
	{
		try {
			$stu_id = $this->query('stu_id');

			if (empty($stu_id)) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			$student_info = $this->lab_model_rest->get_student_info($stu_id);

			$avatar = empty($student_info['stu_avatar']) ? null : base_url() . STUDENT_AVATAR_FOLDER . $student_info['stu_avatar'];

			$data = array(
				'stu_id' => $student_info['stu_id'],
				'stu_firstname' => $student_info['stu_firstname'],
				'stu_lastname' => $student_info['stu_lastname'],
				'stu_nickname' => $student_info['stu_nickname'],
				'can_submit' => $student_info['can_submit'],
				'stu_avatar' => $avatar,
				'group_id' => $student_info['group_id'],
				'group_no' => $student_info['group_no'],
			);

			$this->response($data, RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function resetStudentPassword_post()
	{
		try {
			$stu_id = $this->post('stu_id');

			if (empty($stu_id)) {
				throw new Exception('Invalid data provided.', RestController::HTTP_BAD_REQUEST);
			}

			$this->student_model_rest->student_reset_password($stu_id);
			$this->response(['message' => 'Password reset successfully.'], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function getAssignedStudentExercise_get()
	{
		try {
			$stu_id = $this->query('stu_id');
			$chapter_id = $this->query('chapter_id');
			$item_id = $this->query('item_id');

			$exercise_id = $this->student_model_rest->get_student_assigned_exercise_id($stu_id, $chapter_id, $item_id);

			if (empty($exercise_id)) {
				throw new Exception('No exercise assigned to this student.', RestController::HTTP_NOT_FOUND);
			}

			$exercise = $this->lab_model_rest->get_lab_exercise_by_id($exercise_id);

			$this->response([
				'message' => 'Exercise found.',
				'exercise' => $exercise,
			], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function addStudent_post()
	{
		$stu_data = $this->post('student_data');
		$stu_group_id = $this->post('group_id');
		$string = $stu_data;
		$students = explode("\n", $stu_data);
		$student_data = array();

		foreach ($students as $student) {
			$student_info = preg_split("/[\s\n]+/", $student);
			$row['stu_no'] = $student_info[0];
			$row['stu_id'] = $student_info[1];
			$row['stu_name'] = $student_info[2];
			$row['stu_surname'] = $student_info[3];
			$student_data[] = $row;
		}

		$this->load->model('student_model_rest');
		foreach ($student_data as $row) {
			$stu_id = $row['stu_id'];
			$stu_name = $row['stu_name'];
			$stu_surname = $row['stu_surname'];
			$message = "";
			/* echo $row['stu_no'] . " " . $row['stu_id'] . " " . $row['stu_name'] . " " . $row['stu_surname'] . "<br />"; */
			if (strlen($row['stu_id']) == 8) {
				/* echo "add will be performed.<br />"; */
				$message = $this->student_model_rest->check_or_add_student_to_user($stu_id);
				/* if ($message == 'OK') { */
				$this->createLogfile(__METHOD__ . " : $stu_id is added to user table. ==> " . $message);
				/* echo " ==> Added.<br />"; */
				$stu_gender = 'other';
				if (substr($stu_name, 0, 9) == 'นาย') {
					$stu_gender = 'male';
					$stu_firstname = substr($stu_name, 9, strlen($stu_name));
					$stu_lastname = $stu_surname;
				} else if (substr($stu_name, 0, 18) == 'นางสาว') {
					$stu_gender = 'female';
					$stu_firstname = substr($stu_name, 18, strlen($stu_name));
					$stu_lastname = $stu_surname;
				} else {
					$stu_gender = 'other';
					$stu_firstname = $stu_name;
					$stu_lastname = $stu_surname;
				}

				$student_data = array(
					'stu_id'	=> $stu_id,
					'stu_firstname'	=> $stu_firstname,
					'stu_lastname'	=> $stu_lastname,
					'stu_group'		=> $stu_group_id,
					'stu_gender'	=> $stu_gender
				);
				$message = $this->student_model_rest->check_or_add_student_to_user_student($student_data);

				if ($message == 'Alreadyexist') {
					$this->student_model_rest->update_student_group($stu_id, $stu_group_id);
				}
				/* } */
			}
		}
		$this->response([
			'status' => TRUE,
			'message' => 'Student added successfully'
		], RestController::HTTP_OK);
	}

	public function saveExerciseTestcase_post()
	{
		$req_body = $this->post(null, true);
		$exercise_id = $req_body['exercise_id'];
		$testcase_list = $req_body['testcase_list'];
		$removed_list = $req_body['removed_list'];
		$job_id = $req_body['job_id'];

		if (!isset($exercise_id)) {
			return $this->response(['message' => 'Invalid request body'], RestController::HTTP_BAD_REQUEST);
		}

		$this->load->model('lab_model_rest');

		// Start a transaction
		$this->db->trans_begin();

		if (!empty($removed_list)) {
			$this->lab_model_rest->exercise_testcase_delete_by_id_list($removed_list);
		}

		// Update testcase.is_ready to false
		foreach ($testcase_list as &$testcase) {
			$testcase['is_ready'] = 'no';
			if ($testcase['testcase_id'] == null) {
				$testcase['testcase_id'] = $this->lab_model_rest->exercise_testcase_upsert($testcase);
			} else {
				$this->lab_model_rest->exercise_testcase_upsert($testcase);
			}
		}
		unset($testcase); // Unset reference when it's no longer needed

		$file_name = $this->lab_model_rest->get_sourcecode_filename($exercise_id);

		$role = $this->session->userdata('role');

		$directory_path = $role == "student" ? STUDENT_CFILES_FOLDER : SUPERVISOR_CFILES_FOLDER;

		// Prepare source code file
		$file_to_run = $directory_path . $file_name;

		$result_list = array();

		try {
			$connection = new AMQPStreamConnection('rabbitmq', getenv('RMQ_PORT'), getenv('RMQ_USER'), getenv('RMQ_PASSWORD'));
			$channel = $connection->channel();
			$channel->queue_declare(getenv('RMQ_QUEUE_NAME'), false, true, false, false);

			$message = new AMQPMessage(json_encode(array(
				'job_id' => $job_id,
				'job_type' => 'upsert-testcase',
				'exercise_id' => $exercise_id,
				'testcase_list' => $testcase_list,
				'sourcecode' => file_get_contents($file_to_run),
			)));

			$channel->basic_publish($message, '', 'task-queue');

			$channel->close();
			$connection->close();

			// If the AMQP message was sent successfully, commit the transaction
			$this->db->trans_commit();
		} catch (Exception $e) {
			// If an error occurred, roll back the transaction
			$this->db->trans_rollback();

			$this->response([
				'status' => 'error',
				'message' => 'An error occurred while running testcases',
				'error' => $e->getMessage(),
			], RestController::HTTP_INTERNAL_ERROR);
		}

		$this->response([
			'status' => 'success',
			'message' => 'Testcases are being run',
			'job_id' => $job_id,
		], RestController::HTTP_OK);
	}

	public function getStudentListInGroupWithLabScore_get()
	{
		try {
			$this->logout_after_time_limit();
			$this->update_last_seen();

			$group_id = $this->query('group_id');

			// Check if the group_id is valid or exists
			if (empty($group_id)) {
				throw new Exception('Invalid group ID', RestController::HTTP_BAD_REQUEST);
			}

			// Check if the group exists or handle accordingly
			// Example: if (!$this->lab_model_rest->groupExists($group_id)) {
			//    throw new Exception('Group not found', RestController::HTTP_NOT_FOUND);
			// }

			$this->set_default_for_group_permission($group_id);

			$this->load->model('student_model');
			$this->load->model('lab_model_rest');
			$group_no = $this->lab_model_rest->get_group_no($group_id);
			$students_data = $this->lab_model_rest->get_students_by_group_id($group_id);

			// Check if there are any students in the group
			/* if (empty($students_data)) {
				throw new Exception('No students found in the group', RestController::HTTP_NOT_FOUND);
			} */

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
				'group_no' => $group_no,
				'lab_info' => $lab_info,
				'student_list' => $students_data,
			);

			$this->response([
				'status' => TRUE,
				'message' => 'Successfully fetch student list data',
				'payload' => $data,
			], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function deleteStudent_post()
	{
		try {
			$stu_id = $this->post('stu_id');
			$this->student_model_rest->delete_student($stu_id);

			$this->response([
				'status' => TRUE,
				'message' => 'Student deleted successfully',
			], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}

	public function setStudentCanSubmit_post()
	{
		try {
			$stu_id = $this->post('stu_id');
			$can_submit = $this->post('can_submit');

			$this->student_model_rest->set_student_can_submit($stu_id, $can_submit);

			$this->response([
				'status' => TRUE,
				'message' => 'Student can submit status updated successfully',
			], RestController::HTTP_OK);
		} catch (Exception $e) {
			return $this->handleError($e);
		}
	}
}
