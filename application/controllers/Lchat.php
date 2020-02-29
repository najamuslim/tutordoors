<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lchat extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('Live_chat_m');
		$this->lang->load('livechat', $this->session->userdata('idiom_language'));
	}	

	/* Loading page only */
	function user(){
		$data = array(
			'session_id' => uniqid(),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'is_active' => '1'
			);
		
		$add = $this->Common->add_to_table('live_chat_sessions', $data);

		$this->session->set_userdata('lchat_id', $data['session_id']);

		$this->load->view('admin/livechat/user_page', $data);
	}

	function admin(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'admin-live-chat',
			'title_page' => 'Live Chat',
			'mode' => 'add'
			);

		$data['sessions'] = $this->Live_chat_m->get_active_sessions();

		$this->open_admin_page('admin/livechat/admin_page', $data);
	}
	/* END - Loading page only */

	/* Functions only */
	function usend($session_id){
		$insert = $this->Live_chat_m->insert_new_chat($session_id, $this->input->post('text'), 'user');
		$message = $timestamp = '';
		if($insert->status){
			$get_message = $this->Live_chat_m->get_chat($insert->output);
			$message = $get_message->the_text;
			$timestamp = date_format(new DateTime($get_message->timestamp), 'd M Y H:i');
		}
		
		$response = array(
			'status' => $insert->status, 
			'message' => $message, 
			'timestamp' => $timestamp
			);

		echo json_encode($response);
	}

	function osend($session_id){
		$insert = $this->Live_chat_m->insert_new_chat($session_id, $this->input->post('text'), 'operator');
		$message = $timestamp = '';
		if($insert->status){
			$get_message = $this->Live_chat_m->get_chat($insert->output);
			$message = $get_message->the_text;
			$timestamp = date_format(new DateTime($get_message->timestamp), 'd M Y H:i');
		}
		
		$response = array(
			'status' => $insert->status, 
			'message' => $message, 
			'timestamp' => $timestamp
			);

		echo json_encode($response);
	}

	function remove($session_id){
		$upd_data = array('is_active' => '0');
		$upd = $this->Common->update_data_on_table('live_chat_sessions', 'session_id', $session_id, $upd_data);

		$response = array('status' => $upd->status);

		echo json_encode($response);
	}

	function get($type, $session_id=null){
		if($type=="ochat")
			$chats = $this->Live_chat_m->get_chats_by_session_id($session_id, '0', 'operator');
		else if($type=="uchat")
			$chats = $this->Live_chat_m->get_all_user_chats_not_retrieved();

		$response = array();
		$response['chats'] = array();
		
		if($chats<>false)
			foreach($chats->result() as $chat){
				$response['chats'][] = array(
					'session_id' => $chat->session_id,
					'timestamp' => $chat->timestamp,
					'message' => $chat->the_text
					);
				// update has_been_retrieved = 1
				$upd_data = array('has_been_retrieved' => '1');
				$upd = $this->Common->update_data_on_table('live_chats', 'chat_id', $chat->chat_id, $upd_data);
			}

		echo json_encode($response);
	}
	/* END - Functions only */
}