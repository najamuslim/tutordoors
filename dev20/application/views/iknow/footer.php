
	
    <!--FOOTER START-->
    <footer>
        <div class="container">
        	<div class="row">
                <div class="col-md-3">
                    <div class="widget widget-categories">
                        <h2>Tutordoors.com</h2>
                        <ul class="fa-ul">
                            <li><a href="<?php echo base_url('content/page/'.($this->session->userdata('language')=="id" ? 'tentang-kami' : 'about-us')); ?>"><i class="fa-li fa fa-circle-o" style="color:#fff"></i> <?php echo $this->lang->line('about_us') ?></a></li>
                            <li><a href="<?php echo base_url('content/contact'); ?>"><i class="fa-li fa fa-circle-o" style="color:#fff"></i> <?php echo $this->lang->line('contact') ?></a></li>
                            <li><a href="<?php echo base_url('content/faq'); ?>"><i class="fa-li fa fa-circle-o" style="color:#fff"></i> <?php echo $this->lang->line('faq') ?></a></li>
                            <li><a href="<?php echo base_url('content/page/'.($this->session->userdata('language')=="id" ? 'kebijakan-privasi' : 'privacy-policy')); ?>"><i class="fa-li fa fa-circle-o" style="color:#fff"></i> <?php echo $this->lang->line('privacy_policy') ?></a></li>
                            <li><a href="<?php echo base_url('content/page/'.($this->session->userdata('language')=="id" ? 'syarat-dan-ketentuan' : 'terms-and-conditions')); ?>"><i class="fa-li fa fa-circle-o" style="color:#fff"></i> <?php echo $this->lang->line('term_conditions') ?></a></li>
                            <!-- <li><a href="<?php echo base_url('content/page/help'); ?>"><i class="fa-li fa fa-circle-o" style="color:#fff"></i> <?php echo $this->lang->line('help') ?></a></li> -->
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                	<div class="widget widget-categories">
                        <h2><?php echo $this->lang->line('find_us_in_country') ?></h2>
                        <ul class="fa-ul">
                            <li><a href="#"><i class="fa-li fa fa-circle-o" style="color:#fff"></i> Indonesia</a></li>
                            <li><a href="#"><i class="fa-li fa fa-circle-o" style="color:#fff"></i> Singapore</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="widget widget-categories">
                        <h2>Social Media</h2>
                        <ul class="fa-ul">
                            <?php 
                                $fb_name = $this->Content_m->get_option_by_param('company_fb_name');
                                $fb_link = $this->Content_m->get_option_by_param('company_fb_link');
                                $tw_name = $this->Content_m->get_option_by_param('company_twitter_name');
                                $li_name = $this->Content_m->get_option_by_param('company_linkedin_name');
                                $li_link = $this->Content_m->get_option_by_param('company_linkedin_link');
                             ?>
                            <li><a href="<?php echo $fb_link->parameter_value; ?>"><i class="fa-li fa fa-facebook" style="color:#fff"></i> Page: <?php echo $fb_name->parameter_value; ?></a></li>
                            <li><a href="https://twitter.com/<?php echo $tw_name->parameter_value; ?>"><i class="fa-li fa fa-twitter" style="color:#fff"></i> @<?php echo $tw_name->parameter_value; ?></a></li>
                            <li><a href="<?php echo $li_link->parameter_value; ?>"><i class="fa-li fa fa-linkedin" style="color:#fff"></i> <?php echo $li_name->parameter_value; ?></a></li>
                        </ul>
                    </div>
                </div>
                
                <!--RECENT POSTS WIDGET START-->
				<div class="col-md-3">
                	<div class="widget widget-newsletter">
                        <h2>Newsletters</h2>
                        <div class="newsletter-contant">
                            <p>Subscribe to our services and special offers!</p>
                            <div class="input-group">
                              <input type="text" id="subscribe-email" class="form-control" placeholder="Email">
                              <span class="input-group-addon"><button id="subscribe">Subscribe</button></span>
                            </div>
                            <p id="subscribe-message" style="display:none">Thanks for subscribing!</p>
                            <!-- <p><input type="text"><button>Subscribe</button></p> -->
                        </div>
                        <img src="<?php echo base_url();?>assets/images/logo-white.png" alt="Tutordoors White Logo" width="264">
                    </div>
                </div>
                <!--RECENT POSTS WIDGET END-->                
            </div>
            
        </div>
        <!-- <div class="tweets">
            <div class="container">
            	<div class="tweet-contant">
                	<i class="fa fa-twitter"></i>
                    <h4>Weekly Updates</h4>
                    <ul class="bxslider">
                        <li>
                            <p>Are you a morning person or is the night time the right time? Interesting perspectives on the forum - <a href="#">http://t.co/tdEHlbZf</a></p>
                        </li>
                        <li>
                            <p>Dolor donec sagittis sapien. Ante aptent feugiat adipisicing. Duis int. - <a href="#">http://t.co/tdEHlbZf</a></p>
                        </li>
                        <li>
                            <p>Duis interdum olor donec sagittis sapien. Ante aptent feugiat adipisicing - <a href="#">http://t.co/tdEHlbZf</a></p>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div> -->
        <br>
        <div class="copyright">
        	<div class="container">
        		<p>© Copyrights 2016. All Rights Reserved <a href="#">Tutordoors</a></p>
            </div>
        </div>
    </footer>
    <!--FOOTER END-->
