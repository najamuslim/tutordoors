<?php
	$active_tab = $this->input->get('tab', TRUE);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Setup</a></li>
			<li class="active"><a href="#"><?php echo ucwords($controller) ?></a></li>
		</ol>
    </section>
	
	<!-- General Section -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-md-12">
				<form method="post" enctype="multipart/form-data" action="<?php echo base_url($controller.'/save_config');?>" class="form-horizontal">
					<div class="box box-info">
						<div class="box-body">
						<?php
							$options_group = $this->Content_m->get_option_by_group($controller);
							foreach($options_group->result() as $option){
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
			</div>
		</div>
	</section>
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

</body>
</html>
