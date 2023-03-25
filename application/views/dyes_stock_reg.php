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
         @page{
            margin: 3mm;
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
               </div>                  <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/dyes_stock_reg">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Dyes Stock Register
                           </header>
                           <div class="panel-body">                                                 <div class="form-group col-lg-3">
                                 <label for="dyes_chem_id">Item</label>
                                 <select class="get_item_detail form-control select2" id="dyes_chem_id" name="dyes_chem_id">
                                    <option value="">All</option>
                                    <?php
                                    foreach ($dyes_chemicals as $row) {
                                      ?>
                                      <option value="<?=$row['dyes_chem_id']; ?>" <?=($row['dyes_chem_id'] == $dyes_chem_id)?'selected="selected"':''; ?>><?=$row['dyes_chem_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="dyes_chem_id">Item Code</label>
                                 <select class="get_item_detail form-control select2" id="dyes_chem_code">
                                    <option value="">All</option>
                                    <?php
                                    foreach ($dyes_chemicals as $row) {
                                      ?>
                                      <option value="<?=$row['dyes_chem_id']; ?>" <?=($row['dyes_chem_id'] == $dyes_chem_id)?'selected="selected"':''; ?>><?=$row['dyes_chem_code']; ?></option>
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
                        Dyes Stock Register
                    </header>
                    <div class="panel-body">
                        <h5 class="visible-print">Dyes Stock Register</h5>
                       <table id="example" class="table datatable table-bordered table-striped table-condensed cf packing-register">
                         <thead>
                           <tr>
                              <th>S.No</th>
                              <th>Item</th>
                              <th>Code</th>
                              <th class="text-right">Opening Stock (Kg)</th>
                              <th class="text-right">Inward Stock (Kg)</th>
                              <th class="text-right">Consumption Stock (Kg)</th>
                              <th class="text-right">Balance Stock (Kg)</th>
                           </tr>
                           </thead>
                           <tbody>
                              <?php
                              if(count($result) > 0)
                              {
                                 $sno = 1;
                                 $gr_open_stock = 0;
                                 $gr_inward_qty = 0;
                                 $gr_tot_consumption = 0;
                                 $gr_balance_stock = 0;
                                 foreach ($result as $dyes_chem_id => $row) {
                                    $balance_stock = 0;
                                    $tot_inward_qty = $this->m_purchase->get_dyes_chem_inw_qty($dyes_chem_id);
                                    $tot_consumption = array_sum($row['qty']);
                                    $balance_stock = ($row['open_stock'] + $tot_inward_qty) - $tot_consumption;

                                    $gr_open_stock += $row['open_stock'];
                                    $gr_inward_qty += $tot_inward_qty;
                                    $gr_tot_consumption += $tot_consumption;
                                    $gr_balance_stock += $balance_stock;
                                    ?>
                                    <tr>
                                       <td><?=$sno; ?></td>
                                       <td><?=$row['name']; ?></td>
                                       <td><?=$row['code']; ?></td>
                                       <td class="text-right"><?=number_format($row['open_stock'], 3, '.', ''); ?></td>
                                       <td class="text-right"><?=number_format($tot_inward_qty, 3, '.', ''); ?></td>
                                       <td class="text-right"><?=number_format($tot_consumption, 3, '.', ''); ?></td>
                                       <td class="text-right"><?=number_format($balance_stock, 3, '.', ''); ?></td>
                                    </tr>
                                    <?php
                                    $sno++;
                                 }
                                 ?>
                                 <tfoot>
                                    <tr>
                                       <td colspan="3" class="text-right"><strong>Total</strong></td>
                                       <td class="text-right"><strong><?=number_format($gr_open_stock, 3, '.', ''); ?></strong></td>
                                       <td class="text-right"><strong><?=number_format($gr_inward_qty, 3, '.', ''); ?></strong></td>
                                       <td class="text-right"><strong><?=number_format($gr_tot_consumption, 3, '.', ''); ?></strong></td>
                                       <td class="text-right"><strong><?=number_format($gr_balance_stock, 3, '.', ''); ?></strong></td>
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
        $("#dyes_chem_id").select2("val", $(this).val());
        $("#dyes_chem_code").select2("val", $(this).val());       return false;
      });
      </script>
   </body>
</html>
