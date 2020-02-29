<?php

class Payment_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_teacher_commission_zero(){
		$query = $this->db->query('
						select cea.*, u.first_name, u.last_name, ui.phone_1,
							(select parameter_value from options where parameter_name="teacher_commission") as teacher_commission_percent,
							(select grand_total from orders where order_id = cea.order_id) as total,
							(select parameter_value from options where parameter_name="first_teacher_commission") as first_teacher_commission,
							(select parameter_value from options where parameter_name="second_teacher_commission") as second_teacher_commission
						from course_enrollment cea
						join users u on cea.teacher_id = u.user_id
						join user_info_data ui on u.user_id = ui.user_id
						where cea.enroll_id in 
							(
							select ce.enroll_id from course_enrollment ce
							left join teacher_commissions tc on ce.enroll_id = tc.enroll_id
							group by ce.enroll_id
							having sum(ifnull(tc.termin, 0)) = 0
							order by ce.entry_timestamp
							)
								');

		return $this->db_trans->return_select($query);
	}

	function get_teacher_commission_one(){
		$query = $this->db->query('
						select cea.*, u.first_name, u.last_name, ui.phone_1, 
								(select nominal from teacher_commissions where enroll_id = cea.enroll_id and termin = 1) as paid_termin_1,
								(select parameter_value from options where parameter_name="teacher_commission") as teacher_commission_percent,
								(select grand_total from orders where order_id = cea.order_id) as total
						from course_enrollment cea
						join users u on cea.teacher_id = u.user_id
						join user_info_data ui on u.user_id = ui.user_id
						where cea.enroll_id in 
							(
							select ce.enroll_id from course_enrollment ce
							left join teacher_commissions tc on ce.enroll_id = tc.enroll_id
							group by ce.enroll_id
							having sum(ifnull(tc.termin, 0)) = 1
							order by ce.entry_timestamp
							)
								');

		return $this->db_trans->return_select($query);
	}

	function get_teacher_commission_more(){
		$query = $this->db->query('
						select cea.*, u.first_name, u.last_name, ui.phone_1, 
								(select nominal from teacher_commissions where enroll_id = cea.enroll_id and termin = 1) as paid_termin_1,
								(select nominal from teacher_commissions where enroll_id = cea.enroll_id and termin = 2) as paid_termin_2
						from course_enrollment cea
						join users u on cea.teacher_id = u.user_id
						join user_info_data ui on u.user_id = ui.user_id
						where cea.enroll_id in 
							(
							select ce.enroll_id from course_enrollment ce
							left join teacher_commissions tc on ce.enroll_id = tc.enroll_id
							group by ce.enroll_id
							having sum(ifnull(tc.termin, 0)) > 1
							order by ce.entry_timestamp
							)
								');

		return $this->db_trans->return_select($query);
	}

	function get_invoice_by_id($invoice_id){
		$this->db->from('invoices');
		$this->db->where('invoice_id', $invoice_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_comm_by_teacherid($teacher_id){
		$query = $this->db->query('
						SELECT `tc`.`enroll_id`, 
							(select nominal from teacher_commissions where enroll_id = tc.enroll_id and termin = 1) as termin_1, 
							(select transfer_date from teacher_commissions where enroll_id = tc.enroll_id and termin = 1) as transfer_termin_1,
							ifnull((select nominal from teacher_commissions where enroll_id = tc.enroll_id and termin = 2), 0) as `termin_2`, 
							(select transfer_date from teacher_commissions where enroll_id = tc.enroll_id and termin = 2) as transfer_termin_2,
							`o`.`grand_total`, `cs`.`course_name`, `u`.`first_name` as `student_first_name`, `u`.`last_name` as `student_last_name` 
						FROM `teacher_commissions` `tc` 
						JOIN `course_enrollment` `ce` ON `tc`.`enroll_id` = `ce`.`enroll_id` 
						JOIN `orders` `o` ON `ce`.`order_id` = `o`.`order_id` 
						JOIN `courses` `cs` ON `ce`.`course_id` = `cs`.`id` 
						JOIN `users` `u` ON `ce`.`student_id` = `u`.`user_id` 
						WHERE `ce`.`teacher_id` = "'.$teacher_id.'"
						GROUP BY `tc`.`enroll_id` 
						ORDER BY `ce`.`entry_timestamp` desc');
		// print_r($this->db->last_query());

		return $this->db_trans->return_select($query);
	}
}


?>