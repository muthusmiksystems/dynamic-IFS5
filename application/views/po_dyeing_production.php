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
                <h3><i class="icon-truck"></i> Dyeing Lot Production Entry</h3>
              </header>
            </section>
          </div>
        </div>

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




                <table class="table table-striped border-top" id="sample_1">
                  <thead>
                    <tr>
                      <th>Sno</th>
                      <th>R.PO NO</th>
                      <th>Date</th>
                      <th>Customer name</th>
                      <th>Contact Name</th>
                      <th>From filled by</th>
                      <th>Remark</th>
                      <th>Status</th>
                      <th>Need Date</th>
                      <th>Master Date</th>
                      <th>Delivery Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sno = 1;
                    foreach ($table as $row) {
                      if (($row['status'] != "0") && ($row['status'] != "3")) {
                        if ($row['master_date'] != '') {
                          $date = explode("-", $row['master_date']);
                          $master_date = $date[2] . '-' . $date[1] . '-' . $date[0];
                        } else {
                          $master_date = '0000-00-00';
                        }
                    ?>
                        <tr class="odd gradeX">
                          <td><?= $sno; ?></td>
                          <td><?= $row['R_po_no']; ?></td>
                          <td><?= $row['date']; ?></td>
                          <td><?= $row['cust_name']; ?></td>
                          <td><?= $row['c_name'] . " - " . $row['c_tel']; ?></td>
                          <td><?= $row['user']; ?></td>
                          <td><?= $row['remark']; ?></td>
                          <td>
                            <?php
                            switch ($row['status']) {
                              case 0: ?><span id="send<?= $row['R_po_no'] ?>" class="label label-danger" onclick="send(<?= $row['R_po_no']; ?>)">SEND</span><?php break;
                                                                                                                                                          case 1: ?><span class="label label-xs label-warning">DYEING</span><?php break;
                                                                                                                                                                                                                                  case 2: ?><span class="label label-xs label-success">DELIVERED</span><?php break;
                                                                                                                                                                                                                                      case 3: ?><span class="label label-xs label-primary">CLEAR</span><?php break;
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                    ?>
                          </td>
                          <td>
                            <input type="text" value="<?= $row['need_date']; ?>" class="form-control" disabled>
                          </td>
                          <td>
                            <input type="text" class="dateplugin form-control" id="master_date<?= $row['R_po_no'] ?>" value="<?= $master_date; ?>">
                            <button class="btn btn-xs btn-success" onclick="update_master_date(<?= $row['R_po_no'] ?>)">Update</button>
                          </td>
                          <td>
                            <input type="text" class="dateplugin form-control" id="delivery_date<?= $row['R_po_no'] ?>" value="<?= ($row['delivery_date'] != '0000-00-00') ? $row['delivery_date'] : ''; ?>">
                          </td>
                          <td>
                            <button class="btn btn-xs btn-primary" onclick="tab_detail(<?= $row['R_po_no']; ?>)">Details</button>
                          </td>
                        </tr>
                    <?php
                        $sno++;
                      }
                    }
                    ?>
                  </tbody>
                </table>









              </div>
              <!-- Loading -->
              <div class="pageloader"></div>
              <!-- End Loading -->
            </section>


            <!-- Start Talbe List  -->
            <?php
            /*echo "<pre>";
                      print_r($poy_issue);
                      echo "</pre>";*/
            ?>
            <section class="panel">
              <header class="panel-heading">
                Details
              </header>
              <table class="table table-striped border-top">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>R.PO NO</th>
                    <th>Item Name</th>
                    <th>Customer Colour Name</th>
                    <th>Indofila Shade Name - No</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="tab_details">
                </tbody>
              </table>
            </section>
            <div id="production_form"></div>





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
    $(document).ajaxStart(function() {
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });

    $(function() {

    });

    function tab_detail(id) {
      $.ajax({
        type: "POST",
        url: "<?= base_url(); ?>purchase_order/po_from_customers_table_details_lot/" + id,
        dataType:"html",
        success: function(e) {
          $("#tab_details").html(e);
        }
      })
    }

    function update_master_date(id) {
      var date = $("#master_date" + id).val();
      if (date != "") {
        $.ajax({
          type: "POST",
          url: "<?= base_url(); ?>purchase_order/update_po_from_customers_master/" + id + "/" + date,
          success: function(e) {
            if (e == "successfull") {
              alert("master date updated successfully");
            }
          }
        })
      }
    }


    function get_form(id, R_po_no) {
      $.ajax({
        type: "POST",
        url: "<?= base_url(); ?>purchase_order/po_dyeing_production_form/" + id + "/" + R_po_no,
        success: function(e) {
          $("#production_form").html(e);
        }
      })
    }
  </script>

</body>

</html>