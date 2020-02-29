<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
			<h1>
				Invoice  
				
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
				<div class="col-md-12">
      		<!-- for input filter -->
          <div class="box box-danger">
            <div class="box-header with-border">
        	    <h3 class="box-title">Filter by Status</h3>
            </div>
            <form id="search_form">
            <div class="box-body">
            	<div class="row">
								<div class="col-md-4">
									<div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="status[]" value="Open"/> Open
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="status[]" value="Settlement"/> Settlement
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="status[]" value="Pending"/> Pending
                      </label>
                    </div>
                  </div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="status[]" value="Cancel"/> Cancel
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="status[]" value="Denied"/> Denied
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="status[]" value="Success"/> Success (Credit Card applied)
                      </label>
                    </div>
                  </div>
								</div>
								<div class="col-md-4"></div>
            	</div>
            </div>
            <div class="box-footer">
            	<button type="button" class="btn btn-primary" id="generate-invoice">Submit</button>
            </div>
            </form>
          </div>
        </div>
				<div class="col-md-12">
					<div class="box box-info">
	          <div class="box-header">
							<a href="<?php echo base_url('invoice/create');?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create Invoice</a>
	          </div><!-- /.box-header -->
	          <div class="box-body">
							<table id="table-invoice" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Invoice ID</th>
										<th>Nama Tertagih</th>
										<th>Reference ID</th>
										<th>Type</th>
										<th>Role</th>
										<th>Total</th>
										<th>Due Date</th>
										<th>Status</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php if($invoices<>false)
										foreach($invoices->result() as $row){?>
									<tr>
										<td><?php echo $row->invoice_id;?></td>
										<td><?php echo $row->first_name.' '.$row->last_name;?></td>
										<td><?php echo $row->reference_id;?></td>
										<td><?php echo ucwords($row->reference_table);?></td>
										<td><?php echo $row->user_level;?></td>
										<td>IDR <?php echo number_format($row->total, 0, ',', '.');?></td>
										<td><?php echo date_format(new DateTime($row->due_date), 'd M Y H:i:s');?></td>
										<td><?php echo $row->status;?></td>
										<td>
											<?php 
											if($row->status=="Created") {?>
											<a href="<?php echo base_url('invoice/edit/'.$row->invoice_id)?>" ><i class="fa fa-pencil-square"></i> Edit</a>
											<?php } ?>
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

<?php $this->load->view('admin/footer');?>

<script>
	$(function () {
      $("#table-invoice").dataTable({
  			"bSort": false,
  			"iDisplayLength": 25,
  			"bLengthChange": true,
  			"oSearch": {"sSearch": "<?php echo $this->uri->segment(3)?>"}
  		});
    });

	$('#generate-invoice').click(function() {
    var oTable = $('#table-invoice').DataTable();
    oTable.fnClearTable();
    $.ajax({
      type : "POST",
      url: "<?php echo base_url('invoice/get_data_by_status')?>",
      // async: false,
      data: $("#search_form").serialize(),
      dataType: "json",
      success: function(data) {
        for(var i=0; i<data.length; i++){
          oTable.fnAddData([
            data[i].id,
            data[i].user_name,
            data[i].reference_id,
            data[i].type,
            data[i].role,
            data[i].nominal,
            data[i].due_date,
            data[i].status,
            ''
            ]);
        }
      },
      error: function(e){
        alert('Error processing your request: '+e.responseText);
      }
     });
  });
</script>
</body>
</html>
