<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Otest extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('Otest_m');
	}	

	/* pages start */
	function setup(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'variable-otest',
			'title_page' => 'Setup Variable Data for Online Test'
			);

		$get_options = $this->Content_m->get_all_options();
		foreach($get_options->result() as $param){
			$options[$param->parameter_name]['desc'] = $param->description;
			$options[$param->parameter_name]['value'] = $param->parameter_value;
		}
		$data['options'] = $options;
		$data['controller'] = 'otest';

		$this->open_admin_page('admin/base_setup/one_group', $data);
	}

	function test_setup(){
		$this->load->helper('text');
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'otest-test-setup',
			'title_page' => 'Online Test Setup'
			);

		$data['tests'] = $this->Otest_m->get_test_data();

		$this->open_admin_page('admin/otest/index', $data);
	}

	function create(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'otest-test-setup',
			'title_page' => 'Create an Online Test',
			'mode' => 'add'
			);

		$data['programs'] = $this->Course_m->get_programs();

		$this->open_admin_page('admin/otest/test_form', $data);
	}

	function edit(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'otest-test-setup',
			'title_page' => 'Edit Online Test',
			'mode' => 'edit'
			);

		$data['programs'] = $this->Course_m->get_programs();
		$test_data = $this->Otest_m->get_test_data(array('test_id' => $this->input->get('id', true)));
		$data['test_data'] = $test_data->row();

		$this->open_admin_page('admin/otest/test_form', $data);
	}

	function question($test_id){
		$this->load->helper('text');
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'otest-test-setup',
			'title_page' => 'Online Test Administration'
			);

		$data['test_id'] = $test_id;
		$data['questions'] = $this->Otest_m->get_question_data(array('test_id' => $test_id));

		$this->open_admin_page('admin/otest/question', $data);
	}

	function question_create(){
		$this->check_user_access();
		$this->load->helper('form');

		$data = array(
			'active_menu_id' => 'otest-test-setup',
			'title_page' => 'Create a Question',
			'mode' => 'add'
			);
		$data['answer_types'] = array(
			'' => '-- Please Select --',
			'Single' => 'Single choice',
			'Multiple' => 'Multiple choice',
			'Fill' => 'Fill in the blank',
			'Bool' => 'Boolean'
			);
		$data['bool_types'] = array(
			'yes-no' => 'Yes and No',
			'true-false' => 'True and False'
			);
		$data['bool_answers'] = array(
			'true' => 'Yes / True',
			'false' => 'No / False'
			);

		$this->open_admin_page('admin/otest/question_form', $data);
	}

	function question_edit($test_id, $question_id){
		$this->check_user_access();
		$this->load->helper('form');
		$data = array(
			'active_menu_id' => 'otest-test-setup',
			'title_page' => 'Edit Question',
			'mode' => 'edit',
			'test_id' => $test_id,
			'question_id' => $question_id
			);
		$data['answer_types'] = array(
			'' => '-- Please Select --',
			'Single' => 'Single choice',
			'Multiple' => 'Multiple choice',
			'Fill' => 'Fill in the blank',
			'Bool' => 'Boolean'
			);
		$data['bool_types'] = array(
			'yes-no' => 'Yes and No',
			'true-false' => 'True and False'
			);
		$data['bool_answers'] = array(
			'true' => 'Yes / True',
			'false' => 'No / False'
			);

		$test_data = $this->Otest_m->get_question_data(array('id' => $question_id));
		$data['question_data'] = $test_data->row();
		$answer_data = $this->Otest_m->get_answer_data(array('question_id' => $question_id));
		$data['answer_data'] = array();
		if($answer_data<>false)
			foreach($answer_data->result() as $row)
				$data['answer_data'][] = array(
					'id' => $row->id,
					'answer' => $row->answer,
					'right_answer' => $row->is_right_answer
					);
			

		$this->open_admin_page('admin/otest/question_form', $data);
	}

	function tutor_assignment(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'otest-tutor-assignment',
			'title_page' => 'Tutor Test Assignment'
			);

		$data['teachers'] = $this->User_m->get_user_by_level('teacher');
		$data['tests'] = $this->Otest_m->get_test_data();

		$this->open_admin_page('admin/otest/tutor_assignment', $data);
	}

	function assignment_list(){
		if($this->session->userdata('logged')=="in" and $this->session->userdata('level')=="teacher"){
			$teacher_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($teacher_id);

			$data['assignments'] = $this->Otest_m->get_assignment_data(array('teacher_id' => $teacher_id));
			
			$data['am'] = 'online_test';
			$data['gm'] = 'dashboard';
			$data['page_title'] = 'Online Test Assignment';
			$data['sub_page_title'] = $this->lang->line('online_test_assignment');
			$this->open_page('otest_assignment', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function preview($assignment_id, $test_id){
		if($this->session->userdata('logged')=="in" and $this->session->userdata('level')=="teacher"){
			$teacher_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($teacher_id);

			$test_info = $this->Otest_m->get_test_data(array('test_id' => $test_id));
			if($test_info<>false){
				$data['test_data'] = $test_info->row();
				$data['assignment_id'] = $assignment_id;
				$data['test_id'] = $test_id;
				if($test_info->row()->course_id <> "")
					// get info of the course
					$course_info = $this->Course_m->get_courses(array('c.id' => $test_info->row()->course_id));
	            $data['course'] = isset($course_info) ? $course_info->row()->program_name.' - '.$course_info->row()->course_name : ' - ';
			}
			
			
			$data['am'] = 'online_test';
			$data['gm'] = 'dashboard';
			$data['page_title'] = 'Preview Online Test';
			$data['sub_page_title'] = $this->lang->line('test_preview');
			$this->open_page('otest_preview', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function grade_setup()
	{
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'tutor-grade-otest',
			'title_page' => 'Setup Tutor Grade'
			);

		$data['grades'] = $this->Otest_m->get_grade_data();

		$this->open_admin_page('admin/otest/setup_grade', $data);
	}

	function start($assignment_id, $test_id){
		if($this->session->userdata('logged')=="in" and $this->session->userdata('level')=="teacher"){
			$teacher_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($teacher_id);
			$test_info = $this->Otest_m->get_test_data(array('test_id' => $test_id));

			$data['am'] = 'online_test';
			$data['gm'] = 'dashboard';
			$data['page_title'] = 'Online Test - ('.$test_info->row()->test_id.') '.$test_info->row()->test_name;
			$data['sub_page_title'] = 'Online Test - ('.$test_info->row()->test_id.') '.$test_info->row()->test_name;
			// check if no overtaken of this test
			// take test only permitted one time
			if($this->Otest_m->count_assignment_taken($assignment_id) > 0) // if > 0 then already taken
			{
				$data['assignment_id'] = $assignment_id;
				$data['test_id'] = $test_id;
				$this->open_page('otest_overtaken', $data);
			}
			else
			{
				$get_questions = $this->Otest_m->get_question_data(array('test_id' => $test_id));
				$is_random_question = $test_info->row()->random_question;
				if($is_random_question=="0"){
					$data['questions'] = $get_questions->result_array();
				}
				else if($is_random_question=="1"){
					$question_array = $get_questions->result_array();
					shuffle($question_array);
					$data['questions'] = $question_array;
				}
				$data['test_data'] = $test_info->row();
				$data['assignment_id'] = $assignment_id;
				$data['test_id'] = $test_id;
				if($test_info->row()->course_id <> "")
					// get info of the course
					$course_info = $this->Course_m->get_courses(array('c.id' => $test_info->row()->course_id));
	            $data['course'] = isset($course_info) ? $course_info->row()->program_name.' - '.$course_info->row()->course_name : ' - ';
				
				// insert the taker data
				$taker = array(
					'assignment_id' => $assignment_id,
					'status' => 'Created'
					);
				$add = $this->Common->add_to_table('online_test_takers', $taker);
				$data['taker_id'] = $add->output;

				$this->open_page('otest_running', $data);
			}
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	/* pages end */

	/* functions start */
	function view_answer($taker_id){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'operational-otest',
			'title_page' => 'View Answers'
			);

		$data['answers'] = $this->Otest_m->get_taker_answer_data(array('taker_id' => $taker_id));

		$this->open_admin_page('admin/otest/answer_data', $data);
	}

	/* Page End */

	/* Function Start */

	function question_delete($test_id, $question_id){
		$this->check_user_access();
		

		$del = $this->Common->delete_from_table_by_id('online_test_questions', 'id', $question_id);
		$this->set_session_response_no_redirect('delete', $del);

		redirect('otest/question/'.$test_id);
	}

	function add_test(){
		$this->check_user_access();
		$data = array(
			'test_id' => $this->input->post('id', true),
			'course_id' => ($this->input->post('course_id', true)=="") ? null : $this->input->post('course_id', true),
			'test_name' => $this->input->post('name', true),
			'objectives' => $this->input->post('objective', true),
			'how_to' => $this->input->post('howto', true),
			'time_in_minutes' => $this->input->post('time_in_minutes', true),
			'random_question' => $this->input->post('random-question') == "on" ? '1' : '0',
			'assign_to_new_tutor' => $this->input->post('assign-to-new-user') == "on" ? '1' : '0',
			'assign_to_course_request' => $this->input->post('assign-to-course-request') == "on" ? '1' : '0'
			);

		$add = $this->Common->add_to_table('online_tests', $data);
		
		$this->set_session_response_no_redirect('add', $add);

		if($add->status)
			redirect('otest/edit?id='.$data['test_id']);
		else
			redirect('otest/create');
	}

	function update_test($test_id){
		$this->check_user_access();
		$data = array(
			'course_id' => $this->input->post('course_id', true),
			'test_name' => $this->input->post('name', true),
			'objectives' => $this->input->post('objective', true),
			'how_to' => $this->input->post('howto', true),
			'time_in_minutes' => $this->input->post('time_in_minutes', true),
			'random_question' => $this->input->post('random-question') == "on" ? '1' : '0',
			'assign_to_new_tutor' => $this->input->post('assign-to-new-user') == "on" ? '1' : '0',
			'assign_to_course_request' => $this->input->post('assign-to-course-request') == "on" ? '1' : '0'
			);

		$upd = $this->Common->update_data_on_table('online_tests', 'test_id', $test_id, $data);
		$this->set_session_response_no_redirect('update', $upd);

		redirect('otest/edit?id='.$test_id);
	}

	function delete_test($test_id){
		$this->check_user_access();

		$del = $this->Common->delete_from_table_by_id('online_tests', 'test_id', $test_id);
		$this->set_session_response_no_redirect('delete', $del);

		redirect('otest/test_setup');
	}

	function activate_test($test_id){
		$this->check_user_access();
		
		$upd = $this->Common->update_data_on_table('online_tests', 'test_id', $test_id, array('is_active'=>'1'));
		$this->set_session_response_no_redirect('update', $upd);
		redirect('otest/edit?id='.$test_id);
	}

	function deactivate_test($test_id){
		$this->check_user_access();
		
		$upd = $this->Common->update_data_on_table('online_tests', 'test_id', $test_id, array('is_active'=>'0'));
		$this->set_session_response_no_redirect('update', $upd);
		redirect('otest/edit?id='.$test_id);
	}

	function add_question($test_id){
		$this->check_user_access();

		$this->db->trans_start();
		$data = array(
			'test_id' => $test_id,
			'question' => $this->input->post('question'),
			'answer_type' => $this->input->post('type', true)
			);

		if($this->input->post('type')=="Bool"){
			$data['boolean_type'] = $this->input->post('bool-type', true);
			$data['answer_text'] = $this->input->post('bool-answer', true);
		}
		else if($this->input->post('type')=="Fill"){
			$data['answer_text'] = $this->input->post('fill-answer', true);
		}
		else{
			$data['random_choice'] = $this->input->post('random-choice') == "on" ? '1' : '0';
		}

		
		$add = $this->Common->add_to_table('online_test_questions', $data);
		$this->push_if_transaction_error($add);

		$question_id = $add->output;

		// insert if multiple choice
		if($this->input->post('type')=="Single" or $this->input->post('type')=="Multiple"){
			foreach($this->input->post('answers') as $key => $answer){
				if($answer<>""){
					$data_answer = array(
						'question_id' => $question_id,
						'answer' => $answer
						);
					if($this->input->post('type')=="Single"){
						if($key==$this->input->post('true-answer'))
							$data_answer['is_right_answer'] = '1';
						else
							$data_answer['is_right_answer'] = '0';
					}
					else if($this->input->post('type')=="Multiple"){
						if(in_array($key, $this->input->post('true-answer')))
							$data_answer['is_right_answer'] = '1';
						else
							$data_answer['is_right_answer'] = '0';
					}

					$add = $this->Common->add_to_table('online_test_answer_choices', $data_answer);
					$this->push_if_transaction_error($add);
				}
			}
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    
		    $this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->any_error);
		}
		else
		{
	        $this->db->trans_commit();
	        $this->session->set_flashdata('err_no', '200');
			$this->session->set_flashdata('err_msg', 'Question has been added successfully');
		}
		
		redirect('otest/question/'.$test_id);
	}

	function update_question($test_id, $question_id){
		$this->check_user_access();

		$this->db->trans_start();
		$data = array(
			'question' => $this->input->post('question'),
			'answer_type' => $this->input->post('type', true)
			);

		if($this->input->post('type')=="Bool"){
			$data['boolean_type'] = $this->input->post('bool-type', true);
			$data['answer_text'] = $this->input->post('bool-answer', true);
			$data['random_choice'] = '0';
		}
		else if($this->input->post('type')=="Fill"){
			$data['answer_text'] = $this->input->post('fill-answer', true);
			$data['boolean_type'] = '';
			$data['random_choice'] = '0';
		}
		else{
			$data['random_choice'] = $this->input->post('random-choice') == "on" ? '1' : '0';
			$data['boolean_type'] = '';
			$data['answer_text'] = '';
		}

		
		$upd_question = $this->Common->update_data_on_table('online_test_questions', 'id', $question_id, $data);
		$this->push_if_transaction_error($upd_question);

		// updating data if multiple/single choice
		if($this->input->post('type')=="Single" or $this->input->post('type')=="Multiple"){
			// erase the record on field answer and is_right_answer
			$this->Otest_m->clear_data_answer($question_id);
			$answer_data = $this->Otest_m->get_answer_data(array('question_id' => $question_id));
			if($answer_data<>false){
				// walking on active record $answer_data
				$row_choice = $answer_data->first_row();
				// updating data answer
				foreach($this->input->post('answers') as $key => $answer){
					if($answer<>""){
						$data_answer = array(
							'answer' => $answer
							);
						if($this->input->post('type')=="Single"){
							if($key==$this->input->post('true-answer'))
								$data_answer['is_right_answer'] = '1';
							else
								$data_answer['is_right_answer'] = '0';
						}
						else if($this->input->post('type')=="Multiple"){
							if(in_array($key, $this->input->post('true-answer')))
								$data_answer['is_right_answer'] = '1';
							else
								$data_answer['is_right_answer'] = '0';
						}
						

						$upd_choice = $this->Common->update_data_on_table('online_test_answer_choices', 'id', $row_choice->id, $data_answer);
						$this->push_if_transaction_error($upd_choice);
						$row_choice = $answer_data->next_row();
					}
				}
			}
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    
		    $this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->any_error);
		}
		else
		{
	        $this->db->trans_commit();
	        $this->session->set_flashdata('err_no', '200');
			$this->session->set_flashdata('err_msg', 'Question has been updated successfully');
		}
		
		redirect('otest/question/'.$test_id);
	}

	function get_tutor_assignment($teacher_id){
		$this->check_user_access();
		$assignment_info = $this->Otest_m->get_assignment_data(array('teacher_id' => $teacher_id));
		$teacher_info = $this->User_m->get_user_by_id($teacher_id);
		$response = array();
		$response['tutor'] = array(
			'email' => $teacher_info->email_login,
			'name' => $teacher_info->first_name.' '.$teacher_info->last_name
			);
		$response['assignment'] = array();
		if($assignment_info<>false)
			foreach($assignment_info->result() as $row){
				if($row->course_id <> "")
					// get info of the course
					$course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
				// get taken assignment
				$taken_assignment = array();
				$taken_data = $this->Otest_m->get_taker_data(array('assignment_id' => $row->assignment_id));
            	if($taken_data<>false)
            	{
                	$taker = $taken_data->row();
            		$taken_assignment = array(
            			'taken_id' => $taker->taker_id,
            			'taken_time' => date_format(new DateTime($taker->taken_time), 'd M Y H:i'),
            			'total_question' => $this->Otest_m->count_submitted_answer($taker->taker_id),
            			'total_right_answer' => $this->Otest_m->count_submitted_answer($taker->taker_id, 'right'),
            			'score' => $taker->score,
            			'test_result' => strtoupper($taker->test_result),
            			'grade' => $taker->grade_score,
            			'passing_score' => $taker->passing_score
            			);
                }
                                        
				$response['assignment'][] = array(
					'assignment_id' => $row->assignment_id,
					'test_id' => $row->test_id,
					'teacher_id' => $row->teacher_id,
					'course' => isset($course_info) ? $course_info->row()->program_name.' - '.$course_info->row()->course_name : '-',
					'test_name' => $row->test_name,
					'taken_assignment' => empty($taken_assignment) ? 'empty' : $taken_assignment
					);
			}
		echo json_encode($response);
	}

	function add_assignment(){
		$this->check_user_access();
		$data = array(
			'test_id' => $this->input->post('test-id', true),
			'teacher_id' => $this->input->post('teacher-id', true)
			);
		// if test_id and teacher_id already exist, raise error
		$check = $this->Otest_m->get_assignment_data(array('ota.test_id' => $data['test_id'], 'ota.teacher_id' => $data['teacher_id']));
		if($check<>false){
			array_push($this->any_error, 'Test ID and Tutor ID already exist. Cannot create the same data. Please correct your data or delete the past data.');

			$this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->any_error);

			redirect('otest/tutor_assignment');
		}
		else{
			$result_insert = false;

			// 1.2 generate ID and check if duplicate
			$this->load->helper('myfunction_helper');
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
	        $this->load->library('notification');
	        $notif = array(
	        	'category' => 'new_test_assignment',
	        	'title' => 'Online Test Assignment',
	        	'content' => $this->lang->line('notification_new_test_assignment_create').' ID Assignment = '.$assignment_id,
	        	'sender_id' => 'admin', // admin
	        	'receiver_id' => $this->input->post('teacher-id', true) // tutor ID
	        	);
	        $this->notification->insert($notif);

	        $this->session->set_flashdata('err_no', '200');
			$this->session->set_flashdata('err_msg', 'Assignment has been added successfully');

			redirect('otest/tutor_assignment/'.$this->input->post('teacher-id', true));
		}
	}

	function delete_assignment($assignment_id, $teacher_id){
		$this->check_user_access();
		

		$del = $this->Common->delete_from_table_by_id('online_test_assignments', 'assignment_id', $assignment_id);
		$this->set_session_response_no_redirect('delete', $del);

		redirect('otest/tutor_assignment/'.$teacher_id);
	}

	function submit_answer(){
		
		$taker_id = $this->input->post('taker_id', true);

		$this->db->trans_start();
		foreach($this->input->post() as $key => $answer){
			$post_key = explode('-', $key);
			if($post_key[0]=="answer"){
				$question_id = $post_key[1];
				$check_correct = 'wrong'; // default is wrong, to make an easy checking process

				// check the answer type of each question id
				// we will check the correct answer of them
				$answer_type = $this->Otest_m->get_answer_type_of_question($question_id);
				if($answer_type=="Fill" or $answer_type=="Bool"){
					$answer_text = $this->Otest_m->get_answer_text_of_question($question_id);
					if($answer == $answer_text)
						$check_correct = 'right';
				}
				if($answer_type == "Single"){
					$right_choice = $this->Otest_m->get_right_answer_of_choice('single',$question_id);

					if($right_choice->id == $answer)
						$check_correct = 'right';
				}
				if($answer_type == "Multiple"){
					$right_choice = $this->Otest_m->get_right_answer_of_choice('multiple',$question_id);
					// store the array of ID for checking the chosen options
					$right_options = array();
					foreach($right_choice->result() as $row){
						array_push($right_options, $row->id);
					}
					// if the answer array include wrong chosen option, then it's wrong
					$wrong_chosen = 0;
					$string_of_ids = ''; // store the answer, string of ID
					foreach($answer as $ans){
						if(!in_array($ans, $right_options))
							$wrong_chosen += 1;
						$string_of_ids .= $ans.',';
					}
					$string_of_ids = rtrim($string_of_ids, ',');
					if($wrong_chosen == 0)
						$check_correct = 'right';
				}

				// prepare data
				$data_answer = array(
					'taker_id' => $taker_id,
					'question_id' => $question_id,
					'answer' => ($answer_type == "Multiple" ? $string_of_ids : $answer),
					'is_right' => $check_correct
					);
				$add = $this->Common->add_to_table('online_test_taker_answers', $data_answer);
				$this->push_if_transaction_error($add);
			}
			
		}

		$count_data = $this->Otest_m->count_submitted_answer($taker_id);
		$count_right_data = $this->Otest_m->count_submitted_answer($taker_id, 'right');

		// count score in 0 - 100
        $score = ceil(intval($count_right_data) / intval($count_data) * 100);
        // get grade of score
        $grade_info = $this->Otest_m->get_grade_by_value($score);

        $passing_score_info = $this->Content_m->get_option_by_param('passing_score');
        $passing_score = $passing_score_info->parameter_value;

        $test_result = (intval($score) >= intval($passing_score) ? 'Passed' : 'Failed');
        // update test taker status & result
		$data = array(
			'status' => 'Submitted', 
			'score' => $score,
			'grade_score' => $grade_info <> false ? $grade_info->grade : 'X',
			'test_result' => $test_result,
			'passing_score' => $passing_score
			);
		$upd = $this->Common->update_data_on_table('online_test_takers', 'taker_id', $taker_id, $data);
		$this->push_if_transaction_error($upd);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
			
		    $this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->any_error);

			print_r($this->any_error);
		}
		else{
			// get taken data
			$taker_info = $this->Otest_m->get_taker_data(array('taker_id' => $taker_id));
			$result['assignment_id'] = $taker_info->row()->assignment_id;

			$test_info = $this->Otest_m->get_test_by_assignment($taker_info->row()->assignment_id);

			$result['am'] = 'online_test';
			$data['gm'] = 'dashboard';
			$result['page_title'] = 'Online Test Result - ('.$test_info->test_id.') '.$test_info->test_name;
			$result['sub_page_title'] = $this->lang->line('test_result').' - ('.$test_info->test_id.') '.$test_info->test_name;
			$result['result'] = strtoupper($taker_info->row()->test_result);

			$this->open_page('otest_result', $result);
		}
	}

	function filter_data(){
		$random = $this->input->post('random-question') == "on" ? '1' : '0' ;
		$is_active = $this->input->post('is-active') == "on" ? '1' : '0' ;
		$auto = $this->input->post('auto-assignment') == "on" ? '1' : '0' ;
		$course_req = $this->input->post('course-request') == "on" ? '1' : '0' ;

		$get_data = $this->Otest_m->get_test_data_filter($is_active, $random, $auto, $course_req);
		// print_r($this->db->last_query());
		$response = array();
		if($get_data<>false)
			foreach($get_data->result() as $row){
				if($row->course_id<>""){
					// get info of the course
					$course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
					$course = $course_name->row()->program_name.' - '.$course_name->row()->course_name;
				}
				else
					$course = '-';
				$total_question = $this->Otest_m->count_question($row->test_id);

				$response[] = array(
					'id' => $row->test_id,
					'name' => $row->test_name,
					'course' => $course,
					'total_question' => $total_question,
					'active' => $row->is_active,
					'random' => $row->random_question,
					'auto' => $row->assign_to_new_tutor,
					'course_request' => $row->assign_to_course_request
					);
			}

		echo json_encode($response);
	}

	function save_config(){
		foreach($this->input->post() as $key => $input){
			$upd = $this->Common->update_data_on_table('options', 'parameter_name', $key, array('parameter_value' => $input));
			$this->push_if_transaction_error($upd);
		}

		$this->set_session_response_no_redirect_by_error('update');
		redirect('otest/setup');
	}

	function add_grade()
	{
		$data = array(
			'grade' => $this->input->post('grade', true),
			'min_score' => $this->input->post('min', true),
			'max_score' => $this->input->post('max', true)
			);
		$add = $this->Common->add_to_table('online_test_grades', $data);
		$this->set_session_response_no_redirect('add', $add);

		redirect('otest/grade_setup');
	}

	function update_grade()
	{
		$data = array(
			'grade' => $this->input->post('grade', true),
			'min_score' => $this->input->post('min', true),
			'max_score' => $this->input->post('max', true)
			);
		$upd = $this->Common->update_data_on_table('online_test_grades', 'grade_id', $this->input->post('id', true), $data);
		$this->set_session_response_no_redirect('update', $upd);

		redirect('otest/grade_setup');
	}

	function delete_grade()
	{
		$del = $this->Common->delete_from_table_by_id('online_test_grades', 'grade_id', $this->input->get('id', true));
		$this->set_session_response_no_redirect('delete', $del);

		redirect('otest/grade_setup');
	}

	function get_grade_by_id($id)
	{
		$get = $this->Otest_m->get_grade_data(array('grade_id' => $id));
		$data = $get->row();

		$response = array(
			'grade' => $data->grade,
			'min' => $data->min_score,
			'max' => $data->max_score
			);

		echo json_encode($response);
	}

	/* functions end */	
}