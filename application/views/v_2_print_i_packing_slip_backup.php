<!DOCTYPE html>
<html>
<head>
	<title>Shiva Tapes Packing Slip</title>
	<style type="text/css">
		<!--
		@page { size:1.9in 1.1in; margin: 1cm }
		-->
		table
		{
			/*border: 1px solid #000;*/
		}
		table td strong
		{
			font-size:12px;
		}
		table td
		{			
			font-family: Verdana, Geneva, sans-serif;
			color: #000;
			font-size:9px;
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
<body>
	<?php
	$box_details = $this->m_masters->getmasterdetails('bud_te_innerboxes', 'box_no', $box_no);
	foreach ($box_details as $row) {
		$box_no = $row['box_no'];
		$packing_item = $row['packing_item'];
		$packing_rolls = $row['packing_rolls'];
		$packing_date = $row['packing_date'];
		$packing_time = $row['packing_time'];
	}
	$ed = explode("-", $packing_date);
	$packing_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
	?>
	<!-- <table style="width:188px;height:113px;"> -->
	<table>
		<tr>
			<td>
				Art : <strong><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_item, 'item_id')?></strong>
				&emsp;Box &nbsp;: &nbsp;<strong>S - <?=$box_no; ?></strong>
			</td>
		</tr>
		<tr>
			<td><?=substr($this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_item, 'item_name'), 0, 25)?></td>
		</tr>
		<tr>
			<td>
			<strong style="float:left;">Rolls&nbsp;: &nbsp;<?=$packing_rolls; ?></strong>  <span style="float:right;"><?=$packing_date; ?><br/><?=$packing_time; ?></span>
			</td>
		</tr>
		<tr>
			<td align="left">
				<div id="bcTarget" style="width:99%;"></div>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
	var barcode_text = <?=$box_no;?>;
	$("#bcTarget").barcode("I-"+barcode_text, "code128",{barWidth:1, barHeight:20, output:"bmp"});
	</script>
</body>
</html>