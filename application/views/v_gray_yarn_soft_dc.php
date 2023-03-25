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

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <div class="panel-body">
                <table class="table table-bordered table-striped table-condensed invoice-table">
                  <tbody>
                    <tr class="first-row">
                      <td colspan="4" align="center" style="text-align:center;">
                        <h3 style="margin:0px;">Gray Yarn Soft Packing Delivery</h3>
                      </td>
                    </tr>
                    <tr>
                      <td>No</td>
                      <td>: <strong>S <?= $delivery->delivery_id; ?></strong></td>
                      <td>Date</td>
                      <td>: <?= date("d-m-Y H:i:s", strtotime($delivery->delivery_date)); ?></td>
                    </tr>
                    <tr>
                      <!--ER-07-18#-14-->
                      <td>From</td>
                      <td>: <?php
                            $from_concern = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $delivery->from_concern);
                            $from_concern_name = $delivery->from_concern; //ER-08-18#-46
                            if ($from_concern) {
                              $from_concern_name = $from_concern[0]['concern_name']; //ER-08-18#-46
                            ?>
                          <strong style="font-size:14px;"><?= $from_concern[0]['concern_name']; ?></strong><br />
                          <?= $from_concern[0]['concern_address']; ?><br>

                          GST: <?= $from_concern[0]['concern_gst']; ?><br>
                        <?php
                            } else {
                        ?>
                          <?= $delivery->from_concern; ?>
                        <?php
                            }
                        ?>

                      </td>
                      <td>To</td>
                      <td>: <?php
                            $to_concern = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $delivery->to_concern);
                            if ($to_concern) {
                            ?>
                          <strong style="font-size:14px;"><?= $to_concern[0]['concern_name']; ?></strong><br />
                          <?= $to_concern[0]['concern_address']; ?><br>

                          GST: <?= $to_concern[0]['concern_gst']; ?><br>
                        <?php
                            } else {
                        ?>
                          <?= $delivery->to_concern; ?>
                        <?php
                            }
                        ?>

                      </td>
                      <!--ER-07-18#-14-->
                    </tr>
                    <tr>
                      <td colspan="4">
                        <table class="table table-bordered table-striped table-condensed invoice-table">
                          <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Box No</th>
                              <th>Item Name/Code</th>
                              <th>Shade Name/Code</th>
                              <th>Shade No</th>
                              <th>Lot No</th>
                              <!--//ER-10-18#-64-->
                              <th># Springs</th>
                              <th>Gr.Wt</th>
                              <th>Nt.Wt</th>
                              <th>Tot. Lot Wise</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no_of_boxes = 0;
                            $total_spring = 0;
                            $total_gr_weight = 0;
                            $total_nt_weight = 0;
                            $lot_tot = array();
                            if (sizeof($delivery->outer_boxes) > 0) {
                              //Inclusion of Lotwise tot

                              //End of Inclusion of Lotwise tot
                              $lot = '';
                              $sno = 1;
                              foreach ($delivery->outer_boxes as $outerbox) {
                                $box_id = $outerbox->box_id;
                                $box = $this->m_delivery->soft_delivery_item_details($box_id);
                                if ($box) {

                                  //ER-10-18#-64
                                  switch ($box->box_prefix) {
                                    case 'DIR':
                                      $lot_no = $box->manual_lot_no;
                                      break;
                                    case 'D':
                                      $lot_no = $box->sys_lot_no;
                                      break;
                                    case 'TH':
                                      $lot_no = $box->sys_lot_no;
                                      break;
                                    case 'TI':
                                      $lot_no = $box->sys_lot_no;
                                      break;
                                    case 'G':
                                      $lot_no = $box->yarn_lot_no;
                                      break;
                                    case 'S':
                                      $lot_no = $box->yarn_lot_no;
                                      break;
                                    default:
                                      $lot_no = '';
                                  }
                                  //ER-10-18#-64
                                  if ($lot == $lot_no) //ER-10-18#-64
                                  {
                                    $lot_tot[$lot_no] += number_format((float) $box->net_weight, 3, '.', ''); //ER-10-18#-64
                                  } else {
                                    $lot_tot[$lot_no] = number_format((float) $box->net_weight, 3, '.', ''); //ER-10-18#-64
                                  }
                                  //$lot = $lot_no; //ER-10-18#-64

                                  $no_of_boxes++;
                                  $gross_weight = number_format($box->gross_weight, 3, '.', '');
                                  $net_weight = number_format($box->net_weight, 3, '.', '');
                                  $total_spring += $box->no_of_cones;
                                  $total_spring += $box->no_of_cones_2;
                                  $no_springs = $box->no_of_cones + $box->no_of_cones_2;
                                  $total_gr_weight += $gross_weight;
                                  $total_nt_weight += $net_weight;
                            ?>
                                  <tr>
                                    <td><?= $sno; ?></td>
                                    <td><?= $box->box_prefix . $box->box_no; //ER-08-18#-46
                                        ?></td>
                                    <td><?= $box->item_name; ?>/<?= $box->item_id; ?></td>
                                    <td><?= $box->shade_name; ?>/<?= $box->shade_id; ?></td>
                                    <td><?= $box->shade_code; ?></td>
                                    <td><?= $lot_no; ?></td>
                                    <!--//ER-10-18#-64-->
                                    <td><?= $no_springs; ?></td>
                                    <td><?= $gross_weight; ?></td>
                                    <td><?= $net_weight; ?></td>
                                    <?php
                                    //Inclusion of Lotwise tot
                                    if ($lot == $lot_no) //ER-10-18#-64
                                    {
                                    ?>
                                      <td><?= $lot_tot[$lot_no]; ?></td>
                                      <!--//ER-10-18#-64-->
                                    <?php
                                    } else {
                                    ?>
                                      <td></td>
                                    <?php
                                    }
                                    $lot = $lot_no; //ER-10-18#-64
                                    //end of Inclusion of Lotwise tot
                                    ?>
                                  </tr>
                            <?php
                                }
                                $sno++;
                              }
                            }
                            ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>Total</th>
                              <th><?php echo $no_of_boxes; ?></th>
                              <th>Boxes</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th><?php echo $total_spring; ?></th>
                              <th><?php echo number_format($total_gr_weight, 3, '.', ''); ?></th>
                              <th><?php echo number_format($total_nt_weight, 3, '.', ''); ?></th>
                              <th><?php echo number_format(array_sum($lot_tot), 3, '.', ''); ?></th>
                            </tr>
                          </tfoot>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                        <strong>Remarks:</strong>
                        <p><?= $delivery->remarks; ?></p>
                      </td>
                    </tr>
                    <!--//ER-08-18#-46-->
                  <tfoot>
                    <tr>
                      <td colspan="4">
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
                            <strong>For <?= $from_concern_name; ?>.</strong>
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
                  <!--//ER-08-18#-46-->
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