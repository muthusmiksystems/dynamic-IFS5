<?php include APPPATH.'views/html/header.php'; ?>
    <style type="text/css">
        @media print{
            @page{
                margin: 3mm;
            }
            .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td
            {
                border: 1px solid #403d3d !important;
            }
      }
    </style>
	<section id="main-content">
		<section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Shop Cash Invoice
                        </header>
                        <?php
                        $othercharges_data = json_decode($invoice->othercharges_data, true);
                        $tax_data = json_decode($invoice->tax_data, true);

                        $box_list = array();
                        $cash_inv_items = $this->Sales_model->get_cash_inv_items($invoice->invoice_id);
                        if(sizeof($cash_inv_items) > 0)
                        {
                            foreach ($cash_inv_items as $item) {
                                $box_list[$item->item_id.$item->shade_id][] = $item;
                            }
                        }
                        /*echo "<pre>";
                        print_r($othercharges_data);
                        print_r($tax_data);
                        echo "</pre>";*/
                        ?>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered invoice-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="11" class="text-center" align="center">
                                            <h3 style="margin:0px;">Cash Invoice</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" valign="top" style="vertical-align:top;">
                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->concern_name; ?></strong><br>
                                            <?php echo $invoice->concern_address; ?><br>
                                            GST: <?php echo $invoice->concern_gst; ?>,
                                                                            </th>
                                        <th colspan="5" valign="top" style="vertical-align:top;">
                                            <strong>To:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->cust_name; ?></strong><br>
                                            <?php echo $invoice->cust_address; ?>
                                            <?php echo $invoice->cust_city; ?><br>
                                            GST: <?php echo $invoice->cust_gst; ?>,
                                                                            </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6">
                                            <!-- CASH INV NO: <span style="font-size:18px;">SH/CS-<?php echo $invoice->invoice_id; ?></span> -->
                                            CASH INV NO: <span style="font-size:18px;">SH/CS-<?php echo $invoice->invoice_no; ?></span>
                                        </th>
                                        <th colspan="5" class="text-right" align="right">
                                            <?php echo date("d-m-Y g:i a", strtotime($invoice->invoice_date)); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th># Boxes</th>
                                        <th>Item Name/Code</th>
                                        <th>HSN Code</th>
                                        <th>Shade Name/No</th>
                                        <th># Lots</th>
                                        <th>#Cones</th>
                                        <th>Gr.Wt</th>
                                        <th>Del.Nt.Wt / #Cones</th><!--ER-07-18#-9-->
                                        <th>Rate</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <?php
                                $tot_boxes = 0;
                                $tot_amount = 0;
                                $tot_gr_weight = 0;
                                $tot_nt_weight = 0;
                                $tot_no_cones = 0;
                                $box_nos = array();
                                ?>
                                <tbody>
                                    <?php if(count($box_list) > 0): ?>
                                        <?php foreach($box_list as $key => $boxes): ?>
                                            <?php if(sizeof($boxes) > 0): ?>
                                                <?php
                                                $sno = 1;
                                                $no_cones = 0;
                                                $no_lots = array();
                                                $gr_weight = 0;
                                                $delivery_qty = 0;
                                                ?>
                                                <?php foreach($boxes as $box): ?>
                                                    <?php
                                                    $box_nos[] = $box->box_prefix.$box->box_no;
                                                    $item_name  = $box->item_name.'/'.$box->item_id;
                                                    $shade_name  = $box->shade_name.'/'.$box->shade_code;
                                                    $hsn_code  = $box->hsn_code;
                                                    $shade_code  = $box->shade_code;
                                                    $item_rate  = $box->item_rate;
                                                    $uom_name  = $box->uom_name;
                                                    $no_lots[$box->lot_no]  = $box->lot_no;
                                                    $no_cones += $box->no_cones;
                                                    $gr_weight += $box->gr_weight;
                                                    $delivery_qty += $box->delivery_qty;
                                                    //ER-07-18#-10
                                                    /*
                                                    $tot_gr_weight += $gr_weight;
                                                    $tot_nt_weight += $delivery_qty;
                                                    $tot_no_cones += $no_cones;
                                                    */
                                                    //ER-07-18#-10
                                                    $tot_boxes++;
                                                    ?>
                                                <?php endforeach; ?>
                                                <?php
                                                //ER-07-18#-10
                                                $tot_gr_weight += $gr_weight;
                                                $tot_nt_weight += $delivery_qty;
                                                $tot_no_cones += $no_cones;
                                                //ER-07-18#-10
                                                $item_amt = number_format($delivery_qty * $item_rate, 2, '.', '');
                                                $tot_amount += $item_amt;
                                                ?>
                                                <tr>
                                                    <td><?php echo $sno++; ?></td>
                                                    <td><?php echo sizeof($boxes); ?></td>
                                                    <td><?php echo $item_name; ?></td>
                                                    <td><?php echo $hsn_code; ?></td>
                                                    <td><?php echo $shade_name; ?></td>
                                                    <td><?php echo count($no_lots); ?></td>
                                                    <td><?php echo $no_cones; ?></td>
                                                    <td><?php echo $gr_weight; ?> <?php echo $uom_name; ?></td>
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
                                        <td colspan="3"><strong>Total</strong></td>
                                        <td><strong><?php echo $tot_boxes; ?> Boxes</strong></td>
                                        <td></td>
                                        <td><strong>Total</strong></td>
                                        <td><strong><?php echo $tot_no_cones; ?></strong></td>
                                        <td><strong><?php echo $tot_gr_weight; ?> <?php echo $uom_name; ?></strong></td>
                                        <td><strong><?php echo $tot_nt_weight; ?> <?php echo $uom_name; ?></strong></td>
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
                                                $deduction = 0;
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
                                                    $others[] = $data;                                                                                            }
                                            }
                                        }
                                    }

                                    

                                    if(sizeof($othercharges_data) > 0)
                                    {
                                        foreach ($othercharges_data as $key => $data) {
                                            if($data['type'] == '+')
                                            {
                                                $addition = 0;
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
                                                    $others[] = $data;                                                                                            }
                                            }
                                        }
                                    }
                                    $taxes = array();
                                    $temp = $tot_amount;
                                    if(sizeof($tax_data) > 0)
                                    {
                                        foreach ($tax_data as $key => $data) {
                                            $tax = 0;
                                            $tax = ($temp * $data['value']) / 100;
                                            $tax = number_format($tax, 2, '.', '');
                                            $tax_data[$key]['amount'] = $tax;
                                            $tot_amount += $tax;

                                            $data['amount'] = $tax;
                                            if($tax > 0)
                                            {
                                                $taxes[] = $data;                                                                                    }
                                        }
                                    }

                                    $net_amount = round($tot_amount);

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
                                    // $rowspan = count($others);
                                    ?>
                                    <?php if(count($others) > 0): ?>
                                        <?php foreach($others as $key => $data): ?>
                                            <?php if($data['amount'] > 0): ?>
                                                <tr>
                                                    <?php if($key == 0): ?>
                                                        <td colspan="3" >
                                                            <strong>Delivery Address:</strong>
                                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->del_cust_name; ?></strong><br>
                                                            <?php echo $invoice->del_cust_address; ?>
                                                            <?php echo $invoice->del_cust_city; ?><br>

                                                            <strong>Box Nos:</strong>
                                                            <?php echo implode(",", $box_nos); ?>
                                                        </td>
                                                        <td colspan="4">
                                                            <strong>Remarks:</strong>
                                                            <?php echo $invoice->remarks; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td align="right" colspan="3">
                                                        <strong>
                                                            <?php echo ($data['desc'] != '')?'('.$data['desc'].')':$data['names']; ?>
                                                        </strong>
                                                                                                    </td>
                                                    <td align="right"><strong><?php echo $data['amount']; ?></strong></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" >
                                                <strong>Delivery Address:</strong>
                                                <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->del_cust_name; ?></strong><br>
                                                <?php echo $invoice->del_cust_address; ?>
                                                <?php echo $invoice->del_cust_city; ?><br>
                                                <strong>Box Nos:</strong>
                                                <?php echo implode(",", $box_nos); ?>
                                            </td>
                                            <td colspan="3" >
                                                <strong>Remarks:</strong>
                                                <?php echo $invoice->remarks; ?>
                                            </td>
                                            <td align="right" colspan="4"></td>
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
                                            <?php if($data['amount'] > 0): ?>
                                                <tr>
                                                    <?php if($key == 0): ?>
                                                        <td colspan="7" rowspan="<?php echo $rowspan; ?>">
                                                            <strong>Transport Mode:</strong>
                                                            <?php echo $invoice->transport_mode; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td align="right" colspan="3">
                                                        <strong><?php echo $data['name']; ?></strong>
                                                        <?php echo ($data['value'] != '')?'('.$data['value'].'%)':''; ?>
                                                    </td>
                                                    <td align="right"><strong><?php echo $data['amount']; ?></strong></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" rowspan="<?php echo $rowspan; ?>">
                                                <strong>Transport Mode:</strong>
                                                <?php echo $invoice->transport_mode; ?>
                                            </td>
                                            <td align="right" colspan="3"></td>
                                            <td></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php
                                    $upate_inv['invoice_id'] = $invoice->invoice_id;
                                    $upate_inv['invoice_amt'] = $net_amount;
                                    $this->Sales_model->update_cash_inv_amt($upate_inv);
                                    ?>

                                    <tr>
                                        <td colspan="7">
                                            <strong>Rupees:</strong>
                                            <?php echo $this->Sales_model->amount_words($net_amount); ?>
                                        </td>
                                        <td align="right" colspan="3">
                                            <strong>Net Amount (Round off):</strong>                                                                            </td>
                                        <td align="right"><strong><?php echo number_format($net_amount, 2, '.', ''); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                            <div class="col-lg-12">
                                                <div class="print-div col-lg-3">
                                                    <strong>Received By</strong>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <?php echo $invoice->name; ?>  <?php echo $invoice->mobile_no; ?>
                                                </div>
                                                <div class="print-div col-lg-3" style="border-right:none;">
                                                    <strong>Prepared By</strong>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <?php echo $this->session->userdata('display_name'); ?>
                                                </div>
                                                <div class="print-div col-lg-2" style="border-right:none;">
                                                    <strong>Checked By</strong>
                                                    <br/>
                                                    <br/>
                                                </div>
                                                <div class="print-div right-align col-lg-4">
                                                    <strong>For <?php echo $invoice->concern_name; ?>.</strong>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    Auth.Signatury
                                                </div>
                                            </div>
                                        </td>
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