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
			<li><a href="#">Base Setup</a></li>
			<li class="active"><a href="#">Bank</a></li>
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
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header">
						<h3 class="box-title">
							Company's Bank
						</h3>
					</div> <!-- /.box-header -->
					<div class="box-body">
	          <table class="table table-condensed">
	          	<tr>
	              <th style="width: 10px">#</th>
	              <th>Bank Name</th>
	              <th>Account Number</th>
	              <th>Holder Name</th>
	              <th>Branch</th>
	              <th>City</th>
	              <th>Is Active?</th>
	              <th>Edit</th>
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
	              <td>
	              	<button class="btn btn-primary btn-sm" onclick="bank_set_edit_mode('<?php echo $row->bank_id;?>')"><i class="fa fa-pencil-square"></i> Edit</button>
	              </td>
	            </tr>
				<?php }
					} 
				?>
	          </table>
	        </div><!-- /.box-body -->
	      </div> <!-- box -->
	    </div>
	    <div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<form method="post" action="<?php echo base_url('cms/bank_add');?>" class="form-horizontal">
							<div class="box box-warning">
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
					<div class="col-md-6">
						<form method="post" action="<?php echo base_url('cms/bank_update');?>" class="form-horizontal">
							<div class="box box-danger">
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
			</div>
		</div>
	</section>
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
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
