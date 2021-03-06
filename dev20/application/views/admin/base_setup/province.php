<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Location</a></li>
			<li class="active"><a href="#">Province</a></li>
		</ol>
    </section>
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
	                  	<li>Untuk mengubah data, klik Edit, isi perubahan data, lalu klik Save</li>
	                  	<li>Untuk menghapus data, klik Delete. Data tidak dapat dihapus jika terdapat data lain yang mengacu ke data yang diubah.</li>
	                  </ol>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-md-6">
				<div class="box box-info">
		          	<div class="box-header">
						<a href="<?php echo base_url('location/export/province')?>" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Province</th>
									<th>User Identifier</th>
									<th>Edit</th>
									<th></th>
									<!-- <th>Delete</th> -->
								</tr>
							</thead>
							<tbody>
								<?php if($provinces<>false)
									foreach($provinces->result() as $row){?>
								<tr>
									<td>
										<input type="text" style="width:100%" value="<?php echo $row->province_name;?>" id="tb-<?php echo $row->province_id;?>" class="form-control" readonly>
									</td>
									<td>
										<input type="text" style="width:100%" value="<?php echo $row->user_identifier;?>" id="tb-uid-<?php echo $row->province_id;?>" class="form-control" readonly>
									</td>
									<td>
										<button id="btn-edit-<?php echo $row->province_id;?>" class="btn btn-warning btn-sm" onclick="open_textbox('<?php echo $row->province_id;?>')">Edit</button>
										<button id="btn-save-<?php echo $row->province_id;?>" class="btn btn-primary btn-sm" onclick="save('<?php echo $row->province_id;?>')" style="display:none">Save</button>
										<div class="pull-right" style="display:none" id="loading-submit-<?php echo $row->province_id;?>">
	                                        <i class="fa fa-refresh fa-spin"></i>
	                                    </div>
									</td>
									<td>
										<button id="btn-cancel-<?php echo $row->province_id;?>" class="btn btn-default btn-sm" onclick="cancel('<?php echo $row->province_id;?>')" style="display:none">Cancel</button>
									</td>
									<!--<td>
										<a href="<?php // echo base_url('location/delete_province/'.$row->province_id);?><!--" class="btn btn-danger"><i class="fa fa-warning"></i> Delete</a>
									</td>-->
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
	function open_textbox(id){
		$("#tb-"+id).prop('readonly', false);
		$("#tb-uid-"+id).prop('readonly', false);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}

	function cancel(id){
		$("#tb-"+id).prop('readonly', true);
		$("#tb-uid-"+id).prop('readonly', true);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}

	function save(id){
		$("#loading-submit-"+id).toggle();
		$.ajax({
	        type : "POST",
	        url: '<?php echo base_url("location/update_province");?>',
	        data: "id="+id+"&val="+$("#tb-"+id).val()+"&uid="+$("#tb-uid-"+id).val(),
	        async: false,
	        dataType: "json",
	        success: function(data) {
	          if(data.status=="301")
	            alert(data.message);
	        },
	        error: function(e) {
	        // Schedule the next request when the current one's complete,, in miliseconds
	          alert('Error processing your request: '+e.responseText);
	        }
	      });
		$("#loading-submit-"+id).toggle();

		$("#tb-"+id).prop('readonly', true);
		$("#tb-uid-"+id).prop('readonly', true);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}
	
</script>
</body>
</html>
