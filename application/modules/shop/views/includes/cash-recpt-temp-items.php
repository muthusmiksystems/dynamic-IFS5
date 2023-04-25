<?php
$tot_receipt_amt = 0;
?>
<h4>Selected Receipts</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Receipt No</th>
            <th>Date</th>
            <th>Concern Name</th>
            <th>Party Name</th>
            <th>Name</th>
            <th>Mobile No</th>
            <th>Purpose</th>
            <th>Received By</th>
            <th>Amount</th>
            <th>
                <button type="button" class="btn btn-xs btn-danger">Remove All</button>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1;
        ?>
        <?php if(sizeof($cart_items) > 0): ?>
            <?php foreach($cart_items as $item): ?>
                <?php
                $receipt = $this->Sales_model->get_cash_receipt($item['id']);
                if($receipt):
                    $tot_receipt_amt += $receipt->amount;
                    ?>
                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <td>SHOP-<?php echo $receipt->receipt_id; ?></td>
                        <td><?php echo date("d-m-Y g:i A", strtotime($receipt->receipt_date)); ?></td>
                        <td><?php echo $receipt->concern_name; ?></td>
                        <td><?php echo $receipt->cust_name; ?></td>
                        <td><?php echo $receipt->name; ?></td>
                        <td><?php echo $receipt->mobile_no; ?></td>
                        <td><?php echo $receipt->purpose; ?></td>
                        <td><?php echo $receipt->display_name; ?></td>
                        <td><?php echo $receipt->amount; ?></td>
                        <th>
                            <input type="hidden" name="receipt_ids[]" value="<?php echo $receipt->receipt_id; ?>">
                            <button type="button" class="remove-cart-item btn btn-xs btn-danger" id="<?php echo $receipt->receipt_id; ?>">Remove</button>
                        </th>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9"><strong>Total</strong></td>
            <td><strong><?php echo number_format($tot_receipt_amt, 2, '.', ''); ?></strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>