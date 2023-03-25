<section class="panel">
	<div class="panel-body">
		<div id="formResponse"></div>
		<form role="form" action="<?php echo base_url('shop/stocktrans/accept_dc_update'); ?>" method="post" accept-charset="utf-8" id="acceptForm">
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
			<div class="form-group">
				<label>To Stock Room</label>
				<select class="form-control select2" name="to_stock_room_id" id="to_stock_room_id">
                    <option value="">Select</option>
                    <?php if(sizeof($stock_rooms) > 0): ?>
                        <?php foreach($stock_rooms as $row): ?>
                            <option value="<?php echo $row->stock_room_id; ?>"><?php echo $row->stock_room_name; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
			</div>
			<button type="submit" class="btn btn-info">Save</button>
		</form>
	</div>
</section>

<script type="text/javascript">
	$("#acceptForm").submit(function(e) {
		var url = $(this).attr('action');
		$.ajax({
			type: "POST",
			url: url,
			data: $("#acceptForm").serialize(),
			beforeSend: function(data)
			{
				$(".ajax-loader").css('display', 'block');
			},
			success: function(data)
			{
				// console.log(data);
				response = $.parseJSON(data);
				jQuery('#modal_ajax').modal('hide');
				location.reload();
			}
		});

		e.preventDefault();
	});
</script>