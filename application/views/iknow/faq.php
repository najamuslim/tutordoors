    <!--BANNER START-->
    <div class="page-heading"> 
    	<div class="container">
            <h2><?php echo $sub_page_title; ?></h2>
        </div>
    </div>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="faq-2">
              <h3><?php echo $this->lang->line('faq_general') ?></h3>
              <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel ante a urna tincidunt lobortis. Duis laoreet condimentum est a sagittis. Donec nulla ante, facilisis ut est id, dapibus consequat sem. Nam imperdiet erat in sagittis suscipit. Phasellus et pulvinar lacus. Nunc ut porttitor lacus. In hac habitasse platea dictumst. Suspendisse vestibulum commodo orci. Donec malesuada orci vel mi rutrum lobortis.</p> -->
              <?php if($faq<>false) {
                $cnt = 1;
                foreach($faq->result() as $row){
                  if($row->slug == "faq-general"){
              ?>
              <!--ACORDIAN DATE START-->
              <div class="accordion_cp" id="section<?php echo $cnt?>">
                  <p><?php echo $row->title?></p><span><img src="<?php echo IKNOW_DIR;?>/images/faq-pen.png" alt=""></span>
              </div>
              <div class="contain_cp_accor">
                  <div class="content_cp_accor">
                      <?php echo $row->content?>
                  </div>
              </div>
              <!--ACORDIAN DATE END-->
              <?php $cnt++;
                    }
                  }
                } 
              ?>
            </div> <!-- FAQ END -->
            <div class="faq-2">
              <h3><?php echo $this->lang->line('faq_teacher') ?></h3>
              <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel ante a urna tincidunt lobortis. Duis laoreet condimentum est a sagittis. Donec nulla ante, facilisis ut est id, dapibus consequat sem. Nam imperdiet erat in sagittis suscipit. Phasellus et pulvinar lacus. Nunc ut porttitor lacus. In hac habitasse platea dictumst. Suspendisse vestibulum commodo orci. Donec malesuada orci vel mi rutrum lobortis.</p> -->
              <?php if($faq<>false) {
                $cnt = 1;
                foreach($faq->result() as $row){
                  if($row->slug == "faq-teacher"){
              ?>
              <!--ACORDIAN DATE START-->
              <div class="accordion_cp" id="section<?php echo $cnt?>">
                  <p><?php echo $row->title?></p><span><img src="<?php echo IKNOW_DIR;?>/images/faq-pen.png" alt=""></span>
              </div>
              <div class="contain_cp_accor">
                  <div class="content_cp_accor">
                      <?php echo $row->content?>
                  </div>
              </div>
              <!--ACORDIAN DATE END-->
              <?php $cnt++;
                    }
                  }
                } 
              ?>
            </div> <!-- FAQ END -->
            <div class="faq-2">
              <h3><?php echo $this->lang->line('faq_student') ?></h3>
              <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel ante a urna tincidunt lobortis. Duis laoreet condimentum est a sagittis. Donec nulla ante, facilisis ut est id, dapibus consequat sem. Nam imperdiet erat in sagittis suscipit. Phasellus et pulvinar lacus. Nunc ut porttitor lacus. In hac habitasse platea dictumst. Suspendisse vestibulum commodo orci. Donec malesuada orci vel mi rutrum lobortis.</p> -->
              <?php if($faq<>false) {
                $cnt = 1;
                foreach($faq->result() as $row){
                  if($row->slug == "faq-student"){
              ?>
              <!--ACORDIAN DATE START-->
              <div class="accordion_cp" id="section<?php echo $cnt?>">
                  <p><?php echo $row->title?></p><span><img src="<?php echo IKNOW_DIR;?>/images/faq-pen.png" alt=""></span>
              </div>
              <div class="contain_cp_accor">
                  <div class="content_cp_accor">
                      <?php echo $row->content?>
                  </div>
              </div>
              <!--ACORDIAN DATE END-->
              <?php $cnt++;
                    }
                  }
                } 
              ?>
            </div> <!-- FAQ END -->
          </div> <!-- ./col -->
          <div class="col-md-3">
            <?php include('sidebar_right.php'); ?>
          </div>
        </div>
            
        	
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->