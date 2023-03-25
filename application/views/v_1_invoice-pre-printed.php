<!DOCTYPE html>
<html>

<head>
	<title>Shiva Tapes Packing Slip</title>
	<style type="text/css">
		@font-face {
			font-family: 'Dot Matrix';
			src: url('http://localhost/indofila/themes/default/fonts/dot_matrix.eot');
			src: url('http://localhost/indofila/themes/default/fonts/dot_matrix.eot?#iefix') format('embedded-opentype'),
				url('http://localhost/indofila/themes/default/fonts/dot_matrix.woff') format('woff'),
				url('http://localhost/indofila/themes/default/fonts/dot_matrix.ttf') format('truetype'),
				url('http://localhost/indofila/themes/default/fonts/dot_matrix.svg#http://localhost/indofila/themes/default/fonts/dotMatrixRegular') format('svg');
			font-weight: normal;
			font-style: normal;
		}

		@page {
			size: A4;
			margin: 0;
		}

		@media print {
			.page {
				margin: 0;
				border: initial;
				border-radius: initial;
				width: initial;
				min-height: initial;
				box-shadow: initial;
				background: initial;
				page-break-after: always;
			}
		}

		body {
			margin: 0;
			padding: 0;
			background-color: #FAFAFA;
			font-family: 'Dot Matrix';
			/*font-size: 12px;*/
		}

		.paper-outer {
			width: 21cm;
			min-height: 29.7cm;
			/*padding: 2cm;*/
			margin: 0cm auto;
			border: 1px #D3D3D3 solid;
			border-radius: 5px;
			background: url('<?= base_url(); ?>themes/default/img/pre-printed.jpg');
			background-size: 100% 100%;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		}

		.second-row {
			widows: 21cm;
			height: 2.5cm;
			margin-top: 4.3cm;
			/*border: 1px solid #000;*/
		}

		.to-address {
			margin-left: 11cm
		}

		.to-address h3 {
			margin: 0px;
		}

		.to-address p {
			margin: 0px;
		}

		.third-row {
			widows: 21cm;
			height: 1cm;
			margin-top: 0.3cm;
			/*border: 1px solid #000;*/
		}

		.left-align {
			float: left;
		}

		.invoice-no {
			line-height: 0.9cm;
			margin-left: 2.5cm;
		}

		.invoice-date {
			line-height: 0.9cm;
			margin-left: 2.5cm;
		}

		.fourth-row {
			width: 21cm;
			height: 8.3cm;
			margin-top: 2cm;
			/*border: 1px solid #000;*/
			overflow: hidden;
		}

		.particulers {
			width: 19.5cm;
			margin: 0 auto;
			/*border: 1px solid #000;*/
		}

		.fifth-row {
			width: 21cm;
			height: 1.5cm;
			margin-top: 1.8cm;
			margin-left: 1.0cm;
			/*border: 1px solid #000;*/
		}

		.net-amount {
			float: right;
			margin-right: 2cm;
			line-height: 0.7;
		}

		.six-row {
			width: 21cm;
			height: 0.7cm;
			margin-top: 0.2cm;
			/*border: 1px solid #000;*/
		}

		.six-row p {
			margin: 0px;
			line-height: 0.8cm;
			margin-left: 2.5cm;
		}

		.seventh-row {
			width: 5cm;
			margin-left: 4cm;
			margin-top: 0.3cm;
			/*border: 1px solid #000;*/
		}
	</style>
</head>

