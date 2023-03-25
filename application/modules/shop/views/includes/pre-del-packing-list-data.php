<?php
$tot_boxes = 0;
$tot_gr_weight = 0;
$tot_nt_weight = 0;
$tot_bal_weight = 0;
if (sizeof($boxes) > 0) {
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
if (sizeof($scapsales_boxes) > 0) {
    foreach ($scapsales_boxes as $row) {
        if (isset($scapsales_qty_array[$row->box_id])) {
            $scapsales_qty_array[$row->box_id] += $row->nt_weight;
        } else {
            $scapsales_qty_array[$row->box_id] = $row->nt_weight;
        }
    }
}

$sno = 1;
$dataArr = [];

if (sizeof($boxes) > 0) :
    foreach ($boxes as $box) :

        $no_cones = $box->no_cones;
        $tot_delivery_qty = $box->tot_predc_temp_qty + $box->tot_predc_qty;
        $tot_dc_qty = $box->tot_dc_qty;
        $tot_quote_qty = $box->tot_quote_qty;
        $tot_predc_temp_qty = $this->m_masters->get_tot_field_value('bud_sh_predel_items_temp', 'delivery_qty', array('box_id' => $box->box_id));
        $tot_predc_qty = $this->m_masters->get_tot_field_value('bud_sh_predel_items', 'delivery_qty', array('box_id' => $box->box_id, 'p_delivery_is_deleted' => 1)); //ER-07-18#-1
        $tot_pk_qty = ($box->box_prefix == 'TH') ? $box->no_cones : $box->nt_weight; //ER-07-18#-6
        $bal_qty = $tot_pk_qty - ($tot_predc_temp_qty + $tot_predc_qty); //ER-07-18#-6
        $reserved_stock = $tot_delivery_qty - $tot_dc_qty;

        $box_bal_qty = $bal_qty + $tot_quote_qty;

        $scapsales_qty = (isset($scapsales_qty_array[$box->box_id])) ? $scapsales_qty_array[$box->box_id] : 0;
        $box_bal_qty -= $scapsales_qty;

        if ($bal_qty > 0) :

            $sbutton = "showAjaxModal('" . base_url('shop/predelivery/edit_stock_room/' . $box->box_id) . "')";
            $item_group_id = ($box->item_group_id != '0') ? '$i' . $box->item_group_id : '';

            $dataArr[] = array(
                $sno++,
                $box->box_prefix . $box->box_no,
                $item_group_id,
                $box->item_name . '/' . $box->item_id,
                $box->shade_name . '/' . $box->shade_id,
                '<span class="text-danger">' . $box->shade_code . '</span>',
                $box->lot_no,
                '<span class="text-danger">' . $box->stock_room_name . '</span>',
                $no_cones,
                '<span class="box-gr-wt' . $box->box_id . '">' . $box->gr_weight . '</span>',
                '<span class="box-nt-wt' . $box->box_id . '">' . $box->nt_weight . '</span>',
                '<span class="text-blue box-nt-wt">' . (($box->box_prefix == 'TH') ? $bal_qty . ' Cones' : number_format($bal_qty, 3, '.', '')) . '</span>',
                '<span style="' . (($box->color_code != '') ? 'display: block;background-color:' . $box->color_code : '') . '">' . (($bal_qty > 0) ? '<input type="checkbox" class="chkBoxId" value="' . $box->box_id . '">' : '') . '</span>',
                '<span>' . (($tot_delivery_qty > 0) ? '<label class="badge btn-danger">O.B</label>' : '') . '<button onclick="' . $sbutton . '" class="btn btn-xs btn-primary">E.S.R</button>' . (($reserved_stock > 0) ? '<label class="badge bg-warning">RES</label>' : '') . (($tot_quote_qty > 0) ? '<label class="badge bg-success">RES</label>' : '') . '</span>'
            );

        endif;
    endforeach;
endif;

$result = array(
    'data' => $dataArr,
    'tot_boxes' => $tot_boxes,
    'tot_gr_weight' => $tot_gr_weight,
    'tot_nt_weight' => $tot_nt_weight,
    'tot_bal_weight' => $tot_bal_weight
);
echo str_replace('\"', '', str_replace('\/', '/', json_encode($result)));
