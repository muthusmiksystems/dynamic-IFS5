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
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-file"></i><?=$page_title; ?></h3>
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
              // $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status');           
               ?>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>Mir_reports/prd_report_3">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title; ?>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-2">
                                 <label for="from_date">From</label>
                                 <input type="text" value="<?=$f_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="to_date">To</label>
                                 <input type="text" value="<?=$t_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
                              </div> 
                              <div class="form-group col-lg-2">
                                 <label for="item_id">Item Code</label>
                                 <select class="selects_items form-control select2" id="item_id" name="item_id">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="selects_items form-control select2" id="item_name" name="item_name">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div> 
                              <div class="form-group col-lg-3">
                                 <label for="operator_name">Operator Name</label>
                                 <select class="selects_operator form-control select2" id="operator_name" name="operator_name">
                                    <option value="0">Select Operator Name</option>
                                    <?php
                                    foreach ($staffs as $row) {
                                       ?>
                                       <option value="<?=$row['ID'];?>" <?=($row['ID'] == $operator_id)?'selected="selected"':''; ?>><?=$row['display_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="operator_id">Operator Code</label>
                                 <select class="selects_operator form-control select2" id="operator_id" name="operator_id">
                                    <option value="0">Select Operator Code</option>
                                    <?php
                                    foreach ($staffs as $row) {
                                       ?>
                                       <option value="<?=$row['ID'];?>" <?=($row['ID'] == $operator_id)?'selected="selected"':''; ?>><?=$row['ID'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-1">
                                 <label for="shift">Shift</label>
                                 <select class="form-control" id="shift" name="shift">
                                    <option value="0" selected="selected">All</option>                                       
                                    <option value="Day" <?=($shift == 'Day')?'selected="selected"':''; ?>>Day</option>                                          
                                    <option value="Night" <?=($shift == 'Night')?'selected="selected"':''; ?>>Night</option>                                          
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="sample">Sample / Production</label>
                                 <select class="form-control" id="sample" name="sample">
                                    <option value="0" selected="selected">All</option>

                                    <option value="1" <?=($sample == '1')?'selected="selected"':''; ?>>Sample</option>                                          
                                    <option value="2" <?=($sample == '2')?'selected="selected"':''; ?>>Production</option>                                          
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="machine_id">Machine</label>
                                 <select class="form-control select2" id="machine_id" name="machine_id">
                                    <option value="0">Select Machine</option>
                                    <?php
                                    foreach ($machines as $row) {
                                       ?>
                                       <option value="<?=$row['machine_id'];?>"><?=$row['machine_name'];?></option>
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
               
               ?>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                        
                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>             
                    <div class="panel-body">
                        <h3 class="visible-print"><?=$page_title;?></h3>
                        <div class="col-sm-4">
                           <strong>From Date : <?=$f_date; ?>  To Date: <?=$t_date; ?></strong>
                        </div>
                        <div class="col-sm-4">
                           <strong><?=$page_title; ?></strong>
                        </div>
                        <div class="col-md-4 text-right">
                           <strong>Print Date : <?=date("d-m-Y H:i:s"); ?></strong>
                        </div>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                           <thead>
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total :</strong></td>
                                <td><strong><?=$prd_details['tot_repts'];?>repts</strong></td>
                                <td></td>
                                <td><strong><?=$prd_details['tot_runtime'];?>hrs</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>#</strong></td>
                                <td><strong>Date</strong></td>
                                <td><strong>Operator Name</strong></td>
                                <td><strong>Operator Code</strong></td>
                                <td><strong>Item Name</strong></td>
                                <td><strong>Item Code</strong></td>
                                <td><strong>Shift</strong></td>
                                <td><strong>Sizes</strong></td>
                                <td><strong># of Repts</strong></td>
                                <td><strong>Machine Name</strong></td>
                                <td><strong>Machine Run Time</strong></td>
                                <td><strong>Sample / Production</strong></td>
                              </tr>
                            </thead>
                            <tfoot>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total :</strong></td>
                                <td><strong><?=$prd_details['tot_repts'];?>repts</strong></td>
                                <td></td>
                                <td><strong><?=$prd_details['tot_runtime'];?>hrs</strong></td>
                                <td></td>
                              </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $sno = 1;
                                foreach ($prd_details['details'] as $row) {
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=date('d-M-y',strtotime($row['date'])); ?></td>
                                    <td><?=$row['display_name']; ?></td>
                                    <td><?=$row['operator_id']; ?></td>
                                    <td><?=$row['item_name']; ?></td>
                                    <td><?=$row['item_id']; ?></td>
                                    <td><?=$row['shift']; ?></td>
                                    <td><?=$row['no_repts_size']; ?></td>
                                    <td><?=$row['no_repts']; ?></td>
                                    <td><?=$row['machine_name'].'/'.$row['machine_id']; ?></td>
                                    <td><?=$row['mac_run_time']; ?>hrs</td>
                                    <td><?=($row['sample']==1)?'Sample':'Production'; ?></td>
                                  </tr>
                                  <?php
                                  $sno++;
                                }
                                ?>
                            </tbody>
                           </table>
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

       $(".selects_operator").change(function(){
          $("#operator_name").select2("val", $(this).val());
          $("#operator_id").select2("val", $(this).val());
      });
      </script>
   </body>
</html>
