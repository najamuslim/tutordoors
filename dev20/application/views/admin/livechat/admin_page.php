<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
			<h1>
				Live Chat
				<small>Refresh this page if there is new chat</small>  
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Live Chat</a></li>
				<li class="active"><a href="#">Admin</a></li>
			</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
			<div class="row">
			<?php 
			$cnt = 0;
			if($sessions<>false) 
				foreach($sessions->result() as $session){
					$box_array = array('primary', 'success', 'warning', 'danger');
					if($cnt % 4 == 0)
						$cnt = 0;
			?>
				<div class="col-md-3">
					<!-- DIRECT CHAT PRIMARY -->
          <div class="box box-<?php echo $box_array[$cnt]?> direct-chat direct-chat-<?php echo $box_array[$cnt]?>">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $session->ip_address?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" onclick="remove_sess('<?php echo $session->session_id?>')"><i class="fa fa-times"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages" id="chat-<?php echo $session->session_id?>">
              	<?php
	              	$get_chats = $this->lchat->get_chats_by_session_id($session->session_id);
	              	if($get_chats<>false)
	              		foreach($get_chats->result() as $chat){
	              ?>
                <!-- Admin's message to the left -->
                <?php if($chat->sender=="operator"){?>
                <div class="direct-chat-msg">
                  <div class='direct-chat-info clearfix'>
                    <span class='direct-chat-name pull-left'>You</span>
                    <span class='direct-chat-timestamp pull-right'><?php echo date_format(new DateTime($chat->timestamp), 'd M Y H:i') ?></span>
                  </div><!-- /.direct-chat-info -->
                  <div class="direct-chat-text">
                    <?php echo $chat->the_text ?>
                  </div><!-- /.direct-chat-text -->
                </div><!-- /.direct-chat-msg -->

                <?php } else if($chat->sender=="user"){?>
                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <div class='direct-chat-info clearfix'>
                    <span class='direct-chat-name pull-right'>User</span>
                    <span class='direct-chat-timestamp pull-left'><?php echo date_format(new DateTime($chat->timestamp), 'd M Y H:i') ?></span>
                  </div><!-- /.direct-chat-info -->
                  <div class="direct-chat-text">
                    <?php echo $chat->the_text ?>
                  </div><!-- /.direct-chat-text -->
                </div><!-- /.direct-chat-msg -->

                <?php } ?>
                <?php } ?>
              </div><!--/.direct-chat-messages-->
            </div><!-- /.box-body -->
            <div class="box-footer">
              <form id="form-chat-<?php echo $session->session_id?>">
                <div class="input-group">
                  <textarea name="text" id="text-user-<?php echo $session->session_id?>" rows="3" placeholder="Type a message ..."></textarea>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat" onclick="send('<?php echo $session->session_id?>')">Send</button>
                  </span>
                </div>
              </form>
            </div><!-- /.box-footer-->
          </div><!--/.direct-chat -->
				</div>
			<?php 
				$cnt++;
				} 
			?>
			</div>
		</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

<script>
	function remove_sess(id){
		$.ajax({
				type : "POST",
				url: '<?php echo base_url();?>lchat/remove/'+id,
				dataType: "json",
				success:function(data){
					if(data.status==false)
						alert('ono opo');
				},
				error: function(e){
	        alert('Error processing your request: '+e.responseText);
	      }
			});
	}

	function send(session_id){
		$.ajax({
			type : "POST",
			url: '<?php echo base_url();?>lchat/osend/'+session_id,
			data: $( "#form-chat-"+session_id ).serialize(),
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
					$('#chat-'+session_id).append(msg);
					$('#text-user-'+session_id).val('');
				}
				else
					alert('ono opo');
			},
			error: function(e){
        alert('Error processing your request: '+e.responseText);
      }
		});
	}

	(function refresh_chat() {
	    $.ajax({
	      type : "GET",
	      url: '<?php echo base_url();?>lchat/get/uchat',
	      async: false,
	      dataType: "json",
	      success: function(data) {
	      	for(var i=0; i<data.chats.length; i++){
	      		var msg = '<div class="direct-chat-msg right">\
		              <div class="direct-chat-info clearfix">\
		                <span class="direct-chat-name pull-right">User</span>\
		                <span class="direct-chat-timestamp pull-left">'+data.chats[i].timestamp+'</span>\
		              </div>\
		              <div class="direct-chat-text">\
		                '+data.chats[i].message+'\
		              </div>\
		            </div>';
						$('#chat-'+data.chats[i].session_id).append(msg);
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
