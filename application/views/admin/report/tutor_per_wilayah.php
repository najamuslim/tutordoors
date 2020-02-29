		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
		    <!-- Content Header (Page header) -->
		  <section class="content-header">
				<h1>
					Jumlah Tutor per Propinsi
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
		  	<h3>Verified Tutor</h3>
				<div class="row">
					<div class="col-md-6">
						<!-- Chart -->
						<div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">Chart</h3>
              </div>
              <div class="box-body chart-responsive">
                <div class="chart" id="bar-chart-verified" style="height: 300px;"></div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
					</div>
					<div class="col-md-6">
						<!-- Tabular -->
						<div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Tabular Data</h3>
              </div>
              <div class="box-body">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Propinsi</th>
                    <th>Jumlah</th>
                    <th>Detail per Kota</th>
                  </tr>
                	<?php 
                	$cnt = 0;
                	foreach($verified->result() as $data){
                		$cnt++;
                	 ?>
                  <tr>
                  	<td>
                  		<?php echo $cnt; ?>
                  	</td>
                    <td>
                    	<?php echo $data->province_name ?>
                    </td>
                    <td>
                      <?php echo $data->total ?>
                    </td>
                    <td>
                    	<a href="<?php echo base_url('teacher/report_wilayah_kota?pid='.$data->province_id.'&vf=1') ?>" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>
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

			<!-- Main content -->
		  <section class="boxku">
		  	<h3>Unverified Tutor</h3>
				<div class="row">
					<div class="col-md-6">
						<!-- Chart -->
						<div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">Chart</h3>
              </div>
              <div class="box-body chart-responsive">
                <div class="chart" id="bar-chart-unverified" style="height: 300px;"></div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
					</div>
					<div class="col-md-6">
						<!-- Tabular -->
						<div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Tabular Data</h3>
              </div>
              <div class="box-body">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Propinsi</th>
                    <th>Jumlah</th>
                    <th>Detail per Kota</th>
                  </tr>
                	<?php 
                	$cnt = 0;
                	if($unverified<>false)
	                	foreach($unverified->result() as $data){
	                		$cnt++;
                	 ?>
                  <tr>
                  	<td>
                  		<?php echo $cnt; ?>
                  	</td>
                    <td>
                    	<?php echo $data->province_name ?>
                    </td>
                    <td>
                      <?php echo $data->total ?>
                    </td>
                    <td>
                    	<a href="<?php echo base_url('teacher/report_wilayah_kota?pid='.$data->province_id.'&vf=0') ?>" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>
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
		<script>
			// verified chart
			var data_verified = [];
			<?php 
			foreach($verified->result() as $data) {
			?>
				data_verified.push({'x': '<?php echo $data->province_name ?>', 'value': <?php echo $data->total ?>});
			<?php 
				}
			?>
			
      var bar = new Morris.Bar({
        element: 'bar-chart-verified',
        resize: true,
        data: data_verified,
        barColors: ['#00a65a'],
        xkey: 'x',
        ykeys: ['value'],
        labels: ['Jumlah Tutor'],
        hideHover: 'auto'
      });

      // verified chart
			var data_unverified = [];
			<?php 
			if($unverified<>false)
			foreach($unverified->result() as $data) {
			?>
				data_unverified.push({'x': '<?php echo $data->province_name ?>', 'value': <?php echo $data->total ?>});
			<?php 
				}
			?>
			
      var bar = new Morris.Bar({
        element: 'bar-chart-unverified',
        resize: true,
        data: data_unverified,
        barColors: ['#f56954'],
        xkey: 'x',
        ykeys: ['value'],
        labels: ['Jumlah Tutor'],
        hideHover: 'auto'
      });
		</script>
	</body>
</html>