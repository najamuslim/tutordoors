<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Veritrans extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->config->load('veritrans');
        $params = array('server_key' => $this->config->item('server_key'), 'production' => true);
        // $params = array('server_key' => $this->config->item('server_key'), 'production' => false);
		$this->load->library('veritrans_lib');
		$this->veritrans_lib->config($params);
		$this->load->helper('url');
		$this->load->model('Invoice_m');
    }

	public function index()
	{
		$this->load->view('veritrans/checkout_vtweb');
	}

	function setup(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'setup-veritrans',
			'title_page' => 'Setup Veritrans'
			);

		$get_options = $this->Content_m->get_all_options();
		foreach($get_options->result() as $param){
			$options[$param->parameter_name]['desc'] = $param->description;
			$options[$param->parameter_name]['value'] = $param->parameter_value;
		}
		$data['options'] = $options;
		$data['controller'] = 'veritrans';

		$this->open_admin_page('admin/base_setup/one_group', $data);
	}

	function save_config(){
		foreach($this->input->post() as $key => $input){
			$upd = $this->Common->update_data_on_table('options', 'parameter_name', $key, array('parameter_value' => $input));
			$this->push_if_transaction_error($upd);
		}

		$this->set_session_response_no_redirect_by_error('update');
		redirect('veritrans/setup');
	}

	public function vtweb_checkout()
	{
		$invoice_id = $this->input->get('inv', true);
		// get invoice info
		$invoice_info = $this->Invoice_m->get_invoice_by_id($invoice_id);

		// fetch the order courses
		$order_courses = $this->Order_m->get_accepted_order_courses($invoice_info->reference_id);
		if($order_courses<>false){
			$total_price = 0;
			foreach($order_courses->result() as $item){
				// get info of the course
				$course_info = $this->Course_m->get_courses(array('c.id' => $item->course_id));
				
				$items[] = array(
					'id' => 'course_id_'.$item->course_id,
					'price' => intval($item->total_price),
					'quantity' => 1,
					'name' => $course_info->row()->program_name.' - '.$course_info->row()->course_name,
					);
				$total_price += intval($item->total_price);
			}
		}
		// add admin fee
		// get the admin fee
		$get_opt = $this->Content_m->get_option_by_param('veritrans_admin_fee');
		$admin_fee_value = ($get_opt->parameter_value / 100) * $total_price;
		$order_info = $this->Order_m->get_order_by_id($invoice_info->reference_id);

		$admin_fee = array(
			'id' => 'admin_fee',
			'price' => $admin_fee_value,
			'quantity' => 1,
			'name' => 'Admin Fee'
			);
		array_push($items, $admin_fee);
		

		$transaction_details = array(
			// 'order_id' => $invoice_info->reference_id,
			'order_id' => uniqid(),
			'gross_amount' => intval($invoice_info->total) + $admin_fee_value
		);

		// Populate customer's Info
		$customer_info = $this->User_m->get_user_info($invoice_info->user_id);
		$customer_details = array(
			'first_name' => $customer_info->first_name,
			'last_name' => $customer_info->last_name,
			'email' => $customer_info->email_login,
			'phone' => $customer_info->phone_1
			);

		// Data yang akan dikirim untuk request redirect_url.
		// Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
		$transaction_data = array(
			'payment_type' 			=> 'vtweb', 
			'vtweb' 						=> array(
				//'enabled_payments' 	=> ['credit_card'],
				'credit_card_3d_secure' => true
			),
			'transaction_details'=> $transaction_details,
			'item_details' 			 => $items,
			'customer_details' 	 => $customer_details
		);
	
		try
		{
			// catat di invoice
			$inv_data = array('third_party_name' => 'Veritrans', 'third_party_id' => $transaction_details['order_id']);
			$upd = $this->Common->update_data_on_table('invoices', 'invoice_id', $invoice_info->invoice_id, $inv_data);

			$vtweb_url = $this->veritrans_lib->vtweb_charge($transaction_data);
			header('Location: ' . $vtweb_url);
		} 
		catch (Exception $e) 
		{
    		echo $e->getMessage();
    		print_r($transaction_data);
		}
		
	}

	public function notification()
	{
		$this->load->library('Logging');
		echo 'test notification handler';
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		if($result){
			$notif = $this->veritrans_lib->status($result->order_id);
		}

		error_log(print_r($result,TRUE));

		//notification handler sample

		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		// get invoice ID
		$invoice_info = $this->Invoice_m->get_invoice_by_third_party_id($order_id);

		$notif_string = '';
		if ($transaction == 'capture') {
		  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
		  if ($type == 'credit_card'){
			if($fraud == 'challenge'){
		      // TODO set payment status in merchant's database to 'Challenge by FDS'
		      // TODO merchant should decide whether this transaction is authorized or not in MAP
		      	$notif_string = "Transaction order_id: " . $invoice_info->reference_id ." is challenged by FDS. Invoice ID: ".$invoice_info->invoice_id;
		      	$data = array('status' => 'Challenge by FDS', 'payment_method' => $type, 'status_change_timestamp' => date('Y-m-d H:i:s'));
				$update = $this->Common->update_data_on_table('invoices', 'third_party_id', $order_id, $data);
		      	$this->logging->insert_event_logging('veritrans_test_settlement', 'third_party', $update->status, $this->db->last_query());
	      	} 
		    else {
		      // TODO set payment status in merchant's database to 'Success'
		      	$notif_string = "Transaction order_id: " . $invoice_info->reference_id ." successfully captured using " . $type.". Invoice ID: Invoice ID: ".$invoice_info->invoice_id;
		      	$data = array('status' => 'Success', 'payment_method' => $type, 'status_change_timestamp' => date('Y-m-d H:i:s'));
				$update = $this->Common->update_data_on_table('invoices', 'third_party_id', $order_id, $data);
				$this->logging->insert_event_logging('veritrans_test_settlement', 'third_party', $update->status, $this->db->last_query());
		    }
		  }
		}
		else if ($transaction == 'settlement'){
		  // TODO set payment status in merchant's database to 'Settlement'
			$notif_string = "Transaction order_id: " . $invoice_info->reference_id ." successfully transfered using " . $type.". Invoice ID: Invoice ID: ".$invoice_info->invoice_id;
			$data = array('status' => 'Settlement', 'payment_method' => $type, 'status_change_timestamp' => date('Y-m-d H:i:s'));
			$update = $this->Common->update_data_on_table('invoices', 'third_party_id', $order_id, $data);
			$this->logging->insert_event_logging('veritrans_test_settlement', 'third_party', $update->status, $this->db->last_query());
	  	} 
		else if($transaction == 'pending'){
		  // TODO set payment status in merchant's database to 'Pending'
		  // echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
			$notif_string = "Waiting customer to finish transaction order_id: " . $invoice_info->reference_id . " using " . $type.". Invoice ID: Invoice ID: ".$invoice_info->invoice_id;
		  	$data = array('status' => 'Pending', 'payment_method' => $type, 'status_change_timestamp' => date('Y-m-d H:i:s'));
			$update = $this->Common->update_data_on_table('invoices', 'third_party_id', $order_id, $data);
			$this->logging->insert_event_logging('veritrans_test_settlement', 'third_party', $update->status, $this->db->last_query());
		} 
		else if ($transaction == 'deny') {
		  // TODO set payment status in merchant's database to 'Denied'
		  	$notif_string = "Payment using " . $type . " for transaction order_id: " . $invoice_info->reference_id . " is denied. Invoice ID: Invoice ID: ".$invoice_info->invoice_id;
		  	$data = array('status' => 'Denied', 'payment_method' => $type, 'status_change_timestamp' => date('Y-m-d H:i:s'));
			$update = $this->Common->update_data_on_table('invoices', 'third_party_id', $order_id, $data);
			$this->logging->insert_event_logging('veritrans_test_settlement', 'third_party', $update->status, $this->db->last_query());
		}
		else if ($transaction == 'cancel') {
		  // TODO set payment status in merchant's database to 'Denied'
		  	$notif_string = "Payment using " . $type . " for transaction order_id: " . $invoice_info->reference_id . " is denied. Invoice ID: Invoice ID: ".$invoice_info->invoice_id;
		  	$data = array('status' => 'Cancel', 'payment_method' => $type, 'status_change_timestamp' => date('Y-m-d H:i:s'));
			$update = $this->Common->update_data_on_table('invoices', 'third_party_id', $order_id, $data);
			$this->logging->insert_event_logging('veritrans_test_settlement', 'third_party', $update->status, $this->db->last_query());
		}

		// give notification to admin
        $this->load->library('notification');
        $notif = array(
        	'category' => 'veritrans_notification',
        	'title' => 'Veritrans Notification',
        	'content' => $notif_string,
        	'sender_id' => 'system',
        	'receiver_id' => 'admin'
        	);
        $add_notif = $this->notification->insert($notif);
	}

	function finish(){
		$order_id = $this->input->get('order_id', true);
		$status_code = $this->input->get('status_code', true);
		$trans_status = $this->input->get('transaction_status', true);

		// if($this->session->userdata('level')=="student")
			redirect('student/invoice');
	}

	function unfinish(){
		$order_id = $this->input->get('order_id', true);

		// if($this->session->userdata('level')=="student")
			redirect('student/invoice');
	}

	function test_notif(){
		//API Url
		$url = 'http://localhost/guruprivat/veritrans/notification';
		 
		//Initiate cURL.
		$ch = curl_init($url);
		 
		//The JSON data.
		$jsonData = array(
		    'username' => 'MyUsername',
		    'password' => 'MyPassword'
		);
		 
		//Encode the array into JSON.
		$jsonDataEncoded = '{
  "status_code": "201",
  "status_message": "Veritrans payment notification",
  "transaction_id": "92b4e9a6-c2db-4716-be6a-98d01ae7d159",
  "order_id": "5786f47de906f",
  "gross_amount": "605000.00",
  "payment_type": "bank_transfer",
  "transaction_time": "2016-07-14 09:14:42",
  "transaction_status": "pending",
  "permata_va_number": "8778005502988254",
  "signature_key": "0da8df95c1edefb62b9ad8f607c28959d69559e2d8f6a780e1e588ff2f836ed18a5f103da1041cccb99d0665f421ab32734d3845ad7c2bf5244c0317251a27c9"
}';
		 
		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);
		 
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		 
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		 
		//Execute the request
		$result = curl_exec($ch);
	}

	function error(){
		$this->show_error_page('710', $this->lang->line('error_veritrans_payment'));
	}
}
