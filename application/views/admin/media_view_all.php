<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			All Media
			<!-- <small><a href="<?php echo base_url('cms/post_new');?>">Add new media</a></small> -->
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Media</a></li>
			<li class="active"><a href="#">View All</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>
			<div class="col-xs-12">
				<form action="<?php echo base_url('cms/media_add');?>" method="post" enctype="multipart/form-data">
					<div class="box box-primary">
						<div class="box-header">
							Add new media
						</div>
						<div class="box-body">
							<div class="form-group" id="primary_image">
				                <input type="file" id="image_file" name="image_file" />
				                <p class="help-block">Max size is 50MB.</p>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Submit</button> 
						</div>
					</div>
				</form>
			</div>
			<div class="col-xs-12">
				<div class="box box-info">
                <div class="box-header">
					List
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="table-10row" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th></th>
								<th>Type</th>
								<th>File Name</th>
								<th>Info</th>
								<th>URL</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if($media<>false)
								foreach($media->result() as $row){?>
							<tr>
								<td>
									<?php 
										if($row->file_type=="image/jpeg") {
											echo '<img class="lazy"  src="http://spacergif.org/spacer.gif"  data-src="'.UPLOAD_IMAGE_DIR.'/'.$row->file_name.'" height="283px" width="234px" style="object-fit:contain;" alt=""/>';
                                                                                        echo '<noscript><img src="'.UPLOAD_IMAGE_DIR.'/'.$row->file_name.'" height="283px" width="234px" style="object-fit:contain;" alt="" /></noscript>';       
                                                                                }
									?>
								</td>
								<td><?php echo $row->file_type;?></td>
								<td><?php echo $row->file_name;?></td>
								<td><?php echo $row->img_width. ' x '.$row->img_height;?></td>
								<td><?php echo UPLOAD_IMAGE_DIR.'/'.$row->file_name; ?></td>
								<td>
									<a href="<?php echo base_url('cms/media_delete/'.$row->id);?>">
										<button class="btn btn-danger btn-xs">
											<i class="fa fa-trash-o"></i> Delete
										</button>
									</a>
								</td>
							</tr>
							<?php }	?>	
						</tbody>
                  	</table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			</div>
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->


<?php include('footer.php');?>
</body>

<script>
    var lazy = [];

    registerListener('load', setLazy);
    registerListener('load', lazyLoad);
    registerListener('scroll', lazyLoad);
    registerListener('resize', lazyLoad);
    registerListener('click', lazyLoad);

    function setLazy() {
        //document.getElementById('listing').removeChild(document.getElementById('viewMore'));
        //document.getElementById('nextPage').removeAttribute('class');

        lazy = document.getElementsByClassName('lazy');
        console.log('Found ' + lazy.length + ' lazy images');
    }

    function lazyLoad() {
        for (var i = 0; i < lazy.length; i++) {
            if (isInViewport(lazy[i])) {
                if (lazy[i].getAttribute('data-src')) {
                    lazy[i].src = lazy[i].getAttribute('data-src');
                    lazy[i].removeAttribute('data-src');
                }
            }
        }

        cleanLazy();
    }

    function cleanLazy() {
        lazy = Array.prototype.filter.call(lazy, function (l) {
            return l.getAttribute('data-src');
        });
    }

    function isInViewport(el) {
        var rect = el.getBoundingClientRect();

        return (
                rect.bottom >= 0 &&
                rect.right >= 0 &&
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.left <= (window.innerWidth || document.documentElement.clientWidth)
                );
    }

    function registerListener(event, func) {
        if (window.addEventListener) {
            window.addEventListener(event, func)
        } else {
            window.attachEvent('on' + event, func)
        }
    }
</script>

</html>
