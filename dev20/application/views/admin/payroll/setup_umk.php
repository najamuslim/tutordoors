<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Setup</a></li>
			<li class="active"><a href="#">UMK</a></li>
		</ol>
    </section>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-warning"></i> Petunjuk</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <ol>
            	<li>Untuk mengubah data, klik Edit, isi perubahan data, lalu klik Save</li>
            	<li>Untuk menghapus data, klik Delete. Data tidak dapat dihapus jika terdapat data lain yang mengacu ke data yang diubah.</li>
            </ol>
          </div><!-- /.box-body -->
      </div><!-- /.box -->
			</div>
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-md-8">
				<div class="box box-info">
		          	<div class="box-header">
						List
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Province</th>
									<th>City</th>
									<th>UMK Nominal</th>
									<th>No. Class</th>
									<th>Edit</th>
									<th></th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php if($umk<>false)
									foreach($umk->result() as $row){?>
								<tr>
									<td><?php echo $row->province_name ?></td>
									<td><?php echo $row->city_name ?></td>
									<td>
										<input type="text" style="width:100%" value="<?php echo $row->umk_nominal;?>" id="tb-umk-<?php echo $row->city_id;?>" class="form-control" readonly>
									</td>
									<td>
										<input type="text" style="width:100%" value="<?php echo $row->class_number;?>" id="tb-class-<?php echo $row->city_id;?>" class="form-control" readonly>
									</td>
									<td>
										<button id="btn-edit-<?php echo $row->city_id;?>" class="btn btn-warning btn-sm" onclick="open_textbox('<?php echo $row->city_id;?>')">Edit</button>
										<button id="btn-save-<?php echo $row->city_id;?>" class="btn btn-primary btn-sm" onclick="save('<?php echo $row->city_id;?>')" style="display:none">Save</button>
										<div class="pull-right" style="display:none" id="loading-submit-<?php echo $row->city_id;?>">
                      <i class="fa fa-refresh fa-spin"></i>
                    </div>
									</td>
									<td>
										<button id="btn-cancel-<?php echo $row->city_id;?>" class="btn btn-default btn-sm" onclick="cancel('<?php echo $row->city_id;?>')" style="display:none">Cancel</button>
									</td>
									<td>
										<a href="<?php echo base_url('payroll/delete_umk/'.$row->city_id);?>" class="btn btn-danger" onclick='return confirm("Do you want to delete");'><i class="fa fa-warning"></i> Delete</a>
									</td>
								</tr>
								<?php }	?>	
							</tbody>
			          	</table>
			        </div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div>
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Add UMK</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" id="form" method="post" action="<?php echo base_url();?>payroll/add_umk">
						<div class="box-body">
							<div class="form-group">
								<label for="input-name">Province</label>
								<select class="form-control" id="sel-province" name="province" required>
									<option value="">--Select Province--</option>
									<?php 
									if($provinces <> false) 
									{
										foreach($provinces->result() as $row)
										{
									?>
									<option value="<?php echo $row->province_id;?>"><?php echo $row->province_name;?></option>
									<?php 	
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="input-name">City</label>
								<select class="form-control" id="sel-city" name="city" required>
									<option value="">--Select City--</option>
								</select>
							</div>
							<div class="form-group">
								<label for="input-name">Number Class</label>
								<input type="text" class="form-control input-sm" name="class" required maxlength="2">
							</div>
							<label for="input-name">Nominal UMK</label>
							<div class="input-group">
                <span class="input-group-addon">IDR</span>
                <input type="text" class="form-control input-sm" name="nominal" required>
              </div>
								
						</div><!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<script>
	$("#sel-province").change(function(e){
    $.ajax({
      type : "GET",
      url: '<?php echo base_url()?>location/get_cities_by_province/'+$("#sel-province").val(),
      // data: "id="+$("#ship-city").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#sel-city").find('option').remove().end();
          for(var i=0; i<data.cities.length;i++)
            $("#sel-city").append($("<option></option>").val(data.cities[i].id).html(data.cities[i].name));
        }            
      }
    });
  });

	function open_textbox(id){
		$("#tb-umk-"+id).prop('readonly', false);
		$("#tb-class-"+id).prop('readonly', false);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}

	function cancel(id){
		$("#tb-umk-"+id).prop('readonly', true);
		$("#tb-class-"+id).prop('readonly', true);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}

	function save(id){
		$("#loading-submit-"+id).toggle();
		$.ajax({
	        type : "POST",
	        url: '<?php echo base_url("payroll/update_umk");?>',
	        data: "id="+id+"&umk="+$("#tb-umk-"+id).val()+"&class="+$("#tb-class-"+id).val(),
	        async: false,
	        dataType: "json",
	        success: function(data) {
	          if(data.status=="301")
	            alert(data.message);
	        },
	        error: function(e) {
	        // Schedule the next request when the current one's complete,, in miliseconds
	          alert('Error processing your request: '+e.responseText);
	        }
	      });
		$("#loading-submit-"+id).toggle();

		$("#tb-umk-"+id).prop('readonly', true);
		$("#tb-class-"+id).prop('readonly', true);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}
	
</script>
</body>
</html>
