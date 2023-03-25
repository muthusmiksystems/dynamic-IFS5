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
            <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>shop/registers/rdc_report_sh">
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
                             <strong class="screen-only"><?=$page_title; ?></strong>
                          </div>
                          <div class="col-sm-4 text-right">
                             <strong class="visible-print">Print Date : <?=date("d-M-y g:i A"); ?></strong>
                          </div>
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Date</th>
                                        <th width="5%">SDC No</th>
                                        <th width="15%">Entered By</th>
                                        <th width="15%">Customer</th>
                                        <th width="5%">Box no</th>
                                        <th width="15%">Item Name</th>
                                        <th width="10%">Shade Name</th>
                                        <th width="5%">Del. Qty</th>
                                        <th width="5%">Ret. Nt. Wt.</th>
                                        <th width="5%">Ret. Cones</th>
                                        <th width="5%">Repacked Box No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($rdc_list) > 0): ?>
                                        <?php foreach($rdc_list as $row): ?>
                                          <?php
                                            $ret_box_no=$this->Delivery_model->get_rdc_box_no_sh($row->box_prefix,$row->item_id,$row->shade_id);
                                          ?>
                                            <tr>
                                                <td><?=$sno++; ?></td>
                                                <td><?=date("d-M-y H:ia", strtotime($row->entered_time)); ?></td>
                                                <td><?=$row->delivery_id; ?></td>
                                                <td><?=$row->display_name; ?></td>
                                                <td><?=$row->cust_name; ?></td>
                                                <td><?=$row->box_prefix.$row->box_no; ?></td>
                                                <td><?=$row->item_name; ?></td>
                                                <td><?=$row->shade_name; ?></td>
                                                <td><?=$row->delivery_qty; ?></td>
                                                <td><?=$row->return_qty; ?></td>
                                                <td><?=$row->return_cones; ?></td>
                                                <td><?=$ret_box_no; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>  
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