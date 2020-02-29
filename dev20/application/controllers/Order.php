<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->library('Logging');
	}

	/* Page Start */

	function cart(){
		if($this->session->userdata('level')=="student"){
			$data['cart_array'] = $this->order_lib->get_cart_session();
			$data['page_title'] = $this->lang->line('cart');
			// $data['total_price'] = $this->calculate_total_price();

			// get provinces
			$data['provinces'] = $this->Location_m->get_province();

			// get root course category
			$data['programs'] = $this->Course_m->get_programs();
			// foreach($data['programs']->result() as $root){
			// 	$get_teachers = $this->Teacher_m->get_data_concat_course_by_education_level($root->id);
				
			// 	if($get_teachers<>false){
			// 		foreach($get_teachers->result() as $teacher){
			// 			// get more user info
			// 			$user_info = $this->User_m->get_user_info($teacher->user_id);
			// 			$total_viewed = $user_info->total_viewed;
			// 			// $total_taken_course = $this->Teacher_m->get_total_taken_course($teacher->user_id);

			// 			$data['teachers'][$root->id][] = array(
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

			// use session to store checkpoint
			$this->session->set_userdata('step_teacher_profile', 'on');
			$this->session->set_userdata('step_form_order', 'on');
			$this->session->set_userdata('step_review_order', 'on');
			$this->session->set_userdata('step_order_finish', 'off');

			$this->open_page('cart', $data);
		}
		else
			$this->show_error_page(204, $this->lang->line('error_page_student_only'));
	}

	function open_order_request(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'course-open-request',
			'title_page' => 'Open Order Request From Students',
			'title' => ''
			);

		$data['open_order'] = $this->Order_m->admin_view_open_order();
		
		$this->open_admin_page('admin/order/open_order', $data);
	}

	function order_course_detail($order_id){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'course-open-request',
			'title_page' => 'Order Course Detail for '.$order_id,
			'title' => ''
			);

		$data['order'] = $this->Order_m->get_order_by_id($order_id);
		$data['order_course'] = $this->Order_m->get_order_course_detail($order_id);
		$data['order_id'] = $order_id;
		$data['accepted_course'] = $this->Order_m->count_course_accepted_order_courses($order_id);
		$data['accepted_teacher'] = $this->Order_m->count_teacher_accepted_order_courses($order_id);
		$data['accepted_total_price'] = $this->Order_m->sum_accepted_total_price_order_courses($order_id);
		
		$this->open_admin_page('admin/order/open_order_course_detail', $data);
	}

	function rejected(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'course-rejected',
			'title_page' => 'Rejected Order',
			'title' => ''
			);

		$data['rejects'] = $this->Order_m->admin_view_open_order('Reject');
		
		$this->open_admin_page('admin/order/rejected_order', $data);
	}

	/* Page End */
	/* Function Start */

	function get_day_string($days=null){
		$day_string = '';
		foreach(explode('-', $days) as $day)
			$day_string .= $this->lang->line('day_'.$day).', ';
		$response = array('days' => rtrim($day_string, ', '));

		echo json_encode($response);
	}

	function check_input_course(){
		if(sizeof($this->input->post('course'))==0){
			$this->form_validation->set_message('check_input_course', '{field} '.$this->lang->line('error_require_one_or_more'));
            return FALSE;
		}
		else
			return TRUE;
	}

	function remove_cart_item($teacher_id, $course_id){
		if($this->session->userdata('level')=="teacher"){
			$response['status'] = '301';
			$response['message'] = $this->lang->line('error_teacher_cannot_enter');
		}
		else{
			$carts = $this->order_lib->get_cart_session();
			unset($carts[$teacher_id][$course_id]);
			if(sizeof($carts[$teacher_id])==0)
				unset($carts[$teacher_id]); // jika array teacher sudah habis, unset sekalian teacher-nya
			$this->order_lib->set_cart_session($carts);
			
			redirect('order/cart');
		}
	}

	function add_cart(){
		if($this->session->userdata('level')=="teacher"){
			$response['status'] = '301';
			$response['message'] = $this->lang->line('error_teacher_cannot_enter');
		}
		else{
			$this->load->helper(array('form'));
			$this->load->library('form_validation');

			$rules = array(
				array(
					'field' => 'city',
					'label' => $this->lang->line('city'),
					'rules' => 'required',
					'errors' => array('required' => '%s '.$this->lang->line('error_select_only_one'))
					),
				array(
					'field' => 'course',
					'label' => $this->lang->line('course'),
					'rules' => 'callback_check_input_course'
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
				$carts = $this->order_lib->get_cart_session();
				$cart_on_teacher = array(
					$this->input->post('teacher') => array()
					);
				foreach($this->input->post('course') as $selected_course){
					$any_error = false;
					// 0. get info of the course
					$course_info = $this->Course_m->get_courses(array('c.id' => $selected_course));
					// 1. fetch all course data using name
					// 1.1 days data
					if($this->input->post('days-'.$selected_course)<>""){
						$day_string = '';
						foreach($this->input->post('days-'.$selected_course) as $day)
							$day_string .= $day.',';
						$day_string = rtrim($day_string, ',');
					}
					else{
						$response['status'] = '301';
						$response['message'] = $this->lang->line('course').' '.$course_info->row()->course_name.' '.$this->lang->line('error_days_must_be_selected');
						$any_error = true;
						break;
					}
					
					// 1.2 get module & tryout price if selected
					// get modul price & tryout
			        $pricings = $this->Course_m->get_course_pricing(array('cp.course_id' => $course_info->row()->id));
					
					$module_price = 0;
					if($this->input->post('module-'.$selected_course)=="on" and $pricings<>false)
						$module_price = $pricings->row()->module_price == "" ? 0 : $pricings->row()->module_price;
					
					$tryout_price = 0;
					if($this->input->post('tryout-'.$selected_course)=="on" and $pricings<>false)
						$tryout_price = $pricings->row()->tryout_price == "" ? 0 : $pricings->row()->tryout_price;

					// checking session and class being required
					if($this->input->post('session-'.$selected_course)==""){
						$response['status'] = '301';
						$response['message'] = $this->lang->line('course').' '.$course_info->row()->course_name.' '.$this->lang->line('error_session_must_be_selected');
						$any_error = true;
						break;
					}
					if($this->input->post('class-'.$selected_course)==""){
						$response['status'] = '301';
						$response['message'] = $this->lang->line('course').' '.$course_info->row()->course_name.' '.$this->lang->line('error_class_must_be_selected');
						$any_error = true;
						break;
					}
					// 2. store into cart array
					$cart_on_course = array( $selected_course => array(
						'course_id' => $selected_course,
						'city' => $this->input->post('city'),
						'days' => $day_string,
						'session_hour' => $this->input->post('session-'.$selected_course),
						'class_in_month' => $this->input->post('class-'.$selected_course),
						'module' => $module_price,
						'tryout' => $tryout_price)
						);
					$cart_on_teacher[$this->input->post('teacher')] += $cart_on_course;
				}
				
				// 3. store into cart session only when no error
				if(!$any_error){
					$carts += $cart_on_teacher;
					$this->order_lib->set_cart_session($carts);

					$response = array(
			        	'status' => '200',
			        	'count_cart' => sizeof($this->session->userdata('cart'))
			        );
				}
		    }
		}
		

        echo json_encode($response);
	}

	function save(){
		$student_id = $this->session->userdata('userid');
		$any_error = false;
		if($this->order_lib->count_cart_item()==0)
		{
			$any_error = true;
			$response = array(
				'status' => '204',
				'message' => $this->lang->line('no_order_in_cart')
				);
		}
		if($this->input->post('address', true)=="" or $this->input->post('date-start', true)=="")
		{
			$any_error = true;
			$response = array(
				'status' => '204',
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
				'address_course_held' => $this->input->post('address', true),
				'start_date' => $this->input->post('date-start', true)
				);
			$result_insert_order = false;

			// 1.2 generate ID and check if duplicate
			$this->load->helper('myfunction_helper');
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

			$order_id = $new_id;
			// 2. insert order courses
			// 2.1 fetch the array
			$cart_array = $this->order_lib->get_cart_session();
			$total_price = 0;
			$teacher_array = array();
			foreach($cart_array as $teacher_id => $course_data){
	            $teacher_info = $this->User_m->get_user_info($teacher_id);
	            if(!in_array($teacher_id, $teacher_array))
	            	array_push($teacher_array, $teacher_id);
	            foreach($course_data as $arr){
		            // get info of the course
		            // $info = $this->Teacher_m->get_course_data_by_courseid($arr['course_id']);
		            // get salary per hour
		            $salary = $this->User_m->get_salary_per_hour($teacher_id);

		            // calculate sub price
		            $sub_price = $salary * $arr['session_hour'] * $arr['class_in_month'] / 1.5; // unit jam ngajar yang berlaku = 1,5 jam

		            $sub_price += $arr['module'] + $arr['tryout'];

		            $data = array(
						'order_id' => $order_id,
						'course_id' => $arr['course_id'],
						'teacher_id' => $teacher_id,
						'city_id' => $arr['city'],
						'days' => $arr['days'],
						'session_hour' => $arr['session_hour'],
						'class_in_month' => $arr['class_in_month'],
						'module_price' => $arr['module'],
						'tryout_price' => $arr['tryout'],
						'teacher_salary_per_hour' => $salary,
						'total_price' => $sub_price
						);

		            $add = $this->Order_m->insert_new_order_course($data);

		            $total_price += $sub_price;
	          	} // end foreach 
	        } // end foreach
			
			// 3. update order aggregate
			$upd_data = array(
				'count_course' => sizeof($this->order_lib->get_courses_session()),
				'count_teacher' => sizeof($cart_array),
				'total_price' => $total_price,
				'grand_total' => $total_price
				);
			$upd = $this->Common->update_data_on_table('orders', 'order_id', $order_id, $upd_data);

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
			    $response = array(
					'status' => '204',
					'message' => $this->any_error
					);
			}
			else
			{
		        $this->db->trans_commit();
		        $response = array(
					'status' => '200',
					'order_id' => $order_id
					);

				// 4. clear session
				$this->unset_order_session();

				// 5. send email & notification
				$this->load->library('My_PHPMailer');
				
				$this->load->library('notification');
				// 5.1 to student
		        $notif_to_student = array(
		        	'category' => 'reply_course_request',
		        	'title' => $this->lang->line('reply_course_request'),
		        	'content' => $this->lang->line('hi').' '.$this->session->userdata('fn').$this->lang->line('we_will_contact_tutor_to_make_communication_tih_student'),
		        	'receiver_id' => $this->session->userdata('userid'),
		        	'sender_id' => 'admin'
		        	);
		        $this->notification->insert($notif_to_student);

	          	// get email template from database
		        $get_template = $this->Content_m->get_email_templates(array('id' => 'course-request-for-student-'.$this->session->userdata('language')));
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
		        $destino = $this->session->userdata('email'); // Who is addressed the email to
		        $mail->AddAddress($destino, $this->session->userdata('fn').' '.$this->session->userdata('ln'));

		        if(!$mail->Send()) {
		        	$this->logging->insert_event_logging('send_email_course_request_student', '', 'false', $mail->ErrorInfo);
		        } else {
		            $this->logging->insert_event_logging('send_email_course_request_student', '', 'true', 'Message sent');
		        }

		        // 5.2 to admin
		        $notif_to_admin = array(
		        	'category' => 'new_course_request',
		        	'title' => $this->lang->line('course_request_new'),
		        	'content' => $this->lang->line('course_request_from').$this->session->userdata('fn'),
		        	'sender_id' => $this->session->userdata('userid'), // student ID
		        	'receiver_id' => 'admin' // teacher ID
		        	);
		        $this->notification->insert($notif_to_admin);

		        // send push notification to mobile application
		        $this->load->library('Push_Notification_Lib');
		        $push_result = $this->push_notification_lib->send('admin', $notif_to_admin['title'], $this->lang->line('course_request_from').$this->session->userdata('fn'));

		        // 5.3 to teachers
		        foreach($teacher_array as $tutor){
		        	$notif_to_teacher = array(
			        	'category' => 'new_course_request',
			        	'title' => $this->lang->line('course_request_new'),
			        	'content' => $this->lang->line('course_request_from').$this->session->userdata('fn'),
			        	'sender_id' => $this->session->userdata('userid'), // student ID
			        	'receiver_id' => $tutor
			        	);
			        $this->notification->insert($notif_to_teacher);

			        // send push notification to mobile application
		        	$push_result = $this->push_notification_lib->send($tutor, $notif_to_teacher['title'], $this->lang->line('course_request_from').$this->session->userdata('fn'));

			        // get email template from database
			        $get_template = $this->Content_m->get_email_templates(array('id' => 'course-request-for-tutor-'.$this->session->userdata('language')));
			        $template = htmlspecialchars_decode($get_template->row()->content);
			        
			        // prepare data to replace 
			        $content = $template;
			        $content = str_replace('[STUDENT_FIRST_NAME]', $this->session->userdata('fn'), $content);
			        $content = str_replace('[STUDENT_LAST_NAME]', $this->session->userdata('ln'), $content);
			        $content = str_replace('[STUDENT_FULL_NAME]', $this->session->userdata('fn').' '.$this->session->userdata('ln'), $content);
			        $get_address_office = $this->Content_m->get_option_by_param('company_address');
			        $content = str_replace('[ADDRESS_OFFICE]', $get_address_office->parameter_value, $content);

					// get teacher's email
					$get_teacher_info = $this->User_m->get_user_data(array('user_id' => $tutor));
					$teacher_info = $get_teacher_info->row();

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
		}
		
		
		echo json_encode($response);
	}

	function admin_reject_order_course(){
		$order_id = $this->input->post('order-id', true);
		$status = $this->Order_m->set_order_status($order_id, 'Reject');

		$data = array('reject_notes' => $this->input->post('reason', true));
		$upd = $this->Common->update_data_on_table('orders', 'order_id', $order_id, $data);
		$this->set_session_response_no_redirect('reject', $upd);

		// send email to student
		redirect('order/open_order_request');
	}

	function admin_confirm_order_course(){
		$this->db->trans_start();
		$order_id = $this->input->post('order-id', true);

		$upd = $this->Order_m->set_order_status($order_id, 'Accept');
		$order_info = $this->Order_m->get_order_by_id($order_id);
		
		$accepted = $this->Order_m->get_accepted_order_courses($order_id);
		
		$total_price = 0;

		$this->load->helper('myfunction_helper');

		if($accepted <> false){
			// 1. insert to course enrollment
			foreach($accepted->result() as $course){
				$total_price += $course->total_price;
				// 1.1 prepare data
				$data_ce = array(
					'order_id' => $course->order_id,
					'course_id' => $course->course_id,
					'student_id' => $order_info->student_id,
					'teacher_id' => $course->teacher_id,
					'city_id' => $course->city_id
					);

				$result_insert_ce = false;
				// 1.2. generate ID and check if duplicate
				while($result_insert_ce==false){
					$date = date('ym');
					$prefix = 'CE'.$date;
					$new_id = $prefix.generate_random_string('number', 5);
					$data_ce['enroll_id'] = $new_id;
					$insert = $this->Course_m->insert_course_enrollment($data_ce);
					if($insert)
						$result_insert_ce = true;
					else
						$result_insert_ce = false;
				}
				$enroll_id = $new_id;
			}

		}

		// 2. update grand total in master
		// 2.1 get the admin fee
		// $get_admin_fee = $this->Content_m->get_option_by_param('admin_fee_percentage');
		// $admin_fee = $get_admin_fee->parameter_value;

		$upd_price = array(
			'count_course' => $this->Order_m->count_course_accepted_order_courses($order_id),
			'count_teacher' => $this->Order_m->count_teacher_accepted_order_courses($order_id),
			'total_price' => $total_price,
			'grand_total' => $total_price
			// 'admin_fee' => $admin_fee,
			// 'grand_total' => $total_price + ($total_price * floatval($admin_fee) / 100)
			);
		// $upd = $this->Order_m->update_order_data($order_id, $upd_price);
		$upd = $this->Common->update_data_on_table('orders', 'order_id', $order_id, $upd_price);
		$this->push_if_transaction_error($upd);

		$message = 'Course Enrollment has been created.';

		// 3. create invoice
		$date_now = new DateTime();
		$date_now->add(new DateInterval('PT6H'));
		$due_date = $date_now->format('Y-m-d H:i:s');
		$data_invoice = array(
			'reference_id' => $order_id,
			'reference_table' => 'orders',
			'user_id' => $order_info->student_id,
			'due_date' => $due_date,
			'total' => $upd_price['grand_total'],
			'status' => 'Open',
			'entry_user' => $this->session->userdata('userid')
			);
		$result_insert_invoice = false;

		// 1.2 generate ID and check if duplicate
		$this->load->model('Invoice_m', 'invoice');
		while($result_insert_invoice==false){
			$date = date('ym');
			$prefix = 'INV'.$date;
			$new_id = $prefix.generate_random_string('number', 5);
			
			$data_invoice['invoice_id'] = $new_id;
			$insert = $this->invoice->insert_new_invoice($data_invoice);
			if($insert)
				$result_insert_invoice = true;
			else
				$result_insert_invoice = false;
		}
		
		$invoice_id = $new_id;
		$message .= '<br>Invoice has been create with invoice ID is '.$invoice_id.'. <a href="'.base_url('invoice/view/'.$invoice_id).'">Click here to view the invoice.</a>';

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
			$this->session->set_flashdata('err_msg', $message);

		}

		// 4. send email and notification to student
		// 4.1 get order info after updating data
		$order_info = $this->Order_m->get_order_by_id($order_id);
		// 4.2 send notification to student that course request has been confirmed
        $this->load->library('notification');
        $notif = array(
        	'category' => 'course_confirmed',
        	'title' => $this->lang->line('course_has_been_confirmed'),
        	'content' => $this->lang->line('course_request_with_order_id').$order_info->order_id.'. '.$this->lang->line('please_check_email_for_details'),
        	'sender_id' => 'admin',
        	'receiver_id' => $order_info->student_id // student ID
        	);
        $this->notification->insert($notif);

        // send push notification to mobile application
        $this->load->library('Push_Notification_Lib');
        $push_result = $this->push_notification_lib->send($order_info->student_id, $notif['title'], $this->lang->line('please_check_email_for_details'));

        // 4.3 send email to student
		// 4.3.1 get student info
		$get_student_info = $this->User_m->get_user_data(array('user_id' => $order_info->student_id));
		$student_info = $get_student_info->row();
		
		// 4.3.2 fetch enrollment data into array
		$enrollments = $this->Course_m->get_enrollment_by_order_id($order_id);
		$enroll_array = array();
		$all_course_in_string = '';
		foreach($enrollments->result() as $enroll){
			// get info of the course
			$course_info = $this->Course_m->get_courses(array('c.id' => $enroll->course_id));
			$tutor_info = $this->User_m->get_user_info($enroll->teacher_id);
			$oc = $this->Order_m->get_order_with_course($order_id, $enroll->course_id);

			$all_course_in_string .= $course_info->row()->program_name.' - '.$course_info->row()->course_name.'; ';

			// $enroll_array[] = array(
			// 	'enroll_id' => $enroll->enroll_id,
			// 	'course' => $course_name['root'].' - '.$course_name['course'],
			// 	'tutor_name' => $tutor_info->first_name.' '.$tutor_info->last_name,
			// 	'email' => $tutor_info->email_login,
			// 	'phone' => $tutor_info->phone_1,
			// 	'day' => $this->course_lib->get_days_string($oc->days),
			// 	'session' => $oc->session_hour.' '.$this->lang->line('hour'),
			// 	'additional_module' => $this->course_lib->get_additional_module($oc)
			// 	);
		}

		// $content = array(
		// 	'first_name' => $student_info->first_name,
		// 	'last_name' => $student_info->last_name,
		// 	'order_id' => $order_id,
		// 	'enrollments' => $enroll_array,
		// 	'grand_total' => number_format($order_info->grand_total, 0, '.', ','),
		// 	'due_date' => $due_date,
		// 	'invoice_id' => $invoice_id
		// );

		// get email template from database
        $get_template = $this->Content_m->get_email_templates(array('id' => 'course-request-confirmed-'.$this->session->userdata('language')));
        $template = htmlspecialchars_decode($get_template->row()->content);
        
        // prepare data to replace 
        $content = $template;
        $content = str_replace('[STUDENT_FIRST_NAME]', $student_info->first_name, $content);
        $content = str_replace('[STUDENT_LAST_NAME]', $student_info->last_name, $content);
        $content = str_replace('[STUDENT_FULL_NAME]', $student_info->first_name.' '.$student_info->last_name, $content);
        $content = str_replace('[COURSE_NAME]', $all_course_in_string, $content);
        $content = str_replace('[CURRENCY]', 'IDR', $content);
        $content = str_replace('[TOTAL_PRICE]', number_format($order_info->grand_total, 0, '.', ','), $content);
        $content = str_replace('[DUE_DATE]', $due_date, $content);
        $content = str_replace('[INVOICE_ID]', $invoice_id, $content);
        $get_address_office = $this->Content_m->get_option_by_param('company_address');
        $content = str_replace('[ADDRESS_OFFICE]', $get_address_office->parameter_value, $content);

		$this->load->library('My_PHPMailer');
        $mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = $this->config->item('smtp_host');      // setting GMail as our SMTP server
        $mail->Port       = $this->config->item('smtp_port');                   // SMTP port to connect to GMail
        $mail->Username   = $this->config->item('smtp_user');  // user email address
        $mail->Password   = $this->config->item('smtp_pass');            // password in GMail
        $mail->SetFrom('admin@tutordoors.com', 'Admin Tutordoors');  //Who is sending the email
        $mail->Subject    = $this->lang->line('course_request_approved_and_invoice');

        $mail->Body      = $content;
        $mail->AltBody    = "Plain text message";
        $destino = $student_info->email_login
        ; // Who is addressed the email to
        $mail->AddAddress($destino, $student_info->first_name.' '.$student_info->last_name);

        if(!$mail->Send()) {
        	$this->logging->insert_event_logging('send_email_confirmed_course_request', '', 'false', $mail->ErrorInfo);
        } else {
            $this->logging->insert_event_logging('send_email_confirmed_course_request', '', 'true', 'Message sent');
        }
		
		redirect('order/open_order_request');
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

	function teacher_confirm_order_course(){
		// 1. change order status 
		$upd = $this->Order_m->set_order_course_status($this->input->post('order-id', true), $this->input->post('course-id', true), 'Accept');
		if($upd){
			$response = array('status'=>'200', 'message'=>'Accept');
			$this->check_order_courses_status_and_notify_admin($this->input->post('order-id', true));
		}
		else
			$response = array('status'=>'204', 'message'=>$upd->output);

        echo json_encode($response);
	}

	function reject_course_order(){
		$upd = $this->Order_m->set_order_course_status($this->input->post('order-id', true), $this->input->post('course-id', true), 'Reject', $this->input->post('reason', true));
		if($upd){
			$response = array('status'=>'200', 'message'=>'Reject');
			$this->check_order_courses_status_and_notify_admin($this->input->post('order-id', true));
		}
		else
			$response = array('status'=>'204', 'message'=>$upd->output);

        echo json_encode($response);
	}

	private function create_course_monitoring($order_id, $enroll_id){
		$order_schedule = $this->Order_m->get_order_schedule_request($order_id);
		foreach($order_schedule->result() as $sche){
			$data = array(
				'enroll_id' => $enroll_id,
				'time_start' => $sche->open_date_start,
				'time_end' => $sche->open_date_end
				);
			$add_mon = $this->Common->add_to_table('course_monitoring', $data);
		}
	}

	function create_invoice($enroll_id, $nominal){
		$date_now = new DateTime();
		$date_now->add(new DateInterval('PT3H'));
		
		$data_inv = array(
			'enroll_id' => $enroll_id,
			'grand_total' => $nominal,
			'due_date' => $date_now->format('Y-m-d H:i:s'),
			'status' => 'Open'
			);

		$result_insert = false;
		// 1.2. generate ID and check if duplicate
		while($result_insert==false){
			$date = date('ym');
			$prefix = 'INV'.$date;
			$this->load->helper('myfunction_helper');
			$new_id = $prefix.generate_random_string('number', 5);
			
			$data_inv['invoice_id'] = $new_id;
			$insert = $this->Common->add_to_table('invoices', $data_inv);
			if($insert)
				$result_insert = true;
			else
				$result_insert = false;
		}

		return $new_id;
	}

	public function dest(){
		$this->session->sess_destroy();
	}

	public function submit_payment_conf(){
		$this->load->model('Invoice_m', 'invoice');

		// 1. check if order id is correct
		$check_invoice = $this->invoice->get_invoice_by_id(strtoupper($this->input->post('invoice-id', TRUE)));
		if($check_invoice==false)
			array_push($this->any_error, $this->lang->line('invoice_id_not_found_with_hint'));
		// 2. check if not duplicate in table payment_confirmation, customer should not confirm twice
		$check_duplicate = $this->Order_m->check_payment_conf_duplicate($this->input->post('invoice-id', TRUE));
		if($check_duplicate)
			array_push($this->any_error, $this->lang->line('invoice_id_has_been_confirmed_once').$this->input->post('invoice-id', TRUE));

		if(empty($this->any_error)){
			$data = array(
				'referrence_id' => strtoupper($this->input->post('invoice-id', TRUE)),
				'sender_name' => $this->input->post('name', TRUE),
				'bank_dest_id' => $this->input->post('bank-dest', TRUE),
				'transfer_date' => $this->input->post('transfer-date', TRUE),
				'total_paid' => $this->input->post('total', TRUE),
				'note' => $this->input->post('note', TRUE),
				'status' => 'Open'
				);
			$add_payment_conf = $this->Common->add_to_table('payment_transfer', $data);
			$this->push_if_transaction_error($add_payment_conf);

			// give notification to admin
	        $this->load->library('notification');
	        $notif = array(
	        	'category' => 'new_payment_conf',
	        	'title' => 'New Payment Confirmation',
	        	'content' => 'New payment confirmation for invoice ID '.strtoupper($this->input->post('invoice-id', TRUE)),
	        	'sender_id' => ($this->session->userdata('logged')=="in" ? $this->session->userdata('userid') : ''),
	        	'receiver_id' => 'admin'
	        	);
	        $add_notif = $this->notification->insert($notif);
	        $this->push_if_transaction_error($add_notif);

	        // send push notification to mobile application
            $this->load->library('Push_Notification_Lib');
            $push_result = $this->push_notification_lib->send('admin', $notif['title'], $notif['content']);
		}

        if(empty($this->any_error))
        	$this->session->set_flashdata('payment_done', $this->lang->line('thanks_for_confirm_payment'));
        else
        	$this->session->set_flashdata('payment_done', $this->any_error);

		redirect('frontpage/payment_confirmation');
	}

	public function lookup_order($order_id){
		// get order header
		$order = $this->Order_m->get_order_by_id($order_id);
		if($order==false)
			$response['status'] = '204';
		else{
			$response = array(
				'status' => '200',
				'id' => $order->order_id
				);
		}
		
		echo json_encode($response);
	}

	function mail_smtp(){
		$this->load->library('My_PHPMailer');
        $mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = $this->config->item('smtp_host');      // setting GMail as our SMTP server
        $mail->Port       = $this->config->item('smtp_port');                   // SMTP port to connect to GMail
        $mail->Username   = $this->config->item('smtp_user');  // user email address
        $mail->Password   = $this->config->item('smtp_pass');            // password in GMail
        $mail->SetFrom('admin@tutordoors.com', 'Admin Tutordoors');  //Who is sending the email
        $mail->Subject    = 'Tes dari NB-OCY';
        $mail->Body      = 'Hai OCY';
        $mail->AltBody    = "Plain text message";
        $destino = 'ocky.harliansyah@ifs.co.id'; // Who is addressed the email to
        $mail->AddAddress($destino, 'OCY');

        if(!$mail->Send()) {
        	print_r($mail->ErrorInfo);
        } else {
            echo 'done';
        }
	}

	function get_course_data($teacher_id, $course_id){
		$get_course = $this->Teacher_m->get_opened_course_data(array('toc.course_id' => $course_id, 'toc.user_id' => $teacher_id));
		$course = $get_course->row();

		$day_array = explode(',', $course->days);
		foreach($day_array as $day)
			$response['days'][] = array(
				'id' => $day,
				'name' => $this->lang->line('day_'.$day)
				);
		$response['sessions'] = explode(',', $course->session_hours);
		$response['course_name'] = $course->course_name;
		// get modul price & tryout
        $pricings = $this->Course_m->get_course_pricing(array('cp.course_id' => $course->course_id));
        if($pricings <> false){
	        $response['module_price'] = number_format($pricings->row()->module_price, 0, '.', ',');
	        $response['tryout_price'] = number_format($pricings->row()->tryout_price, 0, '.', ',');
	    }
	    else{
	    	$response['module_price'] = 0;
	        $response['tryout_price'] = 0;
	    }

        // get salary per hour
        $response['salary'] = number_format($this->User_m->get_salary_per_hour($teacher_id), 0, '.', ',');

		echo json_encode($response);
	}

	function calculate_summary_preorder($teacher_id, $course_id, $session=0, $class=0, $module=0, $tryout=0){
		// get info of the course
		$info = $this->Course_m->get_courses(array('c.id' => $course_id));

        // get salary per hour
        $salary = $this->User_m->get_salary_per_hour($teacher_id);

        // calculate sub price
        $sub_price = $salary * $session * $class;

        // get modul price & tryout
        $pricings = $this->Course_m->get_course_pricing(array('cp.course_id' => $course->course_id));
        $module_price = $module == 0 ? 0 : $pricings->row()->module_price;
        $tryout_price = $tryout == 0 ? 0 : $pricings->row()->tryout_price;

        $sub_price += $module_price + $tryout_price;

        // set subprice session on each course
        $course_array = $this->order_lib->get_courses_session();
        $course_array[$course_id]['sub_price'] = $sub_price;
        $this->order_lib->set_courses_session($course_array);

        // calculate total price
        // $total_price = $this->calculate_total_price();
        
        $response = array(
        	'root' => $info->program_name,
        	'course' => $info->course_name,
        	'session' => $session == 0 ? '0' : $session.' '.$this->lang->line('hour'),
        	'class' => $class == 0 ? '0' : $class.' '.$this->lang->line('times'),
        	'module' => number_format($module_price, 0, ',', '.'),
        	'tryout' => number_format($tryout_price, 0, ',', '.'),
        	'sub_price' => number_format($sub_price, 0, ',', '.')
        	// 'total_price' => number_format($total_price, 0, ',', '.')
        	);

        echo json_encode($response);
	}

	function calculate_total_price(){
		// fetch the session courses to calculate based on SUB PRICE
		$total_price = 0;
		$carts = $this->order_lib->get_cart_session();
		foreach($carts as $tutor => $course)
			$total_price += $course['sub_price'];

		return $total_price;
	}

	function preorder_course_session($trans, $course_id){
		/* if checked, then add
			else then remove
		*/
		$course_array = $this->order_lib->get_courses_session();
		if($trans=="add"){
			if(!in_array($course_id, $course_array)){
				$new_data = array($course_id => array('sub_price' => 0));
				$course_array += $new_data;
				// set courses session
				$this->order_lib->set_courses_session($course_array);
			}
		}
		else if($trans=="remove"){
			unset($course_array[$course_id]);
			$this->order_lib->set_courses_session($course_array);
		}
		
		$response = array('status'=>'done');

		echo json_encode($response);
		// print_r($this->order_lib->get_courses_session());
	}

	function unset_order_session(){
		$this->session->set_userdata('cart', array());
		$this->session->set_userdata('courses', array());
	}

	function get_order_session(){
		print_r($this->session->userdata('courses'));
	}

	function check_tutor_confirm_order($order_id){
		$check = $this->Order_m->get_accepted_order_courses($order_id);
		if($check<>false)
			$response['status'] = '200';
		else $response['status'] = '204';

		echo json_encode($response);
	}



	/* Function End */
}
