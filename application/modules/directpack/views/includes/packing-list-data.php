<table class="table table-bordered datatables dataTable">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Date</th>
            <th>Box No</th>
            <th>Item Name/Code</th>
            <th>Shade Name/Code</th>
            <th>Shade No</th>
            <th>S.Lot No</th>
            <th>M.Lot No</th>
            <th>#Cones</th>
            <th>Gr.Wt</th>
            <th>Nt.Wt</th>
            <th>Packed by</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1;
        ?>
        <?php if (sizeof($boxes) > 0) : ?>
            <?php foreach ($boxes as $row) : ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $row->packed_date; ?></td>
                    <td><?php echo $row->box_prefix; ?><?php echo $row->box_no; ?></td>
                    <td><?php echo $row->item_name; ?><?php echo $row->item_id; ?></td>
                    <td><?php echo $row->shade_name; ?><?php echo $row->shade_no; ?></td>
                    <td><?php echo $row->shade_code; ?></td>
                    <td><?php echo $row->lot_lot_no; ?></td>
                    <td><?php echo $row->manual_lot_no; ?></td>
                    <td><?php echo $row->no_of_cones; ?></td>
                    <td><?php echo $row->gross_weight; ?></td>
                    <td><?php echo $row->net_weight; ?></td>
                    <td><?php echo $row->user_nicename; ?></td>
                    <td><?php echo $row->remarks; ?></td>
                    <td>
                        <a href="<?php echo base_url('directpack/print_pack_slip/' . $row->box_id); ?>" target="_blank" class="btn btn-xs btn-primary">Print</a>
                        <?php if ($row->is_deleted == '0' && $row->predelivery_status == '1' && $row->delivery_status == '1') { ?>
                            <!-- <button onclick="showAjaxModal('<?php echo base_url('directpack/confirm_delete/' . $row->box_id); ?>')" class="btn btn-xs btn-danger">Delete</button> -->
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>