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
                            <!--EDIT GENERAL INFO START-->
                            <div class="profile-box editing">
                                <h2 style="font-family:Blackjack; margin-top:0px;" ><?php echo $this->lang->line('personal_data') ?></h2>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profile-box editing">
                                            <?php if($image_thumb<>"") {?>
                                            <div class="thumb">
                                                <a href="#"><img class="img-circle" src="<?php echo UPLOAD_IMAGE_DIR.'/'.$image_thumb;?>" alt="Foto Profil"></a>
                                            </div>
                                            <?php } ?>
                                        </div> 
                                        <a class="btn-style" style="margin:8px 0" href="<?php echo base_url('users/edit_profile') ?>" ><?php echo $this->lang->line('edit_profile') ?></a>
                                        <!--EDIT PRIMARY IMAGE END-->
                                    </div>
                                    <?php if($this->session->userdata('level')=="teacher") {?>
                                    <div class="col-md-4">
                                        <table>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('name_first') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->first_name;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('name_last') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->last_name;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('national_id_number') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->national_card_number;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('national_id_number_attachment') ?></strong></td>
                                                <td>
                                                    <?php if($user_info<>false) 
                                                    if($user_info->national_card_attachment<>""){
                                                        
                                                        $media_filename = $this->media->get_media_data(array('id'=>$user_info->national_card_attachment))->row()->file_name;
                                                        ?>
                                                    <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$media_filename ?>" width="150" height="150" alt="" style="margin-top: 15px">
                                                    <?php } ?>        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('sex') ?></strong></td>
                                                <td><?php if($user_info<>false) echo ($user_info->sex=="male" ? $this->lang->line('sex_male') : $this->lang->line('sex_female'));?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <table>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('birth_place') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->birth_place;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('birth_date') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->birth_date;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('address_on_national_card') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->address_national_card;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('address_different_national_card') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->address_domicile;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('phone') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->phone_1;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('phone_other') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->phone_2;?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php } 
                                    else { // student's profile 
                                    ?>
                                    <div class="col-md-4">
                                        <table>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('name_first') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->first_name;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('name_last') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->last_name;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('national_id_number') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->national_card_number;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('sex') ?></strong></td>
                                                <td><?php if($user_info<>false) echo ($user_info->sex=="male" ? $this->lang->line('sex_male') : $this->lang->line('sex_female'));?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('school_where') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->where_student_school;?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <table>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('birth_place') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->birth_place;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('birth_date') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->birth_date;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('address') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->address_national_card;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('phone') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->phone_1;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('phone_other') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->phone_2;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('about_me') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->about_me;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('hobby') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->hobby;?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--EDIT GENERAL INFO END-->
                            <!--EDIT GENERAL INFO START-->
                            <?php 
                                if($this->session->userdata('level')=="teacher") {
                                    // get latest education
                                    if($user_info<>false){
                                        $get_latest_edu = $this->User_m->get_education_history_by_userid($user_info->user_id);
                                        $latest_edu = $get_latest_edu<>false ? $get_latest_edu->row()->degree.' '.$get_latest_edu->row()->major.' - '.$get_latest_edu->row()->institution : '';
                                    }
                                ?>
                            <div class="profile-box editing">
                                <h2 style="font-family:Blackjack; margin-top:0px;" ><?php echo $this->lang->line('public_data') ?></h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('education_latest') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $latest_edu;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('about_me') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->about_me;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('teach_experience') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->teach_experience;?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('skill_special') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->skill;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('toefl_score') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->toefl_score;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('ielts_score') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->ielts_score;?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $this->lang->line('hobby') ?></strong></td>
                                                <td><?php if($user_info<>false) echo $user_info->hobby;?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--EDIT GENERAL INFO END-->
                            <!-- OPEN edu COURSE START-->
                            <div class="profile-box editing">
                                <h2><?php echo $this->lang->line('education_latest') ?></h2>
                                <table id="edu-history">
                                    <thead>
                                        <tr>
                                            <td><?php echo $this->lang->line('education') ?></td>
                                            <td><?php echo $this->lang->line('university') ?></td>
                                            <td><?php echo $this->lang->line('grade_score') ?></td>
                                            <td><?php echo $this->lang->line('college_year_in_out') ?></td>
                                            <td><?php echo $this->lang->line('document_college_certificate') ?></td>
                                            <td><?php echo $this->lang->line('document_transcript') ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($education_history<>false) {
                                            foreach($education_history->result() as $edu){?>
                                        <tr id="edu-<?php echo $edu->id;?>">
                                            <td><?php echo $edu->degree.' - '.$edu->major;?></td>
                                            <td><?php echo $edu->institution;?></td>
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
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                            <!-- OPEN edu COURSE END-->
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