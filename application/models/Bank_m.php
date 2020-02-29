<?php

class Bank_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_bank_data($filter_by=null, $filter_value=null){
		$this->db->select('*');
		$this->db->from('bank_accounts');
		
		if($filter_by <> null)
			$this->db->where($filter_by, $filter_value);
		$this->db->order_by('bank_name');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_bank_by_id($id){
		$this->db->select('*');
		$this->db->from('bank_accounts');
		$this->db->where('bank_id', $id);
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}
}