<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('Invoice_m', 'invoice');
		// Load helpers
		$this->load->helper('url');
		
		// Load PayPal library
		$this->config->load('paypal');
		
		$config = array(
			'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
			'APIUsername' => $this->config->item('APIUsername'), 	// PayPal API username of the API caller
			'APIPassword' => $this->config->item('APIPassword'), 	// PayPal API password of the API caller
			'APISignature' => $this->config->item('APISignature'), 	// PayPal API signature of the API caller
			'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
			'APIVersion' => $this->config->item('APIVersion'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
			'DeviceID' => $this->config->item('DeviceID'), 
			'ApplicationID' => $this->config->item('ApplicationID'), 
			'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
		);
		
		if($config['Sandbox'])
		{
			// Show Errors
			error_reporting(E_ALL);
			ini_set('display_errors', '1');	
		}
		
		$this->load->library('paypal/Paypal_adaptive', $config);	
	}

	function setup(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'setup-paypal',
			'title_page' => 'Setup Paypal'
			);

		$get_options = $this->Content_m->get_all_options();
		foreach($get_options->result() as $param){
			$options[$param->parameter_name]['desc'] = $param->description;
			$options[$param->parameter_name]['value'] = $param->parameter_value;
		}
		$data['options'] = $options;
		$data['controller'] = 'paypal';

		$this->open_admin_page('admin/base_setup/one_group', $data);
	}

	function save_config(){
		foreach($this->input->post() as $key => $input){
			$upd = $this->Common->update_data_on_table('options', 'parameter_name', $key, array('parameter_value' => $input));
			$this->push_if_transaction_error($upd);
		}

		$this->set_session_response_no_redirect_by_error('update');
		redirect('paypal/setup');
	}

	function finish(){
		redirect('student/invoice');
	}

	function unfinish(){
		redirect('student/invoice');
	}

	function ap_checkout() // Adaptive Payment
	{	
		// get data from database
		$invoice_id = $this->input->get('inv', true);
		// get invoice info
		$invoice_info = $this->invoice->get_invoice_by_id($invoice_id);

		// Prepare request arrays
		$PayRequestFields = array(
								'ActionType' => 'PAY', 								// Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
								'CancelURL' => base_url('paypal/unfinish'), 									// Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
								'CurrencyCode' => 'USD', 								// Required.  3 character currency code.
								'FeesPayer' => 'SENDER', 									// The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
								'IPNNotificationURL' => 'http://tutordoors.com/paypal/ipn_handler', 						// The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
								'Memo' => '', 										// A note associated with the payment (text, not HTML).  1000 char max
								'Pin' => '', 										// The sener's personal id number, which was specified when the sender signed up for the preapproval
								'PreapprovalKey' => '', 							// The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.  
								'ReturnURL' => base_url('paypal/finish'),									// Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
								'ReverseAllParallelPaymentsOnError' => '', 			// Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
								'SenderEmail' => '', 								// Sender's email address.  127 char max.
								'TrackingID' => ''									// Unique ID that you specify to track the payment.  127 char max.
								);
						
		// Populate customer's Info
		$customer_info = $this->User_m->get_user_info($invoice_info->user_id);		
		$ClientDetailsFields = array(
								'CustomerID' => $invoice_info->user_id, 								// Your ID for the sender  127 char max.
								'CustomerType' => $customer_info->user_level, 								// Your ID of the type of customer.  127 char max.
								'GeoLocation' => '', 								// Sender's geographic location
								'Model' => '', 										// A sub-identification of the application.  127 char max.
								'PartnerName' => ''									// Your organization's name or ID
								);
								
		$FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');
		
		$Receivers = array();
		$Receiver = array(
						'Amount' => ceil(intval($invoice_info->total) / 13500), 											// Required.  Amount to be paid to the receiver.
						'Email' => 'td.test@gmail.com', 												// Receiver's email address. 127 char max.
						'InvoiceID' => $invoice_id, 											// The invoice number for the payment.  127 char max.
						'PaymentType' => 'SERVICE', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => '', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => ''												// Whether this receiver is the primary receiver.  Values are:  TRUE, FALSE
						);
		array_push($Receivers,$Receiver);
		
		$SenderIdentifierFields = array(
										'UseCredentials' => ''						// If TRUE, use credentials to identify the sender.  Default is false.
										);
										
		$AccountIdentifierFields = array(
										'Email' => '', 								// Sender's email address.  127 char max.
										'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')								// Sender's phone number.  Numbers only.
										);
										
		$PayPalRequestData = array(
							'PayRequestFields' => $PayRequestFields, 
							'ClientDetailsFields' => $ClientDetailsFields, 
							'FundingTypes' => $FundingTypes, 
							'Receivers' => $Receivers, 
							'SenderIdentifierFields' => $SenderIdentifierFields, 
							'AccountIdentifierFields' => $AccountIdentifierFields
							);	
							
		$PayPalResult = $this->paypal_adaptive->Pay($PayPalRequestData);
		print_r($PayPalResult);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal/samples/error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
			// catat di invoice
		
			$inv_data = array('third_party_name' => 'Paypal', 'third_party_id' => $PayPalResult['CorrelationID']);
			$upd = $this->Common->update_data_on_table('invoices', 'invoice_id', $invoice_info->invoice_id, $inv_data);

			redirect($PayPalResult['RedirectURL']);
		}
	}

	function convert_currency()
	{
		// Prepare request arrays
		$BaseAmountList = array();
		$BaseAmountData = array(
								'Code' => 'USD', 						// Currency code.
								'Amount' => '100.00'						// Amount to be converted.
								);
		array_push($BaseAmountList, $BaseAmountData);
		
		$ConvertToCurrencyList = array('SGD', 'SEK');			// Currency Codes
		
		$PayPalRequestData = array(
								'BaseAmountList' => $BaseAmountList, 
								'ConvertToCurrencyList' => $ConvertToCurrencyList
								);	
								
		$PayPalResult = $this->paypal_adaptive->ConvertCurrency($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal/samples/error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
			$data = array('PayPalResult'=>$PayPalResult);
			// $this->load->view('paypal/samples/convert_currency',$data);
			print_r($data);
		}	
	}

	function ipn_handler(){
		// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
		// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
		// Set this to 0 once you go live or don't require logging.
		define("DEBUG", 1);
		// Set to 0 once you're ready to go live
		define("USE_SANDBOX", 1);
		define("LOG_FILE", "ipn.log");
		// Read POST data
		// reading posted data directly from $_POST causes serialization
		// issues with array data in POST. Reading raw POST data from input stream instead.
		$raw_post_data = file_get_contents('php://input');
		error_log(date('[Y-m-d H:i e] '). "IPN Post Data: $raw_post_data ". PHP_EOL, 3, LOG_FILE);
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}
		// Post IPN data back to PayPal to validate the IPN data is genuine
		// Without this step anyone can fake IPN data
		if(USE_SANDBOX == true) {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		} else {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		}
		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		if(DEBUG == true) {
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
		}
		// CONFIG: Optional proxy configuration
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		// Set TCP timeout to 30 seconds
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
		// of the certificate as shown below. Ensure the file is readable by the webserver.
		// This is mandatory for some environments.
		//$cert = __DIR__ . "./cacert.pem";
		//curl_setopt($ch, CURLOPT_CAINFO, $cert);
		$res = curl_exec($ch);
		if (curl_errno($ch) != 0) // cURL error
			{
			if(DEBUG == true) {	
				error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
			}
			curl_close($ch);
			exit;
		} else {
				// Log the entire HTTP response if debug is switched on.
				if(DEBUG == true) {
					error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
					error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
				}
				curl_close($ch);
		}
		// Inspect IPN validation result and act accordingly
		// Split response headers and payload, a better way for strcmp
		$tokens = explode("\r\n\r\n", trim($res));
		$res = trim(end($tokens));
		if (strcmp ($res, "VERIFIED") == 0) {
			// check whether the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment and mark item as paid.
			// assign posted variables to local variables
			//$item_name = $_POST['item_name'];
			//$item_number = $_POST['item_number'];
			//$payment_status = $_POST['payment_status'];
			//$payment_amount = $_POST['mc_gross'];
			//$payment_currency = $_POST['mc_currency'];
			//$txn_id = $_POST['txn_id'];
			//$receiver_email = $_POST['receiver_email'];
			//$payer_email = $_POST['payer_email'];
			
			// get invoice ID
			$invoice_info = $this->invoice->get_invoice_by_third_party_id($_POST['txn_id']);

		
			$data = array('status' => $_POST['payment_status'], 'payment_method' => $_POST['txn_type'], 'status_change_timestamp' => date('Y-m-d H:i:s'));
			$update = $this->Common->update_data_on_table('invoices', 'third_party_id', $_POST['txn_id'], $data);
			$this->logging->insert_event_logging('paypal_ipn_response', 'third_party', $update->status, $this->db->last_query());
			
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
			}
		} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			// Add business logic here which deals with invalid IPN messages
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
			}

			/* harus dipindah saat live ke if VERIFIED */
			// get invoice ID
			$invoice_info = $this->invoice->get_invoice_by_third_party_id($_POST['txn_id']);

		
			$data = array('status' => $_POST['payment_status'], 'payment_method' => $_POST['txn_type'], 'status_change_timestamp' => date('Y-m-d H:i:s'));
			$update = $this->Common->update_data_on_table('invoices', 'third_party_id', $_POST['txn_id'], $data);
			$this->logging->insert_event_logging('paypal_ipn_response', 'third_party', $update->status, $this->db->last_query());

			// give notification to admin
			$notif_string = "Payment using " . $_POST['txn_type'] . " for transaction order_id: " . $invoice_info->reference_id . " is denied. Invoice ID: Invoice ID: ".$invoice_info->invoice_id;
	        $this->load->library('notification');
	        $notif = array(
	        	'category' => 'paypal_notification',
	        	'title' => 'Paypal Notification',
	        	'content' => $notif_string,
	        	'sender_id' => 'system',
	        	'receiver_id' => 'admin'
	        	);
	        $add_notif = $this->notification->insert($notif);
		}
	}
}