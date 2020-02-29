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
                  <select name="root-course" id="topbar-root" class="form-control styled-select">
                    <option value="">-- <?php echo $this->lang->line('select_education_level') ?> *</option>
                    <?php if($root_courses<>false) {
                        foreach($root_courses->result() as $root){?>
                    <option value="<?php echo $root->id; ?>"><?php echo $root->category; ?></option>
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
          <div class="editing">
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
                      $teacher_info = $this->user->get_user_info($teacher_id);
                      foreach($course_data as $data){
                        // get info of the course
                        $course_info = $this->course_lib->get_course_name_in_string($data['course_id']);
                        // get days
                        $day_string = $this->course_lib->get_days_string($data['days']);
                        
                        // get city
                        $city = $this->loc->get_city(array('c.city_id' => $data['city']))->row()->city_name;
                        // get salary per hour
                        $salary = $this->user->get_salary_per_hour($teacher_id);

                        // calculate sub price
                        $sub_price = $salary * $data['session_hour'] * $data['class_in_month'];

                        $sub_price += $data['module'] + $data['tryout'];

                        // echoing output
                        echo '<tr>';
                          echo '<td><strong>'.$teacher_info->first_name.' '.$teacher_info->last_name.'</strong><br>IDR '.number_format($teacher_info->salary_per_hour,0,'.',',').'</td>';
                          echo '<td>'.$city.'</td>';
                          echo '<td><strong>'.$course_info['root'].'</strong><br> '.$course_info['course'].'</td>';
                          echo '<td><strong>'.$this->lang->line('day').':</strong> '.$day_string.'<br><strong>'.$this->lang->line('session').':</strong> '.$data['session_hour'].' '.$this->lang->line('hour').'<br><strong>'.$this->lang->line('face_to_face').':</strong> '.$data['class_in_month'].' '.$this->lang->line('times').'</td>';
                          echo '<td>'.number_format($data['module'], 0, '.', ',').'</td>';
                          echo '<td>'.number_format($data['tryout'], 0, '.', ',').'</td>';
                          echo '<td style="text-align:right">'.number_format($sub_price, 0, '.', ',').'</td>';
                          echo '<td><a title="Remove" href="'.base_url('order/remove_cart_item/'.$teacher_id.'/'.$data['course_id']).'"><i class="fa fa-times-circle fa-2x" style="color:#f50000"></i></a></td>';
                        echo '</tr>';

                        $total_price += $sub_price;
                      } // end foreach 
                    } // end foreach
                    $get_admin_fee = $this->content->get_option_by_param('admin_fee_percentage');
                    $admin_fee = $total_price * floatval($get_admin_fee->parameter_value) / 100;
                    $grand_total = $total_price + $admin_fee;
                    echo '<tr><td colspan="6" style="text-align:right;">'.$this->lang->line('admin_fee').' '.$get_admin_fee->parameter_value.'%:</td><td style="text-align:right">'.number_format($admin_fee, 0, '.', ',').'</td></tr>';
                    echo '<tr><td colspan="6" style="text-align:right; font-weight:bold; font-size:16px">Total:</td><td style="text-align:right">'.number_format($grand_total, 0, '.', ',').'</td></tr>';
                  } // end else
                ?>
              </tbody>
            </table>
          </div>          	
          <div class="choose" style="float:right">
            <a target="_blank" href="<?php echo base_url('content/page/syarat-dan-ketentuan')?>" class="pull-left"><?php echo $this->lang->line('order_pre_submit') ?></a>
            <a href="<?php echo base_url('order/save');?>" class="btn-style"><?php echo $this->lang->line('complete_order') ?></a>
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
      url: base_url+'cms/get_category_under_root',
      data: "root="+$("#topbar-root").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#topbar-course").find('option').remove().end();
          $("#topbar-course").append($("<option></option>").val('all').html('Semua Kursus'));
          for(var i=0; i<data.result.length;i++)
            $("#topbar-course").append($("<option></option>").val(data.result[i].id).html(data.result[i].name));
        }            
      }
    });
    
  });

  
});
</script>