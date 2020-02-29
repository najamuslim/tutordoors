<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Teacher</a></li>
			<li class="active"><a href="#">Verified</a></li>
		</ol>
    </section>
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-xs-12">
				<div class="box box-info">
		          	<div class="box-header">
						<a href="<?php echo base_url('teacher/export/verified')?>" class="btn btn-success"><i class="fa fa-download"></i> Download Data</a>
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Join Date</th>
									<th>Salary /1.5hr</th>
									<th>Edit Salary</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if($teachers<>false)
									foreach($teachers->result() as $row){?>
								<tr>
									<td><a href="<?php echo site_url('teacher/detail/'.$row->user_id); ?>"><?php echo $row->user_id;?></a></td>
									<td><?php echo $row->first_name.' '.$row->last_name;?></td>
									<td><?php echo $row->email_login;?></td>
									<td><?php echo $row->phone_1;?></td>
									<td><?php echo date_format(new DateTime($row->join_date), 'd M Y');?></td>
									<td>
										<div class="input-group">
						                    <span class="input-group-addon">IDR</span>
						                    <input type="text" style="width:100%" value="<?php echo number_format($row->salary_per_hour, 0, '.', ','); ?>" id="tb-<?php echo $row->user_id;?>" class="form-control" readonly>
						                </div>
									</td>
									<td>
										<button id="btn-edit-<?php echo $row->user_id;?>" class="btn btn-warning btn-sm" onclick="open_textbox('<?php echo $row->user_id;?>')">Edit</button>
										<button id="btn-save-<?php echo $row->user_id;?>" class="btn btn-primary btn-sm" onclick="save('<?php echo $row->user_id;?>')" style="display:none">Save</button>
										<div class="pull-right" style="display:none" id="loading-submit-<?php echo $row->user_id;?>">
	                                        <i class="fa fa-refresh fa-spin"></i>
	                                    </div>
									</td>
									<td>
										<button id="btn-cancel-<?php echo $row->user_id;?>" class="btn btn-default btn-sm" onclick="cancel('<?php echo $row->user_id;?>')" style="display:none">Cancel</button>
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
	function currency_separator(nStr, sep) {
	    nStr += '';
	    x = nStr.split('.');
	    x1 = x[0];
	    x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	            x1 = x1.replace(rgx, '$1' + sep + '$2');
	    }
	    return x1 + x2;
	}
	function open_textbox(id){
		$("#tb-"+id).prop('readonly', false);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
		var str = $('#tb-'+id).val();
		$('#tb-'+id).val(str.replace(",", ""));
	}

	function cancel(id){
		$("#tb-"+id).prop('readonly', true);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
		var str = $('#tb-'+id).val();
		$('#tb-'+id).val(currency_separator(str, ","));
	}

	function save(id){
		$("#loading-submit-"+id).toggle();
		$.ajax({
	        type : "POST",
	        url: '<?php echo base_url("teacher/update_salary_unit_hour");?>',
	        data: "id="+id+"&sal="+$("#tb-"+id).val(),
	        async: false,
	        dataType: "json",
	        success: function(data) {
	          if(data.status=="204")
	            alert(data.message);
	        },
	        error: function(e) {
	        // Schedule the next request when the current one's complete,, in miliseconds
	          alert('Error processing your request: '+e.responseText);
	        }
	      });
		$("#loading-submit-"+id).toggle();

		$("#tb-"+id).prop('readonly', true);
		$("#btn-edit-"+id).toggle();
		$("#btn-save-"+id).toggle();
		$("#btn-cancel-"+id).toggle();
		var str = $('#tb-'+id).val();
		$('#tb-'+id).val(currency_separator(str, ","));
	}
	
</script>
</body>
</html>
