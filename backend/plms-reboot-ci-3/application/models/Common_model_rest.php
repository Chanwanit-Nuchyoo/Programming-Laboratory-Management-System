<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model_rest extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public $prefix  = array(
    'student' => 'stu',
    'supervisor' => 'supervisor',
    'ta' => 'ta',
  );

  public function get_breadcrumbs($params, $mapping)
  {
    $data = array();

    foreach ($params as $key => $value) {
      if (isset($mapping[$key])) {
        $result = $this->db->get_where($mapping[$key]['table'], array($key => $value))->row();
        $data[$mapping[$key]['column']] = $result ? $result->{$mapping[$key]['column']} : NULL;
      }
    }

    return $data;
  }

  public function get_profile_form_data()
  {
    $user_id = $this->session->userdata('id');
    $user_role = $this->session->userdata('role');

    return $this->db->get_where('user_' . $user_role, array($this->prefix[$user_role] . "_id" => $user_id))->row_array();
  }

  public function get_all_department()
  {
    $department = $this->db->select('*')->from('department')->get()->result_array();
    return $department;
  }

  public function updateProfile($role, $data)
  {
    $this->db->where($this->prefix[$role] . '_id', $this->session->userdata('id'));
    $this->db->update('user_' . $role, $data);

    // Update session
    foreach ($data as $key => $value) {
      $this->session->set_userdata($key, $value);
    }

    return $this->db->affected_rows();
  }
}
