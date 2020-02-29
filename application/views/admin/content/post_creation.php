<?php if($mode=="add") $post_title="Add new";
				else if($mode=="edit") $post_title="Edit";
			 ?>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo GENERAL_CSS_DIR;?>/jquery.tagsinput.css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			<?php echo $post_title;?> post
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Post</a></li>
			<li class="active"><a href="#"><?php echo $post_title;?></a></li>
		</ol>
  </section>
	
	<!-- Main content -->
  <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<div class="box box-info">
  				<!-- <div class="box-header">
						<h3 class="box-title"><?php echo $post_title;?> post
						</h3>
        	</div> --><!-- /.box-header -->
        	<div class="box-body no-padding">
						<!-- form start -->
						<form role="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url().($mode=="add" ? 'content/add_post' : 'content/update_post?id='.$this->input->get('id'));?>">
							<input type="hidden" name="type" value="post">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-8">
										<div class="form-group">
											<label for="title">Post Title</label>
											<input type="text" class="form-control input-sm" id="title" name="title" placeholder="" value="<?php if($mode=='edit') echo $post_data->title;?>" onkeyup="set_url(this.value);" required>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">Niece URL</label>
											<input type="text" class="form-control input-sm" id="url" name="url" placeholder="" value="<?php if($mode=='edit') echo $post_data->url;?>" readonly>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="content">Post Content</label>
											<textarea class="form-control" id="content-editor" name="content" rows="10" cols="80" required> <?php if($mode=='edit') echo $post_data->content;?></textarea>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-sm-4">
										<div class="form-group">
											<label>Language</label>
											<?php echo form_dropdown('lang', $languages, ($mode=='edit' ? $post_data->lang_id : 'id'), 'class="form-control" required') ?>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="category">Post Category</label>
											<select class="form-control" id="prod-cat" name="category">
												<option value="">--Select category--</option>
											<?php 
												if($category<>false){ 
													foreach($category->result() as $row){
														if($mode=="edit") $category_array = explode(',', $post_data->category);
											?>
											
												<option value="<?php echo $row->id;?>" <?php if($mode=='edit' and in_array($row->id, $category_array)) echo "selected";?>><?php echo $row->category; ?></option>
											<?php }
												} 
											?>
											</select>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">Tags</label>
											<input id="tags_1" type="text" class="tags" name="tags"  value="<?php if($mode=='edit') echo $post_data->tags;?>"/>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">Link Address</label>
											<input type="text" class="form-control input-sm" id="link" name="link-address" placeholder="" value="<?php if($mode=='edit') echo $post_data->link_href;?>" >
										</div><!-- ./form-group -->
										<div class="form-group" id="primary_image">
			                <label for="exampleInputFile">Primary Image</label>
			                <input type="file" id="image_file" name="image_file" />
			                <p class="help-block">This image will be displayed on blog list.</p>
								  		<br>
			                <?php if($mode=="edit" and $post_image <> false and $post_image->file_name <> ""){
			                ?>
			                <img src="<?php echo $this->config->item('upload_path').$post_image->file_name;?>" width="150" height="200" />
			                <?php
			                } else{
			                ?>
			                <img src="http://placehold.it/150x100" alt="..." class='margin' />
			                <?php
			                	}
			                ?>
			              </div>
									</div><!-- ./col -->
								</div><!-- ./row -->
						
							</div><!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" class="btn btn-primary" name="action" value="publish">Publish</button> 
								<?php if($mode<>"edit"){ ?>
								~ OR ~ 
								<button type="submit" class="btn btn-info" name="action" value="draft">Save as a draft</button>
								<?php } ?>
							</div>
						</form>
        	</div><!-- /.box-body -->
	      </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
		<?php if($mode=="edit"){ ?>
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-success">
        	<div class="box-header">
						<h3 class="box-title">Add more images
						</h3>
		      </div><!-- /.box-header -->
		      <div class="box-body">
		      	<div class="row">
		        	<div class="col-sm-3">
          			<form role="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url('cms/add_more_images');?>">
									<input type="hidden" name="post_id" value="<?php echo $this->input->get('id', TRUE);?>">
									<div class="form-group" id="more_images">
										<input type="file" name="more_images[]" multiple><br><br>
										<button type="submit" class="btn btn-success">Upload</button> 
									</div>
								</form>
        			</div>
		          <div class="col-sm-9">
								<div class="timeline-item">
				          <div class="timeline-body">
				          	<?php if($more_images<>false){
				            	foreach($more_images->result() as $row){
				            ?>
				            <div class="col-sm-3">
				            	<img src="<?php echo $this->config->item('upload_path').$row->file_name;?>" alt="..." class='margin' width="150" hegith="180" /><br>
				              <a href="<?php echo base_url().'cms/post_media_delete?media='.$row->media_id.'&po_id='.$this->input->get('id', TRUE);?>">Delete this image</a>
				            </div>
				                      
	                      <?php
	                      			}
	                      } ?>
	                      
	                    </div>
	                </div>
        			</div>
        		</div>
        	</div><!-- /.box-body -->
        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
		<?php } ?>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Tags Master -->
<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/jquery.tagsinput.js"></script>

<script>
	$(document).ready(function(){
		$('#tags_1').tagsInput({width:'auto'});
		//$(".editor").jqte();
	});

	$(function () {
	    // Replace the <textarea id="editor1"> with a CKEditor
	    // instance, using default configuration.
	    CKEDITOR.replace('content-editor');
	  });

	function set_url(title){
		var in_lower = title.toLowerCase();
		$('#url').val(in_lower.replace(/[^a-zA-Z0-9]/g,'-'));
	}
</script>
</body>
</html>
