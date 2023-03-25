<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Legrand charles">
      <meta name="keyword" content="">
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
    
     
      <style type="text/css">
      @media print{
         @page{
            margin: 2.5mm;
         }
         .packing-register th
         {
            border: 1px solid #000 !important;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
         }
         .packing-register td
         {
            border: 1px solid #000!important;
         }
         .dataTables_filter
         {
            display: none;
         }
         .screen_only
         {
            display: none;
         }
      }
      </style>     
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
               <div class="row screen-only">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-file"></i>  Customer Sales Register</h3>
                        </header>
                     </section>
                  </div>
               </div>

               <?php
               $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
               $items = $this->m_masters->getactivemaster('bud_items', 'item_status');
               $cust_name = null;                      $item_id = null;                      ?>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/cust_sales_register_3">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Customer Sales Register
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="from_date">From</label>
                                 <input type="text" value="<?=$f_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="to_date">To</label>
                                 <input type="text" value="<?=$t_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
                              </div>                                                    <div class="form-group col-lg-3">
                                 <label for="customer_name">Customer Name</label>
                                 <select class="get_item_detail form-control select2" id="customer_name" name="customer_name">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                      ?>
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer)?'selected="selected"':''; ?>><?=$row['cust_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="customer_id">Customer Code</label>
                                 <select class="get_item_detail form-control select2" id="customer_id" name="customer_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                      ?>
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer)?'selected="selected"':''; ?>><?=$row['cust_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                <label>&nbsp;</label>
                                <button class="btn btn-danger" type="submit" name="search">Search</button>
                              </div>                                                </div>
                        </section>
                     </div> 
                  </div>
                </form>

               <?php
               /*echo "<pre>";
               print_r($cust_pack_register);
               echo "</pre>";*/
               ?>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>                         <div class="panel-body">
                        <h3 class="visible-print">Customer Sales Register (Labels)</h3>
                        <div class="col-sm-6">
                           <strong>From Date : <?=$f_date; ?>  To Date: <?=$t_date; ?></strong>
                        </div>
                        <div class="col-md-6 text-right">
                           <strong>Print Date : <?=date("d-m-Y H:i:s"); ?></strong>
                        </div>
                        <?php
                        $gr_amount = 0;
                        foreach ($cust_pack_register as $customer_id => $outerboxes) {
                           $customer = $this->m_reports->get_customer($customer_id);
                           ?>
                           <div class="col-sm-6">
                              Customer Code : <strong><?php echo $customer['cust_id']; ?></strong><br/>                                                 Customer Name : <strong><?php echo $customer['cust_name']; ?></strong>                                              </div>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                            <thead>                                                    <tr>
                                 <th>#</th>
                                 <th>Invoice No</th>
                                 <th>DC NO</th>
                                 <th>Invoice Date</th>
                                 <th>Total Qty</th>
                                 <th>Amount</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              $sno = 1;
                              $total_net_weight = 0;
                              $total_gr_weight = 0;                                                    $no_of_boxes = 0;
                              $total_amount = 0;
                              foreach ($outerboxes as $key => $row) {
                              	$dc_nos = array();
                              	$selected_dc = explode(",", $row->selected_dc);
                              	if(count($selected_dc)>0)
                              	{
                              	foreach($selected_dc as $dc_no)
                              	{
                              		$delivery = $this->m_delivery->get_lbl_delivery($dc_no);
                              		if($delivery)
                              		{
                              		$dc_nos[$dc_no] = $delivery->dc_no;
                              		}
                              	}
                              	}
                                 $total_qty =$this->m_production->boxDeliveredQty(null,null,null,null,null,$row->invoice_id);//partial delivery qty;
                                 $net_amount = number_format($row->net_amount, 2, '.', '');
                                 $total_amount += $net_amount;
                                 $gr_amount += $net_amount;
                                 ?>
                                 <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row->invoice_no; ?></td>
                                    <td><?php echo implode(",", $dc_nos); ?></td>
                                    <td><?=$row->invoice_date; ?></td>
                                    <td><?=number_format($total_qty, 3, '.', ''); ?></td>
                                    <td class="text-right"><?=$net_amount; ?></td>
                                 </tr>
                                 <?php                                                          $sno++;
                              }
                              ?>
                              <tfoot>
                                 <tr>
                                    <td colspan="5" class="text-right">Total</td>
                                    <td class="text-right"><?=number_format($total_amount, 2, '.', ''); ?></td>
                                 </tr>
                              </tfoot>
                              </tbody>
                           </table>
                           <hr>
                           <?php
                        }
                        ?>
                        <table class="table table-bordered">
                           <tr>
                              <td align="right"><strong>Grand Total</strong></td>
                              <td align="right"><strong><?php echo number_format($gr_amount, 2, '.', ''); ?></strong></td>
                           </tr>
                        </table>
                        <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
                     </div>
                  </section>
                  <!-- End Talbe List  -->
               </div>
            </div>
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

      $('.datatable').dataTable({
            "sDom": "<'row'<'col-sm-6'f>r>",
            // "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "bSort": false,
            "bPaginate": false,
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });
      jQuery('#example_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('#example_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

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

      $(".get_item_detail").change(function(){
        $("#customer_name").select2("val", $(this).val());
        $("#customer_id").select2("val", $(this).val());       return false;
      });
      $(".item").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());
      });
      </script>
   </body>
</html>
