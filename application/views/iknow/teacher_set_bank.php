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
                    <!--EDIT AKUN BANK START-->
                    <div class="profile-box editing">
                        <h2><?php echo $this->lang->line('bank_account_data') ?></h2>
                        <p><?php echo $this->lang->line('bank_account_setting_hint') ?></p>
                        <form class="form-horizontal" action="<?php echo base_url('users/set_teacher_bank_account');?>" method="POST">
                            <ul>
                                <li>
                                    <label><strong><?php echo $this->lang->line('bank_name') ?></strong></label>
                                    <input class="form-control" type="text" name="bank-name" value="<?php echo ($bank<>false ? $bank->bank_name : '');?>" required>
                                </li>
                                <li>
                                    <label><strong><?php echo $this->lang->line('bank_account_number') ?></strong></label>
                                    <input class="form-control" type="text" name="number" value="<?php echo ($bank<>false ? $bank->bank_account_number : '');?>" required>
                                </li>
                                <li>
                                    <label><strong><?php echo $this->lang->line('bank_holder_name') ?></strong></label>
                                    <input class="form-control" type="text" name="holder-name" value="<?php echo ($bank<>false ? $bank->bank_holder_name : '');?>" required>
                                </li>
                                <li>
                                    <label><strong><?php echo $this->lang->line('bank_branch') ?></strong></label>
                                    <input class="form-control" type="text" name="branch" value="<?php echo ($bank<>false ? $bank->bank_branch : '');?>">
                                </li>
                                <li>
                                    <label><strong><?php echo $this->lang->line('city') ?></strong></label>
                                    <input class="form-control" type="text" name="city" value="<?php echo ($bank<>false ? $bank->bank_city : '');?>">
                                    <br><br>
                                </li>
                                <li class="fw">
                                    <button type="submit" id="btn-change-password" class="btn-style"><?php echo $this->lang->line('update') ?></button>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <!--EDIT AKUN BANK END-->
                </div>
                <div class="col-md-3 col-md-pull-9">
                    <?php include('sidebar_menu.php'); ?>
                    
                </div>
            </div>
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->