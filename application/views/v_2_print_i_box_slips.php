<!DOCTYPE html>
<html>
<head>
	<title>Shiva Tapes Packing Slip</title>
	<style type="text/css">
		<!--
		@page rotated { size : landscape }
		@page { size:1.9in 1.1in; margin: 5mm }
		-->
		table
		{
			/*border: 1px solid #000;*/
		}
		table td strong
		{
			font-size:11px;
		}
		table td
		{			
			font-family: "Arial Black", Gadget, sans-serif;
			color: #000;
			font-size:9px;
			/*font-size:10px;*/
			letter-spacing: 1px;
			padding: 0px;
		}
		span.date-label
		{
			font-size: 5px;			
		}
		span.footer-text
		{
			/*font-family: Arial, Helvetica, sans-serif;*/
			font-size: 8px;
			padding-top: 2mm;
		}
		.barcode
		{
			margin-top: 1mm;
			margin-bottom: 0.5mm;
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
	$sno = 0;
	foreach ($boxes as $box_no) {
		$box_details = $this->m_masters->getmasterdetails('bud_te_innerboxes', 'box_no', $box_no);
		if($box_details)
		{
			foreach ($box_details as $row) {
				$box_no = $row['box_no'];
				$packing_item = $row['packing_item'];
				$packing_rolls = $row['packing_rolls'];
				$packing_date = $row['packing_date'];
				$packing_time = $row['packing_time'];
				$packing_net_weight = $row['packing_net_weight'];
				$packing_type = $row['packing_type'];
				$packing_tot_mtr = round($row['packing_tot_mtr']);
			}
			$ed = explode("-", $packing_date);
			$packing_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
			?>
			<!-- <table style="width:188px;height:113px;"> -->
			<table <?=($sno % 2 != 0)?'style="float:right;margin-right:5mm;"':'style="float:left;margin-left:3mm;"'; ?>>
				<tr>
					<td colspan="2">
						Art : <strong><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_item, 'item_id')?></strong>
						&emsp;Box &nbsp;: &nbsp;S - <strong><?=$box_no; ?></strong>
					</td>
				</tr>
				<tr>
					<td colspan="2"><?=substr($this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_item, 'item_name'), 0, 25)?></td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						if($packing_type == 'pcs')
						{
							?>
							<strong style="float:left;">Qty&nbsp;: &nbsp;<?=$packing_rolls; ?> Nos</strong>
							<?php
						}
						else
						{
							?>
							<strong style="float:left;">Rolls&nbsp;: &nbsp;<?=$packing_rolls; ?>=<?=$packing_tot_mtr; ?>Mtrs</strong>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td align="left">
						<div class="barcode" id="bcTarget" style="width:99%;"></div>
					</td>
					<td align="right">
						N.Wt: <?=number_format($packing_net_weight, 2, '.', ''); ?><br/>
						<span class="date-label"><?=$packing_date; ?> <?=substr($packing_time, 0, -3); ?></span><br>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<span class="footer-text">A Product of <b>DYNAMIC</b> Group.</span>				
					</td>
				</tr>
			</table>			
			<?php
			echo ($sno % 2 != 0)?'<div style="clear:both;"></div>':'';
		}
		$sno++;
	}
	?>
	<script type="text/javascript">
	var barcode_text = <?=$box_no;?>;
	$(".barcode").barcode("S-"+barcode_text, "code128",{barWidth:1, barHeight:20, output:"bmp"});
	</script>
</body>
</html>