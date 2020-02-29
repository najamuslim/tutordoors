<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Programs
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Course Management</a></li>
			<li><a href="#">Course Setup</a></li>
			<li class="active">Programs</li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<!-- Modal -->
			<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<form role="form" id="form" method="post" action="<?php echo base_url();?>course/update_program">
							<input type="hidden" name="id" id="id-edit" />
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Edit Program</h4>
							</div>
							<div class="modal-body">
								<div class="box-body">
									<div class="form-group">
										<label for="input-name">Program</label>
										<input type="text" class="form-control input-sm" id="name-edit" name="program" placeholder="" onkeyup="set_url_on_edit(this.value);" required>
									</div>
									<div class="form-group">
										<label for="input-name">World Scale</label>
										<select name="scale" id="scale-edit" class="form-control input-sm" required>
											<option value="national" selected>National</option>
											<option value="international">International</option>
										</select>
									</div>
									<div class="form-group">
										<label for="input-name">Slug</label> *good keywords
										<input type="text" class="form-control input-sm" id="slug-edit" name="slug" placeholder="" readonly >
									</div>
								</div><!-- /.box-body -->
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save Changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Modal -->
			
			<div class="col-md-9">
				<div class="box box-info">
                <div class="box-header">
					<!-- <a href="<?php echo base_url('course/export/program')?>" class="btn btn-primary"><i class="fa fa-download"></i> Download</a> -->
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="default-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Program</th>
								<th>Scale</th>
								<th>Slug</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php if($programs<>false)
								foreach($programs->result() as $data){
							?>
							<tr>
								<td><?php echo $data->program_name ?></td>
								<td><?php echo ucwords($data->world_scale) ?></td>
								<td><?php echo $data->slug ?></td>
								<td>
									<button class="btn btn-primary btn-xs" onclick="modal_set('<?php echo $data->program_id ?>')">
										<i class="fa fa-edit"></i> Edit
									</button>
									<a href="<?php echo base_url('course/delete_program?id='.$data->program_id) ?>" onclick="return confirm('Do you want to delete <?php echo $data->program_name ?> ?')" >
										<button class="btn btn-danger btn-xs">
											<i class="fa fa-trash-o"></i> Delete
										</button>
									</a>
								</td>
							</tr>
							<?php 
								}
							?>
						</tbody>
                  	</table>
                </div><!-- /.box-body -->
                <!-- Loading (remove the following to stop the loading)-->
                <div class="overlay" style="display:none" id="loading-edit">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- end loading -->
              </div><!-- /.box -->
			</div>
			<div class="col-md-3">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Add Program</h3>
					</div><!-- /.box-header -->
					
					
					<!-- form start -->
					<form role="form" id="form" method="post" action="<?php echo base_url();?>course/insert_program">
						<div class="box-body">
							<div class="form-group">
								<label for="input-name">Program</label>
								<input type="text" class="form-control input-sm" id="name" name="program" placeholder="" onkeyup="set_url(this.value);" required >
							</div>
							<div class="form-group">
								<label for="input-name">Scale</label>
								<select name="scale" id="scale" class="form-control input-sm" required>
									<option value="national" selected>National</option>
									<option value="international">International</option>
								</select>
							</div>
							<div class="form-group">
								<label for="input-name">Slug</label> *good keywords
								<input type="text" class="form-control input-sm" id="slug" name="slug" placeholder="" readonly >
							</div>
						</div><!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<script>
	//$('#example-modal').modal('hide');
	function modal_set(id){
		$('#loading-edit').toggle();
		$.ajax({
			type : "GET",
			async: false,
			url: '<?php echo base_url();?>course/get_program_by_id/'+id,
			dataType: "json",
			success:function(data){
				$('#id-edit').val(id);
				$('#name-edit').val(data.program);
				$('#scale-edit').val(data.world_scale);
				$('#slug-edit').val(data.slug);
				
				$('#modal-edit').modal('show');
			}
		});
		$('#loading-edit').toggle();
	}
	
	function set_url(title){
		var in_lower = title.toLowerCase();
		$('#slug').val(in_lower.replace(/[^a-zA-Z0-9]/g,'-'));
	}

	function set_url_on_edit(title){
		var in_lower = title.toLowerCase();
		$('#slug-edit').val(in_lower.replace(/[^a-zA-Z0-9]/g,'-'));
	}
</script>
</body>
</html>
