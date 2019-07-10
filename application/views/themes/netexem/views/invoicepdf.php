<html lang="en">
  <style>

    body {
      background: white; 
     font-family: Arial, Helvetica, sans-serif; 
     margin:0; }
     @page {
   size: 216mm 279mm;
   margin-bottom: 0px;
}
  </style>
  <?php
    $path =  base_url().'assets/images/Logo.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $items = get_items_table_data($invoice, 'invoice', 'pdf');
    $inv_date = $this->invoices_model->getInvoicePayDate($invoice->id);
  ?>
  <body translate="no" style='margin:0;'>
    <table align="center" border="0" style="border: none; font-size: 10px;  margin-top: 30px;" width="100%">
      <tr style="border: none">
          <td style="border: none">

            <table style="border:none; font-size: 14px;margin-bottom:56px;margin-top: -33px; margin-left: -9px;" width="30%">
              <tr style="border: none">
                <td style="text-align:left; border: none; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                  <p><img src="<?php echo $base64; ?>" style="padding-left: 20px;width: 170px;height: auto;"></p>
                  <p style="margin:0;padding-left: 20px; width: 200px; margin-top: -3px;" >8583 Irvine Center Drive #363,  </p>
                  <p style="margin:0; padding-left: 20px;" >Irvine, CA 92618 </p>
                </td>
              </tr>
            </table>

            <table style="display: none; width: 30%;"></table>

        

            <table border="1" cellpadding="6" style=' border: 0; width:40%;border-spacing: 0px;float:right; font-size: 32px; color: #0673BA; text-align: right; font-family: Arial, Helvetica, sans-serif; border-radius: 25px; margin-top: -98px; padding-right: 30px;'>
                 <p style='font-family: Arial, Helvetica, sans-serif;font-size: 32px; color: #0673BA; margin-right: 30px; margin-top: -140px; text-align: right;'>
              <strong>Invoice</strong>
            </p>
              <tr style="border-top-left-radius: 10px important;border-top-right-radius: 10px !important; overflow: hidden;">
                <td bgcolor="#0673BA" style="overflow: hidden; font-size: 14px; text-align: center; color: #FFFFFF; font-weight: bold;border-style: solid; border-width: 2px 0px 2px 2px !important;border-color: #0000ff;border-top-left-radius: 10px;border-color: #0000ff;border-spacing: 0;">Date</td>
                <td bgcolor="#0673BA" style="overflow: hidden; font-size: 14px; text-align: center; color: #FFFFFF;font-weight: bold;border-style: solid; border-width: 2px 2px 2px 2px !important;border-color: #0000ff;border-top-right-radius: 10px;border-color: #0000ff; border-spacing: 0;">Invoice # </td>
              </tr>

              <tr>
                <td style="font-size: 14px;text-align: center;color: black;border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;border-bottom-left-radius: 10px;border-color: #0000ff;border-spacing: 0; "><?php echo _d($invoice->date); ?></td>
                <td style="font-size: 14px;text-align: center;color: black;border-style: solid; border-width: 0px 2px 2px 2px !important;border-color: #0000ff;border-bottom-right-radius: 10px;border-color: #0000ff;border-spacing: 0;"><?php echo format_invoice_number($invoice->id); ?></td>
              </tr>
            </table>
                  

            <table border="1" align="left" cellpadding="2" style='border: 0; border-spacing: 0px;float:left;margin-bottom:56px;text-align:left;margin-left:40px;width: 35%; margin-top: 8px;' >
              <tr style="border-top-left-radius: 10px important;border-top-right-radius: 10px !important; overflow: hidden;">
                <td bgcolor="#0673BA" style="border-style: solid; border-width: 2px 2px 2px 2px !important;border-color: #0000ff;border-top-left-radius: 10px;border-top-right-radius: 10px;font-family: Arial, Helvetica, sans-serif; border-color: #0000ff;border-spacing: 0; font-size: 15px; color: #FFFFFF;padding: 4px 9px;">Bill To </td>
              </tr>
              <?php
                  $companyName = "";
                  $companyName.= "<p style='margin:0 5px;font-family: Arial, Helvetica, sans-serif; '>".$invoice->client->company."</p>";


                  $address = "";
                  if(!empty($invoice->billing_street))
                  {
                    $address.= "<p style='margin:0 5px;font-family: Arial, Helvetica, sans-serif; '>".$invoice->billing_street.",</p>";
                  }
                  if(!empty($invoice->billing_city))
                  {
                    $address.= "<p style='margin:0 5px;font-family: Arial, Helvetica, sans-serif; '>".$invoice->billing_city.", ";
                  }
                  if(!empty($invoice->billing_state))
                  {
                    $address.= $invoice->billing_state." ";
                  }
                  if(!empty($invoice->billing_zip))
                  {
                    $address.= $invoice->billing_zip."</p>";
                  }
                ?>
              <tr>
                <td style="font-size: 14px;border-style: solid; border-width: 0px 2px 2px 2px !important;border-color: #0000ff; border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;font-family: Arial, Helvetica, sans-serif; font-weight:normal;border-spacing: 0; ">
                  <?php echo $companyName; ?>
                  <?php echo $address; ?>
                </td>
              </tr>
            </table>

            <?php
            $display = "display: none;";
            if(isset($payment)){ 
              $display = "display: table;"; 
              $inv_paid_date = $invoice->date;
            } 
            ?>
       

             <table style=" <?php echo $display; ?> float: right; margin-right: 230px;     transform: rotate(318deg); ">
               <tbody><tr><td>  
                <div style="text-align: center;">
                <h1 style="color: red; font-weight: bold;">PAID </h1> <h1  style="color: red; font-weight: bold;"><?php echo _d($inv_paid_date); ?></h1>
              </div>
                   </td></tr>
            </tbody></table>
        
            <table style='border: 0; border-spacing: 0px; margin-top: 130px;' align="center" width="100%">
              <tr>
                <th style='text-align:center;font-size:42px;color:black;font-weight:bold; font-family: sans-serif;'></th>
              </tr>

              <tr>
                <td style='overflow: hidden; text-align:center;color:black;font-weight:200;font-size: 36px;word-break: break-word; height: 400px;'>
                  <table height="400px" border="1" align="center" cellpadding="5" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center;  color: black; border: 0; max-height: 400px; min-height: 400px; margin-top: 10px; border-spacing: 0px;">
                    <tr style="border-top-left-radius: 10px important;border-top-right-radius: 10px !important; overflow: hidden;">
                      <td bgcolor="#0673BA" style="overflow: hidden; font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: #FFFFFF;border-style: solid; border-width: 2px 0px 1px 2px;border-top-left-radius: 10px;font-weight: bold;border-color: #0000ff;width:207px;
                         border-spacing: 0">Account No </td>
                      <td  bgcolor="#0673BA" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: #FFFFFF;border-style: solid;border-width: 2px 0px 1px 2px;border-color: #0000ff;width:138px;font-weight: bold;border-spacing: 0">Due Date </td>

                      <td colspan="2" bgcolor="#0673BA" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: #FFFFFF;border-style: solid;border-width: 2px 0px 1px 2px;border-color: #0000ff;font-weight: bold;border-spacing: 0">Project</td>
                      
                      <td colspan="2" bgcolor="#0673BA" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: #FFFFFF;border-style: solid;border-width: 2px 2px 1px 2px;border-top-right-radius: 10px;border-color: #0000ff;font-weight: bold;border-spacing: 0">Terms</td>
                    </tr>

                    <tr>
                      
                      <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: black;border-style: solid;border-width: 1px 0px 1px 2px;border-color: #0000ff;border-spacing: 0;"><?php echo $invoice->client->account_number; ?></td>
                      <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: black;border-style: solid;border-width: 1px 0px 1px 2px;border-color: #0000ff;border-spacing: 0;"><?php echo _d($invoice->duedate); ?></td>
                      <td colspan="2" style='border-style: solid;border-width: 1px 0px 1px 2px;border-color: #0000ff;border-spacing: 0;'>&nbsp;</td>
                      <td colspan="2" style='border-style: solid;border-width: 1px 2px 1px 2px;border-color: #0000ff;border-spacing: 0;'>&nbsp;</td>

                    </tr>

                    <tr>
                      <td colspan="3" bgcolor="#0673BA" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: #FFFFFF;border-style: solid;border-width: 1px 0px 1px 2px;border-color: #0000ff;font-weight: bold;border-spacing: 0;">Description</td>
                      <td bgcolor="#0673BA" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: #FFFFFF;border-style: solid;border-width: 1px 0px 1px 2px;border-color: #0000ff;  width: 52px;font-weight: bold;border-spacing: 0;">Qty</td>
                      <td bgcolor="#0673BA" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: #FFFFFF;border-style: solid;border-width: 1px 0px 1px 2px;border-color: #0000ff;width: 70px;font-weight: bold;border-spacing: 0;">Rate</td>
                      <td bgcolor="#0673BA"style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:center; color: #FFFFFF;border-style: solid; border-width: 1px 2px 1px 2px; border-color: #0000ff;  width: 106px;font-weight: bold;border-spacing: 0;">Amount</td>
                    </tr>

  

                    
                      <?php 

        end($invoice->items);         
        $last_item_key = key($invoice->items);  
        reset($invoice->items);
          $first_key = key($invoice->items);
                      foreach ($invoice->items as $key => $value) {  

                       if ($key == $first_key && $key != $last_item_key) {
                          ?>

                                            <tr >

                      <td colspan="3"style="vertical-align: top; padding:12px 5px 15px 5px;font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:left;border-style: solid;border-width:1px 0px 0px 2px !important;border-color: #0000ff;border-spacing: 0;">
                        <p style='margin: 0 5px;'><?php echo $value['description']; ?></p>
                        <p style='margin: 0 5px;'><?php echo $value['long_description']; ?></p>
                      </td>
                      <td style='vertical-align: top; border-style: solid; border-width: 1px 0px 0px 2px !important;border-color: #0000ff;'><?php echo $value['qty']; ?></td>
                      <td style='vertical-align: top; text-align:right;border-style: solid; border-width: 1px 0px 0px 2px !important;border-color: #0000ff;'><?php echo format_money($value['rate'],$invoice->symbol); ?>  </td>
                      <td style=' vertical-align: top; text-align:right;border-style: solid; border-width: 1px 2px 0px 2px !important;border-color: #0000ff;'><?php echo format_money($value['rate'],$invoice->symbol); ?> </td>
</tr>





                          <?php
                        }elseif ($key == $last_item_key) {

                          $height= "";

                          if ($last_item_key == $first_key) {
                            
                            $height = "height:270px;";
                          }

                         ?>

                         <tr >

                      <td colspan="3"style="<?=$height?> vertical-align: top; padding:12px 5px 15px 5px;font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:left;border-style: solid;border-width:0px 0px 2px 2px !important;border-bottom-left-radius:10px;border-color: #0000ff;border-spacing: 0;">
                        <p style='margin: 0 5px;'><?php echo $value['description']; ?></p>
                        <p style='margin: 0 5px;'><?php echo $value['long_description']; ?></p>
                      </td>
                      <td style='vertical-align: top; border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;'><?php echo $value['qty']; ?></td>
                      <td style='vertical-align: top; text-align:right;border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;'><?php echo format_money($value['rate'],$invoice->symbol); ?>  </td>
                      <td style=' vertical-align: top; text-align:right;border-style: solid; border-width: 0px 2px 2px 2px !important;border-color: #0000ff;'><?php echo format_money($value['rate'],$invoice->symbol); ?> </td>
</tr>

                         <?php
                       }else{
                        ?>

                        <tr >

                      <td colspan="3"style="vertical-align: top; padding:12px 5px 15px 5px;font-family: Arial, Helvetica, sans-serif; font-size: 14px;text-align:left;border-style: solid;border-width:0px 0px 0px 2px !important;border-color: #0000ff;border-spacing: 0;">
                        <p style='margin: 0 5px;'><?php echo $value['description']; ?></p>
                        <p style='margin: 0 5px;'><?php echo $value['long_description']; ?></p>
                      </td>
                      <td style='vertical-align: top; border-style: solid; border-width: 0px 0px 0px 2px !important;border-color: #0000ff;'><?php echo $value['qty']; ?></td>
                      <td style='vertical-align: top; text-align:right;border-style: solid; border-width: 0px 0px 0px 2px !important;border-color: #0000ff;'><?php echo format_money($value['rate'],$invoice->symbol); ?>  </td>
                      <td style=' vertical-align: top; text-align:right;border-style: solid; border-width: 0px 2px 0px 2px !important;border-color: #0000ff;'><?php echo format_money($value['rate'],$invoice->symbol); ?> </td>
</tr>

                        <?php
                       }
                        ?>

                    <?php } ?>
                    

                    <tr>
                      <td colspan="3" rowspan="4" style="font-family: Arial, Helvetica, sans-serif;font-size: 12px;text-align:left;color: #FF631F;font-weight: 700;border:0;padding-top:12px;padding-right: 30px;" >
                        <?php if(isset($notice)){ ?>
                        <p style="color: red"><?=$notice?></p>
                        <?php } ?>
                       <!--  This is a friendly payment reminder, as your account with us now appears  as past due.We&rsquo;d like to bring the following invoice(s) to your immediate  attention: Payment options: our website (link) or PayPal (link) <br> -->
                      <!-- <?php if(!empty($invoice->adminnote)){ echo"<p> Admin Note:";} ?><?php if(!empty($invoice->adminnote)){ echo $invoice->adminnote."</p>";} ?><?php if(!empty($invoice->clientnote)){ echo"<p> Client Note:";} ?><?php if(!empty($invoice->clientnote)){ echo $invoice->clientnote."</p>";} ?> -->

                      </td>
                      <td colspan="2" style='text-align:left;color:blue;padding:0px 0 0px 25px;border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;font-weight:600;'> Total</td>
                      <td style='text-align:right;border-style: solid; border-width: 0px 2px 2px 0px !important;border-color: #0000ff;'> <?php echo format_money($invoice->subtotal, $invoice->symbol); ?> </td>
                    </tr>

                    <?php if(!empty($items->taxes())){
                            foreach ($items->taxes() as $tax) { ?>

                    <tr>
                      <td colspan="2"style='text-align:left;color:blue;padding:0px 0 0px 25px;border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;font-weight:600;'><?php echo $tax['taxname'] . '(' . app_format_number($tax['taxrate']) . '%)'; ?></td>
                      <td style='text-align:right;border-style: solid; border-width: 0px 2px 2px 0px !important;border-color: #0000ff;'><?php echo format_money($tax['total_tax'], $invoice->symbol); ?> </td>
                    </tr>
                     <?php } ?>
                  <?php }else{ ?>

                  <tr>
                      <td colspan="2"style='text-align:left;color:blue;padding:0px 0 0px 25px;border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;font-weight:600;'>Sales Tax</td>
                      <td style='text-align:right;border-style: solid; border-width: 0px 2px 2px 0px !important;border-color: #0000ff;'>$0.00 </td>
                    </tr>

                  <?php } ?>


                  <?php 
                            $credits_applied = total_credits_applied_to_invoice($invoice->id);
                            if(!empty($credits_applied)){
                        ?>

                    <tr>
                      <td colspan="2"style='text-align:left;color:blue;padding:0px 0 0px 25px;border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;font-weight:600;'>Payments/Credits </td>
                      <td style='text-align:right;border-style: solid; border-width: 0px 2px 2px 0px !important;border-color: #0000ff;'><?php echo "-".format_money($credits_applied, $invoice->symbol); ?></td>
                    </tr>

                  <?php }else{ ?>
                    <tr>
                      <td colspan="2"style='text-align:left;color:blue;padding:0px 0 0px 25px;border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;font-weight:600;'>Payments/Credits </td>
                      <td style='text-align:right;border-style: solid; border-width: 0px 2px 2px 0px !important;border-color: #0000ff;'>-$0.00 </td>
                    </tr>
                  <?php } ?>
                    <tr>
                      <td colspan="2"style='text-align:left;color:blue;padding:0 0 0 25px;border-style: solid; border-width: 0px 0px 2px 2px !important;border-color: #0000ff;border-bottom-left-radius:10px;font-weight:600;'>Balance Due </td>
                      <td style='text-align:right;border-style: solid; border-width: 0px 2px 2px 0px !important;border-color: #0000ff;border-bottom-right-radius:10px;'><?php echo format_money($invoice->total_left_to_pay,$invoice->symbol); ?></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table style=" position: fixed; bottom: 70px; text-align: center;border: none;width: 91%; " align="center">
        <tr>
          <td style='text-align:center;font-size:20px;color:blue;font-weight:bold;padding-bottom: 7px;border-bottom:5px double #0D75BB;    '></td>
        </tr>
        <tr>
          <td style="border: none;width:100%;text-align:center;font-size:9pt;color:#636B7E;font-weight:700; font-family: sans-serif; padding-top: 4px;
                  padding-bottom: 5px;">8583 Irvine Center Drive #363, Irvine, CA 92618 | 844.638.3936</td>
        </tr>
      </table>
  </body></html>