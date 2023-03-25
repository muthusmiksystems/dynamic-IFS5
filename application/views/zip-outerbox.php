<?php include APPPATH.'views/html/header.php'; ?>
         <section id="main-content">
            <section class="wrapper">
               <!-- page start-->
               <div class="row screen-only">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-file"></i> Zip Packing Outerbox</h3>
                        </header>
                        <div class="panel-body" id="sample-box">
                        </div>
                     </section>
                  </div>
               </div>
               <div class="row screen-only">
                  <div class="col-lg-12">
                  <?php
                  if(!empty($warning))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-warning fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                           </button>
                           <strong>Warning!</strong> <?=$warning; ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }                                            if(!empty($error))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-block alert-danger fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                           <i class="icon-remove"></i>
                           </button>
                           <strong>Oops sorry!</strong> <?=$error; ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }
                  if(!empty($success))
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
                           <p><?=$success; ?></p>
                        </div>
                     </header>
                  </section>
                  <?php
                  }
                  ?>
                  </div>
               </div>
               <form class="cmxform tasi-form screen-only" autocomplete="off" role="form" id="ajaxForm" method="post" action="<?php echo base_url('production/zip_outerbox/'.$box_no.'/'.$edit); ?>">
                  <input type="hidden" name="box_no" value="<?php echo $box_no; ?>">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Box No
                              <span class="label label-danger" style="font-size:14px;">Z - <?php echo $next_box_no; ?></span>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-md-3">
                                  <label for="lot_id">Lot No</label>
                                  <select class="form-control select2" name="lot_id" id="lot_id">
                                    <option value="">Select Lot</option>
                                    <?php if(sizeof($lots) > 0): ?>
                                      <?php foreach($lots as $lot): ?>
                                        <option value="<?php echo $lot->lot_id; ?>"><?php echo $lot->lot_no; ?></option>
                                      <?php endforeach; ?>
                                    <?php endif; ?>
                                  </select>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="po_date">Total Lot Prod Qnty</label>
                                <span class="label label-primary" id="lable_lot_qty" style="padding: 0 1em;font-size:24px;"><?php echo $lot_qty; ?></span>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="po_date">Total Lot Packed Qty</label>
                                <span class="label label-warning" id="lable_pack_qty" style="padding: 0 1em;font-size:24px;"><?php echo $tot_packed_qty; ?></span>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="po_date">Balance Lot Qty</label>
                                <span class="label label-danger" id="lable_bal_qty" style="padding: 0 1em;font-size:24px;"><?php echo $tot_balancd_qty; ?></span>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="po_date" class="text-danger">This Lot Wastage Qty</label>
                                <input class="form-control" value="" type="text" style="color:red;font-weight:bold;">
                              </div>

                              <div style="clear:both;"></div>

                              <div class="form-group col-md-3">
                                 <label for="customer_id">Customer</label>
                                 <select class="search-term form-control select2" id="customer_id" name="customer_id">
                                    <option value="">Select Customer</option>
                                    <?php if(sizeof($customers) > 0): ?>
                                      <?php foreach ($customers as $customer): ?>
                                         <option value="<?php echo $customer->cust_id; ?>" <?php echo ($customer->cust_id == $customer_id)?'selected="selected"':''; ?>><?php echo $customer->cust_name; ?></option>
                                      <?php endforeach; ?>
                                    <?php endif; ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_id">Item Name</label>
                                 <select class="item-select search-term form-control select2" id="item_id" name="item_id">
                                    <option value="">Select Item</option>
                                    <?php foreach ($items as $item): ?>
                                      <option value="<?php echo $item->item_id; ?>" <?php echo ($item->item_id == $item_id)?'selected="selected"':''; ?>><?php echo $item->item_name; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_code">Item Code</label>
                                 <select class="item-select search-term form-control select2" id="item_code" name="item_code">
                                    <option value="">Select Item</option>
                                    <?php foreach ($items as $item): ?>
                                      <option value="<?php echo $item->item_id; ?>" <?php echo ($item->item_id == $item_id)?'selected="selected"':''; ?>><?php echo $item->item_id; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>

                              <div class="form-group col-lg-2">
                                 <label for="shade_id">Shade Name</label>
                                 <select class="shade-select search-term form-control select2" id="shade_id" name="shade_id">
                                    <option value="">Select Shade</option>
                                    <?php foreach ($shades as $shade): ?>
                                      <option value="<?php echo $shade->shade_id; ?>" <?php echo ($shade->shade_id == $shade_id)?'selected="selected"':''; ?>><?php echo $shade->shade_name; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="shade_code">Shade Code</label>
                                 <select class="shade-select search-term form-control select2" id="shade_code" name="shade_code">
                                    <option value="">Select Shade</option>
                                    <?php foreach ($shades as $shade): ?>
                                      <option value="<?php echo $shade->shade_id; ?>" <?php echo ($shade->shade_id == $shade_id)?'selected="selected"':''; ?>><?php echo $shade->shade_code; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="no_rolls">No of Rolls</label>
                                 <input type="text" class="total_qty form-control" id="no_rolls" name="no_rolls">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="qty_per_roll">Qty Per Roll</label>
                                 <input type="text" class="total_qty form-control" id="qty_per_roll" name="qty_per_roll">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_uom">UOM</label>
                                 <select class="form-control select2" id="item_uom" name="item_uom">
                                    <option value="">Select</option>
                                    <?php foreach($uoms as $uom): ?>
                                        <option value="<?php echo $uom->uom_id; ?>" <?php echo ($uom->uom_id == $item_uom)?'selected="selected"':''; ?>><?php echo $uom->uom_name; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="total_qty">Total Qty</label>
                                 <input type="text" class="form-control" id="total_qty" name="total_qty">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="gross_weight">Gross Weight (Kgs)</label>
                                 <input type="text" class="form-control" id="gross_weight" name="gross_weight">
                              </div>
                              <div class="form-group col-lg-3">
                                    <label for="packing_by">Packed by</label>
                                    <select class="select2 form-control" data-placeholder="Select Operator" name="packing_by" id="packing_by">
                                     <option value="">Select Operator</option>
                                     <?php foreach($users as $user): ?>
                                        <option value="<?php echo $user->ID; ?>" <?php echo ($user->ID == $packing_by)?'selected="selected"':''; ?>><?php echo $user->display_name; ?></option>
                                     <?php endforeach; ?>
                                   </select>
                              </div>
                              <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                 <!-- <button class="btn btn-danger" type="submit" id="save" name="save">Save</button> -->
                                 <!-- <button class="btn btn-primary" type="button">Save &amp; Continue</button> -->
                                 <button class="btn btn-danger" type="submit" name="action" value="save" id="submit">Save</button>
                                 <button class="btn btn-warning" type="submit" name="action" value="save_continue">Save &amp; Continue</button>
                              </div>
                           </div>
                        </section>
                     </div> 
                  </div>
                </form>
                <div class="col-lg-12">
                  <section class="panel">
                      <header class="panel-heading">
                          Outer Boxes
                      </header>
                      <div class="panel-body">
                         <table id="sample_1" class="table table-bordered table-striped table-condensed">
                         <thead>
                            <tr>
                               <th>#</th>
                               <th>Party Name</th>
                               <th>Outer Box No</th>
                               <th>Item</th>
                               <th>Total Meters</th>
                               <th>Total Net Weight</th>
                               <th></th>
                            </tr>
                         </thead>
                         <tbody>
                            <?php
                            $sno = 1;
                            foreach ($outerboxes as $outerbox) {                                                            ?>
                               <!-- <tr>
                                  <td><?=$sno; ?></td>
                                  <td>
                                    <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $outerbox['packing_customer'], 'cust_name'); ?>
                                  </td>
                                  <td><?=$outerbox['box_no']; ?></td>
                                  <td>
                                    <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $outerbox['packing_innerbox_items'], 'item_name'); ?>
                                  </td>                                                                 <td>
                                    <?=$outerbox['total_meters']; ?>
                                  </td>
                                  <td>
                                    <?=$outerbox['packing_net_weight']; ?>
                                  </td>
                                  <td>
                                     <a href="<?=base_url(); ?>production/print_out_pack_slip/<?=$outerbox['box_no']; ?>" target="_blank" data-placement="top" data-original-title="Print" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips">Print</a>
                                      <a href="#<?=$outerbox['box_no']; ?>" data-toggle="modal" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips">Delete</a>
                                      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?=$outerbox['box_no']; ?>" class="modal fade">                                                                           <div class="modal-dialog">
                                            <div class="modal-content">
                                               <div class="modal-header">
                                                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                  <h4 class="modal-title">Remarks</h4>
                                               </div>
                                               <div class="modal-body">
                                                  <form role="form" method="post" action="<?=base_url(); ?>production/delete_box_2">
                                                     <input type="hidden" name="box_no" value="<?=$outerbox['box_no']; ?>">
                                                     <input type="hidden" name="function_name" value="outerBoxQtyWise_2">
                                                     <div class="form-group col-lg-12" style="margin-bottom: 15px;">
                                                        <textarea class="form-control" name="remarks" style="width:100%;"></textarea>
                                                     </div>
                                                     <div style="clear:both;"></div>
                                                     <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                                  </form>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                  </td>
                               </tr> -->
                               <?php
                               $sno++;
                            }
                            ?>
                         </tbody>
                         </table>
                      </div>
                  </section>
               </div>                                                                                            <div class="pageloader"></div>                          <!-- page end-->
            </section>
         </section>
         <!--main content end-->
      </section>

      <?php include APPPATH.'views/html/footer.php'; ?>
      <script>
      $(".total_qty").keyup(function() {
        var no_rolls = $("#no_rolls").val();
        var qty_per_roll = $("#qty_per_roll").val();
        var total_qty = parseInt(no_rolls) * parseInt(qty_per_roll);
        if(total_qty > 0)
        {
          $("#total_qty").val(parseInt(total_qty));
        }
        else
        {
          $("#total_qty").val(0);
        }
      });

      $(".item-select").change(function(){
        $("#item_id").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());
      });

      $(".shade-select").change(function(){
        $("#shade_id").select2("val", $(this).val());
        $("#shade_code").select2("val", $(this).val());
      });

      $(function(){
        $("#lot_id").change(function () {
            var lot_no = $('#lot_id').val();
            var url = "<?=base_url()?>store/get_lot_qty/"+lot_no;
            var postData = 'lot_no='+lot_no;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    // console.log(result);
                    var result = $.parseJSON(result);
                    $("#lable_lot_qty").text(result.lot_qty);
                    $("#lable_pack_qty").text(result.tot_packed_qty);
                    $("#lable_bal_qty").text(result.tot_balancd_qty);

                    $("#customer_id").select2("val", result.customer_id);
                    $("#item_id").select2("val", result.item_id);
                    $("#item_code").select2("val", result.item_id);
                    $("#shade_id").select2("val", result.lot_shade_no);
                    $("#shade_code").select2("val", result.lot_shade_no);

                    $("#lbl_cust_name").html(result.cust_name);
                    $("#lbl_item_name").html(result.item_name);
                    $("#lbl_shade_code").html(result.shade_code);
                    $("#lbl_shade_name").html(result.shade_name);
                    $("#lbl_lot_qty").html(result.lot_qty);
                }
            });
            return false;
        });
      });

      $(".search-term").change(function() {
        var customer_id = $("#customer_id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('store/get_lot_list'); ?>",
            data: { 
              customer_id: customer_id,
              shade_id: $("#shade_id").val(),
              item_id: $("#item_id").val()
            },
            beforeSend: function(data)
            {
                // $(".ajax-loader").css('display', 'block');
            },
            success: function(data)
            {
              // console.log(data);
              $("#lot_id").select2('destroy'); 
              $("#lot_id").html(data);
              $("#lot_id").select2(); 
            }
        });
      });

      function get_lot_qty() {
        var lot_no = $('#lot_id').val();
        var url = "<?=base_url()?>store/get_lot_qty/"+lot_no;
        var postData = 'lot_no='+lot_no;
        $.ajax({
            type: "POST",
            url: url,
            // data: postData,
            success: function(result)
            {
                // console.log(result);
                var result = $.parseJSON(result);
                $("#lable_lot_qty").text(result.lot_qty);
                $("#lable_pack_qty").text(result.tot_packed_qty);
                $("#lable_bal_qty").text(result.tot_balancd_qty);

                $("#customer_id").select2("val", result.customer_id);
                $("#item_id").select2("val", result.item_id);
                $("#item_code").select2("val", result.item_id);
                $("#shade_id").select2("val", result.lot_shade_no);
                $("#shade_code").select2("val", result.lot_shade_no);

                $("#lbl_cust_name").html(result.cust_name);
                $("#lbl_item_name").html(result.item_name);
                $("#lbl_shade_code").html(result.shade_code);
                $("#lbl_shade_name").html(result.shade_name);
                $("#lbl_lot_qty").html(result.lot_qty);
            }
        });
        return false;
      }

      /*$("#ajaxForm").submit(function(e) {
        var url = $(this).attr('action');
        $.ajax({
          type: "POST",
          url: url,
          data: $("#ajaxForm").serialize(),
          beforeSend: function(data)
          {
            // $(".ajax-loader").css('display', 'block');
          },
          success: function(data)
          {
              if(data != 'save_continue')
              {
                  $("#ajaxForm").find("input[type=text], textarea").val("");
              }
          }
        });

        e.preventDefault();
      });*/
      </script>
   </body>
</html>
