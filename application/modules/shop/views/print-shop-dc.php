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
                            Stock Transfer DC
                        </header>
                        <?php
                        $to_users = array();
                        $to_user_ids = explode(",", $shop_dc->to_user_id);
                        if(count($to_user_ids) > 0)
                        {
                            foreach ($to_user_ids as $user_id) {
                                $user = $this->Stocktrans_model->get_user($user_id);
                                if($user)
                                {
                                    $to_users[$user->ID] = $user->display_name;
                                }
                            }
                        }
                        ?>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered invoice-table" style="width:100%;" id="shop_cr_invoice">
                                <thead>
                                    <tr>
                                        <th colspan="10" class="text-center" align="center">
                                            <h4 style="font-weight:bold;margin:0px;">STOCK TRANSFER DC</h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" valign="top">
                                            <strong>From:&emsp;</strong>
                                            <?php echo $shop_dc->from_concern_name; ?><br>
                                            <?php echo $shop_dc->from_concern_addr; ?><br>
                                            GST:<?php echo $shop_dc->from_concern_gst; ?><br>
                                            From Staff: <?php echo $shop_dc->from_staff_name; ?>
                                        </th>
                                        <th colspan="5" valign="top">
                                            <strong>To:&emsp;</strong>
                                            <?php echo $shop_dc->to_concern_name; ?><br>
                                            <?php echo $shop_dc->to_concern_addr; ?><br>
                                            GST:<?php echo $shop_dc->to_concern_gst; ?><br>
                                            To Staff: <?php echo implode(",", $to_users); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5">
                                            DC NO: <span style="font-size:18px;">SHOP-<?php echo $shop_dc->id; ?></span>
                                        </th>
                                        <th colspan="5" class="text-right" align="right">
                                            <?php echo date("d-m-Y g:i a", strtotime($shop_dc->transfer_date)); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Box No</th>
                                        <th>Item name/code</th>
                                        <th>HSN code</th><!--Inclusion of HSN code-->
                                        <th>Shade name/code</th>
                                        <th>Shade No</th>
                                        <th>Lot No</th>
                                        <th>#Cones</th>
                                        <th>Gr.Wt</th>
                                        <th>Nt.Wt</th>
                                        <th>Lotwise Nt.Wt</th>
                                    </tr>
                                </thead>
                                <?php
                                $box_list = array();
                                $sno = 1;
                                $selected_boxes = explode(",", $shop_dc->selected_boxes);
                                if(count($selected_boxes) > 0)
                                {
                                    foreach($selected_boxes as $box_id)
                                    {
                                        $box = $this->Stocktrans_model->getPackingBox($box_id);
                                        if($box)
                                        {
                                            if($box->box_prefix == 'G' || $box->box_prefix == 'S')
                                            {
                                              $lot_no = $box->poy_lot_no;
                                            }
                                            else
                                            {
                                              $lot_no = $box->lot_no;
                                            }
                                            $box_list[$lot_no][] = $box;
                                        }
                                    }
                                }
                                $total_boxes = 0;
                                $total_cones = 0;
                                $total_gr_wt = 0;
                                $total_nt_wt = 0;
                                $total_lot_nt_wt = 0;
                                ?>
                                <tbody>
                                    <?php if(sizeof($box_list) > 0): ?>
                                        <?php foreach($box_list as $lot_no => $boxes): ?>
                                            <?php
                                            $lot_net_weight = 0;
                                            $row_key = 1;
                                            ?>
                                            <?php foreach($boxes as $box): ?>
                                                <?php
                                                $total_boxes++;
                                                $gross_weight = number_format($box->gross_weight, 3, '.', '');
                                                $net_weight = number_format($box->net_weight, 3, '.', '');

                                                $total_cones += $box->no_of_cones;
                                                $total_gr_wt += $gross_weight;
                                                $total_nt_wt += $net_weight;
                                                $lot_net_weight += $net_weight;
                                                $total_lot_nt_wt += $net_weight;
                                                ?>
                                                <tr>
                                                    <td><?php echo $sno++; ?></td>
                                                    <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                                                    <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
                                                    <td><?=$box->hsn_code; ?></td><!--Inclusion of HSN code-->
                                                    <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
                                                    <td><?php echo $box->shade_code; ?></td>
                                                    <td><?php echo $lot_no; ?></td>
                                                    <td><?php echo $box->no_of_cones; ?></td>
                                                    <td><?php echo $gross_weight; ?></td>
                                                    <td><?php echo $net_weight; ?></td>
                                                    <?php if($row_key++ == sizeof($boxes)): ?>
                                                        <td><?php echo number_format($lot_net_weight, 3, '.', ''); ?></td>
                                                    <?php else: ?>
                                                        <td></td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>                                                            </tbody>
                                <tfoot>
                                    <tr class="total" style="border-bottom: 1px solid #000;">
                                        <th>Total</th>
                                        <th><?php echo $total_boxes; ?></th>
                                        <th>Boxes</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php echo $total_cones; ?></th>
                                        <th><?php echo $total_gr_wt; ?></th>
                                        <th><?php echo $total_nt_wt; ?></th>
                                        <th><?php echo $total_lot_nt_wt; ?></th>
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
                                                    <?php echo $this->session->userdata('display_name'); ?>
                                                </div>
                                                <div class="print-div col-lg-3" style="border-right:none;">
                                                    <strong>Checked By</strong>
                                                    <br/>
                                                    <br/>
                                                </div>
                                                <div class="print-div right-align col-lg-3">
                                                    <strong>For <?php echo $shop_dc->from_concern_name; ?>.</strong>
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