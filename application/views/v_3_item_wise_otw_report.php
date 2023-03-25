<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Legrand charles">
      <meta name="keyword" content="">
      <link rel="shortcut icon" href="img/favicon.html">
      <title><?=$page_title; ?></title>

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
                  <section class="panel">
                     <header class="panel-heading">
                        <h3><i class=" icon-file"></i><?=$page_title; ?>
                        <button class="btn btn-info" align='to'><a href="<?=base_url(); ?>Mir_reports/tot_otw_report_3/<?=$term; ?>/<?=$term_value?>" >Back</a></button></h3>
                     </header>
                  </section>
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
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                        
                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>             
                    <div class="panel-body">
                        <h3 class="visible-print"><?=$page_title; ?></h3>
                        <h3 >Month/Year :<?=($term==2)?$year:$month.'-'.$year; ?></h3>
                        <div align='center'>
                           <strong><?=$page_title; ?></strong>
                        </div>
                        <?php
                        /*if($item_detail['tot_invs']=='0')
                        {
                           ?>
                            <div class="col-sm-4">
                              <strong>No Data Printed</strong>
                           </div>
                           <?php
                        }
                        else
                        {*/
                        ?>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                              <thead>
                                <tr>
                                    <th></th>
                                    <th><strong class='text-danger'>Total:<strong></th>
                                    <th></th>
                                    <th><strong class='text-danger'><?=count($item_detail['tot_pdc_boxes']).' Boxes'; ?></strong></th>
                                    <th><strong class='text-danger'><?=round(array_sum($item_detail['tot_pdc_qty'])/100000,2).'L pcs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=count($item_detail['tot_dc_boxes']).' Boxes'; ?></strong></th>
                                    <th><strong class='text-danger'><?=round( array_sum($item_detail['tot_dc_qty'])/100000,2).'L pcs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=count($item_detail['tot_inv_boxes']).' Boxes'; ?></strong></th>
                                    <th><strong class='text-danger'><?=round(array_sum($item_detail['tot_inv_qty'])/100000,2).'L pcs'; ?></strong></th>
                                    <th class="hidden-print"></th>
                                 </tr>
                                 <tr>
                                    <th rowspan="2" >#</th>  
                                    <th rowspan="2" >Item Group</th>
                                    <th rowspan="2" >Item Name</th>
                                    <th colspan="2" class="text-center">Pre DC</th>
                                    <th colspan="2" class="text-center">DC</th>
                                    <th colspan="2" class="text-center">Invoices</th>
                                    <th rowspan="2" ></th>
                                 </tr>
                                 <tr>
                                    <th># Boxes</th>
                                    <th>Delivered Qty <br>Pcs</th>               
                                    <th># Boxes</th>
                                    <th>Delivered Qty <br>Pcs</th>
                                    <th># Boxes</th>
                                    <th>Delivered Qty <br>Pcs</th>
                                 </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                    <th></th>
                                    <th><strong class='text-danger'>Total:<strong></th>
                                    <th></th>
                                    <th><strong class='text-danger'><?=count($item_detail['tot_pdc_boxes']).' Boxes'; ?></strong></th>
                                    <th><strong class='text-danger'><?=round(array_sum($item_detail['tot_pdc_qty'])/100000,2).'L pcs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=count($item_detail['tot_dc_boxes']).' Boxes'; ?></strong></th>
                                    <th><strong class='text-danger'><?=round( array_sum($item_detail['tot_dc_qty'])/100000,2).'L pcs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=count($item_detail['tot_inv_boxes']).' Boxes'; ?></strong></th>
                                    <th><strong class='text-danger'><?=round(array_sum($item_detail['tot_inv_qty'])/100000,2).'L pcs'; ?></strong></th>
                                    <th class="hidden-print"></th>
                                 </tr>
                                 </tr>
                              </tfoot>
                              <tbody>
                              <?php
                                 $sno=1;
                                 foreach ($item_detail['details'] as  $key=>$value) {
                                    ?>
                                    <tr>
                                       <td><?=$sno; ?></td>
                                       <td><?='$'.$this->m_mir->getgroupfields('bud_lbl_items','item_group',array('item_id'=>$key))[0]['item_group'];?></td>
                                       <td><?=$this->m_mir->getgroupfields('bud_lbl_items','item_name',array('item_id'=>$key))[0]['item_name'].'/'.$key;?></td>
                                       <?php
                                       $status='pdc';
                                       ?>
                                       <td><?=count($value[$status]['boxes']);?></td>
                                       <td><?=round(array_sum($value[$status]['tot_qty']),2);?></td>
                                       <?php
                                       $status='dc';
                                       ?>
                                       <td><?=count($value[$status]['boxes']);?></td>
                                       <td><?=round(array_sum($value[$status]['tot_qty']),2);?></td>                                       <?php
                                       $status='inv';
                                       ?>
                                       <td><?=count($value[$status]['boxes']);?></td>
                                       <td><?=round(array_sum($value[$status]['tot_qty']),2);?></td>
                                       <td class="hidden-print">
                                          <a href="<?=base_url(); ?>Mir_reports/tot_otw_box_wise_3/<?=$key;?>/<?=$term;?>/<?=$term_value;?>" class="btn btn-info">View</a>
                                       </td>
                                    </tr>
                                    <?php
                                    $sno++;
                                 }  
                                 ?>
                              </tbody>
                           </table>
                           <?php
                        //}
                        ?>
                           <hr>
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

      $('.datatable').dataTable({
            "sDom": "<'row'<'col-sm-6'f>r>",
            // "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "bSort": true,
            "bPaginate": false,
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': true,
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