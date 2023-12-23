<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for (all) non logged in users
 */
class Auth extends MY_Controller {	
	public function __construct() {
		parent::__construct();
		// $_SESSION['username'] = 'anonymous';
		$_SESSION['page_name'] = 'login';
	}

	public function logged_in_check()
	{
		if ($this->session->userdata("logged_in")) {
			if ($this->session->userdata('role')) {
				//redirect to corresponding page
				redirect($this->session->userdata('role'));
			
			} else { 
				// redirect to dashboard
				redirect("dashboard");
			}
			
		}
	}
/*
	public function update_for_auto_logout() {
		echo __METHOD__."hi<br>";
		$this->load->model('auth_model');
		$timeup_users = $this->auth_model->search_for_timeup_users();
		foreach ($timeup_users as $row) {
			print_r($row);
			echo "<br>";
		}

	}

	public function update_last_seen() {
		$this->load->model('auth_model');
		$this->auth_model->update_last_seen($_SESSION['id']);

	}
*/
	public function index()
	{	
		$this->logout_after_time_limit();


		$this->logged_in_check();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules("username", "Username", "trim|required");
		$this->form_validation->set_rules("password", "Password", "trim|required");
		$this->load->model('auth_model', 'auth');
		if ($this->form_validation->run() == true) 
		{
				
			// check the username & password of user
			$status = $this->auth->validate();
			if ($status == ERR_INVALID_USERNAME) {
				$this->session->set_flashdata("error", "Username is invalid");
			}
			elseif ($status == ERR_INVALID_PASSWORD) {
				$this->session->set_flashdata("error", "Password is invalid");
			}
			elseif ($status == ERR_REPEAT_LOGIN || $status == ERR_UNMATCH_SESSION) {
				$row = $this->auth->get_user_row();
				// echo "<pre>".print_r($row); echo "<br></pre>";
				// print_r($_SESSION); echo "<br>";
				$old_session_id = $row['session_id'];
				$current_session_id = session_id();
				// leave current session
				//session_commit();
				session_destroy();
				// start old session and destroy
				session_id($old_session_id);
				session_start();
				$this->load->model('auth_model');
				$this->auth_model->update_user_logout($row['id']);
				$_SESSION['username']=$row['username'];
				$_SESSION['role']=$row['role'];
				$this->createLogFile("log out");
				

				$this->session->unset_userdata("logged_in");
				$this->session->sess_destroy();
				$this->access = "*";	
				// resume session
				session_id($current_session_id);
				session_start();
				$message = "Repeat log in <br> ";
				$message .= "previous machine logged out.<br>";
				$message .= "Please log in AGAIN!";
				
				$this->session->set_flashdata("error", $message);
				
				

			} elseif ($status == ERR_CLASS_LOGIN_NOT_ALLOW) {

				$this->session->set_flashdata("error", "Login not allow by Instructor.");
			
			} elseif ($status == ERR_UNMATCH_SESSION) {
				$this->session->set_flashdata("error", "Unmatch session");
			}
			else {
				// success
				// store the user data to session
				$this->session->set_userdata($this->auth->get_data());
				$this->session->set_userdata("logged_in", true);
				
				// replace redirect("dashboard");
				// instead redirect to corresponding page
				if ($this->session->userdata('role')) {
					//redirect to corresponding page
					redirect($this->session->userdata('role'));
				
				} else { 
					// redirect to dashboard
					redirect("dashboard");
				}
			}
		}

		$this->load->view("auth_header");		
		$this->load->view("auth_topbar");
		$this->load->view("auth");
		$this->load->view("auth_footer");
		$this->show_to_console($_SERVER);
		$this->show_to_console($_SESSION);
	
	}

	public function logout()
	{
		
		$this->load->model('auth_model');
		if (isset($_SESSION['id']))
			$this->auth_model->update_user_logout($_SESSION['id']);
		$this->createLogFile("log out");
		

		$this->session->unset_userdata("logged_in");
		$this->session->sess_destroy();
		$this->access = "*";	
		$this->logout_after_time_limit();
		redirect("auth");
		
	}

	public function bs5_arsha() {
		echo "this is ok";
	}

	public function bs5_test() {
		$this->load->view("plms_bs5_layout");	
		// $this->load->view("plms_bs5_exercise_content");	
		// $this->load->view("plms_bs5_sourcecode");	
		// $this->load->view("plms_bs5_output");	
		// $this->load->view("plms_footer_bs5");
	}


}
