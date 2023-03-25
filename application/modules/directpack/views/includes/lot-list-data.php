<table class="table table-bordered datatables">
    <thead>
        <tr>
            <th>#</th>
            <th>Lot No</th>
            <th>Date</th>
            <th>Item Name</th>
            <th>Shade Name</th>
            <th>Shade Code</th>
            <th>Oil Required</th>
            <th># Springs</th>
            <th>Lot Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1;
        ?>
        <?php if(sizeof($lot_list) > 0): ?>
            <?php foreach($lot_list as $row): ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $row->lot_no; ?></td>
                    <td><?php echo date("d-m-Y g:i A", strtotime($row->lot_created_date)); ?></td>
                    <td><?php echo $row->item_name; ?>/<?php echo $row->lot_item_id; ?></td>
                    <td><?php echo $row->shade_name; ?>/<?php echo $row->lot_shade_no; ?></td>
                    <td><?php echo $row->shade_code; ?></td>
                    <td><?php echo $row->lot_oil_required; ?></td>
                    <td><?php echo $row->no_springs; ?></td>
                    <td><?php echo $row->lot_qty; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>