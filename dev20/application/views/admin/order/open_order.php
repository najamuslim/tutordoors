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
			<li class="active"><a href="#">Open Request</a></li>
		</ol>
    </section>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-warning"></i> Hint</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <ol>
            	<li>Click on any rows to view order detail.</li>
            	<li>Please tick one or more data that will be confirmed.</li>
            	<li>Tick the checkbox on header to tick all the checkboxes.</li>
            	<li>Click "Save" to complete confirmation.</li>
            </ol>
          </div><!-- /.box-body -->
      	</div><!-- /.box -->
			</div>
			<?php $this->load->view('admin/message_after_transaction');?>
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
										<th>Order ID / Status</th>
										<th>Order Date</th>
										<th>Student</th>
										<th>Requested Course &amp; Status</th>
										<th>Requested Tutor</th>
										<th>Grand Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if($open_order<>false)
									 		foreach($open_order->result() as $order){
						 			?>
									<tr>
										<!--<td width="30px"><input type="checkbox" name="check[]" value=""></td>-->
										<td>
											<p><a href="<?php echo base_url('order/order_course_detail/'.$order->order_id)?>"><strong><?php echo $order->order_id?></strong></a></p>
											<p>Status: <?php echo $order->order_status?></p>
                    </td>
										<td>
										  <p><?php echo date_format(new DateTime($order->entry_date), 'd M Y H:i')?></p>
										</td>
										<td>
											<p><strong>Name:</strong> <?php echo $order->student_fn.' '.$order->student_ln; ?></p>
                      <p><strong>Phone:</strong> <?php echo $order->student_phone; ?></p>
                      <p><strong>Email:</strong> <?php echo $order->student_email; ?></p>
										</td>
										<td>
											<?php 
												$order_courses = $this->Order_m->get_order_courses($order->order_id);
												$no = 0;
												if($order_courses<>false)
												{
													foreach($order_courses->result() as $course){
														$no++;
														// get info of the course
                            $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                    	?>
                    	<p><strong><?php echo $no?>. <?php echo $course_info->row()->program_name ?></strong> - <i><?php echo $course_info->row()->course_name ?></i> <br>
                    		 <strong>Status:</strong> <?php echo $course->order_status?>
                    	</p>
                    	<?php
													}
												}
											?>
										</td>
										<td>
											<?php
												$order_courses = $this->Order_m->get_order_courses_distinct_tutor($order->order_id);
												$no = 0;
												if($order_courses<>false)
												{
													foreach($order_courses->result() as $course){
														$no++;
														$teachers = $this->User_m->get_user_data(array('user_id' => $course->teacher_id));
														$teacher = $teachers->row();
											?>
											<p><strong><?php echo $no?>. ID: <?php echo $teacher->user_id ?></strong> - <i><?php echo $teacher->first_name.' '.$teacher->last_name ?></i></p>
											<?php
													}
												}
											?>
										</td>
										<td>IDR <?php echo number_format($order->grand_total, 0, '.', ',')?></td>
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
<script>
	$("#check-all").change(function () {
	    $("input:checkbox[name='check[]']").prop('checked', $(this).prop("checked"));
	});
</script>
</body>
</html>
