    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-9 col-md-push-3">
                    <h2><?php echo $sub_page_title; ?></h2>
                	<div class="profile-box editing">
                        <!-- <h2>Pesan</h2> -->
                        <table>
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><?php echo $this->lang->line('from') ?></td>
                                    <td><?php echo $this->lang->line('to') ?></td>
                                    <td><?php echo $this->lang->line('subject') ?></td>
                                    <td><?php echo $this->lang->line('message') ?></td>
                                    <td><?php echo $this->lang->line('time') ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($messages<>false) {
                                    foreach($messages->result() as $message){
                                        ?>
                                <tr>
                                    <td width="20px"><?php 
                                            if($message->sender_id==$this->session->userdata('userid')) echo '<i class="fa fa-share" style="color: lime"></i>';
                                            else if($message->receiver_id==$this->session->userdata('userid')) echo '<i class="fa fa-reply" style="color: blue"></i>';
                                        ?>
                                    </td>
                                    <td><?php echo ($message->sender_fn <> "" ? $message->sender_fn.' '.$message->sender_ln : $message->sender_id); ?></td>
                                    <td><?php echo ($message->receiver_fn <> "" ? $message->receiver_fn.' '.$message->receiver_ln : $message->receiver_id); ?></td>
                                    <td><?php echo $message->title; ?></td>
                                    <td><?php echo $message->content; ?></td>
                                    <td><?php echo date_format(new DateTime($message->notif_timestamp), 'd M Y H:i:s'); ?></td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">Total: <?php echo ($messages<>false ? $messages->num_rows() : '0').' '.ucwords($this->lang->line('message')); ?></td>
                                    <!-- <td></td>
                                    <td>pesan</td> -->
                                </tr>
                            </tfoot>
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