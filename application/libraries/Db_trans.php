<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Db_trans {
	private $ci;
	
	public function __construct()
    {
        $this->ci =& get_instance();
    }
	
	public function check_user_logged_in(){
		$CI =& get_instance();
		
		if($CI->session->userdata('login_data')=="")
			return false;
		else
			return true;
	}
	
	public function return_select($result){
		if($result->num_rows() > 0)
			return $result;
		else
			return false;
	}
	
	public function return_select_first_row($result){
		if($result->num_rows() > 0)
			return $result->row();
		else
			return false;
	}
	
	public function insert_data($table_name, $data){
		//$ci =& get_instance();
		$this->ci->load->model('common');
		//$ci->load->library('database');
		$insert = $this->ci->common->add_to_table($table_name, $data); //return last insert id
		$error = $this->ci->db->error();
		if($insert==false and $error['code'] <> 0){
			$this->ci->session->set_flashdata('err_no', '204');
			$this->ci->session->set_flashdata('err_msg', $error['code'].': '.$error['message']);
		} else{
			$this->ci->session->set_flashdata('err_no', '200');
			$this->ci->session->set_flashdata('err_msg', 'Data inserted successfully');
		}
		return $insert; //return last insert id
	}
	
	public function delete_from_table_by_id($table, $field_id, $id){
		$this->ci->db->delete($table, array($field_id => $id));
		if ($this->ci->db->affected_rows() > 0){
			$this->ci->session->set_flashdata('err_no', '200');
			$this->ci->session->set_flashdata('err_msg', 'Data deleted successfully');
		}
		else {
			$error = $this->ci->db->error();
			$this->ci->session->set_flashdata('err_no', '204');
			$this->ci->session->set_flashdata('err_msg', $error['code'].': '.$error['message']);
		}
	}
	
	public function update_data_on_table($table, $field_id, $id, $data){
		$this->ci->db->where($field_id, $id);
		$this->ci->db->update($table, $data);
		$error = $this->ci->db->error();
		if ($this->ci->db->affected_rows() > 0 or $error['code']==0){
			$this->ci->session->set_flashdata('err_no', '200');
			$this->ci->session->set_flashdata('err_msg', 'Data updated successfully');
			return true;
		}
		else {
			$this->ci->session->set_flashdata('err_no', '204');
			$this->ci->session->set_flashdata('err_msg', $error['code'].': '.$error['message']);
			return false;
		}
	}
	
	public function set_error_message($error){
		$ci =& get_instance();
		
		$ci->session->set_flashdata('err_no', '204');
		$ci->session->set_flashdata('err_msg', $error['code'].': '.$error['message']);
	}
}

/* End of file Custom.php */
/* Location: ./application/libraries/Custom.php */