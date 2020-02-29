<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends MY_Controller {
	public function __construct() {
        parent::__construct();
	}

	/* Start Admin Pages */

	public function program(){
		$this->check_user_access();

		$data = array(
			'active_menu_id' => 'course-program',
			'title_page' => 'Programs'
			);
		
		$data['programs'] = $this->Course_m->get_programs();
		$this->open_admin_page('admin/course/program', $data);
	}

	public function course_data(){
		$this->check_user_access();

		$data = array(
			'active_menu_id' => 'course-data',
			'title_page' => 'Courses'
			);
		// get programs
		$data['programs'] = $this->Course_m->get_programs();

		$this->open_admin_page('admin/course/course_data', $data);
	}

	public function pricing(){
		$this->check_user_access();

		$data = array(
			'active_menu_id' => 'course-pricing',
			'title_page' => 'Setup Course Pricing'
			);
		// get category data
		// $data['category'] = $this->Course_m->get_course_pricing();
		$data['programs'] = $this->Course_m->get_programs();
		$this->open_admin_page('admin/course/pricing', $data);
	}


	/* End Admin Pages */
	function insert_program(){
		$data = array(
			'program_name' => $this->input->post('program', TRUE),
			'world_scale' => $this->input->post('scale', TRUE),
			'slug' => $this->input->post('slug', TRUE)
			);
		$add_cat = $this->Common->add_to_table('course_programs', $data);

		$this->set_session_response_no_redirect('add', $add_cat);

		redirect('course/program');
	}

	function update_program(){
		$id = $this->input->post('id', TRUE);

		$data = array(
			'program_name' => $this->input->post('program', TRUE),
			'world_scale' => $this->input->post('scale', TRUE),
			'slug' => $this->input->post('slug', TRUE)
			);
		$upd_cat = $this->Common->update_data_on_table('course_programs', 'program_id', $id, $data);

		$this->set_session_response_no_redirect('update', $upd_cat);

		redirect('course/program');
	}

	function get_program_by_id(){
		// get category data
		$get = $this->Course_m->get_programs(array('program_id' => $this->uri->segment(3)));
		$data = $get->row();
		$response = array(
			'program' => $data->program_name,
			'world_scale' => $data->world_scale,
			'slug' => $data->slug
			);
		
		echo json_encode($response);
	}

	function delete_program(){
		$delete = $this->Common->delete_from_table_by_id('course_programs', 'program_id', $this->input->get('id', true));

		$this->set_session_response_no_redirect('delete', $delete);

		redirect('course/program');
	}

	function insert_course(){
		// insert to courses
		$data = array(
			'course_code' => strtoupper($this->input->post('course-code', TRUE)),
			'course_name' => $this->input->post('course-name', TRUE),
			'program_id' => $this->input->post('program', TRUE),
			'slug' => $this->input->post('slug', TRUE)
			);
		$insert = $this->Common->add_to_table('courses', $data);
		$this->set_session_response_no_redirect('add', $insert);

		redirect('course/course_data');
	}

	function update_course(){
		$course_id = $this->input->post('id', TRUE);

		// insert to courses
		$data = array(
			'course_code' => strtoupper($this->input->post('course-code', TRUE)),
			'course_name' => $this->input->post('course-name', TRUE),
			'slug' => $this->input->post('slug', TRUE)
			);
		$upd_course = $this->Common->update_data_on_table('courses', 'id', $course_id, $data);
		$this->set_session_response_no_redirect('update', $upd_course);
		
		redirect('course/course_data');
	}

	function get_course_by_id(){
		$get = $this->Course_m->get_courses(array('id' => $this->uri->segment(3)));
		$data = $get->row();

		$response = array(
			'id' => $data->id,
			'course_code' => $data->course_code,
			'course_name' => $data->course_name,
			'slug' => $data->slug,
			'program_id' => $data->program_id
			);
		
		echo json_encode($response);
	}

	function delete_course(){
		$delete = $this->Common->delete_from_table_by_id('courses', 'id', $this->input->get('id', true));

		$this->set_session_response_no_redirect('delete', $delete);

		redirect('course/course_data');
	}

	function update_pricing($id){
		// check if exist
		$check = $this->Course_m->get_course_pricing(array('cp.id' => $id));
		// if not exist then add
		if($check==false){
			$add_data = array(
				'course_id' => $id,
				'general_price' => $this->input->post('general-price', true),
				'module_price' => $this->input->post('module-price', true),
				'tryout_price' => $this->input->post('tryout-price', true)
				);
			$add = $this->Common->add_to_table('course_pricing', $add_data);
		}
		else{
			$upd_data = array(
				'general_price' => $this->input->post('general-price', true),
				'module_price' => $this->input->post('module-price', true),
				'tryout_price' => $this->input->post('tryout-price', true)
				);
			$upd = $this->Common->update_data_on_table('course_pricing', 'course_id', $id, $upd_data);
		}

		$response = array(
			'general_price' => $this->input->post('general-price', true),
			'module_price' => $this->input->post('module-price', true),
			'tryout_price' => $this->input->post('tryout-price', true)
			);

		echo json_encode($response);
	}

	function add_absence(){
		$data = array(
			'enroll_id' => $this->input->post('enroll', TRUE),
			'teach_date' => $this->input->post('teach-date', TRUE),
			'time_start' => $this->input->post('start-time', TRUE),
			'time_end' => $this->input->post('end-time', TRUE),
			'teacher_entry' => 'true',
			'teacher_entry_timestamp' => date('Y-m-d H:i:s')
			);
		
		$add = $this->Common->add_to_table('course_monitoring', $data);

		redirect('frontpage/fill_course_monitoring/'.$data['enroll_id']);
	}

	function set_absence(){
		$monitoring_id = $this->input->get('mon', TRUE);
		$enroll_id = $this->input->get('enr', TRUE);

		if($this->session->userdata('level') == "student")
			$data = array(
				'student_entry' => 'true',
				'student_entry_timestamp' => date('Y-m-d H:i:s')
				);
		else if($this->session->userdata('level') == "teacher")
			$data = array(
				'teacher_entry' => 'true',
				'teacher_entry_timestamp' => date('Y-m-d H:i:s')
				);

		
		$set = $this->Common->update_data_on_table('course_monitoring', 'monitoring_id', $monitoring_id, $data);

		redirect('frontpage/fill_course_monitoring/'.$enroll_id);
	}

	function submit_payment(){
		$data = array(
			'enroll_id' => $this->input->post('enroll-id', TRUE),
			'termin' => $this->input->post('termin', TRUE),
			'nominal' => $this->input->post('nominal', TRUE),
			'transfer_date' => $this->input->post('transfer-date', TRUE)
			);
		
		$add = $this->Common->add_to_table('teacher_commissions', $data);
		$this->set_session_response_no_redirect('add', $add);

		// sending email confirmation to teacher
		$course = $this->Course_m->get_course_by_enroll_id($this->input->post('enroll-id', TRUE));
		
		// get teacher data
		$get_teacher_info = $this->User_m->get_user_data(array('user_id' => $course->teacher_id));
		$teacher_info = $get_teacher_info->row();
		
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
        $mail->Subject    = $this->lang->line('salary_payment_for_teacher');

        $mail->Body      = $this->load->view('email_tpl/teacher_commission_'.$this->session->userdata('language'), $data, true);
        $mail->AltBody    = "Plain text message";
        $destino = $teacher_info->email_login; // Who is addressed the email to
        $mail->AddAddress($destino, $teacher_info->first_name.' '.$teacher_info->last_name);

        if(!$mail->Send()) {
        	$this->logging->insert_event_logging('send_email_teacher_commission', '', 'false', $mail->ErrorInfo);
        } else {
            $this->logging->insert_event_logging('send_email_teacher_commission', '', 'true', 'Message sent');
        }

		redirect('cms/view_teacher_commission');
	}

	function admin_completed_course(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'course-completed',
			'title_page' => 'Completed Course'
			);

		$data['completed_course'] = $this->Course_m->get_completed_enrollment();
		// $this->export_query($this->db->last_query());

		$this->open_admin_page('admin/course/completed', $data);
	}

	function complete_course($enroll_id){
		$data = array('is_completed' => 'true');
		
		$set = $this->Common->update_data_on_table('course_enrollment', 'enroll_id', $enroll_id, $data);

		redirect('frontpage/completed_course/');
	}

	public function view_running_course(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'course-running',
			'title_page' => 'Running Course'
			);

		$data['running_course'] = $this->Course_m->get_course_enrollment();
		// print_r($this->db->last_query());

		$this->open_admin_page('admin/course/running', $data);
	}

	public function enrollment_detail(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'course-running',
			'title_page' => 'Detil Enrollment Course'
			);

		$data['detail'] = $this->Course_m->get_course_enrollment($this->input->get('id', TRUE));
		$data['absence'] = $this->Course_m->get_course_monitoring_by_enrollid($this->input->get('id', TRUE));
		// print_r($this->db->last_query());

		$this->open_admin_page('admin/course/enrollment_detail', $data);
	}

	function get_category_scale($id){
		$category = $this->Course_m->get_course_category_by_id($id);

		$response = array('scale' => $category->world_scale);

		echo json_encode($response);
	}

	function get_monitoring_time(){
		$mon_id = $this->input->get('mon', true);
		$monitoring_info = $this->Course_m->get_monitoring_data(array('monitoring_id' => $mon_id));

		$response = array(
			'time_start' => date_format(new DateTime($monitoring_info->row()->time_start), 'H:i'),
			'time_end' => date_format(new DateTime($monitoring_info->row()->time_end), 'H:i'),
			'enroll_id' => $monitoring_info->row()->enroll_id
			);
		echo json_encode($response);
	}

	function edit_absence_time(){
		$data = array(
			'time_start' => $this->input->post('start-time', TRUE),
			'time_end' => $this->input->post('end-time', TRUE)
			);
		
		$upd = $this->Common->update_data_on_table('course_monitoring', 'monitoring_id', $this->input->post('id'), $data);

		redirect('frontpage/fill_course_monitoring/'.$this->input->post('enroll'));
	}

	function export($what)
	{
		//load the excel library
		$this->load->library('excel');
		$this->load->helper('excel_helper');
		// styling
		$style_top_header = set_top_header();
		$alignment = set_alignment();

		if($what=="program")
		{
			$data = $this->Content_m->get_category_data('category_part', 'course');
			$header = array(
				'CATEGORY', 'PARENT CATEGORY', 'WORLD SCALE', 'SLUG (FRIENDLY & UNIQUE WORDS)'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('All course programs');

	        $this->excel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($alignment);

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
			foreach($data->result() as $prog)
			{
				// get parent if it's a child
	        	$parent_info = $this->Content_m->get_category_by_id($prog->parent_id);
	        	$parent_name = ($parent_info<>false ? $parent_info->category : ' - ');

				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $prog->category); // A2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $parent_name); // B2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, ucwords($prog->world_scale)); // C2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $prog->slug); // D2

				$row++;
			}

			// set auto width
			foreach(range('A','D') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Course Programs.xls'; //save our workbook as this file name

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

	function download_doc($media_id){
		$this->load->helper('myfunction_helper');
		$this->load->model('Media_m');

		$file_name = $this->Media_m->get_file_name($media_id);
		download_file('./assets/uploads/'.$file_name, $file_name);
	}

	function get_pricings(){
		$this->check_user_access();

		// get category data
		$get_data = $this->Course_m->get_course_pricing(array('cpm.program_id' => $this->input->get('prog_id', true)));
		$response = array();
		foreach($get_data->result() as $data){
			$response[] = array(
				'id' => $data->cid,
				'course_code' => $data->course_code,
				'course_name' => $data->course_name,
				'general_price' => ($data->general_price=="" ? "" : $data->general_price),
				'module_price' => ($data->module_price=="" ? "" : $data->module_price),
				'tryout_price' => ($data->tryout_price=="" ? "" : $data->tryout_price)
				);
		}

		echo json_encode($response);
	}

	function get_course_by_program($prog_id){
		$get = $this->Course_m->get_courses(array('c.program_id' => $prog_id));
		$response = array();
		if($get<>false)
			foreach($get->result() as $data){
				$response[] = array(
					'id' => $data->id,
					'course_code' => $data->course_code,
					'course_name' => $data->course_name,
					'slug' => $data->slug
					);
			}

		echo json_encode($response);
	}
}