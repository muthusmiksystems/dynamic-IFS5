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
                                <h3><i class="icon-book"></i> New Enquiry</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                    <?php
                    if($this->session->flashdata('warning'))
                    {
                    ?>
                    <section class="panel">
                       <header class="panel-heading">
                          <div class="alert alert-warning fade in">
                             <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                             </button>
                             <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                          </div>
                       </header>
                    </section>
                    <?php
                    }                                              if($this->session->flashdata('error'))
                    {
                    ?>
                    <section class="panel">
                       <header class="panel-heading">
                          <div class="alert alert-block alert-danger fade in">
                             <button data-dismiss="alert" class="close close-sm" type="button">
                             <i class="icon-remove"></i>
                             </button>
                             <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                          </div>
                       </header>
                    </section>
                    <?php
                    }
                    if($this->session->flashdata('success'))
                    {
                    ?>
                    <section class="panel">
                       <header class="panel-heading">
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
                       </header>
                    </section>
                    <?php
                    }
                    ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>purchase/newenquiry_2_save">
                        <section class="panel">                                                <header class="panel-heading">
                                Enquiries Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-4">
                                <label for="enq_date">Date</label>
                                <input class="datepicker form-control" id="enq_date" name="enq_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="enq_customer">Customers</label>
                                <select class="select2 form-control" name="enq_customer" id="enq_customer" required>
                                  <option value="">Select Customer</option>
                                  <?php
                                  foreach ($customers as $customer) {
                                    ?>
                                    <option value="<?=$customer['cust_id']; ?>"><?=$customer['cust_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="enq_mark_staff">Marketing Staff</label>
                                <select class="select2 form-control" name="enq_mark_staff" id="enq_mark_staff" required>
                                  <option value="">Select Staff</option>
                                  <?php
                                  foreach ($staffs as $staff) {
                                    ?>
                                    <option value="<?=$staff['ID']; ?>"><?=$staff['display_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div> 
                            </div>
                        </section>

                        <!-- Start Add Items -->                                        <section class="panel">
                            <header class="panel-heading">
                                Add Items
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-3">
                                <label for="enq_itemgroup">Item Group</label>
                                <select class="select2 form-control" name="enq_itemgroup" id="enq_itemgroup">
                                  <option value="">Select Group</option>
                                    <?php
                                    foreach ($itemgroups as $itemgroup) {
                                      ?>
                                      <option value="<?=$itemgroup['group_id']; ?>"><?=$itemgroup['group_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                </select>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="enq_item">Item Name</label>
                                <select class="select2 form-control" name="enq_item" id="enq_item">
                                  <option value="">Select Item</option>
                                                         </select>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="enq_required_qty">Required Qty</label>
                                <input class="form-control" id="enq_required_qty" name="enq_required_qty" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="enq_itemuom">Item Uom</label>
                                <select class="select2 form-control" name="enq_itemuom" id="enq_itemuom">
                                  <option value="">Select Uom</option>
                                  <?php
                                  foreach ($uoms as $uom) {
                                    ?>
                                    <option value="<?=$uom['uom_id']; ?>"><?=$uom['uom_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
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
                              <table class="table table-striped table-hover" id="cartdata">                                                        <?php $this->load->view('v_2_enq_items.php'); ?>
                              </table>
                            </div>
                        </section>
                        <!-- End Item List -->
                        <!-- Start Remarks -->
                        <section class="panel">                                                <header class="panel-heading">
                                Other Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-6">
                                <label for="enq_lead_time">Lead Time</label>
                                <div class="input-group">
                                  <input class="form-control"  name="enq_lead_time" id="enq_lead_time" type="text" placeholder="No of days">
                                  <span class="input-group-addon">Days</span>
                                </div>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="enq_reference">Reference</label>
                                <input class="form-control"  name="enq_reference" id="enq_reference" type="text" placeholder="">                                                      </div>
                              <div class="form-group col-lg-6">
                                <label for="enq_item_remarks">Item Remarks</label>
                                <textarea class="form-control" name="enq_item_remarks" id="enq_item_remarks"></textarea>
                              </div>
                              <div class="form-group col-lg-6">
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
        $("#enq_itemgroup").change(function () {
            var enq_itemgroup = $('#enq_itemgroup').val();
            // alert(enq_itemgroup);
            var url = "<?=base_url()?>purchase/getItems_2_datas/"+enq_itemgroup;
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
            var enq_itemgroup = $('#enq_itemgroup').val();
            var enq_item = $('#enq_item').val();
            var enq_required_qty = $('#enq_required_qty').val();
            var enq_itemuom = $('#enq_itemuom').val();

            var url = "<?=base_url()?>purchase/add_enq_2_item";
            var postData = 'enq_itemgroup='+enq_itemgroup+'&enq_item='+enq_item+'&enq_required_qty='+enq_required_qty+'&enq_itemuom='+enq_itemuom;
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function(result)
                {
                   $('#cartdata').load('<?=base_url();?>purchase/enq_2_items');
                   // location.reload(true);
                   // console.log(result);
                }
            });
            return false;
        });
      });

      $(function(){
        $( "a.removecart" ).live( "click", function() {
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>purchase/remove_enq_2_item/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#cartdata').load('<?=base_url();?>purchase/enq_2_items');
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
