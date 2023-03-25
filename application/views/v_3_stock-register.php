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
         .packing-register th
         {
            border: 1px solid #000 !important;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
         }
         .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td{
             padding: 0 !important;
             font-size: 16px !important;
             line-height: 1 !important;
           }
           .boxes{
            font-size: 18px !important;
           }
         .packing-register td
         {
            border: 1px solid #000!important;
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
                           <h3><i class=" icon-file"></i>  Item Stock Register</h3>
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
               $items = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
                      ?>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/stock_register_3">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Item Stock Register
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="from_date">From</label>
                                 <input type="text" value="<?=$f_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="to_date">To</label>
                                 <input type="text" value="<?=$t_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
                              </div>                                                    <!-- <div class="form-group col-lg-3">
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
                              </div> -->
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
                               <div class="form-group col-lg-3">
                                 <label for="color_name">Color Name </label>                                                        <select class="form-control select2 color" id="color_name">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($colors as $row) {
                                      ?>
                                      <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?> ><?=$row['shade_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                               <div class="form-group col-lg-3">
                                 <label for="color_code">Color Code</label>                                                     <select class="form-control select2 color" id="color_code" name="color_code">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($colors as $row) {
                                      ?>
                                      <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?> ><?=$row['shade_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="color_code">Stock Room </label>                                                     <select class="form-control select2" id="rno" name="rno">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($room_no as $row) {
                                      ?>
                                      <option value="<?=$row['stock_room_id']; ?>" <?=($row['stock_room_id'] == $room_id)?'selected="selected"':''; ?> ><?=$row['stock_room_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>                                                                             <div style="clear:both;"></div>
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
               $gr_total_qty = 0;
               foreach ($cust_pack_register as $customer_id => $outerboxes) {
                  foreach ($outerboxes as $key => $row) {
                     $box_no = $row->box_no;
                     $quantity = $this->m_reports->get_total_qty_lbl($box_no);
                     $del_qty = $this->m_production->boxDeliveredQty($box_no);//partial delivery qty
                      $qty = $quantity->tot_qty-$del_qty;//partial delivery qty
                     $gr_total_qty += $qty;//partial delivery qty
                     $gr_net_weight += $row->packing_net_weight;
                     $gr_gross_weight += $row->packing_gr_weight;
                     $gr_total_boxes++;

                     $outerboxes[$key]->qty = $qty;
                  }
               }
               ?>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>					
                    <div class="panel-body">
                        <h3 class="visible-print">Item Stock Register (Labels)</h3>
                        <div class="col-sm-6">
                           <strong>From Date : <?=$f_date; ?>  To Date: <?=$t_date; ?></strong>
                        </div>
                        <div class="col-md-6 text-right">
                           <strong>Print Date : <?=date("d-m-Y H:i:s"); ?></strong>
                        </div>
                        <?php
                        /*echo "<pre>";
                        // print_r($cust_pack_register);
                        echo "</pre>";*/
                        $i = 0;
                        foreach ($cust_pack_register as $item_id => $outerboxes) {
                           $total_boxes = 0;
                           $net_gr_weight = 0;
                           $tot_qty = 0;
                           $net_meters = 0;
                           $item = $this->m_reports->get_item_lbl($item_id);
                           $item_code = $item['item_id'];
                           $item_name = $item['item_name'];
                           ?>
                           <div class="col-sm-6">
                              Item Code : <strong><?php echo $item['item_id']; ?></strong><br/>                                                 Item Name : <strong><?php echo $item['item_name']; ?></strong>                                              </div>
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
                                                                <td><strong><?php echo $gr_total_qty; ?></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                 </tr>
                                 <?php
                              }
                              ?>
                              <tr>
                                 <th>#</th>                                                  <th>Box No</th>
                                 <th>Item Name</th>
                                 <th>Item Code</th>
                                 <th>Packing Contact</th>
                                 <th>Stock Qty</th>
                                 <th>Stock Room</th>
                                 <th>Remark</th>
                                 <th>Packed Date</th>
                                 <th>Packed By</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              $sno = 1;
                              $total_tot_qty = 0;
                              $total_gr_weight = 0;
                              foreach ($outerboxes as $key => $row) {
                                 $one_mtr_weight = 0;
                                 $qty = 0;
                                 $box_no = $row->box_no;
                                 $total_gr_weight += $row->packing_gr_weight;
                                 $del_qty = $this->m_production->boxDeliveredQty($box_no);//partial delivery qty
                                 $qty = $row->qty-$del_qty;//partial delivery qty
                                 $total_tot_qty += $qty;//partial delivery qty
                                 ?>
                                 <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row->box_prefix; ?><?=$box_no; ?></td>
                                    <td><?=$item_name; ?></td>
                                    <td><?=$item_code; ?>*</td>
                                    <td><?=$row->packing_contact; ?></td>
                                     <td><?=$qty; ?></td>
                                     <td>
	                                    <?php
	                                    	$this->db->select('*');
	                                    	$this->db->from('bud_stock_rooms');
	                                    	$this->db->where('stock_room_id',$row->packing_stock_room);
	                                    	$q = $this->db->get();
	                                    	$a  = $q->result_array();
	                                    	foreach($a as $b)
	                                    	{
	                                    		echo "<b>".$b['stock_room_name']."</b><br>".$row->packing_stock_place;
	                                    	}
	                                    ?>
	                             </td>   

                                    <td><?=$row->remark; ?></td>
                                                                                          <td><?php echo date("d-m-Y", strtotime($row->date_time));?></td>
                                    <td><?=$row->display_name; ?></td>
                                 </tr>
                                 <?php
                                 $sno++;
                                 $net_gr_weight += $row->packing_gr_weight;
                                 $tot_qty += $qty;
                                 $total_boxes++;
                              }
                              ?>
                              <tr>
                                 <th></th>                                                  <th><?=$total_boxes; ?> Boxes</th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th><?=$tot_qty; ?></th>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <!-- <th class="screen_only"></th> -->
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
            // "sDom": "<'row'<'col-sm-6'f>r>",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
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
      $(".color").change(function(){
        $("#color_name").select2("val", $(this).val());
        $("#color_code").select2("val", $(this).val());
      });
      </script>
   </body>
</html>
