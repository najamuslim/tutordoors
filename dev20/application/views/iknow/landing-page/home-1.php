    <!--CONTANT START-->
    <div class="contant">
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
                          <select name="program" id="sel-program" class="form-control styled-select">
                            <option value="">-- <?php echo $this->lang->line('select_education_level') ?> *</option>
                            <?php if($programs<>false) {
                                foreach($programs->result() as $program){?>
                            <option value="<?php echo $program->program_id; ?>"><?php echo $program->program_name; ?></option>
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

    	<!--SERVICES SECTION START-->
      <section style="padding:0px">
        <!-- <div class="container"> -->
        <div class="benefit dashed-bottom">
          <div class="row">
            <div class="col-md-6 dashed-right" style="padding-left: 80px;">
              <h2><?php echo $this->lang->line('why_should_tutordoors') ?></h2>
              <p><?php echo $this->lang->line('here_the_offers') ?></p>
            </div>
            <div class="col-md-6">
              <img class="book" src="<?php echo site_url('assets/images/buku_miring.png')?>" alt="Buku Miring">
            </div>
          </div>
        </div>
          <!--SECTION HEADER START-->
          <!-- <div class="sec-header">
            <h2><?php //echo $this->lang->line('why_should_tutordoors') ?></h2>
            <p><?php //echo $this->lang->line('here_the_offers') ?></p>
            <span></span>
            <span></span>
            <span></span>
          </div> -->
          <!--SECTION HEADER END-->
          <div class="row" style="margin-right: 0px; margin-left: 0px;">
            <!--SERVICE ITEM START-->
            <div class="col-md-4" style="padding: 0">
              <div class="services service-purple service-expert">
                <div class="text service-text-fff">
                  <h3><?php echo $this->lang->line('experts') ?></h3>
                  <p><?php echo $this->lang->line('experts_benefit') ?></p>
                </div>
              </div>
            </div>
            <!--SERVICE ITEM END-->
            <!--SERVICE ITEM START-->
            <div class="col-md-4" style="padding: 0">
              <div class="services service-yellow service-certification">
                <div class="text service-text-333">
                  <h3><?php echo $this->lang->line('certification') ?></h3>
                  <p><?php echo $this->lang->line('certification_benefit') ?></p>
                </div>
              </div>
            </div>
            <!--SERVICE ITEM END-->
            <!--SERVICE ITEM START-->
            <div class="col-md-4" style="padding: 0">
              <div class="services service-orange service-interactive">
                <!-- <div class="header"> -->
                  <!-- <img src="<?php //echo base_url()?>assets/images/tutor-doors-icon-06.png" alt="" width="122" style="margin-top: 35px;"> -->
                  <!-- <i class="fa fa-tablet"></i>
                  <i class="fa fa-terminal inner-icon"></i> -->
                <!-- </div> -->
                <div class="text service-text-fff">
                  <h3><?php echo $this->lang->line('interactive') ?></h3>
                  <p><?php echo $this->lang->line('interactive_benefit') ?></p>
                </div>
              </div>
            </div>
            <!--SERVICE ITEM END-->
          </div>
        <!-- </div> -->
      </section>
      <!--SERVICES SECTION END-->
      
      <!--COURSES TOPIC SECTION START-->
      <section class="gray-bg tabs-section program-list-box">
        <div class="container">
          <!--SECTION HEADER START-->
          <div class="sec-header" style="padding-bottom: 0px;">
            <h2 class="program-list-header"><?php echo $this->lang->line('program_options') ?></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="programs">
              <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-6">
                  <!-- <div class="services"> -->
                    <div class="program-header">
                      <h3><?php echo $this->lang->line('skill_special') ?></h3>
                    </div>
                    <div class="program-body">
                      <ul class="program-list">
                        <li><a href="<?php echo base_url('teacher/program?prog=7') ?>">Umum Bahasa</a></li>
                        <li><a href="<?php echo base_url('teacher/program?prog=8') ?>">Umum Seni</a></li>
                        <li><a href="<?php echo base_url('teacher/program?prog=9') ?>">Umum Komputer</a></li>
                        <li><a href="<?php echo base_url('teacher/program?prog=10') ?>">Umum Lainnya</a></li>
                        <li><a href="<?php echo base_url('teacher/program?prog=21') ?>">Pelatihan/Professional</a></li>
                      </ul>
                    </div>
                  <!-- </div> -->
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">  
                  <div class="program-header">
                    <h3><?php echo $this->lang->line('national') ?></h3>
                  </div>
                  <div class="program-body">
                    <ul class="program-list">
                      <li><a href="<?php echo base_url('teacher/program?prog=3') ?>">TK/PAUD</a></li>
                      <li><a href="<?php echo base_url('teacher/program?prog=11') ?>">SD/MI</a></li>
                      <li><a href="<?php echo base_url('teacher/program?prog=4') ?>">SMP/MTs</a></li>
                      <li><a href="<?php echo base_url('teacher/program?prog=5') ?>">SMA/SMK/MA</a></li>
                      <li><a href="<?php echo base_url('teacher/program?prog=6') ?>">Universitas</a></li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <!-- <div class="services"> -->
                    <div class="program-header">
                      <h3><?php echo $this->lang->line('international') ?></h3>
                    </div>
                    <div class="program-body">
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <ul class="program-list">
                            <li><a href="<?php echo base_url('teacher/program?prog=12-14') ?>">A/AS Level</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=16') ?>">IGCSE</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=13') ?>">O Level</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=17') ?>">CPC</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=15') ?>">Advanced Placement</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=979') ?>">CFA</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=980') ?>">GMAT</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=981') ?>">GRE</a></li>
                          </ul>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <ul class="program-list">
                            <li><a href="<?php echo base_url('teacher/program?prog=982') ?>">HSK</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=983') ?>">IELTS</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=984') ?>">LSAT</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=985') ?>">MCAT</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=986') ?>">SAT</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=987') ?>">TOEFL ITP</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=988') ?>">TOEFL IBT</a></li>
                            <li><a href="<?php echo base_url('teacher/program?prog=18') ?>">IB</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->
                </div>
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
              </div>
            	<!--SECTION HEADER END-->
            	<div class="row">
                <?php if(isset($latest_articles)) {
                  foreach($latest_articles as $article) {?>
              	<div class="col-md-4">
                	<div class="post">
                    <div class="row">
                      <div class="col-md-9 col-sm-9 col-xs-9" style="padding-right: 0px; padding-left: 0px;">
                        <div class="thumb">
                          <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$article['photo'];?>" alt="<?php echo $article['title'] ?>">
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3" style="padding-right: 0px; padding-left: 0px;">
                        <div class="post-date">
                          <span><?php echo $article['post_dd'] ?></span>
                          <p><?php echo $article['post_mmyy'] ?></p>
                        </div>
                        <!--POST DATE START-->
                        <div class="icons">
                          <div class="row">
                            <div class="col-md-6 col place-icon">
                              <i class="fa fa-heart-o"></i>
                            </div>
                            <div class="col-md-6 col">
                              0
                            </div>
                            <div class="col-md-6 col icon place-icon">
                              <i class="fa fa-comments-o"></i>
                            </div>
                            <div class="col-md-6 col">
                              0
                            </div>
                          </div>
                          <!--<ul>
                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                            <li>0</li>
                            <li><a href="#"><i class="fa fa-comments-o"></i></a></li>
                            <li>0</li>
                          </ul>-->
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="text">
                          <h4><a href="<?php echo base_url('content/page/'.$article['id'].'-'.$article['url'])?>"><?php echo $article['title'] ?></a></h4>
                          <!--<h5><?php //echo $this->lang->line('writer').' '.$article['creator'] ?></h5>-->
                          <p><?php echo $article['truncated_content'] ?><a href="<?php echo base_url('content/page/'.$article['id'].'-'.$article['url'])?>" class="more"><?php echo $this->lang->line('read_more') ?></a></p>
                        </div>
                      </div>
                    </div>                  
                  </div>
                </div> <!-- ./col -->
                <?php }} ?>
              </div> <!-- ./row -->
              <div class="view-all-post">
                <a href="<?php echo base_url('content/blog/article/0/100') ?>"><?php echo $this->lang->line('view_all_article') ?> ...</a>
              </div>
            </div>
        </section>
        <!--PAPULAR POSTS SECTION END-->
        <!--TESTIMONIALS SECTION START-->
        <section class="testimonials">
        	<div class="container testimonial-contant">
          	<div class="sec-header">
              <h2><?php echo $this->lang->line('testimonial') ?></h2>
              <p><?php echo $this->lang->line('what_they_say') ?></p>
              <!-- <span></span>
              <span></span>
              <span></span> -->
            </div>
          </div>
          <div class="testimonial-data">
            <div class="row">
              <div class="col-md-3">
                <div class="side-imgage"><img src="<?php echo IKNOW_DIR;?>/images/testimonials-bg2.png" alt=""></div>
              </div>
              <div class="col-md-5">
                <ul class="bxslider2" style="">
                  <?php if(isset($testimonials)) 
                      foreach($testimonials as $row){
                        if($row['lang_id']==$this->session->userdata('language')){
                        ?>
                  <li>
                    <div class="testimonial-text">
                      <span><?php echo $row['testi'] ?></span>
                      <a href="#"><?php echo $row['name'] ?></a>
                    </div>
                  </li>
                  <?php }} ?>
                </ul>
              </div>
              <div class="col-md-4">
                <div id="bx-pager">
                  <?php if(isset($testimonials)) {
                      $idx = 0;
                      foreach($testimonials as $row){
                        if($row['lang_id']==$this->session->userdata('language')){
                  ?>
                  <a data-slide-index="<?php echo $idx; ?>" href="">
                    <div class="thumb">
                      <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$row['photo'];?>" alt="" width="80" height="80">

                    </div>
                    <p><?php echo $row['name'] ?></p>
                    <!-- <p class="color">guitarist</p> -->
                  </a>
                  <?php $idx++; } } }?>
                </div>
              </div>
            </div>
          </div>
            
        </section>
        <!--TESTIMONIALS SECTION END-->
        <?php //include('follow_social_media.php'); ?>
      </div>
      <!--CONTANT END-->
    <!-- Isotope -->
    <script src="<?php echo IKNOW_DIR;?>/js/isotope.pkgd.js"></script>
<script>
  $(document).ready(function(){

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