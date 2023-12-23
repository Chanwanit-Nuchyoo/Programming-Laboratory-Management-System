<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

require_once(APPPATH . "/controllers/MY_RestController.php");

class Auth_rest extends MY_RestController
{
  public function __construct()
  {
    parent::__construct();
    $_SESSION['page_name'] = 'login';

    $this->load->helper('cookie');
  }

  public function logged_in_check_get()
  {
    $this->logout_after_time_limit();

    $isLoggedIn = $this->isLoggedInCheck();

    if ($isLoggedIn) {
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

  public function login_post()
  {
    try {
      $this->logout_after_time_limit();

      $username = trim($this->post('username', TRUE), " ");
      $password = trim($this->post('password', TRUE), " ");

      // form validation
      if ($username == '' || $password == '') {
        throw new Exception('Username and password cannot be empty.', RestController::HTTP_BAD_REQUEST);
      }

      $this->load->model('auth_model_rest', 'auth');

      // validate user
      $status = $this->auth->validate($username, $password);

      if ($status == ERR_INVALID_USERNAME || $status == ERR_INVALID_PASSWORD) {
        throw new Exception('Username or password is not correct.', RestController::HTTP_UNAUTHORIZED);
      }

      if ($status == ERR_REPEAT_LOGIN || $status == ERR_UNMATCH_SESSION) {
        $row = $this->auth->get_user_row();
        $old_session_id = $row['session_id'];
        $current_session_id = session_id();

        session_destroy();

        session_id($old_session_id);
        session_start();

        $this->auth->update_user_logout($row['id']);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['page_name'] = 'login';
        $this->createLogFile("log out");

        $this->session->unset_userdata("logged_in");
        $this->session->sess_destroy();
        $this->access = "*";

        // Resume the current session
        session_id($current_session_id);
        session_start();

        throw new Exception('Repeat log in. Previous machine logged out. Please try again.', RestController::HTTP_UNAUTHORIZED);
      }

      if ($status == ERR_CLASS_LOGIN_NOT_ALLOW) {
        throw new Exception('Login is not allowed by Instructor.', RestController::HTTP_UNAUTHORIZED);
      }

      if ($status == ERR_UNMATCH_SESSION) {
        throw new Exception('Unmatch session.', RestController::HTTP_UNAUTHORIZED);
      }

      $this->session->set_userdata($this->auth->get_data());
      $this->session->set_userdata("logged_in", true);

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
    }
  }


  public function logout_post()
  {
    try {
      $this->load->model('auth_model_rest', 'auth');

      if (isset($_SESSION['id'])) {
        $this->auth->update_user_logout($_SESSION['id']);
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
    }
  }
}
