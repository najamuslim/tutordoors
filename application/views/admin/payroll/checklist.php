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
			<li class="active"><a href="#">Checklist</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<div class="box box-info">
                <div class="box-header">
					List
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="default-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Payroll ID</th>
								<th>Guru</th>
								<th>Total</th>
								<th>Info Akun Bank</th>
								<th>Pembayaran Selesai</th>
							</tr>
						</thead>
						<tbody>
							<?php if($data_payroll<>false)
								foreach($data_payroll->result() as $row){?>
							<tr>
								<td><?php echo $row->payroll_id ?></td>
								<td><?php echo $row->teacher_name; ?></td>
								<td>IDR <?php echo number_format($row->total_salary, 0, ',', '.') ?></td>
								<td>
									<p><strong><?php echo $row->bank_name ?></strong></p>
									<p>Norek <?php echo $row->bank_account_number ?></p>
									<p>A/n. <?php echo $row->bank_holder_name ?></p>
									<p>Cabang <?php echo $row->bank_branch.' '.$row->bank_city ?></p>
								</td>
								<td>
									<input type="checkbox" id="ch-<?php echo $row->payroll_id?>" <?php echo ($row->payment_status=="1" ? "checked" : "") ?> onchange="change_status(<?php echo $row->payroll_id?>)">
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
