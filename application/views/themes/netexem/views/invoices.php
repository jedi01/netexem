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

.centerbutton{
    display: block;
    margin: auto;
    margin-top: 12px;
    margin-bottom: 12px;
}
.aligntext{
    text-align: center;
    padding: 20px 0px 0px 100px;
}
.nomargin{
    margin: 0 !important;
}
.modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
 /* text-align: left;
  vertical-align: middle;*/
}
</style>
<?php $duebalance = 0; 
$this->load->library('stripe_core');
// echo "<pre>";
// print_r($duedate_invoice);

foreach($invoices as $key => $invoice){ 

    if($invoice['status'] == 1)
    {     
        $duebalance +=get_invoice_total_left_to_pay($invoice['id']);
    }
    if($invoice['status'] == 4)
    {     
        $duebalance +=get_invoice_total_left_to_pay($invoice['id']);
    }
    if($invoice['status'] == 3)
    {   
        $duebalance +=get_invoice_total_left_to_pay($invoice['id']);
    }

}
   $autocheck = "-"; 
   $autocheckColor = "#84c529";
if(!empty($client->stripe_id)){
  $subs = $this->stripe_core->get_subscriptions($client->stripe_id);
    if(isset($subs->data[0]) && $subs->data[0]->billing == "charge_automatically")
    {
        $autocheck = _l('autopay_on');
        $autocheckColor = "#84c529";
    }
    elseif(isset($subs->data[0]) && $subs->data[0]->billing == "send_invoice")
    {
        $autocheck = _l('autopay_off');
        $autocheckColor = "#ff2d42";
    }
}


?>
<div class="panel_s section-heading section-invoices">
    <div class="panel-body">
        <div class="row" style="vertical-align: middle;">
            <div class="col-md-1"></div>

            <div class="col-md-2 list-status text-center">
                <a href="javascript:;" class="active">
                    <h5 class="bold ticket-status-heading"><?php echo _l('client_invoice_due_balance'); ?></h5>
                    <span style="color:<?php if($duebalance == 0){ echo '#84c529'; } else { echo '#ff2d42'; } ?>"><?php if($duebalance == 0){ echo "$0.00"; }else{ echo format_money($duebalance, $invoice['symbol']);  } ?></span>
                </a>
            </div>

            <div class="col-md-2 list-status text-center">
                <a href="javascript:;" class="active">
                    <h5 class="bold ticket-status-heading"><?php echo _l('client_invoice_due_date'); ?></h5>
                    <span style="

                    <?php
                        if(isset($duedate_invoice) && !empty($duedate_invoice))
                        {
                            $invoiceDate =  _d($duedate_invoice->duedate);
                            $current_date = date("m/d/Y");

                            if($invoiceDate >= $current_date)
                            {
                                echo 'color:#84c529';
                            }
                            else
                            {
                                echo 'color:#ff2d42';
                            }
                        }
                        else
                        {
                            echo 'color:#84c529';
                        }
                    ?>
                    ">

                   
                <?php  
                    if(isset($duedate_invoice) && !empty($duedate_invoice)) 
                    {
        
                        echo _d($duedate_invoice->duedate);

                    }
                    else
                    {
                         echo "-";
                    } 
                    ?> 
                </span>
                </a>
            </div>

            <div class="col-md-2 list-status text-center">
                <a href="javascript:;" class="active" onclick="return false;" data-toggle="modal" data-target="#invlice_model">
                    <h5 class="bold ticket-status-heading"><?php echo _l('client_invoice_auto_pay'); ?></h5>
                    <span style="color:<?php echo $autocheckColor; ?>"><?php echo $autocheck; ?> </span>
                </a>
            </div>

            


            <div class="col-md-2 list-status text-center">
                <a href="<?php echo site_url('clients/statement'); ?>" class="active">
                    <h5 class="bold ticket-status-heading"><?php echo _l('client_invoice_payment'); ?> </h5>
                    <h5 class="bold ticket-status-heading nomargin">
                        <?php echo _l('client_invoice_history'); ?>
                    </h5>
                </a>
            </div>

           
            <?php if(!empty($client->stripe_id)){ 
                $managelink = site_url('clients/payments_manage');
                $tool = "";
            }else{

                $managelink = "javascript:;";
                $tool = "You have no card !";
                
             } ?>
            <div class="col-md-2 list-status text-center" data-toggle="tooltip" title="<?php echo $tool; ?>">
                <a href="<?php echo $managelink; ?>" class="active">
                    <h5 class="bold ticket-status-heading"><?php echo _l('manage_payment'); ?></h5>
                    <h5 class="bold ticket-status-heading nomargin"><?php echo _l('client_invoice_method'); ?></h5>
                </a>
            </div>

             <div class="col-md-1"></div>
                
               
               
              </div>
    </div>
