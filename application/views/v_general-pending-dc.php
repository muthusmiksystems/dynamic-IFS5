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
                <h3><i class="icon-truck"></i> DC Acceptance</h3>
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

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Delivery details
              </header>
              <div class="panel-body">
                <script>
                  var data = [];
                </script>



                <table class="table table-striped border-top" id="sample_1x">
                  <thead>
                    <tr>
                      <th>Sno</th>
                      <th>From</th>
                      <th>From Staff</th>
                      <th>To</th>
                      <th>To Staff</th>
                      <th>Transfer Date</th>
                      <th>Accepted Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <?php
                  $sno = 1;
                  foreach ($peding_dc as $row) {
                    $transfer_id = $row['transfer_id'];
                    $status = $row['status'];
                    $staff_name = $row['staff_name'];
                    if ($transfer_id != '') {
                      $action = '';
                      if ($staff_name == $this->session->userdata('user_id')) {
                        if ($status == 1) {
                          $action = '<a href="' . base_url() . 'general/generalDcAcceptance/' . $transfer_id . '" class="label label-danger">View &amp; Accept</a>';
                        } else {
                          $action = '<a href="' . base_url() . 'general/generalStockTransDc/' . $transfer_id . '" class="' . (($status == 0) ? 'label label-success' : 'label label-danger') . '">View</a>';
                        }
                      } else {
                        $action = '<a href="' . base_url() . 'general/generalStockTransDc/' . $transfer_id . '" class="' . (($status == 0) ? 'label label-success' : 'label label-danger') . '">View</a>';
                      }
                  ?>

                      <script>
                        data.push(['<?= $sno; ?>', '<?= $row['from_concern']; ?>', '<?= $row['from_staff_name']; ?>', '<?= $row['to_concern']; ?>', '<?= $row['to_staff_name']; ?>', '<?= $row['transfer_date']; ?>', '<?= $row['accepted_date']; ?>', '<?= $action; ?>']);
                      </script>

                  <?php
                    }
                    $sno++;
                  }
                  ?>
                </table>
              </div>
            </section>
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
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

    $("#transfer_id").change(function() {
      window.location.href = "<?= base_url(); ?>general/generalDcAcceptance/" + $(this).val();
    });
  </script>

</body>

</html>