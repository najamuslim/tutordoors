<?php 
	$abc_array = array('A', 'B', 'C', 'D', 'E', 'F');
 ?>
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
			Answer Data
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Online Test</a></li>
			<li class="active"><a href="#">Answer Data</a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
		          	<div class="box-header">
						<h3 class="box-title">Test Assignment - Answer Data
						</h3>
		          	</div><!-- /.box-header -->
		          	<div class="box-body no-padding">
						<table class="table table-bordered table-striped">
							<tr>
								<th>#</th>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Answer</th>
                                <th>Correct?</th>
							</tr>
							<?php 
							$cnt = 0;
							if($answers<>false)
								foreach($answers->result() as $answer){
									$cnt++;

									$question_info = $this->otest->get_question_data(array('id' => $answer->question_id));
									$answer_type = $question_info->row()->answer_type;
							?>
							<tr>
								<td><?php echo $cnt.'.';?></td>
                                <td>
                                <?php 
                                	$question = $question_info->row()->question;
                                	echo $question;
                                ?>
                                </td>
                                <td>
                                <?php
                                	if($answer_type=="Fill")
                                		echo 'Fill in the blank';
                                	else if($answer_type=="Bool")
                                		echo 'Boolean';
                                	else if($answer_type=="Single")
                                		echo 'Single Choice';
                                	else if($answer_type=="Multiple")
                                		echo "Multiple Choice";
                                ?>
                                </td>
                                <td>
                                <?php 
                                	$is_correct = false;
                                	$right_answer = '';
                                	
                                	if($answer_type=="Fill" or $answer_type=="Bool"){
                                		echo '<p>'.$answer->answer.'</p>';
                                		// get the right answer
                                		$right_answer = $question_info->row()->answer_text;
                                		if($answer->answer == $right_answer)
                                			$is_correct = true;
                                	}
                                	else if($answer_type=="Single"){
                                		$answer_list = $this->otest->get_answer_data(array('question_id' => $answer->question_id));
                                		$right_choice = $this->otest->get_right_answer_of_choice('single',$answer->question_id);

                                		// send to output
                                		echo '<ol type="a">';
                                		$cnt_s = 0;
                                		foreach($answer_list->result() as $list){
                                			if($right_choice->id == $list->id and $list->is_right_answer=="1"){
                                				echo '<li class="right-submitted-answer">'.$list->answer.'</li>';
                                				$right_answer = $abc_array[$cnt_s];
                                			}
                                			else if($answer->answer == $list->id and $list->is_right_answer=="0")
                                				echo '<li class="wrong-submitted-answer">'.$list->answer.'</li>';

                                			else
                                				echo '<li>'.$list->answer.'</li>';

                                			if($answer->answer == $list->id and $list->is_right_answer=="1")
                                				$is_correct = true;

                                			$cnt_s++;
                                		}
                                		echo '</ol>';
                                	}
                                	else if($answer_type=="Multiple"){
                                		// store the answer to array since it's a multiple
                                		$submitted_answer_array = explode(',', $answer->answer);
                                		$right_choice = $this->otest->get_right_answer_of_choice('multiple', $answer->question_id);
                                		// store the array of ID for checking the chosen options
										$right_options = array();
										foreach($right_choice->result() as $row){
											array_push($right_options, $row->id);
										}

										// if the answer array include wrong chosen option, then it's wrong
										$wrong_chosen = 0;
										// foreach($submitted_answer_array as $mul_answer){
											foreach($submitted_answer_array as $ans){
												if(!in_array($ans, $right_options))
													$wrong_chosen += 1;
											}
										// }
										if($wrong_chosen == 0)
											$is_correct = true;
										// get answer option list
                                		$answer_list = $this->otest->get_answer_data(array('question_id' => $answer->question_id));
                                		// send to output
                                		echo '<ol type="a">';
                                		$cnt_m = 0;
                                		foreach($answer_list->result() as $list){
                                			if(in_array($list->id, $right_options) and $list->is_right_answer=="1"){
                                				echo '<li class="right-submitted-answer">'.$list->answer.'</li>';
                                				$right_answer .= $abc_array[$cnt_m].', ';
                                			}
                                			else if(in_array($list->id, $submitted_answer_array) and $list->is_right_answer=="0")
                                				echo '<li class="wrong-submitted-answer">'.$list->answer.'</li>';
                                				
                                			else
                                				echo '<li>'.$list->answer.'</li>';

                                			if($answer->answer == $list->id and $list->is_right_answer=="1")
                                				$is_correct = true;

                                			$cnt_m++;
                                		}
                                		echo '</ol>';
                                		$right_answer = rtrim($right_answer, ', ');
                                	}

                                	if(!$is_correct){
                                		echo '<p class="wrong-submitted-answer">Correct answer: '.$right_answer.'</p>';
                                	}
                                	// $question_info = $this->otest->get_answer_data(array('question_id' => $answer->question_id));
                                	// $question = $question_info->row()->question;
                                	// echo $question;
                                ?>
                                </td>
                               	<td>
                               	<?php 
                               		if($is_correct)
                               			echo '<i class="fa fa-check right-submitted-answer"></i>';
                               		else
                               			echo '<i class="fa fa-times wrong-submitted-answer"></i>';
                               	?>
                               	</td>
							</tr>
							<?php }	?>	
			          	</table>
		          	</div><!-- /.box-body -->
		        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>

</body>
</html>
