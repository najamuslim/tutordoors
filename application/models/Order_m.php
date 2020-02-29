<?php

class Order_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function insert_new_order($data){
		$insert = $this->db->insert('orders', $data);
		if($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function delete_order_id($id){
		$this->db->delete('orders', array('order_id' => $id));
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function get_order_by_id($order_id){
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('order_id', $order_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_order_courses($order_id){
		$this->db->select('*');
		$this->db->from('order_courses');
		$this->db->where('order_id', $order_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_order_courses_distinct_tutor($order_id){
		$this->db->select('teacher_id');
		$this->db->distinct();
		$this->db->from('order_courses');
		$this->db->where('order_id', $order_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_accepted_order_courses($order_id){
		$this->db->select('*');
		$this->db->from('order_courses');
		$this->db->where('order_id', $order_id);
		$this->db->where('order_status', 'Accept');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_order_with_course($order_id, $course_id){
		$this->db->select('*');
		$this->db->from('orders o');
		$this->db->join('order_courses oc', 'o.order_id = oc.order_id');
		$this->db->where('o.order_id', $order_id);
		$this->db->where('oc.course_id', $course_id);

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_open_order_by_teacherid($teacher_id, $with_open_order_course=false){
		if($with_open_order_course)
			$this->db->select('o.*, oc.*, u.*, ui.phone_1, c.city_name');
		else
			$this->db->select('distinct o.*, u.*, ui.phone_1, c.city_name', false);
		$this->db->from('orders o');
		$this->db->join('order_courses oc', 'o.order_id = oc.order_id');
		$this->db->join('users u', 'o.student_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id', 'left');
		$this->db->join('cities c', 'oc.city_id = c.city_id');
		$this->db->where('o.order_status', 'Open');
		if($with_open_order_course)
			$this->db->where('oc.order_status', 'Open');
		$this->db->where('oc.teacher_id', $teacher_id);
		$this->db->order_by('o.entry_date desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		if($query->num_rows() > 0)
			return $query;
		else
			false;
	}

	function get_accepted_order_by_teacherid($teacher_id, $with_open_order_course=false){
		if($with_open_order_course)
			$this->db->select('o.*, oc.*, u.*, ui.phone_1, c.city_name');
		else
			$this->db->select('distinct o.*, u.*, ui.phone_1, c.city_name', false);
		$this->db->from('orders o');
		$this->db->join('order_courses oc', 'o.order_id = oc.order_id');
		$this->db->join('users u', 'o.student_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id', 'left');
		$this->db->join('cities c', 'oc.city_id = c.city_id');
		$this->db->where('o.order_status', 'Accept');
		if($with_open_order_course)
			$this->db->where('oc.order_status', 'Accept');
		$this->db->where('oc.teacher_id', $teacher_id);
		$this->db->order_by('o.entry_date desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		if($query->num_rows() > 0)
			return $query;
		else
			false;
	}

	function get_order_course_by_id($order_id){
		$this->db->select('group_concat(cs.course_name) as courses');
		$this->db->from('order_courses oc');
		$this->db->join('courses cs', 'oc.course_id = cs.id');
		$this->db->where('order_id', $order_id);

		$query = $this->db->get();

		return $this->db_trans->return_select_first_row($query);
	}

	function get_open_order_without_course_by_studentid($student_id){
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('order_status', 'Open');
		$this->db->where('student_id', $student_id);
		$this->db->order_by('entry_date desc');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_accepted_order_without_course_by_studentid($student_id){
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('order_status', 'Accept');
		$this->db->where('student_id', $student_id);
		$this->db->order_by('entry_date desc');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_open_order_by_studentid($student_id){
		$this->db->select('o.*, oc.*, u.*, ui.phone_1, c.city_name');
		$this->db->from('orders o');
		$this->db->join('order_courses oc', 'o.order_id = oc.order_id');
		$this->db->join('users u', 'oc.teacher_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id', 'left');
		$this->db->join('cities c', 'oc.city_id = c.city_id');
		$this->db->where('o.order_status', 'Open');
		$this->db->where('oc.order_status', 'Open');
		$this->db->where('o.student_id', $student_id);
		$this->db->order_by('o.entry_date desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		if($query->num_rows() > 0)
			return $query;
		else
			false;
	}

	function view_order_by_id($order_id){
		$this->db->select('o.*, ub.first_name as student_fn, ub.last_name as student_ln, u.first_name as teacher_fn, u.last_name as teacher_ln, u.email_login');
		$this->db->from('orders o');
		$this->db->join('users u', 'o.teacher_id = u.user_id');
		$this->db->join('users ub', 'o.student_id = ub.user_id');
		$this->db->where('o.order_id', $order_id);
		$this->db->order_by('entry_date desc');

		$query = $this->db->get();

		// print_r($this->db->last_query());
		
		return $this->db_trans->return_select_first_row($query);
	}

	function check_granted_order_view($order_id, $user_id){
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('order_id', $order_id);
		$this->db->where('user_id', $user_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	function count_order_grouping_date(){
		$query = $this->db->query('select substr(entry_date, 1, 10) as sales_date, count(*) as total from orders
					group by substr(entry_date, 1, 10)
					order by substr(entry_date, 1, 10)
					limit 0,30');
		return $this->db_trans->return_select($query);
	}

	function check_payment_conf_duplicate($reff_id){
		// $this->db->select('*');
		$this->db->from('payment_transfer');
		$this->db->where('referrence_id', $reff_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	function get_order_schedule_request($order_id){
		$this->db->select('*');
		$this->db->from('order_schedule_request os');
		$this->db->join('user_calendars uc', 'os.schedule_id = uc.schedule_id');
		$this->db->where('os.order_id', $order_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function insert_new_order_course($data){
		$insert = $this->db->insert('order_courses', $data);
		if($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function set_order_status($order_id, $status){
		$this->db->where('order_id', $order_id);
		$this->db->update('orders', array('order_status' => $status));
		if($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function set_order_course_status($order_id, $course_id, $status, $reason=''){
		$this->db->where('order_id', $order_id);
		$this->db->where('course_id', $course_id);
		$this->db->update('order_courses', array('order_status' => $status, 'reason_on_reject'=>$reason));
		if($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function admin_view_open_order($status="Open"){
		$this->db->select('o.*, us.email_login student_email, us.first_name student_fn, us.last_name student_ln, uis.phone_1 student_phone', false);
		$this->db->from('orders o');
		$this->db->join('users us', 'o.student_id = us.user_id'); // student
		$this->db->join('user_info_data uis', 'us.user_id = uis.user_id', 'left'); // student
		$this->db->where('o.order_status', $status);
		$this->db->order_by('o.entry_date desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		if($query->num_rows() > 0)
			return $query;
		else
			false;
	}

	function get_order_course_detail($order_id){
		$this->db->select('o.*, oc.*, oc.order_status order_course_status, us.email_login student_email, us.first_name student_fn, us.last_name student_ln, uis.phone_1 student_phone, c.city_name, ut.email_login teacher_email, ut.first_name teacher_fn, ut.last_name teacher_ln, uit.phone_1 teacher_phone', false);
		$this->db->from('orders o');
		$this->db->join('order_courses oc', 'o.order_id = oc.order_id');
		$this->db->join('users us', 'o.student_id = us.user_id'); // student
		$this->db->join('user_info_data uis', 'us.user_id = uis.user_id', 'left'); // student
		$this->db->join('users ut', 'oc.teacher_id = ut.user_id'); // teacher
		$this->db->join('user_info_data uit', 'ut.user_id = uit.user_id', 'left'); // teacher
		$this->db->join('cities c', 'oc.city_id = c.city_id');
		$this->db->where('o.order_id', $order_id);
		$this->db->order_by('o.entry_date desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		if($query->num_rows() > 0)
			return $query;
		else
			false;
	}

	function count_course_accepted_order_courses($order_id){
		$this->db->select('count(distinct course_id) as total', false);
		$this->db->from('order_courses');
		$this->db->where('order_id', $order_id);
		$this->db->where('order_status', 'Accept');

		$query = $this->db->get();
		
		return $query->row()->total;
	}

	function count_teacher_accepted_order_courses($order_id){
		$this->db->select('count(distinct teacher_id) as total', false);
		$this->db->from('order_courses');
		$this->db->where('order_id', $order_id);
		$this->db->where('order_status', 'Accept');

		$query = $this->db->get();
		
		return $query->row()->total;
	}

	function sum_accepted_total_price_order_courses($order_id){
		$this->db->select('ifnull(sum(total_price), 0) as total', false);
		$this->db->from('order_courses');
		$this->db->where('order_id', $order_id);
		$this->db->where('order_status', 'Accept');

		$query = $this->db->get();
		
		return $query->row()->total;
	}

	function update_order_data($order_id, $data){
		$this->db->where('order_id', $order_id);
		$this->db->update('orders', $data);
		if($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function count_open_order_courses($order_id){
		$this->db->select('*')
				->from('order_courses')
				->where('order_id', $order_id)
				->where('order_status', 'Open');
				
		$query = $this->db->get();
		return $query->num_rows();
	}
}