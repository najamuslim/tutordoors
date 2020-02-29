    <!--CONTANT START-->
    <div class="contant">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-push-3">
                    <!-- <h2><?php echo $sub_page_title; ?></h2> -->
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
                            <!--EDIT PASSWORD START-->
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('password_edit') ?></h2>
                                <form class="form-horizontal" id="form-password">
                                    <input type="hidden" name="email" value="<?php echo $this->session->userdata('email');?>">
                                    <ul>
                                        <li>
                                            <label><?php echo $this->lang->line('password_old') ?><span class="label-required">*</span></label>
                                            <input class="form-control" type="password" name="old" required>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('password_new') ?><span class="label-required">*</span></label>
                                            <input class="form-control" type="password" name="new" required>
                                        </li>
                                        <li>
                                            <p id="message" style="color: #00A685"></p>
                                        </li>
                                        <li class="fw">
                                            <button type="button" id="btn-change-password" class="btn-style"><?php echo $this->lang->line('save') ?></button>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                            <!--EDIT PASSWORD END-->
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
