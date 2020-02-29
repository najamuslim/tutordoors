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
			<?php echo $general->first_name;?>'s Profile
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Student</a></li>
			<li class="active"><a href="#">Profile</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
		          	<div class="box-header">
						<h3 class="box-title">Private Data
						</h3>
		          	</div><!-- /.box-header -->
		          	<div class="box-body no-padding">
						<div class="row">
							<div class="col-md-6">
								<dl class="dl-horizontal">
				                    <dt>User ID</dt>
				                    <dd><?php echo $general->user_id;?></dd>
				                    <dt>Fullname</dt>
				                    <dd><?php echo $general->first_name.' '.$general->last_name;?></dd>
				                    <dt>Email</dt>
				                    <dd><?php echo $general->email_login;?></dd>
				                    <dt>Primary Phone</dt>
				                    <dd><?php echo isset($info->phone_1) ? $info->phone_1 : "-" ?></dd>
				                    <dt>Secondary Phone</dt>
									<dd><?php echo isset($info->phone_2) ? $info->phone_2 : "-" ?></dd>
									<dt>Registered Date</dt>
									<dd><?php echo date_format(new DateTime($general->join_date), 'd M Y');?></dd>
									<dt>Verification</dt>
									<dd><?php echo ($general->verified_user=="0" ? '<i class="fa fa-times fa-2x" style="color:#ff0000"></i>' : '<i class="fa fa-check fa-2x" style="color:#00ff00"></i>');?></dd>
									<dt>Sex</dt>
									<dd><?php echo isset($info->sex) ? ucwords($info->sex) : "-" ?></dd>
									<dt>Place &amp; Date of Birth</dt>
									<dd><?php if($info<>false) echo $info->birth_place.' '. date_format(new DateTime($info->birth_date), 'd M Y');?></dd>
				                </dl>
							</div>
							<div class="col-md-6">
								<dl class="dl-horizontal">
									<dt>Primary Photo</dt>
									<dd>
										<?php if($info<>false) if($info->file_name<>"") {?>
										<img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$info->file_name?>" alt="Foto" width="180">
										<?php } else { ?>
										Primary photo not set
										<?php } ?>
									</dd>
				                    <dt>Identity Card</dt>
				                    <dd><?php echo isset($info->national_card_number) ? $info->national_card_number : "-" ?></dd>
				                    <dt>Address</dt>
				                    <dd><?php echo isset($info->address_national_card) ? $info->address_national_card : "-" ?></dd>
				                    <dt>Address (Domicile)</dt>
				                    <dd><?php echo isset($info->address_domicile) ? $info->address_domicile : "-" ?></dd>
				                    <dt>School Name</dt>
				                    <dd><?php echo isset($info->where_student_school) ? $info->where_student_school : "-" ?></dd>
				                    <dt>About Me</dt>
									<dd><?php echo isset($info->about_me) ? $info->about_me : "-" ?></dd>
									<dt>Registration Source</dt>
									<dd><?php echo isset($general->register_source) ? ucwords($general->register_source) : "-" ?></dd>
				                </dl>
							</div>
						</div>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

</body>
</html>
