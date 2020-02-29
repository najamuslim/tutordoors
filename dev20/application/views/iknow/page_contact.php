    <!--BANNER START-->
    <div class="page-heading">
    	<div class="container">
            <h2><?php echo $this->lang->line('contact_tutordoors') ?></h2>
        </div>
    </div>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        <div class="row">
          <div class="col-md-7">
            <form method="POST" action="<?php echo base_url('frontpage/submit_question')?>">
              <div class="form-box">
                <!-- <input type="hidden" name="selected-course" id="selected-course"> -->
                  <div class="form-body">
                    <fieldset>
                      <?php 
                      $get_phone = $this->Content_m->get_option_by_param('company_phone');
                      if($this->session->userdata('language')=="id") {
                      ?>
                      <h5>Apabila terdapat pertanyaan seputar Tutordoors.com, hubungi kami di <?php echo $get_phone->parameter_value ?> atau isi formulir di bawah ini. Anda juga dapat melihat daftar pertanyaan yang sering ditanyakan di halaman <a href="<?php echo base_url('content/faq')?>">Frequently Asked Questions</a>.</h5>
                      <?php } else { ?>
                      <h5>If you have any questions about Tutordoors.com, do not hesitate to contact us at <?php echo $get_phone->parameter_value ?> or submit inquiry in the form below. You may read the <a href="<?php echo base_url('content/faq')?>">Frequently Asked Questions</a>.</h5>
                      <?php } ?>
                      <div class="row" style="margin-top:30px">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label><?php echo $this->lang->line('name') ?></label>
                              <input type="text" name="name" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <label><?php echo $this->lang->line('email') ?></label>
                              <input type="email" name="email" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <!-- start form -->
                          <label><?php echo $this->lang->line('category') ?></label>
                          <div class="form-group">
                            <select name="category" class="form-control" required>
                              <option value="service"><?php echo $this->lang->line('service') ?></option>
                              <option value="critic"><?php echo $this->lang->line('critic') ?></option>
                              <option value="feature_complaint"><?php echo $this->lang->line('feature_complaint') ?></option>
                              <option value="payment_or_transaction"><?php echo $this->lang->line('payment_or_transaction') ?></option>
                              <option value="other_question"><?php echo $this->lang->line('other_question') ?></option>
                            </select>
                          </div>
                          <div class="form-group">
                              <label><?php echo $this->lang->line('phone') ?></label>
                              <input type="text" name="phone" class="form-control">
                          </div>
                          <!-- end form -->
                        </div> <!-- ./col -->
                        <div class="col-md-12">
                          <div class="form-group">
                              <label><?php echo $this->lang->line('subject') ?></label>
                              <input type="text" name="subject" class="form-control" required>
                          </div>
                          <label><?php echo $this->lang->line('question_or_message') ?></label>
                          <textarea name="message" class="form-control" rows="8" required></textarea>
                        </div> <!-- ./col -->
                      </div>
                    </fieldset>
                  </div>
                </div> <!-- form box end -->
                
                <!-- form course end -->
                <div class="footer">
                  <div class="row">
                    <button type="submit" class="btn-style pull-right"><?php echo $this->lang->line('submit') ?></button>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-5 summary-box">
              <div class="form-box">
                <div class="form-body">
                  <h2>Our Office</h2>
                  <?php 
                      $get_phone = $this->Content_m->get_option_by_param('company_phone');
                      if($this->session->userdata('language')=="id") {
                      ?>
                      <h4>Jam kerja 8:00 - 16:00</h4>
                      <h5>Di luar jam kerja tersebut, Anda dapat menghubungi kami melalui e-mail atau formulir yang tersedia di halaman ini. Kami akan segera menghubungi Anda!</h5>
                      <?php } else { ?>
                      <h4>Working hour 8:00 - 16.00</h4>
                      <h5>Outside working hours, you can contact us using email or submit inquiry in the form below. We will call you soon!</h5>
                      <?php } ?>
                  <div class="row">
                  <?php 
                  $get_line = $this->Content_m->get_option_by_param('company_socmed_line_name');
                  $get_email = $this->Content_m->get_option_by_param('company_email');
                  ?>
                      <div class="summary-separator"></div>
                      <div class="summary" style="position:relative">
                        <span class="field"><?php echo $this->lang->line('phone')?>:</span>
                        <span class="text"><?php echo $get_phone->parameter_value ?></span>
                      </div>
                      <div class="summary-separator"></div>
                      <div class="summary" style="position:relative">
                        <span class="field">Email:</span>
                        <span class="text"><?php echo $get_email->parameter_value ?></span>
                      </div>
                      <div class="summary-separator"></div>
                      <div class="summary" style="position:relative">
                        <span class="field">Line:</span>
                        <span class="text"><?php echo $get_line->parameter_value ?></span>
                      </div>
                      <div class="summary-separator"></div>
                  </div>
                </div>
              </div>
              <div class="form-box">
                <div class="form-body">
                  <h2><?php echo $this->lang->line('find_us') ?></h2>
                  <div style="text-decoration:none; overflow:hidden; height:500px; width:500px; max-width:100%;"><div id="embedded-map-display" style="height:100%; width:100%;max-width:100%;"><iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=Senayan+Trade+Center,+Gelora,+Central+Jakarta+City,+Special+Capital+Region+of+Jakarta,+Indonesia&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU"></iframe></div><a class="google-code" href="https://www.hostingreviews.website/compare/hostgator-vs-godaddy" id="get-data-for-embed-map">hostgator vs godaddy</a><style>#embedded-map-display img{max-width:none!important;background:none!important;font-size: inherit;}</style></div><script src="https://www.hostingreviews.website/google-maps-authorization.js?id=8624d6fa-31d1-e346-4c08-c7abb02df7c1&c=google-code&u=1469614291" defer="defer" async="async"></script>
                </div>
                <div class="footer">
                  STC Senayan lt. 2 no. 109 Jl. Asia Afrika Senayan, Central Jakarta, 10270
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
      </div>
    <!--CONTANT END-->