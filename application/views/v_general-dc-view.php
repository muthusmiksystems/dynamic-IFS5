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
                <h3><i class="icon-truck"></i> General Delivery</h3>
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
              <h4 class="visible-print text-center">General Delivery</h4>
              <header class="panel-heading">
                Delivery Details
              </header>
              <div class="panel-body">
                <?php
                foreach ($dc_details as $row) {
                  $delivery_id = $row['delivery_id'];
                  $dc_date_time = $row['dc_date_time'];
                  $dc_type = $row['dc_type'];
                  $dc_from = $row['dc_from'];
                  $dc_to = $row['dc_to'];
                  $dc_items = explode(",", $row['dc_items']);
                  $item_descriptions = explode(",", $row['item_descriptions']);
                  $dc_item_suppliers = explode(",", $row['dc_item_suppliers']);
                  $dc_item_qty = explode(",", $row['dc_item_qty']);
                  $dc_item_uom = explode(",", $row['dc_item_uom']);
                  $dc_item_price = explode(",", $row['dc_item_price']);
                  $gross_weights = explode(",", $row['gross_weights']);
                  $net_weights = explode(",", $row['net_weights']);
                  $dc_total_bundels = $row['dc_total_bundels'];
                  $dc_sent_through = $row['dc_sent_through'];
                  $dc_remarks = $row['dc_remarks'];
                  $dc_prepared_by = $row['dc_prepared_by'];
                }
                $date = explode(" ", $dc_date_time);
                $ed = explode("-", $date[0]);
                $dc_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
                ?>
                <!-- Start Item List -->
                <table class="table table-bordered table-striped table-condensed">
                  <tbody>
                    <tr>
                      <td colspan="5">
                        <strong>FROM:</strong><br>
                        <?php
                        $result = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $dc_from);
                        foreach ($result as $row) {
                        ?>
                          <strong><?= $row['concern_name']; ?></strong><br>
                          <strong><?= $row['concern_address']; ?></strong><br>

                          GST: <?= $row['concern_gst']; ?><br>
                        <?php
                        }
                        ?>
                        Staff Name : <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $dc_prepared_by, 'user_login'); ?>
                      </td>
                      <td colspan="5">
                        <strong>TO:</strong><br>
                        <?php
                        $result = $this->m_masters->getmasterdetails('bud_general_customers', 'company_id', $dc_to);

                        foreach ($result as $row) {
                        ?>
                          <strong><?= $row['company_name']; ?></strong><br>
                          <?= nl2br($row['company_address']); ?><br>

                        <?php
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">DC.No</td>
                      <td colspan="2"><strong style="font-size:20px;"><?= $delivery_id; ?></strong></td>
                      <td colspan="">Date </td>
                      <td colspan="5"><?= $dc_date; ?> <?= $date[1]; ?></td>
                    </tr>
                    <tr>
                      <td width="5%">#</td>
                      <td width="10%">Item Code</td>
                      <td width="15%">Item Name</td>
                      <td width="10%">HSN Code</td>
                      <td width="20%">Supplier</td>
                      <td width="5%">Quantity</td>
                      <td width="5%">Uom</td>
                      <td width="10%">Rate</td>
                      <td width="10%">Gross Weight</td>
                      <td width="10%">Net Weight</td>
                    </tr>
                    <?php
                    $total_items = 0;
                    $total_qty = 0;
                    $total_gr_weight = 0;
                    $total_nt_weight = 0;
                    foreach ($dc_items as $key => $value) {
                      $total_qty += $dc_item_qty[$key];
                      $total_gr_weight += $gross_weights[$key];
                      $total_nt_weight += $net_weights[$key];
                    ?>
                      <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $value; ?></td>
                        <td>
                          <?= $this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $value, 'item_name'); ?><br>
                          <?= $item_descriptions[$key]; ?>
                        </td>
                        <td>
                          <?= $this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $value, 'hsn_code'); ?><br>

                        </td>
                        <td><?= $this->m_masters->getmasterIDvalue('bud_general_customers', 'company_id', $dc_item_suppliers[$key], 'company_name'); ?></td>
                        <td><?= $dc_item_qty[$key]; ?></td>
                        <td><?= $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $dc_item_uom[$key], 'uom_name'); ?></td>
                        <td><?= $dc_item_price[$key]; ?></td>
                        <td><?= $gross_weights[$key]; ?></td>
                        <td><?= $net_weights[$key]; ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                    <tr>
                      <td colspan="4"><strong>Total</strong></td>
                      <td><strong><?= $total_qty; ?></strong></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><strong><?= $total_gr_weight; ?></strong></td>
                      <td><strong><?= $total_nt_weight; ?></strong></td>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <strong>Total Bundels: </strong> <?= $dc_total_bundels; ?>
                      </td>
                      <td colspan="7">
                        <strong>Remarks: </strong>
                        <?= $dc_remarks; ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="10">
                        <strong>Sent Through: </strong>
                        <?= $dc_sent_through; ?>
                      </td>

                    </tr>
                    <tr>
                      <td colspan="10">
                        <div class="print-div col-lg-4">
                          <strong>Received By</strong>
                          <br />
                          <br />
                        </div>
                        <div class="print-div col-lg-4" style="border-right:none;">
                          <strong>Prepared By</strong>
                          <br />
                          <br />
                          <?= $this->m_masters->getmasterIDvalue('bud_users', 'ID', $dc_prepared_by, 'user_login'); ?>
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