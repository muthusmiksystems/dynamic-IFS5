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
                                <h3><i class="icon-book"></i> Process Card Entry</h3>
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
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>productions/saveprocesscard">                                        <section class="panel">                                                <header class="panel-heading">
                                Process Card Details
                            </header>
                            <div class="panel-body">
                              <div class="form-group col-lg-4">
                                <label for="process_date">Date</label>
                                <input class="form-control dateplugin" id="process_date" name="process_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="jobcard_category">Category</label>
                                <select class="form-control" name="jobcard_category" id="jobcard_category" required>
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
                                <label for="job_customer_name">Customer Name</label>
                                <select class="form-control" id="jobcard_customer" name="jobcard_customer" required>
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_card_no">Jon Card No</label>
                                <select class="form-control" id="job_card_no" name="job_card_no">
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_card_item">Jon Card Item</label>
                                <select class="form-control" id="job_card_item" name="job_card_item">
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="jobcard_shade">Shade</label>
                                <input class="form-control" id="jobcard_shade" name="jobcard_shade" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="jobcard_lot_no">Lot No</label>
                                <input class="form-control" id="jobcard_lot_no" name="jobcard_lot_no" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="jobcard_balance_qty">Balance Prod.Qty</label>
                                <input class="form-control" id="jobcard_balance_qty" name="jobcard_balance_qty" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="jobcard_prod_qty">Prod.Qty</label>
                                <input class="form-control" id="jobcard_prod_qty" name="jobcard_prod_qty" type="text" required>
                              </div>                                         </div>
                        </section>
                                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form>
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
        $("#jobcard_category").change(function () {
            var jobcard_category = $('#jobcard_category').val();
            // alert(jobcard_category);
            var url = "<?=base_url()?>masters/getcustomerdatas/"+jobcard_category;
            var postData = 'jobcard_category='+jobcard_category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(customers)
                {
                    $('#jobcard_customer').html(customers);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#jobcard_customer").change(function () {
            var jobcard_customer = $('#jobcard_customer').val();
            var url = "<?=base_url()?>productions/getcustomerjobcards/"+jobcard_customer;
            $.ajax({
                type: "POST",
                url: url,
                success: function(jobcards)
                {
                    // colsole.log(jobcards);
                    $('#job_card_no').html(jobcards);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#job_card_no").change(function () {
            var job_card_no = $('#job_card_no').val();
            var url = "<?=base_url()?>productions/getjobcarditems/"+job_card_no;
            $.ajax({
                type: "POST",
                url: url,
                success: function(items)
                {
                    // colsole.log(items);
                    $('#job_card_item').html(items);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#job_card_item").change(function () {
            var job_card_item = $('#job_card_item').val();
            var url = "<?=base_url()?>productions/jobcarditemDetails/"+job_card_item;
            $.ajax({
                type: "POST",
                url: url,
                success: function(itemsdata)
                {
                    var dataArray = itemsdata.split(',');
                    $('#jobcard_shade').val(dataArray[0]);
                    $('#jobcard_lot_no').val(dataArray[1]);
                    $('#jobcard_balance_qty').val(dataArray[2]);
                }
            });
            return false;
        });
      });


  </script>

  </body>
</html>
