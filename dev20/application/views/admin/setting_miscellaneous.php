<?php
	$active_tab = $this->input->get('tab', TRUE);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			Miscellaneous
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Setting</a></li>
			<li class="active"><a href="#">Miscellaneous</a></li>
		</ol>
  </section>
	<!-- Modal -->
		<div class="modal modal-danger fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-sm" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('delete_product'); ?></h4>
		      </div>
		      <div class="modal-body">
		        <?php echo $this->lang->line('want_to_delete_data'); ?><br><p id="title-want-to-delete"></p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
		        <a href="" id="link-delete"><button type="button" class="btn btn-outline">Save changes</button></a>
		      </div>
		    </div>
		  </div>
		</div>
	<!-- General Section -->
  <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>
			<div class="col-md-12">
				<!-- Custom Tabs -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li <?php if($active_tab=="") echo 'class="active"';?>>
							<a href="#tab-bank" data-toggle="tab">Bank</a>
						</li>
						<li <?php if($active_tab=='order') echo 'class="active"';?>>
							<a href="#tab-order" data-toggle="tab">Order</a>
						</li>
						<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
					</ul>
					<div class="tab-content">
						<!-- TAB contact -->
						<div class="tab-pane <?php if($active_tab=='') echo 'active';?>" id="tab-bank">
							<div class="row">
								<div class="col-md-7">
									<div class="box-header">
												<h3 class="box-title">
													<?php echo $this->lang->line('bank_list'); ?>
												</h3>
												<span style="font-size:11px">* <?php echo $this->lang->line('click_for_edit_mode'); ?></span>
											</div> <!-- /.box-header -->
									<div class="box-body no-padding">
					          <table class="table table-condensed">
					          	<tr>
					              <th style="width: 10px">#</th>
					              <th><?php echo $this->lang->line('bank_name'); ?></th>
					              <th><?php echo $this->lang->line('bank_ac_number'); ?></th>
					              <th><?php echo $this->lang->line('bank_holder_name'); ?></th>
					              <th><?php echo $this->lang->line('bank_branch'); ?></th>
					              <th><?php echo $this->lang->line('city'); ?></th>
					              <th><?php echo $this->lang->line('active'); ?></th>
					            </tr>
					            <?php 
					            	$cnt = 0;
					            	if($banks<>false){
					            	foreach($banks->result() as $row){
					            		$cnt += 1;
					            ?>
					            <tr>
					            	<td onclick="bank_set_edit_mode('<?php echo $row->bank_id;?>')"><?php echo $cnt;?>.</td>
					              <td onclick="bank_set_edit_mode('<?php echo $row->bank_id;?>')"><?php echo $row->bank_name;?></td>
					              <td onclick="bank_set_edit_mode('<?php echo $row->bank_id;?>')"><?php echo $row->bank_account_number;?></td>
					              <td onclick="bank_set_edit_mode('<?php echo $row->bank_id;?>')"><?php echo $row->bank_holder_name;?></td>
					              <td onclick="bank_set_edit_mode('<?php echo $row->bank_id;?>')"><?php echo $row->bank_branch;?></td>
					              <td onclick="bank_set_edit_mode('<?php echo $row->bank_id;?>')"><?php echo $row->bank_city;?></td>
					              <td>
					              	<input type="checkbox" id="cb-<?php echo $row->bank_id;?>" <?php if($row->active=="true") echo "checked";?>/>
					              </td>
					            </tr>
								<?php }
									} 
								?>
					          </table>
					        </div><!-- /.box-body -->
								</div> <!-- ./col-md-6 -->
							
								<div class="col-md-5">
									<form method="post" action="<?php echo base_url('cms/bank_add');?>" class="form-horizontal">
										<div class="box box-info">
											<div class="box-header">
												<h3 class="box-title">
													Add Bank Account
												</h3>
											</div> <!-- /.box-header -->
											<div class="box-body">
												<div class='form-group'>
													<label class='col-sm-3 text-left'>Bank Name <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='name' required />
													</div>
												</div>
												<div class='form-group'>
													<label class='col-sm-3 text-left'>Account Number <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='number' required />
													</div>
												</div>
												<div class='form-group'>
													<label class='col-sm-3 text-left'>Account Name <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='account-name' required />
													</div>
												</div>
												<div class='form-group'>
													<label class='col-sm-3 text-left'>Branch <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='branch' required />
													</div>
												</div>
												<div class='form-group'>
													<label class='col-sm-3 text-left'>City <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='city' required />
													</div>
												</div>
											</div><!-- /.box-body -->
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>
											<!-- Loading (remove the following to stop the loading)-->
											<div class="overlay" style="display:none" id="loading-edit">
											  <i class="fa fa-refresh fa-spin"></i>
											</div>
											<!-- end loading -->
										</div><!-- /.box -->
									</form>
								</div>
								<div class="col-md-5">
									<form method="post" action="<?php echo base_url('cms/bank_update');?>" class="form-horizontal">
										<div class="box box-info">
											<div class="box-header">
												<h3 class="box-title">
													Edit Bank Account
												</h3>
											</div> <!-- /.box-header -->
											<div class="box-body">
												<input type="hidden" name="id" id="bank-id" value="" />
												<div class='form-group'>
													<label class='col-sm-3 text-left'>Bank Name <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='name' id="bank-name" required />
													</div>
												</div>
												<div class='form-group'>
													<label class='col-sm-3 text-left'>Account Number <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='number' id="bank-number" required />
													</div>
												</div>
												<div class='form-group'>
													<label class='col-sm-3 text-left'>Account Name <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='account-name' id="bank-account-name" required />
													</div>
												</div>
												<div class='form-group'>
													<label class='col-sm-3 text-left'>Branch <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='branch' id="bank-branch" required />
													</div>
												</div>
												<div class='form-group'>
													<label class='col-sm-3 text-left'>City <span style="color:red">*</span></label>
													<div class='col-sm-6'>
														<input type='text' class='form-control' name='city' id="bank-city" required />
													</div>
												</div>
											</div><!-- /.box-body -->
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>
											<!-- Loading (remove the following to stop the loading)-->
											<div class="overlay" style="display:none" id="loading-edit">
											  <i class="fa fa-refresh fa-spin"></i>
											</div>
											<!-- end loading -->
										</div><!-- /.box -->
									</form>
								</div>
							</div> <!-- ./row -->
						</div><!-- /.tab-bank -->
						<!-- TAB Order -->
						<div class="tab-pane <?php if($active_tab=='order') echo 'active';?>" id="tab-order">
								<div class="box box-success">
	                <div class="box-header">
	                  <!-- <h3 class="box-title">Payroll Settings</h3> -->
	                  <div class="box-tools pull-right">
	                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                  </div>
	                </div><!-- /.box-header -->
	                <form method="post" action="<?php echo base_url('cms/opt_order_update');?>" class="form-horizontal">
		                <div class="box-body">  	
											<?php
												$options_socmed = $this->Content_m->get_option_by_group('order');
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
										</div>
										<div class="box-footer">
											<button type="submit" class="btn btn-primary">Submit</button>
										</div>
									</form>
								</div>
						</div><!-- /.tab-order -->
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
				
			</div>
		</div>
	</section>
