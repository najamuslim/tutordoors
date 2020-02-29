<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Invoice_m');
	}
	
	/* Page Start */	
	function index(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'payment-invoice',
			'title_page' => 'Invoice List'
			);

		$data['invoices'] = $this->Invoice_m->get_invoices();

		$this->open_admin_page('admin/invoice', $data);
	}

	function view($id){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'payment-invoice',
			'title_page' => 'Invoice List'
			);

		$data['invoices'] = $this->Invoice_m->get_invoices();

		$this->open_admin_page('admin/invoice', $data);
	}

	function create(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'payment-invoice',
			'title_page' => 'Create Invoice',
			'title' => 'add'
			);
		
		$data['users'] = $this->User_m->get_user_data(array('user_level'=>'student'));

		$this->open_admin_page('admin/invoice_creation', $data);
	}

	function edit($invoice_id){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'payment-invoice',
			'title_page' => 'Edit Invoice',
			'title' => 'edit'
			);
		
		$data['users'] = $this->User_m->get_user_data(array('user_level'=>'student'));

		$data['invoice'] = $this->Invoice_m->get_invoice_by_id($invoice_id);

		$this->open_admin_page('admin/invoice_creation', $data);
	}

	public function view_payment(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'payment-transfer-confirmation',
			'title_page' => 'Customer Payment Confirmation'
			);


		$data['payments'] = $this->Invoice_m->view_customer_payment();

		$this->open_admin_page('admin/payment_view_all', $data);
	}

	/* Page End */

	/* Function Start */

	function add(){
		$data = array(
			'invoice_id' => $this->input->post('id', true),
			'reference_table' => $this->input->post('reference_table', true),
			'reference_id' => $this->input->post('reference_id', true),
			'user_id' => $this->input->post('user', true),
			'due_date' => $this->input->post('due-date', true),
			'total' => $this->input->post('total', true),
			'status' => 'Open',
			'entry_user' => $this->session->userdata('userid')
			);

		
		$add = $this->Common->add_to_table('invoices', $data);
		$this->set_session_response_no_redirect('add', $add);

		// give notification to student 
        $this->load->library('notification');
        $notif = array(
        	'category' => 'new_invoice',
        	'title' => 'Invoice Kursus',
        	'content' => $this->lang->line('notification_invoice_create').date_format(new DateTime($this->input->post('due-date', true)), 'd M Y H:i:s').' .',
        	'sender_id' => 'admin', // admin
        	'receiver_id' => $this->input->post('user', true) // student ID
        	);
        $this->notification->insert($notif);

		redirect('invoice');
	}

	function update(){
		$data = array(
			'user_id' => $this->input->post('user', true),
			'due_date' => $this->input->post('due-date', true),
			'total' => $this->input->post('total', true),
			'entry_user' => $this->session->userdata('userid')
			);

		$upd = $this->Common->update_data_on_table('invoices', 'invoice_id', $this->input->post('id', true), $data);
		$this->set_session_response_no_redirect('update', $upd);

		redirect('invoice');
	}

	public function change_payment_status(){
		$payment_id = $this->input->get('id', TRUE);
		$ref_id = $this->input->get('refid', TRUE);
		$status = $this->input->get('status', TRUE);

		// update status into table payment_transfer
		$data = array('status' => $status);
		$update = $this->Common->update_data_on_table('payment_transfer', 'payment_id', $payment_id, $data);

		// update status into table invoices only if it paid
		if($status=="Validated"){
			$data = array('status' => 'Paid');
			$update = $this->Common->update_data_on_table('invoices', 'invoice_id', $ref_id, $data);
		}

		if($update)
			$response['status'] = "200";
		else
			$response['status'] = "204";

		echo json_encode($response);
	}

	function get_data_by_status(){
		$this->check_user_access();
		$get = $this->Invoice_m->get_invoice_by_many_status($this->input->post('status'));
		
		$response = array();
		if($get<>false)
			foreach($get->result() as $row){
				$response[] = array(
					'id' => $row->invoice_id,
					'user_name' => $row->first_name.' '.$row->last_name,
					'reference_id' => $row->reference_id,
					'type' => ucwords($row->reference_table),
					'role' => $row->user_level,
					'nominal' => 'IDR '.number_format($row->total, 0, ',', '.'),
					'due_date' => date_format(new DateTime($row->due_date), 'd M Y H:i:s'),
					'status' => $row->status
					);
			}

		echo json_encode($response);
	}
	
	function change_method(){
		$invoice_info = $this->Invoice_m->get_invoice_by_id($this->input->get('inv', true));
		$total = $invoice_info->total;
		$admin_fee = 0;
		if($this->input->get('method', true)=="veritrans"){
			$get_opt = $this->Content_m->get_option_by_param('veritrans_admin_fee');
			$admin_fee = ($get_opt->parameter_value / 100) * $total;
			$grand_total = $total + $admin_fee;
		}
		else // bca & paypal
			$grand_total = $total;

		$response = array(
			'admin_fee' => number_format($admin_fee, 0, ',', '.'),
			'total' => number_format($grand_total, 0, ',', '.')
			);

		echo json_encode($response);
	}	
}