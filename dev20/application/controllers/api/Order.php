<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Order extends REST_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('User_m');
        $this->load->model('Location_m');
        $this->load->model('Common');
        $this->load->model('Content_m');
        $this->load->model('Teacher_m');
        $this->load->model('Course_m');
        $this->load->model('Order_m');
        $this->load->library('Logging');
        if($this->post('lang')<>"")
        	$this->lang_ = $this->post('lang');
        else if($this->get('lang')<>"")
        	$this->lang_ = $this->get('lang');
        else
        	$this->lang_ = 'en';
        $this->lang->load($this->lang_, ($this->lang_=="en" ? 'english' : 'indonesia'));
	}

	function prepare_order_get(){
		$this->load->library('Course_lib');
		$teacher_id = $this->get('tid');
		$response = array();
		// get course data
		$courses = $this->Teacher_m->get_verified_open_course_by_teacher_id($teacher_id, FALSE);
		// print_r($courses->result());
		$course_array = array();
		foreach($courses->result() as $course){
			$course_info = $this->Teacher_m->get_course_data_by_courseid($course->open_course_id);
			// get modul price & tryout
	        $pricings = $this->Course_m->get_course_pricing(array('cp.course_id' => $course->course_id));
	        if($pricings <> false){
		        $module_price = number_format($pricings->row()->module_price, 0, '.', ',');
		        $tryout_price = number_format($pricings->row()->tryout_price, 0, '.', ',');
		    }
		    else{
		    	$module_price = 0;
		        $tryout_price = 0;
		    }
	        // get days
	        $day_array = explode(',', $course_info->days);
	        $days = array();
			foreach($day_array as $day)
				$days[] = array(
					'id' => $day,
					'name' => $this->lang->line('day_'.$day)
					);

			$course_array[] = array(
				'open_course_id' => $course->open_course_id,
				'course_id' => $course->course_id,
				'days' => $days,
				'sessions' => explode(',', $course_info->session_hours),
				'program' => $course->program_name,
				'course_name' => $course->course_name,
				'module_price' => $module_price,
				'tryout_price' => $tryout_price,
				'salary' => $this->User_m->get_salary_per_hour($teacher_id)
				);
		}
		$response['courses'] = $course_array;

		// get open city fo course
		$response['cities'] = $this->Teacher_m->get_concat_city_by_teacher_id($teacher_id, FALSE)->result();
		// get teacher data
		$response['tutor_info'] = $this->User_m->get_user_by_id($teacher_id);

		$this->response($response);
	}

	function review_get(){
		$course_info = $this->Teacher_m->get_course_data_by_courseid($this->get('co'));
		// $course_info = $this->Course_m->get_courses(array('c.id' => $this->get('co')));
		$city_info = $this->Location_m->get_city(array('c.city_id' => $this->get('ci')))->row();
		$start_date = date_format(new DateTime($this->get('sd')), 'd M Y');
		$day_input = urldecode($this->get('day'));
		$day_array = explode(',', $day_input);
        $days = '';
		foreach($day_array as $day)
			$days .= $this->lang->line('day_'.$day).', ';
		$days = rtrim($days, ', ');

		$response = array(
			'program' => $course_info->program_name,
			'course_name' => $course_info->course_name,
			'city_name' => $city_info->city_name,
			'province_name' => $city_info->province_name,
			'start_date' => $start_date,
			'days' => $days
			);

		$this->response($response);
	}

	function save_post(){
		$student_id = $this->post('student_id');
		$teacher_id = $this->post('tutor_id');
		$any_error = false;
		if($this->post('address')=="" or $this->post('start_date')=="")
		{
			$any_error = true;
			$response = array(
				'status' => 'error',
				'message' => $this->lang->line('please_input_address_date')
				);
		}
		if($any_error==false)
		{
			// will make sure all transaction run completed or nothing
			$this->db->trans_start();
			// 1. insert order
			// 1.1 add data into orders
			$data = array(
				'student_id' => $student_id,
				'order_status' => 'Open',
				'address_course_held' => $this->post('address'),
				'start_date' => $this->post('start_date')
				);
			
			// 1.2 generate ID and check if duplicate
			$this->load->helper('myfunction_helper');
			$result_insert_order = false;
			while($result_insert_order==false){
				$date = date('ym');
				$prefix = 'TD'.$date;
				$new_id = $prefix.generate_random_string('number', 5);
				
				$data['order_id'] = $new_id;
				$insert = $this->Order_m->insert_new_order($data);
				if($insert)
					$result_insert_order = true;
				else
					$result_insert_order = false;
			}
			// $date = date('ym');
			// $prefix = 'TD'.$date;
			// $new_id = $prefix.uniqid();
			
			// $data['order_id'] = $new_id;
			// $insert = $this->Order_m->insert_new_order($data);

			$order_id = $new_id;
			// 2. insert order courses
			$total_price = 0;
			
	        $teacher_info = $this->User_m->get_user_info($teacher_id);
	        // get info of the course
	        $course_info = $this->Teacher_m->get_course_data_by_courseid($this->post('course_id'));
		    // $course_info = $this->Course_m->get_courses(array('c.id' => $this->post('course_id')));
            // get salary per hour
            $salary = $this->User_m->get_salary_per_hour($teacher_id);
            // get modul price & tryout
	        $pricings = $this->Course_m->get_course_pricing(array('cp.course_id' => $course_info->course_id));
	        if($pricings <> false){
		        $module_price = number_format($pricings->row()->module_price, 0, '.', ',');
		        $tryout_price = number_format($pricings->row()->tryout_price, 0, '.', ',');
		    }
		    else{
		    	$module_price = 0;
		        $tryout_price = 0;
		    }

            // calculate sub price
            $sub_price = $salary * $this->post('session') * $this->post('class') / 1.5; // unit jam ngajar yang berlaku = 1,5 jam
            if($this->post('inc_module')=="true")
            	$sub_price += $module_price;
            if($this->post('inc_tryout')=="true")
            	$sub_price += $tryout_price;

            $data = array(
				'order_id' => $order_id,
				'course_id' => $course_info->course_id,
				'teacher_id' => $teacher_id,
				'city_id' => $this->post('city_id'),
				'days' => $this->post('days'),
				'session_hour' => $this->post('session'),
				'class_in_month' => $this->post('class'),
				'module_price' => $this->post('inc_module')=="true" ? $module_price : '0',
				'tryout_price' => $this->post('inc_tryout')=="true" ? $tryout_price : '0',
				'teacher_salary_per_hour' => $salary,
				'total_price' => $sub_price
				);

            $add = $this->Order_m->insert_new_order_course($data);

            $total_price += $sub_price;
			
			// 3. update order aggregate
			$upd_data = array(
				'count_course' => '1',
				'count_teacher' => '1',
				'total_price' => $total_price,
				'grand_total' => $total_price
				);
			$upd = $this->Common->update_data_on_table('orders', 'order_id', $order_id, $upd_data);

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
			    $response = array(
					'status' => 'error',
					'message' => $this->lang->line('order_failed_to_submit')
					);
			}
			else
			{
		        $this->db->trans_commit();
		        $response = array(
					'status' => 'OK',
					'order_id' => $order_id
					);

				// 5. send email & notification
				$this->load->library('My_PHPMailer');
				
				$this->load->library('notification');
				// 5.1 to student
				$student_info = $this->User_m->get_user_info($student_id);
		        $notif_to_student = array(
		        	'category' => 'reply_course_request',
		        	'title' => $this->lang->line('reply_course_request'),
		        	'content' => $this->lang->line('hi').' '.$student_info->first_name.', '.$this->lang->line('we_will_contact_tutor_to_make_communication_tih_student'),
		        	'receiver_id' => $this->post('student_id'),
		        	'sender_id' => 'admin'
		        	);
		        $this->notification->insert($notif_to_student);

	          	// get email template from database
		        $get_template = $this->Content_m->get_email_templates(array('id' => 'course-request-for-student-'.$this->lang_));
		        $template = htmlspecialchars_decode($get_template->row()->content);
		        
		        // prepare data to replace 
		        $content = $template;
		        $content = str_replace('[ORDER_ID]', $order_id, $content);
		        $get_address_office = $this->Content_m->get_option_by_param('company_address');
		        $content = str_replace('[ADDRESS_OFFICE]', $get_address_office->parameter_value, $content);
 
	          	$mail = new PHPMailer();
	          	$mail->IsSMTP(); // we are going to use SMTP
		        $mail->SMTPAuth   = true; // enabled SMTP authentication
		        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
		        $mail->Host       = $this->config->item('smtp_host');      // setting GMail as our SMTP server
		        $mail->Port       = $this->config->item('smtp_port');                   // SMTP port to connect to GMail
		        $mail->Username   = $this->config->item('smtp_user');  // user email address
		        $mail->Password   = $this->config->item('smtp_pass');            // password in GMail
		        $mail->SetFrom('admin@tutordoors.com', 'Admin Tutordoors');  //Who is sending the email
		        $mail->Subject    = $this->lang->line('course_request_received');

		        $mail->Body      = $content;
		        $mail->AltBody    = "Plain text message";
		        $destino = $student_info->email_login; // Who is addressed the email to
		        $mail->AddAddress($destino, $student_info->first_name.' '.$student_info->last_name);

		        if(!$mail->Send()) {
		        	$this->logging->insert_event_logging('send_email_course_request_student', '', 'false', $mail->ErrorInfo);
		        } else {
		            $this->logging->insert_event_logging('send_email_course_request_student', '', 'true', 'Message sent');
		        }

		        // 5.2 to admin
		        $notif_to_admin = array(
		        	'category' => 'new_course_request',
		        	'title' => $this->lang->line('course_request_new'),
		        	'content' => $this->lang->line('course_request_from').$student_info->first_name.' '.$student_info->last_name,
		        	'sender_id' => $student_id,
		        	'receiver_id' => 'admin' // admin
		        	);
		        $this->notification->insert($notif_to_admin);

		        // send push notification to mobile application
		        $this->load->library('Push_Notification_Lib');
		        $push_result = $this->push_notification_lib->send('admin', $notif_to_admin['title'], $this->lang->line('course_request_from').$student_info->first_name.' '.$student_info->last_name);

		        // 5.3 to teachers
	        	$notif_to_teacher = array(
		        	'category' => 'new_course_request',
		        	'title' => $this->lang->line('course_request_new'),
		        	'content' => $this->lang->line('course_request_from').$student_info->first_name.' '.$student_info->last_name,
		        	'sender_id' => $student_id,
		        	'receiver_id' => $teacher_id
		        	);
		        $this->notification->insert($notif_to_teacher);
		        // send push notification to mobile application
		        $push_result = $this->push_notification_lib->send($teacher_id, $notif_to_teacher['title'], $this->lang->line('course_request_from').$student_info->first_name.' '.$student_info->last_name);

		        // get email template from database
		        $get_template = $this->Content_m->get_email_templates(array('id' => 'course-request-for-tutor-'.$this->lang_));
		        $template = htmlspecialchars_decode($get_template->row()->content);
		        
		        // prepare data to replace 
		        $content = $template;
		        $content = str_replace('[STUDENT_FIRST_NAME]', $student_info->first_name, $content);
		        $content = str_replace('[STUDENT_LAST_NAME]', $student_info->last_name, $content);
		        $content = str_replace('[STUDENT_FULL_NAME]', $student_info->first_name.' '.$student_info->last_name, $content);
		        $get_address_office = $this->Content_m->get_option_by_param('company_address');
		        $content = str_replace('[ADDRESS_OFFICE]', $get_address_office->parameter_value, $content);

				$mail = new PHPMailer();
		        $mail->IsSMTP(); // we are going to use SMTP
		        $mail->SMTPAuth   = true; // enabled SMTP authentication
		        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
		        $mail->Host       = $this->config->item('smtp_host');      // setting GMail as our SMTP server
		        $mail->Port       = $this->config->item('smtp_port');                   // SMTP port to connect to GMail
		        $mail->Username   = $this->config->item('smtp_user');  // user email address
		        $mail->Password   = $this->config->item('smtp_pass');            // password in GMail
		        $mail->SetFrom('admin@tutordoors.com', 'Admin Tutordoors');  //Who is sending the email
		        $mail->Subject    = $this->lang->line('course_request_received');

		        $mail->Body      = $content;
		        $mail->AltBody    = "Plain text message";
		        $destino = $teacher_info->email_login; // Who is addressed the email to
		        $mail->AddAddress($destino, $teacher_info->first_name.' '.$teacher_info->last_name);

		        if(!$mail->Send()) {
		        	$this->logging->insert_event_logging('send_email_course_request', '', 'false', $mail->ErrorInfo);
		        } else {
		            $this->logging->insert_event_logging('send_email_course_request', '', 'true', 'Message sent');
		        }
		               
			}
		}
		
		
		$this->response($response);
	}

	function student_open_request_get(){
		$user_id = $this->get('sid');
		$this->load->library('Course_lib');
		$response = array();
		// get new open course request
		$data = $this->Order_m->get_open_order_without_course_by_studentid($user_id);
		if($data<>false){
			foreach($data->result() as $order){
				$order_course = $this->Order_m->get_order_courses($order->order_id);
                $course_tutor = $this->Order_m->get_order_courses_distinct_tutor($order->order_id);

                if($order_course<>false)
                {
                    $course = $order_course->row();
                    // get info of the course
                    $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                    $program_name = $course_info->row()->program_name;
                    $course_name = $course_info->row()->course_name;
                    // get days
                    $day_string = $this->course_lib->get_days_string($course->days);
                    // additional modules
                    $modules = $this->course_lib->get_additional_module($course);
                }
                if($course_tutor<>false)
                {
                    $tutor = $course_tutor->row();
                    $user_info = $this->User_m->get_user_info($tutor->teacher_id);
                    $tutor_name = $user_info->first_name.' '.$user_info->last_name;
                }

                $response[] = array(
                	'order_id' => $order->order_id,
                	'tutor' => $tutor_name,
                	'course' => $course_name,
                	'program' => $program_name,
                	'status' => $order->order_status,
                	'address' => $order->address_course_held,
                	'start_date' => date_format(new DateTime($order->start_date), 'd M Y')
                	);

			}
		}
		
		$this->response($response);
	}

	function student_accepted_request_get(){
		$user_id = $this->get('sid');
		$response = array();
		// get new open course request
		$data = $this->Order_m->get_accepted_order_without_course_by_studentid($user_id);
		if($data<>false){
			foreach($data->result() as $order){
				$order_course = $this->Order_m->get_order_courses($order->order_id);
                $course_tutor = $this->Order_m->get_order_courses_distinct_tutor($order->order_id);

                if($order_course<>false)
                {
                    $course = $order_course->row();
                    // get info of the course
                    $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                    $program_name = $course_info->row()->program_name;
                    $course_name = $course_info->row()->course_name;
                    // get days
                    $day_string = $this->course_lib->get_days_string($course->days);
                    // additional modules
                    $modules = $this->course_lib->get_additional_module($course);
                }
                if($course_tutor<>false)
                {
                    $tutor = $course_tutor->row();
                    $user_info = $this->User_m->get_user_info($tutor->teacher_id);
                    $tutor_name = $user_info->first_name.' '.$user_info->last_name;
                }

                // get the invoice
                $this->load->model('Invoice_m');
                $invoice = $this->Invoice_m->get_invoice_by_ref_id($order->order_id);

                $response[] = array(
                	'order_id' => $order->order_id,
                	'tutor' => $tutor_name,
                	'course' => $course_name,
                	'program' => $program_name,
                	'status' => $order->order_status,
                	'address' => $order->address_course_held,
                	'start_date' => date_format(new DateTime($order->start_date), 'd M Y'),
                	'invoice_id' => ($invoice==false ? "" : $invoice->invoice_id)
                	);

			}
		}

		$this->response($response);
	}

	function tutor_open_request_get(){
		$user_id = $this->get('tid');
		$this->load->library('Course_lib');
		$response = array();
		// get new open course request
		$data = $this->Order_m->get_open_order_by_teacherid($user_id);
		if($data<>false){
			foreach($data->result() as $order){
				$order_course = $this->Order_m->get_order_courses($order->order_id);
                // $course_tutor = $this->Order_m->get_order_courses_distinct_tutor($order->order_id);

                if($order_course<>false)
                {
                    $course = $order_course->row();
                    // get info of the course
                    $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                    $program_name = $course_info->row()->program_name;
                    $course_name = $course_info->row()->course_name;
                    // get days
                    $day_string = $this->course_lib->get_days_string($course->days);
                    // additional modules
                    $modules = $this->course_lib->get_additional_module($course);
                }
                // if($course_tutor<>false)
                // {
                //     $tutor = $course_tutor->row();
                //     $user_info = $this->User_m->get_user_info($tutor->teacher_id);
                //     $tutor_name = $user_info->first_name.' '.$user_info->last_name;
                // }

                $response[] = array(
                	'order_id' => $order->order_id,
                	'city' => $order->city_name,
                	'student' => $order->first_name.' '.$order->last_name,
                	// 'tutor' => $tutor_name,
                	'course' => $course_name,
                	'program' => $program_name,
                	'status' => $order->order_status,
                	'address' => $order->address_course_held,
                	'start_date' => date_format(new DateTime($order->start_date), 'd M Y'),
                	'order_date' => date_format(new DateTime($order->entry_date), 'd M Y H:i')
                	);

			}
		}
		
		$this->response($response);
	}

	function tutor_accepted_request_get(){
		$user_id = $this->get('tid');
		$this->load->library('Course_lib');
		$response = array();
		// get new open course request
		$data = $this->Order_m->get_accepted_order_by_teacherid($user_id);
		if($data<>false){
			foreach($data->result() as $order){
				$order_course = $this->Order_m->get_order_courses($order->order_id);
                // $course_tutor = $this->Order_m->get_order_courses_distinct_tutor($order->order_id);

                if($order_course<>false)
                {
                    $course = $order_course->row();
                    // get info of the course
                    $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                    $program_name = $course_info->row()->program_name;
                    $course_name = $course_info->row()->course_name;
                    // get days
                    $day_string = $this->course_lib->get_days_string($course->days);
                    // additional modules
                    $modules = $this->course_lib->get_additional_module($course);
                }

                $response[] = array(
                	'order_id' => $order->order_id,
                	'city' => $order->city_name,
                	'student' => $order->first_name.' '.$order->last_name,
                	// 'tutor' => $tutor_name,
                	'course' => $course_name,
                	'program' => $program_name,
                	'status' => $order->order_status,
                	'address' => $order->address_course_held,
                	'start_date' => date_format(new DateTime($order->start_date), 'd M Y'),
                	'order_date' => date_format(new DateTime($order->entry_date), 'd M Y H:i')
                	);

			}
		}
		
		$this->response($response);
	}

	function teacher_confirm_order_course_post(){
		// 1. change order status 
		$upd = $this->Order_m->set_order_course_status($this->post('order-id'), $this->post('course-id'), 'Accept');
		if($upd){
			$response = array('status'=>'200', 'message'=>'Accept');
			$this->check_order_courses_status_and_notify_admin($this->post('order-id'));
		}
		else
			$response = array('status'=>'204', 'message'=>$upd->output);

        $this->response($response);
	}

	function teacher_reject_course_order_post(){
		$upd = $this->Order_m->set_order_course_status($this->post('order-id'), $this->post('course-id'), 'Reject', $this->post('reason'));
		if($upd){
			$response = array('status'=>'200', 'message'=>'Reject');
			$this->check_order_courses_status_and_notify_admin($this->post('order-id'));
		}
		else
			$response = array('status'=>'204', 'message'=>$upd->output);

        $this->response($response);
	}

	function check_order_courses_status_and_notify_admin($order_id){
		$count_open = $this->Order_m->count_open_order_courses($order_id);
		if($count_open==0){
			// give notification to admin
	        $this->load->library('notification');
	        $notif = array(
	        	'category' => 'tutor_order_confirmation_finished',
	        	'title' => 'Order has been confirmed',
	        	'content' => 'Order ID '.$order_id." has been confirmed. Now, it's your time to make an invoice.",
	        	'sender_id' => ($this->session->userdata('logged')=="in" ? $this->session->userdata('userid') : ''),
	        	'receiver_id' => 'admin'
	        	);
	        $add_notif = $this->notification->insert($notif);

	        // send push notification to mobile application
	        $this->load->library('Push_Notification_Lib');
	        $push_result = $this->push_notification_lib->send('admin', $notif['title'], $notif['content']);
		}
	}
}