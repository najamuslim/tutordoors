<?php
  define('IKNOW_DIR', base_url('assets/themes/iknow/'));
  define('ADMIN_LTE_DIR', base_url('assets/themes/adminlte/'));
  define('GENERAL_JS_DIR', base_url('assets/themes/js/'));
  define('GENERAL_CSS_DIR', base_url('assets/themes/css/'));
?>
<!doctype html>
<html lang="<?php echo $this->session->userdata('language'); ?>">
<head>
<meta charset="utf-8">
<title>Event <?php echo $event_title ?> - Tutordoors.com</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CUSTOM CSS -->
<link href="<?php echo IKNOW_DIR;?>/css/style.css" rel="stylesheet" media="screen">
<link href="<?php echo IKNOW_DIR;?>/css/color.css" rel="stylesheet" media="screen">
<link href="<?php echo IKNOW_DIR;?>/css/transitions.css" rel="stylesheet" media="screen">
<!-- BOOTSTRAP -->
<link href="<?php echo ADMIN_LTE_DIR;?>/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<!-- FONT AWESOME -->
<link href="<?php echo IKNOW_DIR;?>/css/font-awesome.min.css" rel="stylesheet" media="screen">

<link rel="stylesheet" href="<?php echo IKNOW_DIR;?>/css/jquery-ui-smoothness.css" type="text/css" />

<!-- Datetimepicker -->
<link rel="stylesheet" href="<?php echo GENERAL_CSS_DIR;?>/bootstrap-datetimepicker.css" />
<!-- My Own Style -->
<link href="<?php echo IKNOW_DIR;?>/css/mystyle.css" rel="stylesheet" type="text/css" />

<!-- Jquery Lib -->
<script src="<?php echo IKNOW_DIR;?>/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo IKNOW_DIR;?>/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo IKNOW_DIR;?>/js/jquery-ui-1.11.3.js"></script>

<style>
  .form-box h2{
    margin: 10px;
  }
