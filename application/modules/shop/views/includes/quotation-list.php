<table class="table table-bordered datatables">
    <thead>
        <tr>
            <th>#</th>
            <th>Enquiry No</th>
            <th>Enquiry ID</th>
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
        <?php if(sizeof($quotation_list) > 0): ?>
            <?php foreach($quotation_list as $row): ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td>QUOT NO-<?php echo $row->quotation_no; ?></td>
                    <td><?php echo $row->quotation_id; ?></td>
                    <td><?php echo $row->quotation_date; ?></td>
                    <td><?php echo $row->concern_name; ?></td>
                    <td><?php echo $row->cust_name; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->mobile_no; ?></td>
                    <td><?php echo $row->quotation_amt; ?></td>
                    <th>
                        <input type="checkbox" class="quotation-id" value="<?php echo $row->quotation_id; ?>">
                    </th>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<input type="hidden" name="selected_ids" id="selected_ids">
<button class="btn btn-danger" onclick="addToCart()">Add To List</button>