    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
      	<div class="row">
          <div class="col-md-6">
          	<div class="form-box">
              <form action="<?php echo base_url('users/request_reset_password')?>" id="form-login" method="POST">
                <div class="form-body">
                <fieldset>
                <legend><?php echo $this->lang->line('reset_password_input_email_here') ?></legend>
                <label><?php echo $this->lang->line('email') ?></label>
                <input type="text" name="email" placeholder="<?php echo $this->lang->line('email_login_hint') ?>" class="form-control">
                <button type="submit" id="btn-login" class="btn-style" style="margin-top: 10px;"><?php echo $this->lang->line('reset') ?></button>
                <div id="message-login"></div>
                </fieldset>
                </div>
                <div class="footer">
                	<p><?php echo $message ?></p>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6"></div>
        </div>
      </div>
        <!--FOLLOW US SECTION START-->
      <section class="follow-us">
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
      </section>
        <!--FOLLOW US SECTION END-->
    </div>
    <!--CONTANT END-->