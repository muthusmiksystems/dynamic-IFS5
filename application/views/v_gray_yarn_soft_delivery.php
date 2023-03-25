<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="Mosaddek">
   <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
   <link rel="shortcut icon" href="img/favicon.html">

   <title> | INDOFILA SYNTHETICS</title>

   <!-- Bootstrap core CSS -->
   <?php
   foreach ($css as $path) {
   ?>
      <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
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
                        <h3><i class=" icon-truck"></i> Gray Yarn Soft Delivery</h3>
                     </header>
                  </section>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <?php
                  if ($this->session->flashdata('warning')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-warning fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  if ($this->session->flashdata('error')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-block alert-danger fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  if ($this->session->flashdata('success')) {
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
                              <p><?= $this->session->flashdata('success'); ?></p>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  ?>
               </div>
            </div>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url('delivery/gray_yarn_soft_delivery/' . $delivery_id); ?>">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Delivery No
                           <span class="label label-danger" style="font-size:14px;"><?= $dc_no; ?></span>
                        </header>
                        <div class="panel-body">
                           <div class="form-group col-lg-2">
                              <label for="from_date">From</label>
                              <input class="dateplugin form-control" id="from_date" name="from_date" value="<?= $from_date; ?>" type="text" required>
                           </div>
                           <div class="form-group col-lg-2">
                              <label for="to_date">To</label>
                              <input class="dateplugin form-control" id="to_date" name="to_date" value="<?= $to_date; ?>" type="text" required>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="item_name">Item Name</label>
                              <select class="get_outerboxes form-control select2" id="item_id" name="item_id">
                                 <option value="">Select Item</option>
                                 <?php
                                 foreach ($items as $row) {
                                 ?>
                                    <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_name']; ?></option>
                                 <?php
                                 }
                                 ?>

                              </select>
                           </div>
                           <div class="form-group col-lg-2">
                              <label for="item_code">Item Code</label>
                              <select class="get_outerboxes form-control select2" id="item_code">
                                 <option value="">Select Item</option>
                                 <?php
                                 foreach ($items as $row) {
                                 ?>
                                    <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_id']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <!--//ER-08-18#-44-->
                           <div class="form-group col-lg-2">
                              <label for="box_prefix">Box Type</label>
                              <select class="box_prefix form-control select2" id="box_prefix" name="box_prefix">
                                 <option value="S">Soft Packing</option>
                                 <option value="DIR" <?= ($box_prefix == 'DIR') ? 'selected="selected"' : ''; ?>>Direct Packing</option>
                                 <option value="D" <?= ($box_prefix == 'D') ? 'selected="selected"' : ''; ?>>Dyed Packing</option>
                                 <option value="TH" <?= ($box_prefix == 'TH') ? 'selected="selected"' : ''; ?>>Thread Packing</option>
                                 <option value="TI" <?= ($box_prefix == 'TI') ? 'selected="selected"' : ''; ?>>Thread Inner Packing</option>
                                 <option value="G" <?= ($box_prefix == 'G') ? 'selected="selected"' : ''; ?>>Gray Yarn Packing</option>
                              </select>
                           </div>
                           <!--//ER-08-18#-44-->
                           <div style="clear:both"></div>
                           <div class="form-group col-lg-3">
                              <button class="btn btn-danger" type="submit" name="search" value="search">Search</button>
                           </div>
                        </div>
                     </section>
                  </div>
               </div>

               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <div class="panel-body">
                           <table class="table table-striped border-top" id="FIRST">
                              <thead>
                                 <tr>
                                    <th>Sno.</th>
                                    <th>Date</th>
                                    <th>Box No</th>
                                    <th>Item Name</th>
                                    <th>Yarn Dn</th>
                                    <th>Chandren Yarn Lot No/ID</th>
                                    <th>Shade Name/Code</th>
                                    <th>Shade No</th>
                                    <th>POY Lot No</th>
                                    <th>Lot Wastage</th>
                                    <th># Springs</th>
                                    <th>Gr.Weight</th>
                                    <th>Net Weight</th>
                                    <th>
                                       <!-- <label class="checkbox-inline">
                                      <input type="checkbox" id="selecctall">
                                      <b>Select All</b>
                                      </label> -->
                                       Action
                                    </th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 /*echo "<pre>";
                                 print_r($boxes);
                                 echo "</pre>";*/
                                 $sno = 1;
                                 foreach ($boxes as $row) {
                                    $box_id = $row['box_id'];
                                    $no_springs = $row['no_of_cones'] + $row['no_of_cones_2'];

                                    $v = $row['yarn_lot_id'];
                                    $current = current(array_filter($yarn_lots, function ($e) use ($v) {
                                       return $e->yarn_lot_id == $v;
                                    }));
                                    $yarn_lot_no = @$current->yarn_lot_no . '/' . $v;
                                 ?>
                                    <tr>
                                       <td><?= $sno; ?></td>
                                       <td><?= $row['packed_date']; ?></td>
                                       <td><?= $row['box_prefix'] . $row['box_no']; //ER-08-18#-44 
                                             ?></td>
                                       <td><?= $row['item_name']; ?>/<?= $row['item_id']; ?></td>
                                       <td><?= $row['denier_tech']; ?></td>
                                       <td><?= $yarn_lot_no; ?></td>
                                       <td><?= $row['shade_name']; ?>/<?= $row['shade_id']; ?></td>
                                       <td><?= $row['shade_code']; ?></td>
                                       <td><?= ($row['poy_inward_prefix']) ? substr($row['poy_lot_name'], 0) : ''; ?></td>
                                       <td><?= $row['lot_wastage']; ?></td>
                                       <td><?= $no_springs; ?></td>
                                       <td><?= $row['gross_weight']; ?></td>
                                       <td><?= number_format($row['net_weight'], 3); //ER-07-18#-15//ER-08-18#-46 
                                             ?></td>
                                       <td>
                                          <input type="hidden" class="selected_springs" value="<?= $row['spring_weight']; ?>">
                                          <input type="hidden" class="selected_gross_wt" id="mtr_<?= $box_id; ?>" value="<?= $row['gross_weight']; ?>">
                                          <input type="hidden" class="selected_net_wt" id="wt_<?= $box_id; ?>" value="<?= $row['net_weight']; ?>">
                                          <input type="hidden" name="outer_boxes[]" value="<?= $box_id; ?>">
                                          <a href="#" class="btn btn-xs btn-primary">Add</a>
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

                     <section class="panel">
                        <header class="panel-heading">
                           <button class="btn btn-danger" type="button" id="addtolist">Add to List</button>
                        </header>
                     </section>
                  </div>
               </div>
            </form>

            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url('delivery/gray_yarn_soft_delivery/' . $delivery_id); ?>">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Selected Boxes
                           <div style="clear:both;"></div>
                           <div class="form-group col-lg-3">
                              <label for="from_concern">From Concern</label>
                              <!--ER-07-18#-15-->
                              <select class="form-control select2" name="from_concern">
                                 <option value="">Select Concern</option>
                                 <?php
                                 foreach ($concerns as $row) {
                                 ?>
                                    <option value="<?= $row['concern_id']; ?>" <?= ($row['concern_name'] == $from_concern) ? 'selected="selected"' : ''; ?>><?= $row['concern_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                              <!--ER-07-18#-15-->
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="to_concern">To Concern</label>
                              <!--ER-07-18#-15-->
                              <select class="form-control select2" name="to_concern">
                                 <option value="">Select Item</option>
                                 <?php
                                 foreach ($concerns as $row) {
                                 ?>
                                    <option value="<?= $row['concern_id']; ?>" <?= ($row['concern_name'] == $to_concern) ? 'selected="selected"' : ''; ?>><?= $row['concern_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                              <!--ER-07-18#-15-->
                           </div>
                           <div class="form-group col-lg-6">
                              <label for="remarks">Remarks</label>
                              <textarea class="form-control" id="remarks" name="remarks" value="<?= $remarks; ?>"></textarea>
                           </div>
                        </header>
                        <div class="panel-body" id="selected_items">
                           <table class="table table-striped border-top" id="SECOND">
                              <thead>
                                 <tr>
                                    <th colspan="2"></th>
                                    <th id="tot_boxes">0</th>
                                    <th colspan="6"></th>
                                    <th id="tot_springs">0</th>
                                    <th id="tot_gross_wt">0.000</th>
                                    <th id="tot_net_wt">0.000</th>
                                    <th></th>
                                 </tr>
                                 <tr>
                                    <th>Sno</th>
                                    <th>Date</th>
                                    <th>Box No</th>
                                    <th>Item Name/Code</th>
                                    <th>Yarn Dn</th>
                                    <th>Shade Name/Code</th>
                                    <th>Shade No</th>
                                    <th>POY Lot</th>
                                    <th>Lot Wastage</th>
                                    <th># Springs</th>
                                    <th>Gr.Weight</th>
                                    <th>Net Weight</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 if (is_array($outer_boxes) && count($outer_boxes) > 0) {
                                    foreach ($outer_boxes as $box_id) {
                                       $box = $this->m_delivery->soft_delivery_item_details($box_id);
                                       if ($box) {
                                 ?>
                                          <tr>
                                             <td><?= $sno; ?></td>
                                             <td><?= $box->packed_date; ?></td>
                                             <td><?= $box_prefix . $box->box_no; //ER-08-18#-46
                                                   ?></td>
                                             <td><?= $box->item_name; ?>/<?= $box->item_id; ?></td>
                                             <td><?= $box->denier_tech; ?></td>
                                             <td><?= $box->shade_name; ?>/<?= $box->shade_id; ?></td>
                                             <td><?= $box->shade_code; ?></td>
                                             <td><?= ($box->poy_inward_prefix) ? substr($box->poy_lot_name, -4) : ''; ?></td>
                                             <td><?= $box->lot_wastage; ?></td>
                                             <td><?= $box->spring_weight; ?></td>
                                             <td><?= $box->gross_weight; ?></td>
                                             <td><?= number_format($box->net_weight, 3); //ER-08-18#-46 
                                                   ?></td>
                                             <td>
                                                <input type="hidden" class="selected_springs" value="<?= $box->spring_weight; ?>">
                                                <input type="hidden" class="selected_gross_wt" id="mtr_<?= $box_id; ?>" value="<?= $box->gross_weight; ?>">
                                                <input type="hidden" class="selected_net_wt" id="wt_<?= $box_id; ?>" value="<?= $box->net_weight; ?>">
                                                <input type="hidden" name="outer_boxes[]" value="<?= $box_id; ?>">
                                                <a class="btn btn-xs btn-danger">Remove</a>
                                             </td>
                                          </tr>
                                 <?php
                                       }
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
                           <button class="btn btn-danger" type="submit" name="save_as_del" value="save_as_del">Save as Delivery</button>
                        </header>
                     </section>
                  </div>
               </div>
            </form>

            <!-- page end-->
         </section>

         <section class="panel">
            <header class="panel-heading">
               Gray Yarn Soft Delivery
            </header>
            <div class="panel-body">
               <table class="table table-striped border-top" id="sample_1">
                  <thead>
                     <tr>
                        <th>S.No</th>
                        <th>DC No</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Remarks</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $sno = 1;
                     foreach ($deliveries as $row) {
                        $to_concern = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $row->to_concern, 'concern_name'); //ER-08-18#-46
                        $from_concern = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $row->from_concern, 'concern_name'); //ER-08-18#-46
                     ?>
                        <tr>
                           <td><?= $sno; ?></td>
                           <td>S <?= $row->delivery_id; ?></td>
                           <td><?= ($from_concern) ? $from_concern : $row->from_concern; //ER-08-18#-46 
                                 ?></td>
                           <td><?= ($to_concern) ? $to_concern : $row->to_concern; //ER-08-18#-46 
                                 ?></td>
                           <td><?= date("d-m-Y H:i:d", strtotime($row->delivery_date)); ?></td>
                           <td><?= $row->remarks; ?></td>
                           <td>
                              <a href="<?= base_url('delivery/gray_yarn_soft_dc/' . $row->delivery_id); ?>" class="btn btn-xs btn-warning" title="Print" target="_blank">Print</a>
                              <a href="<?= base_url('delivery/gray_yarn_soft_delivery/' . $row->delivery_id); ?>" class="btn btn-xs btn-primary" title="Edit">Edit</a>
                              <a href="<?= base_url('delivery/gray_yarn_soft_delivery/' . $row->delivery_id); ?>" class="btn btn-xs btn-danger" title="Delete">Delete</a>
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
      </section>
      <!--main content end-->
   </section>

   <div class="pageloader"></div>

   <!-- js placed at the end of the document so the pages load faster -->
   <?php
   foreach ($js as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <!--common script for all pages-->
   <?php
   foreach ($js_common as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <!--script for this page-->
   <?php
   foreach ($js_thispage as $path) {
   ?>
      <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
   <?php
   }
   ?>

   <script>
      //owl carousel
      $(document).ready(function() {
         $("#owl-demo").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true

         });
      });

      //custom select box
      $(function() {
         $('select.styled').customSelect();
      });

      $(document).ajaxStart(function() {
         $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
         $('.pageloader').hide();
      });

      net_weights_arr = $(".net_weight");
      total_meters_arr = $(".total_meters");

      $('#selecctall').click(function(event) { //on click
         var no_boxes = 0;
         var net_weight = 0;
         var total_meters = 0;
         if (this.checked) { // check select status
            $('.checkbox').each(function() { //loop through each checkbox
               this.checked = true;
               var selected = $(this).val();
               net_weight += parseFloat($("#wt_" + selected).val());
               total_meters += parseFloat($("#mtr_" + selected).val());
               no_boxes++;
               $("#no_boxes").text(no_boxes + " Boxes");
               $("#total_meters").text(total_meters.toFixed(3));
               $("#net_weight").text(net_weight.toFixed(3));
            });
         } else {
            $('.checkbox').each(function() { //loop through each checkbox
               this.checked = false; //deselect all checkboxes with class "checkbox1"
               $("#no_boxes").text(0 + " Boxes");
               $("#total_meters").text("0");
               $("#net_weight").text("0");
            });
         }
      });

      $(".checkbox").click(function() {
         var no_boxes = 0;
         var net_weight = 0;
         var total_meters = 0;
         $('.checkbox').each(function() {
            if (this.checked) {
               var selected = $(this).val();
               net_weight += parseFloat($("#wt_" + selected).val());
               total_meters += parseFloat($("#mtr_" + selected).val());
               no_boxes++;
            }
         });
         $("#no_boxes").text(no_boxes + " Boxes");
         $("#total_meters").text(total_meters.toFixed(3));
         $("#net_weight").text(net_weight.toFixed(3));
      });

      var sum_gross_wt = 0;
      $("#SECOND .selected_gross_wt").each(function() {
         sum_gross_wt += +$(this).val();
      });
      $("#tot_gross_wt").text(sum_gross_wt.toFixed(3));

      var tot_net_wt = 0;
      $("#SECOND .selected_net_wt").each(function() {
         tot_net_wt += +$(this).val();
      });

      var tot_springs = 0;
      $("#SECOND .selected_springs").each(function() {
         tot_springs += +$(this).val();
      });
      $("#tot_springs").text(tot_springs);

      $("#tot_boxes").text($('#SECOND tbody tr').length);

      $(function() {
         function moveRow(row, targetTable, newLinkText) {
            $(row)
               .appendTo(targetTable)
               .find("A")
               .text(newLinkText);

            var sum_gross_wt = 0;
            $("#SECOND .selected_gross_wt").each(function() {
               sum_gross_wt += +$(this).val();
            });
            $("#tot_gross_wt").text(sum_gross_wt.toFixed(3));

            var tot_net_wt = 0;
            $("#SECOND .selected_net_wt").each(function() {
               tot_net_wt += +$(this).val();
            });
            $("#tot_net_wt").text(tot_net_wt.toFixed(3));

            var tot_springs = 0;
            $("#SECOND .selected_springs").each(function() {
               tot_springs += +$(this).val();
            });
            $("#tot_springs").text(tot_springs);

            $("#tot_boxes").text($('#SECOND tbody tr').length);

         }

         $("#FIRST A").live("click", function() {
            moveRow($(this).parents("tr"), $("#SECOND"), "Remove");
            return false;
         });

         $("#SECOND A").live("click", function() {
            moveRow($(this).parents("tr"), $("#FIRST"), "Add");
            return false;
         });
      });

      $(".get_outerboxes").change(function() {
         $("#item_id").select2("val", $(this).val());
         $("#item_code").select2("val", $(this).val());
         return false;
      });
   </script>
</body>

</html>