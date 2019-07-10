
    <?php
    $path =  base_url().'assets/images/tcpdf_logo.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $items = get_items_table_data($invoice, 'invoice', 'pdf');

    ?>
        <style type="text/css">

        .wd100{
            width: 100%;
        }
        .wd50{
            width: 50%;
        }
        .wd30{
            width: 30%;
        }

        .wd70{
            width: 70%;
        }

        .inline {
            display: inline-flex;
            vertical-align: middle;
        }
        
        .eleRight {
            text-align: right;
        }

        .eleleft{
            text-align: left;
        }
        .eleCenter{
            text-align: center;
        }
        .img-sz{
            width: 100px;
            height: 100px;
        }
        .note-box{
            border: 1px solid;
        }

        .sumtable td{
            border-bottom: 1px solid; 
        }
        .invoice-total{
            background-color: #03a9f4;
            color: #fff;
        }

        .invoice-items-preview{
            width: 100%;
        }
        


        .color1{
            background-color: #03a9f4;
            color: #fff;
        }
        .color2{
            color: black;
            background-color: lightgrey;
        }

        
        
        section#header {
            margin: 30px 0px 30px 0px;
            vertical-align: middle;
            min-height: 155px;
            height: 155px;
        }
        section#client-info{
            background-color: lightgrey;
            padding: 50px 35px 0px 35px;
            min-height: 155px;
            height: 155px;
        }

        section#invoice-info{

        }


        section#footer{
            margin-top: 20px;
        }


        .invoice-detail-table thead th{
            border: 1px solid;
        }
        .invoice-detail-table  td{
            border-bottom: 1px solid;
        }
        section#invoice-detail{

            margin-top: 25px;
        }

        section#invoice-total{
            margin-top: 25px;
        }





table{
    width: 100%;
    color: grey;
    border-spacing: 0px;
        
}
table th{
    padding: 12px;
}
table td{
     padding: 12px;
}






        </style>

<?php // echo "<pre>"; print_r($invoice); ?>
<body>

<!--  ***************************************************************************************************************
                                                HEADER SECTION START
    *************************************************************************************************************** -->

    <section id="header">
        <div class="inline">
            <div class=""> <img class="img-sz" src="<?php echo $base64; ?>"> </div>
            <div class="eleRight">
                <h3 class=""><span style="font-weight:bold;font-size:27px;"> <?php echo _l('invoice_pdf_heading'); ?></span><br /></h3>
                <p class=""><?php $date=date_create($invoice->date); echo date_format($date,"m/d/Y"); ?></p>
            </div>
        </div>
    </section>

    <!--  ***************************************************************************************************************
                                                HEADER SECTION END
    *************************************************************************************************************** -->




    <!--  ***************************************************************************************************************
                                               CLIENT INFO START
    *************************************************************************************************************** -->


    <section id="client-info">

        <div class="inline" style="padding-top: 30px;">

            <div class="eleleft">
                <h4>
                    <?php echo format_customer_info($invoice, 'invoice', 'billing'); ?>

                </h4>
            </div>

            <div class="eleRight">
              <h4>Invoice : <?php echo format_invoice_number($invoice->id); ?><br>
                Account No : <?php echo $invoice->client->account_number; ?><br>
                Due Date : <?php $date=date_create($invoice->duedate); echo date_format($date,"m/d/Y"); ?></h4>
            </div>    


        </div>
    </section>



    <!--  ***************************************************************************************************************
                                               CLIENT INFO END
    *************************************************************************************************************** -->





    <!--  ***************************************************************************************************************
                                               INVOICE INFO START
    *************************************************************************************************************** -->

    <section id="invoice-info">

        <table>
            <thead>
            <tr>
            <th style="border: 1px solid #aaa">Description</th>
            <th style="border: 1px solid #aaa"class="align">QTY</th>
            <th style="border: 1px solid #aaa"class="align">Rate</th>
            <th style="border: 1px solid #aaa"class="align">Amount</th>

            </tr>
            </thead>

            <tbody>
                <?php foreach ($invoice->items as $key => $value) { ?>
            
               
            <tr class="borderbelow">
                <td><?php echo $value['description']; ?></td>
                <td class="align"><?php echo $value['qty']; ?></td>
                <td class="align"><?php echo format_money($value['rate'],$invoice->symbol); ?></td>
                <td class="align"><?php echo format_money($value['rate'],$invoice->symbol); ?></td>
            </tr>
            <?php } ?>
            </tbody>
           
        </table>

    </section>


    <!--  ***************************************************************************************************************
                                               INVOICE INFO END
    *************************************************************************************************************** -->


    <!--  ***************************************************************************************************************
                                               FOOTER START
    *************************************************************************************************************** -->

    <section id="footer">

        <div class="inline" >



        <div class="sumtable">
            <table class="table1">

                <tr>
                    <th rowspan="4" style="border: 1px solid; margin-right: 12px;" width="400px;">
                         <p></p>
                    </th>
                    <td>Total</td>
                    <td><?php echo format_money($invoice->subtotal, $invoice->symbol); ?></td>
                </tr>
                <tr>
                    <td>Sales Tax(7.75%)</td>
                    <td>$10:00</td>
                </tr>
                <tr>
                    <td>Payments/Credits</td>
                    <td>-$20:00</td>
                </tr>
                <tr>
                    <td class="color2">Balanced Due</td>
                    <td class="color1"> <?php echo format_money($invoice->total_left_to_pay,$invoice->symbol); ?></td>
                </tr>

            </table>
        </div>
    </div>


    </section>

    <!--  ***************************************************************************************************************
                                               FOOTER START
    *************************************************************************************************************** -->
</body>