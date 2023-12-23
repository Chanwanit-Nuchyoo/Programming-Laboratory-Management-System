<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));

class Test_fileReader extends MY_Controller {
    public function __construct() {
		parent::__construct();
		echo "<h2> Hello</h2>";
		//echo "<h2> _class_info = <pre>";print_r($this->$_class_info);echo "</pre></h2>";
		//echo "<h2> _lab_data = <pre>";print_r($this->$_lab_data);echo "</pre></h2>";
		//echo "<h2> _group_permission = <pre>";print_r($this->$_group_permission);echo "</pre></h2>";
		//exit();




		
	}
    public function index()	{
		echo "<h3>index</h3>";
		
	}//public function index()
}
?>