<?php
/*echo "<pre>";
print_r($item_rates);
echo "</pre>";*/
$sno = 1;
$key = -1;
?>
<table class="table table-bordered">
	<tbody>
		<?php if(sizeof($item_rates) > 0): ?>
			<?php foreach($item_rates as $rate): ?>
				<?php
				$item_rates = explode(",", $rate->item_rates);
				$rate_changed_by = explode(",", $rate->rate_changed_by);
				$rate_changed_on = explode(",", $rate->rate_changed_on);
				$description = explode(",", $rate->description);
				$item_rate_active = $rate->item_rate_active;
				$rate_id = $rate->rate_id;
				?>
				<input type="hidden" name="rate_id" value="<?php echo $rate->rate_id; ?>">
				<?php foreach ($item_rates as $key => $value): ?>
					<?php
					if($rate_changed_on[$key] != '')
					{
						$date = explode(" ", $rate_changed_on[$key]);
						$ed = explode("-", $date[0]);
						$change_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
					}
					?>
					<tr>
						<td>Rate <?php echo $sno++; ?></td>
						<td>
							<?=$item_rates[$key]; ?>
							<input type="hidden" name="item_rates[]" value="<?php echo $item_rates[$key]; ?>">
						</td>
						<td>
							<input type="radio" name="item_rate_active" <?php echo ($item_rate_active == $key)?'checked="checked"':''; ?> value="<?php echo $key; ?>">
						</td>
						<td>
							<input type="hidden" name="rate_changed_by[]" value="<?php echo $this->session->userdata('user_id'); ?>">
							<input type="hidden" name="rate_changed_on[]" value="<?php echo $rate_changed_on[$key]; ?>">
							<?php echo $this->m_masters->getmasterIDvalue('bud_users', 'ID', $rate_changed_by[$key], 'display_name'); ?> <?php echo $change_date.' '.$date[1]; ?>
						</td>
						<td>
							<textarea name="description[]" class="form-control"><?php echo $description[$key]; ?></textarea>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<tr>
			<td>Rate <?php echo $sno++; ?></td>
			<td>
				<input type="text" class="form-control" name="item_rates[]" value="">
			</td>
			<td>
				<input type="radio" name="item_rate_active" value="<?php echo $key+1; ?>">				
			</td>
			<td>
				<input type="hidden" name="rate_changed_by[]" value="<?php echo $this->session->userdata('user_id'); ?>">
				<input type="hidden" name="rate_changed_on[]" value="<?php echo date("Y-m-d H:i:s"); ?>">
				<?php echo $this->session->userdata('display_name'); ?> <?php echo date("d-m-Y"); ?> / <?php echo date("H:i:s"); ?>
			</td>
			<td>
				<textarea name="description[]"  class="form-control"></textarea>
			</td>
		</tr>
	</tbody>
</table>