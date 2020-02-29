<?php
	$active_tab = $this->input->get('tab', TRUE);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			<?php echo $this->lang->line('tracking_shipping'); ?>
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">CMS</a></li>
			<li class="active"><a href="#">Tracking Shipping</a></li>
		</ol>
  </section>
	<!-- Modal delete confirmation -->
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
				<div class="row">
					<div class="col-md-12">
						<div class="box-header">
							<h3 class="box-title">
								<?php echo $this->lang->line('shipping_list'); ?>
							</h3>
							<!-- <span style="font-size:11px">* <?php echo $this->lang->line('click_for_edit_mode'); ?></span> -->
						</div> <!-- /.box-header -->
						<div class="box-body no-padding">
		          <table id="default-table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th><?php echo $this->lang->line('order_id'); ?></th>
										<th><?php echo $this->lang->line('latest_update'); ?></th>
										<th><?php echo $this->lang->line('latest_date_update'); ?></th>
										<th><?php echo $this->lang->line('note'); ?></th>
										<th><?php echo $this->lang->line('user_entry'); ?></th>
										<th><?php echo $this->lang->line('action'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if($track_shipping<>false)
										foreach($track_shipping->result() as $row){?>
									<tr>
										<td><?php echo $row->order_id;?></td>
										<td><?php echo $row->news_update;?></td>
										<td><?php echo $row->time_update;?></td>
										<td><?php echo $row->note;?></td>
										<td><?php echo $row->first_name;?></td>
										<td>
											<button class="btn btn-primary btn-xs" onclick="edit_mode(<?php echo $row->id;?>)">
												<i class="fa fa-edit"></i> Edit
											</button>
											<!-- <a href="<?php echo base_url('cms/delete_post?ty=product&id='.$row->id);?>"> -->
											<button class="btn btn-danger btn-xs" onclick="modal_set('<?php echo $row->id;?>')">
												<i class="fa fa-trash-o"></i> Delete
											</button>
											<!-- </a> -->
										</td>
									</tr>
									<?php }	?>	
								</tbody>
	          	</table>
		        </div><!-- /.box-body -->
					</div> <!-- ./col-md-12 -->
				
					<div class="col-md-6">
						<form method="post" action="<?php echo base_url('cms/add_tracking');?>" class="form-horizontal">
							<div class="box box-info">
								<div class="box-header">
									<h3 class="box-title">
										<?php echo $this->lang->line('add_tracking'); ?>
									</h3>
								</div> <!-- /.box-header -->
								<div class="box-body">
									<div class='form-group'>
										<label class='col-sm-4 text-left'><?php echo $this->lang->line('order_id'); ?> <span style="color:red">*</span></label>
										<div class='col-sm-8'>
											<input type='text' class='form-control' name='order-id' required />
										</div>
									</div>
									<div class='form-group'>
										<label class='col-sm-4 text-left'><?php echo $this->lang->line('latest_update'); ?> <span style="color:red">*</span></label>
										<div class='col-sm-8'>
											<input type='text' class='form-control' name='update' required />
										</div>
									</div>
									<div class='form-group'>
										<label class='col-sm-4 text-left'><?php echo $this->lang->line('latest_date_update'); ?> <span style="color:red">*</span></label>
										<div class="col-sm-8">
												<input type="text" class="form-control" id="date-update" name="date-update" required>
											</div>
									</div>
									<div class='form-group'>
										<label class='col-sm-4 text-left'><?php echo $this->lang->line('note'); ?> </label>
										<div class='col-sm-8'>
											<input type='text' class='form-control' name='note' />
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
					</div> <!-- ./col-md-6 -->
					<div class="col-md-6">
						<form method="post" action="<?php echo base_url('cms/update_tracking');?>" class="form-horizontal">
							<input type="hidden" name="id" id="id" />
							<div class="box box-info">
								<div class="box-header">
									<h3 class="box-title">
										<?php echo $this->lang->line('edit_tracking'); ?>
									</h3>
								</div> <!-- /.box-header -->
								<div class="box-body">
									<div class='form-group'>
										<label class='col-sm-4 text-left'><?php echo $this->lang->line('order_id'); ?> <span style="color:red">*</span></label>
										<div class='col-sm-8'>
											<input type='text' class='form-control' name='order-id' id="order-id-edit" required readonly />
										</div>
									</div>
									<div class='form-group'>
										<label class='col-sm-4 text-left'><?php echo $this->lang->line('latest_update'); ?> <span style="color:red">*</span></label>
										<div class='col-sm-8'>
											<input type='text' class='form-control' name='update' id="news-edit" required />
										</div>
									</div>
									<div class='form-group'>
										<label class='col-sm-4 text-left'><?php echo $this->lang->line('latest_date_update'); ?> <span style="color:red">*</span></label>
										<div class="col-sm-8">
												<input type="text" class="form-control" id="date-edit" name="date-update" required>
											</div>
									</div>
									<div class='form-group'>
										<label class='col-sm-4 text-left'><?php echo $this->lang->line('note'); ?> </label>
										<div class='col-sm-8'>
											<input type='text' class='form-control' name='note' id="note-edit" />
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
					</div> <!-- ./col-md-6 -->
				</div> <!-- ./row -->				
			</div> <!-- ./col-md-12 -->
		</div>
	</section>
</div><!-- /.content-wrapper -->

<?php include('footer.php');?>
<script>
	$(function () {
		$('#date-update').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});
		$('#date-edit').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});
	});

	function modal_set(id, title){
		$('#title-want-to-delete').html(title);
		$('#link-delete').attr('href', "<?php echo base_url('cms/delete_track_shipping?id=');?>"+id);
		$('#myModal').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function edit_mode(id){
		$.ajax({
	    type : "GET",
	    url: "<?php echo base_url();?>order/get_track_by_id/"+id,
	    dataType: "json",
	    success:function(data){
	      $('#id').val(data.id);
	      $('#order-id-edit').val(data.order_id);
	      $('#news-edit').val(data.news);
	      $('#date-edit').val(data.time_update);
	      $('#note-edit').val(data.note);
	    }
	  });
	}

</script>
</body>
</html>
