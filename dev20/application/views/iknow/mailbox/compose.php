    <!--CONTANT START-->
    <div class="contant">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-push-3">
                    <h2><?php echo $sub_page_title; ?></h2>
                    <?php //for message after submitting data
                        if($this->session->flashdata('err_no')=='200' or $this->session->flashdata('err_no')=='0'){
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo $this->session->flashdata('err_msg');?>
                    </div>
                    <?php 
                        } else if($this->session->flashdata('err_no')=='204' or $this->session->flashdata('error_upload_no')=="204"){
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                        <?php 
                            $error_messages = $this->session->flashdata('err_msg');
                            foreach($error_messages as $msg){
                        ?>
                            <li><?php echo $msg; ?></li>
                        <?php } ?>
                        </ul>
                    </div>
                    <?php 
                        }
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="profile-box email-compose">
                          <div class="row">
                            <?php 
                              $send_link = base_url('mailbox/send');
                              if($mode=="edit")
                                $send_link = base_url('mailbox/send/'.$mail_info->id);
                               ?>
                            <form action="<?php echo $send_link; ?>" method="post">
                              <div class="col-md-12">
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
                                  <label><?php echo $this->lang->line('to') ?><span class="label-required">*</span></label>
                                  <input type="text" class="form-control" name="destination" id="destination" placeholder="<?php echo $this->lang->line('type_id_email_name') ?>" value="<?php if($mode=="edit" or $mode=="reply") echo $recipient->user_id.' | '.$recipient->first_name.' '.$recipient->last_name.' | '.ucwords($recipient->user_level) ?>"  required>
                                </div>
                                <div class="form-group">
                                  <label><?php echo $this->lang->line('subject') ?></label>
                                  <input class="form-control" name="subject" placeholder="Subject:" value="<?php if($mode=="edit") echo $mail_info->subject; else if($mode=="reply") echo 'RE: '.$mail_info->subject; else if($mode=="forward") echo 'FW: '.$mail_info->subject;?>" />
                                </div>
                                <div class="form-group">
                                  <label><?php echo $this->lang->line('content_message') ?> <?php if($this->session->userdata('level')=="teacher") echo '<span class="label-required">*</span>';?></label>
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
                                <div class="pull-right">
                                  <button type="submit" class="btn btn-default" name="action" value="draft"><i class="fa fa-pencil"></i> Draft</button>
                                  <button type="submit" class="btn btn-primary" name="action" value="send"><i class="fa fa-envelope-o"></i> Send</button>
                                </div>
                                <button type="button" id="discard-message" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>                    
                </div>
                <div class="col-md-3 col-md-pull-9">
                    <?php $this->load->view('iknow/sidebar_menu'); ?>
                    
                </div>
            </div>
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->
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

  // on mailbox pages
  $(function () {
    //Add text editor
    $("#compose-mailbox").wysihtml5();
    // $('.editing ul li').css('width', 'none');
  });


</script>