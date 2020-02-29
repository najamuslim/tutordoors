<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Content extends REST_Controller {
	private $lang_;

	public function __construct() {
        parent::__construct();
        
        header("Access-Control-Allow-Origin: *");
        
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

    function feed_page_get(){
        $url = $this->get('u');
        $filter = array(
            'type' => 'page',
            'url' => $url,
            'status' => 'publish'
            );

        $get_post = $this->Content_m->get_post_data($filter);
        $data = $get_post->row();
        $response = array(
            'id' => $data->id,
            'title' => $data->title,
            'content' => $data->content,
            'category' => $data->category_name,
            'slug' => $data->slug,
            'url' => $data->url,
            'image' => base_url('assets/uploads/'.$data->file_name),
            'lang' => $data->lang_id
            );

        $this->response($response);
    }

}