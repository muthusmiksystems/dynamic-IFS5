<?php
$tot_boxes = 0;
$tot_gr_weight = 0;
$tot_no_cones = 0;
$tot_nt_weight = 0;
$tot_bal_weight = 0;
$tot_del_qty = 0;
if(sizeof($predc_items) > 0)
{
    foreach ($predc_items as $box) {
        $tot_boxes++;
        $tot_no_cones += $box->no_cones;
        $tot_nt_weight += $box->nt_weight;
        $tot_del_qty += $box->delivery_qty;
    }
}

if(sizeof($cart_items) > 0)
{
    foreach ($cart_items as $box) {
        $tot_boxes++;
        echo $tot_no_cones += $box->no_cones;
        $tot_nt_weight += $box->nt_weight;
        $tot_del_qty += $box->delivery_qty;
    }
}
?>
<table class="table table-bordered">
    <thead>
    	<tr class="total-row">
			<th></th>
			<th><?php echo $tot_boxes; ?></th>
			<th>Boxes</th>
			<th>Total Qty</th>
			<th></th>
			<th></th>
			<th></th>
			<th><?php echo $tot_no_cones; ?></th>
			<th><?php echo $tot_nt_weight; ?></th>
			<th><?php echo $tot_del_qty; ?></th>
			<th>
				<button class="btn btn-xs btn-danger" onclick="cartRemoveAll()">Remove All</button>
			</th>
    	</tr>
    	<tr>
	        <th>#</th>
	        <th>Box no</th>
	        <th>Item name/code</th>
	        <th>Shade name/code</th>
	        <th>Shade no</th>
	        <th>Lot no</th>
	        <th>Stock Room</th>
	        <th>#Cones</th>
	        <th>Nt.Wt</th>
	        <th>Deliver Qty</th>
	        <th>Action</th>    		
    	</tr>
    </thead>
    <tbody>
		<?php
		$sno = 1;
		?>
		<?php if(sizeof($predc_items) > 0): ?>
			<?php foreach($predc_items as $box): ?>
				<tr>
					<td><?php echo $sno++; ?></td>
					<td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
		            <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
		            <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
		            <td><?php echo $box->shade_code; ?></td>
		            <td><?php echo $box->lot_no; ?></td>
		            <td><?php echo $box->stock_room_name; ?></td>
		            <td><?php echo $box->no_cones; ?></td>
		            <td><?php echo $box->nt_weight; ?></td>
		            <td>
		            	<input type="text" onchange="update_cart_item(this, '<?php echo $box->row_id; ?>', '<?php echo $box->nt_weight; ?>')" value="<?php echo $box->delivery_qty; ?>" class="delivery-qty form-control input-sm" id="<?php echo $box->row_id; ?>">
		            </td>
		            <td>
		            	<input type="hidden" id="predc_items" name="predc_items[]" value="<?php echo $box->row_id; ?>">
		            	<button type="button" id="<?php echo $box->row_id; ?>" class="remove-pdc-item btn btn-xs btn-danger">Remove</button>
		            </td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>

		<!-- Temp List -->
		<?php if(sizeof($cart_items) > 0): ?>
			<?php foreach($cart_items as $box): ?>
				<tr>
					<td><?php echo $sno++; ?></td>
					<td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
		            <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
		            <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
		            <td><?php echo $box->shade_code; ?></td>
		            <td><?php echo $box->lot_no; ?></td>
		            <td><?php echo $box->stock_room_name; ?></td>
		            <td><?php echo $box->no_cones; ?></td>
		            <td><?php echo $box->nt_weight; ?></td>
		            <td>
		            	<input type="text" onchange="update_cart_item(this, '<?php echo $box->row_id; ?>', '<?php echo $box->nt_weight; ?>')" value="<?php echo $box->delivery_qty; ?>" class="delivery-qty form-control input-sm" id="<?php echo $box->row_id; ?>">
		            	<?php
		            	//ER-07-18#-6
                        if($box->box_prefix=='TH'){
                            echo ' Cones'; 
                        }
                        //ER-07-18#-6
                        ?>
		            </td>
		            <td>
		            	<button type="button" id="<?php echo $box->row_id; ?>" class="remove-cart-item btn btn-xs btn-danger">Remove</button>
		            </td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
    </tbody>
    <tfoot>
		<tr class="total-row">
			<th></th>
			<th><?php echo $tot_boxes; ?></th>
			<th align="left">Boxes</th>
			<th>Total Qty</th>
			<th></th>
			<th></th>
			<th></th>
			<th><?php echo $tot_no_cones; ?></th>
			<th><?php echo $tot_nt_weight; ?></th>
			<th><?php echo $tot_del_qty; ?></th>
			<th></th>
		</tr>    	
    </tfoot>
</table>