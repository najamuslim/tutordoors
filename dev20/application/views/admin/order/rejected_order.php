<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Order</a></li>
			<li class="active"><a href="#">Rejected</a></li>
		</ol>
    </section>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<div class="col-xs-12">
				<!-- <form method="POST" action="<?php echo base_url('teacher/verify_request/') ?>"> -->
					<div class="box box-info">
          	<!-- <div class="box-header">
							Open Order Request From Students
          	</div> --><!-- /.box-header -->
          	<div class="box-body">
							<table id="default-table" class="table table-bordered table-striped">
								<thead>
									<tr>
										<!-- <th><input type="checkbox" id="check-all"> Check All</th> -->
										<th>Order ID</th>
										<th>Order Date</th>
										<th>Requested Course</th>
										<th>Grand Total</th>
										<th>Reason</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if($rejects<>false)
									 		foreach($rejects->result() as $order){
						 			?>
									<tr>
										<!--<td width="30px"><input type="checkbox" name="check[]" value=""></td>-->
										<td>
											<a href="<?php echo base_url('order/order_course_detail/'.$order->order_id)?>"><strong><?php echo $order->order_id?></strong></a>
                    </td>
										<td>
										  <?php echo date_format(new DateTime($order->entry_date), 'd M Y H:i')?>
										</td>
										<td>
											<?php 
												$order_courses = $this->Order_m->get_order_courses($order->order_id);
												$no = 0;
												foreach($order_courses->result() as $course){
													$no++;
													// get info of the course
                      		$course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                    	?>
                    	<p><strong><?php echo $no?>. <?php echo $course_info->row()->program_name ?></strong> - <i><?php echo $course_info->row()->course_name ?></i></p>
                    	<?php
												}
											?>
										</td>
										<td>IDR <?php echo number_format($order->grand_total, 0, '.', ',')?></td>
										<td><?php echo $order->reject_notes?></td>
									</tr>
									<?php }	?>	
								</tbody>
	          	</table>
		        </div><!-- /.box-body -->
		        <!-- <div class="box-footer">
		        	<button class="btn btn-primary" type="submit">Verify</button>
		        </div> -->
	        </div><!-- /.box -->
	    	<!-- </form> -->
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

</body>
</html>
