<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="Legrand charles">
   <meta name="keyword" content="">
   <link rel="shortcut icon" href="img/favicon.html">

   <title><?= $page_title; ?> | INDOFILA SYNTHETICS</title>

   <!-- Bootstrap core CSS -->
   <?php
   foreach ($css as $path) {
   ?>
      <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
   <?php
   }
   foreach ($css_print as $path) {
   ?>
      <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet" media="print">
   <?php
   }
   ?>
   
   
      
      
   <style type="text/css">
      @media print {
         @page {
            margin: 3mm;
         }

         .table thead>tr>th,
         .table tbody>tr>th,
         .table tfoot>tr>th,
         .table thead>tr>td,
         .table tbody>tr>td,
         .table tfoot>tr>td {
            padding: 1 !important;
            font-size: 12px !important;
            line-height: 1 !important;
         }

         .boxes {
            font-size: 18px !important;
         }

         .packing-register th {
            border: 1px solid #000 !important;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
         }

         .packing-register td {
            border: 1px solid #000 !important;
         }

         .dataTables_filter {
            display: none;
         }

         .screen_only {
            display: none;
         }
      }

      td.item-name {
         width: 300px;
      }
   </style>
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
            <div class="row screen-only">
               <div class="col-lg-12">
                  <section class="panel">
                     <header class="panel-heading">
                        <h3><i class=" icon-file"></i> Stock Register (Stock Room Wise)</h3>
                     </header>
                  </section>
               </div>
            </div>
            <div class="row screen-only">
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
            <?php
            $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
            $items = $this->m_masters->getactivemaster('bud_items', 'item_status');
            ?>
            <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?= base_url() ?>reports/stock_register_storeroom_wise_1">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Stock Register (Stock Room Wise)
                        </header>
                        <div class="panel-body">
                           <div class="form-group col-lg-3">
                              <label for="from_date">From</label>
                              <input type="text" value="<?= $f_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="to_date">To</label>
                              <input type="text" value="<?= $t_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
                           </div>
                           <!-- <div class="form-group col-lg-3">
                                 <label for="customer_name">Customer Name</label>
                                 <select class="get_item_detail form-control select2" id="customer_name" name="customer_name">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                    ?>
                                      <option value="<?= $row['cust_id']; ?>" <?= ($row['cust_id'] == $customer) ? 'selected="selected"' : ''; ?>><?= $row['cust_name']; ?></option>
                                      <?php
                                    }
                                       ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="customer_id">Customer Code</label>
                                 <select class="get_item_detail form-control select2" id="customer_id" name="customer_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                    ?>
                                      <option value="<?= $row['cust_id']; ?>" <?= ($row['cust_id'] == $customer) ? 'selected="selected"' : ''; ?>><?= $row['cust_id']; ?></option>
                                      <?php
                                    }
                                       ?>
                                 </select>
                              </div> -->

                           <div class="form-group col-lg-3">
                              <label for="item_id">Item Name</label>
                              <select class="form-control select2 item" id="item_id" name="item_id">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($items as $row) {
                                 ?>
                                    <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="item_id">Item Code</label>
                              <select class="form-control select2 item" id="item_name">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($items as $row) {
                                 ?>
                                    <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_id']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="lot_no">Lot No </label>
                              <select class="form-control select2 " id="lot_no" name="lot_no">
                                 <option value="">Select</option>
                                 <?php

                                 foreach ($lot_no as $lot) {

                                 ?>
                                    <option value="<?= $lot['lot_no']; ?>" <?= ($lot['lot_no'] == $lot_number) ? 'selected="selected"' : ''; ?>><?= $lot['lot_no']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="color_name">Color Name </label>
                              <select class="form-control select2 color" id="color_name">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($colors as $row) {
                                 ?>
                                    <option value="<?= $row['shade_id']; ?>" <?= ($row['shade_id'] == $shade_id) ? 'selected="selected"' : ''; ?>><?= $row['shade_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="color_code">Color Code</label>
                              <select class="form-control select2 color" id="color_code" name="color_code">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($colors as $row) {
                                 ?>
                                    <option value="<?= $row['shade_id']; ?>" <?= ($row['shade_id'] == $shade_id) ? 'selected="selected"' : ''; ?>><?= $row['shade_code']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="color_code">Stock Room </label>
                              <select class="form-control select2" id="rno" name="rno">
                                 <option value="">Select</option>
                                 <?php
                                 foreach ($room_no as $row) {
                                 ?>
                                    <option value="<?= $row['stock_room_id']; ?>" <?= ($row['stock_room_id'] == $room_id) ? 'selected="selected"' : ''; ?>><?= $row['stock_room_name']; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="form-group col-lg-3">
                              <label for="color_code">Stock Status</label>
                              <select class="form-control select2" id="status" name="status">
                                 <option value="">Select</option>
                                 <option value='1' <?= ($status == 1) ? 'selected' : ''; ?>>In Stock</option>
                                 <option value='2' <?= ($status == 2) ? 'selected' : ''; ?>>In Transit</option>
                                 <option value='3' <?= ($status == 3) ? 'selected' : ''; ?>>Reserved</option>
                                 <option value='4' <?= ($status == 4) ? 'selected' : ''; ?>>Delivered</option>
                              </select>
                           </div>
                           <div style="clear:both;"></div>
                           <div class="form-group col-lg-3">
                              <label>&nbsp;</label>
                              <button class="btn btn-danger btn-danger2" type="submit" name="search">Search</button>
                           </div>
                        </div>
                     </section>
                  </div>
               </div>
            </form>

            <?php
            $gr_total_boxes = 0;
            $gr_gross_weight = 0;
            $gr_net_weight = 0;
            foreach ($cust_pack_register as $stock_room_id => $outerboxes) {
               foreach ($outerboxes as $key => $row) {
                  $gr_net_weight += $row->net_weight;
                  $gr_gross_weight += $row->gross_weight;
                  $gr_total_boxes++;
               }
            }
            ?>
            <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->
                  <section class="panel">
                     <header class="panel-heading">
                        Summary
                     </header>
                     <div class="panel-body">
                        <?php
                        $i = 0;
                        $total_boxes_array = array();
                        $tot_gr_weight_array = array();
                        $tot_weight_array = array();
                        foreach ($cust_pack_register as $stock_room_id => $outerboxes) {
                           foreach ($outerboxes as $row) {
                              $total_boxes_array[$stock_room_id][] = 1;
                              $tot_gr_weight_array[$stock_room_id][] = $row->gross_weight;
                              $tot_weight_array[$stock_room_id][] = $row->net_weight;
                           }
                        }
                        ?>
                        <h3 align="center"><strong>Stock Register -Stock Room Wise (Yarn &amp; Thread)</strong></h3>

                        <?php
                        foreach ($cust_pack_register as $stock_room_id => $outerboxes) {
                           $this->db->select('stock_room_name');
                           $this->db->from('bud_stock_rooms');
                           $this->db->where('stock_room_id', $stock_room_id);
                           $e = $this->db->get()->result_array();
                           foreach ($e as $ee) {
                              $room_name = $ee['stock_room_name'] . ' / ' . $stock_room_id;
                           }
                        ?>
                           <div class="">
                              <div class="col-md-12" align="center">
                                 <h4><strong> Stock Room Name: </strong> <?= $room_name; ?> &nbsp;&nbsp; <strong> Till Date: </strong> <?= $t_date; ?> &nbsp;&nbsp;
                                    <strong>Print Date :</strong> <?= date("d-m-Y H:i:s"); ?></h4>
                              </div>
                              <div>
                                 <br>
                                 <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                                    <thead>
                                       <?php
                                       if (++$i == 1) {
                                       ?>
                                          <tr>
                                             <th></th>
                                             <th><strong><?php echo $gr_total_boxes; ?> Box(s)</strong></th>
                                             <th></th>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td><strong><?php echo number_format($gr_net_weight, 3, '.', ''); ?></strong></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                          </tr>
                                       <?php
                                       }
                                       ?>
                                       <tr>
                                          <th></th>
                                          <th class="boxes"><?= count($total_boxes_array[$stock_room_id]); ?> Boxes</th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th><?= number_format(array_sum($tot_weight_array[$stock_room_id]), 3, '.', ''); ?></th>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <!-- <th class="screen_only"></th> -->
                                       </tr>
                                       <tr>
                                          <th>#</th>
                                          <th>Box No</th>
                                          <th>Item Name</th>
                                          <th>Item Code</th>
                                          <th>Lot No</th>
                                          <th>Color</th>
                                          <th>Color Code</th>
                                          <th>Status</th>
                                          <th>Nt. Weight</th>
                                          <th>Remarks </th>
                                          <th>Packing Date</th>
                                          <th>Packed by</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $sno = 1;
                                       $total_net_weight = 0;
                                       $total_gr_weight = 0;
                                       $no_of_boxes = 0;

                                       foreach ($outerboxes as $key => $row) {
                                          $one_mtr_weight = 0;
                                          $box_no = $row->box_no;
                                          $room_no = $row->stock_room_id;
                                          $lot_no = $row->lot_no;
                                          $total_net_weight += $row->net_weight;
                                          $total_gr_weight += $row->gross_weight;
                                          $no_of_boxes++;
                                          $this->db->select('item_name');
                                          $this->db->from('bud_items');
                                          $this->db->where('item_id', $row->item_id);
                                          $e = $this->db->get()->result_array();
                                          foreach ($e as $ee) {
                                             $item_name = $ee['item_name'];
                                          }

                                          $tyarn_lot_id = '';
                                          if ($row->yarn_lot_id != '') {
                                             $arr = explode('**', $row->yarn_lot_id);
                                             if (is_array($arr)) {
                                                $tyarn_lot_id = 'CL' . @$arr[0];
                                             }
                                          } else if ($row->lot_no != '') {
                                             $tyarn_lot_id = $row->lot_no;
                                          }

                                       ?>
                                          <tr>
                                             <td><?= $sno; ?></td>
                                             <td><?= $row->box_prefix; ?><?= $box_no; ?></td>
                                             <td class="item-name"><?= $item_name; ?></td>
                                             <td><?= $row->item_id; ?>*</td>
                                             <td><?= ($tyarn_lot_id != '') ? $tyarn_lot_id : '#'; ?></td>
                                             <td><?= $row->shade_name; ?> / <?= $row->shade_id; ?></td>
                                             <td><?= $row->shade_code; ?></td>
                                             <td><?php
                                                   //Dynamic Dost 3.0
                                                   if ($row->delivered_in_group == 1) {
                                                   ?>
                                                   <label class="btn btn-xs btn-danger">Transit</label>
                                                   <?php
                                                      $this->db->select('id');
                                                      $this->db->from('bud_sh_stocktransfer');
                                                      $this->db->where("FIND_IN_SET('$row->box_id',selected_boxes) !=", '');
                                                      $e = $this->db->get()->result_array();
                                                      foreach ($e as $ee) {
                                                         echo 'DC No-' . $ee['id'];
                                                      }
                                                   } elseif ($row->delivery_status == '0') {
                                                   ?>
                                                   <label class="btn btn-danger btn-xs">Delivered -</label>
                                                   <br />
                                                   <?php
                                                      $this->db->select('invoice_no');
                                                      $this->db->from('bud_yt_invoices');
                                                      $this->db->where("FIND_IN_SET('$row->box_id',boxes_array) !=", '');
                                                      $e = $this->db->get()->result_array();
                                                      $inv_no = '';
                                                      foreach ($e as $ee) {
                                                         $inv_no = 'INV-' . $ee['invoice_no'];
                                                      }
                                                      if (empty($inv_no)) {
                                                         $this->db->select('dc_no');
                                                         $this->db->from('bud_yt_delivery');
                                                         $this->db->where("FIND_IN_SET('$row->box_id',delivery_boxes) !=", '');
                                                         $e = $this->db->get()->result_array();
                                                         $inv_no = '';
                                                         foreach ($e as $ee) {
                                                            $inv_no = 'DC-' . $ee['dc_no'];
                                                         }
                                                      }
                                                      echo $inv_no;
                                                      if ($row->delivered_in_group == 1) {
                                                   ?>
                                                      <label class="btn btn-xs btn-danger">Transit</label>
                                                      <?php
                                                         $this->db->select('id');
                                                         $this->db->from('bud_sh_stocktransfer');
                                                         $this->db->where("FIND_IN_SET('$row->box_id',selected_boxes) !=", '');
                                                         $e = $this->db->get()->result_array();
                                                         foreach ($e as $ee) {
                                                            echo 'DC No-' . $ee['id'];
                                                         }
                                                      }
                                                   } elseif ($row->predelivery_status == 0) {
                                                      if ($row->delivered_in_group == 1) {
                                                      ?>
                                                      <label class="btn btn-xs btn-danger">Transit</label>
                                                      <?php
                                                         $this->db->select('id');
                                                         $this->db->from('bud_sh_stocktransfer');
                                                         $this->db->where("FIND_IN_SET('$row->box_id',selected_boxes) !=", '');
                                                         $e = $this->db->get()->result_array();
                                                         foreach ($e as $ee) {
                                                            echo 'DC No-' . $ee['id'];
                                                         }
                                                      } else {
                                                      ?>
                                                      <label class="btn btn-primary btn-xs">Reserved</label>
                                                   <?php
                                                      }
                                                   } else {
                                                   ?>
                                                   <label class="btn btn-success btn-xs">Stock</label>
                                                <?php
                                                   }
                                                   //end of Dunamic 3.0
                                                ?>
                                             </td>
                                             <td><?= number_format($row->net_weight, 3, '.', ''); ?></td>
                                             <td><?= $row->remarks; ?></td>
                                             <td><?php echo date("d-m-Y", strtotime($row->packed_date)); ?></td>
                                             <td><?= $row->packed_by; ?></td>
                                          </tr>
                                          <?php
                                          if (isset($outerboxes[$key + 1]->lot_no)) {
                                             if ($lot_no != $outerboxes[$key + 1]->lot_no) {
                                          ?>
                                                <tr>
                                                   <td></td>
                                                   <td class="boxes"><strong><?= $no_of_boxes; ?> Boxes</strong></td>
                                                   <td></td>
                                                   <td></td>
                                                   <td></td>
                                                   <td></td>
                                                   <td></td>
                                                   <td align="center"><strong>Total</strong></td>
                                                   <td></td>
                                                   <td><strong><?= number_format($total_net_weight, 3, '.', ''); ?></strong></td>
                                                   <td></td>
                                                   <td></td>
                                                </tr>
                                             <?php
                                                $total_net_weight = 0;
                                                $total_gr_weight = 0;
                                                $no_of_boxes = 0;
                                             }
                                          } else {
                                             ?>
                                             <tr>
                                                <td></td>
                                                <td class="boxes"><strong><?= $no_of_boxes; ?> Boxes</strong></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="center"><strong>Total</strong></td>
                                                <td><strong><?= number_format($total_net_weight, 3, '.', ''); ?></strong></td>
                                                <td></td>
                                                <td></td>
                                             </tr>
                                       <?php
                                             $total_net_weight = 0;
                                             $total_gr_weight = 0;
                                             $no_of_boxes = 0;
                                          }
                                          $sno++;
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                                 <hr>
                              <?php

                           }
                              ?>
                              <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
                              <img class="ddloading" src="http://www.lettersmarket.com/uploads/lettersmarket/blog/loaders/common_gray/ajax_loader_gray_512.gif" style="display:none;width:100px;height:100px;z-index:10000;position:absolute;left:43%;top:-200px;">
                              </div>
                  </section>
                  <!-- End Talbe List  -->
               </div>
            </div>
            <div class="pageloader"></div>
            <!-- page end-->
         </section>
      </section>
      <!--main content end-->
   </section>

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

      $(".btn-danger2").on('click', function() {
         $(".ddloading").show();
      });

      $('.datatable').dataTable({
         "sDom": "fr",
         // "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
         "sPaginationType": "bootstrap",
         "bSort": false,
         "bPaginate": false,
         "oLanguage": {
            "sLengthMenu": "_MENU_ records per page",
            "oPaginate": {
               "sPrevious": "Prev",
               "sNext": "Next"
            }
         },
         "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
         }]
      });
      jQuery('#example_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('#example_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

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

      $(".get_item_detail").change(function() {
         $("#customer_name").select2("val", $(this).val());
         $("#customer_id").select2("val", $(this).val());
         return false;
      });
      $(".item").change(function() {
         $("#item_name").select2("val", $(this).val());
         $("#item_id").select2("val", $(this).val());
      });
      $(".color").change(function() {
         $("#color_name").select2("val", $(this).val());
         $("#color_code").select2("val", $(this).val());
      });
   </script>
</body>

</html>