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
                    <input type="hidden" name="level" value="teacher">
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
                          <div class="form-group">
                            <label><?php echo $this->lang->line('national_id_number') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="ktp" maxlength="30" required>
                          </div>
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
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><?php echo $this->lang->line('address_on_national_card') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="address-ktp" required>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('address_different_national_card') ?></label>
                            <input type="text" class="form-control" name="address-domicile">
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('phone') ?><span class="label-required">*</span></label>
                            <input type="text" class="form-control" name="phone-1" required>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('phone_other') ?></label>
                            <input type="text" class="form-control" name="phone-2">
                          </div>
                        </div>
                      </div> <!-- /.row -->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><?php echo $this->lang->line('about_me') ?><span class="label-required">*</span></label>
                            <textarea class="form-control" name="about-me" required></textarea>
                          </div>
                          <div class="form-group">    
                            <label><?php echo $this->lang->line('teach_experience') ?></label>
                            <textarea class="form-control" name="teach-experience"></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><?php echo $this->lang->line('skill_special') ?></label>
                            <textarea class="form-control" name="skill"></textarea>
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('toefl_score') ?></label>
                            <input type="text" class="form-control" name="toefl">
                          </div>
                          <div class="form-group">
                            <label><?php echo $this->lang->line('hobby') ?></label>
                            <input type="text" class="form-control" name="hobby">
                          </div>
                          <div class="form-group">
                            <input type="hidden" name="toefl-file-id" id="toefl-file-id">
                            <span class="btn btn-success fileinput-button">
                              <i class="glyphicon glyphicon-plus"></i>
                              <span>Upload TOEFL Certificate</span>
                              <!-- The file input field used as target for the file upload widget -->
                              <input id="fileupload" type="file" name="userfile">
                            </span>
                            <br>
                            <span>Allowed types: .jpg, .png, .gif, .jpeg</span>
                            <br>
                            <span>Max size: 1 MB</span>
                            <br>
                            <br>
                            <!-- The global progress bar -->
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <!-- The container for the uploaded files -->
                            <div id="files" class="files"></div>
                          </div>
                        </div>
                      </div>
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
                <!-- education-data -->
                <div class="element-item wizard-education-data">
                  <form id="form-education-data">
                    <input type="hidden" id="user-id-education-data" name="user-id-education-data">
                    <h4><?php echo $this->lang->line('fill_in_latest_education') ?></h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $this->lang->line('education') ?><span class="label-required">*</span></label>
                          <select name="degree" id="degree" class="form-control" required>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1" selected>S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label><?php echo $this->lang->line('university') ?><span class="label-required">*</span></label>
                          <input type="text" class="form-control" name="institution" required>
                        </div>
                        <div class="form-group">    
                          <label><?php echo $this->lang->line('major') ?><span class="label-required">*</span></label>
                          <input type="text" class="form-control" name="major" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $this->lang->line('grade_score') ?><span class="label-required">*</span></label>
                          <input type="text" class="form-control" name="grade_score" placeholder="Ex: 3.04" required>
                        </div>
                        <div class="form-group">
                          <label><?php echo $this->lang->line('college_year_in') ?></label>
                          <input type="text" class="form-control" name="year_in" maxlength="4" required>
                        </div>
                        <div class="form-group">
                          <label><?php echo $this->lang->line('college_year_out') ?></label>
                          <input type="text" class="form-control" name="year_out" maxlength="4" required>
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="ijasah-file-id" id="ijasah-file-id">
                          <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span><?php echo $this->lang->line('upload_college_certificate') ?></span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="ijasah" type="file" name="ijasah">
                          </span>
                          <br>
                          <span>Allowed types: .jpg, .png, .gif, .jpeg</span>
                          <br>
                          <span>Max size: 1 MB</span>
                          <br>
                          <br>
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="transkrip-file-id" id="transkrip-file-id">
                          <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span><?php echo $this->lang->line('upload_transcript') ?></span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="transkrip" type="file" name="transkrip">
                          </span>
                          <br>
                          <span>Allowed types: .jpg, .png, .gif, .jpeg</span>
                          <br>
                          <span>Max size: 1 MB</span>
                          <br>
                          <br>
                          <!-- The global progress bar -->
                          <div id="progress-ijasah-transkrip" class="progress">
                              <div class="progress-bar progress-bar-success"></div>
                          </div>
                          <!-- The container for the uploaded files -->
                          <div id="files-ijasah-transkrip" class="files"></div>
                        </div>
                      </div>
                    </div>
                    <div class="footer">
                      <button type="button" id="btn-education-data" class="btn-style" style="float:right"><?php echo $this->lang->line('save') ?></button>
                      <div class="overlay" id="loading-education-data" style="margin-top: 10px; float:right; display: none">
                          <i class="fa fa-refresh fa-spin fa-2x"></i>
                      </div>
                      <p class="message-response" id="message-education-data" style="float: right"></p>
                    </div> <!-- /.footer -->
                  </form>
                </div> <!-- /.element-item -->
                <!-- area-mengajar -->
                <div class="element-item wizard-area-mengajar">
                  <form id="form-area-mengajar">
                    <input type="hidden" id="user-id-area-mengajar" name="user-id-area-mengajar">
                    <h4><?php echo $this->lang->line('define_your_area_mengajar') ?></h4>
                    <p class="wizard-register-question"><?php echo $this->lang->line('you_can_choose_more_than_one_area_mengajar') ?></p>
                    <div class="row tree-options">
                    <?php 
                      $tree_string = '';
                      $prov = $provinces->first_row();
                      $cnt = 1;
                      $total_col_area_mengajar = 2;
                      $total_col_area_mengajar_md = 12 / $total_col_area_mengajar;
                      for($i=0; $i < $total_col_area_mengajar; $i++) { // dibagi 2 column
                        $tree_string .= '<div class="col-md-'.$total_col_area_mengajar_md.'">';
                        $tree_string .= '<div id="tree-prov-'.$i.'">';
                        $tree_string .= '<ul>'; // ul root
                        for($j = 0; $j < $provinces->num_rows() / $total_col_area_mengajar; $j++){
                          $tree_string .= '<li id="'.$prov->province_id.'">'.$prov->province_name;
                          $get_city = $this->Location_m->get_city(array('c.province_id'=>$prov->province_id));
                          if($get_city<>false){
                            $tree_string .= '<ul>'; // ul child
                            foreach($get_city->result() as $city){
                              $tree_string .= '<li id="'.$city->city_id.'">'.$city->city_name.'</li>';
                            }
                            $tree_string .= '</ul>';
                          }
                          $tree_string .= '</li>';

                          $cnt++;
                          if($cnt <= $provinces->num_rows())
                            $prov = $provinces->next_row();
                          else
                            break;
                        }
                        
                        $tree_string .= '</ul>';
                        $tree_string .= '</div>'; // tree node
                        $tree_string .= '</div>'; // col node                      
                      } 

                      echo $tree_string;
                    ?>
                    </div>
                    <div class="footer">
                      <button type="button" id="btn-area-mengajar" class="btn-style" style="float:right"><?php echo $this->lang->line('save') ?></button>
                      <div class="overlay" id="loading-area-mengajar" style="margin-top: 10px; float:right; display: none">
                          <i class="fa fa-refresh fa-spin fa-2x"></i>
                      </div>
                      <p class="message-response" id="message-area-mengajar" style="float: right"></p>
                    </div> <!-- /.footer -->
                  </form>
                </div> <!-- /.element-item -->
                <!-- /.area-mengajar -->
                <!-- program-kursus -->
                <div class="element-item wizard-program-kursus">
                  <form id="form-program-kursus">
                    <input type="hidden" id="user-id-program-kursus" name="user-id-program-kursus">
                    <h4>Tentukan program kursus anda</h4>
                    <p class="wizard-register-question">Anda dapat memilih lebih dari satu program kursus. Pilihlah program kursus sesuai dengan keahlian.</p>
                    <div class="row tree-options">
                    <?php 
                      $tree_string = '';
                      $prog = $programs->first_row();
                      $cnt = 1;
                      $total_col_program_kursus = 2;
                      $total_col_program_kursus_md = 12 / $total_col_program_kursus;
                      for($i=0; $i < $total_col_program_kursus; $i++) { // dibagi 2 column
                        $tree_string .= '<div class="col-md-'.$total_col_program_kursus_md.'">';
                        $tree_string .= '<div id="tree-program-'.$i.'">';
                        $tree_string .= '<ul>'; // ul root
                        for($j = 0; $j < $programs->num_rows() / $total_col_program_kursus; $j++){
                          $tree_string .= '<li id="'.$prog->id.'">'.$prog->category;
                          $get_sub_program = $this->Content_m->get_categories_under_root($prog->id);
                          if($get_sub_program<>false){
                            $tree_string .= '<ul>'; // ul child
                            foreach($get_sub_program->result() as $sub){
                              $tree_string .= '<li id="'.$sub->id.'">'.$sub->category.'</li>';
                            }
                            $tree_string .= '</ul>';
                          }
                          $tree_string .= '</li>';

                          $cnt++;
                          if($cnt <= $programs->num_rows())
                            $prog = $programs->next_row();
                          else
                            break;
                        }
                        
                        $tree_string .= '</ul>';
                        $tree_string .= '</div>'; // tree node
                        $tree_string .= '</div>'; // col node                      
                      } 

                      echo $tree_string;
                    ?>
                    </div>
                    <p class="wizard-register-question">Hari apa saja anda bersedia untuk mengajar?</p>
                    <div class="form-body" style="padding-top: 0px;">
                      <div class="row tree-options">
                        <div class="col-md-6">
                          <div class="form-group">
                            <?php for($i=1; $i<=4; $i++) {?>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="days-course" name="days[]" value="0<?php echo $i?>"> <?php echo $this->lang->line('day_0'.$i) ?>
                              </label>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <?php for($i=5; $i<=7; $i++) {?>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="days-course" name="days[]" value="0<?php echo $i?>"> <?php echo $this->lang->line('day_0'.$i) ?>
                              </label>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="wizard-register-question">Berapa lama sesi anda bersedia untuk mengajar?</p>
                    <div class="form-body" style="padding-top: 0px;">
                      <div class="row tree-options">
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="session-course" name="session[]" value="1.5"> 1.5 <?php echo $this->lang->line('hour') ?>
                              </label>
                            </div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="session-course" name="session[]" value="2"> 2 <?php echo $this->lang->line('hour') ?>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="session-course" name="session[]" value="2.5"> 2.5 <?php echo $this->lang->line('hour') ?>
                              </label>
                            </div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="session-course" name="session[]" value="3"> 3 <?php echo $this->lang->line('hour') ?>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!-- /.form-body -->
                    <div class="footer">
                      <button type="button" id="btn-program-kursus" class="btn-style" style="float:right"><?php echo $this->lang->line('save') ?></button>
                      <div class="overlay" id="loading-program-kursus" style="margin-top: 10px; float:right; display: none">
                          <i class="fa fa-refresh fa-spin fa-2x"></i>
                      </div>
                      <p class="message-response" id="message-program-kursus" style="float: right"></p>
                    </div> <!-- /.footer -->
                  </form>
                </div> <!-- /.element-item -->
                <!-- /.program-kursus -->
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
            filter: '.wizard-area-mengajar'
          });
          $('#user-id-personal-data').val(data.user_id);
          $('#user-id-area-mengajar').val(data.user_id);
          $('#user-id-program-kursus').val(data.user_id);
          $('#user-id-education-data').val(data.user_id);
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
      url: base_url+'wizard/user/add_personal',
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
            filter: '.wizard-education-data'
          });
        }
      }
    });
    $('#loading-personal-data').toggle();
  });

  $('#btn-education-data').on( 'click', function() {
    $('#loading-education-data').toggle();
    $.ajax({
      type : "POST",
      async: false,
      url: base_url+'wizard/user/add_education',
      data: $('#form-education-data').serialize(),
      dataType: "json",
      success:function(data){
        if(data.status=="204"){
          $('#message-education-data').empty();
          $('#message-education-data').append(data.message);
        } 
        else{
          $('.grid').isotope({ 
            itemSelector: '.element-item',
            filter: '.wizard-finish'
          });
        }
      }
    });
    $('#loading-education-data').toggle();
  });

  $('#btn-area-mengajar').on( 'click', function() {
    $('#loading-area-mengajar').toggle();
    // console.log($('#form-area-mengajar').serialize());
    $.ajax({
      type : "POST",
      async: false,
      url: base_url+'wizard/tutor/add_area',
      data: 'tid='+$('#user-id-area-mengajar').val()+'&area='+selected_area_array.join("-"),
      dataType: "json",
      success:function(data){
        if(data.status=="204"){
          $('#message-area-mengajar').empty();
          $('#message-area-mengajar').append(data.message);
        } 
        else{
          $('.grid').isotope({ 
            itemSelector: '.element-item',
            filter: '.wizard-program-kursus'
          });
        }
      }
    });
    $('#loading-area-mengajar').toggle();
  });

  $('#btn-program-kursus').on( 'click', function() {
    $('#loading-program-kursus').toggle();
    // get days of course
    var days = [];
    $('input:checkbox.days-course').each(function () {
      if(this.checked)
        days.push($(this).val());
    });
    // get sessions of course
    var sessions = [];
    $('input:checkbox.session-course').each(function () {
      if(this.checked)
        sessions.push($(this).val());
    });
    // ajax started
    $.ajax({
      type : "POST",
      async: false,
      url: base_url+'wizard/tutor/add_program',
      data: 'tid='+$('#user-id-program-kursus').val()+'&prog='+selected_program_array.join("-")+'&day='+days.join("-")+'&sess='+sessions.join("-"),
      dataType: "json",
      success:function(data){
        if(data.status=="204"){
          $('#message-program-kursus').empty();
          $('#message-program-kursus').append(data.message);
        } 
        else{
          $('.grid').isotope({ 
            itemSelector: '.element-item',
            filter: '.wizard-personal-data'
          });
        }
      }
    });
    $('#loading-program-kursus').toggle();
  });
  // $('#btn-personal-data').on( 'click', function() {
  //   $('.grid').isotope({ 
  //     itemSelector: '.element-item',
  //     filter: '.wizard-education-data'
  //   });
  // });
  // $('#btn-education-data').on( 'click', function() {
  //   $('.grid').isotope({ 
  //     itemSelector: '.element-item',
  //     filter: '.wizard-area-mengajar'
  //   });
  // });


});



