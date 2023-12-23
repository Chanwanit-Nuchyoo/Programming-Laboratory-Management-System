<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class MY_RestController extends RestController
{

  protected $access = "*";

  public function __construct()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    parent::__construct();

    // $this->login_check();
    $_SESSION['walk'] = __METHOD__ . " ";
  }

  public function isLoggedInCheck()
  {
    $this->load->model('auth_model_rest');

    $is_session_match = $this->auth_model_rest->check_session_id();

    if ($is_session_match) {
      return true;
    }

    return false;
  }

  public function protected()
  {
    if (!$this->isLoggedInCheck()) {
      $this->response([
        'status' => FALSE,
        'message' => "unauthorized access.",
      ], RestController::HTTP_UNAUTHORIZED);

      die();
    }
  }

  public function login_check()
  {
    if ($this->access != "*") {
      // here we check the role of the user
      if (!$this->permission_check()) {
        $this->response([
          'status' => FALSE,
          'message' => "Access denied",
        ], RestController::HTTP_UNAUTHORIZED);
        die();
      }
    }
  }

  public function permission_check()
  {
    if ($this->access == "@") {
      return true;
    } else {
      $access = is_array($this->access) ? $this->access :  explode(",", $this->access);
      if (in_array($this->session->userdata("role"), array_map("trim", $access))) {
        return true;
      }

      return false;
    }
  }

  public function createLogFile($action = 'test')
  {
    $_SESSION['action'] = $action;
    $this->load->model('lab_model_rest', 'lab_model');
    $this->lab_model->add_log();
  }

  public function createLogFile_auto_logout($stu_user, $role)
  {
    $log_folder = APPPATH . 'logs' . DIRECTORY_SEPARATOR;
    $today = date('Y-m-d');
    $time = date('H:i:s');
    $ip = 'NULL';
    $user = $stu_user;
    $role = 'student';
    $filename = $_SESSION['role'] . '_' . $today . '.log';
    "";
    $action = 'logout ==> over time limit';


    $fp = fopen(APPPATH . 'logs' . DIRECTORY_SEPARATOR . $filename, 'a') or exit("Can't open $filename!");
    fwrite($fp, '[' . $today . ' ' . $time . '] [' . $user . '] [' . $role . '] [' . $action . '] [' . $ip . ']');
    fwrite($fp, "\r\n");
    fclose($fp);
  }

  public function logout()
  {

    $this->load->model('auth_model_rest');
    $this->auth_model_rest->update_user_logout($_SESSION['id']);
    $this->createLogFile("log out");


    $this->session->unset_userdata("logged_in");
    $this->session->sess_destroy();
    $this->access = "*";

    redirect("auth");
  }

  // logout specific user
  // parameter is a row from USER table
  public function logout_specific_user($user_2b_logout)
  {
    $old_session_id = $user_2b_logout['session_id'];
    $current_session_id = session_id();
    // leave current session
    //session_commit();
    session_destroy();
    // start old session and destroy
    session_id($old_session_id);
    session_start();
    $this->createLogFile("logout over time limit");
    $this->load->model('auth_model_rest');
    $this->auth_model_rest->update_user_logout($user_2b_logout['id']);



    $this->session->unset_userdata("logged_in");
    $this->session->sess_destroy();
    $this->access = "*";
    // resume session
    session_id($current_session_id);
    session_start();
  }

  public function update_last_seen()
  {
    $this->load->model('auth_model_rest');
    $this->auth_model_rest->update_last_seen($_SESSION['id']);
  }

  public function logout_after_time_limit()
  {
    $this->load->model('auth_model_rest');
    $online_users = $this->auth_model_rest->get_online_users();
    $time_now = time();
    foreach ($online_users as $user) {
      $last_seen = strtotime($user['last_seen']);
      $diff_time_in_second = $time_now - $last_seen;
      $diff_time_in_minute = $diff_time_in_second / 60;
      if ($diff_time_in_minute > TIME_LIMIT_IN_MINUTE) {
        $this->logout_specific_user($user);
      }
    }
  }
  // public function show_to_console($arr = 'empty')
  // {
  //   //return;
  //   if ($arr == 'empty') {
  //     $x = json_encode($_SESSION);
  //   } else {
  //     $x = json_encode($arr);
  //   }

  //   echo '<script>' . PHP_EOL;
  //   echo 'var x = ' . json_encode($x) . ';' . PHP_EOL;
  //   echo "console.log(" . $x . ") ;" . PHP_EOL;
  //   echo '</script>' . PHP_EOL;
  // }
}
