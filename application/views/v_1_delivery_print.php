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
    .invoice-table tr td,
    .invoice-table tr th {
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
                <h3><i class=" icon-truck"></i> Delivery</h3>
              </header>
            </section>
          </div>
        </div>
        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="">
          <?php
          // echo "<pre>";
          // print_r($delivery_details);
          // echo "</pre>";
          // echo $delivery_id;
          foreach ($delivery_details as $row) {
            $delivery_boxes = explode(",", $row['delivery_boxes']);
            $delivery_customer = $row['delivery_customer'];
            $delivery_date = $row['delivery_date'];
            $delivery_id = $row['delivery_id'];
            $concern_id = $row['concern_name'];
            $dc_no = $row['dc_no'];
          }
          $ed = explode("-", $delivery_date);
          $delivery_date = date("d-m-Y", strtotime($delivery_date));
          $pre_delivery_list = array();
          $item_names_arr = array();
          $shade_names_arr = array();
          $shade_codes_arr = array();
          $gr_weights_arr = array();
          $nt_weights_arr = array();
          $no_cones_arr = array();
          foreach ($delivery_boxes as $box_no) {
            $outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
            //$outerboxes = $this->ak->yt_packing_box($box_no);
            /*echo "<pre>";
                    print_r($outerboxes);
                    echo "</pre>";*/
            foreach ($outerboxes as $outerbox) {

              $inner_boxes = (array) json_decode($outerbox['inner_boxes']);
              if ($outerbox['box_prefix'] == 'TH' || $outerbox['box_prefix'] == 'TI') {
                $no_of_cones = $outerbox['no_of_cones'] + $outerbox['no_of_cones_2'];
                $item_name = '';
                $item_id = '';
                $shade_id = '';
                $shade_name = '';
                $shade_code = '';
                if (count($inner_boxes) > 0) {
                  foreach ($inner_boxes as $inner_box) {
                    $item_id = $inner_box->item_id;
                    $shade_id = $inner_box->shade_id;
                    $manual = ""; //$inner_box->manual_lot_no;//ER-07-18#-16
                    $item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $inner_box->item_id, 'item_name');
                    $shade_name = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $inner_box->shade_id, 'shade_name');
                    $shade_code = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $inner_box->shade_id, 'shade_code');
                    $yarn_denier = ""; //$inner_box->yarn_den;//ER-07-18#-16
                  }
                } else {
                  $item_name = $outerbox['item_name'];
                  $item_id = $outerbox['item_id'];
                  $shade_id = $outerbox['shade_id'];
                  $manual = $outerbox['manual_lot_no'];
                  $shade_name = $outerbox['shade_name'];
                  $shade_code = $outerbox['shade_code'];
                  $yarn_denier = $outerbox['yarn_den'];
                }
              } else {
                $no_of_cones = $outerbox['no_of_cones'] + $outerbox['no_of_cones_2'];
                $item_name = $outerbox['item_name'];
                $item_id = $outerbox['item_id'];
                $shade_id = $outerbox['shade_id'];
                $shade_name = $outerbox['shade_name'];
                $shade_code = $outerbox['shade_code'];
                $manual = $outerbox['manual_lot_no'];
                $yarn_denier = $outerbox['yarn_den'];
              }

              $packing_gr_weight = $outerbox['gross_weight'];
              $packing_net_weight = $outerbox['net_weight'];
              $yarn_lot_no = $outerbox['lot_no'];

              // echo $outerbox['yarn_den'];

              //echo "<pre>" .json_encode($outerbox,'JSON_PREETY_PRINT').'</pre>';



              if ($outerbox['box_prefix'] == 'G' || $outerbox['box_prefix'] == 'S') {
                $lot_no = $outerbox['poy_lot_no'];
                //$lot_no = $outerbox['yarn_lot_no'];
              } else {
                $lot_no = $outerbox['lot_no'];
              }

              $pre_delivery_list[$lot_no][$outerbox['box_id']] = $outerbox['box_prefix'] . $outerbox['box_no'];
              $item_names_arr[$outerbox['box_id']] = $item_name;
              $shade_names_arr[$outerbox['box_id']] = $shade_name;
              $item_id_arr[$outerbox['box_id']] =  $item_id;
              $shade_codes_arr[$outerbox['box_id']] = $shade_code;
              $gr_weights_arr[$outerbox['box_id']] = $packing_gr_weight;
              $nt_weights_arr[$outerbox['box_id']] = $packing_net_weight;
              $no_cones_arr[$outerbox['box_id']] = $no_of_cones;
              $man_arr[$outerbox['box_id']] = $manual;
              $yarn_arr[$outerbox['box_id']] = $yarn_denier;
            }
          }

          $concern_name = '';
          $concern = $this->m_masters->get_concern($concern_id);
          $customer = $this->m_masters->get_customer($delivery_customer);

          /*echo "<pre>";
                  print_r($concern);
                  echo "</pre>";*/
          ?>
          <input type="hidden" name="delivery_id" value="<?= $delivery_id; ?>">
          <div class="row invoice-list">
            <div class="col-lg-12">
              <section class="panel">
                <div class="panel-body">
                  <table class="table table-bordered invoice-table">
                    <thead>
                      <tr>
                        <th colspan="10">
                          <h3 style="margin:0px;" class="text-center">Delivery</h3>
                        </th>
                      </tr>
                      <tr>
                        <th colspan="5">
                          <strong>FROM:</strong><br />
                          <?php if ($concern) : ?>
                            <?php
                            $concern_name = $concern->concern_name;
                            ?>
                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $concern->concern_name; ?></strong><br />
                            <?php echo $concern->concern_address; ?><br>
                            GST: <?php echo $concern->concern_gst; ?><br>

                          <?php endif; ?>
                        </th>
                        <th colspan="5">
                          <strong>TO:</strong><br />
                          <?php if ($customer) : ?>
                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $customer->cust_name; ?></strong><br />
                            <?php echo $customer->cust_address; ?><br>
                            GST: <?php echo $customer->cust_gst; ?>
                          <?php endif; ?>
                        </th>
                      </tr>
                      <tr>
                        <th colspan="5">
                          <strong style="font-size:18px;">Delivery No: <?php echo $dc_no; ?></strong>
                        </th>
                        <th colspan="5" class="text-right">
                          Date: <?php echo $delivery_date; ?>
                        </th>
                      </tr>
                      <tr>
                        <th>#</th>
                        <th>Box No</th>
                        <th>Item Name</th>
                        <th>HSN Code</th>
                        <th>Shade Name/Code</th>
                        <!--th>Yarn Denier </th>
                        <th>Lot NO</th-->
                        <th style="text-align:right;">M.Lot No</th>
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
                            <td style="width:2cm;">
                              <?php
                              $hsn = $this->m_masters->getmasterdetails('bud_items', 'item_id', $item_id_arr[$key_1]);
                              foreach ($hsn as $h) {
                                echo substr($h['hsn_code'], 0, 4);
                              }
                              ?>
                            </td>
                            <td><?= $shade_names_arr[$key_1]; ?> / <?= $shade_codes_arr[$key_1]; ?></td>
                            <?php /*
                            <td><?= $this->m_masters->getmasterIDvalue('bud_yt_poydeniers', 'denier_id', $yarn_arr[$key_1], 'denier_name'); ?>
                              <?= $yarn_arr[$key_1]; ?></td>
                            <td align="right" nowrap><?= $key; ?></td>
                            */ ?>
                            <td align="right" nowrap><?= $man_arr[$key_1]; ?></td>

                            <td align="right"><?= $no_cones_arr[$key_1]; ?></td>
                            <td align="right"><?= number_format($gr_weights_arr[$key_1], 3, '.', ''); ?></td>
                            <td align="right"><?= number_format($nt_weights_arr[$key_1], 3, '.', ''); ?></td>
                            <td align="right">
                              <?= (count($value) == $row_key) ? number_format($lotwise_nt_weight, 3, '.', '') : ''; ?>
                            </td>
                          </tr>
                      <?php
                          $row_key++;
                          $sno++;
                          $total_items++;
                        }
                      }
                      ?>
                      <tr>
                        <td colspan="5" align="center"><strong style="font-size:14px;">Total</strong></td>
                        <td><strong style="font-size:14px;"><?= $total_items; ?> Boxes</strong></td>
                        <td align="right"><strong style="font-size:14px;"><?= $total_cones; ?></strong></td>
                        <td align="right"><strong style="font-size:14px;"><?= number_format($total_gr_wt, 3, '.', ''); ?></strong></td>
                        <td align="right"><strong style="font-size:14px;"><?= number_format($total_net_wt, 3, '.', ''); ?></strong></td>
                        <td align="right"><strong style="font-size:14px;"><?= number_format($total_net_wt, 3, '.', ''); ?></strong></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="10">
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
                              <br />
                              <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $this->session->userdata('user_id'), 'user_login'); ?>
                            </div>
                            <div class="print-div col-lg-3" style="border-right:none;">
                              <strong>Checked By</strong>
                              <br />
                              <br />
                            </div>
                            <div class="print-div right-align col-lg-3">
                              <strong>For <?php echo $concern_name; ?>.</strong>
                              <br />
                              <br />
                              <br />
                              <br />
                              Auth.Signatury
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
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

    $(".delete").live('click', function(event) {
      $(this).parent().parent().remove();
      return false;
    });
  </script>
</body>

</html>