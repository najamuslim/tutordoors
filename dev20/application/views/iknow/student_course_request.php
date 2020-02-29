    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-9 col-md-push-3">
                    <h2><?php echo $sub_page_title; ?></h2>
                    <div class="warning-box">
                        <i class="fa fa-exclamation-triangle"></i> <?php echo $this->lang->line('notes_in_request_course') ?>
                    </div>
                	<div class="profile-box editing">
                        <h2><?php echo $this->lang->line('course_request_info') ?></h2>
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
                                <?php if($open_request<>false) {
                                    foreach($open_request->result() as $order){
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