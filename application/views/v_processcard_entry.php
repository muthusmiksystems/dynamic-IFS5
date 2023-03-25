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
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>production/saveprocess">
                        <section class="panel">                                                <header class="panel-heading">
                                Process Card Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-4">
                                <label for="po_category">Category</label>
                                <select class="form-control" name="po_category" id="po_category" required>
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
                                <label for="po_date">Date</label>
                                <input class="form-control dateplugin" id="po_date" name="po_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_card">Job Card No</label>
                                <select class="form-control" id="job_card" name="job_card" required>
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="po_customer_name">Customer Name</label>
                                <input class="form-control" id="po_customer_name" name="po_customer_name" type="text" readonly="readonly">
                                <input class="form-control" id="po_customer" name="po_customer" type="hidden">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="po_item">Item</label>
                                <input class="form-control" id="po_item" name="po_item" type="hidden" required >
                                <input class="form-control" id="po_item_name" name="po_item_name" type="text" readonly="readonly">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="req_po_qty">Required Quantity</label>
                                <input class="form-control" id="req_po_qty" name="req_po_qty" type="text" disabled="disabled">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="bal_po_qty">Balance Prod.Qty</label>
                                <input class="form-control" id="bal_po_qty" name="bal_po_qty" type="text" disabled="disabled">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="po_qty">Prod.Qty</label>
                                <input class="form-control" id="po_qty" name="po_qty" type="text">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="lot_no">Lot No</label>
                                <select class="form-control" id="lot_no" name="lot_no">
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="po_remarks">Remarks</label>
                                <textarea class="form-control" id="po_remarks" name="po_remarks"></textarea>
                              </div>
                                                    <input class="form-control" id="po_items" name="po_items" type="hidden">

                            </div>
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
        $("#po_category").change(function () {
            var po_category = $('#po_category').val();
            var url = "<?=base_url()?>store/getActivePO/"+po_category;
            var postData = 'po_category='+po_category;
            $.ajax({
                type: "POST",
                url: url,
                success: function(result)
                {
                    var dataArray = result.split(',');
                    $('#job_card').html(dataArray[0]);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#job_card").change(function () {
            var job_card = $('#job_card').val();
            var url = "<?=base_url()?>production/getjobcard/"+job_card;
            var postData = 'job_card='+job_card;
            $.ajax({
                type: "POST",
                url: url,
                success: function(result)
                {
                    var dataArray = result.split(',');
                    $('#po_customer_name').val(dataArray[0]);
                    $('#po_customer').val(dataArray[1]);
                    $('#po_item').val(dataArray[2]);
                    $('#po_item_name').val(dataArray[3]);
                    $('#req_po_qty').val(dataArray[4]);
                    $('#bal_po_qty').val(dataArray[5]);
                    $('#lot_no').html(dataArray[6]);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#po_item").change(function () {
            var po_item = $('#po_item').val();
            var url = "<?=base_url()?>production/getPOItemdetails/"+po_item;
            var postData = 'po_item='+po_item;
            $.ajax({
                type: "POST",
                url: url,
                success: function(result)
                {
                    var dataArray = result.split(',');
                    $('#req_po_qty').val(dataArray[1]);
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
