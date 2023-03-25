<section class="panel">
	<div class="panel-body">
		<div id="formResponse-del"></div>
		<form role="form" action="<?php echo base_url('directpack/confirm_delete_save'); ?>" method="post" accept-charset="utf-8" id="deleteForm">
			<input type="hidden" name="box_id" id="box_id" value="<?php echo $box_id; ?>">
			<div class="form-group">
				<label>Remarks</label>
				<textarea name="deleted_remarks" id="deleted_remarks" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" name="password" id="password" class="form-control">
			</div>
			<button type="submit" class="btn btn-info">Save</button>
		</form>
	</div>
</section>
<script type="text/javascript">
	$("#deleteForm").submit(function(e) {
		var url = $(this).attr('action');
		// alert(url);
		$.ajax({
			type: "POST",
			url: url,
			data: $("#deleteForm").serialize(),
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