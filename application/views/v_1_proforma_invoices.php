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
                           <h3><i class=" icon-file-text"></i> Proforma Invoices</h3>
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
                  /*echo "<pre>";
                  print_r($proforma_invoices);
                  echo "</pre>";*/
                  ?>
                  <div class="row">                                  <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Summery
                            </header>
                            <div class="panel-body">
                              <table id="sample_1" class="table table-bordered table-striped table-condensed">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>P.I. No</th>
                                       <th>Customer</th>
                                       <th>Amount</th>
                                       <th></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $sno = 1;
                                    foreach ($proforma_invoices as $row) {                                                                      ?>
                                       <tr>
                                          <td><?=$sno; ?></td>
                                          <td><?=$row['invoice_id']; ?></td>
                                          <td><?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $row['customer'], 'cust_name');?><br/></td>
                                          <td><?=number_format($row['net_amount'], 2, '.', ''); ?></td>
                                          <td>
                                             <a href="<?=base_url(); ?>sales/print_trans_invoice_1/<?=$row['invoice_id']; ?>/1" data-placement="top" data-original-title="Print Transport Invoice" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Transport Invoice</a>
                                             <a href="<?=base_url(); ?>sales/print_gatepass_1/<?=$row['invoice_id']; ?>/1" data-placement="top" data-original-title="Print Gatepass" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Gatepass</a>
                                             <a href="<?=base_url(); ?>sales/proforma_1_view/<?=$row['invoice_id']; ?>" data-placement="top" data-original-title="Print Proforma Invoice" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Proforma Invoice</a>
                                             <!-- <a href="#<?=$row['invoice_id']; ?>" data-toggle="modal" data-placement="top" data-original-title="Print Invoice" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Invoice</a>
                                             <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?=$row['invoice_id']; ?>" class="modal fade">
                                                <div class="modal-dialog">
                                                   <div class="modal-content">
                                                      <div class="modal-header">
                                                         <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                         <h4 class="modal-title">Transport Details</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                         <form role="form" method="post" action="<?=base_url(); ?>sales/print_invoice_2">
                                                            <input type="hidden" name="invoice_id" value="<?=$row['invoice_id']; ?>">
                                                            <div class="form-group" style="margin-bottom: 15px;">
                                                            <label>Transport Name</label>
                                                            <input type="text" class="form-control" name="transport_name" placeholder="Transport Name">
                                                            </div>
                                                            <div class="form-group" style="margin-bottom: 15px;">
                                                            <label>LR No and Date</label>
                                                            <input type="text" class="form-control" name="lr_no" placeholder="LR No / Date">
                                                            </div>
                                                            <div style="clear:both;"></div>
                                                            <button type="submit" class="btn btn-default">Submit</button>
                                                         </form>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div> -->
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
                     </div>
                  </div>
               <?php
               ?>
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
