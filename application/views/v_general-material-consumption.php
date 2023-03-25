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
                <h3><i class="icon-truck"></i> Material Consumption</h3>
              </header>
              <div class="panel-body" id="sample-box">
                <!-- Item Sample -->
              </div>
            </section>
          </div>
        </div>
        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/save_materialConsumption">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  No : <span class="label label-danger" style="font-size:14px;"><?= $next_id; ?></span>
                </header>
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
                  <div class="form-group col-lg-3">
                    <label for="item_name">Item Name</label>
                    <select class="item-select form-control select2" id="item_name" name="item_name" required>
                      <option value="">Select Item</option>
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
                    <label for="item_code">Item Code</label>
                    <select class="item-select form-control select2" id="item_code" name="item_code" required>
                      <option value="">Select Code</option>
                      <?php
                      foreach ($items as $row) {
                      ?>
                        <option value="<?= $row['item_id']; ?>"><?= $row['item_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="concern_name">Select Concern</label>
                    <select class="form-control select2" id="concern_name" name="concern_name" required>
                      <option value="">Select</option>
                      <?php
                      foreach ($concerns as $row) {
                      ?>
                        <option value="<?= $row['concern_id']; ?>"><?= $row['concern_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="stockroom_id">From Stock Room</label>
                    <select class="form-control select2" id="stockroom_id" name="stockroom_id" required>
                      <option>Select</option>
                      <?php
                      foreach ($stockrooms as $row) {
                      ?>
                        <option value="<?= $row['stock_room_id']; ?>"><?= $row['stock_room_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="current_stock">Current Stock</label>
                    <input type="text" style="padding: 6px 3px;" class="form-control" value="0" id="current_stock" name="current_stock" readonly="readonly" value="0">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="item_qty">Qty</label>
                    <input type="text" style="padding: 6px 3px;" class="form-control" id="item_qty" name="item_qty" required>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="machines">Machines</label>
                    <select class="form-control select2" id="machines" name="machines" required>
                      <option value="">Select Machines</option>
                      <?php
                      foreach ($machines as $row) {
                      ?>
                        <option value="<?= $row['machine_id']; ?>"><?= $row['machine_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="item_uom">Select</label>
                    <select class="form-control select2" id="item_uom" name="item_uom" required>
                      <option value="">Uom</option>
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
                    <label for="given_to">Custody Of</label>
                    <select class="form-control select2" id="given_to" name="given_to" required>
                      <option value="">Select</option>
                      <?php
                      foreach ($staffs as $row) {
                      ?>
                        <option value="<?= $row['ID']; ?>"><?= $row['user_login']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                  </div>
                </div>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit">Save</button>
                </header>
              </section>
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
                      <td>Sno</td>
                      <td>Concern</td>
                      <td>Item Name</td>
                      <td>Item Code</td>
                      <td>Machine</td>
                      <td>Staff Name</td>
                      <td>Custody Of</td>
                      <td>Remarks</td>
                      <td>Date / Time</td>
                      <td>Qty</td>
                      <td>UOM</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sno = 1;
                    foreach ($mat_consumption as $row) {
                    ?>
                      <script>
                        data.push(['<?= $sno; ?>', '<?= $row['concern_name']; ?>', '<?= $row['consomp_item_name']; ?>', '<?= $row['item_name']; ?>', '<?= $row['machine_name']; ?>', '<?= $row['inward_staff']; ?>', '<?= $row['custody_staff']; ?>', '<?= $row['remarks']; ?>', '<?= $row['date_time']; ?>', '<?= $row['item_qty']; ?>', '<?= $row['uom_name']; ?>']);
                      </script>

                    <?php
                      $sno++;
                    }
                    ?>
                  </tbody>
                </table>
              </section>
              <!-- Loading -->
              <div class="pageloader"></div>
              <!-- End Loading -->

              <!-- <section class="panel">
                        <header class="panel-heading">
                            Summery
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Item Name</th>
                                <th>Supplier</th>
                                <th>Date</th>
                                <th>Party Box No</th>
                                <th>Dynamic Box No</th>
                                <th>Rate</th>
                                <th>Qty</th>
                                <th>Uom</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                          <tbody>
                              <?php /*
                              $sno = 1;
                              $amount = 0;
                              foreach ($inward_list as $row) {
                                $amount = $row['item_rate'] * $row['item_qty'];
                              ?>
                                <tr>
                                  <td>
                                    <input type="checkbox" checked="checked">
                                    <?= $sno; ?>
                                  </td>
                                  <td><?= $row['item_name']; ?></td>
                                  <td><?= $row['company_name']; ?></td>
                                  <td><?= $row['inward_date']; ?></td>
                                  <td><?= $row['party_boxno']; ?></td>
                                  <td><?= $row['dynamic_box_no']; ?></td>
                                  <td><?= $row['item_rate']; ?></td>
                                  <td><?= $row['item_qty']; ?></td>
                                  <td><?= $row['uom_name']; ?></td>
                                  <td><?= number_format($amount, 2, '.', ''); ?></td>
                                </tr>
                                <?php
                                $sno++;
                              }*/
                              ?>
                          </tbody>
                        </table>
                    </section> -->
            </div>
          </div>
        </form>
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
      $('#sample_1x').DataTable({
        'data': data,
        'deferRender': true,
        'processing': true,
        'language': {
          'loadingRecords': '&nbsp;',
          'processing': 'Loading...'
        },
        "order": [
          [0, "desc"]
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

    /*var selected = new Array();
    var oTable = $('#sample_1').dataTable();
    $(oTable.fnGetNodes()).find(':checkbox').each(function () {
        $this = $(this);
        $this.attr('checked', 'checked');
        selected.push($this.val());
    });
    var mystring = selected.join();
    alert(mystring);*/

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

    $(".item-select").change(function() {
      $("#item_name").select2("val", $(this).val());
      $("#item_code").select2("val", $(this).val());
      var item_code = $(this).val();
      var url = "<?= base_url() ?>general/getItemImage/" + item_code;
      var postData = 'item_code=' + item_code;
      $.ajax({
        type: "POST",
        url: url,
        // data: postData,
        success: function(result) {
          if (result != '') {
            $("#sample-box").html('<img src="<?= base_url(); ?>uploads/itemsamples/general/' + result + '" style="width:auto;height:70px;max-width:100%;">');
          } else {
            $("#sample-box").html('');
          }
        }
      });
      return false;
    });

    $(function() {
      $("#supplier").change(function() {
        var supplier = $("#supplier").val();
        var item_name = $("#item_name").val();
        var url = "<?= base_url() ?>general/getSupplierItemRate";
        var postData = 'item_name=' + item_name + '&supplier=' + supplier;
        // alert(postData);
        $.ajax({
          type: "POST",
          url: url,
          data: postData,
          success: function(result) {
            $("#item_rate").val(result);
            // console.log(result);
          }
        });
        return false;
      });
    });

    $("#concern_name").change(function() {
      $("#stockroom_id").select2("val", '');
    });
    $(function() {
      $("#stockroom_id").change(function() {
        var stockroom_id = $("#stockroom_id").val();
        var concern_name = $("#concern_name").val();
        var item_name = $("#item_name").val();
        var url = "<?= base_url() ?>general/getGeneralStock";
        var postData = 'item_id=' + item_name + '&concern_id=' + concern_name + '&stockroom_id=' + stockroom_id;
        // alert(postData);
        $.ajax({
          type: "POST",
          url: url,
          data: postData,
          success: function(result) {
            $("#current_stock").val(result);
            // console.log(result);
          }
        });
        return false;
      });
    });
  </script>

</body>

</html>