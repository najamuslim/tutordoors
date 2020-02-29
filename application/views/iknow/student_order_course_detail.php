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
                                    <td><?php echo $this->lang->line('id').' / '.$this->lang->line('course') ?></td>
                                    <td><?php echo $this->lang->line('tutor') ?></td>
                                    <td><?php echo $this->lang->line('detail') ?></td>
                                    <td><?php echo $this->lang->line('confirmation_status') ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($order_course<>false) {
                                    foreach($order_course->result() as $order){
                                        // get info of the course
                                        $course_info = $this->Course_m->get_courses(array('c.id' => $order->course_id));
                                        
                                        // get days
                                        $day_string = '';
                                        foreach(explode(',', $order->days) as $day)
                                            $day_string .= $this->lang->line('day_'.$day).', ';
                                        $day_string = rtrim($day_string, ', ');

                                        // additional modules
                                        $modules = '';
                                        if($order->module_price>0)
                                            $modules .= $this->lang->line('module_study').', ';
                                        if($order->tryout_price>0)
                                            $modules .= $this->lang->line('module_tryout').', ';
                                        if($modules=="")
                                            $modules = ' - ';
                                        else
                                            $modules = rtrim($modules, ', ');
                                ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $order->order_id?></strong>
                                        <p>
                                          <?php 
                                          echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;
                                          ?>
                                        </p>
                                        <p></p>
                                        <p><strong>Order Time:</strong><br> <?php echo date_format(new DateTime($order->entry_date), 'd M Y H:i')?></p>
                                    </td>
                                    <td>
                                        <div class="open-course-detail">
                                            <p><strong>Name:</strong> <?php echo $order->teacher_fn.' '.$order->teacher_ln; ?></p>
                                            <p><strong>Phone:</strong> <?php echo $order->teacher_phone; ?></p>
                                            <p><strong>Email:</strong> <?php echo $order->teacher_email; ?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="open-course-detail">
                                            <p><strong>City:</strong> <?php echo $order->city_name; ?></p>
                                            <p><strong>Days:</strong> <?php echo $day_string?></p>
                                            <p><strong>Session:</strong> <?php echo $order->session_hour ?> Hours</p>
                                            <p><strong>Class:</strong> <?php echo $order->class_in_month ?> Times</p>
                                            <p><strong>Additional Materials:</strong> <?php echo $modules?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $order->order_course_status ?>
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