<!DOCTYPE html>
<html>

<head>
	<title>Gray Yarn Soft Packing Slip</title>
	<style type="text/css">
		table {
			border: 1px solid #000;
			border-collapse: collapse;
		}

		table td {
			font-size: 9pt;
			font-family: "Arial Rounded MT", Arial, Helvetica, sans-serif;
			font-weight: bold;
			padding-left: 10px;
		}

		table tr td.ps-title {
			font-weight: bold;
			font-size: 10pt;
			text-align: center;
		}

		table tr td.ps-boxno {
			font-weight: bold;
			font-size: 13pt;
		}

		span.ps-time {
			font-size: 5pt;
			text-align: center;
		}

		table tr td.ps-barcode {
			text-align: center;
			float: none;
		}

		#bcTarget {
			margin: 0 auto;
		}

		table tr.border-top td {
			border-top: 1px solid #000;
		}

		table td.border-right {
			border-right: 1px solid #000;
			padding-right: 2px;
		}

		table .ps-footer {
			text-align: center;
		}
	</style>
	<?php
	foreach ($js as $path) {
	?>
		<script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
	<?php
	}
	?>
</head>

<body onload="window.print();">
	<?php //var_dump($box); 
	?>
	<table style="width:100%;margin:0 auto;">
		<tr>
			<td width="15%"></td>
			<td width="35%"></td>
			<td width="15%"></td>
			<td width="35%"></td>
		</tr>
		<tr>
			<td colspan="4" class="ps-title">SOFT PACKAGE SLIP</td>
		</tr>
		<tr>
			<td>Box No</td>
			<td class="ps-boxno">: <?= $box->box_prefix; ?><?= $box->box_no; ?></td>
			<td>Springs</td>
			<td>: <?php echo $box->no_cones + $box->no_of_cones_2; ?></td>
		</tr>
		<tr>
			<td>Y.Quality</td>
			<td>: <?= substr($box->denier_tech, 0, 10); ?></td>
			<td>Gr.Wt</td>
			<td>: <?= number_format($box->gross_weight, 3, '.', ''); ?></td>
		</tr>
		<?php
		$tare_weight = $box->gross_weight - $box->net_weight;
		?>
		<tr>
			<td>ITEM</td>
			<td>: <?= $box->item_name; ?> / <?= $box->item_id; ?></td>
			<td>T.Wt</td>
			<td>: <?= number_format($tare_weight, 3, '.', ''); ?></td>
		</tr>
		<tr>
			<td>Y.Lot No</td>
			<td>: <strong style="font-size: 8.5pt;">
					<?php $cl = @explode('**', $box->yarn_lot_id)[0];
					echo ($cl != '') ? 'CL' . $cl : 'N/A';
					?>
				</strong>
			</td>			
			<td>N.Wt</td>
			<td>: <?= number_format($box->net_weight, 3, '.', ''); ?></td>
		</tr>
		<tr>
			<td>Shade</td>
			<td>: <?= $box->shade_name; ?> / <?= $box->shade_code; ?></td>
			<td>PKD by</td>
			<td>: <?= $box->packed_by; ?></td>
		</tr>
		<tr>
			<td>Note to HOD</td>
			<!--Inclusion remarks packing slip-->
			<td colspan="3">: <?= $box->remarks; ?></td>
			<!--Inclusion remarks needed in packing slip-->
		</tr>
		<tr>
			<td colspan="4" class="ps-barcode">
				<span class="ps-time"><?= date("d-m-Y H:i:s", strtotime($box->packed_date)); ?></span><br>
				<div id="bcTarget"></div>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		var barcode_text = "<?= $box->box_id; ?>";
		$("#bcTarget").barcode("S" + barcode_text, "code128", {
			barWidth: 2,
			barHeight: 30,
			output: "bmp"
		});
	</script>
</body>

</html>