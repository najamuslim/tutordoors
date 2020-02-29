<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Online_course extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /* Start Admin Pages */

    //admin page untuk menampilkan semua online course, 
    //ada menu untuk membuat baru, edit, dan hapus online course
    public function view() {
        $this->check_user_access();

        $data = array(
            'active_menu_id' => 'view-online-courses',
            'title_page' => 'Online Courses'
        );

        $data['programs'] = $this->Course_m->get_programs();
        $data['category'] = $this->Online_course_m->get_category();
        $data['topic'] = $this->Online_course_m->get_topic();
        $this->open_admin_page('admin/online_course/view_online_courses', $data);
    }

    public function module() {
        $this->check_user_access();
        $data = array(
            'active_menu_id' => 'online-courses-module',
            'title_page' => 'Online Courses Module'
        );
        
        $data['programs'] = $this->Course_m->get_programs();
        $data['online_course'] = $this->Online_course_m->get_online_courses();
        $data['video'] = $this->Online_course_m->get_videos();
        $this->open_admin_page('admin/online_course/module_online_course', $data);
    }
    
    //admin page untuk membuat online course baru
    public function pricing() {
        $this->check_user_access();

        $data = array(
            'active_menu_id' => 'pricing-online-courses',
            'title_page' => 'Online Courses Pricing'
        );

        $data['programs'] = $this->Course_m->get_programs();
        $this->open_admin_page('admin/online_course/pricing_online_courses', $data);
    }

    //admin page untuk menampilkan semua video course
    public function video() {
        $this->check_user_access();

        $data = array(
            'active_menu_id' => 'online-courses-video',
            'title_page' => 'Online Courses Video'
        );

        $data['programs'] = $this->Course_m->get_programs();
        $this->open_admin_page('admin/online_course/video_online_course', $data);
    }

    public function insert_video() {
        $this->check_user_access();
        //$this->load->helper(array('form'));
        $this->load->library('upload');
        //var_dump($this->input->post('submit'));
        $duration = 0;
        $videoimagedata = array();
        $videodata = array();
        
        //upload image video     
        $config = array();
        $config['upload_path']          = './assets/uploads/video-image/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = '1024';
        $config['max_width']            = '1280';
        $config['max_height']           = '720';
        $config['max_filename']         = '255';
        $config['encrypt_name']         = TRUE;
        
        //$this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload("video-image"))
        {
                $error = array('error' => $this->upload->display_errors());  
                $this->session->set_flashdata('err_no', "204");
                $this->session->set_flashdata('err_msg', $this->upload->display_errors());
                //var_dump($error);
        }
        else
        {
                $videoimagedata = array('upload_data' => $this->upload->data());      
                //var_dump($videoimagedata); 
        }
        //---------------
        
        //upload video
        $configv = array();
        $configv['upload_path']          = './assets/uploads/video/';
        $configv['allowed_types']        = 'mp4|wmv|avi|mov';
        $configv['max_size']             = '500000';
        $configv['max_filename']         = '255';
        $configv['encrypt_name']         = TRUE;
        //$this->load->library('upload', $configv);
        $this->upload->initialize($configv);
        
        if ( ! $this->upload->do_upload("video-file"))
        {
                $error = array('error' => $this->upload->display_errors());  
                $this->session->set_flashdata('err_no', "204");
                $this->session->set_flashdata('err_msg', $this->upload->display_errors());
                
                //var_dump($error);
        }
        else
        {
                $videodata = array('upload_data' => $this->upload->data()); 
                //var_dump($videodata);
        }
        //--------------
        //var_dump($this->upload->file_type);
        if ($videodata && $videoimagedata) {
            $data = array(
                'title' => $this->input->post('video-name', TRUE),
                'description' => $this->input->post('video-description', TRUE),
                'videoimage' => $videoimagedata['upload_data']['file_name'],
                'filename' => $videodata['upload_data']['file_name'],
                'duration' => $duration
            );

            $insert = $this->Common->add_to_table('product_oc_video', $data);
            $this->set_session_response_no_redirect('insert', $insert);
        } 
        redirect('online_course/video');
        
    }
    
    // admin function untuk update online course
    function update_video() {
        $this->check_user_access();
        $video_id = $this->input->post('id', TRUE);

        $video = $this->get_video_by_id($video_id);
        
        $videoimagename = $video['videoimage'];
        $videoname = $video['filename'];
        
        $this->load->library('upload');
        
        $videoimagedata = array();
        $videodata = array();
        
        //upload image video     
        $config = array();
        $config['upload_path']          = './assets/uploads/video-image/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = '1024';
        $config['max_width']            = '1280';
        $config['max_height']           = '720';
        $config['max_filename']         = '255';
        $config['overwrite']            = TRUE;
        $config['file_name']            = $videoimagename;

        $this->upload->initialize($config);
        
        if (isset($_FILES['video-image-update'])&&$_FILES['video-image-update']['size']>0) {
            if ( ! $this->upload->do_upload("video-image-update"))
            {
                    $error = array('error' => $this->upload->display_errors());  
                    $this->session->set_flashdata('err_no', "204");
                    $this->session->set_flashdata('err_msg', $this->upload->display_errors());
                    //var_dump($error);
            }
            else
            {
                    $videoimagedata = array('upload_data' => $this->upload->data());      
                    //var_dump($videoimagedata); 
            }
        }
        //---------------
        
        //upload video
        $configv = array();
        $configv['upload_path']          = './assets/uploads/video/';
        $configv['allowed_types']        = 'mp4|wmv|avi|mov';
        $configv['max_size']             = '500000';
        $configv['max_filename']         = '255';
        $configv['overwrite']            = TRUE;
        $configv['file_name']            = $videoname;
        
        $this->upload->initialize($configv);
        if (isset($_FILES['video-file-update'])&&$_FILES['video-file-update']['size']>0) {
            if ( ! $this->upload->do_upload("video-file-update"))
            {
                    $error = array('error' => $this->upload->display_errors());  
                    $this->session->set_flashdata('err_no', "204");
                    $this->session->set_flashdata('err_msg', $this->upload->display_errors());

                    //var_dump($error);
            }
            else
            {
                    $videodata = array('upload_data' => $this->upload->data()); 
                    //var_dump($videodata);
            }
        }
        
        // insert to video
        //if ($videodata && $videoimagedata) {
            $data = array(
                'title' => $this->input->post('video-name', TRUE),
                'description' => $this->input->post('video-description', TRUE),
                //'videoimage' => $videoimagedata['upload_data']['file_name'],
                //'filename' => $videodata['upload_data']['file_name'],
                //'duration' => $duration
            );

            $upd_video = $this->Common->update_data_on_table('product_oc_video', 'id', $video_id, $data);
            $this->set_session_response_no_redirect('update', $upd_video);
        //}
        redirect('online_course/video');
    }
    
    function delete_video() {
        $this->check_user_access();
        $id =  $this->input->get('id', true);
        $video = $this->get_video_by_id($id);
        
        $videoimagepath = './assets/uploads/video-image/'.$video['videoimage'];
        $videopath = './assets/uploads/video/'.$video['filename'];
        
        //echo $videoimagepath;
        //echo $videopath;
        
        //unlink($videoimagepath);
        //unlink($videopath);
        
        if (!unlink($videoimagepath)){
            echo ("Error deleting $videoimagepath");
        } else {
            echo ("Deleted $videoimagepath");
        }
        
        if (!unlink($videopath)){
            echo ("Error deleting $videopath");
        } else {
            echo ("Deleted $videopath");
        }
        
        $delete = $this->Common->delete_from_table_by_id('product_oc_video', 'id', $id);

        $this->set_session_response_no_redirect('delete', $delete);

        redirect('online_course/video');
    }
    //admin page untuk menampilkan semua article course
    public function article() {
        $this->check_user_access();

        $data = array(
            'active_menu_id' => 'online-courses-article',
            'title_page' => 'Online Courses Articles'
        );

        $data['programs'] = $this->Course_m->get_programs();
        $this->open_admin_page('admin/online_course/article_online_course', $data);
    }

    // admin function untuk insert online course
    function insert_online_course() {
        $this->check_user_access();
        
        //cek tabel topic, jika ada gunakan id
        //jika tidak ada, insert topic baru, ambil insert id
        $topic_submit = $this->input->post('topic', TRUE);
        $topic_id = $this->insert_topic($topic_submit);

        //insert ke tabel product_online_course
        $data = array(
            'course_code' => strtoupper($this->input->post('course-code', TRUE)),
            'course_name' => $this->input->post('course-name', TRUE),
            'program_id' => $this->input->post('program', TRUE),
            'category_id' => $this->input->post('category', TRUE),
            'topic_id' => $topic_id,
            'description' => $this->input->post('course-description', TRUE),
            //'requirements' => $this->input->post('course-requirements', TRUE),
            //'audience' => $this->input->post('course-audience', TRUE),
            'slug' => $this->input->post('slug', TRUE)
        );
        $insert = $this->Common->add_to_table('product_online_course', $data);
        $this->set_session_response_no_redirect('insert', $insert);
        
        redirect('online_course/view');
    }
    
    // admin function untuk update online course
    function update_online_course() {
        $this->check_user_access();
        $online_course_id = $this->input->post('id', TRUE);

        //cek topic
        $topic_submit = $this->input->post('topic', TRUE);
        $topic_id = $this->insert_topic($topic_submit);
        
        // insert to courses
        $data = array(
            'course_code' => strtoupper($this->input->post('course-code', TRUE)),
            'course_name' => $this->input->post('course-name', TRUE),
            'program_id' => $this->input->post('program', TRUE),
            'category_id' => $this->input->post('category', TRUE),
            'topic_id' => $topic_id,
            'description' => $this->input->post('course-description', TRUE),
            //'requirements' => $this->input->post('course-requirements', TRUE),
            //'audience' => $this->input->post('course-audience', TRUE),
            'slug' => $this->input->post('slug', TRUE)
        );
        $upd_course = $this->Common->update_data_on_table('product_online_course', 'id', $online_course_id, $data);
        $this->set_session_response_no_redirect('update', $upd_course);

        redirect('online_course/view');
    }
    
    // admin function untuk menghapus online course
    function delete_course() {
        $this->check_user_access();
        $delete = $this->Common->delete_from_table_by_id('product_online_course', 'id', $this->input->get('id', true));

        $this->set_session_response_no_redirect('delete', $delete);

        redirect('online_course/view');
    }
    
    function insert_oc_module() {
        $this->check_user_access();
        
        $data = array(
            'oc_id' => $this->input->post('online-course-id'),
            'name' => $this->input->post('module-name'),
            'description' => $this->input->post('module-description'),
            //'video_id' => $this->input->post('video-id'),
            //'test_id',
            'slug' => $this->input->post('slug', TRUE),
        );
        
        $insert = $this->Common->add_to_table('product_oc_module', $data);
        $this->set_session_response_no_redirect('insert', $insert);
        
        redirect('online_course/module');
 
    }
    
    function update_oc_module() {
        $this->check_user_access();
        $module_id = $this->input->post('id', TRUE);
        
        // insert to module
        $data = array(
            'oc_id' => $this->input->post('online-course-id'),
            'name' => $this->input->post('module-name'),
            'description' => $this->input->post('module-description'),
            'video_id' => $this->input->post('video-id'),
            //'test_id',
            'slug' => $this->input->post('slug'),
        );
        $upd_module = $this->Common->update_data_on_table('product_oc_module', 'id', $module_id, $data);
        $this->set_session_response_no_redirect('update', $upd_module);

        redirect('online_course/module');
    }
    
    function delete_oc_module() {
        $this->check_user_access();
        $delete = $this->Common->delete_from_table_by_id('product_oc_module', 'id', $this->input->post('id', true));

        $this->set_session_response_no_redirect('delete', $delete);

        redirect('online_course/module');
    }
    
    function insert_topic($topic_submit) {
        $this->check_user_access();
        $topic_id = "";
        $topic_exist = $this->Online_course_m->get_topic(array('name' => $topic_submit));
        
        if ($topic_exist) {
            $topic_id = $topic_exist->id;
        } else {
            $data = array(
                'category_id' =>$this->input->post('category', TRUE),
                'name' => $topic_submit,
                'slug' => $this->slug_formatter($topic_submit)
            );
            $insert = $this->Common->add_to_table('product_oc_topic', $data);
            if ($insert) {
                $topic_id = $insert->output;
            } else {
                //error insert topic
                //echo $insert->output;
            }
        }
        
        return $topic_id;
    }
    
    //simpan konten video online course
    function save_oc_content() {
        $product_id = $this->input->post('product_id');
        $contents = $this->input->post('contents');
        
        foreach ($contents as $c) {
            $data = array(
                'product_id' => $product_id,
                'video_id' => $c
            );
            //save each data 
            $res = $this->Online_course_m->save_oc_content($data);      
            if (!$res) {
                echo "false";
                break;
            }
        }
        
    }
    
    function add_oc_content() {
        $data = array(
            'video_id' => $this->input->post('video_id'),
            'product_id' => $this->input->post('product_id'),
        );
               
        $res = $this->Online_course_m->save_oc_content($data);
        if ($res) {
            echo "true";
            
        } else {
            echo "false";
        }
    }
    
    function remove_oc_content() {
        $id = $this->input->post('id');
        $res = $this->Online_course_m->delete_oc_content($id);
        if ($res) {
            echo "true";
            
        } else {
            echo "false";
        }
        
        //echo $id;
    }
    
    //simpan harga online course
    function save_oc_price() {
        $product_id = $this->input->post('product_id');
        $price = $this->input->post('price');
        $data = array(
          'product_id' => $product_id,
          'price' => $price
        );
        $res = $this->Online_course_m->save_oc_price($data);    
        echo $res;
    }
    
    /* End Admin Pages */
    
    public function get_course_by_id() {
        $get = $this->Online_course_m->get_online_courses(array('id' => $this->uri->segment(3)));
        $data = $get->row();

        $response = array(
            'id' => $data->id,
            'course_code' => $data->course_code,
            'course_name' => $data->course_name,
            'description' => $data->description,
            //'requirements' => $data->requirements,
            //'audience' => $data->audience,
            'slug' => $data->slug,
            'program_id' => $data->program_id
        );

        echo json_encode($response);
    }

    function get_online_course_by_program($prog_id) {
        $get = $this->Online_course_m->get_online_courses(array('c.program_id' => $prog_id));
        //echo $this->db->last_query();
        $response = array();
        if ($get <> false)
            foreach ($get->result() as $data) {
                $response[] = array(
                    'id' => $data->id,
                    'course_code' => $data->course_code,
                    'course_name' => $data->course_name,
                    'description' => $data->description,
                    //'requirements' => $data->requirements,
                    //'audience' => $data->audience,
                    'slug' => $data->slug
                );
            }

        echo json_encode($response);
    }

    function get_videos() {
        $get = $this->Online_course_m->get_videos();
        $response = array();
        if ($get <> false)
            foreach ($get->result() as $data) {
                $response[] = array(
                    'id' => $data->id,
                    'title' => $data->title,
                    'filename' => $data->filename,
                    'videoimage' => $data->videoimage,
                    'duration' => $data->duration,
                    'description' => $data->description,
                    'entry_date' => $data->entry_date
                );
            }
        echo json_encode($response);
    }
    
    function get_video_by_id($id) {
        $get = $this->Online_course_m->get_videos(array('id' => $id));

        $data = $get->row();

        $response = array(
            'id' => $data->id,
            'title' => $data->title,
            'filename' => $data->filename,
            'videoimage' => $data->videoimage,
            'duration' => $data->duration,
            'description' => $data->description,
            'entry_date' => $data->entry_date
        );
        return $response;
    }
    
    function get_video_by_id_ajax($id) {
        $response = $this->get_video_by_id($id);
        
        echo json_encode($response);
    }
    
    function get_product_content($oc_id) {
        $get = $this->Online_course_m->get_oc_content(array('product_id' => $oc_id));

        $response = array();
        if ($get <> false)
            foreach ($get->result() as $data) {
                $response[] = array(
                    'id' => $data->id,
                    'video_id' => $data->video_id,
                    'product_id' => $data->product_id,
                    'title' => $data->title,
                    'filename' => $data->filename,
                    'videoimage' => $data->videoimage,
                    'duration' => $data->duration,
                    'description' => $data->description,
                    'entry_date' => $data->entry_date
                );
            }
        return $response;
    }
    
    function get_product_content_ajax($oc_id) {
        $response = $this->get_product_content($oc_id);
        
        echo json_encode($response);
    }
    
    function get_oc_price($product_id) {
       $get = $this->Online_course_m->get_oc_price(array('product_id' => $product_id));
       
       $data = $get->row();

        $response = array(
            'id' => $data->id,
            'product_id' => $data->product_id,
            'price' => $data->price,
            'entry_date' => $data->entry_date,
        );
        return $response;
    }
    
    function get_oc_price_ajax($product_id) {
        echo json_encode($this->get_oc_price($product_id));
    }
    
    function get_oc_module($filter_array = null) {
               
        $get = $this->Online_course_m->get_modules($filter_array);
        //echo ($get);
        $response = array();
        if ($get <> false)
            foreach ($get->result() as $data) {
                $response[] = array(
                    'course' => $data->course_name,
                    'name' => $data->name,
                    'description' => $data->description,

                );
            }
        return $response;
    }
    
    function get_oc_module_by_id($id) {
        
    }
    
    function get_oc_module_ajax() {

        $response = $this->get_oc_module();
        echo json_encode($response);
    }
    
    function get_oc_module_by_program_ajax($program_id) {
        $filter_array = array(
            'program_id' => $program_id
        );
        
        $response = $this->get_oc_module($filter_array);
        //echo $this->db->last_query();
        echo json_encode($response);
    }
    
    //halaman katalog online course dari sisi front end
    function catalog() {
        //$data['career'] = $this->Content_m->get_career_posts($this->session->userdata('language'));
        $data['sub_page_title'] = $this->lang->line('online_course');

        //$data['counted_tutors_in_programs'] = $this->Course_m->count_verified_tutor_courses_under_programs();

        $data['page_title'] = $this->lang->line('online_course');
        $this->open_page('catalog_online_course', $data);
    }

}
