    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
      	<div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="form-box wizard-user-registration">
              <div class="grid">
                <!-- general -->
                <div class="element-item wizard-register">
                  <form id="form-register">
                    <input type="hidden" name="level" value="student">
                    <input type="hidden" name="fn" value="<?php echo $logged_user['first_name'] ?>">
                    <input type="hidden" name="ln" value="<?php echo $logged_user['last_name'] ?>">
                    <input type="hidden" name="email" value="<?php echo $logged_user['email'] ?>">
                    <img src="<?php echo base_url('assets/uploads/'.$image_user_filename)?>">
                    <h4><?php echo $this->lang->line('hi')?> <?php echo $logged_user['name'] ?>, <?php echo $this->lang->line('welcome_in_tutordoors') ?></h4>
                    <p><?php echo $this->lang->line('please_fill_to_complete_registration') ?></p>
                    <p class="wizard-register-question"><?php echo $this->lang->line('where_is_teaching_area_in_general') ?>?</p>
                    <div class="form-body" style="padding-top: 0px;">
                      <div class="row">
                        <div class="col-md-6">
                          <select name="province" id="uid-province" class="form-control" required>
                            <option value="">-- <?php echo $this->lang->line('select_province') ?> *</option>
                            <?php if($provinces<>false) {
                                foreach($provinces->result() as $prov){?>
                            <option value="<?php echo $prov->province_id; ?>"><?php echo $prov->province_name; ?></option>
                            <?php }} ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <select name="city" id="uid-city" class="form-control" required>
                            <option value="">-- <?php echo $this->lang->line('select_city') ?> *</option>
                          </select>
                        </div>
                      </div> <!-- /.row -->
                    
                      <!-- <p class="wizard-register-question">Gunakan email dan password dibawah ini jika login tanpa menggunakan media sosial</p>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="ocky.harli@gmail.com">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Ketik Ulang Password</label>
                            <input type="password" class="form-control">
                          </div>
                        </div>
                      </div> --> <!-- /.row -->
                    </div> <!-- /.form-body -->
                    <div class="footer">
                      <button type="button" id="btn-register" class="btn-style" style="float:right"><?php echo $this->lang->line('submit') ?></button>
                      <div class="overlay" id="loading-register" style="margin-top: 10px; float:right; display: none">
                          <i class="fa fa-refresh fa-spin fa-2x"></i>
                      </div>
                      <p class="message-response" id="message-register" style="float: right"></p>
                    </div> <!-- /.footer -->
                  </form>
                </div> <!-- /.element-item -->
                <!-- personal-data -->
                <div class="element-item wizard-personal-data"> 
                  <form id="form-personal-data">
                    <input type="hidden" id="user-id-personal-data" name="user-id-personal-data">
                    <input type="hidden" name="user_photo_id" value="<?php if(isset($image_user_id)) echo $image_user_id ?>">
                    <h4>Lengkapi data pribadi</h4>
                    <p class="wizard-register-question">Data pribadi anda akan ditampilkan pada halaman pencarian tutor dan juga untuk proses administrasi di dalam sistem Tutordoors.</p>
                    <div class="form-body" style="padding-top: 0px;">
                      <div class="row">
                        <div class="col-md-6">
                          <label><?php echo $this->lang->line('sex') ?><span class="label-required">*</span></label>
                          <div class="form-group" style="text-align: left">
                            <div class="radio">
                              <label>
                                <input type="radio" name="sex" value="male" required> <?php echo $this->lang->line('sex_male') ?>
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="sex" value="female" required> <?php echo $this->lang->line('sex_female') ?>
                              </label>
                            </div>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('birth_place') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="birth-place" required>
                          </div>
                          <label><?php echo $this->lang->line('birth_date') ?><span class="label-required">*</span></label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control" id="default-datepicker" name="birth-date" required>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('religion') ?><span class="label-required">*</span></label>
                            <select name="religion" class="form-control">
                              <option value="Islam"><?php echo $this->lang->line('religion_islam') ?></option>
                              <option value="Kristen"><?php echo $this->lang->line('religion_christian') ?></option>
                              <option value="Katholik"><?php echo $this->lang->line('religion_catholic') ?></option>
                              <option value="Hindu"><?php echo $this->lang->line('religion_hindu') ?></option>
                              <option value="Budha"><?php echo $this->lang->line('religion_buddha') ?></option>
                              <option value="Konghucu"><?php echo $this->lang->line('religion_khonghucu') ?></option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('school_where') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="where_student_school" placeholder="<?php echo $this->lang->line('school_where_example') ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><?php echo $this->lang->line('address_on_national_card') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="address-ktp" required>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('phone') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="phone-1" required>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('phone_other') ?></label>
                            <input type="text" class="form-control" name="phone-2">
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('about_me') ?><span class="label-required">*</span></label>
                            <textarea class="form-control" name="about-me" required></textarea>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('hobby') ?></label>
                            <input type="text" class="form-control" name="hobby">
                          </div>
                        </div>
                      </div> <!-- /.row -->
                      <p>Pastikan data yang diinput adalah benar. Anda masih bisa merubah data pribadi di halaman profil pengguna.</p>
                    </div> <!-- /.form-body -->
                    <div class="footer">
                      <button type="button" id="btn-personal-data" class="btn-style" style="float:right"><?php echo $this->lang->line('save') ?></button>
                      <div class="overlay" id="loading-personal-data" style="margin-top: 10px; float:right; display: none">
                          <i class="fa fa-refresh fa-spin fa-2x"></i>
                      </div>
                      <p class="message-response" id="message-personal-data" style="float: right"></p>
                    </div> <!-- /.footer -->
                  </form>
                </div> <!-- /.element-item -->
                <!-- finish -->
                <div class="element-item wizard-finish">
                  <h4><?php echo $this->lang->line('wizard_finish_thanks_for_submit') ?></h4>
                  <a href="<?php echo base_url('my_account')?>">Go to Dashboard...</a>
                </div>
                <!-- /.finish -->
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
        </div>
      </div>
      <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->
