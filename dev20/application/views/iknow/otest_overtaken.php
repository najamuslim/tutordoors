    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
      	<div class="row">
        	<div class="col-md-9 col-md-push-3">
            <h2><?php echo $sub_page_title; ?></h2>
            <h4><?php echo $this->lang->line('test_assignment_id') ?>: <?php echo (isset($assignment_id) ? $assignment_id : '') ?></h4>
            
            <div class="profile-box editing">
              <h2><?php echo $this->lang->line('test_overtaken') ?></h2>
            </div>
            
            <a href="<?php echo base_url('otest/preview/'.$assignment_id.'/'.$test_id);?>" class="btn-style"><?php echo $this->lang->line('back') ?></a>
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
<script>
  
</script>