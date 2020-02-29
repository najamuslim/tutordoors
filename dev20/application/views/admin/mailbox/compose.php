      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <!-- <h1>
            Mailbox
          </h1> -->
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Mailbox</li>
            <li class="active">Compose</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <?php $this->load->view('admin/message_after_transaction');?>
            <div class="col-md-9">
              <?php 
              $send_link = base_url('mailbox/send');
              if($mode=="edit")
                $send_link = base_url('mailbox/send/'.$mail_info->id);
               ?>
              <form action="<?php echo $send_link; ?>" method="post">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Compose New Message</h3>
                  </div><!-- /.box-header -->
                  <div class="box-body">
                    <div class="form-group">
                      <?php 
                      $recipient_id = '';
                      if($mode=="edit"){
                        $recipient_id = $recipient->user_id; 
                      }
                      else if($mode=="reply"){
                        $recipient_id = $mail_info->sender;
                      }
                      ?>
                      <input type="hidden" name="box" value="<?php echo $box ?>" required>
                      <input type="hidden" id="destination_id" name="destination_id" value="<?php echo $recipient_id ?>" required>
                      <input type="text" class="form-control" name="destination" id="destination" placeholder="To:" value="<?php if($mode=="edit" or $mode=="reply") echo $recipient->user_id.' | '.$recipient->first_name.' '.$recipient->last_name.' | '.ucwords($recipient->user_level) ?>"  required>
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="subject" placeholder="Subject:" value="<?php if($mode=="edit") echo $mail_info->subject; else if($mode=="reply") echo 'RE: '.$mail_info->subject; else if($mode=="forward") echo 'FW: '.$mail_info->subject;?>" />
                    </div>
                    <div class="form-group">
                      <textarea id="compose-mailbox" class="form-control" name="content" style="height: 300px">
                      <?php 
                      if($mode=="edit" or $mode=="forward") 
                        echo base64_decode($mail_info->content);
                      else if($mode=="reply"){
                        echo "<br><br><br>-----------------------------------------------------------------------------<br>Replied Message<br>-----------------------------------------------------------------------------<br>";
                        echo base64_decode($mail_info->content);
                      }
                        ?>
                      </textarea>
                    </div>
                    <!-- <div class="form-group">
                      <div class="btn btn-default btn-file">
                        <i class="fa fa-paperclip"></i> Attachment
                        <input type="file" name="attachment"/>
                      </div>
                      <p class="help-block">Max. 32MB</p>
                    </div> -->
                    <div class="form-group">
                      <input type="hidden" name="file-id" id="file-id" value="<?php if($mode=="edit" or $mode=="forward") echo $mail_info->media_id ?>">
                      <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Add Attachments...</span>
                        <!-- The file input field used as target for the file upload widget -->
                        <input id="fileupload" type="file" name="userfile" multiple>
                      </span>
                      <br>
                      <span>Allowed types: .jpg, .png, .gif, .jpeg, .zip</span>
                      <br>
                      <span>Max size: 1 MB</span>
                      <br>
                      <br>
                      <!-- The global progress bar -->
                      <div id="progress" class="progress">
                          <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <!-- The container for the uploaded files -->
                      <div id="files" class="files">
                        <?php 
                        if($mode=="edit" or $mode=="forward") {
                          if($mail_info->media_id<>""){
                            $media_array = explode(',', $mail_info->media_id);
                            foreach($media_array as $media_id){
                              $media_full_name = $this->media_m->get_file_name($media_id);
                          ?>
                        <p><?php echo $media_full_name ?> 
                          <button type="button" class="btn btn-danger delete" data-delete-url="<?php echo base_url('mailbox/delete_attachment?fn='.$media_full_name.'&id='.$media_id.'&mailid='.$mail_info->id) ?>" data-file-id="<?php echo $media_id ?>">
                              <i class="fa fa-trash-o"></i>
                              <span>Delete</span>
                          </button>
                        </p>
                        <?php }}} ?>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <div class="pull-right">
                      <button type="submit" class="btn btn-default" name="action" value="draft"><i class="fa fa-pencil"></i> Draft</button>
                      <button type="submit" class="btn btn-primary" name="action" value="send"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                    <button type="button" id="discard-message" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                  </div><!-- /.box-footer -->
                </div><!-- /. box -->
              </form>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<script>
  //auto complete on teacher's field
  $('#destination').autocomplete({
    source: "<?php echo site_url('users/search_user_autocomplete');?>", // path to the lookup method
    focus : function(){ return false; },
    select: function(event, ui){
      $('#destination').val(ui.item.value);
      $('#destination_id').val(ui.item.id);
    }
  });

  $('#discard-message').on('click', function(){
    window.history.back();
  });
</script>
<script>
var uploaded_file_id = [<?php if($mode=="edit" or $mode=="forward") echo $mail_info->media_id ?>];
/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?php echo base_url('mailbox/upload_files') ?>';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html(file.name+' <button class="btn btn-danger delete" data-delete-url="'+file.deleteUrl+'" data-file-id="'+file.file_id+'">\
                    <i class="fa fa-trash-o"></i>\
                    <span>Delete</span>\
                </button>').appendTo('#files');
                uploaded_file_id.push(file.file_id);
                $('#file-id').val(uploaded_file_id.toString());
            });
            $(".delete").eq(-1).on("click",function(e){
              e.preventDefault();
              var file_id = $(this).data('file-id');
              $.ajax({
                type : "POST",
                url: $(this).data('delete-url'),
                dataType: "json",
                success: function(data) {
                  uploaded_file_id = jQuery.grep(uploaded_file_id, function(value) {
                    return value != file_id;
                  });
                  $('#file-id').val(uploaded_file_id.toString());
                },
                error: function(e) {
                // Schedule the next request when the current one's complete,, in miliseconds
                  alert('Error processing your request: '+e.responseText);
                }
              });
               $(this).parent().remove();
             })
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>

<script>
  $(document).on('ready', function(){
    $(".delete").on("click",function(e){
      e.preventDefault();
      var file_id = $(this).data('file-id');
      $.ajax({
        type : "POST",
        url: $(this).data('delete-url'),
        dataType: "json",
        success: function(data) {
          uploaded_file_id = jQuery.grep(uploaded_file_id, function(value) {
            return value != file_id;
          });
          $('#file-id').val(uploaded_file_id.toString());
        },
        error: function(e) {
        // Schedule the next request when the current one's complete,, in miliseconds
          alert('Error processing your request: '+e.responseText);
        }
      });
       $(this).parent().remove();
     });
  });
</script>
</body>
</html>
