<?php

class Media_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_media_data($filter=null){
		$this->db->select('*');
		$this->db->from('media_files');
		
		if($filter <> null)
			$this->db->where($filter);
		$this->db->order_by('id');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_file_name($id){
		$this->db->select('*');
		$this->db->from('media_files');
		
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
			return $query->row()->file_name;
		else
			return '';
	}
}