<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Course extends REST_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Course_m');
        $this->load->model('Content_m');
        $this->load->model('Order_m');
        $this->load->model('Location_m');
        $this->load->model('Common');
        if($this->post('lang')<>"")
        	$this->lang_ = $this->post('lang');
        else if($this->get('lang')<>"")
        	$this->lang_ = $this->get('lang');
        else
        	$this->lang_ = 'en';
        $this->lang->load($this->lang_, ($this->lang_=="en" ? 'english' : 'indonesia'));
	}

	function index_get(){
		$programs = array();
		foreach($this->Course_m->get_programs()->result() as $prog){
			$course_array = array();
			$get_course = $this->Course_m->get_courses(array('c.program_id' => $prog->program_id));
			foreach($get_course->result() as $course){
				$course_array[] = array(
					'course_id' => $course->id,
					'course_name' => $course->course_name
				);
			}
			$programs[] = array(
				'program_id' => $prog->program_id,
				'program_name' => $prog->program_name,
				'course' => $course_array
				);
		}

		$this->response($programs);
	}

	function program_get(){
		$this->response($this->Course_m->get_programs()->result());
	}

	function course_get(){
		$id = $this->get('id');
		$this->response($this->Course_m->get_courses(array('c.program_id' => $id))->result());
	}

	function request_detail_get(){
		$order_id = $this->get('oid');
		$response = array();
		$data = $this->Order_m->get_order_course_detail($order_id);
		foreach($data->result() as $cou){
			// get info of the course
			$course_info = $this->Course_m->get_courses(array('c.id' => $cou->course_id));
            // get days
            $day_string = $this->get_days_string($cou->days);
            // additional modules
            $modules = $this->get_additional_module($cou);
            // get city and province
            $city_info = $this->Location_m->get_city(array('c.city_id' => $cou->city_id))->row();

			$response[] = array(
				'order_id' => $order_id,
				'course_id' => $cou->course_id,
				'program' => $course_info->row()->program_name,
				'course' => $course_info->row()->course_name,
				'days' => $day_string,
				'modules' => $modules,
				'student_id' => $cou->student_id,
				'student_fn' => $cou->student_fn,
				'student_ln' => $cou->student_ln,
				'student_email' => $cou->student_email,
				'student_phone' => $cou->student_phone,
				'tutor_id' => $cou->teacher_id,
				'tutor_fn' => $cou->teacher_fn,
				'tutor_ln' => $cou->teacher_ln,
				'tutor_email' => $cou->teacher_email,
				'tutor_phone' => $cou->teacher_phone,
				'total_price' => $cou->total_price,
				'grand_total' => $cou->grand_total,
				'address' => $cou->address_course_held,
				'start_date' => date_format(new DateTime($cou->start_date), 'd M Y'),
				'city_id' => $cou->city_id,
				'city_name' => $cou->city_name,
				'province_name' => $city_info->province_name,
				'session' => $cou->session_hour,
				'class' => $cou->class_in_month,
				'module_price' => $cou->module_price,
				'tryout_price' => $cou->tryout_price,
				'order_status' => $cou->order_status,
				'order_course_status' => $cou->order_course_status,
				'salary' => $cou->teacher_salary_per_hour
				);
		}
		$this->response($response);
	}

	function get_days_string($days){
		$day_string = '';
		foreach(explode(',', $days) as $day)
	        $day_string .= $this->lang->line('day_'.$day).', ';
	    $day_string = rtrim($day_string, ', ');

	    return $day_string;
	}

	function get_additional_module($course_array){
		$result = '';
		if($course_array->module_price > 0)
			$result .= $this->lang->line('module_study').', ';
		if($course_array->tryout_price > 0)
			$result .= $this->lang->line('module_tryout').', ';

		$result = rtrim($result, ', ');

		return $result;
	}

    function search_by_program_get(){
        $response = array();
        $programs = $this->Course_m->count_verified_tutor_courses_under_programs();
        foreach($programs->result() as $program){
            $response[] = array(
                'program_id' => $program->program_id,
                'program' => $program->program_name,
                'count' => $program->counted_tutors
                );
        }

        $this->response($response);
    }

    function running_course_get(){
    	$this->load->model('User_m');
    	$this->load->library('Course_lib');
    	$user_id = $this->get('uid');
    	$role = $this->get('role');
    	$response = array();
    	$data = $this->Course_m->get_course_enrollment_by_userid($role, $user_id, 'false');
    	if($data <> false){
    		foreach($data->result() as $course){
    			// get info of the course
                $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                // get order course detail
                $order_course = $this->Order_m->get_order_with_course($course->order_id, $course->course_id);
                // fetch days
                $days = $this->course_lib->get_days_string($order_course->days);
                // get student info data
                $student_info = $this->User_m->get_user_info_data($course->student_id);

    			$response[] = array(
    				'enroll_id' => $course->enroll_id,
    				'program' => $course_info->row()->program_name,
    				'course' => $course_info->row()->course_name,
    				'city' => $course->city_name,
    				'days' => $days,
    				'class' => $order_course->class_in_month,
    				'session' => $order_course->session_hour,
    				'student' => $course->student_fn.' '.$course->student_ln,
    				'tutor' => $course->teacher_fn.' '.$course->teacher_ln,
    				'tutor_phone' => $course->phone_1,
    				'student_phone' => $student_info->phone_1
    				);
    		}
    	}

    	$this->response($response);
    }

    function presence_list_get(){
    	$enroll_id = $this->get('eid');
    	$this->load->library('Course_lib');
		$response = array();
		$data = $this->Course_m->get_course_monitoring_by_enrollid($enroll_id);
		if($data==false)
			$response['presence'] = array();
		else{
			foreach($data->result() as $row){
				$response['presence'][] = array(
					'monitoring_id' => $row->monitoring_id,
					'teach_date' => date_format(new DateTime($row->teach_date), 'd M Y'),
					'start_time' => date_format(new DateTime($row->time_start), 'H:i'),
					'end_time' => date_format(new DateTime($row->time_end), 'H:i'),
					'teacher_entry' => $row->teacher_entry,
					'student_entry' => $row->student_entry
					);
			}
		}

		$enroll_info = $this->Course_m->get_course_enrollment($enroll_id);
		// get info of the course
		$course_info = $this->Course_m->get_courses(array('c.id' => $enroll_info->course_id));
		
		$response['course_name'] = $course_info->row()->program_name.' - '.$course_info->row()->course_name;
		$response['student_name'] = $enroll_info->student_fn.' '.$enroll_info->student_ln;
		$response['teacher_name'] = $enroll_info->teacher_fn.' '.$enroll_info->teacher_ln;

		$this->response($response);
	}

	function add_absence_post(){
		$data = array(
			'enroll_id' => $this->post('eid'),
			'teach_date' => $this->post('teach-date'),
			'time_start' => $this->post('start-time'),
			'time_end' => $this->post('end-time'),
			'teacher_entry' => 'true',
			'teacher_entry_timestamp' => date('Y-m-d H:i:s')
			);
		
		$add = $this->Common->add_to_table('course_monitoring', $data);
		if($add->status)
			$response = array('status'=>'200');
		else
			$response = array('status'=>'204', 'message'=>$add->output);

		$this->response($response);
	}

	function student_confirm_absence_post(){
		$monitoring_id = $this->post('monid');
		$enroll_id = $this->post('eid');

		$data = array(
			'student_entry' => 'true',
			'student_entry_timestamp' => date('Y-m-d H:i:s')
			);
		
		
		$set = $this->Common->update_data_on_table('course_monitoring', 'monitoring_id', $monitoring_id, $data);

		if($set->status)
			$response = array('status'=>'200');
		else
			$response = array('status'=>'204', 'message'=>$set->output);

		$this->response($response);
	}
}