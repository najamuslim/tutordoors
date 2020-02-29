<style>
  .glyphicon { margin-right:10px; }
  .panel-body { padding:0px; }
  .panel-body table tr td { padding-left: 15px }
  .panel-body .table {margin-bottom: 0px; }
</style>
					<?php 
          // get provinces
          $provinces = $this->Location_m->get_province(); 
 
          // get root course category
          $root_courses = $this->Content_m->get_root_category('course');
          // foreach($root_courses->result() as $root){
          //   $get_teachers = $this->Teacher_m->get_data_concat_course_by_education_level($root->id);
            
          //   if($get_teachers<>false){
          //     foreach($get_teachers->result() as $teacher){
          //       // get more user info
          //       $teacher_info = $this->user->get_user_info($teacher->user_id);
          //       $total_viewed = $teacher_info->total_viewed;
          //       // $total_taken_course = $this->Teacher_m->get_total_taken_course($teacher->user_id);

          //       $data['teachers'][$root->id][] = array(
          //         'user_id' => $teacher->user_id,
          //         'level' => $teacher->user_level,
          //         'course' => str_replace(',', ', ', $teacher->courses),
          //         'first_name' => $teacher->first_name,
          //         'last_name' => $teacher->last_name,
          //         // 'sex' => $teacher->sex,
          //         'image_file' => $teacher->file_name,
          //         'about_me' => $teacher->about_me,
          //         'total_viewed' => $total_viewed
          //         // 'total_taken_course' => $total_taken_course
          //         );
          //     }
          //   }
          // }
          ?>
          <!-- SEARCH BOX START -->
          <?php if($this->session->userdata('level')=="student") {?>
          <div class="profile-box search-box-left-sidebar" style="margin-top:0px">
              <div class="menu-title">
                <i class="fa fa-search fa-3x fa-root-menu-title"></i> <div class="menu-title-fix"><?php echo $this->lang->line('search_tutor') ?></div>
              </div>
              <form action="<?php echo base_url('teacher/search/dropdown');?>" method="GET">
                <ul>
                  <li>
                    <select name="province" id="left-sidebar-province" class="form-control styled-select">
                      <option value="">-- <?php echo $this->lang->line('select_province') ?> *</option>
                      <?php if($provinces<>false) {
                          foreach($provinces->result() as $prov){?>
                      <option value="<?php echo $prov->province_id; ?>"><?php echo $prov->province_name; ?></option>
                      <?php }} ?>
                    </select>
                  </li>
                  <li>
                    <select name="city" id="left-sidebar-city" class="form-control styled-select" required>
                      <option value="">-- <?php echo $this->lang->line('select_city') ?> *</option>
                    </select>
                  </li>
                  <li>
                    <select name="root-course" id="left-sidebar-root" class="form-control styled-select">
                      <option value="">-- <?php echo $this->lang->line('select_education_level') ?> *</option>
                      <?php if($root_courses<>false) {
                          foreach($root_courses->result() as $root){?>
                      <option value="<?php echo $root->id; ?>"><?php echo $root->category; ?></option>
                      <?php }} ?>
                    </select>
                  </li>
                  <li>
                    <select name="course" id="left-sidebar-course" class="form-control styled-select" required>
                      <option value="">-- <?php echo $this->lang->line('select_course') ?> *</option>
                    </select>
                  </li>
                  <li>
                    <button id="btn-search-from-left-sidebar" class="home-btn-search" type="submit"><?php echo $this->lang->line('submit') ?></button>
                  </li>
                </ul>
              </form>
          </div>
          <?php } ?>
          <!-- SEARCH BOX END -->
          <!--EDIT PROFILE START-->
          <div class="profile-box edit-profile" <?php if($this->session->userdata('level')=="teacher") echo 'style="margin-top: 0px;"';?>>
          	<div class="menu-title">
                  <i class="fa fa-dashboard fa-3x fa-root-menu-title"></i> <div class="menu-title-fix"><?php echo $this->lang->line('dashboard') ?> 
                  <?php 
                      if($this->session->userdata('level')=="student") echo $this->lang->line('student');
                      else if($this->session->userdata('level')=="teacher") echo $this->lang->line('teacher');
                      ?>
                  </div>
              </div>
              <ul>
                  <li>
                    <a <?php if($am=="dashboard") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('my_account'); ?>"><?php echo $this->lang->line('dashboard') ?>
                    </a>
                  </li>
                  <li>
                    <a <?php if($am=="edit_profile") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('users/view_profile'); ?>"><?php echo $this->lang->line('profile') ?>
                    </a>
                  </li>
                  <li>
                    <a <?php if($am=="change_password") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('users/u_change_password'); ?>"><?php echo $this->lang->line('change_password') ?>
                    </a>
                  </li>
                  <?php if($this->session->userdata('level')=="teacher") {?>
                  <li>
                    <a <?php if($am=="edit_open_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/edit_open_course'); ?>"><?php echo $this->lang->line('city_and_course') ?>
                    </a>
                  </li>
                  <li>
                    <a <?php if($am=="online_test") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('otest/assignment_list'); ?>"><?php echo $this->lang->line('online_test') ?>
                    </a>
                  </li>
                  <?php } ?>
                  <li>
                    <a <?php if($am=="message") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/messages'); ?>"><?php echo $this->lang->line('message') ?> <span class="replace-count-message-sidebar">(<?php echo ($unread_message>0 ? $unread_message : 0);?>)</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('logout'); ?>"><?php echo $this->lang->line('signout') ?></a>
                  </li>
              </ul>
              <!-- <div class="logout">
              	
              </div> -->
          </div>
          <div class="profile-box edit-profile">
              <div class="menu-title">
                  <i class="fa fa-info fa-3x fa-root-menu-title"></i> <div class="menu-title-fix"><?php echo $this->lang->line('course_info') ?></div>
              </div>
              <ul style="margin: 0">
                  <?php if($this->session->userdata('level')=="teacher") {?>
                  <li><a <?php if($am=="teach_schedule") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/teach_schedule'); ?>"><?php echo $this->lang->line('course_schedule') ?></a></li>
                  <li><a <?php if($am=="new_course_request") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/open_course_request'); ?>"><?php echo $this->lang->line('course_request') ?></a></li>
                  <li><a <?php if($am=="running_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/running_course'); ?>"><?php echo $this->lang->line('course_running') ?></a></li>
                  <li><a <?php if($am=="completed_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/completed_course'); ?>"><?php echo $this->lang->line('course_completed') ?></a></li>
                  
                  <?php } 

                  else if($this->session->userdata('level')=="student") {?>

                  <!-- <li><a href="#">View Quiz Scores</a></li> -->
                  <li><a <?php if($am=="teach_schedule") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('student/course_schedule'); ?>"><?php echo $this->lang->line('course_schedule') ?></a></li>
                  <li><a <?php if($am=="student_course_request") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('student/course_request'); ?>"><?php echo $this->lang->line('course_request') ?></a></li>
                  <li><a <?php if($am=="running_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/running_course'); ?>"><?php echo $this->lang->line('course_running') ?></a></li>
                  <li><a <?php if($am=="completed_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/completed_course'); ?>"><?php echo $this->lang->line('course_completed') ?></a></li>
                  
                  <?php } ?>
              </ul>
          </div>
          <div class="profile-box edit-profile">
              <div class="menu-title">
                  <i class="fa fa-money fa-3x fa-root-menu-title"></i> <div class="menu-title-fix"><?php echo $this->lang->line('payment') ?></div>
              </div>
              <ul>
                  <?php if($this->session->userdata('level')=="teacher") {?>
                  <li><a <?php if($am=="set_bank") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/set_bank'); ?>"><?php echo $this->lang->line('bank_account') ?></a></li>
                  <li><a <?php if($am=="teacher_comm") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/commission'); ?>"><?php echo $this->lang->line('commission') ?></a></li>

                  <?php } 

                      else if($this->session->userdata('level')=="student") {?>

                  <li><a <?php if($am=="invoice") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('student/invoice'); ?>"><?php echo $this->lang->line('invoice') ?></a></li>
                  <li><a <?php if($am=="payment_confirmation") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/payment_confirmation'); ?>"><?php echo $this->lang->line('confirmation') ?><a></li>

                  <?php } ?>
              </ul>
          </div>
          <!--EDIT PROFILE END-->
<script>
  $(document).ready(function(){
  // just prepare for document on ready state

  $("#left-sidebar-province").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'location/get_cities_by_province/'+$("#left-sidebar-province").val(),
      // data: "id="+$("#ship-city").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#left-sidebar-city").find('option').remove().end();
          for(var i=0; i<data.cities.length;i++)
            $("#left-sidebar-city").append($("<option></option>").val(data.cities[i].id).html(data.cities[i].name));
        }            
      }
    });
  });

  $("#left-sidebar-root").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'cms/get_category_under_root',
      data: "root="+$("#left-sidebar-root").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#left-sidebar-course").find('option').remove().end();
          $("#left-sidebar-course").append($("<option></option>").val('all').html('Semua Kursus'));
          for(var i=0; i<data.result.length;i++)
            $("#left-sidebar-course").append($("<option></option>").val(data.result[i].id).html(data.result[i].name));
        }            
      }
    });
    
  });

  
});
</script>