<!DOCTYPE html>
<html>

<head>
	<title>Dynamic Dost Invoice</title>
	<style type="text/css">
		@font-face {
			font-family: 'Dot Matrix';
			src: url('<?= base_url(); ?>themes/default/fonts/dot_matrix.eot');
			src: url('<?= base_url(); ?>themes/default/fonts/dot_matrix.eot?#iefix') format('embedded-opentype'),
				url('<?= base_url(); ?>themes/default/fonts/dot_matrix.woff') format('woff'),
				url('<?= base_url(); ?>themes/default/fonts/dot_matrix.ttf') format('truetype'),
				url('<?= base_url(); ?>themes/default/fonts/dot_matrix.svg#<?= base_url(); ?>themes/default/fonts/dotMatrixRegular') format('svg');
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
			height: 3.2cm;
			margin-top: 3.3cm;
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
			height: 9.3cm;
			margin-top: 1cm;
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
			margin-top: 2.9cm;
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
			margin-top: 1.0cm;
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
			margin-top: 1cm;
			/*border: 1px solid #000;*/
		}
	</style>
</head>
<!-- <body onload="window.print(); window.close()"> -->
<?php
error_reporting(E_ALL ^ E_NOTICE);
$invoice_details = $this->m_masters->getmasterdetails('bud_lbl_invoices', 'invoice_id', $invoice_id);
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
	$sub_total = explode(",", $row['sub_total']);
	$invoice_items_row = explode(",", $row['invoice_items_row']);
	$net_amount = $row['net_amount'];
	$lr_no = $row['lr_no'];
	$transport_name = $row['transport_name'];
	$remarks = $row['remarks']; //inclusion of remarks in invoice
}
$invoice_no_array = explode("/", $invoice_no);
$ed = explode("-", $invoice_date);
$invoice_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

$item_id_array = array();
$item_size_array = array();
$item_qty_array = array();
$item_uom_array = array();
$item_rate_array = array();
$item_amt_array = array();
foreach ($invoice_items_row as $key => $value) {
	$rows = explode("-", $value);
	if ($rows[2] == 0) //ER-09-18-55             
	{
		continue;
	}
	$item_id_array[] = $rows[0];
	$item_size_array[] = $rows[1];
	$item_qty_array[] = $rows[2];
	$item_uom_array[] = $rows[3];
	$item_rate_array[] = $rows[4];
	$item_amt_array[] = $rows[5];
}

$concern_details = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'concern_id', $concern_name);
foreach ($concern_details as $row) {
	$concern_title = $row['concern_name'];
	$concern_address = $row['concern_address'];
	$concern_tin = $row['concern_tin'];
	$concern_cst = $row['concern_cst'];
}
?>

<body>
	<div class="paper-outer">
		<div class="second-row">
			<div class="to-address">
				<h3><?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?></h3>
				<p><?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_address'); ?><br /></p>
				<p>GST : <?= $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_gst'); ?></p>
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
					$total_qty = 0;
					$total_amt = 0;
					foreach ($item_id_array as $key => $value) {
						$item_name = $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $value, 'item_name');
						$hsn_code = $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $value, 'hsn_code');
						$total_qty +=  $item_qty_array[$key];
						$total_amt +=  $item_amt_array[$key];
					?>
						<tr>
							<td style="width:1cm;"><?= $sno; ?></td>
							<td style="width:7.5cm;"><?= $item_name; ?></td>
							<td style="width:2cm;"><?= substr($hsn_code, 0, 4); ?></td>
							<td style="width:2cm;"><?= $item_size_array[$key]; ?></td>
							<td style="width:2cm;"><?= round($item_qty_array[$key]); ?></td>
							<td style="width:2cm;"><?= $item_rate_array[$key]; ?></td>
							<td style="float:right;"><?= ($item_qty_array[$key] * $item_rate_array[$key]); ?></td>
						</tr>
					<?php
						$sno++;
					}
					?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="float:right;">------------</td>
					</tr>
					<tr>
						<td align="right" colspan="6">Subtotal </td>
						<td style="float:right;"><strong><?= number_format($total_amt, 2, '.', ''); ?></strong></td>
					</tr>
					<?php
					$add = 0;
					$sub = 0;
					foreach ($deduction_amounts as $key => $value) {
						if ($value > 0) {
							$sub = $sub + $value;
							$deduction_description = $deduction_desc[$key];
					?>
							<tr>
								<td align="right" colspan="6"><?= $deduction_names[$key]; ?><?= ($deduction_description != '') ? '(' . $deduction_description . ')' : ''; ?></td>
								<td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
							</tr>
						<?php
						}
					}

					foreach ($addtions_amounts as $key => $value) {
						if ($value > 0) {
							$add = $add + $value;
							$addtions_description = $addtions_desc[$key];
						?>
							<tr>
								<td align="right" colspan="6"><?= $addtions_names[$key]; ?><?= ($addtions_description != '') ? '(' . $addtions_description . ')' : ''; ?></td>
								<td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
							</tr>
					<?php
						}
					}
					?>
					<tr>
						<td align="right" colspan="6">Subtotal before Tax</td>
						<td style="float:right;"><strong><?= number_format((($total_amt + $add) - $sub), 2, '.', ''); ?></strong></td>
					</tr>
					<?php
					foreach ($tax_amounts as $key => $value) {
						if ($value > 0) {
							$tax_description = $this->m_masters->getTaxDesc($tax_names[$key], $tax_values[$key]);
					?>
							<tr>
								<td align="right" colspan="6"><?= $tax_names[$key]; ?> @ <?= $tax_values[$key]; ?> % <?= ($tax_description != '') ? '(' . $tax_description . ')' : ''; ?></td>
								<td style="float:right;"><strong><?= number_format($value, 2, '.', ''); ?></strong></td>
							</tr>
					<?php
						}
					}
					?>
					<tr>
						<td align="right" colspan="6">Net Amount</td>
						<td align="right"><strong><?= number_format($net_amount, 2, '.', ''); ?></strong></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<!--inclusion of remarks in invoice-->
							<p>
								Spl. Instruction :<?= $remarks ?>
							</p>
							<!--inclusion of remarks in invoice-->
							<p>
								Goods Sent through <?= $transport_name; ?> as per LRNO:<?= $lr_no; ?>
							</p>
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
			<p style="text-transform:capitalize;"><strong style="font-size:12pt;">&#8377;</strong><?= no_to_words($net_amount); ?> Only.</p>
		</div>
		<div class="seventh-row">
			<?php
			$invoice_dc = array();
			foreach ($selected_dc as $key => $value) {
				$invoice_dc[] = $this->m_masters->getmasterIDvalue('bud_lbl_delivery', 'delivery_id', $value, 'dc_no');
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