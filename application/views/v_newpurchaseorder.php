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
                                <h3><i class="icon-book"></i> New Purchase Order</h3>
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
                foreach ($quotations as $quotation) {
                    $quote_id = $quotation['quote_id'];
                    $quote_enq_id = $quotation['quote_enq_id'];
                    $quote_category = $quotation['quote_category'];
                    $quote_customer = $quotation['quote_customer'];
                    $quote_shade_no = $quotation['quote_shade_no'];
                    $quote_lot_no = $quotation['quote_lot_no'];
                    $quote_lead_time = $quotation['quote_lead_time'];
                    $quote_reference = $quotation['quote_reference'];
                    $quote_item_remarks = $quotation['quote_item_remarks'];
                    $quote_payment_terms = $quotation['quote_payment_terms'];
                    $quote_remarks = $quotation['quote_remarks'];

                    $quote_customer_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $quotation['quote_customer'], 'cust_name');
                    $quote_shade_name = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $quote_shade_no, 'shade_name');
                    $quote_lot_name = $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $quote_lot_no, 'lot_no');                            }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>purchase/saveorder">
                        <input type="hidden" name="quote_id" value="<?=$quote_id; ?>">
                        <input type="hidden" name="order_enq_id" value="<?=$quote_enq_id; ?>">
                        <input type="hidden" name="order_category" value="<?=$quote_category; ?>">
                        <section class="panel">                                                <header class="panel-heading">
                                Purchase Order Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-6">
                                <label for="order_date">Date</label>
                                <input class="datepicker form-control" id="order_date" name="order_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="order_customer_name">Customer Name</label>
                                <input type="hidden" name="order_customer" value="<?=$quote_customer; ?>">
                                <input class="form-control" id="order_customer_name" name="order_customer_name" value="<?=$quote_customer_name; ?>" required>
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
                                    <th class="hidden-phone">Item Name</th>
                                    <th class="">Color</th>
                                    <th class="">Uom</th>
                                    <th class="">Quantity</th>
                                    <th class="">Rate</th>
                                    <th class="">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php                                                        $items = $this->m_purchase->getenquiryitems($quote_enq_id);
                                $sno = 1;
                                $order_subtotal = 0;
                                $order_grand_total = 0;
                                foreach ($items as $item) {
                                  ?>
                                  <tr>
                                      <td><?=$sno; ?></td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $item['enq_itemgroup'], 'group_name'); ?>
                                      </td>
                                      <td class="hidden-phone">
                                        <?=$this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item['enq_item'], 'item_name'); ?>
                                      </td>
                                      <td class="">
                                        <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name'); ?>
                                      </td>
                                      <td class="">
                                        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_itemuom'], 'uom_name'); ?>
                                      </td>
                                      <td><?=$item['enq_required_qty']; ?></td>
                                      <td>
                                          <?=$item['enq_item_rate']; ?>
                                      </td>
                                      <td>
                                        <?=($item['enq_required_qty'] * $item['enq_item_rate']); ?>
                                      </td>
                                  </tr>
                                  <?php
                                  $order_subtotal += $item['enq_required_qty'] * $item['enq_item_rate'];
                                  $sno++;
                                }
                                $order_grand_total += $order_subtotal;
                                ?>                                                      </tbody>
                              </table>
                              <div class="row">
                                  <div class="col-lg-4 invoice-block pull-right">
                                      <ul class="unstyled amounts">
                                          <li>
                                            <strong>Sub - Total amount :</strong>  <i class="icon-inr"></i> <?=$order_subtotal; ?>
                                          </li>
                                          <li>
                                            <strong>Tax :</strong>
                                            <?php
                                            $taxs = $this->m_purchase->getactiveTaxs($quote_category);
                                            foreach ($taxs as $tax) {
                                              ?>
                                              <input type="hidden" name="order_tax_names[]" value="<?=$tax['tax_name']; ?>">
                                              <label class="checkbox-inline">
                                                <input type="checkbox" name="taxs[]" value="<?=$tax['tax_value']; ?>">
                                                <?=$tax['tax_name']; ?>
                                              </label>
                                              <?php
                                            }
                                            ?>
                                          </li>
                                          <li><strong>Other Charges :</strong></li>
                                          <?php
                                            $othercharges = $this->m_purchase->getactiveOthercharges($quote_category);
                                            foreach ($othercharges as $othercharge) {
                                              ?>
                                              <li>
                                              <strong><?=$othercharge['othercharge_name']; ?> :</strong>                                                                                  <input name="order_othercharges[<?=$othercharge['othercharge_id']; ?>]" style="width:150px;" type="text">
                                              <input name="order_othercharges_type[<?=$othercharge['othercharge_id']; ?>]" type="hidden" value="<?=$othercharge['othercharge_type']; ?>">
                                              <input name="order_othercharges_names[<?=$othercharge['othercharge_id']; ?>]" type="hidden" value="<?=$othercharge['othercharge_name']; ?>">
                                              <select name="order_othercharges_unit[<?=$othercharge['othercharge_id']; ?>]">
                                                <option value="%">%</option>
                                                <option value="Rs">Rs</option>
                                              </select>
                                              </li>
                                              <?php
                                            }
                                            ?>
                                      </ul>
                                  </div>
                              </div>

                            </div>
                        </section>
                        <!-- End Item List -->

                                        <!-- Start Remarks -->
                        <section class="panel">                                                <header class="panel-heading">
                                Other Details
                            </header>                                              <div class="panel-body">
                              <div class="form-group col-lg-6">
                                <label for="order_packing_details">Packing Details</label>
                                <textarea class="form-control" name="order_packing_details" id="order_packing_details" placeholder=""></textarea>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="order_transportation">Transportation</label>
                                <textarea class="form-control" name="order_transportation" id="order_transportation" placeholder=""></textarea>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="order_lead_time">Lead Time</label>
                                <div class="input-group">
                                  <input class="form-control"  name="order_lead_time" id="order_lead_time" value="<?=$quote_lead_time; ?>" type="text" placeholder="No of days">
                                  <span class="input-group-addon">Days</span>
                                </div>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="order_reference">Reference</label>
                                <input class="form-control"  name="order_reference" id="order_reference" value="<?=$quote_reference; ?>" type="text" placeholder="">                                                      </div>
                              <div class="form-group col-lg-6">
                                <label for="order_item_remarks">Item Remarks</label>
                                <textarea class="form-control" name="order_item_remarks" id="order_item_remarks"><?=$quote_item_remarks; ?></textarea>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="order_remarks">Remarks</label>
                                <textarea class="form-control" name="order_remarks" id="order_remarks"><?=$quote_remarks; ?></textarea>
                              </div> 
                              <div class="form-group col-lg-6">
                                <label for="order_payment_terms">Payment Terms</label>
                                <textarea class="form-control" name="order_payment_terms" id="order_payment_terms" placeholder=""><?=$quote_payment_terms; ?></textarea>
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

      /*$(function(){
        $( "a.removecart" ).live( "click", function() {
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>purchase/deletequotationItem/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#cartdata').fadeOut('slow').load('<?=base_url();?>purchase/quotation_items').fadeIn("slow");                           }
            });
            return false;
        });
      });*/

  </script>

  </body>
</html>
