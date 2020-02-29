<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailbox extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Mailbox_m');
        $this->load->model('Media_m');
	}

	/* Admin page begin */
	function compose($id=null){
		if($this->session->userdata('level')=="admin" or $this->session->userdata('level')=="admin_staff"){
			$this->check_user_access();
			$data = array(
				'active_menu_id' => 'mailbox-compose',
				'title_page' => 'Compose New Message',
				'mode' => ($id==null ? 'create' : 'edit'),
				'box' => 'inbox'
				);
			if($id<>null){
				$mail_info = $this->Mailbox_m->get_mail_by_id($id);
				$data['mail_info'] = $mail_info;
				$data['recipient'] = $this->User_m->get_user_by_id($mail_info->destination);
			}
			$this->open_admin_page('admin/mailbox/compose', $data);
		}
		else{
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'compose';
			$data['gm'] = 'mailbox';
			$data['box'] = 'inbox';
			$data['mode'] = ($id==null ? 'create' : 'edit');
			$data['page_title'] = $this->lang->line('mailbox_compose');
			$data['sub_page_title'] = $this->lang->line('mailbox_compose');

			if($id<>null){
				$mail_info = $this->Mailbox_m->get_mail_by_id($id);
				$data['mail_info'] = $mail_info;
				$data['recipient'] = $this->User_m->get_user_by_id($mail_info->destination);
			}
			$this->open_page('mailbox/compose', $data);
		}
	}

	function inbox(){
		$user_id = $this->session->userdata('userid');
		if($user_id <> ""){
			if($this->session->userdata('level')=="admin" or $this->session->userdata('level')=="admin_staff"){
				$data = array(
					'active_menu_id' => 'mailbox-inbox',
					'title_page' => 'Inbox',
					'box' => 'inbox'
					);
				$data['mails'] = $this->Mailbox_m->get_mail_data($user_id, 'inbox');
				$this->open_admin_page('admin/mailbox/mail_data', $data);
			}
			else{
				$data = $this->get_data_for_profile($user_id);
				$data['am'] = 'mailbox_inbox';
				$data['gm'] = 'mailbox';
				$data['box'] = 'inbox';
				$data['page_title'] = $this->lang->line('mailbox_inbox');
				$data['sub_page_title'] = $this->lang->line('mailbox_inbox');

				$data['mails'] = $this->Mailbox_m->get_mail_data($user_id, 'inbox');
				$this->open_page('mailbox/mail_data', $data);
			}
		}
	}

	function outbox(){
		$user_id = $this->session->userdata('userid');
		if($user_id <> ""){
			if($this->session->userdata('level')=="admin" or $this->session->userdata('level')=="admin_staff"){
				$data = array(
					'active_menu_id' => 'mailbox-outbox',
					'title_page' => 'Outbox',
					'box' => 'outbox'
					);
				$data['mails'] = $this->Mailbox_m->get_mail_data($user_id, 'outbox');
				$this->open_admin_page('admin/mailbox/mail_data', $data);
			}
			else{
				$data = $this->get_data_for_profile($user_id);
				$data['am'] = 'mailbox_outbox';
				$data['gm'] = 'mailbox';
				$data['box'] = 'outbox';
				$data['page_title'] = $this->lang->line('mailbox_outbox');
				$data['sub_page_title'] = $this->lang->line('mailbox_outbox');

				$data['mails'] = $this->Mailbox_m->get_mail_data($user_id, 'outbox');
				$this->open_page('mailbox/mail_data', $data);
			}
		}
	}

	function draft(){
		$user_id = $this->session->userdata('userid');
		if($user_id <> ""){
			if($this->session->userdata('level')=="admin" or $this->session->userdata('level')=="admin_staff"){
				$data = array(
					'active_menu_id' => 'mailbox-draft',
					'title_page' => 'Draft',
					'box' => 'draft'
					);
				$data['mails'] = $this->Mailbox_m->get_mail_data($user_id, 'draft');
				$this->open_admin_page('admin/mailbox/mail_data', $data);
			}
			else{
				$data = $this->get_data_for_profile($user_id);
				$data['am'] = 'mailbox_draft';
				$data['gm'] = 'mailbox';
				$data['box'] = 'draft';
				$data['page_title'] = $this->lang->line('mailbox_draft');
				$data['sub_page_title'] = $this->lang->line('mailbox_draft');

				$data['mails'] = $this->Mailbox_m->get_mail_data($user_id, 'draft');
				$this->open_page('mailbox/mail_data', $data);
			}
		}
	}

	function trash(){
		$user_id = $this->session->userdata('userid');
		if($user_id <> ""){
			if($this->session->userdata('level')=="admin" or $this->session->userdata('level')=="admin_staff"){
				$data = array(
					'active_menu_id' => 'mailbox-trash',
					'title_page' => 'Trash',
					'box' => 'trash'
					);
				$data['mails'] = $this->Mailbox_m->get_mail_data($user_id, 'trash');
				$this->open_admin_page('admin/mailbox/mail_data', $data);
			}
			else{
				$data = $this->get_data_for_profile($user_id);
				$data['am'] = 'mailbox_trash';
				$data['gm'] = 'mailbox';
				$data['box'] = 'trash';
				$data['page_title'] = $this->lang->line('mailbox_trash');
				$data['sub_page_title'] = $this->lang->line('mailbox_trash');

				$data['mails'] = $this->Mailbox_m->get_mail_data($user_id, 'trash');
				$this->open_page('mailbox/mail_data', $data);
			}
		}
	}

	function view(){
		$id = $this->input->get('mid', true);
		$box = $this->input->get('box', true);
		$user_id = $this->session->userdata('userid');
		if($user_id <> ""){
			if($this->session->userdata('level')=="admin" or $this->session->userdata('level')=="admin_staff"){
				$data = array(
					'active_menu_id' => 'mailbox-'.$box,
					'title_page' => 'View Mail',
					'box' => $box,
					'uri_back' => $this->input->get('uri_back', true)
					);
				$data['mail_content'] = $this->Mailbox_m->get_mail_by_id($id);
				$this->open_admin_page('admin/mailbox/view_mail', $data);
			}
			else{
				$data = $this->get_data_for_profile($user_id);
				$data['am'] = 'mailbox_'.$box;
				$data['gm'] = 'mailbox';
				$data['box'] = $box;
				$data['page_title'] = $this->lang->line('mailbox_content');
				$data['sub_page_title'] = $this->lang->line('mailbox_content');
				$data['uri_back'] = $this->input->get('uri_back', true);

				$data['mail_content'] = $this->Mailbox_m->get_mail_by_id($id);
				$this->open_page('mailbox/view_mail', $data);
			}
		}
	}

	function reply(){
		$id = $this->input->get('mid', true);
		$box = $this->input->get('box', true);

		if($this->session->userdata('level')=="admin" or $this->session->userdata('level')=="admin_staff"){
			$data = array(
				'active_menu_id' => 'mailbox-'.$box,
				'title_page' => 'Reply Message',
				'mode' => 'reply',
				'box' => $box
				);
			if($id<>null){
				$mail_info = $this->Mailbox_m->get_mail_by_id($id);
				$data['mail_info'] = $mail_info;
				$data['recipient'] = $this->User_m->get_user_by_id($mail_info->sender);
			}
			$this->open_admin_page('admin/mailbox/compose', $data);
		}
		else{
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'mailbox_'.$box;
			$data['gm'] = 'mailbox';
			$data['box'] = 'inbox';
			$data['mode'] = 'reply';
			$data['page_title'] = $this->lang->line('mailbox_reply');
			$data['sub_page_title'] = $this->lang->line('mailbox_reply');

			if($id<>null){
				$mail_info = $this->Mailbox_m->get_mail_by_id($id);
				$data['mail_info'] = $mail_info;
				$data['recipient'] = $this->User_m->get_user_by_id($mail_info->sender);
			}
			$this->open_page('mailbox/compose', $data);
		}
	}

	function forward(){
		$id = $this->input->get('mid', true);
		$box = $this->input->get('box', true);

		if($this->session->userdata('level')=="admin" or $this->session->userdata('level')=="admin_staff"){
			$data = array(
				'active_menu_id' => 'mailbox-'.$box,
				'title_page' => 'Forward Message',
				'mode' => 'forward',
				'box' => $box
				);
			if($id<>null){
				$mail_info = $this->Mailbox_m->get_mail_by_id($id);
				$data['mail_info'] = $mail_info;
				$data['recipient'] = $this->User_m->get_user_by_id($mail_info->sender);
			}
			$this->open_admin_page('admin/mailbox/compose', $data);
		}
		else{
			$user_id = $this->session->userdata('userid');
			
			$data = $this->get_data_for_profile($user_id);
			$data['am'] = 'mailbox_'.$box;
			$data['gm'] = 'mailbox';
			$data['box'] = $box;
			$data['mode'] = 'forward';
			$data['page_title'] = $this->lang->line('mailbox_forward');
			$data['sub_page_title'] = $this->lang->line('mailbox_forward');

			if($id<>null){
				$mail_info = $this->Mailbox_m->get_mail_by_id($id);
				$data['mail_info'] = $mail_info;
				$data['recipient'] = $this->User_m->get_user_by_id($mail_info->sender);
			}
			$this->open_page('mailbox/compose', $data);
		}
	}
	/* Admin page end */

	/* Function begin */
	function upload_files(){
		$upload_path_url = base_url() . 'assets/uploads/';
		$this->load->library('upload');
		$config = array(
			'upload_path' => './assets/uploads/',
			'allowed_types' => 'jpg|png|gif|jpeg|zip',
			'overwrite' => false,
			'remove_spaces' => true,
			'max_size' => '1000'
		);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload()){
			print_r($this->upload->display_errors());
			//Load the list of existing files in the upload directory
            $existingFiles = get_dir_file_info($config['upload_path']);
            $foundFiles = array();
            $f=0;
            foreach ($existingFiles as $fileName => $info) {
              if($fileName!='thumbs'){//Skip over thumbs directory
                //set the data for the json array   
                $foundFiles[$f]['name'] = $fileName;
                $foundFiles[$f]['size'] = $info['size'];
                $foundFiles[$f]['url'] = $upload_path_url . $fileName;
                $foundFiles[$f]['thumbnailUrl'] = $upload_path_url . 'thumbs/' . $fileName;
                $foundFiles[$f]['deleteUrl'] = base_url() . 'mailbox/delete_attachment/' . $fileName;
                $foundFiles[$f]['deleteType'] = 'DELETE';
                $foundFiles[$f]['error'] = null;

                $f++;
              }
            }
            $this->output
	            ->set_content_type('application/json')
	            ->set_output(json_encode(array('files' => $foundFiles)));
		} 
		else{
			$data = $this->upload->data();
			//insert document data in database
			$upload_data = array(
				'file_name' => $data['file_name'],
				'file_type' => $data['file_type'],
				'file_extension' => $data['file_ext'],
				'img_width' => $data['image_width'],
				'img_height' => $data['image_height'],
				'file_size' => $data['file_size'],
				'is_image' => $data['is_image']
			);

			$add_media = $this->Common->add_to_table('media_files', $upload_data); // return the last inserted id
            // to re-size for thumbnail images un-comment and set path here and in json array
            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $data['full_path'];
            $config['create_thumb'] = TRUE;
            $config['new_image'] = $data['file_path'] . 'thumbs/';
            $config['maintain_ratio'] = TRUE;
            $config['thumb_marker'] = '';
            $config['width'] = 75;
            $config['height'] = 50;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();


            //set the data for the json array
            $info = new StdClass;
            $info->name = $data['file_name'];
            $info->size = $data['file_size'] * 1024;
            $info->type = $data['file_type'];
            $info->url = $upload_path_url . $data['file_name'];
            // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
            $info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
            $info->deleteUrl = base_url() . 'mailbox/delete_attachment?fn=' . $data['file_name'].'&id='.$add_media->output;
            $info->deleteType = 'DELETE';
            $info->error = null;
            $info->file_id = $add_media->output;

            $files[] = $info;
            //this is why we put this in the constants to pass only json data
            if (IS_AJAX) {
                echo json_encode(array("files" => $files));
                //this has to be the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
                // so that this will still work if javascript is not enabled
            } else {
                print_r('mari');
            }
        }

        // echo json_encode($response);
	}

	function delete_attachment() {//gets the job done but you might want to add error checking and security
		$file = $this->input->get('fn');
		$mail_id = $this->input->get('mailid', true);
        $success = unlink(FCPATH . 'assets/uploads/' . $file);
        $success = unlink(FCPATH . 'assets/uploads/thumbs/' . $file);
        //info to see if it is doing what it is supposed to
	    $info = new StdClass;
        $info->sucess = $success;
        $info->path = base_url() . 'assets/uploads/' . $file;
        $info->file = is_file(FCPATH . 'assets/uploads/' . $file);

        // delete from database
		$del_media = $this->Common->delete_from_table_by_id('media_files', 'id', $this->input->get('id'));

		// delete from media_id in table mailbox
		if($mail_id <> null){
			$mail_info = $this->Mailbox_m->get_mail_by_id($mail_id);
			$media_array = explode(',', $mail_info->media_id);
			$key_will_removed = array_search($this->input->get('id'), $media_array);
			unset($media_array[$key_will_removed]);
			$new_media_id = implode(',', $media_array);

			$update_media = array('media_id' => $new_media_id);
			$upd = $this->Common->update_data_on_table('mailbox', 'id', $mail_id, $update_media);
		}

        if (IS_AJAX) {
            //I don't think it matters if this is set but good for error checking in the console/firebug
            $info->status="200";
            echo json_encode(array($info));
        } else {
            //here you will need to decide what you want to show for a successful delete        
            // $file_data['delete_data'] = $file;
            // $this->load->view('admin/delete_success', $file_data);
        }
    }

    function send($mail_id=null){
    	if($this->input->post('action')=="draft")
    		$status = 'Draft';
    	else if($this->input->post('action')=="send")
    		$status = 'Sent';
    	if($mail_id==null){
    		$data = array(
	    		'id' => uniqid(),
	    		'sender' => $this->session->userdata('userid'),
	    		'destination' => $this->input->post('destination_id', true),
	    		'subject' => $this->input->post('subject', true),
	    		'content' => base64_encode($this->input->post('content')),
	    		'media_id' => $this->input->post('file-id', true),
	    		'status' => $status
	    		);
	    	$add = $this->Common->add_to_table('mailbox', $data);
    	}
    	else{
    		$update_data = array(
	    		'destination' => $this->input->post('destination_id', true),
	    		'subject' => $this->input->post('subject', true),
	    		'content' => base64_encode($this->input->post('content')),
	    		'media_id' => $this->input->post('file-id', true),
	    		'status' => $status
	    		);
    		$upd = $this->Common->update_data_on_table('mailbox', 'id', $mail_id, $update_data);
    	}
    	$this->session->set_flashdata('err_no', '200');
    	if($status=="Draft")
			$this->session->set_flashdata('err_msg', 'Data has been saved');
		else
			$this->session->set_flashdata('err_msg', 'Your mail has been sent successfully');

    	if($status=="Draft" and $mail_id==null)
    		redirect('mailbox/compose/'.$data['id']);
    	else if($status=="Draft" and $mail_id <> null)
    		redirect('mailbox/compose/'.$mail_id);
    	if($status=="Sent")
    		redirect('mailbox/'.$this->input->post('box'));
    }

    function set_trash($is_multiple=null){
    	$mail_id = $this->input->get('mid', true);
    	$url_back = $this->input->get('uri_back', true);
    	$trash_data = array(
    		'status' => 'Trash',
    		'trashed_by' => $this->session->userdata('userid')
    		);
    	if($is_multiple==null)
    		$upd = $this->Common->update_data_on_table('mailbox', 'id', $mail_id, $trash_data);
    	else{
    		$id_array = explode('-', $mail_id);
    		foreach($id_array as $id)
    			$upd = $this->Common->update_data_on_table('mailbox', 'id', $id, $trash_data);
    	}
    	if($upd->status){
    		$this->session->set_flashdata('err_no', '200');
    		$this->session->set_flashdata('err_msg', $this->lang->line('mail_sent_to_trash'));
    	}
    	else{
    		$this->session->set_flashdata('err_no', '204');
    		$this->session->set_flashdata('err_msg', $upd->output);
    	}

    	redirect($url_back);
    }

	/* function end */
}