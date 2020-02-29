<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scheduler extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('timezone');
	}

	function sche_coupon_status(){
		$this->load->model('Commerce_m', 'comm');

		$now = date('Y-m-d H:i:s');
		$now_datetime = new DateTime($now);

		echo nl2br("=======================================================================\n");
		echo nl2br("Processing Coupon Status\n");
		echo nl2br("Executed at ".$now."\n");
		echo nl2br("=======================================================================\n");
		
		// 1. check and change status to Running
		// 1.1 get records that NOW is between start time and end time
		$in_now = $this->comm->get_not_running_status_between_time($now);
		if($in_now<>false){
			foreach($in_now->result() as $rec){
				$data = array('status' => 'Running');
				$upd_running = $this->Common->update_data_on_table('coupon_codes', 'coupon_code', $rec->coupon_code, $data);
			}
		}
		
		// 2. check and change status to Completed
		$running_now = $this->comm->get_running_status_over($now);
		if($running_now<>false){
			foreach($running_now->result() as $rec){
				$data = array('status' => 'Completed');
				$upd_running = $this->Common->update_data_on_table('coupon_codes', 'coupon_code', $rec->coupon_code, $data);
			}
		}
		
		echo nl2br("Process done.\n\n\n");
	}
}