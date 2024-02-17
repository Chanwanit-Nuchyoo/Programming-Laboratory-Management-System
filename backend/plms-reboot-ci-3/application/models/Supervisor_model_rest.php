<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Supervisor_model_rest extends CI_Model
{

	private $table = "user_supervisor";
	private $_data = array();

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		//echo "model constructor : ".__FILE__." <br>";

	}

	/*
	*	Update information from user_supervisor table
	*	if supervisor not exits create a new one
	*
	*/
	public function update_supervisor_profile()
	{
		$supervisor_id = $_SESSION['id'];
		$this->db->where("supervisor_id", $supervisor_id);
		$query = $this->db->get($this->table);
		if ($query->num_rows()) {

			//echo "Available : ".$username;  update data from table to $_SESSION			

		} else {
			//echo "NOT available : ".$username;
			// username does not availble , so create new record
			$data = array(
				'supervisor_id'			=> $_SESSION['id'],
				'supervisor_gender'		=> 'other',
				'supervisor_firstname'	=> '',
				'supervisor_lastname'	=> '',
				'supervisor_nickname'	=> '',
				'supervisor_dob'		=> '',
				'supervisor_avatar'		=> '',
				'supervisor_email'		=> '',
				'supervisor_tel'		=> '',
			);

			$this->db->insert('user_supervisor', $data);
			//query again after insert
			$supervisor_id = $_SESSION['id'];
			$this->db->where("supervisor_id", $supervisor_id);
			$query = $this->db->get($this->table);
		}
		//echo '<script> alert("$username does not exit"); </script>';
		$row = $query->row_array();
		$_SESSION['supervisor_id']			= $row['supervisor_id'];
		$_SESSION['supervisor_department']	= $row['supervisor_department'];
		$_SESSION['supervisor_gender']		= $row['supervisor_gender'];
		$_SESSION['supervisor_firstname']	= $row['supervisor_firstname'];
		$_SESSION['supervisor_lastname']	= $row['supervisor_lastname'];
		$_SESSION['supervisor_nickname']	= $row['supervisor_nickname'];
		//$_SESSION['supervisor_dob']			= $row['supervisor_dob'];
		$_SESSION['supervisor_email']		= $row['supervisor_email'];
		//$_SESSION['supervisor_tel']			= $row['supervisor_tel'];
		$_SESSION['supervisor_avatar']			= $row['supervisor_avatar'];
	} //public function update_supervisor_profile()


	public function get_data()
	{
		return $this->_data;
	}

	public function get_supervisor_fullname_by_id($supervisor_id)
	{
		$this->db->select('supervisor_firstname, supervisor_lastname')
			->where('supervisor_id', $supervisor_id);
		$query = $this->db->get($this->table);
		$query = $query->first_row("array");
		return $query['supervisor_firstname'] . " " . $query['supervisor_lastname'];
	}

	public function get_supervisor_data()
	{
		$supervisor_id = $_SESSION['id'];
		/*$this->db->where('supervisor_id',$supervisor_id );
		$query = $this->db->get('user_supervisor');
		$query = $query->first_row("array");
		*/
		$this->db->select('*')
			->from('user_supervisor')
			->join('user', 'user.id = user_supervisor.supervisor_id')

			->where('supervisor_id', $supervisor_id);
		$query = $this->db->get();
		$query = $query->first_row("array");
		return $query;
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





	/*
	* update data from post to user_student table in database
	*	NOT for password
	*/
	public function update_supervisor_record($supervisor_record)
	{


		/*
		$this->db->set('supervisor_gender', $_POST['supervisor_gender']);
		$this->db->set('supervisor_firstname', $_POST['supervisor_firstname']);
		$this->db->set('supervisor_lastname', $_POST['supervisor_lastname']);
		$this->db->set('supervisor_nickname', $_POST['supervisor_nickname']);
		$this->db->set('supervisor_dob', $_POST['supervisor_dob']);
		$this->db->set('supervisor_email', $_POST['supervisor_email']);
		$this->db->set('supervisor_tel', $_POST['supervisor_tel']);
		$this->db->set('supervisor_department', $_POST['supervisor_department']);
		*/
		$supervisor_id = $_SESSION['id'];



		$this->db->set($supervisor_record);
		$this->db->where('supervisor_id', $supervisor_id);
		$this->db->update('user_supervisor');
		//echo $this->db->affected_rows();

	}



	/*
	*	update password ONLY
	*/
	public function update_supervisor_password($new_password)
	{
		/*
		echo '<h3>__FILE__ = '. __FILE__ .'</h3>';
		echo '<h3>__METHOD__ = '. __METHOD__ .'</h3>';
		echo '<h3> student ID : '.$student_id." :   password : ".$new_password.'</h3>';
		*/
		//UPDATE `user` SET `password` = MD5('123') WHERE `user`.`id` = 59112233;
		$this->db->set("password", $new_password);
		$this->db->where("id", $_SESSION['id']);
		$query = $this->db->update('user');

		//echo $this->db->affected_rows();

	}

	/*
	*	user_supervisor only keeps filename
	*/
	public function update_image($saved_filename)
	{
		$this->db->set('supervisor_avatar', $saved_filename);
		$this->db->where('supervisor_id', $_SESSION['id']);
		$this->db->update('user_supervisor');
	}

	public function get_password()
	{
		$this->db->where("id", $_SESSION['id']);
		$query = $this->db->get('user');
		$row = $query->row_array();
		return $row['password'];
	}

	public function get_class_schedule()
	{
		$semester = array(1, 2);
		$this->db->where_in('semester', $semester);
		$query = $this->db->get('class_schedule');
		return $query->result_array();
	}


	// 2565-10-04 kanut
	public function update_midscore($id, $score)
	{

		$this->db->where("stu_id", $id);
		$this->db->set("mid_score", $score);
		$this->db->update('user_student');
	}

	//2565-11-3
	public function get_all_student_data($chapter)
	{
		$query = $this->db->query(
			"SELECT T1.stu_id, T1.chapter_id, T1.exercise_id, SUM(T2.max_marking) AS Quiz1
		FROM student_assigned_chapter_item T1 
			LEFT JOIN
				(SELECT stu_id, exercise_id, MAX(marking) AS max_marking 
				 FROM exercise_submission
				 GROUP BY stu_id, exercise_id) T2
				 
				on T1.stu_id=T2.stu_id AND T1.exercise_id=T2.exercise_id
		WHERE chapter_id=$chapter
		GROUP BY stu_id, chapter_id
		ORDER BY stu_id, chapter_id"
		);

		return $query->result_array();
	}
}//class Supervisor_model