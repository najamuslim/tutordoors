<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Student extends REST_Controller {
	private $lang_;

	public function __construct() {
        parent::__construct();
        $this->load->model('User_m');
        $this->load->model('Location_m');
        $this->load->model('Common');
        $this->load->model('Student_m');
        if($this->post('lang')<>"")
        	$this->lang_ = $this->post('lang');
        else if($this->get('lang')<>"")
        	$this->lang_ = $this->get('lang');
        else
        	$this->lang_ = 'en';
        $this->lang->load($this->lang_, ($this->lang_=="en" ? 'english' : 'indonesia'));
	}

	function update_personal_post(){
		// 1. validate form
		$this->load->library('form_validation');

		$this->form_validation->set_rules('sid', 'User ID', 'required');
		$this->form_validation->set_rules('sex', $this->lang->line('sex'), 'required');
		$this->form_validation->set_rules('birth-place', $this->lang->line('birth_place'), 'required');
		$this->form_validation->set_rules('birth-date', $this->lang->line('birth_date'), 'required');
		$this->form_validation->set_rules('religion', $this->lang->line('religion'), 'required');
		$this->form_validation->set_rules('school-name', $this->lang->line('where_student_school'), 'required');
		$this->form_validation->set_rules('address-ktp', $this->lang->line('address_on_national_card'), 'required');
		$this->form_validation->set_rules('phone-1', $this->lang->line('phone'), 'required');
		$this->form_validation->set_rules('about-me', $this->lang->line('about_me'), 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = 'error';
			$validation_message = validation_errors();
			$validation_message = str_replace('<p>', '', $validation_message);
			$validation_message = str_replace('</p>', '', $validation_message);
			$response['message'] = $validation_message;
			$response['pos'] = 'form validation';
		}
		else
		{
			// 2. update name if isset
			if($this->post('fn')<>'' or $this->post('ln')<>''){
				$name_data = array(
					'first_name' => $this->post('fn'),
					'last_name' => $this->post('ln')
					);
				$upd_name = $this->Common->update_data_on_table('users', 'user_id', $this->post('sid'), $name_data);
			}

			// 3. update personal data
			$personal_data = array(
				'sex' => $this->post('sex'),
				'birth_place' => $this->post('birth-place'),
				'birth_date' => $this->post('birth-date'),
				'where_student_school' => $this->post('school-name'),
				'address_national_card' => $this->post('address-ktp'),
				'address_domicile' => $this->post('address-domicile'),
				'phone_1' => $this->post('phone-1'),
				'phone_2' => $this->post('phone-2'),
				'about_me' => $this->post('about-me'),
				'hobby' => $this->post('hobby'),
				'religion' => $this->post('religion')
				);
			if($this->post('photo_id')<>'')
				$personal_data['photo_primary_id'] = $this->post('photo_id');

			// check if user exist
			$check = $this->User_m->check_user_id_exist($this->post('sid'));
			if($check){
				$upd_info = $this->Common->update_data_on_table('user_info_data', 'user_id', $this->post('sid'), $personal_data);
				if($upd_info->status)
					$response = array('status'=>'OK');
				else
					$response = array('status'=>'error', 'message'=>$upd_info->output);
			}
			else{
				$personal_data['user_id'] = $this->post('sid');
				$add_info = $this->Common->add_to_table('user_info_data', $personal_data);
				if($add_info->status)
					$response = array('status'=>'OK');
				else
					$response = array('status'=>'error', 'message'=>$add_info->output);
			}
			
		}

		$this->response($response);
	}

	function personal_get(){
		$user_id = $this->get('id');
		$this->response($this->User_m->get_user_info($user_id));
	}

}