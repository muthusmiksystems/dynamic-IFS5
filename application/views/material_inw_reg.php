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
                                <h3>Material Inward Register</h3>
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
                                ?>
                                <form class="cmxform tasi-form screen_only" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>registers/material_inw_reg">
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
                                       <label for="supplier">Supplier</label>
                                       <select class="form-control select2" id="supplier" name="supplier">
                                          <option value="">All</option>
                                          <?php
                                          foreach ($customers as $row) {
                                            ?>
                                            <option value="<?=$row['company_id']; ?>" <?=($row['company_id'] == $supplier)?'selected="selected"':''; ?>><?=$row['company_name']; ?></option>
                                            <?php
                                          }
                                          ?>
                                       </select>
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
                                       <label>Concern Name</label>
                                       <select class="form-control select2" name="concern_id">
                                          <option value="">All</option>
                                          <?php
                                          foreach ($concerns as $row) {
                                             ?>
                                             <option value="<?=$row['concern_id']; ?>" <?=($row['concern_id'] == $concern_id)?'selected="selected"':''; ?>><?=$row['concern_name']; ?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                  <div class="form-group col-lg-3">
                                     <label for="prepared_by">Username</label>
                                     <select class="get_item_detail form-control select2" id="prepared_by">
                                        <option value="">All</option>
                                        <?php
                                        foreach ($users as $row) {
                                          ?>
                                          <option value="<?=$row['ID']; ?>" <?=($row['ID'] == $prepared_by)?'selected="selected"':''; ?>><?=$row['display_name']; ?></option>
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
                                $boxes_1_array = 0;
                                $boxes_2_array = 0;
                                $items_array = array();
                                $supp_array = array();
                                $total_qty = 0;
                                $total_amt = 0;
                                foreach ($result_reg as $row) {
                                  $amount = $row->item_rate * $row->item_qty;
                                  $items_array[$row->item_name] = $row->item_id;
                                  $supp_array[$row->supplier] = $row->company_name;
                                  $boxes_1_array++;
                                  $boxes_2_array++;
                                  $total_qty += $row->item_qty;
                                  $total_amt += $amount;
                                }
                                ?>
                                <h3 class="visible-print">Material Inward Register</h3>
                                <div class="row visible-print">
                                  <div class="col-md-6 text-left">
                                    From Date: <strong><?=$from_date; ?></strong>  To Date: <strong><?=$to_date; ?></strong>
                                  </div>
                                  <div class="col-md-6 text-right">
                                    Print Date: <strong><?=date("d-m-Y H:i:s"); ?></strong>
                                  </div>
                                </div>
                                <table id="register_tbl" class="table table-bordered table-condensed">
                                  <thead>
                                     <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th><?=count($items_array); ?></th>
                                        <th></th>
                                        <th><?=count($supp_array); ?></th>
                                        <th><?=$boxes_1_array; ?></th>
                                        <th><?=$boxes_2_array; ?></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?=number_format($total_qty, 3, '.', ''); ?></th>
                                        <th></th>
                                        <th><?=number_format($total_amt, 2, '.', ''); ?></th>
                                        <th></th>
                                        <th></th>
                                     </tr>
                                     <tr>
                                        <th>S.No</th>
                                        <th>Inward.Date</th>
                                        <th>Item Name/Code</th>
                                        <th>Concern Name</th>
                                        <th>Supp.Name/Code</th>
                                        <th>Party Box No</th>
                                        <th>OUR Box No</th>
                                        <th>Stock Room</th>
                                        <th>Inward Staff Name</th>
                                        <th>Rate</th>
                                        <th>Qty</th>
                                        <th>Uom</th>
                                        <th>Amount</th>
                                        <th>Username</th>
                                        <th>Remarks</th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                        <?php
                                        $sno = 1;
                                        foreach ($result_reg as $row) {
                                          $amount = $row->item_rate * $row->item_qty;
                                          ?>
                                          <tr>
                                            <td><?=$sno; ?></td>
                                            <td><?=date("d-m-Y H:i:s", strtotime($row->inward_date)); ?></td>
                                            <td><?=$row->item_id; ?>/<?=$row->item_name; ?></td>
                                            <td><?=$row->concern_name; ?></td>
                                            <td><?=$row->company_name; ?></td>
                                            <td><?=$row->party_boxno; ?></td>
                                            <td><?=$row->dynamic_box_no; ?></td>
                                            <td><?=$row->stock_room_name; ?></td>
                                            <td><?=$row->inward_staff; ?></td>
                                            <td><?=$row->item_rate; ?></td>
                                            <td><?=$row->item_qty; ?></td>
                                            <td><?=$row->uom_name; ?></td>
                                            <td><?=number_format($amount, 2, '.', ''); ?></td>
                                            <td><?=$row->custody_staff; ?></td>
                                            <td><?=$row->remarks; ?></td>
                                          </tr>
                                          <?php
                                          $sno++;
                                        }
                                        ?>
                                     </tbody>
                                     <tfoot>
                                        <tr>
                                           <th>Total</th>
                                            <th></th>
                                            <th><?=count($items_array); ?></th>
                                            <th></th>
                                            <th><?=count($supp_array); ?></th>
                                            <th><?=$boxes_1_array; ?></th>
                                            <th><?=$boxes_2_array; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><?=number_format($total_qty, 3, '.', ''); ?></th>
                                            <th></th>
                                            <th><?=number_format($total_amt, 2, '.', ''); ?></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                     </tfoot>
                                </table>
                                <button class="btn btn-primary screen-only" type="button" onclick="window.print()">Print</button>
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
