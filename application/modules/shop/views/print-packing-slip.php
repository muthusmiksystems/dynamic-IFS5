<!DOCTYPE html>
<html>

<head>
	<title>Packing Slip</title>
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
</head>

<body>
	<!-- <body onload="window.print();"> -->
	<table style="width:100%;margin:0 auto;">
		<tr class="hidden-print">
			<td width="20%"></td>
			<td width="30%"></td>
			<td width="20%"></td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td>Box No</td>
			<td class="ps-boxno">: SH<?php echo $box->box_no; ?></td>
			<td># Spring</td>
			<td>: <?php echo $box->no_cones; ?></td>
		</tr>
		<tr>
			<td>Item</td>
			<td>: <?php echo $box->item_name; ?></td>
			<td>Gr.wt</td>
			<td>: <?php echo $box->gr_weight; ?></td>
		</tr>
		<tr>
			<td>Shade Name</td>
			<td>: <?php echo $box->shade_name; ?></td>
			<td>Nt.Wt</td>
			<td>: <?php echo $box->nt_weight; ?> <?php //echo $box->uom_name; 
													?></td>
		</tr>
		<tr>
			<td>Shade No</td>
			<td>: <?php echo $box->shade_code; ?></td>
			<td>Pkd. By</td>
			<td>: <?php echo $box->user_nicename; ?></td>
		</tr>
		<tr>
			<td>Lot No</td>
			<td>: <?php echo $box->lot_no; ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="4" class="ps-barcode">
				<span class="ps-time"><?php echo date("d-m-Y H:i:s", strtotime($box->packed_on)); ?></span><br>
				<div id="bcTarget"></div>
			</td>
		</tr>
		<tr class="border-top">
			<td colspan="4" class="ps-footer">
				Note : Pls do not mix Yarns of two different lots<br> Customer Care: 93453 40123, 91592 40123, 91509 30760
			</td>
		</tr>
	</table>

	<script src="<?php echo base_url('themes/default/barcode/jquery-1.3.2.min.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('themes/default/barcode/jquery-barcode.js'); ?>" type="text/javascript"></script>
	<script type="text/javascript">
		var barcode_text = '<?php echo $box->box_id; ?>';
		$("#bcTarget").barcode(barcode_text, "code128", {
			barWidth: 2,
			barHeight: 30,
			output: "bmp"
		});
	</script>
</body>

</html>