        <div class="row">
          <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar" style="margin-bottom: 20px;">
              <!--COURSE CATEGORIES WIDGET START-->
              <div class="widget widget-course-categories-b">
                <h2>Browse Categories</h2>
                <ul id="cat-list">
                  <?php 
                    $cnt = 0;
                    foreach($root_courses->result() as $root) {
                      if($cnt==0)
                        echo '<li class="active"><span onclick="filter_tutor('.$root->id.')">'.$root->category.'</span></li>';
                      else
                        echo '<li><span onclick="filter_tutor('.$root->id.')">'.$root->category.'</span></li>';

                      $cnt++;
                    }
                  ?>
                </ul>
                <span class="span-readmore">More Categories..</span>
              </div>
              <!--COURSE CATEGORIES WIDGET END-->
            </div>
          </div>
          <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="tutor-list">
              <div class="row">
              <?php 
                foreach($root_courses->result() as $root) {
                  if(isset($teachers[$root->id])) {
                    foreach($teachers[$root->id] as $teacher){?>
                <div class="col-md-4 col-sm-6 col-xs-6 list" data-root="tutor-<?php echo $root->id?>" style="display:none">
                  <!-- <div class="teacher-profile"> -->
                    <div class="profile">
                      <div class="thumb">
                        <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$teacher['image_file'];?>" alt="" width="100%" height="179">
                      </div>
                      <div class="title">
                        <a href="<?php echo base_url('teacher/profile/'.$teacher['user_id']);?>">
                          <h4><?php echo $teacher['first_name'].' '.$teacher['last_name'];?></h4>
                        </a>
                        <p><i><?php echo $teacher['occupation']; ?></i></p>
                        <p><?php echo $teacher['about_me']; ?></p>
                        <br>
                        <p style="color:#000000;font-size:16px;font-family:Pasifico"><?php echo $this->lang->line('competence') ?>:</p>
                        <p><?php echo $teacher['course']; ?></p>
                        <br>
                      </div>
                      <div class="followers">
                        <i class="fa fa-list"></i>
                        <a href="#"><span><?php echo $teacher['total_viewed'];?></span><?php echo $this->lang->line('total_viewed') ?></a>
                        <a href="#"><span><?php echo $teacher['total_taken_course']; ?></span><?php echo $this->lang->line('total_taken_course') ?></a>
                      </div>
                    </div>
                  <!-- </div> -->
                </div>
                <?php } } }?>
              </div>
            </div>
          </div>
        </div>