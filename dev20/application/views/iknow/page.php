    <!--BANNER START-->
    <div class="page-heading"> 
    	<div class="container">
            <h2><?php echo $sub_page_title; ?></h2>
        </div>
    </div>
    <!--BANNER END-->
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="blog">
              <!--BLOG START-->
              <div class="blog-contant">
                <!-- <h2><a href="<?php echo current_url()?>"><?php echo $page->title ?></a></h2> -->
                <div class="blog-tags">
                  <?php 
                    $tags_string = '';
                    if($page->tags<>""){
                      $tags_array = explode(',', $page->tags);
                      foreach($tags_array as $tags)
                        $tags_string .= '<a href="#">'.$tags.'</a>, ';

                      $tags_string = rtrim($tags_string, ', ');
                    }
                   ?>

                  <?php if($post_type<>"page") {?>
                  <?php echo $this->lang->line('category') ?>: <a href="<?php echo base_url('content/blog/'.$page->slug.'/0/10')?>">
                  <?php echo $page->category_name ?></a> /  Tags: <?php echo $tags_string ?>
                  <?php } ?>
                </div> <!-- ./blog-tags -->
                <div class="thumb">
                <?php if($page->file_name<>""){?>
                  <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$page->file_name?>" alt="<?php echo $page->title ?>" width="770" height="370">
                <?php } ?>
                </div>
                <div class="text">
                  <?php echo $page->content ?>
                </div>
                <div class="blog-comments">
                  <a href="#"><i class="fa fa-user"></i><?php echo $page->first_name ?></a>
                  <a href="#"><i class="fa fa-calendar"></i><?php echo date_format(new DateTime($page->creation_datetime), 'd F Y') ?></a>
                  <!-- <a class="pull-right" href="#"><i class="fa fa-comment"></i>35 Comments</a> -->
                </div>
              </div>
            </div>
          </div> <!-- ./col -->
          <div class="col-md-3">
            <?php include('sidebar_right.php'); ?>
          </div>
        </div>
            
        	
        </div>
        <br>
        <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->