</style>
</head>
<body>
  <!--WRAPPER START-->
  <div class="wrapper">
    <!--HEADER START-->
    <header>
      <!--NAVIGATION START-->
      <div class="navigation-bar">
        <div class="container green-bar">
          <div class="logo">
            <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo-green.png" alt="" width="276"></a>
          </div>
        </div>
      </div>
      <!--NAVIGATION END-->
    </header>
    <!--HEADER END-->
 
    <!--BANNER START-->
    <div class="page-heading" style="margin-top: 20px;"> 
      <div class="container">
        <h2>Selamat Datang di Event <?php echo $event_title ?></h2>
        <br><br>
        <h2>Silahkan mengisi form isian untuk menjadi calon tutor di Tutordoors.com</h2>
      </div>
    </div>
    <!--BANNER END-->
    
    <!--CONTANT START-->
    <div class="contant">
      <div class="container">
        <form method="POST" action="<?php echo base_url('event/jobfair_save/'.$event_id) ?>">
          <input type="hidden" name="user_identifier" value="<?php echo $city_id_for_user_identifier ?>">
          <input type="hidden" name="company_id" value="TD">
          <div class="row">
            <div class="col-md-12">
              <div class="form-box">
                <h2>Identitas Diri</h2>
                <div class="form-body">
                  <fieldset>
                    <div class="row" style="margin-bottom: 15px;">
                      <div class="col-md-6">
                        <!-- Name -->
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label><?php echo $this->lang->line('name_first') ?><span class="label-required">*</span></label>
                              <input type="text" name="fn" placeholder="First Name" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label><?php echo $this->lang->line('name_last') ?></label>
                              <input type="text" name="ln" placeholder="Last Name" class="form-control">
                            </div>
                          </div>
                        </div>
                        <!-- KTP -->
                        <div class="form-group">
                          <label><?php echo $this->lang->line('national_id_number') ?></label>
                          <input type="text" class="form-control" name="ktp" maxlength="30">
                        </div>
                        <!-- Alamat KTP -->
                        <div class="form-group">
                          <label><?php echo $this->lang->line('address_on_national_card') ?><span class="label-required">*</span></label>
                          <input type="text" class="form-control" name="address-ktp" required>
                        </div>
                        <!-- Alamat Domisili -->
                        <div class="form-group">
                          <label><?php echo $this->lang->line('address_different_national_card') ?></label>
                          <input type="text" class="form-control" name="address-domicile">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <!-- Gender -->
                        <label><?php echo $this->lang->line('sex') ?><span class="label-required">*</span></label>
                        <div class="form-group">
                          <div class="radio">
                            <label>
                              <input type="radio" name="sex" value="male" checked required> <?php echo $this->lang->line('sex_male') ?>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="sex" value="female" required> <?php echo $this->lang->line('sex_female') ?>
                            </label>
                          </div>
                        </div>
                        <!-- Agama -->
                        <div class="form-group">
                          <label><?php echo $this->lang->line('religion') ?><span class="label-required">*</span></label>
                          <?php echo form_dropdown('religion', $religion, 'Islam', 'class="form-control" required') ?>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <!-- Birth place -->
                            <div class="form-group">
                              <label><?php echo $this->lang->line('birth_place') ?><span class="label-required">*</span></label>
                              <input type="text" class="form-control" name="birth-place" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <!-- Birth date -->
                            <label><?php echo $this->lang->line('birth_date') ?><span class="label-required">*</span></label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="text" class="form-control" id="default-datepicker" name="birth-date" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <!-- Email -->
                            <label><?php echo $this->lang->line('email') ?><span class="label-required">*</span></label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                              <input type="email" class="form-control" name="email" required>
                            </div>
                            <!-- Email 2 -->
                            <label><?php echo $this->lang->line('email') ?> Alternatif</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                              <input type="email" class="form-control" name="email-2">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <!-- Phone -->
                            <label><?php echo $this->lang->line('phone') ?><span class="label-required">*</span></label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                              <input type="text" class="form-control" name="phone-1" required>
                            </div>
                            <!-- Phone 2 -->
                            <label><?php echo $this->lang->line('phone') ?> Alternatif</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                              <input type="text" class="form-control" name="phone-2">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!-- ./row -->
                  </fieldset>
                </div> <!-- ./form-body -->
              </div> <!-- ./form-box -->
            </div> <!-- ./col-12 -->

            <div class="col-md-12">
              <div class="form-box">
                <h2>Riwayat Pendidikan <button type="button" class="btn-style" onclick="add_row_edu()"><i class="fa fa-plus-circle"></i> Tambah Data</button></h2>
                <div class="form-body">
                  <div class="editing">
                    <table>
                      <thead>
                        <tr>
                          <td>Tingkat Pendidikan</td>
                          <td>Universitas</td>
                          <td>Jurusan</td>
                          <td>IPK/Final Score</td>
                          <td>Tahun Masuk</td>
                          <td>Tahun Keluar</td>
                        </tr>
                      </thead>
                      <tbody id="tab-edu">
                        <tr id="edu-clone-default">
                          <td>
                            <?php echo form_dropdown('edu_level[]', $edu_level, 'S1', 'class="form-control" required') ?>
                          </td>
                          <td>
                            <?php echo form_input('institution[]', '', 'class="form-control" placeholder="Contoh: Universitas Negeri Jakarta" required') ?>
                          </td>
                          <td>
                            <?php echo form_input('major[]', '', 'class="form-control" placeholder="Contoh: Matematika" required') ?>
                          </td>
                          <td>
                            <?php echo form_input('graduate_score[]', '', 'class="form-control" placeholder="Contoh: 3.40" required') ?>
                          </td>
                          <td>
                            <?php echo form_input('edu_in[]', '', 'class="form-control" placeholder="Contoh: 2011" required') ?>
                          </td>
                          <td>
                            <?php echo form_input('edu_out[]', '', 'class="form-control" placeholder="Contoh: 2015" required') ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-box">
                <h2>Pengalaman Bekerja <button type="button" class="btn-style" onclick="add_row_work()"><i class="fa fa-plus-circle"></i> Tambah Data</button></h2>
                <div class="form-body">
                  <div class="editing">
                    <table>
                      <thead>
                        <tr>
                          <td>Perusahaan</td>
                          <td>Posisi</td>
                          <td>Periode Bekerja</td>
                          <td>Alasan Keluar</td>
                          <td>Gaji Terakhir</td>
                        </tr>
                      </thead>
                      <tbody id="tab-work">
                        <tr id="work-clone-default">
                          <td>
                            <?php echo form_input('company[]', '', 'class="form-control" placeholder="Contoh: PT. Auto2000"') ?>
                          </td>
                          <td>
                            <?php echo form_input('position[]', '', 'class="form-control" placeholder="Contoh: Staf Admin"') ?>
                          </td>
                          <td>
                            <?php echo form_input('work_period[]', '', 'class="form-control" placeholder="Contoh: 2014 - 2015"') ?>
                          </td>
                          <td>
                            <?php echo form_input('reason_quit[]', '', 'class="form-control" placeholder="Contoh: Tidak nyaman"') ?>
                          </td>
                          <td>
                            <?php echo form_input('last_salary[]', '', 'class="form-control" placeholder="Contoh: 2700000"') ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-box">
                <h2>Pengalaman Mengajar <button type="button" class="btn-style" onclick="add_row_teach()"><i class="fa fa-plus-circle"></i> Tambah Data</button></h2>
                <div class="form-body">
                  <div class="editing">
                    <table>
                      <thead>
                        <tr>
                          <td>Instansi</td>
                          <td>Mata Pelajaran</td>
                          <td>Periode Mengajar</td>
                          <td>Fee per Pertemuan</td>
                        </tr>
                      </thead>
                      <tbody id="tab-teach">
                        <tr id="teach-clone-default">
                          <td>
                            <?php echo form_input('instansi-mengajar[]', '', 'class="form-control" placeholder="Contoh: LBB XYZ"') ?>
                          </td>
                          <td>
                            <?php echo form_input('mapel[]', '', 'class="form-control" placeholder="Contoh: Fisika"') ?>
                          </td>
                          <td>
                            <?php echo form_input('periode_mengajar[]', '', 'class="form-control" placeholder="Contoh: 2013 - 2014"') ?>
                          </td>
                          <td>
                            <?php echo form_input('fee_tatap_muka[]', '', 'class="form-control" placeholder="Contoh: 30000"') ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="col-md-12">
              <div class="form-box">
                <h2>Keahlian Khusus</h2>
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Bahasa Inggris</label>
                        <input type="text" class="form-control" name="skill-english">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Komputer</label>
                        <input type="text" class="form-control" name="skill-komputer">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Seni</label>
                        <input type="text" class="form-control" name="skill-seni">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Olahraga</label>
                        <input type="text" class="form-control" name="skill-olahraga">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

            <div class="col-md-12">
              <div class="form-box">
                <h2>Screening</h2>
                <div class="form-body">
                  <h4>1. Mata pelajaran apa saja yang dikuasai? (Dapat dipilih lebih dari satu)</h4>
                  <div class="editing">
                    <table>
                      <thead>
                        <tr>
                          <td>Kurikulum Nasional</td>
                          <td>Kurikulum Internasional</td>
                          <td>Olahraga</td>
                          <td>Seni</td>
                          <td>Komputer</td>
                          <td>Bahasa</td>
                          <td>Lainnya</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="nas-matematika"> Matematika
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="nas-biologi"> Biologi
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="nas-fisika"> Fisika
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="nas-kimia"> Kimia
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="nas-ekonomi"> Ekonomi
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="nas-akuntansi"> Akuntansi
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="nas-geografi"> Geografi
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="nas-ppkn"> PPKn
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-mathematics"> Mathematics
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-biology"> Biology
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-physics"> Physics
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-chemistry"> Chemistry
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-economics"> Economics
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-accounting"> Accounting
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-business-studies"> Business Studies
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-commerce"> Commerce
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="internas-environmental-management"> Environmental Management
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="or-taekwondo"> Taekwondo
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="or-catur"> Catur
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="or-bridge"> Bridge
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="or-renang"> Renang
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="or-berkuda"> Berkuda
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="or-panah"> Panah
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="seni-gitar"> Gitar
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="seni-piano"> Piano
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="seni-biola"> Biola
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="seni-drum"> Drum
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="seni-vokal"> Vokal
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="komp-programming"> Programming
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="komp-ms-office"> Ms. Office
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="komp-design"> Design
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="komp-autocad"> AutoCad
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-english"> Inggris
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-indonesia"> Indonesia
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-mandarin"> Mandarin
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-jepang"> Jepang
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-jerman"> Jerman
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-arab"> Arab
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-belanda"> Belanda
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-perancis"> Perancis
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="bahasa-italia"> Italia
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="lain-memasak"> Memasak
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="lain-menggambar"> Menggambar
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="lain-mengaji"> Mengaji
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="lain-menjahit"> Menjahit
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="lain-merajut"> Merajut
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="skill-mapel[]" value="lain-menyetir"> Menyetir
                                </label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <h4>2. Area mengajar yang dijangkau (Dapat dipilih lebih dari satu)</h4>
                  <h5>Jakarta Selatan</h5>
                  <div class="editing" style="padding: 0 30px">
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-pasar-minggu"> Pasar Minggu
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-mampang-prapatan"> Mampang Prapatan
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-kebayoran-lama"> Kebayoran Lama
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-kuningan"> Kuningan
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-manggarai"> Manggarai
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-lebak-bulus"> Lebak Bulus
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-cipulir"> Cipulir
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-pancoran"> Pancoran
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-cilandak"> Cilandak
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-kebayoran-baru"> Kebayoran Baru
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-setiabudi"> Setiabudi
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-kalibata"> Kalibata
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-pondok-pinang"> Pondok Pinang
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-blok-m"> Blok M
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-tebet"> Tebet
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-jagakarsa"> Jagakarsa
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-pesanggrahan"> Pesangrahan
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-tanjung-barat"> Tanjung Barat
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-lenteng-agung"> Lenteng Agung
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-bintaro"> Bintaro
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-ciganjur"> Ciganjur
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-pejaten"> Pejaten
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-ragunan"> Ragunan
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-cipete"> Cipete
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-pondok-labu"> Pondok Labu
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-cinere"> Cinere
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-ciledug"> Ciledug
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaksel-pondok-indah"> Pondok Indah
                                </label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <h5>Jakarta Barat</h5>
                  <div class="editing" style="padding: 0 30px">
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-palmerah"> Palmerah
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-slipi"> Slipi
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-tomang"> Tomang
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-jembatan-lima"> Jembatan Lima
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-grogol"> Grogol
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-tambora"> Tambora
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-daan-mogot"> Daan Mogot
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-kembangan"> Kembangan
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-cengkareng"> Cengkareng
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-taman-sari"> Taman Sari
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-meruya"> Meruya
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-pos-pengumben"> Pos Pengumben
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-kalideres"> Kalideres
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-kebon-jeruk"> Kebon Jeruk
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-puri-indah"> Puri Indah
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakbar-kedoya"> Kedoya
                                </label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <h5>Jakarta Pusat</h5>
                  <div class="editing" style="padding: 0 30px">
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-tanah-abang"> Tanah Abang
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-johar-baru"> Johar Baru
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-sudirman"> Sudirman
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-senen"> Senen
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-kemayoran"> Kemayoran
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-thamrin"> Thamrin
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-gambir"> Gambir
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-sawah-besar"> Sawah Besar
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-cikini"> Cikini
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-cempaka-putih"> Cempaka Putih
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-senayan"> Senayan
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakpus-gunung-sahari"> Gunung Sahari
                                </label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <h5>Jakarta Timur</h5>
                  <div class="editing" style="padding: 0 30px">
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-jatinegara"> Jatinegara
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-kramat-jati"> Kramat Jati
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-cakung"> Cakung
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-cijantung"> Cijantung
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-utan-kayu"> Utan Kayu
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-duren-sawit"> Duren Sawit
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-makasar"> Makasar
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-cipayung"> Cipayung
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-cibubur"> Cibubur
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-matraman"> Matraman
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-pasar-rebo"> Pasar Rebo
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-pondok-kelapa"> Pondok Kelapa
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-pondok-bambu"> Pondok Bambu
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-pulo-gadung"> Pulo Gadung
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-ciracas"> Ciracas
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-pondok-gede"> Pondok Gede
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jaktim-jatiwaringin"> Jatiwaringin
                                </label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                  <h5>Jakarta Utara</h5>
                  <div class="editing" style="padding: 0 30px">
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-pademangan"> Pademangan
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-penjaringan"> Penjaringan
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-pantai-indah-kapuk"> Pantai Indah Kapuk
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-koja"> Koja
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-kelapa-gading"> Kelapa Gading
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-tanjung-priuk"> Tanjung Priuk
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-pulomas"> Pulomas
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-cilincing"> Cilincing
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakuta-sunter"> Sunter
                                </label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                  <h5>Sekitar Jakarta</h5>
                  <div class="editing" style="padding: 0 30px">
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-bogor"> Bogor
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-depok"> Depok
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-bintaro-area"> Bintaro Area
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-bsd-area"> BSD Area
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-tangerang"> Tangerang
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-tangerang-selatan"> Tangerang Selatan
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-bekasi-timur"> Bekasi Timur
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-bekasi-utara"> Bekasi Utara
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-bekasi-barat"> Bekasi Barat
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="area-mengajar[]" value="jakaround-bekasi"> Bekasi
                                </label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                  <h4>3. Jadwal mengajar available dalam seminggu (Dapat diisi lebih dari satu)</h4>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Senin</label>
                        <input type="text" class="form-control" name="jadwal-senin" placeholder="misal: 14:00 - 20:00">
                      </div>
                      <div class="form-group">
                        <label>Selasa</label>
                        <input type="text" class="form-control" name="jadwal-selasa" placeholder="misal: 14:00 - 20:00">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Rabu</label>
                        <input type="text" class="form-control" name="jadwal-rabu" placeholder="misal: 14:00 - 20:00">
                      </div>
                      <div class="form-group">
                        <label>Kamis</label>
                        <input type="text" class="form-control" name="jadwal-kamis" placeholder="misal: 14:00 - 20:00">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Jum'at</label>
                        <input type="text" class="form-control" name="jadwal-jumat" placeholder="misal: 14:00 - 20:00">
                      </div>
                      <div class="form-group">
                        <label>Sabtu</label>
                        <input type="text" class="form-control" name="jadwal-sabtu" placeholder="misal: 14:00 - 20:00">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Minggu</label>
                        <input type="text" class="form-control" name="jadwal-minggu" placeholder="misal: 14:00 - 20:00">
                      </div>
                    </div>
                  </div>

                  <h4>4. Apakah Anda memiliki kendaraan pribadi?</h4>
                  <div class="form-group">
                    <div class="radio">
                      <label>
                        <input type="radio" name="ada-kendaraan-pribadi" value="yes" checked> Ya
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="ada-kendaraan-pribadi" value="no"> Tidak
                      </label>
                    </div>
                  </div>

                  <h4>5. Apakah Anda bersedia untuk terikat dalam waktu minimal 6 bulan?</h4>
                  <div class="form-group">
                    <div class="radio">
                      <label>
                        <input type="radio" name="mau-terikat-kerja" value="yes" checked> Ya
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="mau-terikat-kerja" value="no"> Tidak
                      </label>
                    </div>
                  </div>

                  <h4>6. Pekerjaan yang diminati selain mengajar</h4>
                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="selain-mengajar-1" placeholder="Misalnya: Akuntansi">
                    </div>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="selain-mengajar-2" placeholder="Misalnya: Administrasi">
                    </div>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="selain-mengajar-3" placeholder="Lainnya">
                    </div>
                  </div>
                  <br><br>
                </div>
              </div>
            </div>
            
            <!-- form course end -->
            <div class="footer">
              <!-- <div class="row"> -->
                Dengan ini saya menyatakan bahwa data yang saya masukkan adalah benar.
                <br><br>
                <button type="submit" class="btn-style pull-left"><?php echo $this->lang->line('submit') ?></button>
              <!-- </div> -->
            </div>
          </div> <!-- ./row -->
        </form>
      </div> <!-- ./container -->
    </div> <!-- ./contant -->
  
    <!--FOOTER START-->
    <footer style="padding: 20px 0; margin-top: 10px">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="copyright">
                <p>© Copyrights 2016. All Rights Reserved</p>
              </div>
            </div>
            <div class="col-md-6">
              <img src="<?php echo base_url();?>assets/images/logo-white.png" alt="Tutordoors White Logo" width="264">
            </div>
          </div>
        </div>
    </footer>
    <!--FOOTER END-->
