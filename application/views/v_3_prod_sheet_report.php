<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Legrand charles">
      <meta name="keyword" content="">
      <link rel="shortcut icon" href="img/favicon.html">
      <title><?=$page_title; ?></title>

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
            margin: 2.5mm;
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
         .borderless td ,.borderless th{
            border-color: #FFFFFF !important;
          }
         .dataTables_filter
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
               <div class="row screen-only hidden-print">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-file"></i><?=$page_title; ?></h3>
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
                  }                                  
                  /*if($this->session->flashdata('error'))
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
                  }*/
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
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/prod_sheet_3">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title; ?>
                           </header>
                           <div class="panel-body">
                               <div class="form-group col-lg-3">
                                 <label for="date">From Date</label>
                                 <input class="form-control" type="date" value="<?=$f_date; ?>" id="date" name="f_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="date">To Date</label>
                                 <input class="form-control " type="date" value="<?=$t_date; ?>" id="date" name="t_date">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="sales_to">SAP PO No</label>
                                   <select class="select2 form-control" id="sappono" name="sappono">
                                    <option value="">Select SAPPONO</option>
                                    <?php
                                    foreach ($sappo as $row) {
                                      ?>
                                      <option value="<?=$row['erp_po_id']; ?>" <?=($row['erp_po_id'] == $sappono)?'selected="selected"':''; ?> ><?=$row['erp_po_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="sales_to">Customer</label>
                                   <select class="select2 form-control itemsselects" id="customer" name="cust_id">
                                    <option value="">Select customer</option>
                                    <?php
                                    foreach ($customers as $row) {
                                      ?>
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $cust_id)?'selected="selected"':''; ?>><?=$row['cust_name']." - ".$row['cust_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_id">Item Code</label>
                                 <select class="selects_items form-control select2" id="item_id" name="item_id">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="selects_items form-control select2" id="item_name" name="item_name">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="machine_no">Machine </label>
                                 <select class="form-control select2" id="machine_no" name="machine_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($machines as $row) {
                                       ?>
                                       <option value="<?=$row['machine_id']; ?>" <?=($row['machine_id'] == $machine_id)?'selected="selected"':''; ?>><?=$row['machine_name']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                <label>&nbsp;</label>
                                <button class="btn btn-danger" type="submit" name="search">Search</button>
                              </div>                             
                           </div>
                        </section>
                     </div> 
                  </div>
                </form>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                        
                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>             
                    <div class="panel-body">
                        <div align="right">
                          <strong>Printed staff : <?=$this->session->userdata('display_name');?>  Print Date : <?=date("d-m-Y H:i:s"); ?></strong>
                        </div>
                          <h3 class="visible-print" align="center"><?=$page_title; ?></h3>
                        <table class="tabletable table-bordered table-striped table-condensed packing-register datatable">
                            <thead>
                              <tr>
                                  <td>#</td>
                                  <td>PS#</td>
                                  <td>Date</td>
                                  <td>Machine Name</td>
                                  <td>Item Name / Code</td>
                                  <td>Total PS Qty</td>
                                  <td>PO details</td>
                                  <td class="screen_only"></td>
                              </tr>
                              </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                $same_ps_id='';
                                foreach ($ps_details as $row) {
                                  if((!empty($sappono))||(!empty($cust_id))){
                                    $filtercheck=$this->m_purchase->get_ps_items($row['ps_id'],$cust_id,$sappono);
                                    if(empty($filtercheck))
                                    {
                                      continue;
                                    }
                                  }
                                  $ps_stock_qty=$this->m_mir->total_values('bud_lbl_ps_items',null,'ps_stock_qty',null,null,array('ps_id'=>$row['ps_id']));
                                  $ps_excess_qty=$this->m_mir->total_values('bud_lbl_ps_items',null,'ps_qty',null,null,array('ps_id'=>$row['ps_id']));
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['ps_id']; ?></td>
                                    <td><?=$row['ps_date']; ?></td>
                                    <td><?=$row['machine_name']; ?></td>
                                    <td><?=$row['item_name'].' / '.$row['ps_item_id']; ?></td>
                                    <td><?=$ps_stock_qty+$ps_excess_qty; ?></td>
                                    <td>
                                      <table class="table table-light borderless" style="border:none;">
                                        <?php
                                        $po_details=$this->m_purchase->get_ps_items($row['ps_id']);
                                        foreach ($po_details as $po) {
                                          ?>
                                          <tr style="border:none;">
                                            <td style="border:none;"><?=$po['erp_po_no'].' / '.$po['cust_name'].'-'.$po['cust_id']; ?></td>
                                            <td style="border:none;"><?=$po['ps_item_size'];?></td>
                                            <td style="border:none;"><?=$po['ps_qty'];?></td>
                                            <td style="border:none;"><?=($po['ps_stock_qty'])?$po['ps_stock_qty']:'0';?></td>
                                            <td style="border:none;"><?=$po['ps_stock_qty']+$po['ps_qty'];?></td>
                                          </tr>
                                        <?php
                                        }
                                        ?>                                        
                                      </table>
                                    </td>
                                    <td class="screen_only">
                                      <a href="<?=base_url().'purchase_order/print_ps_lbl/'.$row['ps_id']?>/2" class="btn-info btn">Print</a><br>
                                      <!-- Button trigger modal -->
                                      <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updatePSId(<?=$row['ps_id']?>)">Delete
                                      </button>
                                    </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>
                            </tbody>
                          </table>
                        <hr>
                        <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
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
      <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete Production Sheet</h4>
          </div>
          <form>
          <div class="modal-body">
            <input type="text" name="ps_id" id="psId" value="" hidden>
            <label>Remarks:</label>
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" value="Production Cancelled">Production Cancelled</label>
            </div>       
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks"  value="Wrong Qty">Wrong Qty</label>
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
            <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" onclick="deleteps()">Delete</button>
          </div>
        </form>
        </div><!-- /.modal-content -->

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

      $('.datatable').dataTable({
            "sDom": "<'row'<'col-sm-6'f>r>",
            // "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "bSort": true,
            "bPaginate": false,
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': true,
                'aTargets': [0]
            }]
        });
      jQuery('#example_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('#example_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

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

      $(".item").change(function(){
        $("#itemName").select2("val", $(this).val());
        $("#itemCode").select2("val", $(this).val());       
        return false;
      });
      $(".customer").change(function(){
        $("#customerName").select2("val", $(this).val());
        $("#customerCode").select2("val", $(this).val());       
        return false;
      });
      </script>
      <script >
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
        function updatePSId(ps_id){
          $('#psId').val(ps_id);
        }
        function deleteps(){
          var remarks = $( "input:checked" ).val();
          if(remarks=="others")
          {
            remarks=$('#otherRemarkValue').val();
          }
          var ps_id=$('#psId').val();
          var url = "<?php echo base_url('purchase_order/ps_lbl_delete')?>";
          //alert(remarks+ps_id+url);
          $.ajax({
              type: "POST",
              url: url,
              data:  {
              "ps_id": ps_id,
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