<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Newsletter Subscribers
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">User</a></li>
			<li class="active"><a href="#">Subscribers</a></li>
		</ol>
    </section>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>
			<div class="col-md-8">
				<div class="box box-info">
	                <!-- <div class="box-header">
						List of Users
	                </div> --><!-- /.box-header -->
	                <div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Email</th>
									<th>Related User</th>
								</tr>
							</thead>
							<tbody>
								<?php if($subscribers<>false)
									foreach($subscribers->result() as $row){?>
								<tr>
									<td><?php echo $row->email;?></td>
									<td><?php echo $row->first_name.' '.$row->last_name;?></td>
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

<?php include('footer.php');?>

</body>
</html>
