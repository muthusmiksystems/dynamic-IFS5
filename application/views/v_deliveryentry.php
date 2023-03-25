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
                                <h3><i class="icon-book"></i> Delivery</h3>
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
                <?php
                $othercharges_array = array();
                foreach ($orders as $order) {
                    $order_id = $order['order_id'];
                    $order_enq_id = $order['order_enq_id'];
                    $order_category = $order['order_category'];
                    $order_date = $order['order_date'];
                    $order_supplier = $order['order_supplier'];
                    $order_shade_no = $order['order_shade_no'];
                    $order_lot_no = $order['order_lot_no'];
                    $order_lead_time = $order['order_lead_time'];
                    $order_reference = $order['order_reference'];
                    $order_item_remarks = $order['order_item_remarks'];
                    $order_payment_terms = $order['order_payment_terms'];
                    $order_remarks = $order['order_remarks'];
                    $taxs = explode(",", $order['taxs']);
                    $order_tax_names = explode(",", $order['order_tax_names']);
                    $order_othercharges = explode(",", $order['order_othercharges']);
                    $order_othercharges_unit = explode(",", $order['order_othercharges_unit']);
                    $order_othercharges_type = explode(",", $order['order_othercharges_type']);
                    $order_othercharges_names = explode(",", $order['order_othercharges_names']);

                    $order_supplier_name = $this->m_masters->getmasterIDvalue('bud_suppliers', 'sup_category', $order['order_supplier'], 'sup_name');
                    $order_shade_name = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $order_shade_no, 'shade_name');
                    $order_lot_name = $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $order_lot_no, 'lot_no');
                          }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>purchase/savedelivery">
                        <input type="hidden" name="delivery_enq_id" value="<?=$order_enq_id; ?>">
                        <input type="hidden" name="delivery_category" value="<?=$order_category; ?>">
                        <section class="panel">                                                <header class="panel-heading">
                                Delivery Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-6">
                                <label for="delivery_date">Date</label>
                                <input class="datepicker form-control" id="delivery_date" name="delivery_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="delivery_supplier_name">Supplier Name</label>
                                <input type="hidden" name="delivery_supplier" value="<?=$order_supplier; ?>">
                                <input class="form-control" id="delivery_supplier_name" name="delivery_supplier_name" value="<?=$order_supplier_name; ?>" required>
                              </div> 
                            </div>
                        </section>
                                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Items
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="cartdata">                                                        <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Group</th>
                                    <th>Item Name</th>
                                    <th>Item</th>
                                    <th class="">Color</th>
                                    <th class="">Stock Quantity</th>
                                    <th class="">Uom</th>
                                    <th class="">Delivery Qty</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $items = $this->m_purchase->getenquiryitems($order_enq_id);
                                $sno = 1;
                                foreach ($items as $item) {
                                  ?>
                                  <tr>
                                      <td><?=$sno; ?></td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $item['enq_itemgroup'], 'group_name'); ?>
                                      </td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item['enq_item'], 'item_name'); ?>
                                      </td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item['enq_item'], 'item_code'); ?>
                                      </td>
                                      <td class="">
                                        <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name'); ?>
                                      </td>
                                      <td><?=$item['enq_required_qty']; ?></td>
                                      <td class="">
                                        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_itemuom'], 'uom_name'); ?>
                                      </td>
                                      <td>
                                          <input class="form-control" style="width:150px;" name="order_delivery_qty[<?=$item['enq_item_id']; ?>]" required>                                                                                                                </td>
                                  </tr>
                                  <?php
                                  $sno++;
                                }
                                ?>                                                      </tbody>
                              </table>
                            </div>
                        </section>
                        <!-- End Item List -->

                        <!-- End Yarn Details -->                                        <section class="panel">                                                <header class="panel-heading">
                                Delivery Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-6">
                                <label for="delivery_issued_by">Issued By</label>
                                <input class="form-control"  name="delivery_issued_by" id="delivery_issued_by" type="text" placeholder="">
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="delivery_issued_to">Issued to</label>
                                <input class="form-control"  name="delivery_issued_to" id="delivery_issued_to" type="text" placeholder="">
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="delivery_remarks">Remarks</label>
                                <textarea class="form-control" name="delivery_remarks" id="delivery_remarks" placeholder=""></textarea>
                              </div>
                            </div>
                        </section>
                        <!-- End Yarn Details -->                                        <section class="panel">
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

      /*$(function(){
        $( "a.removecart" ).live( "click", function() {
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>purchase/deleteenquiryItem/"+row_id;
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
      });*/

  </script>

  </body>
</html>
