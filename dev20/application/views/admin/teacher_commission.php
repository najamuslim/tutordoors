<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Komisi Guru
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Payment</a></li>
			<li class="active"><a href="#">Teacher Commission</a></li>
		</ol>
    </section>
	<!-- Modal -->
	<div class="modal modal-default fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Catat Pembayaran Pertama</h4>
	      </div>
	      <form method="post" action="<?php echo base_url('course/submit_payment');?>" class="form-horizontal">
		      <div class="modal-body">
		      	<div class="box-body">
		      		<label>Enroll ID</label>
		        	<div class="input-group">
			        	<span class="input-group-addon"><i class="fa fa-code"></i></span>
			        	<input class="form-control input-sm" type="text" name="enroll-id" id="enroll-id" value="" readonly required>
							</div>
							<label>Termin</label>
							<div class="input-group">
			        	<span class="input-group-addon"><i class="fa fa-tag"></i></span>
								<input class="form-control input-sm" type="text" name="termin" id="termin" value="" readonly required>
							</div>
							<label>Nominal</label>
							<div class="input-group">
			        	<span class="input-group-addon">IDR</span>
								<input class="form-control input-sm" type="text" name="nominal" id="nominal" value="" required>
							</div>
							<label>Tanggal Transfer</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" class="form-control input-sm" id="default-datepicker" name="transfer-date" value="" required>
							</div>
		    		</div>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-info">Submit</button>
		        <!-- <a href="" id="link-delete"><button type="button" class="btn btn-outline">Save changes</button></a> -->
		      </div>
	      </form>
	    </div>
	  </div>
	</div>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>
			<div class="col-xs-12">
				<ul class="nav nav-tabs">
                  <li class="active"><a href="#tab-not-paid" data-toggle="tab">Belum Terbayar</a></li>
                  <li><a href="#tab-termin-1" data-toggle="tab">Terbayar Termin 1</a></li>
                  <li><a href="#tab-termin-2" data-toggle="tab">Terbayar Lunas</a></li>
                  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
				<div class="tab-content">
                  <div class="tab-pane active" id="tab-not-paid">
                    <div class="box box-info">
		                <div class="box-body">
							<table id="default-table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Enroll ID</th>
										<th>Guru</th>
										<th>Total</th>
										<th>Komisi Guru</th>
										<th>Untung Perusahaan</th>
										<th>Termin Pembayaran</th>
										<th>Catat Pembayaran Pertama</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if($comm_zero<>false){
										foreach($comm_zero->result() as $row){
											$total_teacher_comm = ($row->teacher_commission_percent*$row->total) / 100;
											$provit_company = ((100-$row->teacher_commission_percent)*$row->total) / 100;
											$termin_1 = $row->first_teacher_commission * $total_teacher_comm / 100;
											$termin_2 = $row->second_teacher_commission * $total_teacher_comm / 100;
									?>
									<tr>
										<td><?php echo $row->enroll_id;?></td>
										<td>
											<?php echo $row->first_name.' '.$row->last_name;?><br>
											<i class="fa fa-phone"></i> <?php echo $row->phone_1; ?>
										</td>
										<td>IDR <?php echo number_format($row->total, 0, ',', '.'); ?></td>
										<td>
											<?php echo $row->teacher_commission_percent.'% x IDR '. number_format($row->total, 0, ',', '.').' = IDR '.number_format($total_teacher_comm, 0, ',', '.'); ?>
										</td>
										<td>
											<?php echo 100 - $row->teacher_commission_percent.'% x IDR '. number_format($row->total, 0, ',', '.').' = IDR '.number_format($provit_company, 0, ',', '.'); ?>
										</td>
										<td>
											<strong>Termin 1:</strong><br> <?php echo $row->first_teacher_commission.'% x IDR '.number_format($total_teacher_comm, 0, ',', '.').' = IDR '.number_format($termin_1, 0, ',', '.'); ?> <br>
											<strong>Termin 2:</strong><br> <?php echo $row->second_teacher_commission.'% x IDR '.number_format($total_teacher_comm, 0, ',', '.').' = IDR '.number_format($termin_2, 0, ',', '.'); ?>
										</td>
										<td>
											<button class="btn btn-success btn-xs" onclick="modal_set('<?php echo $row->enroll_id;?>', '1')">
												<i class="fa fa-edit"></i> Submit
											</button>
										</td>
									</tr>
									<?php 
										}
									}
									?>	
								</tbody>
		                  	</table>
		                </div><!-- /.box-body -->
	              	</div><!-- /.box -->
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab-termin-1">
                    <div class="box box-primary">
		                <div class="box-body">
							<table id="default-table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Enroll ID</th>
										<th>Guru</th>
										<th>Total Komisi</th>
										<th>Pembayaran 1</th>
										<th>Sisa Bayar</th>
										<th>Catat Pelunasan</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if($comm_one<>false){
										foreach($comm_one->result() as $row){
											$total_teacher_comm = ($row->teacher_commission_percent*$row->total) / 100;
									?>
									<tr>
										<td><?php echo $row->enroll_id;?></td>
										<td>
											<?php echo $row->first_name.' '.$row->last_name;?><br>
											<i class="fa fa-phone"></i> <?php echo $row->phone_1; ?>
										</td>
										<td>IDR <?php echo number_format($total_teacher_comm, 0, ',', '.'); ?></td>
										<td>IDR <?php echo number_format($row->paid_termin_1, 0, ',', '.'); ?></td>
										<td>IDR <?php echo number_format($total_teacher_comm - $row->paid_termin_1, 0, ',', '.'); ?></td>
										<td>
											<button class="btn btn-success btn-xs" onclick="modal_set('<?php echo $row->enroll_id;?>', '2')">
												<i class="fa fa-edit"></i> Submit
											</button>
										</td>
									</tr>
									<?php 
										}
									}
									?>	
								</tbody>
		                  	</table>
		                </div><!-- /.box-body -->
	              	</div><!-- /.box -->
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab-termin-2">
                  	<div class="box box-success">
		                <div class="box-body">
							<table id="default-table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Enroll ID</th>
										<th>Guru</th>
										<th>Pembayaran 1</th>
										<th>Pelunasan</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if($comm_more<>false){
										foreach($comm_more->result() as $row){
									?>
									<tr>
										<td><?php echo $row->enroll_id;?></td>
										<td>
											<?php echo $row->first_name.' '.$row->last_name;?><br>
											<i class="fa fa-phone"></i> <?php echo $row->phone_1; ?>
										</td>
										<td>
											IDR <?php echo number_format($row->paid_termin_1, 0, ',', '.'); ?>
										</td>
										<td>
											IDR <?php echo number_format($row->paid_termin_2, 0, ',', '.'); ?>
										</td>
									</tr>
									<?php 
										}
									}
									?>	
								</tbody>
		                  	</table>
		                </div><!-- /.box-body -->
	              	</div><!-- /.box -->
                  </div>
                </div><!-- /.tab-content -->

				
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<script>
	//$('#example-modal').modal('hide');
	function modal_set(enroll_id, termin){
		$('#enroll-id').val(enroll_id);
		$('#termin').val(termin);
		$('#myModal').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	
</script>

<?php include('footer.php');?>
</body>
</html>
