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
                <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>shop/registers/irr_report_sh">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title; ?>
                           </header>
                           <div class="panel-body">
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
                                 <label for="color_family">Shade Family </label>
                                 <select class="form-control select2" id="color_family" name="family_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shade_family as $row) {
                                      ?>
                                      <option value="<?=$row['family_id']; ?>" <?=($row['family_id'] == $family_id)?'selected="selected"':''; ?> ><?=$row['family_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="color_name">Shade Category</label>
                                 <select class="form-control select2" id="color_category" name="category_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shade_category as $row) {
                                      ?>
                                      <option value="<?=$row['category_id']; ?>" <?=($row['category_id'] == $category_id)?'selected="selected"':''; ?> ><?=$row['color_category']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="color_name">Shade Name </label>
                                 <select class="form-control select2 color" id="color_name" name="shade_name">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $row) {
                                      ?>
                                      <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?> ><?=$row['shade_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                               <div class="form-group col-lg-3">
                                 <label for="color_code">Shade Code</label>          
                                 <select class="form-control select2 color" id="color_code" name="shade_id">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $row) {
                                      ?>
                                      <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?> ><?=$row['shade_id']; ?></option>
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
                          </div>
                          <div class="col-sm-4">
                             <strong><?=$page_title; ?></strong>
                          </div>
                          <div class="col-md-4 text-right">
                             <strong>Print Date : <?=date("d-m-Y H:i:s"); ?></strong>
                          </div>
                            <table class="table table-bordered dataTables">
                                <thead>
                                 <th>#</th>  
                                 <th>Item Name</th>
                                 <th>Shade Name</th>
                                 <th>Shade Family</th>
                                 <th>Shade Category</th>
                                 <th>Customer Name</th>
                                 <th>Active Rate</th>
                                 <th>Created By</th>
                                 <th>Inactive Rates</th>
                              </thead>
                              <tbody>
                              <?php
                                 $sno=1;
                                    if($irr_details)
                                    {
                                    foreach ($irr_details as $irr) {
                                       $rates=explode(',', $irr->item_rates);
                                       $user_ids=explode(',',$irr->rate_changed_by);
                                       $datetime=explode(',',$irr->rate_changed_on);
                                       foreach ($user_ids as $key=>$id) {
                                          $data=$this->m_users->getuserdetails($id);
                                          $user_name[]=($data)?$data[0]['display_name']:'';
                                       }
                                       ?>
                                       <tr>
                                          <td><?=$sno; ?></td>
                                          <td><?=$irr->item_name.'/'.$irr->item_id;?></td>
                                          <td><?=$irr->shade_name;?></td>
                                          <td><?=$irr->family_name;?></td>
                                          <td><?=$irr->color_category;?></td> 
                                          <td><?=$irr->cust_name.'/'.$irr->customer_id;?></td>
                                          <td><?=$rates[$irr->item_rate_active];?></td> 
                                          <td><?=$user_name[$irr->item_rate_active].'/'.date('d-M-y H:i',strtotime($datetime[$irr->item_rate_active]));?></td> 
                                          <td><?php
                                          for ($count=count($rates)-1; $count >= 0 ; $count--){
                                             if($count==$irr->item_rate_active)
                                                continue;
                                              ?>
                                             <font color='red' ><?=$rates[$count];?></font>
                                             <?php
                                             echo '/'.$user_name[$count].'/'.date('d-M-y H:i',strtotime($datetime[$count])).',';
                                          }
                                          ?>
                                          </td>
                                       </tr>
                                       <?php
                                       $sno++;
                                    }
                                 }
                              ?>
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
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });

    var index = $(".dataTables").find('th:last').index();
    oTable01 = $('.dataTables').dataTable({
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "sPaginationType": "bootstrap",
        "bPaginate": false,
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
      $(".color").change(function(){
        $("#color_name").select2("val", $(this).val());
        $("#color_code").select2("val", $(this).val());
      });
      $(".get_cust_detail").change(function(){
        $("#customer_name").select2("val", $(this).val());
        $("#customer_id").select2("val", $(this).val());       
        return false;
      });
</script>
</body>
</html>