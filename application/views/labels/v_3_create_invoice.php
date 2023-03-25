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
                           <h3><i class=" icon-file-text"></i> Create Invoice</h3>
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
                  }                                  
                  if($this->session->flashdata('error'))
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
               
               <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>sales/invoice_3_generate">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              Invoice Details                       
                           </header>
                           <div class="panel-body">                              
                              <div class="form-group col-lg-3">
                                 <label for="customer">Invoice to Customer</label>
                                 <select class="customer form-control select2 placeholder" id="customer" name="customer" required>
                                    <option value="">Select Customer</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>"><?=$customer['cust_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="customer_code">Customer Code</label>
                                 <select class="customer form-control select2 placeholder" id="customer_code" name="customer_code" required>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>"><?=$customer['cust_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <!--Inclusion of  select Concern Option-->
                              <div class="form-group col-lg-3">
                                 <label for="customer">Concern Name</label>
                                 <select class="concern form-control select2" id="concern" name="concern">
                                    <option value="">Select Concern</option>
                                    <?php
                                    foreach ($concerns as $concern) {
                                       ?>
                                       <option value="<?=$concern['concern_id'];?>"><?=$concern['concern_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <!--Inclusion of  select Concern Option-->                                                       
                              <div class="clear"></div>
                           </div>
                        </section>
                     </div>

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Pending Delivery
                            </header>
                            <div class="panel-body">
                               <table class="table datatable table-bordered table-condensed">
                                 <thead>
                                    <tr>
                                       <th>DC No</th>
                                       <th>Date</th>
                                       <th>Customer Name</th>
                                       <th>Item Name</th>
                                       <th>Item Code</th>
                                       <th>Total Qty</th>
                                       <th>
                                          <label class="checkbox-inline">
                                          <input type="checkbox" id="selectall">
                                          <b>Select All</b>
                                          </label>
                                       </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    foreach ($deliveries as $row) {
                                       $dc_ckeckbox = false;
                                       $dc_display = false;
                                       $date_display = false;
                                       $items_codes_array = array();
                                       $items_names_array = array();
                                       $items_qty_array = array();
                                       $boxes=array();//partial delivered qty
                                       $delivery_id = $row->delivery_id;
                                       $dc_no = $row->dc_no;
                                       $delivery_date = $row->delivery_date;
                                       $delivery_customer = $row->delivery_customer;
                                       $cust_name = $row->cust_name;
                                       $delivery_boxes = array_filter(explode(",", $row->delivery_boxes));
                                       $ed = explode("-", $delivery_date);
                                       $delivery_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
                                       $DcItems = $this->m_production->labelDcItems($delivery_boxes);
                                       foreach ($DcItems as $item) {
                                          $items_names_array[] = $item['item_name'];
                                          $items_codes_array[] = $item['item_id'];
                                          $boxes[]=$item['box_no'];//partial delivered qty
                                       }
                                       foreach ($items_names_array as $key => $value) { 
                                          $delv_qty=$this->m_production->boxDeliveredQty($boxes[$key],$items_codes_array[$key],null,null,$delivery_id);//partial delivered qty
                                          ?>
                                          <tr>
                                             <td>
                                                <?php
                                                if($dc_display == false)
                                                {
                                                   $dc_display = true;
                                                   echo $dc_no;
                                                }
                                                ?>
                                             </td>
                                             <td>
                                                <?php
                                                if($date_display == false)
                                                {
                                                   $date_display = true;
                                                   echo $delivery_date;
                                                }
                                                ?>
                                             </td>
                                             <td><?=$cust_name; ?>/<?=$delivery_customer; ?></td>
                                             <td><?=$value; ?></td>
                                             <td><?=$items_codes_array[$key]; ?></td>
                                             <td><?=$delv_qty; ?></td>
                                             <td>
                                                <?php
                                                if($dc_ckeckbox == false)
                                                {
                                                   $dc_ckeckbox = true;
                                                   ?>
                                                   <input type="checkbox" class="checkbox" name="selected_dc[]" value="<?=$delivery_id; ?>">
                                                   <?php
                                                }
                                                ?>
                                             </td>
                                          </tr>
                                          <?php   
                                       }
                                       ?>
                                       <?php
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
                                <button class="btn btn-danger" type="submit" name="view">View Invoice</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                     </div>
                  </div>
               </form>
               <?php
               ?>
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

      var oTable = $('.datatable').dataTable({
         // "sDom": "<'row'<'col-sm-6'f>r>",
         "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
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
      jQuery('.dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('.dataTables_length select').addClass("form-control"); // modify table per page dropdown

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

      $(".customer").change(function(){
          $("#customer").select2("val", $(this).val());
          $("#customer_code").select2("val", $(this).val());
      });

      $('#selectall').click(function() {
         var c = this.checked;
         $('.checkbox').prop('checked',c);
      });

      </script>
   </body>
</html>
