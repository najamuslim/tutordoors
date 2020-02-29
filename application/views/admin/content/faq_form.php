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
			<?php echo $post_title;?> FAQ
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Post</a></li>
			<li class="active"><a href="#"><?php echo $post_title;?> FAQ</a></li>
		</ol>
  </section>
	
	<!-- Main content -->
  <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>			
			<div class="col-xs-12">
				<div class="box box-info">
  				<div class="box-body no-padding">
						<!-- form start -->
						<form role="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url().($mode=="add" ? 'content/add_faq' : 'content/update_faq/'.$this->input->get('id'));?>">
							<input type="hidden" name="type" value="faq">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-8">
										<div class="form-group">
											<label for="title">Question</label>
											<input type="text" class="form-control input-sm" id="title" name="title" placeholder="" value="<?php if($mode=='edit') echo $post_data->title;?>" onkeyup="set_url(this.value);" required>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">Niece URL</label>
											<input type="text" class="form-control input-sm" id="url" name="url" placeholder="" value="<?php if($mode=='edit') echo $post_data->url;?>" readonly>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="content">Answer</label>
											<textarea class="form-control" id="content-editor" name="content" rows="10" cols="80"> <?php if($mode=='edit') echo $post_data->content;?></textarea>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-sm-4">
										<div class="form-group">
											<label>Language</label>
											<?php echo form_dropdown('lang', $languages, ($mode=='edit' ? $post_data->lang_id : 'id'), 'class="form-control" required') ?>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="category">FAQ Category</label>
											<select class="form-control" id="prod-cat" name="category">
												<option value="">--Select category--</option>
											<?php 
												if($faq_categories<>false){ 
													foreach($faq_categories->result() as $row){
											?>
											
												<option value="<?php echo $row->id;?>" <?php if($mode=='edit' and $row->id==$post_data->category) echo "selected";?>><?php echo $row->category; ?></option>
											<?php }
												} 
											?>
											</select>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">List Order</label>
											<input id="tags_1" class="form-control" type="number" min="1" name="list_order"  value="<?php echo ($mode=='edit' ? $post_data->list_order : '1');?>"/>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
								</div><!-- ./row -->
							</div><!-- /.box-body -->
							<div class="box-footer">
								<button type="submit" class="btn btn-primary" name="action" value="publish">Save</button>
							</div>
						</form>
        	</div><!-- /.box-body -->
	      </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

<script>
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
