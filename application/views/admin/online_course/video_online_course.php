<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Video Files
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Online Course Products</a></li>
            <li><a href="#">Course Content</a></li>
            <li class="active">Video </li>
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
                        <form role="form" id="formedit" method="post" action="<?php echo base_url(); ?>online_course/update_video" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id-edit" />
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Edit Course</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box-body">   
                                    <div class="form-group">
                                        <label for="input-name">Video Name</label>
                                        <input type="text" class="form-control input-sm" id="name-edit" name="video-name" placeholder="" onkeyup="set_url(this.value);" required >
                                    </div>
                                    <div class="form-group">
                                        <label for="input-name">Video Description</label>
                                        <textarea  class="form-control input-sm" id="description-edit" name="video-description" placeholder="" ></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input-name">Video Image</label>
                                        <div><img id="existing-image" src="" style="padding-bottom: 5px; max-width: 75px; max-height: 75px;"></div>
                                        <input type="file" id="image-edit" name="video-image-update" class="form-control input-sm" accept="image/*">
                                    </div>
                                        
                                    <div class="form-group">
                                        <label for="input-name">Video File</label>
                                        <div><a id="existing-video" href=""></a></div>
                                        <input type="file" id="video-edit" name="video-file-update" class="form-control input-sm" accept="video/*">
                                    </div>
                                    <div class="form-group">
                                        <label for="input-name">Slug</label> *good keywords
                                        <input type="text" class="form-control input-sm" id="slug-edit" name="slug" placeholder="" readonly >
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
            <!-- for input filter -->   

            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header">
                                            <!-- <a href="<?php echo base_url('course/export/program') ?>" class="btn btn-primary"><i class="fa fa-download"></i> Download</a> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="default-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>File</th>
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
                        <h3 class="box-title">Upload Video</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form role="form" id="formadd" action="<?php echo base_url('online_course/insert_video'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="box-body">
                            <div class="form-group">
                                <label for="input-name">Video Name</label>
                                <input type="text" class="form-control input-sm" id="name" name="video-name" placeholder="" onkeyup="set_url(this.value);" required >
                            </div>
                            <div class="form-group">
                                <label for="input-name">Video Description</label>
                                <textarea  class="form-control input-sm" id="description" name="video-description" placeholder="" ></textarea>
                            </div>
                         
                            <div class="form-group">
                                <label for="input-name">Video Image</label>
                                <input type="file" name="video-image" class="form-control input-sm" accept="image/*">
                            </div>
                            
                            <div class="form-group">
                                <label for="input-name">Video File</label>
                                <input type="file" name="video-file" class="form-control input-sm" accept="video/*">
                            </div>
                            <!-- course benefit -->
                            <!-- course video -->
                            <!-- course article -->

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
        get_video();
    });
    
    function set_url(title) {
        var in_lower = title.toLowerCase();
        $('#slug').val(in_lower.replace(/[^a-zA-Z0-9]/g, '-'));
    }

    function set_url_on_edit(title) {
        var in_lower = title.toLowerCase();
        $('#slug-edit').val(in_lower.replace(/[^a-zA-Z0-9]/g, '-'));
    }

    function modal_set(id) {
        $('#loading-edit').toggle();
        $.ajax({
            type: "GET",
            async: false,
            url: '<?php echo base_url(); ?>online_course/get_video_by_id_ajax/' + id,
            dataType: "json",
            success: function (data) {
                $('#id-edit').val(id);
                $('#name-edit').val(data.title);
                $('#description-edit').val(data.description);
                $("#existing-image").attr("src","<?php echo base_url(); ?>assets/uploads/video-image/"+ data.videoimage);
                $("#existing-video").attr("href","<?php echo base_url(); ?>assets/uploads/video/"+ data.filename);
                $("#existing-video").text(data.filename);
                $('#modal-edit').modal('show');
            },
                   });
        $('#loading-edit').toggle();
    }

    function get_video() {
        var oTable = $('#default-table').DataTable();
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
                        '<div><img id="existing-image" src="<?php echo base_url('assets/uploads/video-image/'); ?>'+ data[i].videoimage +'" style="padding-bottom: 5px; max-width: 75px; max-height: 75px;"></div>',
                        '<a href="<?php echo base_url('assets/uploads/video/'); ?>'+ data[i].filename +'">'+data[i].filename+'</a>',
                        '<button class="btn btn-primary btn-xs" onclick="modal_set(\'' + data[i].id + '\')">\
                                                                                        <i class="fa fa-edit"></i> Edit\
                                                                                </button>',
                        '<a href="<?php echo base_url() ?>online_course/delete_video?id=' + data[i].id + '" onclick="return confirm(\'Do you want to delete ' + data[i].title + ' ?\')" >\
                                                                                        <button class="btn btn-danger btn-xs">\
                                                                                                <i class="fa fa-trash-o"></i> Delete\
                                                                                        </button>\
                                                                                </a>'
                    ]);
                }
            }
        });
        $('#loading-edit').toggle();
    }

</script>
</body>
</html>