</div>
<div class="icon-live-chat"></div>
<!--WRAPPER END-->

<!-- Bootstrap -->
<script src="<?php echo ADMIN_LTE_DIR;?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo IKNOW_DIR;?>/js/jquery.bxslider.min.js"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script> -->
<script src="<?php echo IKNOW_DIR;?>/js/owl.carousel.js"></script>
<script src="<?php echo IKNOW_DIR;?>/js/modernizr.js"></script>
<!-- <script type="text/javascript" src="<?php echo IKNOW_DIR;?>/js/skrollr.min.js"></script> -->

<!-- Accordion -->
<script type="text/javascript" src="<?php echo IKNOW_DIR;?>/js/jquery.accordion.js"></script>
<!-- my functions -->
<script src="<?php echo IKNOW_DIR;?>/js/functions.js"></script>


<!-- Moment.js -->
<script src="<?php echo GENERAL_JS_DIR;?>/moment.js"></script>
<!-- Bootstrap Datetimepicker -->
<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/bootstrap-datetimepicker.js"></script>
<!-- Full Calendar -->
<!-- <script src="<?php echo GENERAL_JS_DIR;?>/fullcalendar.js"></script> -->
<!-- <script src="<?php echo GENERAL_JS_DIR;?>/full_calendar_id.js"></script> -->

<!-- DATA TABLES SCRIPT -->
<script src="<?php echo ADMIN_LTE_DIR;?>/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo ADMIN_LTE_DIR;?>/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- File Upload -->
<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/jquery.fileupload.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo GENERAL_JS_DIR;?>/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

<!-- iCheck 1.0.1 -->
<script src="<?php echo GENERAL_JS_DIR;?>/icheck.min.js" type="text/javascript"></script>


<script>
    var base_url = "<?php echo base_url(); ?>";
    var current_url = "<?php echo current_url(); ?>";
    var prev_url = "<?php echo $this->session->userdata('prev_page'); ?>";
    var url_parts = current_url.replace(/\/\s*$/,'').split('/');
    var user_level = "<?php echo $this->session->userdata('level');?>";
    var logged_in = "<?php echo $this->session->userdata('logged'); ?>";

</script>
<script src="<?php echo GENERAL_JS_DIR;?>/functions.js"></script>

<script>
    $('#subscribe').on('click', function(){
        $.ajax({
          type : "POST",
          url: "<?php echo base_url('users/subscribe')?>",
          // async: false,
          data: "email="+$('#subscribe-email').val(),
          dataType: "json",
          success: function(data) {
            $('#subscribe-message').toggle();
          },
          error: function(e){
            alert('Error processing your request: '+e.responseText);
          }
         });
    })
    
    $(".icon-live-chat").css({
        position: "fixed",
        // top: "70px",
        top: "92%",
        left: "3%",
        background: "#FF642F",
        "border-radius": "35px",
        padding: "10px 15px",
        "font-size": "16px",
        "z-index": "99999",
        cursor: "pointer",
        "box-shadow": "0 1px 3px rgba(0,0,0,0.1)"
    }).html("<a href='<?php echo base_url('lchat/user')?>' target='_blank' style='color:#fff'>Need help? Get Live Chat here!</a>").addClass("no-print");
      // }).html("<a href='<?php echo base_url('lchat/user')?>' target='_blank'><img src='<?php echo base_url('assets/images/icon-chat.png')?>' width='90'></a>").addClass("no-print");    
</script>

<script>
  // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  // (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  // m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  // })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  // ga('create', 'UA-81409535-1', 'auto');
  // ga('send', 'pageview');

</script>

</body>
</html>
