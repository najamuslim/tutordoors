<style>
    hr{
        border-color:#178FC4
    }
</style>
<!--BANNER START-->
<!-- <div class="page-heading">
    <div class="container">
        <h2><?php echo $sub_page_title; ?></h2>
    </div>
</div> -->
<?php $this->load->view('iknow/wizard_order') ?>
<!--BANNER END-->
<!--CONTANT START-->
<div class="contant">
	<div class="container">
  	<div class="teacher-profile">
      <h2><?php echo $this->lang->line('your_detail_order') ?></h2>
      <small>* <?php echo $this->lang->line('you_can_order_more') ?></small>
    	<div class="row">
        <div class="col-md-12">
          <div class="search-box-on-cart">
            <form action="<?php echo base_url('teacher/search/dropdown');?>" method="GET">
              <div class="row">
                <div class="col-md-2">
                  <select name="province" id="topbar-province" class="form-control styled-select">
                    <option value="">-- <?php echo $this->lang->line('select_province') ?> *</option>
                    <?php if($provinces<>false) {
                        foreach($provinces->result() as $prov){?>
                    <option value="<?php echo $prov->province_id; ?>"><?php echo $prov->province_name; ?></option>
                    <?php }} ?>
                  </select>
                </div>
                <div class="col-md-2">
                  <select name="city" id="topbar-city" class="form-control styled-select" required>
                    <option value="">-- <?php echo $this->lang->line('select_city') ?> *</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <select name="program" id="topbar-root" class="form-control styled-select">
                    <option value="">-- <?php echo $this->lang->line('select_education_level') ?> *</option>
                    <?php if($programs<>false) {
                        foreach($programs->result() as $prog){?>
                    <option value="<?php echo $prog->program_id; ?>"><?php echo $prog->program_name; ?></option>
                    <?php }} ?>
                  </select>
                </div>
                <div class="col-md-2">
                  <select name="course" id="topbar-course" class="form-control styled-select" required>
                    <option value="">-- <?php echo $this->lang->line('select_course') ?> *</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <button id="btn-search-from-left-sidebar" class="home-btn-search" type="submit" style="height:30px"><?php echo $this->lang->line('submit') ?></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-12">
          <div class="editing" style="padding-left: 0px; padding-right: 0px; margin-bottom: 0px;">
            <table>
              <thead>
                <tr>
                  <td><?php echo $this->lang->line('teacher') ?> &amp; <?php echo $this->lang->line('tariff') ?></td>
                  <td><?php echo $this->lang->line('city') ?></td>
                  <td><?php echo $this->lang->line('course') ?></td>
                  <td><?php echo $this->lang->line('day') .'/'. $this->lang->line('session') .'/'. $this->lang->line('face_to_face') ?></td>
                  <td><?php echo $this->lang->line('module_study') ?> (IDR)</td>
                  <td><?php echo $this->lang->line('module_tryout') ?> (IDR)</td>
                  <td><?php echo $this->lang->line('sub_price') ?> (IDR)</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if(sizeof($cart_array)==0) 
                    echo '<tr><td colspan="7">'.$this->lang->line('no_order_in_cart').'</td></tr>';
                  else{
                    $total_price = 0;
                    foreach($cart_array as $teacher_id => $course_data){
                      $teacher_info = $this->User_m->get_user_info($teacher_id);
                      foreach($course_data as $data){
                        // get info of the course
                        // $open_course_info = $this->Teacher_m->get_course_data_by_courseid($data['course_id']);
                        $course_info = $this->Course_m->get_courses(array('c.id' => $data['course_id']));
                        // get days
                        $day_string = $this->course_lib->get_days_string($data['days']);
                        
                        // get city
                        $city = $this->Location_m->get_city(array('c.city_id' => $data['city']))->row()->city_name;
                        // get salary per hour
                        $salary = $this->User_m->get_salary_per_hour($teacher_id);

                        // calculate sub price
                        $sub_price = $salary * $data['session_hour'] * $data['class_in_month'] / 1.5; // unit jam ngajar yang berlaku = 1,5 jam

                        $sub_price += $data['module'] + $data['tryout'];

                        // echoing output
                        echo '<tr>';
                          echo '<td><strong>'.$teacher_info->first_name.' '.$teacher_info->last_name.'</strong><br>IDR '.number_format($teacher_info->salary_per_hour,0,'.',',').'</td>';
                          echo '<td>'.$city.'</td>';
                          echo '<td><strong>'.$course_info->row()->program_name.'</strong><br> '.$course_info->row()->course_name.'</td>';
                          echo '<td><strong>'.$this->lang->line('day').':</strong> '.$day_string.'<br><strong>'.$this->lang->line('session').':</strong> '.$data['session_hour'].' '.$this->lang->line('hour').'<br><strong>'.$this->lang->line('face_to_face').':</strong> '.$data['class_in_month'].' '.$this->lang->line('times').'</td>';
                          echo '<td>'.number_format($data['module'], 0, '.', ',').'</td>';
                          echo '<td>'.number_format($data['tryout'], 0, '.', ',').'</td>';
                          echo '<td style="text-align:right">'.number_format($sub_price, 0, '.', ',').'</td>';
                          echo '<td><a title="Remove" href="'.base_url('order/remove_cart_item/'.$teacher_id.'/'.$data['course_id']).'"><i class="fa fa-times-circle fa-2x" style="color:#f50000"></i></a></td>';
                        echo '</tr>';

                        $total_price += $sub_price;
                      } // end foreach 
                    } // end foreach
                    
                    $grand_total = $total_price;
                    echo '<tr><td colspan="6" style="text-align:right; font-weight:bold; font-size:16px">Total:</td><td style="text-align:right">'.number_format($grand_total, 0, '.', ',').'</td></tr>';
                  } // end else
                ?>
              </tbody>
            </table>
          </div>
          <form id="form-order">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label><?php echo $this->lang->line('course_address_held') ?></label>
                  <input type="text" class="form-control" name="address" placeholder="<?php echo $this->lang->line('course_address_held_example') ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <label><?php echo $this->lang->line('date_start') ?></label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" class="form-control" id="default-datepicker" name="date-start" placeholder="Format: 2016-09-30" required>
                </div>
              </div>
              <div class="overlay" style="float:right; display:none" id="loading-confirm-order">
                <i class="fa fa-refresh fa-spin fa-2x"></i>
              </div>
            </div>
            <div class="choose" style="float:right">
              <input type="checkbox" onclick="enable_submit_button()" id="check-term">
              <?php echo $this->lang->line('order_pre_submit_1') ?> <a target="_blank" href="<?php echo base_url('content/page/kebijakan-privasi')?>"><?php echo $this->lang->line('privacy_policy') ?></a> <?php echo $this->lang->line('order_pre_submit_and') ?> <a target="_blank" href="<?php echo base_url('content/page/syarat-dan-ketentuan')?>"><?php echo $this->lang->line('term_conditions') ?></a> <?php echo $this->lang->line('order_pre_submit_2') ?>
              <button type="button" id="btn-submit" class="btn-style" disabled><?php echo $this->lang->line('complete_order') ?></button>
              
            </div>
          </form>

        </div>
      </div>
    </div>
      
  </div>
  <br>
  <?php //include('follow_social_media.php'); ?>
