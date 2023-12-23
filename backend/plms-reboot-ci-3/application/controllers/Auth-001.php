<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for (all) non logged in users
 */
class Auth extends MY_Controller {	

	public function logged_in_check()
	{
		if ($this->session->userdata("logged_in")) {
			redirect("dashboard");
			
		}
	}

	public function index()
	{	
		$this->logged_in_check();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules("username", "Username", "trim|required");
		$this->form_validation->set_rules("password", "Password", "trim|required");
		if ($this->form_validation->run() == true) 
		{
			$this->load->model('auth_model', 'auth');	
			// check the username & password of user
			$status = $this->auth->validate();
			if ($status == ERR_INVALID_USERNAME) {
				$this->session->set_flashdata("error", "Username is invalid");
			}
			elseif ($status == ERR_INVALID_PASSWORD) {
				$this->session->set_flashdata("error", "Password is invalid");

	}
			else
			{
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
	}

	public function logout()
	{
		$this->createLogFile("log out");
		$this->session->unset_userdata("logged_in");
		$this->session->sess_destroy();
		$this->access = "*";
		
		redirect("auth");
	}

}
