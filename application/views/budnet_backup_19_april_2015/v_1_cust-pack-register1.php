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
                        <h3><i class=" icon-file"></i> Customer wise Packing Register</h3>
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
            <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?= base_url() ?>reports/custPackRegister_1">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Packing Regsiter
                        </header>
                        <div class="panel-body">
                           <div class="form-group col-lg-3">
                              <label for="from_date">From</label>
                              <input type="text" value="" class="form-control dateplugin" id="from_date" name="from_date">
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="to_date">To</label>
                              <input type="text" value="" class="form-control dateplugin" id="to_date" name="to_date">
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="customer_name">Customer Name</label>
                              <select class="get_item_detail form-control select2" id="customer_name" name="customer_name">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($customers as $row) {
                                 ?>
                                    <option value="<?= $row['cust_id']; ?>" <?= ($row['cust_id'] == $cust_id) ? 'selected="selected"' : ''; ?>><?= $row['cust_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="customer_id">Customer Code</label>
                              <select class="get_item_detail form-control select2" id="customer_id" name="customer_id">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($customers as $row) {
                                 ?>
                                    <option value="<?= $row['cust_id']; ?>" <?= ($row['cust_id'] == $cust_id) ? 'selected="selected"' : ''; ?>><?= $row['cust_id']; ?></option>
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
            $result = $this->m_reports->getCustDelBoxes($cust_id);
            $boxes_array = array();
            foreach ($result as $row) {
               $boxes_array[] = explode(",", $row['delivery_boxes']);
            }

            $total_gr_wt = 0;
            $total_net_wt = 0;
            $total_cones = 0;
            $boxes_list = array();
            $invoice_items = array();
            $item_names_arr = array();
            $item_codes_arr = array();
            $item_shades_arr = array();
            $item_shade_code_arr = array();
            $gr_weights_arr = array();
            $nt_weights_arr = array();
            $no_cones_arr = array();

            foreach ($boxes_array as $key_1 => $value_1) {
               foreach ($value_1 as $key_2 => $box_no) {
                  $outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
                  foreach ($outerboxes as $outerbox) {
                     $no_of_cones = $outerbox['no_cones'];
                     $packing_gr_weight = $outerbox['gross_weight'];
                     $packing_net_weight = $outerbox['net_weight'];
                     $yarn_lot_no = $outerbox['lot_no'];
                     $item_name = $outerbox['item_name'];
                     $item_id = $outerbox['item_id'];
                     $boxes_list[$yarn_lot_no][$outerbox['box_id']] = $outerbox['box_prefix'] . $outerbox['box_no'];
                     $item_names_arr[$outerbox['box_id']] = $item_name;
                     $item_codes_arr[$outerbox['box_id']] = $item_id;
                     $item_shades_arr[$outerbox['box_id']] = $outerbox['shade_name'];
                     $item_shade_code_arr[$outerbox['box_id']] = $outerbox['shade_id'];
                     $gr_weights_arr[$outerbox['box_id']] = $packing_gr_weight;
                     $nt_weights_arr[$outerbox['box_id']] = $packing_net_weight;
                     $no_cones_arr[$outerbox['box_id']] = $no_of_cones;
                     $total_cones += $no_of_cones;
                     $total_gr_wt += $packing_gr_weight;
                     $total_net_wt += $packing_net_weight;
                     $invoice_items[] = $item_id;
                  }
               }
            }
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
                        <table id="example" class="table table-bordered table-striped table-condensed cf packing-register">
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
                                 <td></td>
                                 <td></td>
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
                                 $total_net_weight += $row['net_weight'];
                                 $total_gr_weight += $row['gross_weight'];
                              ?>
                                 <tr>
                                    <td><?= $sno; ?></td>
                                    <td><?= $row['box_prefix']; ?><?= $box_no; ?></td>
                                    <td><?= $row['item_name']; ?></td>
                                    <td><?= $row['item_id']; ?></td>
                                    <td><?= ($row['lot_no'] == 0) ? '' : $row['lot_no']; ?></td>
                                    <td><?= $row['shade_name']; ?></td>
                                    <td><?= $row['shade_id']; ?></td>
                                    <td><?= $row['gross_weight']; ?></td>
                                    <td><?= $row['net_weight']; ?></td>
                                    <td><?= $row['packed_date']; ?></td>
                                    <td><?= $row['packed_by']; ?></td>
                                 </tr>
                                 <?php
                                 if (isset($outerboxes[$key + 1]['lot_no'])) {
                                    if ($lot_no != $outerboxes[$key + 1]['lot_no']) {
                                 ?>
                                       <tr>
                                          <td colspan="7" align="center"><strong>Total</strong></td>
                                          <td><strong><?= $total_gr_weight; ?></strong></td>
                                          <td><strong><?= $total_net_weight; ?></strong></td>
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
                                       <td colspan="7" align="center"><strong>Total</strong></td>
                                       <td><strong><?= $total_gr_weight; ?></strong></td>
                                       <td><strong><?= $total_net_weight; ?></strong></td>
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
      //owl carousel
      $(document).ready(function() {

         /*$('#example').DataTable({
            "sDom": "<'row'<'col-sm-6 screen-only'l><'col-sm-6 screen-only'f>r>t<'row'<'col-sm-6 screen-only'i><'col-sm-6 screen-only'p>>",
               "sPaginationType": "bootstrap",
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
               }],
            // dom: 'T<"clear">lfrtip', 
            // tableTools: { "sSwfPath": "<?= base_url(); ?>themes/default/tabletools/swf/copy_csv_xls_pdf.swf" } 
            "sDom": 'T<"clear">lfrtip',
            "oTableTools": {
               "aButtons": [
                   // "copy",
                  "print",
                  {
                     "sExtends":    "collection",
                     "sButtonText": "Save",
                     "aButtons":    [ "csv", "xls", "pdf" ]
                  }
               ]
            }
         });*/


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

      $(".get_item_detail").change(function() {
         $("#customer_name").select2("val", $(this).val());
         $("#customer_id").select2("val", $(this).val());
         return false;
      });
   </script>
</body>

</html>