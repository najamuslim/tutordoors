<?php

class Student_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }

    function get_schedule($student_id){
		$this->db->select('o.*, ce.enroll_id, c.city_name, concat(ua.first_name, " ", ua.last_name) as student_name,
 			concat(ub.first_name, " ", ub.last_name) as teacher_name, uia.phone_1 as student_phone, uib.phone_1 as teacher_phone', FALSE);
		$this->db->from('orders o');
		$this->db->join('course_enrollment ce', 'o.order_id = ce.order_id');
		$this->db->join('cities c', 'o.city_id = c.city_id');
		$this->db->join('users ua', 'o.student_id = ua.user_id');
		$this->db->join('user_info_data uia', 'ua.user_id = uia.user_id');
		$this->db->join('users ub', 'o.teacher_id = ub.user_id');
		$this->db->join('user_info_data uib', 'ub.user_id = uib.user_id');
		$this->db->where('order_status', 'Accept');
		$this->db->where('student_id', $student_id);
		$this->db->order_by('entry_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_unverified(){
		$this->db->select('u.user_id, u.email_login, u.first_name, u.last_name, u.join_date, ui.phone_1, m.file_name');
		$this->db->from('users u');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id', 'left');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where('u.verified_user', '0');
		$this->db->where('u.user_level', 'student');
		$this->db->order_by('u.join_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_verified(){
		$this->db->select('u.user_id, u.email_login, u.first_name, u.last_name, u.join_date, ui.phone_1, m.file_name');
		$this->db->from('users u'); 
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id', 'left');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where('u.verified_user', '1');
		$this->db->where('u.user_level', 'student');
		$this->db->order_by('u.join_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}
}