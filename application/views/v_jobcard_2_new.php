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
      ?>
    
    
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
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class="icon-map-marker"></i> Jobcard Entry</h3>
                        </header>
                     </section>
                  </div>
               </div>
               <div class="row">
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
                  <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>production/jobcard_2_new_save">
                  <?php
                  foreach ($p_orders as $p_order) {
                     $po_id = $p_order['po_id'];
                     $po_item = $p_order['po_item'];
                     $po_denier = explode(",", $p_order['po_denier']);                                                       $po_color = explode(",", $p_order['po_color']);                                                       $po_qty = explode(",", $p_order['po_qty']);                                                    }
                  $jobcards = $this->m_purchase->getDatas('bud_te_jabcards', 'jobcard_po', $po_id);
                  $total_jobcard = array();
                  foreach ($jobcards as $jobcard) {
                     $jobcard_qty = array();
                     $jobcard_qty = explode(",", $jobcard['jobcard_qty']);
                     $array_total = 0;
                     foreach ($po_denier as $key => $value) {
                        if(isset($total_jobcard[$key]))
                        {
                           $total_jobcard[$key] = $total_jobcard[$key] + $jobcard_qty[$key]; 
                        }
                        else
                        {
                           $total_jobcard[$key] = $jobcard_qty[$key];                                           }
                     }
                  }
                  ?>
                  <input type="hidden" name="jobcard_po" value="<?=$po_id; ?>">
                  <div class="row">
                     <div class="col-lg-12">
                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Purchase Orders
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="cartdata">                                                        <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Denier</th>
                                        <th>Color</th>
                                        <th>Color Code</th>
                                        <th>Po Qty</th>
                                        <th>Total Jobcard Qty</th>
                                        <th>Po Banance Qty</th>
                                        <th>Job Qty</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $sno = 1;
                                       foreach ($po_denier as $key => $denier) {
                                          ?>
                                          <tr>
                                             <td><?=$sno; ?></td>
                                             <td><?=$denier; ?></td>
                                             <td>
                                                <?=$this->m_masters->getmasterIDvalue('bud_te_shades', 'shade_id', $po_color[$key], 'shade_name'); ?>
                                             </td>
                                             <td>
                                                <?=$this->m_masters->getmasterIDvalue('bud_te_shades', 'shade_id', $po_color[$key], 'shade_code'); ?>
                                             </td>
                                             <td><?=$po_qty[$key]; ?></td>
                                             <td><?=$total_jobcard[$key]; ?></td>
                                             <td><?=$po_qty[$key] - $total_jobcard[$key]; ?></td>
                                             <td>
                                                <div class="col-lg-5">
                                                   <?php
                                                   if(($po_qty[$key] - $total_jobcard[$key]) > 0)
                                                   {
                                                      ?>
                                                      <input class="form-control" name="job_qty[]" value="0" type="text" required>                                                                                                 <?php
                                                   }
                                                   ?>
                                                </div>
                                             </td>
                                          </tr>
                                          <?php
                                       }
                                       $sno++;
                                       ?>
                                    </tbody>
                              </table>
                            </div>
                        </section>

                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>

                     </div>
                  </div>
                  </form>
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
