<!-- <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo GENERAL_CSS_DIR;?>/jquery.tagsinput.css" /> -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Enrollment Detail
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Course</a></li>
			<li><a href="#">Enrollment</a></li>
			<li class="active"><a href="#">Detail</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-info">
		          	<div class="box-header">
						<h3 class="box-title">Summary
						</h3>
		          	</div><!-- /.box-header -->
		          	<div class="box-body no-padding">
						<div class="row">
							<div class="col-md-6">
								<label class="col-md-4 text-left">Enrollment ID</label>
								<p class="col-md-8"><?php echo $detail->enroll_id;?></p>

								<label class="col-md-4 text-left">Order ID</label>
								<p class="col-md-8"><?php echo $detail->order_id;?></p>

								<label class="col-md-4 text-left">Course</label>
								<p class="col-md-8">
									<?php 
										// get info of the course
										$course_info = $this->Course_m->get_courses(array('c.id' => $detail->course_id));
                                        echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;
                                    ?>
								</p>

								<label class="col-md-4 text-left">World Scale</label>
								<p class="col-md-8">
									<?php 
                                        $world_scale = $this->Course_m->get_category_world_scale_by_enroll_id($detail->enroll_id);
                                        echo ucwords($world_scale);
                                    ?>
								</p>

								<label class="col-md-4 text-left">City</label>
								<p class="col-md-8"><?php echo $detail->city_name;?></p>
								
								<?php 
								$order_course = $this->Order_m->get_order_with_course($detail->order_id, $detail->course_id);
								// get days
                      			$day_string = $this->course_lib->get_days_string($order_course->days);
								?>
								<label class="col-md-4 text-left">Days</label>
								<p class="col-md-8"><?php echo $day_string ?></p>

								<label class="col-md-4 text-left">Session</label>
								<p class="col-md-8"><?php echo $order_course->session_hour ?> Hours</p>

								<label class="col-md-4 text-left">Class in a Month</label>
								<p class="col-md-8"><?php echo $order_course->class_in_month ?> Times</p>
							</div>
							<div class="col-md-6">
								<label class="col-md-4 text-left">Tutor</label>
									<p class="col-md-8"><?php echo $detail->teacher_fn.' '.$detail->teacher_ln;?></p>

									<label class="col-md-4 text-left">Student</label>
									<p class="col-md-8"><?php echo $detail->student_fn.' '.$detail->student_ln;?></p>

									<label class="col-md-4 text-left">Address Held</label>
									<p class="col-md-8"><?php echo $detail->address_course_held;?></p>

									<label class="col-md-4 text-left">Progress</label>
	                				<div class="col-md-8">
	                					<?php 
											$progress = ($detail->row_monitoring==0 ? 0 : ceil($detail->monitoring_ok / $detail->row_monitoring * 100)); 
											if($progress<50) $progress_bar_color = 'yellow';
											else if($progress >= 50 and $progress < 80) $progress_bar_color = 'aqua';
											else $progress_bar_color = 'green';
										?>
										<div class="progress">
						                    <div class="progress-bar progress-bar-<?php echo $progress_bar_color;?>" role="progressbar" aria-valuenow="<?php echo $progress;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress;?>%">
						                      <!-- <span class="sr-only"><?php echo $progress;?>% Complete (success)</span> -->
						                    </div>
						                </div>
										<?php echo ceil($progress);?>% Complete
	                				</div>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-xs-12">
				<div class="box box-success">
		          	<div class="box-header">
						<h3 class="box-title">Absence Monitoring
						</h3>
		          	</div><!-- /.box-header -->
		          	<div class="box-body no-padding">
						<table class="table table-condensed">
		                    <tr>
                                <td rowspan="2" style="text-align:center">Absense DateTime</td>
                                <td rowspan="2" style="text-align:center">Duration</td>
                                <td colspan="2" style="text-align:center">Entry by</td>
                                <td colspan="2" style="text-align:center">Entry Timestamp</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Student</td>
                                <td>Tutor</td>
                                <td>Student</td>
                                <td>Tutor</td>
                            </tr>
		                    <?php if($absence<>false) {
                                    foreach($absence->result() as $course){?>
                                <tr>
                                    <td><?php echo date_format(new DateTime($course->teach_date), 'd M Y').' '.date_format(new DateTime($course->time_start), 'H:i').' - '.date_format(new DateTime($course->time_end), 'H:i'); ?></td>
                                    <?php 
	                                	list($hours, $minutes) = explode(':', date_format(new DateTime($course->time_start), 'H:i'));
	                                	$startTimestamp = mktime($hours, $minutes);
	
										list($hours, $minutes) = explode(':', date_format(new DateTime($course->time_end), 'H:i'));
										$endTimestamp = mktime($hours, $minutes);
										
										$seconds = $endTimestamp - $startTimestamp;
										$minutes = ($seconds / 60) % 60;
										$hours = round($seconds / (60 * 60));
	                                 ?>
	                                <td><?php echo $hours.'h '.$minutes.'m'; ?></td>
                                    <td><?php if($course->student_entry=='true') echo '<i class="fa fa-check fa-3x" style="color: #0000FF"></i>';?></td>
                                    <td><?php if($course->teacher_entry=='true') echo '<i class="fa fa-check fa-3x" style="color: #0000FF"></i>';?></td>
                                    <td><?php echo ($course->student_entry_timestamp<>'' ? date_format(new DateTime($course->student_entry_timestamp), 'd M Y H:i') : ''); ?></td>
                                    <td><?php echo ($course->teacher_entry_timestamp<>'' ? date_format(new DateTime($course->teacher_entry_timestamp), 'd M Y H:i') : ''); ?></td>
                                </tr>
                                <?php }} ?>
		                </table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
		
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

</body>
</html>
