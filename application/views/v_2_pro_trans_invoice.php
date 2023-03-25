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
      .no-padding th {
         padding-left: 0px !important;
         padding: 0px !important;
      }

      .no-border th {
         border-bottom: none;
         border: none !important;
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
                        <h3><i class=" icon-file-text"></i> Transport Invoice</h3>
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
            $invoice_details = $this->m_masters->getmasterdetails($table_name, 'invoice_id', $invoice_id);
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
               $lr_no = $row['lr_no'];
               $transport_name = $row['transport_name'];
               $remarks = $row['remarks']; //ER-08-18#-32
               $prepared_by = $row['prepared_by'];
            }
            $ed = explode("-", $invoice_date);
            $invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
            $items = array();
            $item_weights_array = array();
            $item_rate_array = array();
            $item_no_boxes = array();
            foreach ($invoice_items as $key => $value) {
               $item_group = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $value, 'item_group');

               $items[$item_group][] = $value;
               $item_weights_array[$value] = $item_weights[$key];
               $item_rate_array[$value] = $item_rate[$key];
               $item_no_boxes[$item_group][$value] = $no_of_boxes[$key];
            }

            $concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
            foreach ($concern_details as $row) {
               $concern_title = $row['concern_second_name'];
               $concern_address = $row['concern_address'];
               $concern_tin = $row['concern_tin'];
               $concern_gst = $row['concern_gst'];
            }
            ?>
            <div class="row">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        Invoice Details
                     </header>
                     <div class="panel-body">
                        <table style="border:none;" class="table table-bordered table-striped table-condensed">

                           <tbody>
                              <tr class="no-padding no-border;height:0px;">
                                 <td width="10" style="border-width:0px;"></td>
                                 <td width="30%" style="border-width:0px;"></td>
                                 <td width="20%" style="border-width:0px;"></td>
                                 <td width="20%" style="border-width:0px;"></td>
                                 <td width="20%" style="border-width:0px;"></td>
                              </tr>
                              <tr>
                                 <td colspan="9" align="center" style="text-align:center;">
                                    <h3>Transport Invoice</h3>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="3">
                                    <strong>FROM:</strong><br />
                                    <strong style="font-size:14px;"><?= $concern_title; ?></strong><br />
                                    <?= $concern_address; ?><br>
                                    GST NO: <?= $concern_gst; ?><br>

                                 </td>
                                 <td colspan="3">
                                    <strong>TO:</strong><br />
                                    <strong style="text-transform:uppercase;font-size:14px;"><?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?></strong><br />
                                    <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_address'); ?><br />
                                    GST No : <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_gst'); ?>

                                 </td>
                              </tr>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>

                                 <td><strong>Invoice No</strong></td>
                                 <td colspan="2"><strong><?= $invoice_no; ?></strong></td>
                              </tr>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>

                                 <td><strong>Date</strong></td>
                                 <td colspan="2"><strong><?= $invoice_date; ?></strong></td>
                              </tr>
                              <tr>
                                 <td><strong>Sno</strong></td>
                                 <td><strong>Item Name</strong></td>
                                 <td><strong>HSN Code</strong></td>
                                 <td><strong># of Boxes</strong></td>
                                 <td align="right"><strong>Qty</strong></td>
                                 <td align="right"><strong>Amount</strong></td>
                              </tr>
                              <?php
                              $sno = 1;
                              $order_weight = 0;
                              $total_boxes = 0;
                              $sub_total = 0;

                              foreach ($items as $group_key => $invoice_items) {
                                 // $total_boxes = 0;
                                 $total_amount = 0;
                                 $order_weight = 0;

                                 foreach ($invoice_items as $key => $value) {

                                    $group_name = $this->m_masters->getmasterIDvalue('bud_te_itemgroups', 'group_id', $group_key, 'group_name');
                                    $hsn = $this->m_masters->find_hsn($value);
                                    $order_weight += $item_weights_array[$value];
                                    $total_amount += $item_weights_array[$value] * $item_rate_array[$value];
                                 }
                                 $total_boxes += array_sum($item_no_boxes[$group_key]);
                                 $sub_total += $total_amount;

                              ?>
                                 <tr>
                                    <td><?= $sno; ?></td>
                                    <td>
                                       <?= $group_name; ?>
                                    </td>
                                    <td><?= substr($hsn[0]['hsn_code'], 0, 4); ?></td>
                                    <td><?= array_sum($item_no_boxes[$group_key]); ?></td>

                                    <td align="right"><?= number_format($order_weight, 2, '.', ''); ?></td>
                                    <td align="right"><?= number_format($total_amount, 2, '.', ''); ?></td>
                                 </tr>
                              <?php
                                 $sno++;
                              }

                              ?>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td><strong><?= $total_boxes; ?></strong></td>
                                 <td align="right"><strong>Sub Total</strong></td>
                                 <td align="right"><strong><?= number_format($sub_total, 2, '.', ''); ?></strong></td>
                              </tr>

                              <?php
                              foreach ($deduction_amounts as $key => $value) {
                                 if ($value > 0) {
                                    $sub_total = $sub_total - $value;
                              ?>
                                    <tr>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>

                                       <td><strong><?= $deduction_names[$key]; ?></strong></td>
                                       <td align="right" colspan="2"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                    </tr>
                                 <?php
                                 }
                              }
                              foreach ($addtions_amounts as $key => $value) {
                                 if ($value > 0) {
                                    $sub_total = $sub_total + $value;
                                 ?>
                                    <tr>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td><strong><?= $addtions_names[$key]; ?></strong></td>
                                       <td align="right"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
                                    </tr>
                              <?php
                                 }
                              }
                              $tmp = $sub_total;
                              ?>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td><strong> Sub Total</td>
                                 <td align="right"><strong><?= number_format($sub_total, 2, '.', ''); ?></strong></td>
                              </tr>
                              <?php
                              foreach ($tax_amounts as $key => $value) {
                                 if ($value > 0) {
                                    $tax_description = $this->m_masters->getTaxDesc($tax_names[$key], $tax_values[$key]);
                                    $a = $tmp * ($tax_values[$key] / 100);
                                    $sub_total = $sub_total + $a;
                              ?>
                                    <tr>

                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td><strong><?= $tax_names[$key]; ?> @ <?= $tax_values[$key]; ?> % </strong><?= ($tax_description != '') ? '(' . $tax_description . ')' : ''; ?></td>
                                       <td align="right"><strong><?= number_format($a, 2, '.', ''); ?></strong></td>
                                    </tr>
                              <?php
                                 }
                              }

                              ?>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td><strong>Net Amount</strong></td>
                                 <td align="right"><strong><?= number_format(round($sub_total), 2, '.', ''); ?></strong></td>
                              </tr>
                              <tr>
                                 <td colspan="6">
                                    <strong style="text-transform:capitalize;">Rupees : <?= no_to_words(round($sub_total)); ?> Only.</strong></br></br>
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
                              <tr>
                                 <td colspan="6">
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
                                          <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $prepared_by, 'user_login'); ?>
                                       </div>
                                       <div class="print-div col-lg-3" style="border-right:none;">
                                          Checked By
                                          <br />
                                          <br />
                                       </div>
                                       <div class="print-div right-align col-lg-3">
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