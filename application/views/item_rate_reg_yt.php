<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="legrand charles">
      <meta name="keyword" content="">
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
         @page{margin: 3mm;}
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
                      <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>registers/item_rate_reg_yt">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Item Rate Master Register
                           </header>
                           <div class="panel-body">                                                 <div class="form-group col-lg-3">
                                 <label for="from_date">From Date</label>
                                 <input class="dateplugin form-control" id="from_date" name="from_date" value="<?=$from_date; ?>" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="to_date">To Date</label>
                                 <input class="dateplugin form-control" id="to_date" name="to_date" value="<?=$to_date; ?>" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label>Customers</label>
                                 <select class="form-control select2 customers" name="customer_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                       ?>
                                       <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer_id)?'selected="selected"':''; ?>><?=$row['cust_name']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label>Customers Code</label>
                                 <select class="form-control select2 customers" name="customer_code">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                       ?>
                                       <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer_id)?'selected="selected"':''; ?>><?=$row['cust_id']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label>User Name</label>
                                 <select class="form-control select2" name="rate_changed_by">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($users as $row) {
                                       ?>
                                       <option value="<?=$row['ID']; ?>" <?=($row['ID'] == $rate_changed_by)?'selected="selected"':''; ?>><?=$row['display_name']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label>Item Name</label>
                                 <select class="form-control select2 items-select" name="item_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label>Item Code</label>
                                 <select class="form-control select2 items-select" name="item_code">
                                    <option value="">Select</option>
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
                                    <option value="">Select</option>
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
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $row) {
                                       ?>
                                       <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$row['shade_id']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                <label>&nbsp;</label>
                                <button class="btn btn-danger" type="submit" name="search" value="search">Search</button>
                              </div>                                                </div>
                        </section>
                     </div> 
                  </div>
                </form>

               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>
                    <?php
                    $no_customers = 0;
                    $no_items = 0;
                    foreach ($result_reg as $row) {
                        $no_customers++;
                        $no_items++;
                    }
                    ?>
                    <div class="panel-body">
                     <h5 class="visible-print">Item Rate Master Register</h5>
                       <table id="register_tbl" class="table table-bordered table-condensed">
                         <thead>
                           <tr>
                              <th></th>
                              <th></th>
                              <th><?=$no_customers; ?></th>
                              <th><?=$no_items; ?></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                           </tr>
                           <tr>
                              <th>S.No</th>
                              <th>Date</th>
                              <th>Customer Name/Code</th>
                              <th>Item Name/Code</th>
                              <th>Shade Name/Code</th>
                              <th>Active Rate</th>
                              <th>Direct Sale Rate</th>
                              <th>Rates/User Name/Dates</th>
                           </tr>
                           </thead>
                           <tbody>
                              <?php
                              $sno = 1;
                              foreach ($result_reg as $row) {
                                 $item_rates = (array)explode(",", $row->item_rates);
                                 $rate_changed_by = (array)explode(",", $row->rate_changed_by);
                                 $rate_changed_on = (array)explode(",", $row->rate_changed_on);
                                 $description = (array)explode(",", $row->description);

                                 $rate_text = '';
                                 foreach ($item_rates as $key => $value) {
                                    $rate_text .= $item_rates[$key];
                                    $rate_text .= '/'.$this->m_masters->getmasterIDvalue('bud_users', 'ID', $rate_changed_by[$key], 'display_name');
                                    $rate_text .= '/'.date("d-m-Y H:i:s", strtotime($rate_changed_on[$key]));
                                    $rate_text .= '<br>';
                                 }
                                 ?>
                                 <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=date("d-m-Y H:s:i", strtotime($rate_changed_on[$row->item_rate_active])); ?></td>
                                    <td><?=$row->cust_name; ?>/<?=$row->customer_id; ?></td>
                                    <td><?=$row->item_name; ?>/<?=$row->item_id; ?></td>
                                    <td><?=$row->shade_name; ?>/<?=$row->shade_id; ?></td>
                                    <td><?=$item_rates[$row->item_rate_active]; ?></td>
                                    <td><?=$row->direct_sales_rate; ?></td>
                                    <td><?=$rate_text; ?></td>
                                 </tr>
                                 <?php
                                 $sno++;
                              }
                              ?>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td><?=$no_customers; ?></td>
                                 <td><?=$no_items; ?></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                              </tr>
                           </tfoot>
                        </table>
                        <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
                     </div>
                  </section>
                  <!-- End Talbe List  -->
               </div>
            </div>
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
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });
      jQuery('#register_tbl_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('#register_tbl_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

      $(".customers").change(function(){
         $(".customers").select2("val", $(this).val());
         $(".customers").select2("val", $(this).val());        return false;
      });
      $(".items-select").change(function(){
         $(".items-select").select2("val", $(this).val());
         $(".items-select").select2("val", $(this).val());        return false;
      });
      $(".shades-select").change(function(){
         $(".shades-select").select2("val", $(this).val());
         $(".shades-select").select2("val", $(this).val());        return false;
      });
      </script>
   </body>
</html>
