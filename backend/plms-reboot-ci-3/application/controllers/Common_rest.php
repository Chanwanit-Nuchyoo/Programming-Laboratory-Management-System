<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

require_once(APPPATH . "/controllers/MY_RestController.php");

class Common_rest extends MY_RestController
{
  public function __construct()
  {
    parent::__construct();
    $this->protected();

    $this->load->model('auth_model_rest');
    $this->auth_model_rest->update_last_seen($this->session->userdata('id'));
    $this->load->model('common_model_rest');
  }

  public function getBreadCrumbs_get()
  {
    try {
      $params = $this->get();

      // Define a mapping of parameter names to table names and column names
      $mapping = array(
        'group_id' => array('table' => 'class_schedule', 'column' => 'group_no'),
        'chapter_id' => array('table' => 'lab_classinfo', 'column' => 'chapter_name'),
        'exercise_id' => array('table' => 'lab_exercise', 'column' => 'lab_name'),
      );

      // Loop over url query parameters
      $data = $this->common_model_rest->get_breadcrumbs($params, $mapping);

      $this->response($data, RestController::HTTP_OK);
    } catch (Exception $e) {
      $this->handleError($e);
    }
  }

  public function getProfileFormData_get()
  {
    try {
      $prefix = array(
        'student' => 'stu',
        'supervisor' => 'supervisor',
      );

      $role = $this->session->userdata('role');
      $data = $this->common_model_rest->get_profile_form_data();
      $image_file_name = $data[$prefix[$role] . '_avatar'];

      if ($image_file_name) {
        $data[$prefix[$role] . '_avatar'] = ($role == "student" ? STUDENT_AVATAR_FOLDER : SUPERVISOR_AVATAR_FOLDER) . $image_file_name;
      } else {
        $data[$prefix[$role] . '_avatar'] = null;
      }

      // Rename the keys
      $newData = array();
      foreach ($data as $key => $value) {
        $newKey = preg_replace('/^.*?_/', '', $key); // remove everything before and including the first underscore
        $newData[$newKey] = $value;
      }

      if ($role == "student") {
        $department_list = $this->common_model_rest->get_all_department();
        $dept_id = $newData['dept_id'];
        unset($newData['dept_id']);

        foreach ($department_list as $department) {
          if ($department['dept_id'] == $dept_id) {
            $newData['department'] = $department['dept_name'];
            break;
          }
        }
      }
      $this->response($newData, RestController::HTTP_OK);
    } catch (Exception $e) {
      $this->handleError($e);
    }
  }

  public function updateProfile_post()
  {
    try {
      $formData = $this->post(null, true);
      $role = $this->session->userdata('role');

      // Load necessary models and libraries
      $this->load->model('auth_model_rest', 'auth');
      $this->load->library('upload');

      // Verify current password
      if (!$this->auth->verify_password($formData['current_password'])) {
        throw new Exception('Incorrect password.', RestController::HTTP_UNAUTHORIZED);
      }

      $this->db->trans_start(); // Start transaction

      // Check and update password if new password is provided and matches confirm password
      $this->updatePasswordIfProvided($formData, $role);

      // Handle avatar upload if file is provided
      $data = $this->handleAvatarUpload($formData, $role);

      // Update profile with form data
      $data = array_merge($data, $this->prepareProfileData($formData, $role));

      $this->common_model_rest->updateProfile($role, $data);

      $this->db->trans_complete(); // Complete transaction

      return $this->response(['message' => 'Successfully updated profile'], RestController::HTTP_OK);
    } catch (Exception $e) {
      $this->handleError($e);
    }
  }

  private function updatePasswordIfProvided($formData, $role)
  {
    if (!empty($formData['new_password']) && !empty($formData['confirm_password'])) {
      if ($formData['new_password'] == $formData['confirm_password']) {
        $new_password = md5($formData['new_password']);
        switch ($role) {
          case 'student':
            $this->load->model('student_model_rest');
            $this->student_model_rest->update_student_password($this->session->userdata('id'), $new_password);
            break;
          case 'supervisor':
            $this->load->model('supervisor_model_rest');
            $this->supervisor_model_rest->update_supervisor_password($new_password);
            break;
        }
      } else {
        $this->response(['message' => 'New password and confirm password do not match.'], RestController::HTTP_BAD_REQUEST);
      }
    }
  }

