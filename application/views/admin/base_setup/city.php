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
			<li class="active"><a href="#">City</a></li>
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
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title"><strong>Add City</strong></h3>
					</div><!-- /.box-header -->
					
					
					<!-- form start -->
					<form role="form" id="form" method="post" action="<?php echo base_url();?>location/add_city">
						<div class="box-body">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="input-name">City Name</label>
										<input type="text" class="form-control input-sm" name="city" placeholder="" onkeyup="set_url(this.value);" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="input-name">Province</label>
										<select class="form-control" name="province" required>
											<option value="">--Select Province--</option>
											<?php 
											if($provinces <> false) {
												foreach($provinces->result() as $row){
													
											?>
											<option value="<?php echo $row->province_id;?>"><?php echo $row->province_name;?></option>
											<?php 	
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="input-name">User Identifier</label>
										<input type="text" class="form-control input-sm" name="uid" required maxlength="5">
									</div>
								</div>
							</div>
							
						</div><!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div>
			<div class="col-md-12">
				<div class="box box-info">
		          	<div class="box-header">
						<a href="<?php echo base_url('location/export/city')?>" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Province</th>
									<th>City</th>
									<th>User Identifier</th>
									<th>Is Queryable?</th>
									<th>Slug</th>
									<th>Edit</th>
									<th></th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php if($cities<>false)
									foreach($cities->result() as $row){
										if($row->city_queryable == "0")
											$check_queryable = "";
										else if($row->city_queryable == "1")
											$check_queryable = "checked";
								?>
								<tr>
									<td width="30%">
										<?php echo $row->province_name ?>
									</td>
									<td width="30%">
										<input type="text" style="width:100%" value="<?php echo $row->city_name;?>" id="tb-<?php echo $row->city_id;?>" class="form-control" readonly>
									</td>
									<td width="5%">
										<input type="text" style="width:100%" value="<?php echo $row->city_user_identifier;?>" id="tb-uid-<?php echo $row->city_id;?>" class="form-control" readonly>
									</td>
									<td width="10%">
										<input id="cb-uid-<?php echo $row->city_id;?>" type="checkbox" <?php echo $check_queryable ?> onclick="set_queryable('<?php echo $row->city_id;?>');" />
									</td>
									<td width="15%">
										<?php echo $row->city_slug ?>
									</td>
									<td>
										<button id="btn-edit-<?php echo $row->city_id;?>" class="btn btn-warning btn-xs" onclick="open_textbox('<?php echo $row->city_id;?>')"><i class="fa fa-pencil"></i></button>
										<button id="btn-save-<?php echo $row->city_id;?>" class="btn btn-primary btn-xs" onclick="save('<?php echo $row->city_id;?>')" style="display:none">Save</button>
										<div class="pull-right" style="display:none" id="loading-submit-<?php echo $row->city_id;?>">
	                                        <i class="fa fa-refresh fa-spin"></i>
	                                    </div>
									</td>
									<td>
										<button id="btn-cancel-<?php echo $row->city_id;?>" class="btn btn-default btn-sm" onclick="cancel('<?php echo $row->city_id;?>')" style="display:none">Cancel</button>
									</td>
									<td>
										<a onclick="return confirm('Do you really want to delete this city?');" href="<?php echo base_url('location/delete_city/'.$row->city_id);?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>
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
	        url: '<?php echo base_url("location/update_city");?>',
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

	function set_queryable(city_id){
		if(confirm("Enable this city as queryable will display it on some filtering features. Are you sure?")){
			var setter = $('#cb-uid-'+city_id).is(':checked') ? "1" : "0";
			$.ajax({
		        type : "POST",
		        url: '<?php echo base_url("location/set_city_queryable");?>',
		        data: "id="+city_id+"&val="+setter,
		        async: false,
		        dataType: "json",
		        success: function(data) {
		          if(data.status == "200")
		          	console.info("Done");
		          else if(data.status == "301")
		          	alert("Error: "+data.message);
		        },
		        error: function(e) {
		        // Schedule the next request when the current one's complete,, in miliseconds
		          alert('Error processing your request: '+e.responseText);
		        }
		      });
		}
	}
	
</script>
</body>
</html>
