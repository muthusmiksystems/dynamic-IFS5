<table class="table table-bordered dataTables" id="inner_boxes">
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
				<label>
					<input type="checkbox" id="select_all">
				</label>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sno = 1;
		?>
		<?php if (sizeof($inner_boxes) > 0) : ?>
			<?php foreach ($inner_boxes as $row) : ?>
				<tr>
					<td><?php echo $sno++; ?></td>
					<td><?php echo date("d-m-Y H:i:s", strtotime($row->packed_date)); ?></td>
					<td>I<?php echo $row->inner_box_id; ?></td>
					<td><?php echo $row->lot_no; ?></td>
					<td><?php echo $row->item_name; ?>/<?= $row->item_id; ?></td>
					<td><?php echo $row->shade_name; ?>/<?= $row->shade_id; ?></td>
					<td><?php echo $row->gross_weight; ?></td>
					<td><?php echo $row->net_weight; ?></td>
					<td><?php echo $row->packed_by; ?></td>
					<td>
						<input type="checkbox" class="chkBoxId" value="<?php echo $row->inner_box_id; ?>">
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>