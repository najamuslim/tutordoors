<!-- <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo GENERAL_CSS_DIR;?>/jquery.tagsinput.css" /> -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Validation
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Payroll</a></li>
			<li><a href="#">Calculation</a></li>
			<li class="active"><a href="#">Validation</a></li>
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
							<?php 
								// get info of the course
								$course_info = $this->Course_m->get_courses(array('c.id' => $detail->course_id));
                                // get city
                                $city_info = $this->Location_m->get_city(array('c.city_id' => $detail->city_id));

                                $order_course = $this->Order_m->get_order_with_course($detail->order_id, $detail->course_id);
                                // get days
                                $day_string = $this->course_lib->get_days_string($order_course->days);
                            ?>
							<div class="col-md-6">
								<label class="col-md-4 text-left">Enroll ID</label>
								<p class="col-md-8"><?php echo $detail->enroll_id;?></p>

								<label class="col-md-4 text-left">Order ID</label>
								<p class="col-md-8"><?php echo $detail->order_id;?></p>

								<label class="col-md-4 text-left">Course</label>
								<p class="col-md-8">
									
                                    <strong><?php echo $course_info->row()->program_name ?></strong> - <i><?php echo $course_info->row()->course_name ?></i>
								</p>

								<label class="col-md-4 text-left">City</label>
								<p class="col-md-8"><?php echo $city_info->row()->city_name;?></p>
								
								<label class="col-md-4 text-left">Days</label>
								<p class="col-md-8"><?php echo $day_string;?></p>

								<label class="col-md-4 text-left">Session</label>
								<p class="col-md-8"><?php echo $order_course->session_hour.' '.$this->lang->line('hour');?></p>
							</div>
							<div class="col-md-6">
								<label class="col-md-4 text-left">Tutor</label>
								<p class="col-md-8"><?php echo $detail->teacher_fn.' '.$detail->teacher_ln;?></p>

								<label class="col-md-4 text-left">Student</label>
								<p class="col-md-8"><?php echo $detail->student_fn.' '.$detail->student_ln;?></p>

								<label class="col-md-4 text-left">Address of Held Course</label>
								<p class="col-md-8"><?php echo $detail->address_course_held;?></p>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-xs-12">
				<div class="box box-success">
		          	<form method="POST" action="<?php echo base_url('payroll/validate_absence') ?>">
			          	<div class="box-header">
							<h3 class="box-title">Absence Monitoring
							</h3>
			          	</div><!-- /.box-header -->
			          	<div class="box-body no-padding">
							<table class="table table-condensed">
			                    <tr>
	                                <td style="text-align:left" width="60px">
	                                	<input type="checkbox" id="check-all"><br> Check All
	                                </td>
	                                <td>Teaching Time</td>
	                                <td>Counted Hours</td>
	                                <td>Correction of Total Hours<br>Use dot(.) for decimal</td>
	                                <td>Student Absence</td>
	                                <td>Tutor Absence</td>
	                                <td>Status</td>
	                            </tr>
			                    <?php if($absence<>false) {
	                                    foreach($absence->result() as $course){?>
	                            <tr>
	                            	<td><input type="checkbox" name="check[]" value="<?php echo $course->monitoring_id;?>"></td>
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
	                                <td>
	                                	<input type="text" class="form-control" maxlength="1" name="hours[]" value="<?php echo $hours ?>">
	                                </td>
	                                <td>
	                                	<?php if($course->student_entry=='true') echo '<i class="fa fa-check fa-2x" style="color: #0000FF"></i>';?>
	                                	<br>
	                                	<?php echo ($course->student_entry_timestamp<>'' ? date_format(new DateTime($course->student_entry_timestamp), 'd M Y H:i') : ''); ?>
	                                </td>
	                                <td>
	                                	<?php if($course->teacher_entry=='true') echo '<i class="fa fa-check fa-2x" style="color: #0000FF"></i>';?>
	                                	<br>
	                                	<?php echo ($course->teacher_entry_timestamp<>'' ? date_format(new DateTime($course->teacher_entry_timestamp), 'd M Y H:i') : ''); ?>
	                                </td>
	                                <td>
	                                	<?php 
	                                		if($this->Payroll_m->get_validation_status_of_monitoring_id($course->monitoring_id))
	                                			echo '<i class="fa fa-check fa-2x" style="color: #FF0000"></i>';
	                                	?>
	                                </td>
	                            </tr>
	                            <?php }} ?>
			                </table>
			          	</div><!-- /.box-body -->
			          	<div class="box-footer">
				        	<button class="btn btn-primary" type="submit">Validasi</button>
				        </div>
			    	</form>
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
		
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<script>
	$("#check-all").change(function () {
	    $("input:checkbox[name='check[]']").prop('checked', $(this).prop("checked"));
	});
</script>
</body>
</html>
