<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Messaging extends REST_Controller {
	private $lang_;

	public function __construct() {
        parent::__construct();
        $this->load->model('Content_m');
        $this->load->model('User_m');
        $this->load->model('Mailbox_m');
        $this->load->model('Common');
        if($this->post('lang')<>"")
        	$this->lang_ = $this->post('lang');
        else if($this->get('lang')<>"")
        	$this->lang_ = $this->get('lang');
        else
        	$this->lang_ = 'en';
        $this->lang->load($this->lang_, ($this->lang_=="en" ? 'english' : 'indonesia'));
	}

	function notification_get(){
		$this->load->library('notification');
        $get = $this->notification->get_message_by_direction($this->get('user_id'), 'in', $this->get('start'), $this->get('limit'));
        $response = array();
        if($get==false)
            $this->response($response);
        else{
            foreach($get->result() as $notif){
                switch ($notif->category) {
                    case 'teacher_verified':
                        $image_string = 'teacher_verified.png';
                        break;
                    case 'new_course_request':
                        $image_string = 'new course request.png';
                        break;
                    case 'course_confirmed':
                        $image_string = 'course confirmed.png';
                        break;
                    case 'reply_course_request':
                        $image_string = 'new course request acknowledge.png';
                        break;
                    case 'new_test_assignment':
                        $image_string = 'new test assignment.png';
                        break;
                    default:
                        $image_string = 'new test assignment.png';
                        break;
                }
                $response[] = array(
                    'title' => $notif->title,
                    'sender_name' => $notif->sender_fn.' '.$notif->sender_ln,
                    'content' => $notif->content,
                    'timestamp' => date_format(new DateTime($notif->notif_timestamp), 'd M Y'),
                    'image_string' => $image_string
                    );
            }
            $this->response($response);
        }
	}

    /* MAILBOX */
    function fetch_mail($data){
        $response = array();
        foreach($data->result() as $mail){
            $response[] = array(
                'sender_name' => $mail->sender_fn.' '.$mail->sender_ln,
                'destination_name' => $mail->receiver_fn.' '.$mail->receiver_ln,
                'subject' => $mail->subject,
                'content' => base64_decode($mail->content),
                'timestamp' => date_format(new DateTime($mail->sent_timestamp), 'd M Y'));
        }

        return $response;
    }

    function inbox_get(){
        $user_id = $this->get('user_id');
        $response = array();
        $get_mails = $this->Mailbox_m->get_mail_data($user_id, 'inbox', $this->get('start'), $this->get('limit'));
        if($get_mails <> false)
            $response = $this->fetch_mail($get_mails);

        $this->response($response);
    }

    function outbox_get(){
        $user_id = $this->get('user_id');
        $response = array();
        $get_mails = $this->Mailbox_m->get_mail_data($user_id, 'outbox', $this->get('start'), $this->get('limit'));
        if($get_mails <> false)
            $response = $this->fetch_mail($get_mails);    

        $this->response($response);
    }

    function draft_get(){
        $user_id = $this->get('user_id');
        $response = array();
        $get_mails = $this->Mailbox_m->get_mail_data($user_id, 'draft', $this->get('start'), $this->get('limit'));
        if($get_mails <> false)
            $response = $this->fetch_mail($get_mails);    

        $this->response($response);
    }

    function trash_get(){
        $user_id = $this->get('user_id');
        $response = array();
        $get_mails = $this->Mailbox_m->get_mail_data($user_id, 'trash', $this->get('start'), $this->get('limit'));
        if($get_mails <> false)
            $response = $this->fetch_mail($get_mails);    

        $this->response($response);
    }

    function send_mail_post(){

        $data = array(
            'id' => uniqid(),
            'sender' => $this->post('sender_id'),
            'destination' => $this->post('destination_id'),
            'subject' => $this->post('subject'),
            'content' => base64_encode($this->post('content')),
            'media_id' => $this->post('file-id'),
            'status' => 'Sent'
            );
        $add = $this->Common->add_to_table('mailbox', $data);
        if($add->status)
            $response = array('status' => "OK", 'message' => 'Your mail has been sent successfully');
        else
            $response = array('status' => "error", 'message' => $add->output);

        $this->response($response);
    }
    /* MAILBOX END */

}