<script src="<?php echo IKNOW_DIR;?>/js/isotope.pkgd.js"></script>
<script src="<?php echo IKNOW_DIR;?>/js/jstree.min.js"></script>
<script>

var selected_area_array = [];

var selected_program_array = [];

$(document).ready(function(){
  // just prepare for document on ready state

  $("#uid-province").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'location/get_cities_by_province/'+$("#uid-province").val(),
      // data: "id="+$("#ship-city").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#uid-city").find('option').remove().end();
          for(var i=0; i<data.cities.length;i++)
            $("#uid-city").append($("<option></option>").val(data.cities[i].id).html(data.cities[i].name));
        }            
      }
    });
  });

  $('.grid').isotope({ 
    itemSelector: '.element-item',
    filter: '.wizard-register'
  });

  $('#btn-register').on( 'click', function() {
    $('#loading-register').toggle();
    $.ajax({
      type : "POST",
      async: false,
      url: base_url+'wizard/user/add',
      data: $('#form-register').serialize(),
      dataType: "json",
      success:function(data){
        if(data.status=="204"){
          $('#message-register').empty();
          $('#message-register').append(data.message);
        } 
        else{
          $('.grid').isotope({ 
            itemSelector: '.element-item',
            filter: '.wizard-personal-data'
          });
          $('#user-id-personal-data').val(data.user_id);
        }
      }
    });
    $('#loading-register').toggle();
  });

  $('#btn-personal-data').on( 'click', function() {
    $('#loading-personal-data').toggle();
    $.ajax({
      type : "POST",
      async: false,
      url: base_url+'wizard/user/add_personal/student',
      data: $('#form-personal-data').serialize(),
      dataType: "json",
      success:function(data){
        if(data.status=="204"){
          $('#message-personal-data').empty();
          $('#message-personal-data').append(data.message);
        } 
        else{
          $('.grid').isotope({ 
            itemSelector: '.element-item',
            filter: '.wizard-finish'
          });
        }
      }
    });
    $('#loading-personal-data').toggle();
  });

});

</script>