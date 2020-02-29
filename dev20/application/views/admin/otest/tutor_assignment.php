<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			Test Assignment for Tutor
			
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Online Test</a></li>
			<li class="active"><a href="#">Administration</a></li>
		</ol>
  </section>
	<!-- Modal -->
	<div class="modal modal-default fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Assigning a Test</h4>
	      </div>
	      <form method="post" action="<?php echo base_url('otest/add_assignment');?>" class="form-horizontal">
		      <div class="modal-body">
		      	<div class="box-body">
		      		<div class="form-group">
								<label for="name">Teacher ID</label>
								<input type="text" class="form-control input-sm" id="teacher-id" name="teacher-id" readonly required>
							</div><!-- ./form-group -->
							<div class="form-group">
								<label for="name">Teacher Name</label>
								<input type="text" class="form-control input-sm" id="teacher-name" name="teacher-name" readonly required>
							</div><!-- ./form-group -->
							<div class="form-group">
								<label for="name">Test</label>
								<select name="test-id" class="form-control" required>
									<option value="">-- Select a Test --</option>
									<?php 
										if($tests<>false)
											foreach($tests->result() as $row){
												echo '<option value="'.$row->test_id.'">'.$row->test_id.' - '.$row->test_name.'</option>';
											}
									?>
								</select>
							</div><!-- ./form-group -->
		    		</div>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-info">Submit</button>
		        <!-- <a href="" id="link-delete"><button type="button" class="btn btn-outline">Save changes</button></a> -->
		      </div>
	      </form>
	    </div>
	  </div>
	</div>
	<!-- Main content -->
    <section class="boxku">
			<div class="row">
				<?php $this->load->view('admin/message_after_transaction.php');?>
				<div class="col-xs-12">
					<div class="box box-info">
	          <div class="box-header">
							<h3>Assign a Tutor</h3>
	          </div><!-- /.box-header -->
	          <div class="box-body">
							<form id="form" method="post">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="user_id">Type the tutor ID / Name / Email</label>
											<input type="text" class="form-control input-sm" id="user_id" name="user_id">
											<input type="hidden" id="selected_user_id">
										</div><!-- ./form-group -->
									</div>
								</div>
							</form>
	          </div><!-- /.box-body -->
	          <div class="overlay" style="display:none" id="loading-edit">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
	          <div class="box-footer">
							<button type="button" id="btn-open" class="btn btn-info">Open</button>
						</div>
	        </div><!-- /.box -->
				</div>
				<div class="col-xs-12">
					<div class="box box-primary">
	          <div class="box-header">
							<h3 class="replace-detail">Detail Assignment</h3>
	          </div><!-- /.box-header -->
	          <div class="box-body">
	          	<button class="btn btn-warning" style="display: none" id="btn-add-assignment">Add an assignment</button>
							<div id="detail-assignment"></div>
	          </div><!-- /.box-body -->
	        </div><!-- /.box -->
				</div>
			</div>
			</div>
		</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

<script>
	$('#btn-open').on('click', function(){
		if($('#selected_user_id').val()=="")
			alert('Please type the tutor ID');
		else{
			generate_data($('#selected_user_id').val());
		}
	});

	$(document).ready(function(){
		<?php 
			if($this->uri->segment(3)<>"") {
				echo 'generate_data("'.$this->uri->segment(3).'");';
				echo '$("#user_id").val("'.$this->uri->segment(3).'")';
			}

		?>
	})

	function generate_data(element_id){
		$('#detail-assignment').empty();
		$('#loading-edit').toggle();
		$('#btn-add-assignment').show();
		$.ajax({
			type : "POST",
			async: false,
			url: '<?php echo base_url();?>otest/get_tutor_assignment/'+element_id,
			dataType: "json",
			success:function(data){
				var table_data = '';
				
				table_data += '<table class="table table-bordered">\
                  <tr>\
                    <th>Assignment ID</th>\
                    <th>Test Name</th>\
                    <th>Related Course</th>\
                    <th>Assignment Result</th>\
                    <th></th>\
                  </tr>';
        for(var i=0; i < data.assignment.length; i++){
        	var taken_assignment = '';
        	var disable_delete = false;
        	if(data.assignment[i].taken_assignment != "empty"){
        		// fetch taken assignment
	        	taken_assignment += '<p>'+data.assignment[i].taken_assignment.taken_time+'<br>\
        													Correct Answer: '+data.assignment[i].taken_assignment.total_right_answer+' / '+data.assignment[i].taken_assignment.total_question+'<br>\
        													Score: '+data.assignment[i].taken_assignment.score+'<br>\
        													Passing Score: '+data.assignment[i].taken_assignment.passing_score+'<br>\
        													Test Result: '+data.assignment[i].taken_assignment.test_result+'<br>\
        													Grade: '+data.assignment[i].taken_assignment.grade+'<br>\
        													<a href="<?php echo base_url()?>otest/view_answer/'+data.assignment[i].taken_assignment.taken_id+'">View Answers</a></p>';        	

	        	var disable_delete = true;
        	}
	        	

        	table_data += '<tr>\
        										<td>'+data.assignment[i].assignment_id+'</td>\
        										<td><strong>'+data.assignment[i].test_id+'</strong> - '+data.assignment[i].test_name+'</td>\
        										<td>'+data.assignment[i].course+'</td>\
        										<td>'+taken_assignment+'</td>\
        										<td>'+(disable_delete==true ? "" : '<a href="<?php echo base_url()?>otest/delete_assignment/'+data.assignment[i].assignment_id+'/'+data.assignment[i].teacher_id+'"><button class="btn btn-danger btn-xs" onclick=\'return confirm("Do you want to delete");\'>\
																<i class="fa fa-trash-o"></i> Delete\
																	</button>\
																</a>')+'</td>\
        									</tr>';
        }
        table_data += '</table>';
				$('#detail-assignment').append(table_data);
				

				// for data in modal
				$('#teacher-id').val(element_id);
				$('#teacher-name').val(data.tutor.name);

				// for detail h3
				$('.replace-detail').text('Detail Assignment for '+data.tutor.name+'(ID '+element_id+')');
			}
		});
		$('#loading-edit').toggle();
	}

	$('#btn-add-assignment').on('click', function(){
		$('#myModal').modal('show');
	});

	//auto complete on teacher's field
	$('#user_id').autocomplete({
		source: "<?php echo site_url('users/tutor_search');?>", // path to the lookup method
		focus : function(){ return false; },
		select: function(event, ui){
			$('#selected_user_id').val(ui.item.id);
			generate_data(ui.item.id);
		}
	});
</script>
</body>
</html>
