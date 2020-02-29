      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Mailbox
            <!-- <small>13 new messages</small> -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Mailbox</li>
            <li class="active"><?php echo ucwords($box) ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <?php $this->load->view('admin/message_after_transaction');?>
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo ucwords($box) ?></h3>
                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      <input type="text" class="form-control input-sm" placeholder="Search Mail"/>
                      <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
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
                  </div>
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
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
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
                  </div>
                </div>
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    
    <?php $this->load->view('admin/footer');?>
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
  </body>
</html>