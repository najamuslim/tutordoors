<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Online Course Module
            <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Online Course Products</a></li>
                <li><a href="#">Setup Online Course</a></li>
                <li class="active">Course Module </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="boxku">
            <div class="row">
                <?php $this->load->view('admin/message_after_transaction'); ?>
                 <!-- Modal -->
                <div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Video Course</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="box box-info " >
                                        <div class="box-header" >
                                            <h4>Select video</h4>
                                            <div class="box-tools pull-right">
                                                <!-- Collapse Button -->
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                  <i class="fa fa-minus"></i>
                                                </button>
                                              </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="video-table" class="table ">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Image</th>
                                                        <th>File</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>                             
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                 
            <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form role="form" id="form" method="post" action="<?php echo base_url(); ?>online_course/insert_oc_module">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="input-name">Program</label>
                                <select class="form-control" id="program-id-edit" name="program-id" required>
                                    <?php if ($programs <> false) foreach ($programs->result() as $pr) { ?>
                                            <option value="<?php echo $pr->program_id ?>"  ><?php echo $pr->program_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input-name">Course</label>
                                <select class="form-control" id="online-course-id-edit" name="online-course-id" required>                                    
                                    <?php if ($online_course <> false) foreach ($online_course->result() as $course) { ?>
                                            <option value="<?php echo $course->id ?>"><?php echo $course->course_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input-name">Module Name</label>
                                <input type="text" class="form-control input-sm" id="module-name-edit" name="module-name" placeholder="" onkeyup="set_url(this.value);" required >
                            </div>
                            <div class="form-group">
                                <label for="input-name">Module Description</label>
                                <textarea  class="form-control input-sm" id="module-description-edit" name="module-description-edit" placeholder="" ></textarea>
                            </div>
                            <!--<div class="form-group">
                                <label for="input-name">Video</label>
                                <input type="hidden" id="video-id-edit" name="video-id" value="">
                                <div id="video-name"></div>
                                <button id="button-select-video" type="button" class="btn btn-xs btn-block btn-primary" onclick="modal_video_set()">Add Video</button>
                            </div>-->
                            <div class="form-group">
                                <label for="input-name">Slug</label> *good keywords
                                <input type="text" class="form-control input-sm" id="slug-edit" name="slug" placeholder="" readonly >
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
                 
                 <!-- modal end -->
                 
                 
                 
            <!-- module table -->
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header">
                                            
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="default-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Module Name</th>
                                    <th>Module Description</th>
                                    <!--<th>Video</th>-->
                                    <th>Action</th>
                                    
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
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add Module</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form role="form" id="form" method="post" action="<?php echo base_url(); ?>online_course/insert_oc_module">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="input-name">Program</label>
                                <select class="form-control" id="program-id" name="program-id" required>
                                    <?php if ($programs <> false) foreach ($programs->result() as $pr) { ?>
                                            <option value="<?php echo $pr->program_id ?>"><?php echo $pr->program_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input-name">Course</label>
                                <select class="form-control" id="online-course-id" name="online-course-id" required>
                                    <option disabled selected value>select program first</option>
                                    <!--<?php if ($online_course <> false) foreach ($online_course->result() as $course) { ?>
                                            <option value="<?php echo $course->id ?>"><?php echo $course->course_name ?></option>
                                    <?php } ?>-->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input-name">Module Name</label>
                                <input type="text" class="form-control input-sm" id="module-name" name="module-name" placeholder="" onkeyup="set_url(this.value);" required >
                            </div>
                            <div class="form-group">
                                <label for="input-name">Module Description</label>
                                <textarea  class="form-control input-sm" id="module-description" name="module-description" placeholder="" ></textarea>
                            </div>
                            <!--<div class="form-group">
                                <label for="input-name">Video</label>
                                <input type="hidden" id="video-id" name="video-id" value="">
                                <div id="video-name"></div>
                                <button id="button-select-video" type="button" class="btn btn-xs btn-block btn-primary" onclick="modal_video_set()">Add Video</button>
                            </div>-->
                            <div class="form-group">
                                <label for="input-name">Slug</label> *good keywords
                                <input type="text" class="form-control input-sm" id="slug" name="slug" placeholder="" readonly >
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
                 <!-- module table end -->
            </div>
        </section>

</div>
<?php $this->load->view('admin/footer'); ?>
<script>
    $( document ).ready(function() {
        get_modules();
        $('#program-id').on('change', function() {
            get_course_dropdown_by_program($('#online-course-id'), this.value);
        });
        
        $('#program-id-edit').on('change', function() {
            get_course_dropdown_by_program($('#online-course-id-edit'), this.value);
        });
        
        get_course_dropdown_by_program($('#online-course-id'), $('#program-id').value);
        get_course_dropdown_by_program($('#online-course-id-edit'), $('#program-id-edit').value);
    });
    
    function set_url(title) {
        var in_lower = title.toLowerCase();
        $('#slug').val(in_lower.replace(/[^a-zA-Z0-9]/g, '-'));
    }
    
    function set_url_on_edit(title) {
        var in_lower = title.toLowerCase();
        $('#slug-edit').val(in_lower.replace(/[^a-zA-Z0-9]/g, '-'));
    }
    
    function modal_video_set() {
        
        get_videos();
        
        $('#modal-video').modal('show');
        /*$('#save-video').unbind().click(function() {
            var checked = [];
            $("input[name='videoselected[]']:checked").each(function ()
            {
                checked.push(parseInt($(this).val()));
            });
            
            if (checked.length>0) {           
                save_content(id,checked);
            } else {
                alert("you did not select any content!");
            }
        });*/
    }
    
    function modal_edit_set(id) {
        $('#loading-edit').toggle();
        $.ajax({
            type: "POST",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_oc_module_by_id/' + id,
            dataType: "json",
            success: function (data) {
                $('#module-name-edit').val(id);
                $('#module-description-edit').val(data.course_code);
                $('#program-id-edit').removeAttr('selected').filter('[value='+data.program_id+']').attr('selected', true);
                get_module_dropdown_by_program($('#online-course-id-edit'), data.program_id);
                $('#program-id-edit').removeAttr('selected').filter('[value='+data.id+']').attr('selected', true);
                $('#video-id-edit').val(data.course_name);
                $('#slug-edit').val(data.slug);
                $('#modal-edit').modal('show');
            }
        });
        $('#loading-edit').toggle();
    }
    
    function get_videos() {
        var oTable = $('#video-table').DataTable();
        oTable.fnClearTable();
        
        $('#loading-edit').toggle();
        $.ajax({
            type: "GET",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_videos/',
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    oTable.fnAddData([
                        data[i].title,
                        data[i].description,
                        '<div><img id="existing-image" src="<?php echo base_url('assets/uploads/video-image/'); ?>'+ data[i].videoimage +'" style="padding-bottom: 5px; max-width: 50px; max-height: 50px;"></div>',
                        '<a href="<?php echo base_url('assets/uploads/video/'); ?>'+ data[i].filename +'">'+data[i].filename+'</a>',
                        //'<button class="btn btn-primary btn-xs" onclick=""><i class="fa fa-edit"></i>Select</button>',    
                        //'<input type="checkbox" name="videoselected[]" value="'+data[i].id+'" />',
                        '<button id="add_"'+data[i].id+' name="addvideo" onclick="add_video(' + data[i].id + ',\''+data[i].title+'\')" class="btn btn-success btn-xs btn-block" type="button"> Add</button>'
                    ]);
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
        $('#loading-edit').toggle();
    }
    
    //menambahkan id video ke form create module
    function add_video(id, title) {
        $('#video-name').html(title);
        $('#video-id').val(id);
        $('#modal-video').modal('toggle');
    }
    
    function get_modules() {
        var oTable = $('#default-table').DataTable();
        oTable.fnClearTable();
        
        $('#loading-edit').toggle();
        $.ajax({
            type: "GET",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_oc_module_ajax/',
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    oTable.fnAddData([
                        data[i].course,
                        data[i].name,
                        data[i].description,                 
                        //'<a href="<?php //echo base_url('assets/uploads/video/'); ?>'+ data[i].filename +'">'+data[i].filename+'</a>',
                        '<button id="add_"'+data[i].id+' name="deletemodule" onclick="delete_oc_module(' + data[i].id + ')" class="btn btn-danger btn-xs btn-block" type="button"><i class="fa fa-trash-o"></i> Delete</button>'
                    ]);
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
        $('#loading-edit').toggle();
    }
    
    function delete_oc_module(id) {
        //alert("remove "+oc_id);
        $.ajax({
            type: "POST",
            async: false,
            url: '<?php echo base_url(); ?>online_course/delete_oc_module',
            dataType: "json",
            data: {
                id : id,
            },
            success: function (data) {
                get_modules();
            },
            error: function (e) {
                alert(e.responseText);
            }
        }) 
        
    }
    
    function get_course_dropdown_by_program(dropdown, program_id) {

        $('#loading-edit').toggle();
        $.ajax({
            type: "GET",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_online_course_by_program/'+program_id,
            dataType: "json",
            success: function (data) {
                console.log(data);
                dropdown.empty();
                if (data.length>0) {
                    for (var i = 0; i < data.length; i++) {
                        dropdown.append('<option value="'+ data[i].id+'">'+data[i].course_name+'</option>');
                    }
                } else {
                    dropdown.append('<option disabled selected value>No data</option>');
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
        $('#loading-edit').toggle();
    }
    
</script>