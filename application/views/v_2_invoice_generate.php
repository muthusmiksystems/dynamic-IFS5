<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="Mosaddek">
   <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
   <link rel="shortcut icon" href="img/favicon.html">

   <title><?= $page_title; ?> | INDOFILA SYNTHETICS</title>

   <!-- Bootstrap core CSS -->
   <?php
   foreach ($css as $path) {
   ?>
      <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
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
                        <h3><i class=" icon-file-text"></i> Invoice Preview</h3>
                     </header>
                  </section>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <?php
                  if ($this->session->flashdata('warning')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-warning fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  if ($this->session->flashdata('error')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-block alert-danger fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  if ($this->session->flashdata('success')) {
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
                              <p><?= $this->session->flashdata('success'); ?></p>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  ?>
               </div>
            </div>
            <?php
            $uoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
            ?>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>sales/invoice_2_save">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Invoice
                        </header>
                     </section>
                     <div class="panel-body">
                        <?php
                        $sub_total = 0;
                        $items_array = array();
                        $boxes_array = array();
                        foreach ($selected_dc as $dc_no) {
                           $deliveries = $this->m_masters->getmasterdetails('bud_te_delivery', 'delivery_id', $dc_no);
                           foreach ($deliveries as $row) {
                              $dc_ckeckbox = false;
                              $dc_display = false;
                              $date_display = false;
                              $dc_no = $row['dc_no'];
                              $concern_name = $row['concern_name'];
                              $delivery_id = $row['delivery_id'];
                              $delivery_date = $row['delivery_date'];
                              $delivery_customer = $row['delivery_customer'];
                              $delivery_boxes = explode(",", $row['delivery_boxes']);
                              $ed = explode("-", $delivery_date);
                              $delivery_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
                              foreach ($delivery_boxes as $box_no) {
                                 // $box_details = $this->m_masters->getmasterdetails('bud_te_outerboxes','box_no', $box_no);
                                 $box_details = $this->m_delivery->get_tap_delivery_items(array($box_no));
                                 foreach ($box_details as $outerbox) {
                                    $inner_boxes = explode(",", $outerbox->packing_innerboxes);
                                    $packing_innerbox_items = $outerbox->packing_innerbox_items;
                                    $items_array[] = $packing_innerbox_items;
                                    $boxes_array[] = $outerbox->box_no;
                                 }
                              }
                           }
                        }
                        $concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
                        foreach ($concern_details as $row) {
                           $concern_title = $row['concern_name'];
                           $concern_address = $row['concern_address'];
                           $concern_tin = $row['concern_tin'];
                           $concern_gst = $row['concern_gst'];
                        }
                        ?>
                        <table class="table table-bordered table-striped table-condensed">
                           <thead>
                              <!-- <tr>
                                       <th>Sno</th>
                                       <th>Item Name</th>
                                       <th>Item Code</th>
                                       <th>Color Combo</th>                                                                      <th>Weight</th>                                                                      <th>UOM</th>                                                                      <th>Rate</th>                                                                      <th>Amount</th>                                                                   </tr> -->
                           </thead>
                           <tbody>
                              <tr>
                                 <td colspan="3" rowspan="3">
                                    <strong><?= $concern_title; ?></strong><br />
                                    <?= $concern_address; ?><br>

                                    GST: <?= $concern_gst; ?><br>
                                 </td>
                                 <td colspan="5">
                                    <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="1">Invoice No</td>
                                 <td colspan="4">
                                    <?php
                                    $canclled_invoices = $this->m_masters->getactivemaster('bud_te_invoices', 'is_cancelled');
                                    ?>
                                    <select name="invoice_no">
                                       <option value="new">New</option>
                                       <?php
                                       foreach ($canclled_invoices as $row) {
                                       ?>
                                          <option value="<?= $row['invoice_no']; ?>"><?= $row['invoice_no']; ?></option>
                                       <?php
                                       }
                                       ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="1">Date</td>
                                 <td colspan="4"></td>
                              </tr>
                              <tr>
                                 <td>Sno</td>
                                 <td>Item Name</td>
                                 <td># of Box</td>
                                 <td>Color Combo</td>
                                 <td align="right">Qty</td>
                                 <td>UOM</td>
                                 <td align="right">Rate</td>
                                 <td align="right">Amount</td>
                              </tr>
                              <?php
                              $sno = 1;
                              asort($items_array);
                              $item_uom_array = array();
                              $item_weight_array = array();
                              $item_net_weights = array();
                              $if_kgs = false;
                              foreach ($items_array as $key => $item) {
                                 // $box_details = $this->m_masters->getmasterdetails('bud_te_outerboxes','box_no', $boxes_array[$key]);
                                 $box_details = $this->m_delivery->get_tap_delivery_items(array($boxes_array[$key]));
                                 /*echo "<pre>";
                                       print_r($box_details);
                                       echo "</pre>";*/
                                 foreach ($box_details as $outerbox) {
                                    $inner_boxes = explode(",", $outerbox->packing_innerboxes);
                                    $total_meters = 0;
                                    $total_net_weight = 0;
                                    $packing_net_weight = $outerbox->packing_net_weight;
                                    $total_meters = round($outerbox->total_meters);
                                    $packing_type = $outerbox->packing_type;
                                    if ($packing_type == 'kgs') {
                                       // $if_kgs = true;
                                       $item_weight_array[$item][] = $packing_net_weight;
                                       $item_uom_array[$item] = 'Kgs';
                                    } else {
                                       if ($outerbox->uom_name == '') {
                                          $item_uom_array[$item] = 'MTRS';
                                       } else {
                                          $item_uom_array[$item] = $outerbox->uom_name;
                                       }

                                       $item_weight_array[$item][] = $total_meters;
                                    }
                                 }
                              }

                              $invoice_items = array();
                              $invoice_item_weight = array();
                              $invoice_item_rate = array();
                              /*echo '<pre>';
                                    print_r($item_weight_array);
                                    // print_r($item_net_weights);
                                    echo '</pre>';*/
                              $qty_meters = 0;
                              $if_active_save = true;
                              foreach ($item_weight_array as $key => $value) {
                                 $qty_meters = array_sum($value);
                                 $item_rate = 0;
                                 $invoice_items[] = $key;
                                 $invoice_item_weight[] = array_sum($value);
                                 $item_name = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $key, 'item_name');
                                 $rates = $this->m_admin->getitemrates($customer, $key);

                                 if ($rates) {
                                    foreach ($rates as $rate) {
                                       $item_rates = explode(",", $rate['item_rates']);
                                       $item_rate_active = $rate['item_rate_active'];
                                    }
                                    $invoice_item_rate[] = $item_rates[$item_rate_active];
                                    $item_rate = $item_rates[$item_rate_active];
                                 } else {
                                    $invoice_item_rate[] = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $key, 'direct_sales_rate');
                                    $item_rate = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $key, 'direct_sales_rate');
                                 }
                                 if ($item_rate == '') {
                                    $if_active_save = false;
                                 }
                              ?>
                                 <tr>
                                    <td><?= $sno; ?></td>
                                    <td>
                                       Art No: <strong><?= $key; ?></strong> -- <?= $item_name; ?>
                                    </td>
                                    <td><?= sizeof($value); ?></td>
                                    <td></td>
                                    <td align="right">
                                       <?= array_sum($value); ?>
                                       <input type="hidden" name="item_weights[<?= $key; ?>]" value="<?= array_sum($value); ?>">
                                       <input type="hidden" name="no_of_boxes[]" value="<?= sizeof($value); ?>">
                                    </td>
                                    <td>
                                       <!-- <select name="item_uoms[]">
                                                <option value="">Select Uom</option>
                                                <?php
                                                foreach ($uoms as $uom) {
                                                ?>
                                                   <option value="<?= $uom['uom_name']; ?>"><?= $uom['uom_name']; ?></option>
                                                   <?php
                                                }
                                                   ?>
                                             </select> -->
                                       <?= $item_uom_array[$key]; ?>
                                       <input type="hidden" name="item_uoms[]" value="<?= $item_uom_array[$key]; ?>">
                                    </td>
                                    <td align="right">
                                       <?= $item_rate; ?>
                                       <input type="hidden" name="item_rate[]" value="<?= $item_rate; ?>">
                                    </td>
                                    <td align="right"><?= ($qty_meters * $item_rate); ?></td>
                                 </tr>
                              <?php
                                 $sno++;
                                 $sub_total += $qty_meters * $item_rate;
                              }
                              ?>
                              <tr>
                                 <input type="hidden" name="sub_total" value="<?= round($sub_total); ?>">
                                 <input type="hidden" name="selected_dc" value="<?= implode(",", $selected_dc); ?>">
                                 <input type="hidden" name="customer" value="<?= $customer; ?>">
                                 <input type="hidden" name="concern_name" value="<?= $concern_name; ?>">
                                 <input type="hidden" name="invoice_items" value="<?= implode(",", $invoice_items); ?>">
                                 <input type="hidden" name="boxes_array" value="<?= implode(",", $boxes_array); ?>">
                                 <td colspan="8" align="right">
                                    <ul class="unstyled amounts">
                                       <li><strong>Other Charges :</strong></li>
                                       <?php
                                       $othercharges = $this->m_masters->getactivemaster('bud_othercharges', 'othercharge_status');
                                       foreach ($othercharges as $othercharge) {
                                       ?>
                                          <li>
                                             <strong><?= $othercharge['othercharge_name']; ?> :</strong>
                                             <input name="order_othercharges[<?= $othercharge['othercharge_id']; ?>]" style="width:150px;" type="text">
                                             <input name="order_othercharges_type[<?= $othercharge['othercharge_id']; ?>]" type="hidden" value="<?= $othercharge['othercharge_type']; ?>">
                                             <input name="order_othercharges_names[<?= $othercharge['othercharge_id']; ?>]" type="hidden" value="<?= $othercharge['othercharge_name']; ?>">
                                             <select name="order_othercharges_unit[<?= $othercharge['othercharge_id']; ?>]">
                                                <option value="%">%</option>
                                                <option value="Rs">Rs</option>
                                             </select>
                                             <input name="order_othercharges_desc[<?= $othercharge['othercharge_id']; ?>]" type="text" placeholder="Description">
                                          </li>
                                       <?php
                                       }
                                       ?>
                                       <li>
                                          <strong>Tax :</strong>
                                          <?php
                                          $taxs = $this->m_masters->getactivemaster('bud_tax', 'tax_status');
                                          foreach ($taxs as $tax) {
                                          ?>
                                             <input type="hidden" name="order_tax_names[<?= $tax['tax_id']; ?>]" value="<?= $tax['tax_name']; ?>">
                                             <label class="checkbox-inline">
                                                <input type="checkbox" name="taxs[<?= $tax['tax_id']; ?>]" value="<?= $tax['tax_value']; ?>">
                                                <?= $tax['tax_name']; ?> (<?= $tax['tax_value']; ?> %)
                                             </label>
                                          <?php
                                          }
                                          ?>
                                       </li>
                                       <!-- Transport Details -->
                                       <li>
                                          <strong>Transport Name:</strong>
                                          <input type="text" name="transport_name" style="width:30%;">
                                       </li>
                                       <li>
                                          <strong>LR NO:</strong>
                                          <input type="text" name="lr_no">
                                       </li>
                                       <!--ER-08-18#-32-->
                                       <li><strong>Remarks :</strong>
                                          <textarea name="remarks" style="width:300px;" maxlength="100" placeholder="Enter Remarks here"></textarea>
                                       </li>
                                       <!--end of ER-08-18#-32-->
                                    </ul>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
         </section>
         </div>
         <?php
         //if($if_active_save)
         //{
         ?>
         <div class="col-lg-12">
            <section class="panel">
               <header class="panel-heading">
                  <button class="btn btn-danger" type="submit" name="save">Save Invoice</button>
                  <button class="btn btn-danger" type="submit" name="proforma" style="float:right;">Proforma Invoice</button>
                  <button class="btn btn-default" type="button">Cancel</button>
               </header>
            </section>
         </div>
         <?php
         // }
         ?>
         </div>
         </form>
         <?php
         ?>
         <div class="pageloader"></div>
         <!-- page end-->
      </section>
   </section>
   <!--main content end-->
   </section>

   <!-- js placed at the end of the document so the pages load faster -->
   <?php
   foreach ($js as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <!--common script for all pages-->
   <?php
   foreach ($js_common as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <!--script for this page-->
   <?php
   foreach ($js_thispage as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <script>
      //owl carousel
      $(document).ready(function() {
         $("#owl-demo").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true

         });
      });

      //custom select box
      $(function() {
         $('select.styled').customSelect();
      });

      $(document).ajaxStart(function() {
         $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
         $('.pageloader').hide();
      });
   </script>
</body>

</html>