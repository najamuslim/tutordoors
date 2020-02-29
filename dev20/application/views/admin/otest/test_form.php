<?php 
	if($mode=="add") $title="Add New";
	else if($mode=="edit") $title="Edit";

?>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo GENERAL_CSS_DIR;?>/jquery.tagsinput.css" />
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			<?php echo $title;?> Test
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Online Test</a></li>
			<li class="active"><a href="#"><?php echo $title;?></a></li>
		</ol>
  </section>
	
	<!-- Main content -->
  <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>			
			<div class="col-xs-12">
				<div class="box box-info">
  				<!-- <div class="box-header">
						<h3 class="box-title"><?php echo $mode;?> test
						</h3>
        	</div> --><!-- /.box-header -->
        		<!-- form start -->
						<form id="form" method="post" action="<?php echo base_url().($mode=="add" ? 'otest/add_test' : 'otest/update_test/'.$this->input->get('id'));?>">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label for="test-id" class="label-required">Test ID</label>
													<input type="text" class="form-control input-sm" id="test-id" name="id" placeholder="" value="<?php if($mode=='edit') echo $test_data->test_id;?>" onkeyup="format_id(this.value);" required>
												</div><!-- ./form-group -->
											</div>
											<div class="col-sm-9">
												<div class="form-group">
													<label for="name" class="label-required">Test Name</label>
													<input type="text" class="form-control input-sm" id="name" name="name" placeholder="" value="<?php if($mode=='edit') echo $test_data->test_name;?>" required>
												</div><!-- ./form-group -->
											</div>
										</div>
										<div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="random-question" <?php if($mode=="edit") echo ($test_data->random_question=="1" ? "checked" : "") ;?>> Generate random question?
                        </label>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="assign-to-new-user" name="assign-to-new-user" <?php if($mode=="edit") echo ($test_data->assign_to_new_tutor=="1" ? "checked" : "") ;?>> Assign to new tutor users automatically?
                        </label>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="assign-to-course-request" name="assign-to-course-request" <?php if($mode=="edit") echo ($test_data->assign_to_course_request=="1" ? "checked" : ""); else echo "disabled"; ?>> Assign to verified competence request?
                        </label>
                      </div>
                    </div><!-- ./form-group -->
										<div class="form-group">
											<label for="objective" class="label-required">Objectives</label>
											<textarea class="form-control" id="objective" name="objective" rows="10" cols="80"> <?php if($mode=='edit') echo $test_data->objectives;?></textarea>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-sm-6">
										<div class="form-group">
											<label for="sel-course">Related Course</label>
											<select class="form-control" id="sel-program">
              					<option value="">--Select a Program--</option>
              					<?php if($programs<>false) 
              					foreach($programs->result() as $prog) {?>
              					<option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
              					<?php } ?>
              				</select>
											<select class="form-control" id="sel-course" name="course_id"></select>
										</div><!-- ./form-group -->
										<div class="form-group">
	                    <label class="label-required">Time in Minutes</label>
	                    <div class="input-group">
	                      <input type="text" class="form-control input-sm" name="time_in_minutes" value="<?php if($mode=='edit') echo $test_data->time_in_minutes;?>" required>
	                      <div class="input-group-addon">
	                        <i class="fa fa-clock-o"></i>
	                      </div>
	                    </div><!-- /.input group -->
	                  </div><!-- /.form group -->
										<div class="form-group">
											<label for="how-to" class="label-required">How to do the test</label>
											<textarea class="form-control" id="how-to" name="howto" rows="10" cols="80"> <?php if($mode=='edit') echo $test_data->how_to;?></textarea>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
								</div><!-- ./row -->
						
							</div><!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Save</button>
								<?php
								 	if($mode=="edit") {
								 		if($test_data->is_active=="0"){
								?>
								<a href="<?php echo base_url('otest/activate_test/'.$test_data->test_id)?>"><button type="button" id="btn-activate" class="btn btn-success">Activate</button></a>
								<?php } else if($test_data->is_active=="1"){?>
									<a href="<?php echo base_url('otest/deactivate_test/'.$test_data->test_id)?>"><button type="button" id="btn-activate" class="btn btn-success">Deactivate</button></a>
								<?php } ?>
								<a href="<?php echo base_url('otest/question/'.$test_data->test_id)?>"><button type="button" class="btn btn-info">Add/Edit Questions</button></a>
								<?php } ?>
							</div>
						</form>
        	
	      </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<!-- CK Editor -->
<script src="<?php echo ADMIN_LTE_DIR;?>/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<script>
	$(document).ready(function(){
		<?php if($mode=="edit") {
			$course_info = $this->Course_m->get_courses(array('c.id' => $test_data->course_id));
			?>
		$('#sel-program').val('<?php echo $course_info->row()->program_id;?>');
		$('#sel-program').trigger('change');
		$('#sel-course').val('<?php echo $test_data->course_id;?>');

		<?php } ?>

		enable_disable_checkbox();

		$('#sel-course').on('change', function(){
			enable_disable_checkbox();
		});
	});

	function enable_disable_checkbox(){
		if($('#sel-course').val()=="")
		{
			$('#assign-to-new-user').prop('disabled', false);
			$('#assign-to-course-request').prop('disabled', true);
			$('#assign-to-course-request').prop('checked', false);
		}
		else
		{
			$('#assign-to-new-user').prop('disabled', true);
			$('#assign-to-new-user').prop('checked', false);
			$('#assign-to-course-request').prop('disabled', false);
		}
	}

	$(function () {
	    // Replace the <textarea id="editor1"> with a CKEditor
	    // instance, using default configuration.
	    CKEDITOR.replace('objective');
	    CKEDITOR.replace('how-to');
	    
	  });

	function format_id(title){
		var in_upper = title.toUpperCase();
		$('#test-id').val(in_upper.replace(/[^a-zA-Z0-9]/g,'-'));
	}

	$('#sel-program').on('change', function(e){
		$('#loading-edit').toggle();
		$.ajax({
			type : "GET",
			async: false,
			url: '<?php echo base_url();?>course/get_course_by_program/'+$('#sel-program').val(),
			dataType: "json",
			success:function(data){
				$("#sel-course").find('option').remove().end();
				for(var i=0; i<data.length;i++)
          $("#sel-course").append($("<option></option>").val(data[i].id).html(data[i].course_name));
		    
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
