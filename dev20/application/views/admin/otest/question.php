<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
			<h1>
				Questions for Test <?php echo $test_id; ?>  
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Online Test</a></li>
				<li class="active"><a href="#">Questions</a></li>
			</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
			<div class="row">
				<?php $this->load->view('admin/message_after_transaction.php');?>
				<div class="col-xs-12">
					<div class="box box-info">
	          <div class="box-header">
				<a href="<?php echo base_url('otest/question_create/'.$test_id);?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create New Question</a>
	          </div><!-- /.box-header -->
	          <div class="box-body">
				<table id="table-question" class="table table-bordered table-striped table-question">
					<thead>
						<tr>
							<th>#</th>
							<th>Question</th>
							<th>Type</th>
							<th>Answer</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$no = 0;
						if($questions<>false)
							foreach($questions->result() as $row){
								$no++;
						?>
						<tr>
							<td><?php echo $no.'.'; ?></td>
							<td><?php echo $row->question;?></td>
							<td><?php echo ucwords($row->answer_type);?></td>
							<td><?php echo $row->answer_text;?></td>
							<td>
								<a href="<?php echo base_url('otest/question_edit/'.$test_id.'/'.$row->id) ?>">
									<button class="btn btn-primary btn-xs">
										<i class="fa fa-edit"></i> Edit
									</button>
								</a>
								<a href="<?php echo base_url('otest/question_delete/'.$test_id.'/'.$row->id) ?>">
									<button class="btn btn-danger btn-xs" onclick='return confirm("Do you want to delete");'>
										<i class="fa fa-trash-o"></i> Delete
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
	$(function () {
      $("#table-question").dataTable({
  			"bSort": false,
  			"iDisplayLength": 25,
  			"bLengthChange": true
  		});
    });
</script>
</body>
</html>
