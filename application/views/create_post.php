<?php if($title=="add") $post_title="Add new";
				else if($title=="edit") $post_title="Edit";
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
			<li class="active">
				<a href="#"><?php echo $post_title;?></a>
			</li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>			
			<div class="col-xs-12">
				<div class="box box-info">
          <div class="box-header">
						<h3 class="box-title"><?php echo $post_title;?> post
						</h3>
          </div><!-- /.box-header -->
          <div class="box-body no-padding">
						<!-- form start -->
						<form role="form" id="form" method="post" action="<?php echo base_url();?>cms/add_post">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-8">
										<div class="form-group">
											<label for="title">Post Title</label>
											<input type="text" class="form-control input-sm" id="title" name="title" placeholder="" required>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="content">Post Content</label>
											<textarea class="form-control" id="content-editor" name="content" rows="10" cols="80"></textarea>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-sm-4">
										<div class="form-group">
											<label for="category">Post Category</label>
											<?php if($category<>false){ 
													foreach($category->result() as $row)
												?>
												<div class="checkbox">
			                    <label>
			                      <input type="checkbox" name="category" id="category" value="<?php echo $row->id;?>" />
			                      <?php echo $row->category;?>
			                    </label>
			                  </div>
											<?php } ?>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">Tags</label>
											<input id="tags_1" type="text" class="tags" name="tags" />
										</div><!-- ./form-group -->
									</div><!-- ./col -->
								</div><!-- ./row -->
								
							</div><!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" class="btn btn-primary" name="action" value="publish">Publish</button> ~ OR ~ <button type="submit" class="btn btn-info" name="action" value="draft">Save as a draft</button>
							</div>
						</form>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php include('footer.php');?>
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
</script>
</body>
</html>
