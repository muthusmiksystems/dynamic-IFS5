<table class="table table-bordered datatables">
    <thead>
        <tr>
            <th>#</th>
            <th>Lot No</th>
            <th>Date</th>
            <th>Item Name</th>
            <th>Color Name</th>
            <th>Color Code</th>
            <th>Total Oil Required</th>
            <th># Units</th>
            <th>Total Lot Qty</th>
            <th>Rate</th>
            <th>Quality</th>
            <th>Remarks</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1;
        $mir_no=sizeof($lot_list);
        ?>
        <?php if(sizeof($lot_list) > 0): ?>
            <?php foreach($lot_list as $row): ?>
                <?php
                $latest_upd=$this->Directpack_model->get_latest_lots($row->latest_id);
                
                ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td style="color:#41cac0"><strong><?php echo $row->lot_no; ?> - <?php echo $mir_no--; ?></strong></td>
                    <!-- <td><?php echo date("d-m-Y g:i A", strtotime($row->lot_created_date)); ?></td> -->
                    <td><?php echo date("d-m-Y g:i A", strtotime($latest_upd[0]["lot_created_date"])); ?></td>
                    <td><?php echo $row->item_name; ?>/<?php echo $row->lot_item_id; ?></td>
                    <td><?php echo $row->shade_name; ?>/<?php echo $row->lot_shade_no; ?></td>
                    <td><?php echo $row->shade_code; ?></td>
                    <!-- <td><?php echo $row->lot_oil_required; ?></td>
                    <td><?php echo $row->no_springs; ?></td>
                    <td><?php echo $row->lot_qty; ?></td> -->
                    <td><?php echo $row->total_lot_oil_required; ?></td>
                    <td><?php echo $row->total_no_springs; ?></td>
                    <td><?php echo $row->total_lot_qty; ?></td>
                    <td><?php echo $latest_upd[0]["lot_rate"]; ?></td>
                    <td><?php echo $latest_upd[0]["lot_quality"]; ?></td>
                    <td><?php echo $latest_upd[0]['lot_remark']; ?></td>
                    <td>
                    <!-- <a class="btn btn-xs btn-primary" onclick="get_detail(<?= $row->lot_no; ?>)">Add Lot Qty</a> -->
                    <!-- <a class="btn btn-xs btn-primary" href="<?= base_url(); ?>directpack/lot_list_details/<?= $row->lot_no; ?>">Lot Qty Detail</a> -->
                    
                    <form action="<?= base_url(); ?>directpack/lot_list_details" method="post">
                        <input type="hidden" name="lot_no" value="<?= htmlspecialchars($row->lot_no); ?>">
                        <div class="button-group">
                                <button class="btn btn-xs btn-primary" name="action" value="detail" type="submit">Lot Qty Detail</button>
                                <!-- <button class="btn btn-xs btn-warning" name="action" value="edit" type="submit" title="Edit"><i class="icon-pencil"></i></button> -->
                                <div class="btn btn-xs btn-warning"  onclick="showAjaxModal('<?php echo base_url('directpack/direct_lot_inwd_addqty?lot_no=' . urlencode($row->lot_no) . '&id=' . $row->id) . '&action='.'edit'; ?>')"><i class="icon-pencil"></i></div>
                            </div>
                    </form>



                </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>