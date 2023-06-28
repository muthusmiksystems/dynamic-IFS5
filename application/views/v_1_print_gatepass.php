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
                        <h3><i class=" icon-file-text"></i> Gatepass</h3>
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
            $gr_weights_arr = array();
            $nt_weights_arr = array();
            $no_cones_arr = array();
            $rates_arr = array();
            $prepared_by = $this->session->userdata('user_id');
            $invoice_details = $this->m_masters->getmasterdetails($table_name, 'invoice_id', $invoice_id);
            foreach ($invoice_details as $row) {
               $concern_name = $row['concern_name'];
               $invoice_no = $row['invoice_no'];
               $invoice_id = $row['invoice_id'];
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
               $prepared_by = $row['prepared_by'];
            }
            $invoice_no_array = explode("/", $invoice_no);
            $ed = explode("-", $invoice_date);
            $invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

            $concern_title = '';
            $concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
            foreach ($concern_details as $row) {
               $concern_title = $row['concern_name'];
               $concern_address = $row['concern_address'];
               $concern_tin = $row['concern_tin'];
               $concern_cst = $row['concern_cst'];
            }

            $allowed_boxes = array();
            foreach ($boxes_array as $key => $box_no) {
               // $outerboxes = $this->m_delivery->getPreDelItemsDetails($box_no);
               $outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
               foreach ($outerboxes as $outerbox) {
                  $allowed_boxes[] = $outerbox['box_prefix'] . $outerbox['box_no'];
                  $no_of_cones = $outerbox['no_of_cones'];
                  $packing_gr_weight = $outerbox['gross_weight'];
                  $packing_net_weight = $outerbox['net_weight'];
                  $yarn_lot_no = $outerbox['lot_no'];
                  $item_name = $outerbox['item_name'];
                  $item_id = $outerbox['item_id'];

                  if ($outerbox['box_prefix'] == 'G' || $outerbox['box_prefix'] == 'S') {
                     $lot_no = $outerbox['poy_lot_no'];
                  } else {
                     $lot_no = $outerbox['lot_no'];
                  }

                  $pre_delivery_list[$lot_no][$outerbox['box_id']] = $outerbox['box_prefix'] . $outerbox['box_no'];
                  $item_names_arr[$outerbox['box_id']] = $item_name . '/' . $item_id;
                  $gr_weights_arr[$outerbox['box_id']] = $packing_gr_weight;
                  $item_id_arr[$outerbox['box_id']] =  $item_id;
                  $nt_weights_arr[$outerbox['box_id']] = $packing_net_weight;
                  $no_cones_arr[$outerbox['box_id']] = $no_of_cones;
                  $total_cones += $no_of_cones;
                  $total_gr_wt += $packing_gr_weight;
                  $total_net_wt += $packing_net_weight;
                  $invoice_items[] = $item_id;
                  $rates_arr[$box_no] = (isset($item_rate[$key])) ? $item_rate[$key] : 12;
               }
            }
            $invoice_dc = array();
            foreach ($selected_dc as $key => $value) {
               $invoice_dc[] = $this->m_masters->getmasterIDvalue('bud_yt_delivery', 'delivery_id', $value, 'dc_no');
            }
            ?>
            <div class="row">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        Gatepass Details
                     </header>
                     <div class="panel-body">
                        <table style="border:none;" class="table table-bordered table-striped table-condensed">
                           <tbody>
                              <tr>
                                 <td width="5%" style="padding:0px;"></td>
                                 <td width="10%" style="padding:0px;"></td>
                                 <td width="20%" style="padding:0px;"></td>
                                 <td width="13%" style="padding:0px;"></td>
                                 <td width="10%" style="padding:0px;"></td>
                                 <td width="5%" style="padding:0px;"></td>
                                 <td width="7%" style="padding:0px;"></td>
                                 <td width="15%" style="padding:0px;"></td>
                                 <td width="10%" style="padding:0px;"></td>
                                 <td width="15%" style="padding:0px;"></td>
                                 <td width="5%" style="padding:0px;"></td>
                              </tr>
                              <tr class="first-row">
                                 <td colspan="11" align="center" style="text-align:center;">
                                    <h3 style="margin:0px;">Gate Pass</h3>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="2">Gate Pass No</td>
                                 <td colspan="3"><strong style="font-size: 15px;"><?= $invoice_id; ?> - dt. <?= date("d-m-Y H:i:s"); ?></strong></td>
                                 <td colspan="2">Invoice No</td>
                                 <td colspan="4"><strong style="font-size: 15px;"><?= $invoice_no; ?></strong></td>
                              </tr>
                              <tr>
                                 <td colspan="2">Customer Code</td>
                                 <td colspan="3"><?= $customer; ?></td>
                                 <td colspan="2">DC No</td>
                                 <td colspan="4"><?= implode(", ", $invoice_dc); ?></td>
                              </tr>
                              <tr>
                                 <th>#</th>
                                 <th style="text-align:center;">Box No</th>
                                 <th>Item Name/Code</th>
                                 <th>HSN code</th>
                                 <th style="text-align:right;">Lot No</th>
                                 <th style="text-align:right;"># of Units</th>
                                 <th style="text-align:right;">Uom</th>
                                 <th style="text-align:right;" colspan="2">Gr. Weight</th>
                                 <th style="text-align:right;" colspan="2">Lotwise Nt.Weight</th>
                              </tr>
                              <?php
                              $sno = 1;
                              $s_key = 1;
                              $total_items = 0;
                              foreach ($pre_delivery_list as $key => $value) {
                                 $total_conest = 0;
                                 $lotwise_nt_weight = 0;
                                 $lotwise_gr_weight = 0;
                                 $lotwise_amt = 0;
                                 foreach ($value as $key_1 => $value_1) {
                                    $total_cones += $no_cones_arr[$key_1];
                                    $total_conest += $no_cones_arr[$key_1];
                                    $lotwise_nt_weight += $nt_weights_arr[$key_1];
                                    $lotwise_gr_weight += $gr_weights_arr[$key_1];
                                    $lotwise_amt += ($box_qty_array[$key_1] * $rates_arr[$key_1]);

                                    $tcon = '';
                                    $tlw = '';
                                    $tkey = '';
                                    $tlgw = '';
                                    $tamt = '';
                                    if ($s_key == count($value)) {
                                       $tkey = $s_key;
                                       $s_key = 1;
                                       $tcon = $total_conest;
                                       $tlw = $lotwise_nt_weight;
                                       $tlgw = $lotwise_gr_weight;
                                       $tamt = $lotwise_amt;
                                    } else {
                                       $s_key++;
                                       continue;
                                    }

                                    $item_id = explode('/', $item_names_arr[$key_1]);

                                    if (!empty($item_id)) {
                                        $item_uom = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item_id[1], 'item_uom');
                                        $uom_name = $this->m_masters->get_uom('bud_uoms', $item_uom, 'uom_name');
                                        
                                        
                                    } else {
                                       $item_uom='';
                                       $uom_name='';
                                    }
                              ?>
                                    <tr>
                                       <td><?= $sno; ?></td>
                                       <td align="center"><?= $tkey; ?></td>
                                       <td><?= $item_names_arr[$key_1]; ?></td>
                                       <td style="width:2cm;">
                                          <?php
                                          $hsn = $this->m_masters->getmasterdetails('bud_items', 'item_id', $item_id_arr[$key_1]);
                                          foreach ($hsn as $h) {
                                             echo substr($h['hsn_code'], 0, 4);
                                          }
                                          ?>
                                       </td>
                                       <td align="right"><?= $key; ?></td>
                                       <td align="right"><?= $tcon; ?></td>
                                       <td align="right"><?= $uom_name; ?></td>
                                       <td align="right" colspan="2"><?= $tlgw; ?></td>
                                       <td align="right" colspan="2"><?= $tlw; ?></td>
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
                                 <td colspan="2">Boxes Allowed <span style="font-size: 24px; font-weight: bold;">[<?= count($allowed_boxes); ?>]</span></td>
                                 <td colspan="9"><strong style="font-size:24px;"><?= implode(", ", $allowed_boxes); ?></strong></td>
                              </tr>
                              <tr>
                                 <td colspan="11">
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
                                          <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $prepared_by, 'user_login'); ?>
                                       </div>
                                       <div class="print-div col-lg-3" style="border-right:none;">
                                          Checked By
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
                                       <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $prepared_by, 'user_login'); ?>
                                    </div>
                                    <div class="print-div col-lg-3" style="border-right:none;">
                                       Checked By
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