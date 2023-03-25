<?php
$rates = array();
$rates = $this->m_admin->getitemrates_yt($customer, $item_name, $shade_id);
$direct_sales_rate = 0;
$direct_sales_rate = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item_name, 'direct_sales_rate');
?>
<div class="form-group col-lg-2">
	<label for="direct_sales_rate">Direct Sales Rate</label>
	<input class="get-item-retes form-control select2" value="<?=$direct_sales_rate; ?>" id="direct_sales_rate" name="direct_sales_rate" type="text">
</div>
<table class="table table-bordered table-striped table-condensed">
	<!-- <thead>
		<tr>
			<th>Rate</th>
			<th>Value</th>
			<th></th>
			<th>User Details</th>
		</tr>
	</thead> -->
	<tbody>
		<?php
		$sno = 1;
		$key = -1;
		foreach ($rates as $rate) {
			$item_rates = explode(",", $rate['item_rates']);
			$rate_changed_by = explode(",", $rate['rate_changed_by']);
			$rate_changed_on = explode(",", $rate['rate_changed_on']);
			$description = explode(",", $rate['description']);
			$item_rate_active = $rate['item_rate_active'];
			$rate_id = $rate['rate_id'];
			foreach ($item_rates as $key => $value) {
				if($rate_changed_on[$key] != '')
				{
					$date = explode(" ", $rate_changed_on[$key]);
					$ed = explode("-", $date[0]);
					$change_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
				}
				?>
				<tr>
					<td>Rate <?=$sno; ?></td>
					<td>
						<?=$item_rates[$key]; ?>
						<input type="hidden" name="item_rates[]" value="<?=$item_rates[$key]; ?>">
					</td>
					<td>
						<input type="radio" name="item_rate_active" <?=($item_rate_active == $key)?'checked="checked"':''; ?> value="<?=$key; ?>">
					</td>
					<td>
						<input type="hidden" name="rate_changed_by[]" value="<?=$this->session->userdata('user_id'); ?>">
						<input type="hidden" name="rate_changed_on[]" value="<?=$rate_changed_on[$key]; ?>">
						<?=$this->m_masters->getmasterIDvalue('bud_users', 'ID', $rate_changed_by[$key], 'display_name'); ?> <?=$change_date.' '.$date[1]; ?>
					</td>
					<td>
						<textarea name="description[]" class="form-control"><?=$description[$key]; ?></textarea>
					</td>
				</tr>
				<?php
				$sno++;				
			}
		}
		?>
		<tr>
			<td>Rate <?=$sno; ?></td>
			<td>
				<input type="text" class="form-control" name="item_rates[]" value="">
			</td>
			<td>
				<input type="radio" name="item_rate_active" value="<?=$key+1; ?>">				
			</td>
			<td>
				<input type="hidden" name="rate_changed_by[]" value="<?=$this->session->userdata('user_id'); ?>">
				<input type="hidden" name="rate_changed_on[]" value="<?=date("Y-m-d H:i:s"); ?>">
				<?=$this->session->userdata('display_name'); ?> <?=date("d-m-Y"); ?> / <?=date("H:i:s"); ?>
			</td>
			<td>
				<textarea name="description[]"  class="form-control"></textarea>
			</td>
		</tr>
		<?php
		?>
	</tbody>
</table>