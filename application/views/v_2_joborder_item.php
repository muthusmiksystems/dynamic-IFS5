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
                                        <th>Date</th>
                                        <th>PO. No</th>
                                        <th>Customer</th>
                                        <th>Art No</th>
                                        <th>Item Name</th>
                                        <th>Po Qty</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $newArray = array();
                                       foreach ($p_orders as $p_order) {
                                          $newArray[$p_order['order_customer']][] = $p_order['order_id'];
                                       }
                                       $sno = 1;
                                       foreach ($newArray as $key => $value) {
                                          $print_sno = false;
                                          $print_cust = false;
                                          $total_Qty = 0;
                                          foreach ($value as $key1 => $value1) {
                                             $podetails = $this->m_masters->getmasterdetails('bud_te_purchaseorders', 'order_id', $value1);
                                             foreach ($podetails as $podetail) {
                                                $order_id = $podetail['order_id'];
                                                $order_date = $podetail['order_date'];
                                                $order_enq_id = $podetail['order_enq_id'];
                                                $order_customer = $podetail['order_customer'];
                                                $items = $this->m_masters->getmasterdetails('bud_te_enq_items', 'enq_id', $order_enq_id);
                                             }
                                             $cust_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $order_customer, 'cust_name');
                                             foreach ($items as $item) {
                                                $total_Qty += $item['enq_req_qty'];
                                                $item_name = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item['enq_item'], 'item_name');
                                                $uom = $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_item_uom'], 'uom_name');
                                                ?>
                                                <tr>
                                                   <td><?=$sno?></td>
                                                   <td><?=$order_date; ?></td>
                                                   <td><?=$value1; ?></td>
                                                   <td><?=$cust_name; ?></td>
                                                   <td><?=$item['enq_item']; ?></td>
                                                   <td><?=$item_name; ?></td>
                                                   <td><strong><?=$item['enq_req_qty']; ?></strong></td>
                                                   <td>
                                                      <?php
                                                      if($item['jobcard_status'] == 0)
                                                      {
                                                         ?>
                                                         <label class="btn btn-danger btn-xs">Job Card Generated</label>
                                                         <?php
                                                      }
                                                      else
                                                      {
                                                         ?>
                                                         <a href="<?=base_url(); ?>production/create_jobcard_cust_2/<?=$item['enq_item_id']; ?>/<?=$order_id; ?>" data-placement="top" data-original-title="Create Job Card" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Create Job Card</a>
                                                         <?php
                                                      }
                                                      ?>
                                                      <!-- <a href="#" data-placement="top" data-original-title="Hold Job Card" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips">Hold Job Card</a>
                                                      <a href="#" data-placement="top" data-original-title="Cancel Job Card" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips">Cancel Job Card</a> -->
                                                   </td>
                                                </tr>
                                                <?php                                                                                     }
                                          }
                                          ?>
                                          <tr>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td><strong>Total</strong></td>
                                             <td><strong><?=$total_Qty; ?></strong></td>
                                             <td></td>
                                          </tr>
                                          <?php
                                          $sno ++;
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
