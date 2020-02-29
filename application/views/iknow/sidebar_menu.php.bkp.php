                    <?php 
          // get provinces
          $provinces = $this->loc->get_province(); 
 
          // get root course category
          $root_courses = $this->content->get_root_category('course');
          foreach($root_courses->result() as $root){
            $get_teachers = $this->teacher->get_data_concat_course_by_education_level($root->id);
            
            if($get_teachers<>false){
              $this->load->model('User_m', 'user');
              foreach($get_teachers->result() as $teacher){
                // get more user info
                $user_info = $this->user->get_user_info($teacher->user_id);
                $total_viewed = $user_info->total_viewed;
                $total_taken_course = $this->teacher->get_total_taken_course($teacher->user_id);

                $data['teachers'][$root->id][] = array(
                  'user_id' => $teacher->user_id,
                  'level' => $teacher->user_level,
                  'course' => str_replace(',', ', ', $teacher->courses),
                  'first_name' => $teacher->first_name,
                  'last_name' => $teacher->last_name,
                  // 'sex' => $teacher->sex,
                  'image_file' => $teacher->file_name,
                  'about_me' => $teacher->about_me,
                  'occupation' => $teacher->occupation,
                  'total_viewed' => $total_viewed,
                  'total_taken_course' => $total_taken_course
                  );
              }
            }
          }
          ?>
					<div class="sidebar form-data search-box-right-sidebar">
            <!--COURSE CATEGORIES WIDGET START-->
            <div class="widget widget-course-categories">
                <h2><?php echo $this->lang->line('search_tutor') ?></h2>
                <form action="<?php echo base_url('teacher/search/dropdown');?>" method="GET">
                    <ul>
                      <li>
                        <select name="province" id="right-sidebar-province" class="form-control styled-select">
                          <option value="">-- <?php echo $this->lang->line('select_province') ?> *</option>
                          <?php if($provinces<>false) {
                              foreach($provinces->result() as $prov){?>
                          <option value="<?php echo $prov->province_id; ?>"><?php echo $prov->province_name; ?></option>
                          <?php }} ?>
                        </select>
                      </li>
                      <li>
                        <select name="city" id="right-sidebar-city" class="form-control styled-select" required>
                          <option value="">-- <?php echo $this->lang->line('select_city') ?> *</option>
                        </select>
                      </li>
                      <li>
                        <select name="root-course" id="right-sidebar-root" class="form-control styled-select">
                          <option value="">-- <?php echo $this->lang->line('select_education_level') ?> *</option>
                          <?php if($root_courses<>false) {
                              foreach($root_courses->result() as $root){?>
                          <option value="<?php echo $root->id; ?>"><?php echo $root->category; ?></option>
                          <?php }} ?>
                        </select>
                      </li>
                      <li>
                        <select name="course" id="right-sidebar-course" class="form-control styled-select" required>
                          <option value="">-- <?php echo $this->lang->line('select_course') ?> *</option>
                        </select>
                      </li>
                      <li>
                        <button id="btn-search-from-right-sidebar" class="home-btn-search" type="submit"><?php echo $this->lang->line('submit') ?></button>
                      </li>
                    </ul>
                </form>
            </div>
            <!--COURSE CATEGORIES WIDGET END-->
          </div>
          <div class="sidebar" style="margin-top: 20px;">
              <!--COURSE CATEGORIES WIDGET START-->
              <div class="widget widget-course-categories">
                  <h2><?php echo $this->lang->line('find_tutor_per_category') ?></h2>
                  <ul>
                      <?php foreach($course_categories->result() as $cat) {?>
                      <li><a href="<?php echo base_url('teacher/search/category?cat='.$cat->id);?>"><?php echo $cat->category.' ('.$cat->total.')'; ?></a></li>
                      <?php } ?>
                  </ul>
              </div>
              <!--COURSE CATEGORIES WIDGET END-->
          </div>
<script>
  $(document).ready(function(){
  // just prepare for document on ready state

  $("#right-sidebar-province").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'location/get_cities_by_province/'+$("#right-sidebar-province").val(),
      // data: "id="+$("#ship-city").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#right-sidebar-city").find('option').remove().end();
          for(var i=0; i<data.cities.length;i++)
            $("#right-sidebar-city").append($("<option></option>").val(data.cities[i].id).html(data.cities[i].name));
        }            
      }
    });
  });

  $("#right-sidebar-root").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'cms/get_category_under_root',
      data: "root="+$("#right-sidebar-root").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#right-sidebar-course").find('option').remove().end();
          $("#right-sidebar-course").append($("<option></option>").val('all').html('Semua Kursus'));
          for(var i=0; i<data.result.length;i++)
            $("#right-sidebar-course").append($("<option></option>").val(data.result[i].id).html(data.result[i].name));
        }            
      }
    });
    
  });

  
});
</script>