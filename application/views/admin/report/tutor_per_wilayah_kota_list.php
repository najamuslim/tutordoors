		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
		    <!-- Content Header (Page header) -->
		  <section class="content-header">
				<h1>
					Data Tutor di <?php echo $city_name ?>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="#">User Management</a></li>
					<li><a href="#">Tutor</a></li>
					<li class="active"><a href="#">Tutor per Wilayah</a></li>
				</ol>
		  </section>
			
			<!-- Main content -->
		  <section class="boxku">
        <h3><?php echo $verification_title ?> Tutor</h3>
				<div class="row">
					<div class="col-md-12">
						<!-- Tabular -->
						<div class="box box-info">
              <!-- <div class="box-header">
                <h3 class="box-title">Tabular Data</h3>
              </div> -->
              <div class="box-body">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>User ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Detail</th>
                  </tr>
                	<?php 
                	$cnt = 0;
                  if($tutors <> false)
                  	foreach($tutors->result() as $data){
                  		$cnt++;
                	 ?>
                  <tr>
                  	<td>
                  		<?php echo $cnt; ?>
                  	</td>
                    <td>
                      <a href="<?php echo base_url('teacher/detail/'.$data->user_id) ?>"><?php echo $data->user_id ?></a>
                    </td>
                    <td>
                    	<a href="<?php echo base_url('teacher/detail/'.$data->user_id) ?>"><?php echo $data->first_name.' '.$data->last_name ?></a>
                    </td>
                    <td>
                      <a href="<?php echo base_url('teacher/detail/'.$data->user_id) ?>"><?php echo $data->email_login ?></a>
                    </td>
                    <td>
                    	<a href="<?php echo base_url('teacher/detail/'.$data->user_id) ?>" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>
                    </td>
                  </tr>
                	<?php  
                	}
                	?>
                </table>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
					</div>
				</div>
			</section>
				  
		</div><!-- /.content-wrapper -->

		<?php $this->load->view('admin/footer');?>
	</body>
</html>