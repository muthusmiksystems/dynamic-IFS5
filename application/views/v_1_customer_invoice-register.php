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
                           <h3><i class=" icon-file"></i>  Customer &amp; Item Invoice Register</h3>
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
                  }                                  
                  /*if($this->session->flashdata('error'))
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
                  }*/
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
               $items = $this->m_masters->getactivemaster('bud_items', 'item_status');
               $cust_name = null;               
               $item_id = null;               
               ?>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/custinvoiceRegister_1">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              Customer Invoice Register
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="from_date">From</label>
                                 <input type="text" value="<?=$f_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="to_date">To</label>
                                 <input type="text" value="<?=$t_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
                              </div>                              
                              <div class="form-group col-lg-3">
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
                              </div>                             
                           </div>
                        </section>
                     </div> 
                  </div>
                </form>

               <?php
               $gr_total_boxes = 0;
               $gr_gross_weight = 0;
               $gr_net_weight = 0;
               foreach ($cust_pack_register as $item_id => $outerboxes) {
                  foreach ($outerboxes as $key => $row) {
                     $gr_net_weight += $row->net_weight;
                     $gr_gross_weight += $row->gross_weight;
                     $gr_total_boxes++;
                  }
               }
               ?>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                        
                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>             
                    <div class="panel-body">
                        <?php
                        $i = 0;
                        $total_boxes_array = array();
                        $tot_gr_weight_array = array();
                        $tot_weight_array = array();
                        foreach ($cust_pack_register as $customer_id => $outerboxes) {
                           foreach ($outerboxes as $row) {
                              $total_boxes_array[$customer_id][] = 1;
                              $tot_gr_weight_array[$customer_id][] = $row->gross_weight;
                              $tot_weight_array[$customer_id][] = $row->net_weight;
                           }
                        }
                        ?>
                        <h3 class="visible-print">Customer &amp; Item Invoice Register (Yarn &amp; Thread)</h3>
                        <div class="col-sm-6">
                           <strong>From Date : <?=$f_date; ?>  To Date: <?=$t_date; ?></strong>
                        </div>
                        <div class="col-md-6 text-right">
                           <strong>Print Date : <?=date("d-m-Y H:i:s"); ?></strong>
                        </div>
                        <?php
                        foreach ($cust_pack_register as $customer_id => $outerboxes) {
                           $customer = $this->m_reports->get_customer($customer_id);
                           ?>
                           <div class="col-sm-6">
                              Customer Code : <strong><?php echo $customer['cust_id']; ?></strong><br/>                           
                              Customer Name : <strong><?php echo $customer['cust_name']; ?></strong>                           
                           </div>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                            <thead>
                              <?php
                              if(++$i == 1)
                              {
                                 ?>
                                 <tr>
                                    <th></th>
                                    <th><strong><?php echo $gr_total_boxes; ?> Box(s)</strong></th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong><?php echo number_format($gr_gross_weight, 3, '.', ''); ?></strong></td>
                                    <td><strong><?php echo number_format($gr_net_weight, 3, '.', ''); ?></strong></td>
                              <td></td><!--Dynamic Dost 3.0-->
                                    <td></td>
                                    <td></td>
                                 </tr>
                                 <?php
                              }
                              ?>
                              <tr>
                                 <th></th>                         
                                 <th><?=count($total_boxes_array[$customer_id]); ?> Boxes</th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th><?=number_format(array_sum($tot_gr_weight_array[$customer_id]), 3, '.', ''); ?></th>
                                 <th><?=number_format(array_sum($tot_weight_array[$customer_id]), 3, '.', ''); ?></th>
                                 <td></td><!--Dynamic Dost 3.0-->
                                 <td></td>
                                 <td></td>
                                 <!-- <th class="screen_only"></th> -->
                              </tr>
                              <tr>
                                 <th>#</th>                         
                                 <th>Box No</th>
                                 <th>Invoice No</th>
                                 <th>Invoice Date</th>
                                 <th>Item Name</th>
                                 <th>Item Code</th>
                                 <th>Lot No</th>
                                 <th>Color</th>
                                 <th>Color Code</th>
                                 <th>Gr.Weight</th>
                                 <th>Nt. Weight</th>
                                 <th>Item Rate</th><!--Dynamic Dost 3.0-->
                                 <th>Packing Date</th>
                                 <th>Packed by</th>
                              </thead>
                              <tbody>
                              <?php
                              $sno = 1;
                              $total_net_weight = 0;
                              $total_gr_weight = 0;
                              $no_of_boxes = 0;
                              
                              foreach ($outerboxes as $key => $row) {
                                 $one_mtr_weight = 0;
                                 $box_no = $row->box_no;
                                 $lot_no =$this->m_mir->get_yt_box_lot_no($row->box_id);//ER-09-18#-49
                                 $total_net_weight += $row->net_weight;
                                 $total_gr_weight += $row->gross_weight;
                                 $no_of_boxes++;
                                 ?>
                                 <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row->box_prefix; ?><?=$box_no; ?></td>
                                    <td><?=$row->invoice_no; ?></td>
                                    <td><?=$row->invoice_date; ?></td>
                                    <td><?=$row->item_name; ?></td>
                                    <td><?=$row->item_id; ?></td>
                                    <td><?=$lot_no; ?></td>
                                    <td><?=$row->shade_name; ?> / <?=$row->shade_id; ?></td>
                                    <td><?=$row->shade_code; ?></td>
                                    <td><?=number_format($row->gross_weight, 3, '.', ''); ?></td>
                                    <td><?=number_format($row->net_weight, 3, '.', ''); ?></td>
                                    <td><?='Rs.'.number_format($row->item_rate, 2, '.', ''); ?></td><!--Dynamic Dost 3.0-->
                                    <td><?=$row->packed_date; ?></td>
                                    <td><?=$row->packed_by; ?></td>
                                 </tr>
                              <?php
                                 if(isset($outerboxes[$key + 1]->lot_no)||isset($outerboxes[$key + 1]->yarn_lot_id))//ER-09-18#-49
                                 {
                                    $nxt_lot_no =$this->m_mir->get_yt_box_lot_no($outerboxes[$key + 1]->box_id);//ER-09-18#-49
                                    if($lot_no != $nxt_lot_no)//ER-09-18#-49
                                    {
                                       ?>
                                       <tr>
                                          <td></td>
                                          <td><?=$no_of_boxes; ?> Boxes</td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td align="center"><strong>Total</strong></td>
                                          <td><strong><?=number_format($total_gr_weight, 3, '.', ''); ?></strong></td>
                                          <td><strong><?=number_format($total_net_weight, 3, '.', ''); ?></strong></td>
                                          <td></td><!--Dynamic Dost 3.0-->
                                          <td></td>
                                          <td></td>
                                       </tr>
                                       <?php
                                       $total_net_weight = 0;
                                       $total_gr_weight = 0;
                                       $no_of_boxes = 0;
                                    }
                                 }
                                 else
                                 {
                                    ?>
                                    <tr>
                                       <td></td>
                                       <td><?=$no_of_boxes; ?> Boxes</td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td align="center"><strong>Total</strong></td>
                                       <td><strong><?=number_format($total_gr_weight, 3, '.', ''); ?></strong></td>
                                       <td><strong><?=number_format($total_net_weight, 3, '.', ''); ?></strong></td>
                                       <td></td><!--Dynamic Dost 3.0-->
                                       <td></td>
                                       <td></td>
                                    </tr>
                                    <?php
                                    $total_net_weight = 0;
                                     $total_gr_weight = 0;
                                    $no_of_boxes = 0;
                                 }
                                 $sno++;
                              }
                              ?>
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

      $(".get_item_detail").change(function(){
        $("#customer_name").select2("val", $(this).val());
        $("#customer_id").select2("val", $(this).val());       
        return false;
      });
      $(".item").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());
      });
      $(".color").change(function(){
        $("#color_name").select2("val", $(this).val());
        $("#color_code").select2("val", $(this).val());
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

      </script>
   </body>
</html>