<?php 
  for($i=0; $i < $total_col_area_mengajar; $i++) {
   ?>
  $('#tree-prov-<?php echo $i?>').jstree({
    "plugins" : [ "wholerow", "checkbox" ]
  });
  $('#tree-prov-<?php echo $i?>').on("after_open.jstree", function (e, data) {
    var btn = $('#btn-area-mengajar');
    var pos = btn.offset();
    var new_pos = pos.top - 110;
    $('.form-box').css("min-height", new_pos+"px");
  });
  $('#tree-prov-<?php echo $i?>').on("after_close.jstree", function (e, data) {
    var btn = $('#btn-area-mengajar');
    var pos = btn.offset();
    var new_pos = pos.top - 110;
    $('.form-box').css("min-height", new_pos+"px");
  });
  $("#tree-prov-<?php echo $i?>").bind("select_node.jstree",
    function (e, data) {
      // jika node parent dicentang, fetch children, jika tidak fetch selected
      if(! $.isEmptyObject(data.node.children)){
        $.each(data.node.children, function(index, value){
          if($.inArray(value, selected_area_array) == -1)
            selected_area_array.push(value);
        });
      }
      else
        if($.inArray(data.node.id, selected_area_array) == -1)
            selected_area_array.push(data.node.id);
    });
  $("#tree-prov-<?php echo $i?>").bind("deselect_node.jstree",
    function (e, data) {
      // jika node parent dicentang, fetch children, jika tidak fetch selected
      if(! $.isEmptyObject(data.node.children)){
        $.each(data.node.children, function(index, value){
          selected_area_array = jQuery.grep(selected_area_array, function(value_take_out) {
            return value_take_out != value;
          });
        });
      }
      else
        selected_area_array = jQuery.grep(selected_area_array, function(value_take_out) {
            return value_take_out != data.node.id;
          });
    });
<?php } ?>

