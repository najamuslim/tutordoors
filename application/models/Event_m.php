<?php

class Event_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_event_data($filter_by=null, $filter_value=null){
		$this->db->select('*');
		$this->db->from('events');
		if($filter_by <> null)
			$this->db->where($filter_by, $filter_value);

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_applicants($filter_by=null, $filter_value=null){
		$this->db->select('*');
		$this->db->from('jobfair_applicants');
		if($filter_by <> null)
			$this->db->where($filter_by, $filter_value);
		$this->db->order_by('applicant_id');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}
}