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
                           <h3><i class="icon-map-marker"></i> Outer Box Packing</h3>
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
               <?php
               foreach ($outerboxes as $outerbox) {
                  $packing_boxes = explode(",", $outerbox['packing_innerboxes']);
                  $packing_customer = $outerbox['packing_customer'];
                  $packing_date = $outerbox['packing_date'];
                  $packing_box_weight = $outerbox['packing_box_weight'];
                  $packing_no_boxes = $outerbox['packing_no_boxes'];
                  $packing_bag_weight = $outerbox['packing_bag_weight'];
                  $packing_no_bags = $outerbox['packing_no_bags'];
                  $packing_othr_wt = $outerbox['packing_othr_wt'];
               }
               $ed = explode("-", $packing_date);
               $packing_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
               ?>
               <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>production/outer_packing_update">
                  <input type="hidden" name="box_no" value="<?=$box_no; ?>">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Box No
                              <span class="label label-danger" style="font-size:14px;">M - <?=$box_no; ?></span>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="packing_date">Date</label>
                                 <input class="form-control dateplugin" id="packing_date" value="<?=$packing_date; ?>" name="packing_date" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="packing_customer">Party Name</label>
                                 <select class="form-control select2" id="packing_customer" name="packing_customer">
                                    <option value="">Select Party Name</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>" <?=($customer['cust_id'] == $packing_customer)?'selected="selected"':''; ?>><?=$customer['cust_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="packing_box_weight">Box Name</label>
                                <select class="weight form-control select2" id="packing_box_weight" name="packing_box_weight" tabindex="5">
                                   <option value="0">Select Box</option>
                                   <?php
                                   foreach ($tareweights as $tareweight) {
                                      ?>
                                      <option value="<?=$tareweight['tareweight_value']; ?>" <?=($tareweight['tareweight_value'] == $packing_box_weight)?'selected="selected"':''; ?>><?=$tareweight['tareweight_name']; ?></option>
                                      <?php
                                   }
                                   ?>
                                </select>
                             </div>
                             <div class="form-group col-lg-3">
                                <label for="packing_no_boxes">No of Box</label>
                                <input class="weight form-control" id="packing_no_boxes" name="packing_no_boxes" tabindex="6" value="<?=$packing_no_boxes; ?>" type="text">
                             </div>
                             <div class="form-group col-lg-3">
                                <label for="packing_bag_weight">Poly Bag</label>
                                <select class="weight form-control select2" id="packing_bag_weight" tabindex="7" name="packing_bag_weight">
                                   <option value="0">Select Box</option>
                                   <?php
                                   foreach ($tareweights as $tareweight) {
                                      ?>
                                      <option value="<?=$tareweight['tareweight_value']; ?>" <?=($tareweight['tareweight_value'] == $packing_bag_weight)?'selected="selected"':''; ?>><?=$tareweight['tareweight_name']; ?></option>
                                      <?php
                                   }
                                   ?>
                                </select>
                             </div>
                             <div class="form-group col-lg-3">
                                <label for="packing_no_bags">No of Bags</label>
                                <input class="weight form-control" id="packing_no_bags" tabindex="8" name="packing_no_bags" value="<?=$packing_no_bags; ?>" type="text">
                             </div>
                             <div class="form-group col-lg-3">
                                <label for="packing_othr_wt">Other Merial Weight</label>
                                <input class="weight form-control" id="packing_othr_wt" tabindex="9" name="packing_othr_wt" type="text" value="<?=$packing_othr_wt; ?>">
                             </div>                                                </div>
                        </section>
                     </div>                                  <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Inner Boxes
                            </header>
                            <div class="panel-body" id="innerboxdata">                                                    <table class="table table-striped border-top">
                               <thead>
                                  <tr>
                                     <th>Sno</th>
                                     <th>Party Name</th>
                                     <th>Inner Box No</th>
                                     <th>Item Code</th>
                                     <th>Item Name</th>
                                     <th>Qty in Meter</th>
                                     <th>Net Weight</th>
                                     <th>Select</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  <?php
                                  $sno = 1;
                                  foreach ($packing_boxes as $packing_box) {
                                    $innerboxes = $this->m_masters->getmasterdetails('bud_te_innerboxes','box_no', $packing_box);
                                    foreach ($innerboxes as $innerbox) {
                                       ?>
                                       <tr>
                                          <td><?=$sno; ?></td>
                                          <td>
                                             <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $innerbox['packing_cust'], 'cust_name'); ?>
                                          </td>
                                          <td>I-<?=$innerbox['box_no']; ?></td>
                                          <td><?=$innerbox['packing_item']; ?></td>
                                          <td>
                                             <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $innerbox['packing_item'], 'item_name'); ?>
                                          </td>
                                          <td><?=$innerbox['packing_tot_mtr']; ?></td>
                                          <td><?=$innerbox['packing_net_weight']; ?></td>
                                          <td>
                                             <input type="hidden" name="inner_boxes[]" value="<?=$innerbox['box_no']; ?>">
                                             <a href="#" data-placement="top" data-original-title="Remove" data-toggle="tooltip" class="delete btn btn-danger btn-xs tooltips">Remove</a>
                                          </td>
                                       </tr>
                                       <?php
                                       $sno++;
                                    }                                                              }
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
                     </div>                               </div>
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
