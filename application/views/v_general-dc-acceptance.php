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
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
            <?php
            if (isset($transfer_id)) {
            ?>
              <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/generalDcAccepted">
                <input type="hidden" name="transfer_id" value="<?= $transfer_id; ?>">
                <!-- Start Item List -->
                <section class="panel">
                  <header class="panel-heading">
                    Delivery details
                  </header>
                  <div class="panel-body">
                    <?php
                    foreach ($transfer_details as $row) {
                      $transfer_id = $row['transfer_id'];
                      $transfer_date = $row['transfer_date'];
                      $transfer_from = $row['transfer_from'];
                      $transfer_to = $row['transfer_to'];
                      $staff_name = $row['staff_name'];
                      $attn_to = $row['attn_to'];
                      $dc_total_bundels = $row['dc_total_bundels'];
                      $dc_sent_through = $row['dc_sent_through'];
                      $dc_remarks = $row['dc_remarks'];
                      $from_stock_room = $row['from_stock_room'];
                    }
                    $date = explode(" ", $transfer_date);
                    $ed = explode("-", $date[0]);
                    $dc_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

                    $dc_from = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $transfer_from, 'concern_name');
                    $dc_to = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $transfer_to, 'concern_name');
                    ?>
                    <!-- Start Item List -->
                    <input type="hidden" name="from_concern" value="<?= $transfer_from; ?>">
                    <input type="hidden" name="from_stock_room" value="<?= $from_stock_room; ?>">
                    <input type="hidden" name="to_concern" value="<?= $transfer_to; ?>">
                    <table class="table table-bordered table-striped table-condensed">
                      <tbody>
                        <tr>
                          <td colspan="5">
                            <strong>FROM:</strong><br>
                            <strong><?= $dc_from; ?></strong>
                          </td>
                          <td colspan="6">
                            <strong>TO:</strong><br>
                            <strong><?= $dc_from; ?></strong>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">DC.No</td>
                          <td colspan="3"><?= $transfer_id; ?></td>
                          <td colspan="2">Date </td>
                          <td colspan="4"><?= $dc_date; ?> <?= $date[1]; ?></td>
                        </tr>
                        <tr>
                          <td width="5%">#</td>
                          <td width="10%">Item Code</td>
                          <td width="10%">Item Name</td>
                          <td width="15%">Supplier</td>
                          <td width="5%">Quantity</td>
                          <td width="5%">Uom</td>
                          <td width="10%">Rate</td>
                          <td width="10%">Gross Weight</td>
                          <td width="10%">Gr.Wt Received</td>
                          <td width="10%">Net Weight</td>
                          <td width="10%">Place Of Storage</td>
                        </tr>
                        <?php
                        $items = $this->m_masters->getmasterdetails('bud_general_transfer_items', 'transfer_id', $transfer_id);
                        $sno = 1;
                        foreach ($items as $row) {
                          $id = $row['id'];
                          $dc_supplier = $row['dc_supplier'];
                          $item_id = $row['item_id'];
                          $item_description = $row['item_description'];
                          $item_qty = $row['item_qty'];
                          $item_uom = $row['item_uom'];
                          $item_rate = $row['item_rate'];
                          $gross_weight = $row['gross_weight'];
                          $gross_wt_received = $row['gross_wt_received'];
                          $net_weight = $row['net_weight'];
                        ?>
                          <tr>
                            <td><?= $sno; ?></td>
                            <td><?= $item_id; ?></td>
                            <td>
                              <?= $this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $item_id, 'item_name'); ?><br>
                              <?= $item_description; ?>
                            </td>
                            <td><?= $this->m_masters->getmasterIDvalue('bud_general_customers', 'company_id', $dc_supplier, 'company_name'); ?></td>
                            <td><?= $item_qty; ?></td>
                            <td><?= $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item_uom, 'uom_name'); ?></td>
                            <td><?= $item_rate; ?></td>
                            <td><?= $gross_weight; ?></td>
                            <td>
                              <input type="text" name="gr_wt_received[<?= $id; ?>]" style="width:100%;" value="<?= $gross_weight; ?>">
                              <input type="hidden" name="items[<?= $id; ?>]" style="width:100%;" value="<?= $item_id; ?>">
                              <input type="hidden" name="items_qty[<?= $id; ?>]" style="width:100%;" value="<?= $item_qty; ?>">
                            </td>
                            <td><?= $net_weight; ?></td>
                            <td>
                              <select name="stock_room[<?= $id; ?>]">
                                <option value="">Select</option>
                                <?php
                                foreach ($stockrooms as $row) {
                                ?>
                                  <option value="<?= $row['stock_room_id']; ?>"><?= $row['stock_room_name']; ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </td>
                          </tr>
                        <?php
                          $sno++;
                        }
                        ?>
                        <tr>
                          <td colspan="11">
                            <strong>Total Bundels: </strong> <?= $dc_total_bundels; ?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="11">
                            <strong>Remarks: </strong><br>
                            <textarea name="receiver_remarks" style="width:100%;"></textarea>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5">
                            <strong>Sent Through: </strong>
                            <?= $dc_sent_through; ?>
                          </td>
                          <td colspan="6">
                            <strong>Remarks: </strong>
                            <?= $dc_remarks; ?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="11">
                            <div class="print-div col-lg-4">
                              <strong>Received By</strong>
                              <br />
                              <br />
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
                    <button class="btn btn-danger" type="submit">Accepted</button>
                  </header>
                </section>
                <!-- End Item List -->
              </form>
              <!-- End Talbe List  -->
            <?php
            }
            ?>
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

    $("#transfer_id").change(function() {
      window.location.href = "<?= base_url(); ?>general/generalDcAcceptance/" + $(this).val();
    });
  </script>

</body>

</html>