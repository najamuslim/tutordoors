<?php $grades = $this->otest->get_grade_data(); ?>
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
						<form role="form" id="form" method="post" action="<?php echo base_url();?>payroll/update_range_fee">
							<input type="hidden" name="id" id="id-edit" />
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Edit Range Fee</h4>
							</div>
							<div class="modal-body">
								<div class="box-body">
									<div class="form-group">
										<label for="input-name">Class Number</label>
										<select class="form-control input-sm" id="class-edit" name="class" required>
											<?php 
											for($i=1; $i<=10; $i++)
												echo '<option value="'.$i.'">'.$i.'</option>';
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="input-name">Grade</label>
										<select class="form-control input-sm" id="grade-edit" name="grade" required>
											<?php 
											if($grades<>false)
												foreach($grades->result() as $grade)
													echo '<option value="'.$grade->grade_id.'">'.$grade->grade.' ('.$grade->min_score.' - '.$grade->max_score.')</option>';
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="input-name">Range Min</label>
										<div class="input-group">
							                <span class="input-group-addon">IDR</span>
							                <input type="text" class="form-control input-sm" id="min-edit" name="min" placeholder="Numeric only" required>
							            </div>	
									</div>
									<div class="form-group">
										<label for="input-name">Range Max</label>
										<div class="input-group">
							                <span class="input-group-addon">IDR</span>
							                <input type="text" class="form-control input-sm" id="max-edit" name="max" placeholder="Numeric only" required>
							            </div>	
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
                <div class="box-body">
					<table class="table table-striped">
						<tr>
							<th>Class No.</th>
							<?php 
							if($grades<>false)
								foreach($grades->result() as $grade)
									echo '<th>Grade '.$grade->grade.'</th>';
							?>
							<th></th>
						</tr>
						<?php for($i=1; $i<=10; $i++){ ?>
						<tr>
							<td><?php echo $i?></td>
							<?php
								if($grades<>false)
									foreach($grades->result() as $grade)
									{
										$get = $this->payroll->get_range_fee(array('class_number'=>$i, 'grade_id'=>$grade->grade_id));
										if($get<>false)
										{
											$data = $get->row();
											echo '<td>'.number_format($data->range_lowest,0,',','.').' - '. number_format($data->range_highest,0,',','.').'&nbsp;&nbsp;&nbsp;<button title="Edit" class="btn btn-info btn-xs" onclick="modal_set(\''.$data->id.'\')"><i class="fa fa-pencil-square"></i></button>&nbsp;&nbsp;&nbsp;<a title="Delete" href="'.base_url('payroll/delete_range_fee?id='.$data->id).'" onclick="return confirm(\'Do you want to delete?\');"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a></td>';
										}
										else
											echo '<td>(-)</td>';
									}
							?>
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
						<h3 class="box-title">Add Range Fee</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" id="form" method="post" action="<?php echo base_url();?>payroll/add_range_fee">
						<div class="box-body">
							<div class="form-group">
								<label for="input-name">Class Number</label>
								<select class="form-control input-sm" name="class" required>
									<?php 
									for($i=1; $i<=10; $i++)
										echo '<option value="'.$i.'">'.$i.'</option>';
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="input-name">Grade</label>
								<select class="form-control input-sm" name="grade" required>
									<?php 
									if($grades<>false)
										foreach($grades->result() as $grade)
											echo '<option value="'.$grade->grade_id.'">'.$grade->grade.' ('.$grade->min_score.' - '.$grade->max_score.')</option>';
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="input-name">Range Min</label>
								<div class="input-group">
					                <span class="input-group-addon">IDR</span>
					                <input type="text" class="form-control input-sm" name="min" placeholder="Numeric only" required>
					            </div>	
							</div>
							<div class="form-group">
								<label for="input-name">Range Max</label>
								<div class="input-group">
					                <span class="input-group-addon">IDR</span>
					                <input type="text" class="form-control input-sm" name="max" placeholder="Numeric only" required>
					            </div>	
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
			url: '<?php echo base_url();?>payroll/get_range_fee_by_id/'+id,
			dataType: "json",
			success:function(data){
				$('#id-edit').val(id);
				$('#class-edit').val(data.class);
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
