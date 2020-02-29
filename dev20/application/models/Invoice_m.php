<?php

class Invoice_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_invoices($filter_array=null){
		$this->db->select('i.*, u.*');
		$this->db->from('invoices i');
		$this->db->join('users u', 'i.user_id = u.user_id');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('i.due_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_invoice_by_id($invoice_id){
		$this->db->from('invoices');
		$this->db->where('invoice_id', $invoice_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_invoice_by_ref_id($reference_id){
		$this->db->from('invoices');
		$this->db->where('reference_id', $reference_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_all_invoice($filter=null){
		$this->db->select('i.invoice_id, i.grand_total, i.due_date, i.status, i.entry_date, ce.*, cs.course_name, u.first_name, u.last_name, ui.*');
		$this->db->from('invoices i');
		$this->db->join('course_enrollment ce', 'i.enroll_id = ce.enroll_id');
		$this->db->join('courses cs', 'ce.course_id = cs.id');
		$this->db->join('users u', 'ce.student_id = u.user_id'); // get student info
		$this->db->join('user_info_data ui', 'ui.user_id = u.user_id'); // get student info
		if($filter<>null)
			$this->db->where($filter);
		$this->db->order_by('i.due_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function view_customer_payment(){
		$this->db->select('a.*, b.*, i.total, i.status as invoice_status');
		$this->db->from('payment_transfer a');
		$this->db->join('bank_accounts b', 'a.bank_dest_id=b.bank_id');
		$this->db->join('invoices i', 'a.referrence_id = i.invoice_id', 'left');
		$this->db->order_by('a.payment_id desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		return $this->db_trans->return_select($query);
	}

	function insert_new_invoice($data){
		$insert = $this->db->insert('invoices', $data);
		if($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function get_invoice_by_third_party_id($id){
		$this->db->from('invoices');
		$this->db->where('third_party_id', $invoice_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_invoice_by_many_status($status_array){
		$this->db->select('*');
		$this->db->from('invoices i');
		$this->db->join('users u', 'i.user_id = u.user_id');
		$this->db->where('i.status', $status_array[0]);
		if(sizeof($status_array)>1)
			for($i=1; $i<sizeof($status_array); $i++)
				$this->db->or_where('i.status', $status_array[$i]);
		$this->db->order_by('i.due_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}
}


?>