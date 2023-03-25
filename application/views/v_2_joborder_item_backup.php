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
                           <h3><i class="icon-map-marker"></i> Job Order Item wise</h3>
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
                              Summery
                              <?php
                              $machines = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
                              ?>
                              <select class="select2 ">
                                 <option value="">Select Machine</option>
                                 <?php
                                 foreach ($machines as $machine) {
                                    ?>
                                    <option name="<?=$machine['machine_id']; ?>"><?=$machine['machine_name']; ?></option>
                                    <?php
                                 }
                                 ?>
                              </select>
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="cartdata">                                                        <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Art No</th>
                                        <th>Item Name</th>
                                        <th>Po Qty</th>
                                        <th>Uom</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $items = $this->m_production->P_order_itemwise('bud_te_enq_items', 'enq_item_status');
                                       $sno = 1;
                                       foreach ($items as $item) {
                                          $item_name = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item['enq_item'], 'item_name');                                                                            $uom = $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_item_uom'], 'uom_name');                                                                            ?>
                                          <tr>
                                             <td><?=$sno; ?></td>
                                             <td><?=$item['enq_item']; ?></td>
                                             <td><?=$item_name; ?></td>
                                             <td><?=$item['SUM(enq_req_qty)']; ?></td>
                                             <td><?=$uom; ?></td>
                                             <td><a href="#" data-placement="top" data-original-title="Create Job Card" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Create Job Card</a></td>
                                          </tr>
                                          <?php
                                          $sno++;
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
