          <?php if($this->input->get('prog')<>"" and $this->input->get('prog')<>"all" ) {?>
          <div class="profile-box search-box-left-sidebar">
            <div class="menu-title">
              <i class="fa fa-search fa-3x fa-root-menu-title"></i> <div class="menu-title-fix">Filter</div>
            </div>
            <div class="filter-div">
              <div class="row">
                <div class="col-md-4">
                  <label><?php echo $this->lang->line('age') ?></label>
                </div>
                <div class="col-md-3 filter-input">
                  <input type="number" id="age-from" min="18" max="60" value="18">
                </div>
                <div class="col-md-1">
                  -
                </div>
                <div class="col-md-3 filter-input">
                  <input type="number" id="age-to" min="18" max="60" value="60">
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <label><?php echo $this->lang->line('day') ?></label>
                </div>
                <div class="col-md-5 filter-input">
                  <ul>
                  <?php for($i=1; $i<=7; $i+=2) {?>
                  <li><input type="checkbox" name="day-opt" value="0<?php echo $i ?>"> <?php echo $this->lang->line('day_0'.$i) ?></li>
                  <?php } ?>
                  </ul>
                </div>
                <div class="col-md-5 filter-input">
                  <ul>
                  <?php for($i=2; $i<=7; $i+=2) {?>
                  <li><input type="checkbox" name="day-opt" value="0<?php echo $i ?>"> <?php echo $this->lang->line('day_0'.$i) ?></li>
                  <?php } ?>
                  </ul>
                </div>
              </div>
              <button id="btn-filter-from-right-sidebar" class="home-btn-search" type="button"><?php echo $this->lang->line('submit') ?></button>
            </div>
          </div>
          <?php } ?>
          <?php 
          // get provinces
          $provinces = $this->Location_m->get_province(); 
 
          // get root course category
          $root_courses = $this->Content_m->get_root_category('course');
          ?>
					<div class="profile-box search-box-left-sidebar">
            <div class="menu-title">
              <i class="fa fa-search fa-3x fa-root-menu-title"></i> <div class="menu-title-fix"><?php echo $this->lang->line('search_tutor') ?></div>
            </div>
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
          <div class="profile-box search-box-right-sidebar" style="margin-top: 20px;">
            <div class="menu-title">
              <i class="fa fa-list fa-3x fa-root-menu-title"></i> <div class="menu-title-fix"><?php echo $this->lang->line('program_options') ?></div>
            </div>
              <!--COURSE CATEGORIES WIDGET START-->
              <!-- <div class="widget widget-course-categories"> -->
                  <ul>
                      <?php foreach($counted_tutors_in_programs->result() as $ctd_tutor) {?>
                      <li><a href="<?php echo base_url('teacher/program?prog='.$ctd_tutor->program_id);?>"><?php echo $ctd_tutor->program_name.' - <i>('.$ctd_tutor->counted_tutors.' Tutor)</i>'; ?></a></li>
                      <?php } ?>
                  </ul>
              <!-- </div> -->
              <!--COURSE CATEGORIES WIDGET END-->
          </div>
<script>
  $(document).ready(function(){
  // just prepare for document on ready state
  function show_city(){
    $.ajax({
      type : "GET",
      url: base_url+'location/get_cities_by_province/'+$("#right-sidebar-province").val(),
      async: false,
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#right-sidebar-city").find('option').remove().end();
          for(var i=0; i<data.cities.length;i++)
            $("#right-sidebar-city").append($("<option></option>").val(data.cities[i].id).html(data.cities[i].name));
        }            
      }
    });
  }

  $("#right-sidebar-province").change(function(e){
    show_city();
  });

  if('<?php echo $this->input->get('province')?>' != ''){
    $("#right-sidebar-province").val('<?php echo $this->input->get('province')?>');
    show_city();
    $("#right-sidebar-city").val('<?php echo $this->input->get('city')?>');
  }

  function show_course(){
    $.ajax({
      type : "GET",
      url: base_url+'cms/get_category_under_root',
      data: "root="+$("#right-sidebar-root").val(),
      dataType: "json",
      async: false,
      success:function(data){
        if(data.status=="200"){
          $("#right-sidebar-course").find('option').remove().end();
          $("#right-sidebar-course").append($("<option></option>").val('all').html('Semua Kursus'));
          for(var i=0; i<data.result.length;i++)
            $("#right-sidebar-course").append($("<option></option>").val(data.result[i].id).html(data.result[i].name));
        }            
      }
    });
  }

  $("#right-sidebar-root").change(function(e){
    show_course();
  });

  if('<?php echo $this->input->get('root-course')?>' != ''){
    $("#right-sidebar-root").val('<?php echo $this->input->get('root-course')?>');
    show_course();
    $("#right-sidebar-course").val('<?php echo $this->input->get('course')?>');
  }

  if('<?php echo $this->input->get('prog')?>' != '' && '<?php echo $this->input->get('prog')?>' != 'all'){
    $("#right-sidebar-root").val('<?php echo $this->input->get('prog')?>');
    show_course();
  }
  
});
</script>