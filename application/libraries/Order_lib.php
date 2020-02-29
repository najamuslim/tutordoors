<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_lib {
	private $ci;
	
	public function __construct()
    {
        $this->ci =& get_instance();
    }
	
	function set_courses_session($course_data){
		$this->ci->session->set_userdata('courses', $course_data);
	}

	function get_courses_session(){
		if(!$this->ci->session->userdata('courses'))
			$this->set_courses_session(array());

		return $this->ci->session->userdata('courses');
	}

	function set_cart_session($cart_items){
		// will store teacher, course, and detail of order
		$this->ci->session->set_userdata('cart', $cart_items);
	}

	function get_cart_session(){
		if(!$this->ci->session->userdata('cart'))
			$this->set_cart_session(array());

		return $this->ci->session->userdata('cart');
	}

	function clear_cart_session(){
		$this->ci->session->unset_userdata('cart');
	}

	function count_cart_item(){
		$count = 0;
		$cart = $this->get_cart_session();
		foreach($cart as $tutor)
			foreach($tutor as $course)
				$count += 1;
		return $count;
	}

	function set_selected_city_session($course_data){
		$this->ci->session->set_userdata('selected_city', $course_data);
	}

	function get_selected_city_session(){
		if(!$this->ci->session->userdata('selected_city'))
			$this->set_courses_session(array());

		return $this->ci->session->userdata('selected_city');
	}

}

/* End of file Custom.php */
/* Location: ./application/libraries/Custom.php */