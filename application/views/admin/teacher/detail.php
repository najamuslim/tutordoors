<style>
	.dl-horizontal dt{
		margin: 10px 0 10px 0;
		color: #000;
	}
	.dl-horizontal dd{
		padding-top: 10px;
		padding-bottom: 10px;
		color: #000;
	}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo ucwords($teacher_general->first_name) ?>'s Profile
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Tutor</a></li>
			<li class="active"><a href="#">Profile</a></li>
		</ol>
    </section>
	<!-- Main content -->
    <section>
		<div class="row">
			<div class="col-md-10">
				<div class="box box-warning">
          			<div class="box-header with-border">
			            <h3 class="box-title"><i class="fa fa-info-circle"></i> Hint</h3>
			            <div class="box-tools pull-right">
              				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            			</div><!-- /.box-tools -->
          			</div><!-- /.box-header -->
	          		<div class="box-body">
	            		<ol>
			            	<li>Click plus (+) button to expand the panel and minus (-) to collapse the panel</li>
			            </ol>
	          		</div><!-- /.box-body -->
      			</div><!-- /.box -->
			</div>
			<div class="col-md-2">
				<div style="margin-top: 20px">
					<?php if($teacher_general->verified_user=="0") {?>
					<button id="btn-verify" class="btn btn-primary btn-lg">Verify this tutor</button>
					<?php } ?>
					<?php if($teacher_general->verified_user=="1") {?>
					<button id="btn-unverify" class="btn btn-danger btn-lg">Unverify this tutor</button>
					<?php } ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="box box-primary collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Tutor Data</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<dl class="dl-horizontal">
				                    <dt>User ID</dt>
				                    <dd><?php echo $teacher_general->user_id;?></dd>
				                    <dt>Verification</dt>
									<dd><?php echo ($teacher_general->verified_user=="0" ? '<i class="fa fa-times fa-2x" style="color:#ff0000"></i>' : '<i class="fa fa-check fa-2x" style="color:#00ff00"></i>');?></dd>
				                    <dt>First Name</dt>
				                    <dd><?php echo $teacher_general->first_name?></dd>
				                    <dt>Last Name</dt>
				                    <dd><?php echo $teacher_general->last_name;?></dd>
				                    <dt>Salary /1.5 hour</dt>
				                    <dd>IDR <?php echo isset($teacher_info->salary_per_hour) ? number_format($teacher_info->salary_per_hour, 0, ',', '.') : "-" ;?></dd>
				                    <dt>Email</dt>
				                    <dd><?php echo $teacher_general->email_login;?></dd>
				                    <dt>Primary Phone</dt>
				                    <dd><?php echo isset($teacher_info->phone_1) ? $teacher_info->phone_1 : "-" ?></dd>
				                    <dt>Another Phone</dt>
									<dd><?php echo isset($teacher_info->phone_2) ? $teacher_info->phone_2 : "-" ?></dd>
									<dt>Join Date</dt>
									<dd><?php echo date_format(new DateTime($teacher_general->join_date), 'd M Y');?></dd>
									<dt>Birth Date &amp; Place</dt>
									<dd><?php if($teacher_info<>false) echo $teacher_info->birth_place.' '. date_format(new DateTime($teacher_info->birth_date), 'd M Y');?></dd>
									<dt>National Identity</dt>
				                    <dd><?php echo isset($teacher_info->national_card_number) ? $teacher_info->national_card_number : "-" ?></dd>
				                    <dt>Address on ID</dt>
				                    <dd><?php echo isset($teacher_info->address_national_card) ? $teacher_info->address_national_card : "-" ?></dd>
				                    <dt>Domicile Address</dt>
				                    <dd><?php echo isset($teacher_info->address_domicile) ? $teacher_info->address_domicile : "-" ?></dd>
				                </dl>
							</div>
							<div class="col-md-6">
								<dl class="dl-horizontal">
									<dt>Profile Picture</dt>
									<dd>
										<?php if($teacher_info<>false) if($teacher_info->file_name<>"") {?>
										<img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$teacher_info->file_name?>" alt="tutor profile picture" width="180">
										<?php } else { ?>
										Picture has not been set
										<?php } ?>
									</dd>
				                    <dt>Sex</dt>
									<dd><?php echo isset($teacher_info->sex) ? ucwords($teacher_info->sex) : "-" ?></dd>
									<dt>About Tutor</dt>
									<dd><?php echo isset($teacher_info->about_me) ? $teacher_info->about_me : "-" ?></dd>
									<dt>Teaching Experience</dt>
									<dd><?php echo isset($teacher_info->teach_experience) ? nl2br($teacher_info->teach_experience) : "-";?></dd>
									<dt>Certification</dt>
									<dd><?php echo isset($teacher_info->certification) ? nl2br($teacher_info->certification) : "-" ?></dd>
									<dt>Skill</dt>
									<dd><?php echo isset($teacher_info->skill) ? nl2br($teacher_info->skill) : "-" ?></dd>
									<dt>TOEFL Score</dt>
									<dd><?php echo isset($teacher_info->toefl_score) ? nl2br($teacher_info->toefl_score) : "-" ?></dd>
									<dt>IELTS Score</dt>
									<dd><?php echo isset($teacher_info->ielts_score) ? nl2br($teacher_info->ielts_score) : "-" ?></dd>
									<dt>Registration Source</dt>
									<dd><?php echo isset($teacher_general->register_source) ? ucwords($teacher_general->register_source) : "-" ?></dd>
				                </dl>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="box box-success collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Opened Cities for Course</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Province</th>
                                <th>City</th>
                                <!-- <th>Is Verified?</th> -->
							</tr>
							<?php 
							if($open_city<>false) 
								foreach($open_city->result() as $cit){
							?>
							<tr>
								<td><?php echo $cit->province_name?></td>
								<td><?php echo $cit->city_name?></td>
								<!-- <td>
									<?php 
									if($cit->verified == "0") 
										echo '<i class="fa fa-times" style="color: #ff0000"></i>';
									else
										echo '<i class="fa fa-check" style="color: #00ff00"></i>';
									?>
								</td> -->
							</tr>
							<?php } ?>
			          	</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-md-6">
				<div class="box box-danger collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Opened Course Programs</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
		          		<table class="table table-bordered table-striped">
							<tr>
								<th>Course Subject</th>
                                <th>Days</th>
                                <th>Sessions (Hours)</th>
							</tr>
							<?php 
							if($open_course<>false) 
								foreach($open_course->result() as $cou){
									// set days
									$days = $this->course_lib->get_days_string($cou->days);
									// get info of the course
									$course_info = $this->Course_m->get_courses(array('c.id' => $cou->course_id));
							?>
							<tr>
								<td>
									<strong><?php echo $course_info->row()->program_name ?></strong><br><?php echo $course_info->row()->course_name ?>		
								</td>
								<td><?php echo $days?></td>
								<td><?php echo str_replace(',', ', ', $cou->session_hours)?></td>
							</tr>
							<?php } ?>
			          	</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->

		<div class="row">
			<div class="col-md-6">
				<div class="box box-success collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Education</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped">
									<tr>
										<th>Education</th>
		                                <th>Institution</th>
		                                <th>Grade Score</th>
		                                <th>Period</th>
		                                <th>Certificate</th>
		                                <th>Transcript</th>
									</tr>
									<?php if($education_history<>false)
										foreach($education_history->result() as $edu){
									?>
									<tr>
										<td><?php echo $edu->degree.' - '.$edu->major;?></td>
	                                    <td><?php echo $edu->institution;?></td>
	                                    <td><?php echo $edu->grade_score;?></td>
	                                    <td><?php echo $edu->date_in.' - '.($edu->date_out == "0" ? '(On going study)' : $edu->date_out );?></td>
	                                    <td>
	                                        <?php if($edu->certificate_media_id<>0) {
	                                            $certificate_file_name = $this->Media_m->get_media_data(array('id'=>$edu->certificate_media_id))->row()->file_name;
	                                        ?>
	                                        <a href="<?php echo UPLOAD_IMAGE_DIR.'/'.$certificate_file_name ?>"><img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$certificate_file_name ?>" alt="" width="80"></a>
	                                        <br>
	                                        <br>
	                                        <a href="<?php echo base_url('teacher/download/'.$edu->certificate_media_id)?>"><i class="fa fa-download"></i> Download</a>
	                                        <?php } ?>
	                                    </td>
	                                    <td>
	                                        <?php if($edu->transcript_media_id<>0) {
	                                            $transcript_file_name = $this->Media_m->get_media_data(array('id'=>$edu->transcript_media_id))->row()->file_name;
	                                        ?>
	                                        <a href="<?php echo UPLOAD_IMAGE_DIR.'/'.$transcript_file_name ?>"><img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$transcript_file_name ?>" alt="" width="80"></a>
	                                        <br>
	                                        <br>
	                                        <a href="<?php echo base_url('teacher/download/'.$edu->transcript_media_id)?>"><i class="fa fa-download"></i> Download</a>
	                                        <?php } ?>
	                                    </td>
									</tr>
									<?php }	?>	
					          	</table>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-md-6">
				<div class="box box-danger collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Bank</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<dl class="dl-horizontal">
									<dt>Bank</dt>
									<dd><?php echo ($bank==false ? '-' : $bank->bank_name) ?></dd>
									<dt>Account Number</dt>
				                    <dd><?php echo ($bank==false ? '-' : $bank->bank_account_number) ?></dd>
				                    <dt>Holder Name</dt>
									<dd><?php echo ($bank==false ? '-' : $bank->bank_holder_name) ?></dd>
									<dt>Branch</dt>
									<dd><?php echo ($bank==false ? '-' : $bank->bank_branch.' '.$bank->bank_city) ?></dd>
				                </dl>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="box box-success collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Test Assignment Result</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th width="50%">Assignment</th>
                                <th>Assignment Result</th>
							</tr>
							<?php 
							$accumulated_score = $average_score = $total_taken_test = 0;
							$accumulated_grade = '-';
							if($test_assignments<>false)
							{
								$total_taken_test = $test_assignments->num_rows();
								foreach($test_assignments->result() as $row){?>
							<tr>
								<td>
									<p><strong>ID:</strong> <?php echo $row->assignment_id?></p>
									<p><strong>Test Name:</strong> <strong><?php echo $row->test_id?></strong> - <?php echo $row->test_name; ?></p>
									<?php 
										// get info of the course
										$course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
                                    ?>
                                    <p><strong>Related Course:</strong> <?php echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;?></p>
								</td>
                                <td>
                                    <ol>
                                    <?php 
                                        $taker_data = $this->Otest_m->get_taker_data(array('assignment_id' => $row->assignment_id));
                                        if($taker_data<>false)
                                            foreach($taker_data->result() as $taker){

                                    ?>
                                        <li>
                                            <p><?php echo date_format(new DateTime($taker->taken_time), 'd M Y H:i')?></p>
                                            <p>
                                                <?php
                                                $count_data = $this->Otest_m->count_submitted_answer($taker->taker_id);
                                                $count_right_data = $this->Otest_m->count_submitted_answer($taker->taker_id, 'right');
                                                echo 'Correct: '.$count_right_data.' / '.$count_data;
                                                echo '<br>Score: '.$taker->score;
                                                echo '<br>Passing Score: '.$taker->passing_score;
                                                echo '<br>Grade: <strong>'.$taker->grade_score.'</strong>';
                                                echo '<br>Test Result: <strong>'.strtoupper($taker->test_result).'</strong>';
                                                $accumulated_score += $taker->score;
                                                ?>
                                            </p>
                                            <a href="<?php echo base_url('otest/view_answer/'.$taker->taker_id)?>">View Answers</a>
                                        </li>
                                    <?php } ?>
                                    </ol>
                                </td>
							</tr>
							<?php 
								}
							}
							// get the grade if accumulated score <> zero
							if($accumulated_score > 0)
							{
								$average_score = $accumulated_score / $total_taken_test;
								$grade_info = $this->Otest_m->get_grade_by_value($average_score);
								$accumulated_grade = $grade_info->grade;
							}
							?>	
			          	</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-md-6">
				<div class="box box-danger collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Tutor's Fee Suggestions (UMK Based)</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
		          		<?php 
		          		$city = $province = $class = $umk = '';
		          		$range_has_suggestion = false;
						if($teacher_info<>false)
						{
							if($teacher_info->city_id<>"")
							{
								$umk_info = $this->Payroll_m->get_city_umk_data(array('u.city_id' => $teacher_info->city_id));
								if($umk_info<>false)
								{
									$class = $umk_info->row()->class_number;
									$umk = $umk_info->row()->umk_nominal;
									$province = $umk_info->row()->province_name;
									$city = $umk_info->row()->city_name;

									if($class<>'' and $accumulated_grade<>'-')
									{
										$grade_id_info = $this->Otest_m->get_grade_data(array('grade' => $accumulated_grade));
										$range_info = $this->Payroll_m->get_range_fee(array('class_number' => $class, 'grade_id' => $grade_id_info->row()->grade_id));
										if($range_info<>false)
										{
											$range_has_suggestion = true;
											$suggested_range = $range_info->row();
											$lrange = $suggested_range->range_lowest;
											$hrange = $suggested_range->range_highest;
										}
									}
								}
							}
						}
						?>
		          		<dl class="dl-horizontal">
							<dt>Location</dt>
							<dd><?php echo $province.' - '.$city ?></dd>
							<dt>Class Number</dt>
		                    <dd><?php echo $class ?></dd>
		                    <dt>UMK Nominal</dt>
							<dd>IDR <?php echo ($umk<>"" ? number_format($umk, 0, ',', '.') : '0') ?></dd>
							<dt>Score &amp; Grade<br>(Accumulated)</dt>
		                    <dd><?php echo $average_score.' / '.$accumulated_grade ?></dd>
		                    <dt>Suggested Range Fee</dt>
		                    <dd><?php echo ($range_has_suggestion ? 'IDR '.number_format($lrange, 0, ',', '.').' - '.number_format($hrange, 0, ',', '.') : 'Range not been set for class '.$class.' and grade '.$accumulated_grade) ?></dd>
		                </dl>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

<script>
	$('#btn-verify').on('click', function(){
		if(confirm("Are you sure to verify this tutor? Make sure all of his/her data has been added correctly.")){
			window.location.href = "<?php echo base_url('teacher/verify?id='.$teacher_general->user_id);?>";
		}	
	});
	$('#btn-unverify').on('click', function(){
		if(confirm("Are you sure to unverify this tutor?")){
			window.location.href = "<?php echo base_url('teacher/unverify?id='.$teacher_general->user_id);?>";
		}	
	});
</script>
</body>
</html>
