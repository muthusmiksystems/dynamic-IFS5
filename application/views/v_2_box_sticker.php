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
                           <h3><i class=" icon-file"></i> Print Box Sticker</h3>
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
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>production/print_box_sticker_2">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Print Box Sticker
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-2">
                                 <label for="box_type">Box Type</label>
                                 <select class="form-control select2" id="box_type" name="box_type" required>
                                    <option value="">Select</option>
                                    <option value="bud_te_innerboxes">Inner Box</option>
                                    <option value="bud_te_outerboxes">Outer Box</option>
                                 </select>
                              </div>                                                    <div class="form-group col-lg-3">
                                 <label for="from_date">From Date</label>
                                 <input type="text" value="<?=date("d-m-Y"); ?>" class="form-control dateplugin" id="from_date" name="from_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="to_date">To Date</label>
                                 <input type="text" value="<?=date("d-m-Y"); ?>" class="form-control dateplugin" id="to_date" name="to_date">
                              </div>                                                    <div class="form-group col-lg-3">
                                <label>&nbsp;</label>
                                <div style="clear:both;"></div>
                                <button class="btn btn-danger" type="submit" name="search">Search</button>
                              </div>                                                </div>
                        </section>
                     </div> 
                  </div>
                </form> 
                <?php
                if(isset($_POST['search']))
                {
                  $box_type = $this->input->post('box_type');
                  $from_date = $this->input->post('from_date');
                  $to_date = $this->input->post('to_date');
                  $ed = explode("-", $from_date);
                  $from_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
                  $ed = explode("-", $to_date);
                  $to_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
                  $result = $this->m_production->getBoxesDaterange($box_type, 'packing_date', $from_date, $to_date);
                  ?>
                  <form target="_blank" class="cmxform form-horizontal tasi-form screen-only" role="form" method="post" action="<?=base_url()?>production/view_box_sticker_2">
                    <input type="hidden" name="box_type" value="<?=$box_type; ?>">
                    <div class="row">
                       <div class="col-lg-12">
                          <section class="panel">                                                 <header class="panel-heading">
                                Select Boxes
                             </header>
                             <div class="panel-body">
                             <table class="table table-bordered table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Box No</th>
                                  <th>Item Name</th>
                                  <th>Item Code</th>
                                  <th>
                                    <label><input type="checkbox" id="selectall">Select All</label>
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $sno = 1;
                                foreach ($result as $row) {
                                  $box_no = $row['box_no'];
                                  if($box_type == 'bud_te_innerboxes')
                                  {
                                    $packing_item = $row['packing_item'];
                                  }
                                  else
                                  {
                                    $packing_item = $row['packing_innerbox_items'];
                                  }
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$box_no; ?></td>
                                    <td><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_item, 'item_name'); ?></td>
                                    <td><?=$packing_item; ?></td>
                                    <td>
                                      <input type="checkbox" class="checkbox" name="boxes[]" value="<?=$box_no; ?>">                                                                  </td>
                                  </tr>                                                            <?php
                                  $sno++;
                                }
                                ?>
                                <tr></tr>
                              </tbody>
                             </table>
                             <button class="btn btn-danger" type="submit" name="print">Print</button>
                             </div>
                          </section>
                        </div>
                    </div>
                  </form>
                  <?php
                }
                ?>                                                                                           <div class="pageloader"></div>                          <!-- page end-->
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
      $('#selectall').click(function() {
         var c = this.checked;
         $('.checkbox').prop('checked',c);
      });
      </script>
   </body>
</html>
