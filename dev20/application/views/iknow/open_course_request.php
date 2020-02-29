    <!-- Modal -->
    <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" id="form" method="post" action="<?php echo base_url('order/teacher_confirm_order_course');?>">
                    <input type="hidden" name="order-id" id="order-id-confirm" />
                    <input type="hidden" name="course-id" id="course-id-confirm" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirmation')?> ID <span class="replace-title"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <p><?php echo $this->lang->line('are_you_sure_to_confirm_this_order') ?></p>
                            <!-- <div class="form-group">
                                <label for="input-name"><?php echo $this->lang->line('course_address_held');?></label>
                                <textarea class="form-control input-sm" id="address-held" name="address-held" placeholder="" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="input-name"><?php echo $this->lang->line('date_start');?></label>
                                <input type="text" class="form-control input-sm" id="date-start" name="date-start" placeholder="" required>
                            </div> -->
                        </div><!-- /.box-body -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close')?></button>
                        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('confirmation')?></button>
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
                                    <td><?php echo $this->lang->line('id') ?> / <?php echo $this->lang->line('city') ?></td>
                                    <td><?php echo $this->lang->line('course') ?></td>
                                    <td><?php echo $this->lang->line('student_detail') ?></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($open_request<>false) {
                                    foreach($open_request->result() as $order){                                        
                                ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $order->order_id; ?></strong>
                                        <p><?php //echo $course_info['root'].' - '.$course_info['course'];?></p>
                                        <p><?php echo $order->city_name; ?></p>
                                        <p><strong><?php echo $this->lang->line('order_time')?>:</strong><br> <?php echo date_format(new DateTime($order->entry_date), 'd M Y H:i')?></p>
                                    </td>
                                    <td>
                                        <?php 
                                        // get courses by order id
                                        $courses = $this->Order_m->get_order_courses($order->order_id);
                                        if($courses<>false)
                                        {
                                            echo '<ol>';
                                            foreach($courses->result() as $course){
                                                // get info of the course
                                                $course_info = $this->Course_m->get_courses(array('c.id' => $course->course_id));
                                                echo '<li>'.$course_info->row()->program_name.' - '.$course_info->row()->course_name.'</li>';
                                            }
                                            echo '</ol>';
                                        }
                                        ?>
                                        <p><?php echo '<strong>'.$this->lang->line('at').':</strong> '.($order->address_course_held=="" ? "-" : $order->address_course_held); ?></p>
                                        <p><strong><?php echo $this->lang->line('date_start')?>:</strong> <?php echo date_format(new DateTime($order->start_date), 'd M Y')?></p>
                                    </td>
                                    <td>
                                        <div class="open-course-detail">
                                            <p><strong><?php echo $this->lang->line('name')?>:</strong> <?php echo $order->first_name.' '.$order->last_name; ?></p>
                                            <p><strong><?php echo $this->lang->line('phone')?>:</strong> <?php echo $order->phone_1; ?></p>
                                            <p><strong><?php echo $this->lang->line('email')?>:</strong> <?php echo $order->email_login; ?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <p><a href="<?php echo base_url('teacher/open_course_request_detail/'.$order->order_id)?>"><button class="btn-style"><i class="fa fa-search"></i> <?php echo $this->lang->line('open') ?></button></a></p>
                                        <!-- <p><a href="<?php echo base_url('order/cancel_order/'.$order->order_id);?>"><button class="reject-button-style"><i class="fa fa-times"></i> <?php echo $this->lang->line('reject') ?></button></a></p> -->
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
    function do_action_modal(id){
        var id_array = id.split('-');
        $('#order-id-confirm').val(id_array[0]);
        $('#course-id-confirm').val(id_array[1]);
        $('.replace-title').text(id_array[0]);
        $('#modal-confirm').modal('show');
    }

    $(function () {
        $('#date-start').datetimepicker({
          format: 'YYYY-MM-DD'
        });
      });
</script>