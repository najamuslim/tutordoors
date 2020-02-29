<?php

class Commerce_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }

    function get_discount_info($post_id, $qty){
    	$this->db->select('*');
    	$this->db->from('product_discounts');
        $this->db->where('on_quantity <>', '0');
        $this->db->where('on_quantity <=', $qty);
        $this->db->where('discount <>', '0');
        $this->db->where('post_id', $post_id);
    	$this->db->order_by('on_quantity desc');

    	$query = $this->db->get();
		
		return $this->db_trans->return_select($query);	
    }

    function get_all_shipping_cost(){
        $this->db->select('*');
        $this->db->from('shipping_costs');
        $this->db->order_by('company, cost_per_kg');

        $query = $this->db->get();
        
        return $this->db_trans->return_select($query);  
    }

    function get_shipping_city(){
        $this->db->select('id, destination');
        $this->db->from('shipping_costs');
        $this->db->order_by('destination');

        $query = $this->db->get();
        
        return $this->db_trans->return_select($query);  
    }

    function get_ship_cost_by_id($id){
        $this->db->select('*');
        $this->db->from('shipping_costs');
        $this->db->where('id', $id);

        $query = $this->db->get();
        
        return $this->db_trans->return_select_first_row($query);
    }

    function check_coupon_status($code){
        $this->db->select('*');
        $this->db->from('coupon_codes');
        $this->db->where('coupon_code', $code);

        $query = $this->db->get();
        
        return $this->db_trans->return_select_first_row($query);  
    }

    function is_user_ever_take_coupon($coupon_code, $user_id){
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('coupon_taken', $coupon_code);
        $this->db->where('user_id', $user_id);

        $query = $this->db->get();

        if($query->num_rows() > 0)
            return true; // he ever used the coupon, then reject
        else
            return false; // he never used the coupon, then accept
    }

    function get_not_running_status_between_time($datetime){
        $query = $this->db->query('
            SELECT * FROM coupon_codes 
            WHERE "'.$datetime.'" BETWEEN start_time and end_time 
            AND (status = "Created" or status="Completed")
            ORDER BY start_time desc');

        if($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    function get_running_status_over($datetime){
        $query = $this->db->query('
            SELECT * FROM coupon_codes 
            WHERE "'.$datetime.'" > end_time 
            AND status = "Running"
            ORDER BY start_time desc');

        if($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

}