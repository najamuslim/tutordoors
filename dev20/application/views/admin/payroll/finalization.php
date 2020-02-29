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
	<!-- Modal -->
	<div class="modal modal-default fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h3 class="modal-title" id="myModalLabel">Finalisasi Gaji Guru</h3>
	      </div>
	      <div class="modal-body">
	      	<label for="period">Period Tercatat: <?php echo $period.' ('.$period_in_numeric_format.')'; ?></label>
	        Apakah anda yakin untuk finalisasi data ini ?
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	        <a href="<?php echo base_url('payroll/commit/'.$filter_param.'/'.$period_in_numeric_format) ?>" id="link-submit" class="btn btn-warning">Commit</a>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<div class="box box-info">
                <div class="box-header">
					<h4>Daftar Validasi Yang Sudah Masuk</h4>
					<button onclick="open_modal()" class="btn btn-warning">Lanjutkan ke Proses Finalisasi</button>
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="default-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Tutor</th>
								<th>Enroll ID</th>
								<th>Course Info</th>
								<th>Salary per Hour</th>
								<th>Validated Hours</th>
								<th>Percentage Fee (%)</th>
								<th>Total Salary</th>
							</tr>
						</thead>
						<tbody>
							<?php if($data_final<>false)
								foreach($data_final->result() as $row){?>
							<tr>
								<td>
									<p><strong>ID <?php echo $row->teacher_id; ?></strong></p>
									<p><?php echo $row->teacher_name; ?></p>
								</td>
								<td><strong><?php echo $row->enroll_id ?></strong></td>
								<td>
									<?php 
									// get info of the course
									$course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
									$world_scale = $this->Course_m->get_category_world_scale_by_enroll_id($row->enroll_id);
									if($world_scale=="national")
										$percentage_fee_info = $this->Content_m->get_option_by_param('percentage_payroll_national_course_fee');
									else if($world_scale=="international")
										$percentage_fee_info = $this->Content_m->get_option_by_param('percentage_payroll_international_course_fee');

									$percentage_fee = $percentage_fee_info->parameter_value;

									?>
									<p><strong>Course: </strong><?php echo $course_info->row()->program_name.' - '.$course_info->row()->course_name ?></p>
									<p><strong>Scale: </strong><?php echo ucwords($world_scale)?></p>
								</td>
								<td>IDR <?php echo number_format($row->salary_per_hour, 0, ',', '.') ?></td>
								<td><?php echo $row->total_valid_hours ?></td>
								<td><?php echo $percentage_fee ?></td>
								<?php $total_salary = ($percentage_fee / 100) * $row->salary_per_hour * $row->total_valid_hours ?>
								<td>IDR <?php echo number_format($total_salary, 0, ',', '.') ?></td>
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
<script>
	//$('#example-modal').modal('hide');
	function open_modal(){
		$('#myModal').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
</script>
</body>
</html>
