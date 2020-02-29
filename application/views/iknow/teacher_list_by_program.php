<?php //var_dump($teachers); ?>

<!--BANNER START-->
<div class="page-heading"> 
    <div class="container">
        <h2><?php echo $sub_page_title; ?></h2>
        <p><?php if (isset($course_cat)) echo $course_cat; ?></p>
    </div>
</div>
<!--BANNER END-->
<!--CONTANT START-->
<div class="contant">
    <div class="container">
        <div class="tutor-list">
            <div class="row">
                <div class="col-md-9">

                    <?php
                    $cnt = 0;
                    $prog_tot = sizeof($teachers);
                    if (sizeof($teachers) > 0) {
                        foreach ($teachers as $teacher) {
                            // get latest education
                            $get_latest_edu = $this->User_m->get_education_history_by_userid($teacher['user_id']);
                            $latest_edu = $get_latest_edu <> false ? $get_latest_edu->row()->degree . ' ' . $get_latest_edu->row()->major . ' - ' . $get_latest_edu->row()->institution : '';

                            if (($cnt % 3) == 0)
                                echo '<div class="row">';
                            ?>
                            <div class="col-md-4 list age-<?php echo $teacher['age'] ?> <?php echo $teacher['days'] ?>" style="margin-top: 10px;" data-age="<?php echo $teacher['age'] ?>">
                                <div class="profile teacher-list-box" style="text-align:center">
                                    <a href="<?php echo base_url('teacher/profile/' . $teacher['user_id']); ?>">
                                        <!--<div class="label-price">
                                          <span>IDR <?php //echo number_format($teacher['salary'], 0, ',', '.') ?></span>
                                        </div>-->
                                        <div class="thumb">
                                            
                                            <img 
                                                src="http://spacergif.org/spacer.gif"  
                                                class="lazy" 
                                                data-src="<?php echo UPLOAD_IMAGE_DIR . '/' . $teacher['file_name']; ?>" 
                                                alt="" />
                                            <noscript>
                                            <img 
                                                src="<?php echo UPLOAD_IMAGE_DIR . '/' . $teacher['file_name']; ?>" 
                                                alt="" />
                                            </noscript>
                                        </div>
                                        <div class="title">
                                            <h4><?php echo $teacher['first_name'] . ' ' . $teacher['last_name']; ?></h4>
                                            <p><i><?php echo $latest_edu; ?></i></p>
                                            <!-- <p><?php echo $teacher['about_me']; ?></p> -->
                                            <br>
                                        </div>
                                        <div class="footer">
                                            <p><?php echo $this->lang->line('competence') ?>:</p>
                                            <p><?php echo str_replace(',', ', ', $teacher['courses']); ?></p>
                                            <br>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                            if (($cnt % 3) == 2 or $cnt == $prog_tot - 1)
                                echo '</div>';

                            $cnt += 1;
                        }
                    }
                    else {
                        ?>
                        <p><?php echo $this->lang->line('teacher_not_found_info_1') ?></p>
                        <p><?php echo $this->lang->line('teacher_not_found_info_2') ?></p>
                        <a href="<?php echo base_url() ?>" class="btn-style"><i class="fa fa-angle-double-left"></i> Back</a>
                    <?php } ?>
                </div>
                <div class="col-md-3">
                    <?php include('sidebar_right.php'); ?>
                </div>
            </div>
        </div>


    </div>
    <br>
    <?php //include('follow_social_media.php'); ?>
</div>
<!--CONTANT END-->
<!-- Isotope -->
<script src="<?php echo IKNOW_DIR; ?>/js/isotope.pkgd.js"></script>
<script>
    $('#btn-filter-from-right-sidebar').on('click', function () {
        // map input values to an array
        var inclusives = [];
        $('input:checkbox[name="day-opt"]').each(function (i, elem) {
            // if checkbox, use value if checked
            if (elem.checked) {
                inclusives.push(".day-" + elem.value);
            }
        });

        // fetch list by age
        $('.list').each(function (i, elem) {
            var number = $(this).data('age');
            if (parseInt(number, 10) >= parseInt($('#age-from').val(), 10) && parseInt(number, 10) <= parseInt($('#age-to').val(), 10) == true)
                inclusives.push(".age-" + number);
        });

        // if filter conditions not match, the hide all list using function
        var filterValue = inclusives.length ? inclusives.join(', ') : function () {
            return false
        };

        $('.tutor-list').isotope({itemSelector: '.list', filter: filterValue});
    });
    
    
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