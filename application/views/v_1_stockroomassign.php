<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="Mosaddek">
   <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
   <link rel="shortcut icon" href="img/favicon.html">

   <title><?= $page_title; ?> | INDOFILA SYNTHETICS</title>

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
         <section class="wrapper sh_delivery">
            <!-- page start-->
            <div class="row">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        <h3><i class=" icon-truck"></i> Stock Room Box Assign</h3>
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

            <div class="row">
               <div class="col-lg-12">
                  <section class="panel">
                     <div class="panel-body">
                        <div class="responsive">
                           <script>
                              var data = [];
                           </script>
                           <table class="table table-bordered packing-boxes" id="predelivery_boxes">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Box No</th>
                                    <th>Item</th>
                                    <th>Item Code</th>
                                    <th>Gr.Weight</th>
                                    <th>Nt.Weight</th>
                                    <th>Temp Stock Room</th>
                                    <th>
                                       <label class="checkbox-inline">
                                          <input type="checkbox" id="selectall">
                                          <b>Select All</b>
                                       </label>
                                    </th>
                                 </tr>
                              </thead>
                              <?php
                              $sno = 1;
                              foreach ($d_outerboxes as $row) {

                                 if ($row['rack_id'] != '') {
                                    continue;
                                 }

                                 $no_of_cones = $row['no_of_cones'];
                                 $inner_boxes = json_decode($row['inner_boxes']);

                                 $box_no = $row['box_prefix'] . $row['box_no'];

                                 if (sizeof($inner_boxes) > 0) :
                                    $item_names = array();
                                    $item_codes = array();
                                    foreach ($inner_boxes as $inner_box_id => $inner_box) {
                                       $i_box = $this->ak->thread_inner_box_details($inner_box_id);
                                       if ($i_box) {
                                          $item_names[$i_box->item_id] = $i_box->item_name;
                                          $item_codes[] = $i_box->no_of_cones;
                                       }
                                       $no_of_cones = array_sum($item_codes);
                                    }
                                    $item_names = implode(",", $item_names);
                                    $item_codes = implode(",", $item_codes);
                                 else :
                                    $item_names = $row['item_name'];
                                    $item_codes = $row['item_id'];
                                 endif;

                                 $gross_weight = number_format((float) $row['gross_weight'], 3, '.', '') . '<input type="hidden" class="grant_wt" id="mtr_' . $row['b_id'] . '" value="' . $row['gross_weight'] . '">';
                                 $net_weight = number_format((float) $row['net_weight'], 3, '.', '') . '<input type="hidden" class="net_weight" id="wt_' . $row['b_id'] . '" value="' . $row['net_weight'] . '" style="width: 20px;">';
                                 $stock_room_name = $row['stock_room_name'];

                                 $statusfinal = '<input type="checkbox" name="outer_boxes[]" class="checkbox" value="' . $row['b_id'] . '">';

                                 $statusall = $statusfinal; ?>
                                 <script>
                                    data.push([
                                       '<?= $sno; ?>',
                                       '<?= $box_no; ?>',
                                       '<?= $item_names; ?>',
                                       '<?= $item_codes; ?>',
                                       '<?= $gross_weight; ?>',
                                       '<?= $net_weight; ?>',
                                       '<?= $stock_room_name; ?>',
                                       '<?= $statusall; ?>'
                                    ]);
                                 </script>
                              <?php
                                 $sno++;
                              }
                              ?>
                           </table>
                        </div>
                     </div>
                  </section>
               </div>
            </div>

            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/stockroomassign_save">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Selected Boxes
                           <div style="clear:both;"></div>

                        </header>
                        <div class="panel-body">

                           <input type="hidden" value="" name="boxes" class="boxes" />

                           <input type="hidden" value="" name="building" class="building" />
                           <input type="hidden" value="" name="block" class="block" />
                           <input type="hidden" value="" name="rack" class="rack" />

                           <div class="form-group col-lg-3">
                              <label for="concern_name">Building</label>
                              <select class="form-control select2" name="building_name" id="building_name">
                                 <option value="">Select Building</option>
                                 <?php if (sizeof($stock_rooms) > 0) : ?>
                                    <?php foreach ($stock_rooms as $row) : ?>
                                       <option value="<?php echo $row['id']; ?>"><?php echo $row['building_name']; ?> - <?= $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $row['concern_id'], 'concern_name'); ?></option>
                                    <?php endforeach ?>
                                 <?php endif; ?>
                              </select>
                           </div>

                           <div class="form-group col-lg-3">
                              <label for="concern_name">Block</label>
                              <select class="form-control select2" name="block_name" id="block_name">
                                 <option value="">Select Block</option>
                              </select>
                           </div>

                           <div class="form-group col-lg-3">
                              <label for="concern_name">Rack</label>
                              <select class="form-control select2" name="rack_name" id="rack_name">
                                 <option value="">Select Rack</option>
                              </select>
                           </div>

                           <div class="form-group col-lg-3">
                              <label for="concern_name">Rack Count</label>
                              <div><span id="rack_count"><span id="rack_count_total">0</span>-<span id="rack_count_used">0</span>=<span id="rack_count_pending">0</span>-</span><span id="rack_count_box">0</span></div>
                           </div>

                        </div>
                     </section>
                  </div>

                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <button class="btn btn-danger saveroomtobox" type="submit" name="save">Save</button>
                        </header>
                     </section>
                  </div>
               </div>
            </form>

            <!-- page end-->
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
      $(document).ready(function() {

         $('#predelivery_boxes').DataTable({
            'data': data,
            'deferRender': true,
            'processing': true,
            'language': {
               'loadingRecords': '&nbsp;',
               'processing': 'Loading...'
            },
            "order": [
               [0, "desc"]
            ],
            'columnDefs': [{
               'targets': 5,
               'className': 'text-danger'
            }]
         });

         jQuery('.dataTables_filter input').addClass("form-control");
         jQuery('.dataTables_filter').parent().addClass('col-sm-6');
         jQuery('.dataTables_length select').addClass("form-control");
         jQuery('.dataTables_length').parent().addClass('col-sm-6');

      });
   </script>

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

      var rc = '<span id="rack_count_total">0</span>-<span id="rack_count_used">0</span>=<span id="rack_count_pending">0</span>-';

      $(document).on("change", '#building_name', function() {
         var id = $(this).val();
         var name = $('#building_name option:selected').html();
         $(".building").val(name);

         $("#block_name").select2('destroy');
         $("#block_name").html('<option value="">Select Block</option>');
         $("#block_name").select2();

         $("#rack_name").select2('destroy');
         $("#rack_name").html('<option value="">Select Rack</option>');
         $("#rack_name").select2();

         $("#rack_count").html(rc);

         $.ajax({
            type: "POST",
            url: "<?php echo base_url('masters/get_block_list'); ?>",
            data: {
               id: id
            },
            success: function(data) {
               $("#block_name").select2('destroy');
               $("#block_name").html(data);
               $("#block_name").select2();
            }
         });
      });

      $(document).on("change", '#block_name', function() {
         var id = $(this).val();
         var name = $('#block_name option:selected').html();
         $(".block").val(name);

         $("#rack_name").select2('destroy');
         $("#rack_name").html('<option value="">Select Rack</option>');
         $("#rack_name").select2();

         $("#rack_count").html(rc);

         $.ajax({
            type: "POST",
            url: "<?php echo base_url('masters/get_rack_list'); ?>",
            data: {
               id: id
            },
            success: function(data) {
               $("#rack_name").select2('destroy');
               $("#rack_name").html(data);
               $("#rack_name").select2();
            }
         });
      });

      $(document).on("change", '#rack_name', function() {
         var id = $(this).val();
         var name = $('#rack_name option:selected').html();
         $(".rack").val(name);

         $("#rack_count").html(rc);

         $.ajax({
            type: "POST",
            url: "<?php echo base_url('masters/get_rack_count'); ?>",
            data: {
               id: id
            },
            success: function(data) {
               $("#rack_count").html(data);
            }
         });
      });

      $(document).on('click', '#selectall', function(e) {
         if (this.checked) {
            $('tbody .checkbox:not(:checked)').trigger('click');
         } else {
            $('tbody .checkbox:checked').trigger('click');
         }
         $("#rack_count_box").html($('.checkbox:checked').length);

         var boxes = [];
         $('.checkbox:checked').each(function(i, e) {
            boxes.push(e.value);
         });
         boxes = boxes.join(',');

         $(".boxes").val(boxes);
         e.stopPropagation();
      });

      $(document).on('click', ".checkbox", function(e) {
         $("#rack_count_box").html($('.checkbox:checked').length);
         //$('#selectall:checked').prop('checked', false);

         var boxes = [];
         $('.checkbox:checked').each(function(i, e) {
            boxes.push(e.value);
         });
         boxes = boxes.join(',');

         $(".boxes").val(boxes);
         e.stopPropagation();
      });

      $(document).on('click', '.saveroomtobox', function(e) {
         var rcp = $("#rack_count_pending").html();
         var rcb = $("#rack_count_box").html();
         if (rcb == 0) {
            e.preventDefault();
            alert('Box no selected!...');
         }
         if (rcb > rcp) {
            e.preventDefault();
            alert('Box overloaded!...');
         }
      });
   </script>
</body>

</html>