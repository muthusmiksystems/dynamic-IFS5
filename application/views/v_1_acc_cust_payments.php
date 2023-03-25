<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title><?=$page_title; ?> | INDOFILA SYNTHETICS</title>

    <!-- Bootstrap core CSS -->
    <?php
    foreach ($css as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet">
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
                                <h3>Customer Payments</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body">
                                <?php
                                if($this->session->flashdata('warning'))
                                {
                                  ?>
                                  <div class="alert alert-warning fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                                  </div>
                                  <?php
                                }                                                          if($this->session->flashdata('error'))
                                {
                                  ?>
                                  <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                                </div>
                                  <?php
                                }
                                if($this->session->flashdata('success'))
                                {
                                  ?>
                                  <div class="alert alert-success alert-block fade in">
                                      <button data-dismiss="alert" class="close close-sm" type="button">
                                          <i class="icon-remove"></i>
                                      </button>
                                      <h4>
                                          <i class="icon-ok-sign"></i>
                                          Success!
                                      </h4>
                                      <p><?=$this->session->flashdata('success'); ?></p>
                                  </div>
                                  <?php
                                }
                                ?>
                                <table id="sample_1" class="table table-bordered table-striped table-condensed">
                                  <thead>
                                    <tr>
                                      <th>Date</th>
                                      <th>Customer Id</th>
                                      <th>Customer Name</th>
                                      <th>Phone No</th>
                                      <th>Payment Mode</th>
                                      <th>Cheque / DD No</th>
                                      <th>Bank</th>
                                      <th class="text-right">Amount</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach ($payments as $row) {
                                      ?>
                                      <tr>
                                        <td><?=date('d-m-Y', strtotime($row->payment_date)); ?></td>
                                        <td><?=$row->cust_id; ?></td>
                                        <td><?=$row->cust_name; ?></td>
                                        <td><?=$row->cust_phone; ?></td>
                                        <td><?=ucfirst($row->payment_mode); ?></td>
                                        <td><?=$row->cheque_dd_no; ?></td>
                                        <td><?=$row->bank_name; ?></td>
                                        <td class="text-right"><?=$row->amount; ?></td>
                                        <td>
                                          <a href="<?=base_url('accounts/cust_payment_yt/'.$row->payment_id);?>" title="Edit" class="btn btn-xs btn-primary">Edit</a>
                                          <a href="<?=base_url('accounts/delete_payment_yt/'.$row->payment_id);?>" title="Edit" class="btn btn-xs btn-danger">Delete</a>
                                        </td>
                                      </tr>
                                      <?php
                                    }
                                    ?>
                                </table>                                                                                  </div>
                        </section>
                        <!-- End Form Section -->
                    </div>
                </div>             <!-- page end-->
            </section>
      </section>
      <!--main content end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php
    foreach ($js as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>    

    <!--common script for all pages-->
    <?php
    foreach ($js_common as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

    <!--script for this page-->
    <?php
    foreach ($js_thispage as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

  <script>
  //owl carousel
  $(document).ready(function() {
      $("#owl-demo").owlCarousel({
          navigation : true,
          slideSpeed : 300,
          paginationSpeed : 400,
          singleItem : true

      });
  });
  </script>

  </body>
</html>
