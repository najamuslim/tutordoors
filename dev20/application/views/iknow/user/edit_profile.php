    <!-- Modal -->
    <div class="modal fade" id="modal-edu-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form" method="post" action="<?php echo base_url('users/update_education_history');?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edu-id" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('education_edit_data')?></h4>
                    </div>
                    <div class="modal-body">
                      <div class="box-body">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('education_level_select') ?></label>
                            <select name="degree" id="degree-edit" class="form-control" required>
                                <option value=""></option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="form-group">
                          <label><?php echo $this->lang->line('university') ?><span class="label-required">*</span></label>
                          <input type="text" class="form-control" name="institution" id="institution-edit" required>
                        </div>
                        <div class="form-group">
                          <label><?php echo $this->lang->line('major') ?><span class="label-required">*</span></label>
                          <input type="text" class="form-control" name="major" id="major-edit" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('grade_score') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="grade_score" id="grade-edit" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('college_year_in') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="year_in" id="in-edit" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('college_year_out') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="year_out" id="out-edit" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('document_college_certificate') ?><span class="label-required">*</span></label>
                            <input type="file" name="certificate" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('document_transcript') ?><span class="label-required">*</span></label>
                            <input type="file" name="transcript" required>
                        </div>
                      </div><!-- /.box-body -->
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close')?></button>
                      <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('update')?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal -->
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
                        <div class="col-md-4">
                            <!--EDIT PRIMARY IMAGE START-->
                            <div class="profile-box editing">
                              <?php if($image_thumb<>"") {?>
                                <div class="thumb">
                                    <a href="#"><img class="img-circle" src="<?php echo UPLOAD_IMAGE_DIR.'/'.$image_thumb;?>" alt="Foto Profil"></a>
                                </div>
                              <?php } 
                              else echo '<p>'.$this->lang->line('profile_picture_not_set').'</p>';
                                ?>
                            </div> 
                            <!--EDIT PRIMARY IMAGE END-->
                        </div>
                        <div class="col-md-8">
                            <!--EDIT PASSWORD START-->
                            <div class="profile-box editing">
                                <form role="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url('users/update_user_primary_photo');?>">
                                    <h2><?php echo $this->lang->line('change_profile_photo') ?></h2>
                                    
                                    <ul>
                                        <li>
                                            <label style="color:#e74c3c; font-size:12px;"><?php echo $this->lang->line('change_profile_photo_hint') ?></label>
                                            <input type="file" name="image_file">
                                        </li>
                                        <li class="fw">
                                            <button type="submit" class="btn-style" style="margin-top:8px"><?php echo $this->lang->line('save') ?></button>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                            <!--EDIT PASSWORD END-->
                        </div>
                        <?php if($this->session->userdata('level')=="teacher") {?>
                        <div class="col-md-12">
                            <!--EDIT GENERAL INFO START-->
                            <div class="profile-box editing">
                                <h2 style="font-family:Blackjack; margin-top:0px;" ><?php echo $this->lang->line('personal_data') ?></h2>
                                <div class="row">
                                    <form method="POST" action="<?php echo base_url('users/update_personal_info');?>" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('name_first') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="first-name" value="<?php if($user_info<>false) echo $user_info->first_name;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('name_last') ?></label>
                                                <input type="text" class="form-control" name="last-name" value="<?php if($user_info<>false) echo $user_info->last_name;?>">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('national_id_number') ?> <?php if($this->session->userdata('level')=="teacher") echo '<span class="label-required">*</span>';?></label>
                                                <input type="text" class="form-control" name="ktp" value="<?php if($user_info<>false) echo $user_info->national_card_number;?>" maxlength="30" <?php if($this->session->userdata('level')=="teacher") echo "required";?>>
                                            </div>
                                            <label><?php echo $this->lang->line('national_id_number_attachment') ?></label>
                                            <div class="form-group">
                                                <label style="color:#e74c3c; font-size:12px;"><?php echo $this->lang->line('national_id_number_attachment_format') ?></label>
                                                <input type="file" name="image_file">
                                                <?php if($user_info<>false) 
                                                if($user_info->national_card_attachment<>""){
                                                    
                                                    $media_filename = $this->media->get_media_data(array('id'=>$user_info->national_card_attachment))->row()->file_name;
                                                    ?>
                                                <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$media_filename ?>" width="150" height="150" alt="" style="margin-top: 15px">
                                                <?php } ?>
                                            </div>
                                            <label><?php echo $this->lang->line('sex') ?><span class="label-required">*</span></label>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="sex" value="male" <?php if($user_info<>false and $user_info->sex=="male") echo "checked";?> required> <?php echo $this->lang->line('sex_male') ?>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="sex" value="female" <?php if($user_info<>false and $user_info->sex=="female") echo "checked";?> required> <?php echo $this->lang->line('sex_female') ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('birth_place') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="birth-place" value="<?php if($user_info<>false) echo $user_info->birth_place;?>" required>
                                            </div>
                                            <label><?php echo $this->lang->line('birth_date') ?><span class="label-required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" id="default-datepicker" name="birth-date" value="<?php if($user_info<>false) echo $user_info->birth_date;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('address_on_national_card') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="address-ktp" value="<?php if($user_info<>false) echo $user_info->address_national_card;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('address_different_national_card') ?></label>
                                                <input type="text" class="form-control" name="address-domicile" value="<?php if($user_info<>false) echo $user_info->address_domicile;?>">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('phone') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="phone-1" value="<?php if($user_info<>false) echo $user_info->phone_1;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('phone_other') ?></label>
                                                <input type="text" class="form-control" name="phone-2" value="<?php if($user_info<>false) echo $user_info->phone_2;?>">
                                            </div>
                                            
                                        
                                            <button type="submit" class="btn-style"><?php echo $this->lang->line('save') ?></button>
                                        
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--EDIT GENERAL INFO END-->
                        </div>
                        <div class="col-md-12">
                            <!--EDIT GENERAL INFO START-->
                            <div class="profile-box editing">
                                <h2 style="font-family:Blackjack; margin-top:0px;" ><?php echo $this->lang->line('public_data') ?></h2>
                                <div class="row">
                                    <form method="POST" action="<?php echo base_url('users/update_public_info');?>" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('about_me') ?><span class="label-required">*</span></label>
                                                <textarea class="form-control" name="about-me" required><?php if($user_info<>false) echo $user_info->about_me;?></textarea>
                                            </div>
                                            <?php if($this->session->userdata('level')=="teacher") {?>
                                            <div class="form-group">    
                                                <label><?php echo $this->lang->line('teach_experience') ?></label>
                                                <textarea class="form-control" name="teach-experience"><?php if($user_info<>false) echo $user_info->teach_experience;?></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('skill_special') ?></label>
                                                <textarea class="form-control" name="skill"><?php if($user_info<>false) echo $user_info->skill;?></textarea>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('hobby') ?></label>
                                                <input type="text" class="form-control" name="hobby" value="<?php if($user_info<>false) echo $user_info->hobby;?>">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('toefl_score') ?></label>
                                                <input type="text" class="form-control" name="toefl" value="<?php if($user_info<>false) echo $user_info->toefl_score;?>">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('ielts_score') ?></label>
                                                <input type="text" class="form-control" name="ielts" value="<?php if($user_info<>false) echo $user_info->ielts_score;?>">
                                            </div>
                                            <!-- <div class="form-group">
                                                <?php if($this->session->userdata('level')=="teacher") {?>
                                                <label><?php echo $this->lang->line('certification') ?><span class="label-required">*</span></label>
                                                <textarea class="form-control" name="certification" required><?php if($user_info<>false) echo $user_info->certification;?></textarea>
                                                <?php } ?>
                                            </div> -->
                                            <button type="submit" class="btn-style"><?php echo $this->lang->line('save') ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--EDIT GENERAL INFO END-->
                        </div>
                        <div class="col-md-12">
                            <!-- OPEN edu COURSE START-->
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('education_latest') ?></h2>
                                <table id="edu-history">
                                    <thead>
                                        <tr>
                                            <td><?php echo $this->lang->line('education') ?></td>
                                            <!-- <td><?php echo $this->lang->line('university') ?></td> -->
                                            <td><?php echo $this->lang->line('grade_score') ?></td>
                                            <td><?php echo $this->lang->line('college_year_in_out') ?></td>
                                            <td><?php echo $this->lang->line('document_college_certificate') ?></td>
                                            <td><?php echo $this->lang->line('document_transcript') ?></td>
                                            <td><?php echo $this->lang->line('action') ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($education_history<>false) {
                                            foreach($education_history->result() as $edu){?>
                                        <tr id="edu-<?php echo $edu->id;?>">
                                            <td><?php echo $edu->degree.' - '.$edu->major;?><br><?php echo $edu->institution;?></td>
                                            <!-- <td></td> -->
                                            <td><?php echo $edu->grade_score;?></td>
                                            <td><?php echo $edu->date_in.' - '.$edu->date_out;?></td>
                                            <td>
                                                <?php if($edu->certificate_media_id<>0) {
                                                    $certificate_file_name = $this->media->get_media_data(array('id'=>$edu->certificate_media_id))->row()->file_name;
                                                ?>
                                                <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$certificate_file_name ?>" alt="" width="80">
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($edu->transcript_media_id<>0) {
                                                    $transcript_file_name = $this->media->get_media_data(array('id'=>$edu->transcript_media_id))->row()->file_name;
                                                ?>
                                                <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$transcript_file_name ?>" alt="" width="80">
                                                <?php } ?>
                                            </td>
                                            <td>
                                              <div><a href="#" onclick="edit_edu('<?php echo $edu->id ?>')"><i class="fa fa-pencil" style="color: #f5b000"></i> <?php echo $this->lang->line('update') ?></a></div>
                                              <div><a href="<?php echo base_url('users/remove_education_history/'.$edu->id) ?>"><i class="fa fa-times" style="color: #ff0000"></i> <?php echo $this->lang->line('delete') ?></a></div>
                                            </td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                                <?php if($education_history==false) {?>
                                <br><br>
                                <form method="POST" action="<?php echo base_url('users/add_education_history')?>" enctype="multipart/form-data">
                                    <ul>
                                        <li>
                                            <label><?php echo $this->lang->line('education_level_select') ?><span class="label-required">*</span></label>
                                            <select name="degree" id="degree" class="form-control" required>
                                                <option value=""></option>
                                                <option value="D1">D1</option>
                                                <option value="D2">D2</option>
                                                <option value="D3">D3</option>
                                                <option value="D4">D4</option>
                                                <option value="S1">S1</option>
                                                <option value="S2">S2</option>
                                                <option value="S3">S3</option>
                                            </select>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('university') ?><span class="label-required">*</span></label>
                                            <input type="text" class="form-control" name="institution" required>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('major') ?><span class="label-required">*</span></label>
                                            <input type="text" class="form-control" name="major" required>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('grade_score') ?><span class="label-required">*</span></label>
                                            <input type="text" class="form-control" name="grade_score" required>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('college_year_in') ?><span class="label-required">*</span></label>
                                            <input type="text" class="form-control" name="year_in" maxlength="4" placeholder="Ex: 2011" required>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('college_year_out') ?><span class="label-required">*</span></label>
                                            <input type="text" class="form-control" name="year_out" maxlength="4" placeholder="Ex: 2015" required>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('document_college_certificate') ?><span class="label-required">*</span></label>
                                            <input type="file" name="certificate" required>
                                        </li>
                                        <li>
                                            <label><?php echo $this->lang->line('document_transcript') ?><span class="label-required">*</span></label>
                                            <input type="file" name="transcript" required>
                                        </li>
                                        <li class="fw">
                                            <button type="submit" class="btn-style" style="margin-top:10px"><?php echo $this->lang->line('add') ?></button>
                                        </li>
                                    </ul>
                                </form>
                                <?php } ?>
                            </div>
                            <!-- OPEN edu COURSE END-->
                        </div>
                        <?php } 
                        else { // student's profile 
                        ?>
                        <div class="col-md-12">
                            <!--EDIT GENERAL INFO START-->
                            <div class="profile-box editing">
                                <h2 style="font-family:Blackjack; margin-top:0px;" ><?php echo $this->lang->line('personal_data') ?></h2>
                                <div class="row">
                                    <form method="POST" action="<?php echo base_url('users/update_student_personal_info');?>" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('name_first') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="first-name" value="<?php if($user_info<>false) echo $user_info->first_name;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('name_last').' ('.$this->lang->line('optional').')' ?></label>
                                                <input type="text" class="form-control" name="last-name" value="<?php if($user_info<>false) echo $user_info->last_name;?>">
                                            </div>
                                            <label><?php echo $this->lang->line('sex') ?><span class="label-required">*</span></label>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="sex" value="male" <?php if($user_info<>false and $user_info->sex=="male") echo "checked";?> required> <?php echo $this->lang->line('sex_male') ?>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="sex" value="female" <?php if($user_info<>false and $user_info->sex=="female") echo "checked";?> required> <?php echo $this->lang->line('sex_female') ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('birth_place') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="birth-place" value="<?php if($user_info<>false) echo $user_info->birth_place;?>" required>
                                            </div>
                                            <label><?php echo $this->lang->line('birth_date') ?><span class="label-required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" id="default-datepicker" name="birth-date" value="<?php if($user_info<>false) echo $user_info->birth_date;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('school_where') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="where_student_school" value="<?php if($user_info<>false) echo $user_info->where_student_school;?>" placeholder="<?php echo $this->lang->line('school_where_example') ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('address') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="address-ktp" value="<?php if($user_info<>false) echo $user_info->address_national_card;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('phone') ?><span class="label-required">*</span></label>
                                                <input type="text" class="form-control" name="phone-1" value="<?php if($user_info<>false) echo $user_info->phone_1;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('phone_other').' ('.$this->lang->line('optional').')' ?></label>
                                                <input type="text" class="form-control" name="phone-2" value="<?php if($user_info<>false) echo $user_info->phone_2;?>">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('about_me') ?></label>
                                                <textarea class="form-control" name="about-me"><?php if($user_info<>false) echo $user_info->about_me;?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('hobby').' ('.$this->lang->line('optional').')' ?></label>
                                                <input type="text" class="form-control" name="hobby" value="<?php if($user_info<>false) echo $user_info->hobby;?>">
                                            </div>
                                        
                                            <button type="submit" class="btn-style"><?php echo $this->lang->line('save') ?></button>
                                        
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--EDIT GENERAL INFO END-->
                        </div>  
                        <?php } ?>
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
  function edit_edu(id){
    $.ajax({
      type : "GET",
      url: base_url+'users/get_edu_by_id/'+id,
      async: false,
      dataType: "json",
      success: function(data) {
        $('#edu-id').val(id);
        $('#degree-edit').val(data.degree);
        $('#major-edit').val(data.major);
        $('#institution-edit').val(data.institution);
        $('#grade-edit').val(data.grade);
        $('#in-edit').val(data.year_in);
        $('#out-edit').val(data.year_out);

        $('#modal-edu-edit').modal('show');
      },
      error: function(e) {
      // Schedule the next request when the current one's complete,, in miliseconds
        alert('Error processing your request: '+e.responseText);
      }
    });
    
  }
</script>