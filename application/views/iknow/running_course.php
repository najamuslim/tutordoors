    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-9 col-md-push-3">
                    <h2><?php echo $sub_page_title; ?></h2>
                    <?php if($this->session->userdata('level')=="teacher") {?>
                    <div class="warning-box">
                        <i class="fa fa-exclamation-triangle"></i> <?php echo $this->lang->line('course_running_hint') ?>
                    </div>
                    <?php } ?>
                	<div class="profile-box editing">
                        <h2><?php echo $this->lang->line('course_running_info') ?></h2>
                        <table>
                            <thead>
                                <tr> 
                                    <td><?php echo $this->lang->line('course') ?></td>
                                    <td><?php echo $this->lang->line('detail') ?></td>
                                    <td>
                                        <?php 
                                        if($level=="student") echo $this->lang->line('teacher');
                                        else if($level=="teacher") echo $this->lang->line('student');
                                        ?>
                                    </td>
                                    <td><?php echo $this->lang->line('action') ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                if($running_course<>false) {
                                    foreach($running_course->result() as $course){
                                        // get info of the course
                                        $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                                        // get order course detail
                                        $order_course = $this->Order_m->get_order_with_course($course->order_id, $course->course_id);
                                        // fetch days
                                        $days = $this->course_lib->get_days_string($order_course->days);
                                        // get student info data
                                        $student_info = $this->User_m->get_user_info_data($course->student_id);
                                ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $course->enroll_id; ?></strong><br>
                                        <p>
                                            <?php 
                                              echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;
                                            ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p><strong><?php echo $this->lang->line('city') ?>:</strong> <?php echo $course->city_name; ?></p>
                                        <p><strong><?php echo $this->lang->line('day') ?>:</strong> <?php echo $days; ?></p>
                                        <p><strong><?php echo $this->lang->line('class_face_to_face') ?>:</strong> <?php echo $order_course->class_in_month; ?>x</p>
                                        <p><strong><?php echo $this->lang->line('session_given_by_tutor') ?>:</strong> <?php echo $order_course->session_hour; ?> <?php echo $this->lang->line('hour') ?></p>
                                    </td>
                                    <td>
                                        <?php 
                                        if($level=="student"){
                                            echo '<p>'.$course->teacher_fn.' '.$course->teacher_ln.'</p>';
                                            echo '<p><i class="fa fa-phone"></i> '.$course->phone_1.'</p>';
                                        }
                                        else if($level=="teacher"){
                                            echo '<p>'.$course->student_fn.' '.$course->student_ln.'</p>';
                                            echo '<p><i class="fa fa-phone"></i> '.$student_info->phone_1.'</p>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <p><a href="<?php echo base_url('frontpage/fill_course_monitoring/'.$course->enroll_id) ?>"><i class="fa fa-pencil"></i> Set Presence</a></p>
                                        <?php if($this->session->userdata('level')=="teacher") {?>
                                        <p><a style="color:#ff0000" href="<?php echo base_url('course/complete_course/'.$course->enroll_id) ?>"><i class="fa fa-check"></i> Complete</a></p>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3 col-md-pull-9">
                    <?php include('sidebar_menu.php'); ?>
                </div>
            </div>
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->