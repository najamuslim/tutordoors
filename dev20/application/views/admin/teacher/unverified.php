<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Teacher</a></li>
			<li class="active"><a href="#">Unverified</a></li>
		</ol>
    </section>
	<!-- Modal -->
	<div class="modal modal-default fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Verify Tutor</h4>
	      </div>
	      <div class="modal-body">
	        Are you sure to verify tutor with ID <span class="replace-id"></span> ?
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	        <a href="" id="link-submit"><button type="button" class="btn btn-info">Verify</button></a>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning">
	                <div class="box-header with-border">
	                  <h3 class="box-title"><i class="fa fa-warning"></i> Hint</h3>
	                  <div class="box-tools pull-right">
	                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                  </div><!-- /.box-tools -->
	                </div><!-- /.box-header -->
	                <div class="box-body">
	                  <ol>
	                  	<li>Please check all the requirements before verifying a tutor</li>
	                  	<li>Open the tutor detail by clicking the ID, so you can verify their data easily</li>
	                  	<li>Set the tutor fee per 1.5 hours, reference range fee tutor can be seen by opening the tutor detail</li>
	                  </ol>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<div class="box box-info">
		          	<div class="box-header">
						<a href="<?php echo base_url('teacher/export/unverified')?>" class="btn btn-success"><i class="fa fa-download"></i> Download Data</a>
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nama</th>
									<th>Email</th>
									<th>Telepon</th>
									<th>Tgl Daftar</th>
									<!-- <th>ID Baru</th> -->
									<th>Input Gaji Per Jam</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if($teachers<>false)
									foreach($teachers->result() as $row){?>
								<tr>
									<td><a href="<?php echo site_url('teacher/detail/'.$row->user_id); ?>"><?php echo $row->user_id;?></a></td>
									<td><?php echo $row->first_name.' '.$row->last_name;?></td>
									<td><?php echo $row->email_login;?></td>
									<td><?php echo $row->phone_1;?></td>
									<td><?php echo date_format(new DateTime($row->join_date), 'd M Y');?></td>
									<!-- <td>
										<input type="text" id="new-id-<?php echo $row->user_id;?>">
									</td> -->
									<td>
										IDR <input type="text" id="input-salary-<?php echo $row->user_id;?>" value="0">
									</td>
									<td>
										<button class="btn btn-warning" onclick="verify_teacher('<?php echo $row->user_id;?>')">Verifikasi</button>
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
<script>
	//$('#example-modal').modal('hide');
	function verify_teacher(id){
		// if($('#new-id-'+id).val()=="" || $('#input-salary-'+id).val()=="0" || $('#input-salary-'+id).val()=="")
		if($('#input-salary-'+id).val()=="0" || $('#input-salary-'+id).val()=="")
			alert('Salary Per Jam harus diisi.');
		else{
			$('.replace-id').text(id);
			$('#link-submit').attr('href', "<?php echo base_url('teacher/verify');?>?old="+id+"&sal="+$('#input-salary-'+id).val());
			// $('#link-submit').attr('href', "<?php echo base_url('teacher/verify');?>?old="+id+"&new="+$('#new-id-'+id).val()+"&sal="+$('#input-salary-'+id).val());
			$('#myModal').modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
		}
	}
</script>
</body>
</html>
