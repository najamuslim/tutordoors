<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Push_Notification_Lib {
	private $ci;
	
	public function __construct()
    {
        $this->ci =& get_instance();
    }
	
	function send($user_id, $title, $message=''){
		$this->ci->load->model('Push_m');
		$this->ci->load->model('Common');
		$get_token = $this->ci->Push_m->get_active_token($user_id);
		$response = array();
		if($get_token==false){
			return array('status' => '204', 'message' => "User doesn't have an active token");
		}
		else{
			$tokens = array();
			foreach($get_token->result() as $row)
				array_push($tokens, $row->token);
			
			$fields = array
			(
				'tokens' 	=> $tokens,
				'profile'	=> 'tutordoors_id',
				'notification' => array
					(
						'message' 	=> $message,
						'title'		=> $title
					)
			);
			 
			$headers = array
			(
				'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJiMTI2MmU3NC0zNGI2LTQ0MmUtYjQ2Ny1iOGJkNWQ2ZDY4ZWUifQ.Zhrcrgzix7whpzuEMiKj7xkc6CbaIfbmIR2yONXHYdU',
				'Content-Type: application/json'
			);
			 
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://api.ionic.io/push/notifications' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
			$result = curl_exec($ch );
			curl_close( $ch );
			// echo $result;

			// store logging
			$logging_data = array(
				'receiver_user_id' => $user_id,
				'token' => json_encode($tokens),
				'request' => json_encode($fields),
				'response' => $result
				);
			$this->ci->Common->add_to_table('push_notif_logs', $logging_data);

			return array('status' => '200');
		}
	}

}