<?php if($title=="add") $post_title = $this->lang->line('add_new_product');
				else if($title=="edit") $post_title = $this->lang->line('edit_product');
			 ?>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo GENERAL_CSS_DIR;?>/jquery.tagsinput.css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?php echo $post_title;?> 
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Products</a></li>
			<li class="active"><a href="#"><?php echo $post_title;?></a></li>
		</ol>
    </section>
	
	<!-- Main content -->
    <section class="boxku">
		<div class="row">
			<?php include('message_after_transaction.php');?>			
			<div class="col-xs-12">
				<div class="box box-info">
        	<!-- <div class="box-header">
						<h3 class="box-title"><?php echo $post_title;?> </h3>
        	</div> --><!-- /.box-header -->
		      <div class="box-body no-padding">
						<!-- form start -->
						<form role="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url().($title=="add" ? 'cms/product_add' : 'cms/product_update');?>">
							<input type="hidden" name="type" value="product">
							<?php if($title=="edit"){
								echo '<input type="hidden" name="product_id" value="'.$this->input->get('pr_id', TRUE).'">' ;
								echo '<input type="hidden" name="post_id" value="'.$this->input->get('po_id', TRUE).'">' ;
							} ?>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-8">
										<div class="form-group">
											<label for="title"><?php echo $this->lang->line('comodity_id'); ?></label>
											<input type="text" class="form-control input-sm" id="stock-id" name="stock-id" placeholder="" value="<?php if($title=='edit') echo (isset($prod_detail->stock_id) ? $prod_detail->stock_id : "");?>" style="text-transform: uppercase" required>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title"><?php echo $this->lang->line('product_title'); ?></label>
											<input type="text" class="form-control input-sm" id="title" name="title" placeholder="" value="<?php if($title=='edit') echo (isset($post_data->title) ? $post_data->title : "");?>" onkeyup="set_url(this.value);" required>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="title">Niece URL</label>
											<input type="text" class="form-control input-sm" id="url" name="url" placeholder="" value="<?php if($title=='edit') echo (isset($post_data->url) ? $post_data->url : "");?>" readonly>
										</div><!-- ./form-group -->
										<div class="form-group">
											<label for="content"><?php echo $this->lang->line('product_content'); ?></label>
											<textarea class="form-control" id="content-editor" name="content" rows="10" cols="80"> <?php if($title=='edit') echo (isset($post_data->content) ? $post_data->content : "");?></textarea>
										</div><!-- ./form-group -->
									</div><!-- ./col -->
									<div class="col-sm-4">
										<div class="form-group">
											<label for="category"><?php echo $this->lang->line('product_category'); ?></label>
											<select class="form-control" id="prod-cat-root" name="category" required>
												<option value="">--<?php echo $this->lang->line('select_root_category'); ?>--</option>
												<?php foreach($root_category->result() as $row) {?>
												<option value="<?php echo $row->id?>" <?php //if($title=="edit" and $row->id==$post_data->category) echo "selected";?>><?php echo $row->category;?></option>
												<?php } ?>
											</select>											
										</div><!-- ./form-group -->
										<div class="form-group" id="sub-category">
                    </div>
										<div class="form-group">
											<label for="title">Tags</label> *<?php echo $this->lang->line('separated_by_comma'); ?>
											<input id="tags_1" type="text" class="tags" name="tags"  value="<?php if($title=='edit') echo (isset($post_data->tags) ? $post_data->tags : "");?>"/>
										</div><!-- ./form-group -->
										<div class="form-group">
													<label for="title"><?php echo $this->lang->line('stock'); ?></label>
													<div class="input-group">
				                    <span class="input-group-addon"><i class="fa fa-file-o"></i></span>
				                    <input type="text" class="form-control" id="stock" name="stock" value="<?php if($title=='edit') echo (isset($prod_detail->stock_qty) ? $prod_detail->stock_qty : "");?>" required>
					                </div>
												</div><!-- ./form-group -->
												<div class="form-group">
													<label for="title"><?php echo $this->lang->line('price_buy'); ?></label>
													<div class="input-group">
				                    <span class="input-group-addon">Rp</span>
				                    <input type="text" class="form-control" id="price-buy" name="price-buy" onkeyup="give_thousand_separator(this.id, this.value)" value="<?php if($title=='edit') echo (isset($prod_detail->price_buy) ? $prod_detail->price_buy : "");?>" required>
					                </div>
												</div><!-- ./form-group -->
												<div class="form-group">
													<label for="title"><?php echo $this->lang->line('price_sell'); ?></label>
													<div class="input-group">
				                    <span class="input-group-addon">Rp</span>
				                    <input type="text" class="form-control" id="price-sell" name="price-sell" onkeyup="give_thousand_separator(this.id, this.value)" value="<?php if($title=='edit') echo (isset($prod_detail->price_sell) ? $prod_detail->price_sell : "");?>" required>
					                </div>
												</div><!-- ./form-group -->
												<div class="form-group">
													<label for="title"><?php echo $this->lang->line('weight_in_gram'); ?></label>
													<div class="input-group">
				                    <span class="input-group-addon"><i class="fa fa-tachometer"></i></span>
				                    <input type="text" class="form-control" id="weight" name="weight" onkeyup="give_thousand_separator(this.id, this.value)" value="<?php if($title=='edit') echo (isset($prod_detail->weight) ? $prod_detail->weight : "");?>" required>
					                </div>
												</div><!-- ./form-group -->
												<div class="checkbox">
	                        <label>
	                          <input type="checkbox" name="as_best_seller" <?php if($title=="edit" and $prod_detail->as_best_seller_banner=="true") echo "checked";?>/>
	                          <?php echo $this->lang->line('as_banner_best_seller'); ?>
	                        </label>
	                      </div>
	                      <div class="checkbox">
	                        <label>
	                          <input type="checkbox" name="as_special_discount" <?php if($title=="edit" and $prod_detail->as_special_discount_banner=="true") echo "checked";?>/>
	                          <?php echo $this->lang->line('as_banner_special_discount'); ?>
	                        </label>
	                      </div>
										
									</div><!-- ./col -->
								</div><!-- ./row -->
								<div class="row">
									<div class="col-md-12">
										<div class="box box-warning">
			                <div class="box-header">
			                  <h3 class="box-title"><?php echo $this->lang->line('setting_discount'); ?></h3>
			                  <div class="box-tools pull-right">
			                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                  </div>
			                </div><!-- /.box-header -->
											<div class="box-body">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="title"><?php echo $this->lang->line('discount_in_qty'); ?> 1</label> (<?php echo $this->lang->line('decimal_in_dot'); ?>)
															<div class="input-group">
						                    <span class="input-group-addon"><?php echo $this->lang->line('per_qty'); ?></span>
						                    <input type="text" class="form-control" id="quantity-get-discount" name="quantity-get-discount[]" value="<?php echo ($title=="add" ? "0" : $discount_detail[0]->on_quantity);?>">
							                </div>
							                <div class="input-group">
						                    <input type="text" class="form-control" id="discount-on-quantity" name="discount-on-quantity[]" value="<?php echo ($title=="add" ? "0" : $discount_detail[0]->discount);?>">
						                    <span class="input-group-addon">%</span>
							                </div>
														</div><!-- ./form-group -->
														<div class="form-group">
															<label for="title"><?php echo $this->lang->line('discount_in_qty'); ?> 2</label> (<?php echo $this->lang->line('decimal_in_dot'); ?>)
															<div class="input-group">
						                    <span class="input-group-addon"><?php echo $this->lang->line('per_qty'); ?></span>
						                    <input type="text" class="form-control" id="quantity-get-discount" name="quantity-get-discount[]" value="<?php echo ($title=="add" ? "0" : $discount_detail[1]->on_quantity);?>">
							                </div>
							                <div class="input-group">
						                    <input type="text" class="form-control" id="discount-on-quantity" name="discount-on-quantity[]" value="<?php echo ($title=="add" ? "0" : $discount_detail[1]->discount);?>">
						                    <span class="input-group-addon">%</span>
							                </div>
														</div><!-- ./form-group -->
													</div> <!-- ./col -->
													<div class="col-md-6" id="discount-in-qty">
														<div class="form-group">
															<label for="title"><?php echo $this->lang->line('discount_in_qty'); ?> 3</label> (<?php echo $this->lang->line('decimal_in_dot'); ?>)
															<div class="input-group">
						                    <span class="input-group-addon"><?php echo $this->lang->line('per_qty'); ?></span>
						                    <input type="text" class="form-control" id="quantity-get-discount" name="quantity-get-discount[]" value="<?php echo ($title=="add" ? "0" : $discount_detail[2]->on_quantity);?>">
							                </div>
							                <div class="input-group">
						                    <input type="text" class="form-control" id="discount-on-quantity" name="discount-on-quantity[]" value="<?php echo ($title=="add" ? "0" : $discount_detail[2]->discount);?>">
						                    <span class="input-group-addon">%</span>
							                </div>
														</div><!-- ./form-group -->
														<div class="form-group">
															<label for="title"><?php echo $this->lang->line('discount_in_qty'); ?> 4</label> (<?php echo $this->lang->line('decimal_in_dot'); ?>)
															<div class="input-group">
						                    <span class="input-group-addon"><?php echo $this->lang->line('per_qty'); ?></span>
						                    <input type="text" class="form-control" id="quantity-get-discount" name="quantity-get-discount[]" value="<?php echo ($title=="add" ? "0" : $discount_detail[3]->on_quantity);?>">
							                </div>
							                <div class="input-group">
						                    <input type="text" class="form-control" id="discount-on-quantity" name="discount-on-quantity[]" value="<?php echo ($title=="add" ? "0" : $discount_detail[3]->discount);?>">
						                    <span class="input-group-addon">%</span>
							                </div>
														</div><!-- ./form-group -->
													</div> <!-- ./col -->
												</div> <!-- ./row -->
											</div> <!-- ./box-body -->
			              </div> <!-- ./box -->
			            </div> <!-- ./col-md-12 -->
								</div><!-- ./row -->
								<div class="row">
									<div class="col-md-12">
										<div class="box box-success">
											<div class="box-header">
			                  <h3 class="box-title"><?php echo $this->lang->line('setting_image'); ?></h3>
			                  <div class="box-tools pull-right">
			                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                  </div>
			                </div><!-- /.box-header -->
			                <div class="box-body">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group" id="primary_image">
				                      <label for="exampleInputFile"><?php echo $this->lang->line('primary_image'); ?></label>
				                      <input type="file" id="image_file" name="image_file" />
				                      <br>
				                      <?php if($title=="edit" and $prod_image <> false and $prod_image->file_name <> ""){
				                      ?>
				                      	<img src="<?php echo $this->config->item('upload_path').$prod_image->file_name;?>" width="150" height="200" />
				                      <?php
				                      } else{
				                      ?>
				                      	<img src="http://placehold.it/150x100" alt="..." class='margin' />
				                      <?php
				                      	}
				                      ?>
				                      <!-- <p class="help-block">This image will be displayed on blog list.</p> -->
				                    </div>
													</div> <!-- ./col -->
													<div class="col-md-3">
														<div class="form-group" id="more_images">
				                    	<label for="exampleInputFile"><?php echo $this->lang->line('add_more_images'); ?></label>
															<input type="file" name="more_images[]" multiple>
														</div>
													</div>
													<div class="col-md-9">
														<?php if($title=="edit") {?>
														<div class="timeline-item">
					                    <div class="timeline-body">
						                      <?php 
						                      	if($more_images<>false){
						                      		$more_img = $more_images->result();
						                      		$post_per_page = 4;
																			$page = ceil(sizeof($more_img) / $post_per_page);
																			for($i=0; $i<$page; $i++){
						                      ?>
						                      <div class="row">
						                      	<?php 
						                      			for($j=$i*$post_per_page; $j<$i*$post_per_page+4; $j++){
						                      				if(isset($more_img[$j])){
						                      	?>
							                      <div class="col-sm-3">
							                      	<img src="<?php echo $this->config->item('upload_path').$more_img[$j]->file_name;?>" alt="..." class='margin' width="150" hegith="180" /><br>
							                      	<a href="<?php echo base_url().'cms/post_media_delete?media='.$more_img[$j]->media_id.'&po_id='.$this->input->get('po_id', TRUE).'&pr_id='.$this->input->get('pr_id', TRUE);?>">Delete this image</a>
							                      </div>
							                      <?php
							                      			}
							                      		}
							                      ?>
					                      	</div>
					                      	<?php 
					                      			}
					                      		} 
					                      	?>
					                    </div>
						                </div>
														<?php } ?>
													</div>
												</div> <!-- ./row -->
											</div> <!-- ./box-body -->

										</div> <!-- ./box -->
			            </div> <!-- ./col-md-12 -->
								</div><!-- ./row -->
							</div><!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" class="btn btn-primary" name="action" value="publish"><?php echo $this->lang->line('publish'); ?></button> 
								<?php if($title<>"edit"){ ?>
								~ <?php echo $this->lang->line('or'); ?> ~ 
								<button type="submit" class="btn btn-info" name="action" value="draft"><?php echo $this->lang->line('save_as_draft'); ?></button>
								<?php } ?>
							</div>
						</form>
        	</div><!-- /.box-body -->
        </div><!-- /.box -->
			</div><!-- /.col -->
		</div> <!-- ./row -->
	</section>
		  
