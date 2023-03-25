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
                           <h3><i class=" icon-file"></i> Item Delivery Register</h3>
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
               $items = $this->m_masters->getactivemaster('bud_te_items', 'item_status');                      $uoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
               $item_name = null;                      ?>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/itemdeliveryRegister">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Item Delivery Register
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
                                 <label for="item_name">Item Name</label>
                                 <select class="get_item_detail form-control select2" id="item_name" name="item_name">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                      ?>
                                      <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item)?'selected="selected"':''; ?>><?=$row['item_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_code">Item Code</label>
                                 <select class="get_item_detail form-control select2" id="item_code" name="item_code">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                      ?>
                                      <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item)?'selected="selected"':''; ?>><?=$row['item_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>                                                                          <div style="clear:both;"></div>
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
               print_r($outerboxes);
               echo "</pre>";*/
               ?>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>
                    <div class="panel-body">
                        <?php
                        $total_boxes = 0;
                        $net_gr_weight = 0;
                        $net_weight = 0;
                        $net_meters = 0;
                        foreach ($outerboxes as $row) {
                           $net_gr_weight += $row['packing_gr_weight'];
                           $net_weight += $row['packing_net_weight'];
                           $net_meters += round($row['total_meters']);
                           $total_boxes++;
                        }
                        ?>                                    <table id="example" class="table table-bordered table-striped table-condensed cf packing-register">
                         <thead>
                           <tr>
                              <th></th>                                               <th><?=$total_boxes; ?> Boxes</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th><?=number_format($net_gr_weight, 3, '.', ''); ?></th>
                              <th><?=number_format($net_weight, 3, '.', ''); ?></th>
                              <th><?=$net_meters; ?></th>
                              <th class="screen_only"></th>
                           </tr>
                           <tr>
                              <th>#</th>                                               <th>Box No</th>
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
                              $box_no = $row['box_no'];
                              $packing_innerbox_items = $row['packing_innerbox_items'];
                              $packing_gr_weight = $row['packing_gr_weight'];
                              $packing_net_weight = $row['packing_net_weight'];
                              $total_meters = $row['total_meters'];
                              $packing_wt_mtr = $row['packing_wt_mtr'];
                              $packing_wt_mtr_new = $row['packing_wt_mtr_new'];
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

      /*$('#example').DataTable({
         "sDom": "<'row'<'col-sm-6 screen-only'l><'col-sm-6 screen-only'f>r>t<'row'<'col-sm-6 screen-only'i><'col-sm-6 screen-only'p>>",
            "sPaginationType": "bootstrap",
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
            }],
         // dom: 'T<"clear">lfrtip', 
         // tableTools: { "sSwfPath": "<?=base_url(); ?>themes/default/tabletools/swf/copy_csv_xls_pdf.swf" } 
         "sDom": 'T<"clear">lfrtip',
         "oTableTools": {
            "aButtons": [
                // "copy",
               "print",
               {
                  "sExtends":    "collection",
                  "sButtonText": "Save",
                  "aButtons":    [ "csv", "xls", "pdf" ]
               }
            ]
         }
      });*/


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
        $("#item_name").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());       return false;
      });
      </script>
   </body>
</html>
