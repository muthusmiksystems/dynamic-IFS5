<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="Mosaddek">
   <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
   <link rel="shortcut icon" href="img/favicon.html">

   <title><?= $page_title; ?> | INDOFILA SYNTHETICS</title>

   <!-- Bootstrap core CSS -->
   <?php
   foreach ($css as $path) {
   ?>
      <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
   <?php
   }
   foreach ($css_print as $path) {
   ?>
      <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet" media="print">
   <?php
   }
   ?>




   <style type="text/css">
      .invoice-table tr td,
      .invoice-table tr th {
         font-weight: bold;
      }
   </style>
</head>

<body>

   <section id="container" class="">
      <!--header start-->
      <?php $this->load->view('html/v_header.php'); ?>
      <!--header end-->
      <!--sidebar start-->
      <?php $this->load->view('html/v_sidebar.php'); ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
            <!-- page start-->
            <div class="row">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        <h3><i class=" icon-file-text"></i> Invoice Preview</h3>
                     </header>
                  </section>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <?php
                  if ($this->session->flashdata('warning')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-warning fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  if ($this->session->flashdata('error')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-block alert-danger fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  if ($this->session->flashdata('success')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-success alert-block fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <h4>
                                 <i class="icon-ok-sign"></i>
                                 Success!
                              </h4>
                              <p><?= $this->session->flashdata('success'); ?></p>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  ?>
               </div>
            </div>
            <?php
            error_reporting(E_ALL ^ E_NOTICE);
            $sub_total = 0;
            $total_cones = 0;
            $total_gr_wt = 0;
            $total_net_wt = 0;
            $items_array = array();
            $boxes_array = array();
            $pre_delivery_list = array();
            $item_names_arr = array();
            $item_shades_arr = array();
            $item_codes_arr = array();
            $gr_weights_arr = array();
            $nt_weights_arr = array();
            $box_qty_array = array();
            $no_cones_arr = array();
            $rates_arr = array();
            $item_rate = array();
            $prepared_by = $this->session->userdata('user_id');
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
               $cust_pono = $row['cust_pono'];
               $remarks = $row['remarks']; //Inclusion of Remarks in invoices yt
               $prepared_by = $row['prepared_by'];
            }
            $invoice_no_array = explode("/", $invoice_no);
            $ed = explode("-", $invoice_date);
            $invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

            $concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
            foreach ($concern_details as $row) {
               $concern_title = $row['concern_second_name'];
               $concern_address = $row['concern_address'];
               $concern_tin = $row['concern_tin'];
               $concern_cst = $row['concern_cst'];
               $concern_gst=$row['concern_gst'];
            }

            foreach ($boxes_array as $key => $box_no) {
               // $outerboxes = $this->m_delivery->getPreDelItemsDetails($box_no);
               $outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
               /*echo "<pre>";
                     print_r($outerboxes);
                     echo "</pre>";*/
               foreach ($outerboxes as $outerbox) {

                  $inner_boxes = (array) json_decode($outerbox['inner_boxes']);
                  $packing_gr_weight = $outerbox['gross_weight'];
                  $packing_net_weight = $outerbox['net_weight'];
                  $yarn_lot_no = $outerbox['lot_no'];
                  if ($outerbox['box_prefix'] == 'TH' || $outerbox['box_prefix'] == 'TI') {
                     $no_of_cones = $outerbox['no_of_cones'];
                     $box_qty_array[$outerbox['box_id']] = $no_of_cones;
                     $item_name = '';
                     $item_id = '';
                     $shade_id = '';
                     $shade_name = '';
                     $shade_code = '';
                     if (count($inner_boxes) > 0) {
                        foreach ($inner_boxes as $inner_box) {
                           $item_id = $inner_box->item_id;
                           $shade_id = $inner_box->shade_id;
                           $item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $inner_box->item_id, 'item_name');
                           $shade = $this->m_masters->get_yt_shade($inner_box->shade_id);
                           if ($shade) {
                              $shade_name = $shade->shade_name;
                              $shade_code = $shade->shade_code;
                           }
                        }
                     } else {
                        $item_name = $outerbox['item_name'];
                        $item_id = $outerbox['item_id'];
                        $shade_id = $outerbox['shade_id'];
                        $shade_name = $outerbox['shade_name'];
                        $shade_code = $outerbox['shade_code'];
                     }
                  } else {
                     $no_of_cones = $outerbox['no_of_cones'];
                     $item_name = $outerbox['item_name'];
                     $item_id = $outerbox['item_id'];
                     $shade_id = $outerbox['shade_id'];
                     $shade_name = $outerbox['shade_name'];
                     $shade_code = $outerbox['shade_code'];
                     $box_qty_array[$outerbox['box_id']] = $packing_net_weight;
                  }


                  $yarn_lot_no = $outerbox['lot_no'];
                  if ($outerbox['box_prefix'] == 'G' || $outerbox['box_prefix'] == 'S') {
                     $lot_no = $outerbox['poy_lot_no'];
                  } else {
                     $lot_no = $outerbox['lot_no'];
                  }
                  $pre_delivery_list[$lot_no][$outerbox['box_id']] = $outerbox['box_prefix'] . $outerbox['box_no'];
                  $item_names_arr[$outerbox['box_id']] = $item_name . '/' . $item_id;
                  $item_id_arr[$outerbox['box_id']] =  $item_id;
                  $item_shades_arr[$outerbox['box_id']] = $shade_name . '/' . $shade_id;
                  $item_codes_arr[$outerbox['box_id']] = $shade_code;
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
                     <header class="panel-heading">
                        Invoice
                     </header>
                     <div class="panel-body">
                        <table class="table table-bordered table-striped table-condensed invoice-table">
                           <tbody>
                              <tr class="no-padding no-border">
                                 <td width="5%"></td>
                                 <td width="10%"></td>
                                 <td width="15%"></td>
                                 <td width="8%"></td>
                                 <td width="5%"></td>
                                 <td width="10%"></td>
                                 <td width="10%"></td>
                                 <td width="5%"></td>
                                 <td width="7%"></td>
                                 <td width="15%"></td>
                                 <td width="10%"></td>
                                 <td width="15%"></td>
                                 <td width=""></td>
                              </tr>
                              <tr class="first-row">
                                 <td colspan="13" align="right" style="text-align:right;">
                                    <strong><?= $copytype; ?></strong>
                                 </td>
                              </tr>
                              <tr class="first-row">
                                 <td colspan="13" align="center" style="text-align:center;">
                                    <h3 style="margin:0px;">Invoice</h3>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="6">
                                    <strong>FROM:</strong><br />
                                    <strong style="font-size:14px;"><?= $concern_title; ?></strong><br />
                                    <?= $concern_address; ?><br>

                                    GST: <?= $concern_gst; ?><br>
                                 </td>
                                 <td colspan="7">
                                    <strong>TO:</strong><br />
                                    <strong style="text-transform:uppercase;font-size:14px;"><?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?></strong><br />
                                    <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_address'); ?><br />
                                    GST : <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_gst'); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="6">
                                    <strong style="font-size:18px;">Invoice No</strong>&emsp;
                                    <!-- <span><strong style="font-size:18px;">:</strong> &emsp;<?= $invoice_no_array[0]; ?>/<strong style="font-size:24px;"><?= $invoice_no_array[1]; ?></strong></span> -->
                                    <span> <strong style="font-size:18px;">:</strong> &emsp;<?= isset($invoice_no_array[0]) ? $invoice_no_array[0] : ''; ?><strong style="font-size:24px;"><?= isset($invoice_no_array[1]) ? '/' . $invoice_no_array[1] : ''; ?></strong></span>
                                 </td>
                                 <td colspan="7" align="right"><strong>Date: <?= $invoice_date; ?></strong></td>
                              </tr>
                              <tr>
                                 <th>#</th>
                                 <th>Box No</th>
                                 <th>Item <br>Name/Code</th>
                                 <th>HSN Code</th>
                                 <th>Shade Name/Code</th>

                                 <th>Shade No</th>
                                 <th style="text-align:right;">Lot No</th>
                                 <th style="text-align:right;"># of Cones</th>
                                 <th style="text-align:right;">Gr. Weight</th>
                                 <th style="text-align:right;">Net Weight</th>
                                 <th style="text-align:right;">Lotwise Nt.Weight</th>
                                 <th align="right">Rate</th>
                                 <th align="right">Amount</th>
                              </tr>
                              <?php
                              $sno = 1;
                              $s_key = 1;
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
                                       <td style="width:2cm;">
                                          <?php
                                          $hsn = $this->m_masters->getmasterdetails('bud_items', 'item_id', $item_id_arr[$key_1]);
                                          foreach ($hsn as $h) {
                                             echo substr($h['hsn_code'], 0, 4);
                                          }
                                          ?>
                                       </td>
                                       <td><?= $item_shades_arr[$key_1]; ?></td>

                                       <td><?= $item_codes_arr[$key_1]; ?></td>
                                       <td align="right"><?= $key; ?></td>
                                       <td align="right"><?= $no_cones_arr[$key_1]; ?></td>
                                       <td align="right"><?= $gr_weights_arr[$key_1]; ?></td>
                                       <td align="right"><?= number_format($nt_weights_arr[$key_1], 3, '.', ''); ?></td>
                                       <?php
                                       if ($s_key == count($value)) {
                                          $s_key = 1;
                                       ?>
                                          <td align="right"><?php echo $lotwise_nt_weight; ?></td>
                                       <?php
                                       } else {
                                          $s_key++;
                                       ?>
                                          <td></td>
                                       <?php
                                       }
                                       ?>
                                       <td>
                                          <?= number_format($rates_arr[$key_1], 2, '.', ''); ?>
                                          <input type="hidden" name="item_rate[]" value="<?= $rates_arr[$key_1]; ?>">
                                       </td>
                                       <td><?= number_format($box_qty_array[$key_1] * $rates_arr[$key_1], 2, '.', ''); ?></td>
                                    </tr>
                                 <?php

                                    $sno++;
                                    $total_items++;
                                 }

                                 ?>
                                 <!-- <tr>
                                          <td colspan="9"></td>
                                          <td align="right"><?= $lotwise_nt_weight; ?></td>
                                          <td></td>
                                          <td></td>
                                       </tr> -->
                              <?php
                              }
                              ?>
                              <tr>
                                 <td colspan="5" align="center"><strong>Grand Total &emsp; :</strong></td>
                                 <td><strong><?= count($boxes_array); ?> Boxes</strong></td>
                                 <td></td>
                                 <td></td>
                                 <td align="right"><strong><?= $total_gr_wt; ?></strong></td>
                                 <td align="right"><strong><?= $total_net_wt; ?></strong></td>
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
                                 <td colspan="5" rowspan="<?= $rowspan + 2; ?>">
                                    <strong><u>Spl. Instruction</u></strong><br /></strong><br />
                                    <!--Inclusion of Remarks in invoices yt-->
                                    <p>
                                       <strong>Remarks : <?= $remarks; ?></strong>
                                    </p>
                                    <!--end of Inclusion of Remarks in invoices yt-->
                                    <p>
                                       <strong>Goods Sent through <?= $transport_name; ?> as per LRNO:<?= $lr_no; ?></strong> </p>
                                 </td>
                                 <td colspan="4" rowspan="<?= $rowspan + 2; ?>">
                                    <p>
                                       <strong>Customer PO No.: <?= @$cust_pono; ?></strong>
                                    </p>
                                 </td>
                              </tr>
                              <?php
                              $sub = 0;
                              foreach ($deduction_amounts as $key => $value) {
                                 if ($value > 0) {
                                    $sub = $sub + $value;
                                    $deduction_description = (isset($deduction_desc[$key])) ? $deduction_desc[$key] : '';
                                    // $deduction_description = $deduction_desc[$key];
                              ?>
                                    <tr>
                                       <td colspan="3"><strong><?= $deduction_names[$key]; ?></strong><?= ($deduction_description != '') ? '(' . $deduction_description . ')' : ''; ?></td>
                                       <td colspan="1" align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                    </tr>
                                 <?php
                                 }
                              }
                              $add = 0;
                              foreach ($addtions_amounts as $key => $value) {
                                 if ($value > 0) {
                                    $add = $add + $value;
                                    $addtions_description = (isset($addtions_desc[$key])) ? $addtions_desc[$key] : '';
                                    // $addtions_description = (isset($addtions_desc[$key]))?$addtions_desc[$key]:'';
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
                                 <td colspan="3"><strong>Sub total</strong></td>
                                 <td colspan="1" align="right"><strong><?php echo number_format((($sub_total + $add) - $sub), 2, '.', ''); ?></strong></td>
                              </tr>
                              <?php
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
                                    <td colspan="13">
                                       <strong style="text-transform:capitalize;">Rupees : <?= no_to_words($net_amount); ?> Only.</strong>
                                    </td>
                                 </tr>
                              <?php
                              }
                              ?>

                              <tr>
                                 <td colspan="13">
                                    <?php
                                    $invoice_dc = array();
                                    foreach ($selected_dc as $key => $value) {
                                       $invoice_dc[] = $this->m_masters->getmasterIDvalue('bud_yt_delivery', 'delivery_id', $value, 'dc_no');
                                    }
                                    ?>
                                    <strong>OUR DC NO: <?= implode(",", $invoice_dc); ?></strong>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="13">
                                    <div class="col-lg-12">
                                       <div class="print-div col-lg-3">
                                          <strong>Received By</strong>
                                          <br />
                                          <br />
                                       </div>
                                       <div class="print-div col-lg-3" style="border-right:none;">
                                          <strong>Prepared By</strong>
                                          <br />
                                          <br />
                                          <br />
                                          <br />
                                          <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $prepared_by, 'user_login'); ?>
                                       </div>
                                       <div class="print-div col-lg-3" style="border-right:none;">
                                          <strong>Checked By</strong>
                                          <br />
                                          <br />
                                       </div>
                                       <div class="print-div right-align col-lg-3">
                                          <strong>For <?php echo $concern_title; ?>.</strong>
                                          <br />
                                          <br />
                                          <br />
                                          <br />
                                          Auth.Signatury
                                       </div>
                                    </div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </section>
               </div>
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        <button class="btn btn-default" type="button" onclick="window.print()">Print</button>
                     </header>
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
            <div class="pageloader"></div>
            <!-- page end-->
         </section>
      </section>
      <!--main content end-->
   </section>

   <!-- js placed at the end of the document so the pages load faster -->
   <?php
   foreach ($js as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <!--common script for all pages-->
   <?php
   foreach ($js_common as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <!--script for this page-->
   <?php
   foreach ($js_thispage as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <script>
      //owl carousel
      $(document).ready(function() {
         $("#owl-demo").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true

         });
      });

      //custom select box
      $(function() {
         $('select.styled').customSelect();
      });

      $(document).ajaxStart(function() {
         $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
         $('.pageloader').hide();
      });
   </script>
</body>

</html>