<!DOCTYPE html>
<html>
<head>
	<title>Shiva Tapes Packing Slip</title>
	<style type="text/css">
		<!--
		@page rotated { size : landscape }
		@page { size:100mm 70mm; margin: 2.5mm }
		-->
		table
		{
			border: 1px solid #000;
			border-collapse:collapse;
		}
		table td
		{
			font-size: 14px;
			font-family: Verdana, Geneva, sans-serif;
			/*font-weight: bold;*/
		}
		table tr.border-top td
		{
			border-top: 1px solid #000;
		}
		table td.border-right
		{
			border-right: 1px solid #000;
			padding-right: 2px;
		}
	</style>
	<?php
	foreach ($js as $path) {
	?>
	<script src="<?=base_url().'themes/default/'.$path; ?>"></script>
	<?php
	}
	?>
</head>
<!-- <body onload="window.print(); window.close()"> -->
<body>
	<?php
	$box_details = $this->m_production->labelOuterbox($box_no);
	$total_rolls = 0;
	$total_qty = 0;
	$packing_date = '';
	$packing_time = '';
	$items_array = array();
	$rolls_array = array();
	$uom = 'Qty';
	foreach ($box_details as $row) {
		$item_id = $row['item_id'];
		$item_name = $row['item_name'];
		$date_time = $row['date_time'];
		$display_name = $row['display_name'];
		$item_size = $row['item_size'];
		$packing_uom = $row['packing_uom'];
		$packing_gr_weight = $row['packing_gr_weight'];
		$packing_contact = $row['packing_contact'];
		$total_rolls += $row['packed_no_rolls'];
		$items_array[$item_size][] = $row['total_qty'];
		$rolls_array[$item_size][] = $row['packed_no_rolls'];
		$total_qty += $row['total_qty'];
		$d_t = explode(" ", $date_time);
		$date = explode("-", $d_t[0]);
		$packing_date = $date[2].'-'.$date[1].'-'.$date[0];
		$packing_time = $d_t[1];
	}
	$uom = $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $packing_uom, 'uom_name');
	?>
	<table style="width:90%;margin:0 auto;">
		<tr>
			<td width="24%"></td>
			<td width="1%"></td>
			<td width="25%"></td>
			<td width="24%"></td>
			<td width="1%"></td>
			<td width="25%"></td>
		</tr>
		<tr>
			<td colspan="2">Art No : <?=$item_id; ?></td>
			<td>Box No : </td>
			<td colspan="3" align="left"><strong style="font-size:18px;">M - <?=$box_no; ?></strong></td>
		</tr>
		<tr>
			<td colspan="6"><strong><?=$item_name; ?></strong></td>
		</tr>
		<tr style="border:1px solid #000;">
			<td colspan="2" class="border-right">
				<table style="width:100%;border:0px;">
					<tr>
						<td><strong style="font-size:10px;">Size</strong></td>
						<td style="font-size:10px;">Bags/Rolls</td>
						<td align="right"><strong style="font-size:10px;">Qty</strong></td>
					</tr>
					<?php
					foreach ($items_array as $key => $value) {
						?>
						<tr>
							<td><?=$key; ?></td><td><?=array_sum($rolls_array[$key]); ?></td><td align="right"><?=array_sum($value); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</td>
			<td colspan="4" valign="top">
				<table style="width:100%;border:0px;">
					<tr>
						<td>Total Bags/Rolls</td>
						<td>:</td>
						<td><strong><?=$total_rolls; ?></strong></td>
					</tr>
					<tr>
						<td>Total Qty<br>(<?=$uom; ?>)</td>
						<td>:</td>
						<td><strong style="font-size:12pt;"><?=round($total_qty); ?></td>
					</tr>
					<!-- <tr>
						<td>Gr. Weight</td>
						<td>:</td>
						<td><?=$packing_gr_weight; ?></td>
					</tr> -->
					<tr>
						<td colspan="3" style="font-size:10px;border-top:1px solid #000;font-weight:bold;"><br>Contact : <?=$packing_contact; ?></td>
					</tr>
				</table>
			</td>
		</tr>		
		<tr class="border-top">
			<td colspan="3" style="padding-top:3px;">
				<div id="bcTarget" style="float:left;"></div>
			</td>
			<td colspan="3">
				<p style="font-size:8px;float:right;margin:0px;font-weight:normal;">
				Packed by: <?=$display_name; ?><br/>
				<?=$packing_date?> / <?=$packing_time; ?>
				</p>
			</td>
		</tr>
		<tr>
			<td colspan="6" align="center" style="border-top:1px solid #000;">
				<span style="font-size:10px;">Produced &amp; Marketed by :</span>  
				<strong>DYNAMIC DOST</strong>
			</td>
		</tr>		
	</table>
	<script type="text/javascript">
	var barcode_text = <?=$box_no;?>;
	$("#bcTarget").barcode("M-"+barcode_text, "code128",{barWidth:2, barHeight:30, output:"bmp"});
	</script>
</body>
</html>