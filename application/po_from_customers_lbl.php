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
                <h3><i class="icon-truck"></i> Purchase Order From Customers</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>purchase_order/po_from_customers_lbl_save">
              <section class="panel">
                <div class="panel-body">
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

                  <div class="form-group col-lg-12">
                    <label>R PO No : </label>
                    <span class="label label-danger" style="padding: 0 1em;font-size:24px;"><?= $next; ?></span>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="exp_del_date">PO Date</label>
                    <input type="date" name="po_date" class='form-control' value="<?= date('Y-m-d'); ?>"></input>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="po_qty">Customer PO No:</label>
                    <input type="text" class="form-control" id="c_po_num" name="c_po_num">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="sales_to">Customer</label>
                    <select class="select2 form-control itemsselects" id="customer" name="customer" required>
                      <option value="">Select customer</option>
                      <?php
                      foreach ($customers as $row) {
                      ?>
                        <option value="<?= $row['cust_id']; ?>"><?= $row['cust_name'] . " - " . $row['cust_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_qty">PO Contact Name</label>
                    <input type="text" class="form-control" id="po_person" name="po_person">
                  </div>

                  <div class="form-group col-lg-2">
                    <label for="po_qty">PO Contact No</label>
                    <input type="text" class="form-control" id="po_number" name="po_number">
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="po_mkt_staff">Marketing Staff</label>
                    <select class="form-control select2" id="marketStaff" name="staff" required>
                      <option value="">Select Marketing Staff</option>
                      <?php
                      foreach ($staffs as $row) {
                      ?>
                        <option value="<?= $row['ID']; ?>"><?= $row['display_name'] . " - " . $row['ID']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="delivery_form">Delivery form</label>
                    <select class="select2 form-control" id="delivery_form" name="po_delivery_form">
                      <option value="">Select</option>
                      <option value="Roll Form">Roll Form</option>
                      <option value="Cut & Seal">Cut &amp; Seal</option>
                      <option value="Cut & Fold">Cut &amp; Fold</option>
                      <option value="Dye Cut">Dye Cut</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="exp_del_date">Delivery Date</label>
                    <input type="date" name="exp_del_date" class='form-control'></input>
                  </div>

                  <div class="form-group col-lg-5">
                    <label for="po_qty">Remarks</label>
                    <textarea cols="40" rows="3" name="remarks"></textarea>
                  </div>

                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-3">
                    <label for="item_name">Item name</label>
                    <select class="select2 form-control itemsselects" id="item_name" onchange="itemsize(this)">
                      <option value="">Select</option>
                      <?php
                      foreach ($items as $row) {
                      ?>
                        <option value="<?= $row['item_id']; ?>"><?= $row['item_name'] . " - " . $row['item_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="item_size">Item size</label>
                    <select class="form-control" id="itemSizeDetails" onchange="stock_qty(this)">
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="stock_qty">stock Qty</label>
                    <input type="text" class="form-control" id="stockDetails" value="" disabled>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="po_qty">Qty</label>
                    <input type="text" class="form-control" id="qty">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="item_uom">UOM</label>
                    <select class="select2 form-control" id="uom">
                      <option value="">Select</option>
                      <?php
                      foreach ($uoms as $row) {
                      ?>
                        <option value="<?= $row['uom_id']; ?>"><?= $row['uom_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="po_qty">Unit Rate</label>
                    <input type="text" class="form-control" id="rate">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="po_qty">Tax %</label>
                    <select class="select2 form-control" id="tax" name="tax">
                      <option value="">Select</option>
                      <?php
                      foreach ($tax as $row) {
                      ?>
                        <option value="<?= $row['tax_id']; ?>"><?= $row['tax_name'] . '-' . $row['tax_value']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-5">
                    <label for="remarks">Remarks</label>
                    <textarea cols="40" rows="3" name="remarks" id='remarks'></textarea>
                  </div>
                  <div class="form-group col-lg-1">
                    <label>&nbsp;</label>
                    <div style="clear:both;"></div>
                    <button class="btn btn-primary" type="button" id="addtotab">Add</button>
                  </div>
                </div>
                <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
              </section>
              <section class="panel">
                <header class="panel-heading">
                  Items
                </header>
                <div class="panel-body" id="po_cartitems">
                  <table class="table table-striped border-top">
                    <thead>
                      <tr>
                        <th>Sno</th>
                        <th>Item Name - Code</th>
                        <th>Item Size</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Rate</th>
                        <th>Tax</th>
                        <th>Remarks</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="add_values">
                    </tbody>
                  </table>
                  <input type="hidden" name="user" value="<?= $this->session->userdata('user_id'); ?>">
                  <input type="hidden" name="date" value="<?= date("Y-m-d H:i:s"); ?>">

                </div>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit">Save</button>
                  <a href="<?= base_url() . 'purchase_order/po_list_lbl'; ?>" class="btn btn-default" type="button">Cancel</a>
                </header>
              </section>
            </form>
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
        var n_id = 1;
        $("#addtotab").click(function() {
          debugger;
          var item = $("#item_name :selected").text();
          var item_val = $("#item_name").val();
          var qty = $("#qty").val();
          var uom = $("#uom").val();
          var item_size = $("#itemSizeDetails").val();
          var rate = $("#rate").val();
          var tax = $("#tax").val();
          var remarks = $("#remarks").val();
          var row = "<tr id='" + n_id + "'>" +
            "<td>" + n_id + "</td>" +
            "<td>" + item + "</td><input type='hidden' name='item[]' value='" + item_val + "'>" +
            "<td>" + item_size + "</td><input type='hidden' name='item_size[]' value='" + item_size + "'>" +
            "<td>" + qty + "</td><input type='hidden' name='qty[]' value='" + qty + "'>" +
            "<td>" + uom + "</td><input type='hidden' name='uom[]' value='" + uom + "'>" +
            "<td>" + rate + "</td><input type='hidden' name='rate[]' value='" + rate + "'>" +
            "<td>" + tax + "</td><input type='hidden' name='tax[]' value='" + tax + "'>" +
            "<td>" + remarks + "</td><textarea type='hidden' name='remarks[]'>" + tax + "</textarea></td>" +
            "<td onclick='remove_row(" + n_id + ")'>Remove</td></tr>";
          $("#add_values").append(row);
          ++n_id;
        });
      });

      function remove_row(r_id) {
        var select = "#" + r_id;
        $(select).remove();
      }

      function itemsize(item_id) {
        $.ajax({
          type: "POST",
          url: "<?= base_url(); ?>purchase_order/po_item_size/" + $(item_id).val(),
          success: function(e) {
            $("#itemSizeDetails").html(e);
          }
        });
        $.ajax({
          type: "POST",
          url: "<?= base_url(); ?>purchase_order/po_item_rate/" + $(item_id).val() + '/' + $('#customer').val(),
          success: function(e) {
            $("#rate").val(e);
          }
        });
      }

      function stock_qty(item_size) {
        var item_id = $("#item_name").val();
        var size = $(item_size).val();
        size = (size == 'W/S') ? 'ws' : size;
        $.ajax({
          type: "POST",
          url: "<?= base_url(); ?>purchase_order/ps_stock_qty/" + size + "/" + item_id,
          success: function(e) {
            $("#stockDetails").val(e);
          }
        })
      }
    </script>

</body>

</html>