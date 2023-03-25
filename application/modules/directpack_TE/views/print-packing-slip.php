<!DOCTYPE html>
<html>
<head>
	<title>Packing Slip</title>
	<style type="text/css">
		<!--
		@page rotated { size : landscape }
		@page { size:100mm 70mm; margin: 1.5mm }
		-->
		table
		{
			border: 1px solid #000;
			border-collapse:collapse;
		}
		table td
		{
			font-size: 9pt;
			font-family: Verdana, Geneva, sans-serif;
			font-weight: bold;
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
		table td.ps-boxno span{
			font-size: 32px;
			font-weight: bold;
		}
	</style>
</head>
<body>
<!-- <body onload="window.print();"> -->
	<table style="width:100%;margin:0 auto;">
		<tr>
			<td width="15%"></td>
			<td width="35%"></td>
			<td width="15%"></td>
			<td width="35%"></td>
		</tr>
		<tr>
			<td colspan="4" class="ps-title" align="center">PACKING SLIP</td>
		</tr>
		<tr>
			<td>Box No</td>
			<td class="ps-boxno">: <?=$box->box_prefix; ?><span><?=$box->box_no; ?></span></td>
			<td>Cones</td>
			<td>: <?=$box->no_of_cones; ?></td>
		</tr>
		<tr>
			<td>Denier</td>
			<td>: <?=$box->item_name; ?></td>
			<td>Gr.Wt</td>
			<td>: <?=number_format($box->gross_weight, 3, '.', ''); ?></td>
		</tr>
		<?php
		$tare_weight = $box->gross_weight - $box->net_weight;
		?>
		<tr>
			<td>Shade</td>
			<td>: <?=$box->shade_name; ?></td>
			<td>T.Wt</td>
			<td>: <?=number_format($tare_weight, 3, '.', ''); ?></td>
		</tr>
		<tr>
			<td>Sh. No</td>
			<td>: <?=$box->shade_code; ?></td>
			<td>N.Wt</td>
			<td>: <?=number_format($box->net_weight, 3, '.', ''); ?></td>
		</tr>
		<tr>
			<td>Lot No</td>
			<td>: <?=$box->lot_lot_no; ?></td>
			<td>PKD by</td>
			<td>: <?=$box->user_nicename; ?></td>
		</tr>
		<tr>
			<td colspan="4" class="ps-barcode">
				<span class="ps-time"><?=date("d-m-Y H:i:s", strtotime($box->packed_date)); ?></span><br>
				<div id="bcTarget"></div>
			</td>			
		</tr>
		<tr class="border-top">
			<td colspan="4" class="ps-footer">
				Remarks : <?php echo $box->remarks; ?><br>
				<!-- Note : Pls do not mix Yarns of two different lots<br> -->
				Customer Care: 91509 29883, 93453 40123
			</td>
		</tr>
	</table>

	<script src="<?php echo base_url('themes/default/barcode/jquery-1.3.2.min.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('themes/default/barcode/jquery-barcode.js'); ?>" type="text/javascript"></script>
	<script type="text/javascript">
		var barcode_text = '<?php echo $box->box_id; ?>';
		$("#bcTarget").barcode(barcode_text, "code128",{barWidth:2, barHeight:30, output:"bmp"});
	</script>
</body>
</html>