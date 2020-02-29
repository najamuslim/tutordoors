    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-9 col-md-push-3">
                    <h2><?php echo $sub_page_title; ?></h2>
                	<div class="profile-box editing">
                        <h2><?php echo $this->lang->line('commission_history') ?></h2>
                        <table>
                            <thead>
                                <tr>
                                    <td><?php echo $this->lang->line('period') ?></td>
                                    <td><?php echo $this->lang->line('payroll_id') ?></td>
                                    <td><?php echo $this->lang->line('salary_per_unit_hour') ?></td>
                                    <td><?php echo $this->lang->line('total_hours_teaching_course') ?></td>
                                    <td><?php echo $this->lang->line('total_salary') ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($commission<>false) {
                                    foreach($commission->result() as $comm){?>
                                <tr>
                                    <td><?php echo $comm->salary_period; ?></td>
                                    <td><?php echo $comm->payroll_id; ?></td>
                                    <td><?php echo $comm->salary_per_hour; ?></td>
                                    <td><?php echo $comm->total_hours; ?></td>
                                    <td>IDR <?php echo number_format($comm->total_salary, 0, ',', '.'); ?></td>
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