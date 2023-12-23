<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

require_once(APPPATH . "/controllers/MY_RestController.php");

/**
 * Class Student_rest
 *
 * This class extends the MY_RestController class and provides functionality to retrieve data related to a student's lab work.
 */
class Student_rest extends MY_RestController
{
  /**
   * Student_rest constructor.
   *
   * Initializes the class and loads the student_model_rest model.
   */
  public function __construct()
  {
    parent::__construct();
    $this->protected();
    $this->load->model('student_model_rest');
  }

  /**
   * Retrieves data related to a student's lab work and returns it in a specific format.
   */
  public function getChapterList_get()
  {
    $this->load->model("lab_model_rest");

    $stu_id = $this->query('stu_id');
    $stu_group = $this->student_model_rest->get_student_record($stu_id)['stu_group'];

    $permission = $this->lab_model_rest->get_group_permission($stu_group);
    $lab_data = $this->lab_model_rest->setup_student_lab_data($stu_id, $stu_group);
    $student_marking_all_items = $this->lab_model_rest->get_a_student_marking_for_all_submitted_items($stu_id);

    foreach ($student_marking_all_items as $row) {
      $marking = $row['max_marking'] ?? 0;
      $chapter_id = $row['chapter_id'];
      $item_id = $row['item_id'];
      $lab_data[$chapter_id][$item_id]['stu_lab']['marking'] = $marking;
    }

    $data = [];

    for ($i = 1; $i < count($permission) + 1; $i++) {
      $temp = $permission[$i];
      $temp['chapter_id'] = $i;
      $data[$i] = $temp;
      $data[$i]['items'] = array_values($lab_data[$i]);
    }

    $this->response(array_values($data), RestController::HTTP_OK);
  }

  public function getStudentAssignedExercise_get()
  {
    $this->db->trans_start(); // Start the transaction

    // Retrieve the student ID, chapter ID, and item ID from the query parameters
    $stu_id = $this->query('stu_id');
    $chapter_id = $this->query('chapter_id');
    $item_id = $this->query('item_id');

    // Check if the provided data is valid
    if (!isset($stu_id, $chapter_id, $item_id)) {
      $this->response(['message' => 'Invalid data provided.'], RestController::HTTP_BAD_REQUEST);
    }

    // Retrieve the exercise ID assigned to the student based on the provided IDs
    $exercise_id = $this->student_model_rest->get_student_assigned_exercise_id($stu_id, $chapter_id, $item_id);

    // Retrieve the group ID of the student
    $group_id = $this->student_model_rest->get_student_record($stu_id)['stu_group'];

    // Check if exercise_id is null
    if (empty($exercise_id)) {
      // Retrieve the exercise ID pool for the given group, chapter, and item
      $exercise_random_pool = unserialize($this->student_model_rest->get_exercise_random_pool($group_id, $chapter_id, $item_id)['exercise_id_list']);

      // Check if the exercise pool is empty
      if (empty($exercise_random_pool)) {
        $this->response(['message' => 'No exercise available.'], RestController::HTTP_BAD_REQUEST);
      }

      // Select a random exercise ID from the pool
      $exercise_id = $exercise_random_pool[array_rand($exercise_random_pool)];

      // Upsert the student's assigned chapter item with the selected exercise ID
      $this->student_model_rest->upsert_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id);
    }

    $this->load->model('lab_model_rest');

    // Retrieve the details of the assigned exercise using the exercise ID
    $lab_exercise = $this->lab_model_rest->get_lab_exercise_by_id($exercise_id);

    // Retrieve the name of the chapter using the chapter ID
    $lab_exercise['chapter_name'] = $this->lab_model_rest->get_chapter_name($chapter_id);

    $lab_exercise['user_defined_constraints'] = json_decode($lab_exercise['user_defined_constraints']);
    $lab_exercise['suggested_constraints'] = json_decode($lab_exercise['suggested_constraints']);

    // Remove sensitive information from the exercise details
    unset($lab_exercise['sourcecode']);
    unset($lab_exercise['sourcecode_content']);

    $this->db->trans_complete(); // Complete the transaction

    // Check if the transaction failed
    if ($this->db->trans_status() === FALSE) {
      $this->response(['message' => 'Transaction failed.'], RestController::HTTP_INTERNAL_ERROR);
    } else {
      // Return the exercise details
      $this->response($lab_exercise, RestController::HTTP_OK);
    }
  }

  public function getStudentCardInfo_get()
  {
    $stu_id = $this->query('stu_id');

    if (!isset($stu_id)) {
      $this->response(['message' => 'Invalid data provided.'], RestController::HTTP_BAD_REQUEST);
    }

    $student = $this->student_model_rest->get_student_record($stu_id);

    $this->load->model('lab_model_rest');

    $group_data = $this->lab_model_rest->get_class_schedule_by_group_id($student['stu_group']);

    $this->load->model('supervisor_model_rest');

    $lecturer = $this->supervisor_model_rest->get_supervisor_fullname_by_id($group_data['lecturer']);

    $ip_address = $this->input->ip_address();

    $data = [
      'stu_id' => $student['stu_id'],
      'stu_firstname' => $student['stu_firstname'],
      'stu_lastname' => $student['stu_lastname'],
      'mid_score' => $student['mid_score'],
      'group_id' => $student['stu_group'],
      'group_no' => $group_data['group_no'],
      'day_of_week' => $group_data['day_of_week'],
      'time_start' => $group_data['time_start'],
      'time_end' => $group_data['time_end'],
      'year' => $group_data['year'],
      'semester' => $group_data['semester'],
      'lecturer' => $lecturer,
      'stu_ip' => $ip_address,
    ];

    $this->response($data, RestController::HTTP_OK);
  }
}
