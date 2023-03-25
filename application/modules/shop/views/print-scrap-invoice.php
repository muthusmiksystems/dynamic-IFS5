<?php include APPPATH.'views/html/header.php'; ?>
<style type="text/css">
    @media print{
        @page{
            margin: 3mm;
        }
    }
</style>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Shop CLQ Sales
                    </header>
                    <?php
                    $othercharges_data = json_decode($invoice->othercharges_data, true);
                    $tax_data = json_decode($invoice->tax_data, true);

                    $box_list = array();
                    $credit_inv_items = $this->Sales_model->get_credit_inv_items($invoice->invoice_id);
                    if(sizeof($credit_inv_items) > 0)
                    {
                        foreach ($credit_inv_items as $item) {
                            $lot_no = ($item->lot_no != '') ? $item->lot_no : '0' ;
                            $box_list[$item->lot_no][] = $item;
                        }
                    }
                    /*echo "<pre>";
                    // print_r($othercharges_data);
                    print_r($box_list);
                    echo "</pre>";*/
                    ?>
                    <div class="panel-body">                        
                        <table class="table table-bordered invoice-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center" align="center">
                                        <h3 style="margin:0px;">CLQ SALES</h3>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" valign="top" style="vertical-align:top;">
                                        <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->concern_name; ?></strong><br>
                                        <?php echo $invoice->concern_address; ?><br>
                                        TIN: <?php echo $invoice->concern_tin; ?>,
                                        CST: <?php echo $invoice->concern_cst; ?>
                                    </th>
                                    <th colspan="3" valign="top" style="vertical-align:top;">
                                        <strong>To:&emsp;</strong>
                                        <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->cust_name; ?></strong><br>
                                        <?php echo $invoice->cust_address; ?>
                                        <?php echo $invoice->cust_city; ?><br>
                                        TIN: <?php echo $invoice->cust_tinno; ?>,
                                        CST: <?php echo $invoice->cust_cst; ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        INV NO: <span style="font-size:18px;">CLQ-<?php echo $invoice->invoice_no; ?></span>
                                    </th>
                                    <th colspan="3" class="text-right" align="right">
                                        <?php echo date("d-m-Y g:i a"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Item Description</th>
                                    <th>Del.Nt.Wt / #Cones</th><!--ER-07-18#-9-->
                                    <th>Rate</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <?php
                            $tot_amount = $invoice->item_rate * $invoice->item_weight;
                            ?>
                            <tbody>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="50%"><?php echo $invoice->item_description; ?></td>
                                    <td width="15%"><?php echo $invoice->item_weight; ?> <?php echo $invoice->uom_name; ?></td>
                                    <td width="15%"><?php echo $invoice->item_rate; ?></td>
                                    <td width="15%" align="right"><?php echo number_format($tot_amount, 2, '.', ''); ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
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
                                                $others[] = $data;
                                            }
                                        }
                                    }
                                }

                                $taxes = array();
                                $t_amt = $tot_amount;
                                if(sizeof($tax_data) > 0)
                                {
                                    foreach ($tax_data as $key => $data) {
                                        $tax = 0;
                                        $tax = ($t_amt* $data['value']) / 100;
                                        $tax = number_format($tax, 2, '.', '');
                                        $tax_data[$key]['amount'] = $tax;
                                        $tot_amount += $tax;

                                        $data['amount'] = $tax;
                                        $taxes[] = $data;
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
                                                $others[] = $data;                                                    
                                            }
                                        }
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
                                ?>
                                <?php if(count($others) > 0): ?>
                                    <?php $row_no = 0; ?>
                                    <?php foreach($others as $key => $data): ?>
                                        <?php if($data['amount'] > 0): ?>
                                            <tr class="other-row">
                                                <?php if($key == 0): ?>
                                                    <td class="del-address" colspan="2" rowspan="<?php echo $rowspan; ?>">
                                                        <strong>Delivery Address:</strong>
                                                        <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->del_cust_name; ?></strong><br>
                                                        <?php echo $invoice->del_cust_address; ?>
                                                        <?php echo $invoice->del_cust_city; ?><br>
                                                    </td>
                                                <?php endif; ?>
                                                <td align="right" colspan="2">
                                                    <strong>
                                                        <?php echo ($data['desc'] != '')?'('.$data['desc'].')':$data['names']; ?>
                                                    </strong>                                                        
                                                </td>
                                                <td align="right" class="last-col"><strong><?php echo $data['amount']; ?></strong></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="other-row">
                                        <td class="del-address" colspan="2" rowspan="<?php echo $rowspan; ?>">
                                            <strong>Delivery Address:</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->del_cust_name; ?></strong><br>
                                            <?php echo $invoice->del_cust_address; ?>
                                            <?php echo $invoice->del_cust_city; ?><br>
                                        </td>
                                        <td align="right" class="last-col" colspan="2"></td>
                                        <td class="last-col"></td>
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
                                            <tr class="tax-row">
                                                <?php if($key == 0): ?>
                                                    <td colspan="2" rowspan="<?php echo $rowspan; ?>">
                                                        <strong>Transport Mode:</strong>
                                                        <?php echo $invoice->transport_mode; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td align="right" colspan="2">
                                                    <strong><?php echo $data['name']; ?></strong>
                                                    <?php echo ($data['value'] != '')?'('.$data['value'].'%)':''; ?>
                                                </td>
                                                <td align="right" class="last-col"><strong><?php echo $data['amount']; ?></strong></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="tax-row">
                                        <td colspan="6" rowspan="<?php echo $rowspan; ?>">
                                            <strong>Transport Mode:</strong>
                                            <?php echo $invoice->transport_mode; ?>
                                        </td>
                                        <td align="right" colspan="4"></td>
                                        <td class="last-col"></td>
                                    </tr>
                                <?php endif; ?>

                                <?php
                                $upate_inv['invoice_id'] = $invoice->invoice_id;
                                $upate_inv['invoice_amt'] = $net_amount;
                                $this->Scrapsales_model->update_scrap_inv_amt($upate_inv);
                                ?>
                                <tr class="grand-total">
                                    <td colspan="2">
                                        <strong>Rupees:</strong>
                                        <?php echo $this->Sales_model->amount_words($net_amount); ?>
                                    </td>
                                    <td align="right" colspan="2">
                                        <strong>Net Amount (Round off)</strong>                                            
                                    </td>
                                    <td align="right" class="last-col"><strong><?php echo number_format($net_amount, 2, '.', ''); ?></strong></td>
                                </tr>

                                <tr class="invoice-foot">
                                    <td colspan="5">
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
<script type="text/javascript" language="javascript" src="<?=base_url('themes/default'); ?>/tabletools/js/dataTables.tableTools.js"></script>
<script type="text/javascript">
    active_submit();
    $("#item_rate").keyup(function() {
        var item_rate = $(this).val();
        var item_weight = $("#item_weight_text").text();
        var item_amount = parseFloat(item_rate) * parseFloat(item_weight);
        $("#item_amount").val(item_amount.toFixed(2));
        $("#item_amount_text").text(item_amount.toFixed(2));
        active_submit();
    });

    function active_submit(argument) {
        var item_amount = $("#item_amount").val();
        if(item_amount > 0)
        {
            $("#submit").css('display', 'block');
        }
        else
        {
            $("#submit").css('display', 'none');
        }
    }
</script>
</body>
</html>