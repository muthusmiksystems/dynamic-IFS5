<?php include APPPATH . 'views/html/header.php'; ?>
<style type="text/css">
    @media print {
        @page {
            margin: 0.3in;
            size: A4;
        }

        #shop_cr_invoice th,
        #shop_cr_invoice td {
            padding: 3px;
        }

        table {
            page-break-after: auto !important
        }

        tr {
            page-break-inside: avoid !important;
            page-break-after: auto !important
        }

        td {
            page-break-inside: avoid !important;
            page-break-after: auto !important
        }

        /*thead { display:table-header-group !important;}*/
        thead {
            display: table-row-group !important;
        }

        tfoot {
            display: table-footer-group !important
        }

        thead,
        tfoot {
            break-inside: avoid !important;
        }
    }
</style>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Shop Credit Invoice
                    </header>
                    <?php
                    $othercharges_data = json_decode($invoice->othercharges_data, true);
                    $tax_data = json_decode($invoice->tax_data, true);

                    $box_list = array();
                    $credit_inv_items = $this->Sales_model->get_credit_inv_items($invoice->invoice_id);
                    if (sizeof($credit_inv_items) > 0) {
                        foreach ($credit_inv_items as $item) {
                            $lot_no = ($item->lot_no != '') ? $item->lot_no : '0';
                            $item_values[$item->item_name . '/' . $item->item_id]['hsn_code'] = $item->hsn_code;
                            $box_list[$item->item_name . '/' . $item->item_id][$item->shade_name . '/' . $item->shade_code][$item->lot_no][$item->uom_name]['item_rate'] = $item->item_rate;
                            $box_list[$item->item_name . '/' . $item->item_id][$item->shade_name . '/' . $item->shade_code][$item->lot_no][$item->uom_name]['gr_weight'][$item->box_prefix . '-' . $item->box_id] = $item->gr_weight;
                            $box_list[$item->item_name . '/' . $item->item_id][$item->shade_name . '/' . $item->shade_code][$item->lot_no][$item->uom_name]['delivery_qty'][$item->box_prefix . '-' . $item->box_id] = $item->delivery_qty;
                            $box_list[$item->item_name . '/' . $item->item_id][$item->shade_name . '/' . $item->shade_code][$item->lot_no][$item->uom_name]['no_cones'][$item->box_prefix . '-' . $item->box_id] = $item->no_cones;
                            $dc[$item->delivery_id] = 'SH-' . $item->delivery_id;
                        }
                    }
                    /*echo "<pre>";
                        //print_r($othercharges_data);
                        print_r($box_list);
                        echo "</pre>";*/
                    ?>
                    <div class="panel-body" id="transfer_dc">
                        <table class="table table-bordered invoice-table" style="width:100%;" id="shop_cr_invoice">
                            <thead>
                                <tr class="invoice-title">
                                    <td colspan="12" align="right" style="text-align:right;">
                                        <strong><?= $copytype; ?></strong>
                                    </td>
                                </tr>
                                <tr class="invoice-address">
                                    <th colspan="6" valign="top" style="vertical-align:top;">
                                        <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->concern_second_name; ?></strong><br>
                                        <?php echo $invoice->concern_address; ?><br>
                                        GST: <?php echo $invoice->concern_gst; ?>
                                    </th>
                                    <th colspan="6" valign="top" style="vertical-align:top;">
                                        <strong style="text-transform:uppercase;font-size:14px;">To:&emsp;<?php echo $invoice->cust_name; ?></strong><br>
                                        <?php echo $invoice->cust_address; ?>
                                        <?php echo $invoice->cust_city; ?><br>
                                        GST: <?php echo $invoice->cust_gst; ?>
                                    </th>
                                </tr>
                                <tr class="invoice-title">
                                    <th colspan="4" class="invoice-no">
                                        <!-- Invoice No: <span style="font-size:18px;">SH/CR-<?php echo $invoice->invoice_id; ?></span> -->
                                        Invoice No: <span style="font-size:18px;">SH/CR-<?php echo $invoice->invoice_no; ?></span>
                                    </th>
                                    <th colspan="4" class="invoice-type text-center">
                                        <h4 style="font-weight:bold;margin:0px;">CREDIT INVOICE</h4>
                                    </th>
                                    <th colspan="4" class="text-right invoice-date" align="right">
                                        <?php echo date("d-m-Y g:i a", strtotime($invoice->invoice_date)); ?>
                                    </th>
                                </tr>
                                <tr class="invoice-head">
                                    <th>#</th>
                                    <th width="130">Item <br>Name/Code</th>
                                    <th width="130">HSN Code</th>
                                    <th width="120" colspan="2">Shade <br>Name/No</th>
                                    <th>Lot No</th>
                                    <th>#<br>Boxes</th>
                                    <th>#<br>Pkg</th>
                                    <th>Uom</th>
                                    <th width="135">Gr.Wt</th>
                                    <th width="135">Net.Wt</th>
                                    <!--ER-07-18#-9-->
                                    <!-- <th width="90">Lot Nt.Wt</th> -->
                                    <th>Rate</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <?php
                            $tot_boxes = 0;
                            $tot_amount = 0;
                            $tot_no_cones = 0;
                            $tot_gr_weight = 0;
                            $tot_nt_weight = 0;
                            $sno = 1;
                            ?>
                            <tbody>
                                <?php if (count($box_list) > 0) : ?>
                                    <?php foreach ($box_list as $item_name => $boxes) : ?>
                                        <?php if (sizeof($boxes) > 0) : ?>
                                            <?php
                                            $no_cones = 0;
                                            $gr_weight = 0;
                                            $delivery_qty = 0;
                                            $row_key = 1;
                                            $lot_net_weight = 0;
                                            ?>
                                            <?php foreach ($boxes as $shade_name => $box) : ?>
                                                <?php foreach ($box as $lot_no => $lvalues) : ?>
                                                    <?php foreach ($lvalues as $uom_name => $values) : ?>
                                                        <?php
                                                        $item_rate  = $values['item_rate'];
                                                        $no_cones = array_sum($values['no_cones']);
                                                        $gr_weight = array_sum($values['gr_weight']);
                                                        $delivery_qty = array_sum($values['delivery_qty']);
                                                        $hsn_code = $item_values[$item_name]['hsn_code'];
                                                        $lot_net_weight += array_sum($values['delivery_qty']);
                                                        $tot_no_cones +=  array_sum($values['no_cones']);
                                                        $tot_gr_weight += array_sum($values['gr_weight']);
                                                        $tot_nt_weight += array_sum($values['delivery_qty']);

                                                        $tot_boxes += count($values['gr_weight']);
                                                        $item_amt = number_format($delivery_qty * $item_rate, 2, '.', '');
                                                        $tot_amount += $item_amt;
                                                        $item_id = explode('/', $item_name);
                                                        if (!empty($item_id)) {
                                                            $item_uom = $this->m_masters->getmasterIDvalue('bud_items', 'item_id',$item_id[1], 'item_uom');
                                                            $uom_item_name = $this->m_masters->get_uom('bud_uoms', $item_uom, 'uom_name');
                                                            
                                                            
                                                        } else {
                                                           $item_uom='';
                                                           $uom_item_name='';
                                                        }
                                                        ?>
                                                        <tr class="information">
                                                            <td><?php echo $sno++; ?></td>
                                                            <td><?php echo $item_name; ?></td>
                                                            <td><?php echo $hsn_code; ?></td>
                                                            <td colspan="2"><?php echo $shade_name; ?></td>
                                                            <td><?php echo $lot_no; ?></td>
                                                            <td><?php echo count($values['gr_weight']); ?></td>
                                                            <td><?php echo $no_cones; ?></td>
                                                            <td><?php echo $uom_item_name; ?></td>

                                                            <!-- <td><?php echo $gr_weight; ?> <small><?php echo $uom_name; ?></small></td>
                                                            <td><?php echo $delivery_qty; ?> <small><?php echo $uom_name; ?></small></td> -->
                                                            <td><?php echo $gr_weight; ?> </td>
                                                            <td><?php echo $delivery_qty; ?></small></td>
                                                            <!-- <?php if ($row_key++ == sizeof($boxes)) : ?>
                                                            <td><?php echo number_format($lot_net_weight, 3, '.', ''); ?> <?php echo $uom_name; ?></td>
                                                        <?php else : ?>
                                                            <td></td>
                                                        <?php endif; ?> -->
                                                            <td><?php echo $item_rate; ?></td>
                                                            <td align="right"><?php echo $item_amt; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr class="total">
                                    <td colspan="6" align="right"><strong>Sub-Total</strong></td>
                                    <td><strong><?php echo $tot_boxes; ?> Boxes</strong></td>
                                    <td><strong><?php echo $tot_no_cones; ?></strong></td>
                                    <td></td>
                                    <!-- <td><strong><?php echo number_format($tot_gr_weight, 3, '.', ''); ?> <?php echo $uom_name; ?></strong></td>
                                    <td><strong><?php echo number_format($tot_nt_weight, 3, '.', ''); ?> <?php echo $uom_name; ?></strong></td> -->
                                    <td><strong><?php echo number_format($tot_gr_weight, 3, '.', ''); ?></strong></td>
                                    <td><strong><?php echo number_format($tot_nt_weight, 3, '.', ''); ?> </strong></td>
                                    <!-- <td><strong><?php echo number_format($tot_nt_weight, 3, '.', ''); ?> <?php echo $uom_name; ?></strong></td> -->
                                    <td></td>
                                    <td align="right" class="sub-total"><strong><?php echo number_format($tot_amount, 2, '.', ''); ?></strong></td>
                                </tr>
                                <?php
                                $others = array();
                                if (sizeof($othercharges_data) > 0) {
                                    foreach ($othercharges_data as $key => $data) {
                                        if ($data['type'] == '-') {
                                            $deduction = 0;
                                            if ($data['unit'] == '%') {
                                                $deduction = ($tot_amount * $data['value']) / 100;
                                            } else {
                                                $deduction = $data['value'];
                                            }
                                            if ($deduction > 0) {
                                                $deduction = number_format($deduction, 2, '.', '');
                                            }
                                            $othercharges_data[$key]['amount'] = $deduction;
                                            $tot_amount -= $deduction;
                                            $data['amount'] = $deduction;
                                            if ($deduction > 0) {
                                                $others[] = $data;
                                            }
                                        }
                                    }
                                }

                                if (sizeof($othercharges_data) > 0) {
                                    foreach ($othercharges_data as $key => $data) {
                                        if ($data['type'] == '+') {
                                            $addition = 0;
                                            if ($data['unit'] == '%') {
                                                $addition = ($tot_amount * $data['value']) / 100;
                                            } else {
                                                $addition = $data['value'];
                                            }
                                            if ($addition > 0) {
                                                $addition = number_format($addition, 2, '.', '');
                                            }
                                            $othercharges_data[$key]['amount'] = $addition;
                                            $tot_amount += $addition;
                                            $data['amount'] = $addition;
                                            if ($addition > 0) {
                                                $others[] = $data;
                                            }
                                        }
                                    }
                                }
                                $taxes = array();
                                $tmp = $tot_amount;
                                if (sizeof($tax_data) > 0) {
                                    foreach ($tax_data as $key => $data) {
                                        $tax = 0;
                                        $tax = ($tmp * $data['value']) / 100;
                                        $tax = number_format($tax, 2, '.', '');
                                        $tax_data[$key]['amount'] = $tax;
                                        $tot_amount += $tax;

                                        $data['amount'] = $tax;
                                        $taxes[] = $data;
                                    }
                                }


                                $net_amount = round($tot_amount);

                                $rowspan = 0;
                                if (count($others) > 0) {
                                    foreach ($others as $key => $data) {
                                        if ($data['amount'] > 0) {
                                            $rowspan++;
                                        }
                                    }
                                }
                                ?>
                                <!-- <?php if (count($others) > 0) : ?>
                                    <?php $row_no = 0; ?>
                                    <?php foreach ($others as $key => $data) : ?>
                                        <?php if ($data['amount'] > 0) : ?>
                                            <tr class="other-row">
                                                <?php if ($key == 0) : ?>
                                                    <td class="del-address" colspan='3'>
                                                        <strong>DCs :</strong>
                                                        <?= implode(',', $dc); ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <strong>Customer PO No.:</strong>
                                                        <?php echo $invoice->remarks; ?>
                                                </td>
                                                </tr>   
                                                <?php endif; ?>
                                              <tr>  
                                                <td align="right" colspan="12">
                                                    <strong>
                                                        <?php echo ($data['desc'] != '') ? '(' . $data['desc'] . ')' : $data['names']; ?>
                                                    </strong> </td>
                                                <td align="right" class="last-col"><strong><?php echo $data['amount']; ?></strong></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr class="other-row">
                                        <td class="del-address" colspan='3'>
                                            <strong>DCs :</strong>
                                            <?= implode(',', $dc); ?>
                                        </td>
                                        <td colspan="4">
                                            <strong>Customer PO No.:</strong>
                                            <?php echo @$invoice->cust_pono; ?>
                                        </td>
                                        <td align="right" class="last-col" colspan="5"></td>
                                        <td class="last-col"></td>
                                    </tr>
                                <?php endif; ?> -->


                                <tr class="other-row">
                                        <td class="del-address" colspan='3' rowspan='<?php echo $rowspan+1; ?>'>
                                            <strong>DCs :</strong>
                                            <?= implode(',', $dc); ?>
                                        </td>
                                        <td colspan="9">
                                            <strong>Customer PO No.:</strong>
                                            <?php echo @$invoice->cust_pono; ?>
                                        </td>
                                        <!-- <td align="right" class="last-col" colspan="1"></td>
                                        <td class="last-col"></td> -->
                                        <td class="last-col"></td>
                                    </tr>

                                <?php if (count($others) > 0) : ?>
                                    <?php $row_no = 0; ?>
                                    <?php foreach ($others as $key => $data) : ?>
                                       <tr>  
                                                <td align="right" colspan="9">
                                                    <strong>
                                                        <?php echo ($data['desc'] != '') ? '(' . $data['desc'] . ')' : $data['names']; ?>
                                                    </strong> </td>
                                                <td align="right" class="last-col"><strong><?php echo $data['amount']; ?></strong></td>
                                            </tr>
                                        
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                              

                                <?php
                                $rowspan = 0;
                                if (count($taxes) > 0) {
                                    foreach ($taxes as $key => $data) {
                                        if ($data['amount'] > 0) {
                                            $rowspan++;
                                        }
                                    }
                                }
                                ?>
                                <?php if (count($taxes) > 0) : ?>
                                    <?php foreach ($taxes as $key => $data) : ?>
                                        <?php if ($data['amount'] > 0) : ?>
                                            <tr class="tax-row">
                                                <?php if ($key == 0) : ?>
                                                    <td colspan="7" rowspan="<?php echo $rowspan; ?>">
                                                        <strong>Transport Mode:</strong>
                                                        <?php echo $invoice->transport_mode; ?><br>
                                                        <strong>Remarks:</strong>
                                                        <?php echo $invoice->remarks; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td align="right" colspan="5">
                                                    <strong><?php echo $data['name']; ?></strong>
                                                    <?php echo ($data['value'] != '') ? '(' . $data['value'] . '%)' : ''; ?>
                                                </td>
                                                <td align="right" class="last-col"><strong><?php echo $data['amount']; ?></strong></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr class="tax-row">
                                        <td colspan="7" rowspan="<?php echo $rowspan; ?>">
                                            <strong>Transport Mode:</strong>
                                            <?php echo $invoice->transport_mode; ?><br>
                                            <strong>Remarks:</strong>
                                            <?php echo $invoice->remarks; ?>
                                        </td>
                                        <td align="right" colspan="5"></td>
                                        <td class="last-col"></td>
                                    </tr>
                                   
                                <?php endif; ?>
                                <tr class="tax-row">
                                            <td colspan="12" align="right"><strong>+ (or) -</strong></td>
                                         <td  align="right" style="font-size:15px" class="last-col"><strong>
                                            <?php
                                                     $difference = $net_amount - $tot_amount;
                                                     $formatted_difference = number_format($difference, 2, '.', '');
    
                                                if ($difference > 0) {
                                                    echo '+' . $formatted_difference;
                                                         } elseif ($difference < 0) {
                                                     echo '' . $formatted_difference;
                                                    } else {
                                                    echo $formatted_difference;
                                                    }
                                                ?>
                                        </strong></td>
                            </tr>

                                <?php
                                $upate_inv['invoice_id'] = $invoice->invoice_id;
                                $upate_inv['invoice_amt'] = $net_amount;
                                $this->Sales_model->update_credit_inv_amt($upate_inv);
                                ?>

                                <tr class="grand-total">
                                    <td colspan="7">
                                        <strong>Rupees:</strong>
                                        <?php echo $this->Sales_model->amount_words($net_amount); ?>
                                    </td>

                                    

                                    <td align="right" colspan="5" style="font-size:15px">
                                        <strong>Net Amount (Round off)</strong> </td>
                                    <td align="right" class="last-col" style="font-size:15px"><strong><?php echo number_format($net_amount, 2, '.', ''); ?></strong></td>
                                </tr>
                                <tr class="invoice-foot">
                                    <td colspan="13">
                                        <div class="col-lg-12">
                                            <div class="print-div col-lg-3">
                                                <strong>Received By</strong>
                                                <br />
                                                <br />
                                                <br />
                                                <br />
                                                <?php echo $invoice->name; ?> <?php echo $invoice->mobile_no; ?>
                                            </div>
                                            <div class="print-div col-lg-3" style="border-right:none;">
                                                <strong>Prepared By</strong>
                                                <br />
                                                <br />
                                                <br />
                                                <br />
                                                <?php echo $this->session->userdata('display_name'); ?>
                                            </div>
                                            <div class="print-div col-lg-2" style="border-right:none;">
                                                <strong>Checked By</strong>
                                                <br />
                                                <br />
                                            </div>
                                            <div class="print-div right-align col-lg-4">
                                                <strong>For <?php echo $invoice->concern_second_name; ?>.</strong>
                                                <br />
                                                <br />
                                                <br />
                                                <br />
                                                Auth.Signatury
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <button class="btn btn-primary hidden-print " onclick="window.print()" type="button">Print</button>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
<?php include APPPATH . 'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });
</script>
</body>

</html>