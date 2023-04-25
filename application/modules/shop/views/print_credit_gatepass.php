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
                        Gatepass Details
                    </header>
                    <?php
                    $othercharges_data = json_decode($invoice->othercharges_data, true);
                    $tax_data = json_decode($invoice->tax_data, true);

                    $box_list = array();
                    $allowed_boxes = array();
                    $credit_inv_items = $this->Sales_model->get_credit_inv_items($invoice->invoice_id);
                    if (sizeof($credit_inv_items) > 0) {
                        foreach ($credit_inv_items as $item) {
                            $allowed_boxes[] = $item->box_prefix . $item->box_no;
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
                        <table style="border:none;" class="table table-bordered table-striped table-condensed">

                            <tr>
                                <td colspan="8" align="center" style="text-align:center;">
                                    <h3 style="margin:0px;">Gate Pass</h3>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">Gate Pass No</td>
                                <td width="40%" colspan="3"><strong style="font-size: 15px;"><?php echo $invoice->invoice_id; ?> - dt. <?= date("d-m-Y H:i:s"); ?></strong></td>
                                <td width="10%">Invoice No</td>
                                <td width="40%" colspan="3"><strong style="font-size: 15px;">SH/CR-<?php echo $invoice->invoice_no; ?></strong></td>
                            </tr>
                            <tr>
                                <td>Customer Code</td>
                                <td colspan="3"><?= $invoice->customer_id; ?></td>
                                <td>DC No</td>
                                <td colspan="3"><?= implode(',', $dc); ?></td>
                            </tr>

                            <tr class="invoice-head">
                                <th>#</th>
                                <th>Item <br>Name/Code</th>
                                <th>Shade <br>Name/No</th>
                                <th>Lot No</th>
                                <th>#<br>Boxes</th>
                                <th>#<br>Pkg</th>
                                <th>Gr.Wt</th>
                                <th>Net.Wt</th>
                            </tr>
                            <?php
                            $tot_boxes = 0;
                            $tot_amount = 0;
                            $tot_no_cones = 0;
                            $tot_gr_weight = 0;
                            $tot_nt_weight = 0;
                            $sno = 1;
                            ?>
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
                                                    ?>
                                                    <tr class="information">
                                                        <td><?php echo $sno++; ?></td>
                                                        <td><?php echo $item_name; ?></td>
                                                        <td><?php echo $shade_name; ?></td>
                                                        <td><?php echo $lot_no; ?></td>
                                                        <td><?php echo count($values['gr_weight']); ?></td>
                                                        <td><?php echo $no_cones; ?></td>
                                                        <td><?php echo $gr_weight; ?> <small><?php echo $uom_name; ?></small></td>
                                                        <td><?php echo $delivery_qty; ?> <small><?php echo $uom_name; ?></small></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <tr class="total">
                                <td colspan="4" align="right"><strong>Sub-Total</strong></td>
                                <td><strong><?php echo $tot_boxes; ?> Boxes</strong></td>
                                <td><strong><?php echo $tot_no_cones; ?></strong></td>
                                <td><strong><?php echo number_format($tot_gr_weight, 3, '.', ''); ?> <?php echo $uom_name; ?></strong></td>
                                <td><strong><?php echo number_format($tot_nt_weight, 3, '.', ''); ?> <?php echo $uom_name; ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="1">Boxes Allowed <span style="font-size: 24px; font-weight: bold;">[<?= count($allowed_boxes); ?>]</span></td>
                                <td colspan="7"><strong style="font-size:24px;"><?= implode(", ", $allowed_boxes); ?></strong></td>
                            </tr>
                            <tr class="invoice-foot">
                                <td colspan="12">
                                    <div class="col-lg-12">
                                        <div class="print-div col-lg-3">
                                            <strong>Gate Security Name</strong>
                                            <br />
                                            <br />
                                            <br />
                                            <br />
                                            <strong>Signature</strong>
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
                                            <strong>Received By</strong>
                                            <br />
                                            <br />
                                            <br />
                                            <br />
                                            <?php echo $invoice->name; ?> <?php echo $invoice->mobile_no; ?>
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
                        </table>
                        <br />
                        <br />
                        <br />
                        <br />
                        <table style="border:none;" class="table table-bordered table-striped table-condensed">
                            <tr>
                                <td width="25%">
                                    <h2>Boxes Allowed <span>[<?= count($allowed_boxes); ?>]</h2>
                                </td>
                                <td width="75%">
                                    <h2><?= implode(", ", $allowed_boxes); ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="col-lg-12">
                                        <div class="print-div col-lg-3">
                                            <strong>Gate Security Name</strong>
                                            <br />
                                            <br />
                                            <br />
                                            <br />
                                            <strong>Signature</strong>
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
                                            <strong>Received By</strong>
                                            <br />
                                            <br />
                                            <br />
                                            <br />
                                            <?php echo $invoice->name; ?> <?php echo $invoice->mobile_no; ?>
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