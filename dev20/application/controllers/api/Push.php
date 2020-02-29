<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Push extends REST_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Common');
        $this->load->model('Push_m');
	}

	function save_token_post(){
		$user_id = $this->post('user_id');
		$token = $this->post('token');
		$check_token = $this->Push_m->check_if_exist($user_id, $token);
		$token_id = '';
		if($check_token <> false){
			$token_id = $check_token->id;
			$upd_data = array('is_active' => 'true');
			$upd = $this->Common->update_data_on_table('push_notif_tokens', 'id', $token_id, $upd_data);
		}
		else{
			$data = array(
				'id' => uniqid(),
				'user_id' => $this->post('user_id'),
				'is_active' => 'true',
				'token' => $this->post('token')
				);
			$token_id = $data['id'];
			$save = $this->Common->add_to_table('push_notif_tokens', $data);
		}

		$this->response(array('status' => '200', 'token_id' => $token_id));
	}

	function delete_token_post(){
		$data = array('is_active' => 'false');
		$upd = $this->Common->update_data_on_table('push_notif_tokens', 'id', $this->post('token_id'), $data);

		$this->response(array('status' => '200'));
	}

}