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
          <!-- <a href="<?php echo base_url('auth/social_media/facebook') ?>"><button class="btn1 login-btn"><i class="fa fa-facebook"></i>Login with Facebook</button></a> -->
            
          <a href="<?php echo base_url('auth/social_media/google') ?>"><button class="btn2 login-btn"><i class="fa fa-google-plus"></i>Login with Google</button></a>
          
          <!-- <a href="<?php echo base_url('auth/social_media/linkedin') ?>"><button class="btn4 login-btn"><i class="fa fa-linkedin"></i>Login with Linkedin</button></a> -->
           
        </div>
      	<div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
          	<div class="form-box">
              <form action="#" id="form-login">
                <div class="form-body">
                <fieldset>
                <legend><?php echo $this->lang->line('login_below') ?></legend>
                <label><?php echo $this->lang->line('email') ?></label>
                <input type="text" name="email" placeholder="<?php echo $this->lang->line('email_login_hint') ?>" class="form-control">
                <label><?php echo $this->lang->line('password') ?></label>
                <input type="password" name="password" class="form-control">                        
                
                <button type="button" id="btn-login" class="btn-style" style="margin: 10px 0;"><?php echo $this->lang->line('signin') ?></button>
                <div class="overlay" style="display:none" id="loading-sign-in">
                  <i class="fa fa-refresh fa-spin fa-2x"></i>
                </div>
                <div id="message-login"></div>
                </fieldset>
                </div>
                <div class="footer">
                	<p><a href="<?php echo base_url('users/forgot_password');?>"><?php echo $this->lang->line('password_forgot') ?> ?</a></p>
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
  $('#form-login').keypress(function (e) {
    if (e.which == 13) {
      submit_login();
      return false;    //<---- Add this line
    }
  });

  $('#btn-login').on('click', function() {
    submit_login();
  });

  function submit_login(){
    $('#loading-sign-in').toggle();
    $.ajax({ 
      type : "POST",
      url: base_url+'users/do_login',
      data: $( "#form-login" ).serialize(),
      dataType: "json",
      success:function(data){
        console.log(data);
        if(data.status == "200"){
          if(data.user_level=="teacher")
            window.location.href = base_url+'my_account';
          else if(data.user_level=="student"){
            if(prev_url.indexOf("teacher/profile") == -1)
              window.location.href = base_url+'my_account';
            else
              window.history.back();
          }
        }       
        else if(data.status == "204"){
          $('#message-login').empty();
          $('#message-login').append('Username and password not matched.');
        }
      }
    });
    $('#loading-sign-in').toggle();
  }
</script>