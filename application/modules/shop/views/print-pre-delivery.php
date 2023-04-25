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
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Shop Pre Delivery
                        </header>
                        <?php
                        $box_list = array();
                        $predc_items = $this->Predelivery_model->get_predc_items($predc->p_delivery_id);
                        if(sizeof($predc_items) > 0)
                        {
                            foreach ($predc_items as $item) {
                                $lot_no = ($item->lot_no != '') ? $item->lot_no : '0' ;
                                $box_list[$item->lot_no][] = $item;
                            }
                        }
                        /*echo "<pre>";
                        print_r($box_list);
                        echo "</pre>";*/
                        ?>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered invoice-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="11" class="text-center" align="center">
                                            SHOP STOCK CHECKLIST
                                        </th>
                                    </tr>                                    
                                    <tr>
                                        <th colspan="6">
                                            SPDC NO: Shop/<?php echo $predc->p_dc_no; ?>
                                        </th>
                                        <th colspan="5" class="text-right" align="right">
                                            <?php echo date("d-m-Y g:i a", strtotime($predc->p_delivery_date)); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Box No</th>
                                        <th>Stock Room</th>
                                        <th>Item name/code</th>
                                        <th>Shade name/code</th>
                                        <th>Shade No</th>
                                        <th>Lot No</th>
                                        <th>#Cones</th>
                                        <th>Gr.Wt</th>
                                        <th>Nt.Wt</th>
                                        <th>Lot Nt.Wt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tot_boxes = 0;
                                    $tot_no_cones = 0;
                                    $tot_gr_weight = 0;
                                    $tot_nt_weight = 0;
                                    $sno = 1;
                                    ?>
                                    <?php if(count($box_list) > 0): ?>
                                        <?php foreach($box_list as $lot_no => $boxes): ?>
                                            <?php if(sizeof($boxes) > 0): ?>
                                                <?php
                                                $row_key = 1;
                                                $lot_net_weight = 0;
                                                ?>
                                                <?php foreach($boxes as $box): ?>
                                                    <?php
                                                    $lot_net_weight += $box->delivery_qty;
                                                    $tot_no_cones += $box->no_cones;
                                                    $tot_gr_weight += $box->gr_weight;
                                                    $tot_nt_weight += $box->delivery_qty;
                                                    $tot_boxes++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sno++; ?></td>
                                                        <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                                                        <td><?php echo $box->stock_room_name; ?></td>
                                                        <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
                                                        <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
                                                        <td><?php echo $box->shade_code; ?></td>
                                                        <td><?php echo $box->lot_no; ?></td>
                                                        <td><?php echo $box->no_cones; ?></td>
                                                        <td><?php echo $box->gr_weight; ?></td>
                                                        <td><?php echo $box->delivery_qty; ?></td>
                                                        <?php if($row_key++ == sizeof($boxes)): ?>
                                                            <td><?php echo number_format($lot_net_weight, 3, '.', ''); ?></td>
                                                        <?php else: ?>
                                                            <td></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td><strong><?php echo $tot_boxes; ?></strong></td>
                                        <td>Boxes</td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Total</strong></td>
                                        <td></td>
                                        <td><strong><?php echo $tot_no_cones; ?></strong></td>
                                        <td><strong><?php echo number_format($tot_gr_weight, 3, '.', ''); ?></strong></td>
                                        <td><strong><?php echo number_format($tot_nt_weight, 3, '.', ''); ?></strong></td>
                                        <td><strong><?php echo number_format($tot_nt_weight, 3, '.', ''); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="11">
                                            REMARKS: <?php echo $predc->remarks; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" valign="top" style="vertical-align:top;">
                                            <strong>From:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $predc->concern_name; ?></strong><br>
                                            <?php echo $predc->concern_address; ?><br>
                                            <!-- TIN: <?php echo $predc->concern_tin; ?>, -->
                                            CST: <?php echo $predc->concern_gst; ?>
                                        </th>
                                        <th colspan="3" valign="top" style="vertical-align:top;">
                                            <strong>To:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $predc->cust_name; ?></strong><br>
                                            <?php echo $predc->cust_address; ?>
                                            <?php echo $predc->cust_city; ?><br>
                                            <!-- TIN: <?php echo $predc->cust_tinno; ?>, -->
                                            CST: <?php echo $predc->cust_gst; ?>
                                        </th>
                                        <th colspan="4" valign="top" style="vertical-align:top;">
                                            <strong>Delivery Address:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $predc->del_cust_name; ?></strong><br>
                                            <?php echo $predc->del_cust_address; ?>
                                            <?php echo $predc->del_cust_city; ?><br>
                                            PARTY NAME: <?php echo $predc->name; ?><br>
                                            MOBILE NO: <?php echo $predc->mobile_no;?>
                                        </th>
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