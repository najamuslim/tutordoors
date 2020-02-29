    <!--BANNER START-->
    <div class="page-heading">
      <div class="container">
            <h2><?php echo $this->lang->line('ordering_course') ?></h2>
        </div>
    </div>
    <?php $this->load->view('iknow/wizard_order') ?>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <form id="form-master">
              <div class="form-box">
                <input type="hidden" name="teacher" id="teacher" value="<?php echo $this->input->get('tid'); ?>">
                <!-- <input type="hidden" name="selected-course" id="selected-course"> -->
                <div class="form-body">
                  <fieldset>
                    <h2><?php echo $this->lang->line('fill_as_your_need') ?></h2>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('name_first') ?></label>
                            <input type="text" class="form-control" value="<?php echo $this->session->userdata('fn'); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('name_last') ?></label>
                            <input type="text" value="<?php echo $this->session->userdata('ln'); ?>" class="form-control" readonly>
                        </div>
                        
                        <!-- <label><?php echo $this->lang->line('notes') ?></label>
                        <textarea name="notes" class="form-control" placeholder="<?php echo $this->lang->line('notes_order_hint') ?>" class="input-block-level" rows="8"></textarea> -->
                      </div>
                      <div class="col-md-4">
                        <!-- start form -->
                        <label><?php echo $this->lang->line('select_city') ?></label>
                        <div class="form-group">
                          <?php if($cities<>false) {
                            foreach($cities->result() as $city){?>
                          <div class="radio">
                            <label>
                              <input type="radio" name="city" value="<?php echo $city->city_id; ?>"> <?php echo $city->city_name; ?>
                            </label>
                          </div>
                          <?php }} ?>
                        </div>
                        <!-- end form -->
                      </div> <!-- ./col -->
                      <div class="col-md-4">
                        <!-- start form -->
                        <!-- pilih kursus -->
                        <label><?php echo $this->lang->line('select_course') ?></label>
                        <div class="form-group">
                          <?php 
                          if($courses<>false){
                              foreach($courses->result() as $course){
                                // get info of the course
                                $course_info = $this->course_lib->get_course_name_in_string($course->course_id);
                                // print_r($course->course_id);
                          ?>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="course[]" onclick="select_courses()" value="<?php echo $course->course_id; ?>"> <?php echo '<strong>'.$course_info['root'].'</strong> - '.$course_info['course']; ?>
                            </label>
                          </div>
                          <?php }} ?>
                        </div>
                        <!-- end form -->
                      </div> <!-- ./col -->
                    </div>
                  </fieldset>
                </div>
              </div> <!-- form box end -->
              <!-- form courses start -->
              <div id="form-courses">
              </div>
              <!-- form course end -->
              <div class="footer">
                <div class="row">
                  <p class="pull-left"><?php echo $this->lang->line('order_pre_submit') ?></p>
                  <button id="submit-order" type="button" class="btn-style pull-right"><?php echo $this->lang->line('submit') ?></button>

                  <div class="overlay pull-right" style="display:none" id="loading-submit-order">
                      <i class="fa fa-refresh fa-spin fa-2x"></i>
                  </div>
                  <p class="pull-right replace-error-message" style="color:#FF0000"></p>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-4 summary-box">
            <div class="form-box">
              <div class="form-body">
                <h2>Summary</h2>
                <div class="row">
                  <!-- <div class="col-md-6"> -->
                    <div class="summary" style="position:relative">
                      <span class="field"><?php echo $this->lang->line('city')?>:</span>
                      <span class="text replace-city"></span>
                    </div>
                    <div class="summary-separator"></div>
                    <div id="summary-courses"></div>
                    <!-- <div class="summary total-price" style="position:relative">
                      <span class="field-price"><?php echo $this->lang->line('total')?>:</span>
                      <span class="text-price replace-totalprice">IDR 0</span>
                    </div>
                    <div class="summary-separator-finish"></div> -->
                  <!-- </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->
<script>
var teacher_id = "<?php echo $this->input->get('tid'); ?>";

$(function () {
  $('#timepicker, #timepicker2').datetimepicker({
    format: 'HH:mm'
  });
});

function course_add_rem(trans, course_id){
  var url_string = base_url+'order/preorder_course_session/'+trans+'/'+course_id;

  $.ajax({
    type : "GET",
    url: url_string,
    async: false,
    dataType: "json"
  });
}

$('#submit-order').on('click', function(){
  $('#loading-submit-order').toggle();
  $.ajax({
    type : "POST",
    url: base_url+'order/add_cart',
    data:$('#form-master').serialize(),
    async: false,
    dataType: "json",
    success: function(data) {
      if(data.status=="200")
        window.location.href = base_url+'order/cart/';
      else if(data.status=="301")
        $('.replace-error-message').html(data.message);
    },
    error: function(e) {
    // Schedule the next request when the current one's complete,, in miliseconds
      alert('Error processing your request: '+e.responseText);
    }
  });
  $('#loading-submit-order').toggle();
});

