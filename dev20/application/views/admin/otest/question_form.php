<?php 
	if($mode=="add") $title="Add new";
	else if($mode=="edit") $title="Edit";
?>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo GENERAL_CSS_DIR;?>/jquery.tagsinput.css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
		<h1>
			<?php echo $title;?> question
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Online Test</a></li>
			<li class="active"><a href="#"><?php echo $title;?> Question</a></li>
		</ol>
  </section>
	
	<!-- Main content -->
  <section class="boxku">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-warning"></i> Hint</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <ol>
            	<li>Choose the answer type.</li>
            	<li>Type the question inside the editor.</li>
            	<li>If you need to type a mathematic equation, open another editor by clicking button "fx".</li>
            	<li>If the answer type is "Fill in the blank" or "Boolean", set the answer on the right side of the editor.</li>
            	<li>If the answer type is "Single" or "Multiple", set the answer below of the editor.</li>
            </ol>
          </div><!-- /.box-body -->
      	</div><!-- /.box -->
			</div>
			<?php $this->load->view('admin/message_after_transaction');?>			
			<div class="col-xs-12">
				<div class="box box-info">
  				<!-- <div class="box-header">
						<h3 class="box-title"><?php echo $mode;?> test
						</h3>
        	</div> --><!-- /.box-header -->
        		<form id="form" method="post" action="<?php echo base_url().($mode=="add" ? 'otest/add_question/'.$this->uri->segment(3) : 'otest/update_question/'.$test_id.'/'.$question_id);?>">
							<div class="box-body">
								<button type="submit" class="btn btn-primary">Save</button>
								<a href="<?php echo base_url('otest/question/'.$this->uri->segment(3))?>" class="btn btn-default">Back</a>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="type" class="label-required">Type</label>
											<?php echo form_dropdown('type', $answer_types, $mode=="add"?"":$question_data->answer_type, 'id="type" class="form-control"'); ?>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title" class="label-required">Question</label>
											<textarea class="form-control" id="question" name="question" rows="10" cols="80" required> <?php if($mode=='edit') echo $question_data->question;?></textarea>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-md-6">
										<?php 
											$bool_disabled = '';
											$fill_disabled = '';
											if($mode=="edit"){
												if($question_data->answer_type<>"Bool")
													$bool_disabled = 'disabled';
												if($question_data->answer_type<>"Fill")
													$fill_disabled = 'disabled';
											}
											
										 ?>
										<div class="form-group">
											<label for="bool-type">Boolean type</label>
											<?php echo form_dropdown('bool-type', $bool_types, $mode=="add"?"":$question_data->boolean_type, 'id="bool-type" class="form-control "'.$bool_disabled); ?>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="content">Select the correct answer of "Boolean"</label>
											<?php echo form_dropdown('bool-answer', $bool_answers, $mode=="add"?"":$question_data->answer_text, 'id="bool-answer" class="form-control"'.$bool_disabled); ?>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="category">Type the correct answer of "Fill in the blank"</label>
											<input type="text" class="form-control input-sm" id="fill-type" name="fill-answer" value="<?php if($mode=='edit') echo $question_data->answer_text;?>" placeholder="Ex: 148, Sarah, cat" <?php echo $fill_disabled;?>>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-md-12">
										<div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="random-choice" name="random-choice" <?php if($mode=="edit") echo (in_array($question_data->answer_type, array("Single", "Multiple")) ? "" : "disabled");?> <?php if($mode=="edit") echo ($question_data->random_choice=="1" ? "checked" : "")?>> Generate random choice?
                        </label>
                      </div>
                    </div>
										<table class="table table-bordered">
	                    <tr>
	                      <th style="width: 10px">Option #</th>
	                      <th>Answer text</th>
	                      <th>True Answer</th>
	                    </tr>
										<?php for($i=0; $i<5; $i++){ ?>
											<tr>
												<td><?php echo $i+1?></td>
												<td>
													<textarea class="form-control" id="option-<?php echo $i?>" name="answers[]" rows="5" cols="80"> <?php if($mode=='edit' and sizeof($answer_data)>0 and isset($answer_data[$i])) echo $answer_data[$i]['answer'];?></textarea>
												</td>
												<td>
													<div id="true-answer-<?php echo $i?>">
														<?php 
															if($mode=='edit' and sizeof($answer_data)>0)
																if($question_data->answer_type=="Single"){
														?>
														<div class="form-group">
				                      <div class="radio">
				                        <label>
				                          <input type="radio" name="true-answer" value="<?php echo $i?>" <?php if(isset($answer_data[$i])) if($answer_data[$i]['right_answer']=="1") echo "checked"?>>
				                        </label>
				                      </div>
			                      </div>
			                      <?php
			                      	}
			                      	else if($question_data->answer_type=="Multiple"){
			                      ?>
			                      <div class="form-group">
				                      <div class="checkbox">
				                        <label>
				                          <input type="checkbox" name="true-answer[]" value="<?php echo $i?>" <?php if(isset($answer_data[$i])) if($answer_data[$i]['right_answer']=="1") echo "checked"?>>
				                        </label>
				                      </div>
			                      </div>
			                      <?php } ?>
													</div>
												</td>
											</tr>
										<?php } ?>
										</table>
									</div><!-- ./col -->
								</div><!-- ./row -->
							</div><!-- /.box-body -->
							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Save</button>
								<a href="<?php echo base_url('otest/question/'.$this->uri->segment(3))?>" class="btn btn-default">Back</a>
							</div>
						</form>
	      </div><!-- /.box -->
			</div><!-- /.col -->
		</div>
	</section>
		  
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/footer');?>
<!-- CK Editor -->
<script src="<?php echo ADMIN_LTE_DIR;?>/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<script>
	$(function () {
	    // Replace the <textarea id="editor1"> with a CKEditor
	    // instance, using default configuration.
	    CKEDITOR.replace('question');
	    for(var i=0; i<5; i++)
	    	CKEDITOR.replace('option-'+i);
	  });

	$('#type').on('change', function(){
		var type = $(this).val();
		if(type=="Bool"){
			$('#fill-type').prop('disabled', true);
			$('#bool-type').prop('disabled', false);
			$('#bool-answer').prop('disabled', false);
			$('#random-choice').prop('disabled', true);
		}
		else if(type=="Fill"){
			$('#fill-type').prop('disabled', false);
			$('#bool-type').prop('disabled', true);
			$('#bool-answer').prop('disabled', true);
			$('#random-choice').prop('disabled', true);
		}
		else{
			$('#fill-type').prop('disabled', true);
			$('#bool-type').prop('disabled', true);
			$('#bool-answer').prop('disabled', true);
			$('#random-choice').prop('disabled', false);
			if(type=="Single"){
				clear_true_answer_element()
				for(var i=0; i<5; i++)
					$('#true-answer-'+i).append('<div class="form-group">\
                      <div class="radio">\
                        <label>\
                          <input type="radio" name="true-answer" value="'+i+'">\
                        </label>\
                      </div>\
                      </div>');
			}
			else if(type=="Multiple"){
				clear_true_answer_element()
				for(var i=0; i<5; i++)
					$('#true-answer-'+i).append('<div class="form-group">\
                      <div class="checkbox">\
                        <label>\
                          <input type="checkbox" name="true-answer[]" value="'+i+'">\
                        </label>\
                      </div>\
                      </div>');
			}
		}
	});

	function clear_true_answer_element(){
		for(var i=0; i<5; i++){
			$('#true-answer-'+i).empty();
		}
	}
</script>
</body>
</html>
