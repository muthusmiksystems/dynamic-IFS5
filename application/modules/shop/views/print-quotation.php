<?php include APPPATH.'views/html/header.php'; ?>
    <style type="text/css">
        @media print{
            @page{
                margin: 1mm;
            }
            body {
                font-family: Verdana, Geneva, sans-serif;
                width: 72mm !important;
                height: 297mm !important;
                font-size: 14px !important;
            }
            .table
            {
                width: 100% !important;
            }
            .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td
            {
                /*border: 1px solid #403d3d !important;*/
                padding: 3px !important;
                line-height: normal !important;
                width: auto !important;
                word-wrap: break-word !important;
            }
      }
    </style>
	<section id="main-content">
		<section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Quotation
                        </header>
                        <?php
                        $othercharges_data = json_decode($quotation->othercharges_data, true);
                        $tax_data = json_decode($quotation->tax_data, true);

                        $box_list = array();
                        $quotation_items = $this->Sales_model->get_quotation_items($quotation->quotation_id);
                        if(sizeof($quotation_items) > 0)
                        {
                            foreach ($quotation_items as $item) {
                                $box_list[$item->item_id.$item->shade_id][] = $item;
                            }
                        }
                        /*echo "<pre>";
                        print_r($othercharges_data);
                        print_r($tax_data);
                        echo "</pre>";*/
                        ?>
                        <div class="panel-body" id="sh_quotation" style="width: 100%;">
                            <table class="table table-bordered quotation-table" style="width:100%;">
                                <thead>
                                    <tr class="hidden-print">
                                        <th width="10%"></th>
                                        <th width="20%"></th>
                                        <th width="20%"></th>
                                        <th width="10%"></th>
                                        <th width="20%"></th>
                                        <th width="20%"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" class="text-center hidden-print" align="center">
                                            QUOTATION
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" valign="top" style="vertical-align:top;">
                                            <strong>To:&emsp;<?php echo $quotation->name; ?></strong>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">
                                            QUOT NO: <?php echo $quotation->quotation_no; ?>
                                        </th>
                                        <th colspan="2" class="text-right" align="right">
                                            <?php echo date("d-m-Y", strtotime($quotation->quotation_date)); ?>
                                        </th>
                                    </tr>
                                    <!-- <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Shade</th>
                                        <th>Qty</th>
                                        <th>Uom</th>
                                        <th>Rate</th>
                                        <th class="text-right">Amount</th>
                                    </tr> -->
                                </thead>
                                <?php
                                $tot_boxes = 0;
                                $tot_amount = 0;
                                $sno = 1;
                                ?>
                                <tbody>
                                    <?php if(count($box_list) > 0): ?>
                                        <?php foreach($box_list as $key => $boxes): ?>
                                            <?php if(sizeof($boxes) > 0): ?>
                                                <?php
                                                $no_cones = 0;
                                                $gr_weight = 0;
                                                $delivery_qty = 0;
                                                ?>
                                                <?php foreach($boxes as $box): ?>
                                                    <?php
                                                    // $item_name  = $box->group_name.'<br>'.$box->item_name;
                                                    $item_name  = $box->item_name;
                                                    $shade_name  = $box->shade_name.'<br>'.$box->shade_code;
                                                    $shade_code  = $box->shade_code;
                                                    $item_rate  = $box->item_rate;
                                                    $uom_name  = $box->uom_name;
                                                    $lot_no  = $box->lot_no;
                                                    $no_cones += $box->no_cones;
                                                    $gr_weight += $box->gr_weight;
                                                    $delivery_qty += $box->delivery_qty;

                                                    $tot_boxes++;
                                                    ?>
                                                <?php endforeach; ?>
                                                <?php
                                                $item_amt = number_format($delivery_qty * $item_rate, 2, '.', '');
                                                $tot_amount += $item_amt;
                                                ?>
                                                <tr>
                                                    <td><?php echo $sno++; ?></td>
                                                    <td><?php echo $item_name; ?></td>
                                                    <td><?php echo $shade_name; ?></td>
                                                    <td><?php echo $delivery_qty; ?> <?php echo $uom_name; ?></td>
                                                    <td><?php echo $item_rate; ?></td>
                                                    <td align="right"><?php echo $item_amt; ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>                                
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td align="right"><strong>Total</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td align="right"><strong><?php echo number_format($tot_amount, 2, '.', ''); ?></strong></td>
                                    </tr>
                                    <?php
                                    $others = array();
                                    if(sizeof($othercharges_data) > 0)
                                    {
                                        foreach ($othercharges_data as $key => $data) {
                                            if($data['type'] == '-')
                                            {
                                                $deduction = 0.00;
                                                if($data['unit'] == '%')
                                                {
                                                    $deduction = ($tot_amount * $data['value']) / 100;
                                                }
                                                else
                                                {
                                                    $deduction = $data['value'];
                                                }
                                                if($deduction > 0)
                                                {
                                                	$deduction = number_format($deduction, 2, '.', '');
                                                }
                                                
                                                $othercharges_data[$key]['amount'] = $deduction;
                                                $tot_amount -= $deduction;
                                                $data['amount'] = $deduction;
                                                if($deduction > 0)
                                                {
                                                    $others[] = $data;                                                    
                                                }
                                            }
                                        }
                                    }

                                    $taxes = array();
                                    if(sizeof($tax_data) > 0)
                                    {
                                        foreach ($tax_data as $key => $data) {
                                            $tax = 0.00;
                                            $tax = ($tot_amount * $data['value']) / 100;
                                            $tax = number_format($tax, 2, '.', '');
                                            $tax_data[$key]['amount'] = $tax;
                                            $tot_amount += $tax;

                                            $data['amount'] = $tax;
                                            if($tax > 0)
                                            {
                                                $taxes[] = $data;                                                
                                            }
                                        }
                                    }

                                    if(sizeof($othercharges_data) > 0)
                                    {
                                        foreach ($othercharges_data as $key => $data) {
                                            if($data['type'] == '+')
                                            {
                                                $addition = 0.00;
                                                if($data['unit'] == '%')
                                                {
                                                    $addition = ($tot_amount * $data['value']) / 100;
                                                }
                                                else
                                                {
                                                    $addition = $data['value'];
                                                }
                                                if($addition > 0)
                                                {
                                                	$addition = number_format($addition, 2, '.', '');
                                                }
                                                
                                                $othercharges_data[$key]['amount'] = $addition;
                                                $tot_amount += $addition;
                                                $data['amount'] = $addition;
                                                if($addition > 0)
                                                {
                                                    $others[] = $data;                                                    
                                                }
                                            }
                                        }
                                    }
                                    $net_amount = round($tot_amount);
                                    $upate_inv['quotation_id'] = $quotation->quotation_id;
                                    $upate_inv['quotation_amt'] = $net_amount;
                                    $this->Sales_model->update_quotation_amt($upate_inv);
                                    ?>
                                    <?php
                                    $rowspan = 0;
                                    if(count($others) > 0)
                                    {
                                        foreach($others as $key => $data)
                                        {
                                            if($data['amount'] > 0)
                                            {
                                                $rowspan++;
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if(count($others) > 0): ?>
                                        <?php foreach($others as $key => $data): ?>
                                            <tr>
                                                <?php if($key == 0): ?>
                                                    <td colspan="3">
                                                        Rupees: 
                                                        <?php echo $this->Sales_model->amount_words($net_amount); ?>
                                                    </td>
                                                    <td align="right" colspan="2">
                                                        <strong><?php echo $data['names']; ?></strong>
                                                        <?php echo ($data['desc'] != '')?'('.$data['desc'].')':''; ?>
                                                    </td>
                                                    <td align="right"><strong><?php echo $data['amount']; ?></strong></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">
                                                Rupees: 
                                                <?php echo $this->Sales_model->amount_words($net_amount); ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php
                                    $rowspan = 0;
                                    if(count($taxes) > 0)
                                    {
                                        foreach($taxes as $key => $data)
                                        {
                                            if($data['amount'] > 0)
                                            {
                                                $rowspan++;
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if(count($taxes) > 0): ?>
                                        <?php foreach($taxes as $key => $data): ?>
                                            <tr>
                                                <?php if($key == 0): ?>
                                                    <td colspan="3">
                                                        Note: "Taxes as applicable."
                                                    </td>
                                                    <td align="right" colspan="2">
                                                        <strong><?php echo $data['name']; ?></strong>
                                                        <?php echo ($data['value'] != '')?'('.$data['value'].'%)':''; ?>
                                                    </td>
                                                    <td align="right"><strong><?php echo $data['amount']; ?></strong></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">
                                                Note: "Taxes as applicable."
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <!-- <td colspan="3">
                                            REMARKS: <?php echo $quotation->remarks; ?>
                                        </td> -->
                                        <td align="right" colspan="5">
                                            <strong>Net Amount:</strong>                                            
                                        </td>
                                        <td align="right"><strong style="font-size: 16px;"><?php echo number_format($net_amount, 2, '.', ''); ?></strong></td>
                                    </tr>                                
                                </tfoot>
                            </table>
                            <button class="btn btn-primary hidden-print" onclick="window.print()" type="button">Print</button>
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });
</script>
</body>
</html>