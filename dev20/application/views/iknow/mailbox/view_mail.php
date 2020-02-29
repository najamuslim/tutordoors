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
                          <br><br>
                          <?php echo base64_decode($mail_content->content) ?>
                          <br><br>
                        </div><!-- /.mailbox-read-message -->
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
                            <span class="mailbox-attachment-icon has-img"><img src="<?php echo base_url('assets/uploads/'.$media_info->file_name) ?>" width="140px" /></span>
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
                        <div class="mailbox-controls with-border text-center">
                          <div class="btn-group">
                            <a href="<?php echo base_url('mailbox/set_trash?mid='.$mail_content->id.'&uri_back='.$uri_back) ?>"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button></a>
                            <a href="<?php echo base_url('mailbox/reply?mid='.$mail_content->id.'&box='.$box) ?>"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="Reply"><i class="fa fa-reply"></i></button></a>
                            <a href="<?php echo base_url('mailbox/forward?mid='.$mail_content->id.'&box='.$box) ?>"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="Forward"><i class="fa fa-share"></i></button></a>
                          </div><!-- /.btn-group -->
                          <!-- <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></button> -->
                        </div><!-- /.mailbox-controls -->
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