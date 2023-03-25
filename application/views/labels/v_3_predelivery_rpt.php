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
                           <h3><i class="icon-map-marker"></i> Pre Deliveries</h3>
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
                      <section class="panel">
                          <header class="panel-heading">
                              Pre Deliveries
                          </header>
                          <div class="panel-body">
                              <table class="table table-striped border-top" id="sample_1">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Date</th>
                                  <th>Pre Delivery No</th>
                                  <th>Customer</th>
                                  <th>Items</th>
                                  <th>Selected Boxes</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $sno = 1;
                                foreach ($pre_deliveries as $row) {
                                  $boxes_array = array();
                                  $p_delivery_boxes = explode(",", $row['p_delivery_boxes']);
                                                            $item_names_array = array();
                                  $delivery_items = $this->m_production->labelInvoiceItems($p_delivery_boxes);
                                  if(count($delivery_items) > 0)
                                  {
                                    foreach ($delivery_items as $item) {
                                      $item_name = $item['item_name'];
                                      $box_no = $item['box_no'];
                                      $item_names_array[$item['item_id']] = $item_name;
                                    }
                                  }
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['p_delivery_date']; ?></td>
                                    <td><?=$row['p_delivery_id']; ?></td>
                                    <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $row['p_delivery_cust'], 'cust_name');?>
                                    </td>
                                    <td><?=implode(",", $item_names_array); ?></td>
                                    <td><?=implode(",", $p_delivery_boxes); ?></td>
                                    <td>
                                      <a href="<?=base_url(); ?>production/predelivery_3_print/<?=$row['p_delivery_id']; ?>" class="btn btn-success btn-xs">Print</a>
                                    </td>
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
