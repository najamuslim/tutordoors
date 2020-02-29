<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
			<h1>
				Online Test Administration  
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Online Test</a></li>
				<li class="active"><a href="#">Administration</a></li>
			</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
			<div class="row">
				<?php $this->load->view('admin/message_after_transaction.php');?>
				<div class="col-md-12">
      		<!-- for input filter -->
          <div class="box box-danger">
            <div class="box-header with-border">
        	    <h3 class="box-title">Filter</h3>
            </div>
            <form id="search_form">
	            <div class="box-body">
	            	<div class="row">
									<div class="col-md-3">
										<div class="form-group">
	                    <div class="checkbox">
	                      <label>
	                        <input type="checkbox" name="is-active" /> Is Active
	                      </label>
	                    </div>
	                  </div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
	                    <div class="checkbox">
	                      <label>
	                        <input type="checkbox" name="random-question" /> Random Question
	                      </label>
	                    </div>
	                  </div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<div class="checkbox">
	                      <label>
	                        <input type="checkbox" name="auto-assignment" /> Auto Assign to New Tutor User
	                      </label>
	                    </div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<div class="checkbox">
	                      <label>
	                        <input type="checkbox" name="course-request" /> Auto Assign to Course Request
	                      </label>
	                    </div>
										</div>
									</div>
	            	</div>
	            </div>
	            <div class="box-footer">
	            	<button type="button" class="btn btn-primary" id="generate">Submit</button>
	            </div>
            </form>
          </div>
        </div>
				<div class="col-md-12">
					<div class="box box-info">
	          <div class="box-header">
				<a href="<?php echo base_url('otest/create');?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create New Online Test</a>
	          </div><!-- /.box-header -->
	          <div class="box-body">
				<table id="default-table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Test ID</th>
							<th>Test Name</th>
							<th>Course Name</th>
							<th>Total Questions</th>
							<th>Is Active</th>
							<th>Random Question</th>
							<th>Automatic Assignment</th>
							<th>Assign to Course Request</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if($tests<>false)
							foreach($tests->result() as $row){?>
						<tr>
							<td><?php echo $row->test_id;?></td>
							<td><?php echo $row->test_name;?></td>
							<td>
								<?php 
									if($row->course_id<>""){
										// get info of the course
										$course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
										echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;
									}
									else
										echo '-';
								?>
							</td>
							<td><?php echo $this->Otest_m->count_question($row->test_id)?></td>
							<td><?php echo ($row->is_active=="1") ? '<i class="fa fa-check" style="color: #00ff00"></i>' : '<i class="fa fa-times" style="color: #ff0000"></i>' ?></td>
							<td><?php echo ($row->random_question=="1") ? '<i class="fa fa-check" style="color: #00ff00"></i>' : '<i class="fa fa-times" style="color: #ff0000"></i>' ?></td>
							<td><?php echo ($row->assign_to_new_tutor=="1") ? '<i class="fa fa-check" style="color: #00ff00"></i>' : '<i class="fa fa-times" style="color: #ff0000"></i>' ?></td>
							<td><?php echo ($row->assign_to_course_request=="1") ? '<i class="fa fa-check" style="color: #00ff00"></i>' : '<i class="fa fa-times" style="color: #ff0000"></i>' ?></td>
							<td>
								<a href="<?php echo base_url('otest/edit?id='.$row->test_id) ?>">
									<button class="btn btn-primary btn-xs">
										<i class="fa fa-edit"></i> Detail/Edit
									</button>
								</a>
							</td>
							<td>
								<a href="<?php echo base_url('otest/delete_test/'.$row->test_id) ?>">
									<button class="btn btn-danger btn-xs" onclick='return confirm("Do you want to delete");'>
										<i class="fa fa-trash-o"></i> Delete
									</button>
								</a>
							</td>
							<td>
								<a href="<?php echo base_url('otest/question/'.$row->test_id) ?>">
									<button class="btn btn-info btn-xs">
										<i class="fa fa-bookmark"></i> Add/Edit Questions
									</button>
								</a>
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
	$('#generate').on('click', function() {
    var oTable = $('#default-table').DataTable();
    oTable.fnClearTable();
    $.ajax({
      type : "POST",
      url: "<?php echo base_url('otest/filter_data')?>",
      // async: false,
      data: $("#search_form").serialize(),
      dataType: "json",
      success: function(data) {
        for(var i=0; i<data.length; i++){
          oTable.fnAddData([
            data[i].id,
            data[i].name,
            data[i].course,
            data[i].total_question,
            (data[i].active=="1" ? '<i class="fa fa-check" style="color: #00ff00"></i>' : '<i class="fa fa-times" style="color: #ff0000"></i>'),
            (data[i].random=="1" ? '<i class="fa fa-check" style="color: #00ff00"></i>' : '<i class="fa fa-times" style="color: #ff0000"></i>'),
            (data[i].auto=="1" ? '<i class="fa fa-check" style="color: #00ff00"></i>' : '<i class="fa fa-times" style="color: #ff0000"></i>'),
            (data[i].course_request=="1" ? '<i class="fa fa-check" style="color: #00ff00"></i>' : '<i class="fa fa-times" style="color: #ff0000"></i>'),
            '<a href="<?php echo base_url('otest/edit?id='.$row->test_id) ?>">\
									<button class="btn btn-primary btn-xs">\
										<i class="fa fa-edit"></i> Detail/Edit\
									</button>\
								</a>',
            '<a href="<?php echo base_url('otest/delete/'.$row->test_id) ?>">\
									<button class="btn btn-danger btn-xs" onclick="return confirm("Do you want to delete");">\
										<i class="fa fa-trash-o"></i> Delete\
									</button>\
								</a>',
						'<a href="<?php echo base_url('otest/question/'.$row->test_id) ?>">\
									<button class="btn btn-info btn-xs">\
										<i class="fa fa-bookmark"></i> Add/Edit Questions\
									</button>\
								</a>'
            ]);
        }
      },
      error: function(e){
        alert('Error processing your request: '+e.responseText);
      }
     });
  });
</script>
</body>
</html>
