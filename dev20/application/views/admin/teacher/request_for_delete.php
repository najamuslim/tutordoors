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
			<li><a href="#">Verification</a></li>
			<li class="active"><a href="#"><?php echo $part; ?></a></li>
		</ol>
    </section>
	<!-- Modal -->
	<div class="modal modal-default fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Verifikasi <?php echo ($part=="city" ? 'Kota' : 'Kompetensi'); ?></h4>
	      </div>
	      <div class="modal-body">
	        Apakah anda yakin untuk memverifikasi ID <span class="replace-id"></span> ?
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	        <a href="" id="link-submit"><button type="button" class="btn btn-info">Save changes</button></a>
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
	                  <h3 class="box-title"><i class="fa fa-warning"></i> Petunjuk</h3>
	                  <div class="box-tools pull-right">
	                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                  </div><!-- /.box-tools -->
	                </div><!-- /.box-header -->
	                <div class="box-body">
	                  <ol>
	                  	<li>You can only delete data that not exist in foreign table.</li>
	                  	<li>This warning can be seen in column "Dependency Data"</li>
	                  	<li>Please reject records that have dependency data.</li>
	                  </ol>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<form method="POST" action="<?php echo base_url('teacher/delete_'.$part) ?>">
				<div class="box box-info">
		          	<div class="box-header">
						Verifikasi Data <?php echo ($part=="city" ? 'Kota' : 'Kompetensi'); ?>
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<?php foreach($headers as $header) {?>
									<th><?php echo $header; ?></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach($request as $row){?>
								<tr>
									<td width="30px"><?php echo $row['checkbox']; ?></td>
									<td><a href="<?php echo site_url('teacher/detail/'.$row['user_id']); ?>"><?php echo $row['user_id'];?></a></td>
									<td><?php echo $row['name'];?></td>
									<td><?php echo $row['specific'];?></td>
									<td><?php echo $row['category'];?></td>
									<td><?php echo $row['dependency'];?></td>
								</tr>
								<?php }	?>	
							</tbody>
			          	</table>
			        </div><!-- /.box-body -->
			        <div class="box-footer">
			        	<button class="btn btn-primary" type="submit" name="action" value="delete">Delete</button>
			        	<button class="btn btn-danger" type="submit" name="action" value="reject">Reject</button>
			        </div>
		        </div><!-- /.box -->
		    	</form>
			</div>
		</div>
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
