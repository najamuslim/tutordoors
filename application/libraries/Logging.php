<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logging {
	private $ci;
	
	public function __construct()
    {
        $this->ci =& get_instance();
    }
	
	public function insert_event_logging($event_name, $request, $response, $method){
		$data = array(
			'event_name' => $event_name,
			'request_text' => $request,
			'response_text' => $response,
			'request_method' => $method
		);
		$this->ci->load->model('common');
		$insert = $this->ci->common->add_to_table('event_logs', $data);
	}
}

/* End of file Custom.php */
/* Location: ./application/libraries/Custom.php */