</div><!-- /.content-wrapper -->

<?php include('footer.php');?>
<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Tags Master -->
<script type="text/javascript" src="<?php echo GENERAL_JS_DIR;?>/jquery.tagsinput.js"></script>

<script>
	$(document).ready(function(){
		$('#tags_1').tagsInput({width:'auto'});
		$("#prod-cat-root").change(function(e){
			generate_category_under_root();
		});

	  <?php if($title=="edit"){?>
	    $('#prod-cat-root').val("<?php echo $post_data->category;?>");
	    generate_category_under_root("edit");
	    // $('#prod-cat').val("<?php echo $post_data->category;?>");
	  <?php } ?>

	  give_thousand_separator('price-buy', $('#price-buy').val());
	  give_thousand_separator('price-sell', $('#price-sell').val());
	});

	$(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('content-editor');
    
  });

  $('#btn-add-discount').click(function(){
  	console.log('hai');
  });

	function generate_category_under_root(mode="add"){
    var root_id = $('#prod-cat-root').val();
    var url_string = (mode=="add" ? '<?php echo base_url();?>cms/get_category_under_root?root='+root_id : '<?php echo base_url();?>cms/get_category_under_root?root='+root_id+'&post=<?php echo $this->input->get('po_id', TRUE);?>');

    $.ajax({
        type : "GET",
        async: false,
        url: url_string,
        dataType: "json",
        success:function(data){
        	$('#sub-category').empty();
        	if(data.status=='200'){
        		for(var i=0; i<data.result.length; i++){      			
	    	    	$('#sub-category').append('\
	    	    				<div class="checkbox">\
                        <label>\
                          <input type="checkbox" name="cats[]" value="'+data.result[i].id+'" '+(data.result[i].mapped==true ? "checked" : "")+'/>\
                          '+data.result[i].name+'\
                        </label>\
                      </div>');
	    	    }
        	}
    	    
    	}
    });
	}

	function set_url(title){
		var in_lower = title.toLowerCase();
		$('#url').val(in_lower.replace(/[^a-zA-Z0-9]/g,'-'));
	}
</script>
</body>
</html>