</div>
<!--WRAPPER END-->

<!-- Bootstrap -->
<script src="<?php echo ADMIN_LTE_DIR;?>/bootstrap/js/bootstrap.min.js"></script>
<!-- my functions -->
<script src="<?php echo IKNOW_DIR;?>/js/functions.js"></script>
<!-- Moment.js -->
<script src="<?php echo GENERAL_JS_DIR;?>/moment.js"></script>
<!-- Bootstrap Datetimepicker -->
<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/bootstrap-datetimepicker.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81409535-1', 'auto');
  ga('send', 'pageview');

</script>

<script>
  $(function () {
    $('#default-datepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });

  var id_edu = 1;

  function add_row_edu(){
    var row = $('#edu-clone-default'); // find row to copy
    var table = $('#tab-edu'); // find table to append to
    var clone = row.clone(true); // copy children too
    clone.id = id_edu; // change id or other attributes/contents
    table.append(clone); // add new row to end of table
    id_edu++;
  }

  var id_work = 1;

  function add_row_work(){
    var row = $('#work-clone-default'); // find row to copy
    var table = $('#tab-work'); // find table to append to
    var clone = row.clone(true); // copy children too
    clone.id = id_work; // change id or other attributes/contents
    table.append(clone); // add new row to end of table
    id_work++;
  }

  var id_teach = 1;

  function add_row_teach(){
    var row = $('#teach-clone-default'); // find row to copy
    var table = $('#tab-teach'); // find table to append to
    var clone = row.clone(true); // copy children too
    clone.id = id_teach; // change id or other attributes/contents
    table.append(clone); // add new row to end of table
    id_teach++;
  }
</script>

</body>
</html>
