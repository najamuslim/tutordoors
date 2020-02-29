<?php

class User_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_user_data($filter=null){
		$this->db->select('*');
		$this->db->from('users');
		
		if($filter <> null)
			$this->db->where($filter);
		$this->db->order_by('first_name');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_user_info($user_id){
		$this->db->select('u.user_id as key_user_id, u.*, ui.*, m.*');
		$this->db->from('users u');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id','left' );
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where('u.user_id', $user_id);

		$query = $this->db->get();

		return $this->db_trans->return_select_first_row($query);
	}

	function get_user_info_data($user_id){
		$this->db->select('*');
		$this->db->from('user_info_data ui');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where('ui.user_id', $user_id);

		$query = $this->db->get();

		return $this->db_trans->return_select_first_row($query);
	}

	function get_user_by_id($userid){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id', $userid);
		
		$query = $this->db->get();

		return $this->db_trans->return_select_first_row($query);
	}

	function check_user_id_exist($userid){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id', $userid);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return true;
		else return false;
	}

	function check_user_email_exist($email){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email_login', $email);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return true;
		else return false;
	}

	function check_exist_user($email, $pass=null){
		$this->db->select('*');
		$this->db->from('users');
		if($pass==null)
			$this->db->where('email_login', $email);
		else
			$this->db->where("email_login ='".$email."' AND password = md5('".$pass."')");

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row();
		else return false;
	}

	function update_password($email, $new_pass){
		$this->db->where('email_login', $email);
		$this->db->update('users', array('password' => md5($new_pass)));
		if($this->db->affected_rows() > 0)
			return true;
		else{
			$error = $this->db->error();
			if($error['code']<>0)
				return $error['message'];
		}
	}

	function get_reset_password($user_id){
		$this->db->select('password_generated');
		$this->db->from('request_reset_password');
		$this->db->where('user_id', $user_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row();
		else return false;
	}

	function increment_total_user_viewed($user_id){
		$query = $this->db->query("UPDATE user_info_data SET total_viewed = total_viewed + 1 WHERE user_id = '".$user_id."'");

		return true;
	}

	function count_user_level($level){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_level', $level);

		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_user_bank($user_id){
		$this->db->select('*');
		$this->db->from('user_bank_account');
		$this->db->where('user_id', $user_id);

		$query = $this->db->get();

		return $this->db_trans->return_select_first_row($query);
	}

	function get_education_history_by_userid($user_id){
		$this->db->select('e.*, ma.file_name certificate_filename, mb.file_name transcript_filename');
		$this->db->from('user_education_experiences e');
		$this->db->join('media_files ma', 'e.certificate_media_id = ma.id', 'left');
		$this->db->join('media_files mb', 'e.transcript_media_id = mb.id', 'left');
		$this->db->where('user_id', $user_id);
		$this->db->order_by('date_in desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		return $this->db_trans->return_select($query);
	}

	function get_education_history_by_id($edu_id){
		$this->db->select('e.*, ma.file_name certificate_filename, mb.file_name transcript_filename');
		$this->db->from('user_education_experiences e');
		$this->db->join('media_files ma', 'e.certificate_media_id = ma.id', 'left');
		$this->db->join('media_files mb', 'e.transcript_media_id = mb.id', 'left');
		$this->db->where('e.id', $edu_id);

		$query = $this->db->get();
		// print_r($this->db->last_query());
		return $this->db_trans->return_select_first_row($query);
	}

	function get_salary_per_hour($user_id){
		$this->db->select('salary_per_hour');
		$this->db->from('user_info_data');
		$this->db->where('user_id', $user_id);

		$query = $this->db->get();
		// print_r($this->db->last_query());

		return $query->row()->salary_per_hour;
	}

	function get_user_by_level($level){
		$this->db->where('user_level', $level);
		$this->db->order_by('first_name');
		
		$query = $this->db->get('users');
		
		return $this->db_trans->return_select($query);
	}

	function search_user_autocomplete($term){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('(user_id LIKE "%'.$term.'%" OR first_name LIKE "%'.$term.'%" OR last_name LIKE "%'.$term.'%" OR email_login LIKE "%'.$term.'%")');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function search_tutor($term){
		$this->db->select('*');
		$this->db->from('users');
		// $this->db->like('user_id', $term);
		$this->db->where('user_level', 'teacher');
		$this->db->where('(user_id LIKE "%'.$term.'%" OR first_name LIKE "%'.$term.'%" OR last_name LIKE "%'.$term.'%" OR email_login LIKE "%'.$term.'%")');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_subscribers($filter_array=null){
		$this->db->select('n.*, u.email_login, u.first_name, u.last_name');
		$this->db->from('newsletter_subscriber n');
		$this->db->join('users u', 'n.related_user = u.user_id', 'left');
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('id desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function count_snapshot($user_id){
		$this->db->select('*')
				->from('snapshot_user_view')
				->where('user_id', $user_id);
		$get = $this->db->get();

		return $get->num_rows();
	}
}