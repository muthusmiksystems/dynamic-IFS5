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
                                <h3><i class="icon-book"></i> Job Order Enquiry</h3>
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
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>productions/saveenquiry">
                        <section class="panel">                                                <header class="panel-heading">
                                Enquiry Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-4">
                                <label for="enq_category">Category</label>
                                <select class="form-control" name="enq_category" id="enq_category" required>
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
                                <label for="enq_date">Date</label>
                                <input class="form-control dateplugin" id="enq_date" name="enq_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="enq_customer">Customer Name</label>
                                <select class="form-control" id="enq_customer" name="enq_customer" required>
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="enq_contact_person">Contact Person</label>
                                <input class="form-control" id="enq_contact_person" name="enq_contact_person" type="text">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="enq_marketing_staff">Marketing Staff</label>
                                <input class="form-control" id="enq_marketing_staff" name="enq_marketing_staff" type="text">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="enq_mobile_no">MObile No</label>
                                <input class="form-control" id="enq_mobile_no" name="enq_mobile_no" type="text">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="enq_email">Email</label>
                                <input class="form-control" id="enq_email" name="enq_email" type="email">
                              </div>
                            </div>
                        </section>

                        <!-- Start Add Items -->                                        <section class="panel">
                            <header class="panel-heading">
                                Add Items
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-2">
                                <label for="enq_itemgroup">Item Group</label>
                                <select class="form-control" name="enq_itemgroup" id="enq_itemgroup">
                                  <option value="">Select Group</option>
                                                          </select>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="enq_item">Item Name</label>
                                <select class="form-control" name="enq_item" id="enq_item">
                                  <option value="">Select Item</option>
                                                         </select>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="enq_itemcolor">Item Shade</label>
                                <select class="form-control" name="enq_itemcolor" id="enq_itemcolor">
                                  <option value="">Select Color</option>
                                                          </select>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="enq_itemuom">Item Uom</label>
                                <select class="form-control" name="enq_itemuom" id="enq_itemuom">
                                  <option value="">Select Uom</option>
                                                          </select>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="enq_required_qty">Required Qty</label>
                                <input class="form-control" id="enq_required_qty" name="enq_required_qty" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="enq_required_qty">&nbsp;</label>
                                <button type="button" class="form-control btn btn-primary addtocart"><i class="icon-plus"></i> Add</button>
                              </div>
                            </div>
                        </section>
                        <!-- End Add Items -->
                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Items
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="cartdata">                                                        <?php $this->load->view('v_enquiry_items.php'); ?>
                              </table>
                            </div>
                        </section>
                        <!-- End Item List -->

                        <!-- Start Remarks -->
                        <section class="panel">                                                <header class="panel-heading">
                                Other Details
                            </header>
                            <div class="panel-body">
                              <div class="form-group col-lg-12">
                                <label for="enq_remarks">Remarks</label>
                                <textarea class="form-control" name="enq_remarks" id="enq_remarks"></textarea>
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
        $("#enq_category").change(function () {
            var enq_category = $('#enq_category').val();
            // alert(enq_category);
            var url = "<?=base_url()?>productions/jobenquirySelectdatas/"+enq_category;
            var postData = 'enq_category='+enq_category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(groups)
                {
                    var dataArray = groups.split(',');
                    $('#enq_customer').html(dataArray[0]);
                    $('#enq_itemuom').html(dataArray[1]);
                    $('#enq_itemgroup').html(dataArray[2]);
                    $('#enq_itemcolor').html(dataArray[3]);
                    $('#enq_shade_no').html(dataArray[3]);
                    $('#enq_lot_no').html(dataArray[4]);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#enq_itemgroup").change(function () {
            var enq_itemgroup = $('#enq_itemgroup').val();
            // alert(enq_itemgroup);
            var url = "<?=base_url()?>masters/getItemsdatas/"+enq_itemgroup;
            var postData = 'enq_itemgroup='+enq_itemgroup;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(groups)
                {
                    var dataArray = groups.split(',');
                    $('#enq_item').html(dataArray[0]);
                }
            });
            return false;
        });
      });

      $(function(){
        $(".addtocart").click(function() {
            var enq_category = $('#enq_category').val();
            var enq_date = $('#enq_date').val();
            var enq_customer = $('#enq_customer').val();
            var enq_itemgroup = $('#enq_itemgroup').val();
            var enq_item = $('#enq_item').val();
            var enq_itemcolor = $('#enq_itemcolor').val();
            var enq_itemuom = $('#enq_itemuom').val();
            var enq_required_qty = $('#enq_required_qty').val();

            var url = "<?=base_url()?>productions/addenquiryItem";
            var postData = 'enq_category='+enq_category+'&enq_date='+enq_date+'&enq_customer='+enq_customer+'&enq_itemgroup='+enq_itemgroup+'&enq_item='+enq_item+'&enq_itemcolor='+enq_itemcolor+'&enq_itemuom='+enq_itemuom+'&enq_required_qty='+enq_required_qty;
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function(msg)
                {
                   $('#cartdata').fadeOut('slow').load('<?=base_url();?>purchase/enquiry_items').fadeIn("slow");
                   // $('#cartdata').fadeOut('slow').fadeIn("slow");
                   // location.reload(true);
                   console.log(msg);
                }
            });
            return false;
        });
      });

      $(function(){
        $( "a.removecart" ).live( "click", function() {
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>productions/deleteenquiryItem/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#cartdata').fadeOut('slow').load('<?=base_url();?>purchase/enquiry_items').fadeIn("slow");                           }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
