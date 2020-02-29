<?php
	define('ADMIN_LTE_DIR', base_url('assets/themes/adminlte/'));
	define('GENERAL_JS_DIR', base_url('assets/themes/js/'));
	define('GENERAL_CSS_DIR', base_url('assets/themes/css/'));
  define('UPLOAD_IMAGE_DIR', base_url('assets/uploads/'));
  define('WACKY_LOGIN_PAGES_DIR', base_url('assets/themes/wackylogin/'));
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Live Chat - Tutordoors.com</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo WACKY_LOGIN_PAGES_DIR;?>/img/icon.ico">
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo ADMIN_LTE_DIR;?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
		<link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>/font-awesome/css/font-awesome.min.css" />
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

		<body class="align">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<!-- DIRECT CHAT PRIMARY -->
					<?php 
					$box_array = array('primary', 'success', 'warning', 'danger'); 
					$selected = array_rand($box_array, 1);
					?>
		      <div class="box box-<?php echo $box_array[$selected]; ?> direct-chat direct-chat-<?php echo $box_array[$selected]; ?>" style="margin-top: 50px">
		        <div class="box-header with-border">
		          <h3 class="box-title">Live Chat</h3>
		        </div><!-- /.box-header -->
		        <div class="box-body">
		          <!-- Conversations are loaded here -->
		          <div class="direct-chat-messages" style="height: 400px">
		            <!-- message's contents -->
		            <!-- Message to the right -->
	                <div class="direct-chat-msg right">
	                  <div class='direct-chat-info clearfix'>
	                    <span class='direct-chat-name pull-right'>Operator</span>
	                    <span class='direct-chat-timestamp pull-left'><?php echo date('d M Y H:i') ?></span>
	                  </div><!-- /.direct-chat-info -->
	                  <div class="direct-chat-text">
	                    <?php echo $this->lang->line('greetings_start_discuss') ?>
	                  </div><!-- /.direct-chat-text -->
	                </div><!-- /.direct-chat-msg -->
		          </div><!--/.direct-chat-messages-->
		        </div><!-- /.box-body -->
		        <div class="box-footer">
		          <form id="form-chat">
		            <div class="input-group">
		              <!-- <input type="text" name="message" placeholder="Type Message ..." class="form-control"/> -->
		              <textarea name="text" id="text-user" cols="40" rows="3" placeholder="Type a message ..."></textarea>
		              <span class="input-group-btn">
		                <button type="button" id="send" class="btn btn-primary btn-flat">Send</button>
		              </span>
		            </div>
		          </form>
		        </div><!-- /.box-footer-->
		      </div><!--/.direct-chat -->
				</div>
				<div class="col-md-4"></div>
			</div>


		
	<script src="<?php echo ADMIN_LTE_DIR;?>/plugins/jQuery/jQuery-2.1.3.min.js"></script>
	<script>
		$('#send').on('click', function() {
			$.ajax({
				type : "POST",
				url: '<?php echo base_url();?>lchat/usend/<?php echo $session_id;?>',
				data: $( "#form-chat" ).serialize(),
				dataType: "json",
				success:function(data){
					if(data.status==true){
						var msg = '<div class="direct-chat-msg">\
		              <div class="direct-chat-info clearfix">\
		                <span class="direct-chat-name pull-left">You</span>\
		                <span class="direct-chat-timestamp pull-right">'+data.timestamp+'</span>\
		              </div>\
		              <div class="direct-chat-text">\
		                '+data.message+'\
		              </div>\
		            </div>';
						$('.direct-chat-messages').append(msg);
						$('#text-user').val('');
					}
					else
						alert('ono opo');
				},
				error: function(e){
	        alert('Error processing your request: '+e.responseText);
	      }
			});
		});

		(function refresh_chat() {
	    $.ajax({
	      type : "GET",
	      url: '<?php echo base_url();?>lchat/get/ochat/<?php echo $session_id;?>',
	      async: false,
	      dataType: "json",
	      success: function(data) {
	      	for(var i=0; i<data.chats.length; i++){
	      		var msg = '<div class="direct-chat-msg right">\
		              <div class="direct-chat-info clearfix">\
		                <span class="direct-chat-name pull-right">Operator</span>\
		                <span class="direct-chat-timestamp pull-left">'+data.chats[i].timestamp+'</span>\
		              </div>\
		              <div class="direct-chat-text">\
		                '+data.chats[i].message+'\
		              </div>\
		            </div>';
						$('.direct-chat-messages').append(msg);
	      	}
	      },
	      complete: function() {
	      // Schedule the next request when the current one's complete
	        setTimeout(refresh_chat, 5000);
	      }
	     });
	  })
	  ();
	</script>
</body>
</html>
