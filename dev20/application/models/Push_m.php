<?php

class Push_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_active_token($user_id){
		$this->db->select('*');
		$this->db->from('push_notif_tokens');
		$this->db->where('user_id', $user_id);
		$this->db->where('is_active', 'true');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function check_if_exist($user_id, $token){
		$this->db->select('*');
		$this->db->from('push_notif_tokens');
		$this->db->where('user_id', $user_id);
		$this->db->where('token', $token);

		$query = $this->db->get();

		return $this->db_trans->return_select_first_row($query);
	}
}