function select_courses(){
  // 1. clear details
  // $('#form-courses').empty();
  // 2. create summary
  $('#summary-courses').empty();
  // 3. fetch checked courses
  var course_id = '';
  $("input[name='course[]']").each(function(){
    course_id = $(this).val();
    if($(this).is(':checked')){
      // add course to session
      course_add_rem('add', course_id);
      // collecting info
      $.ajax({
        type : "GET",
        url: base_url+'order/get_course_data/<?php echo $teacher_info->user_id?>/'+course_id,
        async: false,
        dataType: "json",
        success: function(data) {
          var head = 
                  '<div class="form-box" id="form-box-'+course_id+'">\
                    <div class="form-body">\
                      <fieldset>';
          var content = 
                      '<h3>'+data.course_name+'</h3>\
                        <div class="row">\
                          <div class="col-md-3">\
                            <label><?php echo $this->lang->line('select_days') ?></label>\
                            <div class="form-group" id="select-days-'+course_id+'">';
          for(var i=0; i<data.days.length; i++)
            content +=      '<div class="checkbox">\
                              <label>\
                                <input type="checkbox" name="days-'+course_id+'[]" onclick="select_days('+course_id+')" value="'+data.days[i].id+'"> '+data.days[i].name+'\
                              </label>\
                            </div>';

          content +=      '</div>'/*end of checkbox select days*/+'\
                          </div>'/*end of col-md-3*/+'\
                          <div class="col-md-3">\
                            <label><?php echo $this->lang->line('session_given_by_tutor') ?>: </label>\
                            <div class="form-group" id="radio-session">';
          for(var j=0; j<data.sessions.length; j++)
            content +=        '<div class="radio">\
                                <label>\
                                  <input type="radio" name="session-'+course_id+'" value="'+data.sessions[j]+'" onchange="select_session('+course_id+')"> '+data.sessions[j]+' <?php echo $this->lang->line('hour')?>\
                                </label>\
                              </div>';

          content +=        '</div>'/*end of radio session*/+'\
                          </div>'/*end of col-md-3*/+'\
                          <div class="col-md-3">\
                            <label><?php echo $this->lang->line('class_face_to_face') ?></label>\
                            <div class="form-group">';
          $.each([ 4, 8, 12, 16 ], function( index, value ) {
            content +=        '<div class="radio">\
                                <label>\
                                  <input type="radio" name="class-'+course_id+'" value="'+value+'" '+(value==4 ? "checked" : "")+' onchange="select_tatap_muka('+course_id+')"> '+value+' <?php echo $this->lang->line('times') ?>\
                                </label>\
                              </div>';
          });
          
          content += '      </div>\
                          </div>\
                          <div class="col-md-3">\
                            <label><?php echo $this->lang->line('use_these_additional_material') ?></label>\
                            <div class="form-group">\
                              <div class="checkbox">\
                                <label>\
                                  <input type="checkbox" name="module-'+course_id+'" onclick="calculate('+course_id+')"> <?php echo $this->lang->line('module_study') ?> (IDR '+data.module_price+')\
                                </label>\
                              </div>\
                              <div class="checkbox">\
                                <label>\
                                  <input type="checkbox" name="tryout-'+course_id+'" onclick="calculate('+course_id+')"> <?php echo $this->lang->line('module_tryout') ?> (IDR '+data.tryout_price+')\
                                </label>\
                              </div>\
                            </div>\
                          </div>\
                        </div>';
          var foot = '</fieldset>\
                    </div>\
                  </div>';
          if($("#form-box-"+course_id).length == 0)
            $('#form-courses').append(head+content+foot).hide().fadeIn(500);
          
          create_summary(course_id);

          // assigning salary per hour
          $('.replace-'+course_id+'-tariff').text('IDR '+data.salary);

          calculate(course_id);
          
        },
        error: function(e) {
        // Schedule the next request when the current one's complete,, in miliseconds
          alert('Error processing your request: '+e.responseText);
        }
      });
    }
    else{
      course_add_rem('remove', course_id);
      $("#form-box-"+course_id).remove().fadeOut(500);
    }
    
  });
  
}

$(document).ready(function(){
  // when city is changed
  $('input:radio[name=city]').change(function() {
    $.ajax({
      type : "GET",
      url: base_url+'location/get_city_name/'+$(this).val(),
      async: false,
      dataType: "json",
      success: function(data) {
        $('.replace-city').text(data.name);
      },
      error: function(e) {
      // Schedule the next request when the current one's complete,, in miliseconds
        alert('Error processing your request: '+e.responseText);
      }
    });
    
  });

  // if session selected course, only open the container
  <?php
    $course_array = $this->order_lib->get_courses_session();
    if(!empty($course_array)){
      echo 'var selected_course = "";';
      foreach($course_array as $course_id => $course){
        echo 'selected_course = "'.$course_id.'";';
  ?>
        $("input[name='course[]']").each(function(){
          if($(this).val()==selected_course){
            $(this).prop('checked', true);
            select_courses(selected_course);
          }
        });
  <?php
      }
    }
  ?>
})

