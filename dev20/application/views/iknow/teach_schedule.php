    <!--CONTANT START-->
    <div class="contant">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-push-3">
                    <div class="profile-box editing">
                        <h2><?php echo $sub_page_title; ?></h2>
                        <table>
                            <thead>
                                <tr>
                                    <td><?php echo $this->lang->line('enroll_id') ?></td>
                                    <td><?php echo $this->lang->line('course') ?></td>
                                    <td><?php echo $this->lang->line('course_schedule') ?></td>
                                    <td>
                                        <?php 
                                        if($level=="student") echo $this->lang->line('teacher');
                                        else if($level=="teacher") echo $this->lang->line('student');
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
                                        <strong><?php echo $sche->enroll_id; ?></strong><br>
                                    </td>
                                    <td>
                                        <?php 
                                        echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;
                                        ?>
                                    </td>
                                    <td>
                                        <p><?php echo str_replace(',', ', ', $day_string) ?></p>
                                    </td>
                                    <td>
                                        <?php 
                                        if($level=="student")
                                            $user_info = $this->User_m->get_user_info($sche->teacher_id);
                                        else if($level=="teacher")
                                            $user_info = $this->User_m->get_user_info($sche->student_id);

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
                <div class="col-md-3 col-md-pull-9">
                    <?php include('sidebar_menu.php'); ?>
                </div>
            </div>
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->