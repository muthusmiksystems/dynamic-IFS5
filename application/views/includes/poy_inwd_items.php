<?php
$sno = 1;
?>
<?php if (count($inward_items) > 0) : ?>
	<?php foreach ($inward_items as $item) : ?>
		<tr>
			<td><?php echo $sno++; ?></td>
			<td><?php echo @$item['edate']; ?></td>
			<td><?php echo @$item['inward_invoice_no']; ?></td>
			<td><?php echo (!empty($item['inward_date'])) ? date("d-m-Y", strtotime($item['inward_date'])) : ''; ?></td>
			<td><?php echo $item['denier_name']; ?></td>
			<td><?php echo $item['inward_quality']; ?></td>
			<td><?php echo (@$item['poy_lot_no_current'] != '') ? @$item['poy_lot_no_current'] : @$item['poy_lot_no']; ?></td>
			<td><?php echo $item['remarks']; ?></td>
			<td><?php echo $item['po_qty']; ?></td>
			<td><?php echo $item['po_item_rate']; ?></td>
			<td><?php echo $item['euser']; ?></td>
			<!--inclusion of poy item rate-->
			<td>
				<?php if ($sno == 2) { ?>
					<button class="btn btn-xs btn-success" onclick="showAjaxModal('<?php echo base_url('poy/poy_inwd_addqty/' . $item['rowid']); ?>')">Add Qty</button>
				<?php } ?>
			</td>
		</tr>
	<?php endforeach; ?>
<?php endif; ?>