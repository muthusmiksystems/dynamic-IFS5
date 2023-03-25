<!DOCTYPE html>
<html>
<head>
	<title>Shiva Tapes Packing Slip</title>
	<style type="text/css">
		<!--
		@page rotated { size : landscape }
		@page { size:1.9in 1.1in; margin: 2.5mm }
		-->
		@media print{
			/*@page { size:1.9in 1.1in; margin: 5mm }*/
			.screen-only
			{
				display: none;
			}
			body
			{
				margin-top: 1.5mm;
			}
			table
			{
				width: 49%;
				float: left;
			}
		}
		table.odd
		{
			float: left;
			margin-left: 3mm;
		}
		table.even
		{
			float: right;
			margin-right: 5mm;
		}
		table td strong
		{
			font-size:7pt;
		}
		table td
		{			
			font-family: "Arial Black", Gadget, sans-serif;
			color: #000;
			font-size:5pt;
			letter-spacing: 1px;
			padding: 0px;
		}
		span.date-label
		{
			font-size: 5pt;			
		}
		span.footer-text
		{
			font-size: 4pt;
		}
		.footer-text strong
		{
			font-size: 5pt;
		}
		.barcode
		{
			/*margin-bottom: 0.5mm;*/
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
	for ($i=1; $i <= $no_qty; $i++) {
		?>
		<table <?=($i % 2 != 0)?'style="float:left;"':'style="float:right;"'; ?>>
	      <tr>
	        <td colspan="2">
	          	<strong><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item_name, 'item_name'); ?></strong>
	        </td>
	      </tr>
	      <?php
	      if($with_barcode)
	      {
	        ?>
	        <tr>
	        	<td align="left">Art No: <strong><?=$item_name; ?></strong></td>
	          	<td align="left">
	            	<div class="barcode" id="bcTarget<?=$i; ?>" style="width:99%;"></div>
	          	</td>
	        </tr>
	        <?php
	      }
	      ?>
	      <tr>
	      	<td># Rolls : <strong><?=$no_rolls; ?></strong></td>
	      	<td>Total Qty : <strong><?=$item_qty; ?></strong> <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item_uom, 'uom_name'); ?></td>
	      </tr>
	      <tr>
	        <td colspan="2">
	        	<!-- <span class="footer-text">SHIVA TAPES from <strong>DYNAMIC</strong> Group.</span> -->
	        	<span class="footer-text">A Product of <strong>DYNAMIC DOST</strong></span>
	        </td>
	      </tr>
	    </table>
	    <?php
	    // echo ($i % 2 == 0)?'<div style="clear:both;visibility:hidden;height:0px;"></div><br>':'';
	}
	?>
	<!-- <button class="screen-only" onclick="window.print(); window.close()">Print</button>    -->
	<script type="text/javascript">
	var barcode_text = <?=$item_name;?>;
	<?php
	for ($i=1; $i <= $no_qty; $i++) { 
		?>
		$("#bcTarget"+<?=$i; ?>).barcode(""+barcode_text, "code128",{barWidth:1, barHeight:20, output:"bmp"});
		<?php
	}
	?>
	</script>
</body>
</html>