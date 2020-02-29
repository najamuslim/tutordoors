    <!-- Modal -->
    <div class="modal fade" id="modal-correction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" id="form" method="post" action="<?php echo base_url('course/edit_absence_time');?>">
                    <input type="hidden" name="id" id="correct-id" />
                    <input type="hidden" name="enroll" id="correct-enroll-id" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirmation')?> ID <span class="replace-title"></span></h4>
                    </div>
                    <div class="modal-body">
                      <div class="box-body">
                        <p><?php echo $this->lang->line('correct_the_time_only_if_mistype_by_tutor') ?></p>
                        <div class="form-group">
                          <label><?php echo $this->lang->line('teach_start_time') ?></label>
                          <input type="text" id="correct-time-start" class="form-control" name="start-time">
                        </div>
                        <div class="form-group">
                          <label><?php echo $this->lang->line('teach_end_time') ?></label>
                          <input type="text" id="correct-time-end" class="form-control" name="end-time">
                        </div>
                      </div><!-- /.box-body -->
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close')?></button>
                      <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('correct')?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal -->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
      	<div class="row">
        	<div class="col-md-9 col-md-push-3">
            <!-- <h2><?php echo $sub_page_title; ?></h2> -->
            <h4><?php echo $this->lang->line('enroll_id') ?>: <?php echo $this->uri->segment(3) ?></h4>
            <h4><?php echo $this->lang->line('course') ?>: <?php echo $course_name ?></h4>
            <?php if($level=="student") {?>
            <h4><?php echo $this->lang->line('teacher') ?>: <?php echo $teacher_name ?></h4>
            <?php } else {?>
            <h4><?php echo $this->lang->line('student') ?>: <?php echo $student_name ?></h4>
            <?php } ?>
          	<div class="profile-box editing">
              <h2><?php echo $this->lang->line('course_monitoring') ?></h2>
              <p><?php echo $this->lang->line('hint') ?>:</p>
              <ol>
                <li><?php echo $this->lang->line('course_monitoring_hint_1') ?></li>
                <?php if($this->session->userdata('level')=="teacher") {?>
                <li><?php echo $this->lang->line('course_monitoring_hint_2') ?></li>
                <li><?php echo $this->lang->line('course_monitoring_hint_3') ?></li>
                <li><?php echo $this->lang->line('course_monitoring_hint_4') ?></li>
                <?php } ?>
              </ol>
              
            </div>
            <?php if($this->session->userdata('level')=="teacher") {?>
            <div class="profile-box padding30">
              <form action="<?php echo base_url('course/add_absence');?>" method="POST">
                <h3><?php echo $this->lang->line('insert_new_absence') ?></h3>
                <input type="hidden" name="enroll" value="<?php echo $this->uri->segment(3)?>">
                <div class="row">
                  <div class="col-md-6">
                    <label><?php echo $this->lang->line('teach_date') ?></label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      <input type="text" class="form-control" id="default-datepicker" name="teach-date">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label><?php echo $this->lang->line('teach_start_time') ?></label>
                      <input type="text" id="time-start" class="form-control" name="start-time">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label><?php echo $this->lang->line('teach_end_time') ?></label>
                      <input type="text" id="time-end" class="form-control" name="end-time">
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn-style" style="margin-top:10px"><?php echo $this->lang->line('submit') ?></button>
              </form>
              <!-- <a href="<?php echo base_url('course/complete_course/'.$course->enroll_id) ?>"><i class="fa fa-check fa-3x"></i> Complete</a> -->
            </div>
            <?php } ?>
            <div class="table-data">
              <table id="default-table" class="table table-bordered table-striped my-table">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('teach_date') ?></th>
                    <th><?php echo $this->lang->line('absence_by_student') ?></th>
                    <th><?php echo $this->lang->line('absence_by_teacher') ?></th>
                    <th><?php echo $this->lang->line('action') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if($monitoring<>false) {
                    foreach($monitoring->result() as $course){?>
                  <tr>
                    <td><?php echo date_format(new DateTime($course->teach_date), 'd M Y').' '.date_format(new DateTime($course->time_start), 'H:i').' - '.date_format(new DateTime($course->time_end), 'H:i'); ?></td>
                    <td>
                      <?php 
                        if($course->student_entry=='true') echo '<i class="fa fa-check fa-3x" style="color: #0000FF"></i>';
                        if($course->student_entry_timestamp<>"")
                          echo '<br>'.date_format(new DateTime($course->student_entry_timestamp), 'd M Y H:i'); 
                      ?>
                    </td>
                    <td>
                      <?php 
                        if($course->teacher_entry=='true') echo '<i class="fa fa-check fa-3x" style="color: #0000FF"></i>';
                        if($course->teacher_entry_timestamp<>"")
                          echo '<br>'.date_format(new DateTime($course->teacher_entry_timestamp), 'd M Y H:i'); 
                      ?>
                    </td>
                    <td>
                        <a href="<?php echo base_url('course/set_absence?mon='.$course->monitoring_id.'&enr='.$course->enroll_id); ?>"><i class="fa fa-check-square"></i> <?php echo $this->lang->line('absence_mark') ?></a>
                        <br>
                        <?php if($this->session->userdata('level')=="student") {?>
                        <button type="button" class="btn-style" onclick="open_correction_modal(<?php echo $course->monitoring_id?>)"><?php echo $this->lang->line('course_monitoring_make_time_correction')?></button>
                        <?php } ?>
                    </td>
                  </tr>
                  <?php }} ?>
                </tbody>
              </table>
            </div>
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
  $(function () {
    $('#time-start, #time-end, #correct-time-start, #correct-time-end').datetimepicker({
      format: 'HH:mm'
    });
  });

  function open_correction_modal(id){
    $.ajax({
      type : "GET",
      url: base_url+'course/get_monitoring_time',
      data:'mon='+id,
      async: false,
      dataType: "json",
      success: function(data) {
        $('#correct-time-start').val(data.time_start);
        $('#correct-time-end').val(data.time_end);
        $('#correct-enroll-id').val(data.enroll_id);
        $('#correct-id').val(id);
      },
      error: function(e) {
      // Schedule the next request when the current one's complete,, in miliseconds
        alert('Error processing your request: '+e.responseText);
      }
    });
    $('#modal-correction').modal('show');
  }
</script>