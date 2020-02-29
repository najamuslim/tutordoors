<?php
	define('ADMIN_LTE_DIR', base_url('assets/themes/adminlte/'));
	define('GENERAL_JS_DIR', base_url('assets/themes/js/'));
	define('GENERAL_CSS_DIR', base_url('assets/themes/css/'));
  define('UPLOAD_IMAGE_DIR', base_url('assets/uploads/'));
  define('WACKY_LOGIN_PAGES_DIR', base_url('assets/themes/wackylogin/'));
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Tutordoors Admin<?php if(isset($title_page)) echo ' | '.$title_page;?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo WACKY_LOGIN_PAGES_DIR;?>/img/icon.ico">
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
	<link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>/font-awesome/css/font-awesome.min.css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- DATA TABLES -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
	<!-- JointJS Javascript Diagramming Library-->
	<!-- <link href="<?php echo GENERAL_CSS_DIR;?>/joint.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- Datetimepicker -->
    <link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>/bootstrap-datetimepicker.css" />
    <!-- File Upload -->
    <link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>/jquery.fileupload.css" />

    <!-- Jquery-ui -->
    <link rel="stylesheet" href="<?php echo ADMIN_LTE_DIR;?>/plugins/jQueryUI/jquery-ui-1.10.3.min.css" />
	
	
    <link href="<?php echo GENERAL_CSS_DIR;?>/custom-admin.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-red">
    <div class="wrapper">
	  <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo"><b>Tutor</b> Doors</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning"><?php echo $notif_unread; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $notif_unread ?> unread notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <?php 
                      if($notifications <> false) {
                        $icon_array = array(
                          // category => icon
                          'default' => "fa fa-bell-o",
                          'new_payment_conf' => "fa fa-money",
                          'new_course_request' => "fa fa-shopping-cart",
                          'new_contact_message' => "fa fa-envelope",
                          'veritrans_notification' => "fa fa-money",
                          'paypal_notification' => "fa fa-money",
                          'open_city_request' => "fa fa-globe",
                          'open_course_request' => "fa fa-ticket",
                          'open_city_to_delete' => "fa fa-minus-square",
                          'open_course_to_delete' => "fa fa-minus-square",
                          'tutor_order_confirmation_finished' => "fa fa-thumbs-o-up"
                          );
                        foreach($notifications as $notif){
                          if($notif->has_been_read=="true")
                            $icon_color = "text-green";
                          else if($notif->has_been_read=="false")
                            $icon_color = "text-red";  
                      ?>
                      <li>
                        <a href="<?php echo base_url('cms/show_notifications?id='.$notif->id);?>">
                          <i class="<?php echo (array_key_exists($notif->category, $icon_array) ? $icon_array[$notif->category] : $icon_array['default']); ?> <?php echo $icon_color; ?>"></i> <?php echo $notif->title; ?>
                        </a>
                      </li>
                      <?php 
                          }
                        }
                      ?>
                    </ul>
                  </li>
                  <li class="footer"><a href="<?php echo base_url('cms/show_notifications');?>">View all</a></li>
                </ul>
              </li>
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- <img src="<?php echo ADMIN_LTE_DIR;?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/> -->
                  <span class="hidden-xs"><?php echo $this->session->userdata('fn');?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <!-- <img src="<?php echo ADMIN_LTE_DIR;?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" /> -->
                    <p>
                      <?php echo $this->session->userdata('fn').' '.$this->session->userdata('ln') ?>
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li> -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <!-- <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div> -->
                    <div class="pull-right">
                      <a href="<?php echo base_url('users/do_logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

