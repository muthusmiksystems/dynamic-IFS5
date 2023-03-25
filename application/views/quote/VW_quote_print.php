<html>
<title>Billing</title>

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://budnet.in/demo/production/theme/print/css/style.css">

    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

    <style type="text/css">
        h1 {
            font-size: 16px !important;
        }

        p {
            font-size: 11px;
            margin-bottom: 0rem;
        }
    </style>
</head>

<body onload="window.print()">

    <?php
    error_reporting(0);

    function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
    function no_to_words($no)
    {
        $words = array(
            '0' => '',
            '1' => 'one',
            '2' => 'two',
            '3' => 'three',
            '4' => 'four',
            '5' => 'five',
            '6' => 'six',
            '7' => 'seven',
            '8' => 'eight',
            '9' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fouteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'nineteen',
            '20' => 'twenty',
            '30' => 'thirty',
            '40' => 'fourty',
            '50' => 'fifty',
            '60' => 'sixty',
            '70' => 'seventy',
            '80' => 'eighty',
            '90' => 'ninty',
            '100' => 'hundred &',
            '1000' => 'thousand',
            '100000' => 'lakh',
            '10000000' => 'crore'
        );
        if ($no == 0)
            return ' ';
        else {
            $novalue = '';
            $highno = $no;
            $remainno = 0;
            $value = 100;
            $value1 = 1000;
            while ($no >= 100) {
                if (($value <= $no) && ($no < $value1)) {
                    $novalue = $words["$value"];
                    $highno = (int) ($no / $value);
                    $remainno = $no % $value;
                    break;
                }

                $value = $value1;
                $value1 = $value * 100;
            }

            if (array_key_exists("$highno", $words)) return $words["$highno"] . " " . $novalue . " " . getIndianCurrency($remainno);
            else {
                $unit = $highno % 10;
                $ten = (int) ($highno / 10) * 10;
                return $words["$ten"] . " " . $words["$unit"] . " " . $novalue . " " . getIndianCurrency($remainno);
            }
        }
    }

    $x = 1;
    /*
$data = $this->user->get_table('purchase_record', null, 'id', $this->uri->segment(3) , null);
$vendor = $this->user->get_table('tbl_vendor', null, 'id', $data[0]['vendor'], null);
$deliver = $this->user->get_table('tbl_vendor', null, 'id', $data[0]['delivery'], null);
$concern = $this->user->get_table('tbl_company', null, 'id', $data[0]['concern'], null);
$purchase_list = $this->user->get_table('tbl_purchase_list',1,'purchase_id',$data[0]['id'],null); 
$total = $this->db->select('count(*) as total')->where('purchase_id',28)->get('tbl_purchase_list')->result_array();
*/


    $data = $this->user->get_table_data('tbl_quote', null, 'id', $this->uri->segment(3), null);
    $purchase_list = $this->user->get_table_data('tbl_quote_list', null, 'purchase_id', $data[0]['id'], null);
    $concern = $this->user->get_table_data('bud_concern_master', null, 'concern_id', $data[0]['branch'], null);

    $vendor = $this->user->get_table_data('bud_customers', null, 'cust_id', $data[0]['cust_id'], null);
    $deliver = $this->user->get_table_data('bud_customers', null, 'cust_id', $data[0]['cust_id'], null);


    $total = $this->db->select('count(*) as total')->where('purchase_id', $data[0]['id'])->get('tbl_quote_list')->result_array();

    ?>
    <?php
    function header_load($data, $concern, $vendor, $deliver)
    {
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="<?= base_url(); ?>/uploads/logo.jpeg" alt="" height="100" width="100%" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td colspan="2" class="text-center purchase"><strong>
                                            <h3>Quotation</h3>
                                        </strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center"><strong>Quote No: <?= $data[0]['bill_no']; ?></strong></td>
                                    <td align="center"><strong>Date : <?= substr($data[0]['added_date'], 0, 10); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Concern Name:</strong><br>
                        <div class="address">
                            <h1><?= $concern[0]['concern_name']; ?></h1>
                            <p><?= nl2br($concern[0]['concern_address']); ?></p>
                            <p><strong>Phone</strong> : <?= $data[0]['phone']; ?><br /><strong>GST</strong> : <?= $concern[0]['concern_gst']; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <strong>Customer Address:</strong><br>
                        <div class="address">
                            <h1><?= $data[0]['cname']; ?></h1>
                            <p><?= nl2br($data[0]['caddress']); ?></p>
                            <p><strong>Phone</strong> : <?= $data[0]['phone']; ?><br /><strong>GST</strong> : <?= $data[0]['gstno']; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <strong>Customer Delivery Address:</strong><br>
                        <div class="address" contenteditable='true'>
                            <h1><?= $data[0]['cname']; ?></h1>
                            <p><?= nl2br($data[0]['caddress']); ?></p>
                            <p><strong>Phone</strong> : <?= $data[0]['phone']; ?><br /><strong>GST</strong> : <?= $data[0]['gstno']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive order">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center"><strong>Cash Mode</strong></th>
                                <th class="text-center"><strong>Request By</strong></th>
                                <th class="text-center"><strong>Delivery Date</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center"><?= $data[0]['cash_mode']; ?></td>
                                <td align="center"><?= $data[0]['request_by']; ?></td>
                                <td align="center"><?= date('d-M-Y', strtotime($data[0]['deliver_date'])); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="container">
        <div class="bill">
            <?php
            echo header_load($data, $concern, $vendor, $deliver);
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th><strong>S.NO</strong></th>
                                            <th><strong>IMG</strong></th>
                                            <th><strong>Description of Goods</strong></th>
                                            <th><strong>HSN CODE</strong></th>
                                            <th><strong>Qty</strong></th>
                                            <th><strong>UOM</strong></th>
                                            <th><strong>Rate</strong></th>
                                            <th><strong>Total</strong></th>
                                            <?php if (substr($data[0]['gstno'], 0, 2) == 33) { ?>

                                                <th><strong>CGST</strong></th>
                                                <th><strong>SGST</strong></th>
                                                <th><strong>Total</strong></th>

                                            <?php } else { ?>
                                                <th><strong>IGST</strong></th>
                                                <th><strong>Total</strong></th>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a = 0;
                                        $page_total = $total[0]['total'];
                                        $total = 0;
                                        $weight = 0;

                                        $all = 0;
                                        $load = 0;
                                        $tamt = 0;
                                        $total_tax_amount = 0;
                                        $total_normal_amount = 0;
                                        foreach ($purchase_list as $row) {
                                            ++$load;
                                            ++$all;
                                            //$product = $this->user->load_detail($r['item_type'],$r['item_name']);
                                            $mul = $row['qty'] * $row['rate'];
                                            $total_normal_amount += $mul;
                                            $div = $row['tax'] / 100;
                                            $t   = ($div * $mul);
                                            $hsn[] = $row['hsn'];
                                            $tax[] = $row['tax'];
                                            $amt[] = $row['qty'] * $row['rate'];
                                            $tamt += $row['qty'] * $row['rate'];

                                            $total_tax_amount +=  $t;
                                            $img = $row['image'];
                                        ?>
                                            <tr>
                                                <td class="desc-last"><?= ++$a; ?></td>
                                                <td class="desc-last" width="10%"><img src="<?= $img; ?>" height="80" width="80"></td>
                                                <td class="desc-last"><?php echo $row['name']; ?></td>
                                                <td class="desc-last">
                                                    <?php echo $row['hsn']; ?>
                                                </td>
                                                <td class="desc-last"><?php echo $row['qty']; ?></td>
                                                <td class="desc-last"><?php echo $row['umo_n']; ?></td>
                                                <td class="desc-last"><?php echo number_format($row['rate'], 2); ?></td>
                                                <td class="desc-last">
                                                    <?php echo number_format(($row['qty'] * $row['rate']), 2); ?>
                                                </td>
                                                <?php if (substr($data[0]['gstno'], 0, 2) == 33) { ?>
                                                    <td><?= number_format(($t / 2), 2); ?></td>
                                                    <td><?= number_format(($t / 2), 2); ?></td>
                                                <?php } else { ?>
                                                    <td><?= number_format(($t), 2); ?></td>
                                                <?php } ?>
                                                <td><?= number_format(($t + $mul), 2); ?></td>


                                            </tr>
                                            <?php
                                            $total += $row['qty'] * $row['rate'];
                                            $weight += $row['qty'];

                                            if ($load == 10 && $all != $page_total) {
                                                $load = 0;
                                            ?>
                                                <tr>
                                                    <th colspan="10"><strong>To Be Continue...</strong></td>

                                                </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="note">
                        <p><strong>Note : </strong><br /></p>
                        <textarea style="border: none;font-size: 11px;padding:0px;margin: 0;height: 110px;overflow: hidden;" class="form-control">1) All Subject to TIRUPUR jurisdictions.
2) Please pay by A/C Payee Cheque/Draft Only 
3) Goods Once sold will not be taken back 
4) if Not paid within duw date, interest will be charged @ 14 p.a</textarea>
                        <p>
                        </p>
                        <p>
                        </p>
                        <p>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="signature">
                        <div class="sign"></div>
                        <p class="text-center">Signature of the candidate</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bill">
            <?php
                                                echo header_load($data, $concern, $vendor, $deliver);
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th><strong>S.NO</strong></th>
                                            <th><strong>IMG</strong></th>
                                            <th><strong>Type</strong></th>
                                            <th><strong>Description</strong></th>
                                            <th><strong>Weight</strong></th>
                                            <th><strong>Price</strong></th>
                                            <th><strong>Total</strong></th>
                                            <?php if (substr($data[0]['gstno'], 0, 2) == 33) { ?>
                                                <th><strong>CGST</strong></th>
                                                <th><strong>SGST</strong></th>
                                                <th><strong>Total</strong></th>
                                            <?php } else { ?>
                                                <th><strong>IGST</strong></th>
                                                <th><strong>Total</strong></th>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                            }
                                        }
                                        /*
                        while($load < 11 )
                        {
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <th><strong></strong></td>
                                <th><strong></strong></td>
                                <th><strong></strong></td>
                                <th><strong></strong></td>
                                <th><strong></strong></td>
                                 <?php if(substr($data[0]['gstno'],0,2) == 33) { ?>
	                        <th><strong></strong></th>
	                        <th><strong></strong></th>
	                        <th><strong></strong></th>
	                        <?php } else { ?>
	                         <th><strong></strong></th>
	                         <th><strong></strong></th>
	                        <?php } ?>
                                                 </tr>
                            <?php
                            $load++;
                        }
                        */
                                        $i = 0;
                                        $total = array();
                                        $tax_amt = array();
                                        while (count($hsn) > $i) {
                                            $t = ($tax[$i] / 100);
                                            if (array_key_exists($hsn[$i], $total)) {
                                                $tax_amt[$hsn[$i]] += $amt[$i] * $t;
                                                $total[$hsn[$i]] += $amt[$i];
                                            } else {
                                                $tax_amt[$hsn[$i]] = $amt[$i] * $t;
                                                $total[$hsn[$i]] = $amt[$i];
                                            }
                                            $i++;
                                        }

                                        $total_amount = $tamt + array_sum($tax_amt);
                                        $ta_amt = array_sum($tax_amt);

                                ?>


                                <tr>
                                    <td class="desc-last"></td>
                                    <td class="desc-last"></td>
                                    <th class="desc-last">Total</th>
                                    <td class="desc-last"></td>
                                    <td class="desc-last"></td>
                                    <th class="desc-last"><?= number_format($weight, 2); ?></th>
                                    <td class="desc-last"></td>
                                    <th class="desc-last"><?= number_format(($total_normal_amount), 2); ?></th>
                                    <?php if (substr($data[0]['gstno'], 0, 2) == 33) { ?>
                                        <th><?= number_format(($total_tax_amount / 2), 2); ?></th>
                                        <th><?= number_format(($total_tax_amount / 2), 2); ?></th>

                                    <?php } else { ?>
                                        <th><?= number_format(($total_tax_amount), 2); ?></th>

                                    <?php } ?>
                                    <th><?= number_format(($total_amount), 2); ?></th>
                                </tr>
                                <tr>
                                    <td class="desc-last" colspan="10">
                                        <b>Note : </b><?= $data[0]['remarks']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="desc-last" colspan="10">
                                        <b> Amount in Words : </b>
                                        <?= strtoupper(getIndianCurrency(($total_amount))); ?> ONLY /-
                                        <br>
                                        <center>[This is auto genrated Quotation, Hence Signature is not required]</center>
                                    </td>
                                </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="note">
                        <p><strong>General Terms : </strong><br />
                            <?= nl2br($data[0]['general']); ?></p>
                        <p>
                        </p>
                        <p>
                        </p>
                        <p>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="note">
                        <p><strong>Payment Terms: </strong><br />
                            <?= nl2br($data[0]['payment']); ?></p>
                        <p>
                        </p>
                        <p>
                        </p>
                        <p>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="note">
                        <p><strong>Delivery Terms: </strong><br />
                            <?= nl2br($data[0]['delivery']); ?></p>
                        <p>
                        </p>
                        <p>
                        </p>
                        <p>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="signature">
                        <p class="text-center"><strong>Quote given By <?= $this->session->userdata('display_name'); ?></strong></p>
                        <br>
                        <div class="sign"></div><br>
                        <p class="text-center"><?= date("d-m-Y H:i:s"); ?></p>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>