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
                           <h3><i class="icon-map-marker"></i> Edit Pre Delivery</h3>
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
               <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>production/predelivery_2_update">
                  <?php
                  foreach ($delivery_details as $row) {
                    $p_delivery_boxes = explode(",", $row['p_delivery_boxes']);
                    $p_delivery_cust = $row['p_delivery_cust'];
                  }
                  ?>
                  <input type="hidden" name="p_delivery_id" value="<?=$p_delivery_id; ?>">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                              Pre Delivery
                              <span class="label label-danger" style="font-size:14px;"><?=$p_delivery_id; ?></span>
                            </header>
                            <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label>Customer</label>
                                 <input class="form-control" value="<?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $p_delivery_cust, 'cust_name');?>" type="text" disabled="disabled">
                              </div>
                               <table class="table table-striped border-top">
                               <thead>                                                            <tr>
                                     <th>#</th>
                                     <th>Party Name</th>
                                     <th>Outer Box No</th>
                                     <th>Item</th>
                                     <th>Total Meters</th>
                                     <th>Total Net Weight</th>
                                     <th></th>
                                  </tr>
                               </thead>
                               <tbody>
                                  <?php
                                  $sno = 1;
                                  foreach ($p_delivery_boxes as $box_no) {
                                    $outerboxes = $this->m_masters->getmasterdetails('bud_te_outerboxes','box_no', $box_no);
                                    foreach ($outerboxes as $outerbox) {
                                       $inner_boxes = explode(",", $outerbox['packing_innerboxes']);
                                       $total_meters = 0;
                                       $total_net_weight = 0;
                                       foreach ($inner_boxes as $inner_box) {
                                         $total_meters += $this->m_masters->getmasterIDvalue('bud_te_innerboxes', 'box_no', $inner_box, 'packing_tot_mtr');
                                         $total_net_weight += $this->m_masters->getmasterIDvalue('bud_te_innerboxes', 'box_no', $inner_box, 'packing_net_weight');
                                       }
                                       ?>
                                       <tr>
                                          <td><?=$sno; ?></td>
                                          <td>
                                            <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $outerbox['packing_customer'], 'cust_name'); ?>
                                          </td>
                                          <td><?=$outerbox['box_no']; ?></td>
                                          <td>
                                            <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $outerbox['packing_innerbox_items'], 'item_name'); ?>
                                          </td>                                                                         <td>
                                            <?=$total_meters; ?>
                                            <input type="hidden" class="total_meters" value="<?=$total_meters; ?>">
                                          </td>
                                          <td>
                                            <?=$total_net_weight; ?>
                                            <input type="hidden" class="net_weight" value="<?=$total_net_weight; ?>">
                                          </td>
                                          <td>
                                            <input type="hidden" name="p_delivery_boxes[]" value="<?=$outerbox['box_no']; ?>">
                                            <a href="#" class="delete btn btn-danger btn-xs">Remove</a>
                                          </td>
                                       </tr>
                                       <?php
                                       $sno++;
                                    }
                                  }
                                  ?>
                               </tbody>
                               </table>
                            </div>
                        </section>
                     </div>

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Update</button>
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
    $(".delete").live('click', function(event) {
        $(this).parent().parent().remove();
        return false;
      });

      </script>
   </body>
</html>
