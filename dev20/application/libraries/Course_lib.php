<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Course_lib {
	private $ci;
	
	public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('Course_m', 'course');
    }
	
	// function get_course_name_in_string($course_id){ // from table teacher_open_courses
	// 	// get info of the course
 //      	$course_info = $this->ci->course->get_open_course_by_id($course_id);
	//     // get the root category
	//     $root = false;
	//     $root_cat_name = '';
	//     $cat_id = $course_info->course_category_id;
	//     while (!$root) {
	//     	$is_root = $this->ci->course->get_course_category_by_id($cat_id);
	//     	if($is_root<>false){
	//     		if($is_root->parent_id == "0"){
	// 	        	$root = true;
	// 	            $root_cat_name = $is_root->category;
	// 	        }
	// 	        $cat_id = $is_root->parent_id;
	//     	}
	//         else
	// 	    	$root = true;
	//     }

	//     return array('root' => $root_cat_name, 'course' => $course_info->course_category);
	// }

	// function get_course_name_from_post_categories($course_id){ // from table post_categories
	// 	$course_info = $this->ci->course->get_course_category_by_id($course_id);
	// 	$course_name = $course_info->category;
	// 	// get the root category
	//     $root = false;
	//     $root_cat_name = '';
	// 	if($course_info->parent_id=="0"){
	// 		$root = true;
	// 		$root_cat_name = $course_name;
	// 	}

	//     while (!$root) {
	//     	$is_root = $this->ci->course->get_course_category_by_id($course_id);
	//     	if($is_root<>false){
	// 	        if($is_root->parent_id == "0"){
	// 	        	$root = true;
	// 	            $root_cat_name = $is_root->category;
	// 	        }
	// 	        $course_id = $is_root->parent_id;
	// 	    }
	// 	    else
	// 	    	$root = true;
	//     }

	//     return array('root' => $root_cat_name, 'course' => $course_name);
	// }

	function get_days_string($days){
		$day_string = '';
		foreach(explode(',', $days) as $day)
	        $day_string .= $this->ci->lang->line('day_'.$day).', ';
	    $day_string = rtrim($day_string, ', ');

	    return $day_string;
	}

	function get_additional_module($course_array){
		$result = '';
		if($course_array->module_price > 0)
			$result .= $this->ci->lang->line('module_study').', ';
		if($course_array->tryout_price > 0)
			$result .= $this->ci->lang->line('module_tryout').', ';

		$result = rtrim($result, ', ');

		return $result;
	}

	// function count_tutor_under_programs(){
	// 	$result = array();
	// 	$programs = $this->ci->course->get_programs();
	// 	foreach($programs->result() as $program){
	// 		$tutors = $this->ci->course->get_tutor_courses_under_program($program->program_id);
	// 		$result[] = array(
	// 			'program_id' => $program->id,
	// 			'program' => $program->category,
	// 			'count' => ($tutors <> false ? $tutors->num_rows() : '0')
	// 			);
	// 	}

	// 	return $result;
	// }

}

/* End of file Custom.php */
/* Location: ./application/libraries/Custom.php */