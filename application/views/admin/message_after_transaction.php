			<?php //for message after submitting data
				if($this->session->flashdata('err_no')=='200' or $this->session->flashdata('err_no')=='0'){
			?>
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<i class="icon fa fa-check"></i>
				<?php echo $this->session->flashdata('err_msg');?>
			</div>
			<?php 
				} else if($this->session->flashdata('err_no')=='204' or $this->session->flashdata('error_upload_no')=="204"){
			?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				<ul>
				<?php 
					$error_messages = $this->session->flashdata('err_msg');
					foreach($error_messages as $msg){
				?>
					<li><?php echo $msg; ?></li>
				<?php } ?>
				</ul>
			</div>
			<?php 
				}
			?>
			