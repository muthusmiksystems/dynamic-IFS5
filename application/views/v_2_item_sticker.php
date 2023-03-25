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
    
    
      <style type="text/css">
      <!--
      @page rotated { size : landscape }
      @page { size:50mm 30mm; margin: 5mm }
      -->
      table
      {
        /*border: 1px solid #000;*/
      }
      table td strong
      {
        font-size:12px;
      }
      table td
      {     font-family: Arial, Helvetica, sans-serif;
        color: #000;
        font-size:9px;
        letter-spacing: 1px;
      }
      @media print { 
        #sidebar, .header, .site-footer {
            display: none ;
        }
        .screen-only
        {
          display: none;
        }
        #printableArea
        {
          padding: 2.5mm;
        }
        table td
        {       font-family: Arial, Helvetica, sans-serif;
          color: #000;
          font-size:9px;
          letter-spacing: 1px;
        }
        span.footer-text
        {
          font-size: 9px;
          padding-top: 2mm;
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
               <div class="row screen-only">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-file"></i> Print Item Sticker</h3>
                        </header>
                     </section>
                  </div>
               </div>
               <div class="row screen-only">
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
               $items = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
               $item_name = null;
               ?>
               <form target="_blank" class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>production/item_sticker_2_view">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Print Item Sticker
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="get_item_detail form-control select2" id="item_name" name="item_name" required>
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                       ?>
                                       <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $item_name)?'selected="selected"':''; ?>><?=$item['item_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_code">Item Code</label>
                                 <select class="get_item_detail form-control select2" id="item_code" name="item_code" required>
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                       ?>
                                       <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $item_name)?'selected="selected"':''; ?>><?=$item['item_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="no_rolls"># Rolls</label>
                                 <input type="text" class="form-control" id="no_rolls" name="no_rolls">
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="item_qty">Total Qty</label>
                                <input type="text" class="form-control" id="item_qty" name="item_qty">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_uom">UOM</label>
                                 <select class="form-control select2" id="item_uom" name="item_uom" required>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($uoms as $row) {
                                       ?>
                                       <option value="<?=$row['uom_id'];?>"><?=$row['uom_name']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                <label for="no_qty">Qty</label>
                                <input type="text" class="form-control" id="no_qty" name="no_qty" value="1">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="with_barcode">Barcode</label>
                                 <input type="checkbox" checked="checked" class="form-control" id="with_barcode" name="with_barcode">
                              </div>
                              <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                 <button class="btn btn-danger" type="submit" name="view">View</button>
                              </div>                                                </div>
                        </section>
                     </div> 
                  </div>
                </form>                                                                                             <div class="pageloader"></div>                          <!-- page end-->
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

      $(".get_item_detail").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());       return false;
      });

      </script>
   </body>
</html>
