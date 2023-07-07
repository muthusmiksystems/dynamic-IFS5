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
            <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>shop/registers/inward_report_sh">
              <div class="row">
                 <div class="col-lg-12">
                    <section class="panel">                            
                       <header class="panel-heading">
                       <h3 style="font-size:20px"><?=$page_title; ?></h3>
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
                          <!--//ER-07-18#-25-->
                          <div class="form-group col-lg-3">
                             <label for="shade_id">Shade Code</label>
                             <select class="get_shade_detail form-control select2" id="shade_id" name="shade_id">
                                <option value="0">Select</option>
                                <?php
                                foreach ($shades as $row) {
                                  ?>
                                  <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$row['shade_code']; ?></option>
                                  <?php
                                }
                                ?>
                             </select>
                          </div>
                          <div class="form-group col-lg-3">
                             <label for="shade_id">Shade Name</label>
                             <select class="get_shade_detail form-control select2" id="shade_name" name="shade_id">
                                <option value="0">Select</option>
                                <?php
                                foreach ($shades as $row) {
                                  ?>
                                  <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$row['shade_name']; ?></option>
                                  <?php
                                }
                                ?>
                             </select>
                          </div>
                          <div class="form-group col-lg-3">
                             <label for="stock_room">Stock Room</label>
                             <select class="get_stock_detail form-control select2" id="stock_room" name="stock_room_id">
                                <option value="0">Select</option>
                                <?php
                                foreach ($stock_rooms as $row) {
                                  ?>
                                  <option value="<?=$row['stock_room_id']; ?>" <?=($row['stock_room_id'] == $stock_room_id)?'selected="selected"':''; ?>><?=$row['stock_room_name']; ?></option>
                                  <?php
                                }
                                ?>
                             </select>
                          </div>
                          <div class="form-group col-lg-3">
                             <label for="stock_delivered">Stock/Delivered</label>
                             <select class="form-control select2" id="stock_delivered" name="stock_delivered">
                                <option value="all" <?=($stock_delivered=='all')?'selected="selected"':''; ?>>All</option>
                                <option value="stock" <?=($stock_delivered=='stock')?'selected="selected"':''; ?>>Stock</option>
                                <option value="delivered" <?=($stock_delivered=='delivered')?'selected="selected"':''; ?>>Delivered</option>
                             </select>
                          </div>
                          <!--end of ER-07-18#-25-->
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
                          <?php
                           if($box_detail)
                           {
                              $tot_nt_wt=0;
                              $tot_gross_wt=0;
                              $tot_cones=0;
                              $tot_box=0;
                              $gr_tot_nt_wt=$this->m_masters->get_tot_field_value('bud_sh_packing','nt_weight',null);
                              $gr_tot_gross_wt=$this->m_masters->get_tot_field_value('bud_sh_packing','gr_weight',null);
                              $gr_tot_cones=$this->m_masters->get_tot_field_value('bud_sh_packing','no_cones',null);
                              $gr_tot_box=sizeof($this->m_masters->getallmaster('bud_sh_packing'));
                              foreach ($box_detail as $box) {
                                //ER-09-18#-61
                                $box_dc=$this->Register_model->get_box_dc_details($box['box_id']);
                                $dc_qty=array_sum($box_dc['dc_qty']);
                                $delivery_qty[$box['box_id']]=$dc_qty;
                                $dc_no[$box['box_id']]=implode(', ',$box_dc['dc']);
                                $cash[$box['box_id']]=implode(', ',$box_dc['cash']);
                                $credit[$box['box_id']]=implode(', ',$box_dc['credit']);
                                $quotation[$box['box_id']]=implode(', ',$box_dc['quotation']);
                                $dc_price[$box['box_id']]=array_sum($box_dc['dc_price']);
                                $cash_price[$box['box_id']]=array_sum($box_dc['cash_price']);
                                $credit_price[$box['box_id']]=array_sum($box_dc['credit_price']);
                                $quotation_price[$box['box_id']]=array_sum($box_dc['quotation_price']);
                                 //ER-07-18#-25
                                 //ER-09-18#-61
                                 $qty=($box['box_prefix']=='TH')?$box['no_cones']:$box['nt_weight'];
                                 $stock[$box['box_id']]=$qty-$dc_qty;//ER-09-18#-61
                                 if(($stock_delivered=='stock')&&($stock[$box['box_id']]<=0)){
                                    continue;
                                 }
                                 if(($stock_delivered=='delivered')&&($delivery_qty[$box['box_id']]<=0)){
                                    continue;
                                 }
                                 //end of ER-07-18#-25
                                 $tot_nt_wt+=$box['nt_weight'];
                                 $tot_gross_wt+=$box['gr_weight'];
                                 $tot_cones+=$box['no_cones'];
                                 $tot_box++;
                              }
                           }
                           if($box_detail){
                           ?>
                            <table class="table table-bordered dataTables table-condensed">
                                <thead>
                                 <tr>
                                    <th><strong class='text-danger'>Grand Total:<strong></th>
                                    <th><strong class='text-danger'><?=$gr_tot_box.' Boxes'; ?></strong></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong class='text-danger'><?=$gr_tot_cones.' Cones'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$gr_tot_gross_wt.' Kgs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$gr_tot_nt_wt.' Kgs'; ?></strong></th>
                                    <th></th><!--ER-07-18#-25-->
                                    <th></th><!--ER-07-18#-25-->
                                    <th></th><!--ER-09-18#-61-->
                                    <th></th><!--ER-09-18#-61-->
                                    <th></th><!--ER-09-18#-61-->
                                    <th></th><!--ER-09-18#-61-->
                                 </tr>
                                <tr>
                                    <th><strong class='text-danger'>Total:<strong></th>
                                    <th><strong class='text-danger'><?=$tot_box.' Boxes'; ?></strong></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong class='text-danger'><?=$tot_cones.' Cones'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$tot_gross_wt.' Kgs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$tot_nt_wt.' Kgs'; ?></strong></th>
                                    <th></th><!--ER-07-18#-25-->
                                    <th><strong class='text-danger'><?=array_sum($dc_price).' Rs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=array_sum($cash_price).' Rs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=array_sum($credit_price).' Rs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=array_sum($quotation_price).' Rs'; ?></strong></th>
                                    <th></th><!--ER-07-18#-25-->
                                 </tr>
                                 <tr>
                                    <th width="2%">#</th>  
                                    <th width="3%">Box No</th>
                                    <th width="5%">Item Name</th>
                                    <th width="5%">Shade Name</th>
                                    <th width="5%">Lot No </th>
                                    <th width="10%">Supplier ID</th>
                                    <th width="5%">Packed By</th>
                                    <th width="10%">Packed On</th>
                                    <th width="10%">Branch Name</th>
                                    <th width="3%"># Units</th>
                                    <th width="2%">Gr wt</th>
                                    <th width="5%">Net Wt</th>
                                    <th width="5%">Status</th><!--ER-07-18#-25-->
                                    <th width="5%">DC Qty</th>
                                    <th width="5%">Cash</th>
                                    <th width="5%">Credit</th>
                                    <th width="5%">Estimate</th>
                                    <th width="10%">Remarks</th><!--ER-07-18#-25-->
                                 </tr>
                              </thead>
                              <tfoot>
                                 <tr>
                                    <th><strong class='text-danger'>Total:<strong></th>
                                    <th><strong class='text-danger'><?=$tot_box.' Boxes'; ?></strong></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong class='text-danger'><?=$tot_cones.' Cones'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$tot_gross_wt.' Kgs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=$tot_nt_wt.' Kgs'; ?></strong></th>
                                    <th></th><!--ER-07-18#-25-->
                                    <th><strong class='text-danger'><?=array_sum($dc_price).' Rs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=array_sum($cash_price).' Rs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=array_sum($credit_price).' Rs'; ?></strong></th>
                                    <th><strong class='text-danger'><?=array_sum($quotation_price).' Rs'; ?></strong></th>
                                    <th></th><!--ER-07-18#-25-->
                                 </tr>
                              </tfoot>
                              <tbody>
                              <?php
                                 $sno=1;
                                 foreach ($box_detail as  $box){
                                    //ER-07-18#-25
                                    if(($stock_delivered=='stock')&&($stock[$box['box_id']]<=0)){
                                       continue;
                                    }
                                    if(($stock_delivered=='delivered')&&($delivery_qty[$box['box_id']]<=0)){
                                       continue;
                                    }
                                    //end of ER-07-18#-25
                                    ?>
                                    <tr>
                                       <td width="2%"><?=$sno; ?></td>
                                       <td width="3%"><?=$box['box_prefix'].$box['box_no'];?></td>
                                       <td width="10%"><?=$box['item_name'].'/'.$box['item_id'];?></td>
                                       <td width="10%"><?=$box['shade_name'].'/'.$box['shade_code'];?></td>
                                       <td width="5%"><?=$box['lot_no'];?></td>
                                       <td width="10%"><?=($box['supplier_id'])?:'UNIT 1';?></td>
                                       <td width="10%"><?=$box['prepared_by'];?></td>
                                       <td width="10%"><?=date('d-M-y H:i',strtotime($box['packed_on']));?></td>
                                       <td width="10%"><?=$box['stock_room_name'];?></td>
                                       <td width="2%"><?=$box['no_cones'];?></td>
                                       <td width="3%"><?=$box['gr_weight'];?></td>
                                       <td width="5%"><?=$box['nt_weight'];?></td>
                                       <!--ER-07-18#-25-->
                                       <td width="10%">
                                          <strong class='text-success'><?=($stock[$box['box_id']]!=0)?'stock :'.$stock[$box['box_id']]:''?></strong>
                                          <br>
                                          <strong class='text-info'><?=($delivery_qty[$box['box_id']]!=0)?'Delivered :'.$delivery_qty[$box['box_id']]:''?></strong>
                                       </td>
                                       <!--ER-07-18#-25-->
                                       <td width="5%"><?=$dc_no[$box['box_id']];?></td><!--ER-09-18#-61-->
                                       <td width="5%"><?=$cash[$box['box_id']];?></td><!--ER-09-18#-61-->
                                       <td width="5%"><?=$credit[$box['box_id']];?></td><!--ER-09-18#-61-->
                                       <td width="5%"><?=$quotation[$box['box_id']];?></td><!--ER-09-18#-61-->
                                       <td width="10"><?=$box['remarks'];?></td>
                                    </tr>
                                    <?php
                                    $sno++;
                                 }  
                                 ?>
                              </tbody>
                            </table>
                            <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
                        <?php
                        }
                        ?>
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
    $(".get_shade_detail").change(function(){
        $("#shade_name").select2("val", $(this).val());
        $("#shade_id").select2("val", $(this).val());       
        return false;
      });
</script>
</body>
</html>