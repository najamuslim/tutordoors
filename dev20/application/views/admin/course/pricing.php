<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Setup Course Pricing
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Course Management</a></li>
			<li><a href="#">Course Setup</a></li>
			<li class="active">Pricings</li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<div class="col-md-12">
    		<!-- for input filter -->
        <div class="box box-danger">
          <form id="search_form">
            <div class="box-body">
            	<div class="row">
								<div class="col-md-4">
									<div class="form-group">
                    <label>Select a Program</label>
                    <select id="filter-program" class="form-control">
                    	<option value="">--Please Select--</option>
                    	<?php foreach($programs->result() as $prog) {?>
                    	<option value="<?php echo $prog->program_id?>"><?php echo $prog->program_name ?> (Scale: <?php echo ucwords($prog->world_scale) ?>)</option>
                    	<?php } ?>
                    </select>
                  </div>
								</div>
								<div class="col-md-4"></div>
								<div class="col-md-4"></div>
            	</div>
            </div>
          </form>
        </div>
      </div>
			<div class="col-md-12">
				<div class="box box-info">
	                <!-- <div class="box-header">
						<h3 class="box-title">Category List</h3>
	                </div> --><!-- /.box-header -->
	                <div class="box-body">
						<table id="default-table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Course</th>
									<th>General Price</th>
									<th>Module Price</th>
									<th>TryOut Price</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
	                  	</table>
	                </div><!-- /.box-body -->
	                <!-- Loading (remove the following to stop the loading)-->
	                <div class="overlay" style="display:none" id="loading-edit">
	                  <i class="fa fa-refresh fa-spin"></i>
	                </div>
	                <!-- end loading -->
                </div><!-- /.box -->
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<script>
	function open_edit_mode(id)
	{
		$('#general-'+id).empty();
		$('#general-'+id).append('<input type="text" form="form-'+id+'" name="general-price" class="form-control" value="'+$('#tmp-general-'+id).val()+'">');

		$('#module-'+id).empty();
		$('#module-'+id).append('<input type="text" form="form-'+id+'" name="module-price" class="form-control" value="'+$('#tmp-module-'+id).val()+'">');

		$('#tryout-'+id).empty();
		$('#tryout-'+id).append('<input type="text" form="form-'+id+'" name="tryout-price" class="form-control" value="'+$('#tmp-tryout-'+id).val()+'">');

		$('#btn-edit-'+id).toggle();
		$('#btn-save-'+id).toggle();
		$('#btn-cancel-'+id).toggle();
	}

	function cancel(id)
	{
		$('#general-'+id).empty();
		if($('#tmp-general-'+id).val()!="")
			$('#general-'+id).append('IDR '+currency_separator($('#tmp-general-'+id).val(), '.'));

		$('#module-'+id).empty();
		if($('#tmp-module-'+id).val()!="")
			$('#module-'+id).append('IDR '+currency_separator($('#tmp-module-'+id).val(), '.'));

		$('#tryout-'+id).empty();
		if($('#tmp-tryout-'+id).val()!="")
			$('#tryout-'+id).append('IDR '+currency_separator($('#tmp-tryout-'+id).val(), '.'));

		$('#btn-edit-'+id).toggle();
		$('#btn-save-'+id).toggle();
		$('#btn-cancel-'+id).toggle();
	}

	function save(id){
		$('#loading-edit').toggle();
		//grab all form data  
    var formData = $('#form-'+id).serialize();

    $.ajax({
      url: '<?php echo base_url('course/update_pricing/')?>/'+id,
      type: 'POST',
      data: formData,
      async: false,
      dataType: "json",
      enctype: 'multipart/form-data',
      // cache: false,
      // contentType: false,
      // processData: false,
      success: function (data) {
      	$('#general-'+id).empty();
				$('#general-'+id).append('IDR '+currency_separator(data.general_price, '.'));

      	$('#module-'+id).empty();
				$('#module-'+id).append('IDR '+currency_separator(data.module_price, '.'));

				$('#tryout-'+id).empty();
				$('#tryout-'+id).append('IDR '+currency_separator(data.tryout_price, '.'));

				$('#btn-edit-'+id).toggle();
				$('#btn-save-'+id).toggle();
				$('#btn-cancel-'+id).toggle();
      },
      error: function(){
          alert('Error processing your request: '+e.responseText);
      }
    });
		// $.ajax({
		// 	type : "POST",
		// 	async: false,
		// 	url: '<?php echo base_url();?>course/get_category_by_id/'+id,
		// 	dataType: "json",
		// 	success:function(data){
		// 		$('#id-edit').val(id);
		// 		$('#name-edit').val(data.category);
		// 		$('#scale-edit').val(data.world_scale);
		// 		$('#slug-edit').val(data.slug);
		// 		$('#parent-edit').val(data.parent_id);
					
				
		// 		$('#modal-modul-cover').modal('show');
		// 	}
		// });
		$('#loading-edit').toggle();
	}

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

	$('#filter-program').on('change', function() {
    var oTable = $('#default-table').DataTable();
    oTable.fnClearTable();
    $.ajax({
      type : "GET",
      url: "<?php echo base_url('course/get_pricings')?>",
      // async: false,
      data: 'prog_id='+$("#filter-program").val(),
      dataType: "json",
      success: function(data) {
        for(var i=0; i<data.length; i++){
          oTable.fnAddData([
            '<form id="form-' + data[i].id + '">\
            <input type="hidden" id="tmp-module-' + data[i].id + '" value="'+data[i].module_price+'">\
            <input type="hidden" id="tmp-tryout-' + data[i].id + '" value="'+data[i].tryout_price+'">\
            <input type="hidden" id="tmp-general-' + data[i].id + '" value="'+data[i].general_price+'">\
            </form>'
            + data[i].course_code + ' - ' + data[i].course_name,
            '<div id="general-'+data[i].id+'">'+(data[i].general_price=="" ? '-' : 'IDR '+currency_separator(data[i].general_price, ','))+'</div>',
            '<div id="module-'+data[i].id+'">'+(data[i].module_price=="" ? '-' : 'IDR '+currency_separator(data[i].module_price, ','))+'</div>',
            '<div id="tryout-'+data[i].id+'">'+(data[i].tryout_price=="" ? '-' : 'IDR '+currency_separator(data[i].tryout_price, ','))+'</div>',
            '<button type="button" id="btn-edit-' + data[i].id + '" class="btn btn-primary btn-xs" onclick="open_edit_mode(' + data[i].id + ')"><i class="fa fa-edit"></i> Edit</button>\
             <button type="button" id="btn-save-' + data[i].id + '" class="btn btn-success btn-xs" onclick="save(' + data[i].id + ')" style="display:none">\<i class="fa fa-edit"></i> Save</button>'
            ,
            '<button type="button" id="btn-cancel-' + data[i].id + '" class="btn btn-warning btn-xs" onclick="cancel(' + data[i].id + ')" style="display:none"><i class="fa fa-edit"></i> Cancel</button>'
            ]);
        }
      },
      error: function(e){
        alert('Error processing your request: '+e.responseText);
      }
     });
  });
</script>
</body>
</html>
