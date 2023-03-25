<!DOCTYPE html>
<!--//ER-09-18#-63-->
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
            <div class="row screen-only">
               <section class="panel">
                  <header class="panel-heading">
                     <h3><i class=" icon-file"></i><?= $page_title; ?>
                  </header>
               </section>
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
            <div class="section">
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?= base_url() ?>registers/box_status_yt">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">
                           <header class="panel-heading">
                              <strong>Box Status Shop</strong>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label>Box Prefix</label>
                                 <input type="text" value="<?= $box_prefix; ?>" class="form-control" name="box_prefix">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label>Box No</label>
                                 <input type="text" value="<?= $box_no; ?>" class="form-control" name="box_no">
                              </div>

                              <div class="form-group col-lg-3">
                                 <label>From Box No:</label>
                                 <input type="text" value="<?= $f_box_no; ?>" class="form-control" name="from_box_no">
                              </div>

                              <div class="form-group col-lg-3">
                                 <label>To Box No:</label>
                                 <input type="text" value="<?= $t_box_no; ?>" class="form-control" name="to_box_no">
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
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <section class="panel">
                     <div class="panel-body" id="transfer_dc">

                        <?php if (sizeof($box_detail) > 0) { ?>
                           <table class="table table-bordered dataTables">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Box no</th>
                                    <th>Packed Date</th>
                                    <th>Packed by</th>
                                    <th>Remarks</th>
                                    <th>Item Name</th>
                                    <th>Shade Code</th>
                                    <th>Lot No</th>
                                    <th>Packed Qty</th>
                                    <th>Deleted Status</th>
                                    <th>Transit</th>
                                    <th>Pre DC </th>
                                    <th>DC </th>
                                    <th>Invoice </th>
                                 </tr>
                              </thead>
                              <?php
                              $sno = 1;
                              ?>
                              <tbody>
                                 <?php foreach ($box_detail as $box) : ?>
                                    <?php

                                    $box_status = $this->m_registers->get_status_details_yt($box->box_id);
                                    if (($box_status['pdc_no'] == '') && ($box->predelivery_status == 0)) {
                                       $box_status['pdc_no'] = 'PDC Before 31march 2018';
                                    }
                                    if (($box_status['dc_no'] == '') && ($box->delivery_status == 0)) {
                                       $box_status['dc_no'] = 'DC Before 31march 2018';
                                    }
                                    $is_deleted = '';
                                    $is_deleted = ($box->is_deleted) ? 'Deleted by ' . $box->deleted_by . ' on ' . date('d-M-y', strtotime($box->deleted_time)) : '';

                                    $tyarn_lot_id = '';
                                    if ($box->yarn_lot_id != '') {
                                       $arr = explode('**', $box->yarn_lot_id);
                                       if (is_array($arr)) {
                                          $tyarn_lot_id = 'CL'.@$arr[0];
                                       }
                                    } else if ($box->lot_no != '') {
                                       $tyarn_lot_id = $box->lot_no;
                                    }
                                    ?>
                                    <tr>
                                       <td><?php echo $sno++; ?></td>
                                       <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                                       <td><?php echo date("d-m-Y", strtotime($box->packed_date)); ?></td>
                                       <td><?php echo $box->packed_by; ?></td>
                                       <td><?php echo $box->remarks ?></td>
                                       <td><?php echo $box->item_name . '/' . $box->item_id ?></td>
                                       <td><?php echo $box->shade_name . '/' . $box->shade_code ?></td>
                                       <td><?= ($tyarn_lot_id != '') ? $tyarn_lot_id : '#'; ?></td>
                                       <td><?php echo number_format($box->net_weight, 3) . 'Kgs ' . $box->no_cones . 'cones'; ?></td>
                                       <td><?php echo $is_deleted; ?></td>
                                       <td><?= ($box->delivered_in_group) ? 'Transfered to shop' : ''; ?></td>
                                       <td><?= $box_status['pdc_no']; ?></td>
                                       <td><?= $box_status['dc_no']; ?></td>
                                       <td><?= $box_status['inv_no']; ?></td>
                                    </tr>
                                 <?php endforeach; ?>
                              </tbody>
                           </table>
                        <?php } else { ?>
                           <span align='center'>
                              <h3><strong class='text-danger'>These boxes are not received in shop. Pls Check with Indofila Unit 1 Data.If not found in unit 1 data,contact Admin</strong></h3>
                           </span>
                        <?php } ?>
                     </div>
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
   </script>
</body>

</html>