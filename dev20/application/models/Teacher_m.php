<?php

class Teacher_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }

    function get_verified_open_course_by_teacher_id($teacher_id, $concat=TRUE){
    	if($concat==TRUE)
    		$this->db->select('group_concat(cs.course_name) as courses', FALSE);
    	else
    		$this->db->select('toc.id as open_course_id, cs.id as course_id, cs.course_name, cp.program_name');
    	$this->db->from('teacher_open_courses toc');
    	$this->db->join('courses cs', 'toc.course_id = cs.id');
    	$this->db->join('course_programs cp', 'cs.program_id = cp.program_id');
    	$this->db->where('toc.user_id', $teacher_id);
    	$this->db->where('toc.verified', '1');
    	$this->db->where('toc.delete_request', '0');

    	$query = $this->db->get();

    	if($concat==TRUE)
    		return $this->db_trans->return_select_first_row($query);
    	else
    		return $this->db_trans->return_select($query);
    }

    function get_concat_city_by_teacher_id($teacher_id, $concat=TRUE){
    	if($concat==TRUE)
    		$this->db->select('group_concat(c.city_name) as city', FALSE);
    	else
    		$this->db->select('tc.city_id, c.city_name');
    	$this->db->from('teacher_open_course_cities tc');
    	$this->db->join('cities c', 'tc.city_id = c.city_id');
    	$this->db->where('tc.user_id', $teacher_id);
    	$this->db->where('tc.verified', '1');
    	$this->db->where('tc.delete_request', '0');

    	$query = $this->db->get();

    	if($concat==TRUE)
    		return $this->db_trans->return_select_first_row($query);
    	else
    		return $this->db_trans->return_select($query);
    }

    function get_data_concat_course($filter_array){
		$this->db->select("toc.user_id, toc.days, toc.session_hours, GROUP_CONCAT(cs.course_name SEPARATOR ', ') AS courses, cp.program_name, ci.city_name, u.first_name, u.last_name, u.user_level,
			ui.about_me, m.file_name, m.file_extension, ui.occupation, ui.salary_per_hour as salary_per_unit_hour", FALSE);
		$this->db->from('teacher_open_courses toc');
		$this->db->join('courses cs', 'toc.course_id = cs.id');
		$this->db->join('course_programs cp', 'cs.program_id = cp.program_id');
		$this->db->join('teacher_open_course_cities occ', 'toc.user_id = occ.user_id');
		$this->db->join('cities ci', 'occ.city_id = ci.city_id');
		$this->db->join('users u', 'toc.user_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where($filter_array);
		$this->db->where('u.verified_user', '1');
		$this->db->where('toc.verified', '1');
		$this->db->where('toc.delete_request', '0');
		
		$this->db->group_by('toc.user_id');
		$this->db->order_by('u.first_name');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_data_concat_course_by_name($name_like){
		$this->db->select('toc.user_id, (select group_concat(cou.course_name) from courses cou join teacher_open_courses tt on cou.id = tt.course_id where user_id = toc.user_id) as courses, u.first_name, u.last_name, u.user_level,
			ui.about_me, m.file_name, m.file_extension, ui.occupation', FALSE);
		$this->db->from('teacher_open_courses toc');
		$this->db->join('courses cs', 'toc.course_id = cs.id');
		$this->db->join('course_programs cp', 'cs.program_id = cp.program_id');
		$this->db->join('teacher_open_course_cities occ', 'toc.user_id = occ.user_id');
		$this->db->join('cities ci', 'occ.city_id = ci.city_id');
		$this->db->join('users u', 'toc.user_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->like('u.first_name', $name_like);
		$this->db->or_like('u.last_name', $name_like);
		$this->db->where('u.verified_user', '1');

		$this->db->group_by('toc.user_id');
		$this->db->order_by('u.first_name');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		return $this->db_trans->return_select($query);
	}

	function get_data_concat_course_by_education_level($root_id){ // by root category
		$this->db->select('
			toc.user_id, 
			(select group_concat(course_name) from teacher_open_courses tt
				join courses cou on tt.course_id = cou.id
				where user_id = toc.user_id and tt.verified=1) as courses,
			pb.category as education_level, ci.city_name, u.first_name, u.last_name, u.user_level,
			ui.about_me, m.file_name, m.file_extension, ui.occupation', FALSE);
		$this->db->from('teacher_open_courses toc');
		$this->db->join('courses cs', 'toc.course_id = cs.id');
		$this->db->join('course_programs cp', 'cs.program_id = cp.program_id');
		$this->db->join('teacher_open_course_cities occ', 'toc.user_id = occ.user_id');
		$this->db->join('cities ci', 'occ.city_id = ci.city_id');
		$this->db->join('users u', 'toc.user_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where('pb.id', $root_id);
		$this->db->where('u.verified_user', '1');

		$this->db->group_by('toc.user_id');
		$this->db->order_by('u.first_name');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_data_by_course_category($cat_id){ // by root category
		$this->db->select('distinct toc.user_id, p.category as courses, pb.category as education_level, u.first_name, u.last_name, u.user_level,
			ui.about_me, m.file_name, m.file_extension, ui.occupation', FALSE);
		$this->db->from('teacher_open_courses toc');
		$this->db->join('courses cs', 'toc.course_id = cs.id');
		$this->db->join('course_programs cp', 'cs.program_id = cp.program_id');
		$this->db->join('teacher_open_course_cities occ', 'toc.user_id = occ.user_id');
		$this->db->join('users u', 'toc.user_id = u.user_id');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where('toc.course_id', $cat_id);
		$this->db->where('u.verified_user', '1');
		$this->db->where('toc.verified', '1');
		$this->db->where('toc.delete_request', '0');

		$this->db->order_by('u.first_name');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_total_taken_course($user_id){
		$this->db->select("count(*) as total_taken_course");
		$this->db->from('course_enrollment ce');
		$this->db->where('ce.teacher_id', $user_id);

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		return $query->row()->total_taken_course;
	}

	function get_open_city($filter_by=null, $filter_value=null){
		$this->db->select('*');
		$this->db->from('teacher_open_course_cities oc');
		$this->db->join('cities c', 'oc.city_id = c.city_id');
		$this->db->join('provinces p', 'c.province_id = p.province_id');
		
		if($filter_by <> null)
			$this->db->where($filter_by, $filter_value);
		$this->db->order_by('p.province_name, c.city_name');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_opened_course_data($filter_array=null){
		$this->db->select('toc.*, c.course_name, cp.program_name');
		$this->db->from('teacher_open_courses toc');
		$this->db->join('courses c', 'toc.course_id = c.id');
		$this->db->join('course_programs cp', 'c.program_id = cp.program_id');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('cp.program_name, c.course_name');
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_course_data_by_userid($teacher_id){
		$this->db->select('toc.*, c.course_name, cp.program_name');
		$this->db->from('teacher_open_courses toc');
		$this->db->join('courses c', 'toc.course_id = c.id');
		$this->db->join('course_programs cp', 'c.program_id = cp.program_id');
		$this->db->where('toc.user_id', $teacher_id);
		$this->db->order_by('cp.program_name, c.course_name');
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_course_data_by_courseid($course_id){
		$this->db->select('toc.*, c.course_name, cp.program_name');
		$this->db->from('teacher_open_courses toc');
		$this->db->join('courses c', 'toc.course_id = c.id');
		$this->db->join('course_programs cp', 'c.program_id = cp.program_id');
		$this->db->where('toc.id', $course_id);
		$this->db->order_by('cp.program_name, c.course_name');
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_unverified(){
		$this->db->select('u.user_id, u.email_login, u.first_name, u.last_name, u.join_date, ui.phone_1, m.file_name');
		$this->db->from('users u');
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id', 'left');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where('u.verified_user', '0');
		$this->db->where('u.user_level', 'teacher');
		$this->db->order_by('u.join_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_verified(){
		$this->db->select('u.user_id, u.email_login, u.first_name, u.last_name, u.join_date, ui.phone_1, m.file_name, ui.salary_per_hour');
		$this->db->from('users u'); 
		$this->db->join('user_info_data ui', 'u.user_id = ui.user_id');
		$this->db->join('media_files m', 'ui.photo_primary_id = m.id', 'left');
		$this->db->where('u.verified_user', '1');
		$this->db->where('u.user_level', 'teacher');
		$this->db->order_by('u.join_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_salary($teacher_id){
		$this->db->select('salary_per_hour');
		$this->db->from('user_info_data');
		$this->db->where('user_id', $teacher_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_city_verification($filter_array=null){
		$this->db->select('oc.*, c.city_name, p.province_name, u.first_name, u.last_name');
		$this->db->from('teacher_open_course_cities oc');
		$this->db->join('cities c', 'oc.city_id = c.city_id');
		$this->db->join('provinces p', 'c.province_id = p.province_id');
		$this->db->join('users u', 'oc.user_id = u.user_id');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('u.first_name');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}
	
	function get_course_verification($filter_array=null){
		$this->db->select('oc.* , u.first_name, u.last_name');
		$this->db->from('teacher_open_courses oc');
		$this->db->join('users u', 'oc.user_id = u.user_id');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('u.first_name');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_schedule($teacher_id){
		$this->db->select('o.*, ce.enroll_id, c.city_name, concat(ua.first_name, " ", ua.last_name) as student_name,
 			concat(ub.first_name, " ", ub.last_name) as teacher_name, uia.phone_1 as student_phone, uib.phone_1 as teacher_phone', FALSE);
		$this->db->from('orders o');
		$this->db->join('course_enrollment ce', 'o.order_id = ce.order_id');
		$this->db->join('cities c', 'o.city_id = c.city_id');
		$this->db->join('users ua', 'o.student_id = ua.user_id');
		$this->db->join('user_info_data uia', 'ua.user_id = uia.user_id');
		$this->db->join('users ub', 'o.teacher_id = ub.user_id');
		$this->db->join('user_info_data uib', 'ub.user_id = uib.user_id');
		$this->db->where('order_status', 'Accept');
		$this->db->where('teacher_id', $teacher_id);
		$this->db->order_by('entry_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}
}