<style>
    hr{
        border-color:#178FC4
    }
</style>
	<!--BANNER START-->
    <!-- <div class="page-heading">
        <div class="container">
            <h2><?php echo $sub_page_title; ?></h2>
        </div>
    </div> -->
    <?php $this->load->view('iknow/wizard_order') ?>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="teacher-profile">
            	<div class="row">
                	<div class="col-md-3">
                        <div class="profile-box profile-view" style="margin-top: 0px;">
                            <div class="thumb">
                              <a href="#"><img class="img-circle" src="<?php echo UPLOAD_IMAGE_DIR.'/'.$image_thumb;?>" alt="Foto Profil"></a>
                            </div>
                            <div class="text">
                                <?php // get latest education
                                $get_latest_edu = $this->User_m->get_education_history_by_userid($user_info->user_id);
                                $latest_edu = $get_latest_edu<>false ? $get_latest_edu->row()->degree.' '.$get_latest_edu->row()->major.' - '.$get_latest_edu->row()->institution : ''; ?>
                              <!-- <p style="margin-bottom:10px">Hi,</p> -->
                              <p style="margin-top:10px"><?php echo $user_info->first_name.' '.$user_info->last_name; ?></p>
                              <p style="margin-top:10px">ID: <?php echo $user_info->user_id; ?></p>
                              <p style="margin-top:10px"><?php echo $this->lang->line('sex') ?>: <?php echo ($user_info->sex=="male" ? $this->lang->line('sex_male') : $this->lang->line('sex_female')); ?></p>
                              <p style="margin-top:10px"><?php echo $this->lang->line('age') ?>: <?php echo date_diff(date_create($user_info->birth_date), date_create('today'))->y; ?></p>
                              <p style="margin-top:10px"><?php echo $this->lang->line('total_viewed') ?>: <?php echo $user_info->total_viewed; ?></p>
                              <p style="margin-top:10px"><?php echo $this->lang->line('tariff') ?>: IDR <?php echo number_format($user_info->salary_per_hour, 0, '.', ','); ?></p>
                              <!-- <p style="margin-top:10px"><?php echo $this->lang->line('total_taken_course') ?>: <?php echo $total_taken_course; ?></p> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                    	<div class="bio">
                        	<?php if($level=="teacher") {?>
                            <h3><i class="fa fa-graduation-cap" style="color:#27aec4"></i> <?php echo $latest_edu; ?></h3>
                            <hr>
                            <h3><?php echo $this->lang->line('city_coverage_for_teaching') ?></h3>
                            <ul class="fa-ul">
                                <?php 
                                if($open_city <> false)
                                    foreach($open_city->result() as $city){
                                        echo '<li><i class="fa-li fa fa-check-square-o" style="color: #0090A4"></i>'.$city->city_name.'</li>';
                                } 
                                ?>
                            </ul>
                            <hr>
                            <h3><?php echo $this->lang->line('competence') ?></h3>
                            <ul class="fa-ul">
                                <?php 
                                if($open_course <> false)
                                    foreach($open_course->result() as $course){
                                        echo '<li><i class="fa-li fa fa-check-square-o" style="color: #0090A4"></i><b>'.$course->program_name.'</b> - '.$course->course_name.'</li>';
                                } 
                                ?>
                            </ul>
                            <hr>
                            <h3><?php echo $this->lang->line('about_me') ?></h3>
                            <p><?php echo nl2br($user_info->about_me); ?></p>
                            <hr>
                            <h3><?php echo $this->lang->line('teach_experience') ?></h3>
                            <p><?php echo nl2br($user_info->teach_experience); ?></p>
                            <hr>
                            <h3><?php echo $this->lang->line('certification') ?></h3>
                            <p><?php echo nl2br($user_info->certification); ?></p>
                            <hr>                            
                            
                            <?php } ?>
                        </div>
                        <div class="choose" style="float:right">
                            <a href="<?php echo base_url('frontpage/prepare_order?tid='.$user_info->user_id);?>"><button id="btn-login" class="btn-style" type="button"><?php echo $this->lang->line('select_this_teacher') ?></button></a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->
    <script>
        var teacher_id = "<?php echo $this->uri->segment(3); ?>";
    </script>