<?php
  define('IKNOW_DIR', base_url('assets/themes/iknow/'));
  define('ADMIN_LTE_DIR', base_url('assets/themes/adminlte/'));
  define('GENERAL_JS_DIR', base_url('assets/themes/js/'));
  define('GENERAL_CSS_DIR', base_url('assets/themes/css/'));
?>
<!doctype html>
<html lang="<?php echo $this->session->userdata('language'); ?>">
<head>
<meta charset="utf-8">
<title>Hexxa Academy | Pesan Kesalahan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CUSTOM CSS -->
<link href="<?php echo IKNOW_DIR;?>/css/style.css" rel="stylesheet" media="screen">
<link href="<?php echo IKNOW_DIR;?>/css/color.css" rel="stylesheet" media="screen">
<link href="<?php echo IKNOW_DIR;?>/css/transitions.css" rel="stylesheet" media="screen">
<!-- BOOTSTRAP -->
<link href="<?php echo ADMIN_LTE_DIR;?>/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<!-- FONT AWESOME -->
<link href="<?php echo IKNOW_DIR;?>/css/font-awesome.min.css" rel="stylesheet" media="screen">

<link rel="stylesheet" href="<?php echo IKNOW_DIR;?>/css/jquery-ui-smoothness.css" type="text/css" />

<!-- Datetimepicker -->
<link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>/bootstrap-datetimepicker.css" />

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
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
      	<div class="error">
          <p class="error-404"><?php echo $error_no; ?></p>
          <p class="ohh"><?php echo $error_message; ?></p>
          <!-- <p class="away">Take me away <span class="color">or</span> Report This</p> -->
        </div>
      </div>
      <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->

    <!--FOOTER START-->
    <footer style="padding: 20px 0; margin-top: 10px">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="copyright">
                <p style="color:#fff">© Copyrights <strong>Hexxa Academy</strong>, 2016. All Rights Reserved</p>
              </div>
            </div>
          </div>
        </div>
    </footer>
    <!--FOOTER END-->
</div>
<!--WRAPPER END-->

<!-- Bootstrap -->
<script src="<?php echo ADMIN_LTE_DIR;?>/bootstrap/js/bootstrap.min.js"></script>
<!-- my functions -->
<script src="<?php echo IKNOW_DIR;?>/js/functions.js"></script>
<!-- Moment.js -->
<script src="<?php echo GENERAL_JS_DIR;?>/moment.js"></script>
<!-- Bootstrap Datetimepicker -->
<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/bootstrap-datetimepicker.js"></script>

<!-- DATA TABLES SCRIPT -->
<script src="<?php echo ADMIN_LTE_DIR;?>/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo ADMIN_LTE_DIR;?>/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81409535-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>