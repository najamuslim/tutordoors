		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
		    <!-- Content Header (Page header) -->
		  <section class="content-header">
				<h1>
					Jumlah Tutor per Kota di <?php echo $province_name ?>
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
						<!-- Chart -->
						<div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">Chart</h3>
              </div>
              <div class="box-body chart-responsive">
                <div class="chart" id="bar-chart" style="height: 300px;"></div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
					</div>
					<div class="col-md-12">
						<!-- Tabular -->
						<div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Tabular Data</h3>
              </div>
              <div class="box-body">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Kota</th>
                    <th>Jumlah</th>
                    <th>List Tutor</th>
                  </tr>
                	<?php 
                	$cnt = 0;
                  if($data_kota <> false)
                  	foreach($data_kota->result() as $data){
                  		$cnt++;
                	 ?>
                  <tr>
                  	<td>
                  		<?php echo $cnt; ?>
                  	</td>
                    <td>
                    	<?php echo $data->city_name ?>
                    </td>
                    <td>
                      <?php echo $data->total ?>
                    </td>
                    <td>
                    	<a href="<?php echo base_url('teacher/report_wilayah_list_tutor?cid='.$data->city_id.'&vf='.$this->input->get('vf', true)) ?>" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>
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
			//BAR CHART
			var data_in_kota = [];
      var color = '<?php echo $this->input->get('vf', true)=="1" ? "#00a65a" : "#f56954" ?>';
			<?php 
			foreach($data_kota->result() as $data) {
			?>
				data_in_kota.push({'x': '<?php echo $data->city_name ?>', 'value': <?php echo $data->total ?>});
			<?php 
				}
			?>
			
      var bar = new Morris.Bar({
        element: 'bar-chart',
        resize: true,
        data: data_in_kota,
        barColors: [color],
        xkey: 'x',
        ykeys: ['value'],
        labels: ['Jumlah Tutor'],
        hideHover: 'auto'
      });
		</script>
	</body>
</html>