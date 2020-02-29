<?php
	$active_tab = $this->input->get('tab', TRUE);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $this->lang->line('global_settings'); ?>
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">CMS</a></li>
			<li class="active"><a href="#">Settings</a></li>
		</ol>
    </section>
	
	<!-- General Section -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>
			<div class="col-md-12">
				<!-- Custom Tabs -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li <?php if($active_tab=='') echo 'class="active"';?>>
							<a href="#tab-web" data-toggle="tab">Web Info</a>
						</li>
						<li <?php if($active_tab=='company') echo 'class="active"';?>>
							<a href="#tab-company" data-toggle="tab">Company Info</a>
						</li>
						<li <?php if($active_tab=='socmed') echo 'class="active"';?>>
							<a href="#tab-socmed" data-toggle="tab">Social Media</a>
						</li>
						<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
					</ul>
					<div class="tab-content">
						<!-- TAB Web -->
						<div class="tab-pane <?php if($active_tab=='') echo 'active';?>" id="tab-web">
							<form method="post" enctype="multipart/form-data" action="<?php echo base_url('cms/opt_web_update');?>" class="form-horizontal">
								<div class="box box-info">
									<div class="box-body">
									<?php
										$options_socmed = $this->Content_m->get_option_by_group('web');
										foreach($options_socmed->result() as $option){
									?>
										<div class="form-group">
										  	<label class='col-sm-3 text-left'><?php echo $option->parameter_label?></label>
										  	<div class='col-sm-6'>
										  		<input type='text' class='form-control' name='<?php echo $option->parameter_name?>' value='<?php echo $options[$option->parameter_name]['value']; ?>' />
										  	</div>
										  	<p class="col-sm-3 help-block"><?php echo $options[$option->parameter_name]['desc'];?></p>
										</div>
									<?php } ?>
									</div><!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div><!-- /.box -->
							</form>
						</div><!-- /.tab-web -->
						<!-- TAB company -->
						<div class="tab-pane <?php if($active_tab=='company') echo 'active';?>" id="tab-company">
							<form method="post" action="<?php echo base_url('cms/opt_company_update');?>" class="form-horizontal">
								<div class="box box-info">
									<div class="box-body">
									<?php
										$options_socmed = $this->Content_m->get_option_by_group('company_info');
										foreach($options_socmed->result() as $option){
									?>
										<div class="form-group">
										  	<label class='col-sm-3 text-left'><?php echo $option->parameter_label?></label>
										  	<div class='col-sm-6'>
										  		<input type='text' class='form-control' name='<?php echo $option->parameter_name?>' value='<?php echo $options[$option->parameter_name]['value']; ?>' />
										  	</div>
										  	<p class="col-sm-3 help-block"><?php echo $options[$option->parameter_name]['desc'];?></p>
										</div>
									<?php } ?>
									</div><!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div><!-- /.box -->
							</form>
						</div><!-- /.tab-company -->
						<!-- TAB socmed -->
						<div class="tab-pane <?php if($active_tab=='socmed') echo 'active';?>" id="tab-socmed">
							<form method="post" action="<?php echo base_url('cms/opt_socmed_update');?>" class="form-horizontal">
								<div class="box box-info">
									<div class="box-body">
									<?php
										$options_socmed = $this->Content_m->get_option_by_group('socmed');
										foreach($options_socmed->result() as $option){
									?>
										<div class="form-group">
										  	<label class='col-sm-3 text-left'><?php echo $option->parameter_label?></label>
										  	<div class='col-sm-6'>
										  		<input type='text' class='form-control' name='<?php echo $option->parameter_name?>' value='<?php echo $options[$option->parameter_name]['value']; ?>' />
										  	</div>
										  	<p class="col-sm-3 help-block"><?php echo $options[$option->parameter_name]['desc'];?></p>
										</div>
									<?php } ?>
									</div><!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div><!-- /.box -->
							</form>
						</div><!-- /.tab-socmed -->
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
				
			</div>
		</div>
	</section>
	<section class="boxku">
		
	</section>
</div><!-- /.content-wrapper -->

<?php include('footer.php');?>

</body>
</html>
