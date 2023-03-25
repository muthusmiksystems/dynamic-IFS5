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
                        <button class="btn btn-info" align='to'><a href="<?=base_url(); ?>Mir_reports/poyvspacking_item_wise_1/<?=$term; ?>/<?=$year;?>/<?=$o_month;?>" >Back</a></button></h3>
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
                        if($box_detail)
                        {
                           $tot_nt_wt=0;
                           $tot_gross_wt=0;
                           $tot_cones=0;
                           $tot_box=0;
                           foreach ($box_detail as $box) {
                              $tot_nt_wt+=$box['net_weight'];
                              $tot_gross_wt+=$box['gross_weight'];
                              $tot_cones+=$box['no_cones'];
                              $tot_box++;
                           }
                        }
                        ?>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                              <thead>
                                <tr>
                                    <th><strong class='text-danger'>Total:<strong></th>
                                    <th><strong class='text-danger'><?=$tot_box.' Boxes'; ?></strong></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong class='text-danger'><?=$tot_cones.' Cones'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$tot_gross_wt.' Kgs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$tot_nt_wt.' Kgs'; ?></strong></th>
                                    <th></th>
                                 </tr>
                                 <tr>
                                    <th >#</th>  
                                    <th >Box No</th>
                                    <th >Item Name</th>
                                    <th >Shade Name</th>
                                    <th >Lot No </th>
                                    <th >Denier Name</th>
                                    <th >Packed By</th>
                                    <th >Packed On</th>
                                    <th >Stock qty</th>
                                    <th ># Cones</th>
                                    <th >Gr wt</th>
                                    <th >Net Wt</th>
                                    <th >Status</th>
                                 </tr>
                              </thead>
                              <tfoot>
                                 <tr>
                                    <th><strong class='text-danger'>Total:<strong></th>
                                    <th><strong class='text-danger'><?=$tot_box.' Boxes'; ?></strong></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong class='text-danger'><?=$tot_cones.' Cones'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$tot_gross_wt.' Kgs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$tot_nt_wt.' Kgs'; ?></strong></th>
                                    <th></th>
                                 </tr>
                              </tfoot>
                              <tbody>
                              <?php
                                 $sno=1;
                                 foreach ($box_detail as  $box){
                                    ?>
                                    <tr>
                                       <td><?=$sno; ?></td>
                                       <td><?=$box['box_prefix'].$box['box_no'];?></td>
                                       <td><?=$box['item_name'].'/'.$box['item_id'];?></td>
                                       <td><?=$box['shade_name'].'/'.$box['shade_code'];?></td>
                                       <td><?=$box['poy_inward_no'];?></td>
                                       <td><?=$box['denier_name'];?></td>
                                       <td><?=$box['display_name'];?></td>
                                       <td><?=date('d-M-y H:i',strtotime($box['packed_date']));?></td>
                                       <td><?=$box['stock_room_name'];?></td>
                                       <td><?=$box['no_cones'];?></td>
                                       <td><?=number_format($box['gross_weight'],2);?></td>
                                       <td><?=number_format($box['net_weight'],2);?></td>
                                       <td><?=($box['predelivery_status']==1)?'Stock':($box['delivery_status']==1)?'reserved':'delivered'?></td>
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

      $(".get_item_detail").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());       
        return false;
      });
      $(".get_cust_detail").change(function(){
        $("#cust_name").select2("val", $(this).val());
        $("#cust_id").select2("val", $(this).val());       
        return false;
      });
      </script>
   </body>
</html>