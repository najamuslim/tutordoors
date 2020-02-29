	<!--BANNER START-->
    <!-- <div class="page-heading">
    	<div class="container">
        <h2><?php echo $this->lang->line('signin') ?></h2>
        <p><?php echo $this->lang->line('login_or_register') ?></p>
      </div>
    </div> -->
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="buttons">
            <!-- <a href="<?php echo base_url('auth/social_media/facebook/student') ?>"><button class="btn1 login-btn"><i class="fa fa-facebook"></i>Sign up with Facebook</button></a> -->
            
            <a href="<?php echo base_url('auth/social_media/google/student') ?>"><button class="btn2 login-btn"><i class="fa fa-google-plus"></i>Sign up with Google</button></a>
            
            <!-- <a href="<?php echo base_url('auth/social_media/linkedin/student') ?>"><button class="btn4 login-btn"><i class="fa fa-linkedin"></i>Sign up with Linkedin</button></a> -->
          	 
          </div>
      	<div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
          	<div class="form-box">
              <form action="#" id="form-register">
              	<div class="form-body">
                  <fieldset>
                    <input type="hidden" name="level" value="student">
                    <!-- <legend>First time here? Sign up now!</legend> -->
                    <legend><?php echo $this->lang->line('register_asking') ?></legend>
                    <div class="row">
                    	<div class="col-md-6">
                      	<label><?php echo $this->lang->line('name_first') ?></label>
                   			<input type="text" name="fn" placeholder="First Name" class="form-control" required>
                      </div>
                      <div class="col-md-6">
                      	<label><?php echo $this->lang->line('name_last') ?></label>
                   			<input type="text" name="ln" placeholder="Last Name" class="form-control">
                      </div>
                    </div>
                    
                    <label><?php echo $this->lang->line('email') ?></label>
                    <input type="text" name="email" class="form-control" required>
                    
                    <label><?php echo $this->lang->line('password') ?></label>
                    <input type="password" name="pass" class="form-control" required>
                    
                    <label><?php echo $this->lang->line('password_retype') ?></label>
                    <input type="password" name="pass_re" class="form-control" required>
                    
                    <button type="button" id="btn-register" class="btn-style" style="margin: 10px 0;"><?php echo $this->lang->line('register') ?></button>
                    <div class="overlay" style="display:none" id="loading-sign-up">
                        <i class="fa fa-refresh fa-spin fa-2x"></i>
                    </div>
                                
                    <div id="message-register"></div>
                  </fieldset>
                </div>
                <div class="footer">
                  <?php echo $this->lang->line('order_pre_submit_1') ?> <a target="_blank" href="<?php echo base_url('content/page/kebijakan-privasi')?>"><?php echo $this->lang->line('privacy_policy') ?></a> <?php echo $this->lang->line('order_pre_submit_and') ?> <a target="_blank" href="<?php echo base_url('content/page/syarat-dan-ketentuan')?>"><?php echo $this->lang->line('term_conditions') ?></a> <?php echo $this->lang->line('order_pre_submit_2') ?>
                  <!-- <p>By Registering, You Accept Terms &amp; Conditions</p> -->
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-3"></div>
        </div>
      </div>
        <!--FOLLOW US SECTION START-->
      <!-- <section class="follow-us">
      	<div class="container">
        	<div class="row">
            <div class="col-md-4">
            	<div class="follow">
              	<a href="#">
                  <i class="fa fa-facebook"></i>
                  <div class="text">
                    <h4>Follow us on Facebook</h4>
                    <p>Faucibus toroot menuts</p>
                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-4">
            	<div class="follow">
              	<a href="#">
                  <i class="fa fa-google"></i>
                  <div class="text">
                      <h4>Follow us on Google Plus</h4>
                      <p>Faucibus toroot menuts</p>
                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-4">
            	<div class="follow">
              	<a href="#">
                  <i class="fa fa-linkedin"></i>
                  <div class="text">
                      <h4>Follow us on Linkedin</h4>
                      <p>Faucibus toroot menuts</p>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section> -->
        <!--FOLLOW US SECTION END-->
    </div>
    <!--CONTANT END-->

<script>
$(document).ready(function(){
  // just prepare for document on ready state

  $('#btn-register').on('click', function() {
    $('#loading-sign-up').toggle();
    $.ajax({
      type : "POST",
      async: false,
      url: base_url+'users/user_add',
      data: $('#form-register').serialize(),
      dataType: "json",
      success:function(data){
        if(data.status=="204"){
          $('#message-register').empty();
          $('#message-register').append(data.message);
        }
          
        else
          window.location.href = base_url+'users/edit_profile';
      }
    });
    $('#loading-sign-up').toggle();
  });
});

</script>