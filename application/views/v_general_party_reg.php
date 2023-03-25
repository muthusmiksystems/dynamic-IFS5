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
  foreach ($css_print as $path) {
  ?>
    <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet" media="print">
  <?php
  }
  ?>


  
  
      
    
  <style type="text/css">
    @media print {
      @page {
        margin: 3mm;
      }

      .packing-register th {
        border: 1px solid #000 !important;
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
      }

      .packing-register td {
        border: 1px solid #000 !important;
      }

      .dataTables_filter,
      .dataTables_info,
      .dataTables_paginate,
      .dataTables_length {
        display: none;
      }

      .screen_only {
        display: none;
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
                <h3>General Party Register</h3>
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

                <h3 class="visible-print">General Party Register</h3>
                <form class="cmxform tasi-form" enctype="multipart/form-data" role="form" method="post" action="<?= base_url(); ?>registers/delete_estimates">
                  <table id="register_tbl" class="table table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Sno</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Contact Name</th>
                        <th>Mobile No</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sno = 1;
                      foreach ($result_reg as $row) {
                        $display_com_name = false;
                        $company_id_ref = $row['company_id'];
                        $company_name = $row['company_name'];
                        $company_address = $row['company_address'];
                        $is_active = $row['is_active'];
                        $contacts = $this->m_masters->getmasterdetails('bud_general_cust_contacts', 'company_id_ref', $company_id_ref);
                        foreach ($contacts as $contact) {
                      ?>
                          <tr class="odd gradeX">
                            <td><?= $sno; ?></td>
                            <td>
                              <?php
                              if ($display_com_name == false) {
                                $display_com_name = true;
                                echo $company_name;
                              }
                              ?>
                            </td>
                            <td><?= $company_address; ?></td>
                            <td><?= $contact['contact_name']; ?></td>
                            <td><?= $contact['mobile_no']; ?></td>
                            <td><?= $contact['email_id']; ?></td>
                            <td><?= $contact['designation']; ?></td>
                            <td>
                              <span class="<?= ($is_active == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($row['is_active'] == 1) ? 'Active' : 'Inactive'; ?></span>
                            </td>
                          </tr>
                      <?php
                          $sno++;
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                  <button class="btn btn-primary screen-only" type="button" onclick="window.print()">Print</button>
                </form>
              </div>
            </section>
            <!-- End Form Section -->
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

      $('#register_tbl').dataTable({
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bPaginate": false,
        "bInfo": false,
        "iDisplayLength": -1,
        "sPaginationType": "bootstrap",
        "oLanguage": {
          "sLengthMenu": "_MENU_ records per page",
          "oPaginate": {
            "sPrevious": "Prev",
            "sNext": "Next"
          }
        },
        "bSort": false
      });
      jQuery('#register_tbl_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('#register_tbl_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

      $(".item").change(function() {
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());
      });

      $(".get_item_detail").change(function() {
        $("#customer_name").select2("val", $(this).val());
        $("#customer_mobile").select2("val", $(this).val());
        return false;
      });
      $(".shades-select").change(function() {
        $(".shades-select").select2("val", $(this).val());
        $(".shades-select").select2("val", $(this).val());
        return false;
      });
    });

    $(function() {
      $('#selectall').click(function(event) {
        if (this.checked) {
          $('.estimates').each(function() {
            this.checked = true;
          });
        } else {
          $('.estimates').each(function() {
            this.checked = false;
          });
        }
      });
    });
  </script>

</body>

</html>