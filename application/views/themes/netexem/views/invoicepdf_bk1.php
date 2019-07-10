<html><head>
    <title>Invoice</title>
    
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="content-type" content="text-html; charset=utf-8">
    <style type="text/css">
        html, body, div, span, applet, object, iframe, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font: inherit;
            font-size: 100%;
            vertical-align: baseline;
        }

        html {
            line-height: 1;
        }

        ol, ul {
            list-style: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        caption, th, td {
            text-align: left;
            font-weight: normal;
            vertical-align: middle;
        }

        q, blockquote {
            quotes: none;
        }
        q:before, q:after, blockquote:before, blockquote:after {
            content: "";
            content: none;
        }

        a img {
            border: none;
        }

        article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
            display: block;
        }

        body {
            font-family: 'Source Sans Pro', sans-serif;
            font-weight: 300;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        body a {
            text-decoration: none;
            color: inherit;
        }
        body a:hover {
            color: inherit;
            opacity: 0.7;
        }
        body .container {
            min-width: 500px;
            margin: 0 auto;
            padding: 0 20px;
        }
        body .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        body .left {
            float: left;
        }
        body .right {
            float: right;
        }
        body .helper {
            display: inline-block;
            height: 100%;
            vertical-align: middle;
        }
        body .no-break {
            page-break-inside: avoid;
        }

        header {
            margin-top: 20px;
            margin-bottom: 50px;
        }
        header figure {
            float: left;
            width: 60px;
            height: 60px;
            margin-right: 10px;
            border-radius: 50%;
            text-align: center;
        }
        header figure img {
            margin-top: 13px;
        }
        header .company-address {
            float: left;
            max-width: 150px;
            line-height: 1.7em;
        }
        header .company-address .title {
            font-weight: 400;
            font-size: 1.5em;
            text-transform: uppercase;
        }
        header .company-contact {
            float: right;
            height: 60px;
            padding: 0 10px;
            color: Black;
        }
        header .company-contact span {
            display: inline-block;
            vertical-align: middle;
        }
        header .company-contact .circle {
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 50%;
            text-align: center;
        }
        header .company-contact .circle img {
            vertical-align: middle;
        }
        header .company-contact .phone {
            height: 100%;
            margin-right: 20px;
        }
        header .company-contact .email {
            height: 100%;
            min-width: 100px;
            text-align: right;
        }

        section .details {
            margin-bottom: 55px;
        }
        section .details .client {
            width: 50%;
            line-height: 20px;
        }
        section .details .client .name {
           
        }
        section .details .data {
            width: 50%;
            text-align: right;
        }
        section .details .title {
            margin-bottom: 15px;
            color: black;
            font-size: 2em;
            font-weight: 800;
            text-transform: uppercase;
        }
        section table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 0.9166em;

        }
        section table .qty, section table .unit, section table .total {
            width: 15%;
        }
        section table .desc {
            width: 55%;
        }
        section table thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
            border-spacing: 0px;
        }
        section table thead th {
            padding: 5px 10px;

            border-bottom: 5px solid #FFFFFF;
            border-right: 4px solid #FFFFFF;
            text-align: right;
            color: black;
            font-weight: 400;
            text-transform: uppercase;
        }
        section table thead th:last-child {
            border-right: none;
        }
        section table thead .desc {
            text-align: left;
        }
        section table thead .qty {
            text-align: center;
        }
        section table tbody td {
            padding: 10px;
            color: black;
            text-align: right;

          }
        section table tbody td:last-child {
            border-right: none;
        }
        section table tbody h3 {
            margin-bottom: 5px;
            font-weight: 600;
        }
        section table tbody .desc {
            text-align: left;
        }
        section table tbody .qty {
            text-align: center;
        }
        section table.grand-total {
            margin-bottom: 45px;
        }
        section table.grand-total td {
            padding: 5px 10px;
            border: none;
            color: black;
            text-align: right;
        }
        section table.grand-total .desc {
            background-color: transparent;
        }


        .color1{
            background-color: #03a9f4;
            color: #fff;
        }
        .logo{
            width: 260px;
            height: 75px;
        }
        .color2{
            color: black;
            background-color: lightgrey;
        }

   
.grand-total td{
     padding: 20px;
}
    </style>
      <?php
    $path =  base_url().'assets/images/NETEXEM.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $items = get_items_table_data($invoice, 'invoice', 'pdf');

    ?>
