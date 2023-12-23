<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for Editor group only
 */
class Editor extends MY_Controller {

	protected $access = array("Admin", "Editor");

	public function index()
	{
		$this->load->view("auth_header");
		$this->load->view("auth_navbar");
		$this->load->view("auth_editor");
		$this->load->view("auth_footer");
	}
}