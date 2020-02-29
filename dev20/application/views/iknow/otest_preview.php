    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
      	<div class="row">
        	<div class="col-md-9 col-md-push-3">
            <h2><?php echo $sub_page_title; ?></h2>
            <h4><?php echo $this->lang->line('test_assignment_id') ?>: <?php echo (isset($assignment_id) ? $assignment_id : '') ?></h4>
            <h4><?php echo $this->lang->line('test_id') ?>: <?php echo (isset($test_id) ? $test_id : '') ?></h4>
            <h4><?php echo $this->lang->line('test_name') ?>: <?php echo (isset($test_data->test_name) ? $test_data->test_name : '') ?></h4>
            <h4><?php echo $this->lang->line('test_related_course') ?>: <?php echo (isset($course) ? $course : '') ?></h4>
            <h4><?php echo $this->lang->line('test_time_lapsed') ?>: <?php echo (isset($test_data->time_in_minutes) ? $test_data->time_in_minutes : '').' '.$this->lang->line('minute') ?></h4>
            <div class="profile-box editing">
              <h2><?php echo $this->lang->line('test_objective') ?></h2>
              <?php echo (isset($test_data->objectives) ? $test_data->objectives : '') ?>
            </div>
            <div class="profile-box editing">
              <h2><?php echo $this->lang->line('test_how_to') ?></h2>
              <?php echo (isset($test_data->how_to) ? $test_data->how_to : '') ?>
            </div>
            <a href="<?php echo base_url('otest/assignment_list');?>" class="btn-style"><?php echo $this->lang->line('back') ?></a> &nbsp;&nbsp;
            <a href="<?php echo base_url('otest/start/'.$assignment_id.'/'.$test_id);?>" class="btn-style"><?php echo $this->lang->line('test_start') ?></a>
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