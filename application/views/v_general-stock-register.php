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
                <h3><i class="icon-user"></i> General Item Stock Register</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
            <?php
            /*echo "<pre>";
                      print_r($stock_register);
                      echo "</pre>";*/
            ?>
            <!-- Start Talbe List  -->
            <section class="panel">
              <header class="panel-heading">
                Stock Register
              </header>
              <script>
                var data = [];
              </script>

              <table class="table table-bordered" id="sample_1x">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Photo</th>
                    <th>Opening Stock</th>
                    <th>Total Qty</th>
                    <th>Used Qty</th>
                    <th>Current Stock</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($stock_register as $row) {
                    $item_sample = $row['item_sample'];
                    $img = '';
                    if ($item_sample != '') :
                      $img = '<img src="' . (base_url('uploads/itemsamples/general/' . $item_sample)) . '" height="50">';
                    endif;
                  ?>
                    <script>
                      data.push(['<?= $sno; ?>', '<?= $row['item_id']; ?>', '<?= $row['item_name']; ?>', '<?= $img; ?>', '<?= ($row['opening_stock'] > 0) ? $row['opening_stock'] : 0; ?>', '<?= ($row['total_qty'] > 0) ? $row['total_qty'] + $row['opening_stock'] : 0 + $row['opening_stock']; ?>', '<?= ($row['total_used'] > 0) ? $row['total_used'] : 0; ?>', '<?= ($row['total_qty'] + $row['opening_stock']) - $row['total_used']; ?>', '<a target="_blank" href="<?= base_url(); ?>general_dc_report/itemstockRegister_view/<?= $row['item_id']; ?>" titile="View" class="btn btn-success btn-xs">View</a>']);
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
  </script>

</body>

</html>