<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model_rest extends CI_Model
{
  private $table = "user";
  private $_data = array();

  public function validate($username, $password)
  {
    $_SESSION['username'] = $username;

    $this->db->where("username", $username);
    $query = $this->db->get($this->table);

    if ($query->num_rows() <= 0) {
      // not found
      return ERR_INVALID_USERNAME;
    }
    // found row by username	
    $row = $query->row_array();

    // now check for the password
    if ($row['password'] != md5($password)) {
      // password not match
      return ERR_INVALID_PASSWORD;
    }

    if ($row['role'] == 'student') {
      $this->db->select('*')
        ->from('user_student')
        ->where('stu_id', $username)
        ->join('class_schedule', 'class_schedule.group_id=user_student.stu_group', 'left');
      $query = $this->db->get()->first_row("array");
      if ($query['allow_login'] == 'no')
        return ERR_CLASS_LOGIN_NOT_ALLOW;
    }




    if ($row['ci_session'] != 0) {
      // user didnot logout correctly			
      return ERR_UNMATCH_SESSION;
    }

    if ($row['status'] == "online") {
      // or user double login
      return ERR_REPEAT_LOGIN;
    }


    //update last login for user
    $this->db->set('last_login', date("Y-m-d H:i:s"));
    $this->db->set('last_seen', date("Y-m-d H:i:s"));
    $this->db->set('status', "online");
    $this->db->set('ci_session', $_SESSION['__ci_last_regenerate']);
    $this->db->set('session_id', session_id());
    $this->db->where('username', $username);
    $this->db->update($this->table);

    //retrieve data to make sure
    $this->db->where("username", $username);
    $query = $this->db->get($this->table);
    $row = $query->row_array();

    // we not need password to store in session
    unset($row['password']);
    $this->_data = $row;

    // get the user avatar and add it to the _data array
    $this->_data['avatar'] = $this->get_user_avatar($row);

    return ERR_NONE;
  }

  public function get_data()
  {
    return $this->_data;
  }

  public function check_session_id()
  {
    if (!isset($_SESSION['username'])) {
      return false;
    }

    $this->db->where("username", $_SESSION['username']);
    $query = $this->db->get($this->table);
    $row = $query->row_array();

    if ($row['session_id'] != session_id()) {
      return false;
    }

    return true;
  }

  public function get_user_avatar($row)
  {
    $id_keyword = [
      'supervisor' => 'supervisor_id',
      'student' => 'stu_id',
      'ta' => 'ta_id',
    ];

    $table = [
      'supervisor' => 'user_supervisor',
      'student' => 'user_student',
      'ta' => 'user_ta',
    ];

    $select = [
      'supervisor' => 'supervisor_avatar',
      'student' => 'stu_avatar',
      'ta' => 'ta_avatar',
    ];

    $avatar_folder = [
      'supervisor' => SUPERVISOR_AVATAR_FOLDER,
      'student' => STUDENT_AVATAR_FOLDER,
      'ta' => SUPERVISOR_AVATAR_FOLDER,
    ];

    $role = $row['role'];

    $this->db->select($select[$row["role"]])->from($table[$role])->where($id_keyword[$role], $row['id']);

    $query = $this->db->get()->first_row("array");

    $has_avatar = empty($query[$select[$role]]) ? false : true;

    if (!$has_avatar) {
      return null;
    }

    return $avatar_folder[$role] . $query[$select[$role]];
  }

  public function get_user_row()
  {
    $username = $_SESSION['username'];
    $this->db->where("username", $username);
    $query = $this->db->get($this->table);
    return $query->row_array();
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

  public function update_user_logout($user_id)
  {
    $this->db->where("id", $user_id);
    $query = $this->db->get($this->table);
    if (!is_null($query)) {
      //update user table to illustrated log out condition

      $this->db->set('last_seen', date("Y-m-d H:i:s"));
      $this->db->set('status', "offline");
      $this->db->set('ci_session', 0);
      $this->db->set('session_id', NULL);
      $this->db->where('id', $user_id);
      $this->db->update($this->table);

      return "";
    } else {
      return "User : " . $user_id . " not log out.";
    }
  }

  public function get_password()
  {
    $this->db->where("id", $_SESSION['id']);
    $query = $this->db->get('user');
    $row = $query->row_array();
    return $row['password'];
  }

  public function check_user_timeup()
  {
    $this->db->where("active", "yes");
    //$this->db->where("status", "online");
    $query = $this->db->get($this->table);
    echo '<br>';
    /*
		foreach ($query->result_array() as $row)
		{
			$row['status']="offline";
			print_r($row);
			printf("<br>");
			$id=$row['id'];
			$this->db->set('status', "offline");
			$this->db->set('active', "no");
			$this->db->where('id', $id);
			$this->db->update($this->table);
		}
		*/
  }

  public function search_for_timeup_users()
  {
    $this->db->where("active", "yes");
    $this->db->where("status", "online");
    $query = $this->db->get($this->table);
    $users_timeup = array();
    foreach ($query->result_array() as $row) {
      $users_timeup[] = $row;
    }
    return $users_timeup;
  }

  public function update_last_seen($user_id)
  {
    $this->db->set('last_seen', date("Y-m-d H:i:s"));

    $this->db->where('id', $user_id);
    $this->db->update($this->table);
  }

  public function get_online_users()
  {
    $this->db->select('*')
      ->from('user')
      ->where('status', 'online')
      ->order_by('id');
    //->join('lab_classinfo', 'lab_classinfo.chapter_id = group_chapter_permission.chapter_id'); 
    $query = $this->db->get();
    $query = $query->result_array();

    return $query;
  }

  public function verify_password($password)
  {
    $this->db->where("id", $_SESSION['id']);
    $query = $this->db->get($this->table);
    $row = $query->row_array();
    if ($row['password'] == md5($password)) {
      return true;
    } else {
      return false;
    }
  }
}
