<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Payroll</a></li>
			<li class="active"><a href="#">Calculation</a></li>
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
								<th>Tutor</th>
								<th>Student</th>
								<th>Enrollment</th>
								<th>Course</th>
								<th>Absence (In)</th>
								<th>Not Signed Absence</th>
								<th>Valid Absence</th>
								<th>Valid Hours</th>
								<th>Validation</th>
							</tr>
						</thead>
						<tbody>
							<?php if($data_monitoring<>false)
								foreach($data_monitoring->result() as $row){
									// get info of the course
									$course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
							?>
							<tr>
								<td>
									<p><strong>ID: <?php echo $row->teacher_id; ?></strong></p>
									<p><?php echo $row->teacher_name; ?></p>
								</td>
								<td>
									<p><strong>ID: <?php echo $row->student_id; ?></strong></p>
									<p>
									<?php
										$student_info = $this->User_m->get_user_by_id($row->student_id);
										echo $student_info->first_name.' '.$student_info->last_name; 
									?>		
									</p>
								</td>
								<td>
									<a href="<?php echo base_url('course/enrollment_detail?id='.$row->enroll_id);?>">
										<?php echo $row->enroll_id ?>
									</a>
								</td>
								<td><strong><?php echo $course_info->row()->program_name ?></strong> - <i><?php echo $course_info->row()->course_name ?></i></td>
								<td>
									<?php 
									$counted_monitoring = $this->Payroll_m->count_counted_monitoring_not_final($row->enroll_id, $date_param);
									echo $counted_monitoring;
									?>
								</td>
								<td>
									<?php 
									$counted_ok_monitoring = $this->Payroll_m->count_counted_monitoring_not_final($row->enroll_id, $date_param, true);
									echo $counted_monitoring - $counted_ok_monitoring;
									?>
								</td>
								<td>
									<?php 
									$counted_valid_monitoring = $this->Payroll_m->count_counted_valid_monitoring_not_final($row->enroll_id, $date_param);
									echo $counted_valid_monitoring;
									?>
								</td>
								<td>
									<?php 
									$counted_total_hours = $this->Payroll_m->count_counted_valid_monitoring_not_final($row->enroll_id, $date_param, true);
									echo $counted_total_hours;
									?>
								</td>
								<td><a href="<?php echo base_url('payroll/monitoring_validation?id='.$row->enroll_id);?>"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
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
