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
      
      
      
       
      <style type="text/css">
      @media print{
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
                           <h3><i class=" icon-file"></i> <?=$page_title;?></h3>
                        </header>
                     </section>
                  </div>
               </div>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/boxStatus_3">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title?>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="from_date">From Box</label>
                                 <input type="text" value="<?=$f_box;?>" class="form-control"  name="from_box">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="to_date">To box </label>
                                 <input type="text" value="<?=$t_box;?>" class="form-control" name="to_box">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label>Box Number</label>
                                 <input type="text" value="<?=$boxes;?>" class="form-control" name="boxes">
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
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                        
                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>
                    <div class="panel-body">
                        <?php
                        $total_boxes = 0;
                        $tot_delv_qty =$this->m_production->boxDeliveredQty(); //partial delivery qty
                        $net_total_pieces = 0;
                        $net_meters = 0;
                        foreach ($outerboxes as $row) {
                           $tot_delv_qty += $row['packing_gr_weight'];
                           $box_size_items=$this->m_masters->getcategoryallmaster('bud_lbl_outerbox_items','box_no',$row['box_no']);
                           foreach ($box_size_items as $box_size_item) {
                              $net_total_pieces+=$box_size_item['total_qty'];  
                           }
                           $total_boxes++;
                        }
                        ?>                     
                       <table id="example" class="table datatable table-bordered table-striped table-condensed cf packing-register">
                         <thead>
                           <tr>
                              <th></th>                         
                              <th><?=$total_boxes; ?> Boxes</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th><?=$net_total_pieces; ?></th>
                              <th><?=$tot_delv_qty;  //partial delivery qty?></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <!-- <th class="screen_only"></th> -->
                           </tr>
                           <tr>
                              <th width="5%">#</th>                         
                              <th width="5%">Box No</th>
                              <th width="15%">Item Group</th>
                              <th width="15%">Item Name/Code</th>
                              <th width="15%">Size Tot. Qty</th>
                              <th width="5%">Tot. Qty</th>
                              <th width="5%">Delivered Qty</th><!--partial delivery qty-->
                              <th width="5%">Packed By</th>
                              <th width="10%">Packing Date</th>
                              <th width="10%">Status</th>
                              <th width="10%">Remarks</th>
                           </tr>
                           </thead>
                           <tbody>
                           <?php
                           $sno = 1;
                           $total_pieces = 0;
                           $total_gr_weight = 0;
                           $total_qty=0;
                           foreach ($outerboxes as $key => $row) {
                              $one_mtr_weight = 0;
                              $box_no=$row['box_no'];
                              $box_size_items=$this->m_masters->getcategoryallmaster('bud_lbl_outerbox_items','box_no',$box_no);
                              $total_pieces += $total_qty;
                              $total_qty=0;
                              $delvd_qty=$this->m_production->boxDeliveredQty($box_no); //partial delivery qty
                              $total_gr_weight = $delvd_qty;
                              ?>
                              <tr>
                                 <td><?=$sno; ?></td>
                                 <td><?=$row['box_prefix'].$box_no;?></td>
                                 <td><?=$row['group_name']; ?></td>
                                 <td><?=$row['item_name'].'/'.$row['item_id']; ?></td>
                                 <td>
                                    <?php
                                    foreach ($box_size_items as $box_size_item) {
                                       echo $box_size_item['item_size'].'-'.$box_size_item['total_qty'].',';
                                       $total_qty+=$box_size_item['total_qty'];
                                    }
                                    ?>
                                 </td>
                                 <td><?=$total_qty.' '.$row['uom_name']; ?></td>
                                 <td><?=($delvd_qty)?$delvd_qty.' '.$row['uom_name']:'';  //partial delivery qty?></td>
                                 <td><?=$row['operator_id'];?></td>
                                 <td><?=date('d-M-y h:i a',strtotime($row['date_time'])); ?></td>
                                 <td class="screen_only">
                                    <!--to include box status in packing register-->
                                    <?php
                                    //partial delivery qty
                                    if(round($total_qty)>$delvd_qty)
                                    {
                                    ?>
                                       <button class="btn btn-success btn-xs">stock</button></br>
                                       <strong style="color:green;">stock=<?=round($total_qty)-$delvd_qty;?></strong></br>
                                    <?php
                                    }  
                                    $status=$this->m_reports->get_box_status($box_no);
                                    $check=true;
                                    if($status['inv_no'])
                                    {
                                       $inv_no=implode(',',$status['inv_no']);
                                       $check=false;
                                    ?>
                                       <button class="btn btn-danger btn-xs">Invoiced</button></br>
                                       <strong style="color:red;"><?=$inv_no;?></strong></br>
                                    <?php
                                    }
                                    if($status['dc_no']){
                                       $check=false;
                                       $dc_no=implode(',',$status['dc_no']);
                                    ?>
                                    <button class="btn btn-warning btn-xs">Delivered</button></br>
                                    <strong style="color:orange;"><?=$dc_no;?></strong></br>
                                    <?php
                                    }
                                    if($status['pdc_no']){
                                       $check=false;
                                       $pdc_no=implode(',',$status['pdc_no']);
                                    ?>
                                    <button class="btn btn-info btn-xs">Reserved</button></br>
                                    <strong style="color:blue;"><?=$pdc_no;?></strong></br>
                                    <?php
                                    }
                                     //partial delivery qty
                                    ?>
                                    <!--to include box status in packing register-->
                                    <a href="<?=base_url(); ?>production/print_out_pack_slip_3/<?=$box_no; ?>" target="_blank" class="btn btn-primary btn-xs">Print</a>
                                 </td>
                                 <td>
                                 <?php
                                 echo $row['remark'].'</br>';
                                 if($row['is_deleted']==1){
                                       echo 'Deleted by '.$row['deleted_by'].' on '.date('d-M-y H:i',strtotime($row['deleted_time']));
                                 }
                                 ?>
                                 </td>
                              </tr>
                              <?php
                              $sno++;
                           }
                           ?>
                           </tbody>
                        </table>
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
      </script>
   </body>
</html>
