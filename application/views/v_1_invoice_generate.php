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
<style>
   .tax_style{
      margin-right:10px;
      margin-top:-3.5px !important;
      font-size:13px;

   }
</style>

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
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>sales/invoice_1_save">
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
                        $total_cones = 0;
                        $total_gr_wt = 0;
                        $total_net_wt = 0;
                        $items_array = array();
                        $boxes_array = array();
                        $pre_delivery_list = array();
                        $item_names_arr = array();
                        $gr_weights_arr = array();
                        $nt_weights_arr = array();
                        $box_qty_array = array();
                        $no_cones_arr = array();
                        $rates_arr = array();
                        $if_active_save = true;
                        $customer_alert = false;
                        foreach ($selected_dc as $dc_no) {
                           $deliveries = $this->m_masters->getmasterdetails('bud_yt_delivery', 'delivery_id', $dc_no);
                           foreach ($deliveries as $row) {
                              $dc_ckeckbox = false;
                              $dc_display = false;
                              $date_display = false;
                              $dc_no = $row['dc_no'];
                              $concern_name = $row['concern_name'];
                              $delivery_id = $row['delivery_id'];
                              $delivery_date = $row['delivery_date'];
                              $delivery_customer = $row['delivery_customer'];

                              if ($delivery_customer != $customer) {
                                 $customer_alert = true;
                              }

                              $delivery_boxes = explode(",", $row['delivery_boxes']);
                              $ed = explode("-", $delivery_date);
                              $delivery_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
                              foreach ($delivery_boxes as $box_no) {
                                 // $outerboxes = $this->m_delivery->getPreDelItemsDetails($box_no);
                                 $outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
                                 foreach ($outerboxes as $outerbox) {
                                    /*$inner_boxes = (array)json_decode($outerbox['inner_boxes']);
                                          print_r($inner_boxes);*/
                                    // print_r($outerbox);
                                    $packing_gr_weight = $outerbox['gross_weight'];
                                    $packing_net_weight = $outerbox['net_weight'];
                                    $inner_boxes = (array) json_decode($outerbox['inner_boxes']);
                                    $yarn_lot_no = $outerbox['lot_no'];
                                    if ($outerbox['box_prefix'] == 'TH' || $outerbox['box_prefix'] == 'TI') {
                                       $no_of_cones = $outerbox['no_of_cones'];
                                       $box_qty_array[$outerbox['box_id']] = $no_of_cones;
                                       $item_name = '';
                                       $item_id = '';
                                       $shade_no = '';
                                       if (count($inner_boxes) > 0) {
                                          foreach ($inner_boxes as $inner_box) {
                                             $item_id = $inner_box->item_id;
                                             $shade_no = $inner_box->shade_id;
                                             $item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $inner_box->item_id, 'item_name');
                                          }
                                       } else {
                                          $item_name = $outerbox['item_name'];
                                          $item_id = $outerbox['item_id'];
                                          $shade_no = $outerbox['shade_no'];
                                       }
                                    } else {
                                       $no_of_cones = $outerbox['no_of_cones'];
                                       $item_name = $outerbox['item_name'];
                                       $item_id = $outerbox['item_id'];
                                       $shade_no = $outerbox['shade_no'];
                                       $box_qty_array[$outerbox['box_id']] = $packing_net_weight;
                                    }

                                    $pre_delivery_list[$yarn_lot_no][$outerbox['box_id']] = $outerbox['box_prefix'] . $outerbox['box_no'];
                                    $item_names_arr[$outerbox['box_id']] = $item_name . '/' . $item_id;
                                    $gr_weights_arr[$outerbox['box_id']] = $packing_gr_weight;
                                    $nt_weights_arr[$outerbox['box_id']] = $packing_net_weight;
                                    $no_cones_arr[$outerbox['box_id']] = $no_of_cones;
                                    $total_cones += $no_of_cones;
                                    $total_gr_wt += $packing_gr_weight;
                                    $total_net_wt += $packing_net_weight;
                                    $invoice_items[] = $item_id;
                                    $boxes_array[] = $outerbox['box_id'];
                                    $rates = $this->m_admin->getitemrates_yt($customer, $item_id, $shade_no);
                                    if ($rates) {
                                       foreach ($rates as $rate) {
                                          $item_rates = explode(",", $rate['item_rates']);
                                          $item_rate_active = $rate['item_rate_active'];
                                       }
                                       $rates_arr[$outerbox['box_id']] = $item_rates[$item_rate_active];
                                       $item_rate = $item_rates[$item_rate_active];
                                    } else {
                                       $rates_arr[$outerbox['box_id']] = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item_id, 'direct_sales_rate');
                                       $item_rate = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item_id, 'direct_sales_rate');
                                    }
                                    if ($item_rate == '') {
                                       $if_active_save = false;
                                    }

                                    if ($outerbox['box_prefix'] == 'TH' || $outerbox['box_prefix'] == 'TI') {
                                       $sub_total += $no_of_cones * $item_rate;
                                    } else {
                                       $sub_total += $packing_net_weight * $item_rate;
                                    }
                                 }
                              }
                           }
                        }
                        $concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
                        foreach ($concern_details as $row) {
                           $concern_title = $row['concern_name'];
                           $concern_address = $row['concern_address'];
                           $concern_tin = $row['concern_tin'];
                           $concern_cst = $row['concern_cst'];
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
                                 <td colspan="6" rowspan="3">
                                    <strong><?= $concern_title; ?></strong><br />
                                    <?= $concern_address; ?><br>
                                    TIN: <?= $concern_tin; ?><br>
                                    CST: <?= $concern_cst; ?><br>
                                 </td>
                                 <td colspan="5">
                                    <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="1">Invoice No</td>
                                 <td colspan="4">
                                    <?php
                                    $canclled_invoices = $this->m_masters->getactivemaster('bud_yt_invoices', 'is_cancelled');
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
                                 <th>#</th>
                                 <th>Box No</th>
                                 <th>Item Name/Code</th>
                                 <th style="text-align:right;">Lot No</th>
                                 <th style="text-align:right;"># of Units</th>
                                 <th style="text-align:right;">Uom</th>
                                 <th style="text-align:right;">Gr. Weight</th>
                                 <th style="text-align:right;">Net Weight</th>
                                 <th style="text-align:right;">Lotwise Nt.Weight</th>
                                 <td align="right">Rate</td>
                                 <td align="right">Amount</td>
                              </tr>
                              <?php
                              $sno = 1;
                              $total_items = 0;
                              foreach ($pre_delivery_list as $key => $value) {
                                 $lotwise_nt_weight = 0;
                                 foreach ($value as $key_1 => $value_1) {
                                    $total_cones += $no_cones_arr[$key_1];
                                    $total_gr_wt += $gr_weights_arr[$key_1];
                                    $total_net_wt += $nt_weights_arr[$key_1];
                                    $lotwise_nt_weight += $nt_weights_arr[$key_1];
                                    $item_id = explode('/', $item_names_arr[$key_1]);

                                    if (!empty($item_id)) {
                                        $item_uom = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item_id[1], 'item_uom');
                                        $uom_name = $this->m_masters->get_uom('bud_uoms', $item_uom, 'uom_name');
                                        
                                        
                                    } else {
                                       $item_uom='';
                                       $uom_name='';
                                    }
                              ?>
                                    <tr>
                                       <td><?= $sno; ?></td>
                                       <td><?= $value_1; ?></td>
                                       <td><?= $item_names_arr[$key_1]; ?></td>
                                       <td align="right"><?= $key; ?></td>
                                       <td align="right"><?= $no_cones_arr[$key_1]; ?></td>
                                       <td align="right"><?= $uom_name; ?></td>
                                       <td align="right"><?= $gr_weights_arr[$key_1]; ?></td>
                                       <td align="right"><?= number_format($nt_weights_arr[$key_1],2,'.',''); ?></td>
                                       <td></td>
                                       <td>
                                          <?= $rates_arr[$key_1]; ?>
                                          <input type="hidden" name="item_rate[]" value="<?= $rates_arr[$key_1]; ?>">
                                       </td>
                                       <td>
                                          <?php echo number_format($box_qty_array[$key_1] * $rates_arr[$key_1], 2, '.', ''); ?>
                                       </td>
                                    </tr>
                                 <?php
                                    $sno++;
                                    $total_items++;
                                 }
                                 ?>
                                 <tr>
                                    <td colspan="7"></td>
                                    <td align="right"><?= $lotwise_nt_weight; ?></td>
                                    <td></td>
                                    <td></td>
                                 </tr>
                              <?php
                              }
                              ?>
                              <tr>
                                 <input type="hidden" name="sub_total" value="<?= round($sub_total); ?>">
                                 <input type="hidden" name="selected_dc" value="<?= implode(",", $selected_dc); ?>">
                                 <input type="hidden" name="customer" value="<?= $customer; ?>">
                                 <input type="hidden" name="concern_name" value="<?= $concern_name; ?>">
                                 <input type="hidden" name="invoice_items" value="<?= implode(",", $invoice_items); ?>">
                                 <input type="hidden" name="boxes_array" value="<?= implode(",", $boxes_array); ?>">
                                 <td colspan="11" align="right">
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
                                       <!--Inclusion of Remarks in invoices-->
                                       <li><strong>Remarks :</strong></li>
                                       <textarea name="remarks" style="width:300px;" maxlength="100" placeholder="Enter Remarks here">remarks</textarea>
                                       <!--end of Inclusion of Remarks in invoices-->
                                       <div>
                                       <li>
                                          <strong><span style="font-size:15px;">Tax :</span></strong>
                                          <?php

                                          $cust_gst = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_gst');
                                          //echo $cust_gst;
                                          $checked = false;
                                          if (substr($cust_gst, 0, 2) == 33 || substr($cust_gst, 0, 2) == 'AW') {
                                             $checked = true;
                                          }
                                       

                                          $taxs = $this->m_masters->getactivemaster('bud_tax', 'tax_status');
                                          foreach ($taxs as $tax) {
                                             
                                             $taxClick = '';
                                             if ($tax['tax_name'] == 'IGST(Other State)' && $checked == false) {
                                                $taxClick = ' checked="true" ';
                                             }
                                             if ($tax['tax_name'] == 'CGST' && $tax['tax_value'] == '6.00' && $checked == true) {
                                                $taxClick = ' checked="true" ';
                                             }
                                             if ($tax['tax_name'] == 'SGST' && $tax['tax_value'] == '6.00' && $checked == true) {
                                                $taxClick = ' checked="true" ';
                                             }
                                          ?>
                                             <input type="hidden" name="order_tax_names[<?= $tax['tax_id']; ?>]" value="<?= $tax['tax_name']; ?>">
                                             <label class="checkbox-inline tax_style">
                                                <input type="checkbox" name="taxs[<?= $tax['tax_id']; ?>]" value="<?= $tax['tax_value']; ?>" <?= $taxClick; ?>>
                                                <?= $tax['tax_name']; ?> (<?= $tax['tax_value']; ?> %)
                                             </label>
                                          <?php
                                          }
                                          ?>
                                       </li>
                                       </div>
                                    </ul>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
         </section>
         </div>
         <?php
         if ($if_active_save) {
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
         }
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

      <?php if ($customer_alert) { ?>
         var customer_alert = confirm('WARNING : Dear User, Your DC customer is diffrent from Invoice Customer!, Do you still want to continue ?...');
         if(customer_alert == false){
            window.history.back();
         }
      <?php } ?>

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