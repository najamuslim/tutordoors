    <?php $this->load->view('iknow/wizard_order') ?>
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="error">
                <p class="ohh"><?php echo $this->lang->line('order_success_string_1') ?></p>
                <p class="ohh"><?php echo $this->lang->line('order_success_string_2') ?></p>
                <!-- <p class="away">Take me away <span class="color">or</span> Report This</p> -->
                <a class="btn-style back-home" href="<?php echo base_url() ?>"><?php echo $this->lang->line('back_to_home') ?></a>
                <p class="or-big"><?php echo $this->lang->line('or_find_other_course') ?></p>
            </div>
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
            </div>
        </div>
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

      });
    </script>