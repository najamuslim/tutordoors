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
			<li class="active"><a href="#">City-Degree-Course Based Fee</a></li>
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
									<th>Location</th>
									<th>Degree</th>
									<th>Course</th>
									<th>Range Lowest</th>
									<th>Range Highest</th>
									<th>Edit</th>
									<th></th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php if($cdc<>false)
									foreach($cdc->result() as $row){?>
								<tr>
									<td><?php echo $row->province_name.' - '.$row->city_name ?></td>
									<td><?php echo $row->degree ?></td>
									<td><?php echo $row->course_program.' - '.$row->course_name ?></td>
									<td>
										<input type="text" style="width:100%" value="<?php echo $row->range_lowest;?>" id="tb-low-<?php echo $row->range_id;?>" class="form-control" readonly>
									</td>
									<td>
										<input type="text" style="width:100%" value="<?php echo $row->range_highest;?>" id="tb-high-<?php echo $row->range_id;?>" class="form-control" readonly>
									</td>
									<td>
										<button id="btn-edit-<?php echo $row->range_id;?>" class="btn btn-warning btn-sm" onclick="open_textbox('<?php echo $row->range_id;?>')">Edit</button>
										<button id="btn-save-<?php echo $row->range_id;?>" class="btn btn-primary btn-sm" onclick="save('<?php echo $row->range_id;?>')" style="display:none">Save</button>
										<div class="pull-right" style="display:none" id="loading-submit-<?php echo $row->range_id;?>">
					                      	<i class="fa fa-refresh fa-spin"></i>
					                    </div>
									</td>
									<td>
										<button id="btn-cancel-<?php echo $row->range_id;?>" class="btn btn-default btn-sm" onclick="cancel('<?php echo $row->range_id;?>')" style="display:none">Cancel</button>
									</td>
									<td>
										<a href="<?php echo base_url('payroll/delete_cdc_range_fee?id='.$row->range_id);?>" class="btn btn-danger" onclick='return confirm("Do you want to delete?");'><i class="fa fa-warning"></i> Delete</a>
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
						<h3 class="box-title">Add Range Fee</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" id="form" method="post" action="<?php echo base_url();?>payroll/add_cdc_range_fee">
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
								<label for="input-name">Degree</label>
								<select class="form-control" name="degree" required>
									<option value="SMA">SMA</option>
									<option value="D1">D1</option>
									<option value="D2">D2</option>
									<option value="D3">D3</option>
									<option value="D4">D4</option>
									<option value="S1" selected>S1</option>
									<option value="S2">S2</option>
									<option value="S3">S3</option>
								</select>
							</div>
							<div class="form-group">
								<label for="input-name">Program</label>
								<select class="form-control" id="sel-program" name="program" required>
									<option value="">--Select Program--</option>
									<?php 
									if($programs <> false) 
									{
										foreach($programs->result() as $row)
										{
									?>
									<option value="<?php echo $row->program_id;?>"><?php echo $row->program_name;?></option>
									<?php 	
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="input-name">Course</label>
								<select class="form-control" id="sel-course" name="course" required>
									<option value="">--Select Course--</option>
								</select>
							</div>
							<label for="input-name">Range Lowest</label>
							<div class="input-group">
				                <span class="input-group-addon">IDR</span>
				                <input type="text" class="form-control input-sm" name="min" required>
				            </div>
				            <label for="input-name">Range Highest</label>
							<div class="input-group">
				                <span class="input-group-addon">IDR</span>
				                <input type="text" class="form-control input-sm" name="max" required>
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

	$("#sel-program").change(function(e){
	    $.ajax({
	      type : "GET",
	      url: '<?php echo base_url();?>course/get_course_by_program/'+$('#sel-program').val(),
	      dataType: "json",
	      success:function(data){
	          $("#sel-course").find('option').remove().end();
	          // $("#sel-course").append($("<option></option>").val('all').html('All'));
	          for(var i=0; i<data.length;i++)
	            $("#sel-course").append($("<option></option>").val(data[i].id).html(data[i].course_name));
	      }
	    });
	    
	  });


	function open_textbox(id){
		$("#tb-low-"+id).prop('readonly', false);
		$("#tb-high-"+id).prop('readonly', false);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}

	function cancel(id){
		$("#tb-low-"+id).prop('readonly', true);
		$("#tb-high-"+id).prop('readonly', true);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}

	function save(id){
		$("#loading-submit-"+id).toggle();
		$.ajax({
	        type : "POST",
	        url: '<?php echo base_url("payroll/update_cdc_range_fee");?>',
	        data: "id="+id+"&min="+$("#tb-low-"+id).val()+"&max="+$("#tb-high-"+id).val(),
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

		$("#tb-low-"+id).prop('readonly', true);
		$("#tb-high-"+id).prop('readonly', true);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
	}
	
</script>
</body>
</html>
