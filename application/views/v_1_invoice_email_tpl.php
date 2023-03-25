<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="Mosaddek">
   <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
   <link rel="shortcut icon" href="img/favicon.html">

   <title>Email Template</title>
   <!-- Bootstrap core CSS -->
   <style type="text/css">
      .table {
         width: 100%;
         margin-bottom: 20px;
      }

      .table-bordered {
         border: 1px solid #ddd;
      }

      .no-border {
         border: none !important;
      }

      tr.no-padding td {
         padding: 0px !important;
      }

      .no-border td {
         margin: 0px !important;
         border: none !important;
         border-top: 0px !important;
         border-bottom: 0px !important;
      }

      .table thead>tr>th,
      .table tbody>tr>th,
      .table tfoot>tr>th,
      .table thead>tr>td,
      .table tbody>tr>td,
      .table tfoot>tr>td {
         padding: 10px;
      }

      .table-bordered>thead>tr>th,
      .table-bordered>tbody>tr>th,
      .table-bordered>tfoot>tr>th,
      .table-bordered>thead>tr>td,
      .table-bordered>tbody>tr>td,
      .table-bordered>tfoot>tr>td {
         border: 1px solid #ddd;
      }

      .table-striped>tbody>tr:nth-child(odd)>td,
      .table-striped>tbody>tr:nth-child(odd)>th {
         background-color: #f9f9f9;
      }

      table {
         border-collapse: collapse;
         border-spacing: 0;
      }
   </style>
</head>

