<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('Payroll_m');
	}	

	/* pages start */

	function calculation_periods(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'payroll-calculation-period',
			'title_page' => 'Payroll Calculation Period',
			'periods' => $this->Payroll_m->get_calc_periods()
			);

		$this->open_admin_page('admin/payroll/calculation_periods', $data);
	}

	function calc_period(){
		$this->check_user_access();

		$id = $this->input->get('id', true);
		if($id == "")
			$data = array(
				'active_menu_id' => 'payroll-calculation-period',
				'title_page' => 'Add New Calculation Period',
				'mode' => 'add'
				);
		else
			$data = array(
				'active_menu_id' => 'payroll-calculation-period',
				'title_page' => 'Edit Calculation Period',
				'mode' => 'edit',
				'period' => $this->Payroll_m->get_calc_period_data(array('period_id' => $id))
				);

		$this->open_admin_page('admin/payroll/calculation_period_form', $data);
	}

	function calculation_start(){
		$this->check_user_access();

		// get active calculation period
		$active_period = $this->Payroll_m->get_active_period();
		$start_date = $active_period->start_date;
		$end_date = $active_period->end_date;
		$start_date_str = date_format(new DateTime($active_period->start_date), "d F Y");
		$end_date_str = date_format(new DateTime($active_period->end_date), "d F Y");

		// // get months
		// $now = new DateTime();
		// $month_now = $now->format('m');
		// $month_now_str = get_month_string($month_now);
		// $year_now = $now->format('Y');
		// $interval = new DateInterval('P1M');//previous month
		// $previous = $now->sub($interval);
		// $month_prev = $previous->format('m');
		// $month_prev_str = get_month_string($month_prev);

		// // get parameters
		// $get_start_date = $this->Content_m->get_option_by_param('salary_calculation_day_start');
		// $start_date = $get_start_date->parameter_value;
		// $get_end_date = $this->Content_m->get_option_by_param('salary_calculation_day_end');
		// $end_date = $get_end_date->parameter_value;

		$data = array(
			'active_menu_id' => 'payroll-calculation',
			'title_page' => 'Absence Calculation',
			'title' => 'Calculation period '.$start_date_str.' - '.$end_date_str
			);
		
		$data['data_monitoring'] = $this->Payroll_m->get_not_final_course_monitoring($end_date);
		$data['date_param'] = $start_date;
		// $this->export_query($this->db->last_query());

		$this->open_admin_page('admin/payroll/calculation_view', $data);
	}

	function monitoring_validation(){
		$this->check_user_access();
		$this->load->helper('myfunction_helper');

		// get active calculation period
		$active_period = $this->Payroll_m->get_active_period();
		$start_date = $active_period->start_date;
		$end_date = $active_period->end_date;
		$start_date_str = date_format(new DateTime($active_period->start_date), "d F Y");
		$end_date_str = date_format(new DateTime($active_period->end_date), "d F Y");

		// // get months
		// $now = new DateTime();
		// $month_now = $now->format('m');
		// $month_now_str = get_month_string($month_now);
		// $year_now = $now->format('Y');
		// $interval = new DateInterval('P1M');//previous month
		// $previous = $now->sub($interval);
		// $month_prev = $previous->format('m');
		// $month_prev_str = get_month_string($month_prev);

		// // get parameters
		// $get_start_date = $this->Content_m->get_option_by_param('salary_calculation_day_start');
		// $start_date = $get_start_date->parameter_value;
		// $get_end_date = $this->Content_m->get_option_by_param('salary_calculation_day_end');
		// $end_date = $get_end_date->parameter_value;

		$data = array(
			'active_menu_id' => 'payroll-calculation',
			'title_page' => 'Absence Calculation',
			'title' => 'Calculation period '.$start_date_str.' - '.$end_date_str
			);

		$data['detail'] = $this->Course_m->get_course_enrollment($this->input->get('id', TRUE));
		$data['absence'] = $this->Payroll_m->get_not_final_course_monitoring($start_date, $this->input->get('id', TRUE));
		// print_r($this->db->last_query());

		$this->open_admin_page('admin/payroll/monitoring_validation', $data);
	}

	function validate_absence(){
		foreach($this->input->post('check') as $key => $id)
			// echo 'id '.$id.' jam '.$_POST['hours'][$key];
			$upd = $this->Common->add_to_table('payroll_absence_validations', array('monitoring_id'=>$id, 'hours'=>$_POST['hours'][$key]));
		
		redirect('payroll/calculation_start');
	}

	function finalization_start(){
		$this->check_user_access();
		$this->load->helper('myfunction_helper');

		// get active calculation period
		$active_period = $this->Payroll_m->get_active_period();
		$start_date = $active_period->start_date;
		$end_date = $active_period->end_date;
		$start_date_str = date_format(new DateTime($active_period->start_date), "d F Y");
		$end_date_str = date_format(new DateTime($active_period->end_date), "d F Y");

		// // get months
		// $now = new DateTime();
		// $month_now = $now->format('m');
		// $month_now_str = get_month_string($month_now);
		// $year_now = $now->format('Y');
		// $interval = new DateInterval('P1M');//previous month
		// $previous = $now->sub($interval);
		// $month_prev = $previous->format('m');
		// $month_prev_str = get_month_string($month_prev);

		// // get parameters
		// $get_start_date = $this->Content_m->get_option_by_param('salary_calculation_day_start');
		// $start_date = $get_start_date->parameter_value;
		// $get_end_date = $this->Content_m->get_option_by_param('salary_calculation_day_end');
		// $end_date = $get_end_date->parameter_value;
		$data = array(
			'active_menu_id' => 'payroll-finalization',
			'title_page' => 'Finalisasi Gaji Guru',
			'title' => 'Finalisasi Gaji Guru Periode '.$start_date_str.' - '.$end_date_str,
			'period' => $active_period->period_id,
			'period_desc' => $active_period->description,
			'filter_param' => $start_date_str
			);
		
		$data['data_final'] = $this->Payroll_m->get_monitoring_validation_not_final($start_date_str);
		// $this->export_query($this->db->last_query());

		$this->open_admin_page('admin/payroll/finalization', $data);
	}

	function history(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'payroll-payment-checklist',
			'title_page' => 'Histori Penggajian Guru',
			'title' => 'Histori Penggajian Guru'
			);
		
		$data['data_payroll'] = $this->Payroll_m->get_histories();
		// $this->export_query($this->db->last_query());

		$this->open_admin_page('admin/payroll/history_all', $data);
	}

	function checklist(){
		$this->check_user_access();
		$period = $this->input->get('p', true);
		
		$data = array(
			'active_menu_id' => 'payroll-payment-checklist',
			'title_page' => 'Checklist Penggajian Guru'
			);
		
		$data['data_payroll'] = $this->Payroll_m->get_final_payroll_by_period_and_bank_account($period);
		// $this->export_query($this->db->last_query());

		$this->open_admin_page('admin/payroll/checklist', $data);
	}

	function setup_umk(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'setup-umk',
			'title_page' => 'Setup Upah Minimum Kota'
			);
		
		$data['provinces'] = $this->Location_m->get_province();
		$data['umk'] = $this->Payroll_m->get_city_umk_data();

		$this->open_admin_page('admin/payroll/setup_umk', $data);
	}

	function setup(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'setup-payroll',
			'title_page' => 'Setup Variable Data for Payroll'
			);

		$get_options = $this->Content_m->get_all_options();
		foreach($get_options->result() as $param){
			$options[$param->parameter_name]['desc'] = $param->description;
			$options[$param->parameter_name]['value'] = $param->parameter_value;
		}
		$data['options'] = $options;
		$data['controller'] = 'payroll';

		$this->open_admin_page('admin/base_setup/one_group', $data);
	}

	function setup_range_fee(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'setup-range-fee',
			'title_page' => 'Setup Range Tutor Fee'
			);

		$this->load->model('Otest_m', 'otest');

		$this->open_admin_page('admin/payroll/setup_range_fee', $data);
	}

	function setup_cdc(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'setup-cdc-fee',
			'title_page' => 'Setup City-Degree-Course Based Fee'
			);
		
		$data['provinces'] = $this->Location_m->get_province();
		$data['programs'] = $this->Course_m->get_programs();
		$data['cdc'] = $this->Payroll_m->get_cdc_data();

		$this->open_admin_page('admin/payroll/setup_cdc', $data);
	}

	/* pages end */

	/* functions start */

	function save_config(){
		foreach($this->input->post() as $key => $input){
			$upd = $this->Common->update_data_on_table('options', 'parameter_name', $key, array('parameter_value' => $input));
			$this->push_if_transaction_error($upd);
		}

		$this->set_session_response_no_redirect_by_error('update');
		redirect('payroll/setup');
	}

	function commit($date, $period){
		$fix_data_per_teacher = $this->Payroll_m->get_monitoring_validation_not_final($date);

		$total_hours = 0;

		// 1. get latest payroll id
		$latest_id = $this->Payroll_m->get_latest_payroll_id($period);
		if($latest_id==false){
			$new_iteration = 1;
			$new_id = $period.str_pad($new_iteration, 4, '0', STR_PAD_LEFT);
		}
		else{
			$latest_iteration = intval(substr($latest_id, -4));
			$new_iteration = $latest_iteration + 1;
			$new_id = $period.str_pad($new_iteration, 4, '0', STR_PAD_LEFT);
		}
		// 2. set payroll id
		$new_payroll_id = $new_id;

		$this->db->trans_start();
		// 3. save payroll id into table payroll_finalizations
		foreach($fix_data_per_teacher->result() as $teacher){
			$world_scale = $this->Course_m->get_category_world_scale_by_enroll_id($teacher->enroll_id);
			if($world_scale=="national")
				$percentage_fee_info = $this->Content_m->get_option_by_param('percentage_payroll_national_course_fee');
			else if($world_scale=="international")
				$percentage_fee_info = $this->Content_m->get_option_by_param('percentage_payroll_international_course_fee');

			$percentage_fee = $percentage_fee_info->parameter_value;

			$data_header = array(
				'payroll_id' => $new_payroll_id,
				'enroll_id' => $teacher->enroll_id,
				'teacher_id' => $teacher->teacher_id,
				'salary_period' => $period,
				'percentage_fee' => $percentage_fee,
				'user_entry' => $this->session->userdata('userid')
				);

			$insert_header = $this->Common->add_to_table('payroll_finalizations', $data_header);
			if($insert_header->status==false and empty($this->any_error)) // if there is error
				array_push($this->any_error, 'Finalisasi Payroll mengalami kegagalan dalam proses pembuatan header. Silahkan coba kembali, dan apabila masalah terjadi kembali, hubungi web developer.');
			$this->push_if_transaction_error($insert_header);
				
			// 4. fetch validation and save it into table payroll_final_details
			$data_validation = $this->Payroll_m->get_absence_validation_by_enroll_id($teacher->enroll_id);
			// print_r($this->db->last_query());
			$total_hours = 0;
			
			foreach($data_validation->result() as $valid){
				$data_detail = array(
					'payroll_id' => $new_payroll_id,
					'absence_validation_id' => $valid->validation_id
					);
				$insert_detail = $this->Common->add_to_table('payroll_final_details', $data_detail);
				if($insert_detail->status==false and empty($this->any_error)) // if there is error
					array_push($this->any_error, 'Finalisasi Payroll mengalami kegagalan proses dalam pembuatan data detil. Silahkan coba kembali, dan apabila masalah terjadi kembali, hubungi web developer.');
				$this->push_if_transaction_error($insert_detail);

				$total_hours += intval($valid->hours);
			}
			// get fee per hour of the course
            $get_fee_per_hour = $this->Teacher_m->get_fee_per_hour($teacher->teacher_id, $teacher->course_id);
            $fee_per_hour = $get_fee_per_hour <> false ? $get_fee_per_hour->fee_per_hour : 0;

			$total_salary = ($percentage_fee / 100) * $total_hours * $fee_per_hour;

			// 5. update total into table payroll_finalizations
			$update_data_header = array(
				'total_hours' => $total_hours,
				'salary_per_hour' => $fee_per_hour,
				'percentage_fee' => $percentage_fee,
				'total_salary' => $total_salary
				);
			$update_header = $this->Common->update_data_on_table('payroll_finalizations', 'payroll_id', $new_payroll_id, $update_data_header);
			if($update_header->status==false and empty($this->any_error)) // if there is error
				array_push($this->any_error, 'Finalisasi Payroll mengalami kegagalan proses. Silahkan coba kembali, dan apabila masalah terjadi kembali, hubungi web developer.');
			$this->push_if_transaction_error($update_header);

			// 6. iterate payroll id
			$latest_iteration = intval(substr($new_payroll_id, -4));
			$new_iteration = $latest_iteration + 1;
			$new_payroll_id = $period.str_pad($new_iteration, 4, '0', STR_PAD_LEFT);
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
			$this->session->set_flashdata('err_msg', 'Finalisasi Payroll berhasil.');
		}
		
		redirect('payroll/finalization_start');
	}

	function set_payment_status($payroll_id, $value){
		$this->check_user_access();
		$upd = $this->Common->update_data_on_table('payroll_finalizations', 'payroll_id', $payroll_id, array('payment_status'=>$value));

		$response = array('status' => $upd->status, 'message' => ($upd->status<>"200" ? $upd->output : ""));

		echo json_encode($response);
	}

	function update_umk(){
		$this->check_user_access();
		$data = array(
			'class_number' => $this->input->post('class', true),
			'umk_nominal' => $this->input->post('umk', true),
			);
		$upd = $this->Common->update_data_on_table('city_umk', 'city_id', $this->input->post('id', true), $data);
		if($upd)
			$response = array('status'=>'200');
		else
			$response = array('status'=>'301', $upd->output);

		echo json_encode($response);
	}

	function add_umk(){
		$this->check_user_access();
		$data = array(
			'city_id' => $this->input->post('city', true),
			'class_number' => $this->input->post('class', true),
			'umk_nominal' => $this->input->post('nominal', true)
			);
		$add = $this->Common->add_to_table('city_umk', $data);
		$this->set_session_response_no_redirect('add', $add);

		redirect('payroll/setup_umk');
	}

	function delete_umk($id){
		$del = $this->Common->delete_from_table_by_id('city_umk', 'city_id', $id);
		$this->set_session_response_no_redirect('delete', $del);

		redirect('payroll/setup_umk');
	}

	function add_range_fee(){
		$this->check_user_access();
		$data = array(
			'class_number' => $this->input->post('class', true),
			'grade_id' => $this->input->post('grade', true),
			'range_lowest' => $this->input->post('min', true),
			'range_highest' => $this->input->post('max', true)
			);
		$add = $this->Common->add_to_table('range_tutor_fees', $data);
		$this->set_session_response_no_redirect('add', $add);

		redirect('payroll/setup_range_fee');
	}

	function update_range_fee()
	{
		$data = array(
			'class_number' => $this->input->post('class', true),
			'grade_id' => $this->input->post('grade', true),
			'range_lowest' => $this->input->post('min', true),
			'range_highest' => $this->input->post('max', true)
			);
		$upd = $this->Common->update_data_on_table('range_tutor_fees', 'id', $this->input->post('id', true), $data);
		$this->set_session_response_no_redirect('update', $upd);

		redirect('payroll/setup_range_fee');
	}

	function delete_range_fee()
	{
		$del = $this->Common->delete_from_table_by_id('range_tutor_fees', 'id', $this->input->get('id', true));
		$this->set_session_response_no_redirect('delete', $del);

		redirect('payroll/setup_range_fee');
	}

	function get_range_fee_by_id($id)
	{
		$get = $this->Payroll_m->get_range_fee(array('id' => $id));
		$data = $get->row();

		$response = array(
			'class' => $data->class_number,
			'grade' => $data->grade_id,
			'min' => $data->range_lowest,
			'max' => $data->range_highest
			);

		echo json_encode($response);
	}

	function add_cdc_range_fee(){
		$this->check_user_access();
		$data = array(
			'city_id' => $this->input->post('city', true),
			'degree' => $this->input->post('degree', true),
			'course_id' => $this->input->post('course', true),
			'range_lowest' => $this->input->post('min', true),
			'range_highest' => $this->input->post('max', true)
			);
		$add = $this->Common->add_to_table('cdc_range_fee', $data);
		$this->set_session_response_no_redirect('add', $add);

		redirect('payroll/setup_cdc');
	}

	function update_cdc_range_fee()
	{
		$data = array(
			'range_lowest' => $this->input->post('min', true),
			'range_highest' => $this->input->post('max', true)
			);
		$upd = $this->Common->update_data_on_table('cdc_range_fee', 'range_id', $this->input->post('id', true), $data);
		if($upd)
			$response = array('status'=>'200');
		else
			$response = array('status'=>'301', $upd->output);

		echo json_encode($response);
	}

	function delete_cdc_range_fee()
	{
		$del = $this->Common->delete_from_table_by_id('cdc_range_fee', 'range_id', $this->input->get('id', true));
		$this->set_session_response_no_redirect('delete', $del);

		redirect('payroll/setup_cdc');
	}

	function get_cdc_range_fee_by_id($id)
	{
		$get = $this->Payroll_m->get_range_fee(array('id' => $id));
		$data = $get->row();

		$response = array(
			'class' => $data->class_number,
			'grade' => $data->grade_id,
			'min' => $data->range_lowest,
			'max' => $data->range_highest
			);

		echo json_encode($response);
	}

	function insert_calc_period(){
		$this->load->library('form_validation');
		$rules = array(
			array(
				'field' => 'period_id',
				'label' => 'Period ID',
				'rules' => 'required'
				),
			array(
				'field' => 'description',
				'label' => 'Description'
				),
			array(
				'field' => 'start_date',
				'label' => 'Start Date'
				),
			array(
				'field' => 'end_date',
				'label' => 'End Date'
				)
			);
		
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			array_push($this->any_error, strip_tags(validation_errors()));
			redirect('payroll/calc_period');
		}
		else{
			$data = array(
				'period_id' => $this->input->post('period_id', true),
				'description' => $this->input->post('description', true),
				'start_date' => $this->input->post('start_date', true),
				'end_date' => $this->input->post('end_date', true)
				);

			$insert = $this->Common->add_to_table('payroll_calculation_periods', $data);
			$this->set_session_response_no_redirect('add', $insert);

			redirect('payroll/calculation_periods');
		}
	}

	function update_calc_period(){
		$this->load->library('form_validation');
		$rules = array(
			array(
				'field' => 'period_id',
				'label' => 'Period ID',
				'rules' => 'required'
				),
			array(
				'field' => 'description',
				'label' => 'Description'
				),
			array(
				'field' => 'start_date',
				'label' => 'Start Date'
				),
			array(
				'field' => 'end_date',
				'label' => 'End Date'
				)
			);
		
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			array_push($this->any_error, strip_tags(validation_errors()));
			redirect('payroll/calc_period');
		}
		else{
			$data = array(
				'description' => $this->input->post('description', true),
				'start_date' => $this->input->post('start_date', true),
				'end_date' => $this->input->post('end_date', true)
				);

			$update = $this->Common->update_data_on_table('payroll_calculation_periods', 'period_id', $this->input->post('period_id'), $data);
			$this->set_session_response_no_redirect('update', $update);
		}

		redirect('payroll/calculation_periods');
	}

	function calc_period_delete(){
		$period_id = $this->input->get('id', true);

		$del = $this->Common->delete_from_table_by_id('payroll_calculation_periods', 'period_id', $period_id);
		$this->set_session_response_no_redirect('delete', $del);

		redirect('payroll/calculation_periods');
	}

	function activate_period(){
		// first, deactivate all periods
		$this->Payroll_m->deactivate_all_period();

		// then activate this period
		$period_id = $this->input->get('id', true);
		$data = array(
				'is_active_for_calculation' => "1"
				);

		$update = $this->Common->update_data_on_table('payroll_calculation_periods', 'period_id', $period_id, $data);
		$this->set_session_response_no_redirect('update', $update);

		redirect('payroll/calculation_periods');
	}

	/* functions end */
}