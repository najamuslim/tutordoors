<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Payroll</a></li>
			<li class="active"><a href="#">Calculation Periods</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<div class="box box-info">
                <div class="box-header">
					<a class="btn btn-danger" href="<?php echo base_url('payroll/calc_period') ?>"><i class="fa fa-plus-circle"></i> Add New Period</a>
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="default-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Period ID</th>
								<th>Description</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Entry Date</th>
								<th>Is active calculation period?</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php if($periods<>false)
								foreach($periods->result() as $row){?>
							<tr>
								<td><?php echo $row->period_id ?></td>
								<td><?php echo $row->description; ?></td>
								<td><?php echo date_format(new DateTime($row->start_date), 'd M Y') ?></td>
								<td><?php echo date_format(new DateTime($row->end_date), 'd M Y') ?></td>
								<td><?php echo date_format(new DateTime($row->entry_date), 'd M Y') ?></td>
								<td>
									<?php echo ($row->is_active_for_calculation=="1" ? '<i class="fa fa-check" style="color: green"></i>' : '<i class="fa fa-times" style="color: red"></i>') ?>
								</td>
								<td>
									<a class="btn btn-primary btn-sm" href="<?php echo base_url('payroll/calc_period?id='.$row->period_id) ?>"><i class="fa fa-pencil-square-o"></i> Edit</a>
									<a href="<?php echo base_url('payroll/activate_period?id='.$row->period_id) ?>" class="btn btn-success" onclick='return confirm("Only one period that can be active. Are you sure?");'>Activate</a>
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
	function change_status(id){
		var checked = '';
		if ($('input#ch-'+id).is(':checked'))
			checked ='1';
		else checked ='0';

		$.ajax({
			type : "POST",
			async: false,
			url: '<?php echo base_url();?>payroll/set_payment_status/'+id+'/'+checked,
			dataType: "json",
			success:function(data){
				alert('Status pembayaran ID Payroll '+id+' telah diubah');
			},
	        error: function(e) {
	          alert('Error processing your request: '+e.responseText);
	        }
		});
	}

</script>
</body>
</html>
