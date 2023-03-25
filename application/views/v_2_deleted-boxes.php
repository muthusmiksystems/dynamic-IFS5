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
                           <h3><i class=" icon-file"></i> Deleted Boxes</h3>
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

                      <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                                  <section class="panel">
                    <header class="panel-heading">
                        Summery
                    </header>
                    <div class="panel-body">                                                           <table class="table table-striped border-top" id="sample_1">
                         <thead>                                              <tr>
                              <th>#</th>                                               <th>Box No</th>
                              <th>Item Name</th>
                              <th>Item Code</th>
                              <th>1 Meter Weight</th>
                              <th style="color:red;">1 Meter Weight New</th>
                              <th>Gr.Weight</th>
                              <th>Nt. Weight</th>
                              <th>Total Meters</th>
                              <th>Packed By</th>
                              <th>Packed Date</th>
                              <th>Deleted By</th>
                              <th>Deleted Date</th>
                              <th>Remarks</th>
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
                              $packing_by = $row['packing_by'];
                              $packing_date = $row['packing_date'];
                              $packing_time = $row['packing_time'];
                              $deleted_by = $row['deleted_by'];
                              $deleted_on = $row['deleted_on'];
                              $remarks = $row['remarks'];
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
                                 <td><?=$this->m_masters->getmasterIDvalue('bud_users', 'ID', $packing_by, 'user_login'); ?></td>
                                 <td><?=$packing_date; ?> <?=$packing_time; ?></td>
                                 <td><?=$this->m_masters->getmasterIDvalue('bud_users', 'ID', $deleted_by, 'user_login'); ?></td>
                                 <td><?=$deleted_on; ?></td>
                                 <td><?=$remarks; ?></td>
                                 <td class="screen_only"><a href="<?=base_url(); ?>production/delete_box_2_deleted/<?=$box_no; ?>" class="btn btn-danger btn-xs del-confirm">Final Delete</a></td>
                              </tr>
                              <?php
                              $sno++;
                           }
                           ?>
                           </tbody>
                        </table>
                        <!-- <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button> -->
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

         $(function(){
              $(".del-confirm").click(function(){
                  if (!confirm("Do you want to delete")){
                    return false;
                  }
              });
          });

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