</div><!-- /.content-wrapper -->

<?php include('footer.php');?>
<script>
	function point_set_edit_mode(id){
		$.ajax({
			type : "GET",
			async: false,
			url: '<?php echo base_url();?>cms/point_get_data_by_id/'+id,
			dataType: "json",
			success:function(data){
				$('#point-id').val(id);
				$('#point-title').val(data.title);
				$('#point-point').val(data.point);
				$('#point-price').val(data.price);
			}
		});
	}

	function bank_set_edit_mode(id){
		$.ajax({
			type : "GET",
			async: false,
			url: '<?php echo base_url();?>cms/bank_get_data_by_id/'+id,
			dataType: "json",
			success:function(data){
				$('#bank-id').val(id);
				$('#bank-name').val(data.name);
				$('#bank-number').val(data.number);
				$('#bank-account-name').val(data.account_name);
				$('#bank-branch').val(data.branch);
				$('#bank-city').val(data.city);
			}
		});
	}

	$(document).ready(function() {
    <?php 
    	if($banks<>false) {
    		foreach($banks->result() as $row) {?>
    $('#cb-<?php echo $row->bank_id;?>').change(function() {
        if($(this).is(":checked"))
          change_bank_active_status("<?php echo $row->bank_id;?>","true");
        else
        	change_bank_active_status("<?php echo $row->bank_id;?>","false");
    });
    <?php 
			}
		}
	?>
	});

	function change_bank_active_status(id, status){
		$.ajax({
			type : "GET",
			async: false,
			url: '<?php echo base_url();?>cms/change_bank_active/'+id+'/'+status,
			dataType: "json",
			success:function(data){
				
			}
		});
	}

	function update_shipping_cost(ship_id){
		var paket = $('#package-'+ship_id).val();
		var cost = $('#cost-'+ship_id).val();
		$.ajax({
			type : "POST",
			async: false,
			url: '<?php echo base_url();?>cms/update_shipping_cost',
			data: 'id='+ship_id+'&package='+paket+'&cost='+cost,
			dataType: "json",
			success:function(data){
				if(data.status="200")
					alert('Data berhasil diubah.');
				else
					alert(data.message);
			}
		});
	}

	function modal_set(id, title){
		$('#title-want-to-delete').html(title);
		$('#link-delete').attr('href', "<?php echo base_url('cms/delete_shipping_cost?id=');?>"+id);
		$('#myModal').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

</script>
</body>
</html>
