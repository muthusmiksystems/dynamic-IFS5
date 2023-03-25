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
                <h3><i class="icon-truck"></i> Stock Transfer With in Store</h3>
              </header>
            </section>
          </div>
        </div>
        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/stock_tran_store_save">
          <div class="row">
            <div class="col-lg-12">
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
                  <div class="form-group col-lg-3">
                    <label for="staff_id">Staff Name</label>
                    <select class="form-control select2" id="staff_id" name="staff_id" required>
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
                    <label for="stock_room">Stock Transfered To</label>
                    <select class="form-control select2" id="stock_room" name="stock_room" required>
                      <option value="">Select</option>
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
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                  </div>
                </div>
              </section>
              <!-- Loading -->
              <div class="pageloader"></div>
              <!-- End Loading -->

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
                      <th>Item Name</th>
                      <th>Concern</th>
                      <th>Supplier</th>
                      <th>Date</th>
                      <th>Party Box No</th>
                      <th>Dynamic Box No</th>
                      <th>Custody Of</th>
                      <th>Stock Room</th>
                      <th></th>
                    </tr>
                  </thead>
                  <?php
                  $sno = 1;
                  $amount = 0;
                  foreach ($inward_list as $row) {
                    $amount = $row['item_rate'] * $row['item_qty'];
                  ?>

                    <script>
                      data.push(['<?= $sno; ?>', '<?= $row['item_name']; ?>', '<?= $row['concern_name']; ?>', '<?= $row['company_name']; ?>', '<?= $row['inward_date']; ?>', '<?= $row['party_boxno']; ?>', '<?= $row['dynamic_box_no']; ?>', '<?= $row['custody_staff']; ?>', '<?= $row['stock_room_name']; ?>', '<input type="checkbox" name="selectedrows[<?= $row['inward_id']; ?>]">']);
                    </script>

                  <?php
                    $sno++;
                  }
                  ?>
                </table>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit">Save</button>
                </header>
              </section>
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
  </script>

</body>

</html>