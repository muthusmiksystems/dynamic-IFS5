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
                                <h3><i class="icon-book"></i> Packing</h3>
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
                      <form class="cmxform form-horizontal tasi-form packing-form" role="form" id="commentForm" method="post" action="<?=base_url()?>production/savepacking">
                        <section class="panel">                                                <header class="panel-heading">
                                Packing Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-3">
                                <label for="packing_date">Date</label>
                                <input class="form-control dateplugin" id="packing_date" name="packing_date" value="<?=date('d-m-Y'); ?>" type="text" required>
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
                                <label for="process_id">Process Card No</label>
                                <select class="form-control select2" id="process_id" name="process_id" required>
                                </select>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_item">Item</label>
                                <input type="hidden" name="box_item" id="box_item">
                                <input type="hidden" name="enq_item" id="enq_item">
                                <input class="form-control" id="packing_item" name="packing_item" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_color">Color</label>
                                <input type="hidden" name="box_itemcolor" id="box_itemcolor">
                                <input class="form-control" id="packing_color" name="packing_color" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_shade_no">Shade No</label>
                                <input class="form-control" id="packing_shade_no" name="packing_shade_no" type="text" required>
                              </div>
                                                                                                       <div class="form-group col-lg-3">
                                <label for="packing_lot_no">Lot No</label>
                                <input type="hidden" name="box_item_lot_no" id="box_item_lot_no">
                                <input class="form-control" id="packing_lot_no" name="packing_lot_no" type="text" required>
                              </div>                                                    <div class="form-group col-lg-3">
                                <label for="packing_expected_qty">Expected Qty</label>
                                <input class="form-control" id="packing_expected_qty" name="packing_expected_qty" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_process_qty">Process Qty</label>
                                <input class="form-control" id="packing_process_qty" name="packing_process_qty" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_box_type">Box Type</label>
                                <input class="form-control" id="packing_box_type" name="packing_box_type" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_box_weight">Box Weight</label>
                                <input class="form-control" id="packing_box_weight" name="packing_box_weight" type="text" required>
                              </div>
                            </div>
                        </section>
                        <section class="panel">                                              <header class="panel-heading">
                              Packing Meterials Details
                          </header>                                              <div class="panel-body" id="packingcones">
                            <div class="conesrow" style="width:100%;float:left">
                              <div class="form-group col-lg-3">
                                <label>Meterial Type</label>
                                <input class="form-control" name="cones_type[]" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_box_weight">Nos</label>
                                <input class="form-control" name="cones_count[]" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_box_weight">Tare Weight</label>
                                <input class="form-control" name="cones_weight[]" type="text" required>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="enq_required_qty">&nbsp;</label>
                                <button type="button" class="form-control btn btn-primary addrow"><i class="icon-plus"></i> Add</button>
                              </div>
                            </div>                                              </div>
                        </section>
                        <!-- <section class="panel">                                              <header class="panel-heading">
                              Weight Details
                          </header>                                              <div class="panel-body">
                            <div class="form-group col-lg-3">
                              <label for="packing_gross_weight">Gross Weight</label>
                              <input class="form-control" id="packing_gross_weight" name="packing_gross_weight" type="text" required>
                            </div>
                            <div class="form-group col-lg-3">
                              <label for="packing_tare_weight">Tare Weight</label>
                              <input class="form-control" id="packing_tare_weight" name="packing_tare_weight" type="text" required>
                            </div>
                            <div class="form-group col-lg-3">
                              <label for="packing_net_weight">Net Weight</label>
                              <input class="form-control" id="packing_net_weight" name="packing_net_weight" type="text" required>
                            </div>
                          </div>
                        </section> -->                          <section class="panel">
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
            var url = "<?=base_url()?>production/getCustomerPO/"+customer_id;
            var postData = 'customer_id='+customer_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(processcards)
                {
                    $("#process_id").html(processcards);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#process_id").change(function () {
            var process_id = $('#process_id').val();
            var url = "<?=base_url()?>production/getPackingItems/"+process_id;
            var postData = 'process_id='+process_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    var dataArray = result.split(',');
                    $("#box_item").val(dataArray[0]);                             $("#packing_item").val(dataArray[1]);                             $("#box_itemcolor").val(dataArray[2]);                               $("#packing_color").val(dataArray[3]);                               $("#packing_shade_no").val(dataArray[4]);                              $("#box_item_lot_no").val(dataArray[5]);                               $("#packing_lot_no").val(dataArray[6]);                               $("#packing_expected_qty").val(dataArray[7]);                               $("#enq_item").val(dataArray[8]);                              $("#packing_process_qty").val(dataArray[9]);                             }
            });
            return false;
        });
      });
  </script>

  </body>
</html>
