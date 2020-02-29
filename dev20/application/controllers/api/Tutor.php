<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Tutor extends REST_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('User_m');
        $this->load->model('Location_m');
        $this->load->model('Common');
        $this->load->model('Content_m');
        $this->load->model('Teacher_m');
        $this->load->model('Course_m');
        if($this->post('lang')<>"")
        	$this->lang_ = $this->post('lang');
        else if($this->get('lang')<>"")
        	$this->lang_ = $this->get('lang');
        else
        	$this->lang_ = 'en';
        $this->lang->load($this->lang_, ($this->lang_=="en" ? 'english' : 'indonesia'));
	}

	function add_area_post(){
		$any_error = array();
		$tutor_id = $this->post('tid');
		$areas = $this->post('area');
		if($tutor_id <> "" and $areas <> ""){
			$area_array = explode('-', $areas);
			foreach($area_array as $area_id){
				$data = array(
					'user_id' => $tutor_id,
					'city_id' => $area_id,
					'verified' => '1'
					);
				
				$add_city = $this->Common->add_to_table('teacher_open_course_cities', $data);
				if(!$add_city->status)
					array_push($any_error, $add_city->output);
			}
		}
		else
			array_push($any_error, $this->lang->line('complete_input_fields'));

		if(empty($any_error))
			$response = array('status'=>'OK', 'message'=>'Submitted');
		else{
			$message = '';
			foreach($any_error as $msg)
				$message .= $msg.'; ';
			$response = array('status'=>'error', 'message'=>$message);
		}

		$this->response($response);
	}

	function add_program_post(){
		$response = array();
		$any_error = array();
		$tutor_id = $this->post('tid');
		$progs = $this->post('prog');
		$days = $sessions = '';
		if($this->post('day')=="" or $this->post('sess')==""){
			array_push($any_error, $this->lang->line('day_and_session_are_required'));
		}
		else{
			$this->load->model('Otest_m');
			$this->load->library('notification');

			// will make sure all transaction run completed or nothing
			$this->db->trans_start();
			
			$day_array = explode('-', $this->post('day'));
			foreach($day_array as $day_id)
				$days .= $day_id.',';
			$days = rtrim($days, ',');

			$sess_array = explode('-', $this->post('sess'));
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
					if(!$add_course->status)
						array_push($any_error, $add_course->output);
					else{
						// create online test assignment if any
				        $auto_assignment = $this->Otest_m->get_test_data(array('is_active'=>'1', 'assign_to_course_request'=>'1', 'course_id'=>$prog_id));
				        if($auto_assignment<>false){
				        	foreach($auto_assignment->result() as $test){
				        		// get last ID
								$get_last_id = $this->Otest_m->get_last_id();
								$last_id = $get_last_id->last_id;
								$new_id = intval($last_id) + 1;

								$assignment_id = 'TA'.str_pad($new_id, 5, "0", STR_PAD_LEFT);

				        		$data = array(
				        			'assignment_id' => $assignment_id,
									'test_id' => $test->test_id,
									'teacher_id' => $tutor_id
									);
								
								$insert = $this->Otest_m->insert_new_assignment($data);
								if($insert == false)
									array_push($any_error, 'Duplicate entries for assignment ID');

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
			else
				array_push($any_error, $this->lang->line('program_is_required'));
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE or !empty($any_error))
		{
		    $this->db->trans_rollback();
		    $message = '';
			foreach($any_error as $msg)
				$message .= $msg.'. ';
			$response = array('status'=>'error', 'message'=>$message);
		}
		else
		{
	        $this->db->trans_commit();
	        $response = array(
				'status' => 'OK'
				);
	    }

		$this->response($response);
	}

	function update_personal_post(){
		$any_error = array();
		// 1. validate form
		$this->load->library('form_validation');

		$this->form_validation->set_rules('tid', 'User ID', 'required');
		$this->form_validation->set_rules('ktp', $this->lang->line('national_id_number'), 'required|numeric');
		$this->form_validation->set_rules('sex', $this->lang->line('sex'), 'required');
		$this->form_validation->set_rules('birth-place', $this->lang->line('birth_place'), 'required');
		$this->form_validation->set_rules('birth-date', $this->lang->line('birth_date'), 'required');
		$this->form_validation->set_rules('religion', $this->lang->line('religion'), 'required');
		$this->form_validation->set_rules('address-domicile', $this->lang->line('address_on_national_card'), 'required');
		$this->form_validation->set_rules('phone-1', $this->lang->line('phone'), 'required');

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
			// 2. update personal data
			$personal_data = array(
				'user_id' => $this->post('tid'),
				'national_card_number' => $this->post('ktp'),
				'sex' => $this->post('sex'),
				'birth_place' => $this->post('birth-place'),
				'birth_date' => $this->post('birth-date'),
				'address_national_card' => $this->post('address-ktp'),
				'address_domicile' => $this->post('address-domicile'),
				'phone_1' => $this->post('phone-1'),
				'phone_2' => $this->post('phone-2'),
				'teach_experience' => $this->post('teach-experience'),
				'toefl_score' => $this->post('toefl'),
				'toefl_certificate_file_id' => $this->post('toefl-file-id'),
				'ielts_score' => $this->post('ielts'),
				'religion' => $this->post('religion')
				);
			// check if user exist
			$check = $this->User_m->check_user_id_exist($this->post('tid'));
			if($check){
				$upd_info = $this->Common->update_data_on_table('user_info_data', 'user_id', $this->post('tid'), $personal_data);
				if($upd_info->status)
					$response = array('status'=>'OK');
				else
					$response = array('status'=>'error', 'message'=>$upd_info->output);
			}
			else{
				$add_info = $this->Common->add_to_table('user_info_data', $personal_data);
				if($add_info->status)
					$response = array('status'=>'OK');
				else
					$response = array('status'=>'error', 'message'=>$add_info->output);
			}
			
		}

		$this->response($response);
	}

	function add_education_post(){
		// 1. validate form
		$this->load->library('form_validation');

		$this->form_validation->set_rules('tid', 'User ID', 'required');
		$this->form_validation->set_rules('degree', $this->lang->line('education'), 'required');
		$this->form_validation->set_rules('institution', $this->lang->line('university'), 'required');
		$this->form_validation->set_rules('major', $this->lang->line('major'), 'required');
		$this->form_validation->set_rules('grade_score', $this->lang->line('grade_score'), 'required|decimal');
		$this->form_validation->set_rules('year_in', $this->lang->line('college_year_in'), 'required|numeric');
		$this->form_validation->set_rules('year_out', $this->lang->line('college_year_out'), 'required|numeric');

		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = 'error';
			$validation_message = validation_errors();
			$validation_message = str_replace('<p>', '', $validation_message);
			$validation_message = str_replace('</p>', '', $validation_message);
			$response['message'] = $validation_message;
		}
		else
		{
			// 2. add education data
			$data = array(
				'user_id' => $this->post('tid'),
				'degree' => $this->post('degree'),
				'institution' => $this->post('institution'),
				'major' => $this->post('major'),
				'date_in' => $this->post('year_in'),
				'date_out' => $this->post('year_out'),
				'grade_score' => $this->post('grade_score'),
				'certificate_media_id' => $this->post('ijasah-file-id'),
				'transcript_media_id' => $this->post('transkrip-file-id')
				);
			
			$add_edu = $this->Common->add_to_table('user_education_experiences', $data);

			if($add_edu->status)
				$response = array('status'=>'OK');
			else
				$response = array('status'=>'error', 'message'=>$add_edu->output);
		}

		$this->response($response);
	}

	function search_get($using){
		$this->load->library('Course_lib');
		$response = array();
		if($this->get('city')=="" or $this->get('program')=="" or $this->get('course')=="")
			$response = array('status'=>'error', 'message'=>$this->lang->line('complete_input_fields'));
		else{
			$course_id = $this->get('course');
			$program_info = $this->Course_m->get_programs(array('program_id' => $this->get('program')));
			$response['program'] = $program_info->row()->program_name;
			// course name
			if($course_id<>"all"){
				$course_info = $this->Course_m->get_courses(array('c.id' => $course_id));
				$response['course'] = $course_info->row()->course_name; 
			}
			else
				$response['course'] = 'All';

			// city
			$get_location = $this->Location_m->get_city(array('c.city_id' => $this->get('city')));
			$response['location'] = $get_location->row()->province_name.'-'.$get_location->row()->city_name;

			if($course_id=="all"){
				$data_tutor = $this->Teacher_m->get_data_concat_course(array('occ.city_id' => $this->get('city'), 'cp.program_id' => $this->get('program')) );
			}
			else
				$data_tutor = $this->Teacher_m->get_data_concat_course(array('occ.city_id' => $this->get('city'), 'cp.program_id' => $this->get('program'), 'toc.course_id' => $this->get('course')));

			if($data_tutor<>false){
				$response['status'] = 'OK';
				$tutors = array();
				
				foreach($data_tutor->result() as $tutor){
					// get latest education
					$get_latest_edu = $this->User_m->get_education_history_by_userid($tutor->user_id);
					$latest_edu = $get_latest_edu<>false ? $get_latest_edu->row()->degree.' '.$get_latest_edu->row()->major.' - '.$get_latest_edu->row()->institution : '';
					$tutors[] = array(
						'tutor_id' => $tutor->user_id,
						'latest_edu' => $latest_edu,
						'first_name' => $tutor->first_name,
						'last_name' => $tutor->last_name,
						'file_name' => $tutor->file_name,
						'program' => $tutor->program_name,
						'courses' => $tutor->courses,
						'days' => $this->course_lib->get_days_string($tutor->days),
						'session' => str_replace(',', ', ', $tutor->session_hours),
						'fee' => number_format($tutor->salary_per_unit_hour, 0, ',', '.'),
						'city' => $tutor->city_name
						);
				}
				$response['tutors'] = $tutors;
			}
			else{
				$response['status'] = 'error';
				$response['message'] = $this->lang->line('search_tutor_not_found');
			}
		}

		$this->response($response);

	}

	function search_program_get(){
		$prog_id_s = $this->get('prog');
		$response = array();
		if($this->get('prog')=="")
			$response = array('status'=>'error', 'message'=>$this->lang->line('complete_input_fields'));
		else{
			$response['status'] = "OK";
			if($prog_id_s=="all")
			{
				$response['title'] = $this->lang->line('education_level_all');
				$get_programs = $this->Course_m->get_programs();
				// $tutor_courses = array();
				foreach($get_programs->result() as $prog)
				{
					// get all course under program
					$under_program = $this->Course_m->get_verified_tutor_courses_under_program($prog->program_id);
					if($under_program<>false){
						$tutors = array();
						foreach($under_program->result() as $tutor){
							$tutor_info = $this->User_m->get_user_info($tutor->user_id);
							// get latest education
							$get_latest_edu = $this->User_m->get_education_history_by_userid($tutor->user_id);
							$latest_edu = $get_latest_edu<>false ? $get_latest_edu->row()->degree.' '.$get_latest_edu->row()->major.' - '.$get_latest_edu->row()->institution : '';
							$tutors[] = array(
								'tutor_id' => $tutor->user_id,
								'latest_edu' => $latest_edu,
								'first_name' => isset($tutor_info->first_name) ? $tutor_info->first_name : "",
								'last_name' => isset($tutor_info->last_name) ? $tutor_info->last_name : "",
								'file_name' => isset($tutor_info->file_name) ? $tutor_info->file_name : "",
								// 'program' => $tutor->education_level,
								'courses' => str_replace(',', ', ', $tutor->courses),
								// 'days' => $this->course_lib->get_days_string($tutor->days),
								// 'session' => str_replace(',', ', ', $tutor->session_hours),
								'fee' => isset($tutor_info->salary_per_hour) ? number_format($tutor_info->salary_per_hour, 0, ',', '.') : "",
								// 'city' => $tutor->city_name
								);
						}
						$response['tutors'] = $tutors;
					}
				}
			}
			else
			{
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

								if(empty($day_array))
									$day_string = '';
								else{
									foreach($day_array as $day)
										$day_string .= $this->lang->line('day_'.$day).', ';
									$day_string = rtrim($day_string, ", ");
								}

								$tutor_info = $this->User_m->get_user_info($row->user_id);

								// $tutor_courses[] = array(
								// 	'user_id' => $row->user_id,
								// 	'courses' => $row->categories,
								// 	'file_name' => $tutor_info->file_name,
								// 	'first_name' => $tutor_info->first_name,
								// 	'last_name' => $tutor_info->last_name,
								// 	'occupation' => $tutor_info->occupation,
								// 	'about_me' => $tutor_info->about_me,
								// 	'salary' => $tutor_info->salary_per_hour,
								// 	'age' => date_diff(date_create($tutor_info->birth_date), date_create('today'))->y,
								// 	'days' => $day_string
								// 	);
								$tutors[] = array(
									'tutor_id' => $row->user_id,
									'first_name' => $tutor_info->first_name,
									'last_name' => $tutor_info->last_name,
									'age' => date_diff(date_create($tutor_info->birth_date), date_create('today'))->y,
									'file_name' => $tutor_info->file_name,
									'about_me' => $tutor_info->about_me,
									// 'program' => $tutor->education_level,
									'courses' => str_replace(',', ', ', $row->courses),
									// 'days' => $this->course_lib->get_days_string($tutor->days),
									// 'session' => str_replace(',', ', ', $tutor->session_hours),
									'fee' => number_format($tutor_info->salary_per_hour, 0, ',', '.'),
									// 'city' => $tutor->city_name,
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
								if(empty($day_array))
									$day_string = '';
								else{
									foreach($day_array as $day)
										$day_string .= $this->lang->line('day_'.$day).', ';
									$day_string = rtrim($day_string, ", ");
								}

								$tutor_info = $this->User_m->get_user_info($row->user_id);
								$tutors[] = array(
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
				$response['tutors'] = $tutors;

				$response['title'] = $this->lang->line('search_tutor_by_program').$program_string;
			}
		}
		
		
		$this->response($response);
	}

	function profile_get(){
		$user_id = $this->get('tid');
		$upd_info = $this->User_m->increment_total_user_viewed($user_id);
		// insert snapshot user view
		$snapshot = array(
			'id' => uniqid(),
			'user_id' => $user_id
			);
		$add_snapshot = $this->Common->add_to_table('snapshot_user_view', $snapshot);

		$response = array();
		// get user info
		$user_info = $this->User_m->get_user_info($user_id);
		if($user_info->verified_user=="0")
			$response = array(
				'status' => 'error',
				'message' => $this->lang->line('error_tutor_isnot_verified_yet')
				);
		else{
			$response['status'] = 'OK';
			$response['user_info'] = $user_info;
			$response['user_age'] = date_diff(date_create($user_info->birth_date), date_create('today'))->y;
			$response['open_city'] = $this->Teacher_m->get_concat_city_by_teacher_id($user_id, FALSE)->result();
			$response['open_course'] = $this->Teacher_m->get_verified_open_course_by_teacher_id($user_id, FALSE)->result();
			$response['education'] = $this->User_m->get_education_history_by_userid($user_id)->result();
			
			// $response['total_taken_course'] = $this->Teacher_m->get_total_taken_course($user_id);

			$response['image_thumb'] = '';
			if($user_info->file_name <> "")
			{
				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/uploads/'.$user_info->file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 120;

				$this->load->library('image_lib', $config);

				$response['image_thumb'] = str_replace($user_info->file_extension, "", $user_info->file_name).'_thumb'.$user_info->file_extension;

				$this->image_lib->resize();
			}
		}
		$this->response($response);
	}

	function personal_get(){
		$user_id = $this->get('id');
		$edu_data = $this->User_m->get_education_history_by_userid($user_id);
		$response = array(
			'profile' => $this->User_m->get_user_info($user_id),
			'education' => $edu_data <> false ? $edu_data->row() : array()
			);
		$this->response($response);
	}

	function update_personal_education_post(){
		$any_error = '';
		// 1. validate form
		$this->load->library('form_validation');

		$this->form_validation->set_rules('tid', 'User ID', 'required');
		$this->form_validation->set_rules('fn', 'First Name', 'required');
		$this->form_validation->set_rules('ln', 'Last Name', 'required');
		$this->form_validation->set_rules('sex', $this->lang->line('sex'), 'required');
		$this->form_validation->set_rules('birth-place', $this->lang->line('birth_place'), 'required');
		$this->form_validation->set_rules('birth-date', $this->lang->line('birth_date'), 'required');
		$this->form_validation->set_rules('religion', $this->lang->line('religion'), 'required');
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
			// will make sure all transaction run completed or nothing
			$this->db->trans_start();

			// 2. update name if isset
			if($this->post('fn')<>'' or $this->post('ln')<>''){
				$name_data = array(
					'first_name' => $this->post('fn'),
					'last_name' => $this->post('ln')
					);
				$upd_name = $this->Common->update_data_on_table('users', 'user_id', $this->post('tid'), $name_data);
			}

			// 3. update personal data
			$personal_data = array(
				'sex' => $this->post('sex'),
				'birth_place' => $this->post('birth-place'),
				'birth_date' => $this->post('birth-date'),
				'address_national_card' => $this->post('address-ktp'),
				'address_domicile' => $this->post('address-domicile'),
				'phone_1' => $this->post('phone-1'),
				'phone_2' => $this->post('phone-2'),
				'about_me' => $this->post('about-me'),
				'hobby' => $this->post('hobby'),
				'religion' => $this->post('religion'),
				'teach_experience' => $this->post('teach-exp'),
				'skill' => $this->post('skill'),
				'toefl_score' => $this->post('toefl')
				);
			if($this->post('photo_id')<>'')
				$personal_data['photo_primary_id'] = $this->post('photo_id');

			// check if user exist
			$check = $this->User_m->check_user_id_exist($this->post('tid'));
			if($check){
				$upd_info = $this->Common->update_data_on_table('user_info_data', 'user_id', $this->post('tid'), $personal_data);
				if(!$upd_info->status)
					$any_error .= $upd_info->output;
			}
			else{
				$personal_data['user_id'] = $this->post('tid');
				$add_info = $this->Common->add_to_table('user_info_data', $personal_data);
				if(!$add_info->status)
					$any_error .= $add_info->output;
			}

			// add education data
			if($this->post('edu-id')==""){
				$data = array(
					'user_id' => $this->post('tid'),
					'degree' => $this->post('degree'),
					'institution' => $this->post('institution'),
					'major' => $this->post('major'),
					'date_in' => $this->post('year-in'),
					'date_out' => $this->post('year-out'),
					'grade_score' => $this->post('grade')
					);
				
				$add_edu = $this->Common->add_to_table('user_education_experiences', $data);
				if(!$add_edu->status)
					$any_error .= $add_edu->output;
			}
			else{
				$data = array(
					'degree' => $this->post('degree'),
					'institution' => $this->post('institution'),
					'major' => $this->post('major'),
					'date_in' => $this->post('year-in'),
					'date_out' => $this->post('year-out'),
					'grade_score' => $this->post('grade')
					);
				
				$update_edu = $this->Common->update_data_on_table('user_education_experiences', 'id', $this->post('edu-id'), $data);
				if(!$update_edu->status)
					$any_error .= $update_edu->output;
			}

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
			    $response = array(
					'status' => 'error',
					'message' => $any_error
					);
			}
			else
			{
		        $this->db->trans_commit();
		        $response = array(
					'status' => 'OK'
					);
		    }
			
		}

		$this->response($response);
	}

	function teach_area_get(){
		$response = array();
		// get open city fo course
		$data = $this->Teacher_m->get_open_city('oc.user_id', $this->get('tid'));
		if($data<>false)
			$this->response($data->result());
		else
			$this->response($response);
	}

	function request_delete_get(){
		$part = $this->get('part');
		$id = $this->get('id');
		$user_id = $this->get('tid');
		if($part=="city")
			$table = 'teacher_open_course_cities';
		else if($part=="course")
			$table = 'teacher_open_courses';

		$upd_data = array('delete_request' => '1');
		$upd = $this->Common->update_data_on_table($table, 'id', $id, $upd_data);

		$response = array();

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
	        $response = array('status' => "OK");
		}
		else
			$response = array('status' => "error", 'message' => $upd->output);

		$this->response($response);
	}

	// function add_open_teach_area_post(){
	// 	$user_id = $this->post('tid');
	// 	$city = $this->post('cid');

	// 	$data = array(
	// 		'user_id' => $user_id,
	// 		'city_id' => $city
	// 		);
		
	// 	$add_city = $this->Common->add_to_table('teacher_open_course_cities', $data);

	// 	if($add_city->status){
	// 		$response = array('status' => 'OK');

	// 		// give notification to admin
	//         $this->load->library('notification');
	//         $notif = array(
	//         	'category' => 'open_city_request',
	//         	'title' => 'Request: Open City for Course',
	//         	'content' => 'UserID '.$user_id.' opened a city for course. Need verification by admin immediately.',
	//         	'sender_id' => $user_id,
	//         	'receiver_id' => 'admin'
	//         	);
	//         $add_notif = $this->notification->insert($notif);

	// 	}
	// 	else{
	// 		$response = array(
	// 			'status' => 'error',
	// 			'message' => $add_city->output
	// 			);
	// 	}

		
	// 	$this->response($response);
	// }

	function opened_course_get(){
		$response = array();
		// get open course
		$data = $this->Teacher_m->get_course_data_by_userid($this->get('tid'));
		if($data<>false){
			foreach($data->result() as $course){
				$days = $sessions = '';

				$day_array = explode(',', $course->days);
				foreach($day_array as $day_id)
					$days .= $this->lang->line('day_'.$day_id).', ';
				$days = rtrim($days, ', ');

				$sess_array = explode(',', $course->session_hours);
				foreach($sess_array as $sess_id)
					$sessions .= $sess_id.', ';
				$sessions = rtrim($sessions, ', ');

				$response[] = array(
					'id' => $course->id,
					'user_id' => $course->user_id,
					'verified' => $course->verified,
					'delete_request' => $course->delete_request,
					'days' => $days,
					'sessions' => $sessions,
					'program' => $course->program_name,
					'course' => $course->course_name
					);
			}
			$this->response($response);
		}
		else
			$this->response($response);
	}

	function bank_get(){
		$user_id = $this->get('id');
		$response = array();
		$get = $this->User_m->get_user_bank($user_id);
		if($get<>false)
			$response = $get;

		$this->response($response);
	}

	function set_bank_account_post(){
		$user_id = $this->post('tid');
		$response = array();
		$data = array(
			'bank_name' => $this->post('bank-name'),
			'bank_account_number' => $this->post('number'),
			'bank_holder_name' => $this->post('holder-name'),
			'bank_branch' => $this->post('branch'),
			'bank_city' => $this->post('city')
			);

		$check_exist_bank = $this->User_m->get_user_bank($user_id);
		if($check_exist_bank<>false){ // if exist
			$update_info = $this->Common->update_data_on_table('user_bank_account', 'user_id', $user_id, $data);
			if(!$update_info->status)
				$response = array('status' => '204', 'message' => $update_info->output);
			else
				$response = array('status' => '200');
		}
		else{
			$data['user_id'] = $user_id;
			$add_info = $this->Common->add_to_table('user_bank_account', $data);
			if(!$add_info->status)
				$response = array('status' => '204', 'message' => $add_info->output);
			else
				$response = array('status' => '200');
		}	

		$this->response($response);
	}

	function commission_get(){
		$user_id = $this->get('tid');
		$response = array();

		$this->load->model('Payroll_m');

		$get = $this->Payroll_m->get_payroll_by_teacher_id($user_id);
		if($get<>false)
			$response = $get->result();

		$this->response($response);
	}

	function count_snapshot_get(){
		$user_id = $this->get('tid');
		$get = $this->User_m->count_snapshot($user_id);
		$response = array('count' => $get);
		$this->response($response);
	}

	function dashboard_get(){
		$user_id = $this->get('tid');
		$response = array();

		// 1. get user status
		$user_data = $this->User_m->get_user_by_id($user_id);
		$response['is_verified'] = $user_data->verified_user;

		// 2. get statistic
		$response['statistic'] = $this->User_m->count_snapshot($user_id);

		$this->response($response);
	}
}