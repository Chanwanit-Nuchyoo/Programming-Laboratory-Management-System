<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for Author group only
 */
class Auth extends MY_Controller {	

	protected $access = "Author";

	public function index()
	{
		$this->load->view("auth_header");
		$this->load->view("auth_navbar");
		$this->load->view("auth_author");
		$this->load->view("auth_footer");
	}

}