<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->library('Logging');
	}
	
	public function user_view(){
		$this->check_user_access();
		$view = $this->input->get('v');
		$data = array(
			'active_menu_id' => 'user-access-view',
			'title_page' => 'View All Users'
			);

		//get user data
		if($view=="all")
			$data['users'] = $this->User_m->get_user_data();
		else if($view=="teacher")
			$data['users'] = $this->User_m->get_user_by_level('teacher');
		else if($view=="student")
			$data['users'] = $this->User_m->get_user_by_level('student');

		$this->open_admin_page('admin/user_view_all', $data);
	}

	public function add_user(){
		$this->check_user_access();
		$this->session->set_flashdata('curr_page', $this->uri->segment(1).'/'.$this->uri->segment(2));
		$data = array(
			'active_menu_id' => 'access-add',
			'title_page' => 'Add New User',
			'title' => 'add'
			);

		//generate captcha
		$this->load->helper('captcha');
		$captcha_data = array(
			'word' => rand(1000, 9999),
			'img_path' => 'assets/captcha/',
			'img_url' => base_url().'assets/captcha/',
			//'font_path' => './path/to/fonts/texb.ttf',
			'img_width' => '150',
			'img_height' => 30,
			'expiration' => 7200
			);

		$cap = create_captcha($captcha_data);
		$insert_cap = array(
			'captcha_time' => $cap['time'],
			'ip_address' => $this->input->ip_address(),
			'word' => $cap['word']
		);
		$query = $this->db->insert_string('captcha', $insert_cap);
		$this->db->query($query);
		//echo $cap['image'];
		$data['captcha'] = $cap['image'];
				
		$this->open_admin_page('admin/user_creation', $data);
	}

	public function edit_user(){
		$this->check_user_access();
		$this->session->set_flashdata('curr_page', $this->uri->segment(1).'/'.$this->uri->segment(2));
		$data = array(
			'active_menu_id' => 'access-add',
			'title_page' => 'Edit User',
			'title' => 'edit'
			);

		//get user data
		$data['user'] = $this->User_m->get_user_by_id($this->input->get('id', TRUE));

		//generate captcha
		$this->load->helper('captcha');
		$captcha_data = array(
			'word' => rand(1000, 9999),
			'img_path' => 'assets/captcha/',
			'img_url' => base_url().'assets/captcha/',
			//'font_path' => './path/to/fonts/texb.ttf',
			'img_width' => '150',
			'img_height' => 30,
			'expiration' => 7200
			);

		$cap = create_captcha($captcha_data);
		$insert_cap = array(
			'captcha_time' => $cap['time'],
			'ip_address' => $this->input->ip_address(),
			'word' => $cap['word']
		);
		$query = $this->db->insert_string('captcha', $insert_cap);
		$this->db->query($query);
		//echo $cap['image'];
		$data['captcha'] = $cap['image'];
				
		$this->open_admin_page('admin/user_creation', $data);
	}

	public function change_password_view(){
		$this->check_user_access();
		$this->session->set_flashdata('curr_page', $this->uri->segment(1).'/'.$this->uri->segment(2));
		$data = array(
			'active_menu_id' => 'access-change-password',
			'title_page' => 'Change My Password'
			);

		$this->open_admin_page('admin/change_password', $data);
	}

	public function subscribers(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'newsletter-subscriber',
			'title_page' => 'Newsletter Subscribers'
			);

		//get user data
		$data['subscribers'] = $this->User_m->get_subscribers();

		$this->open_admin_page('admin/newsletter_subscribers', $data);
	}

	/* end pages */

	/* function start */

	function check_captcha(){
		// First, delete old captchas
		$expiration = time()-7200; // Two hour limit
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

		// Then see if a captcha exists:
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($this->input->post('captcha', TRUE) , $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		return $row;
	}

	public function user_add(){
		//check captcha
		// $row = $this->check_captcha();
		// if ($row->count == 0)
		// {
		// 	$response['status'] = '204';
		// 	$response['message'] = $this->lang->line('error_characters_correctly');
		// }
		// else{
		$this->load->helper(array('form'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('pass', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('pass_re', 'Verifikasi Password', 'required|matches[pass]');
		$this->form_validation->set_rules('fn', 'Nama Depan', 'required');
		// $this->form_validation->set_rules('province', 'Propinsi', 'required');
		// $this->form_validation->set_rules('city', 'Kota', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = '204';
			$response['message'] = validation_errors();
		}
		else
		{
			$check_exist_email = $this->User_m->check_exist_user($this->input->post('email', TRUE));
			if($check_exist_email<>false)
				$response = array(
					'status' => '204',
					'message' => $this->lang->line('error_email_exist')
					);
			else{
				$check_exist_user = true;
				$verification_key = generate_random_string('letter', 13).generate_random_string('number', 10).generate_random_string('letter', 7).uniqid();
				$data = array(
					'email_login' => $this->input->post('email', TRUE),
					'password' => md5($this->input->post('pass', TRUE)),
					'first_name' => $this->input->post('fn', TRUE),
					'last_name' => $this->input->post('ln', TRUE),
					'user_level' => $this->input->post('level', TRUE),
					'register_source' => 'web',
					'verification_key' => $verification_key
					);
				// // get user identifier for province and city
				// $prov_uid = $this->Location_m->get_user_identifier('province', $this->input->post('province'));
				// $city_uid = $this->Location_m->get_user_identifier('city', $this->input->post('city'));
				// $location_uid = $prov_uid.$city_uid;

				$this->load->helper('myfunction_helper');
				while ($check_exist_user==true){
					$random_letter = generate_random_string('letter', 3);
					$random_number = generate_random_string('number', 3);
					// format menjadi 6 char
					// susunan: karakter dipasangkan dari setiap letter & number sesuai urutan
					// misal letter = ABC & number = 567 => A5B6C7
					$generated_id = '';
					for($i = 0; $i < 3; $i++)
						$generated_id .= substr($random_letter, $i, 1).substr($random_number, $i, 1);
					
					$new_user_id = $generated_id;
					// $new_user_id = $location_uid.$random_number;
					if(!$this->User_m->check_user_id_exist($new_user_id))
						$check_exist_user=false;
				}
				$data['user_id'] = $new_user_id;

				$create = $this->Common->add_to_table('users', $data);
				// // create data in opened city course - start
				// $data = array(
				// 	'user_id' => $new_user_id,
				// 	'city_id' => $this->input->post('city'),
				// 	'verified' => '1'
				// 	);
				
				// $add_city = $this->Common->add_to_table('teacher_open_course_cities', $data);
				// // create data in opened city course - end
				if($create->status){
					if($this->session->userdata('logged')==""){
						$this->session->set_userdata('logged', 'in');
						$this->session->set_userdata('userid', $new_user_id);
						$this->session->set_userdata('email', $this->input->post('email', TRUE));
						$this->session->set_userdata('fn', $this->input->post('fn', TRUE));
						$this->session->set_userdata('ln', $this->input->post('ln', TRUE));
						$this->session->set_userdata('level', $this->input->post('level', TRUE));
					}

					$response['status'] = '200';

					// get email template from database
			        $get_template = $this->Content_m->get_email_templates(array('id' => 'post-registration-'.$this->session->userdata('language')));
			        $template = htmlspecialchars_decode($get_template->row()->content);
			        
			        // prepare data to replace 
			        $content = $template;
			        $content = str_replace('[FULL_NAME]', $this->session->userdata('fn').($this->session->userdata('ln')=="" ? "":$this->session->userdata('ln')), $content);
			        $content = str_replace('[FIRST_NAME]', $this->session->userdata('fn'), $content);
			        $content = str_replace('[LAST_NAME]', $this->session->userdata('ln'), $content);
			        $content = str_replace('[EMAIL]', $this->session->userdata('email'), $content);
			        $content = str_replace('[USER_ID]', $this->session->userdata('userid'), $content);
			        $get_email_cs = $this->Content_m->get_option_by_param('company_email_customer_service');
			        $content = str_replace('[EMAIL_CS]', $get_email_cs->parameter_value, $content);
			        $get_phone_office = $this->Content_m->get_option_by_param('company_phone');
			        $content = str_replace('[PHONE_OFFICE]', $get_phone_office->parameter_value, $content);
			        $get_address_office = $this->Content_m->get_option_by_param('company_address');
			        $content = str_replace('[ADDRESS_OFFICE]', $get_address_office->parameter_value, $content);
			        $content = str_replace('[VERIFICATION_LINK]', $verification_key, $content);

					// send email to customer
					$this->load->library('My_PHPMailer');
			        $mail = new PHPMailer();
			        $mail->IsSMTP(); // we are going to use SMTP
			        $mail->SMTPAuth   = true; // enabled SMTP authentication
			        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
			        $mail->Host       = $this->config->item('smtp_host');      // setting GMail as our SMTP server
			        $mail->Port       = $this->config->item('smtp_port');                   // SMTP port to connect to GMail
			        $mail->Username   = $this->config->item('smtp_user');  // user email address
			        $mail->Password   = $this->config->item('smtp_pass');            // password in GMail
			        $mail->SetFrom('admin@tutordoors.com', 'Admin Tutordoors');  //Who is sending the email
			        $mail->Subject    = $this->lang->line('welcome_in_tutordoors');
			        $mail->Body      = $content;
			        $mail->AltBody    = "Plain text message";
			        $destino = $this->session->userdata('email'); // Who is addressed the email to
			        $mail->AddAddress($destino, $this->session->userdata('fn'));

			        if(!$mail->Send()) {
			        	$this->logging->insert_event_logging('send_email_new_member', '', 'false', $mail->ErrorInfo);
			        } else {
			            $this->logging->insert_event_logging('send_email_new_member', '', 'true', 'Message sent');
			        }

			        // create online test assignment if any and if level is tutor
			        if($this->session->userdata('level')=="teacher"){
			        	$this->load->model('Otest_m', 'otest');
			        	$this->load->library('notification');
				        $auto_assignment = $this->otest->get_test_data(array('is_active'=>'1', 'assign_to_new_tutor'=>'1'));
				        if($auto_assignment<>false){
				        	$get_max_retry = $this->Content_m->get_option_by_param('max_retry');
				        	foreach($auto_assignment->result() as $test){
				        		$data = array(
									'test_id' => $test->test_id,
									'teacher_id' => $this->session->userdata('userid')
									);
								
								$result_insert = false;

								// 1.2 generate ID and check if duplicate
								while($result_insert==false){
									$new_id = 'TA'.generate_random_string('number', 5);
									$data['assignment_id'] = $new_id;
									$insert = $this->otest->insert_new_assignment($data);
									if($insert)
										$result_insert = true;
									else
										$result_insert = false;
								}

								$assignment_id = $new_id;

								// give notification to tutor
						        $notif = array(
						        	'category' => 'new_test_assignment',
						        	'title' => 'Online Test Assignment',
						        	'content' => $this->lang->line('notification_new_test_assignment_create').' ID Assignment = '.$assignment_id,
						        	'sender_id' => 'admin', // admin
						        	'receiver_id' => $this->session->userdata('userid') // tutor ID
						        	);
						        $this->notification->insert($notif);
				        	}
				        }
			        }
				}
				else{
					$response['status'] = '204';
					$response['message'] = $create->output;
				}
			}
		}
		// }

		echo json_encode($response);
	}

	public function user_update(){
		$userid = $this->input->post('user_id');
		//check captcha
		$row = $this->check_captcha();
		if ($row->count == 0)
		{
			$this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->lang->line('error_characters_correctly'));
			redirect('users/edit_user?id='.$userid);
		}
		else{
	
			$data = array(
				'email_login' => $this->input->post('email', TRUE),
				'first_name' => $this->input->post('fn', TRUE),
				'last_name' => $this->input->post('ln', TRUE),
				'user_level' => $this->input->post('level', TRUE)
				);

			$update = $this->Common->update_data_on_table('users', 'user_id', $userid, $data);
			$this->set_session_response_no_redirect('update', $update);

			$response['status'] = '200';
			echo json_encode($response);
		}
	}

	public function user_delete(){
		$id = $this->input->get('id', TRUE);
		$delete = $this->Common->delete_from_table_by_id('users', 'user_id', $id);
		// print_r($this->db->last_query());
		$this->set_session_response_no_redirect('delete', $delete);

		redirect('users/user_view?v=all');
	}

	public function do_login(){
		$current_page = $this->uri->segment(1).'/'.$this->uri->segment(2);

		$user_data = $this->User_m->check_exist_user($this->input->post('email', TRUE), $this->input->post('password', TRUE));
		if(!$user_data)
			$response['status'] = '204'; 
		else{
			if($current_page=="cms/login"){
				if($user_data->user_level=="admin" or $user_data->user_level=="staff"){
					$response['status'] = '200';
					$response['user_level'] = $user_data->user_level;
					$this->session->set_userdata('logged', 'in');
					$this->session->set_userdata('userid', $user_data->user_id);
					$this->session->set_userdata('email', $user_data->email_login);
					$this->session->set_userdata('fn', $user_data->first_name);
					$this->session->set_userdata('ln', $user_data->last_name);
					$this->session->set_userdata('level', $user_data->user_level);
				}
				else
					$response['status'] = '205';
			}
			else{ // if not cms login
				$response['status'] = '200';
				$response['user_level'] = $user_data->user_level;
				$this->session->set_userdata('logged', 'in');
				$this->session->set_userdata('userid', $user_data->user_id);
				$this->session->set_userdata('email', $user_data->email_login);
				$this->session->set_userdata('fn', $user_data->first_name);
				$this->session->set_userdata('ln', $user_data->last_name);
				$this->session->set_userdata('level', $user_data->user_level);
			}
		}
			
		echo json_encode($response);
	}

	public function do_logout(){
		$this->session->sess_destroy();

		$current_page = $this->session->flashdata('curr_page');
		redirect($current_page);
	}

	function password_change(){
		$email = $this->input->post('email', TRUE);
		$old = $this->input->post('old', TRUE);
		$new = $this->input->post('new', TRUE);

		// check email and old password first
		$check = $this->User_m->check_exist_user($email, $old);
		if(!$check){
			$response['status'] = '204';
			$response['message'] = $this->lang->line('error_email_password_not_matched');
		}
		else{
			$update = $this->User_m->update_password($email, $new);
			if($update)
				$response['status'] = '200';
			else{
				$response['status'] = '204';
				$response['message'] = $update;
			}
		}

		echo json_encode($response);
	}

	// function change_profile(){
	// 	$user_id = $this->input->post('userid', TRUE);
	// 	$general = array(
	// 		'first_name' => $this->input->post('fn', TRUE),
	// 		'last_name' => $this->input->post('ln', TRUE)
	// 		);
	// 	$this->load->model('Common');
	// 	$update_general = $this->Common->update_data_on_table('users', 'user_id', $user_id, $general);
		
	// 	redirect('profile?tab=profile');
	// }

	function forgot_password(){
		$data['message'] = $this->session->flashdata('msg_reset');
		$data['page_title'] = $this->lang->line('password_forgot');
		$this->open_page('forgot_password', $data);
	}

	function request_reset_password(){
		$email = $this->input->post('email', TRUE);
		
		$get = $this->User_m->get_user_data(array('email_login' => $email));
		if($get==false){
			$this->session->set_flashdata('msg_reset', $this->lang->line('error_email_not_found_for_login'));
			redirect('users/forgot_password');
		}
		else{
			// $this->load->helper('myfunction_helper');
			$random_letter = generate_random_string('letter', 5);
			$random_number = generate_random_string('number', 5);
			$generated_password = $random_letter.$random_number;

			$user_id = $get->row()->user_id;
			$data = array( // insert to request reset password
				'user_id' => $user_id,
				'password_generated' => $generated_password
				);
			// delete the old requests
			$delete = $this->Common->delete_from_table_by_id('request_reset_password', 'user_id', $user_id);
			// then we insert the data
			$insert = $this->Common->add_to_table('request_reset_password', $data);

			// get email template from database
	        $get_template = $this->Content_m->get_email_templates(array('id' => 'request-reset-password-'.$this->session->userdata('language')));
	        $template = htmlspecialchars_decode($get_template->row()->content);
	        
	        // prepare data to replace 
	        $content = $template;
	        $content = str_replace('[NEW_PASSWORD]', $generated_password, $content);
	        $content = str_replace('[RESET_LINK]', '<a href="'.base_url('users/reset?id='.$user_id).'">'.base_url('users/reset?id='.$user_id).'</a>', $content);
	        $get_address_office = $this->Content_m->get_option_by_param('company_address');
	        $content = str_replace('[ADDRESS_OFFICE]', $get_address_office->parameter_value, $content);
			
			$this->load->library('My_PHPMailer');
	        $mail = new PHPMailer();
	        $mail->IsSMTP(); // we are going to use SMTP
	        $mail->SMTPAuth   = true; // enabled SMTP authentication
	        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
	        $mail->Host       = $this->config->item('smtp_host');      // setting GMail as our SMTP server
	        $mail->Port       = $this->config->item('smtp_port');                   // SMTP port to connect to GMail
	        $mail->Username   = $this->config->item('smtp_user');  // user email address
	        $mail->Password   = $this->config->item('smtp_pass');            // password in GMail
	        $mail->SetFrom('admin@tutordoors.com', 'Admin Tutordoors');  //Who is sending the email
	        $mail->Subject    = $this->lang->line('password_request_reset');

	        $mail->Body      = $content;
	        $mail->AltBody    = "Plain text message";
	        $destino = $email; // Who is addressed the email to
	        $mail->AddAddress($destino, "Customer");

	        if(!$mail->Send()) {
	        	$this->logging->insert_event_logging('send_email_request_reset_password', '', 'false', $mail->ErrorInfo);
	        } else {
	            $this->logging->insert_event_logging('send_email_request_reset_password', '', 'true', 'Message sent');
	        }

	        $this->session->set_flashdata('msg_reset', $this->lang->line('password_request_reset_notification'));
			redirect('users/forgot_password');
		}
	}

	function reset(){
		$user_id = $this->input->get('id', TRUE);
		// get password in request reset password
		$get = $this->User_m->get_reset_password($user_id);
		$new_password = $get->password_generated;

		// then update in users
		$data = array('password' => md5($new_password));
		$update = $this->Common->update_data_on_table('users', 'user_id', $user_id, $data);

		$this->session->set_flashdata('msg_reset', $this->lang->line('password_new_is_active'));
		$this->show_success_page(200, $this->lang->line('reset_password_done_and_able_to_login'));
	}

	function update_user_primary_photo(){
		$user_id = $this->session->userdata('userid');

		$this->load->library('upload');
		$config = array(
			'upload_path' => './assets/uploads/',
			'allowed_types' => 'jpg|png|gif|jpeg',
			'max_size' => 1000,
			// 'max_width' => '270',
			// 'max_height' => '300',
			'overwrite' => false,
			'remove_spaces' => true
		);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('image_file')){
			// var_dump($this->upload->display_errors());
			// var_dump($this->upload->file_type);

			array_push($this->any_error, $this->lang->line('error_set_primary_image').' '.$this->upload->display_errors());
		} 
		else{
			$upload_data = $this->upload->data();
			//insert document data in database
	
			$data = array(
				'file_name' => $upload_data['file_name'],
				'file_type' => $upload_data['file_type'],
				'file_extension' => $upload_data['file_ext'],
				'img_width' => $upload_data['image_width'],
				'img_height' => $upload_data['image_height'],
			);

			$add_media = $this->Common->add_to_table('media_files', $data); // return the last inserted id
			$this->push_if_transaction_error($add_media);
			// mapping profil and media
			$update_data = array('photo_primary_id' => $add_media->output);
			$insert_data = array('user_id' => $user_id, 'photo_primary_id' => $add_media->output);
			// if the user info data not exist, it will create the new one, otherwise will update
			$check_exist_info = $this->User_m->get_user_info_data($user_id);
			if($check_exist_info<>false) // if exist
				$upd_info = $this->Common->update_data_on_table('user_info_data', 'user_id', $user_id, $update_data);
			else
				$map_photo = $this->Common->add_to_table('user_info_data', $insert_data);
			$this->push_if_transaction_error($upd_info); 
        }

        $this->set_session_response_no_redirect_by_error('update');

        redirect('users/edit_profile');
	}

	function update_personal_info(){
		$user_id = $this->session->userdata('userid');

		// will make sure all transaction run completed or nothing
		$this->db->trans_start();
		// 1. update name
		$name_data = array(
			'first_name' => $this->input->post('first-name'),
			'last_name' => $this->input->post('last-name')
			);
		$update_name = $this->Common->update_data_on_table('users', 'user_id', $user_id, $name_data);
		$this->push_if_transaction_error($update_name); 

		// 2. update personal data
		$personal_data = array(
			'national_card_number' => $this->input->post('ktp', TRUE),
			'sex' => $this->input->post('sex', TRUE),
			'birth_place' => $this->input->post('birth-place', TRUE),
			'birth_date' => $this->input->post('birth-date', TRUE),
			'address_national_card' => $this->input->post('address-ktp', TRUE),
			'address_domicile' => $this->input->post('address-domicile', TRUE),
			'phone_1' => $this->input->post('phone-1', TRUE),
			'phone_2' => $this->input->post('phone-2', TRUE)
			);

		
		$check_exist_info = $this->User_m->get_user_info_data($user_id);
		if($check_exist_info<>false){ // if exist
			$update_info = $this->Common->update_data_on_table('user_info_data', 'user_id', $user_id, $personal_data);
			$this->push_if_transaction_error($update_info); 
		}
		else{
			$personal_data['user_id'] = $user_id;
			$add_info = $this->Common->add_to_table('user_info_data', $personal_data);
			$this->push_if_transaction_error($add_info);
		}

		if (!empty($_FILES['image_file']['name'])){ // uploading national card attachment
			$this->load->library('upload');
			$config = array(
				'upload_path' => './assets/uploads/',
				'allowed_types' => 'jpg|png|jpeg',
				'overwrite' => false,
				'remove_spaces' => true,
				'max_size' => '10000'
			);
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('image_file')){
				array_push($this->any_error, 'Error on set primary image: '.$this->upload->display_errors());
			} 
			else{
				$upload_data = $this->upload->data();
				//insert document data in database
				$data = array(
					'file_name' => $upload_data['file_name'],
					'file_type' => $upload_data['file_type'],
					'file_extension' => $upload_data['file_ext'],
					'img_width' => $upload_data['image_width'],
					'img_height' => $upload_data['image_height'],
				);

				$add_media = $this->Common->add_to_table('media_files', $data); // return the last inserted id
				$this->push_if_transaction_error($add_media);
				// mapping post and media
				$map = array('national_card_attachment' => $add_media->output);
				$mapping_media = $this->Common->update_data_on_table('user_info_data', 'user_id', $user_id, $map);
				$this->push_if_transaction_error($mapping_media);
	        }
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		}
		else
		{
	        $this->db->trans_commit();
	    }
	    $this->set_session_response_no_redirect_by_error('update');

		redirect('users/edit_profile');
	}

	function update_student_personal_info(){
		$user_id = $this->session->userdata('userid');

		// will make sure all transaction run completed or nothing
		$this->db->trans_start();
		// 1. update name
		$name_data = array(
			'first_name' => $this->input->post('first-name'),
			'last_name' => $this->input->post('last-name')
			);
		$update_name = $this->Common->update_data_on_table('users', 'user_id', $user_id, $name_data);
		$this->push_if_transaction_error($update_name);

		// 2. update personal data
		$personal_data = array(
			'sex' => $this->input->post('sex', TRUE),
			'birth_place' => $this->input->post('birth-place', TRUE),
			'birth_date' => $this->input->post('birth-date', TRUE),
			'where_student_school' => $this->input->post('where_student_school', TRUE),
			'address_national_card' => $this->input->post('address-ktp', TRUE),
			'phone_1' => $this->input->post('phone-1', TRUE),
			'phone_2' => $this->input->post('phone-2', TRUE),
			'about_me' => $this->input->post('about-me', TRUE),
			'hobby' => $this->input->post('hobby', TRUE)
			);

		
		$check_exist_info = $this->User_m->get_user_info_data($user_id);
		if($check_exist_info<>false){ // if exist
			$update_info = $this->Common->update_data_on_table('user_info_data', 'user_id', $user_id, $personal_data);
			$this->push_if_transaction_error($update_info);
		}
		else{
			$personal_data['user_id'] = $user_id;
			$add_info = $this->Common->add_to_table('user_info_data', $personal_data);
			$this->push_if_transaction_error($add_info);
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		}
		else
		{
	        $this->db->trans_commit();
	    }
	    $this->set_session_response_no_redirect_by_error('update');

		redirect('users/edit_profile');
	}

	function update_public_info(){
		$user_id = $this->session->userdata('userid');

		// update public data
		$public_data = array(
			'about_me' => $this->input->post('about-me', TRUE),
			'teach_experience' => $this->input->post('teach-experience', TRUE),
			'toefl_score' => $this->input->post('toefl', TRUE),
			'ielts_score' => $this->input->post('ielts', TRUE),
			'skill' => $this->input->post('skill', TRUE),
			'hobby' => $this->input->post('hobby', TRUE)
			);

		
		$check_exist_info = $this->User_m->get_user_info_data($user_id);
		if($check_exist_info<>false){ // if exist
			$update_info = $this->Common->update_data_on_table('user_info_data', 'user_id', $user_id, $public_data);
			$this->set_session_response_no_redirect('update', $update_info);
		}
		else{
			$public_data['user_id'] = $user_id;
			$add_info = $this->Common->add_to_table('user_info_data', $public_data);
			$this->set_session_response_no_redirect('add', $add_info);
		}

		redirect('users/edit_profile');
	}

	function set_teacher_bank_account(){
		$user_id = $this->session->userdata('userid');

		$data = array(
			'bank_name' => $this->input->post('bank-name', TRUE),
			'bank_account_number' => $this->input->post('number', TRUE),
			'bank_holder_name' => $this->input->post('holder-name', TRUE),
			'bank_branch' => $this->input->post('branch', TRUE),
			'bank_city' => $this->input->post('city', TRUE)
			);

		$check_exist_bank = $this->User_m->get_user_bank($user_id);
		if($check_exist_bank<>false){ // if exist
			$update_info = $this->Common->update_data_on_table('user_bank_account', 'user_id', $user_id, $data);
			$this->set_session_response_no_redirect('update', $update_info);
		}
		else{
			$data['user_id'] = $user_id;
			$add_info = $this->Common->add_to_table('user_bank_account', $data);
			$this->set_session_response_no_redirect('add', $add_info);
		}	

		redirect('teacher/set_bank');
	}

	function u_change_password(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'change_password';
			$data['gm'] = 'dashboard';

			$data['page_title'] = $this->lang->line('change_password');
			$data['sub_page_title'] = $this->lang->line('change_password');
			
			$this->open_page('user/change_password', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function edit_profile(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'edit_profile';
			$data['gm'] = 'dashboard';

			$data['page_title'] = $this->lang->line('edit_profile');
			$data['sub_page_title'] = $this->lang->line('edit_profile');
			$this->load->model('Media_m', 'media');

			// get education experience
			$data['education_history'] = $this->User_m->get_education_history_by_userid($user_id);
			
			$this->open_page('user/edit_profile', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function view_profile(){
		if($this->session->userdata('logged')=="in"){
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'edit_profile';
			$data['gm'] = 'dashboard';

			$data['page_title'] = 'View Profile';
			// $data['sub_page_title'] = 'View Profile';
			$this->load->model('Media_m', 'media');

			// get education experience
			$data['education_history'] = $this->User_m->get_education_history_by_userid($user_id);
			
			$this->open_page('user/profile_user_full', $data);
		}
		else
			$this->show_error_page('700', $this->lang->line('error_must_login'));
	}

	function add_education_history(){
		$user_id = $this->session->userdata('userid');
		
		$this->db->trans_start();
		$data = array(
			'user_id' => $user_id,
			'degree' => $this->input->post('degree', true),
			'institution' => $this->input->post('institution', true),
			'major' => $this->input->post('major', true),
			'date_in' => $this->input->post('year_in', true),
			'date_out' => $this->input->post('year_out', true),
			'grade_score' => $this->input->post('grade_score', true)
			);
		
		$add_edu = $this->Common->add_to_table('user_education_experiences', $data);
		$this->push_if_transaction_error($add_edu);

		$this->load->library('upload');
		$config = array(
			'upload_path' => './assets/uploads/',
			'allowed_types' => 'jpg|png|jpeg',
			'overwrite' => false,
			'remove_spaces' => true,
			'max_size' => '2000'
		);
		
		if (!empty($_FILES['certificate']['name'])){	
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('certificate')){
				array_push($this->any_error, 'Error on set primary image: '.$this->upload->display_errors());
			} 
			else{
				$upload_data = $this->upload->data();
				//insert document data in database
				$data = array(
					'file_name' => $upload_data['file_name'],
					'file_type' => $upload_data['file_type'],
					'file_extension' => $upload_data['file_ext'],
					'img_width' => $upload_data['image_width'],
					'img_height' => $upload_data['image_height'],
				);

				$add_media = $this->Common->add_to_table('media_files', $data); // return the last inserted id
				$this->push_if_transaction_error($add_media);
				// mapping post and media
				$map = array('certificate_media_id' => $add_media->output);
				$mapping_media = $this->Common->update_data_on_table('user_education_experiences', 'id', $add_edu->output, $map);
				$this->push_if_transaction_error($mapping_media);
	        }
		}

		if (!empty($_FILES['transcript']['name'])){	
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('transcript')){
				array_push($this->any_error, 'Error on set primary image: '.$this->upload->display_errors());
			} 
			else{
				$upload_data = $this->upload->data();
				//insert document data in database
				$data = array(
					'file_name' => $upload_data['file_name'],
					'file_type' => $upload_data['file_type'],
					'file_extension' => $upload_data['file_ext'],
					'img_width' => $upload_data['image_width'],
					'img_height' => $upload_data['image_height'],
				);

				$add_media = $this->Common->add_to_table('media_files', $data); // return the last inserted id
				$this->push_if_transaction_error($add_media);
				// mapping post and media
				$map = array('transcript_media_id' => $add_media->output);
				$mapping_media = $this->Common->update_data_on_table('user_education_experiences', 'id', $add_edu->output, $map);
				$this->push_if_transaction_error($mapping_media);
	        }
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		}
		else
		{
	        $this->db->trans_commit();
	    }
	    $this->set_session_response_no_redirect_by_error('add');

		redirect('users/edit_profile');
	}

	function update_education_history(){
		$user_id = $this->session->userdata('userid');
		
		$this->db->trans_start();
		$data = array(
			'degree' => $this->input->post('degree', true),
			'institution' => $this->input->post('institution', true),
			'major' => $this->input->post('major', true),
			'date_in' => $this->input->post('year_in', true),
			'date_out' => $this->input->post('year_out', true),
			'grade_score' => $this->input->post('grade_score', true)
			);
		
		$update_edu = $this->Common->update_data_on_table('user_education_experiences', 'id', $this->input->post('id'), $data);
		$this->push_if_transaction_error($update_edu);

		$this->load->library('upload');
		$config = array(
			'upload_path' => './assets/uploads/',
			'allowed_types' => 'jpg|png|jpeg',
			'overwrite' => false,
			'remove_spaces' => true,
			'max_size' => '2000'
		);
		
		if (!empty($_FILES['certificate']['name'])){	
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('certificate')){
				array_push($this->any_error, 'Error on set primary image: '.$this->upload->display_errors());
			} 
			else{
				$upload_data = $this->upload->data();
				//insert document data in database
				$data = array(
					'file_name' => $upload_data['file_name'],
					'file_type' => $upload_data['file_type'],
					'file_extension' => $upload_data['file_ext'],
					'img_width' => $upload_data['image_width'],
					'img_height' => $upload_data['image_height'],
				);

				$add_media = $this->Common->add_to_table('media_files', $data); // return the last inserted id
				$this->push_if_transaction_error($add_media);
				// mapping post and media
				$map = array('certificate_media_id' => $add_media->output);
				$mapping_media = $this->Common->update_data_on_table('user_education_experiences', 'id', $this->input->post('id'), $map);
				$this->push_if_transaction_error($mapping_media);
	        }
		}

		if (!empty($_FILES['transcript']['name'])){	
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('transcript')){
				array_push($this->any_error, 'Error on set primary image: '.$this->upload->display_errors());
			} 
			else{
				$upload_data = $this->upload->data();
				//insert document data in database
				$data = array(
					'file_name' => $upload_data['file_name'],
					'file_type' => $upload_data['file_type'],
					'file_extension' => $upload_data['file_ext'],
					'img_width' => $upload_data['image_width'],
					'img_height' => $upload_data['image_height'],
				);

				$add_media = $this->Common->add_to_table('media_files', $data); // return the last inserted id
				$this->push_if_transaction_error($add_media);
				// mapping post and media
				$map = array('transcript_media_id' => $add_media->output);
				$mapping_media = $this->Common->update_data_on_table('user_education_experiences', 'id', $this->input->post('id'), $map);
				$this->push_if_transaction_error($mapping_media);
	        }
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		}
		else
		{
	        $this->db->trans_commit();
	    }
	    $this->set_session_response_no_redirect_by_error('update');

		redirect('users/edit_profile');
	}

	function remove_education_history($id){
		$delete = $this->Common->delete_from_table_by_id('user_education_experiences', 'id', $id);
		$this->set_session_response_no_redirect('delete', $delete);
		redirect('users/edit_profile');
	}

	function search_user_autocomplete(){
		$suggestions = $this->User_m->search_user_autocomplete($this->input->get('term', true));

		$response = array();
		if($suggestions->num_rows() > 0)
			foreach($suggestions->result() as $suggest){
				$response[] = array(
					'value' => ucwords($suggest->user_level).': ID '.$suggest->user_id.' | '.$suggest->first_name.' '.$suggest->last_name,
					'id' => $suggest->user_id
					);
			}

		echo json_encode($response);
	}

	function tutor_search(){
		$suggestions = $this->User_m->search_tutor($this->input->get('term', true));

		$response = array();
		if($suggestions->num_rows() > 0)
			foreach($suggestions->result() as $suggest){
				$response[] = array(
					'value' => $suggest->user_id.' | '.$suggest->first_name.' '.$suggest->last_name.' | '.$suggest->email_login,
					'id' => $suggest->user_id
					);
			}

		echo json_encode($response);
	}

	function subscribe(){
		$data = array(
			'email' => $this->input->post('email', true),
			'related_user' => $this->session->userdata('userid')
			);

		$add = $this->Common->add_to_table('newsletter_subscriber', $data);

		$response = array('status' => '200');

		echo json_encode($response);
	}

	function add_admin(){
		//check captcha
		$row = $this->check_captcha();
		if ($row->count == 0)
		{
			$response['status'] = '204';
			$response['message'] = $this->lang->line('error_characters_correctly');
		}
		else{
			$this->load->helper(array('form'));
			$this->load->library('form_validation');

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('pass', 'Password', 'required');
			$this->form_validation->set_rules('pass_re', 'Password Verification', 'required|matches[pass]');
			$this->form_validation->set_rules('fn', 'First Name', 'required');
			$this->form_validation->set_rules('level', 'Level', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				$response['status'] = '204';
				$response['message'] = validation_errors();
			}
			else
			{
				$check_exist_email = $this->User_m->check_exist_user($this->input->post('email', TRUE));
				if($check_exist_email<>false)
					$response = array(
						'status' => '204',
						'message' => $this->lang->line('error_email_exist')
						);
				else{
					$check_exist_user = true;
					$data = array(
						'email_login' => $this->input->post('email', TRUE),
						'password' => md5($this->input->post('pass', TRUE)),
						'first_name' => $this->input->post('fn', TRUE),
						'last_name' => $this->input->post('ln', TRUE),
						'user_level' => $this->input->post('level', TRUE)
						);
					// get user identifier for province and city
					$this->load->helper('myfunction_helper');
					while ($check_exist_user==true){
						$random_letter = generate_random_string('letter', 5);
						$random_number = generate_random_string('number', 5);
						$new_user_id = $random_letter.$random_number;
						if(!$this->User_m->check_user_id_exist($new_user_id))
							$check_exist_user=false;
					}
					$data['user_id'] = $new_user_id;

					$create = $this->Common->add_to_table('users', $data);

					$response['status'] = '200';

					// send email to new member
					$content = array(
						'first_name' => $data['first_name'],
						'last_name' => $data['last_name'],
						'level' => $data['user_level'],
						'email_login' => $data['email_login'],
						'user_id' => $data['user_id']
					);

					// send email to customer
					$this->load->library('My_PHPMailer');
			        $mail = new PHPMailer();
			        $mail->IsSMTP(); // we are going to use SMTP
			        $mail->SMTPAuth   = true; // enabled SMTP authentication
			        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
			        $mail->Host       = $this->config->item('smtp_host');      // setting GMail as our SMTP server
			        $mail->Port       = $this->config->item('smtp_port');                   // SMTP port to connect to GMail
			        $mail->Username   = $this->config->item('smtp_user');  // user email address
			        $mail->Password   = $this->config->item('smtp_pass');            // password in GMail
			        $mail->SetFrom('admin@tutordoors.com', 'Admin Tutordoors');  //Who is sending the email
			        $mail->Subject    = $this->lang->line('welcome_in_tutordoors');

			        $mail->Body      = $this->load->view('email_tpl/new_member_'.$this->session->userdata('language'), $content, true);
			        $mail->AltBody    = "Plain text message";
			        $destino = $this->session->userdata('email'); // Who is addressed the email to
			        $mail->AddAddress($destino, $this->session->userdata('fn'));

			        if(!$mail->Send()) {
			        	$this->logging->insert_event_logging('send_email_new_member', '', 'false', $mail->ErrorInfo);
			        } else {
			            $this->logging->insert_event_logging('send_email_new_member', '', 'true', 'Message sent');
			        }
				}
			}			
		}

		echo json_encode($response);
	}

	function update_admin(){
		$userid = $this->input->post('user_id');
		//check captcha
		$row = $this->check_captcha();
		if ($row->count == 0)
		{
			$this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->lang->line('error_characters_correctly'));
			redirect('users/edit_user?id='.$userid);
		}
		else{
	
			$data = array(
				'email_login' => $this->input->post('email', TRUE),
				'first_name' => $this->input->post('fn', TRUE),
				'last_name' => $this->input->post('ln', TRUE),
				'user_level' => $this->input->post('level', TRUE)
				);

			$update = $this->Common->update_data_on_table('users', 'user_id', $userid, $data);
			$this->set_session_response_no_redirect('update', $update);

			$response['status'] = '200';
			echo json_encode($response);
		}
	}

	function export($what)
	{
		//load the excel library
		$this->load->library('excel');
		$this->load->helper('excel_helper');
		// styling
		$style_top_header = set_top_header();
		$alignment = set_alignment();

		if($what=="all")
		{
			$data = $this->User_m->get_user_data();
			$header = array(
				'USER ID', 'USER LEVEL', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'IS VERIFIED', 'TARIFF PER 1.5 HOURS', 'SCHOOL', 'GENDER', 'BIRTH PLACE', 'BIRTH DATE', 'PRIMARY PHONE', 'SECONDARY PHONE', 'PROVINCE', 'CITY', 'ID CARD', 'ADDRESS ON ID CARD', 'DOMICILE ADDRESS', 'ABOUT ME', 'TEACH EXPERIENCE', 'CERTIFICATION', 'SKILL', 'ACHIEVEMENT', 'TOEFL SCORE', 'HOBBY'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('All users');

	        $this->excel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($alignment);

			// filling the header
			$col = 0; // starting at A1
			$row = 1;
			foreach($header as $head){
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $head);
				$col++;
			}
			// filling the content
			$col = 0; // starting at A2
			$row = 2;
			foreach($data->result() as $user)
			{
				// get user info
				$user_info = $this->User_m->get_user_info_data($user->user_id);
				if($user_info<>false)
					if($user_info->city_id<>"")
					{
						// get city
						$get_city_info = $this->Location_m->get_city(array('city_id' => $user_info->city_id));
						$city_info = $get_city_info->row();
					}

				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $user->user_id, PHPExcel_Cell_DataType::TYPE_STRING); // A2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, ucwords($user->user_level)); // B2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $user->email_login); // C2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $user->first_name); // D2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $user->last_name); // E2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, date_format(new DateTime($user->join_date), 'd M Y H:i')); // F2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, ($user->verified_user=="0" ? 'NOT VERIFIED' : 'VERIFIED')); // G2
				if($user_info<>false)
				{
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, 'IDR '.number_format($user_info->salary_per_hour, 0, ',', '.')); // H2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $user_info->where_student_school); // I2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, ucwords($user_info->sex)); // J2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $user_info->birth_place); // K2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, date_format(new DateTime($user_info->birth_date), 'd M Y')); // L2
					// set the phone as a text
					$this->excel->getActiveSheet()->setCellValueExplicit('M'.$row, $user_info->phone_1, PHPExcel_Cell_DataType::TYPE_STRING); // M2
					$this->excel->getActiveSheet()->setCellValueExplicit('N'.$row, $user_info->phone_2, PHPExcel_Cell_DataType::TYPE_STRING); // N2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, (isset($city_info) ? $city_info->province_name : '')); // O2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, (isset($city_info) ? $city_info->city_name : '')); // P2
					$this->excel->getActiveSheet()->setCellValueExplicit('Q'.$row, $user_info->national_card_number, PHPExcel_Cell_DataType::TYPE_STRING); // Q2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $user_info->address_national_card); // R2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $user_info->address_domicile); // S1
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $user_info->about_me); // U2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $user_info->teach_experience); // V2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $user_info->certification); // W2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $user_info->skill); // X2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(23, $row, $user_info->achievement); // Y2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $user_info->toefl_score); // Z2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(25, $row, $user_info->hobby); // AA2
				}

				$row++;
			}

			// set auto width
			foreach(range('A','AA') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='All Tutordoors Users.xls'; //save our workbook as this file name

		}
		else if($what=="tutor")
		{
			$data = $this->User_m->get_user_by_level('teacher');
			$header = array(
				'USER ID', 'USER LEVEL', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'IS VERIFIED', 'TARIFF PER 1.5 HOURS', 'GENDER', 'BIRTH PLACE', 'BIRTH DATE', 'PRIMARY PHONE', 'SECONDARY PHONE', 'PROVINCE', 'CITY', 'ID CARD', 'ADDRESS ON ID CARD', 'DOMICILE ADDRESS', 'ABOUT ME', 'TEACH EXPERIENCE', 'CERTIFICATION', 'SKILL', 'ACHIEVEMENT', 'TOEFL SCORE', 'HOBBY'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('All Tutors');

	        $this->excel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($alignment);

			// filling the header
			$col = 0; // starting at A1
			$row = 1;
			foreach($header as $head){
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $head);
				$col++;
			}
			// filling the content
			$col = 0; // starting at A2
			$row = 2;
			foreach($data->result() as $user)
			{
				// get user info
				$user_info = $this->User_m->get_user_info_data($user->user_id);
				if($user_info<>false)
					if($user_info->city_id<>"")
					{
						// get city
						$get_city_info = $this->Location_m->get_city(array('city_id' => $user_info->city_id));
						$city_info = $get_city_info->row();
					}

				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $user->user_id, PHPExcel_Cell_DataType::TYPE_STRING); // A2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, ucwords($user->user_level)); // B2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $user->email_login); // C2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $user->first_name); // D2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $user->last_name); // E2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, date_format(new DateTime($user->join_date), 'd M Y H:i')); // F2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, ($user->verified_user=="0" ? 'NOT VERIFIED' : 'VERIFIED')); // G2
				if($user_info<>false)
				{
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, 'IDR '.number_format($user_info->salary_per_hour, 0, ',', '.')); // H2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, ucwords($user_info->sex)); // I2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $user_info->birth_place); // J2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, date_format(new DateTime($user_info->birth_date), 'd M Y')); // K2
					// set the phone as a text
					$this->excel->getActiveSheet()->setCellValueExplicit('L'.$row, $user_info->phone_1, PHPExcel_Cell_DataType::TYPE_STRING); // L2
					$this->excel->getActiveSheet()->setCellValueExplicit('M'.$row, $user_info->phone_2, PHPExcel_Cell_DataType::TYPE_STRING); // M2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, (isset($city_info) ? $city_info->province_name : '')); // N2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, (isset($city_info) ? $city_info->city_name : '')); // O2
					$this->excel->getActiveSheet()->setCellValueExplicit('P'.$row, $user_info->national_card_number, PHPExcel_Cell_DataType::TYPE_STRING); // P2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $user_info->address_national_card); // Q2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $user_info->address_domicile); // R2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $user_info->about_me); // T2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $user_info->teach_experience); // U2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $user_info->certification); // V2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $user_info->skill); // W2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $user_info->achievement); // X2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(23, $row, $user_info->toefl_score); // Y2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $user_info->hobby); // Z2
				}

				$row++;
			}

			// set auto width
			foreach(range('A','Z') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Unverified Student List.xls'; //save our workbook as this file name

		}
		else if($what=="student")
		{
			$data = $this->User_m->get_user_by_level('student');
			$header = array(
				'USER ID', 'USER LEVEL', 'EMAIL', 'FIRST NAME', 'LAST NAME', 'JOIN DATE', 'IS VERIFIED', 'SCHOOL', 'GENDER', 'BIRTH PLACE', 'BIRTH DATE', 'PRIMARY PHONE', 'SECONDARY PHONE', 'PROVINCE', 'CITY', 'ID CARD', 'ADDRESS ON ID CARD', 'DOMICILE ADDRESS', 'ABOUT ME', 'TOEFL SCORE', 'HOBBY'
				);
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('All students');

	        $this->excel->getActiveSheet()->getStyle('A1:U1')->applyFromArray($style_top_header);
			$this->excel->getActiveSheet()->getStyle('A1:U1')->applyFromArray($alignment);

			// filling the header
			$col = 0; // starting at A1
			$row = 1;
			foreach($header as $head){
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $head);
				$col++;
			}
			// filling the content
			$col = 0; // starting at A2
			$row = 2;
			foreach($data->result() as $user)
			{
				// get user info
				$user_info = $this->User_m->get_user_info_data($user->user_id);
				if($user_info<>false)
					if($user_info->city_id<>"")
					{
						// get city
						$get_city_info = $this->Location_m->get_city(array('city_id' => $user_info->city_id));
						$city_info = $get_city_info->row();
					}

				// set the user_id as a text
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $user->user_id, PHPExcel_Cell_DataType::TYPE_STRING); // A2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, ucwords($user->user_level)); // B2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $user->email_login); // C2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $user->first_name); // D2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $user->last_name); // E2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, date_format(new DateTime($user->join_date), 'd M Y H:i')); // F2
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, ($user->verified_user=="0" ? 'NOT VERIFIED' : 'VERIFIED')); // G2
				if($user_info<>false)
				{
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $user_info->where_student_school); // H2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, ucwords($user_info->sex)); // I2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $user_info->birth_place); // J2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, date_format(new DateTime($user_info->birth_date), 'd M Y')); // K2
					// set the phone as a text
					$this->excel->getActiveSheet()->setCellValueExplicit('L'.$row, $user_info->phone_1, PHPExcel_Cell_DataType::TYPE_STRING); // L2
					$this->excel->getActiveSheet()->setCellValueExplicit('M'.$row, $user_info->phone_2, PHPExcel_Cell_DataType::TYPE_STRING); // M2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, (isset($city_info) ? $city_info->province_name : '')); // N2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, (isset($city_info) ? $city_info->city_name : '')); // O2
					$this->excel->getActiveSheet()->setCellValueExplicit('P'.$row, $user_info->national_card_number, PHPExcel_Cell_DataType::TYPE_STRING); // P2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $user_info->address_national_card); // Q2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $user_info->address_domicile); // R2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $user_info->about_me); // S2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $user_info->toefl_score); // T2
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(25, $row, $user_info->hobby); // U2
				}

				$row++;
			}

			// set auto width
			foreach(range('A','U') as $columnID) {
			    $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
	 
	        $filename='Unverified Student List.xls'; //save our workbook as this file name

		}

		header('Content-Type: application/vnd.ms-excel'); //mime type
	 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}

	function get_edu_by_id($id){
		$get = $this->User_m->get_education_history_by_id($id);
		$response = array();
		if($get<>false)
			$response = array(
				'degree' => $get->degree,
				'major' => $get->major,
				'institution' => $get->institution,
				'grade' => $get->grade_score,
				'year_in' => $get->date_in,
				'year_out' => $get->date_out
				);

		echo json_encode($response);
	}

	function google_login(){
		// Include two files from google-php-client library in controller
		require_once APPPATH . "libraries/google-api-php-client-2.1.0/vendor/autoload.php";
		$this->config->load('google');

		$client_id = $this->config->item('client_id');
		$client_secret = $this->config->item('client_secret');
		$redirect_uri = $this->config->item('redirect_uri');
		$simple_api_key = $this->config->item('api_key');
		
		// Create Client Request to access Google API
		$client = new Google_Client();
		$client->setApplicationName("PHP Google OAuth Login Example");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setDeveloperKey($simple_api_key);
		$client->addScope("https://www.googleapis.com/auth/userinfo.email");
		
		// Send Client Request
		$objOAuthService = new Google_Service_Oauth2($client);
		// print_r($objOAuthService);

		// Add Access Token to Session
		if (isset($_GET['code'])) {
		$client->authenticate($_GET['code']);
		$_SESSION['access_token'] = $client->getAccessToken();
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}

		// Set Access Token to make Request
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
		$client->setAccessToken($_SESSION['access_token']);
		}

		// Get User Data from Google and store them in $data
		if ($client->getAccessToken()) {
		$userData = $objOAuthService->userinfo->get();
		$data['userData'] = $userData;
		$_SESSION['access_token'] = $client->getAccessToken();
		} else {
		$authUrl = $client->createAuthUrl();
		$data['authUrl'] = $authUrl;
		}

		$this->load->view('test', $data);

		// print_r($data);
	}

	public function wizard_user_add(){
		// 1. form validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('fn', $this->lang->line('first_name'), 'required');
		$this->form_validation->set_rules('province', $this->lang->line('province'), 'required');
		$this->form_validation->set_rules('city', $this->lang->line('city'), 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = '204';
			$validation_message = validation_errors();
			$validation_message = str_replace('<p>', '', $validation_message);
			$validation_message = str_replace('</p>', '', $validation_message);
			$response['message'] = $validation_message;
			$response['pos'] = 'validasi';
			$response['email'] = $this->input->post('email');
			$response['post'] = $this->input->get();
		}
		else
		{
			// 2. check exist user by email
			$check_exist_email = $this->User_m->check_exist_user($this->input->post('email', TRUE));
			// 2.1 if email exist
			if($check_exist_email<>false)
				$response = array(
					'status' => '204',
					'message' => $this->lang->line('error_email_exist'),
					'pos' => 'check email'
					);
			// 2.2 if email not exist
			else{
				// 3. adding user 
				$check_exist_user = true;
				$data = array(
					'email_login' => $this->input->post('email', TRUE),
					'first_name' => $this->input->post('fn', TRUE),
					'last_name' => $this->input->post('ln', TRUE),
					'user_level' => $this->input->post('level', TRUE)
					);
				$province_input = $this->input->post('province');
				$city_input = $this->input->post('city');
				// 3.1 check if province and city is numberic. if it is, then get the id
				if(!is_numeric($province_input)){
					$province_info = $this->Location_m->get_province(array('province_name' => $province_input));
					$province_id = $province_info->row()->province_id;
				}
				else
					$province_id = $province_input;

				if(!is_numeric($city_input)){
					$city_info = $this->Location_m->get_city(array('city_name' => $city_input));
					$city_id = $city_info->row()->city_id;
				}
				else
					$city_id = $city_input;
				// 3.2 get user identifier for province and city
				$prov_uid = $this->Location_m->get_user_identifier('province', $province_id);
				$city_uid = $this->Location_m->get_user_identifier('city', $city_id);
				$location_uid = $prov_uid.$city_uid;

				$this->load->helper('myfunction_helper');
				// 3.3 looping check exist user ID with the new user ID generated by location_uid + random number
				while ($check_exist_user==true){
					$random_number = generate_random_string('number', 5);
					$new_user_id = $location_uid.$random_number;
					if(!$this->User_m->check_user_id_exist($new_user_id))
						$check_exist_user=false;
				}
				$data['user_id'] = $new_user_id;

				$create = $this->Common->add_to_table('users', $data);
				// create data in opened city course - start
				$data = array(
					'user_id' => $new_user_id,
					'city_id' => $city_id,
					'verified' => '1'
					);
				
				$add_city = $this->Common->add_to_table('teacher_open_course_cities', $data);
				if($create->status){
					if($this->session->userdata('logged')==""){
						$this->session->set_userdata('logged', 'in');
						$this->session->set_userdata('userid', $new_user_id);
						$this->session->set_userdata('email', $this->input->post('email', TRUE));
						$this->session->set_userdata('fn', $this->input->post('fn', TRUE));
						$this->session->set_userdata('ln', $this->input->post('ln', TRUE));
						$this->session->set_userdata('level', $this->input->post('level', TRUE));						
					}

					$response['status'] = '200';
					$response['user_id'] = $new_user_id;

					// get email template from database
			        $get_template = $this->Content_m->get_email_templates(array('id' => 'post-registration-'.$this->session->userdata('language')));
			        $template = htmlspecialchars_decode($get_template->row()->content);
			        
			        // prepare data to replace 
			        $content = $template;
			        $content = str_replace('[FULL_NAME]', $this->session->userdata('fn').($this->session->userdata('ln')=="" ? "":$this->session->userdata('ln')), $content);
			        $content = str_replace('[FIRST_NAME]', $this->session->userdata('fn'), $content);
			        $content = str_replace('[LAST_NAME]', $this->session->userdata('ln'), $content);
			        $content = str_replace('[EMAIL]', $this->session->userdata('email'), $content);
			        $content = str_replace('[USER_ID]', $this->session->userdata('userid'), $content);
			        $get_email_cs = $this->Content_m->get_option_by_param('company_email_customer_service');
			        $content = str_replace('[EMAIL_CS]', $get_email_cs->parameter_value, $content);
			        $get_phone_office = $this->Content_m->get_option_by_param('company_phone');
			        $content = str_replace('[PHONE_OFFICE]', $get_phone_office->parameter_value, $content);
			        $get_address_office = $this->Content_m->get_option_by_param('company_address');
			        $content = str_replace('[ADDRESS_OFFICE]', $get_address_office->parameter_value, $content);

					// send email to customer
					$this->load->library('My_PHPMailer');
			        $mail = new PHPMailer();
			        $mail->IsSMTP(); // we are going to use SMTP
			        $mail->SMTPAuth   = true; // enabled SMTP authentication
			        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
			        $mail->Host       = $this->config->item('smtp_host');      // setting GMail as our SMTP server
			        $mail->Port       = $this->config->item('smtp_port');                   // SMTP port to connect to GMail
			        $mail->Username   = $this->config->item('smtp_user');  // user email address
			        $mail->Password   = $this->config->item('smtp_pass');            // password in GMail
			        $mail->SetFrom('admin@tutordoors.com', 'Admin Tutordoors');  //Who is sending the email
			        $mail->Subject    = $this->lang->line('welcome_in_tutordoors');

			        $mail->Body      = $content;
			        $mail->AltBody    = "Plain text message";
			        $destino = $this->session->userdata('email'); // Who is addressed the email to
			        $mail->AddAddress($destino, $this->session->userdata('fn'));

			        if(!$mail->Send()) {
			        	$this->logging->insert_event_logging('send_email_new_member', '', 'false', $mail->ErrorInfo);
			        } else {
			            $this->logging->insert_event_logging('send_email_new_member', '', 'true', 'Message sent');
			        }

			        // create online test assignment if any AND if level is tutor
			        if($this->session->userdata('level')=="teacher"){
			        	$this->load->model('Otest_m', 'otest');
			        	$this->load->library('notification');
				        $auto_assignment = $this->otest->get_test_data(array('is_active'=>'1', 'assign_to_new_tutor'=>'1'));
				        if($auto_assignment<>false){
				        	$get_max_retry = $this->Content_m->get_option_by_param('max_retry');
				        	foreach($auto_assignment->result() as $test){
				        		$data = array(
									'test_id' => $test->test_id,
									'teacher_id' => $new_user_id
									);
								
								$result_insert = false;

								// 1.2 generate ID and check if duplicate
								while($result_insert==false){
									$new_id = 'TA'.generate_random_string('number', 5);
									
									$data['assignment_id'] = $new_id;
									$insert = $this->otest->insert_new_assignment($data);
									if($insert)
										$result_insert = true;
									else
										$result_insert = false;
								}

								$assignment_id = $new_id;

								// give notification to tutor 
						        $notif = array(
						        	'category' => 'new_test_assignment',
						        	'title' => 'Online Test Assignment',
						        	'content' => $this->lang->line('notification_new_test_assignment_create').' ID Assignment = '.$assignment_id,
						        	'sender_id' => 'admin', // admin
						        	'receiver_id' => $new_user_id // tutor ID
						        	);
						        $this->notification->insert($notif);
				        	}
				        }
			        }
				}
				else{
					$response['status'] = '204';
					$response['message'] = $create->output;
					$response['pos'] = 'create user';
				}
			}
		}
		echo json_encode($response);
	}

	function wizard_add_personal_info(){
		// 1. validate form
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user-id-personal-data', 'User ID', 'required');
		$this->form_validation->set_rules('ktp', $this->lang->line('national_id_number'), 'required|numeric');
		$this->form_validation->set_rules('sex', $this->lang->line('sex'), 'required');
		$this->form_validation->set_rules('birth-place', $this->lang->line('birth_place'), 'required');
		$this->form_validation->set_rules('birth-date', $this->lang->line('birth_date'), 'required');
		$this->form_validation->set_rules('religion', $this->lang->line('religion'), 'required');
		$this->form_validation->set_rules('where_student_school', $this->lang->line('where_student_school'), 'required');
		$this->form_validation->set_rules('address-ktp', $this->lang->line('address_on_national_card'), 'required');
		$this->form_validation->set_rules('phone-1', $this->lang->line('phone'), 'required');
		$this->form_validation->set_rules('about-me', $this->lang->line('about_me'), 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = '204';
			$validation_message = validation_errors();
			$validation_message = str_replace('<p>', '', $validation_message);
			$validation_message = str_replace('</p>', '', $validation_message);
			$response['message'] = $validation_message;
		}
		else
		{
			// 2. update personal data
			$personal_data = array(
				'user_id' => $this->input->post('user-id-personal-data', TRUE),
				'national_card_number' => $this->input->post('ktp', TRUE),
				'sex' => $this->input->post('sex', TRUE),
				'birth_place' => $this->input->post('birth-place', TRUE),
				'birth_date' => $this->input->post('birth-date', TRUE),
				'address_national_card' => $this->input->post('address-ktp', TRUE),
				'address_domicile' => $this->input->post('address-domicile', TRUE),
				'photo_primary_id' => $this->input->post('user_photo_id', TRUE),
				'phone_1' => $this->input->post('phone-1', TRUE),
				'phone_2' => $this->input->post('phone-2', TRUE),
				'about_me' => $this->input->post('about-me', TRUE),
				'teach_experience' => $this->input->post('teach-experience', TRUE),
				'toefl_score' => $this->input->post('toefl', TRUE),
				'toefl_certificate_file_id' => $this->input->post('toefl-file-id', TRUE),
				'skill' => $this->input->post('skill', TRUE),
				'hobby' => $this->input->post('hobby', TRUE),
				'religion' => $this->input->post('religion', TRUE)
				);

			
			$add_info = $this->Common->add_to_table('user_info_data', $personal_data);
			if($add_info->status)
				$response = array('status'=>'200');
			else
				$response = array('status'=>'204', 'message'=>$add_info->output);
		}

		echo json_encode($response);
	}

	function wizard_add_student_personal_info(){
		// 1. validate form
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user-id-personal-data', 'User ID', 'required');
		$this->form_validation->set_rules('sex', $this->lang->line('sex'), 'required');
		$this->form_validation->set_rules('birth-place', $this->lang->line('birth_place'), 'required');
		$this->form_validation->set_rules('birth-date', $this->lang->line('birth_date'), 'required');
		$this->form_validation->set_rules('religion', $this->lang->line('religion'), 'required');
		$this->form_validation->set_rules('where_student_school', $this->lang->line('where_student_school'), 'required');
		$this->form_validation->set_rules('address-ktp', $this->lang->line('address_on_national_card'), 'required');
		$this->form_validation->set_rules('phone-1', $this->lang->line('phone'), 'required');
		$this->form_validation->set_rules('about-me', $this->lang->line('about_me'), 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = '204';
			$validation_message = validation_errors();
			$validation_message = str_replace('<p>', '', $validation_message);
			$validation_message = str_replace('</p>', '', $validation_message);
			$response['message'] = $validation_message;
		}
		else
		{
			// 2. update personal data
			$personal_data = array(
				'user_id' => $this->input->post('user-id-personal-data', TRUE),
				'sex' => $this->input->post('sex', TRUE),
				'birth_place' => $this->input->post('birth-place', TRUE),
				'birth_date' => $this->input->post('birth-date', TRUE),
				'where_student_school' => $this->input->post('where_student_school', TRUE),
				'address_national_card' => $this->input->post('address-ktp', TRUE),
				'photo_primary_id' => $this->input->post('user_photo_id', TRUE),
				'phone_1' => $this->input->post('phone-1', TRUE),
				'phone_2' => $this->input->post('phone-2', TRUE),
				'about_me' => $this->input->post('about-me', TRUE),
				'hobby' => $this->input->post('hobby', TRUE),
				'religion' => $this->input->post('religion', TRUE)
				);

			
			$add_info = $this->Common->add_to_table('user_info_data', $personal_data);
			if($add_info->status)
				$response = array('status'=>'200');
			else
				$response = array('status'=>'204', 'message'=>$add_info->output);
		}

		echo json_encode($response);
	}

	function wizard_add_education(){
		// 1. validate form
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user-id-education-data', 'User ID', 'required');
		$this->form_validation->set_rules('degree', $this->lang->line('education'), 'required');
		$this->form_validation->set_rules('institution', $this->lang->line('university'), 'required');
		$this->form_validation->set_rules('major', $this->lang->line('major'), 'required');
		$this->form_validation->set_rules('grade_score', $this->lang->line('grade_score'), 'required|decimal');
		$this->form_validation->set_rules('year_in', $this->lang->line('college_year_in'), 'required|numeric');
		$this->form_validation->set_rules('year_out', $this->lang->line('college_year_out'), 'required|numeric');

		if ($this->form_validation->run() == FALSE)
		{
			$response['status'] = '204';
			$validation_message = validation_errors();
			$validation_message = str_replace('<p>', '', $validation_message);
			$validation_message = str_replace('</p>', '', $validation_message);
			$response['message'] = $validation_message;
		}
		else
		{
			// 2. add education data
			$data = array(
				'user_id' => $this->input->post('user-id-education-data', true),
				'degree' => $this->input->post('degree', true),
				'institution' => $this->input->post('institution', true),
				'major' => $this->input->post('major', true),
				'date_in' => $this->input->post('year_in', true),
				'date_out' => $this->input->post('year_out', true),
				'grade_score' => $this->input->post('grade_score', true),
				'certificate_media_id' => $this->input->post('ijasah-file-id', true),
				'transcript_media_id' => $this->input->post('transkrip-file-id', true)
				);
			
			$add_edu = $this->Common->add_to_table('user_education_experiences', $data);

			if($add_edu->status)
				$response = array('status'=>'200');
			else
				$response = array('status'=>'204', 'message'=>$add_edu->output);
		}

		echo json_encode($response);
	}

	public function check_exist_email(){
		$user_info = $this->User_m->check_exist_user($this->input->get('e', TRUE));
		if($user_info==false)
			$response = array(
				'status' => '204',
				'message' => 'Email not found'
				);
		else
			$response = array(
				'status' => '200',
				'user_id' => $user_info->user_id,
				'first_name' => $user_info->first_name,
				'last_name' => $user_info->last_name,
				'full_name' => $user_info->first_name.' '.$user_info->last_name,
				'role' => $user_info->user_level
				);
		echo json_encode($response);
	}
}
