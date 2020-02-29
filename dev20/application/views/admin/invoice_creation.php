<?php if($title=="add") $post_title = 'Add Invoice';
				else if($title=="edit") $post_title = 'Edit Invoice';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  	<section class="content-header">
		<h1>
			<?php echo $post_title;?>
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Payment</a></li>
			<li class="active"><a href="#">Invoice</a></li>
		</ol>
 	</section>
	
	<!-- Main content -->
  	<section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction.php');?>			
			<div class="col-xs-12">
				<div class="box box-info">
  					<!-- <div class="box-header">
						<h3 class="box-title"><?php echo $post_title;?>
						</h3>
	        		</div> --><!-- /.box-header -->
		        	<div class="box-body no-padding">
						<!-- form start -->
						<form role="form" id="form" method="post" action="<?php echo base_url().($title=="add" ? 'invoice/add' : 'invoice/update');?>">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="title">Invoice ID</label>
											<input type="text" class="form-control input-sm" name="id" id="id" placeholder="" value="<?php if($title=='edit') echo $invoice->invoice_id;?>" onkeyup="to_upper_case('id', this.value);" maxlength="20" required <?php if($title=="edit") echo "readonly";?>>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="content">User</label>
											<select name="user" class="form-control">
												<option value=""></option>
												<?php if($users<>false) 
													foreach($users->result() as $row){?>
												<option value="<?php echo $row->user_id?>" <?php if($title=='edit') if($invoice->user_id==$row->user_id) echo "selected"?>><?php echo $row->user_id.' | '.$row->first_name.' '.$row->last_name ?></option>
												<?php } ?>
											</select>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-sm-4">
										<div class="form-group">
											<label for="content">Reference</label>
											<select name="reference_table" class="form-control">
												<option value="Orders">Order</option>
											</select>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">Reference ID</label>
											<input type="text" class="form-control input-sm" name="reference_id" id="reference_id" value="<?php if($title=='edit') echo $invoice->reference_id;?>" onkeyup="to_upper_case('reference_id', this.value);" required>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-sm-4">
										<div class="form-group">
											<label for="content">Batas Waktu</label>
											<div class="input-group">
												<input type="text" class="form-control input-sm" id="starttime-datepicker" name="due-date" value="<?php if($title=='edit') echo $invoice->due_date;?>" required>
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											</div>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">Total Tagihan</label>
											<input type="text" class="form-control input-sm" name="total" value="<?php if($title=='edit') echo $invoice->total;?>" required>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
								</div><!-- ./row -->
						
							</div><!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Submit</button> 
							</div>
						</form>
	        		</div><!-- /.box-body -->
	      		</div><!-- /.box -->
			</div><!-- /.col -->
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

<script>
	$(function () {
		$('#starttime-datepicker').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});
	});

	function to_upper_case(el, title){
		var res = title.toUpperCase();
		$('#'+el).val(res);
	}
</script>
</body>
</html>
