<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style type="text/css">
       .onoffswitch {
    position: relative;
    width: 50px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none
}
.onoffswitch-checkbox {
    display: none
}
.onoffswitch-label {
    display: block;
    overflow: hidden;
    cursor: pointer;
    height: 20px;
    padding: 0;
    line-height: 22px;
    border: 1px solid #bfcbd9;
    border-radius: 22px;
    background-color: #bfcbd9;
    -webkit-transition: background-color .3s ease-in;
    transition: background-color .3s ease-in
}
.onoffswitch-label:before {
    content: "";
    display: block;
    width: 20px;
    margin: 0;
    background: #fff;
    position: absolute;
    top: 0;
    bottom: 0;
    right: 30px;
    border: 1px solid #bfcbd9;
    border-radius: 20px;
    -webkit-transition: all .3s ease-in 0s;
    transition: all .3s ease-in 0s
}
.onoffswitch-checkbox:checked+.onoffswitch-label {
    background-color: #84c529
}
.onoffswitch-checkbox:checked+.onoffswitch-label, .onoffswitch-checkbox:checked+.onoffswitch-label:before {
    border-color: #84c529
}
.onoffswitch-checkbox:checked+.onoffswitch-label:before {
    right: 0
}
.onoffswitch-checkbox:disabled+.onoffswitch-label {
    opacity: .5
}
.itemdiv{
  margin-top: 65px;
}
</style>

<div class="col-md-12 page-pdf-html-logo">
   <div class="invoice-html-logo">
      <?php get_company_logo('','pull-left'); ?>
   </div>
   <?php if(is_client_logged_in() && has_contact_permission('invoices')){ ?>
   <a href="<?php echo site_url('clients/invoices/'); ?>" class="btn btn-default pull-right go-to-portal">
   <?php echo _l('client_go_to_dashboard'); ?>
   </a>
   <?php } ?>
