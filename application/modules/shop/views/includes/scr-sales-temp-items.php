<?php
$tot_quotation_amt = 0;
?>
<h4>Selected Quotations</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>quotation No</th>
            <th>Date</th>
            <th>Concern Name</th>
            <th>Party Name</th>
            <th>Name</th>
            <th>Mobile No</th>
            <th>Amount</th>
            <th>
                Action
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
                $quotation = $this->Sales_model->get_quotation($item['id']);
                if($quotation):
                    $tot_quotation_amt += $quotation->quotation_amt;
                    ?>
                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <td>QUOT NO-<?php echo $quotation->quotation_id; ?></td>
                        <td><?php echo date("d-m-Y g:i A", strtotime($quotation->quotation_date)); ?></td>
                        <td><?php echo $quotation->concern_name; ?></td>
                        <td><?php echo $quotation->cust_name; ?></td>
                        <td><?php echo $quotation->name; ?></td>
                        <td><?php echo $quotation->mobile_no; ?></td>
                        <td><?php echo $quotation->quotation_amt; ?></td>
                        <th>
                            <input type="hidden" name="quotation_ids[]" value="<?php echo $quotation->quotation_id; ?>">
                            <button type="button" class="remove-cart-item btn btn-xs btn-danger" id="<?php echo $quotation->quotation_id; ?>">Remove</button>
                        </th>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7"><strong>Total</strong></td>
            <td><strong><?php echo number_format($tot_quotation_amt, 2, '.', ''); ?></strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>