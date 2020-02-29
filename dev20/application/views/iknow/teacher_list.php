    <!--BANNER START-->
    <div class="page-heading"> 
    	<div class="container">
            <h2><?php echo $sub_page_title; ?></h2>
            <p><?php if(isset($program_course_title)) echo $program_course_title; ?></p>
        </div>
    </div>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        <div class="row">
          <div class="col-md-9">
            <?php if($teachers<>false) {
              foreach($teachers->result() as $teacher){
                // get latest education
                $get_latest_edu = $this->User_m->get_education_history_by_userid($teacher->user_id);
                $latest_edu = $get_latest_edu<>false ? $get_latest_edu->row()->degree.' '.$get_latest_edu->row()->major.' - '.$get_latest_edu->row()->institution : '';
            ?>
            <div class="col-md-4">
              <div class="profile" style="text-align:center">
                <a href="<?php echo base_url('teacher/profile/'.$teacher->user_id);?>">
                  <div class="thumb">
                    <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$teacher->file_name;?>" alt="">
                  </div>
                  <div class="title">
                    <h4><?php echo $teacher->first_name.' '.$teacher->last_name;?></h4>
                    <p><i><?php echo $latest_edu; ?></i></p>
                    <p><?php echo $teacher->about_me; ?></p>
                    <br>
                  </div>
                  <div class="footer">
                    <p><?php echo $this->lang->line('competence') ?>:</p>
                    <p><?php echo str_replace(',', ', ', $teacher->courses); ?></p>
                    <br>
                  </div>
                </a>
              </div>
            </div>
            <?php }}
              else {
            ?>
            <p><?php echo $this->lang->line('teacher_not_found_info_1') ?></p>
            <p><?php echo $this->lang->line('teacher_not_found_info_2') ?></p>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <?php include('sidebar_right.php'); ?>
          </div>
        </div>
            
        	
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->