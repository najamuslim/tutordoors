    <!--CONTANT START-->
    <div class="contant">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-push-3">
                  <h2><?php echo $sub_page_title; ?></h2>
                    <div class="warning-box">
                        <i class="fa fa-exclamation-triangle"></i> <?php echo $this->lang->line('city_course_editing_hint') ?>
                    </div>
                    <!-- OPEN CITY COURSE START-->
                    <div class="profile-box editing">
                        <h2><?php echo $this->lang->line('city_coverage_for_teaching') ?></h2>
                        <sup>*)</sup> <span style="font-size: 10px"><?php echo $this->lang->line('able_to_add_more_than_one_area') ?></span>
                        <table id="city-course">
                            <thead>
                                <tr>
                                    <td><?php echo $this->lang->line('province') ?></td>
                                    <td><?php echo $this->lang->line('city') ?></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($open_city<>false) {
                                    foreach($open_city->result() as $city){?>
                                <tr id="city-<?php echo $city->id;?>">
                                    <td><?php echo $city->province_name;?></td>
                                    <td><?php echo $city->city_name;?></td>
                                    <td>
                                        <?php if($city->verified=="0") {?>
                                        <button class="btn btn-default btn-block btn-flat" onclick="remove_open_city('<?php echo $city->id;?>')"><span class="fa fa-minus-circle" style="color:red"></span> <?php echo $this->lang->line('delete') ?></button>
                                        <?php } 
                                        else {
                                          if($city->delete_request=="0") { ?>
                                        <a class="btn btn-default btn-block btn-flat" href="<?php echo base_url('teacher/request_delete/city/'.$city->id);?>"><span class="fa fa-minus-circle" style="color:red"></span> <?php echo $this->lang->line('delete_request') ?></a>
                                        <?php }
                                          else echo '<i class="fa fa-warning" style="color:#0000ff"></i> '.$this->lang->line('delete_in_verification');
                                         } ?>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                        <br><br>
                        <ul>
                            <li>
                                <label><?php echo $this->lang->line('select_province') ?></label>
                                <select name="province" id="province" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($provinces->result() as $prov) {?>
                                    <option value="<?php echo $prov->province_id; ?>"><?php echo $prov->province_name; ?></option>
                                    <?php } ?>
                                </select>
                            </li>
                            <li>
                                <label><?php echo $this->lang->line('select_city') ?></label>
                                <select name="city" id="city" class="form-control">
                                </select>
                            </li>
                            <li class="fw">
                                <button type="button" id="add-open-city" class="btn-style" style="margin-top:10px"><?php echo $this->lang->line('add_this_city') ?></button>
                            </li>
                        </ul>
                    </div>
                    <!-- OPEN CITY COURSE END-->

                    <!-- OPEN CITY COURSE START-->
                    <div class="profile-box editing">
                        <h2><?php echo $this->lang->line('subject_or_course') ?></h2>
                        <sup>*)</sup> <span style="font-size: 10px"><?php echo $this->lang->line('able_to_add_more_than_one_course') ?></span>
                        <table id="open-course">
                            <thead>
                                <tr>
                                    <td><?php echo $this->lang->line('opened_course') ?></td>
                                    <td><?php echo $this->lang->line('session') ?></td>
                                    <td><?php echo $this->lang->line('action') ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($open_course<>false) {
                                    foreach($open_course->result() as $course){?>
                                <tr id="course-<?php echo $course->id;?>">
                                    <td>
                                      <?php 
                                        echo '<strong>'.$course->course_name.'</strong><br>'.$this->lang->line('education_level').': '.$course->program_name;
                                      ?>
                                    </td>
                                    <td>
                                      <?php
                                        $days = $this->course_lib->get_days_string($course->days);

                                        echo $days.($course->session_hours>0 ? '<br>'.$this->lang->line('session').': '.str_replace(',', ', ', $course->session_hours).' '.$this->lang->line('hour') : '');
                                      ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($course->verified=="0") {
                                        ?>
                                        <button class="btn btn-default btn-block btn-flat" onclick="remove_open_course('<?php echo $course->id;?>')"><span class="fa fa-minus-circle" style="color:red"></span> <?php echo $this->lang->line('delete') ?></button>
                                        <?php 
                                            } 
                                            else { 
                                                if($course->delete_request=="0") { 
                                        ?>
                                        <a class="btn btn-default btn-block btn-flat" href="<?php echo base_url('teacher/request_delete/course/'.$course->id);?>"><span class="fa fa-minus-circle" style="color:red"></span> <?php echo $this->lang->line('delete_request') ?></a>
                                        <?php 
                                                }
                                                else echo '<i class="fa fa-warning" style="color:#0000ff"></i> '.$this->lang->line('delete_in_verification');
                                            } 
                                         ?>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                        <br><br>
                        <form id="form-add-course">
                          <ul>
                            <li>
                                <label><?php echo $this->lang->line('select_program') ?></label>
                                <select name="program" id="program" class="form-control">
                                    <option value=""></option>
                                    <?php if($programs<>false) {
                                        foreach($programs->result() as $program){?>
                                    <option value="<?php echo $program->program_id; ?>"><?php echo $program->program_name; ?></option>
                                    <?php }} ?>
                                </select>
                            </li>
                            <li>
                                <label><?php echo $this->lang->line('select_course') ?></label>
                                <select name="course" id="course" class="form-control" required>
                                </select>
                            </li>
                            <li>
                                <label><?php echo $this->lang->line('day_select') ?></label>
                                <sup>*)</sup> <span style="font-size: 10px"><?php echo $this->lang->line('able_to_add_more_than_one') ?></span>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <?php for($i=1; $i<=4; $i++) {?>
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="days[]" value="0<?php echo $i?>"> <?php echo $this->lang->line('day_0'.$i) ?>
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
                                          <input type="checkbox" name="days[]" value="0<?php echo $i?>"> <?php echo $this->lang->line('day_0'.$i) ?>
                                        </label>
                                      </div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                            </li>
                            <li>
                                <label><?php echo $this->lang->line('session_select') ?></label>
                                <sup>*)</sup> <span style="font-size: 10px"><?php echo $this->lang->line('able_to_add_more_than_one') ?></span>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="session[]" value="1.5"> 1.5 <?php echo $this->lang->line('hour') ?>
                                        </label>
                                      </div>
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="session[]" value="2"> 2 <?php echo $this->lang->line('hour') ?>
                                        </label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="session[]" value="2.5"> 2.5 <?php echo $this->lang->line('hour') ?>
                                        </label>
                                      </div>
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="session[]" value="3"> 3 <?php echo $this->lang->line('hour') ?>
                                        </label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </li>
                            <li class="fw">
                                <button type="button" id="add-open-course" class="btn-style" style="margin-top:10px"><?php echo $this->lang->line('add_this_course') ?></button>
                            </li>
                          </ul>
                        </form>
                        
                    </div>
                    <!-- OPEN CITY COURSE END-->
                </div>
                <div class="col-md-3 col-md-pull-9">
                    <?php include('sidebar_menu.php'); ?>
                </div>
            </div>
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->
<script>
$("#province").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'location/get_cities_by_province/'+$("#province").val(),
      // data: "id="+$("#ship-city").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#city").find('option').remove().end();
          for(var i=0; i<data.cities.length;i++)
            $("#city").append($("<option></option>").val(data.cities[i].id).html(data.cities[i].name));
        }            
      }
    });
});

