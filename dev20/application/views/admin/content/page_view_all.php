<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			All Pages
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Page</a></li>
			<li class="active"><a href="#">View All</a></li>
		</ol>
  </section>
	
	<!-- Main content -->
  <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-md-12">
				<?php 
				// create loop for table view based on different language
				$lang_array = array('id', 'en');
				 ?>
				<ul class="nav nav-tabs">
          <li class="active"><a href="#tab_id" data-toggle="tab">Content in Bahasa Indonesia</a></li>
          <li><a href="#tab_en" data-toggle="tab">Content in English</a></li>
        </ul>
        <div class="tab-content">
        	<?php 
        	$cnt = 0;
        	foreach($lang_array as $lang){
        		$active = '';
        		if($cnt==0)
        			$active = ' active';
        	 ?>
		      <div class="tab-pane<?php echo $active?>" id="tab_<?php echo $lang?>">
						<div class="box box-info">
		          <div class="box-header">
								<a href="<?php echo base_url('content/page_new');?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add new page</a>
              </div><!-- /.box-header -->
		          <div class="box-body">
								<table id="default-table-<?php echo $lang?>" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Title</th>
											<th>Author</th>
											<th>URL</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if($post<>false)
											foreach($post->result() as $row){
												if($row->lang_id==$lang){?>
										<tr>
											<td><?php echo $row->title;?></td>
											<td><?php echo $row->first_name;?></td>
											<td><?php echo $row->url;?></td>
											<td>
												<a href="<?php echo base_url('content/page_edit?id='.$row->id);?>">
													<button class="btn btn-primary btn-xs">
														<i class="fa fa-edit"></i> Edit
													</button>
												</a>
												<a href="<?php echo base_url('content/delete_post?ty=page&id='.$row->id);?>" onclick="return confirm('Do you want to delete this page?');" >
													<button class="btn btn-danger btn-xs">
													<i class="fa fa-trash-o"></i> Delete
												</button></a>
											</td>
										</tr>
										<?php }}	?>	
									</tbody>
		          	</table>
		          </div><!-- /.box-body -->
		        </div><!-- /.box -->
	        </div>
		      <?php 
		      	$cnt++;
		      	} ?>
		    </div>
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
</body>
</html>
