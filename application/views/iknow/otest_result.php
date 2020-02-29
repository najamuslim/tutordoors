    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
      	<div class="row">
        	<div class="col-md-9 col-md-push-3">
            <h2><?php echo $sub_page_title; ?></h2>
            <h4><?php echo $this->lang->line('test_assignment_id') ?>: <?php echo (isset($assignment_id) ? $assignment_id : '') ?></h4>
            <h4><?php echo $this->lang->line('test_result') ?>: <?php echo $result?></h4>
            <a href="<?php echo base_url('otest/assignment_list');?>" class="btn-style"><?php echo $this->lang->line('back') ?></a> &nbsp;&nbsp;
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