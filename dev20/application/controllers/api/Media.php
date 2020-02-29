<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Media extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_m');
        $this->load->model('Common');
        $this->load->model('Content_m');
    }

    function upload_image_post(){
		$upload_path_url = base_url() . 'assets/uploads/';
		$this->load->library('upload');
		$config = array(
			'upload_path' => './assets/uploads/',
			'allowed_types' => 'jpg|png|gif|jpeg',
			'overwrite' => false,
			'remove_spaces' => true,
			'max_size' => '5000'
		);
		$this->upload->initialize($config);
		
        $response = array();
		if ( ! $this->upload->do_upload()){
            $response = array(
                'status' => 'error',
                'message' => $this->upload->display_errors()
                );
		} 
		else{
			$data = $this->upload->data();
			//insert document data in database
			$upload_data = array(
				'file_name' => $data['file_name'],
				'file_type' => $data['file_type'],
				'file_extension' => $data['file_ext'],
				'img_width' => $data['image_width'],
				'img_height' => $data['image_height'],
				'file_size' => $data['file_size'],
				'is_image' => $data['is_image']
			);

			$add_media = $this->Common->add_to_table('media_files', $upload_data); // return the last inserted id
            $media_id = $add_media->output;
            
            $response = array(
                'status' => 'OK',
                'message' => 'Image uploaded successfully',
                'media_id' => $media_id
                );
        }

        $this->response($response);
	}
}