</div>
<div class="clearfix"></div>
<div class="panel_s mtop20">
   <div class="panel-body">
      <div class="col-md-10 col-md-offset-1">
         <div class="row">
            <div class="col-md-6">
               <div class="mtop10 display-block invoice-html-status">
                  <?php echo format_invoice_status($invoice->status,'',true); ?>
               </div>
            </div>
            <div class="col-md-6 text-right _buttons">
               <div class="visible-xs">
                  <div class="mtop10"></div>
               </div>
               <a href="#" style="display:none;" class="btn btn-success pull-right mleft5 invoice-html-pay-now-top<?php if (($invoice->status != 2 && $invoice->status != 5 && $invoice->total > 0) && found_invoice_mode($payment_modes,$invoice->id,false)){ echo ' pay-now-top'; } ?>"><?php echo _l('invoice_html_online_payment_button_text'); ?></a>
               <?php echo form_open("invoicepdf/".$this->uri->segment(2)."/".$this->uri->segment(3)); ?>
     
               <button type="submit" name="invoicepdf" value="invoicepdf" class="btn btn-default"><i class='fa fa-file-pdf-o'></i> <?php echo _l('clients_invoice_html_btn_download'); ?></button>
               <?php echo form_close(); ?>
            </div>
         </div>
         <div class="row mtop40">
            <div class="col-md-3 col-sm-6 transaction-html-info-col-left">

               <style type="text/css">
                .abc{
                  margin-left: 42px;
                }
                
              </style>




               <?php
                  $companyName = "";
                  $companyName.= "<span class='invoice-html-bill-to bold'>".$invoice->client->company."</span><br>";


                  $address = "";
                  if(!empty($invoice->billing_street))
                  {
                    $address.= "<p>".$invoice->billing_street."<br>";
                  }
                  if(!empty($invoice->billing_city))
                  {
                    $address.= $invoice->billing_city.", ";
                  }
                  if(!empty($invoice->billing_state))
                  {
                    $address.= $invoice->billing_state." ";
                  }
                  if(!empty($invoice->billing_zip))
                  {
                    $address.= $invoice->billing_zip."<p>";
                  }
                ?>

               <span class="bold invoice-html-bill-to"><?php echo _l('invoice_bill_to'); ?>:
                </span> <?php echo $companyName; ?>
                <div class="abc">
                 <?php echo $address; ?>
                </div>
               
               
            </div>
            <div class="col-md-6 col-sm-6 transaction-html-info-col-left"></div>
            <div class="col-sm-3 text-right transaction-html-info-col-right">
              <style type="text/css">
                .custombold{
                  text-align: left; 
                  color: black;    
                }
                .algnLeft{
                  text-align: left;
                }
              </style>
            <div class="row">
              <div class="col-sm-6  bold algnLeft" >
                <?php echo _l('invoice_no'); ?>:
              </div>

              <div class="col-sm-6  bold algnLeft">
                <?php echo format_invoice_number($invoice->id); ?>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 bold algnLeft">
                <?php echo _l('client_account_no'); ?>:
              </div>

              <div class="col-sm-6  bold algnLeft">
                <?php echo $invoice->client->account_number; ?>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6  bold algnLeft">
                <?php echo _l('invoice_data_date'); ?>
              </div>

              <div class="col-sm-6 bold  algnLeft">
                <?php echo _d($invoice->date); ?>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 bold algnLeft">
                <?php echo _l('invoice_data_duedate'); ?>
              </div>

              <div class="col-sm-6 bold algnLeft">
                <?php echo _d($invoice->duedate); ?>
              </div>
            </div>







               <?php if($invoice->sale_agent != 0 && get_option('show_sale_agent_on_invoices') == 1){ ?>
               <p class="no-mbot invoice-html-sale-agent">
                  <span class="bold"><?php echo _l('sale_agent_string'); ?>:</span>
                  <?php echo get_staff_full_name($invoice->sale_agent); ?>
               </p>
               <?php } ?>
               <?php if($invoice->project_id != 0 && get_option('show_project_on_invoice') == 1){ ?>
               <p class="no-mbot invoice-html-project">
                  <span class="bold"><?php echo _l('project'); ?>:</span>
                  <?php echo get_project_name_by_id($invoice->project_id); ?>
               </p>
               <?php } ?>
               <?php $pdf_custom_fields = get_custom_fields('invoice',array('show_on_pdf'=>1,'show_on_client_portal'=>1));
                  foreach($pdf_custom_fields as $field){
                      $value = get_custom_field_value($invoice->id,$field['id'],'invoice');
                      if($value == ''){continue;} ?>
               <p class="no-mbot">
                  <span class="bold"><?php echo $field['name']; ?>: </span>
                  <?php echo $value; ?>
               </p>
               <?php } ?>
            </div>
         </div>
         <div class="row itemdiv">
            <div class="col-md-12">
                <div class="table-responsive">
                 <?php
                     $items = get_items_table_data($invoice, 'invoice');
                     echo $items->table();
                  ?>
            </div>
            </div>
            <div class="col-md-6 col-md-offset-6">
               <table class="table text-right">
                  <tbody>
                     <tr id="subtotal">
                        <td><span class="bold"><?php echo _l('invoice_subtotal'); ?></span>
                        </td>
                        <td class="subtotal">
                           <?php echo format_money($invoice->subtotal,$invoice->symbol); ?>
                        </td>
                     </tr>
                     <?php if(is_sale_discount_applied($invoice)){ ?>
                     <tr>
                        <td>
                           <span class="bold"><?php echo _l('invoice_discount'); ?>
                           <?php if(is_sale_discount($invoice,'percent')){ ?>
                           (<?php echo app_format_number($invoice->discount_percent,true); ?>%)
                           <?php } ?></span>
                        </td>
                        <td class="discount">
                           <?php echo '-' . format_money($invoice->discount_total,$invoice->symbol); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php
                        foreach($items->taxes() as $tax){
                            echo '<tr class="tax-area"><td class="bold">'.$tax['taxname'].' ('.app_format_number($tax['taxrate']).'%)</td><td>'.format_money($tax['total_tax'], $invoice->symbol).'</td></tr>';
                        }
                        ?>
                     <?php if((int)$invoice->adjustment != 0){ ?>
                     <tr>
                        <td>
                           <span class="bold"><?php echo _l('invoice_adjustment'); ?></span>
                        </td>
                        <td class="adjustment">
                           <?php echo format_money($invoice->adjustment,$invoice->symbol); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <tr>
                        <td><span class="bold"><?php echo _l('invoice_total'); ?></span>
                        </td>
                        <td class="total">
                           <?php echo format_money($invoice->total,$invoice->symbol); ?>
                        </td>
                     </tr>
                     <?php if(count($invoice->payments) > 0 && get_option('show_total_paid_on_invoice') == 1){ ?>
                     <tr>
                        <td><span class="bold"><?php echo _l('invoice_total_paid'); ?></span></td>
                        <td>
                           <?php echo '-' . format_money(sum_from_table(db_prefix().'invoicepaymentrecords',array('field'=>'amount','where'=>array('invoiceid'=>$invoice->id))),$invoice->symbol); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php if(get_option('show_credits_applied_on_invoice') == 1 && $credits_applied = total_credits_applied_to_invoice($invoice->id)){ ?>
                     <tr>
                        <td><span class="bold"><?php echo _l('applied_credits'); ?></span></td>
                        <td>
                           <?php echo '-' . format_money($credits_applied,$invoice->symbol); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php if(get_option('show_amount_due_on_invoice') == 1 && $invoice->status != 5) { ?>
                     <tr>
                        <td><span class="<?php if($invoice->total_left_to_pay > 0){echo 'text-danger ';} ?>bold"><?php echo _l('invoice_amount_due'); ?></span></td>
                        <td>
                           <span class="<?php if($invoice->total_left_to_pay > 0){echo 'text-danger';} ?>">
                           <?php echo format_money($invoice->total_left_to_pay,$invoice->symbol); ?>
                           </span>
                        </td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
            <?php if(get_option('total_to_words_enabled') == 1){ ?>
            <div class="col-md-12 text-center invoice-html-total-to-words">
               <p class="bold no-margin">
                  <?php echo  _l('num_word').': '.$this->numberword->convert($invoice->total,$invoice->currency_name); ?>
               </p>
            </div>
            <?php } ?>
            <?php if(count($invoice->attachments) > 0 && $invoice->visible_attachments_to_customer_found == true){ ?>
            <div class="clearfix"></div>
            <div class="invoice-html-files">
               <div class="col-md-12">
                  <hr />
                  <p class="bold mbot15 font-medium"><?php echo _l('invoice_files'); ?></p>
               </div>
               <?php foreach($invoice->attachments as $attachment){
                  // Do not show hidden attachments to customer
                  if($attachment['visible_to_customer'] == 0){continue;}
                  $attachment_url = site_url('download/file/sales_attachment/'.$attachment['attachment_key']);
                  if(!empty($attachment['external'])){
                  $attachment_url = $attachment['external_link'];
                  }
                  ?>
               <div class="col-md-12 mbot10">
                  <div class="pull-left"><i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i></div>
                  <a href="<?php echo $attachment_url; ?>"><?php echo $attachment['file_name']; ?></a>
               </div>
               <?php } ?>
            </div>
            <?php } ?>
            <?php if(!empty($invoice->clientnote)){ ?>
            <div class="col-md-12 invoice-html-note">
               <b><?php echo _l('invoice_note'); ?></b><br /><br /><?php echo $invoice->clientnote; ?>
            </div>
            <?php } ?>
            <?php if(!empty($invoice->terms)){ ?>
            <div class="col-md-12 invoice-html-terms-and-conditions">
               <hr />
               <b><?php echo _l('terms_and_conditions'); ?></b><br /><br /><?php echo $invoice->terms; ?>
            </div>
            <?php } ?>
            <div class="col-md-12">
               <hr />
            </div>
            <!-- <div class="col-md-12 invoice-html-payments">
               <?php
                  $total_payments = count($invoice->payments);
                  if($total_payments > 0){ ?>
               <p class="bold mbot15 font-medium"><?php echo _l('invoice_received_payments'); ?></p>
               <table class="table table-hover invoice-payments-table">
                  <thead>
                     <tr>
                        <th><?php echo _l('invoice_payments_table_number_heading'); ?></th>
                        <th><?php echo _l('invoice_payments_table_mode_heading'); ?></th>
                        <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
                        <th><?php echo _l('invoice_payments_table_amount_heading'); ?></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($invoice->payments as $payment){ ?>
                     <tr>
                        <td>
                           <span class="pull-left"><?php echo $payment['paymentid']; ?></span>
                           <?php echo form_open($this->uri->uri_string()); ?>
                           <button type="submit" value="<?php echo $payment['paymentid']; ?>" class="btn btn-icon btn-default pull-right" name="paymentpdf"><i class="fa fa-file-pdf-o"></i></button>
                           <?php echo form_close(); ?>
                        </td>
                        <td><?php echo $payment['name']; ?> <?php if(!empty($payment['paymentmethod'])){echo ' - '.$payment['paymentmethod']; } ?></td>
                        <td><?php echo _d($payment['date']); ?></td>
                        <td><?php echo format_money($payment['amount'],$invoice->symbol); ?></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
               <hr />
               <?php } else { ?>
               <h5 class="bold pull-left"><?php echo _l('invoice_no_payments_found'); ?></h5>
               <div class="clearfix"></div>
               <hr />
               <?php } ?>
            </div> -->
            <?php
               // No payments for paid and cancelled
               if (($invoice->status != 2 && $invoice->status != 5 && $invoice->total > 0)){ ?>
            <div class="col-md-12">
               <div class="row">
                  <?php
                     $found_online_mode = false;
                     if(found_invoice_mode($payment_modes,$invoice->id,false)) {
                         $found_online_mode = true;
                         ?>
                  <div class="col-md-12 text-left">
                     <!-- <p class="bold mbot15 font-medium"><?php echo _l('invoice_html_online_payment'); ?></p> -->
                     <?php echo form_open($this->uri->uri_string(),array('id'=>'online_payment_form','novalidate'=>true)); ?>
                     <?php foreach($payment_modes as $mode){
                        if(!is_numeric($mode['id']) && !empty($mode['id'])) {
                            if(!is_payment_mode_allowed_for_invoice($mode['id'],$invoice->id)){
                                continue;
                            }
                            ?>
<!-- 
                     <div class="radio radio-success online-payment-radio">
                        <input type="radio" value="<?php echo $mode['id']; ?>" id="pm_<?php echo $mode['id']; ?>" name="paymentmode">
                        <label for="pm_<?php echo $mode['id']; ?>"><?php echo $mode['name']; ?></label>

                     </div> -->
                     <input type="hidden" name="paymentmode" value="<?php echo $mode['id']; ?>">

                     <?php if(!empty($mode['description'])){ ?>
                     <div class="mbot15">
                        <?php echo $mode['description']; ?>
                     </div>
                     <?php }
                        }
                        } ?>
                    
                    <?php if($invoice->recurring == 0){ ?>
                    
                     <div class="form-group mtop25">
                        <?php if(get_option('allow_payment_amount_to_be_modified') == 1){ ?>
                        <label for="amount" class="control-label"><?php echo _l('invoice_html_amount'); ?></label>
                        <div class="input-group">
                           <input type="number" required max="<?php echo $invoice->total_left_to_pay; ?>" data-total="<?php echo $invoice->total_left_to_pay; ?>" name="amount" id="totalpay1" class="form-control" value="<?php echo $invoice->total_left_to_pay; ?>">
                           <span class="input-group-addon">
                           <?php echo $invoice->symbol; ?>
                           </span>
                        </div>
                        <?php } else {
                           echo '<span class="bold">' . _l('invoice_html_total_pay',format_money($invoice->total_left_to_pay,$invoice->symbol)) . '</span>';
                           } ?>
                     </div>
                   <?php } else { ?>
                    <input type="hidden" name="amount" id="totalpay2" value="<?php echo $invoice->total_left_to_pay; ?>">
                  <?php } ?>

                  <?php if($invoice->recurring != 0){ ?>
                    <div class="col-md-12">
                        <h5>From here you can make a one-time payment, set up recurring payments, or update your existing recurring method of payment. Select the frequency and method of payment that best fits your needs.</h5>
                  </div>
                  <div class="col-md-6">

                    <div class="row">
                      <div class="col-md-6">
                        <h3 style="    margin: auto;
                        padding: 3px;">Payment Frequency:</h3>
                      </div>
                      <div class="col-md-6">
                        <?php echo render_yes_no_option("autopay","","",'Recurring', 'One-time'); ?>
                      </div>

                    </div>

                  </div>
                <?php }else { ?>
                  <div class="col-sm-6"></div>
                <?php } ?>
                  <div class="col-md-6" style="text-align: right;">
                   
                     <button type="button" class="btn btn-success paymentbtn" data-id="<?=$invoice->id?>" data-toggle="modal" data-target="#payModel"><?php echo _l('invoice_html_online_payment_button_text'); ?></button>
           <!--       <input type="submit" name="make_payment" class="btn btn-success" style="float: right;" value="<?php echo _l('invoice_html_online_payment_button_text'); ?>"> -->
                       <input type="hidden" name="hash" value="<?php echo $hash; ?>">                        <?php echo form_close(); ?>
                  
                  
               </div>
                  </div>




                  <!-- Model Start -->
                  <div id="payModel" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                     
                        <div class="modal-body">

                          <div class="row">
                            <div class="panel_s">
                              <div class="panel-body" style="text-align: center;">
                               <h4 class="no-margin">
                                <?php echo _l('payment_for_invoice'); ?>
                                <a href="<?php echo site_url('invoice/' . $invoice->id . '/' . $invoice->hash); ?>">
                                  <?php echo format_invoice_number($invoice->id); ?>
                                </a>
                              </h4>
                              <hr />
                              <p>
                                <span class="bold custompay">
                                  <?php echo _l('payment_total', format_money($invoice->total, $invoice->symbol)); ?>
                                </span>
                              </p>
                              <?php
                              if(isset($stripe_customer) && !empty($stripe_customer->default_source->brand)) {
                                echo form_open(site_url('gateways/stripe/complete_purchase/'.$invoice->id.'/'. $invoice->hash));
                                echo '<button type="submit" name="pay_with_card" value="true" class="btn btn-success mbot15">';
                                echo form_hidden('total', $invoice->total);
                                echo _l('view_invoice_pdf_link_pay') . ' ('.$stripe_customer->default_source->brand . ' ' . $stripe_customer->default_source->last4.')';
                                echo '</button>';
                                echo form_close();
                              }
                              $form = '<form action="' . site_url('gateways/stripe/complete_purchase/'.$invoice->id.'/'. $invoice->hash) . '" method="POST">
                              <script
                              src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                              data-label="'.(isset($stripe_customer) && !empty($stripe_customer->default_source) ? _l('enter_new_card') : _l('pay_with_card')).'"
                              data-key="' . $this->stripe_gateway->getSetting('api_publishable_key') . '"
                              data-amount="' . (strcasecmp($invoice->currency_name, 'JPY') == 0 ? $invoice->total : $invoice->total * 100) . '"
                              data-name="' . get_option('companyname') . '"
                              data-billing-address="true"
                              data-description=" ' . _l('payment_for_invoice') . ' ' . format_invoice_number($invoice->id) . '";
                    
                              ' . (is_client_logged_in() ? 'data-email="' . $contact->email . '"' : '') . '
                              data-currency="' . $invoice->currency_name . '"
                              >
                              </script>
                              ' . form_hidden('total', $invoice->total ) . '
                              </form>';
                              echo $form;

                          
                              ?>
                            
                          </div>
                        </div>

                        </div>
                       
                      </div>

                    </div>
                  </div>


                  <!-- Model End -->


                  <?php } ?>
                  <!-- <?php if(found_invoice_mode($payment_modes,$invoice->id)) { ?>
                  <div class="invoice-html-offline-payments <?php if($found_online_mode == true){echo 'col-md-6 text-right';}else{echo 'col-md-12';};?>">
                     <p class="bold mbot15 font-medium"><?php echo _l('invoice_html_offline_payment'); ?></p>
                     <?php foreach($payment_modes as $mode){
                        if(is_numeric($mode['id'])) {
                            if(!is_payment_mode_allowed_for_invoice($mode['id'],$invoice->id)){
                                continue;
                            }
                            ?>
                     <p class="bold"><?php echo $mode['name']; ?></p>
                     <?php if(!empty($mode['description'])){ ?>
                     <div class="mbot15">
                        <?php echo $mode['description']; ?>
                     </div>
                     <?php }
                        }
                        } ?>
                  </div>
                  <?php } ?> -->
               </div>
            </div>
            <?php } ?>
            
           
        
         
         </div>
         
      </div>
   </div>
</div>
<script>
   $(function(){

       var pay_now_top = $('.pay-now-top');
       if(pay_now_top.length) {
           if ($(document).height() > $(window).height() + 40) {
               pay_now_top.css('display','block');
           }
           $('.pay-now-top').on('click',function(e){
               e.preventDefault();
               $('html,body').animate({
                   scrollTop: $("#online_payment_form").offset().top},
                   'slow');
           });
       }

       $('#online_payment_form').validate();

       var online_payments = $('.online-payment-radio');
       if(online_payments.length == 1){
           online_payments.find('input').prop('checked',true);
       }



   });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $(".paymentbtn").on("click",function(){
      var csrf_tkn = $("[name='csrf_token_name']").val();
      var invoice_id = $(this).attr('data-id');
      var option = $("[name='settings[autopay]']:checked").val();

      $.ajax({
        method:'post',
        url:'<?php echo base_url('invoice/updateInvoice');?>',
        data:{csrf_tkn:csrf_tkn,invoice_id:invoice_id,option:option},
        dataType:'json',
        success:function(suc)
        {

          if(suc.status)
          {
            console.log("true");
          }

        },


      });
    })


    $("#totalpay1").on("keyup",function(){

      var total = $("#totalpay1").val();
      var apvalue = "";

      var num = total % 1;
      if(num == "")
      {
        apvalue = parseInt(total)+".00";
      }
      else
      {
        apvalue = parseInt(total)+parseFloat(num.toFixed(2))

      }
       $(".custompay").html("Total: $"+apvalue);
       $("[name='total']").val(apvalue);

    })


  })
</script>
