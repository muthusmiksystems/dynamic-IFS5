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


  
  
      
    
  <style type="text/css">
    .gross-weight {
      height: 100px;
      font-size: 62px;
      font-weight: bold;
      color: red;
    }

    .gross-weight-lbl {
      font-size: 32px;
      color: red;
      text-transform: uppercase;
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
                <h3><i class="icon-book"></i> Dyed Thread Packing Entry ( Without Inner )</h3>
              </header>
            </section>
            <?php
            if ($this->session->flashdata('warning')) {
            ?>
              <div class="alert alert-warning fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                  <i class="icon-remove"></i>
                </button>
                <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
              </div>
            <?php
            }
            if ($this->session->flashdata('error')) {
            ?>
              <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                  <i class="icon-remove"></i>
                </button>
                <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
              </div>
            <?php
            }
            if ($this->session->flashdata('success')) {
            ?>
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
            <?php
            }
            ?>
          </div>
        </div>
        <?php
        $t_wt = 0;
        $item_name = '';
        $item_id = '';
        $cust_name = '';
        $customer_id = '';
        $shade_code = '';
        $shade_name = '';
        if (isset($id)) {
          $result = $this->m_masters->getmasterdetails('bud_yt_packing_boxes', 'box_id', $id);
          foreach ($result as $row) {
            $box_no = $row['box_no'];
            $item_id = $row['item_id'];
            $lot_no = $row['lot_no'];
            $shade_no = $row['shade_no'];
            $box_weight = $row['box_weight'];
            $remark = $row['remarks'];
            $no_boxes = $row['no_boxes'];
            $poly_bag_weight = $row['poly_bag_weight'];
            $no_bags = $row['no_bags'];
            $cone_weight = $row['cone_weight'];
            $no_cones = $row['no_cones'];
            $no_of_cones = $row['no_of_cones'];
            $spring_weight = $row['spring_weight'];
            $weight_per_cone = $row['weight_per_cone'];
            $no_of_cones = $row['no_of_cones'];
            $meter_per_cone = $row['meter_per_cone'];
            $other_weight = $row['other_weight'];
            $gross_weight = $row['gross_weight'];
            $net_weight = $row['net_weight'];
            $net_weight_cones = $row['net_weight_cones'];
            $packed_by = $row['packed_by'];
            $packed_date = $row['packed_date'];
            $stock_room_id = $row['stock_room_id'];
            $grant_wt = $row['gross_weight'];
            $net_wt = $row['net_weight'];
          }
          // $t_wt = ($box_weight * $no_boxes) + ($poly_bag_weight * $no_bags) + ($cone_weight * $no_cones) + $other_weight + $spring_weight;
          $t_wt = $grant_wt - $net_wt;
          $next = $box_no;
        } else {
          $id = '';
          $box_no = '';
          $item_id = '';
          $lot_no = '';
          $shade_no = '';
          $box_weight = '';
          $no_boxes = '';
          $poly_bag_weight = '';
          $no_bags = '';
          $cone_weight = '';
          $no_cones = '';
          $no_of_cones = '';
          $spring_weight = '';
          $weight_per_cone = '';
          $no_of_cones = '';
          $meter_per_cone = '';
          $other_weight = '';
          $gross_weight = '';
          $net_weight = '';
          $net_weight_cones = '';
          $packed_by = '';
          $packed_date = '';
          $stock_room_id = '';
          $remark = '';
        }

        $lot_qty = 0.000;
        $tot_packed_qty = 0.000;
        $tot_balancd_qty = 0.000;
        $shade = '';
        $percentage = 0;
        if (!empty($lot_no)) {
          $lot_id = $lot_no;
          if (!empty($lot_id)) {
            $lot = $this->m_masters->get_lot($lot_id);
            if ($lot) {
              $dlc_items = $this->m_purchase->get_dlc_lot_qty($lot_id);
              if (sizeof($dlc_items) > 0) {
                foreach ($dlc_items as $item) {
                  $lot_qty += $item->net_weight;
                }
              }
              // $lot_qty = $lot->lot_actual_qty;
              $shade = $lot->lot_shade_no;
            }

            $pack_qty = $this->m_masters->get_lot_pack_qty($lot_id);
            if ($pack_qty) {
              if ($pack_qty->tot_packed_qty > 0) {
                $tot_packed_qty = $pack_qty->tot_packed_qty;
              }
            }
          }
          $tot_balancd_qty = $lot_qty - $tot_packed_qty;

          $lot_qty = number_format($lot_qty, 3, '.', '');
          $tot_packed_qty = number_format($tot_packed_qty, 3, '.', '');
          $tot_balancd_qty = number_format($tot_balancd_qty, 3, '.', '');

          $lot = $this->m_masters->get_lot_details($lot_id);
          // print_r($lot);
          if ($lot) {
            $item_name = $lot->item_name;
            $item_id = $lot->item_id;
            $cust_name = $lot->cust_name;
            $customer_id = $lot->bud_customers;
            $shade_code = $lot->shade_code;
            $shade_name = $lot->shade_name;
          }
        }
        ?>
        <div class="row">
          <div class="col-lg-12">
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>store/dyed_thread_packing_save">
              <input type="hidden" name="box_id" value="<?= $id; ?>">
              <section class="panel">
                <header class="panel-heading">
                  <div class="form-group col-lg-12">
                    <label>Box No : </label>
                    <span class="label label-danger" style="padding: 0 1em;font-size:24px;" id="box" value="<?= $next ?>">TH<?= $next_boxno; ?></span>
                  </div>
                </header>
                <div class="panel-body">
                  <div class="form-group col-lg-3">
                    <label for="po_category">LOT</label>
                    <select class="form-control select2" name="lot_no" id="lot_no" required>
                      <option value="">Select LOT</option>
                      <?php
                      foreach ($lots as $row) {
                      ?>
                        <option value="<?= $row->lot_id; ?>" <?= ($row->lot_id == $lot_no) ? 'selected="selected"' : ''; ?>><?= $row->lot_no; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>


                  <div class="form-group col-lg-2">
                    <label for="po_date">Total Lot Prod Qnty</label>
                    <span class="label label-primary" id="lable_lot_qty" style="padding: 0 1em;font-size:24px;"><?= $lot_qty; ?></span>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="po_date">Total Lot Packed Qty</label>
                    <span class="label label-warning" id="lable_pack_qty" style="padding: 0 1em;font-size:24px;"><?= $tot_packed_qty; ?></span>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="po_date">Balance Lot Qty</label>
                    <span class="label label-danger" id="lable_bal_qty" style="padding: 0 1em;font-size:24px;"><?= $tot_balancd_qty; ?></span>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="po_date" class="text-danger">This Lot Wastage Qty</label>
                    <input class="form-control" value="" type="text" style="color:red;font-weight:bold;">
                  </div>

                  <div style="clear:both"></div>
                  <div class="row">
                    <div class="col-md-8">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-danger">Customer</th>
                            <th class="text-danger">Item Name</th>
                            <th class="text-danger">Color Name</th>
                            <th class="text-danger">Color Code</th>
                            <th class="text-danger">Qty</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td id="lbl_cust_name"><?php echo $cust_name; ?></td>
                            <td id="lbl_item_name"><?php echo $item_name; ?></td>
                            <td id="lbl_shade_name"><?php echo $shade_name; ?></td>
                            <td id="lbl_shade_code"><?php echo $shade_code; ?></td>
                            <td id="lbl_lot_qty"><?php echo $lot_qty; ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="customer_id">Customer</label>
                      <select class="search-term form-control select2" id="customer_id" name="customer_id">
                        <option value="">Select Customer</option>
                        <?php if (sizeof($customers) > 0) : ?>
                          <?php foreach ($customers as $customer) : ?>
                            <option value="<?php echo $customer->cust_id; ?>" <?php echo ($customer->cust_id == $customer_id) ? 'selected="selected"' : ''; ?>><?php echo $customer->cust_name; ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                    </div>
                  </div>

                  <div class="row col-lg-12">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="po_date" class="gross-weight-lbl">Gross Wt:</label>
                        <input class="gross-weight form-control" id="g_wt" name="gross" value="<?= $gross_weight; ?>" type="number" required autofocus="">
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="form-group col-lg-6">
                        <label for="po_date">Item Name - code</label>
                        <select class="search-term form-control select2" id="item_id" name="item_id" required>
                          <option>Select</option>
                          <?php
                          foreach ($items as $row) {
                          ?>
                            <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_name']; ?> / <?= $row['item_id']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>

                      <div class="form-group col-lg-6">
                        <label for="po_date">Color / Code</label>
                        <select class="search-term form-control select2" id="shade_no" name="shade_no" required readonly>
                          <option>Select</option>
                          <?php
                          foreach ($shades as $row) {
                          ?>
                            <option value="<?= $row['shade_id']; ?>" <?= ($row['shade_id'] == $shade_no) ? 'selected="selected"' : ''; ?>><?= $row['shade_name']; ?> / <?= $row['shade_code']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>

                      <div class="form-group col-lg-4">
                        <label for="po_category">Box Weight</label>
                        <select class="form-control select2" id="b_wt" name="box_wt" required>
                          <option value="1">Select Box</option>
                          <?php
                          foreach ($tareweights as $row) {
                          ?>
                            <option value="<?= $row['tareweight_value']; ?>" <?= ($row['tareweight_value'] == $box_weight) ? 'selected="selected"' : ''; ?>><?= $row['tareweight_name']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group col-lg-4">
                        <label for="po_date">Num of boxe(s)</label>
                        <input class="form-control" id="n_bx" type="number" name="no_boxes" value="<?= $no_boxes; ?>" onkeyup="total_box()" required>
                      </div>
                      <div class="form-group col-lg-4">
                        <label for="po_date">Total Box weight</label>
                        <input class="form-control" id="t_bx" value="<?= $box_weight * $no_boxes; ?>" type="text" required readonly>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div style="clear:both"></div>

                  <div class="form-group col-lg-2">
                    <label for="po_category">Paper Tube Weight</label>
                    <select class="form-control select2" id="p_wt" name="poly_bag_weight" required>
                      <option value="1">Select</option>
                      <?php
                      foreach ($tareweights as $row) {
                      ?>
                        <option value="<?= $row['tareweight_value']; ?>" <?= ($row['tareweight_value'] == $poly_bag_weight) ? 'selected="selected"' : ''; ?>><?= $row['tareweight_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>


                  <div class="form-group col-lg-2">
                    <label for="po_date">Num of Bags</label>
                    <input class="form-control" id="n_bg" name="no_bags" value="<?= $no_bags; ?>" type="number" onkeyup="total_bag()" required>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Total Poly Bag Weight</label>
                    <input class="form-control" id="t_bg" value="<?= $poly_bag_weight * $no_bags; ?>" type="text" required readonly>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Weight per cone (gms)</label>
                    <input class="form-control" id="cone_wt" name="weight_per_cone" value="<?= $weight_per_cone ?>" type="number" required onkeyup="calculate()">
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Total No of cones</label>
                    <input class="form-control" id="no_of_cones" name="no_of_cones" value="<?= $no_of_cones; ?>" type="number" required onkeyup="calculate()">
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Other Weight</label>
                    <input class="form-control" name="other_weight" id="ot_wt" value="<?= $other_weight; ?>" type="number" required min="-1" onkeyup="tare_wt()">
                  </div>

                  <div style="clear:both"></div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Net Weight (1 cone wt.* # cones)</label>
                    <input class="form-control" id="cal_wt" name="nt_wt1" value="<?= $net_weight_cones; ?>" type="number" required readonly>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Meter per cone</label>
                    <input class="form-control" id="cone_meter" name="meter_per_cone" value="<?= $meter_per_cone; ?>" type="number" required>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Tare Weight</label>
                    <input class="form-control" id="t_wt" name="t_wt" value="<?= $gross_weight - $net_weight; ?>" type="text" readonly>
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="po_date">Remarks : </label>
                    <textarea name="remark" class="form-control" style="resize: vertical;" required="required"><?= $remark; ?></textarea>
                  </div>

                  <div class="form-group col-lg-offset-4 col-lg-2">
                    <label for="stock_room_id">Stock Room</label>
                    <select class="form-control select2" name="stock_room_id" id="stock_room_id" required>
                      <option value="">Select Box</option>
                      <?php
                      foreach ($stock_rooms as $row) {
                      ?>
                        <option value="<?= $row['stock_room_id']; ?>" <?= ($row['stock_room_id'] == $stock_room_id) ? 'selected="selected"' : ''; ?>><?= $row['stock_room_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Net Weight (System calculated wt) </label>
                    <input class="form-control" id="nt_wt" name="nt_wt" value="<?= $net_weight; ?>" type="number" required readonly>
                  </div>
                  <input type="hidden" id="pack_by" name="pack_by" value="<?= $this->session->userdata('display_name'); ?>">
              </section>

              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit" name="action" value="save" id="submit">Save</button>
                  <button class="btn btn-danger" type="submit" name="action" value="duplicate">Duplicate</button>
                  <button class="btn btn-warning" type="submit" name="action" value="save_continue">Save &amp; Continue</button>
                  <button class="btn btn-warning" type="submit" name="action" value="save_continue_p">Save &amp; Continue with Print</button>
                </header>
              </section>
            </form>

            <section class="panel">
              <header class="panel-heading">
                Summery
              </header>
              <script>
                var data = [];
              </script>
              <table class="table table-striped border-top" id="sample_1x">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>Date</th>
                    <th>Box No</th>
                    <th>LOT</th>
                    <th>Item name/code</th>
                    <th>Colour name/code</th>
                    <th>Gross Weight</th>
                    <th>Net Weight</th>
                    <th>Stock Room </th>
                    <th> Remarks </th>
                    <th>Packed By</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <?php
                $sno = 1;
                foreach ($table as $row) {
                ?>
                  <?php
                  $stock_room_name = '';
                  $this->db->select('*');
                  $this->db->from('bud_stock_rooms');
                  $this->db->where('stock_room_id', $row['stock_room_id']);
                  $q = $this->db->get();
                  $a = $q->result_array();
                  foreach ($a as $b) {
                    $stock_room_name = $b['stock_room_name'];
                  }
                  $delBtn = '';
                  if ($row['is_deleted'] == '0' && $row['predelivery_status'] == '1' && $row['delivery_status'] == '1') {
                    $delBtn = '<button type="submit" class="btn btn-danger" name="delete">Delete</button>';
                  }
                  ?>
                  <script>
                    data.push(['<?= $sno; ?>', '<?= date('d-m-Y h:i:s', strtotime($row['packed_date'])); ?>', '<?= $row['box_prefix']; ?><?= $row['box_no']; ?>', '<?= $row['lot_no']; ?>', '<?= $row['item_name'] . "/" . $row['item_id']; ?>', '<?= $row['shade_name'] . "/" . $row['shade_code']; ?>', '<?= $row['gross_weight']; ?>', '<?= $row['net_weight']; ?>', '<? $stock_room_name; ?>', '<?= $row['bud_remarks']; ?>', '<?= $row['packed_by']; ?>', '<a href="<?= base_url(); ?>store/print_thread_without_i/<?= $row['box_id']; ?>" class="btn btn-xs btn-warning" title="Print" target="_blank">Print</a><a href="<?= base_url(); ?>store/dyed_thread_packing/<?= $row['box_id']; ?>" class="btn btn-xs btn-primary" title="Edit">Edit</a><a href="<?= base_url(); ?>store/dyed_thread_packing/<?= $row['box_id']; ?>" class="btn btn-xs btn-success" title="Duplicate">Duplicate</a><a href="#<?= $row['box_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger" title="Delete">Delete</a><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?= $row['box_id']; ?>" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">Remarks</h4></div><div class="modal-body"><form role="form" method="post" action="<?= base_url(); ?>store/delete_packing_box/<?= $row['box_id']; ?>/dyed_thread_packing"><input type="hidden" name="box_id" value="<?= $row['box_id']; ?>"><input type="hidden" name="function_name" value="dyed_thread_packing"><div class="form-group col-lg-12" style="margin-bottom: 15px;"><textarea class="form-control" name="remarks" required style="width:100%;"></textarea></div><div style="clear:both;"></div><?= $delBtn; ?></form></div></div></div></div>']);
                  </script>
                <?php
                  $sno++;
                }
                ?>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
        <!-- Loading -->
        <div class="pageloader"></div>
        <!-- End Loading -->
      </section>

    </section>
    <h5 style="text-align:right;font-size:5px;margin-right:20px;">application\views\v_store_dyed_thread_packing.php</h5>
    <h5 style="text-align:right;font-size:5px;margin-right:20px;">application\views\v_store_print_thread_without_i.php</h5>
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
    var userLogin = <?= json_encode($user_login) ?>;
    function printTab() {
      var form = document.createElement("form");
      form.method = "GET";
      form.action = "<?= $print; ?>";
      form.target = "_blank";
      document.body.appendChild(form);
      form.submit();
    }
    <?php if ($print) { ?>
      printTab();
    <?php } ?>

    $(document).ready(function() {
      $('#sample_1x').DataTable({
        'data': data,
        'deferRender': true,
        'processing': true,
        'language': {
          'loadingRecords': '&nbsp;',
          'processing': 'Loading...'
        },
        "order": [
          [0, "asc"]
        ]
      });
      jQuery('.dataTables_filter input').addClass("form-control");
      jQuery('.dataTables_filter').parent().addClass('col-sm-6');
      jQuery('.dataTables_length select').addClass("form-control");
      jQuery('.dataTables_length').parent().addClass('col-sm-6');
    });

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
      // alert('Start');
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });


    function total_box() {
      $("#t_bx").val($("#b_wt").val() * $("#n_bx").val());
    }

    function total_bag() {
      $("#t_bg").val($("#p_wt").val() * $("#n_bg").val());
    }

    function tare_wt() {
      var grant = parseFloat($("#g_wt").val());
      var box = parseFloat($("#t_bx").val());
      var bag = parseFloat($("#t_bg").val());
      var spring = parseFloat($("#sp_twt").val());
      var other = parseFloat($("#ot_wt").val());
      var tare = parseFloat($("#t_wt").val());

      if (other >= 0) {
        if (grant >= 0) {
          if ((box >= 0) && (bag >= 0)) {
            var tare_total = box + bag + other;
            if (tare_total < grant) {
              $("#t_wt").val(tare_total);
              $("#nt_wt").val(grant - $("#t_wt").val());
            } else {
              $("#ot_wt").val("");
              //alert("tare wt is greater than gross wt");
              alert(`Dear ${userLogin}, Dynamic Dost can not save this record, Because Tare weight is MORE than Gross Weight, Correct it and save again.`);
            }

          } else {
            $("#ot_wt").val("");
            alert("check box and bag weight");
          }
        } else {
          $("#ot_wt").val("");
          alert("check Grant weight");
        }
      } else {
        $("#g_wt").val();
        $("#ot_wt").val("");
        $("#t_wt").val("");
        $("#nt_wt").val("");
      }
    }

    function calculate() {
      $("#cal_wt").val($("#cone_wt").val() * $("#no_of_cones").val());
    }


    $(function() {
      $("#lot_no").change(function() {
        var lot_no = $('#lot_no').val();
        var url = "<?= base_url() ?>store/get_lot_qty/" + lot_no;
        var postData = 'lot_no=' + lot_no;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            // console.log(result);
            var result = $.parseJSON(result);
            $("#lable_lot_qty").text(result.lot_qty);
            $("#lable_pack_qty").text(result.tot_packed_qty);
            $("#lable_bal_qty").text(result.tot_balancd_qty);

            $("#customer_id").select2("val", result.customer_id);
            $("#item_name").select2("val", result.item_id);
            $("#item_id").select2("val", result.item_id);
            // $("#colour").select2("val", result.lot_shade_no);
            $("#shade_no").select2("val", result.lot_shade_no);
            // $("#shade_no").val(result.lot_shade_no);

            $("#lbl_cust_name").html(result.cust_name);
            $("#lbl_item_name").html(result.item_name);
            $("#lbl_shade_code").html(result.shade_code);
            $("#lbl_shade_name").html(result.shade_name);
            $("#lbl_lot_qty").html(result.lot_qty);
          }
        });
        return false;
      });
    });

    $(".search-term").change(function() {
      var customer_id = $("#customer_id").val();
      // alert($("#colour_code").val());
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('store/get_lot_list'); ?>",
        dataType:"html",
        data: {
          customer_id: customer_id,
          shade_id: $("#shade_no").val(),
          item_id: $("#item_id").val()
        },
        beforeSend: function(data) {
          // $(".ajax-loader").css('display', 'block');
        },
        success: function(data) {
          // console.log(data);
          $("#lot_no").select2('destroy');
          $("#lot_no").html(data);
          $("#lot_no").select2();
        }
      });
    });

    $("#g_wt").on('blur', function(evt) {
      if ($(this).val().trim()) {
        var txt = $(this).val().replace(/\s/g, '');
        var n = parseFloat(txt, 10);
        var formatted = n.toLocaleString('en', {
          minimumFractionDigits: 3,
          maximumFractionDigits: 3
        }).replace(/,/g, ' ');
        $(this).val(formatted);
      }
    });
  </script>

</body>

</html>