<?php
  define('IKNOW_DIR', base_url('assets/themes/iknow/'));
  define('ADMIN_LTE_DIR', base_url('assets/themes/adminlte/'));
  define('GENERAL_JS_DIR', base_url('assets/themes/js/'));
  define('GENERAL_CSS_DIR', base_url('assets/themes/css/'));
  define('UPLOAD_IMAGE_DIR', base_url('assets/uploads/'));
?>
<!doctype html>
<html lang="<?php echo $this->session->userdata('language'); ?>">
<head>
<meta charset="utf-8">
<title><?php echo $page_title; ?> - Tutordoors.com</title>
<link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon2.png') ?>" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CUSTOM CSS -->
<link href="<?php echo IKNOW_DIR;?>css/style.css?t=<?php echo time()?>" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo IKNOW_DIR;?>css/color.css?t=<?php echo time()?>" rel="stylesheet" media="screen">
<link href="<?php echo IKNOW_DIR;?>css/transitions.css" rel="stylesheet" media="screen">
<!-- BOOTSTRAP -->
<link href="<?php echo ADMIN_LTE_DIR;?>bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<!-- <link href="<?php echo IKNOW_DIR;?>css/bootstrap-responsive.css" rel="stylesheet" media="screen"> -->
<!-- BX SLIDER-->
<link href="<?php echo IKNOW_DIR;?>css/jquery.bxslider.css" rel="stylesheet" media="screen">
<!-- OWL CAROUSEL -->
<link href="<?php echo IKNOW_DIR;?>css/owl.carousel.css" rel="stylesheet">
<!-- FONT AWESOME -->
<link href="<?php echo IKNOW_DIR;?>css/font-awesome.min.css" rel="stylesheet" media="screen">
<!-- PARALLAX BACKGROUNDS -->
<link href="<?php echo IKNOW_DIR;?>css/parallax.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo IKNOW_DIR;?>css/jquery-ui-smoothness.css" type="text/css" />

<!-- File Upload -->
<link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>jquery.fileupload.css" />

<!-- Full Calendar -->
<!-- <link href="<?php echo GENERAL_CSS_DIR;?>fullcalendar.css" rel="stylesheet" type="text/css" /> -->
<!-- <link href="<?php echo GENERAL_CSS_DIR;?>fullcalendar.print.css" rel='stylesheet' media='print' /> -->



<!-- Datetimepicker -->
<link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>bootstrap-datetimepicker.css" />

<!-- DATA TABLES -->
<link href="<?php echo ADMIN_LTE_DIR;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<!-- My Own Style -->
<link href="<?php echo IKNOW_DIR;?>css/mystyle.css?t=<?php echo time()?>" rel="stylesheet" type="text/css" />

<!-- JSTREE -->
<link href="<?php echo IKNOW_DIR;?>css/jstree.min.css" rel="stylesheet" type="text/css" />

<!-- Jquery Lib -->
<script src="<?php echo IKNOW_DIR;?>js/jquery-1.11.3.min.js"></script>
<script src="<?php echo IKNOW_DIR;?>js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo IKNOW_DIR;?>js/jquery-ui-1.11.3.js"></script>

<!-- bootstrap wysihtml5 - text editor -->
<link href="<?php echo GENERAL_CSS_DIR;?>bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

<!-- iCheck -->
<link href="<?php echo GENERAL_CSS_DIR;?>iCheck/flat/blue.css" rel="stylesheet" type="text/css" />

<style>
  .fa { margin-right:10px; }
  .panel-body { padding:0px; }
  .panel-body table tr td { padding-left: 15px }
  .panel-body .table {margin-bottom: 0px; }
</style>

