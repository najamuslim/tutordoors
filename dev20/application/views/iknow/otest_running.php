<script>
  var total_question = <?php echo sizeof($questions)?>;
</script>
    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
      	<div class="row">
        	<div class="col-md-9 col-md-push-3">
            <h2><?php echo $sub_page_title; ?></h2>
            <h4><?php echo $this->lang->line('test_assignment_id') ?>: <?php echo (isset($assignment_id) ? $assignment_id : '') ?></h4>
            <h4><?php echo $this->lang->line('remaining_time') ?>: </h4>
            <div id="countdown" class="countdown"></div>
            <form id="form-answer" method="POST" action="<?php echo base_url('otest/submit_answer')?>">
              <input type="hidden" name="taker_id" value="<?php echo $taker_id?>">
              <div class="profile-box editing">
                <div class="grid question">
                  <?php
                    $cnt = 1;
                    foreach($questions as $question) {
                  ?>
                  <div class="element-item question-<?php echo $cnt ?>">
                    <h4><?php echo $this->lang->line('test_question').' '.$cnt; ?></h4>
                    <?php echo $question['question']?>

                    <?php if($question['answer_type']=="Fill"){?>
                    <p><?php echo $this->lang->line('test_type_your_answer_here')?></p>
                    <input type="text" name="answer-<?php echo $question['id']?>" class="form-control">

                    <?php } else if($question['answer_type']=="Bool") {?>
                    <div class="form-group">
                      <div class="radio">
                        <label>
                          <input type="radio" name="answer-<?php echo $question['id']?>" value="true"> <?php echo ($question['boolean_type']=="yes-no" ? "Yes" : "True"); ?>
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="answer-<?php echo $question['id']?>" value="false"> <?php echo ($question['boolean_type']=="yes-no" ? "No" : "False"); ?>
                        </label>
                      </div>
                    </div>
                    <?php 
                      }
                      else { // single or multiple
                        $answer_data = $this->otest->get_answer_data(array('question_id' => $question['id']));
                        $answer_array = $answer_data->result_array();
                        if($question['random_choice']=="1")
                          shuffle($answer_array);
                    ?>
                    <div class="form-group">
                    <?php   
                        foreach($answer_array as $answer){
                          if($question['answer_type']=="Single"){
                      ?>
                      <div class="radio">
                        <label>
                          <input type="radio" name="answer-<?php echo $question['id']?>" value="<?php echo $answer['id'] ?>"> <?php echo preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $answer['answer']); ?>
                        </label>
                      </div>
                    <?php } if($question['answer_type']=="Multiple") {?>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="answer-<?php echo $question['id']?>[]" value="<?php echo $answer['id'] ?>"> <?php echo preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $answer['answer']); ?>
                        </label>
                      </div>
                    <?php 
                          } 
                        }
                    ?>
                    </div>
                  <?php 
                      }
                      $cnt++;
                  ?>
                  </div>
                  <?php
                    } 
                  ?>
                </div>
              </div>
              
              <button type="button" class="btn-style" id="btn-prev" disabled><?php echo $this->lang->line('test_previous') ?></button> &nbsp;&nbsp;
              <button type="button" class="btn-style" id="btn-next"><?php echo $this->lang->line('test_next') ?></button> &nbsp;&nbsp;
              <button type="submit" class="btn-style" onclick="return confirm('Do you really want to submit your answers?')"><?php echo $this->lang->line('submit') ?></button>
            </form>
          </div>
          <div class="col-md-3 col-md-pull-9">
            <?php include('sidebar_menu.php'); ?>
          
          </div>
        </div>
      </div>
      <br>
          <?php //include('follow_social_media.php'); ?>
    </div>
    <!--CONTANT END-->
    <!-- Isotope -->
    <script src="<?php echo IKNOW_DIR;?>/js/isotope.pkgd.js"></script>
    <script>
      var curr_position = 1;
      var next_position = 2;
      var prev_position = 1;

      $(document).ready(function(){
        $('.grid').isotope({ 
          itemSelector: '.element-item',
          filter: '.question-'+curr_position
        });

        countdown( "countdown", <?php echo $test_data->time_in_minutes ?>, 0 );
      })
      $('#btn-next').on( 'click', function() {
        // console.log(next_position);
        $('.grid').isotope({ 
          itemSelector: '.element-item',
          filter: '.question-'+next_position
        });

        next_position += 1;
        prev_position += 1;

        if(prev_position==total_question)
          prev_position -= 1;

        disable_prev_next();
      });

      $('#btn-prev').on( 'click', function() {
        // console.log(prev_position);
        $('.grid').isotope({ 
          itemSelector: '.element-item',
          filter: '.question-'+prev_position
        });

        next_position -= 1;
        prev_position -= 1;

        if(next_position==1)
          next_position += 2;

        disable_prev_next();
      });

      function disable_prev_next()
      {
        if(prev_position == 0)
          $('#btn-prev').prop('disabled', true);
        else
          $('#btn-prev').prop('disabled', false);

        if(next_position == total_question + 1)
          $('#btn-next').prop('disabled', true);
        else
          $('#btn-next').prop('disabled', false);
      }

      function countdown( elementName, minutes, seconds )
      {
        var element, endTime, hours, mins, msLeft, time;

        function twoDigits( n )
        {
            return (n <= 9 ? "0" + n : n);
        }

        function updateTimer()
        {
            msLeft = endTime - (+new Date);
            if ( msLeft < 1000 ) {
                element.innerHTML = "<?php echo $this->lang->line('test_time_up')?>!";
                $('#form-answer').submit();
            } else {
                time = new Date( msLeft );
                hours = time.getUTCHours();
                mins = time.getUTCMinutes();
                element.innerHTML = (hours ? hours + ':' + twoDigits( mins ) : mins) + ':' + twoDigits( time.getUTCSeconds() );
                setTimeout( updateTimer, time.getUTCMilliseconds() + 500 );
            }
        }

        element = document.getElementById( elementName );
        endTime = (+new Date) + 1000 * (60*minutes + seconds) + 500;
        updateTimer();
      }
    </script>