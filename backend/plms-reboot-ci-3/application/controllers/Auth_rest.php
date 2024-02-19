<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

require_once(APPPATH . "/controllers/MY_RestController.php");

class Auth_rest extends MY_RestController
{
  public function __construct()
  {
    parent::__construct();
    $_SESSION['page_name'] = 'login';

    $this->load->model('auth_model_rest', 'auth');
    $this->auth->update_last_seen($this->session->userdata('id'));
    $this->load->helper('cookie');
  }

  public function logged_in_check_get()
  {
    $isLoggedIn = $this->isLoggedInCheck();

    if ($isLoggedIn) {
      $row = $this->auth->get_user_row();
      unset($row['password']);

      $avatar = $this->auth->get_user_avatar($row);

      foreach ($row as $key => $value) {
        $_SESSION[$key] = $value;
      }

      $_SESSION['avatar'] = $avatar;

      $this->response([
        'status' => TRUE,
        'message' => "already logged in",
        'payload' => $_SESSION
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => FALSE,
        'message' => "session expired.",
      ], RestController::HTTP_OK);
    }
  }

  public function publishActionMessage($redis, $user, $action)
  {
    if ($user["role"] == "student") {
      $this->load->model('lab_model_rest');
      $student = $this->lab_model_rest->get_student_info($user['id']);
      $group_id = $student['stu_group'];
      $redis->publish("online-students:$group_id", json_encode($action));
    }
  }

  public function login_post()
  {
    $redis = null;
    try {
      // Get and sanitize the username and password
      $username = trim($this->post('username', TRUE), " ");
      $password = trim($this->post('password', TRUE), " ");

      $redis = $this->get_redis_instance();

      // Check if the username and password are not empty
      if (empty($username) || empty($password)) {
        throw new Exception('Username and password cannot be empty.', RestController::HTTP_BAD_REQUEST);
      }

      // Validate the user's credentials
      $status = $this->auth->validate($username, $password);

      // Check if the username or password is invalid
      if ($status == ERR_INVALID_USERNAME || $status == ERR_INVALID_PASSWORD) {
        throw new Exception('Username or password is not correct.', RestController::HTTP_UNAUTHORIZED);
      }

      // Get the user's data
      $user = $this->auth->get_user_row();

      // Check if the user is trying to log in from a different session
      if ($status == ERR_REPEAT_LOGIN || $status == ERR_UNMATCH_SESSION) {
        // Save the current and old session IDs
        $old_session_id = $user['session_id'];
        $current_session_id = session_id();

        // Destroy the current session
        session_destroy();

        // Start the old session
        session_id($old_session_id);
        session_start();

        // Log the user out from the old session
        $this->auth->update_user_logout($user['id']);

        // Set the session data
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['page_name'] = 'login';

        // Log the logout event
        $this->createLogFile("log out");

        // Unset the logged_in flag and destroy the session
        $this->session->unset_userdata("logged_in");
        $this->session->sess_destroy();

        // Reset the access level
        $this->access = "*";

        // Resume the current session
        session_id($current_session_id);
        session_start();

        $this->publishActionMessage($redis, $user, array(
          "action" => "logout",
          "id" => $user["id"]
        ));

        // Throw an exception to indicate that the user needs to log in again
        throw new Exception('Repeat log in. Previous machine logged out. Please try again.', RestController::HTTP_UNAUTHORIZED);
      }

      // Check if the user is not allowed to log in
      if ($status == ERR_CLASS_LOGIN_NOT_ALLOW) {
        throw new Exception('Login is not allowed by Instructor.', RestController::HTTP_UNAUTHORIZED);
      }

      // Set the session data
      $this->session->set_userdata($this->auth->get_data());
      $this->session->set_userdata("logged_in", true);

      $this->publishActionMessage($redis, $user, array(
        "action" => "login",
        "id" => $user["id"]
      ));

      // Send a success response
      $this->response([
        'status' => TRUE,
        'message' => 'Login successful!',
        'payload' => $this->session->userdata(),
      ], RestController::HTTP_OK);
    } catch (Exception $e) {
      // Handle exceptions here
      $error_message = $e->getMessage();
      $http_code = $e->getCode(); // Get the HTTP error code from the exception

      // Send an error response with the specified HTTP error code
      $this->response([
        'status' => FALSE,
        'message' => $error_message
      ], $http_code);
    } finally {
      if ($redis) {
        $redis->close();
      }
    }
  }


  public function logout_post()
  {
    $redis = null;
    try {
      if (isset($_SESSION['id'])) {
        $this->auth->update_user_logout($_SESSION['id']);
        $user = $this->auth->get_user_row();
        $redis = $this->get_redis_instance();
        $this->publishActionMessage($redis, $user, array(
          "action" => "logout",
          "id" => $user["id"]
        ));
      } else {
        throw new Exception('User ID not found in session.');
      }

      $this->createLogFile("log out");
      $this->session->unset_userdata("logged_in");
      $this->session->sess_destroy();
      $this->access = "*";
      $this->logout_after_time_limit();

      // Delete the ci_session cookie
      delete_cookie("ci_session");

      // Send a success response
      $this->response([
        'status' => TRUE,
        'message' => 'Logout successful'
      ], RestController::HTTP_OK);
    } catch (Exception $e) {
      // Handle exceptions here
      $error_message = $e->getMessage();

      // Send an error response
      $this->response([
        'status' => FALSE,
        'message' => 'Logout failed: ' . $error_message
      ], RestController::HTTP_INTERNAL_ERROR);
    } finally {
      if ($redis) {
        $redis->close();
      }
    }
  }
}
