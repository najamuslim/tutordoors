<?php 
	function build_tree_data(array $elements, $parentId = 0, $title=null, $depth=0) {
	    // $branch = array();

	    foreach ($elements as $element) {
	        if ($element['parent_id'] == $parentId) {
	        	// give dash & space
	        	$dash = '';
	        	for($i=0; $i<$depth;$i++)
	        		$dash .= '- - ';
	        	$tr = '<tr>
							<td>'.$dash.$element['category'].'</td>
							<td>'.$element['slug'].'</td>
							<td>
								<button class="btn btn-primary btn-xs" onclick="modal_set('.$element['id'].')">
									<i class="fa fa-edit"></i> Edit
								</button>
								<a href="'.base_url('content/category_delete?ty='.$title.'&id='.$element['id']).'" onclick="return confirm(\'Do you want to delete this category?\');">
									<button class="btn btn-danger btn-xs">
										<i class="fa fa-trash-o"></i> Delete
									</button>
								</a>
							</td>
						</tr>';
				echo $tr;
				$depth_up = $depth + 1;
	            $children = build_tree_data($elements, $element['id'], $title, $depth_up);
	            // if ($children) {
	            //     $element['children'] = $children;
	            // }
	            // $branch[] = $element;
	        }
	    }

	    // return $branch;
	}

	function build_tree_dropdown(array $elements, $parentId = 0, $title=null, $depth=0) {
	    foreach ($elements as $element) {
	        if ($element['parent_id'] == $parentId) {
	        	// give dash & space
	        	$dash = '';
	        	for($i=0; $i<$depth;$i++)
	        		$dash .= '- - ';
	        	$tr = '<option value="'.$element['id'].'">'.$dash.$element['category'].'</option>';
				echo $tr;
				$depth_up = $depth + 1;
	            $children = build_tree_dropdown($elements, $element['id'], $title, $depth_up);
	        }
	    }
	}
 ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo ucwords($title);?> Category
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Content</a></li>
			<li class="active">Category</li>
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
						<form role="form" id="form" method="post" action="<?php echo base_url();?>content/category_update">
							<input type="hidden" name="type" value="<?php echo $title;?>" />
							<input type="hidden" name="id" id="id-edit" />
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Edit Category</h4>
							</div>
							<div class="modal-body">
								<div class="box-body">
									<div class="form-group">
										<label for="input-name"><?php echo $this->lang->line('category');?></label>
										<input type="text" class="form-control input-sm" id="name-edit" name="category" placeholder="" required>
									</div>
									<div class="form-group">
										<label for="input-name">Slug</label> *good keywords
										<input type="text" class="form-control input-sm" id="slug-edit" name="slug" placeholder="" required >
									</div>
									<div class="form-group">
										<label for="input-name">Parent Category</label>
										<select class="form-control" id="parent-edit" name="parent">
											<option value="0">--<?php echo $this->lang->line('select');?> <?php echo $this->lang->line('category');?>--</option>
											<?php 
											if($category <> false) {
												foreach($category->result() as $row){
													
											?>
											<option value="<?php echo $row->id;?>"><?php echo $row->category;?></option>
											<?php 	
												} 
											}
											?>
										</select>
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
			
			<div class="col-xs-8">
				<div class="box box-info">
                <div class="box-header">
					<h3 class="box-title">Category List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="default-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Category</th>
								<!-- <th>Parent</th> -->
								<th>Slug</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php if($category<>false)
								build_tree_data($category->result_array(), 0, $title);
							?>
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
			<div class="col-xs-4">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Add Category</h3>
					</div><!-- /.box-header -->
					
					
					<!-- form start -->
					<form role="form" id="form" method="post" action="<?php echo base_url();?>content/category_add">
						<input type="hidden" name="type" value="<?php echo $title;?>" />
						<div class="box-body">
							<div class="form-group">
								<label for="input-name">Kategori</label>
								<input type="text" class="form-control input-sm" id="name" name="category" placeholder="" required >
							</div>
							<div class="form-group">
								<label for="input-name">Slug</label> *good keywords
								<input type="text" class="form-control input-sm" id="slug" name="slug" placeholder="" required >
							</div>
							<div class="form-group">
								<label for="input-name">Parent</label>
								<select class="form-control" id="parent-add" name="parent">
									<option value="">--Select Category--</option>
									<?php 
									if($category <> false) 
										build_tree_dropdown($category->result_array(), 0, $title);	
									?>
								</select>
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
	//$('#example-modal').modal('hide');
	function modal_set(id){
		$('#loading-edit').toggle();
		$.ajax({
			type : "POST",
			async: false,
			url: '<?php echo base_url();?>content/get_category_by_id/'+id,
			dataType: "json",
			success:function(data){
				$('#id-edit').val(id);
				$('#name-edit').val(data.category);
				$('#slug-edit').val(data.slug);
				$('#parent-edit').val(data.parent_id);
					
				
				$('#modal-edit').modal('show');
			}
		});
		$('#loading-edit').toggle();
	}
</script>
</body>
</html>
