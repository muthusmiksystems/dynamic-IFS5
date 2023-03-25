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
         .packing-register th {
            border: 1px solid #000 !important;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
         }

         .packing-register td {
            border: 1px solid #000 !important;
         }

         .screen_only {
            display: none;
         }
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
                        <h3><i class=" icon-file"></i> Packing Register</h3>
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
            <?php
            $items = $this->m_masters->getactivemaster('bud_items', 'item_status');
            $item_name = null;
            ?>
            <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?= base_url() ?>reports/packingRegister_1">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Packing Regsiter
                        </header>
                        <div class="panel-body">
                           <div class="form-group col-lg-3">
                              <label for="from_date">From</label>
                              <input type="text" value="<?= $f_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="to_date">To</label>
                              <input type="text" value="<?= $t_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="item_name">Item Name</label>
                              <select class="get_item_detail form-control select2" id="item_name" name="item_name">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($items as $row) {
                                 ?>
                                    <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item) ? 'selected="selected"' : ''; ?>><?= $row['item_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="item_code">Item Code</label>
                              <select class="get_item_detail form-control select2" id="item_code" name="item_code">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($items as $row) {
                                 ?>
                                    <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item) ? 'selected="selected"' : ''; ?>><?= $row['item_id']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div style="clear:both;"></div>
                           <div class="form-group col-lg-3">
                              <label>&nbsp;</label>
                              <button class="btn btn-danger" type="submit" name="search">Search</button>
                           </div>
                        </div>
                     </section>
                  </div>
               </div>
            </form>

            <?php
            /*echo "<pre>";
               print_r($outerboxes);
               echo "</pre>";*/
            ?>
            <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->
                  <section class="panel">
                     <header class="panel-heading">
                        Summery
                     </header>
                     <div class="panel-body">
                        <?php
                        $total_boxes = 0;
                        $net_gr_weight = 0;
                        $net_weight = 0;
                        $net_meters = 0;
                        foreach ($outerboxes as $row) {
                           $net_gr_weight += $row['gross_weight'];
                           $net_weight += $row['net_weight'];
                           $total_boxes++;
                        }
                        ?>
                        <table id="example" class="table datatable table-bordered table-condensed cf packing-register">
                           <thead>
                              <tr>
                                 <th></th>
                                 <th><?= $total_boxes; ?> Boxes</th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th><?= number_format($net_gr_weight, 3, '.', ''); ?></th>
                                 <th><?= number_format($net_weight, 3, '.', ''); ?></th>
                                 <th></th>
                                 <!--ER-08-18#-26-->
                                 <th></th>
                                 <th></th>
                                 <!-- <th class="screen_only"></th> -->
                              </tr>
                              <tr>
                                 <th>#</th>
                                 <th>Box No</th>
                                 <th>Item Name</th>
                                 <th>Item Code</th>
                                 <th>Lot No</th>
                                 <th>Color</th>
                                 <th>Color Code</th>
                                 <th>Gr.Weight</th>
                                 <th>Nt. Weight</th>
                                 <th>Prod. Date</th>
                                 <!--ER-08-18#-26-->
                                 <th>Packing Date</th>
                                 <th>Packed by</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $sno = 1;
                              $total_net_weight = 0;
                              $total_gr_weight = 0;
                              foreach ($outerboxes as $key => $row) {
                                 $one_mtr_weight = 0;
                                 $box_no = $row['box_no'];
                                 $lot_no = $row['lot_no'];
                                 $net_weight = number_format($row['net_weight'], 3, '.', '');
                                 $gross_weight = number_format($row['gross_weight'], 3, '.', '');
                                 $total_net_weight += $net_weight;
                                 $total_gr_weight += $gross_weight;

                                 $tyarn_lot_id = '';
                                 if ($row['yarn_lot_id'] != '') {
                                    $arr = explode('**', $row['yarn_lot_id']);
                                    if (is_array($arr)) {
                                       $tyarn_lot_id = 'CL' . @$arr[0];
                                    }
                                 } else if ($row['lot_no'] != '') {
                                    $tyarn_lot_id = $row['lot_no'];
                                 }

                              ?>
                                 <tr>
                                    <td><?= $sno; ?></td>
                                    <td><?= $row['box_prefix']; ?><?= $box_no; ?></td>
                                    <td><?= $row['item_name']; ?></td>
                                    <td><?= $row['item_id']; ?></td>
                                    <td><?= ($tyarn_lot_id != '') ? $tyarn_lot_id : '#'; ?></td>
                                    <td><?= $row['shade_name']; ?> / <?= $row['shade_id']; ?></td>
                                    <td><?= $row['shade_code']; ?></td>
                                    <td><?= $gross_weight; ?></td>
                                    <td><?= $net_weight; ?></td>
                                    <td><?= ($row['prod_date'] != '0000-00-00') ? date('d-M-y', strtotime($row['prod_date'])) : ''; ?></td>
                                    <!--ER-08-18#-26-->
                                    <td><?= date('d-M-y h:i a', strtotime($row['packed_date'])); ?></td>
                                    <td><?= $row['packed_by']; ?></td>
                                 </tr>
                                 <?php
                                 if (isset($outerboxes[$key + 1]['lot_no'])) {
                                    if ($lot_no != $outerboxes[$key + 1]['lot_no']) {
                                 ?>
                                       <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td align="center"><strong>Total</strong></td>
                                          <td><strong><?= $total_gr_weight; ?></strong></td>
                                          <td><strong><?= $total_net_weight; ?></strong></td>
                                          <td></td>
                                          <!--ER-08-18#-26-->
                                          <td></td>
                                          <td></td>
                                       </tr>
                                    <?php
                                       $total_net_weight = 0;
                                       $total_gr_weight = 0;
                                    }
                                 } else {
                                    ?>
                                    <tr>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td align="center"><strong>Total</strong></td>
                                       <td><strong><?= $total_gr_weight; ?></strong></td>
                                       <td><strong><?= $total_net_weight; ?></strong></td>
                                       <td></td>
                                       <!--ER-08-18#-26-->
                                       <td></td>
                                       <td></td>
                                    </tr>
                              <?php
                                    $total_net_weight = 0;
                                    $total_gr_weight = 0;
                                 }
                                 $sno++;
                              }
                              ?>
                           </tbody>
                        </table>
                        <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
                     </div>
                  </section>
                  <!-- End Talbe List  -->
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
      $(".get_item_detail").change(function() {
         $("#item_name").select2("val", $(this).val());
         $("#item_code").select2("val", $(this).val());
         return false;
      });

      //owl carousel
      $(document).ready(function() {

         $('.datatable').dataTable({
            // "sDom": "<'row'<'col-sm-6'f>r>",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "bSort": false,
            "bPaginate": false,
            "oLanguage": {
               "sLengthMenu": "_MENU_ records per page",
               "oPaginate": {
                  "sPrevious": "Prev",
                  "sNext": "Next"
               }
            },
            "aoColumnDefs": [{
               'bSortable': false,
               'aTargets': [0]
            }]
         });
         jQuery('#example_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
         jQuery('#example_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown


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