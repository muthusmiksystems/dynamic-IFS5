<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="Legrand charles">
   <meta name="keyword" content="">
   <link rel="shortcut icon" href="img/favicon.html">
   <title><?= $page_title; ?></title>

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
            margin: 2.5mm;
         }

         .packing-register th {
            border: 1px solid #000 !important;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
         }

         .packing-register td {
            border: 1px solid #000 !important;
         }

         .borderless td,
         .borderless th {
            border-color: #FFFFFF !important;
         }

         .dataTables_filter {
            display: none;
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
            <div class="row screen-only hidden-print">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        <h3><i class=" icon-file"></i><?= $page_title; ?></h3>
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
                  /*if($this->session->flashdata('error'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-block alert-danger fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                           <i class="icon-remove"></i>
                           </button>
                           <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }*/
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
            <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?= base_url() ?>reports/poy_register_1">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <?= $page_title; ?>
                        </header>
                        <div class="panel-body">
                           <div class="form-group col-lg-2">
                              <label for="date">From Date</label>
                              <input class="form-control" type="date" value="<?= $f_date; ?>" id="date" name="f_date">
                           </div>
                           <div class="form-group col-lg-2">
                              <label for="date">To Date</label>
                              <input class="form-control " type="date" value="<?= $t_date; ?>" id="date" name="t_date">
                           </div>
                           <div class="form-group col-lg-2">
                              <label for="sales_to">Supplier Name</label>
                              <select class="select2 form-control customer" id="supplierCode" name="supplier_id">
                                 <option value="">Select Supplier Name</option>
                                 <?php
                                 foreach ($supplier as $row) {
                                 ?>
                                    <option value="<?= $row['sup_id']; ?>" <?= ($row['sup_id'] == $supplier_id) ? 'selected="selected"' : ''; ?>><?= $row['sup_name'] . '/' . $row['sup_id']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <?php /*
                           <div class="col-lg-2 form-group">
                              <label><strong>Item name: </strong></label>
                              <select class="select2 form-control item" id="itemName" name="item_id">
                                 <option value="">Select Item Name</option>
                                 <?php
                                 foreach ($items as $row) {
                                 ?>
                                    <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="col-lg-2 form-group">
                              <label><strong>Item Code: </strong></label>
                              <select class="select2 form-control item col-lg-3" id="itemCode" name="item_id">
                                 <option value="">Select Item Code</option>
                                 <?php
                                 foreach ($items as $row) {
                                 ?>
                                    <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_id']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           */ ?>
                           <div class="form-group col-lg-2">
                              <label for="sales_to"> POY Deniers</label>
                              <select class="select2 form-control" id="poyDenierId" name="poy_denier_id">
                                 <option value="">Select POY Denier</option>
                                 <?php
                                 foreach ($poy_deniers as $row) {
                                 ?>
                                    <option value="<?= $row['denier_id']; ?>" <?= ($row['denier_id'] == $poy_denier_id) ? 'selected="selected"' : ''; ?>><?= $row['denier_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-2">
                              <label for="sales_to"> POY Inward No</label>
                              <select class="select2 form-control" id="poyInwardNo" name="poy_inward_no">
                                 <option value="">Select POY Inward No</option>
                                 <?php
                                 foreach ($poy_inward as $row) {
                                 ?>
                                    <option value="<?= $row['po_no']; ?>" <?= ($row['po_no'] == $poy_inward_no) ? 'selected="selected"' : ''; ?>><?= $row['po_no']; ?></option>
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
            <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->
                  <section class="panel">
                     <header class="panel-heading">
                        Summary
                     </header>
                     <div class="panel-body">
                        <div align="right">
                           <strong>Printed staff : <?= $this->session->userdata('display_name'); ?> Print Date : <?= date("d-m-Y H:i:s"); ?></strong>
                        </div>
                        <h3 class="visible-print" align="center"><?= $page_title; ?></h3>
                        <?php
                        $gr_poy_qty = $this->m_mir->total_values(' bud_yt_poyinw_items', null, 'po_qty', null, null, null);
                        $tot_poy_qty = 0;
                        foreach ($poy_details as $row) {
                           $tot_poy_qty += $row['po_qty'];
                        }
                        if ($poy_details) {
                        ?>
                           <table class="tabletable table-bordered table-striped table-condensed packing-register datatable">
                              <thead>
                                 <tr>
                                    <th></th>
                                    <th class="text-danger">Grand Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-danger"><?= number_format($gr_poy_qty, 3) ?></th>
                                    <th></th>
                                    <th></th>
                                 </tr>
                                 <tr>
                                    <th></th>
                                    <th><strong>Total :</strong></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong><?= number_format($tot_poy_qty, 3) ?></strong></th>
                                    <th></th>
                                    <th></th>
                                 </tr>
                                 <tr>
                                    <th width="5%">Sno</th>
                                    <th width="10%">Inward Dt.</th>
                                    <th width="10%">POY Inward No </th>
                                    <th width="10%">Invoice No</th>
                                    <th width="15%">Inv. Date</th>
                                    <th width="15%">Supplier name</th>
                                    <th width="15%">POY Denier</th>
                                    <th width="15%">POY Quality</th>
                                    <th width="10%">POY Lot No.</th>
                                    <th width="10%">Current POY Lot No.</th>
                                    <th width="5%">Rate</th>
                                    <th width="5%">Qty</th>
                                    <th width="20%">Remarks</th>
                                    <th width="20%">Inward By</th>
                                 </tr>
                              </thead>
                              <tfoot>
                                 <tr>
                                    <th></th>
                                    <th><strong>Total :</strong></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong><?= number_format($tot_poy_qty, 3) ?></strong></th>
                                    <th></th>
                                    <th></th>
                                 </tr>
                              </tfoot>
                              <tbody>
                                 <?php
                                 $sno = 1;
                                 foreach ($poy_details as $row) {
                                 ?>
                                    <tr>
                                       <td><?= $sno; ?></td>
                                       <td><?= date('d-M-y H:i:s', strtotime($row['edate'])); ?></td>
                                       <td><?= $row['po_no']; ?></td>
                                       <td><?= $row['inward_invoice_no']; ?></td>
                                       <td><?= date('d-M-y', strtotime($row['inward_date'])); ?></td>
                                       <td><?= $row['sup_name'] . '/' . $row['supplier_id']; ?></td>
                                       <td><?= $row['denier_name']; ?></td>
                                       <td><?= $row['inward_quality']; ?></td>
                                       <td><?= $row['poy_lot']; ?></td>
                                       <td><?= @$row['poy_lot_no_current']; ?></td>
                                       <td><?= $row['po_item_rate']; ?></td>
                                       <td><?= number_format($row['po_qty'], 3); ?></td>
                                       <td><?= $row['remarks']; ?></td>
                                       <td><?= (@$row['euser'] != '') ? $row['euser'] : $row['display_name']; ?></td>
                                    </tr>
                                 <?php
                                    $sno++;
                                 }
                                 ?>
                              </tbody>
                           </table>
                           <hr>
                           <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
                        <?php
                        }
                        ?>
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
      //owl carousel
      $(document).ready(function() {
         $("#owl-demo").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true

         });
      });

      $('.datatable').dataTable({
         "sDom": "<'row'<'col-sm-6'f>r>",
         // "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
         "sPaginationType": "bootstrap",
         "bSort": true,
         "bPaginate": false,
         "oLanguage": {
            "sLengthMenu": "_MENU_ records per page",
            "oPaginate": {
               "sPrevious": "Prev",
               "sNext": "Next"
            }
         },
         "aoColumnDefs": [{
            'bSortable': true,
            'aTargets': [0]
         }]
      });
      jQuery('#example_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('#example_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

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

      $(".item").change(function() {
         $("#itemName").select2("val", $(this).val());
         $("#itemCode").select2("val", $(this).val());
         return false;
      });
   </script>
</body>

</html>