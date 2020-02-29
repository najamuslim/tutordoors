<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->library('oauth2/OAuth2');
	}

    public function social_media($provider, $user_level=null)
    {
        $this->load->helper('url_helper');

        $this->config->load($provider);

        // $this->load->spark('oauth2/0.3.1');

        $provider = $this->oauth2->provider($provider, array(
            'id' => $this->config->item('client_id'),
            'secret' => $this->config->item('client_secret')
        ));

        if ( ! $this->input->get('code'))
        {
            // By sending no options it'll come back here
            $provider->authorize();
        }
        else
        {
            // Howzit?
            try
            {
                $token = $provider->access($_GET['code']);

                $user = $provider->get_user_info($token);

                // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
                // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
                // echo "<pre>Tokens: ";
                // var_dump($token);

                // echo "\n\nUser Info: ";
                // var_dump($user);

                $data['logged_user'] = $user;

                // check if it's existing user
				$check_exist = $this->User_m->check_user_email_exist($user['email']);
				if($check_exist){
					// get user data
					$user_data = $this->User_m->get_user_data(array('email_login' => $user['email']));
					$this->session->set_userdata('logged', 'in');
					$this->session->set_userdata('userid', $user_data->row()->user_id);
					$this->session->set_userdata('email', $user_data->row()->email_login);
					$this->session->set_userdata('fn', $user_data->row()->first_name);
					$this->session->set_userdata('ln', $user_data->row()->last_name);
					$this->session->set_userdata('level', $user_data->row()->user_level);
					
					if($user_level==null)
						redirect('my_account');
					else
						redirect('users/edit_profile');
				}
				else {
					if($user_level==null)
						$this->show_error_page('204', $this->lang->line('please_register_using_signup_menu'));
					else{
						$this->user_add($user, $user_level);
						redirect('users/edit_profile');
						// $data['captcha'] = $this->generate_captcha();
						// $data['page_title'] = 'Sign Up!';
						// // get provinces
						// $data['provinces'] = $this->Location_m->get_province();
						// // get root course category
						// $data['programs'] = $this->Content_m->get_root_category('course');

						// $data['image_user_id'] = '';
						// $data['image_user_filename'] = '';
						// // store the image
						// if($user['image'] <> ""){
						// 	// print_r($user['image']);
						// 	$image_file_info = $user['image'];
						// 	// $file_info = pathinfo($image_file_info);
						// 	// print_r($file_info);
						// 	$new_file_name = $user['uid'].'_'.uniqid().'.jpg';
						// 	$file_path = $_SERVER['DOCUMENT_ROOT']."/dev20/assets/uploads/".$new_file_name;
						// 	//Get the file
						// 	$content = file_get_contents($image_file_info);
						// 	// print_r($content);
						// 	//Store in the filesystem.
						// 	$fp = fopen($file_path, "w");
						// 	fwrite($fp, $content);
						// 	fclose($fp);

						// 	$file_info = pathinfo($file_path);

						// 	$upload_data = array(
						// 		'file_name' => $new_file_name,
						// 		'file_type' => 'image/jpeg',
						// 		'file_extension' => '.'.$file_info['extension'],
						// 		'img_width' => '0',
						// 		'img_height' => '0',
						// 		'file_size' => '0',
						// 		'is_image' => '1'
						// 	);

						// 	$add_media = $this->Common->add_to_table('media_files', $upload_data);
						// 	$data['image_user_id'] = $add_media->output;
						// 	$data['image_user_filename'] = $new_file_name;
						// }

						// $this->open_page('user/wizard_'.$user_level.'_registration', $data);
					}
				}
            }

            catch (OAuth2_Exception $e)
            {
            	$this->show_error_page('700', $e);
                // show_error('That didnt work: '.$e);
            }

        }
    }

    function generate_captcha(){
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
		$captcha = $cap['image'];

		return $captcha;
	}

	function user_add($user_info, $user_level){
		if($user_level=="tutor")
			$user_level = "teacher";

		$check_exist_user = true;
		$verification_key = generate_random_string('letter', 13).generate_random_string('number', 10).generate_random_string('letter', 7).uniqid();
		$data = array(
			'email_login' => $user_info['email'],
			'first_name' => $user_info['first_name'],
			'last_name' => $user_info['last_name'],
			'user_level' => $user_level,
			'register_source' => 'web',
			'verification_key' => $verification_key
			);

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
		
		if($create->status){
			if($this->session->userdata('logged')==""){
				$this->session->set_userdata('logged', 'in');
				$this->session->set_userdata('userid', $new_user_id);
				$this->session->set_userdata('email', $user_info['email']);
				$this->session->set_userdata('fn', $user_info['first_name']);
				$this->session->set_userdata('ln', $user_info['last_name']);
				$this->session->set_userdata('level', $user_level);
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
}