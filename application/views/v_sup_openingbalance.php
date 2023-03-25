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
                                <h3><i class="icon-book"></i> Supplier Opening Balance</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
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
                            }                                                      if($this->session->flashdata('error'))
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
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>accounts/savesupplieropenbalance">                                        <section class="panel">                                                <header class="panel-heading">
                                Details
                            </header>
                            <div class="panel-body">
                              <div class="form-group col-lg-4">
                                <label for="process_date">Date</label>
                                <input class="form-control dateplugin" id="process_date" name="process_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="payment_category">Category</label>
                                <select class="form-control" name="payment_category" id="payment_category" required>
                                  <option value="">Select Category</option>
                                  <?php
                                  foreach ($categories as $category) {
                                    ?>
                                    <option value="<?=$category['category_id']; ?>"><?=$category['category_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="payment_customer">Customer Name</label>
                                <select class="form-control" id="payment_customer" name="payment_customer" required>
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="amount">Amount</label>
                                <input class="form-control" id="amount" name="amount" type="text" required>
                              </div>                                                    <div class="form-group col-lg-4">
                                <label for="amount_type">Type</label>
                                <select class="form-control" id="amount_type" name="amount_type" required>
                                  <option value="+">Credit</option>
                                  <option value="-">Debit</option>
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="reffrence">Reffrence #</label>
                                <input class="form-control" id="reffrence" name="reffrence" type="text" required>
                              </div>                                       </div>
                        </section>
                                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form>

                        <!-- Start Report -->
                        <section class="panel">
                            <header class="panel-heading">
                                Summery
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="customerdata">                                                                              </table>
                            </div>
                        </section>
                        <!-- End Report -->
                      <!-- Loading -->
                      <div class="pageloader"></div>
                      <!-- End Loading -->
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

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      $(document).ajaxStart(function() {
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

      $(function(){
        $("#payment_category").change(function () {
            var payment_category = $('#payment_category').val();
            var url = "<?=base_url()?>masters/getsupplierdatas/"+payment_category;
            var postData = 'payment_category='+payment_category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(customers)
                {
                    $('#payment_customer').html(customers);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#payment_customer").change(function () {
            var payment_customer = $('#payment_customer').val();
            var url = "<?=base_url()?>accounts/supplierpayements/"+payment_customer;
            var postData = 'payment_customer='+payment_customer;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    $('#customerdata').html(result);
                }
            });
            return false;
        });
      });
  </script>

  </body>
</html>
