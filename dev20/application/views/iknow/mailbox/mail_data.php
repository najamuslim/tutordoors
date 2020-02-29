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
                        <div class="mailbox-controls">
                          <!-- Check all button -->
                          <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                          <div class="btn-group">
                            <a href="#" id="link-delete"><button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></a>
                            <!-- <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                            <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button> -->
                          </div><!-- /.btn-group -->
                          <button class="btn btn-default btn-sm" onclick="location.reload()"><i class="fa fa-refresh"></i></button>
                          <div class="pull-right">
                            <!-- 1-50/200 -->
                            <div class="btn-group">
                              <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                              <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                            </div><!-- /.btn-group -->
                          </div><!-- /.pull-right -->
                        </div> <!-- /.mailbox-controls -->
                        <div class="table-responsive mailbox-messages">
                          <table class="table table-hover table-striped">
                            <tbody>
                              <?php if($mails<>false) 
                                foreach($mails->result() as $mail){
                                  $sender_info = $this->User_m->get_user_by_id($mail->sender);
                                  if($box=="draft")
                                    $link = base_url('mailbox/compose?mid='.$mail->id.'&uri_back='.current_url());
                                  else
                                    $link = base_url('mailbox/view?mid='.$mail->id.'&box='.$box.'&uri_back='.current_url());

                                  $full_name = '';
                                  if($box=="inbox")
                                    $user_info = $this->User_m->get_user_by_id($mail->sender);
                                  else if($box=="outbox" or $box=="draft")
                                    $user_info = $this->User_m->get_user_by_id($mail->destination);
                                  else if($box=="trash"){
                                    if($mail->trashed_by == $mail->sender)
                                      $user_info = $this->User_m->get_user_by_id($mail->destination);
                                    else if($mail->trashed_by == $mail->destination)
                                      $user_info = $this->User_m->get_user_by_id($mail->sender);
                                  }
                                  $full_name = $user_info->first_name.' '.$user_info->last_name;
                              ?>
                              <tr>
                                <td><input type="checkbox" value="<?php echo $mail->id ?>" /></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="<?php echo $link ?>"><?php echo $full_name ?></a></td>
                                <td class="mailbox-subject" width="300px"><a href="<?php echo $link ?>"><?php echo $mail->subject ?></td>
                                <td class="mailbox-attachment"><?php if($mail->media_id <> "") echo '<i class="fa fa-file-o"></i>' ?></td>
                                <td class="mailbox-date" width="100px"><?php echo date_format(new DateTime($mail->sent_timestamp), 'd/m/y H:i') ?></td>
                              </tr>
                              <?php } 
                              else{?>
                              <tr>
                                <td colspan="6">Sorry, there is no <?php echo $box ?> for you ...</td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                        <div class="mailbox-controls">
                          <!-- Check all button -->
                          <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>                    
                          <div class="btn-group">
                            <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                            <!-- <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                            <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button> -->
                          </div><!-- /.btn-group -->
                          <button class="btn btn-default btn-sm" onclick="location.reload()"><i class="fa fa-refresh"></i></button>
                          <div class="pull-right">
                            <!-- 1-50/200 -->
                            <!-- <div class="btn-group">
                              <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                              <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                            </div> --><!-- /.btn-group -->
                          </div><!-- /.pull-right -->
                        </div> <!-- /.mailbox-controls -->
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
      var checked_box = [];
      function get_all_checked_box(){
        checked_box = [];
        // get all checked and store into array
        $('input[type=checkbox]').each(function () {
          if(this.checked)
            checked_box.push($(this).val());
        });
        set_delete_link();
      }

      function set_delete_link(){
        var href_string = '<?php echo base_url('mailbox/set_trash/multiple?uri_back='.current_url().'&mid=')?>';
        $.each(checked_box, function(index, value){
          href_string += value + '-';
        });
        href_string = href_string.substring(0,href_string.length - 1);
        $('#link-delete').prop('href', href_string);
      }

      $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        // For oncheck callback
        $('input[type="checkbox"]').on('ifChecked', function () { get_all_checked_box() })

        // For onUncheck callback
        $('input[type="checkbox"]').on('ifUnchecked', function () { get_all_checked_box() })

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
          } else {
            //Check all checkboxes
            $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
          }
          $(this).data("clicks", !clicks);

          get_all_checked_box();    
        });

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
          e.preventDefault();
          //detect type
          var $this = $(this).find("a > i");
          var glyph = $this.hasClass("glyphicon");
          var fa = $this.hasClass("fa");          

          //Switch states
          if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
          }

          if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
          }
        });
      });
    </script>