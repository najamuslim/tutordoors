<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Online Courses
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Online Course Products</a></li>
            <li><a href="#">Setup Online Course</a></li>
            <li class="active">View All </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="boxku">
        <div class="row">
            <?php $this->load->view('admin/message_after_transaction'); ?>
            <!-- Modal -->
            <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form role="form" id="form" method="post" action="<?php echo base_url(); ?>online_course/update_online_course">
                            <input type="hidden" name="id" id="id-edit" />
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Edit Course</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box-body">
                                    
                                    <div class="form-group">
                                        <label for="input-name">Online Course ID</label>
                                        <input type="text" class="form-control input-sm" style="text-transform: uppercase;" id="course-code-edit" name="course-code" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="input-name">Name</label>
                                        <input type="text" class="form-control input-sm" id="course-name-edit" name="course-name" placeholder="" onkeyup="set_url_on_edit(this.value);" required >
                                    </div>
                                    <div class="form-group">
                                        <label for="input-name">Description</label>
                                        <!--<input type="text" class="form-control input-sm" id="course-description-edit" name="course-description" placeholder="" >-->
                                        <textarea rows="4"  class="form-control input-sm" id="course-description-edit" name="course-description" placeholder=""></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="input-name">Program</label>
                                        <select class="form-control" id="sel-program-edit" name="program" required>
                                            <?php if ($programs <> false) foreach ($programs->result() as $prog) { ?>
                                                    <option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="input-name">Category</label>
                                        <select class="form-control" id="sel-category-edit" name="category" required>
                                            <?php if ($category <> false) foreach ($category->result() as $cat) { ?>
                                                    <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="input-name">Topic</label>
                                        <input type="text" class="form-control input-sm" id="topic-edit" name="topic" placeholder=""  >
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input-name">Slug</label> *good keywords
                                        <input type="text" class="form-control input-sm" id="slug-edit" name="slug" placeholder="" readonly >
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-module" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Set Module</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="box box-info " >
                                    <div class="box-header" >
                                        <h4>Module contents</h4>
                                        <div class="box-tools pull-right">
                                            <!-- Collapse Button -->
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                              <i class="fa fa-minus"></i>
                                            </button>
                                          </div>
                                    </div>
                                    <div class="box-body">
                                        <table id="content-table" class="table ">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Description</th>  
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>                        
                                <div class="box box-primary collapsed-box " style='background: #eeeeff;' >
                                    <div class="box-header" >
                                        <h4>Add New Module</h4>
                                        <div class="box-tools pull-right">
                                            <!-- Collapse Button -->
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                              <i class="fa fa-plus"></i>
                                            </button>
                                          </div>
                                    </div>
                                    <div class="box-body">
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="save-content" type="button" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- modal set content -->
            <div class="modal fade" id="modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Set Content</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="box box-info " >
                                    <div class="box-header" >
                                        <h4>Course contents</h4>
                                        <div class="box-tools pull-right">
                                            <!-- Collapse Button -->
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                              <i class="fa fa-minus"></i>
                                            </button>
                                          </div>
                                    </div>
                                    <div class="box-body">
                                        <table id="content-table" class="table ">
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
                                <div class="box box-primary collapsed-box " style='background: #eeeeff;' >
                                    <div class="box-header" >
                                        <h4>Insert content to Course</h4>
                                        <div class="box-tools pull-right">
                                            <!-- Collapse Button -->
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                              <i class="fa fa-plus"></i>
                                            </button>
                                          </div>
                                    </div>
                                    <div class="box-body">
                                        <table id="video-table" class="table table-bordered table-striped">
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
                            <button id="save-content" type="button" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal set price -->
            <div class="modal fade" id="modal-price" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Set Price</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box-body">
                                <input type="hidden" name="id" id="id-price" />
                                <div class="form-group">
                                        <label for="input-name">Online Course Price</label>
                                        
                                        <input type="number" class="form-control input-sm" style="text-transform: uppercase;" id="online-course-price" name="course-price" placeholder="" >

                                </div>
                                    
                                    
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <!--<button id="save-price" type="submit" class="btn btn-primary">Save Changes</button>-->
                            </div>
                        
                    </div>
                </div>
            </div>
            
            <!-- /Modal -->
            <!-- for input filter -->
            <div class="col-md-12">      		
                <div class="box box-danger">
                    <form id="search_form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="input-name">Choose a Program</label>
                                        <select class="form-control" id="sel-program">
                                            <option value=""></option>
                                            <?php if ($programs <> false)
                                                foreach ($programs->result() as $prog) {
                                                    ?>
                                                    <option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header">
                                            <!-- <a href="<?php echo base_url('course/export/program') ?>" class="btn btn-primary"><i class="fa fa-download"></i> Download</a> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="default-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Course ID</th>
                                    <th>Course Name</th>
                                    <th>Course Description</th>
                                    <th>Slug</th>
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
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add Course</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form role="form" id="form" method="post" action="<?php echo base_url(); ?>online_course/insert_online_course">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="input-name">Course ID</label>
                                <input type="text" class="form-control input-sm" style="text-transform: uppercase;" id="id" name="course-code" placeholder="" >
                            </div>
                            <div class="form-group">
                                <label for="input-name">Course Name</label>
                                <input type="text" class="form-control input-sm" id="name" name="course-name" placeholder="" onkeyup="set_url(this.value);" required >
                            </div>
                            <div class="form-group">
                                <label for="input-name">Course Description</label>
                                <textarea  class="form-control input-sm" id="description" name="course-description" placeholder="" ></textarea>
                            </div>
                         
                            <!-- course benefit -->
                            <!-- course video -->
                            <!-- course article -->

                            <div class="form-group">
                                <label for="input-name">Program</label>
                                <select class="form-control" name="program" required>
                                    <?php if ($programs <> false) foreach ($programs->result() as $prog) { ?>
                                            <option value="<?php echo $prog->program_id ?>"><?php echo $prog->program_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="input-name">Category</label>
                                <select class="form-control" id="sel-category-edit" name="category" required>
                                    <?php if ($category <> false) foreach ($category->result() as $cat) { ?>
                                            <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                        <label for="input-name">Topic</label>
                                        <input type="text" class="form-control input-sm" id="topic-edit" name="topic" placeholder=""  >
                                    </div>

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
        </div>
    </section>

</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer'); ?>
<script>
    $( document ).ready(function() {
        get_online_course();
    });

    function set_url(title) {
        var in_lower = title.toLowerCase();
        $('#slug').val(in_lower.replace(/[^a-zA-Z0-9]/g, '-'));
    }

    function set_url_on_edit(title) {
        var in_lower = title.toLowerCase();
        $('#slug-edit').val(in_lower.replace(/[^a-zA-Z0-9]/g, '-'));
    }

    function modal_edit_set(id) {
        $('#loading-edit').toggle();
        $.ajax({
            type: "POST",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_course_by_id/' + id,
            dataType: "json",
            success: function (data) {
                $('#id-edit').val(id);
                $('#course-code-edit').val(data.course_code);
                $('#course-name-edit').val(data.course_name);
                $('#course-description-edit').val(data.description);
                $('#slug-edit').val(data.slug);
                $('#sel-program-edit').val(data.program_id);

                $('#modal-edit').modal('show');
            }
        });
        $('#loading-edit').toggle();
    }

    function modal_content_set(id) {
        
        get_video(id);
        get_oc_content(id);
        $('#modal-content').modal('show');
        $('#save-content').unbind().click(function() {
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
        });
    }
    
    function modal_module_set(id) {
        
        //get_video(id);
        //get_oc_content(id);
        $('#modal-module').modal('show');
    }
    
    function save_content(product_id,checked_contents) {
        
        $.ajax({
            type: "POST",
            async: false,
            url: '<?php echo base_url(); ?>online_course/save_oc_content',
            dataType: "json",
            data: {
                product_id : product_id,
                contents: checked_contents
            },
            success: function (data) {
                //alert(data);
                $('#modal-content').modal('toggle');
            },
            error: function (e) {
                alert(e.responseText);
            }
        })
        
        
    }
    
    function modal_price_set(id) { 
        get_price(id);
        $('#modal-price').modal('show');
        $('#save-price').unbind().click(function(){
            console.log("id = " +id);
            save_price(id,$('#online-course-price').val());
        }); 

    }
    
    function save_price(product_id, price) {
        $.ajax({
            type: "POST",
            async: false,
            url: '<?php echo base_url(); ?>online_course/save_oc_price',
            dataType: "json",
            data: {
                product_id : product_id,
                price: price
            },
            success: function (data) {
                $('#online-course-price').val("");
                $('#modal-price').modal('toggle');
                //alert(data);
            },
            error: function (e) {
                alert(e.responseText);
            }
        }) 
    }
    
    $('#sel-program').on('change', function (e) {
    
        get_online_course($('#sel-program').val());
    })
    function get_online_course(prog_id) {
        $('#loading-edit').toggle();
        var oTable = $('#default-table').DataTable();
        oTable.fnClearTable();
        $.ajax({
            type: "GET",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_online_course_by_program/' + prog_id,
            dataType: "json",
            success: function (data) {
                //if (data != false) {
                for (var i = 0; i < data.length; i++) {
                    oTable.fnAddData([
                        data[i].course_code,
                        data[i].course_name, 
                        data[i].description,
                        data[i].slug,
                        '<div><button style="margin: 3px;" class="btn btn-primary btn-xs btn-block" onclick="modal_edit_set(\'' + data[i].id + '\')">\
                                                                                        <i class="fa fa-edit"></i> Edit\
                                                                                </button></div>\n\
                         <div><button style="margin: 3px;" class="btn btn-info btn-xs btn-block" onclick="modal_module_set(\'' + data[i].id + '\')">\
                                                                                        <i class="fa fa-file"></i> Set Module\
                                                                                </button></div>\n\
                         <div><button style="margin: 3px;" class="btn btn-warning btn-xs btn-block" onclick="modal_price_set(\'' + data[i].id + '\')">\
                                                                                        <i class="fa fa-money"></i> Set Price\
                                                                                </button></div>   ',
                        '<a href="<?php echo base_url() ?>online_course/delete_course?id=' + data[i].id + '" onclick="return confirm(\'Do you want to delete ' + data[i].course_name + ' ?\')" >\
                                                                                        <button class="btn btn-danger btn-xs">\
                                                                                                <i class="fa fa-trash-o"></i> Delete\
                                                                                        </button>\
                                                                                </a>'
                    ]);
                }
                //}
                $('#loading-edit').toggle();

            },
            error: function (e) {
                $('#loading-edit').toggle();
                alert('Error processing your request: ' + e.responseText);
            }
        });
    }
    function get_video(product_id) {
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
                        '<button id="add_"'+data[i].id+' name="addvideo" onclick="add_content(' + data[i].id + ',' + product_id + ')" class="btn btn-success btn-xs btn-block" type="button"> Add</button>'
                    ]);
                }
            }
        });
        $('#loading-edit').toggle();
    }
    
    function get_oc_content(product_id) { 
        var oTable = $('#content-table').DataTable(); 
        oTable.fnClearTable();
        
        $.ajax({
            type: "GET",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_product_content_ajax/'+product_id,
            dataType: "json",
            success: function (data) {
               for (var i = 0; i < data.length; i++) {
                    oTable.fnAddData([
                        data[i].title,
                        data[i].description,
                        '<div><img id="existing-image" src="<?php echo base_url('assets/uploads/video-image/'); ?>'+ data[i].videoimage +'" style="padding-bottom: 5px; max-height: 50px;"></div>',
                        '<a href="<?php echo base_url('assets/uploads/video/'); ?>'+ data[i].filename +'">'+data[i].filename+'</a>',
                        //'<button class="btn btn-primary btn-xs" onclick=""><i class="fa fa-edit"></i>Select</button>',    
                        //'<input type="checkbox" name="videoselected[]" value="'+data[i].id+'" />',
                        '<button id="remove_"'+data[i].id+' name="removevideo" onclick="remove_content(' + data[i].id + ',' + product_id + ')" class="btn btn-danger btn-xs btn-block" type="button"> Remove</button>'
                    ]);
                }
               
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });  
    }
    
    function get_price(product_id) {
        $.ajax({
            type: "GET",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_oc_price_ajax/'+product_id,
            dataType: "json",
            success: function (data) {
                $('#online-course-price').val(data.price);
            }
        });   
    }
     
    function add_content(video_id, product_id) {
        //alert("remove "+oc_id);
        $.ajax({
            type: "POST",
            async: false,
            url: '<?php echo base_url(); ?>online_course/add_oc_content',
            dataType: "json",
            data: {
                video_id : video_id,
                product_id : product_id,
            },
            success: function (data) {
                get_oc_content(product_id);
            },
            error: function (e) {
                alert(e.responseText);
            }
        }) 
        
    } 
     
    function remove_content(oc_id, product_id) {
        //alert("remove "+oc_id);
        $.ajax({
            type: "POST",
            async: false,
            url: '<?php echo base_url(); ?>online_course/remove_oc_content',
            dataType: "json",
            data: {
                id : oc_id,
            },
            success: function (data) {
                get_oc_content(product_id);
            },
            error: function (e) {
                alert(e.responseText);
            }
        }) 
        
    }
     
</script>
</body>
</html>