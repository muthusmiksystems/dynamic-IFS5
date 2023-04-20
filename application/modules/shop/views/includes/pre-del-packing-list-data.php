<?php

/*echo "<pre>";

print_r($boxes);

echo "</pre>";*/

$tot_boxes = 0;

$tot_gr_weight = 0;

$tot_nt_weight = 0;

$tot_bal_weight = 0;

if(sizeof($boxes) > 0)

{

    foreach ($boxes as $box) {

        $tot_boxes++;

        $tot_gr_weight += $box->gr_weight;

        $tot_nt_weight += $box->nt_weight;

        $bal_qty = $box->nt_weight - ($box->tot_predc_temp_qty + $box->tot_predc_qty);

        $tot_bal_weight += $bal_qty;

    }

}



$scapsales_qty_array = array();

$scapsales_boxes = $this->Predelivery_model->get_scapsales_boxes();

if(sizeof($scapsales_boxes) > 0)

{

    foreach ($scapsales_boxes as $row) {

        if(isset($scapsales_qty_array[$row->box_id]))

        {

            $scapsales_qty_array[$row->box_id] += $row->nt_weight;

        }

        else

        {

            $scapsales_qty_array[$row->box_id] = $row->nt_weight;

        }

    }

}



/*echo "<pre>";

print_r($scapsales_qty_array);

echo "</pre>";*/

?>

<table class="packing-boxes table table-bordered dataTables">

    <thead>

        <tr class="total-row">

            <th></th>

            <th><?php echo $tot_boxes; ?></th>

            <th></th>

            <th>Boxes</th>

            <th>Total Qty</th>

            <th></th>

            <th></th>

            <th></th>

            <th></th>

            <th><?php echo $tot_gr_weight; ?></th>

            <th><?php echo $tot_nt_weight; ?></th>

            <th><?php echo $tot_bal_weight; ?></th>

            <th></th>

            <th></th>

        </tr>

        <tr class="total-row">

            <th></th>

            <th class="cart-boxes">0</th>

            <th></th>

            <th>Boxes</th>

            <th>Total Qty</th>

            <th></th>

            <th></th>

            <th></th>

            <th></th>

            <th class="cart-gr-wt">0</th>

            <th class="cart-nt-wt">0</th>

            <th></th>

            <th></th>

            <th></th>

        </tr>

        <tr>

            <th>#</th>

            <th>Box no</th>

            <th>Grp</th>

            <th>Item name/<br>code</th>

            <th>Shade name/<br>code</th>

            <th>Shade no</th>

            <th>Lot no</th>

            <th>Stock Room</th>

            <th>#Con</th>

            <th>Gr.Wt</th>

            <th>Nt.Wt</th>

            <th>Bal.Qty</th>

            <th>

                <label>

                    <input type="checkbox" id="select_all">

                    All

                </label>

            </th>

            <th>Status</th>

        </tr>

    </thead>

    <tbody>

        <?php

        $sno = 1;

        ?>

        <?php if(sizeof($boxes) > 0): ?>

            <?php foreach($boxes as $box): ?>

                <?php

                $no_cones = $box->no_cones;

                $tot_delivery_qty = $box->tot_predc_temp_qty + $box->tot_predc_qty;

                $tot_dc_qty = $box->tot_dc_qty;

                $tot_quote_qty = $box->tot_quote_qty;

                $tot_predc_temp_qty=$this->m_masters->get_tot_field_value('bud_sh_predel_items_temp','delivery_qty',array('box_id'=>$box->box_id));

                $tot_predc_qty=$this->m_masters->get_tot_field_value('bud_sh_predel_items','delivery_qty',array('box_id'=>$box->box_id,'p_delivery_is_deleted'=>1));//ER-07-18#-1

                $tot_pk_qty=($box->box_prefix=='TH')?$box->no_cones:$box->nt_weight;//ER-07-18#-6

                $bal_qty = $tot_pk_qty - ($tot_predc_temp_qty + $tot_predc_qty);//ER-07-18#-6

                $reserved_stock = $tot_delivery_qty - $tot_dc_qty;



                // $bal_qty += $tot_quote_qty;

                $box_bal_qty = $bal_qty + $tot_quote_qty;



                $scapsales_qty = (isset($scapsales_qty_array[$box->box_id])) ? $scapsales_qty_array[$box->box_id] : 0 ;

                $box_bal_qty -= $scapsales_qty;

                ?>

                <?php //if($bal_qty > 0 || $reserved_stock > 0 || $tot_quote_qty > 0): ?>

                <?php //if($box_bal_qty > 0): ?>

                <?php if($bal_qty > 0): ?>

                    <tr>

                        <td><?php echo $sno++; ?></td>

                        <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>

                        <td>

                            <?php echo ($box->item_group_id != '0')?'$i'.$box->item_group_id:''; ?>

                        </td>

                        <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>

                        <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>

                        <td class="text-danger"><?php echo $box->shade_code; ?></td>

                        <td><?php echo $box->lot_no; ?></td>

                        <td class="text-danger"><?php echo $box->stock_room_name; ?></td>

                        <td><?php echo $no_cones; ?></td>

                        <td class="box-gr-wt"><?php echo $box->gr_weight; ?></td>

                        <td><?php echo $box->nt_weight; ?></td>

                        <td class="text-blue box-nt-wt">

                            <?php 

                            //ER-07-18#-6

                            if($box->box_prefix=='TH'){

                                echo $bal_qty.' Cones'; 

                            }

                            else{

                                echo number_format($bal_qty, 3, '.', '');

                            }

                            //ER-07-18#-6

                            ?>

                        </td>

                        <td style="<?php echo ($box->color_code != '')?'background-color:'.$box->color_code:''; ?>">

                            <?php if($bal_qty > 0): ?>

                                <input type="checkbox" class="chkBoxId" value="<?php echo $box->box_id; ?>">

                            <?php endif; ?>

                            <?php //echo $tot_delivery_qty.'/'.$reserved_stock.'/'.$tot_dc_qty; ?>

                        </td>

                        <td>

                            <?php if($tot_delivery_qty > 0): ?>

                                <label class="badge btn-danger">O.B</label>

                            <?php endif; ?>

                            <button onclick="showAjaxModal('<?php echo base_url('shop/predelivery/edit_stock_room/'.$box->box_id); ?>')" class="btn  btn-xs btn-primary">E.S.R</button>

                            <?php if($reserved_stock > 0): ?>

                                <label class="badge bg-warning">RES</label>

                            <?php endif; ?>

                            <?php if($tot_quote_qty > 0): ?>

                                <label class="badge bg-success">RES</label>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    </tbody>

    <tfoot>

        <tr class="total-row">

            <th></th>

            <th><?php echo $tot_boxes; ?></th>

            <th></th>

            <th>Boxes</th>

            <th>Total Qty</th>

            <th></th>

            <th></th>

            <th></th>

            <th></th>

            <th><?php echo $tot_gr_weight; ?></th>

            <th><?php echo $tot_nt_weight; ?></th>

            <th><?php echo $tot_bal_weight; ?></th>

            <th></th>

            <th></th>

        </tr>

    </tfoot>

</table>