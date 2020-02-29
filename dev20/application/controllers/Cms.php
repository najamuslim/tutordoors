<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {
	public function __construct() {
        parent::__construct();
	}

	/* pages begin */
	public function index(){
		redirect('cms/dashboard');
	}

	function dashboard(){
		$this->load->model('Software_m');
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'admin-dashboard',
			'title_page' => 'Dashboard',
			'title' => ''
			);
		
		$data['total_student'] = $this->User_m->count_user_level('student');
		$data['total_teacher'] = $this->User_m->count_user_level('teacher');
		$data['total_enrollment'] = $this->Course_m->count_course_enrollment();
		$get_unverified = $this->Teacher_m->get_unverified();
		$data['total_unverified'] = $get_unverified->num_rows();
		$get_verified = $this->Teacher_m->get_verified();
		$data['total_verified'] = $get_verified->num_rows();
		
		$data['software_updates'] = $this->Software_m->get_software_updates(array('software_name' => 'tutordoors.com'));
		

		// $count_order = $this->Order_m->view_order_summary();
		// $data['count_order'] = ($count_order<>false ? $count_order->num_rows() : 0);

		// $grouping_order = $this->Order_m->count_order_grouping_date();
		// $data['total_sales_per_date'] = $grouping_order->result();

		$this->open_admin_page('admin/dashboard', $data);
	}

	public function login(){
		$this->session->set_userdata('prev_page', $this->session->userdata('curr_page'));
		$this->session->set_userdata('curr_page', $this->uri->segment(1).'/'.$this->uri->segment(2));
		$this->load->view('admin/login');
	}

	public function set_options(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'company-info',
			'title_page' => 'Global Company Info'
			);

		$get_options = $this->Content_m->get_all_options();
		foreach($get_options->result() as $param){
			$options[$param->parameter_name]['desc'] = $param->description;
			$options[$param->parameter_name]['value'] = $param->parameter_value;
		}
		$data['options'] = $options;

		$this->open_admin_page('admin/setting', $data);
	}

	function setup_bank()
	{
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'setup-bank',
			'title_page' => 'Setup Company\'s Bank'
			);
		
		$this->load->model('Bank_m');
		$data['banks'] = $this->Bank_m->get_bank_data();

		$this->open_admin_page('admin/base_setup/bank', $data);
	}

	public function set_miscellaneous(){
		$this->check_user_access();
		$data = array(
			'am' => 'base_setup',
			'asm_1' => 'miscellaneous',
			'title_page' => 'Miscellaneous Setting'
			);

		$this->load->model('Commerce_m');
		
		$this->load->model('Bank_m');
		$data['banks'] = $this->Bank_m->get_bank_data();

		// $this->load->model('Content_m', 'content');
		$get_options = $this->Content_m->get_all_options();
		foreach($get_options->result() as $param){
			$options[$param->parameter_name]['desc'] = $param->description;
			$options[$param->parameter_name]['value'] = $param->parameter_value;
		}
		$data['options'] = $options;

		// load shipping cost setting
		$data['ship_cost'] = $this->Commerce_m->get_all_shipping_cost();

		$this->open_admin_page('admin/setting_miscellaneous', $data);
	}

	function show_notifications(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'notification',
			'title_page' => 'Notifications'
			);

		$id=$this->input->get('id', TRUE);

		$this->load->library('notification');

		if($id=="")
			$get_data = $this->notification->get_data();
		else
			$get_data = $this->notification->get_data('id', $id);
		// print_r($this->db->last_query());
		foreach($get_data as $notif){
			$this->load->model('Common');
			$data_read = array('has_been_read' => "true");
			if($notif->has_been_read=="false")
				$this->Common->update_data_on_table('notifications', 'id', $notif->id, $data_read);
		}

		if($id=="")
			$get_data = $this->notification->get_data();
		else
			$get_data = $this->notification->get_data('id', $id);
		
		$data['show_notifications'] = $get_data;

		$this->open_admin_page('admin/notifications', $data);
	}

	function media_view_all(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'media',
			'title_page' => 'Media'
			);

		$data['media'] = $this->Content_m->get_media();

		$this->open_admin_page('admin/media_view_all', $data);
	}

	/* end pages */

	function setup_discount($post_id){
		$cnt = 1;
		foreach($_POST['quantity-get-discount'] as $key => $disc){
			$data = array(
				'post_id' => $post_id,
				'on_quantity' => $disc,
				'discount' => $_POST['discount-on-quantity'][$key],
				'order_list' => $cnt
			);
			$add_discount = $this->Common->add_to_table('product_discounts', $data);
			if(!$add_discount->status)
				array_push($this->any_error, $add_discount->output);
			$cnt++;
		}
	}

	public function opt_web_update(){
		$this->update_options_fetch_all_input();
		redirect('cms/set_options');
	}

	function opt_socmed_update(){
		$this->update_options_fetch_all_input();
		redirect('cms/set_options?tab=socmed');
	}

	public function opt_company_update(){
		$this->update_options_fetch_all_input();
		redirect('cms/set_options?tab=company');
	}

	public function opt_payroll_update(){
		$this->update_options_fetch_all_input();
		redirect('cms/set_miscellaneous?tab=payroll');
	}

	public function opt_order_update(){
		$this->update_options_fetch_all_input();
		redirect('cms/set_miscellaneous?tab=order');
	}

	function update_options_fetch_all_input(){
		foreach($this->input->post() as $key => $input){
			$upd = $this->Common->update_data_on_table('options', 'parameter_name', $key, array('parameter_value' => $input));
			$this->push_if_transaction_error($upd);
		}

		$this->set_session_response_no_redirect_by_error('update');
	}

	public function post_media_delete(){
		$media_id = $this->input->get('media', TRUE);
		$post_id = $this->input->get('po_id', TRUE);
		$prod_id = $this->input->get('pr_id', TRUE);

		// $this->load->model('content_m', 'content');
		//get the filename and delete from storage
		$get = $this->Content_m->get_post_image($media_id);
		$filename = $get->file_name;
		unlink('./assets/uploads/'.$filename);

		$this->load->library('Db_trans');
		$this->db_trans->delete_from_table_by_id('media_files', 'id', $media_id);

		if($prod_id<>"")
			redirect('cms/product_edit?po_id='.$post_id.'&pr_id='.$prod_id);
		else
			redirect('cms/post_edit?id='.$post_id);
	}

	public function get_category_under_root(){
		$root_id = $this->input->get('root');
		$post_id = $this->input->get('post');

		$get = $this->Content_m->get_categories_under_root($root_id);
		$mapped_category = array();
		if($post_id <> ""){ // if post id fulfilled then it's an edit mode
			$get_category = $this->Content_m->get_mapped_post_categories($post_id); 
			
			foreach($get_category->result() as $row)
				array_push($mapped_category, $row->category_id);
		}
			
		if($get==false)
			$response['status'] = '204';
		else{
			$response['status'] = '200';
			foreach($get->result() as $row){
				$response['result'][] = array(
					'id' => $row->id,
					'name' => $row->category,
					'mapped' => in_array($row->id, $mapped_category)
					);
			}
		}
		
		echo json_encode($response);
	}

	public function change_bank_active(){
		$id = $this->uri->segment(3);
		$status = $this->uri->segment(4);

		$data = array('active' => $status);
		$upd_active = $this->Common->update_data_on_table('bank_accounts', 'bank_id', $id, $data);

		redirect('cms/set_miscellaneous?tab=bank');
	}

	public function bank_add(){
		$data = array(
			'bank_name' => $this->input->post('name', TRUE),
			'bank_account_number' => $this->input->post('number', TRUE),
			'bank_holder_name' => $this->input->post('account-name', TRUE),
			'bank_branch' => $this->input->post('branch', TRUE),
			'bank_city' => $this->input->post('city', TRUE),
			'active' => 'false'
			);
		$add_bank = $this->Common->add_to_table('bank_accounts', $data);
		$this->set_session_response_no_redirect('add', $add_bank);

		redirect('cms/set_miscellaneous');
	}

	public function bank_update(){
		$id = $this->input->post('id', TRUE);
		$data = array(
			'bank_name' => $this->input->post('name', TRUE),
			'bank_account_number' => $this->input->post('number', TRUE),
			'bank_holder_name' => $this->input->post('account-name', TRUE),
			'bank_branch' => $this->input->post('branch', TRUE),
			'bank_city' => $this->input->post('city', TRUE)
			);
		$upd_bank = $this->Common->update_data_on_table('bank_accounts', 'bank_id', $id, $data);
		$this->set_session_response_no_redirect('update', $upd_bank);

		redirect('cms/set_miscellaneous');
	}

	function bank_get_data_by_id(){
		$id = $this->uri->segment(3);
		$this->load->model('Bank_m', 'bank');
		$bank = $this->bank->get_bank_by_id($id);

		$response = array(
			'id' => $bank->bank_id,
			'name' => $bank->bank_name,
			'account_name' => $bank->bank_holder_name,
			'number' => $bank->bank_account_number,
			'branch' => $bank->bank_branch,
			'city' => $bank->bank_city
			);

		echo json_encode($response);
	}

	function count_notification(){ 
		$this->load->library('notification');
		$get_notif = $this->notification->get_data_both_send_receiver($this->session->userdata('userid'));
		$response['notifications'] = array();
		$response['notif_unread'] = $this->notification->count_unread_by_userid($this->session->userdata('userid'));
		if($get_notif<>false)
			foreach($get_notif->result() as $row){
				$response['notifications'][] = array(
					'id' => $row->id,
					'category' => $row->category,
					'title' => $row->title,
					'content' => $row->content,
					'has_been_read' => $row->has_been_read
					);
			}

		echo json_encode($response);
	}

	function media_add(){
		$this->load->library('upload');
		$this->load->library('Db_trans');
		$config = array(
			'upload_path' => './assets/uploads/',
			'allowed_types' => 'jpg|png|jpeg|mp3|mp4|wmv',
			'overwrite' => false,
			'remove_spaces' => true,
			'max_size' => '50000'
		);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('image_file')){
			//$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('err_no', "204");
			$this->session->set_flashdata('err_msg', $this->upload->display_errors());
		} 
		else{
			$upload_data = $this->upload->data();
			//insert document data in database
	
			$data = array(
				'file_name' => $upload_data['file_name'],
				'file_type' => $upload_data['file_type'],
				'file_extension' => $upload_data['file_ext'],
				'img_width' => $upload_data['image_width'],
				'img_height' => $upload_data['image_height'],
			);
			$insert_file = $this->db_trans->insert_data('media_files', $data); // return the last inserted id
        }

		redirect('cms/media_view_all');
	}

	function media_delete(){
		$this->load->library('Db_trans');
		// $this->load->model('Content_m', 'content');

		$media_id = $this->uri->segment(3);
		$any_in_post = false;
		// check if the media is in any post or post_media
		if($this->Content_m->check_media_in_post($media_id))
			$any_in_post = true;
		if($this->Content_m->check_media_in_post_media($media_id))
			$any_in_post = true;

		if($any_in_post){
			$this->session->set_flashdata('err_no', "204");
			$this->session->set_flashdata('err_msg', "Media you wish to delete is embedded in a post, please change image in your post then delete it.");
		}
		else{
			//get the filename and delete from storage
			$get = $this->Content_m->get_post_image($media_id);
			$filename = $get->file_name;
			// delete from database
			$this->db_trans->delete_from_table_by_id('media_files', 'id', $media_id);
			// delete from storage
			unlink('./assets/uploads/'.$filename);
		}
		redirect('cms/media_view_all');
	}

	// public function add_coupon(){
	// 	$this->load->model('Common', 'Common');
		
	// 	$coupon = array(
	// 		'coupon_code' => $this->input->post('code', TRUE),
	// 		'minimum_order' => $this->input->post('min-order', TRUE),
	// 		'discount' => $this->input->post('discount', TRUE),
	// 		'description' => $this->input->post('desc', TRUE),
	// 		'start_time' => $this->input->post('start-time', TRUE),
	// 		'end_time' => $this->input->post('end-time', TRUE),
	// 		'status' => 'Created'
	// 		);
	// 	$add_coupon = $this->Common->add_to_table('coupon_codes', $coupon);

	// 	$this->set_session_response_no_redirect('add', $add_coupon);

	// 	redirect('cms/coupon_view_all');
	// }

	// public function update_coupon(){
	// 	$this->load->model('Common', 'Common');
		
	// 	$coupon = array(
	// 		'discount' => $this->input->post('discount', TRUE),
	// 		'minimum_order' => $this->input->post('min-order', TRUE),
	// 		'description' => $this->input->post('desc', TRUE),
	// 		'start_time' => $this->input->post('start-time', TRUE),
	// 		'end_time' => $this->input->post('end-time', TRUE)
	// 		);

	// 	$upd_coupon = $this->Common->update_data_on_table('coupon_codes', 'coupon_code', $this->input->post('code', TRUE), $coupon);

	// 	$this->set_session_response_no_redirect('update', $upd_coupon);

	// 	redirect('cms/coupon_view_all');
	// }

	// public function delete_coupon(){
	// 	$this->load->model('Common', 'Common');
		
	// 	$del_coupon = $this->Common->delete_from_table_by_id('coupon_codes', 'coupon_code', $this->input->get('code', TRUE));

	// 	$this->set_session_response_no_redirect('delete', $del_coupon);

	// 	redirect('cms/coupon_view_all');
	// }

	
}
