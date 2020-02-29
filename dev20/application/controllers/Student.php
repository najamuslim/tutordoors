<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_Controller {
	function course_request(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($user_id);

			// get new open course request
			$data['open_request'] = $this->Order_m->get_open_order_without_course_by_studentid($user_id);
			// $data['open_request'] = $this->Order_m->get_open_order_by_studentid($user_id);

			$data['am'] = 'student_course_request';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_request');
			$data['sub_page_title'] = $this->lang->line('course_request');
			$this->open_page('student_course_request', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function course_schedule(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'teach_schedule';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_schedule');
			$data['sub_page_title'] = $this->lang->line('course_schedule');
			$data['level'] = 'student';

			$data['schedule'] = $this->Course_m->get_incompleted_enrollment(array('student_id' => $user_id));

			$this->open_page('teach_schedule', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function invoice(){
		if($this->session->userdata('logged')=="in" and $this->session->userdata('level')=="student"){
			$user_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($user_id);

			// get new open course request
			$this->load->model('Invoice_m');
			$data['invoices'] = $this->Invoice_m->get_invoices(array('i.user_id' => $user_id));
			// get bank
			$this->load->model('Bank_m');
			$data['bank_accounts'] = $this->Bank_m->get_bank_data('active', 'true');

			$data['am'] = 'invoice';
			$data['gm'] = 'payment';
			$data['page_title'] = $this->lang->line('invoice');
			$data['sub_page_title'] = $this->lang->line('invoice');
			$this->open_page('invoice', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function order_course_detail($order_id){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');

			$data = $this->get_data_for_profile($user_id);

			$data['order'] = $this->Order_m->get_order_by_id($order_id);
			$data['order_course'] = $this->Order_m->get_order_course_detail($order_id);
			$data['order_id'] = $order_id;
			$data['accepted_course'] = $this->Order_m->count_course_accepted_order_courses($order_id);
			$data['accepted_teacher'] = $this->Order_m->count_teacher_accepted_order_courses($order_id);
			$data['accepted_total_price'] = $this->Order_m->sum_accepted_total_price_order_courses($order_id);
			

			$data['am'] = 'student_course_request';
			$data['gm'] = 'course';
			$data['page_title'] = $this->lang->line('course_request');
			$data['sub_page_title'] = $this->lang->line('course_request');
			$this->open_page('student_order_course_detail', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function unverified(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'student-unverified',
			'title_page' => 'Unverified Students'
			);
		
		$data['students'] = $this->Student_m->get_unverified();
		$this->open_admin_page('admin/student/unverified', $data);
	}

	function verified(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'student-verified',
			'title_page' => 'Verified Students'
			);
		
		$data['students'] = $this->Student_m->get_verified(); 
		// print_r($this->db->last_query());
		$this->open_admin_page('admin/student/verified', $data);
	}

	function detail($student_id){
		$this->check_user_access();
		$this->load->model('Media_m', 'media');
		$data = array(
			'active_menu_id' => 'user-student',
			'title_page' => 'Student Detail'
			);
		$data['general'] = $this->User_m->get_user_by_id($student_id);
		$data['info'] = $this->User_m->get_user_info_data($student_id);
		
		$this->open_admin_page('admin/student/detail', $data);
	}

	function verify(){		
		if(sizeof($this->input->post('check')) > 0){
			foreach($this->input->post('check') as $id){
				$update_data = array('verified_user'=>'1');
				$upd = $this->Common->update_data_on_table('users', 'user_id', $id, $update_data);
				$this->set_session_response_no_redirect('update', $upd);
			}
		}
		else{
			array_push($this->any_error, 'Please select the checkbox(es)');
			$this->set_session_response_no_redirect_by_error('add');
		}

		redirect('student/unverified');
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
			$data = $this->Student_m->get_verified();
			$header = array(
				'USER ID', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'PHONE'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Verified student');

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
			foreach($data->result() as $student)
			{
				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $student->user_id, PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $student->email_login); // B3
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $student->first_name); // C3
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $student->last_name); // D3
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, date_format(new DateTime($student->join_date), 'd M Y H:i')); // E3
				// set the phone as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$row, $student->phone_1, PHPExcel_Cell_DataType::TYPE_STRING);
				$row++;
			}

			// set auto width
			foreach(range('A','G') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Verified Student List.xls'; //save our workbook as this file name

		}
		else if($what=="unverified")
		{
			$data = $this->Student_m->get_unverified();
			$header = array(
				'USER ID', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'PHONE'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Unverified student');

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
			foreach($data->result() as $student)
			{
				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $student->user_id, PHPExcel_Cell_DataType::TYPE_STRING); //A2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $student->email_login); // B2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $student->first_name); // C2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $student->last_name); // D2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, date_format(new DateTime($student->join_date), 'd M Y H:i')); // E2
				// set the phone as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$row, $student->phone_1, PHPExcel_Cell_DataType::TYPE_STRING); // F2
				$row++;
			}

			// set auto width
			foreach(range('A','F') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Unverified Student List.xls'; //save our workbook as this file name

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
}