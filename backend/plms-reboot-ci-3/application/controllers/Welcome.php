<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function index()
	{
		//$this->load->view('welcome_test');
		//$this->load->view('head');
		//$this->load->view('body_head');
		//$this->load->view('body_nav');
		//$this->load->view('body_main');
		//$this->load->view('footer');
		//$this->load->view('test_layout_webpage');
		redirect('/Auth');
		//$this->load->view('sb-admin/sb-admin');
		// echo __METHOD__;

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