<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
	<h1>
		All Messages on Contact Form
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Content</a></li>
		<li class="active"><a href="#">Message Contact</a></li>
	</ol>
  </section>

<!-- Main content -->
<section class="boxku">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
        <div class="box-body">
					<table id="default-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sender Info</th>
								<th>Category</th>
								<th>Subject</th>
								<th>Message</th>
								<th>Timestamp</th>
								<th>Follow Up</th>
							</tr>
						</thead>
						<tbody>
							<?php if($messages<>false)
								foreach($messages->result() as $row){?>
							<tr>
								<td>
									<?php echo $row->name;?><br>
									<i class="fa fa-phone"></i> <?php echo $row->phone;?><br>
									<i class="fa fa-envelope"></i> <?php echo $row->email;?><br>
								</td>
								<td><?php echo $this->lang->line($row->category);?></td>
								<td><?php echo $row->subject;?></td>
								<td width="40%"><?php echo $row->message;?></td>
								<td><?php echo date_format(new DateTime($row->entry_date), 'd M Y H:i:s');?></td>
								<td>
								<div id="status-<?php echo $row->id?>">
								<?php 
									if($row->followed_up=="1")
										echo '<i class="fa fa-check" style="color:#00ff00"></i>';
									else{
										echo '<i class="fa fa-times" style="color:#ff0000"></i><br>';
										echo '<button class="btn btn-warning btn-sm" id="btn-'.$row->id.'" type="button" onclick="follow_up('.$row->id.')">Set as Followed Up</button>';
									}
								?>
								</div>
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
	function follow_up(id){
		$.ajax({
			type : "POST",
			async: false,
			url: '<?php echo base_url();?>content/set_follow_up/'+id,
			dataType: "json",
			success:function(data){
				if(data.status=="200"){
					$('#status-'+id).empty();
					$('#status-'+id).append('<i class="fa fa-check" style="color:#00ff00"></i>');
				}
				else
					alert('Something wrong with the query');
			}
		});
	}
</script>
</body>
</html>
