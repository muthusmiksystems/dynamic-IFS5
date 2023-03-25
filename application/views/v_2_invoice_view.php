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
            $prepared_by = $this->session->userdata('user_id');
            $invoice_details = $this->m_masters->getmasterdetails('bud_te_invoices', 'invoice_id', $invoice_id);
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
               $sub_total = explode(",", $row['sub_total']);
               $net_amount = $row['net_amount'];
               $lr_no = $row['lr_no'];
               $transport_name = $row['transport_name'];
               $remarks = $row['remarks']; //ER-08-18#-32
               $prepared_by = $row['prepared_by'];
            }

            $invoice_no_array = explode("/", $invoice_no);
            $ed = explode("-", $invoice_date);
            $invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

            $concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
            foreach ($concern_details as $row) {
               $concern_title = $row['concern_second_name'];
               $concern_prefix = $row['concern_prefix'];
               $concern_address = $row['concern_address'];
               $concern_gst = $row['concern_gst'];
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
                                 <td width="35%"></td>
                                 <td width="13%"></td>
                                 <td width="10%"></td>
                                 <td width="5%"></td>
                                 <td width="7%"></td>
                                 <td width="15%"></td>
                                 <td width="15%"></td>
                              </tr>
                              <?php
                              $invoice_title = '';
                              if (preg_match('/ESTIMATE|Estimate|estimate/', $concern_title)) {
                                 $invoice_title = 'ESTIMATE';
                              } else {
                                 $invoice_title = 'Invoice';
                              }
                              ?>
                              <tr class="first-row">
                                 <td colspan="9" align="center" style="text-align:center;">
                                    <h3 style="margin:0px;"><?= ($invoice_title == "ESTIMATE") ? $concern_title : 'Invoice'; ?></h3>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="3">
                                    <?php
                                    if ($invoice_title != "ESTIMATE") {
                                    ?>
                                       <strong>FROM:</strong><br />
                                       <strong style="font-size:14px;"><?= $concern_title; ?></strong><br />
                                       <?= $concern_address; ?><br>

                                       GST No: <?= $concern_gst; ?><br>
                                    <?php
                                    } else {
                                       $marketing_id = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_agent');
                                       $marketing_name = $this->m_masters->getmasterIDvalue('bud_users', 'ID', $marketing_id, 'display_name');
                                    ?>
                                       <strong style="font-size:14px;"><?= $marketing_name; ?></strong><br />
                                    <?php
                                    }
                                    ?>
                                 </td>
                                 <td colspan="6">
                                    <strong>TO:</strong><br />
                                    <strong style="text-transform:uppercase;font-size:14px;"><?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?></strong><br />
                                    <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_address'); ?><br />
                                    GST No : <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_gst'); ?>

                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="5">
                                    <strong style="font-size:18px;"><?php echo ($concern_title == "ESTIMATE") ? 'Estimate' : 'Invoice'; ?> No</strong>&emsp;
                                    <!-- <span> <strong style="font-size:18px;">:</strong> &emsp;<?= $invoice_no_array[0]; ?>/<strong style="font-size:24px;"><?= $invoice_no_array[1]; ?></strong></span> -->
                                    <span> <strong style="font-size:18px;">:</strong> &emsp;<?= isset($invoice_no_array[0]) ? $invoice_no_array[0] : ''; ?><strong style="font-size:24px;"><?= isset($invoice_no_array[1]) ? '/' . $invoice_no_array[1] : ''; ?></strong></span>
                                 </td>
                                 <td colspan="2"><strong>Date</strong></td>
                                 <td colspan="2"><strong><?= $invoice_date; ?></strong></td>
                              </tr>
                              <tr>
                                 <td><strong>Sno</strong></td>
                                 <td><strong>Art No</strong></td>
                                 <td><strong>Item Name</strong></td>
                                 <td><strong>HSN Code</strong></td>
                                 <td><strong># of Boxes</strong></td>
                                 <td align="right"><strong>Qty</strong></td>
                                 <td><strong>UOM</strong></td>
                                 <td align="right"><strong>Rate</strong></td>
                                 <td align="right"><strong>Amount</strong></td>
                              </tr>
                              <?php
                              $sno = 1;
                              $order_subtotal = 0;
                              $order_weight = 0;
                              $box_key = 0;
                              $total_boxes = 0;
                              $net_meters = 0;
                              $net_value = 0;
                              foreach ($invoice_items as $key => $value) {
                                 $item_name = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $value, 'item_name');
                                 $hsn_code = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $value, 'hsn_code');
                                 $total_meters = $item_weights[$key];

                                 $total_boxes += $no_of_boxes[$key];
                                 $net_meters += $total_meters;
                                 $amount = $total_meters * $item_rate[$key];
                                 $net_value += $amount;
                              ?>
                                 <tr>
                                    <td><?= $sno; ?></td>
                                    <td><?= $value; ?></td>
                                    <td>
                                       Art No: <strong><?= $value; ?></strong> -- <?= $item_name; ?>
                                    </td>
                                    <td>
                                       <strong><?= substr($hsn_code, 0, 4); ?>
                                    </td>
                                    <td><?= $no_of_boxes[$key]; ?></td>
                                    <td align="right"><?= $total_meters; ?></td>
                                    <td align="right"><?= $item_uoms[$key]; ?></td>
                                    <td align="right"><?= number_format($item_rate[$key], 2, '.', ''); ?></td>
                                    <td align="right"><?= number_format(($total_meters * $item_rate[$key]), 2, '.', ''); ?></td>
                                 </tr>
                              <?php
                                 $order_weight += $total_meters;
                                 $order_subtotal += $total_meters * $item_rate[$key];
                                 $sno++;
                              }
                              ?>
                              <tr>
                                 <td colspan="4" align="center"><strong>Grand Total &emsp; :</strong></td>
                                 <td><strong><?= $total_boxes; ?> Boxes</strong></td>
                                 <td align="right"><strong><?= $net_meters; ?></strong></td>
                                 <td></td>
                                 <td></td>
                                 <td align="right"><strong><?= number_format($net_value, 2, '.', ''); ?></strong></td>
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
                                    <strong><u>Spl. Instruction</u></strong><br /></strong>
                                    <!--ER-08-18#-32-->
                                    <strong><u>Remarks :</u></strong><?= $remarks ?><br />
                                    <!--end of ER-08-18#-32-->
                                    <?php
                                    $inv_gr_weight = $this->m_reports->get_invoic_gr_wt_te($selected_dc);
                                    ?>
                                    <p>Gross Weight: <strong><?= number_format($inv_gr_weight, 3, '.', ''); ?></strong></p>
                                    <p>
                                       <strong>Goods Sent through <?= $transport_name; ?> as per LRNO:<?= $lr_no; ?></strong>
                                    </p>
                                 </td>
                              </tr>
                              <?php
                              foreach ($deduction_amounts as $key => $value) {
                                 if ($value > 0) {
                                    $deduction_description = $deduction_desc[$key];
                                    $net_value = $net_value - $value;
                              ?>
                                    <tr>
                                       <td colspan="3"><strong><?= $deduction_names[$key]; ?></strong><?= ($deduction_description != '') ? '(' . $deduction_description . ')' : ''; ?></td>
                                       <td colspan="1" align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                    </tr>
                                 <?php
                                 }
                              }
                              error_reporting(E_ALL ^ E_NOTICE);
                              foreach ($addtions_amounts as $key => $value) {

                                 if ($value > 0) {
                                    $addtions_description = $addtions_desc[$key];
                                    $net_value = $net_value + $value;
                                 ?>
                                    <tr>
                                       <td colspan="3"><strong><?= $addtions_names[$key]; ?></strong><?= ($addtions_description != '') ? '(' . $addtions_description . ')' : ''; ?></td>
                                       <td colspan="1" align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                    </tr>
                              <?php
                                 }
                              }
                              $tmp = $net_value;
                              ?>
                              <tr>
                                 <td colspan="3"><strong> Sub Total</td>
                                 <td colspan="1" align="right"><strong><?= number_format($net_value, 2, '.', ''); ?></strong></td>
                              </tr>
                              <?php
                              foreach ($tax_amounts as $key => $value) {
                                 if ($value > 0) {
                                    $tax_description = $this->m_masters->getTaxDesc($tax_names[$key], $tax_values[$key]);
                                    $a = $tmp * ($tax_values[$key] / 100);
                                    $net_value = $net_value + $a;
                              ?>
                                    <tr>
                                       <td colspan="3"><strong><?= $tax_names[$key]; ?> @ <?= $tax_values[$key]; ?> % </strong><?= ($tax_description != '') ? '(' . $tax_description . ')' : ''; ?></td>
                                       <td colspan="1" align="right"><strong><?= number_format($a, 2, '.', ''); ?></strong></td>
                                    </tr>
                              <?php
                                 }
                              }

                              ?>
                              <tr>
                                 <!-- <td colspan="4"></td> -->
                                 <td colspan="3"><strong>Net Amount</strong></td>
                                 <td colspan="1" align="right"><strong><?= number_format(round($net_value), 2, '.', ''); ?></strong></td>
                              </tr>
                              <tr>
                                 <td colspan="9">
                                    <strong style="text-transform:capitalize;">Rupees : <?= no_to_words(round($net_value)); ?> Only.</strong>
                                 </td>
                              </tr>
                              <?php if ($concern_title != "ESTIMATE") : ?>
                                 <tr>
                                    <td colspan="9">
                                       <?php
                                       $invoice_dc = array();
                                       foreach ($selected_dc as $key => $value) {
                                          $invoice_dc[] = $this->m_masters->getmasterIDvalue('bud_te_delivery', 'delivery_id', $value, 'dc_no');
                                       }
                                       ?>
                                       <strong>OUR DC NO: <?= implode(",", $invoice_dc); ?></strong>
                                    </td>
                                 </tr>
                              <?php endif; ?>
                              <tr>
                                 <td colspan="9">
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
                                          Checked By
                                          <br />
                                          <br />
                                       </div>
                                       <div class="print-div right-align col-lg-3">
                                          <?php if ($concern_title != "ESTIMATE") : ?>
                                             <strong>For <?php echo $concern_title; ?>.</strong>
                                          <?php endif; ?>
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