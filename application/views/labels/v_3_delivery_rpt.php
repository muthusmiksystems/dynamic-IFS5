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
                           <h3><i class="icon-map-marker"></i> Deliveries register Label</h3>
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
                                }                                  
                                if($this->session->flashdata('error'))
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
                                <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>reports/rpt_delivery_3">
                                    
                                    <div class="form-group col-lg-3">
                                       <label for="date">From Date</label>
                                       <input class="form-control" type="date" value="<?=$f_date; ?>" id="date" name="f_date">
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="date">To Date</label>
                                       <input class="form-control " type="date" value="<?=$t_date; ?>" id="date" name="t_date">
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
                                    <div style="clear:both;"></div>
                                    <div class="col-lg-3">
                                      <button class="btn btn-danger" type="submit" name="search">Search</button>
                                      <button class="btn btn-default" type="button">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </section>
                      <section class="panel">
                          <header class="panel-heading">
                              Deliveries
                          </header>
                          <div class="panel-body">
                              <table class="table border-top" id="sample_1">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Date</th>
                                  <th>Pre DC No</th>
                                  <th>DC No</th><!--Inclusion of DC No And Status-->
                                  <th>Customer</th>                                  <th width='65%'>Selected Box Nos </th><!--Inclusion of DC No And Status-->
                                  <th>Tot. Qty</th>
                                  <th ></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $sno = 1;
                                foreach ($deliveries as $row) {
                                  if($item_id)
                                  {
                                    $condition=array('item_id'=>$item_id,
                                                 'delivery_id'=>$row['delivery_id'],
                                                 'p_delivery_is_deleted'=>1);
                                    if(!$this->m_purchase->checkItem('bud_lbl_predelivery_items',$condition))
                                    {
                                      continue;
                                    }
                                  }
                                  $dc_items=$this->m_reports->dc_items_lbl($row['delivery_id']);
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=date('d-M-y',strtotime($row['delivery_date'])); ?></td><!--Inclusion of DC No And Status-->
                                    <td><?=$row['p_delivery_ref']; ?></td><!--Inclusion of DC No And Status-->
                                    <td><?=$row['dc_no']; ?></td><!--Inclusion of DC No And Status-->
                                    <td><?=$row['cust_name']?></td>
                                    <td>
                                      <table class="table" style="border:none;">
                                        <?php
                                        $tot_qty=0;
                                        $exist_item=0;
                                        foreach ($dc_items as $dc_item) {
                                          ?>
                                          <tr  style="border:none;">
                                            <?php
                                            if($exist_item!=$dc_item['item_id'])
                                            {
                                            ?>
                                              <td  style="border:none;"><span class="text-danger"><?=$dc_item['item_id']?></span><?=' - '.$dc_item['item_name'];?></td>
                                            <?php
                                            }
                                            else
                                            {
                                              ?>
                                              <td  style="border:none;"></td>
                                              <?php
                                            }
                                            ?>
                                            <td  style="border:none;"><?='M'.$dc_item['box_id'].' - '.$dc_item['item_size'];?></td>
                                            <td style="border:none;" class="borderless"><?=$dc_item['delivery_qty'].'<br>';?></td>
                                            <td style="border:none;" class="borderless"><a href="<?=base_url(); ?>production/print_delivery_pack_slip_3/<?=$row['delivery_id']; ?>/<?=$dc_item['box_id']?>" class="btn btn-info btn-xs">Print packing slip</a></td>
                                          </tr>
                                          <?php
                                          $exist_item=$dc_item['item_id'];
                                          $tot_qty+=$dc_item['delivery_qty'];
                                        }
                                         ?>
                                      </table>
                                    </td>
                                    <td><?=$tot_qty;?></td>
                                    <td>
                                      <a href="<?=base_url(); ?>production/delivery_3_print/<?=$row['delivery_id']; ?>" class="btn btn-success btn-xs">Print DC</a>
                                      <!--Inclusion of DC No And Status-->
                                      <?php
                                        if($row['invoice_status']==0) {
                                       $inv_no=$this->m_reports->get_dc_invoiced_lbl($row['delivery_id']);
                                      ?>
                                       <br>
                                       <button class="btn btn-danger btn-xs">Invoiced</button>
                                       <strong style="color:red;"><?=$inv_no;?></strong>
                                       <?php
                                        }
                                        else
                                        {
                                        ?>
                                      <!-- Button trigger modal -->
                                      <br>
                                      <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updateDCId(<?=$row['delivery_id']?>)">Delete
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
            <h4 class="modal-title" id="myModalLabel">Delete Delivery</h4>
          </div>
          <form>
          <div class="modal-body">
            <input type="text" name="delivery_id" id="deliveryId" value="" hidden>
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

      $(".selects_items").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());       
        return false;
      });

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
      function updateDCId(dc_id){
        $('#deliveryId').val(dc_id);
      }
      function deletedc(){
        var remarks = $( "input:checked" ).val();
        if(remarks=="others")
        {
          remarks=$('#otherRemarkValue').val();
        }
        var delivery_id=$('#deliveryId').val();
        var url = "<?php echo base_url('production/delivery_3_delete')?>";
        $.ajax({
            type: "POST",
            url: url,
            data:  {
            "delivery_id": delivery_id,
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
