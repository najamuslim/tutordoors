      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <!-- <h1>
            Read Mail
          </h1> -->
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Mailbox</li>
            <li class="active">View Mail</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Read Mail</h3>
                  <div class="box-tools pull-right">
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="mailbox-read-info">
                    <h3><?php echo $mail_content->subject ?></h3>
                    <?php 
                    if($box=="inbox") {
                      $user_info = $this->User_m->get_user_by_id($mail_content->sender);
                      $direction_text = "From:";
                    }
                    else if($box=="outbox") {
                      $user_info = $this->User_m->get_user_by_id($mail_content->destination);
                      $direction_text = "To:";
                    }
                    ?>
                    <h5><?php echo $direction_text ?> <?php echo $user_info->first_name.' '.$user_info->last_name ?> <span class="mailbox-read-time pull-right"><?php echo date_format(new DateTime($mail_content->sent_timestamp), 'd M Y H:i') ?></span></h5>
                  </div><!-- /.mailbox-read-info -->
                  <div class="mailbox-controls with-border text-center">
                    <div class="btn-group">
                      <a href="<?php echo base_url('mailbox/set_trash?mid='.$mail_content->id.'&uri_back='.$uri_back) ?>"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button></a>
                      <a href="<?php echo base_url('mailbox/reply?mid='.$mail_content->id.'&box='.$box) ?>"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="Reply"><i class="fa fa-reply"></i></button></a>
                      <a href="<?php echo base_url('mailbox/forward?mid='.$mail_content->id.'&box='.$box) ?>"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="Forward"><i class="fa fa-share"></i></button></a>
                    </div><!-- /.btn-group -->
                    <!-- <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></button> -->
                  </div><!-- /.mailbox-controls -->
                  <div class="mailbox-read-message">
                    <?php echo base64_decode($mail_content->content) ?>
                  </div><!-- /.mailbox-read-message -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <ul class="mailbox-attachments clearfix">
                    <?php 
                    if($mail_content->media_id<>""){
                      $media_array = explode(',', $mail_content->media_id);
                      foreach($media_array as $media_id){
                        $get_media = $this->media_m->get_media_data(array('id' => $media_id));
                        $media_info = $get_media->row();
                     ?>
                    <li>
                      <?php if($media_info->is_image<>"0") {?>
                      <span class="mailbox-attachment-icon has-img"><img src="<?php echo base_url('assets/uploads/'.$media_info->file_name) ?>" /></span>
                      <?php } ?>
                      <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?php echo $media_info->file_name ?></a>
                        <span class="mailbox-attachment-size">
                          <?php echo number_format($media_info->file_size, 0, '.', ',') ?> KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                      </div>
                    </li>
                    <?php }} ?>
                  </ul>
                </div><!-- /.box-footer -->
                <div class="box-footer">
                  <div class="pull-right">
                    <a href="<?php echo base_url('mailbox/reply?mid='.$mail_content->id.'&box='.$box) ?>"><button class="btn btn-default"><i class="fa fa-reply"></i> Reply</button></a>
                    <a href="<?php echo base_url('mailbox/forward?mid='.$mail_content->id.'&box='.$box) ?>"><button class="btn btn-default"><i class="fa fa-share"></i> Forward</button></a>
                  </div>
                  <a href="<?php echo base_url('mailbox/set_trash?mid='.$mail_content->id.'&uri_back='.$uri_back) ?>"><button class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button></a>
                  <!-- <button class="btn btn-default"><i class="fa fa-print"></i> Print</button> -->
                </div><!-- /.box-footer -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    <?php $this->load->view('admin/footer');?>
  </body>
</html>