</div>
<!--CONTANT END-->
<script>
  $(document).ready(function(){
  // just prepare for document on ready state

  $("#topbar-province").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'location/get_cities_by_province/'+$("#topbar-province").val(),
      // data: "id="+$("#ship-city").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#topbar-city").find('option').remove().end();
          for(var i=0; i<data.cities.length;i++)
            $("#topbar-city").append($("<option></option>").val(data.cities[i].id).html(data.cities[i].name));
        }            
      }
    });
  });

  $("#topbar-root").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'course/get_course_by_program/'+$('#topbar-root').val(),
      dataType: "json",
      success:function(data){
        $("#topbar-course").find('option').remove().end();
        $("#topbar-course").append($("<option></option>").val('all').html('Semua Kursus'));
        for(var i=0; i<data.length;i++)
          $("#topbar-course").append($("<option></option>").val(data[i].id).html(data[i].course_name));
      }
    });
    
  });

  $("#btn-submit").on('click', function(e){
    $('#loading-confirm-order').toggle();
    $.ajax({
      type : "POST",
      url: base_url+'order/save',
      data: $('#form-order').serialize(),
      dataType: "json",
      success:function(data){
        if(data.status=="200")
        {
          window.location.href = base_url+'frontpage/order_received/'+data.order_id;
        }
        else if(data.status=="204")
        {
          alert(data.message);
        }
        $('#loading-confirm-order').toggle();
      },
      error: function(e) {
        // Schedule the next request when the current one's complete,, in miliseconds
          alert('Error processing your request: '+e.responseText);
          $('#loading-confirm-order').toggle();
        }
    });
    
  });
});

function enable_submit_button(){
  if($('#check-term').is(':checked'))
    $('#btn-submit').prop('disabled', false);
  
  else{
    $('#btn-submit').prop('disabled', true);
    $('.replace-error-message').html('');
  }
}
</script>