<table class="table table-bordered datatables">
    <thead>
        <tr>
            <th>#</th>
            <th>invoice No</th>
            <th>invoice ID</th>
            <th>Date</th>
            <th>Concern Name</th>
            <th>Party Name</th>
            <th>Name</th>
            <th>Mobile No</th>
            <th>Amount</th>
            <th>
                <label>
                    <input type="checkbox" name="" id="select_all">
                    Select All                                                        
                </label>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1;
        ?>
        <?php if(sizeof($invoice_list) > 0): ?>
            <?php foreach($invoice_list as $row): ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td>SH/CS-<?php echo $row->invoice_no; ?></td>
                    <td><?php echo $row->invoice_id; ?></td>
                    <td><?php echo $row->invoice_date; ?></td>
                    <td><?php echo $row->concern_name; ?></td>
                    <td><?php echo $row->cust_name; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->mobile_no; ?></td>
                    <td><?php echo $row->invoice_amt; ?></td>
                    <th>
                        <input type="checkbox" class="invoice-id" value="<?php echo $row->invoice_id; ?>">
                    </th>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<input type="hidden" name="selected_ids" id="selected_ids">
<button class="btn btn-danger" onclick="addToCart()">Add To List</button>