<table class="table table-bordered" id="dataTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Box no</th>
            <th>Supplier</th>
            <th>Sup.DC.no</th>
            <th>Item name/code</th>
            <th>Shade name/code</th>
            <th>Shade number</th>
            <th>Lot no</th>
            <th>#Boxes</th>
            <th>#Cones</th>
            <th>Gr.Wt</th>
            <th>Nt.Wt</th>
            <th>Total lot wise Qty</th>
            <th>Remarks</th>
            <th>Prepared by</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1;
        ?>
        <?php if (sizeof($boxes) > 0) : ?>
            <?php foreach ($boxes as $box) : ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                    <td><?php echo $box->sup_name; ?></td>
                    <td><?php echo $box->supplier_dc_no; ?></td>
                    <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
                    <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
                    <td><?php echo $box->shade_code; ?></td>
                    <td><?php echo $box->lot_no; ?></td>
                    <td><?php echo $box->no_boxes; ?></td>
                    <td><?php echo $box->no_cones; ?></td>
                    <td><?php echo $box->gr_weight; ?></td>
                    <td><?php echo $box->nt_weight; ?></td>
                    <td><?php echo $box->nt_weight; ?></td>
                    <td><?php echo $box->remarks; ?></td>
                    <td><?php echo $box->user_nicename; ?></td>
                    <td><?php echo date("d-m-Y H:i", strtotime($box->packed_on)); ?></td>
                    <td>
                        <a href="<?php echo base_url('shop/packing/print_pack_slip/' . $box->box_id); ?>" target="_blank" class="btn btn-xs btn-primary">Packing Slip</a>
                        <?php if ($box->is_deleted == '0') { ?>
                            <button onclick="showAjaxModal('<?php echo base_url('shop/packing/confirm_delete/' . $box->box_id); ?>')" class="btn btn-xs btn-danger">Delete</button>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>