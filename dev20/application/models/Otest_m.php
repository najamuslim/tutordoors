<?php

class Otest_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_test_data($filter_array=null){
		$this->db->select('*');
		$this->db->from('online_tests');
		
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('entry_date desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_test_data_filter($is_active, $random, $auto, $course_request){
		$this->db->select('*');
		$this->db->from('online_tests');
		if($is_active=="1")
			$this->db->where('is_active', $is_active);
		if($random=="1")
			$this->db->where('random_question', $random);
		if($auto=="1")
			$this->db->where('assign_to_new_tutor', $auto);
		if($course_request=="1")
			$this->db->where('assign_to_course_request', $course_request);

		$this->db->order_by('entry_date desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_question_data($filter_array=null){
		$this->db->select('*');
		$this->db->from('online_test_questions');
		
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('entry_date desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function count_question($test_id){
		$this->db->where('test_id', $test_id);
		$query = $this->db->get('online_test_questions');

		return $query->num_rows();
	}

	function get_answer_data($filter_array=null){
		$this->db->select('*');
		$this->db->from('online_test_answer_choices');
		
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('id');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function clear_data_answer($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->update('online_test_answer_choices', array('answer' => '', 'is_right_answer' => '0'));
	}

	function get_assignment_data($filter_array=null){
		$this->db->select('ota.*, t.course_id, t.test_name');
		$this->db->from('online_test_assignments ota');
		$this->db->join('online_tests t', 'ota.test_id = t.test_id');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('ota.entry_date desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function insert_new_assignment($data){
		$insert = $this->db->insert('online_test_assignments', $data);
		if($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

	function count_assignment_taken($assignment_id){
		$this->db->where('assignment_id', $assignment_id);
		$query = $this->db->get('online_test_takers');

		return $query->num_rows();
	}

	function get_answer_type_of_question($question_id){
		$this->db->select('answer_type');
		$this->db->from('online_test_questions');
		$this->db->where('id', $question_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row()->answer_type;
		else
			return '';
	}

	function get_answer_text_of_question($question_id){
		$this->db->select('answer_text');
		$this->db->from('online_test_questions');
		$this->db->where('id', $question_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row()->answer_text;
		else
			return '';
	}

	function get_right_answer_of_choice($type, $question_id){
		$this->db->select('*');
		$this->db->from('online_test_answer_choices');
		$this->db->where('question_id', $question_id);
		$this->db->where('is_right_answer', '1');

		$query = $this->db->get();

		if($type=="single")
			return $this->db_trans->return_select_first_row($query);
		else if($type=="multiple")
			return $this->db_trans->return_select($query);
	}

	function get_taker_answer_data($filter_array=null){
		$this->db->select('*');
		$this->db->from('online_test_taker_answers');
		
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('question_id');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function count_submitted_answer($taker_id, $is_right=null){
		$this->db->select('*');
		$this->db->from('online_test_taker_answers');
		$this->db->where('taker_id', $taker_id);
		if($is_right<>null)
			$this->db->where('is_right', $is_right);
		$this->db->order_by('question_id');
		$query = $this->db->get();
		
		return $query->num_rows();
	}

	function get_taker_data($filter_array=null){
		$this->db->select('*');
		$this->db->from('online_test_takers');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('taken_time desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_test_by_assignment($assignment_id){
		$this->db->select('ta.assignment_id, t.*');
		$this->db->from('online_test_assignments ta');
		$this->db->join('online_tests t', 'ta.test_id = t.test_id');
		$this->db->where('ta.assignment_id', $assignment_id);

		$query = $this->db->get();

		return $this->db_trans->return_select_first_row($query);
	}

	function get_grade_data($filter_array=null)
	{
		$this->db->select('*');
		$this->db->from('online_test_grades');
		
		if($filter_array <> null)
			$this->db->where($filter_array);
		$this->db->order_by('min_score');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_grade_by_value($value)
	{
		$this->db->select('*');
		$this->db->from('online_test_grades');
		$this->db->where('min_score <=', $value);
		$this->db->where('max_score >=', $value);
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_last_id(){
		$this->db->select('max(substr(assignment_id, 3, 5)) as last_id', false)
				->from('online_test_assignments');
				
		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}
}