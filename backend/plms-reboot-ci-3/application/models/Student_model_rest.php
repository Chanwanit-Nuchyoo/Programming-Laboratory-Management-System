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
}//class Student_model