<body onload="window.print();">
	<?php
	error_reporting(E_ALL ^ E_NOTICE);
	$sub_total = 0;
	$total_cones = 0;
	$total_gr_wt = 0;
	$total_net_wt = 0;
	$items_array = array();
	$boxes_array = array();
	$pre_delivery_list = array();
	$item_names_arr = array();
	$gr_weights_arr = array();
	$nt_weights_arr = array();
	$no_cones_arr = array();
	$rates_arr = array();
	$invoice_details = $this->m_masters->getmasterdetails('bud_yt_invoices', 'invoice_id', $invoice_id);
	foreach ($invoice_details as $row) {
		$concern_name = $row['concern_name'];
		$invoice_no = $row['invoice_no'];
		$invoice_date = $row['invoice_date'];
		$customer = $row['customer'];
		$selected_dc = explode(",", $row['selected_dc']);
		$invoice_items = explode(",", $row['invoice_items']);
		$item_weights = explode(",", $row['item_weights']);
		$item_rate = explode(",", $row['item_rate']);
		$no_of_boxes = explode(",", $row['no_of_boxes']);
		$item_uoms = explode(",", $row['item_uoms']);
		$boxes_array = explode(",", $row['boxes_array']);
		$addtions_names = explode(",", $row['addtions_names']);
		$addtions_values = explode(",", $row['addtions_values']);
		$addtions_amounts = explode(",", $row['addtions_amounts']);
		$addtions_desc = explode(",", $row['addtions_desc']);
		$tax_names = explode(",", $row['tax_names']);
		$tax_values = explode(",", $row['tax_values']);
		$tax_amounts = explode(",", $row['tax_amounts']);
		$deduction_names = explode(",", $row['deduction_names']);
		$deduction_values = explode(",", $row['deduction_values']);
		$deduction_amounts = explode(",", $row['deduction_amounts']);
		$deduction_desc = explode(",", $row['deduction_desc']);
		$sub_total = $row['sub_total'];
		$net_amount = $row['net_amount'];
		$lr_no = $row['lr_no'];
		$transport_name = $row['transport_name'];
		$cust_pono = @$row['cust_pono'];
		$remarks = @$row['remarks'];
	}
	$invoice_no_array = explode("/", $invoice_no);
	$ed = explode("-", $invoice_date);
	$invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

	$concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
	foreach ($concern_details as $row) {
		$concern_title = $row['concern_name'];
		$concern_address = $row['concern_address'];
		$concern_tin = $row['concern_tin'];
		$concern_cst = $row['concern_cst'];
	}

	foreach ($boxes_array as $key => $box_no) {
		// $outerboxes = $this->m_delivery->getPreDelItemsDetails($box_no);
		$outerboxes = $this->m_delivery->getPackingBoxDetails($box_no);
		foreach ($outerboxes as $outerbox) {
			$no_of_cones = $outerbox['no_of_cones'];
			$packing_gr_weight = $outerbox['gross_weight'];
			$packing_net_weight = $outerbox['net_weight'];
			$yarn_lot_no = $outerbox['lot_no'];
			$item_name = $outerbox['item_name'];
			$item_id = $outerbox['item_id'];
			$pre_delivery_list[$yarn_lot_no][$outerbox['box_id']] = $outerbox['box_prefix'] . $outerbox['box_no'];
			$item_names_arr[$outerbox['box_id']] = $item_name . '/' . $item_id;
			$item_id_arr[$outerbox['box_id']] = $item_id;
			$gr_weights_arr[$outerbox['box_id']] = $packing_gr_weight;
			$nt_weights_arr[$outerbox['box_id']] = $packing_net_weight;
			$no_cones_arr[$outerbox['box_id']] = $no_of_cones;
			$total_cones += $no_of_cones;
			$total_gr_wt += $packing_gr_weight;
			$total_net_wt += $packing_net_weight;
			$invoice_items[] = $item_id;
			$rates_arr[$box_no] = $item_rate[$key];
		}
	}

	?>

	<body>
		<div class="paper-outer">
			<div class="second-row">
				<div class="to-address">
					<h3><?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?></h3>
					<p><?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_address'); ?><br /></p>
					<p>Tin No : <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_tinno'); ?></p>
				</div>
			</div>
			<div class="third-row">
				<div class="invoice-no left-align" style="font-size:10px;">
					<?= $invoice_no_array[0]; ?>/<strong style="font-size:24px;"><?= $invoice_no_array[1]; ?></strong>
				</div>
				<div class="invoice-date left-align">
					<?= $invoice_date; ?>
				</div>
			</div>
			<div class="fourth-row">
				<div class="particulers">
					<table style="width:100%;">
						<?php
						$sno = 1;
						$total_items = 0;
						foreach ($pre_delivery_list as $key => $value) {
							$lotwise_nt_weight = 0;
							$lotwise_gr_weight = 0;
							$lotwise_no_boxes = 0;
							$lotwise_amount = 0;
							foreach ($value as $key_1 => $value_1) {
								$lotwise_no_boxes++;
								$total_cones += $no_cones_arr[$key_1];
								$lotwise_nt_weight += $nt_weights_arr[$key_1];
								$lotwise_gr_weight += $gr_weights_arr[$key_1];
								$lotwise_amount += $nt_weights_arr[$key_1] * $rates_arr[$key_1];
							}
						?>
							<tr>
								<td style="width:1cm;"><?= $sno; ?></td>
								<td style="width:1cm;"><?= $lotwise_no_boxes; ?></td>
								<td style="width:6cm;"><?= $item_names_arr[$key_1];  ?></td>
								<td style="width:2cm;">
									<?php
									$hsn = $this->m_masters->getmasterdetails('bud_items', 'item_id', $item_id_arr[$key_1]);
									foreach ($hsn as $h) {
										echo substr($h['hsn_code'], 0, 4);
									}
									?>
								</td>
								<td style="width:1cm;"><?= $key; ?></td>
								<td style="width:2cm;"><?= $lotwise_gr_weight; ?></td>
								<td style="width:2cm;"><?= $lotwise_nt_weight; ?></td>
								<td><?= $rates_arr[$key_1]; ?></td>
								<td style="float:right;"><?= $lotwise_amount; ?></td>
							</tr>
						<?php
							$sno++;
							$total_items++;
						}
						?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td style="float:right;">------------------</td>
						</tr>
						<tr>
							<td align="right" colspan="7">Subtotal before Tax</td>
							<td style="float:right;"><strong><?= number_format($sub_total, 2, '.', ''); ?></strong></td>
						</tr>
						<?php
						foreach ($deduction_amounts as $key => $value) {
							if ($value > 0) {
								$deduction_description = $deduction_desc[$key];
						?>
								<tr>
									<td align="right" colspan="7"><?= $deduction_names[$key]; ?><?= ($deduction_description != '') ? '(' . $deduction_description . ')' : ''; ?></td>
									<td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
								</tr>
							<?php
							}
						}

						foreach ($addtions_amounts as $key => $value) {
							if ($value > 0) {
								$addtions_description = $addtions_desc[$key];
							?>
								<tr>
									<td align="right" colspan="7"><strong><?= $addtions_names[$key]; ?></strong><?= ($addtions_description != '') ? '(' . $addtions_description . ')' : ''; ?></td>
									<td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
								</tr>
							<?php
							}
						}
						foreach ($tax_amounts as $key => $value) {
							if ($value > 0) {
								$tax_description = $this->m_masters->getTaxDesc($tax_names[$key], $tax_values[$key]);
							?>
								<tr>
									<td align="right" colspan="7"><strong><?= $tax_names[$key]; ?> @ <?= $tax_values[$key]; ?> % </strong><?= ($tax_description != '') ? '(' . $tax_description . ')' : ''; ?></td>
									<td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
								</tr>
						<?php
							}
						}
						?>
						<tr>
							<td align="right" colspan="7">Net Amount</td>
							<td align="right"><strong><?= number_format($net_amount, 2, '.', ''); ?></strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4">
								<p>Goods Sent through <?= $transport_name; ?> as per LRNO:<?= $lr_no; ?></p>
								<p>Customer PO No. <?= $cust_pono; ?></p>
								<p><?= $remarks; ?></p>
							</td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="fifth-row">
				<div class="net-amount">
					<h3><?= number_format($net_amount, 2, '.', ''); ?></h3>
				</div>
			</div>
			<div class="six-row">
				<p style="text-transform: capitalize;">Rupees <?= no_to_words($net_amount); ?> Only.</p>
			</div>
			<div class="seventh-row">
				<?php
				$invoice_dc = array();
				foreach ($selected_dc as $key => $value) {
					$invoice_dc[] = $this->m_masters->getmasterIDvalue('bud_te_delivery', 'delivery_id', $value, 'dc_no');
				}
				?>
				<p><?= implode(",", $invoice_dc); ?></p>
			</div>
		</div>

		<?php
		function no_to_words($no)
		{
			$words = array('0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fouteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty', '30' => 'thirty', '40' => 'fourty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninty', '100' => 'hundred &', '1000' => 'thousand', '100000' => 'lakh', '10000000' => 'crore');
			if ($no == 0)
				return ' ';
			else {
				$novalue = '';
				$highno = $no;
				$remainno = 0;
				$value = 100;
				$value1 = 1000;
				while ($no >= 100) {
					if (($value <= $no) && ($no  < $value1)) {
						$novalue = $words["$value"];
						$highno = (int) ($no / $value);
						$remainno = $no % $value;
						break;
					}
					$value = $value1;
					$value1 = $value * 100;
				}
				if (array_key_exists("$highno", $words))
					return $words["$highno"] . " " . $novalue . " " . no_to_words($remainno);
				else {
					$unit = $highno % 10;
					$ten = (int) ($highno / 10) * 10;
					return $words["$ten"] . " " . $words["$unit"] . " " . $novalue . " " . no_to_words($remainno);
				}
			}
		}
		?>
	</body>

</html>