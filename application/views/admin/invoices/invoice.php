<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			echo form_open($this->uri->uri_string(),array('id'=>'invoice-form','class'=>'_transaction_form invoice-form'));
			if(isset($invoice)){
				echo form_hidden('isedit');
			}
			?>
			<div class="col-md-12">
				<?php $this->load->view('admin/invoices/invoice_template'); ?>
			</div>
			<?php echo form_close(); ?>
			<?php $this->load->view('admin/invoice_items/item'); ?>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
	$(function(){
		validate_invoice_form();
	    // Init accountacy currency symbol
	    init_currency_symbol();
	    // Project ajax search
	    init_ajax_project_search_by_customer_id();
	    // Maybe items ajax search
	    init_ajax_search('items','#item_select.ajax-search',undefined,admin_url+'items/search');
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".recurring_custom").hide();
		$("#cycles_wrapper").hide();
		$('#recurring').on("change",function(){
			var recurring = $('[name="recurring"]').val();
			var clientid = $("#clientid").val();

			if(recurring != 0 && $.isNumeric(recurring))
			{
				$(".recurring_custom").hide();
				$("#cycles_wrapper").show();
				$.ajax({
				method:'post',
				url:'<?php echo base_url('admin/invoices/check_recurring_invoice');?>',
				data:{clientid:clientid},
				dataType:'json',
		        success:function(res)
		        {	


		        	if(res.status)
		        	{
		        		$(".error_alert").html('<div class="alert alert-danger" role="alert">This client already has recurring invoice</div>');
		        		$(".savebtn").prop("disabled",true);
		        	}
		        	else
		        	{
		        		$(".error_alert").html("");
		        		$(".savebtn").removeAttr("disabled");
		        	}
		        },

    			});
			}
			else if(recurring == "custom")
			{	
				$("#cycles_wrapper").show();
				$(".recurring_custom").show();
			}
			else
			{
				$(".recurring_custom").hide();
				$("#cycles_wrapper").hide();
				$(".error_alert").html("");
				$(".savebtn").prop("disabled",false);
			}
			return false;
			
		});


		
	})
</script>
</body>
</html>
