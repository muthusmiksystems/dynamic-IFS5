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
                           <h3><i class=" icon-file-text"></i> Invoice Preview</h3>
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
                  }                                            if($this->session->flashdata('error'))
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
               <?php
               $uoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
               ?>
               <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>sales/cash_invoice_2_save">
                  <div class="row">                                  <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Invoice
                            </header>
                            <div class="panel-body">
                               <table class="table table-bordered table-striped table-condensed">                                                          <tbody>
                                    <tr>
                                       <td colspan="3" rowspan="3">
                                          <strong>FROM:</strong><br/>
                                          <strong style="font-size:14px;">SHIVA TAPES</strong><br/>
                                          18-A, ASHER NAGAR,<br/>
                                          3rd STREET, GANDHI NAGAR.<br/>
                                       </td>
                                       <td colspan="5">
                                          <strong>TO:</strong><br/>
                                          <strong style="font-size:14px;"><?=$cust_name; ?></strong><br/>
                                          Mobile No : <?=$cust_mobile_no; ?>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="1">Invoice No</td>
                                       <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                       <td colspan="1">Date</td>
                                       <td colspan="4"><?=date("d-m-Y"); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Sno</td>
                                       <td>Art No</td>                                                                      <td>Item Name</td>
                                       <td>Box No</td>
                                       <td align="right">Qty.</td>                                                                      <td>UOM</td>                                                                      <td align="right">Rate</td>                                                                      <td align="right">Amount</td>                                                                   </tr>
                                    <?php
                                    $sno = 1;
                                    $sub_total = 0;
                                    $invoice_items = array();
                                    foreach ($selected_boxes as $box_no) {
                                       $box_details = $this->m_masters->getmasterdetails('bud_te_outerboxes','box_no', $box_no);
                                       foreach ($box_details as $outerbox) {
                                          $inner_boxes = explode(",", $outerbox['packing_innerboxes']);
                                          $packing_innerbox_items = $outerbox['packing_innerbox_items'];
                                          $total_meters = 0;
                                          $total_net_weight = 0;
                                          foreach ($inner_boxes as $i_box_no) {
                                             $i_box_details = $this->m_masters->getmasterdetails('bud_te_innerboxes','box_no', $i_box_no);
                                             foreach ($i_box_details as $inner_box) {
                                                $total_meters += $inner_box['packing_tot_mtr'];
                                                $total_net_weight += $inner_box['packing_net_weight'];
                                             }
                                          }
                                       }
                                       $invoice_items[] = $packing_innerbox_items;
                                       $item_name = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_innerbox_items, 'item_name');
                                       $item_rate = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_innerbox_items, 'direct_sales_rate');
                                       ?>
                                       <tr>
                                          <td><?=$sno; ?></td>
                                          <td><?=$packing_innerbox_items; ?></td>
                                          <td><?=$item_name; ?></td>
                                          <td>M-<?=$box_no; ?></td>
                                          <td align="right">
                                             <?=$total_net_weight; ?>
                                             <input type="hidden" name="item_weights[]" value="<?=$total_net_weight; ?>">
                                          </td>
                                          <td>
                                             <select name="item_uoms[]">
                                                <option value="">Select Uom</option>
                                                <?php
                                                foreach ($uoms as $uom) {
                                                   ?>
                                                   <option value="<?=$uom['uom_name']; ?>"><?=$uom['uom_name']; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                          </td>
                                          <td align="right">
                                             <?=$item_rate; ?>
                                             <input type="hidden" name="item_rate[]" value="<?=$item_rate; ?>">
                                          </td>
                                          <td align="right"><?=number_format(($total_net_weight * $item_rate), 2, '.', ''); ?></td>
                                       </tr>
                                       <?php
                                       $sno++;
                                       $sub_total += $total_net_weight * $item_rate;
                                    }
                                    ?>
                                    <tr>
                                       <input type="hidden" name="sub_total" value="<?=round($sub_total); ?>">
                                       <input type="hidden" name="customer" value="<?=$customer; ?>">
                                       <input type="hidden" name="cust_name" value="<?=$cust_name; ?>">
                                       <input type="hidden" name="customer_mobile" value="<?=$cust_mobile_no; ?>">
                                       <input type="hidden" name="customer_email" value="<?=$customer_email; ?>">
                                       <input type="hidden" name="invoice_items" value="<?=implode(",", $invoice_items); ?>">
                                       <input type="hidden" name="boxes_array" value="<?=implode(",", $selected_boxes); ?>">
                                       <td colspan="8" align="right">
                                          <ul class="unstyled amounts">
                                             <li><strong>Other Charges :</strong></li>
                                             <?php
                                               $othercharges = $this->m_masters->getactivemaster('bud_othercharges','othercharge_status');
                                               foreach ($othercharges as $othercharge) {
                                                 ?>
                                                 <li>
                                                 <strong><?=$othercharge['othercharge_name']; ?> :</strong>                                                                                     <input name="othercharges[<?=$othercharge['othercharge_id']; ?>]" style="width:150px;" type="text">
                                                 <input name="othercharges_type[<?=$othercharge['othercharge_id']; ?>]" type="hidden" value="<?=$othercharge['othercharge_type']; ?>">
                                                 <input name="othercharges_names[<?=$othercharge['othercharge_id']; ?>]" type="hidden" value="<?=$othercharge['othercharge_name']; ?>">
                                                 <select name="othercharges_unit[<?=$othercharge['othercharge_id']; ?>]">
                                                   <option value="%">%</option>
                                                   <option value="Rs">Rs</option>
                                                 </select>
                                                 </li>
                                                 <?php
                                               }
                                               ?>
                                             <li>
                                                <strong>Tax :</strong>
                                                <?php
                                                $taxs = $this->m_masters->getactivemaster('bud_tax','tax_status');
                                                foreach ($taxs as $tax) {
                                                ?>
                                                <input type="hidden" name="tax_names[<?=$tax['tax_id']; ?>]" value="<?=$tax['tax_name']; ?>">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" name="taxs[<?=$tax['tax_id']; ?>]" value="<?=$tax['tax_value']; ?>">
                                                <?=$tax['tax_name']; ?>
                                                </label>
                                                <?php
                                                }
                                                ?>
                                             </li>
                                         </ul>
                                       </td>
                                    </tr>
                                 </tbody>
                               </table>
                            </div>
                        </section>
                     </div>                                 <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" name="save">Save Invoice</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                     </div>
                  </div>
               </form>
               <?php
               ?>
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

      </script>
   </body>
</html>
