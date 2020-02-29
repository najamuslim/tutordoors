<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Content extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('form');
	}

	/* admin pages BEGIN */
	public function category_view(){
		$this->check_user_access();
		$type = $this->input->get('ty',TRUE);

		// $this->load->model('Content_m', 'content');

		$data = array(
			'active_menu_id' => $type.'-category',
			'title_page' => 'Category',
			'title' => $type
			);
		// get category data
		$data['category'] = $this->Content_m->get_category_data('category_part', $type);
		
		$this->open_admin_page('admin/content/category_crud', $data);
	}

	public function post_new(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'post-add',
			'title_page' => 'Add new post',
			'mode' => 'add'
			);
		// get category
		$data['category'] = $this->Content_m->get_category('category_part', 'post');
		$data['languages'] = array(
			'id' => 'Bahasa Indonesia',
			'en' => 'English'
			);

		$this->open_admin_page('admin/content/post_creation', $data);
	}

	public function view_post(){
		$this->check_user_access();
		$type = $this->input->get('ty');
		
		$data = array(
			'active_menu_id' => $type.'-view',
			'title_page' => 'View all '.$type.'s',
			'title' => 'view'
			);
		
		$data['post'] = $this->Content_m->get_post_data(array('type' => $type));
		
		$this->open_admin_page('admin/content/'.$type.'_view_all', $data);
	}

	public function post_edit(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'post-add',
			'title_page' => 'Edit post',
			'mode' => 'edit'
			);
		// get category
		$data['category'] = $this->Content_m->get_category('category_part', 'post');
		// get post data by post id and return to client
		$post_data = $this->Content_m->get_post_data(array('type' => 'post' , 'a.id' => $this->input->get('id', TRUE)));
		$data['post_data'] = $post_data->row();
		// get post image
		$data['post_image'] = $this->Content_m->get_post_image($data['post_data']->primary_image);
		// get additional images
		$data['more_images'] = $this->Content_m->get_post_additional_images($this->input->get('id', TRUE));
		$data['languages'] = array(
			'id' => 'Bahasa Indonesia',
			'en' => 'English'
			);

		$this->open_admin_page('admin/content/post_creation', $data);
	}

	public function page_new(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'page-add',
			'title_page' => 'Add new page',
			'mode' => 'add'
			);
		$data['languages'] = array(
			'id' => 'Bahasa Indonesia',
			'en' => 'English'
			);

		$this->open_admin_page('admin/content/page_creation', $data);
	}

	public function page_edit(){
		$this->check_user_access();
		
		$data = array(
			'active_menu_id' => 'page-add',
			'title_page' => 'Edit page',
			'mode' => 'edit'
			);
		// get post data by post id and return to client
		$post_data = $this->Content_m->get_post_data(array('type' => 'page','a.id' => $this->input->get('id', TRUE)));
		
		$data['page_data'] = $post_data->row();
		$data['languages'] = array(
			'id' => 'Bahasa Indonesia',
			'en' => 'English'
			);
		
		$this->open_admin_page('admin/content/page_creation', $data);
	}

	function message_contact(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'message-contact-form',
			'title_page' => 'Messages on Contact Form',
			);

		$data['messages'] = $this->Content_m->get_messages_contact();

		$this->open_admin_page('admin/content/message_on_contact_form', $data);
	}

	function second_top_menu(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'second-top-menu',
			'title_page' => 'Editing Second Top Menu',
			);

		$this->load->helper('form');

		$data['menus'] = $this->Content_m->get_menu_by_part('second_top');

		$data['programs'] = $this->Course_m->get_programs();

		// $get_parents = $this->Content_m->get_parent_menu('second_top');
		// $parents = array();
		// if($get_parents<>false)
		// 	foreach($get_parents->result() as $parent)
		// 		$parents[$parent->id] = $parent->menu_label;
		// $data['parents'] = $parents;

		$this->open_admin_page('admin/appearance/second_top_menu', $data);
	}

	function post_faq(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'post-faq',
			'title_page' => 'Frequently Asked Questions'
			);

		$data['faq'] = $this->Content_m->get_faq_posts();

		$this->open_admin_page('admin/content/faq', $data);
	}
        
        function post_career(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'post-career',
			'title_page' => 'Career & Job Vacancy'
			);

		$data['career'] = $this->Content_m->get_career_posts();

		$this->open_admin_page('admin/content/career', $data);
	}

	function faq_form(){
		$mode = $this->input->get('id')=="" ? "add" : "edit";
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'post-faq',
			'title_page' => 'Frequently Asked Questions',
			'mode' => $mode
			);
		$data['faq_categories'] = $this->Content_m->get_faq_categories();
		$data['languages'] = array(
			'id' => 'Bahasa Indonesia',
			'en' => 'English'
			);
		if($mode=="edit"){
			// get post data by post id and return to client
			$post_data = $this->Content_m->get_post_data(array('a.id' => $this->input->get('id', TRUE)));
			$data['post_data'] = $post_data->row();
		}

		$this->open_admin_page('admin/content/faq_form', $data);
	}
        
        function career_form(){
		$mode = $this->input->get('id')=="" ? "add" : "edit";
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'post-career',
			'title_page' => 'Job Vacancy',
			'mode' => $mode
			);
		$data['career_categories'] = $this->Content_m->get_career_categories();
		$data['languages'] = array(
			'id' => 'Bahasa Indonesia',
			'en' => 'English'
			);
		if($mode=="edit"){
			// get post data by post id and return to client
			$post_data = $this->Content_m->get_post_data(array('a.id' => $this->input->get('id', TRUE)));
			$data['post_data'] = $post_data->row();
		}

		$this->open_admin_page('admin/content/career_form', $data);
	}
        

	function email_template(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'email-template',
			'title_page' => 'Email Templates'
			);

		$data['templates'] = $this->Content_m->get_email_templates();

		$this->open_admin_page('admin/content/email_templates', $data);
	}

	function email_template_edit(){
		$this->check_user_access();
		$data = array(
			'active_menu_id' => 'email-template',
			'title_page' => 'Edit Email Template'
			);

		$template_info = $this->Content_m->get_email_templates(array('id'=>$this->input->get('id', true)));
		$data['template'] = $template_info->row();

		$this->open_admin_page('admin/content/email_template_edit', $data);
	}

	/* admin pages END */

	/* user pages BEGIN */

	function faq(){
		$data['faq'] = $this->Content_m->get_faq_posts($this->session->userdata('language'));
		$data['sub_page_title'] = $this->lang->line('faq_long');

		$data['counted_tutors_in_programs'] = $this->Course_m->count_verified_tutor_courses_under_programs();
		
		$data['page_title'] = $this->lang->line('faq_long');
		$this->open_page('faq', $data);
	}
        
        function career() {
                $data['career'] = $this->Content_m->get_career_posts($this->session->userdata('language'));
		$data['sub_page_title'] = $this->lang->line('career_long');

		//$data['counted_tutors_in_programs'] = $this->Course_m->count_verified_tutor_courses_under_programs();
		
		$data['page_title'] = $this->lang->line('career_long');
		$this->open_page('career', $data);
        }

	function page($url){
		$id_array = explode('-', $this->uri->segment(3), 2);
		if(is_numeric($id_array[0])) // if it's a numeric refer to blog post, else refer to page
			$filter = array('a.id' => $id_array[0]);
		else
			$filter = array(
				'type' => 'page',
				'url' => $url,
				'status' => 'publish'
				);
		$get_post = $this->Content_m->get_post_data($filter);

		$data['page'] = $get_post->row();
		
		$data['page_title'] = $data['page']->title;
		$data['sub_page_title'] = $data['page']->title;
		$data['meta_social_title'] = $data['page']->title;
		$data['meta_social_image'] = '';
		$data['meta_social_desc'] = '';

		$data['counted_tutors_in_programs'] = $this->Course_m->count_verified_tutor_courses_under_programs();
		$data['post_type'] = 'page';

		$this->open_page('page', $data);
	}

	function feed_page_json($url){
		$id_array = explode('-', $this->uri->segment(3), 2);
		if(is_numeric($id_array[0])) // if it's a numeric refer to blog post, else refer to page
			$filter = array('a.id' => $id_array[0]);
		else
			$filter = array(
				'type' => 'page',
				'url' => $url,
				'status' => 'publish'
				);
		$get_post = $this->Content_m->get_post_data($filter);
		$data = $get_post->row();
		$response = array(
			'id' => $data->id,
			'title' => $data->title,
			'content' => $data->content,
			'category' => $data->category_name,
			'slug' => $data->slug,
			'url' => $data->url,
			'image' => base_url('assets/uploads/'.$data->file_name),
			'lang' => $data->lang_id
			);
		echo json_encode($response);
	}

	function contact(){
		$data['page_title'] = 'Contact Us';
		
		$data['meta_social_title'] = $this->lang->line('contact_us');
		$data['meta_social_image'] = '';
		$data['meta_social_desc'] = '';

		$this->open_page('page_contact', $data);
	}

	function blog($slug, $limit_start, $limit_end){
		$this->load->helper('text');
		$data['posts'] = $this->Content_m->get_post_category_slug($slug, $limit_start, $limit_end);
		$data['total_post'] = intval($this->Content_m->count_post_category_slug($slug));
		$data['page_link'] = ceil(intval($this->Content_m->count_post_category_slug($slug)) / $limit_end);
		$data['active_pagination_link'] = $limit_start < $limit_end ? 1 : floor($limit_start / $limit_end);
		
		$data['page_title'] = 'Blog '.ucwords($slug);
		$data['sub_page_title'] = 'Blog '.ucwords($slug);
		$data['meta_social_title'] = 'Blog '.ucwords($slug);
		$data['meta_social_image'] = '';
		$data['meta_social_desc'] = '';

		$data['counted_tutors_in_programs'] = $this->Course_m->count_verified_tutor_courses_under_programs();

		$this->open_page('blog', $data);
	}

	/* user pages END */

	/* functions begin */

	function set_follow_up($id){
		$data = array('followed_up' => '1');
		$upd = $this->Common->update_data_on_table('contact_form_messages', 'id', $id, $data);

		if($upd->status)
			$response['status'] = '200';
		else $response['status'] = '204';

		echo json_encode($response);
	}

	function add_second_top(){
		if($this->input->post('link-method', true)=="empty")
			$link = '#';
		else if($this->input->post('link-method', true)=="all")
			$link = base_url('teacher/program?prog=all');
		else if($this->input->post('link-method', true)=="program")
			$link = base_url('teacher/program?prog='.$this->input->post('program', true));

		$data = array(
			'menu_part' => $this->input->post('part', true),
			'menu_label' => $this->input->post('label', true),
			'level' => $this->input->post('level', true),
			'parent_id' => $this->input->post('parent', true),
			'ordinal' => $this->input->post('ordinal', true),
			'link_address' => $this->input->post('gen-link', true)
			);

		$add = $this->Common->add_to_table('appearance_menu', $data);
		
		$this->set_session_response_no_redirect('add', $add);

		redirect('content/second_top_menu');
	}

	function update_second_top(){
		if($this->input->post('link-method', true)=="empty")
			$link = '#';
		else if($this->input->post('link-method', true)=="all")
			$link = base_url('teacher/program?prog=all');
		else if($this->input->post('link-method', true)=="program")
			$link = base_url('teacher/program?prog='.$this->input->post('program', true));

		$data = array(
			'menu_part' => $this->input->post('part', true),
			'menu_label' => $this->input->post('label', true),
			'level' => $this->input->post('level', true),
			'parent_id' => $this->input->post('parent', true),
			'ordinal' => $this->input->post('ordinal', true),
			'link_address' => $this->input->post('gen-link', true)
			);

		$upd = $this->Common->update_data_on_table('appearance_menu', 'id', $this->input->post('id', true), $data);
		
		$this->set_session_response_no_redirect('update', $upd);

		redirect('content/second_top_menu');
	}

	function delete_second_top($id)
	{
		// check if parent has child
        $check_child = $this->Content_m->check_menu_has_child($id);
        if($check_child==0)
        {
			$del = $this->Common->delete_from_table_by_id('appearance_menu', 'id', $id);
			$this->set_session_response_no_redirect('delete', $del);
        }
        else
        {
        	array_push($this->any_error, 'This menu has child menu. Delete the child first, then retry delete the parent.');
        	$this->set_session_response_no_redirect_by_error('delete');
        }
        redirect('content/second_top_menu');
	}

	function get_menu_by_id($id)
	{
		$menu = $this->Content_m->get_menu_by_id($id);
		// find the program if data link is related to specific course
		$program = $course = '';
		if($menu->link_address<>"#"){
			if(substr($menu->link_address, -3) <> "all"){
				$pos = strpos($menu->link_address, "=");
				$program = $course = substr($menu->link_address, $pos + 1);
				$course_info = $this->Course_m->get_courses(array('c.id' => $course));
				if($course_info<>false)
					$program = $course_info->row()->program_id;
			}
		}
		
		$response = array(
			'id' => $menu->id,
			'label' => $menu->menu_label,
			'link' => $menu->link_address,
			'level' => $menu->level,
			'parent' => $menu->parent_id,
			'ordinal' => $menu->ordinal,
			'program' => $program,
			'course' => $course
			);

		echo json_encode($response);
	}

	public function delete_post(){
		$type = $this->input->get('ty');
		$id = $this->input->get('id', TRUE);

		$post_data = $this->Content_m->get_post_data(array('type' => $type, 'a.id' => $id));
		$primary_image = $post_data->row()->primary_image;

		$del_post = $this->Common->delete_from_table_by_id('posts', 'id', $id);
		$this->push_if_transaction_error($del_post);

		//get the filename and delete from storage
		$get = $this->Content_m->get_post_image($primary_image);
		$filename = $get->file_name;
		// delete from database
		$del_media = $this->Common->delete_from_table_by_id('media_files', 'id', $primary_image);
		$this->push_if_transaction_error($del_media);
		// delete from storage
		unlink('./assets/uploads/'.$filename);

		if(empty($this->any_error)){
			$this->session->set_flashdata('err_no', '200');
			$this->session->set_flashdata('err_msg', 'Data berhasil dihapus');
		}
		else{
			$this->session->set_flashdata('err_no', '204');
			$this->session->set_flashdata('err_msg', $this->any_error);
		}

		redirect('content/view_post?ty='.$type);
	}

	public function add_post(){
		$data = $this->general_post_data();
		$add_post = $this->Common->add_to_table('posts', $data);
		$this->set_session_response_no_redirect('add', $add_post);
		
		if (!empty($_FILES['image_file']['name']))
			$this->upload_set_primary_image($add_post->output);

		redirect('content/post_edit?id='.$add_post->output);
	}

	public function update_post(){
		$id = $this->input->get('id', TRUE);
		$data = $this->general_post_data();
		$update = $this->Common->update_data_on_table('posts', 'id', $id, $data);
		$this->set_session_response_no_redirect('update', $update);

		if (!empty($_FILES['image_file']['name']))
			$this->upload_set_primary_image($id);

		redirect('content/post_edit?id='.$id);
	}

	public function add_page(){
		$data = $this->general_post_data();
		$add_page = $this->Common->add_to_table('posts', $data);
		$this->set_session_response_no_redirect('add', $add_page);

		redirect('content/page_edit?id='.$add_page->output);
	}

	public function update_page(){
		$id = $this->input->get('id', TRUE);
		$data = $this->general_post_data();
		$update_page = $this->Common->update_data_on_table('posts', 'id', $id, $data);
		$this->set_session_response_no_redirect('update', $update_page);

		redirect('content/page_edit?id='.$id);
	}

	function general_post_data(){		
		$data = array(
			'title' => ucwords($this->input->post('title', TRUE)),
			'category' => $this->input->post('category', TRUE),
			'type' => $this->input->post('type', TRUE),
			'content' => $this->input->post('content'),
			'tags' => $this->input->post('tags', TRUE),
			'status' => $this->input->post('action', TRUE),
			'author' => $this->session->userdata('userid'),
			'url' => $this->input->post('url'),
			'link_href' => $this->input->post('link-address'),
			'lang_id' => $this->input->post('lang', TRUE)
			);

		return $data;
	}

	function mapping_product_category($post_id){
		foreach($this->input->post('cats') as $cat){
			$data = array('post_id' => $post_id, 'category_id' => $cat);
			$add_map = $this->Common->add_to_table('post_categories_mapping', $data);
			if(!$add_map->status)
				array_push($this->any_error, $add_map->output);
		}
	}

	public function add_more_images($post_id){
		$config = array(
			'upload_path' => './assets/uploads/',
			'allowed_types' => 'jpg|png|jpeg',
			'overwrite' => false,
			'remove_spaces' => true,
			'max_size' => '4000'
		);

		foreach ($_FILES['more_images']['name'] as $key => $image)  //fieldname is the form field name
		{
			$_FILES['more_images[]']['name']= $_FILES['more_images']['name'][$key];
	        $_FILES['more_images[]']['type']= $_FILES['more_images']['type'][$key];
	        $_FILES['more_images[]']['tmp_name']= $_FILES['more_images']['tmp_name'][$key];
	        $_FILES['more_images[]']['error']= $_FILES['more_images']['error'][$key];
	        $_FILES['more_images[]']['size']= $_FILES['more_images']['size'][$key];

	        $this->load->library('upload');
		    $this->upload->initialize($config);

		    if ($this->upload->do_upload('more_images[]')) {
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
				if(!$add_media->status)
					array_push($this->any_error, $add_media->output);
				// mapping post and media
				$map = array(
					'post_id' => $post_id,
					'media_id' => $add_media->output
					);
				$map_post_media = $this->Common->add_to_table('post_media', $map);
	        } else {
	            array_push($this->any_error, 'Error upload file '.$_FILES['more_images']['name'][$key].' . Error message: '.$this->upload->display_errors());
	        }
		}
	}

	function upload_set_primary_image($post_id){
		$this->load->library('upload');
		$config = array(
			'upload_path' => './assets/uploads/',
			'allowed_types' => 'jpg|png|gif|jpeg',
			'overwrite' => false,
			'remove_spaces' => true,
			'max_size' => '50000'
		);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('image_file')){
			// var_dump($this->upload->display_errors());
			// var_dump($this->upload->file_type);

			array_push($this->any_error, 'Error on set primary image: '.$this->upload->display_errors());
		} 
		else{
			// print_r('gak ono');
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
			$map = array('primary_image' => $add_media->output);
			$map_post_media = $this->Common->update_data_on_table('posts', 'id', $post_id, $map);
			$this->push_if_transaction_error($map_post_media);
        }
	}

	public function get_category_by_id(){
		// get category data
		$category = $this->Content_m->get_category_data('id', $this->uri->segment(3));
		$data = $category->row();
		$response = array(
			'category' => $data->category,
			'slug' => $data->slug,
			'parent_id' => $data->parent_id
			);
		
		echo json_encode($response);
	}

	public function category_add(){
		$type = $this->input->post('type', TRUE);

		$data = array(
			'category' => $this->input->post('category', TRUE),
			'slug' => $this->input->post('slug', TRUE),
			'parent_id' => $this->input->post('parent', TRUE),
			'category_part' => $type
			);
		$add_cat = $this->Common->add_to_table('post_categories', $data);

		$this->set_session_response_no_redirect('add', $add_cat);

		redirect('content/category_view?ty='.$type);
	}

	public function category_update(){
		$type = $this->input->post('type', TRUE);
		$id = $this->input->post('id', TRUE);

		$data = array(
			'category' => $this->input->post('category', TRUE),
			'slug' => $this->input->post('slug', TRUE),
			'parent_id' => $this->input->post('parent', TRUE),
			'category_part' => $type
			);
		$upd_cat = $this->Common->update_data_on_table('post_categories', 'id', $id, $data);

		$this->set_session_response_no_redirect('update', $upd_cat);

		redirect('content/category_view?ty='.$type);
	}

	public function category_delete(){
		$type = $this->input->get('ty', TRUE);
		$id = $this->input->get('id', TRUE);

		$del_cat = $this->Common->delete_from_table_by_id('post_categories', 'id', $id);

		$this->set_session_response_no_redirect('delete', $del_cat);

		redirect('content/category_view?ty='.$type);
	}

	public function add_faq(){
		$data = array(
			'title' => $this->input->post('title', true),
			'content' => $this->input->post('content', true),
			'url' => $this->input->post('url', true),
			'list_order' => $this->input->post('list_order', true),
			'category' => $this->input->post('category', true),
			'type' => $this->input->post('type', true),
			'lang_id' => $this->input->post('lang', true)
			);
		$add = $this->Common->add_to_table('posts', $data);
		$this->set_session_response_no_redirect('add', $add);
		
		redirect('content/post_faq');
	}

	public function update_faq($id){
		$data = array(
			'title' => $this->input->post('title', true),
			'content' => $this->input->post('content', true),
			'url' => $this->input->post('url', true),
			'list_order' => $this->input->post('list_order', true),
			'category' => $this->input->post('category', true),
			'type' => $this->input->post('type', true),
			'lang_id' => $this->input->post('lang', true)
			);
		$update = $this->Common->update_data_on_table('posts', 'id', $id, $data);
		$this->set_session_response_no_redirect('update', $update);
		
		redirect('content/post_faq');
	}

	public function delete_faq($id){
		$del_post = $this->Common->delete_from_table_by_id('posts', 'id', $id);
		$this->set_session_response_no_redirect('delete', $del_post);

		redirect('content/post_faq');
	}
        
        public function add_career(){
		$data = $this->general_post_data();
		$add_post = $this->Common->add_to_table('posts', $data);
		$this->set_session_response_no_redirect('add', $add_post);
		
		if (!empty($_FILES['image_file']['name']))
			$this->upload_set_primary_image($add_post->output);

		redirect('content/post_career');
	}

	public function update_career(){
		$id = $this->input->get('id', TRUE);
		$data = $this->general_post_data();
		$update = $this->Common->update_data_on_table('posts', 'id', $id, $data);
		$this->set_session_response_no_redirect('update', $update);

		if (!empty($_FILES['image_file']['name']))
			$this->upload_set_primary_image($id);

		redirect('content/post_career');
	}
        
        
        public function delete_career($id){
		$del_post = $this->Common->delete_from_table_by_id('posts', 'id', $id);
		$this->set_session_response_no_redirect('delete', $del_post);

		redirect('content/post_career');
	}

	public function update_email_template($id){
		$update_content = array('content' => htmlspecialchars($this->input->post('content')));
		$upd = $this->Common->update_data_on_table('email_templates', 'id', $id, $update_content);
		$this->set_session_response_no_redirect('update', $upd);

		redirect('content/email_template');
	}

	function upload_file($type, $name=""){
		$upload_path_url = base_url() . 'assets/uploads/';
		$this->load->library('upload');

		$config = array(
			'upload_path' => './assets/uploads/',
			'overwrite' => false,
			'remove_spaces' => true,
			'max_size' => '1000'
		);
		if($type=="image")
			$config['allowed_types'] = 'jpg|png|gif|jpeg';

		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload($name)){
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
                $foundFiles[$f]['deleteUrl'] = base_url() . 'content/delete_file/' . $fileName;
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
            $info->deleteUrl = base_url() . 'content/delete_file?fn=' . $data['file_name'].'&id='.$add_media->output;
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

	function delete_file() {//gets the job done but you might want to add error checking and security
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
			$mail_info = $this->mailbox_m->get_mail_by_id($mail_id);
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

	/* functions END */

	function test_mail(){
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
        $mail->Subject    = "Lama tak jumpa nih";

        $mail->Body      = "Hai ocky, gimana kabarnya?";
        $mail->AltBody    = "Plain text message";
        $destino = 'ocky.harli@gmail.com'; // Who is addressed the email to
        $mail->AddAddress($destino, "Ocky Harliansyah");

        if(!$mail->Send()) {
        	echo $mail->ErrorInfo;
        }
	}
}