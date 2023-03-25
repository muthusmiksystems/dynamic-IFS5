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
                                <h3>Customer Account Statement</h3>
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
                                      <th>Customer Id</th>
                                      <th>Customer Name</th>
                                      <th>Phone No</th>
                                      <th>Address</th>
                                      <th class="text-right">Amount</th>
                                      <th class="text-right">Paid</th>
                                      <th class="text-right">Balance</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $sno = 1;
                                    $grand_total = 0;
                                    $grand_paid = 0;
                                    $grand_balance = 0;
                                    foreach ($customers as $row) {
                                      $cust_id = $row['cust_id'];
                                      $total_amount = 0;
                                      $paid_amount = 0;
                                      $balance_amount = 0;
                                      $total_amount = $this->m_accounts->getTotalAmount_yt($cust_id);
                                      $paid_amount = $this->m_accounts->get_paid_amount_yt($cust_id);
                                      $balance_amount = $total_amount - $paid_amount;

                                      $grand_total += $total_amount;
                                      $grand_paid += $paid_amount;
                                      $grand_balance += $balance_amount;
                                      ?>
                                      <tr>
                                        <td><?=$row['cust_id']; ?></td>
                                        <td><?=$row['cust_name']; ?></td>
                                        <td><?=$row['cust_phone']; ?></td>
                                        <td><?=$row['cust_address']; ?></td>
                                        <td class="text-right"><?=number_format($total_amount, 2, '.', ''); ?></td>
                                        <td class="text-right"><?=number_format($paid_amount, 2, '.', ''); ?></td>
                                        <td class="text-right"><?=number_format($balance_amount, 2, '.', ''); ?></td>
                                      </tr>
                                      <?php
                                      $sno++;
                                    }
                                    ?>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <td colspan="4"><strong>Total</strong></td>
                                      <td class="text-right"><strong><?=number_format($grand_total, 2, '.', ''); ?></strong></td>
                                      <td class="text-right"><strong><?=number_format($grand_paid, 2, '.', ''); ?></strong></td>
                                      <td class="text-right"><strong><?=number_format($grand_balance, 2, '.', ''); ?></strong></td>
                                    </tr>
                                  </tfoot>
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