<?php 
  for($i=0; $i < $total_col_program_kursus; $i++) {
 ?>
  $('#tree-program-<?php echo $i?>').jstree({
    "plugins" : [ "wholerow", "checkbox" ]
  });
  $('#tree-program-<?php echo $i?>').on("after_open.jstree", function (e, data) {
    var btn = $('#btn-program-kursus');
    var pos = btn.offset();
    var new_pos = pos.top - 110;
    $('.form-box').css("min-height", new_pos+"px");
  });
  $('#tree-program-<?php echo $i?>').on("after_close.jstree", function (e, data) {
    var btn = $('#btn-program-kursus');
    var pos = btn.offset();
    var new_pos = pos.top - 110;
    $('.form-box').css("min-height", new_pos+"px");
  });
  $("#tree-program-<?php echo $i?>").bind("select_node.jstree",
    function (e, data) {
      // jika node parent dicentang, fetch children, jika tidak fetch selected
      if(! $.isEmptyObject(data.node.children)){
        $.each(data.node.children, function(index, value){
          if($.inArray(value, selected_program_array) == -1)
            selected_program_array.push(value);
        });
      }
      else
        if($.inArray(data.node.id, selected_program_array) == -1)
            selected_program_array.push(data.node.id);
    });
  $("#tree-program-<?php echo $i?>").bind("deselect_node.jstree",
    function (e, data) {
      // jika node parent dicentang, fetch children, jika tidak fetch selected
      if(! $.isEmptyObject(data.node.children)){
        $.each(data.node.children, function(index, value){
          selected_program_array = jQuery.grep(selected_program_array, function(value_take_out) {
            return value_take_out != value;
          });
        });
      }
      else
        selected_program_array = jQuery.grep(selected_program_array, function(value_take_out) {
            return value_take_out != data.node.id;
          });
    });
<?php } ?>

