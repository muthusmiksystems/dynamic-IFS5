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
                        <h3><i class=" icon-truck"></i> Pre DC Transfer to Delivery</h3>
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
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>delivery/delivery_1_save">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Delivery
                           <span class="label label-danger" style="font-size:14px;"><?= $next_delivery; ?></span>
                        </header>
                        <div class="panel-body">
                           <div class="form-group col-lg-3">
                              <label for="delivery_date">Date</label>
                              <input class="form-control dateplugin" id="delivery_date" value="<?= date('d-m-Y'); ?>" name="delivery_date" type="text" required>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="pre_delivery">Pre Delivery Ref</label>
                              <select class="form-control select2" id="pre_delivery" name="pre_delivery">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($pre_deliveries as $p_delivery) {
                                 ?>
                                    <option value="<?= $p_delivery['p_delivery_id']; ?>" <?= ($p_delivery['p_delivery_id'] == $this->uri->segment(3)) ? 'selected="selected"' : ''; ?>><?= $p_delivery['p_delivery_id']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                        </div>
                     </section>
                  </div> <?php
                           if (isset($p_delivery_id)) {
                              foreach ($delivery_details as $row) {
                                 $delivery_boxes = explode(",", $row['p_delivery_boxes']);
                                 $p_delivery_cust = $row['p_delivery_cust'];
                                 $concern_name = $row['concern_name'];
                                 $delivery_date = $row['p_delivery_date'];
                              }

                              $ed = explode("-", $delivery_date);
                              $delivery_date = $ed[2] . '/' . $ed[1] . '/' . $ed[0];
                              $pre_delivery_list = array();
                              $item_names_arr = array();
                              $gr_weights_arr = array();
                              $nt_weights_arr = array();
                              $no_cones_arr = array();
                              foreach ($delivery_boxes as $box_no) {
                                 // $outerboxes = $this->m_delivery->getPreDelItemsDetails($box_no);
                                 $outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
                                 foreach ($outerboxes as $outerbox) {
                                    $no_of_cones = $outerbox['no_of_cones'];
                                    $packing_gr_weight = $outerbox['gross_weight'];
                                    $packing_net_weight = $outerbox['net_weight'];
                                    $yarn_lot_no = $outerbox['lot_no'];
                                    $item_name = $outerbox['item_name'];
                                    $item_id = $outerbox['item_id'];
                                    $pre_delivery_list[$yarn_lot_no][$outerbox['box_id']] = $outerbox['box_prefix'] . $outerbox['box_no'];
                                    $item_names_arr[$outerbox['box_id']] = $item_name . '/' . $item_id;
                                    $gr_weights_arr[$outerbox['box_id']] = $packing_gr_weight;
                                    $nt_weights_arr[$outerbox['box_id']] = $packing_net_weight;
                                    $no_cones_arr[$outerbox['box_id']] = $no_of_cones;
                                 }
                              }
                           ?>
                     <input type="hidden" name="delivery_customer" value="<?= $p_delivery_cust; ?>">
                     <input type="hidden" name="concern_name" value="<?= $concern_name; ?>">
                     <div class="col-lg-12">
                        <section class="panel">
                           <header class="panel-heading">
                              Delivery Items
                           </header>
                           <div class="panel-body">
                              <table class="table table-striped border-top">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>Box No</th>
                                       <th>Item Name/Code</th>
                                       <th style="text-align:right;">Lot No</th>
                                       <th style="text-align:right;"># of Cones</th>
                                       <th style="text-align:right;">Gr. Weight</th>
                                       <th style="text-align:right;">Net Weight</th>
                                       <th style="text-align:right;">Lotwise Nt.Weight</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $sno = 1;
                                    $total_items = 0;
                                    $total_cones = 0;
                                    $total_gr_wt = 0;
                                    $total_net_wt = 0;
                                    $total_net_mtr = 0;
                                    $sno = 1;
                                    foreach ($pre_delivery_list as $key => $value) {
                                       $lotwise_nt_weight = 0;
                                       $row_key = 1;
                                       foreach ($value as $key_1 => $value_1) {
                                          $total_cones += $no_cones_arr[$key_1];
                                          $total_gr_wt += $gr_weights_arr[$key_1];
                                          $total_net_wt += $nt_weights_arr[$key_1];
                                          $lotwise_nt_weight += $nt_weights_arr[$key_1];
                                    ?>
                                          <tr>
                                             <td><?= $sno; ?></td>
                                             <td><?= $value_1; ?></td>
                                             <td><?= $item_names_arr[$key_1]; ?></td>
                                             <td align="right"><?= $key; ?></td>
                                             <td align="right"><?= $no_cones_arr[$key_1]; ?></td>
                                             <td align="right"><?= $gr_weights_arr[$key_1]; ?></td>
                                             <td align="right"><?= number_format($nt_weights_arr[$key_1], 3, '.', ''); ?></td>
                                             <td align="right">
                                                <?= (count($value) == $row_key) ? $lotwise_nt_weight : ''; ?>
                                                <input type="hidden" name="delivery_boxes[]" value="<?= $key_1; ?>">
                                             </td>
                                          </tr>
                                    <?php
                                          $sno++;
                                          $total_items++;
                                       }
                                    }
                                    ?>
                                    <tr>
                                       <td colspan="2" align="center"><strong style="font-size:14px;">Total</strong></td>
                                       <td><strong style="font-size:14px;"><?= $total_items; ?> Boxes</strong></td>
                                       <td></td>
                                       <td align="right"><strong style="font-size:14px;"><?= $total_cones; ?></strong></td>
                                       <td align="right"><strong style="font-size:14px;"><?= $total_gr_wt; ?></strong></td>
                                       <td align="right"><strong style="font-size:14px;"><?= number_format($total_net_wt, 3, '.', ''); ?></strong></td>
                                       <td align="right"><strong style="font-size:14px;"><?= number_format($total_net_wt, 3, '.', ''); ?></strong></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </section>
                     </div>
                     <div class="col-lg-12">
                        <section class="panel">
                           <header class="panel-heading">
                              <button class="btn btn-danger" type="submit">Transfer to delivery</button>
                              <button class="btn btn-default" type="button">Cancel</button>
                           </header>
                        </section>
                     </div>
                  <?php
                           }
                  ?>
               </div>
            </form>
            <div class="pageloader"></div> <!-- page end-->
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
         $("#pre_delivery").change(function() {
            var pre_delivery = $('#pre_delivery').val();
            window.location = '<?= base_url() ?>delivery/delivery_1/' + pre_delivery;
         });
      });
   </script>
</body>

</html>