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
    .datepicker {
      z-index: 10000;
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
                <h3><i class="icon-user"></i> Raw Material & POY Inward</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>poy/poy_inward_save">
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
                    <label>Inward No</label>
                    <span class="label label-danger" style="font-size:24px;"><?= $inward_no; ?></span>
                    <input type="hidden" name="inward_no" value="<?= $inward_no; ?>" />
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="sup_group_id">Supplier Group</label>
                    <select class="select2 form-control" id="sup_group_id" name="sup_group_id" required>
                      <option value="">Select</option>
                      <?php
                      foreach ($supplier_groups as $row) {
                      ?>
                        <option value="<?= $row['group_id']; ?>"><?= $row['group_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="department">Sub Department</label>
                    <select class="select2 form-control" id="department" name="department" required>
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
                    <label for="item_name">Select Item Name (To be Produced)</label>
                    <select class="select2 form-control itemsselects" id="item_name" name="item_name">
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
                  <div class="form-group col-lg-3">
                    <label for="item_id">Item Code</label>
                    <select class="select2 form-control itemsselects" id="item_id" name="item_id">
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
                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-3">
                    <label for="supplier_id">Supplier</label>
                    <select class="select2 form-control" id="supplier_id" name="supplier_id" required>
                      <?php
                      foreach ($suppliers as $row) {
                      ?>
                        <option value="<?= $row['sup_id']; ?>"><?= $row['sup_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="poy_denier">R.Mat & POY dn.</label>
                    <select class="select2 form-control" id="poy_denier" name="poy_denier" required>

                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="poy_lot">R.Mat & POY Lot</label>
                    <select class="select2 form-control" id="poy_lot" name="poy_lot" required>

                    </select>
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="po_qty">Qty</label>
                    <input type="text" class="form-control" id="po_qty" name="po_qty" required>
                  </div>
                  <!--inclusion of poy item rate-->
                  <div class="form-group col-lg-2">
                    <label for="po_item_rate">Rate</label>
                    <input type="text" class="form-control" id="po_item_rate" name="po_item_rate" required>
                  </div>
                  <!--end of inclusion of poy item rate-->
                  <div class="form-group col-lg-2">
                    <label for="item_uom">UOM</label>
                    <select class="select2 form-control" id="item_uom" name="item_uom" required>
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
                    <!-- button class="btn btn-primary" type="button" id="addtocart">Add</button -->
                  </div>
                </div>
                <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
              </section>

              <!-- section class="panel">
                <header class="panel-heading">
                  Items
                </header>
                <div class="panel-body" id="po_cartitems">

                </div>
              </section -->
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
                      print_r($poy_inward);
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
                    <th>Inward No</th>
                    <th>Supplier</th>
                    <th>R.Mat & POY dn.</th>
                    <th>Sub Deprtment</th>
                    <th>Item Name<br>(To be Produced)</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Quality</th>
                    <th>Remarks</th>
                    <?php
                    /*
                    <th>Date</th>
                    <th>Time</th>
                    <th>Rate</th>
                    <th>Remarks</th>
                    */
                    ?>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($poy_inward as $row) {

                    $po_no = $row['po_no'];
                    if ($po_no != '') {
                  ?>
                      <tr class="odd gradeX">
                        <td><?= $sno; ?></td>
                        <td><?= $row['inward_no']; ?></td>
                        <td><?= $row['group_name']; ?></td>
                        <td><?= $row['denier_name']; ?></td>
                        <td><?= $row['dept_name']; ?></td>
                        <td><?= $row['item_name']; ?>/<?= $row['item_id']; ?></td>
                        <td><?= number_format((float)$row['tatalPOqty'], 3, '.', ''); ?></td>
                        <?php
                        /*                        
                        <td><?= $row['po_date']; ?></td>
                        <td><?= $row['po_time']; ?></td>
                        <td><?= number_format((float)$row['po_item_rate'], 2, '.', ''); ?></td>
                        <td><?= $row['remarks']; ?></td>
                        */
                        ?>
                        <?php
                        $fItems = @$this->ak->poy_inwd_detail($row['po_no'], 1);
                        if ($fItems) {
                          foreach ($fItems as $items) {
                        ?>
                            <td><?= number_format((float)$items['po_item_rate'], 2, '.', ''); ?></td>
                            <td><?= $items['inward_quality']; ?></td>
                            <td><?= $items['remarks']; ?></td>
                          <?php
                          }
                        } else {
                          ?>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                        <?php
                        }
                        ?>
                        <!--inclusion of poy item rate-->
                        <td>
                          <a class="btn btn-xs btn-primary" onclick="get_detail(<?= $row['po_no']; ?>)">Detail</a>
                          <!--  
                            <span class="label label-primary" onclick="get_detail(<?= $row['po_no']; ?>)">Detail</span>
                            <a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>  -->
                        </td>
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
                    <th>Inward Date</th>
                    <th>Invoice No</th>
                    <th>Inv. Date</th>
                    <th>R.Mat & POY dn.</th>
                    <th>Quality</th>
                    <th>R.Mat & POY lot</th>
                    <th>Remarks</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Inward By</th>
                    <th></th>
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


  <!-- Modal -->
  <!-- (Ajax Modal)-->
  <div class="modal fade" id="modal_ajax">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">POY Inward Update Qty</h4>
        </div>

        <div class="modal-body" style="height:500px; overflow:auto;">

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->

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

    function showAjaxModal(url) {
      // SHOWING AJAX PRELOADER IMAGE
      jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url('themes/admin/img/preloader.gif') ?>" /></div>');

      // LOADING THE AJAX MODAL
      jQuery('#modal_ajax').modal('show', {
        backdrop: 'true'
      });

      // SHOW AJAX RESPONSE ON REQUEST SUCCESS
      $.ajax({
        url: url,
        success: function(response) {
          jQuery('#modal_ajax .modal-body').html(response);

          /*$(function(){
              $('.dateplugin').datepicker({
                  format: 'dd-mm-yyyy',
                  autoclose: true
              });
          });*/
          $('.dateplugin').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
          });
        }
      });
    }

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
    $('#po_cartitems').load('<?= base_url(); ?>poy/poyInw_cartItems');
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
        var supplier_id = $('#supplier_id').val();
        var poy_denier = $('#poy_denier').val();
        var poy_lot = $('#poy_lot').val();
        var po_qty = $('#po_qty').val();
        var po_item_rate = $('#po_item_rate').val(); //inclusion of poy item rate
        var item_uom = $('#item_uom').val();
        var url = "<?= base_url() ?>poy/poyInw_addtocart";
        var postData = 'item_id=' + item_id + '&supplier_id=' + supplier_id + "&poy_denier=" + poy_denier + "&poy_lot=" + poy_lot + "&po_qty=" + po_qty + "&po_item_rate=" + po_item_rate + "&item_uom=" + item_uom; //inclusion of poy item rate
        $.ajax({
          type: "POST",
          url: url,
          data: postData,
          success: function(result) {
            $('#po_cartitems').load('<?= base_url(); ?>poy/poyInw_cartItems');
          }
        });
        return false;
      });
    });
    $(function() {
      $("a.removetocart").live("click", function() {
        // alert('hi');
        var row_id = $(this).attr('id');
        var url = "<?= base_url() ?>poy/poyInw_removetocart/" + row_id;
        var postData = 'row_id=' + row_id;
        $.ajax({
          type: "POST",
          url: url,
          success: function(msg) {
            $('#po_cartitems').load('<?= base_url(); ?>poy/poyInw_cartItems');
          }
        });
        return false;
      });
    });



    function get_detail(po_no) {
      $.ajax({
        type: "POST",
        url: "<?= base_url(); ?>poy/poy_inwd_detail/" + po_no,
        success: function(e) {
          $("#Detail_table").html(e);
        }
      });
    }

    /*$('.dateplugin').datepicker({
        format: 'dd-mm-yyyy'
    });*/
  </script>

</body>

</html>