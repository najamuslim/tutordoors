<?php 
  function build_tree_data(array $elements, $parentId = 0, $depth=0) {
    $ci =& get_instance();
    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
          // give dash & space
          $dash = '';
          for($i=0; $i<$depth;$i++)
            $dash .= '- - ';
          // check if parent has child
          $check_child = $ci->Content_m->check_menu_has_child($element['id']);
          $delete_button = '';
          if($check_child == 0)
            $delete_button = '<a href="'.base_url('content/delete_second_top/'.$element['id']).'" onclick=\'return confirm("Do you want to delete '.$element['menu_label'].'");\'>
                <button class="btn btn-danger btn-xs">
                  <i class="fa fa-trash-o"></i> Delete
                </button>
              </a>';
          $tr = '<tr>
            <td>'.$dash.$element['menu_label'].'</td>
            <td>'.$element['link_address'].'</td>
            <td>'.$element['ordinal'].'</td>
            <td>
              <button class="btn btn-primary btn-xs" onclick="modal_edit_mode('.$element['id'].')">
                <i class="fa fa-edit"></i> Edit
              </button>
              '.$delete_button.'
            </td>
          </tr>';
      echo $tr;
      $depth_up = $depth + 1;
            $children = build_tree_data($elements, $element['id'], $depth_up);
        }
    }
  }

  function build_tree_dropdown_menu(array $elements, $parentId = 0, $depth=0) {
      foreach ($elements as $element) {
          if ($element['parent_id'] == $parentId) {
            // give dash & space
            $dash = '';
            for($i=0; $i<$depth;$i++)
              $dash .= '- - ';
            $tr = '<option value="'.$element['id'].'">'.$dash.$element['menu_label'].'</option>';
        echo $tr;
        $depth_up = $depth + 1;
              $children = build_tree_dropdown_menu($elements, $element['id'], $depth_up);
          }
      }
  }

  function build_tree_dropdown_program(array $elements, $parentId = 0, $depth=0) {
      foreach ($elements as $element) {
          if ($element['parent_id'] == $parentId) {
            // give dash & space
            $dash = '';
            for($i=0; $i<$depth;$i++)
              $dash .= '- - ';
            $tr = '<option value="'.$element['id'].'">'.$dash.$element['category'].'</option>';
        echo $tr;
        $depth_up = $depth + 1;
              $children = build_tree_dropdown_program($elements, $element['id'], $depth_up);
          }
      }
  }
 ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			<?php echo $title_page; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Appearance</a></li>
			<li><a href="#">Menu</a></li>
			<li class="active"><a href="#">Second Top</a></li>
		</ol>
  </section>
	<!-- Modal -->
  <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" id="form" method="post" action="<?php echo base_url('content/add_second_top');?>">
          <input type="hidden" name="part" value="second_top" />
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Adding Second Top Menu</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="input-name">Menu Label</label>
                <input type="text" class="form-control input-sm" name="label" placeholder="" required>
              </div>
              <div class="form-group">
                <label for="input-name">Ordinal (Urutan)</label>
                <input type="number" min="1" max="20" class="form-control input-sm" name="ordinal" value="1" required>
              </div>
              <div class="form-group">
                <label for="input-name">Menu Level</label>
                <select class="form-control" name="level" id="level-sel-add" required>
                  <option value="0" selected>Level 0</option>
                  <option value="1">Level 1</option>
                  <option value="2">Level 2</option>
                </select>
              </div>
              <div class="form-group">
                <label for="input-name">Parent Menu</label>
                <select name="parent" id="parent-sel-add" class="form-control input-sm" disabled>
                  <?php 
                  if($menus <> false) 
                    build_tree_dropdown_menu($menus->result_array());  
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="input-name">Link Method</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="link-method" id="link-method-empty" value="empty">
                    Not linking to any course
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="link-method" id="link-method-all" value="all">
                    Linking to all courses
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="link-method" id="link-method-program" value="program">
                    Linking to spesific course
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="input-name">Spesific Course</label>
                <select class="form-control" id="program-sel-add" disabled>
                  <option value="">--Select Program--</option>
                  <?php if($programs<>false) 
                    foreach($programs->result() as $prog) {
                  ?>
                  <option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
                  <?php } ?>
                </select>
                <select class="form-control" id="sel-course-add" name="program" disabled>
                  <option value="">--Select Course--</option>
                </select>
              </div>
              <div class="form-group">
                <label for="input-name">Generated Link</label>
                <input type="text" class="form-control" id="gen-link-add" name="gen-link" readonly>
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /Modal -->
  <!-- Modal -->
  <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" id="form" method="post" action="<?php echo base_url('content/update_second_top');?>">
          <input type="hidden" name="part" value="second_top" />
          <input type="hidden" name="id" id="menu-id" value="" />
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editing Second Top Menu</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="input-name">Menu Label</label>
                <input type="text" class="form-control input-sm" id="label-edit" name="label" placeholder="" required>
              </div>
              <div class="form-group">
                <label for="input-name">Ordinal (Urutan)</label>
                <input type="number" min="1" max="20" class="form-control input-sm" id="ordinal-edit" name="ordinal" value="1" required>
              </div>
              <div class="form-group">
                <label for="input-name">Menu Level</label>
                <select class="form-control" name="level" id="level-sel-edit" required>
                  <option value="0" selected>Level 0</option>
                  <option value="1">Level 1</option>
                  <option value="2">Level 2</option>
                </select>
              </div>
              <div class="form-group">
                <label for="input-name">Parent Menu</label>
                <select name="parent" id="parent-sel-edit" class="form-control input-sm" disabled>
                  <?php 
                  if($menus <> false) 
                    build_tree_dropdown_menu($menus->result_array());  
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="input-name">Link Method</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="link-method" id="link-method-empty-edit" value="empty">
                    Not linking to any program
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="link-method" id="link-method-all-edit" value="all">
                    Linking to all programs
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="link-method" id="link-method-program-edit" value="program">
                    Linking to spesific program
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="input-name">Spesific Program</label>
                <select class="form-control" id="program-sel-edit" disabled>
                  <option value="">--Select Program--</option>
                  <?php if($programs<>false) 
                    foreach($programs->result() as $prog) {
                  ?>
                  <option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
                  <?php } ?>
                </select>
                <select class="form-control" id="sel-course-edit" name="program" disabled>
                  <option value="">--Select Course--</option>
                </select>
              </div>
              <div class="form-group">
                <label for="input-name">Generated Link</label>
                <input type="text" class="form-control" id="gen-link-edit" name="gen-link" readonly>
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
	<!-- Main content -->
  <section class="boxku">
    <div class="row">
      <?php $this->load->view('admin/message_after_transaction');?>
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            <button class="btn btn-primary" id="btn-add"><i class="fa fa-plus-circle"></i> Add new menu</button>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="default-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Label</th>
                  <th>Link Address</th>
                  <th>Ordinal</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($menus<>false)
                  build_tree_data($menus->result_array(), 0);
                ?>
              </tbody>
            </table>
          </div><!-- /.box-body -->
          <div class="overlay" style="display:none" id="loading-edit">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div><!-- /.box -->
      </div>
    </div>
  </section>
      
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<script>
  var base_url = "<?php echo base_url('teacher/program?prog=')?>";
  $(document).ready(function() {
    $("#btn-add").on('click', function () {
      $('#modal-add').modal('show');
    });

    $("#btn-reject").on('click', function () {
        $('#modal-edit').modal('show');
    });

    $("#level-sel-add").on('change', function () {
        if($('#level-sel-add').val()=="0")
          $('#parent-sel-add').prop("disabled", true);
        else
          $('#parent-sel-add').prop("disabled", false);
    });

    $("#level-sel-edit").on('change', function () {
        if($('#level-sel-edit').val()=="0")
          $('#parent-sel-edit').prop("disabled", true);
        else
          $('#parent-sel-edit').prop("disabled", false);
    });

    $("#program-sel-add").on('change', function (e) {    
        $.ajax({
          type : "GET",
          async: false,
          url: '<?php echo base_url();?>course/get_course_by_program/'+$(this).val(),
          dataType: "json",
          success:function(data){
            $("#sel-course-add").find('option').remove().end();
            $("#sel-course-add").append($("<option></option>").val("").html("--Select Course--"));
            for(var i=0; i<data.length;i++)
              $("#sel-course-add").append($("<option></option>").val(data[i].id).html(data[i].course_name));
          },
              error: function(e){
                alert('Error processing your request: '+e.responseText);
              }
        });
    });

    $("#program-sel-edit").on('change', function () {
        $.ajax({
          type : "GET",
          async: false,
          url: '<?php echo base_url();?>course/get_course_by_program/'+$(this).val(),
          dataType: "json",
          success:function(data){
            $("#sel-course-edit").find('option').remove().end();
            $("#sel-course-edit").append($("<option></option>").val("").html("--Select Course--"));
            for(var i=0; i<data.length;i++)
              $("#sel-course-edit").append($("<option></option>").val(data[i].id).html(data[i].course_name));
          },
              error: function(e){
                alert('Error processing your request: '+e.responseText);
              }
        });
    });

    $("#program-sel-add").on('change', function(e){
      $('#gen-link-add').val(base_url+$(this).val());
    });

    $("#program-sel-edit").on('change', function(e){
      $('#gen-link-edit').val(base_url+$(this).val());
    });

    $("#sel-course-add").on('change', function(e){
      if($(this).val() == "")
        $('#gen-link-add').val('<?php echo base_url('teacher/program?prog=')?>'+$("#program-sel-add").val());

      else
        $('#gen-link-add').val('<?php echo base_url('teacher/program?prog=')?>'+$(this).val());
    });

    $("#sel-course-edit").on('change', function(e){
      if($(this).val() == "")
        $('#gen-link-edit').val('<?php echo base_url('teacher/program?prog=')?>'+$("#program-sel-edit").val());

      else
        $('#gen-link-edit').val('<?php echo base_url('teacher/program?prog=')?>'+$(this).val());
    });

    $('input[type=radio][name=link-method]').change(function() {
        if (this.value == 'empty') {
            $('#gen-link-add, #gen-link-edit').val("#");
            $("#program-sel-add, #program-sel-edit, #sel-course-add").prop("disabled", true);
        }
        else if (this.value == 'all') {
            $('#gen-link-add, #gen-link-edit').val('<?php echo base_url('teacher/program?prog=all')?>');
            $("#program-sel-add, #program-sel-edit, #sel-course-add").prop("disabled", true);
        }
        else if (this.value == 'program') {
            $("#program-sel-add, #program-sel-edit, #sel-course-add").prop("disabled", false);
        }
    });
});

  function modal_edit_mode(id){
    $('#loading-edit').toggle();
    $.ajax({
      type : "POST",
      async: false,
      url: '<?php echo base_url();?>content/get_menu_by_id/'+id,
      dataType: "json",
      success:function(data){
        $('#menu-id').val(id);
        $('#label-edit').val(data.label);
        $('#ordinal-edit').val(data.ordinal);
        
        $('#level-sel-edit').val(data.level);
        $('#gen-link-edit').val(data.link);
        if(data.link=="#"){
          $('#link-method-empty-edit').prop('checked', true);
          $('#program-sel-edit').prop('disabled', true);
        }
        else{
          var link = data.link;
          if(link.substr(link.length-3)=="all")
          {
            $('#link-method-all-edit').prop('checked', true);
            $('#program-sel-edit').prop('disabled', true);
          }
          else
          {
            $('#link-method-program-edit').prop('checked', true);
            // var index_equal = link.indexOf("=");
            // var selected_program = link.substr(index_equal+1);
            // console.log(selected_program);
            $('#program-sel-edit').prop('disabled', false);
            $('#sel-course-edit').prop('disabled', false);
            $('#program-sel-edit').val(data.program);
            $('#program-sel-edit').trigger('change');
            $("#sel-course-edit").val(data.course);
          }
        }
        if(data.level!="0")
        {
          $('#parent-sel-edit').prop('disabled', false);
          $('#parent-sel-edit').val(data.parent);
        }
        
        $('#modal-edit').modal('show');
      }
    });
    $('#loading-edit').toggle();
  }
</script>
</body>
</html>
