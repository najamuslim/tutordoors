    <!--BANNER START-->
    <div class="page-heading">
    	<div class="container">
            <h2><?php echo $sub_page_title; ?></h2>
            <!-- <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</p> -->
        </div>
    </div>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-9 col-md-push-3">
                	<div class="profile-box editing">
                        <h2><?php echo $this->lang->line('course_completed') ?></h2>
                        <table>
                            <thead>
                                <tr>
                                    <td><?php echo $this->lang->line('id') ?></td>
                                    <td><?php echo $this->lang->line('city') ?></td>
                                    <td>
                                        <?php 
                                        if($level=="student") echo $this->lang->line('teacher');
                                        else if($level=="teacher") echo $this->lang->line('student');
                                        ?>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($completed_course<>false) {
                                    foreach($completed_course->result() as $course){?>
                                <tr>
                                    <td>
                                        <strong><?php echo $course->enroll_id; ?></strong><br>
                                        <p>
                                            <?php 
                                            $order = $this->Order_m->get_order_course_by_id($course->order_id); 
                                            echo str_replace(',', ', ', $order->courses);
                                            ?>
                                        </p>
                                    </td>
                                    <td><?php echo $course->city_name; ?></td>
                                    <td>
                                        <?php 
                                        if($level=="student"){
                                            echo '<p>'.$course->teacher_fn.' '.$course->teacher_ln.'</p>';
                                            echo '<p><i class="fa fa-phone"></i> '.$course->phone_1.'</p>';
                                        }
                                        else if($level=="teacher"){
                                            echo '<p>'.$course->student_fn.' '.$course->student_ln.'</p>';
                                            echo '<p><i class="fa fa-phone"></i> '.$course->phone_1.'</p>';
                                        }
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