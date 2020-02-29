    <!--BANNER START-->
    <div class="page-heading">
        <div class="container">
            <h2><?php echo $sub_page_title; ?></h2>
            <!-- <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</p> -->
        </div>
    </div>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-push-3">
                    <div class="row">
                        <div class="col-md-4">
                            <!--EDIT PRIMARY IMAGE START-->
                            <div class="profile-box editing">
                                <form role="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url('users/update_user_primary_photo');?>">
                                    <h2><?php echo $this->lang->line('change_profile_photo') ?></h2>
                                    <ul>
                                        <li>
                                            <label style="color:#e74c3c; font-size:12px;"><?php echo $this->lang->line('change_profile_photo_hint') ?></label>
                                            <input type="file" name="image_file">
                                        </li>
                                        <li class="fw">
                                            <button type="submit" class="btn-style" style="margin-top:8px"><?php echo $this->lang->line('update') ?></button>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                            <!--EDIT PRIMARY IMAGE END-->
                        </div>
                        <div class="col-md-8">
                            <!--EDIT PASSWORD START-->
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('password_edit') ?></h2>
                                <form class="form-horizontal" id="form-password">
                                    <input type="hidden" name="email" value="<?php echo $this->session->userdata('email');?>">
                                    <ul>
                                        <li>
                                            <label><?php echo $this->lang->line('password_old') ?></label>
                                            <input class="form-control" type="password" name="old" required>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('password_new') ?></label>
                                            <input class="form-control" type="password" name="new" required>
                                        </li>
                                        <li>
                                            <p id="message" style="color: #00A685"></p>
                                        </li>
                                        <li class="fw">
                                            <button type="button" id="btn-change-password" class="btn-style"><?php echo $this->lang->line('update') ?></button>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                            <!--EDIT PASSWORD END-->
                        </div>
                        <div class="col-md-12">
                            <!--EDIT GENERAL INFO START-->
                            <div class="profile-box padding30">
                                <h2 style="font-family:Blackjack; margin-top:0px;" ><?php echo $this->lang->line('general_data') ?></h2>
                                <div class="row">
                                    <form method="POST" action="<?php echo base_url('users/update_general_info');?>">
                                        <div class="col-md-6">
                                            <label><?php echo $this->lang->line('sex') ?></label>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="sex" value="male" <?php if($user_info<>false and $user_info->sex=="male") echo "checked";?>> <?php echo $this->lang->line('sex_male') ?>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="sex" value="female" <?php if($user_info<>false and $user_info->sex=="female") echo "checked";?>> <?php echo $this->lang->line('sex_female') ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('national_id_number') ?></label>
                                                <input type="text" class="form-control" name="ktp" value="<?php if($user_info<>false) echo $user_info->national_card_number;?>" maxlength="30" <?php if($this->session->userdata('level')=="teacher") echo "required";?>>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('birth_place') ?></label>
                                                <input type="text" class="form-control" name="birth-place" value="<?php if($user_info<>false) echo $user_info->birth_place;?>">
                                            </div>
                                            <label><?php echo $this->lang->line('birth_date') ?></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" id="default-datepicker" name="birth-date" value="<?php if($user_info<>false) echo $user_info->birth_date;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('address_on_national_card') ?></label>
                                                <input type="text" class="form-control" name="address-ktp" value="<?php if($user_info<>false) echo $user_info->address_national_card;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('address_different_national_card') ?></label>
                                                <input type="text" class="form-control" name="address-domicile" value="<?php if($user_info<>false) echo $user_info->address_domicile;?>">
                                            </div>
                                      
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('alumni_or_in_college') ?></label>
                                                <input type="text" class="form-control" name="occupation" value="<?php if($user_info<>false) echo $user_info->occupation;?>" placeholder="<?php echo $this->lang->line('alumni_or_in_college_example') ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('phone') ?></label>
                                                <input type="text" class="form-control" name="phone-1" value="<?php if($user_info<>false) echo $user_info->phone_1;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('phone_other') ?></label>
                                                <input type="text" class="form-control" name="phone-2" value="<?php if($user_info<>false) echo $user_info->phone_2;?>">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('about_me') ?></label>
                                                <textarea class="form-control" name="about-me" required><?php if($user_info<>false) echo $user_info->about_me;?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <?php if($this->session->userdata('level')=="teacher") {?>
                                                <label><?php echo $this->lang->line('teach_experience') ?></label>
                                                <textarea class="form-control" name="teach-experience" required><?php if($user_info<>false) echo $user_info->teach_experience;?></textarea>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group">
                                                <?php if($this->session->userdata('level')=="teacher") {?>
                                                <label><?php echo $this->lang->line('certification') ?></label>
                                                <textarea class="form-control" name="certification" required><?php if($user_info<>false) echo $user_info->certification;?></textarea>
                                                <?php } ?>
                                            </div>
                                        
                                            <button type="submit" class="btn-style"><?php echo $this->lang->line('update') ?></button>
                                        
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--EDIT GENERAL INFO END-->
                        </div>
                    </div>                    
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