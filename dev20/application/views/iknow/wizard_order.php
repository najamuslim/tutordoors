	<div class="wizard-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <ul class="wizard-order" style="margin-bottom:20px">
                        <li><a href="#" <?php if($this->session->userdata('step_teacher_profile')=="off") echo 'class="disabled"';?>>1. <?php echo $this->lang->line('select_tutor')?></a></li>
                        <li><a href="#" <?php if($this->session->userdata('step_form_order')=="off") echo 'class="disabled"';?>>2. <?php echo $this->lang->line('select_course')?></a></li>
                        <li><a href="#" <?php if($this->session->userdata('step_review_order')=="off") echo 'class="disabled"';?>>3. <?php echo $this->lang->line('review_order')?></a></li>
                        <li><a href="#" <?php if($this->session->userdata('step_order_finish')=="off") echo 'class="disabled"';?>>4. <?php echo $this->lang->line('finish')?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>