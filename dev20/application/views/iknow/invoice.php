    <!--CONTANT START-->
    <div class="contant">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-9 col-md-push-3">
                    <h2><?php echo $sub_page_title; ?></h2>
                    <div class="profile-box invoice-hint">
                      <h2><?php echo $this->lang->line('invoice_payment_hint_2') ?></h2>
                      <ul class="fa-ul">
                        <?php if($bank_accounts <> false) 
                            foreach($bank_accounts->result() as $acc){
                        ?>
                            <li><i class="fa-li fa fa-bank"></i> <?php echo $acc->bank_name ?>
                                <p><u><?php echo $acc->bank_account_number ?></u> (<?php echo $acc->bank_holder_name ?>)</p>
                                <p><?php echo $this->lang->line('bank_branch') . ': ' . $acc->bank_branch . ' '.$acc->bank_city ?></p>
                            </li>
                        <?php } ?>
                        <!-- <li>Veritrans
                            <ul class="fa-ul">
                                <li><i class="fa-li fa fa-circle-o"></i> <?php echo $this->lang->line('invoice_payment_hint_veritrans_1') ?></li>
                                <li><i class="fa-li fa fa-circle-o"></i> <?php echo $this->lang->line('invoice_payment_hint_veritrans_2') ?></li>
                                <li><i class="fa-li fa fa-circle-o"></i> <?php echo $this->lang->line('invoice_payment_hint_veritrans_admin_fee') ?> 3.3%</li>
                                <li><i class="fa-li fa fa-circle-o"></i> <?php echo $this->lang->line('invoice_payment_hint_veritrans_3') ?></li>
                            </ul>
                        </li>

                        <li>ATM Transfer BCA
                        	<ul class="fa-ul">
                                <li><i class="fa-li fa fa-circle-o"></i> <?php echo $this->lang->line('invoice_payment_hint_no_admin_fee') ?></li>
                            </ul>
                        </li> -->
                        <!-- <li>Paypal
                        	<ul class="fa-ul">
                                <li><i class="fa-li fa fa-circle-o"></i> <?php echo $this->lang->line('invoice_payment_hint_no_admin_fee') ?></li>
                            </ul>
                        </li> -->
                      </ol>
                    </div>
                	<div class="profile-box editing">
                        <h2><?php echo $this->lang->line('invoice_data') ?></h2>
                        <table>
                            <thead>
                                <tr>
                                    <td><?php echo $this->lang->line('invoice_id') ?></td>
                                    <td><?php echo $this->lang->line('total') ?> (IDR)</td>
                                    <td><?php echo $this->lang->line('due_date') ?></td>
                                    <td><?php echo $this->lang->line('choose_bank_account_destination') ?></td>
                                    <!-- <td><?php echo $this->lang->line('admin_fee') ?> (IDR)</td>
                                    <td><?php echo $this->lang->line('grand_total') ?> (IDR)</td> -->
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($invoices<>false) {
                                    foreach($invoices->result() as $inv){?>
                                <tr>
                                    <td>
                                    	<p><strong><?php echo $inv->invoice_id; ?></strong></p>
                                    	<p><strong>Status: </strong><?php echo $inv->status; ?></p>
                                    </td>
                                    <td><?php echo number_format($inv->total, 0, ',', '.'); ?></td>
                                    <td><?php echo date_format(new DateTime($inv->due_date), 'd M Y H:i:s'); ?></td>
                                    <?php if($inv->status=="Open") {?>
                                    <td>
                                    	<!-- <select class="form-control" id="sel-pay-<?php echo $inv->invoice_id ?>" onchange="change_sel('<?php echo $inv->invoice_id ?>')"> -->
                                        <select class="form-control" id="sel-pay-<?php echo $inv->invoice_id ?>">
                                    		<option value=""></option>
                                            <?php if($bank_accounts <> false) 
                                                foreach($bank_accounts->result() as $acc){
                                            ?>
                                                <option><?php echo $acc->bank_name ?></option>
                                            <?php } ?>
                                    		<!-- <option value="veritrans">Veritrans</option>
                                    		<option value="bca">Bank BCA</option> -->
                                    		<!-- <option value="paypal">Paypal</option> -->
                                    	</select>
                                    </td>
                                    <!-- <td><p id="admin-fee-<?php echo $inv->invoice_id ?>"></td>
                                    <td><p id="total-<?php echo $inv->invoice_id ?>"></td> -->
                                    <td>
                                    	<button class="btn-style" id="btn-pay-<?php echo $inv->invoice_id ?>" onclick="pay('<?php echo $inv->invoice_id ?>')"><?php echo $this->lang->line('confirm_payment')?></button>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
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
<script>
	function change_sel(inv_id){
		$.ajax({
	      type : "GET",
	      url: base_url+'invoice/change_method',
	      data: 'inv='+inv_id+'&method='+$('#sel-pay-'+inv_id).val(),
	      dataType: "json",
	      success:function(data){
	        $('#admin-fee-'+inv_id).text(data.admin_fee);
	        $('#total-'+inv_id).text(data.total);
	      },
	      error: function(e) {
	        // Schedule the next request when the current one's complete,, in miliseconds
	          alert('Error processing your request: '+e.responseText);
	        }
	    });
	}

	function pay(inv_id){
		// if($('#sel-pay-'+inv_id).val()=="veritrans")
		// 	window.location.href = base_url+'veritrans/vtweb_checkout?inv='+inv_id;
		// else if($('#sel-pay-'+inv_id).val()=="bca")
		// 	window.location.href = base_url+'frontpage/payment_confirmation?bank=bca&inv='+inv_id;
		// else if($('#sel-pay-'+inv_id).val()=="paypal")
		// 	window.location.href = base_url+'paypal/ap_checkout?inv='+inv_id;
        var acc_name = $('#sel-pay-'+inv_id).val();
		if(acc_name=="")
			alert('<?php echo $this->lang->line('choose_one')?>');
        else
            window.location.href = base_url+'frontpage/payment_confirmation?bank='+acc_name.toLowerCase()+'&inv='+inv_id;
	}
</script>