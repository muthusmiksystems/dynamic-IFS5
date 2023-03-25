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
  foreach ($print_css as $path) {
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
            <section class="panel">
              <header class="panel-heading">
                <h3><i class="icon-truck"></i> General Delivery Inward</h3>
              </header>
              <div class="panel-body" id="sample-box">
                <!-- Item Sample -->
              </div>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/generalDcInwrdSave">
              <!-- Start Item List -->
              <section class="panel">
                <header class="panel-heading">
                  Receipt No: <span class="label label-danger" style="font-size:14px;"><?= $receipt_no; ?></span>
                </header>
                <div class="panel-body">
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
                  <div class="form-group col-lg-3">
                    <label for="dc_no">DC No</label>
                    <select class="form-control select2" id="dc_no" name="dc_no" required>
                      <option value="">Select</option>
                      <?php
                      /*foreach ($gen_deliveries as $row) {
                                       ?>
                                       <option value="<?=$row['delivery_id']; ?>"><?=$row['delivery_id']; ?></option>
                                       <?php
                                     }*/
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="item_name">Item Name</label>
                    <select class="form-control select2" id="item_name" name="item_name" required>
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
                    <label for="item_uom">Item Uom</label>
                    <select class="form-control select2" id="item_uom" name="item_uom" required>
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
                    <label for="total_qty_sent">Total Qty Sent</label>
                    <input class="form-control" id="total_qty_sent" name="total_qty_sent" required type="text" readonly="readonly">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="received_qty">Received Qty</label>
                    <input class="form-control" id="received_qty" name="received_qty" required type="text">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="balance_qty">Balance Qty</label>
                    <input class="form-control" id="balance_qty" name="balance_qty" required type="text" readonly="readonly">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="packeges_recieved"># of Packages Received</label>
                    <input class="form-control" id="packeges_recieved" name="packeges_recieved" required type="text" readonly="readonly">
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
            </form>
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

    $("#supplier").live("change", function() {
      var supplier = $(this).val();
      var url = "<?= base_url() ?>general/supGeneralDC/" + supplier;
      var postData = 'supplier=' + supplier;
      $.ajax({
        type: "POST",
        url: url,
        success: function(result) {
          $('#dc_no').html('');
          $('#item_name').html('');
          $('#dc_no').select2('val', '');
          $('#item_name').select2('val', '');
          $('#total_qty_sent').val(0);
          $('#packeges_recieved').val(0);
          $('#balance_qty').val(0);

          $('#dc_no').html(result);
        }
      });
      return false;
    });

    $("#dc_no").live("change", function() {
      var dc_no = $(this).val();
      var url = "<?= base_url() ?>general/getGeneralDCItems/" + dc_no;
      var postData = 'dc_no=' + dc_no;
      $.ajax({
        type: "POST",
        url: url,
        success: function(result) {
          $('#item_name').html(result);
        }
      });
      return false;
    });
    $("#item_name").live("change", function() {
      var supplier = $("#supplier").val();
      var dc_no = $("#dc_no").val();
      var item_name = $(this).val();
      var url = "<?= base_url() ?>general/getGeneralDCItemQty";
      var postData = 'item_name=' + item_name + '&supplier=' + supplier + '&dc_no=' + dc_no;
      $.ajax({
        type: "POST",
        url: url,
        data: postData,
        success: function(result) {
          var dataArray = result.split(',');
          $('#total_qty_sent').val(dataArray[0]);
          $('#packeges_recieved').val(dataArray[0] - dataArray[1]);
          $('#balance_qty').val(dataArray[1]);
          if (dataArray[2] != '') {
            $("#sample-box").html('<img src="<?= base_url(); ?>uploads/itemsamples/general/' + dataArray[2] + '" style="width:auto;height:70px;max-width:100%;">');
          } else {
            $("#sample-box").html('');
          }
          // console.log(result);
        }
      });
      return false;
    });

    $("#received_qty").keyup(function() {
      var received_qty = parseInt($(this).val());
      var total_qty_sent = parseInt($("#total_qty_sent").val());
      var packeges_recieved = parseInt($("#packeges_recieved").val());
      var balance = total_qty_sent - (packeges_recieved + received_qty);
      $("#balance_qty").val(balance);
    });
  </script>

</body>

</html>