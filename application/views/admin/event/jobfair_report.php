<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Events</a></li>
			<li class="active"><a href="#">Job Fair</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-md-12">
				<div class="box box-primary">
          <div class="box-header">
          </div><!-- /.box-header -->
          <div class="box-body">
          	<div class="row">
          		<div class="col-md-3">
          			<select id="sel-events" class="form-control">
              		<option value="">-- Please Select --</option>
              		<?php foreach($events->result() as $event) {?>
              		<option value="<?php echo $event->event_id?>"><?php echo $event->event_name ?></option>
              		<?php } ?>
              	</select>
          		</div>
          		<div class="col-md-3">
          			<button id="btn-generate-data" class="btn btn-primary"><i class="fa fa-search"></i> Search Data</button>
          		</div>
          		<div class="overlay" style="display: none" id="loading-edit">
              	<i class="fa fa-refresh fa-spin"></i>
              </div>
          	</div>
          </div><!-- /.box-body -->
    		</div><!-- /.box -->
			</div>
			<div class="col-md-12">
				<div class="box box-info">
          <div class="box-header">
          	<h4>Applicants Data</h4>
          	<a id="link-download" href="#" class="btn btn-success"><i class="fa fa-download"></i> Download Data</a>
          </div><!-- /.box-header -->
        	<div class="box-body">
						<table id="table-event" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Applicant</th>
									<th>Contact</th>
									<th>Latest Education</th>
									<th>IPK</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
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
	$(function () {
      $("#table-event").dataTable({
  			"bSort": false,
  			"iDisplayLength": 25,
  			"bLengthChange": true,
  			"oSearch": {"sSearch": "<?php echo $this->uri->segment(3)?>"}
  		});
    });

	$('#btn-generate-data').on('click', function(){
		if($('#sel-events').val()=="")
			alert('Please select one event');
		else{
			$('#loading-edit').toggle();

			var oTable = $('#table-event').DataTable();
    	oTable.fnClearTable();

    	$('#link-download').prop('href', '#');

			$.ajax({
				type : "POST",
				async: false,
				url: '<?php echo base_url();?>event/search_applicants/'+$('#sel-events').val(),
				dataType: "json",
				success:function(data){
					if(data.status=="204")
						alert(data.message);
					else{
						for(var i=0; i<data.applicants.length; i++){
							var applicant = data.applicants[i];
		          oTable.fnAddData([
		            applicant.user_info.full_name+'<br/>ID: '+applicant.user_info.user_id,
		            '<i class="fa fa-envelope"></i> '+applicant.user_info.email_primary+'<br/><i class="fa fa-phone"></i> '+applicant.user_info.phone_1,
		            applicant.latest_education.degree+' '+applicant.latest_education.major+' - '+applicant.latest_education.institution,
		            applicant.latest_education.score,
		            '<a target="_blank" class="btn btn-info" href="<?php echo base_url()?>event/open_applicant/'+applicant.user_info.applicant_id+'"><i class="fa fa-search"> Detail</a>'
		            ]);
		        }
		        $('#link-download').prop('href', '<?php echo base_url()?>event/export/jobfair/'+$('#sel-events').val());
					}
				},
	      error: function(e){
	        alert('Error processing your request: '+e.responseText);
	      }
			});
			$('#loading-edit').toggle();
		}
	});

</script>

</body>
</html>
