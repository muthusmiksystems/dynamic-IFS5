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
                                <h3><i class="icon-user"></i> POY PO Issue</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>poy/po_issue_save">
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
                                <div class="form-group col-lg-12">
                                   <label >PO No</label>
                                   <span class="label label-danger" style="font-size:24px;"><?=$issue_no; ?></span>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="customer_name">Supplier Name</label>
                                   <select class="select2 form-control customerselects" id="customer_name" name="customer_name" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($suppliers as $row) {
                                        ?>
                                        <option value="<?=$row['sup_id']; ?>"><?=$row['sup_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="customer_id">Supplier Code</label>
                                   <select class="select2 form-control customerselects" id="customer_id" name="customer_id" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($suppliers as $row) {
                                        ?>
                                        <option value="<?=$row['sup_id']; ?>"><?=$row['sup_id']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="delivery_date">Delivery Date</label>
                                   <input type="text" class="datepicker form-control" id="delivery_date" name="delivery_date">
                                </div>
                                <div style="clear:both;"></div>
                                <div class="form-group col-lg-3">
                                   <label for="item_name">Item Name</label>
                                   <select class="select2 form-control itemsselects" id="item_name" name="item_name" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($items as $row) {
                                        ?>
                                        <option value="<?=$row['item_id']; ?>"><?=$row['item_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="item_id">Item Code</label>
                                   <select class="select2 form-control itemsselects" id="item_id" name="item_id" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($items as $row) {
                                        ?>
                                        <option value="<?=$row['item_id']; ?>"><?=$row['item_id']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label>Shade Name</label>
                                   <select class="select2 form-control shades-select" name="shade_id" id="shade_id" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($shades as $row) {
                                        ?>
                                        <option value="<?=$row['shade_id']; ?>"><?=$row['shade_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label>Shade No</label>
                                   <select class="select2 form-control shades-select">
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($shades as $row) {
                                        ?>
                                        <option value="<?=$row['shade_id']; ?>"><?=$row['shade_code']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2">
                                   <label for="po_qty">Qty</label>
                                   <input type="text" class="form-control" id="po_qty" name="po_qty">
                                </div>
                                <div class="form-group col-lg-2">
                                   <label for="item_uom">UOM</label>
                                   <select class="select2 form-control" id="item_uom" name="item_uom">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($uoms as $row) {
                                      ?>
                                      <option value="<?=$row['uom_id']; ?>"><?=$row['uom_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-1">
                                   <label>&nbsp;</label>
                                   <div style="clear:both;"></div>
                                   <button class="btn btn-primary" type="button" id="addtocart">Add</button>
                                </div>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
                                        <section class="panel">
                            <header class="panel-heading">
                            Items
                            </header>
                            <div class="panel-body" id="po_cartitems">
                                                  </div>
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form> 

                      <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            Summery <!-- //

*********************************************************************************************************************************************
**********************************************FOR ITEMS REFER *******************************************************************************
PURCHASE ORDER TABLE => BUD_YT_PO_ISSUE  p_key(PO_NO);
PURCHASE ITEMS 		 => BUD_YT_PO_ITEMS  f_key(PO_NO);
*********************************************************************************************************************************************
							-->
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
								                <th>Po no</th>
                                <th>Supplier</th>
                                <th>Item Name/Code</th>
                                <th>Shade Name/Code</th>
                                <th>Date</th>
								                <th>Time</th>
                                <th>Delivery Date</th>
                                <th>Qty</th>
                                <th>Uom</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($po_issue as $row) {
                              ?>
                              <tr class="odd gradeX">
                                  <td><?=$sno; ?></td>
								                  <td><?=$row['po_no']; ?></td>
                                  <td><?=$row['cust_name']; ?></td>
                                  <td><?php echo $row['item_name']; ?>/<?php echo $row['item_id']; ?></td>
                                  <td><?php echo $row['shade_name']; ?>/<?php echo $row['shade_code']; ?></td>
                                  <td><?=$row['po_date']; ?></td>      
								                  <td><?=$row['po_time']; ?></td>      
								                  <td><?=$row['delivery_date']; ?></td>                                                           <td><?=$row['tatalPOqty']; ?></td>
                                  <td>Kg</td>
                                  <td>
                                    <a href="#" title="Delete" class="btn btn-danger btn-xs delete-user">Delete</a>
                                  </td>
                              </tr>
                              <?php
                              $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
                    </section>
                    <!-- End Talbe List  -->                               </div>
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
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });
      $('#po_cartitems').load('<?=base_url();?>poy/po_cartItems'); 
      $(".customerselects").change(function(){
        $(".customerselects").select2("val", $(this).val());
      });
      $(".itemsselects").change(function(){
        $(".itemsselects").select2("val", $(this).val());
      });
      $(".shades-select").change(function(){
        $(".shades-select").select2("val", $(this).val());
      });
      $(function(){
        $("#sup_group_id").change(function () {
            var sup_group_id = $('#sup_group_id').val();
            var url = "<?=base_url()?>poy/getsuppliers/"+sup_group_id;
            var postData = 'sup_group_id='+sup_group_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                  $("#supplier_id").html('<option value="">Select</option>');
                  $("#poy_lot").html('<option value="">Select</option>');
                  $("#poy_denier").html('<option value="">Select</option>');
                  $("#supplier_id").select2("val", '');
                  $("#poy_lot").select2("val", '');
                  $("#poy_denier").select2("val", '');
                  $("#supplier_id").html(result);
                }
            });
            return false;
        });
      });
      $(function(){
        $("#supplier_id").change(function () {
            var supplier_id = $('#supplier_id').val();
            var url = "<?=base_url()?>poy/getsupplierDeniers/"+supplier_id;
            var postData = 'supplier_id='+supplier_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                  $("#poy_denier").html('<option value="">Select</option>');
                  $("#poy_lot").html('<option value="">Select</option>');
                  $("#poy_denier").select2("val", '');
                  $("#poy_lot").select2("val", '');
                  $("#poy_denier").html(result);
                }
            });
            return false;
        });
      });
      $(function(){
        $("#poy_denier").change(function () {
            var poy_denier = $('#poy_denier').val();
            var url = "<?=base_url()?>poy/getpoylots/"+poy_denier;
            var postData = 'poy_denier='+poy_denier;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                  $("#poy_lot").html('<option value="">Select</option>');
                  $("#poy_lot").select2("val", '');
                  $("#poy_lot").html(result);
                }
            });
            return false;
        });
      });
      $(function(){
        $("#addtocart").click(function () {
            var item_id = $('#item_id').val();
            var shade_id = $('#shade_id').val();
            var po_qty = $('#po_qty').val();
            var item_uom = $('#item_uom').val();
            var url = "<?=base_url()?>poy/po_addtocart";
            var postData = 'item_id='+item_id+"&shade_id="+shade_id+"&po_qty="+po_qty+"&item_uom="+item_uom;
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function(result)
                {
                  $('#po_cartitems').load('<?=base_url();?>poy/po_cartItems');
                }
            });
            return false;
        });
      });
      $(function(){
        $( "a.removetocart" ).live( "click", function() {
            // alert('hi');
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>poy/po_removetocart/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#po_cartitems').load('<?=base_url();?>poy/po_cartItems');
                }
            });
            return false;
        });
      });
  </script>

  </body>
</html>
