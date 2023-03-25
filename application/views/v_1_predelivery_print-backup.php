<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Mosaddek">
      <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
      <link rel="shortcut icon" href="img/favicon.html">

      <title><?=$page_title; ?> | INDOFILA SYNTHETICS</title>

      <!-- Bootstrap core CSS -->
      <?php
      foreach ($css as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet">
      <?php
      }
      foreach ($css_print as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet" media="print">
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
                           <h3><i class=" icon-truck"></i> Pre Delivery</h3>
                        </header>
                     </section>
                  </div>
               </div>                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="">
                  <?php
                  /*echo "<pre>";
                  print_r($delivery_details);
                  echo "</pre>";*/
                  foreach ($delivery_details as $row) {
                    $delivery_boxes = explode(",", $row['p_delivery_boxes']);
                    $delivery_customer = $row['p_delivery_cust'];
                    $delivery_date = $row['p_delivery_date'];
                    $delivery_id = $row['p_delivery_id'];
                  }
                  $ed = explode("-", $delivery_date);
                  $delivery_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
                  $pre_delivery_list = array();
                  $item_names_arr = array();
                  $gr_weights_arr = array();
                  $nt_weights_arr = array();
                  $no_cones_arr = array();
                  foreach ($delivery_boxes as $box_no) {
                    // $outerboxes = $this->m_delivery->getPreDelItemsDetails($box_no);
                    $outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
                    foreach ($outerboxes as $outerbox) {
                      $no_of_cones = $outerbox['no_cones'];
                      $packing_gr_weight = $outerbox['gross_weight'];
                      $packing_net_weight = $outerbox['net_weight'];
                      $yarn_lot_no = $outerbox['lot_no'];
                      $item_name = $outerbox['item_name'];
                      $item_id = $outerbox['item_id'];
                      $pre_delivery_list[$yarn_lot_no][$outerbox['box_id']] = $outerbox['box_prefix'].$outerbox['box_no'];
                      $item_names_arr[$outerbox['box_id']] = $item_name .'/'. $item_id;
                      $gr_weights_arr[$outerbox['box_id']] = $packing_gr_weight;
                      $nt_weights_arr[$outerbox['box_id']] = $packing_net_weight;
                      $no_cones_arr[$outerbox['box_id']] = $no_of_cones;
                    }
                  }

                  /*echo "<pre>";
                  print_r($pre_delivery_list);
                  echo "</pre>";*/
                  ?>
                  <input type="hidden" name="delivery_id" value="<?=$delivery_id; ?>">
                  <div class="row invoice-list">
                     <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="col-lg-4 col-sm-4">
                                    <h3>Pre Delivery</h3>
                                    <h4>Pre Delivery No : <strong><?=$delivery_id;?></strong></h4>
                                    <h4><?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $delivery_customer, 'cust_name');?></h4>
                                    <h4>Date : <?=$delivery_date;?></h4>
                                                            </div>
                               <table class="table table-striped border-top">
                               <thead>                                                            <tr>
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
                                    foreach ($value as $key_1 => $value_1) {
                                      $total_cones += $no_cones_arr[$key_1];
                                      $total_gr_wt += $gr_weights_arr[$key_1];
                                      $total_net_wt += $nt_weights_arr[$key_1];
                                      $lotwise_nt_weight += $nt_weights_arr[$key_1];
                                      ?>
                                      <tr>
                                        <td><?=$sno; ?></td>
                                        <td><?=$value_1; ?></td>
                                        <td><?=$item_names_arr[$key_1]; ?></td>
                                        <td align="right"><?=$key; ?></td>
                                        <td align="right"><?=$no_cones_arr[$key_1]; ?></td>
                                        <td align="right"><?=$gr_weights_arr[$key_1]; ?></td>
                                        <td align="right"><?=$nt_weights_arr[$key_1]; ?></td>
                                        <td></td>
                                      </tr>
                                      <?php
                                      $sno++;
                                      $total_items++;
                                    }
                                    ?>
                                    <tr>
                                      <td colspan="7"></td>
                                      <td align="right"><?=$lotwise_nt_weight; ?></td>
                                    </tr>
                                    <?php
                                  }
                                  ?>
                                  <tr>
                                    <td colspan="2" align="center"><strong style="font-size:14px;">Total</strong></td>
                                    <td><strong style="font-size:14px;"><?=$total_items; ?> Boxes</strong></td>
                                    <td></td>
                                    <td align="right"><strong style="font-size:14px;"><?=$total_cones; ?></strong></td>
                                    <td align="right"><strong style="font-size:14px;"><?=$total_gr_wt; ?></strong></td>
                                    <td align="right"><strong style="font-size:14px;"><?=$total_net_wt; ?></strong></td>
                                    <td align="right"><strong style="font-size:14px;"><?=$total_net_wt; ?></strong></td>
                                  </tr>
                               </tbody>
                               </table>
                              <div class="col-lg-4 col-sm-4">
                                <br/>
                                <br/>
                                <br/>
                                <strong>Auth. Signature</strong>                                                          </div>
                            </div>
                        </section>
                     </div>

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="button" onclick="window.print()">Print</button>
                            </header>
                        </section>
                     </div>
                  </div>
                  </form>
               <div class="pageloader"></div>                          <!-- page end-->
            </section>
         </section>
         <!--main content end-->
      </section>

      <!-- js placed at the end of the document so the pages load faster -->
      <?php
      foreach ($js as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
      }
      ?>    

      <!--common script for all pages-->
      <?php
      foreach ($js_common as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
      }
      ?>

      <!--script for this page-->
      <?php
      foreach ($js_thispage as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
      }
      ?>

      <script>

      //owl carousel
      $(document).ready(function() {
      $("#owl-demo").owlCarousel({
      navigation : true,
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem : true

      });
      });

      //custom select box
      $(function(){
      $('select.styled').customSelect();
      });

      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });
    $(".delete").live('click', function(event) {
        $(this).parent().parent().remove();
        return false;
      });

      </script>
   </body>
</html>
