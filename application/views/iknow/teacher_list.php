<!--BANNER START-->
<div class="page-heading"> 
    <div class="container">
        <h2><?php echo $sub_page_title; ?></h2>
        <p><?php if (isset($program_course_title)) echo $program_course_title; ?></p>
    </div>
</div>
<!--BANNER END-->
<!--CONTANT START-->
<div class="contant">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php
                $cnt = 0;
                if ($teachers <> false) {
                    $total = sizeof($teachers->result());
                    foreach ($teachers->result() as $teacher) {
                        // get latest education
                        $get_latest_edu = $this->User_m->get_education_history_by_userid($teacher->user_id);
                        $latest_edu = $get_latest_edu <> false ? $get_latest_edu->row()->degree . ' ' . $get_latest_edu->row()->major . ' - ' . $get_latest_edu->row()->institution : '';

                        if (($cnt % 3) == 0)
                            echo '<div class="row">';
                        ?>
                        <div class="col-md-4">
                            <div class="profile" style="text-align:center">
                                <a href="<?php echo base_url('teacher/profile/' . $teacher->user_id); ?>">
                                    <div class="thumb">

                                        <img 
                                            src="http://spacergif.org/spacer.gif"  
                                            class="lazy" 
                                            data-src="<?php echo UPLOAD_IMAGE_DIR . '/' . $teacher->file_name; ?>" 
                                            alt="" />
                                        <noscript>
                                        <img 
                                            src="<?php echo UPLOAD_IMAGE_DIR . '/' . $teacher->file_name; ?>" 
                                            alt="" />
                                        </noscript>

                                    </div>
                                    <div class="title">
                                        <h4><?php echo $teacher->first_name . ' ' . $teacher->last_name; ?></h4>
                                        <p><i><?php echo $latest_edu; ?></i></p>
                                        <!-- <p><?php echo $teacher->about_me; ?></p> -->
                                        <br>
                                    </div>
                                    <div class="footer">
                                        <p><?php echo $this->lang->line('competence') ?>:</p>
                                        <p><?php echo str_replace(',', ', ', $teacher->courses); ?></p>
                                        <br>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                        if (($cnt % 3) == 2 or $cnt == $total - 1)
                            echo '</div>';

                        $cnt += 1;
                    }
                }
                else {
                    ?>
                    <p><?php echo $this->lang->line('teacher_not_found_info_1') ?></p>
                    <p><?php echo $this->lang->line('teacher_not_found_info_2') ?></p>
                <?php } ?>
            </div>
            <div class="col-md-3">
                <?php include('sidebar_right.php'); ?>
            </div>
        </div>


    </div>
    <br>
    <?php //include('follow_social_media.php'); ?>
</div>
<!--CONTANT END-->

<script>
    var lazy = [];

    registerListener('load', setLazy);
    registerListener('load', lazyLoad);
    registerListener('scroll', lazyLoad);
    registerListener('resize', lazyLoad);

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
