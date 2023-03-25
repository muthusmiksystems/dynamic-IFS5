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
                           <h3><i class=" icon-file-text"></i> Main Invoice &amp; Transport Invoice</h3>
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
                  /*$input = 25;
                  echo str_pad($input, 12, "0", STR_PAD_LEFT);
                  echo '<br>';
                  echo str_pad($input+1000, 12, "0", STR_PAD_LEFT);*/
                  ?>
                  </div>
               </div>
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
                                       <th>Date</th><!--Include Invoice Date-->
                                       <th>Invoice No</th>
                                       <th width="250px">Customer</th>
                                       <th>Total Qty</th>
                                       <th>Amount</th>
                                       <th width="300px"></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $sno = 1;
                                    foreach ($proforma_invoices as $row) {
                                       $total_amount = 0;
                                       $net_amount = 0;
                                       $item_weights = explode(",", $row['item_weights']);
                                       $item_rate = explode(",", $row['item_rate']);
                                       $addtions_names = explode(",", $row['addtions_names']);
                                       $addtions_values = explode(",", $row['addtions_values']);
                                       $addtions_amounts = explode(",", $row['addtions_amounts']);
                                       $tax_names = explode(",", $row['tax_names']);
                                       $tax_values = explode(",", $row['tax_values']);
                                       $tax_amounts = explode(",", $row['tax_amounts']);
                                       $deduction_names = explode(",", $row['deduction_names']);
                                       $deduction_values = explode(",", $row['deduction_values']);
                                       $deduction_amounts = explode(",", $row['deduction_amounts']);
                                       $sub_total = explode(",", $row['sub_total']);
                                       $net_amount = $row['net_amount'];
                                       $lr_no = $row['lr_no'];
                                       $transport_name = $row['transport_name'];

                                       foreach ($item_weights as $key => $value) {
                                          $total_amount +=  $item_weights[$key] * $item_rate[$key];
                                       }
                                                                      ?>
                                       <tr>
                                          <td><?=$sno; ?></td>
                                          <td><?=date('d-M-Y',strtotime($row['invoice_date'])); ?></td><!--Include Invoice Date-->
                                          <td><?=$row['invoice_no']; ?></td>
                                          <td><?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $row['customer'], 'cust_name');?><br/></td>
                                          <td><?=array_sum($item_weights); ?></td>
                                          <td><?=number_format($net_amount, 2, '.', ''); ?></td>
                                          <td>
                                             <a href="<?=base_url(); ?>sales/print_trans_invoice_2/<?=$row['invoice_id']; ?>/2" data-placement="top" data-original-title="Print Transport Invoice" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Transport Invoice</a>
                                             <a href="<?=base_url(); ?>sales/print_gatepass_2/<?=$row['invoice_id']; ?>/2" data-placement="top" data-original-title="Print Gatepass" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Gatepass</a>
                                             <a target="_blank" href="<?=base_url(); ?>sales/invoice_2_preprint/<?=$row['invoice_id']; ?>/2" data-placement="top" data-original-title="Print Pre-printed" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Pre-printed</a>
                                             <?php
                                             if($lr_no != '')
                                             {
                                                ?>
                                                <a href="<?=base_url(); ?>sales/invoice_2_view/<?=$row['invoice_id']; ?>" target="_blank" data-placement="top" data-original-title="View" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">View</a>
                                                                                        <a href="#<?=$row['invoice_id']; ?>" data-toggle="modal" data-placement="top" data-original-title="Print Invoice" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Invoice</a>
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
                                                               <input type="text" class="form-control" name="transport_name" value="<?=$transport_name; ?>" required placeholder="Transport Name">
                                                               </div>
                                                               <div class="form-group" style="margin-bottom: 15px;">
                                                               <label>LR No and Date</label>
                                                               <input type="text" class="form-control" name="lr_no" value="<?=$lr_no; ?>" required placeholder="LR No / Date">
                                                               </div>
                                                               <div style="clear:both;"></div>
                                                               <button type="submit" class="btn btn-default" name="print">Print</button>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <?php
                                             }
                                             else
                                             {
                                                ?>
                                                <a href="#<?=$row['invoice_id']; ?>" data-toggle="modal" data-placement="top" data-original-title="Print Invoice" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Print Invoice</a>
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
                                                               <input type="text" class="form-control" name="transport_name" value="<?=$transport_name; ?>" required placeholder="Transport Name">
                                                               </div>
                                                               <div class="form-group" style="margin-bottom: 15px;">
                                                               <label>LR No and Date</label>
                                                               <input type="text" class="form-control" name="lr_no" value="<?=$lr_no; ?>" required placeholder="LR No / Date">
                                                               </div>
                                                               <div style="clear:both;"></div>
                                                               <button type="submit" class="btn btn-default" name="print">Print</button>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <?php
                                             }
                                             $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
                                             if($is_admin)
                                             {
                                                ?>
                                                <a href="<?=base_url(); ?>sales/invoice_2_edit/<?=$row['invoice_id']; ?>" class="btn btn-danger btn-xs">Edit</a>
                                                <!-- Button trigger modal -->
                                                <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updateINVId(<?=$row['invoice_id']?>)">Delete
                                                  </button>
                                             <?php
                                             }
                                             ?>
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
      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Delete Invoice</h4>
            </div>
            <form>
            <div class="modal-body">
              <input type="text"  id="invoiceId" value="" hidden>
              <label>Remarks:</label>
              <div class="radio">
                <label><input type="radio" name="remarks" class="remarks" id="custChanged" value="Customer is Changed">Customer is Changed</label>
              </div>             <div class="radio">
                <label><input type="radio" name="remarks" class="remarks" id="WrongQty" value="Qty is != PO Qty">Qty is != PO Qty</label>
              </div>
              <div class="radio">
                <label><input type="radio" name="remarks" id='others' value="others">Others</label>
              </div>
              <div class="form-group" id="otherRemarks">
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="5" name="others" id="otherRemarkValue"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" onclick="deletedc()">Delete</button>
            </div>
          </form>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

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
      <script>
        $('#otherRemarks').hide();
        $('#others').click(function(event) {
        if(this.checked) { // check select status
          $('#otherRemarks').show();
        }
        else
        {
          $('#otherRemarks').hide();
        }
        });
        $('.remarks').click(function(event) {
        $('#otherRemarks').hide();
        });
        function updateINVId(invoice_id){
          $('#invoiceId').val(invoice_id);
        }
        function deletedc(){
          var remarks = $( "input:checked" ).val();
          if(remarks=="others")
          {
            remarks=$('#otherRemarkValue').val();
          }
          var invoice_id=$('#invoiceId').val();
          var url = "<?php echo base_url('sales/delete_invoice_2')?>";
          $.ajax({
              type: "POST",
              url: url,
              data:  {
              "invoice_id": invoice_id,
              "remarks": remarks
              },
              success: function(result)
              {
                alert(result);
                location.reload(true);
              }
            });
        }
      </script>
   </body>
</html>
