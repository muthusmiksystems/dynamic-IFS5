<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="legrand charles">
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
         @page{margin: 3mm;}
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
                      <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/dyes_cost_reg">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Dyes Costing Register
                           </header>
                           <div class="panel-body">                                                 <div class="form-group col-lg-3">
                                 <label for="from_date">From Date</label>
                                 <input class="dateplugin form-control" id="from_date" name="from_date" value="<?=$from_date; ?>" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="to_date">To Date</label>
                                 <input class="dateplugin form-control" id="to_date" name="to_date" value="<?=$to_date; ?>" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="lot_prefix">Machine</label>
                                 <select class="form-control select2" id="lot_prefix" name="lot_prefix">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($machines as $row) {
                                      ?>
                                      <option value="<?=$row['machine_id']; ?>" <?=($row['machine_id'] == $lot_prefix)?'selected="selected"':''; ?>><?=$row['machine_prefix']; ?><?=$row['machine_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="lot_id">Batch No</label>
                                 <select class="form-control select2" id="lot_id" name="lot_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($lots as $row) {
                                      ?>
                                      <option value="<?=$row->lot_id; ?>" <?=($row->lot_id == $lot_id)?'selected="selected"':''; ?>><?=$row->lot_no; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                <label>&nbsp;</label>
                                <button class="btn btn-danger" type="submit" name="search" value="search">Search</button>
                              </div>                                                </div>
                        </section>
                     </div> 
                  </div>
                </form>

               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>
                    <div class="panel-body">
                     <h5 class="visible-print">Dyes &amp; Chemicals Costing Register</h5>
                       <table id="example" class="table table-bordered table-striped table-condensed cf packing-register">
                         <thead>
                           <tr>
                              <th rowspan="2">S.No</th>
                              <th rowspan="2">Batch No</th>
                              <th rowspan="2">Machine No</th>
                              <th rowspan="2">Lot Weight</th>
                              <th colspan="2" class="text-center">Dyes &amp; Chemicals</th>
                              <!-- <th rowspan="2">Total Cost</th> -->
                              <th rowspan="2" align="right">Avg Cost/Kg</th>
                           </tr>
                           <tr>
                              <th>Quantity</th>
                              <th>Value</th>
                           </tr>
                           </thead>
                           <tbody>
                              <?php
                              if(count($total_consumption) > 0)
                              {
                                 $sno = 1;
                                 $gr_lot_qty = 0;
                                 $gr_total_consumption = 0;
                                 $gr_total_value = 0;
                                 $gr_cost_per_kg = 0;
                                 foreach ($total_consumption as $lot_id => $row) {
                                    $cost_per_kg = 0;
                                    if($row['total_consumption'] > 0)
                                    {
                                       $cost_per_kg = $row['total_value'] / $row['total_consumption'];                                                                   }

                                    $gr_lot_qty += $row['lot_qty'];
                                    $gr_total_consumption += $row['total_consumption'];
                                    $gr_total_value += $row['total_value'];
                                    $gr_cost_per_kg += $cost_per_kg;
                                    ?>
                                    <tr>
                                       <td><?=$sno; ?></td>
                                       <td><?=$row['lot_no']; ?></td>
                                       <td><?=$row['machine_name']; ?></td>
                                       <td align="right"><?=number_format($row['lot_qty'], 3, '.', ''); ?></td>
                                       <td align="right"><?=number_format($row['total_consumption'], 3, '.', ''); ?></td>
                                       <td align="right"><?=number_format($row['total_value'], 2, '.', ''); ?></td>
                                       <td align="right"><?=number_format($cost_per_kg, 2, '.', ''); ?></td>
                                    </tr>
                                    <?php
                                    $sno++;
                                 }
                                 ?>
                                 <tfoot>
                                    <tr>
                                       <td></td>
                                       <td colspan="2" align="right"><strong>Total</strong></td>
                                       <td align="right"><strong><?=number_format($gr_lot_qty, 3, '.', ''); ?></strong></td>
                                       <td align="right"><strong><?=number_format($gr_total_consumption, 3, '.', ''); ?></strong></td>
                                       <td align="right"><strong><?=number_format($gr_total_value, 2, '.', ''); ?></strong></td>
                                       <td align="right"><strong><?=number_format($gr_cost_per_kg, 2, '.', ''); ?></strong></td>
                                    </tr>
                                 </tfoot>
                                                          <?php
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
