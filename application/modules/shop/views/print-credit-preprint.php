<!DOCTYPE html>
<html>

<head>
    <title>Shiva Tapes Packing Slip</title>
    <style type="text/css">
        @font-face {
            font-family: 'Dot Matrix';
            src: url('http://localhost/indofila/themes/default/fonts/dot_matrix.eot');
            src: url('http://localhost/indofila/themes/default/fonts/dot_matrix.eot?#iefix') format('embedded-opentype'),
                url('http://localhost/indofila/themes/default/fonts/dot_matrix.woff') format('woff'),
                url('http://localhost/indofila/themes/default/fonts/dot_matrix.ttf') format('truetype'),
                url('http://localhost/indofila/themes/default/fonts/dot_matrix.svg#http://localhost/indofila/themes/default/fonts/dotMatrixRegular') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: 'Dot Matrix';
            /*font-size: 12px;*/
        }

        .paper-outer {
            width: 21cm;
            min-height: 29.7cm;
            /*padding: 2cm;*/
            margin: 0cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: url('<?= base_url(); ?>themes/default/img/pre-printed.jpg');
            background-size: 100% 100%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .second-row {
            widows: 21cm;
            height: 2.5cm;
            margin-top: 4.3cm;
            /*border: 1px solid #000;*/
        }

        .to-address {
            margin-left: 11cm
        }

        .to-address h3 {
            margin: 0px;
        }

        .to-address p {
            margin: 0px;
        }

        .third-row {
            widows: 21cm;
            height: 1cm;
            margin-top: 0.3cm;
            /*border: 1px solid #000;*/
        }

        .left-align {
            float: left;
        }

        .invoice-no {
            line-height: 0.9cm;
            margin-left: 2.5cm;
        }

        .invoice-date {
            line-height: 0.9cm;
            margin-left: 2.5cm;
        }

        .fourth-row {
            width: 21cm;
            height: 8.3cm;
            margin-top: 2cm;
            /*border: 1px solid #000;*/
            overflow: hidden;
        }

        .particulers {
            width: 19.5cm;
            margin: 0 auto;
            /*border: 1px solid #000;*/
        }

        .fifth-row {
            width: 21cm;
            height: 1.5cm;
            margin-top: 1.8cm;
            margin-left: 1.0cm;
            /*border: 1px solid #000;*/
        }

        .net-amount {
            float: right;
            margin-right: 2cm;
            line-height: 0.7;
        }

        .six-row {
            width: 21cm;
            height: 0.7cm;
            margin-top: 0.2cm;
            /*border: 1px solid #000;*/
        }

        .six-row p {
            margin: 0px;
            line-height: 0.8cm;
            margin-left: 2.5cm;
        }

        .seventh-row {
            width: 5cm;
            margin-left: 4cm;
            margin-top: 0.3cm;
            /*border: 1px solid #000;*/
        }
    </style>
</head>

<body onload="window.print();">

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

    <body>
        <div class="paper-outer">
            <div class="second-row">
                <div class="to-address">
                    <h3><?php echo $invoice->cust_name; ?></h3>
                    <p><?php echo $invoice->cust_address; ?> <?php echo $invoice->cust_city; ?><br /></p>
                    <p>GST : <?php echo $invoice->cust_gst; ?></p>
                </div>
            </div>
            <div class="third-row">
                <div class="invoice-no left-align" style="font-size:14px">
                    SH/CR- <span style="font-size:18px"><?php echo $invoice->invoice_no; ?></span>
                </div>
                <div class="invoice-date left-align">
                    <?php echo date("d-m-Y", strtotime($invoice->invoice_date)); ?>
                </div>
            </div>
            <div class="fourth-row">
                <div class="particulers">
                    <table style="width:100%;">

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
                                                    <td width="3%"><?php echo $sno++; ?></td>
                                                    <td width="3%"><?php echo count($values['gr_weight']); ?></td>
                                                    <td><?php echo $item_name; ?></td>
                                                    <td><?php echo $hsn_code; ?></td>
                                                    <td><?php echo $lot_no; ?></td>
                                                    <td width="10%"><?php echo $gr_weight; ?></td>
                                                    <td width="10%"><?php echo $delivery_qty; ?></td>
                                                    <td width="10%"><?php echo $item_rate; ?></td>
                                                    <td width="10%" align="right"><?php echo $item_amt; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2">------------------</td>
                        </tr>
                        <tr>
                            <td align="right" colspan="7">Subtotal before Tax</td>
                            <!-- <td style="float:right;"><strong><?php echo number_format($tot_amount, 2, '.', ''); ?></strong></td> -->
                            <td style="float:right;"><strong><?php echo $tot_amount; ?></strong></td>
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
                        <?php if (count($others) > 0) : ?>
                            <?php $row_no = 0; ?>
                            <?php foreach ($others as $key => $data) : ?>
                                <?php if ($data['amount'] > 0) : ?>
                                    <tr>
                                        <td align="right" colspan="7"><?php echo ($data['desc'] != '') ? '(' . $data['desc'] . ')' : $data['names']; ?></td>
                                        <td style="float:right;"><strong><?= number_format($data['amount'], 2, '.', ''); ?></strong></td>
                                    </tr>
                                <?php endif; ?>
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
                                    <tr>
                                        <td align="right" colspan="7"><strong><?php echo $data['name']; ?> @ <?php echo ($data['value'] != '') ? '(' . $data['value'] . '%)' : ''; ?></strong></td>
                                        <td style="float:right;"><strong><?= number_format($data['amount'], 2, '.', ''); ?></strong></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>


                        <?php
                        /*foreach ($deduction_amounts as $key => $value) {
                            if ($value > 0) {
                                $deduction_description = $deduction_desc[$key];
                        ?>
                                <tr>
                                    <td align="right" colspan="7"><?= $deduction_names[$key]; ?><?= ($deduction_description != '') ? '(' . $deduction_description . ')' : ''; ?></td>
                                    <td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                </tr>
                            <?php
                            }
                        }

                        foreach ($addtions_amounts as $key => $value) {
                            if ($value > 0) {
                                $addtions_description = $addtions_desc[$key];
                            ?>
                                <tr>
                                    <td align="right" colspan="7"><strong><?= $addtions_names[$key]; ?></strong><?= ($addtions_description != '') ? '(' . $addtions_description . ')' : ''; ?></td>
                                    <td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                </tr>
                            <?php
                            }
                        }
                        foreach ($tax_amounts as $key => $value) {
                            if ($value > 0) {
                                $tax_description = $this->m_masters->getTaxDesc($tax_names[$key], $tax_values[$key]);
                            ?>
                                <tr>
                                    <td align="right" colspan="7"><strong><?= $tax_names[$key]; ?> @ <?= $tax_values[$key]; ?> % </strong><?= ($tax_description != '') ? '(' . $tax_description . ')' : ''; ?></td>
                                    <td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                </tr>
                        <?php
                            }
                        }*/
                        ?>
                         <tr>
                                            <td colspan="7" align="right"><strong>+ (or) -</strong></td>
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
                        <tr>
                            <td align="right" colspan="7">Net Amount</td>
                            <td align="right"><strong><?= number_format($net_amount, 2, '.', ''); ?></strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4">
                                <p>Goods Sent through <?php echo $invoice->transport_mode; ?></p>
                                <p>Customer PO No. <?php echo @$invoice->cust_pono; ?></p>
                                <p><?php echo $invoice->remarks; ?></p>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="fifth-row">
                <div class="net-amount">
                    <h3><?= number_format($net_amount, 2, '.', ''); ?></h3>
                </div>
            </div>
            <div class="six-row">
                <p style="text-transform: capitalize;">Rupees <?= no_to_words($net_amount); ?> Only.</p>
            </div>
            <div class="seventh-row">
                <p><?= implode(',', $dc); ?></p>
            </div>
        </div>

        <?php
        function no_to_words($no)
        {
            $words = array('0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fouteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty', '30' => 'thirty', '40' => 'fourty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninty', '100' => 'hundred &', '1000' => 'thousand', '100000' => 'lakh', '10000000' => 'crore');
            if ($no == 0)
                return ' ';
            else {
                $novalue = '';
                $highno = $no;
                $remainno = 0;
                $value = 100;
                $value1 = 1000;
                while ($no >= 100) {
                    if (($value <= $no) && ($no  < $value1)) {
                        $novalue = $words["$value"];
                        $highno = (int) ($no / $value);
                        $remainno = $no % $value;
                        break;
                    }
                    $value = $value1;
                    $value1 = $value * 100;
                }
                if (array_key_exists("$highno", $words))
                    return $words["$highno"] . " " . $novalue . " " . no_to_words($remainno);
                else {
                    $unit = $highno % 10;
                    $ten = (int) ($highno / 10) * 10;
                    return $words["$ten"] . " " . $words["$unit"] . " " . $novalue . " " . no_to_words($remainno);
                }
            }
        }
        ?>
    </body>

</html>