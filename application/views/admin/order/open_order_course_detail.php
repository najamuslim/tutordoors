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
	<!-- Modal -->
    <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" id="form" method="post" action="<?php echo base_url('order/admin_confirm_order_course');?>">
                    <input type="hidden" name="order-id" value="<?php echo $order_id ?>" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Confirm ID <?php echo $order_id ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <p>Are you sure to confirm this data?</p>
                            <div class="form-group">
				                      <div class="checkbox">
				                        <label>
				                          Invoice will be automatically generated and send to student.
				                        </label>
				                      </div>
			                      </div>
                        </div><!-- /.box-body -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal -->
    <!-- Modal -->
    <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" id="form" method="post" action="<?php echo base_url('order/admin_reject_order_course');?>">
                    <input type="hidden" name="order-id" value="<?php echo $order_id ?>" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Reject ID <?php echo $order_id ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <p>Are you sure to reject this order?</p>
                            <div class="form-group">
                                <label for="input-name">Reason</label>
                                <textarea class="form-control input-sm" name="reason" required></textarea>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal -->
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
            	<li>Please make a coordination with tutor and also student before confirming this order</li>
            	<li>Tutor can accept or reject the order</li>
            	<li>If admin want to confirm this order, only accepted course by Tutor would be confirmed.</li>
            	<li>Click "Confirm" to confirm the accepted course only.</li>
            	<li>Invoice will be created once confirmation completed.</li>
            	<li>Please be noted that grand total is the actual accepted course, and will update the aggregration.</li>
            </ol>
          </div><!-- /.box-body -->
      	</div><!-- /.box -->
			</div>
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-md-12">
				<div class="box box-success">
					<div class="box-header">
						<h3>Summary before confirmed</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<h4>Request from student</h4>
								<dl class="dl-horizontal">
                  <dt>Course</dt>
                  <dd><?php echo $order->count_course ?> Items</dd>
                  <dt>Tutor</dt>
                  <dd><?php echo $order->count_teacher ?> Person</dd>
                  <!-- <dt>Total Price</dt>
                  <dd>IDR <?php //echo number_format($order->total_price, 0, '.', ',') ?></dd> -->
                  <!-- <dt>Admin Fee</dt>
                  <dd>IDR <?php //echo number_format($order->admin_fee * $order->total_price / 100, 0, '.', ',') ?></dd> -->
                  <dt>Grand Total</dt>
                  <dd>IDR <?php echo number_format($order->grand_total, 0, '.', ',') ?></dd>
                  <dt>Status</dt>
                  <dd><?php echo $order->order_status ?></dd>
                </dl>
							</div>
							<div class="col-md-6">
								<h4>Actual accepted by tutor</h4>
								<dl class="dl-horizontal">
                  <dt>Course</dt>
                  <dd><?php echo $accepted_course ?> Items</dd>
                  <dt>Tutor</dt>
                  <dd><?php echo $accepted_teacher ?> Person</dd>
                  <!-- <dt>Total Price</dt>
                  <dd>IDR <?php //echo number_format($accepted_total_price, 0, '.', ',') ?></dd> -->
                  <?php 
                    // $get_admin_fee = $this->Content_m->get_option_by_param('admin_fee_percentage');
                    // $admin_fee = $accepted_total_price * floatval($get_admin_fee->parameter_value) / 100;
                    // $grand_total = $accepted_total_price + $admin_fee;
                    $grand_total = $accepted_total_price;
                   ?>
                  <!-- <dt>Admin Fee</dt>
                  <dd>IDR <?php //echo number_format($admin_fee, 0, '.', ',') ?></dd> -->
                  <dt>Grand Total</dt>
                  <dd>IDR <?php echo number_format($grand_total, 0, '.', ',') ?></dd>
                </dl>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<form method="POST" action="<?php echo base_url('teacher/verify_request/') ?>">
					<div class="box box-info">
          	<!-- <div class="box-header">
							Order Course Detail for ID <?php echo $order_id?>
          	</div> --><!-- /.box-header -->
          	<div class="box-body">
							<table class="table table-striped">
								<tr>
									<th>Order ID / Course</th>
									<th>Student</th>
									<th>Course Detail</th>
									<th>Tutor</th>
									<th>Confirm Status By Tutor</th>
								</tr>
								<?php
									if($order_course<>false)
								 		foreach($order_course->result() as $order){
                      // get info of the course
                      $course_info = $this->Course_m->get_courses(array('c.id' => $order->course_id));
                      // get days
                      $day_string = $this->course_lib->get_days_string($order->days);

                      // additional modules
                      $modules = '';
                      if($order->module_price>0)
                          $modules .= $this->lang->line('module_study').', ';
                      if($order->tryout_price>0)
                          $modules .= $this->lang->line('module_tryout').', ';
                      if($modules=="")
                          $modules = ' - ';
                      else
                          $modules = rtrim($modules, ', ');
					 			?>
								<tr>
									<td>
										<strong><?php echo $order->order_id?></strong>
										<p>
                      <?php 
                      echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;
                      ?>
                    </p>
                    <p></p>
                    <p><strong>Order Time:</strong><br> <?php echo date_format(new DateTime($order->entry_date), 'd M Y H:i')?></p>
									</td>
									<td>
										<p><strong>Name:</strong> <?php echo $order->student_fn.' '.$order->student_ln; ?></p>
                    <p><strong>Phone:</strong> <?php echo $order->student_phone; ?></p>
                    <p><strong>Email:</strong> <?php echo $order->student_email; ?></p>
									</td>
									<td>
										<p><strong>City:</strong> <?php echo $order->city_name; ?></p>
                    <p><strong>Days:</strong> <?php echo $day_string?></p>
                    <p><strong>Session:</strong> <?php echo $order->session_hour ?> Hours</p>
                    <p><strong>Class:</strong> <?php echo $order->class_in_month ?> Times</p>
                    <p><strong>Additional Materials:</strong> <?php echo $modules?></p>
									</td>
									<td>
										<p><strong>Name:</strong> <?php echo $order->teacher_fn.' '.$order->teacher_ln; ?></p>
                    <p><strong>Phone:</strong> <?php echo $order->teacher_phone; ?></p>
                    <p><strong>Email:</strong> <?php echo $order->teacher_email; ?></p>
									</td>
									<td>
										<?php echo $order->order_course_status ?>
									</td>
								</tr>
								<?php }	?>
	          	</table>
		        </div><!-- /.box-body -->
		        <div class="box-footer">
		        	<button class="btn btn-info" type="button" id="btn-confirm">Confirm</button>
		        	<button class="btn btn-danger" type="button" id="btn-reject">Reject</button>
		        </div>
	        </div><!-- /.box -->
	    	</form>
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<script>
	$("#btn-confirm").on('click', function () {
    // check if tutor has confirmed at least one course
    $.ajax({
      type : "POST",
      async: false,
      url: '<?php echo base_url();?>order/check_tutor_confirm_order/<?php echo $order_id ?>',
      dataType: "json",
      success:function(data){
        if(data.status=="200")
          $('#modal-confirm').modal('show');
        else
          alert('Tutor must confirm at least one course order, then retry this action.');
      },
      error: function(e) {
        alert('Error processing your request: '+e.responseText);
      }
    });
    
	});

	$("#btn-reject").on('click', function () {
	    $('#modal-reject').modal('show');
	});

  $(function () {
      $('#date-start').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
</script>
</body>
</html>
