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
                    // get open city fo course
                    $check_city = $this->Teacher_m->get_open_city('oc.user_id', $this->session->userdata('userid'));

                    // get open course
                    $check_course = $this->Teacher_m->get_course_data_by_userid($this->session->userdata('userid'));

                    if($check_picture==0 or $check_phone==0 or $user_info->verified_user=="0" or $check_city==false or $check_course==false){
                     ?>
                        <div class="col-md-12">
                            <div class="warning-box">
                                <ul class="fa-ul">
                                    <?php 
                                    if($check_picture==0)
                                        echo '<li><i class="fa-li fa fa-exclamation-triangle"></i> '.$this->lang->line('profile_picture_not_set').'</li>';
                                    if($check_phone==0)
                                        echo '<li><i class="fa-li fa fa-exclamation-triangle"></i> '.$this->lang->line('profile_profile_not_set').'</li>';
                                    if($check_city==false)
                                        echo '<li><i class="fa-li fa fa-exclamation-triangle"></i> '.$this->lang->line('profile_city_not_set').'</li>';
                                    if($check_course==false)
                                        echo '<li><i class="fa-li fa fa-exclamation-triangle"></i> '.$this->lang->line('profile_course_not_set').'</li>';
                                    if($user_info->verified_user == "0")
                                        echo '<li><i class="fa-li fa fa-exclamation-triangle"></i> '.$this->lang->line('account_not_verified_yet').'</li>';
                                    ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                        <div class="col-md-6">
                            <!--PROFILE IMAGE START-->
                            <div class="profile-box profile-view" style="margin-top: 0px;">
                                <!-- <div class="thumb"> -->
                                    <?php 
                                    $photo_name = $this->Media_m->get_file_name($user_info->photo_primary_id);
                                     ?>
                                    <a href="#"><img class="img-circle" src="<?php echo UPLOAD_IMAGE_DIR.'/'.$photo_name;?>" width="140" height="140" alt="Foto Profil"></a>
                                <!-- </div> -->
                                <div class="text">
                                  <!-- <p style="margin-bottom:10px">Hi,</p> -->
                                    <p style="margin-top:10px"><?php echo $this->session->userdata('fn').' '.$this->session->userdata('ln'); ?></p>
                                    <p style="margin-top:10px">ID: <?php echo $user_info->key_user_id; ?></p>
                                    <p style="margin-top:10px">Fee /1.5h: IDR <?php echo number_format($user_info->salary_per_hour, 0, '.', ','); ?></p>
                                    <p style="margin-top:10px"><a href="<?php echo base_url('users/view_profile')?>"><?php echo $this->lang->line('profile_full_info') ?>..</a></p>
                                </div>
                            </div>
                              <!--PROFILE IMAGE END-->
                        </div>
                        <div class="col-md-6">
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('course_schedule'); ?></h2>
                                <table>
                                    <tbody>
                                        <?php 
                                        if($schedule<>false) {
                                            $cnt = 0;
                                            foreach($schedule->result() as $sche){
                                                if($cnt>1)
                                                    break;
                                                $order_course = $this->Order_m->get_order_with_course($sche->order_id, $sche->course_id);
                                                // get info of the course
                                                $course_info = $this->Course_m->get_courses(array('c.id' => $sche->course_id));
                                                // get days
                                                $day_string = $this->course_lib->get_days_string($order_course->days);
                                                // get student info
                                                $user_info = $this->User_m->get_user_info($sche->student_id);

                                                $cnt++;
                                        ?>
                                        <tr>
                                            <td>
                                                <p><?php echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;?></p>
                                                <p><?php echo $this->lang->line('day').': '.$day_string ?></p>
                                                <p><?php echo $this->lang->line('student').': '.$user_info->first_name.' '.$user_info->last_name ?></p>
                                                <p><?php echo '<i class="fa fa-phone"></i> '.$user_info->phone_1 ?></p>
                                            </td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                    <?php 
                                    if($schedule<>false)
                                        if($schedule->num_rows() > 2){
                                    ?>
                                    <tfoot>
                                        <tr>
                                            <td><a href="<?php echo base_url('teacher/teach_schedule')?>">More..</a></td>
                                        </tr>
                                    </tfoot>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8" style="margin-top: 30px">
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('course_request_new') ?></h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <td><?php echo $this->lang->line('id') ?> / <?php echo $this->lang->line('city') ?></td>
                                            <td><?php echo $this->lang->line('course') ?></td>
                                            <td><?php echo $this->lang->line('student_detail') ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($open_request<>false) {
                                            foreach($open_request->result() as $order){

                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $order->order_id; ?></strong>
                                                <p><?php echo $order->city_name; ?></p>
                                                <p><strong><?php echo $this->lang->line('order_time')?>:</strong><br> <?php echo date_format(new DateTime($order->entry_date), 'd M Y H:i')?></p>
                                            </td>
                                            <td>
                                                <?php 
                                                // get courses by order id
                                                $courses = $this->Order_m->get_order_courses($order->order_id);
                                                if($courses<>false)
                                                {
                                                    echo '<ol>';
                                                    foreach($courses->result() as $course){
                                                        // get info of the course
                                                        $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                                                        echo '<li>'.$course_info->row()->program_name.' - '.$course_info->row()->course_name.'</li>';
                                                    }
                                                    echo '</ol>';
                                                }
                                                ?>
                                                <p><?php echo '<strong>'.$this->lang->line('at').':</strong> '.($order->address_course_held=="" ? "-" : $order->address_course_held); ?></p>
                                                <p><strong><?php echo $this->lang->line('date_start')?>:</strong> <?php echo date_format(new DateTime($order->start_date), 'd M Y')?></p>
                                            </td>
                                            <td>
                                                <div class="open-course-detail">
                                                    <p><strong><?php echo $this->lang->line('name')?>:</strong> <?php echo $order->first_name.' '.$order->last_name; ?></p>
                                                    <p><strong><?php echo $this->lang->line('phone')?>:</strong> <?php echo $order->phone_1; ?></p>
                                                    <p><strong><?php echo $this->lang->line('email')?>:</strong> <?php echo $order->email_login; ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-md-4" style="margin-top: 30px">
                            
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