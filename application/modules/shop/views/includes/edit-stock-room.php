<section class="panel">
	<div class="panel-body">
		<div id="formResponse-del"></div>
		<form role="form" action="<?php echo base_url('shop/predelivery/update_stock_room'); ?>" method="post" accept-charset="utf-8" id="updateStockRoom">
			<input type="hidden" name="box_id" id="box_id" value="<?php echo $box_id; ?>">
			<div class="form-group">
				<label>Existing Stock Room</label><br>
				<strong><?php echo $box->stock_room_name; ?></strong>
			</div>
			<div class="form-group">
				<label>To Stock Room</label>
				<select class="form-control" name="stock_room_id" id="edit_stock_room_id">
                    <option value="">Select</option>
                    <?php if(sizeof($stock_rooms) > 0): ?>
                        <?php foreach($stock_rooms as $row): ?>
                            <option value="<?php echo $row->stock_room_id; ?>" <?php echo ($row->stock_room_id == $box->stock_room_id)?'selected="selected"':''; ?>><?php echo $row->stock_room_name; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
			</div>
			<button type="submit" class="btn btn-info">Update</button>
		</form>
	</div>
</section>
<script type="text/javascript">
	$("#updateStockRoom").submit(function(e) {
		var url = $(this).attr('action');
		// alert(url);
		$.ajax({
			type: "POST",
			url: url,
			data: $("#updateStockRoom").serialize(),
			beforeSend: function(data)
			{
				$(".ajax-loader").css('display', 'block');
			},
			success: function(data)
			{
				response = $.parseJSON(data);
	            $.each(response, function(k, v) {
	                if(k=='error')
	                {
	                    $("#formResponse-del").html('<div class="alert alert-danger">'+v+'</div>');
	                }
	                if(k=='success')
	                {
	                	jQuery('#modal_ajax').modal('hide');
	                	load_packing_list();
	                }
	            });
			}
		});

		e.preventDefault();
	});
</script>