<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Content extends REST_Controller {
	private $lang_;

	public function __construct() {
        parent::__construct();
        $this->load->model('Content_m');
        if($this->post('lang')<>"")
        	$this->lang_ = $this->post('lang');
        else if($this->get('lang')<>"")
        	$this->lang_ = $this->get('lang');
        else
        	$this->lang_ = 'en';
        $this->lang->load($this->lang_, ($this->lang_=="en" ? 'english' : 'indonesia'));
	}

	function faq_get(){
		$lang = $this->get('lang');
		$this->response($this->Content_m->get_faq_posts($this->lang_)->result());
	}

}