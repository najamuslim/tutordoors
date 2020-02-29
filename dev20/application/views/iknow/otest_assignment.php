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
                                    <td><?php echo $this->lang->line('test_assignment_id') ?></td>
                                    <td><?php echo $this->lang->line('test_name') ?></td>
                                    <td><?php echo $this->lang->line('test_related_course') ?></td>
                                    <td><?php echo $this->lang->line('test_take_this') ?></td>
                                    <td><?php echo $this->lang->line('test_result') ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($assignments<>false) {
                                    foreach($assignments->result() as $row){
                                        ?>
                                <tr>
                                    <td><?php echo $row->assignment_id?></td>
                                    <td><strong><?php echo $row->test_id?></strong> - <?php echo $row->test_name; ?></td>
                                    <td>
                                        <?php 
                                            if($row->course_id <> ""){
                                                // get info of the course
                                                $course_info = $this->Course_m->get_courses(array('c.id' => $row->course_id));
                                                
                                                echo $course_info->row()->program_name.' - '.$course_info->row()->course_name;
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $taker_data = $this->otest->get_taker_data(array('assignment_id' => $row->assignment_id));
                                            if($taker_data==false)
                                            {
                                        ?>
                                        <a href="<?php echo base_url('otest/preview/'.$row->assignment_id.'/'.$row->test_id) ?>"><i class="fa fa-play"></i></a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($taker_data<>false)
                                            {
                                                $taker = $taker_data->row();
                                        ?>
                                        <p><?php echo date_format(new DateTime($taker->taken_time), 'd M Y H:i')?></p>
                                        <p><?php echo strtoupper($taker->test_result)?></p>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">Total: <?php echo ($assignments<>false ? $assignments->num_rows() : '0').' '.ucwords($this->lang->line('test_assignment')); ?></td>
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