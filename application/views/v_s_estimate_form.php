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
                                <h3>Estimate Entry</h3>
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
                                <div class="row">
                                  <div class="form-group col-lg-3">
                                    <label for="item_name">Item Name</label>
                                    <select class="select2 form-control item" name="item_name" id="item_name">
                                       <option value="">Select Item</option>
                                       <?php
                                       foreach ($items as $row) {
                                          ?>
                                          <option value="<?=$row['item_id']; ?>"><?=$row['item_name']; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-lg-2">
                                    <label for="item_id">Item Code</label>
                                    <select class="select2 form-control item" name="item_id" id="item_id">
                                       <option value="">Select Item</option>
                                       <?php
                                       foreach ($items as $row) {
                                          ?>
                                          <option value="<?=$row['item_id']; ?>"><?=$row['item_id']; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-lg-2">
                                    <label for="shade_name">Shade Name</label>
                                    <select class="select2 form-control shade" name="shade_name" id="shade_name">
                                       <option value="">Select Item</option>
                                       <?php
                                       foreach ($shades as $row) {
                                          ?>
                                          <option value="<?=$row['shade_id']; ?>"><?=$row['shade_name']; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-lg-2">
                                    <label for="shade_id">Shade Code</label>
                                    <select class="select2 form-control shade" name="shade_id" id="shade_id">
                                       <option value="">Select Item</option>
                                       <?php
                                       foreach ($shades as $row) {
                                          ?>
                                          <option value="<?=$row['shade_id']; ?>"><?=$row['shade_id']; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-lg-2">
                                    <label for="qty">Qty</label>
                                    <input type="text" class="form-control" name="qty" id="qty">
                                  </div>
                                  <div class="form-group col-lg-2">
                                    <label for="item_uom">Uom</label>
                                    <select class="form-control" name="item_uom" id="item_uom">
                                      <option value="kg">Kg</option>
                                      <option value="cones">Cones</option>
                                    </select>
                                  </div>
                                  <div class="form-group col-lg-2">
                                    <label for="rate">Rate</label>
                                    <input type="text" class="form-control" name="rate" id="rate">
                                  </div>
                                  <div class="form-group col-lg-2">
                                    <label>&nbsp;</label><br/>
                                    <button type="button" class="btn btn-primary" id="addtocart">Add</button>
                                  </div>
                                </div>
                                <hr>
                                <form class="cmxform tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url('estimate/estimate_save');?>">
                                  <div class="row">
                                    <div class="form-group col-lg-4">
                                      <label for="customer_name">Customer Name</label>
                                      <input type="text" class="form-control" name="customer_name" id="customer_name">
                                    </div>
                                    <div class="form-group col-lg-4">
                                      <label for="customer_mobile">Mobile No</label>
                                      <input type="text" class="form-control" name="customer_mobile" id="customer_mobile">
                                    </div>
                                    <div class="form-group col-lg-4">
                                      <label for="estimate_date">Date</label>
                                      <input type="text" class="form-control dateplugin" name="estimate_date" id="estimate_date" value="<?=date("d-m-Y"); ?>">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group col-lg-12">
                                      <label for="remarks">Remarks</label>
                                      <textarea class="form-control" name="remarks" id="remarks"></textarea>
                                    </div>
                                  </div>

                                  <div class="row col-lg-12">
                                    <table id="cart_table" class="table table-bordered table-striped table-condensed">
                                                                  </table>
                                  </div>

                                  <div style="clear:both;"></div>
                                  <div class="row">
                                    <div class="form-group col-lg-12">
                                        <div class="">
                                            <button class="btn btn-danger" type="submit">Save</button>
                                        </div>
                                    </div>
                                  </div>
                                </form>                                                                                   </div>
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

      $(".item").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());
      });
      $(".shade").change(function(){
        $("#shade_name").select2("val", $(this).val());
        $("#shade_id").select2("val", $(this).val());
      });

      $('#cart_table').load('<?=base_url();?>estimate/estimate_cartItems');
      $("#addtocart").click(function(){
        var item_id = $("#item_id").val();
        var shade_id = $("#shade_id").val();
        var qty = $("#qty").val();
        var item_uom = $("#item_uom").val();
        var rate = $("#rate").val();
        var url = "<?=base_url()?>estimate/addtocart";
        var postData = 'item_id='+item_id+'&shade_id='+shade_id+'&qty='+qty+'&item_uom='+item_uom+"&rate="+rate;
        // alert(postData);
        $.ajax({
            type: "POST",
            url: url,
            data: postData,
            success: function(result)
            {
              $('#cart_table').load('<?=base_url();?>estimate/estimate_cartItems');
            }
        });
        return false;
      });

      $(function(){
        $( "a.removetocart" ).live( "click", function() {
            // alert('hi');
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>estimate/removetocart/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#cart_table').load('<?=base_url();?>estimate/estimate_cartItems');
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
