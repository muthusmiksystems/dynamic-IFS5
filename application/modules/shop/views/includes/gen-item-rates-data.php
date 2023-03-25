<table class="table table-bordered">
    <thead>
        <tr>
            <th>Qty From</th>
            <th>Qty To</th>
            <th>Rate</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(sizeof($item_rates) > 0): ?>
            <?php foreach($item_rates as $key => $rate): ?>
                <tr>
                    <td>
                        <input type="text" name="qty_from[]" value="<?php echo $rate->qty_from; ?>" class="form-control input-sm">
                    </td>
                    <td>
                        <input type="text" name="qty_to[]" value="<?php echo $rate->qty_to; ?>" class="form-control input-sm">
                    </td>
                    <td>
                        <input type="text" name="item_rate[]" value="<?php echo $rate->item_rate; ?>" class="form-control input-sm">
                    </td>
                    <td>
                        <?php if($key == 0): ?>
                            <button type="button" class="add-row btn btn-xs btn-success">Add</button>
                        <?php else: ?>
                            <button type="button" class="remove-row btn btn-xs btn-danger">Remove</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td>
                    <input type="text" name="qty_from[]" class="form-control input-sm">
                </td>
                <td>
                    <input type="text" name="qty_to[]" class="form-control input-sm">
                </td>
                <td>
                    <input type="text" name="item_rate[]" class="form-control input-sm">
                </td>
                <td>
                    <button type="button" class="add-row btn btn-xs btn-success">Add</button>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>