</div>
<div class="panel_s">
 <div class="panel-body">
     <?php get_template_part('invoices_stats'); ?>
     <hr />
     <table class="table dt-table table-invoices" data-order-col="1" data-order-type="desc">
         <thead>
            <tr>
                <th class="th-invoice-number"><?php echo _l('clients_invoice_dt_number'); ?></th>
                <th class="th-invoice-date"><?php echo _l('clients_invoice_dt_date'); ?></th>
                <th class="th-invoice-duedate"><?php echo _l('clients_invoice_dt_duedate'); ?></th>
                <th class="th-invoice-amount"><?php echo _l('clients_invoice_dt_amount'); ?></th>
                <th class="th-invoice-status"><?php echo _l('clients_invoice_dt_status'); ?></th>
                <?php
                $custom_fields = get_custom_fields('invoice',array('show_on_client_portal'=>1));
                foreach($custom_fields as $field){ ?>
                    <th><?php echo $field['name']; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($invoices as $invoice){ 
            
              
                ?>
                <tr>
                    <td data-order="<?php echo $invoice['number']; ?>"><a href="<?php echo site_url('invoice/' . $invoice['id'] . '/' . $invoice['hash']); ?>" class="invoice-number"><?php echo format_invoice_number($invoice['id']); ?></a>
                        <?php
                          $recurringLinkedStatus = getLinkedInvoiceStatus($invoice['is_recurring_from']);
                          if(!empty($recurringLinkedStatus->recurring))
                          {
                            echo '<br /><span class="label label-primary inline-block mtop4"> ' . _l('invoice_recurring_indicator') . '</span>';
                            }
                            elseif(!empty($invoice['recurring']))
                            {
                                 echo '<br /><span class="label label-primary inline-block mtop4"> ' . _l('invoice_recurring_indicator') . '</span>';
                            }

                         ?>
                    </td>
                    <td data-order="<?php echo $invoice['date']; ?>"><?php echo _d($invoice['date']); ?></td>
                    <td data-order="<?php echo $invoice['duedate']; ?>"><?php echo _d($invoice['duedate']); ?></td>
                    <td data-order="<?php echo $invoice['total']; ?>"><?php echo format_money($invoice['total'], $invoice['symbol']);; ?></td>
                    <td><?php echo format_invoice_status($invoice['status'], 'inline-block', true); ?></td>
                    <?php foreach($custom_fields as $field){ ?>
                        <td><?php echo get_custom_field_value($invoice['id'],$field['id'],'invoice'); ?></td>
                    <?php } ?>
                </tr>
               

            <?php } ?>

        </tbody>
    </table>
</div>
</div>  




<div class="modal likes_modal fade" id="invlice_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div id="" class="text-center">
                        <?php 
                        // $data['stripe_customer'] = "";
                        // $language = load_client_language($client->userid);
                        // $data['locale'] = get_locale_key($language);
                        // if(!empty($client->stripe_id)){
                
                        //     $data['stripe_customer'] = $this->stripe_core->get_customer_with_default_source($client->stripe_id);
                           

                        // }
                         ?>
                        <?php //echo payment_gateway_head(_l('payment_for_invoice')); ?>
                        <form method="POST" action="<?php echo site_url('gateways/stripe/subscription/'.$client->userid); ?>">
                            <div class="">
                                <div class="col-md-8 col-md-offset-2">
                                 
                                    <div class="row ">
                                            <div class="row mbot30">
                                                <div class="col-md-7">
                                                    <h4>

                                                        <?php if($autocheck == "ON"){ $title =  _l('client_invoice_deactivate_autopay');}else{
                                                            $title =  _l('client_invoice_activate_autopay');
                                                        } 
                                                        echo _l('client_invoice_auto_pay');
                                                        ?></h4>
                                                </div>
                                                <div class="col-md-5" style="padding: 9px 0px 0px 20px;">
                                                    <div class="onoffswitch" data-toggle="tooltip" data-title="Auto Pay"  title="" aria-describedby="">
                                                        <input type="checkbox" data-switch-url="" name="autopay" class="onoffswitch-checkbox" id="1" data-id="1" <?php if($autocheck == "ON"){ echo "checked";}else{} ?>>
                                                        <label class="onoffswitch-label" for="1"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                           // if($autocheck == "ON"){
                                                ?>
                                               <!--  <button class="btn btn-danger" type="submit">Deactivate Auto Pay</button>  -->
                                                <?php
                                           // }else{
                                             ?>
                                                <button class="btn btn-info" type="submit">Save</button> 
                                                <?php
                                          //  } ?>
                                           
                                        </div>

                                    </div>

                                </div>

                            </form>
                                <?php echo payment_gateway_footer(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>