<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model_rest extends CI_Model
{

	private $table = "user_student";

	public function __construct()
	{
		parent::__construct();
	}

	public function get_student_assigned_exercise_id($stu_id, $chapter_id, $item_id)
	{
		$assigned_item_id = $this->db->select('*')
			->from('student_assigned_chapter_item')
			->where('stu_id', $stu_id)
			->where('chapter_id', $chapter_id)
			->where('item_id', $item_id)
			->get()
			->first_row('array');

		if (empty($assigned_item_id)) {
			return null;
		} else {
			return $assigned_item_id['exercise_id'];
		}
	}

	public function student_reset_password($stu_id)
	{
		$this->update_student_password($stu_id, md5($stu_id));
	}

	public function get_student_record($stu_id)
	{
		$student_record = $this->db->select('*')
			->from($this->table)
			->where('stu_id', $stu_id)
			->get()
			->first_row('array');

		return $student_record;
	}

	public function get_exercise_random_pool($group_id, $chapter_id, $item_id)
	{
		$exercise_random_pool = $this->db->select('*')
			->from('group_assigned_chapter_item')
			->where('group_id', $group_id)
			->where('chapter_id', $chapter_id)
			->where('item_id', $item_id)
			->get()
			->first_row('array');
		return $exercise_random_pool;
	}

	public function upsert_student_assigned_chapter_item($stu_id, $chapter_id, $item_id, $exercise_id)
	{
		$student_assigned_chapter_item = $this->db->select('*')
			->from('student_assigned_chapter_item')
			->where('stu_id', $stu_id)
			->where('chapter_id', $chapter_id)
			->where('item_id', $item_id)
			->get()
			->first_row('array');

		if (empty($student_assigned_chapter_item)) {
			$this->db->insert('student_assigned_chapter_item', [
				'stu_id' => $stu_id,
				'chapter_id' => $chapter_id,
				'item_id' => $item_id,
				'exercise_id' => $exercise_id,
				'full_mark' => 2,
				'marking' => 0,
				'added_date' => date('Y-m-d H:i:s'),
				'time_start' => date('Y-m-d H:i:s'),
				'time_end' => NULL,
			]);
		} else {
			$this->db->where('stu_id', $stu_id)
				->where('chapter_id', $chapter_id)
				->where('item_id', $item_id)
				->update('student_assigned_chapter_item', [
					'exercise_id' => $exercise_id
				]);
		}

		$student_assigned_chapter_item = $this->db->select('*')
			->from('student_assigned_chapter_item')
			->where('stu_id', $stu_id)
			->where('chapter_id', $chapter_id)
			->where('item_id', $item_id)
			->get()
			->first_row('array');

		return $student_assigned_chapter_item;
	}

	public function update_student_password($student_id, $new_password)
	{
		$this->db->set("password", $new_password);
		$this->db->where("id", $student_id);
		$query = $this->db->update('user');
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
		// $table = 'user_student';

		// check first before add
		$this->db->where("stu_id", $student_data['stu_id']);
		$query = $this->db->get($this->table); // Fix: Change 'this->table' to '$this->table'
		if ($query->num_rows() >= 1) {
			//echo "Already exist : "; print_r($query->result_array());
			return "Alreadyexist";
		} else {
			//add new student to 'user' table
			$this->db->insert($this->table, $student_data); // Fix: Change 'this->table' to '$this->table'
			//echo "Insert : " . $student_data['stu_id'] . " : num of row : " . $this->db->affected_rows();
			return "OK";
		}
	}

	public function update_student_group($stu_id, $group_id)
	{
		$this->db->set("stu_group", $group_id);
		$this->db->where("stu_id", $stu_id);
		$query = $this->db->update($this->table);
	}
}//class Student_model