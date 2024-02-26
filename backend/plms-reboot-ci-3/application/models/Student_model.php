<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_Model
{

	private $table = "user_student";
	private $_data = array();

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		//echo "model constructor : ".__FILE__." <br>";

	}

	public function update_image($saved_filename)
	{
		$this->db->set('stu_avatar', $saved_filename);
		$this->db->where('stu_id', $_POST['stu_id']);
		$this->db->update('user_student');
	}


	public function validate()
	{
		exit('this is ok');
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->where("username", $username);
		$query = $this->db->get($this->table);

		if ($query->num_rows()) {
			// found row by username	
			$row = $query->row_array();

			// now check for the password
			if ($row['password'] == md5($password)) {
				//update last login for user
				$this->db->set('last_login', date("Y-m-d H:i:s"));
				$this->db->where('username', $username);
				$this->db->update($this->table);

				//retrieve data to make sure
				$this->db->where("username", $username);
				$query = $this->db->get($this->table);
				$row = $query->row_array();

				// we not need password to store in session
				unset($row['password']);
				$this->_data = $row;
				return ERR_NONE;
			}

			// password not match
			return ERR_INVALID_PASSWORD;
		} else {
			// not found
			return ERR_INVALID_USERNAME;
		}
	}

	public function get_data()
	{
		return $this->_data;
	}

	public function update_user_lastlogin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->where("username", $username);
		$query = $this->db->get($this->table);

		if ($query->num_rows()) {
			// found row by username	
			$row = $query->row_array();

			// now check for the password
			if ($row['password'] == md5($password)) {
				// we not need password to store in session
				unset($row['password']);
				$this->_data = $row;
				return ERR_NONE;
			}

			// password not match
			return ERR_INVALID_PASSWORD;
		} else {
			// not found
			return ERR_INVALID_USERNAME;
		}
	}

	public function retrieve_student_record($stu_id)
	{
		//echo '<h2>__METHOD__ = '. __METHOD__ .'</h2><h3>stu_id : '.$stu_id.'</h3>';
		$this->db->select('*');
		$this->db->from('user_student');
		$this->db->where('stu_id', $stu_id);
		//->order_by('group_chapter_permission.chapter_id')
		$this->db->join('class_schedule', 'class_schedule.group_id = user_student.stu_group');
		$this->db->join('user_supervisor', 'class_schedule.lecturer = user_supervisor.supervisor_id');
		//$this->db->join('department', 'department.dept_id = user_student.stu_dept_id');
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			echo "<h1>Cannot retrieve " . $stu_id . "<br/></h1>";
		$student_data = $query->first_row("array");
		$student_data['stu_dept_name'] = "วิศวกรรมศาสตร์";
		//echo "query: <pre>"; print_r($query); echo "</pre>";
		if ($student_data['stu_dept_id'] <= 0) {  //นักศึกษายัง ไม่บันทึก ภาควิชา ให้นำข้อมูลจาก class_schedule มาใช้
			$student_data['stu_dept_id'] = $student_data['department'];
		}

		$this->db->where('dept_id', $student_data['stu_dept_id']);
		$query = $this->db->get('department');
		$query = $query->first_row("array");
		$student_data['stu_dept_name'] = $query['dept_name'];



		/*
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2><h3>stu_id : '.$stu_id.'</h3>';
		echo "query: <pre>"; print_r($query); echo "</pre>";
		echo "student_data: <pre>"; print_r($student_data); echo "</pre>";
		*/
		return $student_data;
	}

	/* update information from user_student TABLE to SESSION
	*
	*
	*/
	public function update_student_profile()
	{
		$student_id = $_SESSION['stu_id'];
		//echo "<h2>".__FILE__." : ".$_SESSION['stu_id']."</h2>";
		//echo "<h2>".__METHOD__." : ".$_SESSION['stu_id']."</h2>";

		$this->db->where("stu_id", $student_id);
		$query = $this->db->get('user_student');
		$row = $query->first_row("array");
		if (empty($row)) {
			//echo "cannot find data new record to TABLE user_student";
			//add new record to TABLE user_student
			$data = array(
				'stu_id'			=> $_SESSION['stu_id'],
				'stu_gender'		=> 'other',
				'stu_firstname'		=> '',
				'stu_lastname'		=> '',
				'stu_nickname'		=> '',
				'stu_dob'			=> '',
				'stu_avatar'		=> '',
				'stu_email'			=> '',
				'stu_tel'			=> '',
				'stu_dept_id'		=> 16,  // 16 is others
				'stu_group'			=> '0',
				'note'				=> ''
			);

			$this->db->insert('user_student', $data);
			//echo $this->db->affected_rows();
			$this->db->where("stu_id", $student_id);
			$query = $this->db->get('user_student');
			$row = $query->first_row("array");
		}
		//udpate student profile to $_SESSION 
		$_SESSION['stu_id']			= $row['stu_id'];
		$_SESSION['stu_gender']		= $row['stu_gender'];
		$_SESSION['stu_firstname']	= $row['stu_firstname'];
		$_SESSION['stu_lastname']	= $row['stu_lastname'];
		$_SESSION['stu_nickname']	= $row['stu_nickname'];
		$_SESSION['stu_dob']		= $row['stu_dob'];
		$_SESSION['stu_avatar']		= $row['stu_avatar'];
		$_SESSION['stu_email']		= $row['stu_email'];
		$_SESSION['stu_tel']		= $row['stu_tel'];
		$_SESSION['stu_group']		= $row['stu_group'];
		//$_SESSION[note] = 


	} //update_student_profile()


	/*
	* update data from post to user_student table in database
	*/
	public function update_student_record()
	{
		//echo '<h3>__FILE__ = '. __FILE__ .'</h3>';
		//echo '<h3>__FILE__ = '. __METHOD__ .'</h3>';

		//echo '<pre>';		print_r($_POST);		echo '</pre>';
		//echo '<pre>';		print_r($_SESSION);		echo '</pre>';

		/*
		$data = array(
				'stu_id'			=> $_POST['stu_id'],
				'stu_gender'		=> $_POST['stu_gender'],
				'stu_firstname'		=> $_POST['stu_firstname'],
				'stu_lastname'		=> $_POST['stu_lastname'],
				'stu_nickname'		=> $_POST['stu_nickname'],
				'stu_dob'			=> $_POST['stu_dob'],
				'stu_avatar'		=> $_POST['stu_avatar'],
				'stu_email'			=> $_POST['stu_email'],
				'stu_tel'			=> $_POST['stu_tel'],
				'stu_department'	=> $_POST['stu_department'],
				'stu_group'			=> $_POST['stu_group'],
				'note'				=> ''				);*/
		//$this->db->set('stu_group', $_POST['stu_group']);
		$this->db->set('stu_gender', $_POST['stu_gender']);
		$this->db->set('stu_firstname', $_POST['stu_firstname']);
		$this->db->set('stu_lastname', $_POST['stu_lastname']);
		$this->db->set('stu_nickname', $_POST['stu_nickname']);
		$this->db->set('stu_dob', $_POST['stu_dob']);
		$this->db->set('stu_email', $_POST['stu_email']);
		$this->db->set('stu_tel', $_POST['stu_tel']);
		//$this->db->set('stu_department', $_POST['stu_department']);


		$this->db->where('stu_id', $_POST['stu_id']);
		$this->db->update('user_student');
		//echo $this->db->affected_rows();
		if (isset($_POST['password'])) {
			//echo "<h2> : Changing password ".$_POST['password']."</h2>";
			$this->update_student_password($_POST['stu_id']);
		}
	}

	public function get_student_password($student_id)
	{
		$this->db->where("username", $student_id);
		$query = $this->db->get('user');
		$row = $query->row_array();
		return $row['password'];
	}

	public function update_student_password($student_id, $new_password)
	{
		/*
		echo '<h3>__FILE__ = '. __FILE__ .'</h3>';
		echo '<h3>__METHOD__ = '. __METHOD__ .'</h3>';
		echo '<h3> student ID : '.$student_id." :   password : ".$new_password.'</h3>';
		*/
		//UPDATE `user` SET `password` = MD5('123') WHERE `user`.`id` = 59112233;
		$this->db->set("password", $new_password);
		$this->db->where("id", $student_id);
		$query = $this->db->update('user');

		//echo $this->db->affected_rows();

	}

	public function get_all_active_students()
	{
		$this->db->select('*');
		$this->db->from('user_student');
		$this->db - join('user', 'user.id = user_student.stu_id');
		$query = $this->db->get();
		echo $this->db->last_query() . "<br>";
		foreach ($query->result() as $row) {
			//echo "<pre> ".print_r($row)." </pre>";
		}
	}

	public function check_or_add_student_to_user($stu_id)
	{
		//echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		$this->db->where("id", $stu_id);
		$query = $this->db->get('user');
		if ($query->num_rows() >= 1) {
			//print_r($query->result_array());
			//echo $stu_id." have previously been added to 'user' table.<br>";
			return "cannot add";
		} else {
			//add new student to 'user' table
			$data = array(
				"id"		=> $stu_id,
				"username"	=> $stu_id,
				"password"	=> md5($stu_id),
				"role"		=> 'student',
				"active"	=> 'yes',
				"added_by"	=> $_SESSION['username']
			);
			$this->db->insert('user', $data);
			//echo "Insert : ".$data['id']." : num of row : ".$this->db->affected_rows();
			return "OK";
		}
	}

	public function check_or_add_student_to_user_student($student_data)
	{
		//echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		//print_r($student_data); echo "<br>";
		$table = 'user_student';

		// check first before add
		$this->db->where("stu_id", $student_data['stu_id']);
		$query = $this->db->get($table);
		if ($query->num_rows() >= 1) {
			//echo "Already exist : "; print_r($query->result_array());
			return "Already exist !!!";
		} else {
			//add new student to 'user' table

			$this->db->insert($table, $student_data);
			//echo "Insert : ".$student_data['stu_id']." : num of row : ".$this->db->affected_rows();
			return "OK";
		}
	}

	public function get_student_group($stu_group)
	{
		$table = 'user_student';
		$this->db->where('stu_group', $stu_group);
		$this->db->order_by('stu_id');
		$query = $this->db->get($table);
		//foreach($query->result() as $row) {
		//	echo "<pre> ".print_r($row)." </pre>";
		//}
		return $query->result_array();
	}

	public function get_max_student_marking($stu_id)
	{
		$table = 'exercise_submission';
		$this->db->where('stu_id', $stu_id);
		$query = $this->db->get($table);
	}

	public function student_reset_password($stu_id)
	{
		$this->update_student_password($stu_id, md5($stu_id));
	}


	public function get_student_submission_times($stu_id, $exercise_id)
	{
		$table = "exercise_submission";
		$this->db->where('stu_id', $stu_id);
		$this->db->where('exercise_id', $exercise_id);
		$query = $this->db->get($table);
		$query = $query->result_array();
		//echo __METHOD__," : ",sizeof($query),'<br>';
		return sizeof($query);
	}

	public function get_student_last_submission_record($stu_id, $exercise_id)
	{
		$table = "exercise_submission";
		$this->db->where('stu_id', $stu_id);
		$this->db->where('exercise_id', $exercise_id);
		$this->db->order_by('time_submit');
		$query = $this->db->get($table);
		$query = $query->last_row();

		return (array) $query;
	}

	public function get_exercise_from_student_assigned_chapter_item($stu_id, $chapter_id, $item_id)
	{
		$_table = 'student_assigned_chapter_item';
		$exercise_id = ''; //place holder

		$this->db->where("stu_id", $stu_id);
		$this->db->where("chapter_id", $chapter_id);
		$this->db->where("item_id", $item_id);
		$query = $this->db->get($_table);
		if ($query->num_rows() == 0) {
			$exercise_id = -1;
		} else {
			$query = (array) $query->first_row();
			$exercise_id = $query['exercise_id'];
		}

		return $exercise_id;
	}

	public function get_department_list()
	{
		$query = $this->db->get('department');
		$query = $query->result_array();
		return $query;
	}

	public function get_class_info($stu_id)
	{
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		// $this->show_to_console($_SESSION);
		// $this->show_to_console($stu_id);

		$this->db->select('*')
			->from('user_student')
			->join('user', 'user.id = user_student.stu_id')
			->join('class_schedule', 'class_schedule.group_id = user_student.stu_group')
			->where('stu_id', $stu_id);

		$query = $this->db->get();
		$query = $query->first_row('array');
		unset($query['password']);
		//$this->db->where('lecturer', $lecturer);	
		//$query = $this->db->get('class_schedule');

		// $this->show_to_console($query);
		$group_id = $query['group_id'];
		$this->db->select('*')
			->from('class_lab_staff')
			->join('class_schedule', 'class_schedule.group_id = class_lab_staff.class_id')
			->join('user_supervisor', 'user_supervisor.supervisor_id = class_lab_staff.staff_id')
			->where('group_id', $group_id);
		$staff = $this->db->get();
		$staff = $staff->result_array();
		//echo '<h3>$staff = </h3> <pre>'; print_r($staff); echo "</pre><br>";
		$query['staff'] = $staff;

		//echo '<h3>$query = </h3> <pre>'; print_r($query); echo "</pre><br>";


		return $query;
	}

	public function get_class_schedule()
	{

		$this->db->where('year', 2017);
		$this->db->where('semester', 1);
		$this->db->order_by('group_no');

		$query = $this->db->get('class_schedule');
		$query = $query->result_array();
		return $query;
	}


	public function show_to_console($arr = 'empty')
	{
		return;
		if ($arr == 'empty') {
			$x = json_encode($_SESSION);
		} else {
			$x = json_encode($arr);
		}

		echo '<script>';
		echo "console.log(" . $x . ") ;";
		echo '</script>';
	}

	public function get_student_record()
	{
		// return $_SESSION;
		$ci_sesion = $_SESSION['ci_session'];
		$stu_id = intVal($_SESSION['id']);
		$this->db->select('*');
		$this->db->where('stu_id', $stu_id);
		$result = $this->db->get('user_student');
		return $result->first_row('array');
	}
}//class Student_model