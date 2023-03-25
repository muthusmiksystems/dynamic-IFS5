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
                <h3><i class="icon-truck"></i> Purchase Order Received From Factory</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>purchase_order/po_from_customers_save">
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
                    <label for="po_qty">Cust. EPO No. (Online)</label>
                    <input type="text" class="form-control" id="cust_epono" name="cust_epono">
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
                    <label for="po_qty">Customer Colour Name</label>
                    <input type="text" class="form-control" id="c_shade">
                  </div>

                  <div style="clear:both;"></div>

                  <div class="form-group col-lg-3">
                    <label for="item_name">Item name</label>
                    <select class="select2 form-control itemsselects" id="item_name">
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

                  <div class="form-group col-lg-3">
                    <label for="item_id">Colour Name</label>
                    <select class="select2 form-control itemsselects" id="color_name">
                      <option value="">Select</option>
                      <?php
                      foreach ($shades as $row) {
                      ?>
                        <option value="<?= $row['shade_id']; ?>"><?= $row['shade_name'] . " - " . $row['shade_code']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-3">
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
                    <input type="text" class="form-control" id="tax">
                  </div>

                  <div style="clear:both;"></div>

                  <div class="form-group col-lg-5">
                    <label for="po_qty">Remarks</label>
                    <textarea class="form-control" cols="70" rows="3" name="remarks"></textarea>
                  </div>

                  <div style="clear:both;"></div>

                  <div class="form-group col-lg-1">
                    <label>&nbsp;</label>
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
                        <th>Customer Colour Name</th>
                        <th>Colour Name - Code</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Rate</th>
                        <th>Tax</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="add_values">

                    </tbody>
                  </table>
                  <input type="hidden" name="user" value="<?= $this->session->userdata('display_name'); ?>">
                  <input type="hidden" name="date" value="<?= date("Y-m-d H:i:s"); ?>">

                </div>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit">Save</button>
                  <button class="btn btn-default" type="button">Cancel</button>
                </header>
              </section>
            </form>

            <!-- Start Talbe List  -->
            <?php
            /*echo "<pre>";
                      print_r($poy_issue);
                      echo "</pre>";*/
            ?>
            <section class="panel">
              <header class="panel-heading">
                Summery
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>R.PO NO</th>
                    <th>Online EPO NO</th>
                    <th>Date</th>
                    <th>Customer name</th>
                    <th>Contact Name</th>
                    <th>From filled by</th>
                    <th>Remark</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($table as $row) {
                  ?>
                    <tr class="odd gradeX">
                      <td><?= $sno; ?></td>
                      <td><?= $row['R_po_no']; ?></td>
                      <td><?= $row['cust_epono']; ?></td>
                      <td><?= $row['date']; ?></td>
                      <td><?= $row['cust_name']; ?></td>
                      <td><?= $row['c_name'] . " - " . $row['c_tel']; ?></td>
                      <td><?= $row['user']; ?></td>
                      <td><?= $row['remark']; ?></td>
                      <td><label class="btn btn-xs btn-success" onclick="tab_detail(<?= $row['R_po_no']; ?>)">Details</label></td>
                    </tr>
                  <?php
                    $sno++;
                  }
                  ?>
                </tbody>
              </table>
            </section>


            <section class="panel">
              <header class="panel-heading">
                Details
              </header>
              <table class="table table-striped border-top">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>R.PO NO</th>
                    <th>Online EPO NO</th>
                    <th>Item Name</th>
                    <th>Customer Colour</th>
                    <th>Colour Name</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th>Unit Rate</th>
                    <th>Tax</th>
                  </tr>
                </thead>
                <tbody id="tab_details">
                </tbody>
              </table>
            </section>
            <!-- End Talbe List  -->
          </div>
        </div>
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

    $(function() {
      var n_id = 1;
      $("#addtotab").click(function() {
        debugger;
        var item = $("#item_name :selected").text();
        var item_val = $("#item_name").val();
        var c_shade = $("#c_shade").val();
        var color = $("#color_name :selected").text();
        var color_val = $("#color_name").val();
        var qty = $("#qty").val();
        var uom = $("#uom").val();
        var rate = $("#rate").val();
        var tax = $("#tax").val();

        var row = "<tr id='" + n_id + "'>" +
          "<td>" + n_id + "</td>" +
          "<td>" + item + "</td><input type='hidden' name='item[]' value='" + item_val + "'>" +
          "<td>" + c_shade + "</td><input type='hidden' name='c_shade[]' value='" + c_shade + "'>" +
          "<td>" + color + "</td><input type='hidden' name='colour[]' value='" + color_val + "'>" +
          "<td>" + qty + "</td><input type='hidden' name='qty[]' value='" + qty + "'>" +
          "<td>" + uom + "</td><input type='hidden' name='uom[]' value='" + uom + "'>" +
          "<td>" + rate + "</td><input type='hidden' name='rate[]' value='" + rate + "'>" +
          "<td>" + tax + "</td><input type='hidden' name='tax[]' value='" + tax + "'>" +
          "<td onclick='remove_row(" + n_id + ")'>Remove</td></tr>";
        $("#add_values").append(row);
        ++n_id;
      });
    });

    function remove_row(r_id) {
      var select = "#" + r_id;
      $(select).remove();
    }

    function tab_detail(id) {
      $.ajax({
        type: "POST",
        url: "<?= base_url(); ?>purchase_order/po_from_customers_table_details/" + id,
        success: function(e) {
          $("#tab_details").html(e);
        }
      })
    }
  </script>

</body>

</html>