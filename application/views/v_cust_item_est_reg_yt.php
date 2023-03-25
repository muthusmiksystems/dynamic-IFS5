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
    foreach ($css_print as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet" media="print">
      <?php
    }
    ?>
    


  
    <style type="text/css">
      @media print{
          @page{
            margin: 3mm;
          }
         .packing-register th
         {
            border: 1px solid #000 !important;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
         }
         .packing-register td
         {
            border: 1px solid #000!important;
         }
         .dataTables_filter, .dataTables_info, .dataTables_paginate, .dataTables_length
         {
            display: none;
         }
         .screen_only
         {
            display: none;
         }
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
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <h3>Shop(Quotation) Customer &amp; Item Wise Sales Register</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body">
                                <?php
                                if($this->session->flashdata('warning'))
                                {
                                  ?>
                                  <div class="alert alert-warning fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                                  </div>
                                  <?php
                                }                                                          if($this->session->flashdata('error'))
                                {
                                  ?>
                                  <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                                </div>
                                  <?php
                                }
                                if($this->session->flashdata('success'))
                                {
                                  ?>
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
                                  <?php
                                }
                                $items = $this->m_masters->getactivemaster('bud_items', 'item_status');
                                $customers = $this->m_registers->getCustomers();
                                /*echo "<pre>";
                                print_r($customers);
                                echo "</pre>";*/
                                ?>
                                <form class="cmxform tasi-form screen_only" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>registers/cust_item_est_reg_yt">
                                  <div class="row">
                                    <div class="form-group col-lg-3">
                                      <label for="from_date">From Date</label>
                                      <input type="text" value="<?=$from_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                                    </div>
                                    <div class="form-group col-lg-3">
                                      <label for="to_date">To Date</label>
                                      <input type="text" value="<?=$to_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="item_id">Item Name</label>
                                       <select class="form-control select2 item" id="item_id" name="item_id">
                                          <option value="">All</option>
                                          <?php
                                          foreach ($items as $row) {
                                            ?>
                                            <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name']; ?></option>
                                            <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                       <label for="item_id">Item Code</label>
                                       <select class="form-control select2 item" id="item_name">
                                          <option value="">All</option>
                                          <?php
                                          foreach ($items as $row) {
                                            ?>
                                            <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id']; ?></option>
                                            <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label>Shade Name</label>
                                       <select class="form-control select2 shades-select" name="shade_id">
                                          <option value="">All</option>
                                          <?php
                                          foreach ($shades as $row) {
                                             ?>
                                             <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$row['shade_name']; ?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label>Shade Code</label>
                                       <select class="form-control select2 shades-select" name="shade_code">
                                          <option value="">All</option>
                                          <?php
                                          foreach ($shades as $row) {
                                             ?>
                                             <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$row['shade_code']; ?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                  <div class="form-group col-lg-3">
                                     <label for="customer_name">Customer Name</label>
                                     <select class="get_item_detail form-control select2" id="customer_name">
                                        <option value="">All</option>
                                        <?php
                                        foreach ($customers as $row) {
                                          ?>
                                          <option value="<?=$row['customer_mobile']; ?>" <?=($row['customer_mobile'] == $customer_mobile)?'selected="selected"':''; ?>><?=$row['customer_name']; ?></option>
                                          <?php
                                        }
                                        ?>
                                     </select>
                                  </div>
                                  <div class="form-group col-lg-3">
                                     <label for="customer_mobile">Customer Mobile</label>
                                     <select class="get_item_detail form-control select2" id="customer_mobile" name="customer_mobile">
                                        <option value="">All</option>
                                        <?php
                                        foreach ($customers as $row) {
                                          ?>
                                          <option value="<?=$row['customer_mobile']; ?>" <?=($row['customer_mobile'] == $customer_mobile)?'selected="selected"':''; ?>><?=$row['customer_mobile']; ?></option>
                                          <?php
                                        }
                                        ?>
                                     </select>
                                  </div>
                                </div>
                                <div style="clear:both;"></div>
                                <div class="row">
                                  <div class="form-group col-lg-12">
                                      <div class="">
                                          <button class="btn btn-danger" type="submit" name="search" value="search">Search</button>
                                      </div>
                                  </div>
                                </div>
                                </form>
                                <?php
                                $quotes_array = array();
                                $cust_array = array();
                                $items_array = array();
                                $shades_array = array();
                                $total_qty = 0;
                                $total_amt = 0;
                                foreach ($result_reg as $estimates) {
                                  foreach ($estimates as $row) {
                                    $quotes_array[$row->estimate_id] = $row->estimate_id;
                                    $cust_array[$row->customer_mobile] = $row->customer_mobile;
                                    $items_array[$row->item_id] = $row->item_name;
                                    $shades_array[$row->shade_id] = $row->shade_name;
                                    $total_qty += $row->qty;
                                    $total_amt += $row->amount;
                                  }
                                }
                                ?>
                                <h3 class="visible-print">Shop(Quotation) Customer &amp; Item Wise Sales Register</h3>
                                <div class="row visible-print">
                                  <div class="col-md-6 text-left">
                                    From Date: <strong><?=$from_date; ?></strong>  To Date: <strong><?=$to_date; ?></strong>
                                  </div>
                                  <div class="col-md-6 text-right">
                                    Print Date: <strong><?=date("d-m-Y H:i:s"); ?></strong>
                                  </div>
                                </div>
                                <form class="cmxform tasi-form" enctype="multipart/form-data" role="form" method="post" action="<?=base_url();?>registers/delete_estimates">
                                  <table id="register_tbl" class="table table-bordered table-condensed">
                                    <thead>
                                      <tr>
                                        <th><strong>Total</strong></th>
                                        <th><?=count($quotes_array); ?></th>
                                        <th><?=count($cust_array); ?></th>
                                        <th></th>
                                        <th><?=count($items_array); ?></th>
                                        <th><?=count($shades_array); ?></th>
                                        <th></th>
                                        <th></th>
                                        <th><?=number_format($total_qty, 3, '.', ''); ?></th>
                                        <th></th>
                                        <th></th>
                                        <th><?=number_format($total_amt, 2, '.', ''); ?></th>
                                        <th class="screen-only"></th>
                                      </tr>
                                      <tr>
                                        <th>S.No</th>
                                        <th>Quot.No<br>&amp;Inv.No/Date</th>
                                        <th>Customer Name/Code</th>
                                        <th>Cust.Mob.No</th>
                                        <th>Item Name/Code</th>
                                        <th>Shade Name/Code</th>
                                        <th>Shade No</th>
                                        <th>Lot No</th>
                                        <th>Qty</th>
                                        <th>Uom</th>
                                        <th>Rate</th>
                                        <th class="text-right">Amount</th>
                                        <th class="screen-only"><label><input type="checkbox" id="selectall">All</label></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sno = 1;
                                      $grand_total = 0;
                                      foreach ($result_reg as $estimates) {
                                        $estimate_amount = 0;
                                        $sno_display = false;
                                        foreach ($estimates as $row) {
                                          $estimate_id = $row->estimate_id;
                                          $amount = $row->amount;
                                          $estimate_amount += $amount;
                                          $grand_total += $amount;
                                          ?>
                                          <tr>
                                            <td><?=($sno_display == false)?$sno:''; ?></td>
                                            <td><?=$row->estimate_id; ?>/<?=date("d-m-Y", strtotime($row->estimate_date)); ?></td>
                                            <td><?=$row->customer_name; ?>/NA</td>
                                            <td><?=$row->customer_mobile; ?></td>
                                            <td><?=$row->item_name; ?>/<?=$row->item_id; ?></td>
                                            <td><?=$row->shade_name; ?>/<?=$row->shade_code; ?></td>
                                            <td><?=$row->shade_id; ?></td>
                                            <td></td>
                                            <td><?=number_format($row->qty, 3, '.', ''); ?></td>
                                            <td><?=$row->item_uom; ?></td>
                                            <td><?=number_format($row->rate, 2, '.', ''); ?></td>
                                            <td class="text-right"><?=$amount; ?></td>
                                            <td class="screen-only"></td>
                                          </tr>
                                          <?php
                                          $sno_display = true;
                                        }
                                        ?>
                                        <tr>
                                          <td class="text-right"><strong>Total</strong></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td class="text-right"><strong><?=number_format($estimate_amount, 2, '.', ''); ?></strong></td>
                                          <td class="screen-only"><input type="checkbox" name="selected_estimate[]" value="<?=$row->estimate_id; ?>" class="estimates"></td>
                                        </tr>
                                        <?php
                                        $sno++;
                                      }
                                      ?>
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <td class="text-right"><strong>Gr.Total</strong></td>
                                        <td><strong><?=count($quotes_array); ?></strong></td>
                                        <td><strong><?=count($cust_array); ?></strong></td>
                                        <td></td>
                                        <td><strong><?=count($items_array); ?></strong></td>
                                        <td><strong><?=count($shades_array); ?></strong></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong><?=number_format($total_qty, 3, '.', ''); ?></strong></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right"><strong><?=number_format($total_amt, 2, '.', ''); ?></strong></td>
                                        <td class="screen-only"></td>
                                      </tr>
                                    </tfoot>
                                  </table>
                                  <button class="btn btn-primary screen-only" type="button" onclick="window.print()">Print</button>                                                                                        <div class="pull-right">
                                    <button class="btn btn-warning screen-only" type="submit" name="delete" value="delete">Delete</button>
                                    <button class="btn btn-danger screen-only" type="submit" name="final_delete" value="final_delete">Final Delete</button>                                                            </div>
                                </form>
                            </div>
                        </section>
                        <!-- End Form Section -->
                    </div>
                </div>             <!-- page end-->
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

      $('#register_tbl').dataTable({
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "bPaginate": false,
            "bInfo": false,
            "iDisplayLength": -1,
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "bSort" : false
        });
      jQuery('#register_tbl_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('#register_tbl_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

      $(".item").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());
      });

      $(".get_item_detail").change(function(){
        $("#customer_name").select2("val", $(this).val());
        $("#customer_mobile").select2("val", $(this).val());       return false;
      });
      $(".shades-select").change(function(){
         $(".shades-select").select2("val", $(this).val());
         $(".shades-select").select2("val", $(this).val());        return false;
      });
    });
$(function() {
      $('#selectall').click(function(event) {
          if(this.checked) {
              $('.estimates').each(function() {
                  this.checked = true;
              });
          }else{
              $('.estimates').each(function() {
                  this.checked = false;
              });           }
      });
    });

  </script>

  </body>
</html>
