<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontpage extends MY_Controller {
	public function __construct() {
        parent::__construct();
	}

	/* pages begin */

	function generate_captcha(){
		//generate captcha
		$this->load->helper('captcha');
		$captcha_data = array(
			'word' => rand(1000, 9999),
			'img_path' => 'assets/captcha/',
			'img_url' => base_url().'assets/captcha/',
			//'font_path' => './path/to/fonts/texb.ttf',
			'img_width' => '150',
			'img_height' => 30,
			'expiration' => 7200
			);

		$cap = create_captcha($captcha_data);
		$insert_cap = array(
			'captcha_time' => $cap['time'],
			'ip_address' => $this->input->ip_address(),
			'word' => $cap['word']
		);
		$query = $this->db->insert_string('captcha', $insert_cap);
		$this->db->query($query);
		//echo $cap['image'];
		$captcha = $cap['image'];

		return $captcha;
	}

	public function home(){ 
		// get provinces
		$data['provinces'] = $this->Location_m->get_province(array("queryable" => "1"));

		// get programs
		$data['programs'] = $this->Course_m->get_programs();
		// foreach($data['programs']->result() as $program){
		// 	$get_teachers = $this->Teacher_m->get_data_concat_course_by_education_level($program->program_id);
			
		// 	if($get_teachers<>false){
		// 		// $this->load->model('User_m', 'user');
		// 		foreach($get_teachers->result() as $teacher){
		// 			// get more user info
		// 			$user_info = $this->User_m->get_user_info($teacher->user_id);
		// 			$total_viewed = $user_info->total_viewed;
		// 			// $total_taken_course = $this->Teacher_m->get_total_taken_course($teacher->user_id);

		// 			$data['teachers'][$program->program_id][] = array(
		// 				'user_id' => $teacher->user_id,
		// 				'level' => $teacher->user_level,
		// 				'course' => str_replace(',', ', ', $teacher->courses),
		// 				'first_name' => $teacher->first_name,
		// 				'last_name' => $teacher->last_name,
		// 				// 'sex' => $teacher->sex,
		// 				'image_file' => $teacher->file_name,
		// 				'about_me' => $teacher->about_me,
		// 				'total_viewed' => $total_viewed,
		// 				// 'total_taken_course' => $total_taken_course
		// 				);
		// 		}
		// 	}
		// }

		// get testimonials
		$testimonials = $this->Content_m->get_post_data(array('type' => 'post', 'b.slug' => 'testimoni-siswa'), 5);
		if($testimonials<>false){
			foreach($testimonials->result() as $testi){
				// get post image
				$image = $this->Content_m->get_post_image($testi->primary_image);
				$data['testimonials'][] = array(
					'id' => $testi->id,
					'name' => $testi->title,
					'testi' => $testi->content,
					'photo' => $image->file_name,
					'lang_id' => $testi->lang_id
					);
			}
		}

		// get latest articles
		$this->load->helper('text');
		$latest_articles = $this->Content_m->get_post_data(array('type' => 'post', 'b.slug' => 'article', 'lang_id' => $this->session->userdata('language')), 3);
		if($latest_articles<>false){
			foreach($latest_articles->result() as $article){
				// get post image
				$image = $this->Content_m->get_post_image($article->primary_image);
				$data['latest_articles'][] = array(
					'id' => $article->id,
					'title' => $article->title,
					'truncated_content' => character_limiter($article->content, 150),
					'photo' => $image->file_name,
					'post_dd' => date_format(new DateTime($article->creation_datetime), 'd'),
					'post_mmyy' => date_format(new DateTime($article->creation_datetime), 'M Y'),
					'creator' => $article->first_name.' '.$article->last_name,
					'url' => $article->url
					);
			}
		}

		$data['page_title'] = 'Home';
		// print_r($data['courses']);
		$this->open_page('landing-page/home-2', $data);
	}

	function order_received($order_id=null){
		if($this->session->userdata('logged')=="in"){
			$this->load->model('Bank_m');
			// get order header
			$data['order'] = $this->Order_m->get_order_by_id($order_id);
			// get provinces
			$data['provinces'] = $this->Location_m->get_province();

			// get programs
			$data['programs'] = $this->Course_m->get_programs();
			// get order detail
			// $data['detail'] = $this->Order_m->get_order_detail($order_id);
			// // get order shipping
			// $data['ship'] = $this->Order_m->get_order_shipping($order_id);
			// get list of bank
			// $data['banks'] = $this->Bank_m->get_bank_data('active', 'true');
			$data['page_title'] = $this->lang->line('order_success');
			$data['meta_social_title'] = '';
			$data['meta_social_image'] = '';
			$data['meta_social_desc'] = '';

			// use session to store checkpoint
			$this->session->set_userdata('step_teacher_profile', 'off');
			$this->session->set_userdata('step_form_order', 'off');
			$this->session->set_userdata('step_review_order', 'off');
			$this->session->set_userdata('step_order_finish', 'on');

			$this->open_page('order_success', $data);
		}
		else 
			$this->show_error_page(204, $this->lang->line('order_received_error_not_logged_in'));
		
	}

	function payment_confirmation(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($user_id);

			$this->load->model('Bank_m');

			if($this->input->get('bank', true)<>""){
				$data['selected_bank'] = $this->Bank_m->get_bank_data('bank_name', strtoupper($this->input->get('bank', true)));
			}

			$data['banks'] = $this->Bank_m->get_bank_data('active', 'true');

			$data['page_title'] = $this->lang->line('confirm_payment');
			$data['am'] = 'payment_confirmation';
			$data['gm'] = 'payment';
			$data['sub_page_title'] = $this->lang->line('confirm_payment');
			$data['meta_social_title'] = $this->lang->line('confirm_payment');
			$data['meta_social_image'] = '';
			$data['meta_social_desc'] = $this->lang->line('confirm_payment_here_after_do_payment');

			$this->open_page('payment_confirmation', $data);	
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
		
	}

	function test(){
		$this->load->view('test');
	}

	function login(){
		$data['page_title'] = 'Login User';
		if($this->session->userdata('logged')=="in")
			redirect(base_url());
		else{
			$this->open_page('user/login', $data);
		}
	}

	function signup($level){
		// $data['captcha'] = $this->generate_captcha();
		$data['page_title'] = 'Sign Up!';
		if($this->session->userdata('logged')=="in")
			redirect(base_url());
		else{
			// get provinces
			// $data['provinces'] = $this->Location_m->get_province();
			$this->open_page('user/signup_'.$level, $data);
			// print_r($data);
		}
	}
	
	function my_account(){
		if($this->logged_in and !$this->admin_granted){
			$user_id = $this->session->userdata('userid');
			
			$this->load->model('Media_m');
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'dashboard';
			$data['gm'] = 'dashboard';
			// for teacher
			// if($this->session->userdata('level')=="teacher"){
			// 	// get open courses
			// 	$data['my_course'] = $this->Order_m->get_open_order_by_teacherid($user_id); 
			// }

			// for student
			if($this->session->userdata('level')=="student"){
				
				$data['course_order'] = $this->Order_m->get_open_order_without_course_by_studentid($user_id);

				// get new open course request
				$this->load->model('Invoice_m');
				$data['invoices'] = $this->Invoice_m->get_invoices(array('i.user_id' => $user_id, 'status' => 'Open'));

				// get course schedule
				$data['schedule'] = $this->Course_m->get_incompleted_enrollment(array('student_id' => $user_id));
			}
			// for teacher
			else if($this->session->userdata('level')=="teacher"){
				// get course schedule
				$data['schedule'] = $this->Course_m->get_incompleted_enrollment(array('teacher_id' => $user_id));
				// get new open course request
				$data['open_request'] = $this->Order_m->get_open_order_by_teacherid($user_id);
			}

			$data['page_title'] = 'My Account';
			$data['sub_page_title'] = 'Dashboard '.($this->session->userdata('level')=="teacher" ? 'Tutor' : 'Siswa');
			if($this->session->userdata('level')=="teacher")
				$this->open_page('user/dashboard_tutor', $data);
			else if($this->session->userdata('level')=="student")
				$this->open_page('user/dashboard_student', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function messages(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($user_id);

			$this->load->library('notification');
			$data['notifications'] = $this->notification->get_message_by_direction($user_id, 'in');

			// update read status
			if($data['notifications']<>false){
				foreach($data['notifications']->result() as $msg){
					$data_upd = array('has_been_read' => 'true');
					if($msg->receiver_id==$user_id)
						$upd = $this->Common->update_data_on_table('notifications', 'id', $msg->id, $data_upd);
				}
			}

			$data['am'] = 'notification';
			$data['gm'] = 'dashboard';
			$data['page_title'] = 'Notification';
			$data['sub_page_title'] = $this->lang->line('notification');
			$this->open_page('notification', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function running_course(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			$level = $this->session->userdata('level');

			$data = $this->get_data_for_profile($user_id);

			$data['running_course'] = $this->Course_m->get_course_enrollment_by_userid($level, $user_id, 'false');
			$data['level'] = $level;                        

			$data['am'] = 'running_course';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_running');
			$data['sub_page_title'] = $this->lang->line('course_running');
			$this->open_page('running_course', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function fill_course_monitoring($enroll_id){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			$level = $this->session->userdata('level');

			$data = $this->get_data_for_profile($user_id);

			$data['monitoring'] = $this->Course_m->get_course_monitoring_by_enrollid($enroll_id);
			
			$data['level'] = $level;

			$enroll_info = $this->Course_m->get_course_enrollment($enroll_id);
			// get info of the course
			$course_info = $this->Course_m->get_courses(array('c.id' => $enroll_info->course_id));
			$data['course_name'] = $course_info->row()->program_name.' - '.$course_info->row()->course_name;
			$data['student_name'] = $enroll_info->student_fn.' '.$enroll_info->student_ln;
			$data['teacher_name'] = $enroll_info->teacher_fn.' '.$enroll_info->teacher_ln;

			$data['am'] = 'running_course';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_absence');
			$data['sub_page_title'] = $this->lang->line('course_absence');
			$this->open_page('fill_course_monitoring', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function completed_course(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			$level = $this->session->userdata('level');

			$data = $this->get_data_for_profile($user_id);

			$data['completed_course'] = $this->Course_m->get_course_enrollment_by_userid($level, $user_id, 'true');
			$data['level'] = $level;


			$data['am'] = 'completed_course';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_completed');
			$data['sub_page_title'] = $this->lang->line('course_completed');
			$this->open_page('completed_course', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}
	
	public function blog(){
		// setlocale(LC_ALL, 'IND');
		$cat_slug = $this->uri->segment(3);
		$limit_start = $this->input->get('ls', TRUE);
		$limit_end = $this->input->get('le', TRUE);

		// get post
		if($limit_start=="")
			$get_post = $this->Content_m->get_post_category_slug($cat_slug);
		else
			$get_post = $this->Content_m->get_post_category_slug($cat_slug, $limit_start, $limit_end);

		if($get_post==false)
			$data['posts'] = false;
		else{
			// check if the post category match the slug
			foreach($get_post as $post){
				$image = $this->Content_m->get_post_image($post->primary_image);
				$data['posts'][] = array(
					'id' => $post->id,
					'title' => $post->title,
					'content' => $post->content,
					'tags' => $post->tags,
					'category' => $post->category_name,
					'image' => ($image==false ? '': $image->file_name),
					'timestamp' => $post->creation_datetime
					);
			}
		}

		$data['group_month'] = $this->Content_m->grouping_blog_month();

		$data['page_title'] = $post->title;
		$data['meta_social_title'] = $post->title;
		$data['meta_social_image'] = '';
		$data['meta_social_desc'] = '';

		$this->open_page('blog_view', $data);
	}

	public function page_view(){
		$url_page = $this->uri->segment(2);

		$data['page'] = $this->Content_m->get_page_by_url($url_page);
		$data['best_selling'] = $this->display_best_selling_product();
		// $data['group_month'] = $this->Content_m->grouping_blog_month();

		$data['page_title'] = $data['page']->title;
		$data['meta_social_title'] = $data['page']->title;
		$data['meta_social_image'] = '';
		$data['meta_social_desc'] = '';

		$this->open_page('page_view', $data);
	}

	public function reset_done(){
		$this->open_page('reset_password_completed');
	}

	function prepare_order(){
		$teacher_id = $this->input->get('tid', TRUE);
		// $course_id = $this->input->get('cid', TRUE);

		if($this->session->userdata('logged')<>"in"){
			redirect('login');
		}
		else{
			// get course data
			$data['courses'] = $this->Teacher_m->get_verified_open_course_by_teacher_id($teacher_id, FALSE);
			// get open city fo course
			$data['cities'] = $this->Teacher_m->get_concat_city_by_teacher_id($teacher_id, FALSE);
			// get teacher data
			$data['teacher_info'] = $this->User_m->get_user_by_id($teacher_id);
			
			$data['page_title'] = $this->lang->line('order_form');

			// use session to store checkpoint
			$this->session->set_userdata('step_teacher_profile', 'on');
			$this->session->set_userdata('step_form_order', 'on');
			$this->session->set_userdata('step_review_order', 'off');
			$this->session->set_userdata('step_order_finish', 'off');
			
			$this->open_page('preparing_order', $data);
		}
	}

	function how_to_pay(){
		$this->load->model('Bank_m');
		$data['banks'] = $this->Bank_m->get_bank_data('active', 'true');
		
		$data['page_title'] = $this->lang->line('how_to_pay');
		$data['meta_social_title'] = $this->lang->line('how_to_pay');
		$data['meta_social_image'] = '';
		$data['meta_social_desc'] = '';

		$this->open_page('how_to_pay', $data);
		
	}

	function registration_wizard($user_level){
		$data['page_title'] = 'User Registation Wizard';
		// get provinces
		$data['provinces'] = $this->Location_m->get_province();
		// get root course category
		$data['programs'] = $this->Content_m->get_root_category('course');

		$data['first_name'] = 'Ocky';
		$data['last_name'] = 'Army';
		$data['email'] = 'ocky.armi@gmail.com';

		$this->open_page('wizard_user_registration', $data);
	}


	/* end pages */

	function submit_comment(){
		$data = array(
			'post_id' => $this->input->post('post-id', TRUE),
			'content' => $this->input->post('review', TRUE),
			'rating' => $this->input->post('rating', TRUE),
			'user_id' => $this->session->userdata('userid')
			);
		$this->Common->add_to_table('post_comments', $data);

		redirect('product/single/'.$this->input->post('last-url', TRUE));
	}

	

	function change_language($lang, $idiom){
		$this->session->set_userdata('language', $lang);
		$this->session->set_userdata('idiom_language', $idiom);

		redirect($this->session->userdata('curr_page'));
	}

	function submit_question(){
		$data = array(
			'name' => $this->input->post('name', true),
			'email' => $this->input->post('email', true),
			'category' => $this->input->post('category', true),
			'phone' => $this->input->post('phone', true),
			'subject' => $this->input->post('subject', true),
			'message' => $this->input->post('message', true)
			);
		$add = $this->Common->add_to_table('contact_form_messages', $data);

		$this->load->library('notification');
		// 5.1 to student
        $notif = array(
        	'category' => 'new_contact_message',
        	'title' => 'New message on contact form',
        	'content' => 'There is a message from '.$this->input->post('name', true),
        	'receiver_id' => 'admin',
        	'sender_id' => 'system'
        	);
        $this->notification->insert($notif);

		redirect('content/contact');
	}
        
        
        
}