  private function handleAvatarUpload($formData, $role)
  {
    $data = [];
    if (!empty($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
      $newFileName = "image_" . $_SESSION['id'] . "." . pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
      $folder = $role == "student" ? STUDENT_AVATAR_FOLDER : SUPERVISOR_AVATAR_FOLDER;

      $config = [
        'upload_path' => $folder,
        'allowed_types' => 'gif|jpg|png|jpeg',
        'file_name' => $newFileName,
        'overwrite' => true
      ];

      $this->upload->initialize($config);
      if (!$this->upload->do_upload('avatar')) {
        error_log('File upload error: ' . $this->upload->display_errors());
        return $data;
      }

      $data[$this->common_model_rest->prefix[$role] . "_" . 'avatar'] = $newFileName;
    } else {
      error_log('No file uploaded for avatar');
    }
    return $data;
  }

  private function prepareProfileData($formData, $role)
  {
    $data = [];
    $allowed_keys = ['firstname', 'lastname', 'nickname', 'gender', 'dob', 'email', 'tel', 'department'];
    foreach ($formData as $key => $value) {
      if (in_array($key, $allowed_keys)) {
        if ($key !== 'department') {
          $data[$this->common_model_rest->prefix[$role] . "_" . $key] = $value;
        } else {
          $data = array_merge($data, $this->handleDepartmentData($value, $role));
        }
      }
    }
    return $data;
  }

  private function handleDepartmentData($value, $role)
  {
    $data = [];
    switch ($role) {
      case 'student':
        $department_list = $this->common_model_rest->get_all_department();
        $department_names = array_column($department_list, 'dept_name');
        $department_ids = array_column($department_list, 'dept_id');

        $key = array_search($value, $department_names);
        if ($key !== false) {
          $data['stu_dept_id'] = $department_ids[$key];
        }
        break;
      case 'supervisor':
        $data['supervisor_department'] = $value;
        break;
    }
    return $data;
  }

  public function getAllDepartment_get()
  {
    $this->load->model('lab_model_rest');
    $data = $this->common_model_rest->get_all_department();

    $this->response($data, RestController::HTTP_OK);
  }

  public function getRunTaskResult_get()
  {
    $job_id = $this->get('job_id');

    if (!isset($job_id)) {
      return $this->response(['message' => 'Invalid request body'], RestController::HTTP_BAD_REQUEST);
    }

    $this->load->model('lab_model_rest');

    $result_list = $this->lab_model_rest->get_testcase_result_by_job_id($job_id);

    $this->response([
      'status' => 'success',
      'message' => 'Testcases are being run',
      'result_list' => $result_list,
    ], RestController::HTTP_OK);
  }

  public function checkKeyword_post()
  {
    $sourcecode = $this->post('sourcecode');
    $exercise_kw_list = $this->post('exercise_kw_list');

    if (empty($sourcecode) || empty($exercise_kw_list)) {
      return $this->response([
        'status' => 'failed',
        'message' => 'Invalid request body'
      ], RestController::HTTP_BAD_REQUEST);
    }

    $result = $this->kw_check($sourcecode, $exercise_kw_list);

    if (empty($result)) {
      return $this->response([
        'status' => 'failed',
        'message' => 'An error occurred while checking keywords'
      ], RestController::HTTP_INTERNAL_ERROR);
    }

    $this->response($result, RestController::HTTP_OK);
  }


  public function get_kw_list($sourcecode)
  {
    $program = "python-files/keyword_list.py";

    // create temp file with unique name at the directory path
    $tempfile = tempnam("python-files", 'temp');

    try {
      file_put_contents($tempfile, $sourcecode);

      $command = escapeshellcmd("python3.12 $program $tempfile");
      $output = shell_exec($command);

      return json_decode($output, true);
    } finally {
      // delete temp file
      if (file_exists($tempfile)) {
        unlink($tempfile);
      }
    }
  }

  public function kw_check($sourcecode, $exercise_kw_list)
  {
    $tempfile1 = tempnam("python-files", 'temp');
    $tempfile2 = tempnam("python-files", 'temp');

    try {
      file_put_contents($tempfile1, $sourcecode);

      if (gettype($exercise_kw_list) == "array") {
        $exercise_kw_list = json_encode($exercise_kw_list);
      }

      file_put_contents($tempfile2, $exercise_kw_list);

      $command = escapeshellcmd("python3.12 python-files/kw_checker.py '$tempfile1' '$tempfile2'");
      $output = shell_exec($command);

      return json_decode($output, true);
    } finally {
      // delete temp files
      if (file_exists($tempfile1)) {
        unlink($tempfile1);
      }
      if (file_exists($tempfile2)) {
        unlink($tempfile2);
      }
    }
  }

  public function getKeywordList_post()
  {
    $sourcecode = $this->post('sourcecode');
    $kw_list = $this->get_kw_list($sourcecode);

    $this->response($kw_list, RestController::HTTP_OK);
  }

  public function getStudentSubmissionList_get()
  {
    $stu_id = $this->query('stu_id');
    $chapter_id = $this->query('chapter_id');
    $item_id = $this->query('item_id');

    if (!isset($stu_id, $chapter_id, $item_id)) {
      $this->response(['message' => 'Invalid data provided.'], RestController::HTTP_BAD_REQUEST);
    }

    $this->load->model('lab_model_rest');
    $this->load->model('student_model_rest');

    $exercise_id = $this->student_model_rest->get_student_assigned_exercise_id($stu_id, $chapter_id, $item_id);


    $submission_list = $this->lab_model_rest->get_student_submission($stu_id, $exercise_id);

    foreach ($submission_list as &$submission) {
      $file_path = STUDENT_CFILES_FOLDER . $submission['sourcecode_filename'];
      if (file_exists($file_path)) {
        $file_content = file_get_contents($file_path);
        $submission['sourcecode_content'] = $file_content !== FALSE ? $file_content : "file not found";
      } else {
        $submission['sourcecode_content'] = "# file not found";
      }

      $submission['result'] = json_decode($submission['result']);
    }

    $this->response($submission_list, RestController::HTTP_OK);
  }
}
