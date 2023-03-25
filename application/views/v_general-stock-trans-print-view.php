<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="arunkumar">
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
        margin: 2mm;
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
                <div id="divToPrintDC" class="DCPrint">
                  <center>
                    <table class="table table-bordered table-striped table-condensed" style="font-size: 9px;width:95%">
                      <tbody>
                        <tr>
                          <td colspan="9" align="center"><strong style="font-size:12px;">General Stock Transfer DC</strong> <span class="pull-right"><?= date('Y-m-d H:i:s'); ?></span></td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <strong>FROM</strong>
                            <?php
                            $from = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $from_concern);
                            foreach ($from as $row) {
                            ?>
                              <strong><?= $row['concern_name']; ?></strong><br>
                              <?= $row['concern_address']; ?>
                              , TIN : <?= $row['concern_tin']; ?>
                              , CST : <?= $row['concern_cst']; ?>
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
                              <?= $row['concern_address']; ?>
                              , TIN : <?= $row['concern_tin']; ?>
                              , CST : <?= $row['concern_cst']; ?>
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
                            $dc_sent_through = $row['dc_sent_through'];
                        ?>
                            <tr class="odd gradeX">
                              <td><strong style="font-size:12px;"><?= $sno; ?></strong></td>
                              <td><strong style="font-size:12px;"><?= $transfer_id; ?></strong></td>
                              <td><strong style="font-size:12px;"><?= $row['from_staff_name']; ?></strong></td>
                              <td><strong style="font-size:12px;"><?= $row['item_name']; ?></strong></td>
                              <td><strong style="font-size:12px;"><?= $row['item_qty']; ?> <?= $row['uom_name']; ?></strong></td>
                              <td><strong style="font-size:12px;"><?= $row['to_staff_name']; ?></strong></td>
                              <td>

                              </td>
                            </tr>
                        <?php
                          }
                          $sno++;
                        }
                        ?>
                        <tr>


                          <table class="center" style="font-size:9px;width:90%">
                            <thead>
                              <td class="text-left">Received By</td>
                              <td class="text-center">sent through</td>
                              <td class="text-center">Prepared By</td>
                              <td class="text-right" height="40" valign="top">For <?= $from_concern; ?></td>
                            </thead>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>

                            <tr>
                              <td></td>
                              <td><?= $dc_sent_through; ?></td>
                              <td class="text-center"><?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $this->session->userdata('user_id'), 'user_login'); ?><br></td>
                              <td class="text-right" valign="bottom">Authorized Signature</td>
                            </tr>
                          </table>





                        </tr>
                      </tbody>
                    </table>

                </div>
                <br>
                <br>
                <br>
                <div id="divToPrintG" class="GatePrint">
                  <center>
                    <table class="table table-bordered table-striped table-condensed" style="width:95%;font-size:9px;">
                      <tr>
                        <td colspan="4" class="text-center">Gate Pass For General Stock Transfer DC <span class="pull-right"><?= date('Y-m-d H:i:s'); ?></span> </td>
                      </tr>

                      <tr>
                        <td><strong>DC NO:</strong></td>
                        <?php
                        foreach ($selected_dc as $key => $value) {
                          $result = $this->m_general->getstockTransDcdetails($value);
                          foreach ($result as $row) {
                            $transfer_id = $row['transfer_id'];
                        ?>


                            <td><?= $transfer_id; ?></td>

                        <?php
                          }
                          $sno++;
                        } ?><td><strong>TOTAL :</strong></td>
                        <td><strong>For <?= $from_concern; ?></strong></td>
                      </tr>
                      <tr>
                        <td><strong>QTY :</strong></td>
                        <?php
                        $tot_qty = 0;
                        foreach ($selected_dc as $key => $value) {
                          $result = $this->m_general->getstockTransDcdetails($value);
                          foreach ($result as $row) {
                            $transfer_id = $row['transfer_id'];
                        ?>

                            <td><?= $row['item_qty']; ?> <?= $row['uom_name']; ?></td>
                        <?php
                            $tot_qty += $row['item_qty'];
                          }
                          $sno++;
                        } ?><td><strong><?= $tot_qty ?></strong></td>
                        <td><strong>Authorized Signature</strong></td>
                      </tr>

                    </table>
                  </center>
                </div>
              </div>
            </section>
            <section class="panel">
              <header class="panel-heading">
                <button class="btn btn-danger" onclick="PrintDivDC()" type="button">Print DC</button>
                <button class="btn btn-danger" onclick="PrintDivG()" type="button">Print Gate pass</button>
                <button class="btn btn-danger" onclick="PrintDivDC2G()" type="button">print 2 DC 1 Gate</button>
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

  <script>
    function PrintDivDC() {
      var con = $("#divToPrintDC").html();
      var cs = "<?php foreach ($css as $path) { ?> <link href=<?= base_url() . 'themes/default/' . $path; ?> rel='stylesheet'> <?php } ?>";
      var sty = "<style type='text/css'>@media print{ @page { margin: 3mm; }}</style>";


      var popupWin = window.open('', '_blank', '');
      popupWin.document.open();
      popupWin.document.write('<html><head>' + sty + cs + '</h' + 'ead><body style="font-size: 14px;margin:10%;" onload="window.print()">' + con + '</html>');
      popupWin.document.close();
    }
  </script>
  <script>
    function PrintDivG() {
      var con = $("#divToPrintG").html();
      var cs = "<?php foreach ($css as $path) { ?> <link href=<?= base_url() . 'themes/default/' . $path; ?> rel='stylesheet'> <?php } ?>";
      var sty = "<style type='text/css'>@media print{ @page { margin: 3mm; }}</style>";

      var popupWin = window.open('', '_blank', '');
      popupWin.document.open();
      popupWin.document.write('<html><head>' + cs + sty + '</he' + 'ad><body style="font-size: 14px;margin:10%;" onload="window.print()">' + con + '</html>');
      popupWin.document.close();
    }
  </script>
  <script>
    function PrintDivDC2G() {
      var con = $("#divToPrintDC").html();
      var con3 = $("#divToPrintG").html();
      var cs = "<?php foreach ($css as $path) { ?> <link href=<?= base_url() . 'themes/default/' . $path; ?> rel='stylesheet'> <?php } ?>";
      var sty = "<style type='text/css'>@media print{ @page { margin: 3mm; }}</style>";


      var popupWin = window.open('', '_blank', '');
      popupWin.document.open();
      popupWin.document.write('<html><head>' + sty + cs + '</head><body style="font-size: 14px;margin:0px;" onload="window.print()">' + con + '<hr style="border-top: 2px dotted #000;">' + con + '<hr style="border-top: 2px dotted #000;">' + con + '<hr style="border-top: 2px dotted #000;">' + con3 + '</html>');
      popupWin.document.close();
    }
  </script>
</body>

</html>