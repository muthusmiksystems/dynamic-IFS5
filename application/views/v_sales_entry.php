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
                                <h3><i class="icon-book"></i> Sales Invoice Entry</h3>
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
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url()?>sales/savesalesentry">
                        <section class="panel">                                                <header class="panel-heading">
                                Sales Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-3">
                                <label for="sales_date">Date</label>
                                <input class="form-control dateplugin" id="sales_date" name="sales_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_category">Category</label>
                                <select class="form-control select2" name="packing_category" id="packing_category" required>
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
                              <div class="form-group col-lg-3">
                                <label for="customer_id">Customer Name</label>
                                <select class="form-control select2" name="customer_id" id="customer_id">
                                  <option></option>
                                </select>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="sales_dc_no">Dc No</label>
                                <select class="form-control select2" name="sales_dc_no" id="sales_dc_no">
                                  <option></option>
                                </select>
                              </div>                                                 </div>
                        </section>

                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Items
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="itemsdata">
                              </table>
                            </div>
                        </section>
                        <!-- End Item List -->

                        <section class="panel">
                            <header class="panel-heading">
                                Remarks
                            </header>
                            <div class="panel-body">
                              <textarea class="form-control" id="sales_remarks" name="sales_remarks"></textarea>
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

      // Add Row
      $(function() {
        var scntDiv = $('#packingcones');
        var i = $('#packingcones .conesrow').size() + 1;
        $( ".addrow" ).live( "click", function() {
          var nextrow = '<div class="clear"></div><div class="conesrow" style="width:100%;float:left"><div class="form-group col-lg-3"><input class="form-control" name="cones_type[]" type="text" required></div><div class="form-group col-lg-3"><input class="form-control" name="cones_count[]" type="text" required></div><div class="form-group col-lg-3"><input class="form-control" name="cones_weight[]" type="text" required></div><div class="form-group col-lg-2"><button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button></div></div>';
          $(nextrow).appendTo(scntDiv);          i++;
          return false;
          alert( i ); // jQuery 1.3+
        });
        $('.removerow').live('click', function() {
          if( i > 2 ) {
              $(this).parents('#packingcones .conesrow').remove();
              i--;
          }
          return false;
        });
      });
      

      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });
      $(function(){
        $("#packing_category").change(function () {
            var packing_category = $('#packing_category').val();
            // alert(packing_category);
            var url = "<?=base_url()?>masters/getcustomerdatas/"+packing_category;
            var postData = 'packing_category='+packing_category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(customers)
                {
                    $("#customer_id").html(customers);
                }
            });
            return false;
        });
      });
      $(function(){
        $("#customer_id").change(function () {
            var customer_id = $('#customer_id').val();
            var url = "<?=base_url()?>sales/getcustomerDC/"+customer_id;
            var postData = 'customer_id='+customer_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    console.log(result);
                    $("#sales_dc_no").html(result);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#sales_dc_no").change(function () {
            var sales_dc_no = $('#sales_dc_no').val();
            var url = "<?=base_url()?>sales/getDCItems/"+sales_dc_no;
            var postData = 'sales_dc_no='+sales_dc_no;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    console.log(result);
                    $("#itemsdata").html(result);
                }
            });
            return false;
        });
      });
      
  </script>

  </body>
</html>
