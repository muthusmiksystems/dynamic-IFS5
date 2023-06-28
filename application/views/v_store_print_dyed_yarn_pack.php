<!DOCTYPE html>
<html>

<head>
	<title>Dyed Yarn Soft Packing Slip</title>
	<style type="text/css">
		table {
			border: 1px solid #000;
			border-collapse: collapse;
		}

		table td {
			font-size: 8pt;
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
			font-size: 6pt;
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

		table tr td.ps-wight {
			font-weight: bold;
			font-size: 13px;
		}
		.table_border{
			margin:0 auto; 
			margin-left:20px !important;
			margin-right:30px !important;
			
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
	<table style="width:90%;" class="table_border">
		<tr>
			<td width="15%"></td>
			<td width="35%"></td>
			<td width="15%"></td>
			<td width="35%"></td>
		</tr>
		<tr>
			<td colspan="4" class="ps-title">DYNAMIC DOST PACKING SLIP</td>
		</tr>
		<tr>
			<td>Box No</td>
			<td class="ps-boxno">: <?= $box->box_prefix; ?><?= $box->box_no; ?></td>
			<td># Cones</td>
			<td class="ps-boxno">: <?php echo $box->no_cones + $box->no_of_cones_2; ?></td>
		</tr>
		<tr>
			<!-- <td>Denier</td>
			<td>: <?= $box->denier_tech; ?></td> -->
			<td>Item Name</td>
			<td>: <?= $box->item_name; ?></td>
			<td>Gr.Wt</td>
			<td>: <?= number_format($box->gross_weight, 3, '.', ''); ?></td>
		</tr>
		<?php
		$tare_weight = $box->gross_weight - $box->net_weight;
		?>
		<tr>
			<td>Shade</td>
			<td>: <?= $box->shade_name; ?></td>
			<td>T.Wt</td>
			<td>: <?= number_format($tare_weight, 3, '.', ''); ?></td>
		</tr>
		<tr>
			<td>Sh. No</td>
			<td>: <?= $box->shade_code; ?></td>
			<td>N.Wt</td>
			<td class="ps-wight">: <?= number_format($box->net_weight, 3, '.', ''); ?></td>
		</tr>
		<tr>
			<td>Lot No</td>
			<td>: <?= $box->lot_no; ?></td>
			<td>PKD by</td>
			<td>: <?= $box->packed_by; ?></td>
		</tr>
		<tr>
			<!-- <td>Note to HOD</td> -->
			<td>Remarks</td>
			<!--Inclusion remarks packing slip-->
			<td colspan="3">: <?= substr($box->box_remarks,0,100); ?></td>
			<!--Inclusion remarks needed in packing slip-->
		</tr>
		<tr>
			<td colspan="4" class="ps-barcode">
				<span class="ps-time"><?= date("d-m-Y H:i:s", strtotime($box->packed_date)); ?></span><br>
				<div id="bcTarget"></div>
			</td>
		</tr>
		<tr class="border-top">
			<td colspan="4" class="ps-footer">
				Note : Pls do not mix Yarns of two different lots<br> Customer Care:  93453 40123, 93441 40123, 93452 40123
			</td>
		</tr>
		<!--<tr  class='hidden-print'><td colspan="4"><a href="<?= base_url(); ?>store/dyed_yarn_packing/<?= ($continue) ? $box->box_id : ''; ?>"  title="Packing Entry Page">Back</a></td>
		</tr>-->
	</table>
	<script type="text/javascript">
		var barcode_text = "<?= $box->box_id; ?>";
		$("#bcTarget").barcode("D" + barcode_text, "code128", {
			barWidth: 2,
			barHeight: 30,
			output: "bmp"
		});
	</script>
</body>

</html>