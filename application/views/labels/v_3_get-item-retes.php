<?php
$rates = $this->m_admin->getitemrates_label($customer, $item_name);
$direct_sales_rate = 0;
$direct_sales_rate = $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $item_name, 'direct_sales_rate');
?>
<div class="form-group col-lg-3">
	<label for="direct_sales_rate">Direct Sales Rate</label>
	<input class="get-item-retes form-control select2" value="<?=$direct_sales_rate; ?>" id="direct_sales_rate" name="direct_sales_rate" type="text">
</div>
<table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>Rate</th>
			<th>Roll</th>
			<th>Cut &amp; Seal</th>
			<th>Center Fold</th>
			<th>Dye Cut</th>
			<th>Meter Fold</th>
			<th>End Fold</th>
			<th></th>
			<th>User Details</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sno = 1;
		$key = -1;
		$item_rate_form = 'roll';
		foreach ($rates as $rate) {
			$item_rates = explode(",", $rate['item_rates']);
			$rate_changed_by = explode(",", $rate['rate_changed_by']);
			$rate_changed_on = explode(",", $rate['rate_changed_on']);
			$description = explode(",", $rate['description']);
			$rates_cut_seal = explode(",", $rate['rates_cut_seal']);
			$rates_center_fold = explode(",", $rate['rates_center_fold']);
			$rates_dye_cut = explode(",", $rate['rates_dye_cut']);
			$rates_meter_fold = explode(",", $rate['rates_meter_fold']);
			$rates_end_fold = explode(",", $rate['rates_end_fold']);
			$item_rate_active = $rate['item_rate_active'];
			$item_rate_form = $rate['item_rate_form'];
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
						<?=$item_rates[$key]; ?><br>
						<input type="radio" name="item_rate_form" <?=($item_rate_form == 'roll')?'checked="checked"':''; ?> value="roll">
						<input type="hidden" name="item_rates[]" value="<?=$item_rates[$key]; ?>">
						<input type="hidden" name="rates_cut_seal[]" value="<?=$rates_cut_seal[$key]; ?>">
						<input type="hidden" name="rates_center_fold[]" value="<?=$rates_center_fold[$key]; ?>">
						<input type="hidden" name="rates_dye_cut[]" value="<?=$rates_dye_cut[$key]; ?>">
						<input type="hidden" name="rates_meter_fold[]" value="<?=$rates_meter_fold[$key]; ?>">
						<input type="hidden" name="rates_end_fold[]" value="<?=$rates_end_fold[$key]; ?>">
					</td>
					<td>
						<?=$rates_cut_seal[$key]; ?><br>
						<input type="radio" name="item_rate_form" <?=($item_rate_form == 'rates_cut_seal')?'checked="checked"':''; ?> value="rates_cut_seal">
					</td>
					<td>
						<?=$rates_center_fold[$key]; ?><br>
						<input type="radio" name="item_rate_form" <?=($item_rate_form == 'rates_center_fold')?'checked="checked"':''; ?> value="rates_center_fold">
					</td>
					<td>
						<?=$rates_dye_cut[$key]; ?>
						<input type="radio" name="item_rate_form" <?=($item_rate_form == 'rates_dye_cut')?'checked="checked"':''; ?> value="rates_dye_cut">
					</td>
					<td>
						<?=$rates_meter_fold[$key]; ?><br>
						<input type="radio" name="item_rate_form" <?=($item_rate_form == 'rates_meter_fold')?'checked="checked"':''; ?> value="rates_meter_fold">
					</td>
					<td>
						<?=$rates_end_fold[$key]; ?><br>
						<input type="radio" name="item_rate_form" <?=($item_rate_form == 'rates_end_fold')?'checked="checked"':''; ?> value="rates_end_fold">
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
						<textarea name="description[]" cols="50"><?=$description[$key]; ?></textarea>
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
				<input type="text" name="item_rates[]" value="" style="width:100px;"><br>
				<input type="radio" name="item_rate_form" value="roll">
			</td>
			<td>
				<input type="text" name="rates_cut_seal[]" value="0.07" style="width:100px;"><br>
				<input type="radio" name="item_rate_form" value="rates_cut_seal">
			</td>
			<td>
				<input type="text" name="rates_center_fold[]" value="0.10" style="width:100px;"><br>
				<input type="radio" name="item_rate_form" value="rates_center_fold">
			</td>
			<td>
				<input type="text" name="rates_dye_cut[]" value="1.00" style="width:100px;"><br>
				<input type="radio" name="item_rate_form" value="rates_dye_cut">
			</td>
			<td>
				<input type="text" name="rates_meter_fold[]" value="0.10" style="width:100px;"><br>
				<input type="radio" name="item_rate_form" value="rates_meter_fold">
			</td>
			<td>
				<input type="text" name="rates_end_fold[]" value="0.10" style="width:100px;"><br>
				<input type="radio" name="item_rate_form" value="rates_end_fold">
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
				<textarea name="description[]" cols="50"></textarea>
			</td>
		</tr>
		<?php
		?>
	</tbody>
</table>