<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Student</a></li>
			<li class="active"><a href="#">Unverified</a></li>
		</ol>
    </section>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<form method="POST" action="<?php echo base_url('student/verify/') ?>">
					<div class="box box-info">
          	<div class="box-header">
							<a href="<?php echo base_url('student/export/verified')?>" class="btn btn-success"><i class="fa fa-download"></i> Download Data</a>
          	</div><!-- /.box-header -->
          	<div class="box-body">
							<table id="default-table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>User ID</th>
										<th>Full Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Registered Date</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if($students<>false)
									 		foreach($students->result() as $student){
						 			?>
									<tr>
										<td>
											<p><a href="<?php echo base_url('student/detail/'.$student->user_id)?>"><strong><?php echo $student->user_id?></strong></a></p>
                    </td>
										<td>
										  <p><?php echo $student->first_name.' '.$student->last_name ?></p>
										</td>
										<td>
                      <p><?php echo $student->email_login; ?></p>
										</td>
										<td>
											<p><?php echo $student->phone_1; ?></p>
										</td>
										<td>
											<p><?php echo date_format(new DateTime($student->join_date), 'd M Y H:i')?></p>
										</td>
									</tr>
									<?php }	?>	
								</tbody>
	          	</table>
		        </div><!-- /.box-body -->
		        <div class="box-footer">
		        	<button class="btn btn-primary" type="submit">Verify</button>
		        </div>
	        </div><!-- /.box -->
	    	</form>
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

</body>
</html>
