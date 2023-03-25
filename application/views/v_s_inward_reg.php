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
                                <h3>Inward Register</h3>
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
                                <form class="cmxform tasi-form screen_only" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>shop/inward_register">
                                  <div class="row">
                                    <div class="form-group col-lg-3">
                                      <label for="from_date">From Date</label>
                                      <input type="text" value="<?=$from_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                                    </div>
                                    <div class="form-group col-lg-3">
                                      <label for="to_date">To Date</label>
                                      <input type="text" value="<?=$to_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
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
                                <h3 class="visible-print">Inward Register</h3>
                                <table id="sample_1" class="table table-bordered table-striped table-condensed">
                                  <thead>
                                    <tr>
                                      <th>S.No</th>
                                      <th>Date</th>
                                      <th>DC No</th>
                                      <th>Box No</th>
                                      <th>Item Name</th>
                                      <th>Item Code</th>
                                      <th>Shade Name</th>
                                      <th>Shade Code</th>
                                      <th class="text-right"># Of Cones</th>
                                      <th class="text-right">Gr.Weight</th>
                                      <th class="text-right">Nt.Weight</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $sno = 1;
                                    $total_no_cones = 0;
                                    $total_gr_weight = 0;
                                    $total_nt_weight = 0;
                                    foreach ($inward_register as $row) {
                                      $total_no_cones += $row['no_cones'];
                                      $total_gr_weight += $row['gr_weight'];
                                      $total_nt_weight += $row['nt_weight'];
                                      ?>
                                      <tr>
                                        <td><?=$sno; ?></td>
                                        <td><?=$row['inward_date']; ?></td>
                                        <td><?=$row['dc_no']; ?></td>
                                        <td><?=$row['box_no']; ?></td>
                                        <td><?=$row['item_name']; ?></td>
                                        <td><?=$row['item_id']; ?></td>
                                        <td><?=$row['shade_name']; ?></td>
                                        <td><?=$row['shade_id']; ?></td>
                                        <td class="text-right"><?=$row['no_cones']; ?></td>
                                        <td class="text-right"><?=$row['gr_weight']; ?></td>
                                        <td class="text-right"><?=$row['nt_weight']; ?></td>
                                      </tr>
                                      <?php
                                      $sno++;
                                    }
                                    ?>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <td colspan="8"></td>
                                      <td class="text-right"><strong><?=$total_no_cones; ?></strong></td>
                                      <td class="text-right"><strong><?=number_format($total_gr_weight, 3, '.', ''); ?></strong></td>
                                      <td class="text-right"><strong><?=number_format($total_nt_weight, 3, '.', ''); ?></strong></td>
                                    </tr>
                                  </tfoot>
                                </table>
                                <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>                                                   </div>
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
      });

      $(".item").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());
      });
      $(".shade").change(function(){
        $("#shade_name").select2("val", $(this).val());
        $("#shade_id").select2("val", $(this).val());
      });

  </script>

  </body>
</html>
