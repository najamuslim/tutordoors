<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Invoice extends REST_Controller {
	public function __construct() {
        parent::__construct();
        
        if($this->post('lang')<>"")
        	$this->lang_ = $this->post('lang');
        else if($this->get('lang')<>"")
        	$this->lang_ = $this->get('lang');
        else
        	$this->lang_ = 'en';
        $this->lang->load($this->lang_, ($this->lang_=="en" ? 'english' : 'indonesia'));
	}

    function info_get(){
        $this->load->model('Invoice_m');
        $inv = $this->Invoice_m->get_invoice_by_id($this->get('inv'));
        $response = array(
            'id' => $this->get('inv'),
            'total' => number_format($inv->total, 0, ',', '.'),
            'ref_id' => $inv->reference_id,
            'ref_type' => $inv->reference_table,
            'charged_user_id' => $inv->user_id,
            'due_date' => date_format(new DateTime($inv->due_date), 'd M Y H:i'),
            'status' => $inv->status
            );
        $this->response($response);
    }

    public function submit_payment_conf_post(){
        $this->load->model('Invoice_m');
        $this->load->model('Bank_m');
        $this->load->model('Order_m');
        $this->load->model('Common');
        $response = array();
        // 1. check if order id is correct
        $check_invoice = $this->Invoice_m->get_invoice_by_id(strtoupper($this->post('invoice-id')));
        if($check_invoice==false)
            $response = array('status' => "204", 'message' => $this->lang->line('invoice_id_not_found_with_hint'));
        else{
            // 2. check if not duplicate in table payment_confirmation, customer should not confirm twice
            $check_duplicate = $this->Order_m->check_payment_conf_duplicate($this->post('invoice-id'));
            if($check_duplicate)
                $response = array('status' => "204", 'message' => $this->lang->line('invoice_id_has_been_confirmed_once'));
            else{
                $selected_bank = '';
                if($this->post('bank')=="bca")
                    $selected_bank = $this->Bank_m->get_bank_data('bank_name', 'BCA');
                $data = array(
                    'referrence_id' => strtoupper($this->post('invoice-id')),
                    'sender_name' => $this->post('name'),
                    'bank_dest_id' => $selected_bank->row()->bank_id,
                    'transfer_date' => $this->post('transfer-date'),
                    'total_paid' => $this->post('total'),
                    'note' => $this->post('note'),
                    'status' => 'Open'
                    );
                $add_payment_conf = $this->Common->add_to_table('payment_transfer', $data);

                // give notification to admin
                $this->load->library('notification');
                $notif = array(
                    'category' => 'new_payment_conf',
                    'title' => 'New Payment Confirmation',
                    'content' => 'New payment confirmation for invoice ID '.strtoupper($this->post('invoice-id')),
                    'sender_id' => ($this->post('user_id') <> "" ? $this->post('user_id') : ''),
                    'receiver_id' => 'admin'
                    );
                $add_notif = $this->notification->insert($notif);

                // send push notification to mobile application
                $this->load->library('Push_Notification_Lib');
                $push_result = $this->push_notification_lib->send('admin', $notif['title'], $notif['content']);

                $response = array('status' => '200', 'message' => $this->lang->line('thanks_for_confirm_payment'));
            }
        }
        
        $this->response($response);
    }
}