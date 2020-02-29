    <!--BANNER START-->
    <!-- <div class="page-heading">
    	<div class="container">
            <h2><?php echo $sub_page_title; ?></h2>
        </div>
    </div> -->
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-9 col-md-push-3">
                    <h2><?php echo $sub_page_title; ?></h2>
                    <div class="row">
                    <?php 
                    $check_picture = ($image_thumb=="" ? 0 : 1);
                    $check_phone = ($user_info->phone_1=="" ? 0 : 1);

                    if($check_picture==0 or $check_phone==0){
                     ?>
                        <div class="col-md-12">
                            <div class="warning-box">
                                <ul class="fa-ul">
                                    <?php if($check_picture==0) {?>
                                    <li><i class="fa-li fa fa-exclamation-triangle"></i> <?php echo $this->lang->line('profile_picture_not_set') ?></li>
                                    <?php } if($check_phone==0) {?>
                                    <li><i class="fa-li fa fa-exclamation-triangle"></i> <?php echo $this->lang->line('profile_profile_not_set') ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                        <div class="col-md-6">
                            <!--PROFILE IMAGE START-->
                            <div class="profile-box profile-view" style="margin-top: 0px;">
                                <?php 
                                    $photo_name = $this->Media_m->get_file_name($user_info->photo_primary_id);
                                 ?>
                                <a href="#"><img class="img-circle" src="<?php echo UPLOAD_IMAGE_DIR.'/'.$photo_name;?>" width="140" height="140" alt="Foto Profil"></a>
                                <div class="text">
                                  <!-- <p style="margin-bottom:10px">Hi,</p> -->
                                    <p style="margin-top:10px"><?php echo $this->session->userdata('fn').' '.$this->session->userdata('ln'); ?></p>
                                    <p style="margin-top:10px">ID: <?php echo $user_info->key_user_id; ?></p>
                                    <p style="margin-top:10px"><a href="<?php echo base_url('users/view_profile')?>"><?php echo $this->lang->line('profile_full_info') ?>..</a></p>
                                </div>
                            </div>
                              <!--PROFILE IMAGE END-->
                        </div>
                        <div class="col-md-12" style="margin-top: 30px">
                            <?php if($invoices<>false) {?>
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('invoice_open') ?></h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <td><?php echo $this->lang->line('invoice_id') ?></td>
                                            <td><?php echo $this->lang->line('total') ?></td>
                                            <td><?php echo $this->lang->line('due_date') ?></td>
                                            <td><?php echo $this->lang->line('choose_payment_method') ?></td>
                                            <!-- <td></td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($invoices<>false) {
                                            foreach($invoices->result() as $inv){?>
                                        <tr>
                                            <td><strong><?php echo $inv->invoice_id; ?></strong></td>
                                            <td>IDR <?php echo number_format($inv->total, 0, ',', '.'); ?></td>
                                            <td><?php echo date_format(new DateTime($inv->due_date), 'd M Y H:i:s'); ?></td>
                                            <td>
                                                <a style="color: #333" href="<?php echo base_url('student/invoice')?>"><i class="fa fa-location-arrow"></i> <?php echo $this->lang->line('pay_now')?>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-12" style="margin-top: 30px">
                            <!-- course status, student only -->
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('course_request') ?></h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <td><?php echo $this->lang->line('id') ?></td>
                                            <td><?php echo $this->lang->line('teacher') ?></td>
                                            <td><?php echo $this->lang->line('course') ?></td>
                                            <td><?php echo $this->lang->line('status') ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($course_order<>false) {
                                            foreach($course_order->result() as $order){
                                                $order_course = $this->Order_m->get_order_courses($order->order_id);
                                                $course_tutor = $this->Order_m->get_order_courses_distinct_tutor($order->order_id);
                                                // print_r($this->db->last_query());
                                                $courses = '';
                                                $tutors = '';
                                                $cnt = $cnt_t = 1;

                                                if($order_course<>false)
                                                {
                                                    foreach($order_course->result() as $course){
                                                        // get info of the course
                                                        $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));

                                                        $courses .= $cnt.'. '.$course_info->row()->program_name.' - '.$course_info->row()->course_name.'<br>';
                                                        // get days
                                                        $day_string = $this->course_lib->get_days_string($course->days);
                                                        // additional modules
                                                        $modules = $this->course_lib->get_additional_module($course);

                                                        $cnt++;
                                                    }
                                                }
                                                if($course_tutor<>false)
                                                {
                                                    foreach($course_tutor->result() as $tutor){
                                                        $user_info = $this->User_m->get_user_info($tutor->teacher_id);
                                                        $tutors .= $cnt_t.'. '.$user_info->first_name.' '.$user_info->last_name.'<br>';
                                                    }
                                                }
                                                    
                                        ?>
                                        <tr>
                                            <td><?php echo $order->order_id ?></td>
                                            <td><?php echo $tutors; ?></td>
                                            <td><?php echo $courses; ?></td>
                                            <td><?php echo $order->order_status; ?></td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ./ course status, student only -->
                        </div>

                        <div class="col-md-8" style="margin-top: 30px">
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('course_schedule'); ?></h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <td><?php echo $this->lang->line('course') ?></td>
                                            <td><?php echo $this->lang->line('course_schedule') ?></td>
                                            <td>
                                                <?php 
                                                echo $this->lang->line('teacher');
                                                ?>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if($schedule<>false) {
                                            foreach($schedule->result() as $sche){
                                                $order_course = $this->Order_m->get_order_with_course($sche->order_id, $sche->course_id);
                                                // get info of the course
                                                $course_info = $this->Course_m->get_courses(array('c.id' => $sche->course_id));
                                                // get days
                                                $day_string = $this->course_lib->get_days_string($order_course->days);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;
                                                ?>
                                            </td>
                                            <td>
                                                <p><?php echo $day_string ?></p>
                                            </td>
                                            <td>
                                                <?php 
                                                $user_info = $this->User_m->get_user_info($sche->teacher_id);
                                                
                                                echo '<p>'.$user_info->first_name.' '.$user_info->last_name.'</p>';
                                                echo '<p><i class="fa fa-phone"></i> '.$user_info->phone_1.'</p>';
                                                ?>
                                            </td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-md-pull-9">
                    <?php $this->load->view('iknow/sidebar_menu'); ?>
                    
                </div>
            </div>
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->