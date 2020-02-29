<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
			<h1>
				All Product
				<small><a href="<?php echo base_url('cms/product_new');?>">Add new product</a></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Product</a></li>
				<li class="active"><a href="#">View All</a></li>
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
	<!-- Main content -->
    <section class="boxku">
			<div class="row">
				<?php include('message_after_transaction.php');?>
				<div class="col-xs-12">
					<div class="box box-info">
	          <div class="box-header">
							List
	          </div><!-- /.box-header -->
	          <div class="box-body">
							<table id="default-table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th><?php echo $this->lang->line('product'); ?></th>
										<th><?php echo $this->lang->line('author'); ?></th>
										<th><?php echo $this->lang->line('category'); ?></th>
										<th><?php echo $this->lang->line('stock'); ?></th>
										<th><?php echo $this->lang->line('price'); ?></th>
										<th><?php echo $this->lang->line('tags'); ?></th>
										<th><?php echo $this->lang->line('status'); ?></th>
										<th><?php echo $this->lang->line('action'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if($post<>false)
										foreach($post->result() as $row){?>
									<tr>
										<td>
											<img src="<?php echo $this->config->item('upload_path').$primary_image[$row->id];?>" alt="foto produk" width="150px" height="100px">
											<br><br>
											<span style="color:green"><i><?php echo $row->title;?></i></span>
										</td>
										<td><?php echo $row->first_name;?></td>
										<td>
											<?php echo $row->category_name;?>
											<br><br>
											<?php echo $cats[$row->id];?>
										</td>
										<td style="text-align:center"><?php echo (isset($prod_detail[$row->id]->stock_qty) ? $prod_detail[$row->id]->stock_qty : "");?></td>
										<?php 
											if(sizeof($prod_detail)>0){
										?>
										<td style="text-align:right"><?php echo (isset($prod_detail[$row->id]->price_sell) ? number_format($prod_detail[$row->id]->price_sell, 0, ',', '.') : "");?></td>
										<?php
											}
										 ?>
										<td><?php echo $row->tags;?></td>
										<td><?php echo $row->status;?></td>
										<td>
											<a href="<?php echo base_url('cms/product_edit').'?po_id='.$row->id.'&pr_id='.(isset($prod_detail[$row->id]->id) ? $prod_detail[$row->id]->id : "");?>">
												<button class="btn btn-primary btn-xs">
													<i class="fa fa-edit"></i> Edit
												</button>
											</a>
											<!-- <a href="<?php echo base_url('cms/delete_post?ty=product&id='.$row->id);?>"> -->
												<button class="btn btn-danger btn-xs" onclick="modal_set('<?php echo $row->id;?>', '<?php echo $row->title;?>')">
													<i class="fa fa-trash-o"></i> Delete
												</button>
											<!-- </a> -->
										</td>
									</tr>
									<?php }	?>	
								</tbody>
	          	</table>
	          </div><!-- /.box-body -->
	        </div><!-- /.box -->
				</div>
			</div>
		</section>
		  
</div><!-- /.content-wrapper -->

<?php include('footer.php');?>
<script>
	//$('#example-modal').modal('hide');
	function modal_set(id, title){
		$('#title-want-to-delete').html(title);
		$('#link-delete').attr('href', "<?php echo base_url('cms/delete_post?ty=product&id=');?>"+id);
		$('#myModal').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
</script>
</body>
</html>
