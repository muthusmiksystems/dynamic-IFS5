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
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>reports/po_report_lbl">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title; ?>
                           </header>
                           <div class="panel-body">
                               <div class="form-group col-lg-2">
                                 <label for="date">From Date</label>
                                 <input class="form-control" type="date" value="<?=$f_date; ?>" id="date" name="f_date">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="date">To Date</label>
                                 <input class="form-control " type="date" value="<?=$t_date; ?>" id="date" name="t_date">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="sales_to">Customer</label>
                                   <select class="select2 form-control customer" id="customerName" name="cust_id">
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
                              <div class="form-group col-lg-2">
                                 <label for="sales_to">Customer Code</label>
                                   <select class="select2 form-control customer" id="customerCode" name="cust_id">
                                    <option value="">Select customer Code</option>
                                    <?php
                                    foreach ($customers as $row) {
                                      ?>
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $cust_id)?'selected="selected"':''; ?>><?=$row['cust_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                              </div>
                              <div class="col-lg-2 form-group">
                               <label ><strong>Item name:  </strong></label>
                               <select class="select2 form-control item" id="itemName" name="item_id">
                                  <option value="">Select Item Name</option>
                                  <?php
                                  foreach ($items as $row) {
                                    ?>
                                    <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="col-lg-2 form-group">
                               <label ><strong>Item Code:  </strong></label>
                               <select class="select2 form-control item col-lg-3" id="itemCode" name="item_id">
                                  <option value="">Select Item Code</option>
                                  <?php
                                  foreach ($items as $row) {
                                    ?>
                                    <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
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
                        <?php
                         $gr_po_qty=$this->m_mir->total_values('bud_lbl_po_item',null,'po_item_qty',null,null,array('po_is_deleted'=>1));
                         $gr_ps_po_qty=$this->m_purchase->getTotPSQty(null,null,null,'ps_qty');
                         $gr_ps_stock_qty=$this->m_purchase->getTotPSQty(null,null,null,'ps_stock_qty');
                         $tot_po_qty=0;
                         $tot_ps_po_qty=0;
                         foreach ($po_details as $row) {
                            $tot_ps_qty=$this->m_purchase->getTotPSQty($row['erp_po_id'],null,null,'ps_qty');
                            $tot_stock_qty=$this->m_purchase->getTotPSQty($row['erp_po_id'],null,null,'ps_stock_qty');
                            $po_qty=$this->m_mir->total_values('bud_lbl_po_item',null,'po_item_qty',null,null,array('erp_po_no'=>$row['erp_po_id'],'po_is_deleted'=>1));
                            if($item_id)
                            {
                              $condition=array('po_item_id'=>$item_id,
                                                 'erp_po_no'=>$row['erp_po_id'],
                                                 'po_is_deleted'=>1);
                              if(!$this->m_purchase->checkItem('bud_lbl_po_item',$condition))
                              {
                                continue;
                              }
                            }
                            $tot_po_qty+=$po_qty;
                            $tot_ps_po_qty+=$tot_ps_qty+$tot_stock_qty;
                          }
                        ?>
                        <table class="tabletable table-bordered table-striped table-condensed packing-register datatable">
                          <thead>
                            <tr>
                              <th></th>
                              <th class="text-danger">Grand Total</th>
                              <th></th>
                              <th></th>
                              <th></th>                              
                              <th></th>
                              <th class="text-danger"><?=$gr_po_qty?></th>
                              <th class="text-danger"><?=$gr_ps_po_qty + $gr_ps_stock_qty ;?></th>
                              <th class="text-danger"><?=$gr_po_qty-$gr_ps_po_qty + $gr_ps_stock_qty ;?></th>
                              <th></th>
                              <th class="hidden-print"></th>
                            </tr>
                            <tr>
                              <th></th>
                              <th><strong>Total :</strong></th>
                              <th></th>
                              <th></th>
                              <th></th>                              
                              <th></th>
                              <th><strong><?=$tot_po_qty ?></strong></th>
                              <th><strong><?=$tot_ps_po_qty ;?></strong></th>
                              <th><strong><?=$tot_po_qty-$tot_ps_po_qty;?></strong></th>
                              <th></th>
                              <th class="hidden-print"></th>
                            </tr>
                            <tr>
                              <th width="5%">Sno</th>
                              <th width="5%">SAP. <br>PO NO </th>
                              <th width="10%">PO Date</th>
                              <th width="10%">Entered Date/Time</th>
                              <th width="15%">Customer name</th>        
                              <th width="35%">PO Items</th>
                              <th width="5%">JO. Qty</th>
                              <th width="5%">PS Qty</th>
                              <th width="5%">Bal. Qty</th>
                              <th width="5%">PS Ids</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th></th>
                              <th><strong>Total :</strong></th>
                              <th></th>
                              <th></th>
                              <th></th>                              
                              <th></th>
                              <th><strong><?=$tot_po_qty ?></strong></th>
                              <th></th>
                              <th><strong><?=$tot_po_qty-$tot_ps_po_qty;?></strong></th>
                              <th></th>
                              <th class="hidden-print"></th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($po_details as $row) {
                              //$po_qty=$this->m_mir->total_values('bud_lbl_po_item',null,'po_item_qty',null,null,array('erp_po_no'=>$row['erp_po_id']));
                              $po_qty=0;
                              $tot_ps_qty=$this->m_purchase->getTotPSQty($row['erp_po_id'],null,null,'ps_qty');
                              $tot_stock_qty=$this->m_purchase->getTotPSQty($row['erp_po_id'],null,null,'ps_stock_qty');
                              $po_items=$this->m_purchase->getpolist(null,null,null,null,$row['erp_po_id']);
                              if($item_id)
                              {
                                $condition=array('po_item_id'=>$item_id,
                                                 'erp_po_no'=>$row['erp_po_id'],
                                                 'po_is_deleted'=>1);
                                if(!$this->m_purchase->checkItem('bud_lbl_po_item',$condition))
                                {
                                  continue;
                                }
                              }
                              ?>
                              <tr>
                                <td><?=$sno; ?></td>
                                <td><?=$row['erp_po_id']; ?></td>
                                <td><?=date('d-M-y',strtotime($row['po_date'])); ?></td> 
                                <td><?=$row['display_name'].' / '.date('d-M-y h:i',strtotime($row['po_entered_date'])); ?></td>
                                <td><?=$row['cust_name']; ?></td>
                                <td>
                                  <table class="table table-light borderless" style="border:none;">
                                  <?php
                                  $exist_item='';
                                  foreach ($po_items as $po_item) {
                                    ?>
                                    <tr  style="border:none;">
                                    <?php
                                    if($exist_item!=$po_item['po_item_id'])
                                    {
                                      ?>
                                    <td  style="border:none;"><span class="text-danger"><?=$po_item['po_item_id']?></span><?=' - '.$po_item['item_name'];?></td>
                                    <?php
                                    }
                                    else
                                    {
                                      ?>
                                      <td  style="border:none;"></td>
                                      <?php
                                    }
                                    ?>
                                    <td  style="border:none;"><?=$po_item['po_item_size'].' - ';?></td><td style="border:none;" class="borderless"><?=$po_item['po_item_qty'].' '.$po_item['uom'].'<br>';?></td></tr>
                                    <?php
                                    $po_qty+=$po_item['po_item_qty'];
                                    $exist_item=$po_item['po_item_id'];
                                  }
                                   ?>
                                  </table>
                                </td>      
                                <td><?=$po_qty?></td>
                                <td><?=$tot_ps_qty+$tot_stock_qty ?></td>
                                <td><?=$po_qty-$tot_stock_qty-$tot_ps_qty ?></td>
                                <td>Ps Ids- <?=$this->m_purchase->getGroupFieldInOneVar('bud_lbl_ps_items','erp_po_no',$row['erp_po_id'],'ps_id','ps_is_deleted');?></td>
                                <td class=" hidden-print">
                                  <?php
                                  if(($tot_stock_qty==0)&&($tot_ps_qty==0))
                                  {
                                    ?>
                                    <!-- Button trigger modal -->
                                      <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updatePOId(<?=$row['erp_po_id']?>)">Delete
                                      </button>                                    <?php
                                  }
                                  else{
                                    ?>
                                    <a class="text-success" href="<?=base_url().'reports/prod_sheet_3/'.$row['erp_po_id']?>"> PS List</a>
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
            <h4 class="modal-title" id="myModalLabel">Delete Purchase Order</h4>
          </div>
          <form>
          <div class="modal-body">
            <input type="text" name="po_id" id="poId" value="" hidden>
            <label>Remarks:</label>
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" id="custChanged" value="Customer is Changed">Customer is Changed</label>
            </div>       
            <div class="radio">
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
            <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" onclick="deletepo()">Delete</button>
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
        function updatePOId(po_id){
          $('#poId').val(po_id);
        }
        function deletepo(){
          var remarks = $( "input:checked" ).val();
          if(remarks=="others")
          {
            remarks=$('#otherRemarkValue').val();
          }
          var erp_po_id=$('#poId').val();
          var url = "<?php echo base_url('purchase_order/po_lbl_delete')?>";
          $.ajax({
              type: "POST",
              url: url,
              data:  {
              "erp_po_id": erp_po_id,
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