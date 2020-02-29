<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			All Users
			<small><a href="<?php echo base_url('users/add_user');?>">Add new user</a></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">User</a></li>
			<li class="active"><a href="#">View All</a></li>
		</ol>
    </section>
	<!-- Modal delete confirmation -->
		<div class="modal modal-danger fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-sm" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Deleting User</h4>
		      </div>
		      <div class="modal-body">
		        Do you really want to delete this user?<br><p id="title-want-to-delete"></p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
		        <a href="" id="link-delete"><button type="button" class="btn btn-outline">Save changes</button></a>
		      </div>
		    </div>
		  </div>
		</div>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>
			<div class="col-xs-12">
				<div class="box box-info">
	                <div class="box-header">
						<a href="<?php echo base_url('users/export/all')?>" class="btn btn-primary"><i class="fa fa-download"></i> Download All Users</a>
						<a href="<?php echo base_url('users/export/tutor')?>" class="btn btn-warning"><i class="fa fa-download"></i> Download Tutors</a>
						<a href="<?php echo base_url('users/export/student')?>" class="btn btn-success"><i class="fa fa-download"></i> Download Students</a>
	                </div><!-- /.box-header -->
	                <div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>User ID</th>
									<th>Email</th>
									<th>User Level</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Join Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if($users<>false)
									foreach($users->result() as $row){?>
								<tr>
									<td>
										<?php 
										if($row->user_level=="teacher")
											echo '<a target="_blank" href="'.site_url('teacher/detail/'.$row->user_id).'">'.$row->user_id.'</a>';
										else if($row->user_level=="student")
											echo '<a target="_blank" href="'.site_url('student/detail/'.$row->user_id).'">'.$row->user_id.'</a>';
										else
											echo $row->user_id;
										?>
									</td>
									<td><?php echo $row->email_login;?></td>
									<td><?php echo ucwords($row->user_level);?></td>
									<td><?php echo $row->first_name;?></td>
									<td><?php echo $row->last_name;?></td>
									<td><?php echo date_format(new DateTime($row->join_date), 'Y-m-d');?></td>
									<td>
										<a href="<?php echo base_url('users/edit_user?id='.$row->user_id);?>">
											<button class="btn btn-primary btn-xs">
												<i class="fa fa-edit"></i> Edit
											</button>
										</a>
										<?php if($row->user_id<>"admin"){?>
										<button class="btn btn-danger btn-xs" onclick="modal_set('<?php echo $row->user_id;?>', '<?php echo $row->email_login;?>')">
											<i class="fa fa-trash-o"></i> Delete
										</button>
										<?php } ?>
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

<?php include('footer.php');?>

<script>
	function modal_set(id, title){
		$('#title-want-to-delete').html(title);
		$('#link-delete').attr('href', "<?php echo base_url('users/user_delete?id=');?>"+id);
		$('#myModal').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
</script>
</body>
</html>
