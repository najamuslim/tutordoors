<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $admin_granted = false;
	public $logged_in = false;
	public $any_error = array();


	public function __construct() {
		parent::__construct();
		
		date_default_timezone_set('Asia/Jakarta');

		$this->is_logged_in();
		$this->cms_has_access();
		
		$this->load->model('Course_m');	
		$this->load->model('Teacher_m');
		$this->load->model('Student_m');
		$this->load->model('Order_m');
		$this->load->model('Location_m');
		$this->load->model('Content_m');
		$this->load->model('User_m');
		$this->load->model('Common');

		// load language in session, if no language session then back to config language
		if($this->session->userdata('language')==""){
			$this->lang->load('id','indonesia');
			$this->session->set_userdata('language', 'id');
			$this->session->set_userdata('idiom_language', 'indonesia');
		}
		else
			$this->lang->load($this->session->userdata('language'), $this->session->userdata('idiom_language'));

		// assign currency
		if($this->session->userdata('currency')=="")
			$this->session->set_userdata('currency', 'IDR');
	}	
	
	function is_logged_in() {
	   	$user = $this->session->userdata('logged');
	   	if($user=="")
	   		$this->logged_in = false;
	   	else
	   		$this->logged_in = true;
	}

	function cms_has_access(){
		$user_level = $this->session->userdata('level');
		if($user_level=="student" or $user_level=="teacher")
			$this->admin_granted = false;
		else 
			$this->admin_granted = true;
	}

	function open_page($file_name, $data=null){
		if($this->session->userdata('curr_page') <> current_url()){
			$this->session->set_userdata('prev_page', $this->session->userdata('curr_page'));
			$this->session->set_userdata('curr_page', current_url());
		}

		if($this->uri->segment(1).'/'.$this->uri->segment(2) == "frontpage/checkout" ){
			$this->session->set_userdata('prev_page', $this->session->userdata('curr_page'));
		}

		/*$get_options = $this->Content_m->get_all_options();
		foreach($get_options->result() as $param){
			$options[$param->parameter_name]['desc'] = $param->description;
			$options[$param->parameter_name]['value'] = $param->parameter_value;
		}
		$footer['options'] = $options;*/

		$this->load->view('iknow/header_2', $data);
		$this->load->view('iknow/'.$file_name, $data);
		$this->load->view('iknow/footer');
	}

	function open_admin_page($file_name, $data=null){
		// if($this->logged_in){
		// 	if($this->admin_granted and $this->session->userdata('level')<>""){
				// get notifications
		$this->load->library('notification');
		$this->load->helper('menu_builder_helper');
		$data['notifications'] = $this->notification->get_data();
		$data['notif_unread'] = $this->notification->count_unread();

		$data['navigator'] = $this->Content_m->get_top_navigator_by_user_level($this->session->userdata('level'));

		$this->load->model('Software_m');
		$data['latest_version'] = $this->Software_m->get_latest_version('tutordoors.com');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar_left');
		$this->load->view($file_name);
			// }
			// else
			// 	print_r($this->logged_in);
				// show_error('Anda tidak boleh mengakses halaman ini.', 403);
		// }
		// else
		// 	redirect('cms/login');
	}

	function show_error_page($error_no, $message){
		$data['error_no'] = $error_no;
		$data['error_message'] = $message;
		$data['page_title'] = 'Pesan kesalahan';
		$this->open_page('error_message', $data);
	}

	function show_success_page($error_no, $message){
		$data['error_no'] = $error_no;
		$data['error_message'] = $message;
		$data['page_title'] = 'Sukses';
		$this->open_page('error_message', $data);
	}

	function get_data_for_profile($user_id){
		$data['user_info'] = $this->get_user_info($user_id);
		$data['image_thumb'] = '';
		if($data['user_info']<>false)
			if($data['user_info']->file_name<>"")
				$data['image_thumb'] = set_image_thumb_name($data['user_info']);
		$this->load->library('notification');
		$data['unread_message'] = $this->notification->count_unread_by_userid($user_id);

		return $data;
	}

	function get_user_info($user_id){
		$user_info = $this->User_m->get_user_info($user_id);

		if($user_info<>false and $user_info->file_name<>""){
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/uploads/'.$user_info->file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 140;
			$config['height'] = 140;

			$this->load->library('image_lib', $config);

			$this->image_lib->resize();
		}

		return $user_info;
	}

	function check_user_access(){
		if(!$this->logged_in)
			redirect('cms/login');
		if(!$this->admin_granted)
			show_error('Anda tidak boleh mengakses halaman ini.', 403);
	}

	function set_session_response_no_redirect($transaction, $trans_result){
		if($trans_result->status){
			$this->session->set_flashdata('err_no', '200');
			$this->session->set_flashdata('err_msg', $this->lang->line('response_'.$transaction.'_ok'));
		}
		else{
			array_push($this->any_error, $trans_result->output);
			$this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->any_error);
		}
	}

	function set_session_response_no_redirect_by_error($transaction){
		if(empty($this->any_error)){
			$this->session->set_flashdata('err_no', '200');
			$this->session->set_flashdata('err_msg', $this->lang->line('response_'.$transaction.'_ok'));
		}
		else{
			$this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->any_error);
		}
	}

	function push_if_transaction_error($trans_result){
		if(!$trans_result->status)
			array_push($this->any_error, $trans_result->output);
	}

	function export_query($query){
		$add = $this->Common->add_to_table('query_strings', array('query'=>$query));
	}
}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */
