<?php

class Mailbox_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_mail_by_id($id){
		$this->db->select('*');
		$this->db->from('mailbox');
		$this->db->where('id', $id);
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_mail_data($user_id, $box, $limit_start=null, $limit_end=10){
		$this->db->select('m.*, b.first_name as sender_fn, b.last_name as sender_ln, c.first_name as receiver_fn, c.last_name as receiver_ln');
		$this->db->from('mailbox m');
		$this->db->join('users b', 'm.sender=b.user_id', 'left');
		$this->db->join('users c', 'm.destination=c.user_id', 'left');
		if($box=="inbox"){
			$this->db->like('destination', $user_id);
			$this->db->where('status', 'Sent');
		}
		else if($box=="outbox"){
			$this->db->where('sender', $user_id);
			$this->db->where('status', 'Sent');
		}
		else if($box=="draft"){
			$this->db->where('sender', $user_id);
			$this->db->where('status', 'Draft');
		}
		else if($box=="trash"){
			$this->db->where('trashed_by', $user_id);
			$this->db->where('status', 'Trash');
		}
		$this->db->order_by('sent_timestamp desc');
		if($limit_start<>null)
			$this->db->limit($limit_end, $limit_start);
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_outbox_data($user_id){
		$this->db->select('*');
		$this->db->from('mailbox');
		$this->db->order_by('sent_timestamp desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_draft_data($user_id){
		$this->db->select('*');
		$this->db->from('mailbox');
		
		$this->db->order_by('sent_timestamp desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}
}