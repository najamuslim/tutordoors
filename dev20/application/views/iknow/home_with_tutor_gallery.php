    <!--BANNER START-->
    <div class="banner">
      <ul class="bxslider">
        <li><img src="<?php echo base_url('assets/images');?>/slider-image-1.jpg" alt=""> </li>
        <li><img src="<?php echo base_url('assets/images');?>/slider-image-2.jpg" alt=""> </li>
        <li><img src="<?php echo base_url('assets/images');?>/slider-image-3.jpg" alt=""> </li>
      </ul>
      <div class="newsletters">
      	<h1><?php echo $this->lang->line('find_tutor_here') ?></h1>
        <h4><?php echo $this->lang->line('we_provide_the_best') ?></h4>
          <!-- <div class="subscribe">
          	<input type="text" class="input-block-level">
              <button>Subscribe</button>
          </div> -->
      </div> 
    </div>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<!--SERVICES SECTION START-->
      <section>
        <div class="container">
          <!--SECTION HEADER START-->
          <div class="sec-header">
            <h2><?php echo $this->lang->line('why_should_tutordoors') ?></h2>
            <p><?php echo $this->lang->line('here_the_offers') ?></p>
            <span></span>
            <span></span>
            <span></span>
          </div>
          <!--SECTION HEADER END-->
          <div class="row">
            <!--SERVICE ITEM START-->
            <div class="col-md-4">
              <div class="services">
                <div class="header">
                  <img src="<?php echo base_url()?>assets/images/tutor-doors-icon-02.png" alt="" width="122">
                  <!-- <i class="fa fa-tablet"></i>
                  <i class="fa fa-user inner-icon"></i> -->
                </div>
                <div class="text">
                  <h3><a href="#"><?php echo $this->lang->line('experts') ?></a></h3>
                  <p><?php echo $this->lang->line('experts_benefit') ?></p>
                </div>
              </div>
            </div>
            <!--SERVICE ITEM END-->
            <!--SERVICE ITEM START-->
            <div class="col-md-4">
              <div class="services">
                <div class="header">
                  <img src="<?php echo base_url()?>assets/images/tutor-doors-icon-04.png" alt="" width="122" style="margin-top: 20px;">
                  <!-- <i class="fa fa-tablet"></i>
                  <i class="fa fa-list-alt inner-icon"></i> -->
                </div>
                <div class="text">
                  <h3><a href="#"><?php echo $this->lang->line('certification') ?></a></h3>
                  <p><?php echo $this->lang->line('certification_benefit') ?></p>
                </div>
              </div>
            </div>
            <!--SERVICE ITEM END-->
            <!--SERVICE ITEM START-->
            <div class="col-md-4">
              <div class="services">
                <div class="header">
                  <img src="<?php echo base_url()?>assets/images/tutor-doors-icon-06.png" alt="" width="122" style="margin-top: 35px;">
                  <!-- <i class="fa fa-tablet"></i>
                  <i class="fa fa-terminal inner-icon"></i> -->
                </div>
                <div class="text">
                  <h3><a href="#"><?php echo $this->lang->line('interactive') ?></a></h3>
                  <p><?php echo $this->lang->line('interactive_benefit') ?></p>
                </div>
              </div>
            </div>
            <!--SERVICE ITEM END-->
          </div>
        </div>
      </section>
      <!--SERVICES SECTION END-->
      <!--STUDENT FORM SECTION START-->
      <section class="form">
        <div class="form-contant relative">
          <div class="container form-fields"> 
            <div class="row">
              <div class="col-md-6">
                <!-- <img src="<?php // echo IKNOW_DIR;?>/images/student.png" alt=""> -->
                <div class="find-tutor-now">
                  <h3><?php echo $this->lang->line('find_tutor_now') ?></h3>
                  <h4><?php echo $this->lang->line('find_tutor_now_best_tutor_infrontof_you') ?></h4>
                </div>
              </div>
              <div class="col-md-6">
                <div class="student-form">
                  <div class="header">
                    <!-- <h2>Student Form</h2> -->
                  </div>
                  <div class="form-data">
                    <form action="<?php echo base_url('teacher/search/dropdown');?>" method="GET">
                      <ul>
                        <li>
                          <select name="province" id="sel-province" class="form-control styled-select">
                            <option value="">-- <?php echo $this->lang->line('select_province') ?> *</option>
                            <?php if($provinces<>false) {
                                foreach($provinces->result() as $prov){?>
                            <option value="<?php echo $prov->province_id; ?>"><?php echo $prov->province_name; ?></option>
                            <?php }} ?>
                          </select> 
                        </li>
                        <li>
                          <select name="city" id="sel-city" class="form-control styled-select" required>
                            <option value="">-- <?php echo $this->lang->line('select_city') ?> *</option>
                          </select>
                        </li>
                        <li>
                          <select name="root-course" id="sel-root" class="form-control styled-select">
                            <option value="">-- <?php echo $this->lang->line('select_education_level') ?> *</option>
                            <?php if($root_courses<>false) {
                                foreach($root_courses->result() as $root){?>
                            <option value="<?php echo $root->id; ?>"><?php echo $root->category; ?></option>
                            <?php }} ?>
                          </select>
                        </li>
                        <li>
                          <select name="course" id="sel-course" class="form-control styled-select" required>
                            <option value="">-- <?php echo $this->lang->line('select_course') ?> *</option>
                          </select>
                        </li>
                        <li>
                            <!-- <div class="gender">
                                <span>
                                    <input name="gender" type="radio" value="" id="male">
                                    <label for="male">Male</label>
                                </span>
                                <span>
                                    <input name="gender" type="radio" value="" id="female">
                                    <label for="female">Female</label>
                                </span>
                            </div> -->
                          <button id="btn-search-from-home" class="home-btn-search" type="submit"><?php echo $this->lang->line('submit') ?></button>
                        </li>
                      </ul>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>            
          <div id="bg1" data-0="background-position:0px 0px;" data-end="background-position:0px -1000px;"></div>
          <div id="bg2" data-0="background-position:0px 0px;" data-end="background-position:0px -1500px;"></div>
          <div id="bg3" data-0="background-position:0px 0px;" data-end="background-position:0px -900px;"></div>
        </div>
      </section>
      <!--STUDENT FORM SECTION END-->
      <!--COURSES TOPIC SECTION START-->
      <section class="gray-bg tabs-section">
      	<div class="container">
        	<!--SECTION HEADER START-->
        	<div class="sec-header">
          	<h2><?php echo $this->lang->line('find_tutor_here') ?></h2>
            <p><?php echo $this->lang->line('find_tutor_related_education_level') ?></p>
            <span></span>
            <span></span>
            <span></span>
          </div>
          <div class="customNavigation">
            <a class="btn prev"><i class="fa fa-angle-left"></i></a>
            <a class="btn next"><i class="fa fa-angle-right"></i></a>
          </div>
          <div id="owl-carousel" class="owl-carousel owl-theme filter-button-group">
            <?php 
              $cnt = 0;
              foreach($root_courses->result() as $root) {?>
              <!--COURSE ITEM START-->
            <div class="course">
              <div class="text">
                <div class="header">
                  <h4><?php echo $root->category ?></h4>
                  <!-- <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                  </div> -->
                </div>
                <div class="course-detail-btn">
                  <a href="#">Subscribe</a>
                  <button data-filter=".tutor-<?php echo $root->id ?>" onclick="filter_tutor('<?php echo $root->id ?>')">Tutor</button>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="tutor-list">
              <div class="row">
              <?php 
                foreach($root_courses->result() as $root) {
                  if(isset($teachers[$root->id])) {
                    foreach($teachers[$root->id] as $teacher){?>
                      <div class="col-md-3 col-sm-6 col-xs-6 list tutor-<?php echo $root->id?>" data-root="tutor-<?php echo $root->id?>">
                        <div class="profile">
                          <div class="thumb">
                            <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$teacher['image_file'];?>" alt="">
                          </div>
                          <div class="title">
                            <a href="<?php echo base_url('teacher/profile/'.$teacher['user_id']);?>">
                              <h4><?php echo $teacher['first_name'].' '.$teacher['last_name'];?></h4>
                            </a>
                            <p><i><?php echo $teacher['occupation']; ?></i></p>
                            <p><?php echo $teacher['about_me']; ?></p>
                            <br>
                          </div>
                          <div class="footer">
                            <p><?php echo $this->lang->line('competence') ?>:</p>
                            <p><?php echo $teacher['course']; ?></p>
                            <br>
                          </div>
                        </div>
                      </div>
                <?php } } }?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--COURSES TOPIC SECTION END-->
      <!--PAPULAR POSTS SECTION START-->
      <section class="papular-post">
      	<div id="bg4" data-0="background-position:0px 0px;" data-end="background-position:0px -1000px;"></div>
          <div class="container post-contant">
          	<!--SECTION HEADER START-->
              <div class="sec-header">
                <h2><?php echo $this->lang->line('latest_post') ?></h2>
                <!-- <p><?php // echo $this->lang->line('competence') ?></p> -->
                <span></span>
                <span></span>
                <span></span>
              </div>
            	<!--SECTION HEADER END-->
            	<div class="row">
                <?php if(isset($latest_articles)) {
                  foreach($latest_articles as $article) {?>
              	<div class="col-md-4">
                	<div class="post">
                  	<div class="thumb"><img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$article['photo'];?>" alt="<?php echo $article['title'] ?>"></div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="attribute">
                          <!--POST DATE START-->
                          <div class="post-date">
                            <span><?php echo $article['post_dd'] ?></span>
                            <p><?php echo $article['post_mmyy'] ?></p>
                          </div>
                          <!--POST DATE START-->
                          <div class="icons">
                            <ul>
                              <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                              <li>0</li>
                              <li><a href="#"><i class="fa fa-comments-o"></i></a></li>
                              <li>0</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="text">
                          <h4><a href="<?php echo base_url('content/page/'.$article['id'].'-'.$article['url'])?>"><?php echo $article['title'] ?></a></h4>
                          <h5><?php echo $this->lang->line('writer').' '.$article['creator'] ?></h5>
                          <p><?php echo $article['truncated_content'] ?><a href="<?php echo base_url('content/page/'.$article['id'].'-'.$article['url'])?>" class="more"><?php echo $this->lang->line('read_more') ?></a></p>
                        </div>
                      </div>
                    </div>                  
                  </div>
                </div> <!-- ./col -->
                <?php }} ?>
              </div> <!-- ./row -->
            </div>
        </section>
        <!--PAPULAR POSTS SECTION END-->
        <!--TESTIMONIALS SECTION START-->
        <section class="testimonials">
        	<div class="container testimonial-contant">
            	<div class="sec-header">
                <h2><?php echo $this->lang->line('testimonial') ?></h2>
                <p><?php echo $this->lang->line('what_they_say') ?></p>
                <span></span>
                <span></span>
                <span></span>
              </div>
              <div class="testimonial-data">
                <div id="bx-pager">
                  <?php if(isset($testimonials)) {
                      $idx = 0;
                      foreach($testimonials as $row){
                  ?>
                  <a data-slide-index="<?php echo $idx; ?>" href="">
                    <div class="thumb">
                      <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$row['photo'];?>" alt="" width="80" height="80">
                    </div>
                    <p><?php echo $row['name'] ?></p>
                    <!-- <p class="color">guitarist</p> -->
                  </a>
                  <?php $idx++; } }?>
                </div>
                <ul class="bxslider2">
                  <?php if(isset($testimonials)) 
                      foreach($testimonials as $row){?>
                  <li>
                    <div class="testimonial-text">
                      <span><?php echo $row['testi'] ?></span>
                      <a href="#"><?php echo $row['name'] ?></a>
                    </div>
                  </li>
                  <?php } ?>
                </ul>
              </div>
              <div class="side-imgage"><img src="<?php echo IKNOW_DIR;?>/images/testimonials-bg2.png" alt=""></div>
            </div>
        </section>
        <!--TESTIMONIALS SECTION END-->
        <?php //include('follow_social_media.php'); ?>
      </div>
      <!--CONTANT END-->
    <!-- Isotope -->
    <script src="<?php echo IKNOW_DIR;?>/js/isotope.pkgd.js"></script>
<script>
  // $(function () {
  //   $('.span-readmore').click(function () {
  //     $('#cat-list li:hidden').slice(0, 10).show();
  //     if ($('#cat-list li').length == $('#cat-list li:visible').length) {
  //       $('.span-readmore ').hide();
  //     }
  //   });
  // });

  function filter_tutor(root_id){
    // console.log(root_id);
    // $('.tutor-list .row [data-root!="tutor-'+root_id+'"]').hide().find('*').hide(1000);
    // $('.tutor-list .row [data-root="tutor-'+root_id+'"]').show().find('*').show(1000);
    // $('.grid').isotope({filter: '.tutor'+root_id});
  }

  $(document).ready(function(){
    // $('.span-readmore').on('click', function() {
    //   $('#cat-list li:hidden').slice(0, 10).show();
    //   if ($('#cat-list li').length == $('#cat-list li:visible').length) {
    //     $('.span-readmore ').hide();
    //   }
    // });
    $('.filter-button-group').on( 'click', 'button', function() {
      // console.log('hai');
      var filterValue = $(this).attr('data-filter');
      // console.log(filterValue);
      $('.tutor-list').isotope({ 
        itemSelector: '.list',
        filter: filterValue 
      });
    });

    $('.span-readmore').on('click touchstart', function() {
      $('#cat-list li:hidden').slice(0, 10).show();
      if ($('#cat-list li').length == $('#cat-list li:visible').length) {
        $('.span-readmore ').hide();
      }
    });

    var owl = $("#owl-carousel");
    
    owl.owlCarousel({
      items : 4, //10 items above 1000px browser width
      itemsDesktop : [1000,3], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,3], // betweem 900px and 601px
      itemsTablet: [600,2], //2 items between 600 and 0
      itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option
    });
    
    // Custom Navigation Events
    $(".next").click(function(){
      owl.trigger('owl.next');
    })
    $(".prev").click(function(){
      owl.trigger('owl.prev');
    });
  });
</script>