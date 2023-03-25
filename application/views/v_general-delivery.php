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
                <h3><i class="icon-truck"></i> General Delivery</h3>
              </header>
              <div class="panel-body" id="sample-box">
                <!-- Item Sample -->
              </div>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Select Items
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
                <div class="form-group col-lg-2">
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
                  <label for="supplier">Supplier</label>
                  <select class="form-control select2" id="supplier" name="supplier" required>
                    <option value="">Select Supplier</option>
                    <?php
                    foreach ($suppliers as $row) {
                    ?>
                      <option value="<?= $row['company_id']; ?>"><?= $row['company_name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group col-lg-2">
                  <label for="item_rate">Rate</label>
                  <input type="text" class="form-control" id="item_rate" name="item_rate" required>
                </div>
                <div class="form-group col-lg-1">
                  <label for="item_qty">Qty</label>
                  <input type="text" style="padding: 6px 3px;" class="form-control" id="item_qty" name="item_qty" required>
                </div>
                <div class="form-group col-lg-1">
                  <label for="item_uom">Uom</label>
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
              </div>
            </section>
            <section class="panel">
              <header class="panel-heading">
                <button class="btn btn-danger addtocart" type="button">Add to List</button>
                <button class="btn btn-default" type="button">Cancel</button>
              </header>
            </section>
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/generalDcGenerate">
              <!-- Start Item List -->
              <section class="panel">
                <header class="panel-heading">
                  Selected Items
                </header>
                <div class="panel-body">
                  <table class="table table-striped table-hover" id="cartdata">
                    <?php $this->load->view('v_general-delivery-items'); ?>
                  </table>
                </div>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit">Next</button>
                </header>
              </section>
              <!-- End Item List -->
            </form>
            <?php
            /*echo "<pre>";
                    print_r($general_dc);
                    echo "</pre>";*/
            ?>
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
                    <th>Dc No</th>
                    <th>DC From</th>
                    <th>DC To</th>
                    <th># of Items</th>
                    <th>Total Qty</th>
                    <th>Total Received</th>
                    <th>Type</th>
                    <th>DC Date</th>
                    <th>Remarks</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  $total_received = 0;
                  foreach ($general_dc as $row) {
                    $delivery_id = $row['delivery_id'];
                    $dc_date_time = $row['dc_date_time'];
                    $dc_type = $row['dc_type'];
                    $dc_items = explode(",", $row['dc_items']);
                    $dc_item_qty = explode(",", $row['dc_item_qty']);
                    $dc_remarks = $row['dc_remarks'];
                    $concern_name = $row['concern_name'];
                    $company_name = $row['company_name'];
                    $total_received = $this->m_general->getGeneralDcReceived($delivery_id);
                  ?>
                    <script>
                      data.push(['<?= $sno; ?>', '<?= $delivery_id; ?>', '<?= $concern_name; ?>', '<?= $company_name; ?>', '<?= sizeof($dc_items); ?>', '<?= array_sum($dc_item_qty); ?>', '<?= $total_received; ?>', '<?= ($dc_type == 1) ? 'Returnable' : 'Non Returnable'; ?>', '<?= $dc_date_time; ?>', '<?= $dc_remarks; ?>', '<a target="_blank" href="<?= base_url(); ?>general/generalDcView/<?= $delivery_id; ?>" data-placement="top" data-original-title="View" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">View</a>']);
                    </script>

                  <?php
                    $sno++;
                  }
                  ?>
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

    $("#add").click(function() {
      var $tableBody = $('#tbl').find("tbody"),
        $trFirst = $tableBody.find("tr:first"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trFirst.clone(true);
      $trLast.after($trNew);
      $trNew.find("input").val("");
      return false;
    });
    $('.remove-row').live('click', function() {
      $(this).closest('tr').remove();
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
    $(function() {
      $(".addtocart").click(function() {
        var item_name = $('#item_name').val();
        var item_qty = $('#item_qty').val();
        var item_rate = $('#item_rate').val();
        var item_uom = $('#item_uom').val();
        var supplier = $('#supplier').val();

        var url = "<?= base_url() ?>general/addGeneralDCItem";
        var postData = 'item_name=' + item_name + '&item_qty=' + item_qty + '&item_rate=' + item_rate + '&item_uom=' + item_uom + '&supplier=' + supplier;
        // alert(postData);
        $.ajax({
          type: "POST",
          url: url,
          data: postData,
          success: function(result) {
            $('#cartdata').load('<?= base_url(); ?>general/generalDeliveryItems');
            location.reload();
          }
        });
        return false;
      });
    });
    $(function() {
      $("a.removecart").live("click", function() {
        var row_id = $(this).attr('id');
        var url = "<?= base_url() ?>general/removeGeneralDCItem/" + row_id;
        var postData = 'row_id=' + row_id;
        $.ajax({
          type: "POST",
          url: url,
          success: function(msg) {
            $('#cartdata').load('<?= base_url(); ?>general/generalDeliveryItems');
          }
        });
        return false;
      });
    });
  </script>

</body>

</html>