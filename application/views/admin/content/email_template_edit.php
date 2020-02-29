<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo GENERAL_CSS_DIR;?>/jquery.tagsinput.css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			Editing Template
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Application Base Setup</a></li>
			<li class="active"><a href="#">Email Template</a></li>
		</ol>
  </section>
	
	<!-- Main content -->
  <section class="boxku">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-warning"></i> Hint for editing template</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <ol>
            	<li>Open <a href="http://www.mailchimp.com">Mailchimp.com</a></li>
            	<li>Open menu Template</li>
            	<li>Click <b>Edit</b> on template that will be edited</li>
            	<li>You can use <b>allowed fields</b> as the variable of this email template, and use like this as example: <b>[FIRST_NAME]</b></li>
            	<li>Make changes then <b>Save &amp; Exit</b></li>
            	<li>Click down arrow beside of <b>Edit</b> button, and click <b>Export as HTML</b>. Download the source code into your local PC.</li>
            	<li>Open it using File Editor such as Notepad, Sublime, or else.</li>
            	<li>Copy and paste the code to textarea below, and click <b>Submit</b> to finish</li>
            </ol>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
			</div>
			<div class="col-md-6">
				<div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-warning"></i> Allowed Fields</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="fa-ul">
            	<?php 
            	$fields = explode(';', $template->allowed_fields); 
            	foreach($fields as $field)
            		echo '<li><i class="fa-li fa fa-check"></i>'.$field.'</li>';
            	?>
            </ul>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
			</div>
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<div class="box box-info">
  				<div class="box-header">
						<h3 class="box-title"><?php echo $template->title ?>
						</h3>
        	</div><!-- /.box-header -->
        	<div class="box-body no-padding">
						<!-- form start -->
						<form role="form" method="post" action="<?php echo base_url('content/update_email_template/'.$template->id);?>">
							<input type="hidden" name="type" value="page">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-8">
										<div class="form-group">
											<label for="content">Template</label>
											<textarea class="form-control" name="content" rows="10" cols="80" required><?php echo htmlspecialchars_decode($template->content);?></textarea>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-sm-4"></div><!-- ./col -->
								</div><!-- ./row -->
						
							</div><!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" class="btn btn-primary" name="action">Submit</button> 
							</div>
						</form>
        	</div><!-- /.box-body -->
	      </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

</body>
</html>
