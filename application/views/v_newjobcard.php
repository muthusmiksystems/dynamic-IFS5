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
                                <h3><i class="icon-book"></i> Job Card Entry</h3>
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
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>productions/savejobcard">                                        <section class="panel">                                                <header class="panel-heading">
                                Job Card Details
                            </header>
                            <div class="panel-body">
                              <div class="form-group col-lg-4">
                                <label for="job_date">Date</label>
                                <input class="form-control dateplugin" id="job_date" name="job_date" value="<?=date('d-m-Y'); ?>" type="text" required>
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
                                <label for="job_inward_no">Jon Inward No</label>
                                <select class="form-control" id="job_inward_no" name="job_inward_no">
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_customer_po_no">Customer PO No</label>
                                <input class="form-control" id="job_customer_po_no" name="job_customer_po_no" type="text">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_marketing_staff">Marketing Staff</label>
                                <input class="form-control" id="job_marketing_staff" name="job_marketing_staff" type="text">
                              </div>                                                  </div>
                        </section>
                                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Items
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="cartdata">                                                                              </table>
                            </div>
                        </section>
                        <!-- End Item List -->

                        <!-- Start Remarks -->
                        <section class="panel">                                                <header class="panel-heading">
                                Other Details
                            </header>                                              <div class="panel-body">
                              <div class="form-group col-lg-12">
                                <label for="jobcard_remarks">Remarks</label>
                                <textarea class="form-control" name="jobcard_remarks" id="jobcard_remarks"></textarea>
                              </div> 
                            </div>
                        </section>
                        <!-- End Remarks -->
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
            // alert(jobcard_customer);
            var url = "<?=base_url()?>productions/getcustomerjobinwards/"+jobcard_customer;
            var postData = 'jobcard_customer='+jobcard_customer;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(customers)
                {
                    $('#job_inward_no').html(customers);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#job_inward_no").change(function () {
            var job_inward_no = $(this).val();
            var url = "<?=base_url()?>productions/joborderItems/"+job_inward_no;
            // var postData = 'job_inward_no='+job_inward_no;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(msg)
                {
                    console.log(msg);
                    $('#cartdata').html(msg);
                    // $('#cartdata').fadeOut('slow').load('<?=base_url();?>productions/joborderItems').fadeIn("slow");
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
