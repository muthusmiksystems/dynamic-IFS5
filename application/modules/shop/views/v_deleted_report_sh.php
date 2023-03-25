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
            <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>shop/registers/deleted_report_sh">
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
                             <label for="credit_cash">Report</label>
                             <select class=" form-control" id="credit_cash" name="status">
                                <option value="">Select</option>
                                <option value="cashinvoice" <?=($status=='cashinvoice')?'selected="selected"':''; ?>>Cash Invoice</option>
                                <option value="creditinvoice" <?=($status=='creditinvoice')?'selected="selected"':''; ?>>Credit Invoice</option>
                                <option value="delivery" <?=($status=='delivery')?'selected="selected"':''; ?>>Delivery</option>
                                <option value="predelivery" <?=($status=='predelivery')?'selected="selected"':''; ?>>Predelivery</option>
                                <option value="enquiry" <?=($status=='enquiry')?'selected="selected"':''; ?>>Enquiry</option>
                             </select>
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
                    <section class="panel">
                        <div class="panel-body" id="transfer_dc">
                          <h3 class="visible-print"><?=$page_title; ?></h3>
                          <div class="col-sm-4">
                            <strong class="visible-print">Printed By : <?=$this->session->userdata('display_name'); ?></strong>
                          </div>
                          <div class="col-sm-4">
                             <strong class="screen-only"><?=$page_title.' - '.$status; ?></strong>
                          </div>
                          <div class="col-sm-4 text-right">
                             <strong class="visible-print">Print Date : <?=date("d-M-y g:i A"); ?></strong>
                          </div>
                          <?php if($status =='creditinvoice'): ?>
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Concern</th>
                                        <th>Customer </br> Delivery Address</th>
                                        <th>Name </br> Mobile No</th>
                                        <th>Selected DC</th>
                                        <th>Invoice Items</th>
                                        <th>Selected Boxes</th>
                                        <th>Amount</th>
                                        <TH>Deleted By</TH>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($credit_invoices_list) > 0): ?>
                                      <?php foreach($credit_invoices_list as $row): ?>
                                            <?php
                                            $item_names = array();
                                            $item_boxes = array();
                                            $dcs=array();
                                            $check=1;
                                            $invoices_items =$this->Sales_model->get_credit_inv_items($row->invoice_id,'',0);
                                            if(sizeof($invoices_items) > 0)
                                            {
                                                foreach ($invoices_items as $item) {
                                                    $item_names[$item->item_id] = $item->item_name;
                                                    $item_boxes[$item->box_id] = $item->box_prefix.$item->box_no;
                                                    $dcs[$item->delivery_id]=$item->delivery_id;
                                                    if(!empty($item_id)){
                                                      if($item_id==$item->item_id){
                                                      $check=0;
                                                      }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                              continue;
                                            }
                                            if (!empty($item_id)&&($check==1)) {
                                              continue;
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo $row->invoice_no; ?></td>
                                                <td><?php echo date("d-m-Y g:i a", strtotime($row->invoice_date)); ?></td>
                                                <td><?php echo $row->concern_name; ?></td>
                                                <td><?php echo $row->cust_name; ?><br><?php echo $row->del_cust_name; ?></td>
                                                <td><?php echo $row->name; ?><br><?php echo $row->mobile_no; ?></td>
                                                <td><?php echo implode(", ", $dcs); ?></td>
                                                <td><?php echo implode(", ", $item_names); ?></td>
                                                <td><?php echo implode(", ", $item_boxes); ?></td>
                                                <td><?php echo $row->invoice_amt; ?></td>

                                                <td><?=$row->last_edited_by.' On '.date("d-M-y h:ma", strtotime($row->last_edited_time)); ?></td>
                                                <td><?=$row->remarks; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                      <?php endif; ?>    
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php if($status =='cashinvoice'): ?>
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Concern</th>
                                        <th>Customer </br> Delivery Address</th>
                                        <th>Name </br> Mobile No</th>
                                        <th>Selected DC</th>
                                        <th>Invoice Items</th>
                                        <th>Selected Boxes</th>
                                        <th>Amount</th>
                                        <TH>Deleted By</TH>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($cash_invoices_list) > 0): ?>
                                        <?php foreach($cash_invoices_list as $row): ?>
                                            <?php
                                            $item_names = array();
                                            $item_boxes = array();
                                            $dcs=array();
                                            $check=1;
                                            $invoices_items =$this->Sales_model->get_cash_inv_items($row->invoice_id,'',0);
                                            if(sizeof($invoices_items) > 0)
                                            {
                                                foreach ($invoices_items as $item) {
                                                    $item_names[$item->item_id] = $item->item_name;
                                                    $item_boxes[$item->box_id] = $item->box_prefix.$item->box_no;
                                                    $dcs[$item->delivery_id]=$item->delivery_id;
                                                    if(!empty($item_id)){
                                                      if($item_id==$item->item_id){
                                                      $check=0;
                                                      }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                              continue;
                                            }
                                            if (!empty($item_id)&&($check==1)) {
                                              continue;
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo $row->invoice_no; ?></td>
                                                <td><?php echo date("d-m-Y g:i a", strtotime($row->invoice_date)); ?></td>
                                                <td><?php echo $row->concern_name; ?></td>
                                                <td><?php echo $row->cust_name; ?><br><?php echo $row->del_cust_name; ?></td>
                                                <td><?php echo $row->name; ?><br><?php echo $row->mobile_no; ?></td>
                                                <td><?php echo implode(", ", $dcs); ?></td>
                                                <td><?php echo implode(", ", $item_names); ?></td>
                                                <td><?php echo implode(", ", $item_boxes); ?></td>
                                                <td><?php echo $row->invoice_amt; ?></td>
                                                <td><?=$row->last_edited_by.' On '.date("d-M-y h:ma", strtotime($row->last_edited_time)); ?></td>
                                                <td><?=$row->remarks; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                      <?php endif; ?>  
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php if($status =='enquiry'): ?>
                              <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Concern</th>
                                        <th>Customer </br> Delivery Address</th>
                                        <th>Name </br> Mobile No</th>
                                        <th>Selected DC</th>
                                        <th>Invoice Items</th>
                                        <th>Selected Boxes</th>
                                        <th>Amount</th>
                                        <th>Deleted by</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($enquiry_list) > 0): ?>
                                        <?php foreach($enquiry_list as $row): ?>
                                            <?php
                                            $item_names = array();
                                            $item_boxes = array();
                                            $dcs=array();
                                            $check=1;
                                            $invoices_items =$this->Sales_model->get_quotation_items($row->quotation_id,'',0);
                                            if(sizeof($invoices_items) > 0)
                                            {
                                                foreach ($invoices_items as $item) {
                                                    $item_names[$item->item_id] = $item->item_name;
                                                    $item_boxes[$item->box_id] = $item->box_prefix.$item->box_no;
                                                    $dcs[$item->delivery_id]=$item->delivery_id;
                                                    if(!empty($item_id)){
                                                      if($item_id==$item->item_id){
                                                      $check=0;
                                                      }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                              continue;
                                            }
                                            if (!empty($item_id)&&($check==1)) {
                                              continue;
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo $row->quotation_no; ?></td>
                                                <td><?php echo date("d-m-Y g:i a", strtotime($row->quotation_date)); ?></td>
                                                <td><?php echo $row->concern_name; ?></td>
                                                <td><?php echo $row->cust_name; ?><br><?php echo $row->del_cust_name; ?></td>
                                                <td><?php echo $row->name; ?><br><?php echo $row->mobile_no; ?></td>
                                                <td><?php echo implode(", ", $dcs); ?></td>
                                                <td><?php echo implode(", ", $item_names); ?></td>
                                                <td><?php echo implode(", ", $item_boxes); ?></td>
                                                <td><?php echo $row->quotation_amt; ?></td>
                                                <td><?=$row->last_edited_by.' On '.date("d-M-y h:ma", strtotime($row->last_edited_time)); ?></td>
                                                <td><?=$row->remarks; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php if($status =='predelivery'): ?>
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Date</th>
                                        <th width="5%">SPDC No</th>
                                        <th width="15%">Customer</th>
                                        <th width="10%">Items</th>
                                        <th width="20%">Boxes</th>
                                        <th width="15%">Deleted By</th>
                                        <th width="20%">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($predelivery_list) > 0): ?>
                                        <?php foreach($predelivery_list as $row): ?>
                                            <?php
                                            $item_names = array();
                                            $item_boxes = array();
                                            $check=1;
                                            $predc_items = $this->Predelivery_model->get_predc_items($row->p_delivery_id,'',0);
                                            if(sizeof($predc_items) > 0)
                                            {
                                                foreach ($predc_items as $item) {
                                                    $item_names[$item->item_id] = $item->item_name;
                                                    $item_boxes[$item->box_id] = $item->box_prefix.$item->box_no;
                                                    if(!empty($item_id)){
                                                      if($item_id==$item->item_id){
                                                      $check=0;
                                                      }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                              continue;
                                            }
                                            if (!empty($item_id)&&($check==1)) {
                                              continue;
                                            }
                                            ?>
                                            <tr>
                                                <td><?=$sno++; ?></td>
                                                <td><?=date("d-M-y", strtotime($row->p_delivery_date)); ?></td>
                                                <td><?=$row->p_delivery_id; ?></td>
                                                <td><?=$row->cust_name; ?></td>
                                                <td><?=implode(", ", $item_names); ?></td>
                                                <td><?=implode(", ", $item_boxes); ?></td>
                                                <td><?=$row->last_edited_by.' On '.date("d-M-y h:ma", strtotime($row->p_delivery_lt_edtd_time)); ?></td>
                                                <td><?=$row->remarks; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php if($status =='delivery'): ?>
                              <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Date</th>
                                        <th width="5%">SDC No</th>
                                        <th width="15%">Customer</th>
                                        <th width="10%">Items</th>
                                        <th width="20%">Boxes</th>
                                        <th width="15%">Deleted By</th>
                                        <th width="20%">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($delivery_list) > 0): ?>
                                        <?php foreach($delivery_list as $row): ?>
                                            <?php
                                            $item_names = array();
                                            $item_boxes = array();
                                            $check=1;
                                            $delivery_items = $this->Delivery_model->get_delivery_items($row->delivery_id,null,0);
                                            if(sizeof($delivery_items) > 0)
                                            {
                                                foreach ($delivery_items as $item) {
                                                    $item_names[$item->item_id] = $item->item_name;
                                                    $item_boxes[$item->box_id] = $item->box_prefix.$item->box_no;
                                                    if(!empty($item_id)){
                                                      if($item_id==$item->item_id){
                                                      $check=0;
                                                      }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                              continue;
                                            }
                                            if (!empty($item_id)&&($check==1)) {
                                              continue;
                                            } 
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo date("d-m-Y g:i A", strtotime($row->delivery_date)); ?></td>
                                                <td><?php echo $row->dc_no; ?></td>
                                                <td><?php echo $row->cust_name; ?></td>
                                                <td><?php echo implode(", ", $item_names); ?></td>
                                                <td><?php echo implode(", ", $item_boxes); ?></td>
                                                <td><?=$row->last_edited_by.' On '.date("d-M-y h:ma", strtotime($row->delivery_lt_edtd_time)); ?></td>
                                                <td><?=$row->remarks; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    var index = $(".dataTables").find('th:last').index();
    oTable01 = $('.dataTables').dataTable({
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "sPaginationType": "bootstrap",
        "bPaginate": false,
        "bSort": true,
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
</script>
</body>
</html>