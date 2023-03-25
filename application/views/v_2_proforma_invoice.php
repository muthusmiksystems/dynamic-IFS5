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
            $invoice_details = $this->m_masters->getmasterdetails('bud_te_proforma_invoices', 'invoice_id', $invoice_id);
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
               $tax_names = explode(",", $row['tax_names']);
               $tax_values = explode(",", $row['tax_values']);
               $tax_amounts = explode(",", $row['tax_amounts']);
               $deduction_names = explode(",", $row['deduction_names']);
               $deduction_values = explode(",", $row['deduction_values']);
               $deduction_amounts = explode(",", $row['deduction_amounts']);
               $sub_total = explode(",", $row['sub_total']);
               $net_amount = $row['net_amount'];
            }
            $ed = explode("-", $invoice_date);
            $invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
            $concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
            foreach ($concern_details as $row) {
               $concern_title = $row['concern_name'];
               $concern_address = $row['concern_address'];
               $concern_tin = $row['concern_tin'];
               $concern_cst = $row['concern_cst'];
            }
            ?>
            <div class="row">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        Proforma Invoice
                     </header>
                     <div class="panel-body">
                        <table style="border:none;" class="table table-bordered table-striped table-condensed">
                           <tbody>
                              <tr class="no-padding no-border">
                                 <td width="5%"></td>
                                 <td width="10%"></td>
                                 <td width="35%"></td>
                                 <td width="10%"></td>
                                 <td width="10%"></td>
                                 <td width="10%"></td>
                                 <td width="10%"></td>
                                 <td width="10%"></td>
                              </tr>
                              <tr>
                                 <td colspan="8" align="center" style="text-align:center;">
                                    <h3>Proforma Invoice</h3>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="3">
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
                                 <td colspan="3"></td>
                                 <td colspan="2"><strong>Proforma Invoice No</strong></td>
                                 <td colspan="3"><strong><?= $invoice_id; ?></strong></td>
                              </tr>
                              <tr>
                                 <td colspan="3"></td>
                                 <td colspan="2"><strong>Date</strong></td>
                                 <td colspan="3"><strong><?= $invoice_date; ?></strong></td>
                              </tr>
                              <tr>
                                 <td><strong>Sno</strong></td>
                                 <td><strong>Art No</strong></td>
                                 <td><strong>Item Name</strong></td>
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
                              $total_boxes = 0;
                              foreach ($invoice_items as $key => $value) {
                                 $item_name = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $value, 'item_name');
                              ?>
                                 <tr>
                                    <td><?= $sno; ?></td>
                                    <td><?= $value; ?></td>
                                    <td>
                                       <?= $item_name; ?>
                                    </td>
                                    <td><?= $no_of_boxes[$key]; ?></td>
                                    <td align="right"><?= number_format($item_weights[$key], 2, '.', ''); ?></td>
                                    <td><?= $item_uoms[$key]; ?></td>
                                    <td align="right"><?= number_format($item_rate[$key], 2, '.', ''); ?></td>
                                    <td align="right"><?= number_format(($item_weights[$key] * $item_rate[$key]), 2, '.', ''); ?></td>
                                 </tr>
                              <?php
                                 $total_boxes += $no_of_boxes[$key];
                                 $order_weight += $item_weights[$key];
                                 $order_subtotal += $item_weights[$key] * $item_rate[$key];
                                 $sno++;
                              }
                              ?>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td align="right"><strong><?= number_format($order_weight, 2, '.', ''); ?></strong></td>
                                 <td></td>
                                 <td></td>
                                 <td align="right"><strong><?= number_format($order_subtotal, 2, '.', ''); ?></strong></td>
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
                                 <td colspan="4" rowspan="<?= $rowspan + 1; ?>">
                                    <strong><u>Spl. Instruction</u></strong><br /></strong>
                                 </td>
                              </tr>
                              <?php
                              foreach ($deduction_amounts as $key => $value) {
                                 if ($value > 0) {
                              ?>
                                    <tr>
                                       <td colspan="3"><strong><?= $deduction_names[$key]; ?></strong></td>
                                       <td colspan="1" align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                    </tr>
                                 <?php
                                 }
                              }
                              foreach ($tax_amounts as $key => $value) {
                                 if ($value > 0) {
                                 ?>
                                    <tr>
                                       <td colspan="3"><strong><?= $tax_names[$key]; ?></strong></td>
                                       <td colspan="1" align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                    </tr>
                                 <?php
                                 }
                              }
                              foreach ($addtions_amounts as $key => $value) {
                                 if ($value > 0) {
                                 ?>
                                    <tr>
                                       <td colspan="3"><strong><?= $addtions_names[$key]; ?></strong></td>
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
                              <tr>
                                 <td colspan="8">
                                    <strong>OUR DC NO: <?= implode(",", $selected_dc); ?></strong>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="8">
                                    <strong style="text-transform:capitalize;"><?= no_to_words($net_amount); ?> Only.</strong>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="8">
                                    <div class="col-lg-12">
                                       <div class="col-lg-3">
                                          <strong>Received By</strong>
                                          <br />
                                          <br />
                                       </div>
                                       <div class="col-lg-3" style="border-right:none;">
                                          <strong>Prepared By</strong>
                                          <br />
                                          <br />
                                       </div>
                                       <div class="col-lg-3" style="border-right:none;">
                                          Checked By
                                          <br />
                                          <br />
                                       </div>
                                       <div class="col-lg-3" align="right">
                                          <strong>For SHIVA TAPES.</strong>
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