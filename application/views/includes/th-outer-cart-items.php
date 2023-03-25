<table class="table table-bordered">
	<thead>
		<tr>
			<th>S.No</th>
			<th>Date</th>
			<th>Box No</th>
			<th>LOT</th>
			<th>Item name/code</th>
			<th>Colour name/code</th>
			<th>Gross Weight</th>
			<th>Net Weight</th>
			<th>Packed By</th>
			<th>

			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sno = 1;
		$box_ids = array();
		?>
		<?php if (sizeof($cart_items) > 0) : ?>
			<?php foreach ($cart_items as $item) : ?>
				<?php
				$box = $this->ak->thread_inner_box_details($item['id']);
				?>
				<?php if ($box) : ?>
					<?php
					$box_ids[$box->inner_box_id] = $box->inner_box_id;
					?>
					<tr>
						<td><?php echo $sno++; ?></td>
						<td><?php echo date("d-m-Y H:i:s", strtotime($box->packed_date)); ?></td>
						<td>I<?php echo $box->inner_box_id; ?></td>
						<td><?php echo $box->lot_no; ?></td>
						<td><?php echo $box->item_name; ?>/<?= $box->item_id; ?></td>
						<td><?php echo $box->shade_name; ?>/<?= $box->shade_id; ?></td>
						<td><?php echo $box->gross_weight; ?></td>
						<td><?php echo $box->net_weight; ?></td>
						<td><?php echo $box->packed_by; ?></td>
						<td>
							<input type="hidden" name="box_ids[]" value="<?php echo $box->inner_box_id; ?>">
							<button type="button" class="remove-cart-item btn btn-xs btn-danger" id="<?php echo $box->inner_box_id; ?>">Remove</button>
						</td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<input type="hidden" name="box_ids" value="<?php echo implode(",", $box_ids); ?>">