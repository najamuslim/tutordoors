    <!--BANNER START-->
    <div class="page-heading">
        <div class="container">
            <h2><?php echo $sub_page_title; ?></h2>
            <!-- <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</p> -->
        </div>
    </div>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-push-3">
                    <!--EDIT GENERAL INFO START-->
                    <div class="profile-box editing">
                        <h2><?php echo $this->lang->line('dealing_course_schedule') ?></h2>
                        <form class="form-horizontal" id="form-confirm-order" action="<?php echo base_url('order/confirm_course');?>">
                            <input type="hidden" name="order-id" value="<?php echo $this->uri->segment(3);?>"> 
                            <ul>
                                <?php $this->load->model('Order_m', 'order'); ?>
                                <li>
                                    <strong><?php echo $this->lang->line('id') ?></strong><br>
                                    <label><?php echo $course->order_id; ?></label>
                                </li>
                                <li>
                                    <strong><?php echo $this->lang->line('course') ?></strong><br>
                                    <label><?php 
                                        $order = $this->Order_m->get_order_course_by_id($course->order_id); 
                                        echo str_replace(',', ', ', $order->courses);
                                        ?></label>
                                </li>
                                <li>
                                    <strong><?php echo $this->lang->line('day_requested') ?></strong><br>
                                    <label><?php echo str_replace(',', ', ', $course->days_selected)?></label>
                                </li>
                                <li>
                                    <strong><?php echo $this->lang->line('hour_requested') ?></strong><br>
                                    <label><?php echo str_replace(',', ', ', $course->time_selected)?></label>
                                </li>
                                <li>
                                    <strong><?php echo $this->lang->line('student_name') ?></strong><br>
                                    <label><?php echo $course->student_fn.' '.$course->student_ln; ?></label>
                                </li>
                                <li>
                                    <label><?php echo $this->lang->line('course_address_held') ?></label><br>
                                    <input type="text" class="form-control" name="address" placeholder="<?php echo $this->lang->line('course_address_held_example') ?>"><br><br>
                                </li>
                            </ul>

                            <ul>
                                <li><p id="nothing"></p></li>
                                <li><p id="nothing"></p></li>
                                <li class="fw">
                                    <button type="button" class="btn-style" onclick="goBack()"><?php echo $this->lang->line('back') ?></button> &nbsp;&nbsp;
                                    <a href="<?php echo base_url('order/cancel_course_order/'.$this->uri->segment(3));?>" class="btn-style"><?php echo $this->lang->line('reject') ?></a> &nbsp;&nbsp;
                                    <button id="submit-confirm-order" type="button" class="btn-style"><?php echo $this->lang->line('confirmation') ?></button>
                                </li>
                                <li>
                                    <div class="overlay" style="display:none" id="loading-confirm-order">
                                        <i class="fa fa-refresh fa-spin fa-2x"></i>
                                    </div>
                                </li>
                                <li>
                                    <p class="pull-right replace-error-message" style="color:#FF0000"></p>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <!--EDIT GENERAL INFO END-->
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
    $('#submit-confirm-order').on('click', function(){
      $('#loading-confirm-order').toggle();
      $.ajax({
        type : "POST",
        url: base_url+'order/confirm_course',
        data:$('#form-confirm-order').serialize(),
        async: false,
        dataType: "json",
        success: function(data) {
          if(data.status=="200")
            window.location.href = base_url+'teacher/open_course_request/';
          else if(data.status=="301")
            $('.replace-error-message').html(data.message);
        },
        error: function(e) {
        // Schedule the next request when the current one's complete,, in miliseconds
          alert('Error processing your request: '+e.responseText);
        }
      });
      $('#loading-confirm-order').toggle();
    });
</script>