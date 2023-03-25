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
                                        <th>PO No</th>
                                        <th>Po Qty</th>
                                        <th>Po Qty. Balance</th>
                                        <th class=""></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       foreach ($p_orders as $p_order) {
                                          $order_id = $p_order['order_id'];
                                          $order_enq_id = $p_order['order_enq_id'];
                                          $total_Qty = $this->m_purchase->get_total_Qty('bud_te_enq_items', 'enq_id', 'enq_req_qty', $p_order['order_enq_id']);
                                          $total_jobcard = 0;
                                          $jobcards = $this->m_purchase->getDatas('bud_te_jabcards', 'jobcard_po', $order_id);
                                          foreach ($jobcards as $jobcard) {
                                             $jobcard_qty = array();
                                             $jobcard_qty = explode(",", $jobcard['jobcard_qty']);
                                             $total_jobcard += array_sum($jobcard_qty);
                                          }
                                          ?>
                                          <tr>
                                             <td><?=$order_id; ?></td>
                                             <td>
                                                <?=$total_Qty; ?>
                                             </td>
                                             <td><?=$total_Qty - $total_jobcard; ?></td>
                                             <td>
                                                <a href="<?=base_url()?>production/jobcard_2_new/<?=$order_id; ?>">
                                                   <span class="label label-success">Create Jobcard</span>
                                                </a>
                                             </td>
                                          </tr>                                                            <?php
                                       }
                                       ?>
                                    </tbody>
                              </table>
                            </div>
                        </section>

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
