<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class K_Controller extends CI_Controller {

	protected $access = "*";

	public function __construct()
	{
		parent::__construct();
		// $_SESSION['username']='anonymous';
		// $_SESSION['role'] = 'undefined';
		$this->login_check();
	}

    public function login_check() {
        $this->load->model('auth_model');
        // $this->auth_model->update_user_logout($_SESSION['id']);
    }


	public function show_to_console($arr='empty') {
		if ($arr=='empty') {
			$x= json_encode($_SESSION);
		} else {
			$x = json_encode($arr);
		}
		
		echo '<script>';
		echo "console.log(".$x.") ;";
		echo '</script>';
		
	}
	

}//class K_Controller extends CI_Controller
