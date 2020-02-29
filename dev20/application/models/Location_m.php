<?php

class Location_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_province($filter_array=null){
		$this->db->select('*');
		$this->db->from('provinces');
		
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('province_name');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_city($filter_array=null){
		$this->db->select('*, c.user_identifier as city_user_identifier');
		$this->db->from('cities c');
		$this->db->join('provinces p', 'c.province_id = p.province_id');
		
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('p.province_id, c.user_identifier');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_user_identifier($by, $id){
		$this->db->select('user_identifier');
		if($by=="city"){
			$this->db->from('cities');
			$this->db->where('city_id', $id);
		}
		else if($by=="province"){
			$this->db->from('provinces');
			$this->db->where('province_id', $id);
		}
		$query = $this->db->get();
		return $query->row()->user_identifier;
	}
}