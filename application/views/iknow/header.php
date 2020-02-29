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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CUSTOM CSS -->
<link href="<?php echo IKNOW_DIR;?>/css/style.css" rel="stylesheet" media="screen">
<link href="<?php echo IKNOW_DIR;?>/css/color.css" rel="stylesheet" media="screen">
<link href="<?php echo IKNOW_DIR;?>/css/transitions.css" rel="stylesheet" media="screen">
<!-- BOOTSTRAP -->
<link href="<?php echo ADMIN_LTE_DIR;?>/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<!-- <link href="<?php echo IKNOW_DIR;?>/css/bootstrap-responsive.css" rel="stylesheet" media="screen"> -->
<!-- BX SLIDER-->
<link href="<?php echo IKNOW_DIR;?>/css/jquery.bxslider.css" rel="stylesheet" media="screen">
<!-- OWL CAROUSEL -->
<link href="<?php echo IKNOW_DIR;?>/css/owl.carousel.css" rel="stylesheet">
<!-- FONT AWESOME -->
<link href="<?php echo IKNOW_DIR;?>/css/font-awesome.min.css" rel="stylesheet" media="screen">
<!-- PARALLAX BACKGROUNDS -->
<link href="<?php echo IKNOW_DIR;?>/css/parallax.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo IKNOW_DIR;?>/css/jquery-ui-smoothness.css" type="text/css" />

<!-- Full Calendar -->
<!-- <link href="<?php echo GENERAL_CSS_DIR;?>/fullcalendar.css" rel="stylesheet" type="text/css" /> -->
<!-- <link href="<?php echo GENERAL_CSS_DIR;?>/fullcalendar.print.css" rel='stylesheet' media='print' /> -->



<!-- Datetimepicker -->
<link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>/bootstrap-datetimepicker.css" />

<!-- DATA TABLES -->
<link href="<?php echo ADMIN_LTE_DIR;?>/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<!-- My Own Style -->
<link href="<?php echo IKNOW_DIR;?>/css/mystyle.css" rel="stylesheet" type="text/css" />

<!-- Jquery Lib -->
<script src="<?php echo IKNOW_DIR;?>/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo IKNOW_DIR;?>/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo IKNOW_DIR;?>/js/jquery-ui-1.11.3.js"></script>

</head>
<body>
<!--WRAPPER START-->
<div class="wrapper">
  <!--HEADER START-->
  <header>
  	<!--TOP STRIP START-->
    <!-- <div class="top-strip"></div> -->
    <!--TOP STRIP END-->
    <!--NAVIGATION START-->
    <div class="navigation-bar">
    	<div class="container">
      	<div class="logo">
        	<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo-green-1.png" alt="" width="276"></a>
        </div>
        <div class="language">
          <ul>
            <li><a href="<?php echo base_url('frontpage/change_language/en/english')?>">ENG</a> | </li>
            <li><a href="<?php echo base_url('frontpage/change_language/id/indonesia')?>">IND</a></li>
          </ul>
        </div>
        <div class="navigation" style="margin-top: 30px;">
          <div class="cart">
            <nav class="navbar">
              <div class="navbar-inner">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>                       
              </div><!-- /.container-fluid -->
            </nav>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <?php if($this->session->userdata('logged')=="in") {?>
              <li><a href="#" style="font-size: 16px">Hi, <?php echo $this->session->userdata('fn');?>!</a></li>
              <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home') ?></a></li>
              <li><a href="<?php echo base_url('my_account'); ?>"><?php echo $this->lang->line('my_account') ?></a></li>
              <li><a href="<?php echo base_url('frontpage/messages');?>"><i class="fa fa-envelope"></i> <?php echo $this->lang->line('message') ?> <span class="replace-count-message"></span></a></li>
              <li><a href="<?php echo base_url('order/cart');?>"><i class="fa fa-shopping-cart"></i> <?php echo $this->lang->line('cart') ?> <span class="replace-count-cart">(<?php echo $this->order_lib->count_cart_item()?>)</span></a></li>
              <li><a href="<?php echo base_url('logout'); ?>"><?php echo $this->lang->line('signout') ?></a></li>
              <?php }
                else {
              ?>
              <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home') ?></a></li>
              <li><a href="<?php echo base_url('content/faq'); ?>"><?php echo $this->lang->line('faq') ?></a></li>
              <li><a href="<?php echo base_url('login'); ?>"><?php echo $this->lang->line('signin_signup') ?></a></li>
              <?php } ?>
            </ul>
            <!-- <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
            </ul> -->
          </div><!-- /.navbar-collapse -->
        </div>
      </div>
    </div>
    <!--NAVIGATION END-->
  </header>
  <!--HEADER END-->