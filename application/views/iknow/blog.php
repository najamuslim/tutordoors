<style>
  .pagination {
  margin: 20px 0;
  float:left;
  width:100%;
}

.pagination ul {
  display: inline-block;
  *display: inline;
  margin-bottom: 0;
  margin-left: 0;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  *zoom: 1;
  -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
     -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
          box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.pagination ul > li {
  display: inline;
}

.pagination ul > li > a,
.pagination ul > li > span {
  float: left;
  padding: 4px 12px;
  line-height: 20px;
  text-decoration: none;
  background-color: #ffffff;
  border: 1px solid #dddddd;
  border-left-width: 0;
}

.pagination ul > li > a:hover,
.pagination ul > li > a:focus,
.pagination ul > .active > a,
.pagination ul > .active > span {
color:#fff;
}

.pagination ul > .active > a,
.pagination ul > .active > span {
  color: #fff;
  cursor: default;
}

.pagination ul > .disabled > span,
.pagination ul > .disabled > a,
.pagination ul > .disabled > a:hover,
.pagination ul > .disabled > a:focus {
  color: #999999;
  cursor: default;
  background-color: transparent;
}

.pagination ul > li:first-child > a,
.pagination ul > li:first-child > span {
  border-left-width: 1px;
  -webkit-border-bottom-left-radius: 4px;
          border-bottom-left-radius: 4px;
  -webkit-border-top-left-radius: 4px;
          border-top-left-radius: 4px;
  -moz-border-radius-bottomleft: 4px;
  -moz-border-radius-topleft: 4px;
}

.pagination ul > li:last-child > a,
.pagination ul > li:last-child > span {
  -webkit-border-top-right-radius: 4px;
          border-top-right-radius: 4px;
  -webkit-border-bottom-right-radius: 4px;
          border-bottom-right-radius: 4px;
  -moz-border-radius-topright: 4px;
  -moz-border-radius-bottomright: 4px;
}
</style>
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
              <?php 
              if($posts<>false)
                foreach($posts->result() as $post){
               ?>
              <div class="blog-contant">
                <h2><a href="<?php echo base_url('content/page/'.$post->id)?>"><?php echo $post->title ?></a></h2>
                <div class="blog-tags">
                  <?php 
                    $tags_string = '';
                    if($post->tags<>""){
                      $tags_array = explode(',', $post->tags);  
                      foreach($tags_array as $tags)
                        $tags_string .= '<a href="#">'.$tags.'</a>, ';

                      $tags_string = rtrim($tags_string, ', ');
                    }
                   ?>
                  <?php echo $this->lang->line('category') ?>: <a href="#"><?php echo $post->category_name ?></a> /  Tags: <?php echo $tags_string ?>
                </div> <!-- ./blog-tags -->
                <div class="thumb">
                  <img src="<?php echo UPLOAD_IMAGE_DIR.'/'.$post->file_name?>" alt="<?php echo $post->title ?>" width="770" height="370">
                </div>
                <div class="text">
                  <?php echo character_limiter(strip_tags($post->content), 500) ?>
                </div>
                <div class="blog-comments">
                  <a href="#"><i class="fa fa-user"></i><?php echo $post->first_name ?></a>
                  <a href="#"><i class="fa fa-calendar"></i><?php echo date_format(new DateTime($post->creation_datetime), 'd F Y') ?></a>
                  <!-- <a class="pull-right" href="#"><i class="fa fa-comment"></i>35 Comments</a> -->
                </div>
              </div>
              <?php } ?>
            </div> <!-- ./blog -->
            <div class="pagination">
              <ul>
                <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                <?php for($i=1; $i<=$page_link; $i++) {
                  $active_class = '';
                  if($i == $active_pagination_link)
                    $active_class = 'active';
                  ?>
                <li class="<?php echo $active_class?>"><a href="#"><?php echo $i ?></a></li>
                <?php } ?>
                <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
              </ul>
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