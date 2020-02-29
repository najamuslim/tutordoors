    <!--CONTANT START-->
    <div class="contant">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-push-3">
                    <!--EDIT GENERAL INFO START-->
                    <div class="profile-box padding30">
                        <?php if(isset($selected_bank)) {
                            echo '<h2>'.$this->lang->line('transfer_payment_to').':</h2>';
                            echo '<p>Bank '.$selected_bank->row()->bank_name.'</p>';
                            echo '<p>'.$this->lang->line('bank_account_number').': '.$selected_bank->row()->bank_account_number.'</p>';
                            echo '<p>'.$this->lang->line('bank_holder_name').': '.$selected_bank->row()->bank_holder_name.'</p>';
                            echo '<p>'.$this->lang->line('bank_branch').': '.$selected_bank->row()->bank_branch.' '.$selected_bank->row()->bank_city.'</p>';
                            echo '<br><br>';
                            } ?>

                        <?php if($this->session->flashdata('payment_done')=="") {?>
                        <h2><?php echo $this->lang->line('confirm_payment') ?></h2>
                        <?php } 
                        else if($this->session->flashdata('payment_done')<>"" and is_array($this->session->flashdata('payment_done'))) { // jika ada error
                            foreach($this->session->flashdata('payment_done') as $error){?>
                        <h2 style="color:#FF0000"> <?php echo $error; ?> </h2>
                        <?php }
                        } else if($this->session->flashdata('payment_done')<>"" and !is_array($this->session->flashdata('payment_done'))) {?>
                        <h2 style="color:#0000FF"> <?php echo $this->session->flashdata('payment_done'); ?> </h2>
                        <?php } ?>

                        
                        
                        <form method="POST" action="<?php echo base_url('order/submit_payment_conf');?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label><?php echo $this->lang->line('invoice_id') ?> <span class="required">*</span></label>
                                      <input class="form-control" type="text" name="invoice-id" value="<?php echo $this->input->get('inv', TRUE);?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('bank_destination') ?> <span class="required">*</span></label>
                                        <?php if(isset($selected_bank)) {?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label><?php echo $selected_bank->row()->bank_name.' - '.$selected_bank->row()->bank_account_number; ?></label>
                                        <input type="hidden" name="bank-dest" value="<?php echo $selected_bank->row()->bank_id; ?>">
                                        <?php } else {?>
                                        <br>
                                        <select name="bank-dest" id="bank-dest" class="form-control" required>
                                            <?php if($banks<>false) {
                                                foreach($banks->result() as $bank){?>
                                                <option value="<?php echo $bank->bank_id;?>"><?php echo $bank->bank_name; ?></option>
                                            <?php }} ?>
                                        </select>
                                        <?php }?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('sender_name') ?> <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('nominal') ?> <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="total" required>
                                    </div>
                                    <label><?php echo $this->lang->line('transfer_date') ?> <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control" id="default-datepicker" name="transfer-date" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('notes') ?></label>
                                        <textarea class="form-control" name="note"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-style"><?php echo $this->lang->line('submit') ?></button>
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