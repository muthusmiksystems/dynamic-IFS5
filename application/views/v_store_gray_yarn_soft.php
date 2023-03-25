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
                <h3>Soft Yarn Packing Entry</h3>
              </header>
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
            </section>
          </div>
        </div>

        <?php
        $t_wt = 0;
        $supplier_name = '';
        $poy_denier = '';
        $denier_name = '';
        $item_id = '';
        $item_name = '';
        $poy_lot_id = '';
        $poy_lot_no = '';
        $yarn_denier = '';
        $yarn_lot_id = '';
        $cone_weight = '';
        $no_of_cones = '0';
        $cone_weight_2 = '';
        $no_of_cones_2 = '0';
        $tot_cone_weight_2 = '';
        if (isset($id)) {
          $result = $this->m_masters->getmasterdetails('bud_yt_packing_boxes', 'box_id', $id);
          foreach ($result as $row) {
            $item_id = $row['item_id'];
            $edit_box_no = $row['box_no'];
            $poy = $row['poy_denier'];
            $poy_inward_no = $row['poy_inward_no'];
            $poy_lot_id = $row['poy_lot_id'];
            $yarn = $row['yarn_denier'];
            $shade = $row['shade_no'];
            $grant_wt = $row['gross_weight'];
            $net_wt = $row['net_weight'];
            $lot_wastage = $row['lot_wastage'];
            $packed_by = $row['packed_by'];
            $date = $row['packed_date'];
            $box_weight = $row['box_weight'];
            $no_of_box = $row['no_boxes'];
            $poly_bag = $row['poly_bag_weight'];
            $no_of_poly_bag = $row['no_bags'];
            $other_weight = $row['other_weight'];
            $spring_weight = $row['spring_weight'];
            $stock_room_id = $row['stock_room_id'];
            $poy_inward_no = $row['poy_inward_no'];
            $yarn_lot_id = $row['yarn_lot_id'];
            $remark = $row['remarks'];

            $cone_weight = $row['cone_weight'];
            $no_of_cones = $row['no_cones'];

            $cone_weight_2 = $row['cone_weight_2'];
            $no_of_cones_2 = $row['no_of_cones_2'];
            $tot_cone_weight_2 = $row['tot_cone_weight_2'];
          }
          // $t_wt = ($box_weight * $no_of_box) + ($poly_bag * $no_of_poly_bag) + $other_weight;
          $t_wt = $grant_wt - $net_wt;
          $next = $id;
        } else {
          $id = '';
          $item_id = '';
          $poy = '';
          $yarn = '';
          $remark = '';
          $shade = '';
          $grant_wt = '';
          $net_wt = '';
          $lot_wastage = '';
          $packed_by = '';
          $date = '';
          $box_weight = '';
          $no_of_box = '1';
          $poly_bag = '';
          $no_of_poly_bag = '0';
          $other_weight = '0';
          $poy_inward_no = '';
          $poy_lot_id = '';
          $spring_weight = '0';
          $stock_room_id = '';
          $poy_inward_no = '';
          $yarn_lot_id = '';
        }

        $inward_qty = 0.000;
        $tot_packed_qty = 0.000;
        $tot_balancd_qty = 0.000;
        $tot_wastage_qty = 0.000;
        $percentage = 0;
        if (!empty($poy_inward_no)) {
          if (!empty($poy_inward_no)) {

            $poy_inward = $this->m_poy->get_poy_inward($poy_inward_no);
            if (sizeof($poy_inward) > 0) {
              foreach ($poy_inward as $row) {
                $inward_items = $row->inward_items;
                /*echo "<pre>";
                        print_r($inward_items);
                        echo "</pre>";*/
                if (sizeof($inward_items) > 0) {
                  foreach ($inward_items as $item) {
                    $inward_qty += $item->po_qty;
                    $poy_denier = $item->poy_denier;
                    $denier_name = $item->denier_name;
                    //$item_id = $item->item_id;
                    $item_name = $item->item_name;
                    $poy_lot_id = $item->poy_lot_id;
                    $poy_lot_no = $item->poy_lot_no;
                  }
                }

                $supplier_name = $row->group_name;
              }
            }

            $pack_qty = $this->m_masters->get_inward_pack_qty($poy_inward_no);
            if ($pack_qty) {
              if ($pack_qty->tot_packed_qty > 0) {
                $tot_packed_qty = $pack_qty->tot_packed_qty;
                $tot_wastage_qty = $pack_qty->tot_wastage_qty;
              }
            }
          }
          $tot_balancd_qty = $inward_qty - ($tot_packed_qty + $tot_wastage_qty);
          if ($inward_qty > 0) {
            // $percentage = (($tot_packed_qty - $inward_qty) / $inward_qty) * 100;
            if ($tot_wastage_qty > 0) {
              $percentage = ($tot_wastage_qty / $tot_packed_qty) * 100;
            }
          }

          $inward_qty = number_format($inward_qty, 3, '.', '');
          $tot_packed_qty = number_format($tot_packed_qty, 3, '.', '');
          $tot_balancd_qty = number_format($tot_balancd_qty, 3, '.', '');
        }

        if (!empty($edit)) {
          $box_no = $edit_box_no;
        }
        ?>
        <div class="row">
          <div class="col-lg-12">
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>store/gray_yarn_soft_save">
              <input type="hidden" name="id" value="<?= $id; ?>">
              <section class="panel">
                <header class="panel-heading">
                  <div class="form-group col-lg-12">
                    <label>Box No : </label>
                    <span class="label label-danger" style="padding: 0 1em;font-size:24px;">S<?= $box_no; ?></span>
                  </div>
                </header>
                <div class="panel-body">
                  <div class="form-group col-lg-2">
                    <label>POY Denier</label>
                    <select class="form-control select2" name="poy_denier" id="poy_denierr">
                      <option value="">Select</option>
                      <?php
                      foreach ($denier as $row) {
                      ?>
                        <option value="<?= $row->denier_id; ?>" <?= ($row->denier_id == $poy) ? 'selected="selected"' : ''; ?>><?= $row->denier_name; ?> / <?= $row->denier_id; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-2">
                    <label>Poy Inward No</label>
                    <select class="form-control select2" name="poy_inward_no" id="poy_inward_no">
                      <option value="">Select</option>
                      <?php
                      foreach ($poy_inwards as $row) {
                      ?>
                        <option value="<?= $row->po_no; ?>" <?= ($row->po_no == $poy_inward_no) ? 'selected="selected"' : ''; ?>><?= $row->po_no; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">POY Inward Qty</label><br>
                    <span class="label label-primary" id="label_inward_qty" style="padding: 0 1em;font-size:24px;"><?= $inward_qty; ?></span>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Total Lot Packed Qty</label><br>
                    <span class="label label-warning" id="label_pack_qty" style="padding: 0 1em;font-size:24px;"><?= $tot_packed_qty; ?></span>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date">Balance Lot Qty</label><br>
                    <span class="label label-danger" id="label_bal_qty" style="padding: 0 1em;font-size:24px;"><?= $tot_balancd_qty; ?></span>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="label_tot_wastage_qty">Wastage Qty</label><br>
                    <span class="label label-danger" id="label_tot_wastage_qty" style="padding: 0 1em;font-size:24px;"><?= $tot_balancd_qty; ?></span>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_date" class="text-danger">This Lot Wastage Qty</label><br>
                    <input class="form-control" name="lot_wastage" id="lot_wastage" value="<?= $lot_wastage; ?>" type="text" style="color:red;font-weight:bold;">
                  </div>

                  <div class="form-group col-lg-1">
                    <label for="po_date" class="text-danger">%</label><br>
                    <span class="label label-danger" id="label_percentage" style="padding: 0 1em;font-size:24px;"><?= number_format($percentage, 2, '.', ''); ?></span>
                  </div>

                  <div style="clear:both;"></div>


                  <div class="form-group col-md-6">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-danger">Supplier</th>
                          <th class="text-danger">Poy Denier</th>
                          <th class="text-danger">Poy Lot No</th>
                          <th class="text-danger">Item Name</th>
                          <th class="text-danger">Qty</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td id="lbl_supplier_name"><?php echo $supplier_name; ?></td>
                          <td id="lbl_denier_name"><?php echo $denier_name; ?></td>
                          <td id="lbl_poy_lot_no"><?php echo $poy_lot_no; ?></td>
                          <td id="lbl_item_name"><?php echo $item_name; ?></td>
                          <td id="lbl_inw_qty"><?php echo $inward_qty; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="form-group col-md-2 hide">
                    <label for="supplier_id">Supplier</label>
                    <select class="search-term form-control select2" id="supplier_id" name="supplier_id">
                      <option value="">Select Supplier</option>
                      <?php if (sizeof($suppliers) > 0) : ?>
                        <?php foreach ($suppliers as $supplier) : ?>
                          <option value="<?php echo $supplier->sup_id; ?>" <?php echo ($supplier->sup_id == $supplier_id) ? 'selected="selected"' : ''; ?>><?php echo $supplier->sup_name; ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2 hide">
                    <label for="poy_lot_id">POY Lot No</label>
                    <select class="search-term form-control select2" id="poy_lot_id" name="poy_lot_id">
                      <option value="">Select POY Lot</option>
                      <?php if (sizeof($poy_lots) > 0) : ?>
                        <?php foreach ($poy_lots as $poy_lot) : ?>
                          <option value="<?php echo $poy_lot->poy_lot_id ?>" <?php echo ($poy_lot->poy_lot_id == $poy_lot_id) ? 'selected="selected"' : ''; ?>><?php echo $poy_lot->poy_lot_no; ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>

                  <div style="clear:both;"></div>
                  <div class="form-group col-md-2">
                    <label for="yarn_lot_id">Chandren Yarn Lot No</label>
                    <!-- <select class="search-term form-control select2" id="yarn_lot_id" name="yarn_lot_id"> -->
                    <select class="form-control select2 yarn_lot_id_filter" id="yarn_lot_id" name="yarn_lot_id" required>
                      <option value="">Select POY Lot</option>
                      <?php if (sizeof($yarn_lots) > 0) : ?>
                        <?php foreach ($yarn_lots as $yarn_lot) : ?>
                          <option data-id="<?= $yarn_lot->yarn_lot_id; ?>" value="<?= $yarn_lot->yarn_lot_id . '**' . $yarn_lot->yarn_lot_name . '**' . $yarn_lot->yarn_denier_name . ' / ' . $yarn_lot->yarn_denier . '**' . $yarn_lot->poy_denier_name . '**' . $yarn_lot->yarn_lot_poyinwardno; ?>" <?= ($yarn_lot->yarn_lot_id . '**' . $yarn_lot->yarn_lot_name . '**' . $yarn_lot->yarn_denier_name . ' / ' . $yarn_lot->yarn_denier . '**' . $yarn_lot->poy_denier_name . '**' . $yarn_lot->yarn_lot_poyinwardno == $yarn_lot_id || $yarn_lot->yarn_lot_id == $yarn_lot_id) ? 'selected="selected"' : ''; ?>><?= $yarn_lot->yarn_lot_no; ?> / CL<?= $yarn_lot->yarn_lot_id; ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-danger">Final Yarn Denier</th>
                          <th class="text-danger">Poy Denier</th>
                          <th class="text-danger">Poy Inward No</th>
                          <th class="text-danger">Poy Lot No</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <?php
                          $lbl_3_final_yarn_denier = '';
                          $lbl_3_poy_denier = '';
                          $lbl_3_poy_inward_no = '';
                          if (!empty($yarn_lot_id)) {
                            $yarn_lot_id3 = explode('**', $yarn_lot_id);
                            if (is_array($yarn_lot_id3)) {
                              $lbl_3_final_yarn_denier = @$yarn_lot_id3[2];
                              $lbl_3_poy_denier = @$yarn_lot_id3[3];
                              $lbl_3_poy_inward_no = @$yarn_lot_id3[4];
                            }
                          }
                          ?>
                          <td id="lbl_3_final_yarn_denier"><?= $lbl_3_final_yarn_denier; ?></td>
                          <td id="lbl_3_poy_denier"><?= $lbl_3_poy_denier; ?></td>
                          <th class="text-danger" id="lbl_3_poy_inward_no"><?= $lbl_3_poy_inward_no; ?></th>
                          <td id="lbl_3_poy_lot_no"></td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="text-danger setmsgforunmatch" style="font-weight: bold;font-size: 15pt;"></div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="text-danger">Click for poy inward from chandren lot Master</div><br>
                    <a class="btn btn-xs btn-danger" target="_blank" href="<?= base_url(); ?>poy/yarn_lots">View</a>
                  </div>

                  <div style="clear:both;"></div>
                  <!-- <p class="text-danger" style="font-weight:bold;">Supplier &emsp;&emsp;  Poy Denier &emsp;&emsp;  Poy Lot No  &emsp;&emsp;   Item Name  &emsp;&emsp; Qty</p> -->
                  <div class="form-group col-lg-2">
                    <label for="item_name">Item Name</label>
                    <select class="item-select form-control select2" id="item_name" name="item_name">
                      <option value="">Select Item</option>
                      <?php
                      foreach ($items as $item) {
                      ?>
                        <option value="<?= $item['item_id']; ?>" <?= ($item['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $item['item_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="item_id">Item Id</label>
                    <select class="item-select form-control select2" id="item_id" name="item_id">
                      <option value="">Select Item</option>
                      <?php
                      foreach ($items as $item) {
                      ?>
                        <option value="<?= $item['item_id']; ?>" <?= ($item['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $item['item_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-2 hide">
                    <label for="po_category">Poy denier</label>
                    <select class="search-term form-control select2" name="poy_deniers" id="poy_denier" required>
                      <option value="">Select denier</option>
                      <?php
                      foreach ($poydeniers as $row) {
                      ?>
                        <option value="<?= $row['denier_id']; ?>" <?= ($row['denier_id'] == $poy) ? 'selected="selected"' : ''; ?>><?php echo $row['denier_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_category">Yarn Quality</label>
                    <!-- <select class="search-term form-control select2" name="yarn_denier" id="yarn_denier" required> -->
                    <select class="form-control select2" name="yarn_denier" id="yarn_denier" required>
                      <option value="">Select denier</option>
                      <?php
                      foreach ($yarndeniers as $row) {
                      ?>
                        <option value="<?= $row['denier_id']; ?>" <?= ($row['denier_id'] == $yarn) ? 'selected="selected"' : ''; ?>><?php echo $row['denier_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>



                  <div style="clear:both"></div>

                  <div class="row col-md-12">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="po_date" class="gross-weight-lbl">Gross Weight</label>
                        <input class="form-control gross-weight" id="g_wt" name="g_wt" value="<?= $grant_wt; ?>" type="number" required>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <?php
                      $shade_ids = '';
                      $shade_code = '';
                      if (sizeof($shades) > 0) :
                        foreach ($shades as $row) :
                          $selected = ($row['shade_id'] == $shade) ? 'selected="selected"' : '';
                          $shade_ids .= '<option value="' . $row['shade_id'] . '" ' . $selected . '>' . $row['shade_name'] . ' / ' . $row['shade_id'] . '</option>';
                          $shade_code .= '<option value="' . $row['shade_id'] . '" ' . $selected . '>' . $row['shade_code'] . '</option>';
                        endforeach;
                      endif; ?>

                      <div class="form-group col-lg-6">
                        <label for="po_category">Shade Name/Code</label>
                        <select class="select2 shade-select form-control" name="colour" id="colour" required>
                          <option value="">Select</option>
                          <?php echo $shade_ids; ?>
                        </select>
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="po_category">Shade No</label>
                        <select class="select2 shade-select form-control" id="colour_code" required>
                          <option value="">Select</option>
                          <?php echo $shade_code; ?>
                        </select>
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="spring_weight">Springs</label>
                        <input class="form-control" name="spring_weight" id="spring_weight" value="<?= $spring_weight; ?>">
                      </div>
                      <div class="form-group col-lg-6">
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
                    </div>
                  </div>
                  <div style="clear:both"></div>


                  <br />

                  <div class="form-group col-lg-4">
                    <label for="po_category">Box Weight</label>
                    <select class="form-control select2" name="box_weight" id="b_wt" required>
                      <option value="0">Select Box</option>
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
                    <label for="po_date">No of boxe(s)</label>
                    <input class="form-control" id="n_bx" name="no_of_box" value="<?= $no_of_box; ?>" type="text" onkeyup="total_box()" required>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="po_date">Total Box weight</label>
                    <input class="form-control" id="t_bx" value="<?= ($box_weight * $no_of_box); ?>" type="text" required readonly>
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="po_category">Poly Bag Weight</label>
                    <select class="form-control select2" name="poly_bag" id="p_wt" required>
                      <option value="0">Select Box</option>
                      <?php
                      foreach ($tareweights as $row) {
                      ?>
                        <option value="<?= $row['tareweight_value']; ?>" <?= ($row['tareweight_value'] == $poly_bag) ? 'selected="selected"' : ''; ?>><?= $row['tareweight_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>


                  <div class="form-group col-lg-4">
                    <label for="po_date">No of Bags</label>
                    <input class="form-control" name="no_of_poly_bag" id="n_bg" value="<?= $no_of_poly_bag; ?>" type="text" onkeyup="total_bag()" required>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="po_date">Total Bag Weight</label>
                    <input class="form-control" id="t_bg" value="<?= ($poly_bag * $no_of_poly_bag); ?>" type="text" required readonly>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <!-- Cone Weight -->
                      <div class="form-group col-lg-4">
                        <label for="cone_weight">Spring Weight</label>
                        <select class="form-control select2" name="cone_weight" id="cone_weight" required>
                          <option value="0">Select Box</option>
                          <?php
                          foreach ($tareweights as $row) {
                          ?>
                            <option value="<?= $row['tareweight_value']; ?>" <?= ($row['tareweight_value'] == $cone_weight) ? 'selected="selected"' : ''; ?>><?= $row['tareweight_name']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group col-lg-4">
                        <label for="no_of_cones">No of Springs</label>
                        <input class="form-control" name="no_of_cones" id="no_of_cones" value="<?= $no_of_cones; ?>" type="text" onkeyup="total_cones()" required>
                      </div>

                      <div class="form-group col-lg-4">
                        <label for="tot_cone_weight">Total Spring Weight</label>
                        <input class="form-control" id="tot_cone_weight" value="<?= ($cone_weight * $no_of_cones); ?>" type="text" required readonly>
                      </div>
                      <!-- End Cone Weight -->
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <!-- Cone Weight 2 -->
                      <div class="form-group col-lg-4">
                        <label for="cone_weight_2">Cone Spring 2</label>
                        <select class="form-control select2" name="cone_weight_2" id="cone_weight_2" required>
                          <option value="0">Select Box</option>
                          <?php
                          foreach ($tareweights as $row) {
                          ?>
                            <option value="<?= $row['tareweight_value']; ?>" <?= ($row['tareweight_value'] == $cone_weight_2) ? 'selected="selected"' : ''; ?>><?= $row['tareweight_name']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group col-lg-4">
                        <label for="no_of_cones_2">No of Springs 2</label>
                        <input class="form-control" name="no_of_cones_2" id="no_of_cones_2" value="<?= $no_of_cones_2; ?>" type="number" onkeyup="total_cones_2()" required>
                      </div>
                      <div class="form-group col-lg-4">
                        <label for="tot_cone_weight_2">Total Spring Weight 2</label>
                        <input class="form-control" id="tot_cone_weight_2" value="<?= ($cone_weight_2 * $no_of_cones_2); ?>" type="text" required readonly>
                      </div>
                    </div>
                    <!-- End Cone Weight 2 -->
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="po_date">Other Weight</label>
                    <input class="form-control" name="other_weight" id="ot_wt" value="<?= $other_weight; ?>" type="text" required min="-1" onkeyup="tare_wt()">
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="po_date">Net Weight</label>
                    <input class="form-control" id="nt_wt" name="nt_wt" value="<?= $net_wt; ?>" type="text" required readonly>
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="po_date">Tare Weight</label>
                    <input class="form-control" id="t_wt" name="t_wt" value="<?= $t_wt; ?>" type="text" readonly>
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="po_date">Remarks : </label>
                    <textarea name="remark" class="form-control" style="resize: vertical;" required="required"><?= $remark; ?></textarea>
                  </div>
                  <input type="hidden" id="pack_by" name="pack_by" value="<?= $this->session->userdata('display_name'); ?>">
                </div>
              </section>

              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger matchlimit" type="submit" name="action" value="save" id="submit">Save</button>
                  <button class="btn btn-danger matchlimit" type="submit" name="action" value="duplicate">Duplicate</button>
                  <button class="btn btn-warning matchlimit" type="submit" name="action" value="save_continue">Save &amp; Continue</button>
                  <button class="btn btn-warning matchlimit" type="submit" name="action" value="save_continue_p">Save &amp; Continue with Print</button>
                  <button class="btn btn-default" type="button">Cancel</button>
                </header>
              </section>
            </form>
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
          </div>
        </div>
        <!-- page end-->

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
                <th>Yarn Quality</th>
                <th>Chandren Yarn Lot No</th>
                <th>Item Name/Code</th>
                <th>Colour Name /ID /Code</th>
                <th>POY Denier</th>
                <th>POY Lot</th>
                <th>Gr.Weight</th>
                <th>Net Weight</th>
                <th>Lot Wastage</th>
                <th>Stock Room </th>
                <th>Remarks </th>
                <th>Packed By</th>
                <th></th>
              </tr>
            </thead>

            <?php
            $sno = 1;
            foreach ($gray_yarn_soft as $row) {
              $box_id = $row['box_id'];
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
              $yarn_lot_no = @explode('**', $row['yarn_lot_id'])[0];
              ?>
              <script>
                data.push(['<?= $sno; ?>', '<?= $row['packed_date']; ?>', 'S<?= $row['box_no']; ?>', '<?= $row['denier_tech']; ?>', '<?= ($yarn_lot_no != '') ? 'CL' . $yarn_lot_no : 'N/A'; ?>', '<?= $row['item_name']; ?>/<?= $row['item_id']; ?>', '<?= $row['shade_name']; ?> / <?= $row['shade_id']; ?> / <?= $row['shade_code']; ?> ', '<?= $row['poy_denier_name']; ?>', '<?= $row['poy_lot_name']; ?>', '<?= $row['gross_weight']; ?>', '<?= $row['net_weight']; ?>', '<?= $row['lot_wastage']; ?>', '<?= $stock_room_name; ?>', '<?= $row['remarks']; ?>', '<?= $row['packed_by']; ?>', '<a href="<?= base_url('store/print_gray_yarn_soft/' . $box_id); ?>" target="_blank" class="btn btn-xs btn-warning" title="Print"><i class="icon-print"></i></a><a href="<?= base_url(); ?>store/gray_yarn_soft/<?= $row['box_id']; ?>/edit" class="btn btn-xs btn-primary" title="Duplicate"><i class="icon-pencil"></i></a><a href="<?= base_url(); ?>store/gray_yarn_soft/<?= $row['box_id']; ?>" class="btn btn-xs btn-success" title="Duplicate"><i class="icon-copy"></i></a><a href="#<?= $row['box_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger" title="Delete"><i class="icon-trash"></i></a><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?= $row['box_id']; ?>" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">Remarks</h4></div><div class="modal-body"><form role="form" method="post" action="<?= base_url(); ?>store/delete_packing_box/<?= $row['box_id']; ?>/gray_yarn_soft"><input type="hidden" name="box_id" value="<?= $row['box_id']; ?>"><input type="hidden" name="function_name" value="gray_yarn_soft"><div class="form-group col-lg-12" style="margin-bottom: 15px;"><textarea class="form-control" name="remarks" required style="width:100%;"></textarea></div><div style="clear:both;"></div><?= $delBtn; ?></form></div></div></div></div>']);
              </script>

            <?php
              $sno++;
            }
            ?>
          </table>
        </section>
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

      jQuery(".shade-select").change(function() {
        jQuery("#colour").select2("val", jQuery(this).val());
        jQuery("#colour_code").select2("val", jQuery(this).val());
        return false;
      });
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

    function total_cones() {
      $("#tot_cone_weight").val($("#cone_weight").val() * $("#no_of_cones").val());
    }

    function total_cones_2() {
      $("#tot_cone_weight_2").val($("#cone_weight_2").val() * $("#no_of_cones_2").val());
    }

    function tare_wt() {
      var grant = parseFloat($("#g_wt").val());
      var box = parseFloat($("#t_bx").val());
      var bag = parseFloat($("#t_bg").val());
      var tot_cone_weight = parseFloat($("#tot_cone_weight").val());
      var tot_cone_weight_2 = parseFloat($("#tot_cone_weight_2").val());
      var spring_weight = parseFloat($("#spring_weight").val());
      var other = parseFloat($("#ot_wt").val());
      var tare = parseFloat($("#t_wt").val());

      if (other >= 0) {
        if (grant >= 0) {
          if ((box >= 0) && (bag >= 0)) {
            // var tare_total = box + bag + other spring_weight +;

            var tare_total = box + bag + other + tot_cone_weight + tot_cone_weight_2;
            if (tare_total < grant) {
              $("#t_wt").val(tare_total);
              $("#nt_wt").val(grant - $("#t_wt").val());
            } else {
              $("#ot_wt").val("");
              alert("tare wt is greater than grant");
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



    $(function() {

      var lbl_3_poy_inward_no = $("#lbl_3_poy_inward_no").text();
      if (lbl_3_poy_inward_no != null) {
        var url = "<?= base_url() ?>store/get_poy_inward_qty/" + lbl_3_poy_inward_no;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            // console.log(result);
            var result = $.parseJSON(result);
            $("#lbl_3_poy_lot_no").text(result.poy_lot_no);
          }
        });
      }

      $("#submit").click(function() {
        if ($("#nt_wt").val() != "") {
          $("#commentForm").submit();
        } else {
          alert("check all the fields are filled");
        }
      })
    });

    $(".item-select").on('change', function() {
      $("#item_name").select2("val", $(this).val());
      $("#item_id").select2("val", $(this).val());
    });
    $(".color-select").on('change', function() {
      $("#colour").select2("val", $(this).val());
      $("#colour_code").select2("val", $(this).val());
    });

    $(function() {
      $("#poy_inward_no").on('change', function() {
        var poy_inward_no = $('#poy_inward_no').val();
        var url = "<?= base_url() ?>store/get_poy_inward_qty/" + poy_inward_no;
        var postData = 'poy_inward_no=' + poy_inward_no;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            // console.log(result);
            var result = $.parseJSON(result);
            $("#label_inward_qty").text(result.inward_qty);
            $("#label_pack_qty").text(result.tot_packed_qty);
            $("#label_bal_qty").text(result.tot_balancd_qty);
            $("#label_percentage").text(result.percentage);
            $("#label_tot_wastage_qty").text(result.tot_wastage_qty);
            $("#lbl_supplier_name").text(result.supplier_name);
            $("#lbl_denier_name").text(result.denier_name);
            $("#lbl_item_name").text(result.item_name);
            $("#lbl_poy_lot_no").text(result.poy_lot_no);
            $("#lbl_inw_qty").text(result.inward_qty);


            // $("#poy_lot_id").val(result.poy_lot_id);

            $("#poy_denierr").select2("val", result.poy_denier);
            // $("#item_name").select2("val", result.item_id);
            // $("#item_id").select2("val", result.item_id);
            $("#poy_lot_id").select2("val", result.poy_lot_id);
            $("#supplier_id").select2("val", result.supplier_id);
            //$("#yarn_denier").select2("val", result.yarn_denier);
            // $("#poy_denier").select2("val", result.poy_denier);
            //  $("#yarn_lot_id").select2("val", result.yarn_lot_id);
            var poy_inward_no = $("#poy_inward_no").val();
            var poy_inward_no3 = $("#lbl_3_poy_inward_no").text();
            if (poy_inward_no3 == poy_inward_no) {
              $(".setmsgforunmatch").text('');
              $(".matchlimit").show();
            } else {
              $(".setmsgforunmatch").text('WARNING TO USER : THIS BOX CAN NOT BE SAVED BECAUSE POY INWARD NUMBER AND CHANDREN LOT NUMBER IS NOT MATCHING. MATCH IT AND SAVE AGAIN');
              $(".matchlimit").hide();
            }
          }
        });
        return false;
      });
    });

    $(".search-term").on('change', function() {
      var supplier_id = $("#supplier_id").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('store/get_poy_inward_list'); ?>",
        data: {
          supplier_id: supplier_id,
          poy_lot_id: $("#poy_lot_id").val(),
          yarn_lot_id: $("#yarn_lot_id").val(),
          poy_denier: $("#poy_denier").val(),
          yarn_denier: $("#yarn_denier").val(),
        },
        beforeSend: function(data) {
          // $(".ajax-loader").css('display', 'block');
        },
        success: function(data) {
          // console.log(data);
          $("#poy_inward_no").select2('destroy');
          $("#poy_inward_no").html(data);
          $("#poy_inward_no").select2();
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

    $("#yarn_lot_id").on('change', function() {
      var str = $(this).val();
      var res = str.split("**");

      $("#lbl_3_final_yarn_denier").text(res[2]);
      $("#lbl_3_poy_denier").text(res[3]);
      $("#lbl_3_poy_inward_no").text('');
      $("#lbl_3_poy_lot_no").text('');

      if (res[4] != '') {

        var poy_inward_no = $("#poy_inward_no").val();
        if (res[4] == poy_inward_no) {
          $(".setmsgforunmatch").text('');
          $(".matchlimit").show();
        } else {
          $(".setmsgforunmatch").text('WARNING TO USER : THIS BOX CAN NOT BE SAVED BECAUSE POY INWARD NUMBER AND CHANDREN LOT NUMBER IS NOT MATCHING. MATCH IT AND SAVE AGAIN');
          $(".matchlimit").hide();
        }

        $("#lbl_3_poy_inward_no").text(res[4]);
        var url = "<?= base_url() ?>store/get_poy_inward_qty/" + res[4];
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            // console.log(result);
            var result = $.parseJSON(result);
            $("#lbl_3_poy_lot_no").text(result.poy_lot_no);
          }
        });
      }
      return false;

    });

    $("#poy_denierr").on('change', function() {
      var poy_inward_no_2 = $(this).val();
      var url = "<?= base_url() ?>store/get_poy_po_no/" + poy_inward_no_2;
      var postData = 'id=' + poy_inward_no_2;
      $.ajax({
        type: "POST",
        url: url,
        // data: postData,
        success: function(result) {
          $("#poy_inward_no").select2('destroy');
          $("#poy_inward_no").html(result);
          $("#poy_inward_no").select2();

        }
      });
      return false;
    });
  </script>

</body>

</html>