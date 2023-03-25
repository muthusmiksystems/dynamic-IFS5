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
      /*.packing-slip
         {
            width: 80%;
            page-break-before: always;
            page-break-after: always;
         }
         .packing-slip tr { 
            page-break-inside: avoid;
         }*/
      .packing-slip td {
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
            <div class="row screen-only">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        <h3><i class=" icon-file-text"></i> Packing Slip</h3>
                     </header>
                  </section>
               </div>
            </div>
            <div class="row screen-only">
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
            <div class="row screen-only">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        Print Packing Slip
                     </header>
                     <div class="panel-body">
                        <?php
                        $invoices = $this->m_masters->getallmaster('bud_te_invoices');
                        ?>
                        <div class="form-group col-lg-3">
                           <label for="invoice_id">Select Invoice ID</label>
                           <select class="form-control select2" id="invoice_id" name="invoice_id">
                              <option value="">Select Invoice</option>
                              <?php
                              foreach ($invoices as $invoice) {
                              ?>
                                 <option value="<?= $invoice['invoice_id']; ?>" <?= ($invoice['invoice_id'] == $this->uri->segment(3)) ? 'selected="selected"' : ''; ?>><?= $invoice['invoice_no']; ?></option>
                              <?php
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </section>
               </div>
            </div>
            <?php
            if ($this->uri->segment(3)) {
               $invoice_id = $this->uri->segment(3);
               $invoice_details = $this->m_masters->getmasterdetails('bud_te_invoices', 'invoice_id', $invoice_id);
               foreach ($invoice_details as $row) {
                  $invoice_date = $row['invoice_date'];
                  $customer = $row['customer'];
                  $invoice_no = $row['invoice_no'];
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
                  $lr_no = $row['lr_no'];
                  $transport_name = $row['transport_name'];
               }
               $ed = explode("-", $invoice_date);
               $invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
               $cust_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name');
               $packing_slip_items = array();
               $packing_innerbox_items = 0;
               $total_rolls = 0;
               $packing_gr_weight = 0;
               $packing_net_weight = 0;
               $total_meters = 0;
               foreach ($boxes_array as $key => $value) {
                  $outerboxes = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_no', $value);
                  foreach ($outerboxes as $row) {
                     $packing_innerbox_items = $row['packing_innerbox_items'];
                     $packing_type = $row['packing_type'];
                     $total_rolls = $row['total_rolls'];
                     $packing_gr_weight = $row['packing_gr_weight'];
                     if ($packing_type == 'qtywise') {
                        $packing_net_weight = '';
                     } else {
                        $packing_net_weight = number_format($row['packing_net_weight'], 2, '.', '');
                     }
                     $total_meters = $row['total_meters'];
                  }
                  $packing_slip_items[$packing_innerbox_items][$value]['bag_no'] = $value;
                  $packing_slip_items[$packing_innerbox_items][$value]['rolls'] = $total_rolls;
                  $packing_slip_items[$packing_innerbox_items][$value]['gr_weight'] = ($packing_gr_weight != '') ? $packing_gr_weight : '0.00';
                  $packing_slip_items[$packing_innerbox_items][$value]['nt_weight'] = ($packing_net_weight != '') ? $packing_net_weight : '';
                  $packing_slip_items[$packing_innerbox_items][$value]['tot_meters'] = ($total_meters != '') ? $total_meters : '0.00';
               }

               /*echo "<pre>";
                  print_r($invoice_items);
                  print_r($no_of_boxes);
                  print_r($boxes_array);
                  print_r($packing_slip_items);
                  echo "</pre>";*/
            ?>
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Packing Slip
                        </header>
                        <div class="panel-body">
                           <?php
                           $box_key = 0;
                           $sno = 1;
                           foreach ($packing_slip_items as $item_code => $item) {
                              $item_name = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item_code, 'item_name');
                           ?>
                              <table class="table table-bordered table-striped table-condensed packing-slip">
                                 <tr>
                                    <td class="heading-3" colspan="5" align="center">SHIVA TAPES PACKING SLIP</td>
                                    <td>Date : <?= $invoice_date; ?></td>
                                 </tr>
                                 <tr>
                                    <td colspan="5" align="center">Customer : <?= $cust_name; ?></td>
                                    <td>Packing Slip No : <?= $invoice_no; ?></td>
                                 </tr>
                                 <tr>
                                    <td class="heading-3" colspan="5" align="center"><?= $item_name; ?></td>
                                    <td>Invoice No : <?= $invoice_no; ?></td>
                                 </tr>
                                 <tr>
                                    <td class="heading-3">Sno</td>
                                    <td class="heading-3">Bag No</td>
                                    <td class="heading-3"># of Rolls</td>
                                    <td class="heading-3">Gr. Weight</td>
                                    <td class="heading-3">Net. Weight</td>
                                    <td class="heading-3">Total Meters</td>
                                 </tr>
                                 <?php
                                 $total_meters = 0;
                                 $total_net_weight = 0;
                                 $total_gr_weight = 0;
                                 $total_rolls = 0;
                                 // print_r($item);
                                 foreach ($item as $key => $row) {
                                    $total_rolls += $row['rolls'];
                                    $total_gr_weight += $row['gr_weight'];
                                    $total_net_weight += $row['nt_weight'];
                                    $total_meters += $row['tot_meters'];
                                 ?>
                                    <tr>
                                       <td><?= $sno; ?></td>
                                       <td><?= $row['bag_no']; ?></td>
                                       <td><?= $row['rolls']; ?></td>
                                       <td><?= number_format($row['gr_weight'], 2, '.', ''); ?></td>
                                       <td><?= $row['nt_weight']; ?></td>
                                       <td><?= number_format($row['tot_meters'], 2, '.', ''); ?></td>
                                    </tr>
                                 <?php
                                    $sno++;
                                 }
                                 ?>
                                 <tr>
                                    <td colspan="6" height="20"></td>
                                 </tr>
                                 <tr>
                                    <td class="heading-3">Total</td>
                                    <td><?= sizeof($item); ?></td>
                                    <td><?= $total_rolls; ?></td>
                                    <td><?= number_format($total_gr_weight, 2, '.', ''); ?></td>
                                    <td><?= number_format($total_net_weight, 2, '.', ''); ?></td>
                                    <td><?= number_format($total_meters, 2, '.', ''); ?></td>
                                 </tr>
                                 <?php /*
                                 <tr>
                                    <td colspan="6" align="center">
                                       <?php
                                       $one_mtr_weight = 0;
                                       $one_kg_weight = 0;
                                       $one_mtr_weight = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item_code, 'item_weight_mtr');
                                       if ($one_mtr_weight > 0) {
                                          $one_kg_weight = 1 / $one_mtr_weight;
                                       }
                                       ?>
                                       FOR YOUR REFERENCE 1 KGS OF TAPE = <?= round($one_kg_weight); ?> METER &#177; 1%.
                                    </td>
                                 </tr>
                                 */ ?>
                              </table>
                           <?php
                           }
                           ?> </div>
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
            }
            ?> <div class="pageloader"></div> <!-- page end-->
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
      $(function() {
         $("#invoice_id").change(function() {
            var invoice_id = $('#invoice_id').val();
            window.location = '<?= base_url() ?>sales/packing_slip_2/' + invoice_id;
         });
      });
   </script>
</body>

</html>