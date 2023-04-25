<table class="table table-bordered">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Date</th>
            <th>Box No</th>
            <th>Item Name/Code</th>
            <th>Shade Name/Code</th>
            <th>Shade No</th>
            <th>Lot No</th>
            <th>Gr.Lot No</th>
            <th>#Cones</th>
            <th>Gr.Wt</th>
            <th>Nt.Wt</th>
            <th>Packed by</th>
            <th>
                <label class="checkbox-inline">
                    <input type="checkbox" id="select_all">
                    <b>Select All</b>
                </label>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1;
        ?>
        <?php if(sizeof($boxes) > 0): ?>
            <?php foreach($boxes as $box): ?>
                <?php
                $net_weight = number_format($box->net_weight, 3, '.', '');
                $no_of_cones = $box->no_of_cones + $box->no_of_cones_2;
                /*echo "<pre>";
                print_r($box);
                echo "</pre>";*/
                ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $box->packed_date; ?></td>
                    <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                    <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
                    <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
                    <td><?php echo $box->shade_code; ?></td>
                    <td><?php echo $box->lot_no; ?></td>
                    <td><?php echo $box->poy_lot_no; ?></td>
                    <td><?php echo $no_of_cones; ?></td>
                    <td><?php echo $box->gross_weight; ?></td>
                    <td><?php echo $net_weight; ?></td>
                    <td><?php echo $box->packed_by; ?></td>
                    <td>
                        <input type="checkbox" class="chkBoxId"  value="<?php echo $box->box_id; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>