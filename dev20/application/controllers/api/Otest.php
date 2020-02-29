<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Otest extends REST_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Otest_m');
        $this->load->model('Common');
        $this->load->model('Course_m');
        $this->load->library('Course_lib');
        if($this->post('lang')<>"")
        	$this->lang_ = $this->post('lang');
        else if($this->get('lang')<>"")
        	$this->lang_ = $this->get('lang');
        else
        	$this->lang_ = 'en';
        $this->lang->load($this->lang_, ($this->lang_=="en" ? 'english' : 'indonesia'));
	}

    function assignment_list_get(){
        $tutor_id = $this->get('tid');
        
        $response = array();
        $assignment = $this->Otest_m->get_assignment_data(array('teacher_id' => $tutor_id));
        if($assignment<>false)
            foreach($assignment->result() as $row){
                $course_name = '(-)';
                if($row->course_id <> ""){
                    $course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
                    $course_name = $course_info->row()->program_name.' - '.$course_info->row()->course_name;
                }
                $taker_data = $this->Otest_m->get_taker_data(array('assignment_id' => $row->assignment_id));
                $result = $taken_time = '(-)';
                if($taker_data<>false){
                    // diambil hanya tes terakhir
                    $result = $taker_data->row()->test_result;
                    $taken_time = date_format(new DateTime($taker_data->row()->taken_time), 'd M Y H:i');
                }

                $response[] = array(
                    'assignment_id' => $row->assignment_id,
                    'test_id' => $row->test_id,
                    'test_name' => $row->test_name,
                    'course_name' => $course_name,
                    'result' => $result,
                    'taken_time' => $taken_time
                    );
            }

        $this->response($response);
    }

    function preview_get($assignment_id, $test_id){
        $assignment_id = $this->get('assid');
        $test_id = $this->get('testid');
        
        $response = array();
        $test_info = $this->Otest_m->get_test_data(array('test_id' => $test_id));
        if($test_info<>false){
            if($test_info->row()->course_id <> "")
                $course_info = $this->Course_m->get_courses(array('c.id' => $test_info->row()->course_id));
            $response = array(
                'test_data' => $test_info->row(),
                'assignment_id' => $assignment_id,
                'test_id' => $test_id,
                'course_name' => isset($course_info) ? $course_info->row()->program_name.' - '.$course_info->row()->course_name : '(-)'
                );
        }
        
        $this->response($response);
    }

    function start_get(){
        $assignment_id = $this->get('assid');
        $test_id = $this->get('testid');
        $test_info = $this->Otest_m->get_test_data(array('test_id' => $test_id));
        $response = array();
        $response['title'] = 'Online Test - ('.$test_info->row()->test_id.') '.$test_info->row()->test_name;
        // check if no overtaken of this test
        // take test only permitted one time
        if($this->Otest_m->count_assignment_taken($assignment_id) > 0) // if > 0 then already taken
        {
            $response = array('status' => '204', 'message' => $this->lang->line('test_overtaken'));
        }
        else
        {
            $response['status'] = '200';
            $get_questions = $this->Otest_m->get_question_data(array('test_id' => $test_id));
            $is_random_question = $test_info->row()->random_question;
            if($is_random_question=="0"){
                $response['questions'] = $get_questions->result_array();
            }
            else if($is_random_question=="1"){
                $question_array = $get_questions->result_array();
                shuffle($question_array);
                $response['questions'] = $question_array;
            }
            
            foreach($response['questions'] as $key => $que){
                if($que['answer_type'] == "Single" or $que['answer_type'] == "Multiple"){
                    $response['questions'][$key]['answer_data'] = array();
                    $answer_data = $this->Otest_m->get_answer_data(array('question_id' => $que['id']));
                    $answer_array = $answer_data->result_array();
                    if($que['random_choice']=="1")
                        shuffle($answer_array);
                    $response['questions'][$key]['answer_data'] = $answer_array;
                }
            }
            $response['test_data'] = $test_info->row();
            $response['assignment_id'] = $assignment_id;
            $response['test_id'] = $test_id;
            if($test_info->row()->course_id <> "")
                $course_info = $this->Course_m->get_courses(array('c.id' => $test_info->row()->course_id));
            $response['course'] = isset($course_info) ? $course_info->row()->program_name.' - '.$course_info->row()->course_name : '(-)';
            
            // insert the taker data
            $taker = array(
                'assignment_id' => $assignment_id,
                'status' => 'Created'
                );
            $add = $this->Common->add_to_table('online_test_takers', $taker);
            $response['taker_id'] = $add->output;
        }

        $this->response($response);
    }

    function submit_answer_post(){
        $this->load->model('Content_m');
        $taker_id = $this->post('taker_id');
        $response = array();

        $this->db->trans_start();
        foreach($this->post() as $key => $answer){
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
                if($answer_type == "Single" or $answer_type == "Multiple"){
                    $right_choice = $this->Otest_m->get_right_answer_of_choice('single',$question_id);

                    if($right_choice->id == $answer)
                        $check_correct = 'right';
                }
                // // sementara multiple answer dinonaktifkan dan menjadi single answer
                // if($answer_type == "Multiple"){
                //     $right_choice = $this->Otest_m->get_right_answer_of_choice('multiple',$question_id);
                //     // store the array of ID for checking the chosen options
                //     $right_options = array();
                //     foreach($right_choice->result() as $row){
                //         array_push($right_options, $row->id);
                //     }
                //     // if the answer array include wrong chosen option, then it's wrong
                //     $wrong_chosen = 0;
                //     $string_of_ids = ''; // store the answer, string of ID
                //     foreach($answer as $ans){
                //         if(!in_array($ans, $right_options))
                //             $wrong_chosen += 1;
                //         $string_of_ids .= $ans.',';
                //     }
                //     $string_of_ids = rtrim($string_of_ids, ',');
                //     if($wrong_chosen == 0)
                //         $check_correct = 'right';
                // }

                // prepare data
                $data_answer = array(
                    'taker_id' => $taker_id,
                    'question_id' => $question_id,
                    'answer' => $answer,
                    'is_right' => $check_correct
                    );
                $add = $this->Common->add_to_table('online_test_taker_answers', $data_answer);
                if(!$add->status)
                    $response = array('status' => '204', $add->output);
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
        if(!$upd->status)
            $response = array('status' => '204', $upd->output);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else{
            // get taken data
            $taker_info = $this->Otest_m->get_taker_data(array('taker_id' => $taker_id));

            $result['result'] = strtoupper($taker_info->row()->test_result);
            $response = array(
                'status' => '200',
                'assignment_id' => $taker_info->row()->assignment_id,
                'result' => strtoupper($taker_info->row()->test_result)
                );
        }

        $this->response($response);
    }
}