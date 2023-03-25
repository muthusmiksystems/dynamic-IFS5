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
      @media print {
         @page {
            margin: 3mm;
         }

         .table thead>tr>th,
         .table tbody>tr>th,
         .table tfoot>tr>th,
         .table thead>tr>td,
         .table tbody>tr>td,
         .table tfoot>tr>td {
            padding: 5px 10px;
            font-size: 13px;
         }
      }

      table tr td {
         font-weight: bold;
         font-size: 14px;
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
                        <h3><i class=" icon-file-text"></i> Print Recipe</h3>
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
            $recipe_id = $recipe->recipe_id;
            $date = date("d-m-Y g:i A", strtotime($recipe->date));
            $shade_name = $recipe->shade_name;
            $shade_id = $recipe->shade_id;
            $shade_code = $recipe->shade_code;
            $shade_chemicals = (array) json_decode($recipe->shade_chemicals);
            $shade_dyes = (array) json_decode($recipe->shade_dyes);
            $stage3 = (array) json_decode($recipe->stage3);
            $stage4 = (array) json_decode($recipe->stage4);
            $username = $recipe->username;
            $remarks = $recipe->remarks;
            $stage1_remarks = $recipe->stage1_remarks;
            $stage2_remarks = $recipe->stage2_remarks;
            $stage3_remarks = $recipe->stage3_remarks;
            $stage4_remarks = $recipe->stage4_remarks;

            $lot = $this->m_masters->get_lot_details($lot_id);

            $lot_no = '';
            $lot_qty = '0.000';
            $no_springs = '';
            $po_no = '';
            $item_name = '';
            if ($lot) {
               $lot_no = $lot->lot_no;
               $lot_qty = $lot->lot_qty;
               $no_springs = $lot->no_springs;
               $po_no = $lot->po_no;
               $item_name = $lot->item_name;
               $lot_value = $lot_qty / 100;
               $date = date("d-m-Y g:i A", strtotime($lot->lot_created_date));
            }

            $customer_name = '';
            if (!empty($po_no)) {
               $lot_customer = $this->m_masters->get_lot_customer($po_no);
               $customer_name = $lot_customer->cust_name;
            }

            /*echo "<pre>";
                  print_r($lot_customer);
                  echo "</pre>";*/
            ?>
            <div class="row">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        Recipe Details
                     </header>
                     <div class="panel-body">
                        <table class="table table-bordered table-striped table-condensed invoice-table">
                           <tbody>
                              <?php
                              if (!empty($lot_no)) {
                              ?>
                                 <tr>
                                    <td colspan="4" class="visible-print text-center">
                                       Dyeing Batch (Lot) Card
                                    </td>
                                 </tr>
                              <?php
                              } else {
                              ?>
                                 <tr>
                                    <td colspan="4" class="visible-print text-center">
                                       Recipe Details
                                    </td>
                                 </tr>
                              <?php
                              }

                              if (!empty($lot_no)) {
                              ?>
                                 <tr>
                                    <td colspan="4">Batch No: <strong><?= $lot_no; ?></strong></td>
                                 </tr>
                              <?php
                              }
                              ?>
                              <tr>
                                 <td colspan="2">Recipe No: <strong><?= $recipe_id; ?></strong></td>
                                 <td colspan="2" class="text-right">Date: <strong><?= $date; ?></strong></td>
                              </tr>
                              <tr>
                                 <td colspan="2">Denior: <strong><?= $item_name; ?></strong></td>
                                 <td colspan="2" class="text-right">Party: <strong><?= $customer_name; ?></strong></td>
                              </tr>
                              <tr>
                                 <td>Shade:</td>
                                 <td><strong><?= $shade_name; ?></strong></td>
                                 <td class="text-right">No of cheeses:</td>
                                 <td><strong><?= $no_springs; ?></strong></td>
                              </tr>
                              <tr>
                                 <td>Shade No:</td>
                                 <td><strong><?= $shade_code; ?></strong></td>
                                 <td class="text-right">Net Weight:</td>
                                 <td><?= number_format($lot_qty, 3, '.', ''); ?></td>
                              </tr>
                              <tr>
                                 <td colspan="2" width="50%">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th colspan="2" class="text-center">START NEW LOT & ADD CHEMICALS</th>
                                          </tr>
                                          <tr>
                                             <th>Chemical</th>
                                             <th>Value</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          if (isset($shade_chemicals) && count($shade_chemicals) > 0) {
                                             foreach ($shade_chemicals as $chemical) {
                                                if (!empty($chemical)) {
                                          ?>
                                                   <tr>
                                                      <td><?= $chemical->chemical_name; ?></td>
                                                      <?php
                                                      if ($lot_qty > 0) {
                                                      ?>
                                                         <td><?= number_format(($chemical->chemical_value * $lot_qty), 3, '.', ''); ?> Kg</td>
                                                      <?php
                                                      } else {
                                                      ?>
                                                         <td><?= $chemical->chemical_value; ?> <?= $chemical->chemical_uom_name; ?></td>
                                                      <?php
                                                      }
                                                      ?>
                                                   </tr>
                                          <?php
                                                }
                                             }
                                          }
                                          ?>
                                          <tr>
                                             <td colspan="2">Remarks: <?= $stage1_remarks; ?></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                                 <td colspan="2" width="50%">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th colspan="2" class="text-center">MAIN DYEING PROCESS</th>
                                          </tr>
                                          <tr>
                                             <th>Dyes</th>
                                             <th>Value</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          if (isset($shade_dyes) && count($shade_dyes) > 0) {
                                             foreach ($shade_dyes as $dyes) {
                                                if (!empty($dyes)) {
                                          ?>
                                                   <tr>
                                                      <td><?= $dyes->dyes_name; ?></td>
                                                      <?php
                                                      if ($lot_qty > 0) {
                                                      ?>
                                                         <td><?= number_format($dyes->dyes_value * $lot_qty, 5, '.', ''); ?> Kg</td>
                                                      <?php
                                                      } else {
                                                      ?>
                                                         <td><?= number_format((float) $dyes->dyes_value, 6, '.', ''); ?> <?= $dyes->dyes_uom_name; ?></td>
                                                      <?php
                                                      }
                                                      ?>
                                                   </tr>
                                          <?php
                                                }
                                             }
                                          }
                                          ?>
                                          <tr>
                                             <td colspan="2">Remarks: <?= $stage2_remarks; ?></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="2">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th colspan="2" class="text-center">R/C WASHING</th>
                                          </tr>
                                          <tr>
                                             <th>Dyes</th>
                                             <th>Value</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          if (isset($stage3) && count($stage3) > 0) {
                                             foreach ($stage3 as $dyes) {
                                                if (!empty($dyes)) {
                                          ?>
                                                   <tr>
                                                      <td><?= $dyes->dyes_name; ?></td>
                                                      <?php
                                                      if ($lot_qty > 0) {
                                                      ?>
                                                         <td><?= number_format($dyes->dyes_value * $lot_qty, 3, '.', ''); ?> Kg</td>
                                                      <?php
                                                      } else {
                                                      ?>
                                                         <td><?= $dyes->dyes_value; ?> <?= $dyes->dyes_uom_name; ?></td>
                                                      <?php
                                                      }
                                                      ?>
                                                   </tr>
                                          <?php
                                                }
                                             }
                                          }
                                          ?>
                                          <tr>
                                             <td colspan="2">Remarks: <?= $stage3_remarks; ?></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>

                                 <td colspan="2">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th colspan="2" class="text-center">ADD SOFTNER & FINAL WASHING</th>
                                          </tr>
                                          <tr>
                                             <th>Dyes</th>
                                             <th>Value</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          if (isset($stage4) && count($stage4) > 0) {
                                             foreach ($stage4 as $dyes) {
                                                if (!empty($dyes)) {
                                          ?>
                                                   <tr>
                                                      <td><?= $dyes->dyes_name; ?></td>
                                                      <?php
                                                      if ($lot_qty > 0) {
                                                      ?>
                                                         <td><?= number_format($dyes->dyes_value * $lot_qty, 3, '.', ''); ?> Kg</td>
                                                      <?php
                                                      } else {
                                                      ?>
                                                         <td><?= $dyes->dyes_value; ?> <?= $dyes->dyes_uom_name; ?></td>
                                                      <?php
                                                      }
                                                      ?>
                                                   </tr>
                                          <?php
                                                }
                                             }
                                          }
                                          ?>
                                          <tr>
                                             <td colspan="2">Remarks: <?= $stage4_remarks; ?></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="4">
                                    <strong>Remarks: </strong><?= $remarks; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="4" valign="bottom">
                                    <table class="no-border" width="100%">
                                       <tr>
                                          <td class="text-center borderless" valign="bottom">
                                             <br>
                                             Operator Name
                                          </td>
                                          <td class="text-center">
                                             <?= $this->session->userdata('display_name'); ?><br>
                                             Prepared by
                                          </td>
                                          <td class="text-center" valign="bottom">
                                             <br>
                                             Auth.Sign
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="2">Batch Start Time: </td>
                                 <td>Batch End Time: </td>
                                 <td>Total Time: </td>
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