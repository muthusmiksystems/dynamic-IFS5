<!DOCTYPE html>
<html>

<head>
	<title>Dyed Thread Packing Slip</title>
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
	<?php
	$inner_boxes = json_decode($box->inner_boxes);
	$no_of_cones = 0;
	foreach ($inner_boxes as $inner_box_id => $row) {
		$inner_box = $this->ak->thread_inner_box_details($inner_box_id);
		if ($inner_box) {
			$no_of_cones += $inner_box->no_of_cones;
		}
	}
	?>
	<table style="width:100%;margin:0 auto;">
		<tr>
			<td width="15%"></td>
			<td width="35%"></td>
			<td width="15%"></td>
			<td width="35%"></td>
		</tr>
		<tr>
			<td colspan="4" class="ps-title">INDOFILA THREAD PACKING SLIP</td>
		</tr>
		<tr>
			<td>Box No</td>
			<td class="ps-boxno">: <?= $box->box_prefix; ?><?= $box->box_no; ?></td>
			<td>N.Wt</td>
			<td>: <?= number_format($box->net_weight, 3, '.', ''); ?></td>
		</tr>
		<?php
		$tare_weight = $box->gross_weight - $box->net_weight;
		?>
		<tr>
			<td>Gr.Wt</td>
			<td>: <?= $box->gross_weight; ?></td>
			<td>T.Wt</td>
			<td>: <?= number_format($tare_weight, 3, '.', ''); ?></td>
		</tr>
		<tr>
			<td>PKD by</td>
			<td>: <?= $box->packed_by; ?></td>
			<td># Cones</td>
			<td>: <strong style="font-size:14px;"><?= $no_of_cones; ?></strong></td>
		</tr>
		<tr>
			<td colspan="4">
				<table width="100%">
					<thead>
						<tr>
							<th>Box No</th>
							<th>Lot No</th>
							<th>Item/No</th>
							<th>Shade/No</th>
							<th>Code</th>
							<th>#Cones</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($inner_boxes as $inner_box_id => $row) {
							$inner_box = $this->ak->thread_inner_box_details($inner_box_id);
						?>
							<tr>
								<td align="center">I<?php echo $inner_box->inner_box_id; ?></td>
								<td align="center"><?= $inner_box->lot_no; ?></td>
								<td align="center"><?= $inner_box->item_name; ?>/<?= $inner_box->item_id; ?></td>
								<td align="center"><?= $inner_box->shade_name; ?>/<?= $inner_box->shade_id; ?></td>
								<td align="center"><?= $inner_box->shade_code; ?></td>
								<td align="center"><strong><?= $row->no_of_cones; ?></strong></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="ps-barcode">
				<span class="ps-time"><?= date("d-m-Y H:i:s", strtotime($box->packed_date)); ?></span><br>
				<div id="bcTarget"></div>
			</td>
		</tr>
		<tr class="border-top">
			<td colspan="4" class="ps-footer">
				Note : Pls do not mix Yarns of two different lots<br> Customer Care: 93453 40123, 91592 40123, 91509 30760
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		var barcode_text = "<?= $box->box_id; ?>";
		$("#bcTarget").barcode("TI" + barcode_text, "code128", {
			barWidth: 2,
			barHeight: 30,
			output: "bmp"
		});
	</script>
</body>

</html>