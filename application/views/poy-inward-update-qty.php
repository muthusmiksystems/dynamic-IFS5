<?php if ($item) : ?>
	<section class="panel">
		<div class="panel-body">
			<div id="formResponse"></div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Inward No</th>
						<th>Item Name /Code</th>
						<th>R.Mat & POY denier</th>
						<th>R.Mat & POY lot</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $item->po_no; ?></td>
						<td><?php echo $item->item_name; ?>/<?php echo $item->item_id; ?></td>
						<td><?php echo $item->denier_name; ?></td>
						<td><?php echo $item->poy_lot_no; ?></td>
					</tr>
				</tbody>
			</table>
			<form role="form" action="<?php echo base_url('poy/inwd_addqty_save'); ?>" method="post" accept-charset="utf-8" id="examForm">
				<input type="hidden" id="po_no" <?php echo $item->po_no; ?>>
				<input type="hidden" name="rowid" id="rowid" value="<?php echo $item->rowid; ?>">
				<div class="form-group">
					<label>Invoice No</label>
					<input type="text" class="form-control" value="<?php echo $item->inward_invoice_no; ?>" id="inward_invoice_no" name="inward_invoice_no">
				</div>
				<div class="form-group">
					<label>Invoice Date</label>
					<input type="text" class="dateplugin form-control" value="<?php echo $inward_date; ?>" id="inward_date" name="inward_date">
				</div>
				<div class="form-group">
					<label>R.Mat & POY Lot No.</label>
					<input type="text" class="form-control" value="<?php echo $item->poy_lot_no_current; ?>" id="poy_lot_no_current" name="poy_lot_no_current">
				</div>
				<div class="form-group">
					<label>Quality</label>
					<input type="text" class="form-control" value="<?php echo $item->inward_quality; ?>" id="inward_quality" name="inward_quality">
				</div>
				<div class="form-group">
					<label for="qty">Qty</label>
					<input type="text" class="form-control" value="<?php echo $qty; ?>" id="qty" name="qty">
				</div>
				<!--inclusion of poy item rate-->
				<div class="form-group">
					<label for="po_item_rate">Rate</label>
					<input type="text" class="form-control" value="<?= $item->po_item_rate; ?>" id="po_item_rate" name="po_item_rate">
				</div>
				<!--end of inclusion of poy item rates-->
				<div class="form-group">
					<label for="remarks">Remarks</label>
					<textarea class="form-control" name="remarks" id="remarks"></textarea>
				</div>
				<button type="submit" class="btn btn-info">Save</button>
				<img src="<?php echo base_url('themes/default/img/loader.gif') ?>" alt="loading" class="ajax-loader" style="display:none;">
			</form>
		</div>
	</section>

	<script type="text/javascript">
		$("#examForm").submit(function(e) {
			var url = $(this).attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: $("#examForm").serialize(),
				beforeSend: function(data) {
					$(".ajax-loader").css('display', 'block');
				},
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
					$(".ajax-loader").css('display', 'none');
					get_detail('<?php echo $item->po_no; ?>');
				}
			});

			e.preventDefault();
		});
	</script>
<?php endif; ?>