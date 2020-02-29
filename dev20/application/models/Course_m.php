<?php

class Course_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }

    function get_programs($filter_array=null){
    	$this->db->select('*');
    	$this->db->from('course_programs');
    	if($filter_array<>null)
    		$this->db->where($filter_array);
    	$this->db->order_by('program_name');

    	$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
    }

    function get_courses($filter_array=null){
    	$this->db->select('c.*, cp.program_name, cp.slug program_slug');
    	$this->db->from('courses c');
    	$this->db->join('course_programs cp', 'c.program_id = cp.program_id');
    	if($filter_array<>null)
    		$this->db->where($filter_array);
    	$this->db->order_by('course_name');
    	
    	$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
    }

  //   function get_course_programs(){
  //   	$this->db->select('*');
  //   	$this->db->from('post_categories');
  //   	$this->db->where('parent_id', '0');
  //   	$this->db->where('category_part', 'course');
  //   	$this->db->order_by('category');

  //   	$query = $this->db->get();
		
		// return $this->db_trans->return_select($query);
  //   }
	
	function get_open_city_by_user_city($user_id, $city_id){
		$this->db->select('*');
		$this->db->from('teacher_open_course_cities oc');
		$this->db->join('cities c', 'oc.city_id = c.city_id');
		$this->db->join('provinces p', 'c.province_id = p.province_id');
		$this->db->where('oc.user_id', $user_id);
		$this->db->where('oc.city_id', $city_id);
		$this->db->order_by('p.province_name, c.city_name');
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_course_by_teacher_name($name_like){
		$this->db->select('toc.id as course_id, toc.user_id, toc.tariff_hourly, cs.course_name, cp.program_name, u.first_name, u.last_name, ui.about_me, m.file_name'); // , group_concat(ci.city_name) as city_name' << barangkali dibutuhin untuk concat city name
		$this->db->distinct();
		$this->db->from('teacher_open_courses toc');
		$this->db->join('courses cs', 'toc.course_id = cs.id');
		$this->db->join('course_programs cp', 'cs.program_id = cp.program_id');
		$this->db->join('teacher_open_course_cities occ', 'toc.user_id = occ.user_id');
		// $this->db->join('cities ci', 'occ.city_id = ci.city_id');
		$this->db->join('users u', 'toc.user_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->like('u.first_name', $name_like);
		$this->db->or_like('u.last_name', $name_like);
		// $this->db->group_by(array('toc.id', 'toc.user_id', 'toc.tariff_hourly', 'p.category', 'p.slug', 'pb.category', 'pb.slug', 'u.first_name', 'u.last_name', 'ui.about_me', 'm.file_name'));
		$this->db->order_by('u.first_name');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		return $this->db_trans->return_select($query);
	}

	// function get_course_by_category($category_id){ // by root category
	// 	$this->db->select('toc.id as course_id, toc.user_id, toc.tariff_hourly, p.category as course_category, pb.category as education_level, u.first_name, u.last_name, ui.about_me, m.file_name'); // , group_concat(ci.city_name) as city_name' << barangkali dibutuhin untuk concat city name
	// 	$this->db->distinct();
	// 	$this->db->from('teacher_open_courses toc');
	// 	$this->db->join('post_categories p', 'toc.course_category_id = p.id');
	// 	$this->db->join('post_categories pb', 'p.parent_id = pb.id');
	// 	$this->db->join('teacher_open_course_cities occ', 'toc.user_id = occ.user_id');
	// 	// $this->db->join('cities ci', 'occ.city_id = ci.city_id');
	// 	$this->db->join('users u', 'toc.user_id = u.user_id');
	// 	$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
	// 	$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
	// 	$this->db->where('p.id', $category_id);
	// 	// $this->db->group_by(array('toc.id', 'toc.user_id', 'toc.tariff_hourly', 'p.category', 'p.slug', 'pb.category', 'pb.slug', 'u.first_name', 'u.last_name', 'ui.about_me', 'm.file_name'));
	// 	$this->db->order_by('u.first_name');

	// 	$query = $this->db->get();
	// 	// print_r($this->db->last_query());
		
	// 	return $this->db_trans->return_select($query);
	// }

	function insert_course_enrollment($data){
		$insert = $this->db->insert('course_enrollment', $data);
		if($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function get_my_calendar($user_id){
		$this->db->select('*');
		$this->db->from('user_calendars uc');
		$this->db->join('users u', 'uc.user_id = u.user_id');
		$this->db->where('uc.user_id', $user_id);
		$this->db->order_by('open_date_start');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_event_by_id($event_id){
		$this->db->select('*');
		$this->db->from('user_calendars');
		$this->db->where('schedule_id', $event_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_course_by_enroll_id($enroll_id){
		$this->db->select('ce.*, cs.course_name');
		$this->db->from('course_enrollment ce');
		$this->db->join('courses cs', 'ce.course_id = cs.id');
		$this->db->where('ce.enroll_id', $enroll_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_course_by_invoice_id($invoice_id){
		$this->db->select('i.*, ce.*, cs.course_name');
		$this->db->from('invoices i');
		$this->db->join('course_enrollment ce', 'i.enroll_id = ce.enroll_id');
		$this->db->join('courses cs', 'ce.course_id = cs.id');
		$this->db->where('ce.enroll_id', $enroll_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function count_course_enrollment(){
		$this->db->select('*');
		$this->db->from('course_enrollment');

		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_course_enrollment_by_userid($level, $user_id, $is_completed){
		$this->db->select('ce.*, u.first_name as teacher_fn, u.last_name as teacher_ln, ub.first_name as student_fn, ub.last_name as student_ln, ci.city_name, ui.*');
		$this->db->from('course_enrollment ce');
		$this->db->join('users u', 'ce.teacher_id = u.user_id'); // teacher id
		$this->db->join('users ub', 'ce.student_id = ub.user_id'); // student id
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
		$this->db->join('cities ci', 'ce.city_id = ci.city_id');
		if($level=="student")
			$this->db->where('ce.student_id', $user_id);
		if($level=="teacher" or $level=="tutor")
			$this->db->where('ce.teacher_id', $user_id);
		$this->db->where('is_completed', $is_completed);
		$this->db->order_by('entry_timestamp desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		return $this->db_trans->return_select($query);
	}

	function get_course_monitoring_by_enrollid($enroll_id){
		$this->db->select('cm.*, ce.order_id, ce.teacher_id, ce.student_id');
		$this->db->from('course_monitoring cm');
		$this->db->join('course_enrollment ce', 'cm.enroll_id = ce.enroll_id');
		$this->db->join('orders o', 'ce.order_id = o.order_id');
		$this->db->where('cm.enroll_id', $enroll_id);
		$this->db->order_by('cm.teach_date desc, cm.time_start');
		
		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		return $this->db_trans->return_select($query);
	}

	function get_course_enrollment($enroll_id=null){
		$this->db->select('ce.*, ce.teacher_id, ce.student_id, 
			ut.first_name AS teacher_fn, ut.last_name AS teacher_ln, us.first_name AS student_fn, us.last_name AS student_ln, 
			ci.city_name, 
			(SELECT COUNT(*) FROM course_monitoring cm WHERE cm.enroll_id = ce.enroll_id) AS row_monitoring, 
			(SELECT COUNT(*) FROM course_monitoring cm WHERE cm.enroll_id = ce.enroll_id 
				AND cm.teacher_entry = "true" AND cm.student_entry = "true") AS monitoring_ok', false);
		$this->db->from('course_enrollment ce');
		$this->db->join('users ut', 'ce.teacher_id = ut.user_id'); // lookup guru
		$this->db->join('users us', 'ce.student_id = us.user_id'); // lookup siswa
		$this->db->join('cities ci', 'ce.city_id = ci.city_id');
		if($enroll_id<>null)
			$this->db->where('ce.enroll_id', $enroll_id);

		$this->db->order_by('entry_timestamp desc');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		if($enroll_id<>null)
			return $this->db_trans->return_select_first_row($query);
		else
			return $this->db_trans->return_select($query);
	}

	// function count_course_category(){
	// 	$this->db->select('pc.id, pc.category, count(*) as total');
	// 	$this->db->from('post_categories pc');
	// 	$this->db->join('teacher_open_courses toc', 'pc.id = toc.course_category_id');
	// 	$this->db->join('users u', 'toc.user_id = u.user_id');
	// 	$this->db->where('u.verified_user', '1');
	// 	$this->db->where('toc.verified', '1');
	// 	$this->db->group_by('pc.id, pc.category');
	// 	$this->db->order_by('pc.category');

	// 	$query = $this->db->get();
		
	// 	return $this->db_trans->return_select($query);
	// }

	function get_completed_enrollment($filter_array=null){
		$this->db->select('*');
		$this->db->from('course_enrollment');
		$this->db->where('is_completed', 'true');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('entry_timestamp desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_incompleted_enrollment($filter_array=null){
		$this->db->select('*');
		$this->db->from('course_enrollment');
		$this->db->where('is_completed', 'false');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('entry_timestamp desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	// function get_course_category_by_id($id){
	// 	$this->db->from('post_categories');
	// 	$this->db->where('id', $id);

	// 	$query = $this->db->get();
		
	// 	return $this->db_trans->return_select_first_row($query);
	// }

	function get_course_pricing($filter_array=null){
		$this->db->select('cp.*, cs.id cid, cs.course_code, cs.course_name, cs.slug')
				->from('course_programs cpm')
				->join('courses cs', 'cpm.program_id = cs.program_id')
				->join('course_pricing cp', 'cs.id = cp.course_id', 'left');
		if($filter_array<>null)
			$this->db->where($filter_array);

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	// function get_category_module_tryout($filter_array=null)
	// {
	// 	$this->db->select('p.*, c.module_price, m.file_name, c.tryout_price, m.file_name as module_doc, c.module_file_id');
	// 	$this->db->from('post_categories p');
	// 	$this->db->join('course_categories_data c', 'p.id = c.category_id', 'left');
	// 	$this->db->join('media_files m', 'c.module_cover = m.id', 'left');
	// 	$this->db->join('media_files m2', 'c.module_file_id = m2.id', 'left');
	// 	if($filter_array<>null)
	// 		$this->db->where($filter_array);
	// 	$this->db->order_by('p.parent_id, p.category');

	// 	$query = $this->db->get();
		
	// 	return $this->db_trans->return_select($query);
	// }

	function get_enrollment_by_order_id($order_id){
		$this->db->select('*');
		$this->db->from('course_enrollment');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_monitoring_data($filter_array=null){
		$this->db->select('*');
		$this->db->from('course_monitoring');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('monitoring_id');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_category_world_scale_by_enroll_id($enroll_id){
		$this->db->select('world_scale');
		$this->db->from('course_enrollment ce');
		$this->db->join('courses cs', 'ce.course_id = cs.id');
		$this->db->join('course_programs cp', 'cs.program_id = cp.program_id');
		$this->db->where('ce.enroll_id', $enroll_id);

		$query = $this->db->get();

		return $query->row()->world_scale;
	}

	function count_verified_tutor_courses_under_programs(){
		$this->db->select('cp.program_id, cp.program_name, count(distinct toc.user_id) as counted_tutors', 'FALSE')
				->from('course_programs cp')
				->join('courses cs', 'cp.program_id = cs.program_id')
				->join('teacher_open_courses toc', 'cs.id = toc.course_id')
				->join('users u', 'toc.user_id = u.user_id')
				->where('toc.verified = 1')
				->where('u.verified_user = 1')
				->group_by('cp.program_id, cp.program_name');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_verified_tutor_courses_under_program($program_id){
		$this->db->select('cp.program_id, cp.program_name, toc.user_id, group_concat(cs.id) as ids, group_concat(cs.course_name) as courses, u.first_name, u.last_name, u.email_login')
				->from('course_programs cp')
				->join('courses cs', 'cp.program_id = cs.program_id')
				->join('teacher_open_courses toc', 'cs.id = toc.course_id')
				->join('users u', 'toc.user_id = u.user_id')
				->where('cs.program_id', $program_id)
				->where('toc.verified = 1')
				->where('u.verified_user = 1')
				->group_by('cp.program_id, cp.program_name, toc.user_id');

		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function count_course_enrollment_by_city_course($field, $value){
		$this->db->select('*');
		$this->db->from('course_enrollment');
		$this->db->where($field, $value);

		$query = $this->db->get();

		return $query->num_rows();
	}
}