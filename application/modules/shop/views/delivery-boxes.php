<?php include APPPATH.'views/html/header.php'; ?>
    <style type="text/css">
        @media print{
          @page{
            margin: 3mm;
          }
      }
    </style>
	<section id="main-content">
		<section class="wrapper">
            <!--//ER-10-18#-66-->
            <div class="row" >
                <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>shop/registers/delivery_boxes">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title; ?>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3 date">
                                 <label for="date">From Date</label>
                                 <input class="form-control " type="date" value="<?=$f_date; ?>" id="date" name="f_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="date">To Date</label>
                                 <input class="form-control " type="date" value="<?=$t_date; ?>" id="date" name="t_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="get_item_detail form-control select2" id="item_name" name="item_name">
                                    <option value="0">Select</option>
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
                                 <label for="item_id">Item Code</label>
                                 <select class="get_item_detail form-control select2" id="item_id" name="item_id">
                                    <option value="0">Select</option>
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
                                 <label for="shade_code">Shade Code</label>
                                 <select class="get_shade form-control select2" id="shade_code" name="shade_code">
                                    <option value="0">Select</option>
                                    <?php
                                    foreach ($shades as $row) {
                                      ?>
                                      <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_code)?'selected="selected"':''; ?>><?=$row['shade_code']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="shade_code">Shade Name</label>
                                 <select class="get_shade form-control select2" id="shade_name" name="shade_code">
                                    <option value="0">Select</option>
                                    <?php
                                    foreach ($shades as $row) {
                                      ?>
                                      <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_code)?'selected="selected"':''; ?>><?=$row['shade_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="customer_name">Customer Name</label>
                                 <select class="get_cust_detail form-control select2" id="customer_name" name="customer_name">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                      ?>
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $cust_id)?'selected="selected"':''; ?>><?=$row['cust_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="customer_id">Customer Code</label>
                                 <select class="get_cust_detail form-control select2" id="customer_id" name="cust_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                      ?>
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $cust_id)?'selected="selected"':''; ?>><?=$row['cust_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="dc_boxes">Delivered Boxes</label>
                                 <select class="form-control select2" id="box_id" name="box_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($dc_boxes as $row) {
                                        if($row['is_deleted']=='1'){
                                            continue;
                                        }
                                      ?>
                                      <option value="<?=$row['box_id']; ?>" <?=($row['box_id'] == $box_id)?'selected="selected"':''; ?>><?=$row['box_prefix'].$row['box_no']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="dc_boxes">Delivered id</label>
                                 <select class="form-control select2" id="dc_id" name="dc_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($dc_ids as $row) {
                                      ?>
                                      <option value="<?=$row['delivery_id']; ?>" <?=($row['delivery_id'] == $dc_id)?'selected="selected"':''; ?>><?=$row['delivery_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="dc_status">Delivered status</label></br>
                                 <select class=" form-control select2" id="dc_status" name="dc_status">
                                    <option value="0">All Dcs</option>
                                    <option value="1" <?=($dc_status=='1')?'selected="selected"':''; ?>>Pending DCs</option>
                                    <option value="2" <?=($dc_status=='2')?'selected="selected"':''; ?>>Invoiced DCs</option>
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
            </div>
            <!--//ER-10-18#-66-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading"><!--//ER-10-18#-66-->
                            Summary
                        </header>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Box no</th>
                                        <th>SDC No</th>
                                        <th>Date</th>
                                        <th>Customer</th><!--//ER-10-18#-66-->
                                        <th>Item name/code</th>
                                        <th>Shade name/code</th>
                                        <th>Shade number</th>
                                        <th>Lot no</th>
                                        <th>#Boxes</th>
                                        <th>#Cones</th>
                                        <th>Gr.Wt</th>
                                        <th>Nt.Wt</th>
                                        <th>Del. Qty</th><!--//ER-10-18#-66-->
                                        <th>Item Rate</th><!--//ER-10-18#-66-->
                                        <th>Amount</th><!--//ER-10-18#-66-->
                                        <th>Status</th><!--//ER-10-18#-66-->
                                    </tr>
                                </thead>
                                <?php
                                $sno = 1;
                                ?>
                                <tbody>
                                    <?php if(sizeof($boxes) > 0): ?>
                                        <?php foreach($boxes as $box): ?>
                                            <!--//ER-10-18#-66-->
                                            <?php
                                            $invoice_no='';//ER-10-18#-67
                                            $item_rate=0;//ER-10-18#-67
                                            if($box->delivery_status=='1'){
                                                $cash_inv=$this->m_mir->get_two_table_values('bud_sh_cash_invoice_items','bud_sh_cash_invoices','invoice_no,item_rate','invoice_id','invoice_id',array(
                                                'delivery_id'=>$box->delivery_id, 
                                                'bud_sh_cash_invoices.is_deleted'=>1
                                                ));
                                                foreach ($cash_inv as $inv) {
                                                  $invoice_no=$inv['invoice_no'];
                                                  $item_rate=$inv['item_rate'];
                                                }
                                                $credit=$this->m_mir->get_two_table_values('bud_sh_credit_invoice_items','bud_sh_credit_invoices','invoice_no,item_rate','invoice_id','invoice_id',array(
                                                'delivery_id'=>$box->delivery_id, 
                                                'bud_sh_credit_invoices.is_deleted'=>1
                                                ));
                                                foreach ($credit as $inv) {
                                                  $invoice_no=$inv['invoice_no'];
                                                  $item_rate=$inv['item_rate'];
                                                }
                                                $quote=$this->m_mir->get_two_table_values('bud_sh_quotation_items','bud_sh_quotations','quotation_no,item_rate','quotation_id','quotation_id',array(
                                                'delivery_id'=>$box->delivery_id, 
                                                'bud_sh_quotations.is_deleted'=>1
                                                ));
                                                foreach ($quote as $inv) {
                                                  $invoice_no=$inv['quotation_no'];
                                                  $item_rate=$inv['item_rate'];
                                                }
                                            }
                                            if($box->delivery_status=='0'){
                                                $rate_filter['item_id']=$box->item_id;
                                                $rate_filter['shade_id']=$box->shade_id;
                                                $rate_filter['customer_id']=$box->customer_id;
                                                $dc_rates=$this->m_mir->get_two_table_values('bud_sh_itemrates','','item_rates,item_rate_active','','',$rate_filter);
                                                foreach ($dc_rates as $dc_rate) {
                                                  $item_rate_array=explode(',',$dc_rate['item_rates']);
                                                  $item_rate=$item_rate_array[$dc_rate['item_rate_active']];
                                                }
                                            }
                                            ?>
                                            <!--//ER-10-18#-66-->
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                                                <td><?php echo $box->delivery_id; ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($box->delivery_date)); ?></td>
                                                <td><?php echo $box->cust_name.'/'.$box->customer_id; ?></td><!--//ER-10-18#-66-->
                                                <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
                                                <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
                                                <td><?php echo $box->shade_code; ?></td>
                                                <td><?php echo $box->lot_no; ?></td>
                                                <td><?php echo $box->no_boxes; ?></td>
                                                <td><?php echo $box->no_cones; ?></td>
                                                <td><?php echo $box->gr_weight; ?></td>
                                                <td><?php echo $box->nt_weight; ?></td>
                                                <td><?php echo $box->delivery_qty; ?></td><!--//ER-10-18#-66-->
                                                <td><?php echo $item_rate; ?></td><!--//ER-10-18#-66-->
                                                <td><?php echo $box->delivery_qty*$item_rate; ?></td><!--//ER-10-18#-66-->
                                                <td><?php echo ($box->delivery_status=='1')?$invoice_no:'pedning dc'; ?></td><!--//ER-10-18#-66-->
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>       
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });

    var index = $(".dataTables").find('th:last').index();
    oTable01 = $('.dataTables').dataTable({
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        }
    });
    jQuery('.dataTables_filter input').addClass("form-control");
    jQuery('.dataTables_length select').addClass("form-control");
    //ER-10-18#-66
    $(".get_item_detail").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());       
        return false;
      });
      $(".get_cust_detail").change(function(){
        $("#customer_name").select2("val", $(this).val());
        $("#customer_id").select2("val", $(this).val());       
        return false;
      });
      $(".get_shade").change(function(){
        $("#shade_code").select2("val", $(this).val());
        $("#shade_name").select2("val", $(this).val());       
        return false;
      });
      //ER-10-18#-66
</script>
</body>
</html>