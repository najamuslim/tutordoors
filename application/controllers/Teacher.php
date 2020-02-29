<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends MY_Controller {

	/* Pages start */
	function search($using){
		if($using=="dropdown"){
			$selected_city = $this->input->get('city', TRUE);
			$selected_province = $this->input->get('province', TRUE);
			$selected_program = $this->input->get('program', TRUE);
			$selected_course = $this->input->get('course', TRUE);
			
			if($selected_city <> "all" and $selected_course <> "all"){ // if 0 0
				$data['teachers'] = $this->Teacher_m->get_data_concat_course(array('occ.city_id' => $selected_city, 'cp.program_id' => $selected_program, 'toc.course_id' => $selected_course));
				$data['sub_page_title'] = ($data['teachers']<>false ? $this->lang->line('search_tutor_in').$data['teachers']->row()->city_name : $this->lang->line('search_tutor_not_found'));
			}
			else if($selected_city <> "all" and $selected_course=="all"){ // if 0 1
				$data['teachers'] = $this->Teacher_m->get_data_concat_course(array('occ.city_id' => $selected_city, 'cp.program_id' => $selected_program) );
				$data['sub_page_title'] = ($data['teachers']<>false ? $this->lang->line('search_tutor_in').$data['teachers']->row()->city_name : $this->lang->line('search_tutor_not_found'));
			}
			else if($selected_city == "all" and $selected_course <> "all"){ // if 1 0
				$data['teachers'] = $this->Teacher_m->get_data_concat_course(array('ci.province_id' => $selected_province, 'cp.program_id' => $selected_program, 'ci.queryable' => '1', 'toc.course_id' => $selected_course) );
				$data['sub_page_title'] = $data['sub_page_title'] = ($data['teachers']<>false ? $this->lang->line('search_tutor_in').$data['teachers']->row()->province_name : $this->lang->line('search_tutor_not_found'));
			}
			else if($selected_city == "all" and $selected_course == "all"){ // if 1 1
				$data['teachers'] = $this->Teacher_m->get_data_concat_course(array('ci.province_id' => $selected_province, 'cp.program_id' => $selected_program, 'ci.queryable' => '1') );
				$data['sub_page_title'] = $data['sub_page_title'] = ($data['teachers']<>false ? $this->lang->line('search_tutor_in').$data['teachers']->row()->province_name : $this->lang->line('search_tutor_not_found'));
			}
			
			if($selected_course<>"all"){
				$program_info = $this->Course_m->get_programs(array('program_id' => $selected_program));

				$course_info = $this->Course_m->get_courses(array('c.id' => $selected_course));
				$data['program_course_title'] = $program_info->row()->program_name.' - '.$course_info->row()->course_name; 
			}
				
		}
		else if($using=="searchbox"){
			$data['teachers'] = $this->Teacher_m->get_data_concat_course_by_name($this->input->get('q', TRUE));
			$data['sub_page_title'] = $this->lang->line('search_tutor_by_word').$this->input->get('q', TRUE);
		}
		else if($using=="category"){
			$data['teachers'] = $this->Teacher_m->get_data_by_course_category($this->input->get('cat', TRUE));
			// $get_cat = $this->Content_m->get_category_by_id($this->input->get('cat', TRUE));
			// $data['sub_page_title'] = 'Kategori '.$get_cat->category; 
			$data['sub_page_title'] = $this->lang->line('search_tutor_by_category').$data['teachers']->row()->courses;
		}

		if($data['teachers']<>false){
			foreach($data['teachers']->result_array() as $key =>$row){
					$user_info = $this->User_m->get_user_info($row['user_id']);
					$data['teachers']->result()[$key]->total_viewed = $user_info->total_viewed;
					// $data['teachers']->result()[$key]->total_taken_course = $this->Teacher_m->get_total_taken_course($row['user_level'], $row['user_id']);
				}
		}
		$data['counted_tutors_in_programs'] = $this->Course_m->count_verified_tutor_courses_under_programs();
		// print_r($data);
		$data['page_title'] = $this->lang->line('tutor_list');
		
		$this->open_page('teacher_list', $data);
	}

	function program(){
		$prog_id_s = $this->input->get('prog', true);
		if($prog_id_s=="all")
		{
			$get_programs = $this->Course_m->get_programs();
			$tutor_courses = array();
			foreach($get_programs->result() as $prog)
			{
				// get all course under program
				$under_program = $this->Course_m->get_verified_tutor_courses_under_program($prog->program_id);
				// print_r($this->db->last_query());
				if($under_program<>false and $under_program->row()->user_id <> '')
					foreach($under_program->result() as $row)
					{
						$tutor_info = $this->User_m->get_user_info($row->user_id);

						$tutor_courses[$prog->program_id][] = array(
							'user_id' => $row->user_id,
							'courses' => str_replace(',', ', ', $row->courses),
							'file_name' => isset($tutor_info->file_name) ? $tutor_info->file_name : "",
							'first_name' => isset($tutor_info->first_name) ? $tutor_info->first_name : "",
							'last_name' => isset($tutor_info->last_name) ? $tutor_info->last_name : "",
							'about_me' => isset($tutor_info->about_me) ? $tutor_info->about_me : "",
							'salary' => isset($tutor_info->salary_per_hour) ? $tutor_info->salary_per_hour : ""
							);

					}
			}
			$data['teachers'] = $tutor_courses;

			$data['page_title'] = $this->lang->line('tutor_list');
			$data['sub_page_title'] = $this->lang->line('education_level_all');

			$data['counted_tutors_in_programs'] = $this->Course_m->count_verified_tutor_courses_under_programs();
			
			// print_r($tutor_courses);
			$this->open_page('teacher_list_all_program', $data);
		}
		else
		{
			// program yang dicari bisa berupa program_id atau course_id, jadi...
			// jika tidak ketemu di table course_programs, cari di courses
			$prog_array = explode('-', $prog_id_s);
			$program_string = '';
			$tutor_courses = array();
			foreach($prog_array as $prog_id){
				// get the program name
				$program_info = $this->Course_m->get_programs(array('program_id' => $prog_id));
				if($program_info<>false){ // jika id berupa program id
					$program_string .= $program_info->row()->program_name.', ';
					// get all course under program
					$under_program = $this->Course_m->get_verified_tutor_courses_under_program($prog_id);
					if($under_program<>false and $under_program->row()->program_id <> '')
						foreach($under_program->result() as $row)
						{
							// get days
							$day_string = '';
							$day_array = array();
							$program_id_array = explode(',', $row->ids);
							foreach($program_id_array as $prog_id){
								$get_course_info = $this->Teacher_m->get_opened_course_data(array('toc.user_id' => $row->user_id, 'toc.course_id' => $prog_id));
								$day_info_array = explode(',', $get_course_info->row()->days);
								foreach($day_info_array as $day)
									if(!in_array($day, $day_array))
										array_push($day_array, $day);
							}
							$day_string = (empty($day_array) ? '' : 'day-'.implode(' day-', $day_array));

							$tutor_info = $this->User_m->get_user_info($row->user_id);

							$tutor_courses[] = array(
								'user_id' => $row->user_id,
								'courses' => str_replace(',', ', ', $row->courses),
								'file_name' => $tutor_info->file_name,
								'first_name' => $tutor_info->first_name,
								'last_name' => $tutor_info->last_name,
								'about_me' => $tutor_info->about_me,
								'salary' => $tutor_info->salary_per_hour,
								'age' => date_diff(date_create($tutor_info->birth_date), date_create('today'))->y,
								'days' => $day_string
								);

						}
				}
				else{
					// jika id berupa course id
					$get_course_info = $this->Course_m->get_courses(array('c.id' => $prog_id));
					if($get_course_info<>false){
						$program_string .= $get_course_info->row()->program_name.', ';
						$get = $this->Teacher_m->get_data_concat_course(array('toc.course_id' => $prog_id));
						if($get <> false)
							foreach($get->result() as $row){
								// get days
								$day_string = '';
								$day_array = array();
								$program_id_array = explode(',', $row->ids);
								foreach($program_id_array as $prog_id){
									$get_course_info = $this->Teacher_m->get_opened_course_data(array('toc.user_id' => $row->user_id, 'toc.course_id' => $prog_id));
									$day_info_array = explode(',', $get_course_info->days);
									foreach($day_info_array as $day)
										if(!in_array($day, $day_array))
											array_push($day_array, $day);
								}
								$day_string = (empty($day_array) ? '' : 'day-'.implode(' day-', $day_array));

								$tutor_info = $this->User_m->get_user_info($row->user_id);
								$tutor_courses[] = array(
									'user_id' => $row->user_id,
									'courses' => str_replace(',', ', ', $row->courses),
									'file_name' => $tutor_info->file_name,
									'first_name' => $tutor_info->first_name,
									'last_name' => $tutor_info->last_name,
									'about_me' => $tutor_info->about_me,
									'salary' => $tutor_info->salary_per_hour,
									'age' => date_diff(date_create($tutor_info->birth_date), date_create('today'))->y,
									'days' => $day_string
									);
							}
					}
				}
			}
			$program_string = rtrim($program_string, ', ');
			$data['teachers'] = $tutor_courses;

			$data['page_title'] = $this->lang->line('tutor_list');
			$data['sub_page_title'] = $this->lang->line('search_tutor_by_program').$program_string;

			$data['counted_tutors_in_programs'] = $this->Course_m->count_verified_tutor_courses_under_programs();
			
			$this->open_page('teacher_list_by_program', $data);
		}
		
	}
	
	function profile($user_id){
		$upd_info = $this->User_m->increment_total_user_viewed($user_id);
		// insert snapshot user view
		$snapshot = array(
			'id' => uniqid(),
			'user_id' => $user_id
			);
		$add_snapshot = $this->Common->add_to_table('snapshot_user_view', $snapshot);

		$level = 'teacher';
		$data['level'] = $level;
		// get user info
		$data['user_info'] = $this->User_m->get_user_info($user_id);
		if($data['user_info']->verified_user=="0")
			$this->show_error_page('235', $this->lang->line('error_tutor_isnot_verified_yet'));
		else{
			// if teacher, get the open city and course
			if($data['user_info']->user_level=="teacher"){
				$data['open_city'] = $this->Teacher_m->get_concat_city_by_teacher_id($user_id, FALSE);
				$data['open_course'] = $this->Teacher_m->get_verified_open_course_by_teacher_id($user_id, FALSE);
			}
			// $data['total_taken_course'] = $this->Teacher_m->get_total_taken_course($user_id);

			$data['page_title'] = $this->lang->line('profile').' '.$data['user_info']->first_name.' '.$data['user_info']->last_name;
			$data['sub_page_title'] = $this->lang->line('profile').' '.($level=="teacher" ? $this->lang->line('teacher') : $this->lang->line('student'));
			$data['image_thumb'] = '';
			if($data['user_info']->file_name <> "")
			{
				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/uploads/'.$data['user_info']->file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 120;

				$this->load->library('image_lib', $config);

				$data['image_thumb'] = str_replace($data['user_info']->file_extension, "", $data['user_info']->file_name).'_thumb'.$data['user_info']->file_extension;

				$this->image_lib->resize();
			}
				
			// $data['meta_social_title'] = $data['post_data']->title;
			// $data['meta_social_image'] = $data['prod_image']->file_name;
			// $data['meta_social_desc'] = $data['post_data']->content;
			
			$this->session->set_userdata('step_teacher_profile', 'on');
			$this->session->set_userdata('step_form_order', 'off');
			$this->session->set_userdata('step_review_order', 'off');
			$this->session->set_userdata('step_order_finish', 'off');

			$this->open_page('user/profile', $data);
		}
	}

	function edit_open_course(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'edit_open_course';
			$data['gm'] = 'dashboard';

			// get provinces
			$data['provinces'] = $this->Location_m->get_province();

			// get root course category
			$data['programs'] = $this->Course_m->get_programs();

			// get open city fo course
			$data['open_city'] = $this->Teacher_m->get_open_city('oc.user_id', $user_id);

			// get open course
			$data['open_course'] = $this->Teacher_m->get_course_data_by_userid($user_id);
			
			// open form
			$this->load->helper('form');

			$data['page_title'] = $this->lang->line('opened_course');
			$data['sub_page_title'] = $this->lang->line('opened_course');

			$data['days'] = array(
				'01' => $this->lang->line('day_monday'),
				'02' => $this->lang->line('day_tuesday'),
				'03' => $this->lang->line('day_wednesday'),
				'04' => $this->lang->line('day_thursday'),
				'05' => $this->lang->line('day_friday'),
				'06' => $this->lang->line('day_saturday'),
				'07' => $this->lang->line('day_sunday'),
				);

			$this->open_page('open_course', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function open_course_request(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($user_id);

			// get new open course request
			$data['open_request'] = $this->Order_m->get_open_order_by_teacherid($user_id);

			$data['am'] = 'new_course_request';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_request_new');
			$data['sub_page_title'] = $this->lang->line('course_request_new');
			$this->open_page('open_course_request', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function open_course_request_detail($order_id){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($user_id);

			$data['order_detail'] = $this->Order_m->get_order_course_detail($order_id);

			$data['am'] = 'new_course_request';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_request_detail');
			$data['sub_page_title'] = $this->lang->line('course_request_detail');
			$this->open_page('open_course_request_detail', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function confirm_course($order_id, $course_id){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($user_id);

			// get new open course request
			$data['course'] = $this->Order_m->get_order_with_course($order_id, $course_id);
			// $data['order_schedule'] = $this->Order_m->get_order_schedule_request($this->uri->segment(3));

			$data['am'] = 'new_course_request';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('confirm_course');
			$data['sub_page_title'] = $this->lang->line('confirm_course');
			$this->open_page('confirm_course', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function teach_schedule(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'teach_schedule';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_schedule');
			$data['sub_page_title'] = $this->lang->line('course_schedule');
			$data['level'] = 'teacher';

			$data['schedule'] = $this->Course_m->get_incompleted_enrollment(array('teacher_id' => $user_id));

			$this->open_page('teach_schedule', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function set_bank(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			$level = $this->session->userdata('level');

			$data = $this->get_data_for_profile($user_id);

			$data['bank'] = $this->User_m->get_user_bank($user_id);

			$data['am'] = 'edit_bank';
			$data['gm'] = 'payment';
			$data['page_title'] = $this->lang->line('bank_account_data');
			$data['sub_page_title'] = '';
			$this->open_page('teacher_set_bank', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function commission(){
		if($this->session->userdata('logged')=="in" and $this->session->userdata('level')=="teacher"){
			$user_id = $this->session->userdata('userid');
			$level = $this->session->userdata('level');

			$data = $this->get_data_for_profile($user_id);

			$this->load->model('Payroll_m');
			$data['commission'] = $this->Payroll_m->get_payroll_by_teacher_id($user_id);

			$data['am'] = 'teacher_comm';
			$data['gm'] = 'payment';
			$data['page_title'] = $this->lang->line('commission');;
			$data['sub_page_title'] = '';
			$this->open_page('teacher_commission', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function unverified(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'tutor-unverified',
			'title_page' => 'Unverified Tutors'
			);
		
		$data['teachers'] = $this->Teacher_m->get_unverified();
		$this->open_admin_page('admin/teacher/unverified', $data);
	}

	function verified(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'tutor-verified',
			'title_page' => 'Verified Tutors'
			);
		
		$data['teachers'] = $this->Teacher_m->get_verified();
		// print_r($this->db->last_query());
		$this->open_admin_page('admin/teacher/verified', $data);
	}

	function detail($teacher_id){
		$this->check_user_access();
		$this->load->model('Media_m');
		$data = array(
			'active_menu_id' => 'user-tutor',
			'title_page' => 'Tutor\'s Detail'
			);
		$data['teacher_general'] = $this->User_m->get_user_by_id($teacher_id);
		$data['teacher_info'] = $this->User_m->get_user_info_data($teacher_id);
		// get education experience
		$data['education_history'] = $this->User_m->get_education_history_by_userid($teacher_id);
		// get user bank
		$data['bank'] = $this->User_m->get_user_bank($teacher_id);
		// get online test assignment
		$this->load->model('Otest_m');
		$data['test_assignments'] = $this->Otest_m->get_assignment_data(array('teacher_id' => $teacher_id));
		$this->load->model('Payroll_m');

		// get opened city and course
		$data['open_city'] = $this->Teacher_m->get_city_verification(array('oc.user_id' => $teacher_id));
		$data['open_course'] = $this->Teacher_m->get_course_verification(array('oc.user_id' => $teacher_id));
		// print_r($this->db->last_query());

		$this->open_admin_page('admin/teacher/detail', $data);
	}

	function report_wilayah(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'report-tutor-per-wilayah',
			'title_page' => 'Jumlah Tutor Per Wilayah'
			);
		
		$data['verified'] = $this->Teacher_m->get_total_tutor_in_province('1');
		$data['unverified'] = $this->Teacher_m->get_total_tutor_in_province('0');
		$this->open_admin_page('admin/report/tutor_per_wilayah', $data);
	}

	function report_wilayah_kota(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'report-tutor-per-wilayah',
			'title_page' => 'Jumlah Tutor Per Kota',
			'verification_title' => $this->input->get('vf', true) == "1" ? "Verified" : "Unverified"
			);
		
		$this->load->model('Location_m');
		$get_province = $this->Location_m->get_province(array('province_id' => $this->input->get('pid', true)));
		$data['province_name'] = $get_province->row()->province_name;

		$data['data_kota'] = $this->Teacher_m->get_total_tutor_in_city($this->input->get('pid', true), $this->input->get('vf', true));
		$this->open_admin_page('admin/report/tutor_per_wilayah_kota', $data);
	}

	function report_wilayah_list_tutor(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'report-tutor-per-wilayah',
			'title_page' => 'Data Tutor Per Kota',
			'verification_title' => $this->input->get('vf', true) == "1" ? "Verified" : "Unverified"
			);
		
		$this->load->model('Location_m');
		$get_city = $this->Location_m->get_city(array('city_id' => $this->input->get('cid', true)));
		$data['city_name'] = $get_city->row()->city_name;

		$data['tutors'] = $this->Teacher_m->get_tutor_list_in_city($this->input->get('cid', true), $this->input->get('vf', true));
		$this->open_admin_page('admin/report/tutor_per_wilayah_kota_list', $data);
	}

	/* Pages end */

	/* Functions start */

	function check_input_days(){
		if(sizeof($this->input->post('days'))==0){
			$this->form_validation->set_message('check_input_days', '{field} '.$this->lang->line('error_require_one_or_more'));
            return FALSE;
		}
		else
			return TRUE;
	}

	function check_input_sessions(){
		if(sizeof($this->input->post('session'))==0){
			$this->form_validation->set_message('check_input_sessions', '{field} '.$this->lang->line('error_require_one_or_more'));
            return FALSE;
		}
		else
			return TRUE;
	}

	function add_open_course(){
		$user_id = $this->session->userdata('userid');
		$course_id = $this->input->post('course', TRUE);

		// $this->load->helper('form');
		$this->load->library('form_validation');

		$rules = array(
			array(
				'field' => 'course',
				'label' => $this->lang->line('course'),
				'rules' => 'required',
				'errors' => array('required' => '%s '.$this->lang->line('error_require'))
				),
			array(
				'field' => 'session',
				'label' => $this->lang->line('session'),
				'rules' => 'callback_check_input_sessions'
				),
			array(
				'field' => 'days',
				'label' => $this->lang->line('day'),
				'rules' => 'callback_check_input_days'
				)
			);
			// array(
			// 	'field' => 'fee',
			// 	'label' => $this->lang->line('fee_per_hour'),
			// 	'rules' => 'required',
			// 	'errors' => array('required' => '%s '.$this->lang->line('error_require'))
			// 	)
			// );
		
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = '301';
			$response['message'] = strip_tags(validation_errors());
		}
		else
		{
			$data = array(
				'user_id' => $this->session->userdata('userid'),
				'course_id' => $this->input->post('course', TRUE),
				'days' => implode(',', $this->input->post('days', true)),
				'session_hours' => implode(',', $this->input->post('session', TRUE))
				);
			
			$add_course = $this->Common->add_to_table('teacher_open_courses', $data);

			if($add_course->status){
				// get info of the course
				$info = $this->Teacher_m->get_course_data_by_courseid($add_course->output);

				$day_string = $this->course_lib->get_days_string($info->days);

                $response = array(
					'status' => '200',
					'id' => $info->id,
					'course_name' => $info->course_name,
					'program_name' => $info->program_name,
					'days' => $day_string,
					'session' => str_replace(',', ', ', $info->session_hours)
					);
			}
			else
				$response = array(
					'status' => '204',
					'message' => $add_course->output
					);
		}

		echo json_encode($response);
	}

	function update_open_course(){
		$open_course_id = $this->input->post('id', TRUE);

		// $this->load->helper('form');
		$this->load->library('form_validation');

		$rules = array(
			array(
				'field' => 'session',
				'label' => $this->lang->line('session'),
				'rules' => 'callback_check_input_sessions'
				),
			array(
				'field' => 'days',
				'label' => $this->lang->line('day'),
				'rules' => 'callback_check_input_days'
				)
			);
		
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = '301';
			$response['message'] = strip_tags(validation_errors());
		}
		else
		{
			$data = array(
				'days' => implode(',', $this->input->post('days', true)),
				'session_hours' => implode(',', $this->input->post('session', TRUE))
				);
			
			$add_course = $this->Common->update_data_on_table('teacher_open_courses', 'id', $open_course_id, $data);
		}

		redirect('teacher/edit_open_course');
	}

	function remove_open_course(){
		$id = $this->input->post('id', TRUE);

		$del_course = $this->Common->delete_from_table_by_id('teacher_open_courses', 'id', $id);

		if($del_course->status)
			$response['status'] = '200';
		else{
			$response['status'] = '204';
			$response['message'] = $del_course->output;
		}
			

		echo json_encode($response);
	}

	function add_open_city_course(){
		$user_id = $this->session->userdata('userid');
		$city = $this->input->post('city', TRUE);

		$data = array(
			'user_id' => $user_id,
			'city_id' => $city
			);
		
		$add_city = $this->Common->add_to_table('teacher_open_course_cities', $data);

		if($add_city->status){
			// get info of the city
			
			$get_info = $this->Course_m->get_open_city_by_user_city($user_id, $city);
			$info = $get_info->row();

			$response = array(
				'status' => '200',
				'id' => $info->id,
				'city' => $info->city_name,
				'province' => $info->province_name);
		}
		else{
			$response = array(
				'status' => '204',
				'message' => $add_city->output
				);
		}

		
		echo json_encode($response);
	}

	function remove_open_city_course(){
		$id = $this->input->post('id', TRUE);

		$del_city = $this->Common->delete_from_table_by_id('teacher_open_course_cities', 'id', $id);

		if($del_city->status)
			$response['status'] = '200';
		else{
			$response['status'] = '204';
			$response['message'] = $del_city->output;
		}
			

		echo json_encode($response);
	}

	function verify(){
		$id = $this->input->get('id', TRUE);
		// $salary = $this->input->get('sal', TRUE);

		// $update_data = array('user_id'=>$new_id, 'verified_user'=>'1');
		$update_data = array('verified_user'=>'1');
		$upd = $this->Common->update_data_on_table('users', 'user_id', $id, $update_data);

		// // input salary
		// $upd_data_info = array('salary_per_hour'=>$salary);
		// $check_exist_info = $this->User_m->get_user_info_data($id);
		
		// if($check_exist_info<>false) // if exist
		// 	$upd = $this->Common->update_data_on_table('user_info_data', 'user_id', $id, $upd_data_info);
		// 	// $upd = $this->Common->update_data_on_table('user_info_data', 'user_id', $new_id, $upd_data_info);
		// else{
		// 	// $upd_data_info['user_id'] = $new_id;
		// 	$upd_data_info['user_id'] = $id;
		// 	$add_info = $this->Common->add_to_table('user_info_data', $upd_data_info);
		// }

		// kirim notifikasi ke tutor
		$notif = array(
        	'category' => 'teacher_verified',
        	'title' => $this->lang->line('verification_teacher_done'),
        	'content' => $this->lang->line('verification_teacher_done_message_1').$this->lang->line('verification_teacher_done_message_2'),
        	// 'content' => $this->lang->line('verification_teacher_done_message_1').$new_id.$this->lang->line('verification_teacher_done_message_2'),
        	'sender_id' => 'admin',
        	'receiver_id' => $id // teacher ID
        	);
        $this->notification->insert($notif);

        // send push notification to mobile application
        $this->load->library('Push_Notification_Lib');
        $push_result = $this->push_notification_lib->send($id, $notif['title'], $this->lang->line('verification_teacher_done_message_1'));

        // kirim ke user ID baru
        // $notif = array(
        // 	'category' => 'teacher_verified',
        // 	'title' => 'Verifikasi Guru OK',
        // 	'content' => $this->lang->line('verification_teacher_done_message_1').$new_id.$this->lang->line('verification_teacher_done_message_3'),
        // 	'sender_id' => 'admin',
        // 	'receiver_id' => $new_id // teacher ID
        // 	);
        // $this->notification->insert($notif);

		redirect('teacher/unverified');
	}

	function unverify(){
		$id = $this->input->get('id', TRUE);
		// $salary = $this->input->get('sal', TRUE);

		// $update_data = array('user_id'=>$new_id, 'verified_user'=>'1');
		$update_data = array('verified_user'=>'0');
		$upd = $this->Common->update_data_on_table('users', 'user_id', $id, $update_data);

		redirect('teacher/verified');
	}

	// function request_delete($part, $id){
	// 	if($part=="city")
	// 		$table = 'teacher_open_course_cities';
	// 	else if($part=="course")
	// 		$table = 'teacher_open_courses';

	// 	$upd_data = array('delete_request' => '1');
	// 	$this->load->model('Common', 'Common');
	// 	$upd = $this->Common->update_data_on_table($table, 'id', $id, $upd_data);

	// 	if($upd->status){
	// 		// give notification to admin
	//         $this->load->library('notification');
	//         $notif = array(
	//         	'category' => 'open_'.$part.'_to_delete',
	//         	'title' => 'Request: Open '.ucwords($part).' to Delete',
	//         	'content' => 'UserID '.$user_id.' requested a '.$part.' to delete. Need verification by admin immediately.',
	//         	'sender_id' => $user_id,
	//         	'receiver_id' => 'admin'
	//         	);
	//         $add_notif = $this->notification->insert($notif);
	// 	}

	// 	redirect('teacher/edit_open_course');
	// }

	// function delete_city(){
	// 	foreach($this->input->post('check') as $id){
	// 		if($this->input->post('action')=="delete"){
	// 			$del = $this->Common->delete_from_table_by_id('teacher_open_course_cities', 'id', $id);
	// 			$this->set_session_response_no_redirect('delete', $del);
	// 		}
	// 		else if($this->input->post('action')=="reject"){
	// 			$reject_data = array('delete_request' => '0');
	// 			$upd = $this->Common->update_data_on_table('teacher_open_course_cities', 'id', $id, $reject_data);
	// 			$this->set_session_response_no_redirect('update', $upd);
	// 		}
	// 	}
		
	// 	redirect('teacher/request_for_delete/city');
	// }

	// function delete_course(){
	// 	foreach($this->input->post('check') as $id){
	// 		if($this->input->post('action')=="delete"){
	// 			$del = $this->Common->delete_from_table_by_id('teacher_open_courses', 'id', $id);
	// 			$this->set_session_response_no_redirect('delete', $del);
	// 		}
	// 		else if($this->input->post('action')=="reject"){
	// 			$reject_data = array('delete_request' => '0');
	// 			$upd = $this->Common->update_data_on_table('teacher_open_courses', 'id', $id, $reject_data);
	// 			$this->set_session_response_no_redirect('update', $upd);
	// 		}
	// 	}
		
		
	// 	redirect('teacher/request_for_delete/course');
	// }

	function download($media_id){
		$this->load->helper('myfunction_helper');
		$this->load->model('Media_m');

		$file_name = $this->Media_m->get_file_name($media_id);
		download_file('./assets/uploads/'.$file_name, $file_name);
	}

	// function update_salary_unit_hour()
	// {
	// 	$data = array('salary_per_hour' => $this->input->post('sal', true));
	// 	$upd = $this->Common->update_data_on_table('user_info_data', 'user_id', $this->input->post('id', true), $data);
	// 	if($upd->status)
	// 		$response['status'] = '200';
	// 	else
	// 		$response = array(
	// 			'status' => '204',
	// 			'message' => $upd->output
	// 			);
	// 	echo json_encode($response);
	// }

	function export($what)
	{
		//load the excel library
		$this->load->library('excel');
		$this->load->helper('excel_helper');
		// styling
		$style_top_header = set_top_header();
		$alignment = set_alignment();

		if($what=="verified")
		{
			$data = $this->Teacher_m->get_verified();
			$header = array(
				'USER ID', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'PHONE', 'SALARY PER 1.5 HOURS', 'DEGREE', 'MAJOR', 'INSTITUTION'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Verified tutor');

	        $this->excel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($alignment);

			// filling the header
			$col = 0; // starting at A1
			$row = 1;
			foreach($header as $head){
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $head);
				$col++;
			}
			// filling the content
			$col = 0; // starting at A2
			$row = 2;
			foreach($data->result() as $tutor)
			{
				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $tutor->user_id, PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $tutor->email_login); // B3
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $tutor->first_name); // C3
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $tutor->last_name); // D3
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, date_format(new DateTime($tutor->join_date), 'd M Y H:i')); // E3
				// set the phone as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$row, $tutor->phone_1, PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, 'IDR '.number_format($tutor->salary_per_hour, 0, ',', '.')); // G3

				// get latest education
                $get_latest_edu = $this->User_m->get_education_history_by_userid($tutor->user_id);

                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $get_latest_edu<>false ? $get_latest_edu->row()->degree : '-'); // H2
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $get_latest_edu<>false ? $get_latest_edu->row()->major : '-'); // I2
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $get_latest_edu<>false ? $get_latest_edu->row()->institution : '-'); // J2
				$row++;
			}

			// set auto width
			foreach(range('A','J') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Verified Tutor List.xls'; //save our workbook as this file name

		}
		else if($what=="unverified")
		{
			$data = $this->Teacher_m->get_unverified();
			$header = array(
				'USER ID', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'PHONE', 'DEGREE', 'MAJOR', 'INSTITUTION'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Unverified tutor');

	        $this->excel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($alignment);

			// filling the header
			$col = 0; // starting at A1
			$row = 1;
			foreach($header as $head){
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $head);
				$col++;
			}
			// filling the content
			$col = 0; // starting at A2
			$row = 2;
			foreach($data->result() as $tutor)
			{
				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $tutor->user_id, PHPExcel_Cell_DataType::TYPE_STRING); //A2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $tutor->email_login); // B2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $tutor->first_name); // C2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $tutor->last_name); // D2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, date_format(new DateTime($tutor->join_date), 'd M Y H:i')); // E2
				// set the phone as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$row, $tutor->phone_1, PHPExcel_Cell_DataType::TYPE_STRING); // F2
				// get latest education
                $get_latest_edu = $this->User_m->get_education_history_by_userid($tutor->user_id);

                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $get_latest_edu<>false ? $get_latest_edu->row()->degree : '-'); // G2
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $get_latest_edu<>false ? $get_latest_edu->row()->major : '-'); // H2
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $get_latest_edu<>false ? $get_latest_edu->row()->institution : '-'); // I2

				$row++;
			}

			// set auto width
			foreach(range('A','I') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Unverified Tutor List.xls'; //save our workbook as this file name

		}

		header('Content-Type: application/vnd.ms-excel'); //mime type
	 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}

	function wizard_add_area(){
		$tutor_id = $this->input->post('tid', true);
		$areas = $this->input->post('area', true);
		if($tutor_id <> "" and $areas <> ""){
			$area_array = explode('-', $areas);
			foreach($area_array as $area_id){
				$data = array(
					'user_id' => $tutor_id,
					'city_id' => $area_id
					);
				
				$add_city = $this->Common->add_to_table('teacher_open_course_cities', $data);
				$this->push_if_transaction_error($add_city);
			}
		}
		else
			array_push($this->any_error, 'Inputan tidak lengkap.');

		if(empty($this->any_error))
			$response = array('status'=>'200', 'message'=>'');
		else{
			$message = '';
			foreach($this->any_error as $msg)
				$message .= $msg.'; ';
			$response = array('status'=>'204', 'message'=>$message);
		}

		echo json_encode($response);
	}

	function wizard_add_program(){
		$tutor_id = $this->input->post('tid', true);
		$progs = $this->input->post('prog', true);
		$days = $sessions = '';
		if($this->input->post('day', true)=="" or $this->input->post('sess', true)=="")
			array_push($this->any_error, $this->lang->line('day_and_session_are_required'));
		else{
			$day_array = explode('-', $this->input->post('day'));
			foreach($day_array as $day_id)
				$days .= $day_id.',';
			$days = rtrim($days, ',');

			$sess_array = explode('-', $this->input->post('sess'));
			foreach($sess_array as $sess_id)
				$sessions .= $sess_id.',';
			$sessions = rtrim($sessions, ',');

			if($tutor_id <> "" and $progs <> ""){
				$prog_array = explode('-', $progs);
				foreach($prog_array as $prog_id){
					$data = array(
						'user_id' => $tutor_id,
						'course_id' => $prog_id,
						'days' => $days,
						'session_hours' => $sessions
						);
					
					$add_course = $this->Common->add_to_table('teacher_open_courses', $data);
					$this->push_if_transaction_error($add_course);
				}
			}
			else
				array_push($this->any_error, $this->lang->line('program_is_required'));
		}
		
		if(empty($this->any_error))
			$response = array('status'=>'200', 'message'=>'');
		else{
			$message = '';
			foreach($this->any_error as $msg)
				$message .= $msg.'. ';
			$response = array('status'=>'204', 'message'=>$message);
		}

		echo json_encode($response);
	}

	function get_open_course_by_id($id){
		// get info of the course
		$info = $this->Teacher_m->get_course_data_by_courseid($id);

        $response = array(
			'status' => '200',
			'id' => $info->id,
			'course_name' => $info->course_name,
			'program_name' => $info->program_name,
			'days' => explode(',', $info->days),
			'session' => explode(',', $info->session_hours)
			);

		echo json_encode($response);
	}

	/* Functions end */	
}