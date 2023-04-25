<?php
$tot_invoice_amt = 0;
?>
<h4>Selected Invoices</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice No</th>
            <th>Invoice ID</th>
            <th>Date</th>
            <th>Concern Name</th>
            <th>Party Name</th>
            <th>Name</th>
            <th>Mobile No</th>
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
                $invoice = $this->Sales_model->get_cash_invoice($item['id']);
                if($invoice):
                    $tot_invoice_amt += $invoice->invoice_amt;
                    ?>
                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <td>SH/CC-<?php echo $invoice->invoice_no; ?></td>
                        <td><?php echo $invoice->invoice_id; ?></td>
                        <td><?php echo date("d-m-Y g:i A", strtotime($invoice->invoice_date)); ?></td>
                        <td><?php echo $invoice->concern_name; ?></td>
                        <td><?php echo $invoice->cust_name; ?></td>
                        <td><?php echo $invoice->name; ?></td>
                        <td><?php echo $invoice->mobile_no; ?></td>
                        <td><?php echo $invoice->invoice_amt; ?></td>
                        <th>
                            <input type="hidden" name="invoice_ids[]" value="<?php echo $invoice->invoice_id; ?>">
                            <button type="button" class="remove-cart-item btn btn-xs btn-danger" id="<?php echo $invoice->invoice_id; ?>">Remove</button>
                        </th>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7"><strong>Total</strong></td>
            <td><strong><?php echo number_format($tot_invoice_amt, 2, '.', ''); ?></strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>