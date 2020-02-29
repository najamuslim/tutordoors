<?php 
	/* untuk module cover

	-- di build_tree_data
	<td id="file-'.$element['id'].'">'.($element['file_name']=="" ? '' : '<img src="'.UPLOAD_IMAGE_DIR.'/'.$element['file_name'].'" width="150px" alt="module cover">' ).'
								<br>
								<button type="button" class="btn btn-info btn-xs" onclick="open_modal_module_cover('.$element['id'].')" style="margin-top: 5px;">
									<i class="fa fa-edit"></i> Add / Edit Module Cover
								</button>
							</td>

	-- di modal
	<!-- Modal -->
			<div class="modal fade" id="modal-modul-cover" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<form role="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>course/update_module_cover">
							<input type="hidden" name="id" id="id-edit" />
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Add/Edit Module Cover</h4>
							</div>
							<div class="modal-body">
								<div class="box-body">
									<p>Allowed file types: *.jpg, *.png, *.gif, *.jpeg</p>
									<div class="form-group">
										<!-- <label for="input-name">Category</label> -->
										<input type="file" name="module-file" required>
									</div>
								</div><!-- /.box-body -->
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save Changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Modal -->
	-- di table header

	<th>Module Cover</th>
	*/
	function build_tree_data(array $elements, $parentId = 0, $title=null, $depth=0) {
	    // $branch = array();

	    foreach ($elements as $element) {
	        if ($element['parent_id'] == $parentId) {
	        	// give dash & space
	        	$dash = '';
	        	for($i=0; $i<$depth;$i++)
	        		$dash .= '- - ';
	        	$tr = '<tr>
	        				<form id="form-'.$element['id'].'">
	        					<input type="hidden" id="tmp-module-'.$element['id'].'" value="'.$element['module_price'].'">
	        					<input type="hidden" id="tmp-tryout-'.$element['id'].'" value="'.$element['tryout_price'].'">
	        					<input type="hidden" id="tmp-file-'.$element['id'].'" value="'.$element['file_name'].'">
	        				</form>
							<td>'.$dash.$element['category'].'</td>
							<td>'.$element['world_scale'].'</td>
							<td id="file-'.$element['id'].'">'.(($element['module_file_id']=="" or $element['module_file_id']=="0") ? '' : '<a href="'.base_url('course/download_doc/'.$element['module_file_id']).'"><i class="fa fa-download"></i> Download</a>' ).'
								<br>
								<button type="button" class="btn btn-info btn-xs" onclick="open_modal_module_doc('.$element['id'].')" style="margin-top: 5px;">
									<i class="fa fa-edit"></i> Add / Edit Module Document
								</button>
							</td>
							<td id="module-'.$element['id'].'">'.($element['module_price']<>"" ? 'IDR '.number_format($element['module_price'], 0, ',', '.') : '').'</td>
							<td id="tryout-'.$element['id'].'">'.($element['tryout_price']<>"" ? 'IDR '.number_format($element['tryout_price'], 0, ',', '.') : '').'</td>
							<td>
								<button type="button" id="btn-edit-'.$element['id'].'" class="btn btn-primary btn-xs" onclick="open_edit_mode('.$element['id'].')">
									<i class="fa fa-edit"></i> Edit
								</button>
								<button type="button" id="btn-save-'.$element['id'].'" class="btn btn-success btn-xs" onclick="save('.$element['id'].')" style="display:none">
									<i class="fa fa-edit"></i> Save
								</button>
							</td>
							<td>
								<button type="button" id="btn-cancel-'.$element['id'].'" class="btn btn-warning btn-xs" onclick="cancel('.$element['id'].')" style="display:none">
									<i class="fa fa-edit"></i> Cancel
								</button>
							</td>
						</tr>';
				echo $tr;
				$depth_up = $depth + 1;
	            $children = build_tree_data($elements, $element['id'], $title, $depth_up);
	            // if ($children) {
	            //     $element['children'] = $children;
	            // }
	            // $branch[] = $element;
	        }
	    }

	    // return $branch;
	}

	function build_tree_dropdown(array $elements, $parentId = 0, $title=null, $depth=0) {
	    foreach ($elements as $element) {
	        if ($element['parent_id'] == $parentId) {
	        	// give dash & space
	        	$dash = '';
	        	for($i=0; $i<$depth;$i++)
	        		$dash .= '- - ';
	        	$tr = '<option value="'.$element['id'].'">'.$dash.$element['category'].'</option>';
				echo $tr;
				$depth_up = $depth + 1;
	            $children = build_tree_dropdown($elements, $element['id'], $title, $depth_up);
	        }
	    }
	}
 ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Setup Module &amp; Try-Out
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Course</a></li>
			<li class="active">Set Modul &amp; Try-Out</li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php $this->load->view('admin/message_after_transaction');?>
			<!-- Modal -->
			<div class="modal fade" id="modal-modul-document" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<form role="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>course/update_module_document">
							<input type="hidden" name="id" id="id-doc-edit" />
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Add/Edit Module Document</h4>
							</div>
							<div class="modal-body">
								<div class="box-body">
									<p>Allowed file types: *.doc, *.docx, *.xls, *.xlsx, *.pdf, *.zip</p>
									<div class="form-group">
										<!-- <label for="input-name">Category</label> -->
										<input type="file" name="module-file" required>
									</div>
								</div><!-- /.box-body -->
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save Changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Modal -->
			<div class="col-md-12">
      		<!-- for input filter -->
          <div class="box box-danger">
            <div class="box-header with-border">
        	    <h3 class="box-title">Filter by Program</h3>
            </div>
            <form id="search_form">
            <div class="box-body">
            	<div class="row">
								<div class="col-md-4">
									<div class="form-group">
                    <label>Select a Program</label>
                    <select id="filter-program" class="form-control">
                    	<option value="">--Please Select--</option>
                    	<?php foreach($programs->result() as $prog) {?>
                    	<option value="<?php echo $prog->id?>"><?php echo $prog->category ?></option>
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
									<th>Category</th>
									<th>Scale</th>
									<th>Module Document</th>
									<th>Module Price</th>
									<th>TryOut Price</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php // if($category<>false)
									// build_tree_data($category->result_array(), 0, $title);
								?>
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
            url: '<?php echo base_url('course/update_module_tryout/')?>/'+id,
            type: 'POST',
            data: formData,
            async: false,
            dataType: "json",
            enctype: 'multipart/form-data',
            // cache: false,
            // contentType: false,
            // processData: false,
            success: function (data) {
            	$('#module-'+id).empty();
				$('#module-'+id).append('IDR '+currency_separator(data.module_price, '.'));

				$('#tryout-'+id).empty();
				$('#tryout-'+id).append('IDR '+currency_separator(data.tryout_price, '.'));

				$('#btn-edit-'+id).toggle();
				$('#btn-save-'+id).toggle();
				$('#btn-cancel-'+id).toggle();
            },
            error: function(){
                alert("Error in ajax form submission");
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

	function open_modal_module_cover(id){
		$('#id-edit').val(id);
				
		$('#modal-modul-cover').modal('show');
	}

	function open_modal_module_doc(id){
		$('#id-doc-edit').val(id);
				
		$('#modal-modul-document').modal('show');
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
      url: "<?php echo base_url('course/get_module_tryout_by_program')?>",
      // async: false,
      data: 'prog_id='+$("#filter-program").val(),
      dataType: "json",
      success: function(data) {
        for(var i=0; i<data.length; i++){
          oTable.fnAddData([
            '<form id="form-' + data[i].id + '"><input type="hidden" id="tmp-module-' + data[i].id + '" value="'+data[i].module_price+'"><input type="hidden" id="tmp-tryout-' + data[i].id + '" value="'+data[i].tryout_price+'"><input type="hidden" id="tmp-file-' + data[i].id + '" value="'+data[i].file_name+'"></form>'
            + data[i].category,
            data[i].world_scale,
            '<div id="file-'+data[i].id+'">'+
            ((data[i].module_file_id=="" || data[i].module_file_id=="0") ? '' : '<a href="<?php echo base_url();?>course/download_doc/' + data[i].module_file_id + '"><i class="fa fa-download"></i> Download</a><br>' ) +
						'<button type="button" class="btn btn-info btn-xs" onclick="open_modal_module_doc(' + data[i].id + ')" style="margin-top: 5px;"><i class="fa fa-edit"></i> Add / Edit Module Document</button></div>',
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