</head>
<body>
<!--WRAPPER START-->
<div class="wrapper">
  <!--HEADER START-->
  <header>
  	<!--TOP STRIP START-->
    <!-- <div class="top-strip"></div> -->
    <!--TOP STRIP END-->
    <!-- TOP BAR START -->
    <?php 
        $opt_phone = $this->Content_m->get_option_by_param('company_phone');
        $opt_mobile = $this->Content_m->get_option_by_param('company_mobile');
        $fb_name = $this->Content_m->get_option_by_param('company_fb_name');
        $fb_link = $this->Content_m->get_option_by_param('company_fb_link');
        $tw_name = $this->Content_m->get_option_by_param('company_twitter_name');
        $li_name = $this->Content_m->get_option_by_param('company_linkedin_name');
        $li_link = $this->Content_m->get_option_by_param('company_linkedin_link');
        $comp_address = $this->Content_m->get_option_by_param('company_address');
        $ig_name = $this->Content_m->get_option_by_param('company_instagram_name');
        $ig_link = $this->Content_m->get_option_by_param('company_instagram_link');
    ?>
    <div class="top-bar">
      <div class="row">
        <div class="col-md-5 col-sm-12 col-xs-12 col">
          <div class="field" style="margin-top: -8px;">
          </div>
          <div class="value"><i class="fa fa-building-o"></i> <?php echo $comp_address->parameter_value ?></div>
        </div>
        <div class="col-md-3 col-sm-8 col-xs-8 col">
          <div class="field" style="margin-top: -8px;">
            <!-- <span class="fa-stack fa-lg">
              <i class="fa fa-square fa-stack-2x back-white"></i>
              <i class="fa fa-phone fa-stack-1x back-parent"></i>
            </span> -->
          </div>
          <div class="value"><i class="fa fa-phone"></i> <?php echo $opt_mobile->parameter_value ?></div>
        </div>
        <!-- <div class="col-md-3 col-sm-3 col-xs-6 col">
          <div class="field">Phone:</div>
          <div class="value"><?php echo $opt_phone->parameter_value ?></div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6 col">
          <div class="field">Mobile:</div>
          <div class="value"><?php echo $opt_mobile->parameter_value ?></div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6 col">
          <div class="field">Address:</div>
          <div class="value"><?php echo $comp_address->parameter_value ?></div>
        </div> -->
        <div class="col-md-2 col-sm-4 col-xs-4">
          <div class="social-media-bar">
            <a href="<?php echo $fb_link->parameter_value; ?>">
              <i class="fa fa-facebook"></i>
              <!-- <span class="fa-stack fa-lg">
                <i class="fa fa-square fa-stack-2x back-white"></i>
                <i class="fa fa-facebook fa-stack-1x back-parent"></i>
              </span> -->
            </a>
            <a href="https://twitter.com/<?php echo $tw_name->parameter_value; ?>">
              <i class="fa fa-twitter"></i>
              <!-- <span class="fa-stack fa-lg">
                <i class="fa fa-square fa-stack-2x back-white"></i>
                <i class="fa fa-twitter fa-stack-1x back-parent"></i>
              </span> -->
            </a>
            <a href="<?php echo $li_link->parameter_value; ?>">
              <i class="fa fa-linkedin"></i>
              <!-- <span class="fa-stack fa-lg">
                <i class="fa fa-square fa-stack-2x back-white"></i>
                <i class="fa fa-linkedin fa-stack-1x back-parent"></i>
              </span> -->
            </a>
            <a href="<?php echo $ig_link->parameter_value; ?>" target="_blank">
              <i class="fa fa-instagram"></i>
              <!-- <span class="fa-stack fa-lg">
                <i class="fa fa-square fa-stack-2x back-white"></i>
                <i class="fa fa-linkedin fa-stack-1x back-parent"></i>
              </span> -->
            </a>
          </div> 
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4">
          <div class="social-media-bar value">
            <a href="<?php echo base_url('frontpage/change_language/en/english')?>">ENG</a> <span style="color: #fff">|</span> <a href="<?php echo base_url('frontpage/change_language/id/indonesia')?>">IND</a>
          </div>
        </div>
      </div>
    </div>
    <!-- TOP BAR END -->
    <!--NAVIGATION START-->
    <div class="navigation-bar">
    	<div class="container green-bar">
      	<div class="logo">
        	<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo-green.png" alt=""></a>
        </div>
        <!-- <div class="language">
          <ul>
            <li><a href="<?php echo base_url('frontpage/change_language/en/english')?>">ENG</a> | </li>
            <li><a href="<?php echo base_url('frontpage/change_language/id/indonesia')?>">IND</a></li>
          </ul>
        </div> -->
        <div class="navigation">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <?php if($this->session->userdata('logged')=="in") {?>
              <li><a href="#" style="font-size: 16px">Hi, <?php echo $this->session->userdata('fn');?>!</a></li>
              <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home') ?></a></li>
              <li><a href="<?php echo base_url('my_account'); ?>"><?php echo $this->lang->line('my_account') ?></a></li>
              <li><a href="<?php echo base_url('frontpage/messages ');?>"><i class="fa fa-envelope"></i> <?php echo $this->lang->line('notification') ?> <span class="replace-count-message"></span></a></li>
              <!-- <li><a href="<?php echo base_url('order/cart');?>"><i class="fa fa-shopping-cart"></i> <?php echo $this->lang->line('cart') ?> <span class="replace-count-cart">(<?php echo $this->order_lib->count_cart_item()?>)</span></a></li> -->
              <li><a href="<?php echo base_url('logout'); ?>"><?php echo $this->lang->line('signout') ?></a></li>
              <?php }
                else {
              ?>
              <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home') ?></a></li>
              <li><a href="<?php echo base_url('content/faq'); ?>"><?php echo $this->lang->line('faq') ?></a></li>
              <li><a href="<?php echo base_url('content/career'); ?>"><?php echo $this->lang->line('career') ?></a></li>
              <li><a href="<?php echo base_url('login'); ?>">Login</a></li>
              <li><a href="<?php echo base_url('signup/tutor'); ?>">Register Tutor</a></li>
              <li><a href="<?php echo base_url('signup/student'); ?>"><?php echo $this->lang->line('signup_as_student') ?></a></li>
              <?php } ?>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div>
      </div>
    </div>
   <!--  <div class="navigation-bar">
      <div class="container">
        <div class="navigation-2"> -->
          <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse-2">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button> -->
          <!-- <div class="collapse navbar-collapse navbar-collapse-2" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
              <?php 
              $menu_level_0 = $this->Content_m->get_parent_menu('second_top');
              $menu_string = '';
              if($menu_level_0<>false)
                foreach($menu_level_0->result() as $zero)
                {
                  // generate level 1
                  // if has child add class dropdown-submenu
                  $menu_level_1 = $this->Content_m->get_child_menu('second_top', $zero->id, '1');

                  if($menu_level_1<>false)
                  {
                    $menu_string .= '<li><a href="'.$zero->link_address.'" class="dropdown-toggle" data-toggle="dropdown">'.$zero->menu_label.' <b class="caret"></b></a>';
                    $menu_string .= '<ul class="dropdown-menu multi-level">';
                    foreach($menu_level_1->result() as $one)
                    {
                      // generate level 2
                      // if has child add class for dropdown
                      $menu_level_2 = $this->Content_m->get_child_menu('second_top', $one->id, '2');
                      if($menu_level_2<>false)
                      {
                        $menu_string .= '<li class="dropdown-submenu"><a href="'.$one->link_address.'" class="dropdown-toggle" data-toggle="dropdown">'.$one->menu_label.'</a>';
                        $menu_string .= '<ul class="dropdown-menu">';
                        foreach($menu_level_2->result() as $two)
                        {
                          $menu_string .= '<li><a href="'.$two->link_address.'">'.$two->menu_label.'</a></li>';
                        }
                        $menu_string .= '</ul>';
                      }
                      else{
                        $menu_string .= '<li><a href="'.$one->link_address.'">'.$one->menu_label.'</a>';
                      }
                      $menu_string .= '</li>';
                    }
                    $menu_string .= '</ul>';
                  }
                  else{
                    $menu_string .= '<li><a href="'.$zero->link_address.'">'.$zero->menu_label.'</a>';
                  }
                } 
              echo $menu_string;
              ?>
            </ul> -->
            <!-- <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
            </ul> -->
          <!-- </div>/.navbar-collapse -->
        <!-- </div>
      </div>
    </div> -->
    <!--NAVIGATION END-->
  </header>
  <!--HEADER END-->