<?php

class Live_chat_m extends CI_Model {

	private $kunci = 'B4rm4ng4n';

	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');	
    }
	
	function insert_new_chat($session_id, $text, $sender){
		$this->db->set('session_id', $session_id);
		$this->db->set('has_been_retrieved', '0');
		$this->db->set('sender', $sender);
		$this->db->set('chat_text', 'aes_encrypt("'.$text.'", "'.$this->kunci.'")', false);
		$this->db->insert('live_chats');
		$error = $this->db->error();
		$result = new stdclass();
		if ($this->db->affected_rows() > 0 or $error['code']==0){
			$result->status = true;
			$result->output = $this->db->insert_id();
		}
		else{
			$result->status = false;
			$result->output = $error['code'].': '.$error['message'];
		}

		return $result;
	}

	function get_chat($chat_id){
		$this->db->select('aes_decrypt(chat_text, "'.$this->kunci.'") as the_text, timestamp', false);
		$this->db->from('live_chats');
		$this->db->where('chat_id', $chat_id);

		$query = $this->db->get();

		return $query->row();
	}

	function get_active_sessions(){
		$this->db->select('*');
		$this->db->from('live_chat_sessions');
		$this->db->where('is_active', '1');
		$this->db->order_by('timestamp');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_chats_by_session_id($session_id, $is_retrieved=null, $sender=null){
		$this->db->select('*, aes_decrypt(chat_text, "'.$this->kunci.'") as the_text', false);
		$this->db->from('live_chats');
		$this->db->where('session_id', $session_id);
		if($is_retrieved<>null)
			$this->db->where('has_been_retrieved', $is_retrieved);
		if($sender<>null)
			$this->db->where('sender', $sender);
		$this->db->order_by('timestamp');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_all_user_chats_not_retrieved(){
		$this->db->select('*, aes_decrypt(chat_text, "'.$this->kunci.'") as the_text', false);
		$this->db->from('live_chats');
		$this->db->where('has_been_retrieved', '0');
		$this->db->where('sender', 'user');
		$this->db->order_by('timestamp');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

}