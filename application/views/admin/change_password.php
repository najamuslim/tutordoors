<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Change My Password
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">User</a></li>
			<li class="active"><a href="#">Change Password</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>			
			<div class="col-xs-12">
				<div class="box box-info">
		          	<div class="box-header">
						<h3 class="box-title">Change My Password
						</h3>
		          	</div><!-- /.box-header -->
		          	<div class="box-body no-padding">
						<!-- form start -->
						<form role="form" id="form-password">
							<input type="hidden" name="email" value="<?php echo $this->session->userdata('email');?>">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="password">Old Password</label>
											<input type="password" class="form-control input-sm" name="old" required>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="password">New Password</label>
											<input type="password" class="form-control input-sm" name="new" required>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
								</div><!-- ./row -->
								
							</div><!-- /.box-body -->

							<div class="box-footer">
								<button type="button" id="btn-submit" class="btn btn-primary" name="action">Submit</button> 
								<p id="message"></p>
							</div>
						</form>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->
<?php include('footer.php');?>
<script>
  $('#btn-submit').on('click', function() {
    $.ajax({
      type : "POST",
      async: false,
      url: "<?php echo base_url();?>users/password_change",
      data: $('#form-password').serialize(),
      dataType: "json",
      success:function(data){
        if(data.status=="200")
          $('#message').text('Password berhasil diubah');
        
        else
          $('#message').text(data.message);
        
      }
    });
  })
</script>



</body>
</html>