</head><body>
    <header class="clearfix" style="margin-top: 100px;">
        <div class="container">
            <img class="logo" src="<?php echo $base64; ?>" alt="">
            
            <div class="company-contact">
                <div class="phone left" style="text-align: left;">
    
                    <h2 style="font-weight: 800; font-size: 17px;"><?php echo _l('invoice_pdf_heading'); ?></h2><br>
                    <a><?php $date=date_create($invoice->date); echo date_format($date,"m/d/Y"); ?></a>
                </div>
            </div>
        </div>
    </header>

    <section>
        <div class="container">

            <div class="details clearfix" style="margin-top: 150px; background-color: lightgrey; padding: 45px 25px 45px 25px;">
                <div class="client left">
                    <p class="title">Bill to:</p>
                    <p><?php echo format_customer_info($invoice, 'invoice', 'billing'); ?></p>
                </div>
                <div class="data right">
                    <div class="date">
                        <a style="font-weight: 700;">Invoice No </a> : <?php echo format_invoice_number($invoice->id); ?><br>
                        <a style="font-weight: 700;">Account No </a> : <?php echo $invoice->client->account_number; ?><br>
                        <a style="font-weight: 700;">Due Date </a>: <?php $date=date_create($invoice->duedate); echo date_format($date,"m/d/Y"); ?>
                    </div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="border: 1px solid" class="desc">Description</th>
                        <th style="border: 1px solid" class="qty">Qty</th>
                        <th style="border: 1px solid" class="unit">Rate</th>
                        <th style="border: 1px solid" class="total">Amount</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($invoice->items as $key => $value) { ?>
                    <tr>
                        <td class="desc"><?php echo $value['description']; ?></td>
                        <td class="qty"><?php echo $value['qty']; ?></td>
                        <td class="unit"><?php echo format_money($value['rate'],$invoice->symbol); ?></td>
                        <td class="total"><?php echo format_money($value['rate'],$invoice->symbol); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <hr>
            <div class="no-break">
                <table class="grand-total">
                    <tbody>
                        <tr>
                     
                            <td class="desc left"><?php if(!empty($invoice->adminnote)){ echo"Admin Note:";} ?><?php if(!empty($invoice->adminnote)){ echo "<p>".$invoice->clientnote."</p>";} ?><?php if(!empty($invoice->clientnote)){ echo"Client Note:";} ?><?php if(!empty($invoice->clientnote)){ echo "<p>".$invoice->clientnote."</p>";} ?></td>
                            <td class="qty"></td>
                            <td class="unit" style="text-align: left; padding: 12px; border-bottom: 1px solid;">Total</td>
                            <td class="total" style="border-bottom: 1px solid; padding: 12px;"><?php echo format_money($invoice->subtotal, $invoice->symbol); ?></td>
                        </tr>

        

                        <?php if(!empty($items->taxes())){ ?>
                        <tr>
                            <td class="desc"></td>
                            <td class="qty"></td>
                            <?php
                                foreach ($items->taxes() as $tax) { ?>
                                <td class="unit" style="text-align: left; border-bottom: 1px solid;padding: 12px;"><?php echo $tax['taxname'] . '(' . app_format_number($tax['taxrate']) . '%)'; ?></td>
                                <td class="total" style="border-bottom: 1px solid;padding: 12px;"><?php echo format_money($tax['total_tax'], $invoice->symbol); ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>



                        <?php 
                            $credits_applied = total_credits_applied_to_invoice($invoice->id);
                            if(!empty($credits_applied)){
                        ?>
                         <tr>
                            <td class="desc"></td>
                            <td class="qty"></td>
                            <td class="unit" style="text-align: left; border-bottom: 1px solid;padding: 12px;"><?php echo _l('applied_credits'); ?></td>
                            <td class="total" style="border-bottom: 1px solid;padding: 12px;"><?php echo "-".format_money($credits_applied, $invoice->symbol); ?></td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td class="desc"></td>
                            <td class="qty"></td>
                            <td class="unit color2" style="text-align: left; padding: 12px;">Balanced Due</td>
                            <td class="total color1" style="padding: 12px;"><?php echo format_money($invoice->total_left_to_pay,$invoice->symbol); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</body></html>
