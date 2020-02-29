<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			All Notifications
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Notification</a></li>
			<li class="active"><a href="#">View All</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>
			<div class="col-xs-12">
				<div class="box box-info">
                <div class="box-header">
					List
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="default-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Title</th>
								<th>Content</th>
								<th>Sender</th>
								<th>Timestamp</th>
							</tr>
						</thead>
						<tbody>
							<?php if($show_notifications<>false)
								foreach($show_notifications as $row){?>
							<tr>
								<td><?php echo $row->title;?></td>
								<td width="50%"><?php echo $row->content;?></td>
								<td><?php echo $row->first_name.' '.$row->last_name;?></td>
								<td><?php echo date_format(new DateTime($row->notif_timestamp), 'd M Y H:i:s');?></td>
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