$("#program").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'course/get_course_by_program/'+$('#program').val(),
      dataType: "json",
      success:function(data){
        $("#course").find('option').remove().end();
        // $("#course").append($("<option></option>").val('').html('All'));
        for(var i=0; i<data.length;i++)
          $("#course").append($("<option></option>").val(data[i].id).html(data[i].course_name));            
      }
    });

});
$('#add-open-city').on('click', function() {
  if($('#city').val()=="" || $('#city').val()==null)
    alert('Please select a city');
  else{
    $.ajax({
      type : "POST",
      async: false,
      url: base_url+"teacher/add_open_city_course",
      data: 'city='+$('#city').val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200")
          $('#city-course tbody').append('<tr id="city-'+data.id+'"><td>'+data.province+'</td><td>'+data.city+'</td><td><button class="btn btn-default btn-block btn-flat" onclick="remove_open_city(\''+data.id+'\')"><span class="fa fa-minus-circle" style="color:red"></span> <?php echo $this->lang->line('delete') ?></button></td></tr>');
        else if(data.status=="204")
          alert(data.message);
        else
          alert('Undefined error number.');
      }
    });
  }
})

function remove_open_city(id){
  $.ajax({
    type : "POST",
    async: false,
    url: base_url+"teacher/remove_open_city_course",
    data: 'id='+id,
    dataType: "json",
    success:function(data){
      if(data.status=="200")
        $('#city-'+id).remove();
      else
        alert(data.status);
    }
  });
}

$('#add-open-course').on('click', function() {
  $.ajax({
    type : "POST",
    async: false,
    url: base_url+"teacher/add_open_course",
    data: $('#form-add-course').serialize(),
    dataType: "json",
    success:function(data){
      if(data.status=="200")
        $('#open-course tbody').append('<tr id="course-'+data.id+'"><td><strong>'+data.course_name+'</strong><br><?php echo $this->lang->line('category')?>: '+data.program_name+'</td><td>'+data.days+'<br><?php echo $this->lang->line('session')?>: '+data.session+' <?php echo $this->lang->line('hour')?></td><td><button class="btn btn-default btn-block btn-flat" onclick="remove_open_course(\''+data.id+'\')"><span class="fa fa-minus-circle" style="color:red"></span> <?php echo $this->lang->line('delete') ?></button></td></tr>');
      else
        alert(data.message);
    }
  });
})

function remove_open_course(id){
  $.ajax({
    type : "POST",
    async: false,
    url: base_url+"teacher/remove_open_course",
    data: 'id='+id,
    dataType: "json",
    success:function(data){
      if(data.status=="200")
        $('#course-'+id).remove();
      else
        alert(data.status);
    }
  });
}

function request_remove_open_city(id){
  $.ajax({
    type : "POST",
    async: false,
    url: base_url+"teacher/request_remove_open_course",
    data: 'id='+id,
    dataType: "json",
    success:function(data){
      if(data.status=="200")
        $('#course-'+id).remove();
      else
        alert(data.status);
    }
  });
}
</script>