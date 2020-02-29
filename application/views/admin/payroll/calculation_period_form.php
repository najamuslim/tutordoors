<?php 
	if($mode=="add") $title="Add New";
	else if($mode=="edit") $title="Edit";

?>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo GENERAL_CSS_DIR;?>/jquery.tagsinput.css" />
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			<?php echo $title_page;?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Payroll</a></li>
			<li class="active"><a href="#">Calculation Period</a></li>
		</ol>
  </section>
	
	<!-- Main content -->
  <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>			
			<div class="col-xs-12">
				<div class="box box-info">
  				<!-- <div class="box-header">
						<h3 class="box-title"><?php echo $mode;?> test
						</h3>
        	</div> --><!-- /.box-header -->
        		<!-- form start -->
						<form id="form" method="post" action="<?php echo base_url().($mode=="add" ? 'payroll/insert_calc_period' : 'payroll/update_calc_period'); ?>">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="test-id" class="label-required">Period ID *</label>
											<input type="text" class="form-control input-sm" maxlength="10" name="period_id" placeholder="" value="<?php if($mode=='edit') echo $period->period_id;?>" required <?php if($mode=="edit") echo "readonly"; ?>>
										</div><!-- ./form-group -->
											
										<div class="form-group">
											<label for="name" class="label-required">Description *</label>
											<input type="text" class="form-control input-sm" name="description" placeholder="" value="<?php if($mode=='edit') echo $period->description;?>" required>
										</div><!-- ./form-group -->
										
									</div><!-- ./col -->
									<div class="col-sm-6">
										<div class="form-group">
	                    <label class="label-required">Start Date *</label>
	                    <div class="input-group">
	                    	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                      <input type="text" class="form-control input-sm" id="startdate-datepicker" name="start_date" value="<?php if($mode=='edit') echo $period->start_date;?>" required>
	                    </div><!-- /.input group -->
	                  </div><!-- /.form group -->
										<div class="form-group">
											<label for="how-to" class="label-required">End Date *</label>
											<div class="input-group">
	                    	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                      <input type="text" class="form-control input-sm" id="enddate-datepicker" name="end_date" value="<?php if($mode=='edit') echo $period->end_date;?>" required>
	                    </div><!-- /.input group -->
										</div><!-- ./form-group -->
									</div><!-- ./col -->
								</div><!-- ./row -->
						
							</div><!-- /.box-body -->

							<div class="box-footer">
								<?php
								 	if($mode=="add") {
								?>
								<button type="submit" class="btn btn-primary">Save</button>
								<?php
									}
								 	else if($mode=="edit") {
								?>
								<button type="submit" class="btn btn-primary">Update Changes</button>
								<?php } ?>
							</div>
						</form>
        	
	      </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

<script>
	$(function () {
	  $('#startdate-datepicker, #enddate-datepicker').datetimepicker({
	  		format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#startdate-datepicker').datetimepicker().on('dp.change', function (e) {
        var incrementDay = moment(new Date(e.date));
        incrementDay.add(1, 'days');
        $('#enddate-datepicker').data('DateTimePicker').minDate(incrementDay);
        $(this).data("DateTimePicker").hide();
    });

    $('#enddate-datepicker').datetimepicker().on('dp.change', function (e) {
        var decrementDay = moment(new Date(e.date));
        decrementDay.subtract(1, 'days');
        $('#startdate-datepicker').data('DateTimePicker').maxDate(decrementDay);
         $(this).data("DateTimePicker").hide();
    });
	});

</script>
</body>
</html>
