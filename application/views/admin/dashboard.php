      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $total_teacher; ?></h3>
                  <p>Total Teachers</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url();?>users/user_view?v=teacher" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $total_verified; ?></h3>
                  <p>Total Verified Teachers</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url();?>teacher/verified" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $total_unverified; ?></h3>
                  <p>Total Unverified Teachers</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url();?>teacher/unverified" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $total_student; ?></h3>
                  <p>Total Students</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url();?>users/user_view?v=student" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $total_enrollment; ?></h3>
                  <p>Total Course Enrollment</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ribbon-b"></i>
                </div>
                <a href="<?php echo base_url();?>course/view_running_course" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
          </div><!-- /.row -->

          <div class="row">
            <div class="col-md-4 col-sm-6">
              <!-- Chat box -->
              <div class="box box-success">
                <div class="box-header">
                  <i class="fa fa-info-circle"></i>
                  <h3 class="box-title">Software Updates Website</h3>
                </div>
                <div class="box-body chat" id="chat-box">
                  <?php foreach($software_updates->result() as $row){?>
                  <!-- chat item -->
                  <div class="item">
                    <p class="message" style="margin: 0">
                      <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo date_format(new DateTime($row->release_date), 'd/m/Y') ?></small>
                        Version <?php echo $row->version ?>
                      </a>
                      <?php echo nl2br($row->description) ?>
                    </p>
                  </div><!-- /.item -->
                  <?php } ?>
                </div><!-- /.chat -->
              </div><!-- /.box (chat box) -->
            </div>

            <div class="col-md-4 col-sm-6">
              <!-- Chat box -->
              <div class="box box-primary">
                <div class="box-header">
                  <i class="fa fa-info-circle"></i>
                  <h3 class="box-title">Software Updates Android</h3>
                </div>
                <div class="box-body chat" id="chat-box">
                  <?php foreach($software_updates_android_td_id->result() as $row){?>
                  <!-- chat item -->
                  <div class="item">
                    <p class="message" style="margin: 0">
                      <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo date_format(new DateTime($row->release_date), 'd/m/Y') ?></small>
                        Version <?php echo $row->version ?>
                      </a>
                      <?php echo nl2br($row->description) ?>
                    </p>
                  </div><!-- /.item -->
                  <?php } ?>
                </div><!-- /.chat -->
              </div><!-- /.box (chat box) -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->



<?php include('footer.php');?>
<script type="text/javascript">
  //SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').slimScroll({
    height: '250px'
  });
</script>
</body>
</html>
