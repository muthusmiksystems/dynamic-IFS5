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
               <!-- page start-->
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-truck"></i> Pre Delivery</h3>
                        </header>
                     </section>
                  </div>
               </div>                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="">
                  <?php
                  foreach ($delivery_details as $row) {
                    $delivery_boxes = explode(",", $row['p_delivery_boxes']);
                    $delivery_customer = $row['p_delivery_cust'];
                    $concern_name = $row['concern_name'];
                    $delivery_date = $row['p_delivery_date'];
                    $delivery_id = $row['p_delivery_id'];
                    $concern_id = $row['concern_name'];
                  }

                  /*$ed = explode("-", $delivery_date);
                  $delivery_date = $ed[2].'-'.$ed[1].'-'.$ed[0];*/
                            $InvoiceItems = $this->m_production->labelInvoiceItems($delivery_boxes);
                  /*echo "<pre>";
                  print_r($InvoiceItems);
                  echo "</pre>";*/
                  $item_sizes_array = array();
                  $item_id_array = array();
                  $item_names_array = array();
                  $item_boxes_array = array();
                  $item_uom_array = array();
                  $item_gr_wt_array = array();
                  foreach ($InvoiceItems as $item) {
                    $item_id = $item['item_id'];
                    $item_size = $item['item_size'];
                    $total_qty = $item['total_qty'];
                    $item_name = $item['item_name'];
                    $box_no = $item['box_no'];
                    $packing_uom = $item['packing_uom'];
                    $packing_gr_weight = $item['packing_gr_weight'];
                    $item_sizes_array[$box_no][$item_size][] = $total_qty;
                    $item_names_array[$box_no] = $item_name;
                    $item_id_array[$box_no] = $item_id;
                    $item_boxes_array[$box_no][] = $box_no;
                    $item_gr_wt_array[$box_no] = $packing_gr_weight;
                    $item_uom_array[$item_size] = $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $packing_uom, 'uom_name');
                  }

                  $concern_name = '';
                  $concern = $this->m_masters->get_concern($concern_id);
                  $customer = $this->m_masters->get_customer($delivery_customer);
                  ?>
                  <input type="hidden" name="delivery_id" value="<?=$delivery_id; ?>">
                  <div class="row invoice-list">
                     <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body">
                               <table class="table table-bordered border-top">
                               <thead>
                                  <tr>
                                    <th colspan="7">
                                      <h3 style="margin:0px;" class="text-center">STOCK CHECK LIST(Goods not allowed to go out with this document.)</h3>
                                    </th>
                                  </tr>
                                  <!-- <tr>
                                    <th colspan="4">
                                      <strong>FROM:</strong><br/>
                                      <?php if($concern): ?>
                                        <?php
                                        $concern_name = $concern->concern_name;
                                        ?>
                                        <strong style="text-transform:uppercase;font-size:14px;"><?php echo $concern->concern_name; ?></strong><br/>
                                        <?php echo $concern->concern_address; ?><br>
                                        TIN: <?php echo $concern->concern_tin; ?><br>
                                        CST: <?php echo $concern->concern_cst; ?><br>
                                      <?php endif; ?>
                                    </th>
                                    <th colspan="3">
                                      <strong>TO:</strong><br/>
                                      <?php if($customer): ?>
                                        <strong style="text-transform:uppercase;font-size:14px;"><?php echo $customer->cust_name; ?></strong><br/>
                                        <?php echo $customer->cust_address; ?><br>
                                        TIN: <?php echo $customer->cust_tinno; ?>
                                      <?php endif; ?>
                                    </th>
                                  </tr> -->
                                  <tr>
                                    <th colspan="4">
                                      <strong style="font-size:18px;">Pre Delivery No: <?php echo $delivery_id;?></strong>
                                    </th>
                                    <th colspan="3" class="text-right">
                                      Date: <?php echo date("d-m-Y", strtotime($delivery_date)); ?>
                                    </th>
                                  </tr>
                                  <tr>
                                     <th>#</th>
                                     <th>Item Code</th>
                                     <th>Item</th>
                                     <th style="text-align:right;">Box No</th>
                                     <th>Size/Qty</th>
                                     <th style="text-align:right;">Gr.Weight</th>
                                     <th style="text-align:right;">Total Qty</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  <?php
                                  $sno = 1;
                                  $total_items = 0;
                                  $total_gr_wt = 0;
                                  $total_net_qty = 0;
                                  foreach ($item_sizes_array as $key => $sizes) {
                                    $total_item_qty = 0;
                                    $total_gr_wt += $item_gr_wt_array[$key];
                                    // foreach ($sizes as $size_key => $value) {
                                    ?>
                                    <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$item_id_array[$key]; ?></td>                                                                  <td><?=$item_names_array[$key]; ?></td>
                                    <td style="text-align:right;"><?=$key; ?></td>
                                    <td style="text-align:left;">
                                      <?php
                                      foreach ($sizes as $size_key => $value) {
                                        $total_item_qty += array_sum($value);
                                        echo $size_key.'='.array_sum($value).',';
                                      }
                                      $total_net_qty += $total_item_qty;
                                      ?>
                                    </td>
                                    <td style="text-align:right;"><?=$item_gr_wt_array[$key]; ?></td>
                                    <td style="text-align:right;"><?=$total_item_qty; ?></td>
                                    </tr>
                                    <?php
                                    $sno++;
                                    $total_items++;
                                    // }
                                  }
                                  ?>
                                  <tr>
                                    <td colspan="3" align="center"><strong style="font-size:14px;">Total</strong></td>
                                    <td align="right"><strong style="font-size:14px;"><?=$total_items; ?> Boxes</strong></td>
                                    <td></td>
                                    <td align="right"><strong style="font-size:14px;"><?=$total_gr_wt; ?></strong></td>
                                    <td align="right"><strong style="font-size:14px;"><?=$total_net_qty; ?></strong></td>
                                  </tr>
                               </tbody>
                               <tfoot>
                                  <tr>
                                    <th colspan="4">
                                      <strong>FROM:</strong>&emsp;
                                      <?php if($concern): ?>
                                        <?php
                                        $concern_name = $concern->concern_name;
                                        ?>
                                        <strong style="text-transform:uppercase;font-size:14px;"><?php echo $concern->concern_name; ?></strong><br/>
                                      <?php endif; ?>
                                    </th>
                                    <th colspan="3">
                                      <strong>TO:</strong>&emsp;
                                      <?php if($customer): ?>
                                        <strong style="text-transform:uppercase;font-size:14px;"><?php echo $customer->cust_name; ?></strong><br/>
                                      <?php endif; ?>
                                    </th>
                                  </tr>
                                 <tr>
                                   <td colspan="8">
                                     <div class="col-lg-12">
                                       <div class="print-div col-lg-3">
                                          <strong>Received By</strong>
                                          <br/>
                                          <br/>
                                       </div>
                                       <div class="print-div col-lg-3" style="border-right:none;">
                                          <strong>Prepared By</strong>
                                          <br/>
                                          <br/>
                                          <br/>
                                          <br/>
                                          <?=$this->m_masters->getmasterIDvalue('bud_users', 'ID', $this->session->userdata('user_id'), 'user_login'); ?>
                                       </div>
                                       <div class="print-div col-lg-3" style="border-right:none;">
                                          <strong>Checked By</strong>
                                          <br/>
                                          <br/>
                                       </div>
                                       <div class="print-div right-align col-lg-3">
                                          <strong>For <?php echo $concern_name; ?>.</strong>
                                          <br/>
                                          <br/>
                                          <br/>
                                          <br/>
                                          Auth.Signatury
                                       </div>
                                    </div>
                                   </td>
                                 </tr>
                               </tfoot>
                               </table>
                            </div>
                        </section>
                     </div>

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="button" onclick="window.print()">Print</button>
                            </header>
                        </section>
                     </div>
                  </div>
                  </form>
               <div class="pageloader"></div>                          <!-- page end-->
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
    $(".delete").live('click', function(event) {
        $(this).parent().parent().remove();
        return false;
      });

      </script>
   </body>
</html>
