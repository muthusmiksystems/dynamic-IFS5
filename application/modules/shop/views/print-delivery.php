<?php include APPPATH.'views/html/header.php'; ?>
    <style type="text/css">
        @media print{
          @page{
            margin: 3mm;
          }
          thead {display: table-row-group !important;}
      }
    </style>
	<section id="main-content">
		<section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Shop Delivery
                        </header>
                        <?php
                        $box_list = array();
                        $delivery_items = $this->Delivery_model->get_delivery_items($delivery->delivery_id);
                        if(sizeof($delivery_items) > 0)
                        {
                            foreach ($delivery_items as $item) {
                                $lot_no = ($item->lot_no != '') ? $item->lot_no : '0' ;
                                $box_list[$item->lot_no][] = $item;
                            }
                        }
                        /*echo "<pre>";
                        print_r($delivery);
                        echo "</pre>";*/
                        ?>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered invoice-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="11" class="text-center" align="center">
                                            SHOP DELIVERY
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" valign="top" style="vertical-align:top;">
                                            <strong>From:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?=$delivery->concern_name; ?></strong><br>
                                            <?=$delivery->concern_address; ?><br>
                                            GST: <?=$delivery->concern_gst; ?>
                                                                           </th>
                                        <th colspan="3" valign="top" style="vertical-align:top;">
                                            <strong>To:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?=$delivery->cust_name; ?></strong><br>
                                            <?=$delivery->cust_address; ?>
                                            <?=$delivery->cust_city; ?><br>
                                            GST: <?=$delivery->cust_gst; ?>
                                                                        </th>
                                        <th colspan="4" valign="top" style="vertical-align:top;">
                                            <strong>Delivery Address:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?=$delivery->del_cust_name; ?></strong><br>
                                            <?=$delivery->del_cust_address; ?>
                                            <?=$delivery->del_cust_city; ?><br>
                                            PARTY NAME: <?=$delivery->name; ?><br>
                                            MOBILE NO: <?=$delivery->mobile_no;?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5">
                                            SDC NO: Shop/<?=$delivery->dc_no; ?>
                                        </th>
                                        <th colspan="6" class="text-right" align="right">
                                            <?=date("d-m-Y g:i a", strtotime($delivery->delivery_date)); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Box No</th>
                                        <th>Item name/code</th>
                                        <th>HSN Code</th>
                                        <th>Shade name/code</th>                                                    <th>Shade No</th>
                                        <th>Lot No</th>
                                        <th>#Cones</th>
                                        <th>Gr.Wt</th>
                                        <th>Nt.Wt</th>
                                        <th>Del.Nt.Wt / #Cones</th><!--ER-07-18#-9-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tot_boxes = 0;
                                    $tot_no_cones = 0;
                                    $tot_gr_weight = 0;
                                    $tot_nt_weight = 0;
                                    $tot_delv_net_weight=0;
                                    $sno = 1;
                                    ?>
                                    <?php if(count($box_list) > 0): ?>
                                        <?php foreach($box_list as $lot_no => $boxes): ?>
                                            <?php if(sizeof($boxes) > 0): ?>
                                                <?php
                                                $row_key = 1;
                                                $delv_net_weight = 0;
                                                ?>
                                                <?php foreach($boxes as $box): ?>
                                                    <?php
                                                    $delv_net_weight += $box->delivery_qty;
                                                    $tot_no_cones += $box->no_cones;
                                                    $tot_gr_weight += $box->gr_weight;
                                                    $tot_nt_weight += $box->nt_weight;
                                                    $tot_delv_net_weight += $box->delivery_qty;
                                                    $tot_boxes++;
                                                    ?>
                                                    <tr>
                                                        <td><?=$sno++; ?></td>
                                                        <td><?=$box->box_prefix; ?><?=$box->box_no; ?></td>
                                                        <td><?=$box->item_name; ?>/<?=$box->item_id; ?></td>
                                                        <td><?=$box->hsn_code; ?></td>
                                                        <td><?=$box->shade_name; ?>/<?=$box->shade_id; ?></td>
                                                        <td><?=$box->shade_code; ?></td>
                                                        <td><?=$box->lot_no; ?></td>
                                                        <td><?=$box->no_cones; ?></td>
                                                        <td><?=$box->gr_weight; ?></td>
                                                        <td><?=$box->nt_weight; ?></td>
                                                        <?php //if($row_key++ == sizeof($boxes)): ?>
                                                        <td><?=$box->delivery_qty; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><strong><?=$tot_boxes; ?></strong></td>
                                        <td>Boxes</td>
                                        <td></td>
                                        <td><strong>Total</strong></td>
                                        <td></td>
                                        <td><strong><?=$tot_no_cones; ?></strong></td>
                                        <td><strong><?=number_format($tot_gr_weight, 3, '.', ''); ?></strong></td>
                                        <td><strong><?=number_format($tot_nt_weight, 3, '.', ''); ?></strong></td>
                                        <td><strong><?=number_format($tot_delv_net_weight, 3, '.', ''); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="11">
                                            REMARKS: <?=$delivery->remarks; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="11">
                                            <div class="col-lg-12">
                                                <div class="print-div col-lg-3">
                                                    <strong>Received By</strong>
                                                    <br/>
                                                    <br/>
                                                </div>
                                                <div class="print-div col-lg-3" style="border-right:none;">
                                                    <strong>Prepared By</strong>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <?=$this->session->userdata('display_name'); ?>
                                                </div>
                                                <div class="print-div col-lg-3" style="border-right:none;">
                                                    <strong>Checked By</strong>
                                                    <br/>
                                                    <br/>
                                                </div>
                                                <div class="print-div right-align col-lg-3">
                                                    <strong>For <?=$delivery->concern_name; ?>.</strong>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    Auth.Signatury
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button class="btn btn-primary hidden-print" onclick="window.print()" type="button">Print</button>
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
</script>
</body>
</html>