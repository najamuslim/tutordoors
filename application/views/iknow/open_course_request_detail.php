    <!-- Modal -->
    <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-reject">
                    <input type="hidden" name="order-id" id="order-id-reject" />
                    <input type="hidden" name="course-id" id="course-id-reject" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('reject')?> ID <span class="replace-title"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <p><?php echo $this->lang->line('are_you_sure_to_reject_this_order') ?></p>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('reason');?></label>
                                <input type="text" class="form-control input-sm" id="reason">
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close')?></button>
                        <button type="button" onclick="reject()" class="btn btn-danger"><?php echo $this->lang->line('confirmation')?></button>
                        <div class="overlay" style="display:none" id="loading-reject">
                            <i class="fa fa-refresh fa-spin fa-2x"></i>
                        </div>
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
                    <h2><?php echo $sub_page_title; ?></h2>
                	<div class="profile-box editing">
                        <h2><?php echo $this->lang->line('course_request_info') ?></h2>
                        <table>
                            <thead>
                                <tr>
                                    <td><?php echo $this->lang->line('id_and_course') ?></td>
                                    <td><?php echo $this->lang->line('course') ?></td>
                                    <td><?php echo $this->lang->line('student_detail') ?></td>
                                    <td><?php echo $this->lang->line('status') ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($order_detail<>false) {
                                    foreach($order_detail->result() as $course){
                                        // get info of the course
                                        $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                                        // get days
                                        $day_string = $this->course_lib->get_days_string($course->days);
                                        // additional modules
                                        $modules = $this->course_lib->get_additional_module($course);
                                ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $course->order_id; ?></strong>
                                        <p><?php echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;?></p>
                                    </td>
                                    <td>
                                        <div class="open-course-detail">
                                            <p><strong><?php echo $this->lang->line('city')?>:</strong> <?php echo $course->city_name; ?></p>
                                            <p><strong><?php echo $this->lang->line('day')?>:</strong> <?php echo $day_string?></p>
                                            <p><strong><?php echo $this->lang->line('session')?>:</strong> <?php echo $course->session_hour.' '.$this->lang->line('hour') ?></p>
                                            <p><strong><?php echo $this->lang->line('face_to_face')?>:</strong> <?php echo $course->class_in_month.' '.$this->lang->line('times') ?></p>
                                            <p><strong><?php echo $this->lang->line('module')?>:</strong> <?php echo ($modules=="" ? "-" : $modules) ?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="open-course-detail">
                                            <p><strong><?php echo $this->lang->line('name')?>:</strong> <?php echo $course->student_fn.' '.$course->student_ln; ?></p>
                                            <p><strong><?php echo $this->lang->line('phone')?>:</strong> <?php echo $course->student_phone; ?></p>
                                            <p><strong><?php echo $this->lang->line('email')?>:</strong> <?php echo $course->student_email; ?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <p id="status-<?php echo $course->order_id.'-'.$course->course_id?>"><strong><?php echo $this->lang->line('status')?>: </strong><?php echo $course->order_course_status ?></p>
                                        <?php if($course->order_course_status=="Open"){?>
                                        <div id="action-<?php echo $course->order_id.'-'.$course->course_id?>">
                                            <p><button type="button" class="btn-style" onclick="confirm('<?php echo $course->order_id?>','<?php echo $course->course_id?>')"><?php echo $this->lang->line('confirmation') ?></button></p>
                                            <p><button type="button" class="reject-button-style" onclick="open_modal_reject('<?php echo $course->order_id?>','<?php echo $course->course_id?>')"><?php echo $this->lang->line('reject') ?></button></p>
                                        </div>
                                        <?php } ?>
                                        <div class="overlay" style="display:none" id="loading-confirm-<?php echo $course->order_id.'-'.$course->course_id?>">
                                            <i class="fa fa-refresh fa-spin fa-2x"></i>
                                        </div>
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
    function confirm(order_id, course_id){
        $('#loading-confirm-'+order_id+'-'+course_id).toggle();
        $.ajax({
          type : "POST",
          url: base_url+'order/teacher_confirm_order_course',
          data: 'order-id='+order_id+'&course-id='+course_id,
          dataType: "json",
          success:function(data){
            if(data.status=="200")
            {
              $('#status-'+order_id+'-'+course_id).text('Status: '+data.message);
              $('#action-'+order_id+'-'+course_id).empty();
            }
            else if(data.status=="204")
            {
              alert(data.message);
            }
            $('#loading-confirm-'+order_id+'-'+course_id).toggle();
          },
          error: function(e) {
            // Schedule the next request when the current one's complete,, in miliseconds
              alert('Error processing your request: '+e.responseText);
              $('#loading-confirm-'+order_id+'-'+course_id).toggle();
            }
        });
    }

    function open_modal_reject(order_id, course_id)
    {
        $('#order-id-reject').val(order_id);
        $('#course-id-reject').val(course_id);
        $('#modal-reject').modal('show');
    }

    function reject(){
        if($('#reason').val()=="")
            alert('<?php echo $this->lang->line('reason_required')?>');
        else
        {
            $('#loading-reject').toggle();
            $.ajax({
              type : "POST",
              url: base_url+'order/reject_course_order',
              data: 'order-id='+$('#order-id-reject').val()+'&course-id='+$('#course-id-reject').val()+'&reason='+$('#reason').val(),
              dataType: "json",
              success:function(data){
                if(data.status=="200")
                {
                  $('#status-'+$('#order-id-reject').val()+'-'+$('#course-id-reject').val()).text('Status: '+data.message);
                  $('#action-'+$('#order-id-reject').val()+'-'+$('#course-id-reject').val()).empty();
                  $('#modal-reject').modal('hide');
                }
                else if(data.status=="204")
                {
                  alert(data.message);
                }
                $('#loading-reject').toggle();
              },
              error: function(e) {
                // Schedule the next request when the current one's complete,, in miliseconds
                  alert('Error processing your request: '+e.responseText);
                  $('#loading-reject').toggle();
                }
            });
        }
    }
</script>