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


  
  
  
  <style type="text/css">
    @media print {
      @page {
        margin: 15mm 10mm 0mm 10mm;
      }
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
                <h3><i class="icon-truck"></i> Stock Transfer Dc</h3>
              </header>
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
            <!-- Start Item List -->
            <section class="panel">
              <div class="panel-body">
                <!-- Start Item List -->
                <table class="table table-bordered table-striped table-condensed">
                  <tbody>
                    <tr>
                      <td colspan="9" align="center">
                        <h4>General Stock Transfer DC</h4>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                        <strong>FROM</strong><br>
                        <?php
                        $from = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $from_concern);
                        foreach ($from as $row) {
                        ?>
                          <strong><?= $row['concern_name']; ?></strong><br>
                          <?= $row['concern_address']; ?><br>
                          TIN : <?= $row['concern_tin']; ?><br>
                          CST : <?= $row['concern_cst']; ?><br>
                        <?php
                        }
                        ?>
                      </td>
                      <td colspan="3">
                        <strong>TO</strong>
                        <?php
                        $to = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $to_concern);
                        foreach ($to as $row) {
                        ?>
                          <strong><?= $row['concern_name']; ?></strong><br>
                          <?= $row['concern_address']; ?><br>
                          TIN : <?= $row['concern_tin']; ?><br>
                          CST : <?= $row['concern_cst']; ?><br>
                        <?php
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>S.No</strong></td>
                      <td><strong>DC No</strong></td>
                      <td><strong>From Staff</strong></td>
                      <td><strong>Particulars</strong></td>
                      <td><strong>Qty</strong></td>
                      <td><strong>To Staff</strong></td>
                      <td><strong>Sign</strong></td>
                    </tr>
                    <?php
                    $sno = 1;
                    foreach ($selected_dc as $key => $value) {
                      $result = $this->m_general->getstockTransDcdetails($value);
                      foreach ($result as $row) {
                        $transfer_id = $row['transfer_id'];
                        $from_concern = $row['from_concern'];
                        $to_concern = $row['to_concern'];
                    ?>
                        <tr class="odd gradeX">
                          <td><?= $sno; ?></td>
                          <td><?= $transfer_id; ?></td>
                          <td><?= $row['from_staff_name']; ?></td>
                          <td><?= $row['item_name']; ?></td>
                          <td><?= $row['item_qty']; ?> <?= $row['uom_name']; ?></td>
                          <td><?= $row['to_staff_name']; ?></td>
                          <td>

                          </td>
                        </tr>
                    <?php
                      }
                      $sno++;
                    }
                    ?>
                    <tr>
                      <td colspan="9">
                        <div class="print-div col-lg-4">
                          <strong>Received By</strong>
                          <br />
                          <br />
                        </div>
                        <div class="print-div col-lg-4">
                          <strong>Prepared By</strong>
                          <br />
                          <br />
                          <br>
                          <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $this->session->userdata('user_id'), 'user_login'); ?><br>
                        </div>
                        <div class="col-lg-4" style="float:right;text-align:right;">
                          <strong>For <?= $from_concern; ?></strong><br>
                          <br />
                          <br />
                          <br>
                          Authorized Signature
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <br>
                <br>
                <table class="table table-bordered table-striped table-condensed">
                  <tr>
                    <td colspan="3" align="center">
                      <h4>Gate Pass For General Stock Transfer DC</h4>
                    </td>
                  </tr>
                  <tr>
                    <td>S.No</td>
                    <td>DC No</td>
                    <td>Qty</td>
                  </tr>
                  <?php
                  $sno = 1;
                  foreach ($selected_dc as $key => $value) {
                    $result = $this->m_general->getstockTransDcdetails($value);
                    foreach ($result as $row) {
                      $transfer_id = $row['transfer_id'];
                  ?>
                      <tr class="odd gradeX">
                        <td><?= $sno; ?></td>
                        <td><?= $transfer_id; ?></td>
                        <td><?= $row['item_qty']; ?> <?= $row['uom_name']; ?></td>
                      </tr>
                  <?php
                    }
                    $sno++;
                  }
                  ?>
                  <tr>
                    <td colspan="3">
                      <div class="col-lg-4" style="float:right;text-align:right;">
                        <strong>For <?= $from_concern; ?></strong><br>
                        <br />
                        <br />
                        <br>
                        Authorized Signature
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </section>
            <section class="panel">
              <header class="panel-heading">
                <button class="btn btn-danger" onclick="window.print()" type="button">Print</button>
              </header>
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