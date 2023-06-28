<?php if ($item) : ?>
	<section class="panel">
		<!-- <?php
	$len= strlen($item[0]->lot_id); // Get the length of $lot_id
	$machine_id = substr($item[0]->lot_no, 0, -$len); //
	?> -->
		<div class="panel-body">
			<div id="formResponse"></div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Lot Id</th>
						<th>Item Name</th>
						<th>Shade Name</th>
						<th>Shade Code</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $item[0]->lot_id; ?></td>
						<td><?php echo $item[0]->item_name; ?>/<?php echo $item[0]->lot_item_id; ?></td>
						<td><?php echo $item[0]->shade_name; ?>/<?php echo $item[0]->lot_shade_no; ?></td>
						<td><?php echo $item[0]->shade_code; ?></td>
					</tr>
				</tbody>
			</table>
			<form role="form" action="<?php echo base_url('directpack/lot_save/' . $item[0]->lot_id . '/' . $item[0]->lot_no); ?>" method="post" accept-charset="utf-8" id="examForm">
				<!-- Form fields omitted for brevity -->

				<input type="hidden" id="po_no" <?php echo $item[0]->lot_no; ?>>
				<input type="hidden" name="rowid" id="rowid" value="<?php echo $item[0]->lot_no; ?>">

				<input type="hidden" name="upd_lot_no" id="upd_lot_no" value="<?php echo $item[0]->	lot_no; ?>">
				<input type="hidden" name="upd_lot_id" id="upd_lot_id" value="<?php echo $item[0]->	lot_id; ?>">
				<input type="hidden" name="machine_id" id="machine_id" value="<?php echo $item[0]->	lot_prefix; ?>">
				<input type="hidden" name="item_id" id="item_id" value="<?php echo $item[0]->lot_item_id; ?>">
				<input type="hidden" name="shade_id" id="item_id" value="<?php echo $item[0]->lot_shade_no; ?>">
			
				<!-- <div class="form-group">
					<label>Invoice No</label>
					<input type="text" class="form-control" value="<?php echo $item->inward_invoice_no; ?>" id="inward_invoice_no" name="inward_invoice_no">
				</div> -->
				<div class="form-group">
					<label>Invoice Date</label>
					<input type="text" class="dateplugin form-control" value="<?php echo $inward_date; ?>" id="inward_date" name="inward_date">
				</div>
				<div class="form-group">
					<label>Direct Lot No</label>
					 <span class="form-control" id="poy_lot_no_current" name="poy_lot_no_current"><?php echo $item[0]->lot_no; ?></span>
				</div>
				<div class="form-group">
					<label>Invoice No</label>
					<input type="text" class="form-control" value="<?php echo $item[0]->lot_invoice_no; ?>" id="lot_invoice_no" name="lot_invoice_no">
				</div>
				
				<div class="form-group">
					<label>Quality</label>
					<input type="text" class="form-control" value="<?php echo $item[0]->lot_quality; ?>" id="lot_quality" name="lot_quality">
				</div>
				<div class="form-group">
					<label for="qty">Qty</label>
					<input type="text" class="form-control" value="" id="lot_qty" name="lot_qty">
				</div>
				<!--inclusion of poy item rate-->
				<div class="form-group">
					<label for="po_item_rate"># Units</label>
					<input type="text" class="form-control" value="<?php echo $item[0]->no_springs; ?>" id="no_springs" name="no_springs">
				</div>

				<div class="form-group">
					<label for="lot_rate">Lot Rate</label>
					<input type="text" class="form-control" value="<?php echo $item[0]->lot_rate; ?>" id="lot_rate" name="lot_rate">
				</div>

        	<div class="form-group">
					<label for="lot_oil_required">Oil Required</label>
					<input type="text" class="form-control" value="<?php echo $item[0]->lot_oil_required; ?>" id="oil_required" name="oil_required">
				</div>
				<!--end of inclusion of poy item rates-->
				<div class="form-group">
					<label for="remarks">Remarks</label>
					<textarea class="form-control" name="lot_remark" id="lot_remark"></textarea>
				</div>
				<!-- JavaScript validation -->
				<script type="text/javascript">
					$("#examForm").submit(function(e) {
						e.preventDefault(); // Prevent form submission

						// Validate late rate and units
						var lateRate = $("#lot_rate").val();
						var lot_qty = $("#lot_qty").val();

						if (lateRate === '') {
							$("#formResponse").html('<div class="alert alert-warning">Please enter the  rate.</div>');
						} 
						if (lot_qty === '') {
							$("#formResponse").html('<div class="alert alert-warning">Please enter the Qty.</div>');
						}else if (isNaN(lateRate)) {
							$("#formResponse").html('<div class="alert alert-warning">Please enter numeric values for the  rate.</div>');
						} else {
							$(".ajax-loader").css('display', 'block'); // Show loader

							// Submit the form
							$.ajax({
								type: "POST",
								url: $(this).attr('action'),
								data: $(this).serialize(),
								success: function(data) {
									response = $.parseJSON(data);
			
									$.each(response, function(k, v) {
										if (k == 'error') {
											$("#formResponse").html(v);
										}
										if (k == 'success') {
											$('#modal_ajax').modal('hide');
											location.reload();
										}
									});
									$(".ajax-loader").css('display', 'none'); // Hide loader
								}
							});
						}
					});
				</script>

				<button type="submit" class="btn btn-info">Save</button>
				<img src="<?php echo base_url('themes/default/img/loader.gif') ?>" alt="loading" class="ajax-loader" style="display:none;">
			</form>
		</div>
	</section>
<?php endif; ?>
