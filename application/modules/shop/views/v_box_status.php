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
                <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>shop/registers/box_status">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <strong>Box Status Shop</strong>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label >Box Prefix</label>
                                 <input type="text" value="<?=$box_prefix; ?>" class="form-control"  name="box_prefix">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label >Box No</label>
                                 <input type="text" value="<?=$box_no; ?>" class="form-control"  name="box_no">
                              </div>

                              <div class="form-group col-lg-3">
                                 <label >From Box No:</label>
                                 <input type="text" value="<?=$f_box_no; ?>" class="form-control"  name="from_box_no">
                              </div>

                              <div class="form-group col-lg-3">
                                 <label >To Box No:</label>
                                 <input type="text" value="<?=$t_box_no; ?>" class="form-control"  name="to_box_no">
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
                         <?php if(sizeof($box_detail) > 0){ ?>
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Box no</th>
                                        <th>Date</th>
                                        <th>Packed by</th>
                                        <th>STDC No</th>
                                        <th>Remarks</th>
                                        <th>Deleted Status</th>
                                        <th>Packed  Qty</th>
                                        <th>Pre DC Qty</th>
                                        <th>DC Qty</th>
                                        <th>Invoiced Qty</th>
                                        <th>Stock Qty</th>                           </tr>
                                </thead>
                                <?php
                                $sno = 1;
                                ?>
                                <tbody>
                                    <?php foreach($box_detail as $box): ?>
                                    <?php
                                        $stdc_no=$this->Stocktrans_model->get_stdc_id($box->box_id);
                                        $p_dcs=$this->Predelivery_model->get_predc_id($box->box_id);
                                        $dcs=$this->Delivery_model->get_dc_id($box->box_id);
                                        $inv=$this->Register_model->get_inv_id($box->box_id);
                                        $is_deleted=($box->is_deleted)?'Deleted by '.$box->deleted_by.' on '.date('d-M-y',strtotime($box->deleted_on)).' Remarks: '.$box->deleted_remarks:'';

                                    ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($box->packed_on)); ?></td>
                                            <td><?php echo $box->prepared_by;?></td>
                                            <td><?php echo $stdc_no; ?></td>
                                            <td><?php echo $box->remarks?></td>
                                            <td><?php echo $is_deleted; ?></td>
                                            <td><?php echo $box->nt_weight; ?></td>
                                            <td><?php  
                                                $p_dc_qty=null;
                                                foreach ($p_dcs as $result) {
                                                  $p_dc_qty+=$result['delivery_qty'];
                                                  echo 'shop/'.$result['p_delivery_id'].'=';
                                                  ?>
                                                  <span class='text-danger'><?=$result['delivery_qty']?></span>
                                                  <?php
                                                  echo ';  ';
                                                }?></td>
                                            <td><?php       
                                              foreach ($dcs as $result) {
                                                echo 'shop/'.$result['delivery_id'].'=';
                                                ?>
                                                <span class='text-danger'><?=$result['delivery_qty']?></span>
                                                <?php
                                                echo ';  ';
                                              } ?></td>
                                            <td><?php
                                              foreach ($inv['cash'] as $result) {
                                                  echo 'shop/'.$result['invoice_no'].'=';
                                                ?>
                                                <span class='text-danger'><?=$result['delivery_qty']?></span>
                                                <?php
                                                echo ';  ';               
                                              }
                                              foreach ($inv['credit'] as $result) {
                                                echo 'shop/'.$result['invoice_no'].'=';
                                                ?>
                                                <span class='text-danger'><?=$result['delivery_qty']?></span>
                                                <?php
                                                echo ';  ';               
                                              }
                                              foreach ($inv['quote'] as $result) {
                                                  echo 'shop/'.$result['quotation_no'].'=';
                                                ?>
                                                <span class='text-danger'><?=$result['delivery_qty']?></span>
                                                <?php
                                                echo ';  ';
                                              }?></td>
                                            <td><?php echo round($box->nt_weight-$p_dc_qty,3); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>       
                            <?php } 
                             else { ?>
                                <span align='center'><h3><strong class='text-danger'>These boxes are not received in shop. Pls Check with Indofila Unit 1 Data.If not found in unit 1 data,contact Admin</strong></h3></span>
                            <?php } ?>
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
</script>
</body>
</html>