<section class="panel">
	<div class="panel-body" >
		<div class="form-group col-lg-4">
			<label >LOT No : </label>
			<span class="label label-danger" style="padding: 0 1em;font-size:24px;">
				<?=$next; ?>
			</span>
		</div>
		<div class="form-group col-lg-4">
			<label >Total qty </label>
			<span class="label label-warning" style="padding: 0 1em;font-size:24px;">
				<?=$tot ?>
			</span>
		</div>		

		<div class="form-group col-lg-4">
			<label >Remaining qty </label>
			<span class="label label-primary" style="padding: 0 1em;font-size:24px;" id="remain">
				<?=$balance ?>
			</span>
		</div>	

		<div class="form-group col-lg-4">
			<label for="machine">Machine</label>
			<select class="select2 form-control itemsselects" id="machine" name="machine" required>
				<?php
				foreach ($machines as $row) {
					?>
					<option value="<?=$row['machine_id']; ?>"><?=$row['machine_prefix']; ?><?=$row['machine_id']; ?></option>
					<?php
				}
				?>
			</select>
		</div>

		<div class="form-group col-lg-4">
			<label for="lot_oil_required">Oil Required</label>
			<input class="form-control" id="lot_oil_required" name="lot_oil_required" value="0" required>
			<input type="hidden" id="lot_shade_no" value="<?=$lot_shade_no; ?>">
			<input type="hidden" id="lot_item_id" value="<?=$lot_item_id; ?>">
			<input type="hidden" id="nextlot" value="<?=$next; ?>">
		</div>

		<div class="form-group col-lg-4">
			<label for="po_qty">Dyed Lot Production Qty(Net Weight)</label>
			<input type="text" class="form-control" id="lot_qty" name="lot_qty">
		</div>
		<div class="col-lg-8"></div>
		<div class="form-group col-lg-4">
			<label for="no_springs">No of Springs</label>
			<input type="text" class="form-control" id="no_springs" name="no_springs">
		</div>
		<div style="clear:both"></div>
		<div class="form-group col-lg-4">
			<label for="po_qty">&nbsp;</label>
			<td>
				<!-- <button class="btn btn-success" onclick="form_submit()">Save</button> -->
				<button class="btn btn-success" id="create_lot">Save Lot</button>
			</td>
		</div>
	</div>

	<!-- Loading -->
	<div class="pageloader"></div>
</section>
<script>
function form_submit()
{
	var machine = $("#machine").val();
	var lot = $("#lot_qty").val();
	if( lot > 0 )
	{
		$.ajax({
			type : "POST",
			url  : "<?=base_url(); ?>purchase_order/po_dyeing_production_form_save/"+<?=$R_po_no ?>+"/"+<?=$id ?>+"/"+lot+"/"+machine,
			success: function(e){
				if(e == "success")
				{
					alert("successfully updated");
					get_form(<?php echo $id.",".$R_po_no ?>);
				}
			}
		});
	}
	else
	{
		alert("Check Dyed Lot Production Qty");
	}
}

$('#create_lot').click(function(){
	if($("#lot_oil_required").val() == '') {
		alert("Enter Lot Oil Required");
	}
	else if($("#lot_qty").val() == '') {
		alert("Enter Lot Qty");
	}
	else {
	    $.post("<?php echo base_url('purchase_order/po_dyeing_production_form_save');?>", {
	        po_no: <?=$R_po_no ?>,
	        nextlot: $("#nextlot").val(),
	        lot_prefix: $("#machine").val(),
	        lot_oil_required: $("#lot_oil_required").val(),
	        lot_qty: $("#lot_qty").val(),
	        lot_item_id: $("#lot_item_id").val(),
	        lot_shade_no: $("#lot_shade_no").val(),
	        no_springs: $("#no_springs").val()
	    })
	    .done(function(data) {
	        // The API returned success response
	        alert("Successfully Updated");
	        get_form(<?php echo $id.",".$R_po_no ?>);
	    })
	    .fail(function(jqXHR, textStatus, errorThrown) {
	        // The API returned an error response
	        alert("API Error: " + textStatus + " - " + errorThrown);
	    });		
	}
});
</script>

