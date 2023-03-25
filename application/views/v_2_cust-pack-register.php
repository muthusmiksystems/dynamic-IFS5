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
         @page
         {
            margin: 5mm;
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
         .dataTables_filter, .dataTables_info, .dataTables_paginate, .dataTables_length
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
                           <h3><i class=" icon-file"></i>  Customer &amp; Item Packing Register</h3>
                        </header>
                     </section>
                  </div>
               </div>
               <div class="row screen-only">
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
               $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
               $items = $this->m_masters->getactivemaster('bud_te_items', 'item_status');                      ?>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/custPackRegister">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Customer &amp; Item Packing Register
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
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer_name)?'selected="selected"':''; ?>><?=$row['cust_name']; ?></option>
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
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer_name)?'selected="selected"':''; ?>><?=$row['cust_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_id">Item Name</label>
                                 <select class="form-control select2 item" id="item_id" name="item_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                      ?>
                                      <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_id">Item Code</label>
                                 <select class="form-control select2 item" id="item_name">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                      ?>
                                      <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id']; ?></option>
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
               $gr_total_boxes = 0;
               $gr_gross_weight = 0;
               $gr_net_weight = 0;
               $gr_total_meters = 0;
               foreach ($cust_pack_register as $customer_id => $outerboxes) {
                  foreach ($outerboxes as $row) {
                     $gr_gross_weight += $row->packing_gr_weight;
                     $gr_net_weight += $row->packing_net_weight;
                     $gr_total_meters += $row->total_meters;
                     $gr_total_boxes++;
                  }
               }
               ?>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>					
                    <div class="panel-body">                                        <h3 class="visible-print">Customer &amp; Item Packing Register (Tapes &amp; Elastic)</h3>
                        <div class="col-sm-6">
                           <strong>From Date : <?=$f_date; ?>  To Date: <?=$t_date; ?></strong>
                        </div>
                        <div class="col-md-6 text-right">
                           <strong>Print Date : <?=date("d-m-Y H:i:s"); ?></strong>
                        </div>
                        <?php
                        $i = 0;
                        foreach ($cust_pack_register as $customer_id => $outerboxes) {
                           $total_boxes = 0;
                           $net_gr_weight = 0;
                           $net_weight = 0;
                           $net_meters = 0;

                           $customer = $this->m_reports->get_customer($customer_id);
                           if($customer)
                           {
                              ?>
                              <div class="col-sm-6">
                                 Customer Code : <strong><?php echo $customer['cust_id']; ?></strong><br/>                                                    Customer Name : <strong><?php echo $customer['cust_name']; ?></strong>                                                 </div>
                              <?php
                           }
                           else
                           {
                              ?>
                              <div class="col-sm-6">
                                 Customer : <strong>General Customer</strong><br/>                                                 </div>
                              <?php
                           }
                           ?>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                            <thead>
                              <?php
                              if(++$i == 1)
                              {
                                 ?>
                                 <tr>
                                    <td></td>
                                    <td><strong><?php echo $gr_total_boxes; ?> Box(s)</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong><?php echo number_format($gr_gross_weight, 3, '.', ''); ?></strong></td>
                                    <td><strong><?php echo number_format($gr_net_weight, 3, '.', ''); ?></strong></td>
                                    <td><strong><?php echo round($gr_total_meters); ?></strong></td>
                                    <td class="screen_only"></td>
                                 </tr>
                                 <?php
                              }
                              ?>
                              <tr>
                                 <th>#</th>                                                  <th>Box No</th>
                                 <th>Item Name</th>
                                 <th>Item Code</th>
                                 <th>1 Meter Weight</th>
                                 <th style="color:red;">1 Meter Weight New</th>
                                 <th>Gr.Weight</th>
                                 <th>Nt. Weight</th>
                                 <th>Total Meters</th>
                                 <th class="screen_only"></th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              $sno = 1;
                              foreach ($outerboxes as $row) {
                                 $one_mtr_weight = 0;
                                 $box_no = $row->box_no;
                                 $packing_innerbox_items = $row->packing_innerbox_items;
                                 $packing_gr_weight = $row->packing_gr_weight;
                                 $packing_net_weight = $row->packing_net_weight;
                                 $total_meters = $row->total_meters;
                                 $packing_wt_mtr = $row->packing_wt_mtr;
                                 $packing_wt_mtr_new = $row->packing_wt_mtr_new;
                                 $one_mtr_weight = ($packing_wt_mtr_new > 0)?$packing_wt_mtr_new:$packing_wt_mtr;
                                 ?>
                                 <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$box_no; ?></td>
                                    <td>
                                       <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_innerbox_items, 'item_name'); ?>
                                    </td>
                                    <td><?=$packing_innerbox_items; ?></td>
                                    <td><?=$packing_wt_mtr; ?></td>
                                    <td><strong style="color:red;"><?=$packing_wt_mtr_new; ?></strong></td>
                                    <td><?=$packing_gr_weight; ?></td>
                                    <td><?=$packing_net_weight; ?></td>
                                    <td><?=round($total_meters); ?></td>
                                    <td class="screen_only"><a href="<?=base_url(); ?>production/print_out_pack_slip/<?=$box_no; ?>" target="_blank" class="btn btn-primary btn-xs">Print</a></td>
                                 </tr>
                                 <?php
                                 $sno++;
                                 $net_gr_weight += $row->packing_gr_weight;
                                 $net_weight += $row->packing_net_weight;
                                 $net_meters += round($row->total_meters);
                                 $total_boxes++;
                              }
                              ?>
                                 <tr>
                                    <th></th>                                                     <th><?=$total_boxes; ?> Boxes</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?=number_format($net_gr_weight, 3, '.', ''); ?></th>
                                    <th><?=number_format($net_weight, 3, '.', ''); ?></th>
                                    <th><?=$net_meters; ?></th>
                                    <th class="screen_only"></th>
                                 </tr>
                              </tbody>
                           </table>
                           <hr>
                           <?php
                        }
                        ?>
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
