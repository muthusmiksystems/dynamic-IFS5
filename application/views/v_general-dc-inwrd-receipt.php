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
                <h3><i class="icon-truck"></i> General Delivery Inward Receipt</h3>
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
              <header class="panel-heading">
                Delivery Inward Details
              </header>
              <div class="panel-body">
                <?php
                foreach ($inward_details as $row) {
                  $inward_id = $row['inward_id'];
                  $date_time = $row['date_time'];
                  $supplier = $row['supplier'];
                  $dc_no = $row['dc_no'];
                  $item_name = $row['item_name'];
                  $item_uom = $row['item_uom'];
                  $total_qty_sent = $row['total_qty_sent'];
                  $received_qty = $row['received_qty'];
                  $balance_qty = $row['balance_qty'];
                  $packeges_recieved = $row['packeges_recieved'];
                  $prepared_by = $row['prepared_by'];
                  $remarks = $row['remarks'];
                  $dc_date_time = $this->m_masters->getmasterIDvalue('bud_general_deliveries', 'delivery_id', $dc_no, 'dc_date_time');
                }
                $date = explode(" ", $date_time);
                $ed = explode("-", $date[0]);
                $dc_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

                $dc_date_time = explode(" ", $dc_date_time);
                $ed = explode("-", $dc_date_time[0]);
                $dc_created_on = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

                $dc_to = $this->m_masters->getmasterIDvalue('bud_general_deliveries', 'delivery_id', $dc_no, 'dc_from');
                ?>
                <!-- Start Item List -->
                <table class="table table-bordered table-striped table-condensed">
                  <tbody>
                    <tr>
                      <td colspan="7" align="center">
                        <h3>General Delivery Inward Receipt</h3>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                        <strong>FROM:</strong><br>
                        <?php
                        $result = $this->m_masters->getmasterdetails('bud_general_customers', 'company_id', $supplier);
                        foreach ($result as $row) {
                        ?>
                          <strong><?= $row['company_name']; ?></strong><br>
                          <?= $row['company_address']; ?>

                        <?php
                        }
                        ?>
                      </td>
                      <td colspan="3">
                        <strong>TO:</strong><br>
                        <?php
                        $result = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $dc_to);
                        foreach ($result as $row) {
                        ?>
                          <strong><?= $row['concern_name']; ?></strong><br>
                          <?= $row['concern_address']; ?><br>
                          <strong>GST : <?= $row['concern_gst']; ?></strong>
                        <?php
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td>DC.No</td>
                      <td colspan="2">
                        <sgtrong style="font-size:20px;"><?= $dc_no; ?></sgtrong>
                      </td>
                      <td>Date </td>
                      <td colspan="3"><?= $dc_created_on; ?> <?= $dc_date_time[1]; ?></td>
                    </tr>
                    <tr>
                      <td width="10%">#</td>
                      <td width="15%">Item Name</td>
                      <td width="10%">HSN Code</td>
                      <td width="15%">Quantity Received</td>
                      <td width="15%">Uom</td>
                      <td width="15%">Balance Qty</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td><?= $this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $item_name, 'item_name'); ?></td>
                      <td><?= $this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $item_name, 'hsn_code'); ?></td>
                      <td><?= $received_qty; ?></td>
                      <td><?= $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item_uom, 'uom_name'); ?></td>
                      <td><?= $balance_qty; ?></td>
                    </tr>
                    <tr>
                      <td colspan="7">
                        <strong>Remarks:</strong><br>
                        <?= $remarks; ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="7">
                        <div class="print-div col-lg-4">
                          <strong>Received By</strong>
                          <br />
                          <br />
                        </div>
                        <div class="print-div col-lg-4" style="border-right:none;">
                          <strong>Prepared By</strong>
                          <br />
                          <br />
                          <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $prepared_by, 'user_login'); ?>
                        </div>
                        <div class="col-lg-4" style="float:right;text-align:right;">
                          Authorized Signature
                          <br />
                          <br />
                        </div>
                      </td>
                    </tr>
                  </tbody>
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