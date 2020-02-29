<?php

class Software_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_software_updates($filter_array=null){
		$this->db->select('*');
		$this->db->from('software_version_logs');
		
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('release_date desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_latest_version($name){
		$this->db->select('*')
					->from('software_version_logs')
					->where('software_name', $name)
					->order_by('release_date desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}
}