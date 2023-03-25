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
                                <h3><i class="icon-book"></i> SELLING POY</h3>
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
                            /*echo "<pre>";
                            print_r($poy_deniers);
                            echo "</pre>";*/
                            ?>   
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>store/savestockissue">
                        <section class="panel">                                                <header class="panel-heading">
                                Issue Details
                            </header>                                                <div class="panel-body">
							
							   <div class="form-group col-lg-4">
                                <label for="po_date">Invoice No</label>
                                <input class="form-control" id="invoice" name="invoice" value="0143" type="text" required disabled>
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">To</label>
                                <input class="form-control" id="to" name="to" value="" type="text" required>
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">Item Name</label>
                                <input class="form-control" id="to" name="to" value="" type="text" required>
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">Item code</label>
                                <input class="form-control" id="to" name="to" value="" type="text" required>
                              </div>
							  
                              <div class="form-group col-lg-4">
                                <label for="po_category">Poy denier</label>
                                <select class="form-control select2" name="po_category" id="poy_denier" required>
                                  <option value="">Select denier</option>
                                  <?php
                                  foreach ($poy_deniers as $row) {
                                    ?>
                                    <option value="<?=$row['denier_id']; ?>"><?=$row['denier_name']; ?></option>									                                             <?php
                                  }
                                  ?>
                                </select>
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">Poy Lot Number</label>
                                <input class="form-control" id="to" name="to" value="" type="text" required>
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">Qty</label>
                                <input class="form-control" id="to" name="to" value="" type="text" required>
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">Rate</label>
                                <input class="form-control" id="to" name="to" value="" type="text" required>
                              </div>				
                              <div class="form-group col-lg-4">
                                <label for="po_issued_remarks">Remarks</label>
                                <textarea class="form-control" id="po_issued_remarks" name="po_issued_remarks"></textarea>
                              </div>
                                                    <input class="form-control" id="po_items" name="po_items" type="hidden">

                            </div>
                        </section>

                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Sale</button>
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
                    $('#po_order').html(dataArray[0]);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#po_order").change(function () {
            var po_order = $('#po_order').val();
            var url = "<?=base_url()?>store/getPOdetails/"+po_order;
            var postData = 'po_order='+po_order;
            $.ajax({
                type: "POST",
                url: url,
                success: function(result)
                {
                    var dataArray = result.split(',');
                    $('#po_customer_name').val(dataArray[0]);
                    $('#po_customer').val(dataArray[1]);
                    $('#po_qty').val(dataArray[2]);
                    $('#po_issued_qty').val(dataArray[3]);
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
