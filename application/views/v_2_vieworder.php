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
    foreach ($css_print as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet" media="print">
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
                <!-- page start-->                       <?php
                $othercharges_array = array();
                foreach ($orders as $order) {
                    $order_id = $order['order_id'];
                    $order_enq_id = $order['order_enq_id'];
                    $order_date = $order['order_date'];
                    $order_customer = $order['order_customer'];
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
                    $order_rate_id = explode(",", $order['order_rate_id']);
                    $order_customer_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $order['order_customer'], 'cust_name');                                      }
                // print_r($order_othercharges_type);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>purchase/saveorder">
                                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Order Preview
                            </header>
                            <div class="panel-body">
                              <div class="row invoice-list">
                                  <div class="text-center corporate-id">
                                      <a href="#" class="logo" style="float:none;">Dynamic<span> Dost</span></a>
                                  </div>
                                  <div class="col-lg-4 col-sm-4">
                                      <h4>BILLING ADDRESS</h4>
                                      <p>
                                          <?=$order_customer_name; ?> <br>
                                          44 Dreamland Tower, Suite 566 <br>
                                          ABC, Dreamland 1230<br>
                                          Tel: +12 (012) 345-67-89
                                      </p>
                                  </div>
                                  <div class="col-lg-4 col-sm-4">
                                      <h4>SHIPPING ADDRESS</h4>
                                      <p>
                                          Vector Lab<br>
                                          Road 1, House 2, Sector 3<br>
                                          ABC, Dreamland 1230<br>
                                          P: +38 (123) 456-7890<br>
                                      </p>
                                  </div>
                                  <div class="col-lg-4 col-sm-4">
                                      <h4>INVOICE INFO</h4>
                                      <ul class="unstyled">
                                          <li>Invoice Number    : <strong><?=$order_id; ?></strong></li>
                                          <li>Invoice Date    : <?=$order_date; ?></li>
                                          <li>Due Date      : 2013-03-20</li>
                                          <li>Invoice Status    : Paid</li>
                                      </ul>
                                  </div>
                              </div>
                              <table class="table table-striped table-hover" id="cartdata">                                                        <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Group</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Uom</th>
                                    <th>Rate</th>
                                    <th align="right">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $items = $this->m_masters->getmasterdetails('bud_te_enq_items', 'enq_id', $order_enq_id);
                                $sno = 1;
                                $order_subtotal = 0;
                                $order_grand_total = 0;
                                foreach ($items as $key => $item) {
                                  $enq_item_rates = explode(",", $item['enq_item_rate']);
                                  $item_rate = $enq_item_rates[$order_rate_id[$key]];
                                  ?>
                                  <tr>
                                      <td><?=$sno; ?></td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_te_itemgroups', 'group_id', $item['enq_item_group'], 'group_name'); ?>
                                      </td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item['enq_item'], 'item_name'); ?>
                                      </td>
                                      <td><?=$item['enq_req_qty']; ?></td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_item_uom'], 'uom_name'); ?>
                                      </td>
                                      <td><?=$item_rate; ?></td>
                                      <td align="right">
                                        <?=($item['enq_req_qty'] * $item_rate); ?>
                                      </td>
                                  </tr>
                                  <?php
                                  $order_subtotal += $item['enq_req_qty'] * $item_rate;
                                  $sno++;
                                }
                                $display_subtotal = $order_subtotal;
                                $order_grand_total = 0;
                                // $order_grand_total += $order_subtotal;
                                /* Calculate Deduction */
                                foreach ($order_othercharges_type as $key => $value) {
                                  if($value == '-')
                                  {
                                    $duduction = 0;
                                    if($order_othercharges_unit[$key] == '%')
                                    {
                                      $duduction = ($order_subtotal * $order_othercharges[$key]) / 100;
                                    }
                                    else
                                    {
                                      $duduction = $order_othercharges[$key];
                                    }
                                    $array_key = $order_othercharges_names[$key];
                                    $othercharges_array[$array_key] = $duduction;
                                    $order_subtotal = $order_subtotal - $duduction;
                                    $order_grand_total = $order_grand_total + $order_subtotal;
                                  }
                                }
                                /* Calculate Tax */
                                $tax_array = array();
                                foreach ($taxs as $key => $tax) {
                                  $tax_value = ($order_subtotal * $tax) / 100;
                                  $order_grand_total = $order_grand_total + $tax_value;
                                  $array_key = $order_tax_names[$key];
                                  $tax_array[$array_key] = $tax_value;
                                }
                                /* Calculate Additions */
                                foreach ($order_othercharges_type as $key => $value) {
                                  if($value == '+')
                                  {
                                    $addition = 0;
                                    if($order_othercharges_unit[$key] == '%')
                                    {
                                      $addition = ($order_subtotal * $order_othercharges[$key]) / 100;
                                    }
                                    else
                                    {
                                      $addition = $order_othercharges[$key];
                                    }
                                    $array_key = $order_othercharges_names[$key];
                                    $othercharges_array[$array_key] = $addition;
                                    $order_grand_total = $order_grand_total + $addition;
                                  }
                                }
                                ?>                                                      </tbody>
                              </table>
                              <div class="row">
                                  <div class="col-lg-4 invoice-block pull-right">
                                      <ul class="unstyled amounts">
                                          <li>
                                            <strong>Sub - Total amount :</strong>  <i class="icon-inr"></i> <?=$display_subtotal; ?>
                                          </li>                                                                            <li><strong>Other Charges :</strong></li>
                                          <?php
                                          foreach ($othercharges_array as $key => $value) {
                                            ?>
                                            <li><strong><?=$key; ?> :</strong> <i class="icon-inr"></i> <?=$value; ?></li>
                                            <?php
                                          }                                                                              ?>
                                          <?php
                                          foreach ($tax_array as $key => $value) {
                                            ?>
                                            <li><strong><?=$key; ?> :</strong> <i class="icon-inr"></i> <?=$value; ?></li>
                                            <?php
                                          }                                                                              ?>
                                          <li>
                                            <strong>Grand Total :</strong> <i class="icon-inr"></i> <?=$order_grand_total; ?>
                                          </li>
                                      </ul>
                                  </div>
                              </div>

                            </div>
                        </section>
                        <!-- End Item List -->                                        <section class="panel">
                            <header class="panel-heading">
                                <!-- <button class="btn btn-danger" type="submit">Save</button> -->
                                <a class="btn btn-info btn-lg" onclick="javascript:window.print();"><i class="icon-print"></i> Print </a>
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
