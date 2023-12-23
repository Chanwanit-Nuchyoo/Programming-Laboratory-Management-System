<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// define('K_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));

class Bs5_test extends MY_CONTROLLER {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function index()
	{
		
		$this->show_to_console(__FILE__);
		$this->show_to_console (__DIR__ );
		$this->show_to_console(__FUNCTION__);
		$this->show_to_console (__METHOD__ );
		$this->show_to_console(__NAMESPACE__);
		$this->show_to_console (__TRAIT__ );
		$this->show_to_console($_ENV);			// deprecated
		$this->show_to_console($_REQUEST);
		$this->show_to_console($_SERVER);
		$this->show_to_console($_SESSION);
		$this->load->view("bs5_arsha");		

	}//public function index()

	public function verify() 
	{
		echo '<h2>username : '.$this->input->post('username').'</h2>';
		echo '<h2>password : '.$this->input->post('password').__POST['password'].'</h2>';
		//redirect('/Student');
	}

	public function show()
	{
		echo '$_POST'."<pre>";
		print_r($_POST);
		echo "</pre>";
	}

	public function test_path() 
	{
		echo '<h2>__FILE__ = '. __FILE__ .'</h2>';
		echo '<h2>__DIR__ = '. __DIR__ .'</h2>';
		echo '<h2>__FUNCTION__ = '. __FUNCTION__ .'</h2>';
		echo '<h2>__CLASS__ = '. __CLASS__ .'</h2>';
		echo '<h2>__TRAIT__ = '. __TRAIT__ .'</h2>';
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		echo '<h2>__NAMESPACE__ = '. __NAMESPACE__ .'</h2>';
	}
	public function nav_sideleft() {
		$this->load->model('student_model');		
		$data = array( 
						
						'class_info'	=>	$this->_class_info,
						'lab_data'		=>	$this->_lab_data,
						'student_data'	=>	$this->_student_data

					);

		$this->load->view('student/nav_sideleft',$data);
	}
	public function template_check() {
		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		echo __METHOD__;
	}
}//class Welcome
?>