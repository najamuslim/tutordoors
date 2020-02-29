<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
			<h1>
				Running Course Monitoring
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Course</a></li>
				<li class="active"><a href="#">Running</a></li>
			</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<div class="box box-info">
		    	    <div class="box-header">
						List
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Enroll ID</th>
									<th>Order ID</th>
									<th>Course</th>
									<th>Tutor</th>
									<th>Student</th>
									<th>City</th>
									<th>Progress Absensi</th>
								</tr>
							</thead>
							<tbody>
								<?php if($running_course<>false)
									foreach($running_course->result() as $row){
										// get info of the course
										$course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
                                        
	                                    // get city
	                                    $city_info = $this->Location_m->get_city(array('c.city_id' => $row->city_id));
	                                    // teacher & student info
	                                    $teacher_info = $this->User_m->get_user_info($row->teacher_id);
	                                    $student_info = $this->User_m->get_user_info($row->student_id);
								?>
								<tr>
									<td>
										<a href="<?php echo base_url('course/enrollment_detail?id='.$row->enroll_id);?>"><?php echo $row->enroll_id;?>
										</a>
									</td>
									<td><?php echo $row->order_id;?></td>
									<td><?php echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;?></td>
									<td><?php echo $teacher_info->first_name.' '.$teacher_info->last_name ?></td>
									<td><?php echo $student_info->first_name.' '.$student_info->last_name ?></td>
									<td><?php echo $city_info->row()->city_name; ?></td>
									<td>
										<?php 
											$progress = ($row->row_monitoring==0 ? 0 : ceil($row->monitoring_ok / $row->row_monitoring * 100)); 
											if($progress<50) $progress_bar_color = 'yellow';
											else if($progress >= 50 and $progress < 80) $progress_bar_color = 'aqua';
											else $progress_bar_color = 'green';
										?>
										<div class="progress">
						                    <div class="progress-bar progress-bar-<?php echo $progress_bar_color;?>" role="progressbar" aria-valuenow="<?php echo $progress;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress;?>%">
						                      <!-- <span class="sr-only"><?php echo $progress;?>% Complete (success)</span> -->
						                    </div>
						                </div>
										<?php echo $progress;?>% Complete
									</td>
								</tr>
								<?php }	?>	
							</tbody>
		          		</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
</body>
</html>
