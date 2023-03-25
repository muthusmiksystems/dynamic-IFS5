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
                <h3><i class="icon-truck"></i> Inter Department Transfer</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>poy/yarn_delivery_save">
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
                    <label>Issue No : </label>
                    <span class="label label-danger" style="padding: 0 1em;font-size:24px;"><?= $delivery_no; ?></span>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="delivery_from">Delivery From</label>
                    <select class="select2 form-control" id="delivery_from" name="delivery_from" required>
                      <option value="">Select</option>
                      <?php
                      foreach ($departments as $row) {
                      ?>
                        <option value="<?= $row['dept_id']; ?>"><?= $row['dept_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    From Staff
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="delivery_to">Delivery To</label>
                    <select class="select2 form-control" id="delivery_to" name="delivery_to" required>
                      <option value="">Select</option>
                      <?php
                      foreach ($departments as $row) {
                      ?>
                        <option value="<?= $row['dept_id']; ?>"><?= $row['dept_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    To Staff
                  </div>
                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-2">
                    <label for="item_name">Item Name</label>
                    <select class="select2 form-control itemsselects" id="item_name" name="item_name" required>
                      <option value="">Select</option>
                      <?php
                      foreach ($items as $row) {
                      ?>
                        <option value="<?= $row['item_id']; ?>"><?= $row['item_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="item_id">Item Code</label>
                    <select class="select2 form-control itemsselects" id="item_id" name="item_id" required>
                      <option value="">Select</option>
                      <?php
                      foreach ($items as $row) {
                      ?>
                        <option value="<?= $row['item_id']; ?>"><?= $row['item_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="poy_denier">POY Denier</label>
                    <select class="select2 form-control" id="poy_denier" name="poy_denier">
                      <option value="">Select</option>
                      <?php
                      foreach ($poy_deniers as $row) {
                      ?>
                        <option value="<?= $row['denier_id']; ?>"><?= $row['denier_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="yarn_denier">Yarn Denier</label>
                    <select class="select2 form-control" id="yarn_denier" name="yarn_denier">
                      <option value="">Select</option>
                      <?php
                      foreach ($yarn_deniers as $row) {
                      ?>
                        <option value="<?= $row['denier_id']; ?>"><?= $row['denier_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="po_qty">Qty</label>
                    <input type="text" class="form-control" id="po_qty" name="po_qty">
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="item_uom">UOM</label>
                    <select class="select2 form-control" id="item_uom" name="item_uom">
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
                  <div class="form-group col-lg-1">
                    <label>&nbsp;</label>
                    <div style="clear:both;"></div>
                    <button class="btn btn-primary" type="button" id="addtocart">Add</button>
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
            // echo "<pre>";
            // print_r($yarn_delivery);
            // echo "</pre>";
            ?>
            <section class="panel">
              <header class="panel-heading">
                Summery
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>Issue No</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Qty</th>
                    <th>Uom</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($yarn_delivery as $row) {
                    $delivery_id = $row['delivery_id'];
                    $is_accepted = $row['is_accepted'];
                    if ($delivery_id != '') {
                  ?>
                      <tr class="odd gradeX">
                        <td><?= $sno; ?></td>
                        <td><?= $row['delivery_id']; ?></td>
                        <td><?= $row['from_dept']; ?></td>
                        <td><?= $row['to_dept']; ?></td>
                        <td><?= $row['delivery_date_time']; ?></td>
                        <td><?= $row['tatalqty']; ?></td>
                        <td><?= $row['uom_name']; ?></td>
                        <td>
                          <span class="<?= ($is_accepted == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($is_accepted == 1) ? 'Accepted' : 'Not Accepted'; ?></span>
                        </td>
                        <td><label class="btn btn-xs btn-primary" onclick="get_detail(<?= $row['delivery_id']; ?>)">Detail</label></td>
                      </tr>
                  <?php
                    }
                    $sno++;
                  }
                  ?>
                </tbody>
              </table>
            </section>


            <section class="panel">
              <header class="panel-heading">
                Detail
              </header>
              <table class="table table-striped border-top">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>Issue No</th>
                    <th>Item Name</th>
                    <th>Item code</th>
                    <th>POY denier</th>
                    <th>Yarn denier</th>
                    <th>Qty</th>
                  </tr>
                </thead>
                <tbody id="Detail_table">

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
    $('#po_cartitems').load('<?= base_url(); ?>poy/yarn_del_cartitems');
    $(".itemsselects").change(function() {
      $(".itemsselects").select2("val", $(this).val());
    });
    $(function() {
      $("#sup_group_id").change(function() {
        var sup_group_id = $('#sup_group_id').val();
        var url = "<?= base_url() ?>poy/getsuppliers/" + sup_group_id;
        var postData = 'sup_group_id=' + sup_group_id;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            $("#supplier_id").html('<option value="">Select</option>');
            $("#poy_lot").html('<option value="">Select</option>');
            $("#poy_denier").html('<option value="">Select</option>');
            $("#supplier_id").select2("val", '');
            $("#poy_lot").select2("val", '');
            $("#poy_denier").select2("val", '');
            $("#supplier_id").html(result);
          }
        });
        return false;
      });
    });
    $(function() {
      $("#supplier_id").change(function() {
        var supplier_id = $('#supplier_id').val();
        var url = "<?= base_url() ?>poy/getsupplierDeniers/" + supplier_id;
        var postData = 'supplier_id=' + supplier_id;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            $("#poy_denier").html('<option value="">Select</option>');
            $("#poy_lot").html('<option value="">Select</option>');
            $("#poy_denier").select2("val", '');
            $("#poy_lot").select2("val", '');
            $("#poy_denier").html(result);
          }
        });
        return false;
      });
    });
    $(function() {
      $("#poy_denier").change(function() {
        var poy_denier = $('#poy_denier').val();
        var url = "<?= base_url() ?>poy/getpoylots/" + poy_denier;
        var postData = 'poy_denier=' + poy_denier;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            $("#poy_lot").html('<option value="">Select</option>');
            $("#poy_lot").select2("val", '');
            $("#poy_lot").html(result);
          }
        });
        return false;
      });
    });
    $(function() {
      $("#addtocart").click(function() {
        var item_id = $('#item_id').val();
        var yarn_denier = $('#yarn_denier').val();
        var poy_denier = $('#poy_denier').val();
        var po_qty = $('#po_qty').val();
        var item_uom = $('#item_uom').val();
        var url = "<?= base_url() ?>poy/yarn_del_addtocart";
        var postData = 'item_id=' + item_id + '&yarn_denier=' + yarn_denier + "&poy_denier=" + poy_denier + "&po_qty=" + po_qty + "&item_uom=" + item_uom;
        $.ajax({
          type: "POST",
          url: url,
          data: postData,
          success: function(result) {
            $('#po_cartitems').load('<?= base_url(); ?>poy/yarn_del_cartitems');
          }
        });
        return false;
      });
    });
    $(function() {
      $("a.removetocart").live("click", function() {
        // alert('hi');
        var row_id = $(this).attr('id');
        var url = "<?= base_url() ?>poy/yarn_del_removetocart/" + row_id;
        var postData = 'row_id=' + row_id;
        $.ajax({
          type: "POST",
          url: url,
          success: function(msg) {
            $('#po_cartitems').load('<?= base_url(); ?>poy/yarn_del_cartitems');
          }
        });
        return false;
      });
    });


    function get_detail(po_no) {
      $.ajax({
        type: "POST",
        url: "<?= base_url(); ?>poy/yarn_detail/" + po_no,
        success: function(e) {
          $("#Detail_table").html(e);
        }
      });
    }
  </script>

</body>

</html>