</script>

<script>
var uploaded_file_id = [];
/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '<?php echo base_url('content/upload_file/image/userfile') ?>';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html(file.name+' <button class="btn btn-danger delete" data-delete-url="'+file.deleteUrl+'" data-file-id="'+file.file_id+'">\
                    <i class="fa fa-trash-o"></i>\
                    <span>Delete</span>\
                </button>').appendTo('#files');
                uploaded_file_id.push(file.file_id);
                $('#toefl-file-id').val(uploaded_file_id.toString());
            });
            $(".delete").eq(-1).on("click",function(e){
              e.preventDefault();
              var file_id = $(this).data('file-id');
              $.ajax({
                type : "POST",
                url: $(this).data('delete-url'),
                dataType: "json",
                success: function(data) {
                  uploaded_file_id = jQuery.grep(uploaded_file_id, function(value) {
                    return value != file_id;
                  });
                  $('#toefl-file-id').val(uploaded_file_id.toString());
                },
                error: function(e) {
                // Schedule the next request when the current one's complete,, in miliseconds
                  alert('Error processing your request: '+e.responseText);
                }
              });
               $(this).parent().remove();
             })
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('#ijasah').fileupload({
        url: '<?php echo base_url('content/upload_file/image/ijasah') ?>',
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html(file.name+' <button class="btn btn-danger delete" data-delete-url="'+file.deleteUrl+'" data-file-id="'+file.file_id+'">\
                    <i class="fa fa-trash-o"></i>\
                    <span>Delete</span>\
                </button>').appendTo('#files-ijasah-transkrip');
                
                $('#ijasah-file-id').val(file.file_id);
            });
            $(".delete").eq(-1).on("click",function(e){
              e.preventDefault();
              var file_id = $(this).data('file-id');
              $.ajax({
                type : "POST",
                url: $(this).data('delete-url'),
                dataType: "json",
                success: function(data) {
                  uploaded_file_id = jQuery.grep(uploaded_file_id, function(value) {
                    return value != file_id;
                  });
                  $('#ijasah-file-id').val('');
                },
                error: function(e) {
                // Schedule the next request when the current one's complete,, in miliseconds
                  alert('Error processing your request: '+e.responseText);
                }
              });
               $(this).parent().remove();
             })
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress-ijasah-transkrip .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('#transkrip').fileupload({
        url: '<?php echo base_url('content/upload_file/image/transkrip') ?>',
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html(file.name+' <button class="btn btn-danger delete" data-delete-url="'+file.deleteUrl+'" data-file-id="'+file.file_id+'">\
                    <i class="fa fa-trash-o"></i>\
                    <span>Delete</span>\
                </button>').appendTo('#files-ijasah-transkrip');
                
                $('#transkrip-file-id').val(file.file_id);
            });
            $(".delete").eq(-1).on("click",function(e){
              e.preventDefault();
              var file_id = $(this).data('file-id');
              $.ajax({
                type : "POST",
                url: $(this).data('delete-url'),
                dataType: "json",
                success: function(data) {
                  uploaded_file_id = jQuery.grep(uploaded_file_id, function(value) {
                    return value != file_id;
                  });
                  $('#transkrip-file-id').val('');
                },
                error: function(e) {
                // Schedule the next request when the current one's complete,, in miliseconds
                  alert('Error processing your request: '+e.responseText);
                }
              });
               $(this).parent().remove();
             })
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress-ijasah-transkrip .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>