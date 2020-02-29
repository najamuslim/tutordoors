<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Payroll</a></li>
			<li class="active"><a href="#">History</a></li>
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
								<th>Periode</th>
								<th>Jumlah Guru</th>
								<th>Total Jam</th>
								<th>Total Gaji</th>
								<th>Pembayaran Selesai</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php if($data_payroll<>false)
								foreach($data_payroll->result() as $row){?>
							<tr>
								<td><a href="<?php echo base_url('payroll/checklist?p='.$row->salary_period);?>"><?php echo $row->salary_period; ?></a></td>
								<td><?php echo $row->teachers; ?></td>
								<td><?php echo $row->hours ?></td>
								<td>IDR <?php echo number_format($row->salary, 0, ',', '.'); ?></td>
								<td><?php echo $row->paid_payment ?></td>
								<td>
									<a class="btn btn-info btn-sm" href="<?php echo base_url('payroll/checklist?p='.$row->salary_period);?>"><i class="fa fa-info-circle"></i> Payment Checklist</a>
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
</body>
</html>
