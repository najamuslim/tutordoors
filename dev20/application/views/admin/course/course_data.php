<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Courses
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Course Management</a></li>
			<li><a href="#">Course Setup</a></li>
			<li class="active">Courses</li>
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
						<form role="form" id="form" method="post" action="<?php echo base_url();?>course/update_course">
							<input type="hidden" name="id" id="id-edit" />
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Edit Course</h4>
							</div>
							<div class="modal-body">
								<div class="box-body">
									<div class="form-group">
										<label for="input-name">Course ID</label>
										<input type="text" class="form-control input-sm" style="text-transform: uppercase;" id="course-code-edit" name="course-code" placeholder="">
									</div>
									<div class="form-group">
										<label for="input-name">Course Name</label>
										<input type="text" class="form-control input-sm" id="course-name-edit" name="course-name" placeholder="" onkeyup="set_url_on_edit(this.value);" required >
									</div>
									<div class="form-group">
										<label for="input-name">Program</label>
										<select class="form-control" id="sel-program-edit" name="program" required>
											<?php if($programs<>false) foreach($programs->result() as $prog) {?>
					                        <option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
					                        <?php } ?>
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
			<!-- for input filter -->
			<div class="col-md-12">      		
          		<div class="box box-danger">
            		<form id="search_form">
	            		<div class="box-body">
	            			<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="input-name">Choose a Program</label>
	                    				<select class="form-control" id="sel-program">
	                      					<option value=""></option>
	                      					<?php if($programs<>false) 
	                      					foreach($programs->result() as $prog) {?>
	                      					<option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
	                      					<?php } ?>
	                    				</select>
	                  				</div>
								</div>
	            			</div>
	            		</div>
            		</form>
          		</div>
        	</div>

			<div class="col-md-8">
				<div class="box box-info">
                <div class="box-header">
					<!-- <a href="<?php echo base_url('course/export/program')?>" class="btn btn-primary"><i class="fa fa-download"></i> Download</a> -->
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="default-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Course ID</th>
								<th>Course Name</th>
								<th>Slug</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							
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
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Add Course</h3>
					</div><!-- /.box-header -->
					
					<!-- form start -->
					<form role="form" id="form" method="post" action="<?php echo base_url();?>course/insert_course">
						<div class="box-body">
							<div class="form-group">
								<label for="input-name">Course ID</label>
								<input type="text" class="form-control input-sm" style="text-transform: uppercase;" id="id" name="course-code" placeholder="" >
							</div>
							<div class="form-group">
								<label for="input-name">Course Name</label>
								<input type="text" class="form-control input-sm" id="name" name="course-name" placeholder="" onkeyup="set_url(this.value);" required >
							</div>
							<div class="form-group">
								<label for="input-name">Program</label>
								<select class="form-control" name="program" required>
									<?php if($programs<>false) foreach($programs->result() as $prog) {?>
			                        <option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
			                        <?php } ?>
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
	function set_url(title){
		var in_lower = title.toLowerCase();
		$('#slug').val(in_lower.replace(/[^a-zA-Z0-9]/g,'-'));
	}

	function set_url_on_edit(title){
		var in_lower = title.toLowerCase();
		$('#slug-edit').val(in_lower.replace(/[^a-zA-Z0-9]/g,'-'));
	}

	function modal_set(id){
		$('#loading-edit').toggle();
		$.ajax({
			type : "POST",
			async: false,
			url: '<?php echo base_url();?>course/get_course_by_id/'+id,
			dataType: "json",
			success:function(data){
				$('#id-edit').val(id);
				$('#course-code-edit').val(data.course_code);
				$('#course-name-edit').val(data.course_name);
				$('#slug-edit').val(data.slug);
				$('#sel-program-edit').val(data.program_id);
				
				$('#modal-edit').modal('show');
			}
		});
		$('#loading-edit').toggle();
	}

	$('#sel-program').on('change', function(e){
		$('#loading-edit').toggle();
		var oTable = $('#default-table').DataTable();
    	oTable.fnClearTable();
		$.ajax({
			type : "GET",
			async: false,
			url: '<?php echo base_url();?>course/get_course_by_program/'+$('#sel-program').val(),
			dataType: "json",
			success:function(data){
				for(var i=0; i<data.length; i++){
		          oTable.fnAddData([
		            data[i].course_code,
		            data[i].course_name,
		            data[i].slug,
		            '<button class="btn btn-primary btn-xs" onclick="modal_set(\''+data[i].id+'\')">\
										<i class="fa fa-edit"></i> Edit\
									</button>',
		            '<a href="<?php echo base_url() ?>course/delete_course?id='+data[i].id+'" onclick="return confirm(\'Do you want to delete '+data[i].course_name+' ?\')" >\
										<button class="btn btn-danger btn-xs">\
											<i class="fa fa-trash-o"></i> Delete\
										</button>\
									</a>'
		            ]);
		        }
		        $('#loading-edit').toggle();
			},
	      	error: function(e){
	      		$('#loading-edit').toggle();
	        	alert('Error processing your request: '+e.responseText);
	      	}
		});
	})	
</script>
</body>
</html>