// days checkbox
function select_days(course_id){
  var days_input = '';
  $("input[name='days-"+course_id+"[]']:checked").each(function(){
    days_input += $(this).val()+'-';
  });
  days_input = days_input.slice(0,-1);
  $.ajax({
    type : "GET",
    url: base_url+'order/get_day_string/'+days_input,
    async: false,
    dataType: "json",
    success: function(data) {
      $('.replace-'+course_id+'-days').text(data.days);
    },
    error: function(e) {
    // Schedule the next request when the current one's complete,, in miliseconds
      alert('Error processing your request: '+e.responseText);
    }
  });
}

// on radio change
function select_session(course_id){
  calculate(course_id);
}

function select_tatap_muka(course_id){
  calculate(course_id);
}

function get_module_checked(course_id){
  var module_param = '';
  $("input:checkbox[name=module-"+course_id+"]:checked").each(function(){
    module_param = $(this).val()=="on" ? "1" : "0";
  });

  return module_param;
}

function get_tryout_checked(course_id){
  var tryout_param = '';
  $("input:checkbox[name=tryout-"+course_id+"]:checked").each(function(){
    tryout_param = $(this).val()=="on" ? "1" : "0";
  });

  return tryout_param;
}

function calculate(course_id){
  $.ajax({
    type : "GET",
    url: base_url+'order/calculate_summary_preorder/'+$('#teacher').val()+'/'+course_id+'/'+$('input:radio[name=session-'+course_id+']:checked').val()+'/'+$('input:radio[name=class-'+course_id+']:checked').val()+'/'+get_module_checked(course_id)+'/'+get_tryout_checked(course_id),
    async: false,
    dataType: "json",
    success: function(data) {
      $('.replace-'+course_id+'-root').text(data.root);
      $('.replace-'+course_id+'-course').text(data.course);
      $('.replace-'+course_id+'-session').text(data.session);
      $('.replace-'+course_id+'-class').text(data.class);
      $('.replace-'+course_id+'-subprice').text('IDR '+data.sub_price);
      $('.replace-'+course_id+'-modul').text('IDR '+data.module);
      $('.replace-'+course_id+'-tryout').text('IDR '+data.tryout);
      // $('.replace-totalprice').text(data.total_price);
    },
    error: function(e) {
    // Schedule the next request when the current one's complete,, in miliseconds
      alert('Error processing your request: '+e.responseText);
    }
  });
}

function create_summary(course_id){
  $('#summary-courses').append('<div class="summary" style="position:relative">\
                        <span class="field"><?php echo $this->lang->line('category')?>:</span>\
                        <span class="text replace-'+course_id+'-root"></span>\
                      </div>\
                      <div class="summary" style="position:relative">\
                        <span class="field"><?php echo $this->lang->line('course')?>:</span>\
                        <span class="text replace-'+course_id+'-course"></span>\
                      </div>\
                      <div class="summary" style="position:relative">\
                        <span class="field"><?php echo $this->lang->line('day')?>:</span>\
                        <span class="text replace-'+course_id+'-days"></span>\
                      </div>\
                      <div class="summary" style="position:relative">\
                        <span class="field"><?php echo $this->lang->line('session')?>:</span>\
                        <span class="text replace-'+course_id+'-session">0 jam</span>\
                      </div>\
                      <div class="summary" style="position:relative">\
                        <span class="field"><?php echo $this->lang->line('class_face_to_face')?>:</span>\
                        <span class="text replace-'+course_id+'-class">0 kali</span>\
                      </div>\
                      <div class="summary" style="position:relative">\
                        <span class="field"><?php echo $this->lang->line('tariff_hourly')?>:</span>\
                        <span class="text replace-'+course_id+'-tariff">IDR 0</span>\
                      </div>\
                      <div class="summary" style="position:relative">\
                        <span class="field"><?php echo $this->lang->line('module_study')?>:</span>\
                        <span class="text replace-'+course_id+'-modul">IDR 0</span>\
                      </div>\
                      <div class="summary" style="position:relative">\
                        <span class="field"><?php echo $this->lang->line('module_tryout')?>:</span>\
                        <span class="text replace-'+course_id+'-tryout">IDR 0</span>\
                      </div>\
                      <div class="summary price" style="position:relative">\
                        <span class="field-price"><?php echo $this->lang->line('sub_price')?>:</span>\
                        <span class="text-price replace-'+course_id+'-subprice">IDR 0</span>\
                      </div>');
}
</script>