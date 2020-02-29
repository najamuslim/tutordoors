          <?php 
          // get provinces
          $provinces = $this->Location_m->get_province(); 
 
          // get root course category
          $root_courses = $this->Content_m->get_root_category('course');
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
          <div class="panel-group" id="accordion">
            <div class="panel panel-default profile-box edit-profile">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse-dashboard"><span class="fa fa-dashboard">
                    </span><?php echo $this->lang->line('dashboard') ?> 
                  <?php 
                      if($this->session->userdata('level')=="student") echo $this->lang->line('student');
                      else if($this->session->userdata('level')=="teacher") echo $this->lang->line('teacher');
                      ?></a>
                </h4>
              </div>
              <div id="collapse-dashboard" class="panel-collapse collapse <?php if($gm=="dashboard") echo "in" ?>">
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <td>
                        <span class="fa fa-dashboard text-primary"></span>
                        <a <?php if($am=="dashboard") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('my_account'); ?>"><?php echo $this->lang->line('dashboard') ?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-user text-success"></span>
                        <a <?php if($am=="edit_profile") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('users/view_profile'); ?>"><?php echo $this->lang->line('profile') ?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-key text-info"></span>
                        <a <?php if($am=="change_password") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('users/u_change_password'); ?>"><?php echo $this->lang->line('change_password') ?>
                        </a>
                      </td>
                    </tr>
                    <?php if($this->session->userdata('level')=="teacher") {?>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="edit_open_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/edit_open_course'); ?>"><?php echo $this->lang->line('city_and_course') ?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-edit text-success"></span>
                        <a <?php if($am=="online_test") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('otest/assignment_list'); ?>"><?php echo $this->lang->line('online_test') ?>
                        </a>
                      </td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td>
                        <span class="fa fa-envelope-o text-success"></span>
                        <a <?php if($am=="message") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/messages'); ?>"><?php echo $this->lang->line('notification') ?> <span class="label label-info">(<?php echo ($unread_message>0 ? $unread_message : 0);?>)</span>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-sign-out text-success"></span>
                        <a href="<?php echo base_url('logout'); ?>"><?php echo $this->lang->line('signout') ?></a>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="panel panel-default profile-box edit-profile">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse-course"><span class="fa fa-info">
                  </span><?php echo $this->lang->line('course_info') ?></a>
                </h4>
              </div>
              <div id="collapse-course" class="panel-collapse collapse <?php if($gm=="course") echo "in" ?>">
                <div class="panel-body">
                  <table class="table">
                    <?php if($this->session->userdata('level')=="teacher") {?>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="teach_schedule") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/teach_schedule'); ?>"><?php echo $this->lang->line('course_schedule') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="new_course_request") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/open_course_request'); ?>"><?php echo $this->lang->line('course_request') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="running_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/running_course'); ?>"><?php echo $this->lang->line('course_running') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="completed_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/completed_course'); ?>"><?php echo $this->lang->line('course_completed') ?></a>
                      </td>
                    </tr>
                    <?php } 
                    else if($this->session->userdata('level')=="student") {
                      ?>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="teach_schedule") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('student/course_schedule'); ?>"><?php echo $this->lang->line('course_schedule') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="student_course_request") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('student/course_request'); ?>"><?php echo $this->lang->line('course_request') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="running_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/running_course'); ?>"><?php echo $this->lang->line('course_running') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="completed_course") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/completed_course'); ?>"><?php echo $this->lang->line('course_completed') ?></a>
                      </td>
                    </tr>
                    <?php } ?>
                  </table>
                </div>
              </div>
            </div>

            <div class="panel panel-default profile-box edit-profile">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse-mailbox"><span class="fa fa-envelope">
                  </span><?php echo $this->lang->line('message') ?></a>
                </h4>
              </div>
              <div id="collapse-mailbox" class="panel-collapse collapse <?php if($gm=="mailbox") echo "in" ?>">
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <td>
                        <span class="fa fa-edit text-success"></span>
                        <a <?php if($am=="compose") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('mailbox/compose'); ?>"><?php echo $this->lang->line('mailbox_compose') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-download text-success"></span>
                        <a <?php if($am=="mailbox_inbox") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('mailbox/inbox'); ?>"><?php echo $this->lang->line('mailbox_inbox') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-envelope-o text-success"></span>
                        <a <?php if($am=="mailbox_outbox") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('mailbox/outbox'); ?>"><?php echo $this->lang->line('mailbox_outbox') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-file-o text-success"></span>
                        <a <?php if($am=="mailbox_draft") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('mailbox/draft'); ?>"><?php echo $this->lang->line('mailbox_draft') ?><a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-trash-o text-success"></span>
                        <a <?php if($am=="mailbox_trash") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('mailbox/trash'); ?>"><?php echo $this->lang->line('mailbox_trash') ?><a>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div class="panel panel-default profile-box edit-profile">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse-payment"><span class="fa fa-money">
                  </span><?php echo $this->lang->line('payment') ?></a>
                </h4>
              </div>
              <div id="collapse-payment" class="panel-collapse collapse <?php if($gm=="payment") echo "in" ?>">
                <div class="panel-body">
                  <table class="table">
                    <?php if($this->session->userdata('level')=="teacher") {?>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="set_bank") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/set_bank'); ?>"><?php echo $this->lang->line('bank_account') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="teacher_comm") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('teacher/commission'); ?>"><?php echo $this->lang->line('commission') ?></a>
                      </td>
                    </tr>
                    <?php } 
                    else if($this->session->userdata('level')=="student") {
                      ?>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="invoice") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('student/invoice'); ?>"><?php echo $this->lang->line('invoice') ?></a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fa fa-compass text-success"></span>
                        <a <?php if($am=="payment_confirmation") echo 'style="padding-left: 15px;color:#00A685;font-weight:600"';?> href="<?php echo base_url('frontpage/payment_confirmation'); ?>"><?php echo $this->lang->line('confirmation') ?><a>
                      </td>
                    </tr>
                    <?php } ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
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