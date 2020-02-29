<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			All Media
			<!-- <small><a href="<?php echo base_url('cms/post_new');?>">Add new media</a></small> -->
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Media</a></li>
			<li class="active"><a href="#">View All</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>
			<div class="col-xs-12">
				<form action="<?php echo base_url('cms/media_add');?>" method="post" enctype="multipart/form-data">
					<div class="box box-primary">
						<div class="box-header">
							Add new media
						</div>
						<div class="box-body">
							<div class="form-group" id="primary_image">
				                <input type="file" id="image_file" name="image_file" />
				                <p class="help-block">Max size is 50MB.</p>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Submit</button> 
						</div>
					</div>
				</form>
			</div>
			<div class="col-xs-12">
				<div class="box box-info">
                <div class="box-header">
					List
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="table-10rows" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th></th>
								<th>Type</th>
								<th>File Name</th>
								<th>Info</th>
								<th>URL</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if($media<>false)
								foreach($media->result() as $row){?>
							<tr>
								<td>
									<?php 
										if($row->file_type=="image/jpeg")
											echo '<img src="'.UPLOAD_IMAGE_DIR.'/'.$row->file_name.'" height="283px" width="234px" />';
										
									?>
								</td>
								<td><?php echo $row->file_type;?></td>
								<td><?php echo $row->file_name;?></td>
								<td><?php echo $row->img_width. ' x '.$row->img_height;?></td>
								<td><?php echo UPLOAD_IMAGE_DIR.'/'.$row->file_name; ?></td>
								<td>
									<a href="<?php echo base_url('cms/media_delete/'.$row->id);?>">
										<button class="btn btn-danger btn-xs">
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


<?php include('footer.php');?>
</body>
</html>