<body>
   <?php
   $sub_total = 0;
   $total_cones = 0;
   $total_gr_wt = 0;
   $total_net_wt = 0;
   $items_array = array();
   $boxes_array = array();
   $pre_delivery_list = array();
   $item_names_arr = array();
   $gr_weights_arr = array();
   $nt_weights_arr = array();
   $no_cones_arr = array();
   $rates_arr = array();
   $item_rate = array();
   $invoice_details = $this->m_masters->getmasterdetails('bud_yt_invoices', 'invoice_id', $invoice_id);
   foreach ($invoice_details as $row) {
      $concern_name = $row['concern_name'];
      $invoice_no = $row['invoice_no'];
      $invoice_date = $row['invoice_date'];
      $customer = $row['customer'];
      $selected_dc = explode(",", $row['selected_dc']);
      $invoice_items = explode(",", $row['invoice_items']);
      $item_weights = explode(",", $row['item_weights']);
      $item_rate = explode(",", $row['item_rate']);
      $no_of_boxes = explode(",", $row['no_of_boxes']);
      $item_uoms = explode(",", $row['item_uoms']);
      $boxes_array = explode(",", $row['boxes_array']);
      $addtions_names = explode(",", $row['addtions_names']);
      $addtions_values = explode(",", $row['addtions_values']);
      $addtions_amounts = explode(",", $row['addtions_amounts']);
      $addtions_desc = explode(",", $row['addtions_desc']);
      $tax_names = explode(",", $row['tax_names']);
      $tax_values = explode(",", $row['tax_values']);
      $tax_amounts = explode(",", $row['tax_amounts']);
      $deduction_names = explode(",", $row['deduction_names']);
      $deduction_values = explode(",", $row['deduction_values']);
      $deduction_amounts = explode(",", $row['deduction_amounts']);
      $deduction_desc = explode(",", $row['deduction_desc']);
      $sub_total = $row['sub_total'];
      $net_amount = $row['net_amount'];
      $lr_no = $row['lr_no'];
      $transport_name = $row['transport_name'];
   }
   $invoice_no_array = explode("/", $invoice_no);
   $ed = explode("-", $invoice_date);
   $invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

   $concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
   foreach ($concern_details as $row) {
      $concern_title = $row['concern_name'];
      $concern_address = $row['concern_address'];
      $concern_tin = $row['concern_tin'];
      $concern_cst = $row['concern_cst'];
   }

   foreach ($boxes_array as $key => $box_no) {
      // $outerboxes = $this->m_delivery->getPreDelItemsDetails($box_no);
      $outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
      foreach ($outerboxes as $outerbox) {
         $no_of_cones = $outerbox['no_of_cones'];
         $packing_gr_weight = $outerbox['gross_weight'];
         $packing_net_weight = $outerbox['net_weight'];
         $yarn_lot_no = $outerbox['lot_no'];
         $item_name = $outerbox['item_name'];
         $item_id = $outerbox['item_id'];
         $pre_delivery_list[$yarn_lot_no][$outerbox['box_id']] = $outerbox['box_prefix'] . $outerbox['box_no'];
         $item_names_arr[$outerbox['box_id']] = $item_name . '/' . $item_id;
         $gr_weights_arr[$outerbox['box_id']] = $packing_gr_weight;
         $nt_weights_arr[$outerbox['box_id']] = $packing_net_weight;
         $no_cones_arr[$outerbox['box_id']] = $no_of_cones;
         $total_cones += $no_of_cones;
         $total_gr_wt += $packing_gr_weight;
         $total_net_wt += $packing_net_weight;
         $invoice_items[] = $item_id;
         $rates_arr[$box_no] = (isset($item_rate[$key])) ? $item_rate[$key] : 0;
      }
   }
   ?>
   <div class="row">
      <div class="col-lg-12">
         <section class="panel">
            <div class="panel-body">
               <table class="table table-bordered table-striped table-condensed invoice-table">
                  <tbody>
                     <tr class="no-padding no-border">
                        <td width="5%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                        <td width="13%"></td>
                        <td width="10%"></td>
                        <td width="5%"></td>
                        <td width="7%"></td>
                        <td width="15%"></td>
                        <td width="10%"></td>
                        <td width="15%"></td>
                     </tr>
                     <tr class="first-row">
                        <td colspan="10" align="center" style="text-align:center;">
                           <h3 style="margin:0px;">Invoice</h3>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="5">
                           <strong>FROM:</strong><br />
                           <strong style="font-size:14px;"><?= $concern_title; ?></strong><br />
                           <?= $concern_address; ?><br>
                           TIN: <?= $concern_tin; ?><br>
                           CST: <?= $concern_cst; ?><br>
                        </td>
                        <td colspan="5">
                           <strong>TO:</strong><br />
                           <strong style="text-transform:uppercase;font-size:14px;"><?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?></strong><br />
                           <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_address'); ?><br />
                           Tin No : <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_tinno'); ?>

                        </td>
                     </tr>
                     <tr>
                        <td colspan="7">
                           <strong style="font-size:18px;">Invoice No</strong>&emsp;
                           <span> <strong style="font-size:18px;">:</strong> &emsp;<?= $invoice_no_array[0]; ?>/<strong style="font-size:24px;"><?= $invoice_no_array[1]; ?></strong></span>
                        </td>
                        <td colspan="2"><strong>Date</strong></td>
                        <td><strong><?= $invoice_date; ?></strong></td>
                     </tr>
                     <tr>
                        <th>#</th>
                        <th>Box No</th>
                        <th>Item Name/Code</th>
                        <th style="text-align:right;">Lot No</th>
                        <th style="text-align:right;"># of Cones</th>
                        <th style="text-align:right;">Gr. Weight</th>
                        <th style="text-align:right;">Net Weight</th>
                        <th style="text-align:right;">Lotwise Nt.Weight</th>
                        <td align="right">Rate</td>
                        <td align="right">Amount</td>
                     </tr>
                     <?php
                     $sno = 1;
                     $total_items = 0;
                     foreach ($pre_delivery_list as $key => $value) {
                        $lotwise_nt_weight = 0;
                        foreach ($value as $key_1 => $value_1) {
                           $total_cones += $no_cones_arr[$key_1];
                           $lotwise_nt_weight += $nt_weights_arr[$key_1];
                     ?>
                           <tr>
                              <td><?= $sno; ?></td>
                              <td><?= $value_1; ?></td>
                              <td><?= $item_names_arr[$key_1]; ?></td>
                              <td align="right"><?= $key; ?></td>
                              <td align="right"><?= $no_cones_arr[$key_1]; ?></td>
                              <td align="right"><?= $gr_weights_arr[$key_1]; ?></td>
                              <td align="right"><?= number_format($nt_weights_arr[$key_1], 3, '.', ''); ?></td>
                              <td></td>
                              <td>
                                 <?= number_format($rates_arr[$key_1], 2, '.', ''); ?>
                                 <input type="hidden" name="item_rate[]" value="<?= $rates_arr[$key_1]; ?>">
                              </td>
                              <td><?= number_format($nt_weights_arr[$key_1] * $rates_arr[$key_1], 2, '.', ''); ?></td>
                           </tr>
                        <?php
                           $sno++;
                           $total_items++;
                        }
                        ?>
                        <tr>
                           <td colspan="7"></td>
                           <td align="right"><?= $lotwise_nt_weight; ?></td>
                           <td></td>
                           <td></td>
                        </tr>
                     <?php
                     }
                     ?>
                     <tr>
                        <td colspan="3" align="center"><strong>Grand Total &emsp; :</strong></td>
                        <td><strong><?= count($boxes_array); ?> Boxes</strong></td>
                        <td></td>
                        <td align="right"><strong><?= $total_gr_wt; ?></strong></td>
                        <td align="right"><strong><?= $total_net_wt; ?></strong></td>
                        <td></td>
                        <td></td>
                        <td align="right"><strong><?= number_format($sub_total, 2, '.', ''); ?></strong></td>
                     </tr>
                     <tr>
                        <!-- <td></td>
                              <td></td>
                              <td></td>
                              <td></td> -->
                        <td colspan="6">
                           <p>
                              <strong>Goods Sent through <?= $transport_name; ?> as per LRNO:<?= $lr_no; ?></strong>
                           </p>
                        </td>
                        <td align="right"></td>
                        <td></td>
                        <td></td>
                        <td align="right"><strong><?= number_format($sub_total, 2, '.', ''); ?></strong></td>
                     </tr>
                     <?php
                     $rowspan = 1;
                     foreach ($deduction_amounts as $key => $value) {
                        if ($value > 0) {
                           $rowspan++;
                        }
                     }
                     foreach ($addtions_amounts as $key => $value) {
                        if ($value > 0) {
                           $rowspan++;
                        }
                     }
                     foreach ($tax_amounts as $key => $value) {
                        if ($value > 0) {
                           $rowspan++;
                        }
                     }
                     ?>
                     <tr>
                        <td colspan="6" rowspan="<?= $rowspan + 1; ?>">
                           <strong><u>Spl. Instruction</u></strong><br /></strong>
                        </td>
                     </tr>
                     <?php
                     foreach ($deduction_amounts as $key => $value) {
                        if ($value > 0) {
                           $deduction_description = $deduction_desc[$key];
                     ?>
                           <tr>
                              <td colspan="3"><strong><?= $deduction_names[$key]; ?></strong><?= ($deduction_description != '') ? '(' . $deduction_description . ')' : ''; ?></td>
                              <td colspan="1" align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                           </tr>
                        <?php
                        }
                     }
                     foreach ($tax_amounts as $key => $value) {
                        if ($value > 0) {
                           $tax_description = $this->m_masters->getTaxDesc($tax_names[$key], $tax_values[$key]);
                        ?>
                           <tr>
                              <td colspan="3"><strong><?= $tax_names[$key]; ?> @ <?= $tax_values[$key]; ?> % </strong><?= ($tax_description != '') ? '(' . $tax_description . ')' : ''; ?></td>
                              <td colspan="1" align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                           </tr>
                        <?php
                        }
                     }
                     foreach ($addtions_amounts as $key => $value) {
                        if ($value > 0) {
                           $addtions_description = $addtions_desc[$key];
                        ?>
                           <tr>
                              <td colspan="3"><strong><?= $addtions_names[$key]; ?></strong><?= ($addtions_description != '') ? '(' . $addtions_description . ')' : ''; ?></td>
                              <td colspan="1" align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                           </tr>
                     <?php
                        }
                     }
                     ?>
                     <tr>
                        <!-- <td colspan="4"></td> -->
                        <td colspan="3"><strong>Net Amount</strong></td>
                        <td colspan="1" align="right"><strong><?= number_format($net_amount, 2, '.', ''); ?></strong></td>
                     </tr>
                     <?php
                     if ($net_amount >= 0) {
                     ?>
                        <tr>
                           <td colspan="10">
                              <strong style="text-transform:capitalize;">Rupees : <?= no_to_words($net_amount); ?> Only.</strong>
                           </td>
                        </tr>
                     <?php
                     }
                     ?>

                     <tr>
                        <td colspan="10">
                           <?php
                           $invoice_dc = array();
                           foreach ($selected_dc as $key => $value) {
                              $invoice_dc[] = $this->m_masters->getmasterIDvalue('bud_yt_delivery', 'delivery_id', $value, 'dc_no');
                           }
                           ?>
                           <strong>OUR DC NO: <?= implode(",", $invoice_dc); ?></strong>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </section>
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