<style>
	.dl-horizontal dt{
		margin: 10px 0 10px 0;
		color: #000;
	}
	.dl-horizontal dd{
		padding-top: 10px;
		padding-bottom: 10px;
		color: #000;
	}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Applicant Detail
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Events</a></li>
			<li><a href="#">Job Fair</a></li>
			<li class="active"><a href="#">Applicant</a></li>
		</ol>
    </section>
	<!-- Main content -->
    <section>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary collapsed-box">
				<!-- <div class="box box-primary"> -->
		          	<div class="box-header">
						<h3 class="box-title">Applicant Data</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<dl class="dl-horizontal">
				                    <dt>User ID</dt>
				                    <dd><?php echo $applicant_user_info->key_user_id;?></dd>
				                    <dt>First Name</dt>
				                    <dd><?php echo $applicant_user_info->first_name?></dd>
				                    <dt>Last Name</dt>
				                    <dd><?php echo $applicant_user_info->last_name;?></dd>
				                    <dt>Email Primary</dt>
				                    <dd><?php echo $applicant_user_info->email_login;?></dd>
				                    <dt>Email Alternative</dt>
				                    <dd><?php echo ($applicant_user_info->email_2=="" ? "(-)" : $applicant_user_info->email_2);?></dd>
				                    <dt>Phone Primary</dt>
				                    <dd><?php echo $applicant_user_info->phone_1;?></dd>
				                    <dt>Phone Alternative</dt>
									<dd><?php echo ($applicant_user_info->phone_2=="" ? "(-)" : $applicant_user_info->phone_2);?></dd>
				                </dl>
							</div>
							<div class="col-md-6">
								<dl class="dl-horizontal">
									<dt>Birth Date &amp; Place</dt>
									<dd><?php echo $applicant_user_info->birth_place.' '. date_format(new DateTime($applicant_user_info->birth_date), 'd M Y');?></dd>
									<dt>National Identity</dt>
				                    <dd><?php echo $applicant_user_info->national_card_number;?></dd>
				                    <dt>Address on ID</dt>
				                    <dd><?php echo $applicant_user_info->address_national_card;?></dd>
				                    <dt>Domicile Address</dt>
				                    <dd><?php echo $applicant_user_info->address_domicile;?></dd>
									<dt>Sex</dt>
									<dd><?php echo ucwords($applicant_user_info->sex)?></dd>
									<dt>Religion</dt>
									<dd><?php echo $applicant_user_info->religion?></dd>
									<dt>Join Date</dt>
									<dd><?php echo date_format(new DateTime($applicant_user_info->join_date), 'd F Y');?></dd>
				                </dl>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-md-6">
				<div class="box box-success collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Education</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped">
									<tr>
										<th><?php echo $this->lang->line('education') ?></th>
		                                <th><?php echo $this->lang->line('university') ?></th>
		                                <th><?php echo $this->lang->line('grade_score') ?></th>
		                                <th><?php echo $this->lang->line('college_year_in_out') ?></th>
									</tr>
									<?php if($educations<>false)
										foreach($educations->result() as $edu){
									?>
									<tr>
										<td><?php echo $edu->degree.' - '.$edu->major;?></td>
	                                    <td><?php echo $edu->institution;?></td>
	                                    <td><?php echo $edu->grade_score;?></td>
	                                    <td><?php echo $edu->date_in.' - '.$edu->date_out;?></td>
									</tr>
									<?php }	?>	
					          	</table>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-md-6">
				<div class="box box-danger collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Work Experience</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped">
									<tr>
										<th>Company</th>
		                                <th>Position</th>
		                                <th>Period</th>
		                                <th>Reason Quit</th>
		                                <th>Last Salary</th>
									</tr>
									<?php 
										foreach($other_data->work_experience as $work){
									?>
									<tr>
										<td><?php echo $work->company;?></td>
	                                    <td><?php echo $work->position;?></td>
	                                    <td><?php echo $work->work_period;?></td>
	                                    <td><?php echo $work->reason_quit;?></td>
	                                    <td><?php echo $work->last_salary;?></td>
									</tr>
									<?php }	?>	
					          	</table>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="box box-success collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Teach Experience</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped">
									<tr>
										<th>Instansi</th>
		                                <th>Mata Pelajaran</th>
		                                <th>Periode Mengajar</th>
		                                <th>Fee tiap Pertemuan</th>
									</tr>
									<?php 
										foreach($other_data->teach_experience as $teach){
									?>
									<tr>
										<td><?php echo $teach->instansi;?></td>
	                                    <td><?php echo $teach->mapel;?></td>
	                                    <td><?php echo $teach->periode_mengajar;?></td>
	                                    <td><?php echo number_format($teach->fee_tatap_muka, 0, ',', '.');?></td>
									</tr>
									<?php }	?>	
					          	</table>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-md-6">
				<div class="box box-danger collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Mata Pelajaran yang Dikuasai</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
		          		<table class="table table-bordered table-striped">
							<?php 
							foreach($other_data->skill_mapel as $mapel){
								$string_mapel = explode('-', $mapel);
								$kategori_mapel = '';
								switch($string_mapel[0]){
									case "nas":
										$kategori_mapel = 'Nasional';
										break;
									case "internas":
										$kategori_mapel = 'Internasional';
										break;
									case "or":
										$kategori_mapel = 'Olahraga';
										break;
									case "seni":
										$kategori_mapel = 'Seni';
										break;
									case "komp":
										$kategori_mapel = 'Komputer';
										break;
									case "bahasa":
										$kategori_mapel = 'Bahasa';
										break;
									case "lain":
										$kategori_mapel = 'Lainnya';
										break;
								}
								$mapel = '';
								for($i=1; $i<sizeof($string_mapel); $i++){
									$mapel .= ucwords($string_mapel[$i]).' ';
								}
								$mapel = rtrim($mapel, ' ');
							?>
							<tr>
								<td><i class="fa fa-check" style="color: green"></i> <?php echo $kategori_mapel.' - '.$mapel?></td>
							</tr>
							<?php } ?>
			          	</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
		<div class="row">
			<div class="col-md-6">
				<div class="box box-success collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Area Mengajar</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table class="table table-bordered table-striped">
							<?php 
							foreach($other_data->area_mengajar as $area){
								$string_area_mengajar = explode('-', $area);
								$kategori_area = '';
								switch($string_area_mengajar[0]){
									case "jaksel":
										$kategori_area = 'Jakarta Selatan';
										break;
									case "jakbar":
										$kategori_area = 'Jakarta Barat';
										break;
									case "jakpus":
										$kategori_area = 'Jakarta Pusat';
										break;
									case "jaktim":
										$kategori_area = 'Jakarta Timur';
										break;
									case "jakuta":
										$kategori_area = 'Jakarta Utara';
										break;
									case "jakaround":
										$kategori_area = 'Sekitar Jakarta';
										break;
								}
								$area_mengajar = '';
								for($i=1; $i<sizeof($string_area_mengajar); $i++){
									$area_mengajar .= ucwords($string_area_mengajar[$i]).' ';
								}
								$area_mengajar = rtrim($area_mengajar, ' ');
							?>
							<tr>
								<td><i class="fa fa-check" style="color: green"></i> <?php echo $kategori_area.' - '.$area_mengajar?></td>
							</tr>
							<?php } ?>
			          	</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-md-6">
				<div class="box box-danger collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Jadwal Mengajar Available</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
		          		<table class="table table-striped">
							<tr>
								<th>Hari</th>
                                <th>Waktu</th>
							</tr>
							<tr>
								<td>Senin</td>
                                <td><?php echo ($other_data->jadwal_mengajar->senin=="" ? "(-)" : $other_data->jadwal_mengajar->senin);?></td>
							</tr>
							<tr>
								<td>Selasa</td>
                                <td><?php echo ($other_data->jadwal_mengajar->selasa=="" ? "(-)" : $other_data->jadwal_mengajar->selasa);?></td>
							</tr>
							<tr>
								<td>Rabu</td>
                                <td><?php echo ($other_data->jadwal_mengajar->rabu=="" ? "(-)" : $other_data->jadwal_mengajar->rabu);?></td>
							</tr>
							<tr>
								<td>Kamis</td>
                                <td><?php echo ($other_data->jadwal_mengajar->kamis=="" ? "(-)" : $other_data->jadwal_mengajar->kamis);?></td>
							</tr>
							<tr>
								<td>Jum'at</td>
                                <td><?php echo ($other_data->jadwal_mengajar->jumat=="" ? "(-)" : $other_data->jadwal_mengajar->jumat);?></td>
							</tr>
							<tr>
								<td>Sabtu</td>
                                <td><?php echo ($other_data->jadwal_mengajar->sabtu=="" ? "(-)" : $other_data->jadwal_mengajar->sabtu);?></td>
							</tr>
							<tr>
								<td>Minggu</td>
                                <td><?php echo ($other_data->jadwal_mengajar->minggu=="" ? "(-)" : $other_data->jadwal_mengajar->minggu);?></td>
							</tr>
			          	</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
		<div class="row">
			<div class="col-md-6">
				<div class="box box-success collapsed-box">
		          	<div class="box-header">
						<h3 class="box-title">Pertanyaan Lainnya</h3>
						<div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                </div><!-- /.box-tools -->
		          	</div><!-- /.box-header -->
		          	<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<td>Memiliki kendaraan pribadi</td>
								<td><?php echo $other_data->ada_kendaraan_pribadi ?></td>
							</tr>
							<tr>
								<td>Mau terikat kerja 6 bulan</td>
								<td><?php echo $other_data->mau_terikat_kerja ?></td>
							</tr>
							<?php 
							$cnt = 1;
							foreach($other_data->selain_mengajar as $selain) {?>
							<tr>
								<td>Pekerjaan lainnya yg diminati (<?php echo $cnt ?>)</td>
								<td><?php echo ($selain=="" ? "(-)" : $selain) ?></td>
							</tr>
							<?php $cnt++; } ?>
			          	</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

</body>
</html>
