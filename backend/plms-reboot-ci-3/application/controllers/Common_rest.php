<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once(APPPATH . "/controllers/MY_RestController.php");

class Common_rest extends MY_RestController
{
  public function __construct()
  {
    parent::__construct();
    // $this->protected();
    $this->load->model('common_model_rest');
  }

  public function getBreadCrumbs_get()
  {
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
  }

  public function getProfileFormData_get()
  {
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
  }
  public function updateProfile_post()
  {
    $formData = $this->post(null, true);
    $role = $this->session->userdata('role');

    // Load necessary models and libraries
    $this->load->model('auth_model_rest', 'auth');
    $this->load->library('upload');

    // Verify current password
    if (!$this->auth->verify_password($formData['current_password'])) {
      return $this->response(['message' => 'Incorrect password.'], RestController::HTTP_UNAUTHORIZED);
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
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
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

  public function runTestcases_post()
  {
    $req_body = $this->post(null, true);
    $exercise_id = $req_body['exercise_id'];
    $testcase_list = $req_body['testcase_list'];
    $removed_list = $req_body['removed_list'];

    if (!isset($exercise_id)) {
      return $this->response(['message' => 'Invalid request body'], RestController::HTTP_BAD_REQUEST);
    }

    if (!empty($removed_list)) {
      $this->load->model('lab_model_rest');
      $this->lab_model_rest->exercise_testcase_delete_by_id_list($removed_list);
    }

    $this->load->model('lab_model_rest');
    $file_name = $this->lab_model_rest->get_sourcecode_filename($exercise_id);

    $role = $this->session->userdata('role');

    $directory_path = $role == "student" ? STUDENT_CFILES_FOLDER : SUPERVISOR_CFILES_FOLDER;

    // Prepare source code file
    $file_to_run = $directory_path . $file_name; //$this->prepareExerciseCode($directory_path . $file_name, $exercise_id, $directory_path);

    $result_list = array();

    $this->load->model("lab_model_rest");

    foreach ($testcase_list as $testcase) {
      // Prepare input file
      $input_file = $this->prepareInputFile($testcase['testcase_content'], $exercise_id, $directory_path);

      // Run the test case
      $result = $this->runPython($file_to_run, $input_file);

      $testcase['testcase_output'] = $result['output'];
      $testcase['testcase_error'] = $result['error'];

      array_push($result_list, $testcase);



      $this->lab_model_rest->exercise_testcase_upsert($testcase);
    }

    $this->response([
      'status' => 'success',
      'message' => 'Testcases are being run',
      'job_id' => $job_id,
    ], RestController::HTTP_OK);
  }

  public function sendRunTaskMessage_post()
  {
    $req_body = $this->post(null, true);
    $exercise_id = $req_body['exercise_id'];
    $testcase_list = $req_body['testcase_list'];
    $removed_list = $req_body['removed_list'];

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
      $connection = new AMQPStreamConnection('rabbitmq', 5672, 'plms', 'plmskmitl2023');
      $channel = $connection->channel();
      $channel->queue_declare('task-queue', false, true, false, false);

      $job_id = uniqid();

      $message = new AMQPMessage(json_encode(array(
        'job_id' => $job_id,
        'job_type' => 'upsert-testcase',
        'exercise_id' => $exercise_id,
        'testcase_list' => $testcase_list,
        'sourcecode' => file_get_contents($file_to_run),
      )));

      $channel->basic_publish($message, '', 'exercise-testcase');

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

  public function prepareExerciseCode($file_path, $exercise_id, $directory_path)
  {
    $python_code = <<<EOT
  # ================== Injected code ==================
  import builtins
  
  def custom_input(user_inputs, prompt=""):
      if not user_inputs:
          raise EOFError("Ran out of input values.")
      response = user_inputs.pop(0)
      print(prompt + response)
      return response
  
  with open('{$directory_path}exercise_temp_$exercise_id.py.input', 'r') as file:
      user_inputs = file.read().splitlines()
  
  builtins.input = lambda prompt="": custom_input(user_inputs, prompt)
  
  # ================== Actual sourcecode content ================== 
  
  EOT;

    $temp_file = $directory_path . "exercise_temp_" . $exercise_id . ".py";
    $temp_file_handle = fopen($temp_file, "w");
    fwrite($temp_file_handle, $python_code);
    fwrite($temp_file_handle, "\n");  // Add an empty line
    fwrite($temp_file_handle, file_get_contents($file_path));
    fclose($temp_file_handle);

    return $temp_file;
  }

  public function prepareInputFile($input, $exercise_id, $directory_path)
  {
    $input_file = $directory_path . "exercise_temp_" . $exercise_id . ".py.input";
    $input_file_handle = fopen($input_file, "w");
    fwrite($input_file_handle, $input);
    fclose($input_file_handle);

    // return the temp file path
    return $input_file;
  }

  public function runPython($exercise_path, $input_path)
  {
    // Set the time limit
    $time_limit = 3;  // 1 second
    $memory_limit = 100000; // 100 MB

    // Sanitize the input to prevent command injection
    $exercise_path = escapeshellarg($exercise_path);
    $input_path = escapeshellarg($input_path);
    $runner_path = escapeshellarg("py-runner/runner.py");

    // Run the Python file with the input file and return the output within time limit
    $command = "timeout $time_limit /bin/bash -c \"ulimit -v $memory_limit; python3.12 $runner_path $exercise_path $input_path\" 2>&1";
    $output = [];
    $return_var = null;
    exec($command, $output, $return_var);

    // Prepare a result array
    $result = array(
      'output' => null,
      'error' => null,
      'command' => $command,
      'return_var' => $return_var,
    );

    // Check if the command timed out
    if ($return_var == 124) {
      $result['error'] = "Time limit exceeded";
      return $result;
    }

    // Check if the memory limit was exceeded
    if ($return_var == 139) {
      $result['error'] = "Memory limit exceeded";
      return $result;
    }

    // Check for other errors
    if ($return_var != 0) {
      if (!empty($output)) {
        $result['error'] = implode("\n", $output);
      } else {
        $result['error'] = "An error occurred while executing the script";
      }
      return $result;
    }

    if (empty($output)) {
      $result['error'] = "The script didn't produce any output";
      return $result;
    }

    $result['output'] = implode("\n", $output);
    return $result;
  }

  public function studentExerciseSubmit()
  {
    $stu_id = $this->input->post('stu_id');
    $chapter_id = $this->input->post('chapter_id');
    $item = $this->input->post('item');
    $exercise_id = $this->input->post('exercise_id');
    $sourcecode = $this->input->post('sourcecode');

    if (!isset($exercise_id) || !isset($stu_id) || !isset($sourcecode)) {
      return $this->response(['message' => 'Invalid request body'], RestController::HTTP_BAD_REQUEST);
    }

    // get all submitted exercise
    $this->load->model('lab_model_rest');
    $submission_list = $this->lab_model_rest->get_student_submission($stu_id, $exercise_id);

    // get the attemps number as a string
    $attemps = count($submission_list) + 1;

    // if the digit of attemps is less than 4 then add 0 to the front
    if (strlen($attemps) < 4) {
      $attemps = str_pad($attemps, 4, "0", STR_PAD_LEFT);
    }

    $directory_path = STUDENT_CFILES_FOLDER;
    $file_name = $stu_id . "_" . $chapter_id . "_" . $item . "_" . $attemps . ".py";

    // write the sourcecode to the file at the directory
    $writer = fopen($directory_path . $file_name, "w");
    fwrite($writer, $sourcecode);
    fclose($writer);

    // insert the submission to the database
    $submission = array(
      'stu_id' => $stu_id,
      'exercise_id' => $exercise_id,
      'is_ready' => 'no',
      'sourcecode_filename' => $file_name,
      'marking' => 0,
      'time_submit' => date("Y-m-d H:i:s"),
      'inf_loop' => 'No',
      'output' => null
    );

    $this->db->trans_start();
    $inserted_row = $this->lab_model_rest->exercise_submission_add($submission);

    $testcase_list = $this->lab_model_rest->get_testcase_array($exercise_id);

    try {
      $connection = new AMQPStreamConnection('rabbitmq', 5672, 'plms', 'plmskmitl2023');
      $channel = $connection->channel();
      $channel->queue_declare('task-queue', false, true, false, false);

      $job_id = uniqid();

      $message = new AMQPMessage(json_encode(array(
        'job_id' => $job_id,
        'job_type' => 'exercise-submit',
        'submission_id' => $inserted_row,
        'sourcecode' => file_get_contents($directory_path . $file_name),
        'testcase_list' => $testcase_list,
        'keyword-constraint' => array(),
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
      'message' => 'Submission are being run',
      'job_id' => $job_id,
    ], RestController::HTTP_OK);
  }
}
