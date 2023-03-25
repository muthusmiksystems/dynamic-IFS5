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
	foreach ($boxes as $box_no) {
		$box_details = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_no', $box_no);
		foreach ($box_details as $row) {
			$box_no = $row['box_no'];
			$packing_customer = $row['packing_customer'];
			$packing_innerbox_items = $row['packing_innerbox_items'];
			$packing_date = $row['packing_date'];
			$packing_time = $row['packing_time'];
			$packing_gr_weight = $row['packing_gr_weight'];
			$total_tare_weight = $row['total_tare_weight'];
			$packing_net_weight = $row['packing_net_weight'];
			$total_rolls = $row['total_rolls'];
			$total_meters = $row['total_meters'];
			$item_uom = $row['item_uom'];
			$packing_by = $row['packing_by'];
			$packing_type = $row['packing_type'];
			$ed = explode("-", $packing_date);
			$packing_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
		}
		if($packing_type == 'qtywise')
		{
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
					<td colspan="2">Art No : <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_innerbox_items, 'item_id')?></td>
					<td>Box No : </td>
					<td colspan="3" align="left"><strong style="font-size:26px;">M - <?=$box_no; ?></strong></td>
				</tr>
				<tr>
					<td colspan="6"><strong><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_innerbox_items, 'item_name')?></strong></td>
				</tr>
				<tr class="border-top">
					<td>Gr. Weight</td>
					<td>:</td>
					<td class="border-right" align="right"><?=number_format($packing_gr_weight, 3, '.', ''); ?></td>
					<td>Total Rolls</td>
					<td>:</td>
					<td><?=$total_rolls; ?></td>
				</tr>
				<tr>
					<td>Total Qty</td>
					<td>:</td>
					<td class="border-right" align="right">
						<strong style="font-size:14pt;"><?=round($total_meters); ?> <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item_uom, 'uom_name'); ?></strong>
					</td>
					<td colspan="3"></td>
				</tr>
				
				<tr class="border-top">
					<td colspan="3" style="padding-top:3px;">
						<div id="bcTarget" style="float:left;"></div>
					</td>
					<td colspan="3">
						<p style="font-size:10px;float:right;margin:0px;font-weight:normal;">
						Packed by: <?=$this->m_masters->getmasterIDvalue('bud_users', 'ID', $packing_by, 'display_name')?><br/>
						<?=$packing_date?> / <?=$packing_time; ?>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="6" align="center" style="border-top:1px solid #000;">
						<span style="font-size:10px;">Produced &amp; Marketed by :</span><br/> 
						<strong>SHIVA TAPES</strong> a concern of <strong>"DYNAMIC"</strong> Group
					</td>
				</tr>		
			</table>
			<?php
		}
		else
		{
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
				<td colspan="2">Art No : <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_innerbox_items, 'item_id')?></td>
				<td>Box No : </td>
				<td colspan="3" align="left"><strong style="font-size:26px;">M - <?=$box_no; ?></strong></td>
			</tr>
			<tr>
				<td colspan="6"><strong><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_innerbox_items, 'item_name')?></strong></td>
			</tr>
			<tr class="border-top">
				<td>Gr. Weight</td>
				<td>:</td>
				<td class="border-right" align="right"><?=number_format($packing_gr_weight, 3, '.', ''); ?></td>
				<td>Total Rolls</td>
				<td>:</td>
				<td><?=$total_rolls; ?></td>
			</tr>
			<tr>
				<td>Tare Weight</td>
				<td>:</td>
				<td class="border-right" align="right"><?=number_format($total_tare_weight, 3,'.',''); ?></td>
				<td rowspan="2"><strong>Total Meters</strong></td>
				<td rowspan="2">:</td>
				<td rowspan="2"><strong style="font-size:14pt;"><?=round($total_meters); ?></strong></td>
			</tr>
			<tr>
				<td>Net Weight</td>
				<td>:</td>
				<td class="border-right" align="right"><?=number_format($packing_net_weight, 3, '.', ''); ?></td>
				<!-- <td></td> -->
				<!-- <td></td>
				<td></td> -->
			</tr>
			<tr class="border-top">
				<td colspan="3" style="padding-top:3px;">
					<div id="bcTarget" style="float:left;"></div>
				</td>
				<td colspan="3">
					<p style="font-size:10px;float:right;margin:0px;font-weight:normal;">
					Packed by: <?=$this->m_masters->getmasterIDvalue('bud_users', 'ID', $packing_by, 'display_name')?><br/>
					<?=$packing_date?> / <?=$packing_time; ?>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="6" align="center" style="border-top:1px solid #000;">
					<span style="font-size:10px;">Produced &amp; Marketed by :</span><br/> 
					<strong>SHIVA TAPES</strong> a concern of <strong>"DYNAMIC"</strong> Group
				</td>
			</tr>		
		</table>
		<br>
		<?php
		}
	}
	?>
	<script type="text/javascript">
	var barcode_text = <?=$box_no;?>;
	$("#bcTarget").barcode("I-"+barcode_text, "code128",{barWidth:2, barHeight:30, output:"bmp"});
	</script>
</body>
</html>