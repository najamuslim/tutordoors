<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Base Setup</a></li>
			<li><a href="#">Online Test</a></li>
			<li class="active">Tutor Grade</li>
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
						<form role="form" id="form" method="post" action="<?php echo base_url();?>otest/update_grade">
							<input type="hidden" name="id" id="id-edit" />
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Edit Grade</h4>
							</div>
							<div class="modal-body">
								<div class="box-body">
									<div class="form-group">
										<label for="input-name">Grade</label>
										<input type="text" class="form-control input-sm" id="grade-edit" name="grade" placeholder="ex: A or B or C or D or E" required>
									</div>
									<div class="form-group">
										<label for="input-name">Min Score</label>
										<input type="number" min="0" max="100" class="form-control input-sm" id="min-edit" name="min" placeholder="Choose 0 - 100" required>
									</div>
									<div class="form-group">
										<label for="input-name">Max Score</label>
										<input type="number" min="0" max="100" class="form-control input-sm" id="max-edit" name="max" placeholder="Choose 0 - 100" required>
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
					<h3 class="box-title">Tutor Grade List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<table class="table table-striped">
						<tr>
							<th>Grade</th>
							<th>Min Score</th>
							<th>Max Score</th>
							<th></th>
						</tr>
						<?php 
						if($grades<>false) 
							foreach($grades->result() as $grade)
							{
						?>
						<tr>
							<td><?php echo $grade->grade?></td>
							<td><?php echo $grade->min_score?></td>
							<td><?php echo $grade->max_score?></td>
							<td>
								<button class="btn btn-primary btn-xs" onclick="modal_set('<?php echo $grade->grade_id ?>')">
									<i class="fa fa-edit"></i> Edit
								</button>
								<a href="<?php echo base_url('otest/delete_grade?id='.$grade->grade_id)?>" onclick="return confirm(\'Do you want to delete?\');">
									<button class="btn btn-danger btn-xs">
										<i class="fa fa-trash-o"></i> Delete
									</button>
								</a>
							</td>
						</tr>
						<?php } ?>
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
						<h3 class="box-title">Add Grade</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" id="form" method="post" action="<?php echo base_url();?>otest/add_grade">
						<div class="box-body">
							<div class="form-group">
								<label for="input-name">Grade</label>
								<input type="text" class="form-control input-sm" id="grade" name="grade" placeholder="ex: A or B or C or D or E" required>
							</div>
							<div class="form-group">
								<label for="input-name">Min Score</label>
								<input type="number" min="0" max="100" class="form-control input-sm" id="min" name="min" placeholder="Choose 0 - 100" required>
							</div>
							<div class="form-group">
								<label for="input-name">Max Score</label>
								<input type="number" min="0" max="100" class="form-control input-sm" id="max" name="max" placeholder="Choose 0 - 100" required>
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
	function modal_set(id){
		$('#loading-edit').toggle();
		$.ajax({
			type : "POST",
			async: false,
			url: '<?php echo base_url();?>otest/get_grade_by_id/'+id,
			dataType: "json",
			success:function(data){
				$('#id-edit').val(id);
				$('#grade-edit').val(data.grade);
				$('#min-edit').val(data.min);
				$('#max-edit').val(data.max);
				
				$('#modal-edit').modal('show');
			}
		});
		$('#loading-edit').toggle();
	}
</script>
</body>
</html>
