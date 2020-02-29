<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends MY_Controller {
	function search($using){
		if($using=="dropdown"){
			$selected_course = $this->input->get('course', TRUE);
			if($selected_course=="all"){
				$data['teachers'] = $this->Teacher_m->get_data_concat_course(array('occ.city_id' => $this->input->get('city', TRUE), 'cp.program_id' => $this->input->get('program', TRUE)) );
			}
			else
				$data['teachers'] = $this->Teacher_m->get_data_concat_course(array('occ.city_id' => $this->input->get('city', TRUE), 'cp.program_id' => $this->input->get('program', TRUE), 'toc.course_id' => $this->input->get('course', TRUE)));

			$data['sub_page_title'] = ($data['teachers']<>false ? $this->lang->line('search_tutor_in').$data['teachers']->row()->city_name : $this->lang->line('search_tutor_not_found'));
			if($selected_course<>"all"){
				$program_info = $this->Course_m->get_programs(array('program_id' => $this->input->get('program', true)));

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
			// $tutor_courses = array();
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
						$program_string .= $program_info->row()->program_name.', ';
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
				'session_hours' => implode(',', $this->input->post('session', TRUE)),
				'verified' => '1'
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
					'session' => str_replace(',', ', ', implode(',', $this->input->post('session', TRUE)))
					);

				// // give notification to admin
		  //       $this->load->library('notification');
		  //       $notif = array(
		  //       	'category' => 'open_course_request',
		  //       	'title' => 'Request: Open Course',
		  //       	'content' => 'UserID '.$user_id.' opened a course. Need verification by admin immediately.',
		  //       	'sender_id' => $user_id,
		  //       	'receiver_id' => 'admin'
		  //       	);
		  //       $add_notif = $this->notification->insert($notif);
			}
			else
				$response = array(
					'status' => '204',
					'message' => $add_course->output
					);
		}

		echo json_encode($response);
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
			'city_id' => $city,
			'verified' => '1'
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

			// // give notification to admin
	  //       $this->load->library('notification');
	  //       $notif = array(
	  //       	'category' => 'open_city_request',
	  //       	'title' => 'Request: Open City for Course',
	  //       	'content' => 'UserID '.$user_id.' opened a city for course. Need verification by admin immediately.',
	  //       	'sender_id' => $user_id,
	  //       	'receiver_id' => 'admin'
	  //       	);
	  //       $add_notif = $this->notification->insert($notif);

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

	function verify(){
		$old_id = $this->input->get('old', TRUE);
		// $new_id = $this->input->get('new', TRUE);
		$salary = $this->input->get('sal', TRUE);

		// $update_data = array('user_id'=>$new_id, 'verified_user'=>'1');
		$update_data = array('verified_user'=>'1');
		$upd = $this->Common->update_data_on_table('users', 'user_id', $old_id, $update_data);

		// input salary
		$upd_data_info = array('salary_per_hour'=>$salary);
		$check_exist_info = $this->User_m->get_user_info_data($old_id);
		// $check_exist_info = $this->User_m->get_user_info_data($new_id);
		// print_r($this->db->last_query());
		if($check_exist_info<>false) // if exist
			$upd = $this->Common->update_data_on_table('user_info_data', 'user_id', $old_id, $upd_data_info);
			// $upd = $this->Common->update_data_on_table('user_info_data', 'user_id', $new_id, $upd_data_info);
		else{
			// $upd_data_info['user_id'] = $new_id;
			$upd_data_info['user_id'] = $old_id;
			$add_info = $this->Common->add_to_table('user_info_data', $upd_data_info);
		}

		// kirim ke user ID lama karena mungkin dia sedang login
		$notif = array(
        	'category' => 'teacher_verified',
        	'title' => $this->lang->line('verification_teacher_done'),
        	'content' => $this->lang->line('verification_teacher_done_message_1').$this->lang->line('verification_teacher_done_message_2'),
        	// 'content' => $this->lang->line('verification_teacher_done_message_1').$new_id.$this->lang->line('verification_teacher_done_message_2'),
        	'sender_id' => 'admin',
        	'receiver_id' => $old_id // teacher ID
        	);
        $this->notification->insert($notif);

        // send push notification to mobile application
        $this->load->library('Push_Notification_Lib');
        $push_result = $this->push_notification_lib->send($old_id, $notif['title'], $this->lang->line('verification_teacher_done_message_1'));

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

	function verification_request($part){
		$this->check_user_access();
		$data = array( 
			'active_menu_id' => 'tutor-req-'.$part,
			'title_page' => 'Request for Data Verification',
			'part' => $part
			);

		$data['unverified'] = array();
		if($part=='city'){
			$data['headers'] = array('<input type="checkbox" id="check-all"> Check All','ID', 'Name', 'City', 'Province/State');
			$records = $this->Teacher_m->get_city_verification(array('verified'=>'0'));
			if($records<>false){
				foreach($records->result() as $row)
					$data['unverified'][] = array(
						'checkbox' => '<input type="checkbox" name="check[]" value="'.$row->id.'">',
						'user_id' => $row->user_id,
						'name' => $row->first_name.' '.$row->last_name,
						'specific' => $row->city_name,
						'category' => $row->province_name
						);
			}
			
		}
		else if($part=='course'){
			$data['headers'] = array('<input type="checkbox" id="check-all"> Check All', 'ID', 'Name', 'Course', 'Program', 'Days', 'Sessions');
			$records = $this->Teacher_m->get_course_verification(array('verified'=>'0'));
			if($records<>false){
				foreach($records->result() as $row){
					// salary info
					$salary_info = $this->Teacher_m->get_salary($row->user_id);
 					
					// set days
					$days = $this->course_lib->get_days_string($row->days);

					// get info of the course
					$course_info = $this->Course_m->get_courses(array('c.id' => $row->id));

					$data['unverified'][] = array(
						'checkbox' => '<input type="checkbox" name="check[]" value="'.$row->id.'">',
						'id' => $row->id,
						'user_id' => $row->user_id,
						'name' => $row->first_name.' '.$row->last_name,
						'specific' => $course_info->row()->program_name,
						'category' => $course_info->row()->course_name,
						'days' => $days,
						'hours' => str_replace(',', ', ', $row->session_hours)
						);
				}
			}
		}
		
		$this->open_admin_page('admin/teacher/verification_request', $data);
	}

	function verify_request($part){
		if($part=="city")
			$table = 'teacher_open_course_cities';
		else if($part=="course")
			$table = 'teacher_open_courses';

		if(sizeof($this->input->post('check')) > 0){
			// load online test model
			$this->load->model('Otest_m');
			$this->load->helper('myfunction_helper');
			$this->load->library('notification');

			foreach($this->input->post('check') as $id){
				if($part=="city"){
					$upd_data = array('verified' => '1');
					$upd = $this->Common->update_data_on_table($table, 'id', $id, $upd_data);
					$this->set_session_response_no_redirect('update', $upd);
				}
				else if($part=="course"){
					// $post_index = 'set_price_'.$id;
					
					// if($this->input->post($post_index)=="" or $this->input->post('set_modul_'.$id)=="" or $this->input->post('set_tryout_'.$id)==""){
					// 	array_push($this->any_error, 'Price, Modul or Try-Out price cannot be blank or zero');
					// 	$this->set_session_response_no_redirect_by_error('add');
					// }
					// else{
					$upd_data = array('verified' => '1');
					$upd = $this->Common->update_data_on_table($table, 'id', $id, $upd_data);
					$this->set_session_response_no_redirect('update', $upd);
					// }

					$get_course = $this->Teacher_m->get_opened_course_data(array('toc.id' => $id));
					$course_id = $get_course->row()->course_id;
					$tutor_id = $get_course->row()->user_id;
					// create online test assignment if any
			        $auto_assignment = $this->Otest_m->get_test_data(array('is_active'=>'1', 'assign_to_course_request'=>'1', 'course_id'=>$course_id));
			        if($auto_assignment<>false){
			        	$get_max_retry = $this->Content_m->get_option_by_param('max_retry');
			        	foreach($auto_assignment->result() as $test){
			        		$data = array(
								'test_id' => $test->test_id,
								'teacher_id' => $tutor_id,
								'max_retry' => $get_max_retry->parameter_value
								);
							
							$result_insert = false;
							// 1.2 generate ID and check if duplicate
							while($result_insert==false){
								$new_id = 'TA'.generate_random_string('number', 5);
								
								$data['assignment_id'] = $new_id;
								$insert = $this->Otest_m->insert_new_assignment($data);
								if($insert)
									$result_insert = true;
								else
									$result_insert = false;
							}

							$assignment_id = $new_id;

							// give notification to tutor 
					        
					        $notif = array(
					        	'category' => 'new_test_assignment',
					        	'title' => 'Online Test Assignment',
					        	'content' => $this->lang->line('notification_new_test_assignment_create').' ID Assignment = '.$assignment_id,
					        	'sender_id' => 'admin', // admin
					        	'receiver_id' => $tutor_id // tutor ID
					        	);
					        $this->notification->insert($notif);
			        	}
			        }
				}
			}
		}
		else{
			array_push($this->any_error, 'Please select the checkbox(es)');
			$this->set_session_response_no_redirect_by_error('add');
		}

		redirect('teacher/verification_request/'.$part);
	}

	function request_delete($part, $id){
		if($part=="city")
			$table = 'teacher_open_course_cities';
		else if($part=="course")
			$table = 'teacher_open_courses';

		$upd_data = array('delete_request' => '1');
		$this->load->model('Common', 'Common');
		$upd = $this->Common->update_data_on_table($table, 'id', $id, $upd_data);

		if($upd->status){
			// give notification to admin
	        $this->load->library('notification');
	        $notif = array(
	        	'category' => 'open_'.$part.'_to_delete',
	        	'title' => 'Request: Open '.ucwords($part).' to Delete',
	        	'content' => 'UserID '.$user_id.' requested a '.$part.' to delete. Need verification by admin immediately.',
	        	'sender_id' => $user_id,
	        	'receiver_id' => 'admin'
	        	);
	        $add_notif = $this->notification->insert($notif);
		}

		redirect('teacher/edit_open_course');
	}

	function request_for_delete($part){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'tutor-req-'.$part.'-del',
			'title_page' => 'Request for Data Deletion',
			'part' => $part
			);

		$data['request'] = array();
		if($part=='city'){
			$data['headers'] = array('<input type="checkbox" id="check-all"> Check All','ID', 'Name', 'City', 'Province');
			$records = $this->Teacher_m->get_city_verification(array('delete_request'=>'1'));
			if($records<>false){
				foreach($records->result() as $row){
					// check dependency in onther table
					$check = $this->Course_m->count_course_enrollment_by_city_course('city_id', $row->id);
					$dependency = ($check == 0 ? 'OK, ready to be deleted.' : $check.' data found in order. Cannot be deleted. Reject this one.');
					$data['request'][] = array(
						'checkbox' => '<input type="checkbox" name="check[]" value="'.$row->id.'">',
						'user_id' => $row->user_id,
						'name' => $row->first_name.' '.$row->last_name,
						'specific' => $row->city_name,
						'category' => $row->province_name,
						'dependency' => $dependency
						);
				}
			}
			
		}
		else if($part=='course'){
			$data['headers'] = array('<input type="checkbox" id="check-all"> Check All','ID', 'Name', 'Course', 'Program', 'Dependency Data');
			$records = $this->Teacher_m->get_course_verification(array('delete_request'=>'1'));
			if($records<>false){
				foreach($records->result() as $row){
					// get info of the course
					$course_info = $this->Course_m->get_courses(array('c.id' => $row->id));
					
					// check dependency in onther table
					$check = $this->Course_m->count_course_enrollment_by_city_course('course_id', $row->id);
					$dependency = ($check == 0 ? 'OK, ready to be deleted.' : $check.' data found in order. Cannot be deleted. Reject this one.');
					$data['request'][] = array(
						'checkbox' => '<input type="checkbox" name="check[]" value="'.$row->id.'">',
						'user_id' => $row->user_id,
						'name' => $row->first_name.' '.$row->last_name,
						'specific' => $course_info->row()->program_name,
						'category' => $course_info->row()->course_name,
						'dependency' => $dependency
						);
				}
			}
		}

		
		
		$this->open_admin_page('admin/teacher/request_for_delete', $data);
	}

	function delete_city(){
		foreach($this->input->post('check') as $id){
			if($this->input->post('action')=="delete"){
				$del = $this->Common->delete_from_table_by_id('teacher_open_course_cities', 'id', $id);
				$this->set_session_response_no_redirect('delete', $del);
			}
			else if($this->input->post('action')=="reject"){
				$reject_data = array('delete_request' => '0');
				$upd = $this->Common->update_data_on_table('teacher_open_course_cities', 'id', $id, $reject_data);
				$this->set_session_response_no_redirect('update', $upd);
			}
		}
		
		redirect('teacher/request_for_delete/city');
	}

	function delete_course(){
		foreach($this->input->post('check') as $id){
			if($this->input->post('action')=="delete"){
				$del = $this->Common->delete_from_table_by_id('teacher_open_courses', 'id', $id);
				$this->set_session_response_no_redirect('delete', $del);
			}
			else if($this->input->post('action')=="reject"){
				$reject_data = array('delete_request' => '0');
				$upd = $this->Common->update_data_on_table('teacher_open_courses', 'id', $id, $reject_data);
				$this->set_session_response_no_redirect('update', $upd);
			}
		}
		
		
		redirect('teacher/request_for_delete/course');
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

	function download($media_id){
		$this->load->helper('myfunction_helper');
		$this->load->model('Media_m');

		$file_name = $this->Media_m->get_file_name($media_id);
		download_file('./assets/uploads/'.$file_name, $file_name);
	}

	function update_salary_unit_hour()
	{
		$data = array('salary_per_hour' => $this->input->post('sal', true));
		$upd = $this->Common->update_data_on_table('user_info_data', 'user_id', $this->input->post('id', true), $data);
		if($upd->status)
			$response['status'] = '200';
		else
			$response = array(
				'status' => '204',
				'message' => $upd->output
				);
		echo json_encode($response);
	}

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
				'USER ID', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'PHONE', 'SALARY PER 1.5 HOURS'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Verified tutor');

	        $this->excel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($alignment);

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
				$row++;
			}

			// set auto width
			foreach(range('A','G') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Verified Tutor List.xls'; //save our workbook as this file name

		}
		else if($what=="unverified")
		{
			$data = $this->Teacher_m->get_unverified();
			$header = array(
				'USER ID', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'PHONE'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Unverified tutor');

	        $this->excel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($alignment);

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
				$row++;
			}

			// set auto width
			foreach(range('A','F') as $columnID) {
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
					'city_id' => $area_id,
					'verified' => '1'
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
						'session_hours' => $sessions,
						'verified' => '1'
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
}