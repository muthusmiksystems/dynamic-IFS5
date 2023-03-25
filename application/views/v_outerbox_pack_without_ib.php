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
                           <h3><i class="icon-map-marker"></i> Out box packing without innerbox</h3>
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
               <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>production/outerbox_pack_without_ib_save">                            <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Packing Details
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="packing_date">Date</label>
                                 <input class="form-control dateplugin" id="packing_date" value="<?=date('d-m-Y');?>" name="packing_date" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="packing_item">Item</label>
                                 <select class="form-control select2" id="packing_item" name="packing_item" type="text">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                       ?>
                                       <option value="<?=$item['item_id'];?>"><?=$item['item_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="packing_rolls">No of Rolls</label>
                                 <input class="rolls form-control" id="packing_rolls" name="packing_rolls" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="packing_mtr_roll">Meter per Roll</label>
                                 <input class="rolls form-control" id="packing_mtr_roll" name="packing_mtr_roll" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="packing_tot_mtr">Total Meters</label>
                                 <input class="form-control" id="packing_tot_mtr" name="packing_tot_mtr" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="packing_gr_weight">Gross Weight</label>
                                 <input class="weight form-control" id="packing_gr_weight" name="packing_gr_weight" type="number">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="packing_box_weight">Box Weight</label>
                                 <input class="weight form-control" id="packing_box_weight" name="packing_box_weight" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="packing_pb_weight">Poly Bag Weight</label>
                                 <input class="weight form-control" id="packing_pb_weight" name="packing_pb_weight" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="packing_net_weight">Net Weight</label>
                                 <div class="form-group col-lg-12">
	                         <label for="po_date">Remarks : </label>                               
	                         <textarea name="remark" class="form-control" style="resize: vertical;" required="required"><?=$remark; ?></textarea>
                                 </div>
                                 <input class="form-control" id="packing_net_weight" name="packing_net_weight" type="text">
                              </div>
                             <div class="form-group">
                            <label for="packing_by">Packed by</label>
                            <select class="select2 form-control" data-placeholder="Select Operator" readonly="readonly" tabindex="11" name="packing_by" 
                            id="packing_by" required >                                                          <?php
     foreach ($staffs as $staff) {
     		if($this->session->userdata('display_name') == $staff['display_name'])
     		{
       ?>
       <option value="<?=$staff['ID']; ?>" <?=($staff['ID'] == $packing_by)?'selected="selected"':''; ?>><?=$staff['display_name']; ?></option>
       <?php
       }
     }
     ?>
   </select>
 </div>
                              <div class="form-group col-lg-3">
                                 <label for="packing_stock_room">Stock Room</label>
                                 <select class="select2 form-control" id="packing_stock_room" name="packing_stock_room">
                                    <option value="">Select Srock Room</option>
                                    <?php
                                    foreach ($stock_rooms as $stock_room) {
                                       ?>
                                       <option value="<?=$stock_room['stock_room_id']; ?>"><?=$stock_room['stock_room_name']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="packing_customer">Item</label>
                                 <select class="form-control select2" id="packing_customer" name="packing_customer">
                                    <option value="">Select Party Name</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>"><?=$customer['cust_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>                                                      <div class="clear"></div>
                           </div>
                        </section>
                     </div>                    

                     <div class="col-lg-12">
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
    $("input.rolls").live('keyup', function ()
      {
         $("#packing_tot_mtr").val($("#packing_rolls").val() * $("#packing_mtr_roll").val());
      });

      $("input.weight").live('keyup', function ()
      {
         var packing_gr_weight = $("#packing_gr_weight").val();
         var packing_box_weight = $("#packing_box_weight").val();
         var packing_pb_weight = $("#packing_pb_weight").val();
         $("#packing_net_weight").val(packing_gr_weight - (parseInt(packing_box_weight) + parseInt(packing_pb_weight)));
      });
      $("#packing_gr_weight").on('blur', function(evt) {
	   if ($(this).val().trim()) {
	     var txt = $(this).val().replace(/\s/g, '');
	     var n = parseFloat(txt, 10);
	     var formatted = n.toLocaleString('en', {
	        minimumFractionDigits: 3,
	       maximumFractionDigits: 3
	     }).replace(/,/g, ' ');
	     $(this).val(formatted);
	   }
	 });
      </script>
   </body>
</html>
