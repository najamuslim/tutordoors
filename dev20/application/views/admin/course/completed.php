<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Enrollment</a></li>
			<li class="active"><a href="#">Completed</a></li>
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
								<th>Enrollment</th>
								<th>Course</th>
								<th>City</th>
								<th>Tutor</th>
								<th>Student</th> 
							</tr>
						</thead>
						<tbody>
							<?php if($completed_course<>false)
								foreach($completed_course->result() as $row){
									$order_course = $this->Order_m->get_order_with_course($row->order_id, $row->course_id);
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
									<a href="<?php echo base_url('course/enrollment_detail?id='.$row->enroll_id);?>">
									<?php echo $row->enroll_id; ?>
									</a>
								</td>
								<td><?php echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;?></td>
								<td><?php echo $city_info->row()->city_name; ?></td>
								<td><?php echo $teacher_info->first_name.' '.$teacher_info->last_name ?></td>
								<td><?php echo $student_info->first_name.' '.$student_info->last_name ?></td>
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
