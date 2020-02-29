<?php

class Payroll_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_not_final_course_monitoring($end_time, $enroll_id=null){
		$this->db->select('ce.*, concat(u.first_name," ", u.last_name) as teacher_name, cm.*', false);
		$this->db->from('course_enrollment ce');
		$this->db->join('users u', 'ce.teacher_id = u.user_id');
		$this->db->join('course_monitoring cm', 'ce.enroll_id = cm.enroll_id');
		$this->db->join('payroll_absence_validations pav', 'cm.monitoring_id = pav.monitoring_id', 'left');
		$this->db->join('payroll_final_details pfd', 'pav.validation_id = pfd.absence_validation_id', 'left');
		$this->db->where('pfd.payroll_id is null', null, FALSE);
		$this->db->where('cm.teach_date <', $end_time);
		if($enroll_id<>null)
			$this->db->where('cm.enroll_id', $enroll_id);
		// $this->db->group_by('ce.teacher_id, ce.course_id, concat(u.first_name," ", u.last_name), ce.order_id, ce.enroll_id', FALSE);

		$query = $this->db->get();
		// print_r($this->db->last_query());

		return $this->db_trans->return_select($query);
	}

	function count_counted_monitoring_not_final($enroll_id, $end_time, $both_absence_ok=false){
		$this->db->select('count(*) as counted', false);
		$this->db->from('course_monitoring cm');
		$this->db->join('payroll_absence_validations pav', 'cm.monitoring_id = pav.monitoring_id', 'left');
		$this->db->join('payroll_final_details pfd', 'pav.validation_id = pfd.absence_validation_id', 'left');
		$this->db->where('pfd.payroll_id is null', null, FALSE);
		$this->db->where('cm.enroll_id', $enroll_id);
		$this->db->where('cm.teach_date <', $end_time);
		if($both_absence_ok){
			$this->db->where('cm.teacher_entry', 'true');
			$this->db->where('cm.student_entry', 'true');
		}

		$query = $this->db->get();
		// print_r($this->db->last_query());

		return $query->row()->counted;
	}

	function count_counted_valid_monitoring_not_final($enroll_id, $end_time, $sum_hours=false){
		if(!$sum_hours)
			$this->db->select('count(*) as counted', false);
		else
			$this->db->select('sum(pav.hours) as counted', false);
		$this->db->from('course_monitoring cm');
		$this->db->join('payroll_absence_validations pav', 'cm.monitoring_id = pav.monitoring_id');
		$this->db->join('payroll_final_details pfd', 'pav.validation_id = pfd.absence_validation_id', 'left');
		$this->db->where('pfd.payroll_id is null', null, FALSE);
		$this->db->where('cm.enroll_id', $enroll_id);
		$this->db->where('cm.teach_date <', $end_time);

		$query = $this->db->get();

		return $query->row()->counted;
	}

	function get_validation_status_of_monitoring_id($mon_id){
		$this->db->where('monitoring_id', $mon_id);
		$query = $this->db->get('payroll_absence_validations');

		if($query->num_rows() == 0)
			return false;
		else
			return true;
	}

	function get_monitoring_validation_not_final($end_time){
		$this->db->select('ce.enroll_id, ce.teacher_id, ce.course_id, concat(u.first_name," ", u.last_name) as teacher_name, ui.salary_per_hour, sum(pav.hours) as total_valid_hours', FALSE);
		$this->db->from('course_enrollment ce');
		$this->db->join('users u', 'ce.teacher_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
		$this->db->join('course_monitoring cm', 'ce.enroll_id = cm.enroll_id');
		$this->db->join('payroll_absence_validations pav', 'cm.monitoring_id = pav.monitoring_id');
		$this->db->join('payroll_final_details pfd', 'pav.validation_id = pfd.absence_validation_id', 'left');
		$this->db->where('pfd.payroll_id is null', null, FALSE);
		$this->db->where('cm.teach_date <', $end_time);
		$this->db->group_by('ce.enroll_id, ce.teacher_id, ce.course_id, concat(u.first_name, " ", u.last_name)', FALSE);

		$query = $this->db->get();
		// print_r($this->db->last_query());

		return $this->db_trans->return_select($query);
	}

	function get_latest_payroll_id($period_like){
		$this->db->select('payroll_id');
		$this->db->from('payroll_finalizations');
		$this->db->like('payroll_id', $period_like);

		$query = $this->db->get();
		// print_r($this->db->last_query());

		if($query->num_rows() > 0)
			return $query->row()->payroll_id;
		else
			return false;
	}

	function get_histories(){
		$this->db->select('salary_period, COUNT(teacher_id) AS teachers, SUM(total_hours) AS hours, SUM(total_salary) AS salary, sum(payment_status) as paid_payment', FALSE);
		$this->db->from('payroll_finalizations');
		$this->db->group_by('salary_period');
		$this->db->order_by('salary_period desc');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_final_payroll_by_period_and_bank_account($period){
		$this->db->select('pf.*, concat(u.first_name, " ", u.last_name) as teacher_name, uba.*', false);
		$this->db->from('payroll_finalizations pf');
		$this->db->join('users u', 'pf.teacher_id = u.user_id');
		$this->db->join('user_bank_account uba', 'u.user_id = uba.user_id', 'left');
		$this->db->where('salary_period', $period);
		$this->db->order_by('payroll_id');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_payroll_by_teacher_id($teacher_id, $status=1){
		$this->db->select('*');
		$this->db->from('payroll_finalizations');
		$this->db->where('teacher_id', $teacher_id);
		$this->db->where('payment_status', $status);
		$this->db->order_by('salary_period desc');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_absence_validation_by_enroll_id($enroll_id){
		$this->db->select('pav.*');
		$this->db->from('course_monitoring cm');
		$this->db->join('payroll_absence_validations pav', 'cm.monitoring_id = pav.monitoring_id');
		$this->db->where('cm.enroll_id', $enroll_id);
		$this->db->order_by('pav.validation_id');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function sum_hours_pav_by_enroll_id($enroll_id){
		$this->db->select('sum(pav.hours) as sum_hours', false);
		$this->db->from('course_monitoring cm');
		$this->db->join('payroll_absence_validations pav', 'cm.monitoring_id = pav.monitoring_id');
		$this->db->where('enroll_id', $enroll_id);

		$query = $this->db->get();

		return $query->row()->sum_hours;
	}

	function get_city_umk_data($filter_array=null){
		$this->db->select('c.*, u.class_number, u.umk_nominal, p.province_name');
		$this->db->from('cities c');
		$this->db->join('city_umk u', 'c.city_id = u.city_id');
		$this->db->join('provinces p', 'c.province_id = p.province_id');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('c.province_id, c.city_name');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_range_fee($filter_array=null){
		$this->db->select('*');
		$this->db->from('range_tutor_fees');
		if($filter_array<>null)
			$this->db->where($filter_array);

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_cdc_data($filter_array=null){
		$this->db->select('cdc.*, c.city_name, p.province_name, cs.course_name, cp.program_name course_program');
		$this->db->from('cdc_range_fee cdc');
		$this->db->join('cities c', 'cdc.city_id = c.city_id');
		$this->db->join('provinces p', 'c.province_id = p.province_id');
		$this->db->join('courses cs', 'cdc.course_id = cs.id');
		$this->db->join('course_programs cp', 'cs.program_id = cp.program_id');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('c.city_name, cdc.degree, cs.course_name');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}
}