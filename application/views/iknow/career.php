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
            <div class="col-md-12 career">
                
                <?php foreach($career->result() as $c) { ?>
                
                <h2 style="font-family: latomedium, Serif;"><?php echo $c->title ?></h2>
                <div>
                    <?php echo $c->content ?>
                </div>
                <img 
                    src="<?php echo UPLOAD_IMAGE_DIR . '/' . $c->file_name; ?>" 
                    alt="" />
                <?php }
                ?>
                
                

            </div> <!-- ./col -->

        </div>


    </div>
    <br>
    <?php //include('follow_social_media.php'); ?> 
</div>
<!--CONTANT END-->