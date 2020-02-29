<?php

class Online_course_m extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('Db_trans');
    }

    function get_online_courses($filter_array = null) {
        $this->db->select('c.*, cp.program_name, cp.slug program_slug');
        $this->db->from('product_online_course c');
        $this->db->join('course_programs cp', 'c.program_id = cp.program_id');
        if ($filter_array <> null)
            $this->db->where($filter_array);
        $this->db->order_by('course_name');

        $query = $this->db->get();
        //return $this->db->last_query();
        //return $query->row();
        return $this->db_trans->return_select($query);
    }
    
    function get_modules($filter_array = null) {
        $this->db->select('*');
        $this->db->from('product_oc_module');
        $this->db->join('product_online_course', "product_online_course.id = product_oc_module.oc_id");
        //$this->db->join('product_oc_video', "product_oc_video.id = product_oc_module.video_id");
        
        if ($filter_array <> null)
            $this->db->where($filter_array);
        //$this->db->order_by('entry_date','desc');

        $query = $this->db->get();
        //return $this->db->last_query();
        //return $query->row();
        return $this->db_trans->return_select($query);
    }
    
    function get_videos($filter_array = null) {
        $this->db->select('*');
        $this->db->from('product_oc_video');

        if ($filter_array <> null)
            $this->db->where($filter_array);
        $this->db->order_by('entry_date','desc');

        $query = $this->db->get();
        //return $this->db->last_query();
        //return $query->row();
        return $this->db_trans->return_select($query);
    }
    
    function get_oc_content($filter_array = null) {
        $this->db->select(' product_oc_items.id, product_id,video_id, article_id, title, filename, videoimage, duration, description, entry_date');
        $this->db->from('product_oc_items');
        $this->db->join('product_oc_video', 'product_oc_items.video_id = product_oc_video.id');
        
        if ($filter_array <> null)
            $this->db->where($filter_array);
        //$this->db->order_by('entry_date','desc');

        
        $query = $this->db->get();
        //return $this->db->last_query();
        //return $query->row();
        return $this->db_trans->return_select($query);
    }
    
    
    
    function get_category($filter_array=null) {
        $this->db->select('*');
    	$this->db->from('product_oc_category');
    	if($filter_array<>null)
    		$this->db->where($filter_array);
    	$this->db->order_by('name');

    	$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
    }
    
    function get_topic($filter_array=null) {
        $this->db->select('*');
    	$this->db->from('product_oc_topic');
    	if($filter_array<>null)
    		$this->db->where($filter_array);
    	$this->db->order_by('name');

    	$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
    }

    function save_oc_content($data) {
        //check if data exist
        $this->db->from('product_oc_items');
        $this->db->where('product_id', $data['product_id']); 
        $this->db->where('video_id', $data['video_id']); 
        $query = $this->db->get();
        
        if($query->num_rows() >0){ //update if data exist
            $this->db->where('product_id', $data['product_id']); 
            $this->db->where('video_id', $data['video_id']); 
            $this->db->update('product_oc_items', $data); 
            return ($this->db->affected_rows() > 0);
        }else{       //else insert
            $this->db->insert('product_oc_items',$data);
            return ($this->db->insert_id()>0);
        }
    }
    
    function delete_oc_content($id) {
        $this->db->where('id',$id);
        $this->db->delete('product_oc_items');
        return ($this->db->affected_rows() > 0);
    }
    
    function save_oc_module($data) {
        $this->db->insert('product_oc_module',$data);
        return ($this->db->insert_id()>0);
    }
    
    function delete_oc_module($id) {
        $this->db->where('id',$id);
        $this->db->delete('product_oc_module');
        return ($this->db->affected_rows() > 0);
    }
    
    function get_oc_price($filter_array=null) {
        $this->db->from('product_oc_price');
        if($filter_array<>null)
    		$this->db->where($filter_array);
        $query = $this->db->get();
        
        return $this->db_trans->return_select($query);
    }
    
    function save_oc_price($data) {
        //check if data exist
        $this->db->from('product_oc_price');
        $this->db->where('product_id', $data['product_id']); 
        $query = $this->db->get();
        
        if($query->num_rows() > 0){ //update if data exist
            $this->db->where('product_id', $data['product_id']); 
            $this->db->update('product_oc_price', $data); 
            return ($this->db->affected_rows() > 0);
        }else{       //else insert
            $this->db->insert('product_oc_price',$data);
            return ($this->db->insert_id());
        }
    }

}
