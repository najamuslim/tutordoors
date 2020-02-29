		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> <?php echo $latest_version->version ?>
			</div>
			<strong>Copyright &copy; 2016 <a href="#">Tutordoors</a>.</strong> All rights reserved. <strong>Admin Template by <a href="http://almsaeedstudio.com">Almsaeed Studio</a></strong>
		</footer>
	  
	</div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- jQuery-ui 1.11.4 -->
    <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/jQueryUI/jquery-ui-1.10.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo ADMIN_LTE_DIR;?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABLES SCRIPT -->
    <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<!-- iCheck 1.0.1 -->
    <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo ADMIN_LTE_DIR;?>/plugins/fastclick/fastclick.min.js'></script>
    <!-- Morris Chart -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo ADMIN_LTE_DIR;?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo ADMIN_LTE_DIR;?>/dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <!--<script src="<?php echo ADMIN_LTE_DIR;?>/dist/js/demo.js" type="text/javascript"></script>-->
	<!-- My Custom Function -->
	<!-- <script src="<?php echo GENERAL_JS_DIR;?>/functions.js" type="text/javascript"></script> -->
	<!-- Bootstrap Datetimepicker -->
	<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/moment.js"></script>
	<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/bootstrap-datetimepicker.js"></script>
  <!-- File Upload -->
  <script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/jquery.ui.widget.js"></script>
  <script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/jquery.iframe-transport.js"></script>
  <script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/jquery.fileupload.js"></script>
	<!-- page script -->
  <script type="text/javascript">
    $(function () {
      $('#default-datepicker').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });

    $(function () {
      $("#default-table").dataTable({
  			"bSort": false,
  			"iDisplayLength": 25,
  			"bLengthChange": true
  		});
      $("#default-table-en").dataTable({
        "bSort": false,
        "iDisplayLength": 25,
        "bLengthChange": true
      });
      $("#default-table-id").dataTable({
        "bSort": false,
        "iDisplayLength": 25,
        "bLengthChange": true
      });
      $("#table-10rows").dataTable({
        "bSort": false,
        "iDisplayLength": 10,
        "bLengthChange": true
      });
    });
	  //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    // on mailbox pages
    $(function () {
      //Add text editor
      $("#compose-mailbox").wysihtml5();
    });
  </script>
  <script type="text/javascript">
  (function refresh_notification() {
    $.ajax({
      type : "GET",
      url: '<?php echo base_url();?>cms/count_notification', 
      async: false,
      dataType: "json",
      success: function(data) {
        $('.notifications-menu').empty();
        $('.notifications-menu').append('\
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">\
                  <i class="fa fa-bell-o"></i>\
                  <span class="label label-warning">'+data.notif_unread+'</span>\
                </a>');
        var list_string = icon = icon_color = "";

        // object icon 
        var icons = {
          default: "fa fa-bell-o",
          new_payment_conf: "fa fa-money",
          new_course_request: "fa fa-shopping-cart",
          new_contact_message: "fa fa-envelope",
          veritrans_notification: "fa fa-money",
          paypal_notification: "fa fa-money",
          open_city_request: "fa fa-globe",
          open_course_request: "fa fa-ticket",
          open_city_to_delete: "fa fa-minus-square",
          open_course_to_delete: "fa fa-minus-square",
          tutor_order_confirmation_finished: "fa fa-thumbs-o-up"
        }

        for(var i=0; i<data.notifications.length; i++){
          if(data.notifications[i].category in icons)
            icon = icons[data.notifications[i].category];
          else
            icon = icons.default;

          if(data.notifications[i].has_been_read=="true")
            icon_color = "text-green";
          else if(data.notifications[i].has_been_read=="false")
            icon_color = "text-red";

          list_string += '<li>\
                            <a href="<?php echo base_url();?>cms/show_notifications?id='+data.notifications[i].id+'">\
                              <i class="'+icon+' '+icon_color+'"></i> '+data.notifications[i].title+'\
                            </a>\
                          </li>';
        }

        $('.notifications-menu').append('\
                <ul class="dropdown-menu">\
                  <li class="header">You have '+data.notif_unread+' unread notifications</li>\
                  <li>\
                    <ul class="menu">'+list_string+'</ul>\
                  </li>\
                  <li class="footer"><a href="<?php echo base_url();?>cms/show_notifications">View all</a></li>\
                </ul>');
      },
      complete: function() {
      // Schedule the next request when the current one's complete
        setTimeout(refresh_notification, 60000);
      }
     });
  })
  ();
</script>
