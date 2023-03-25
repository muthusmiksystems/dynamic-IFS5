<section class="panel">
	<div class="panel-body">
		<div id="formResponse-del"></div>
		<form role="form" action="<?php echo base_url('poy/wpoy_accept/' . $id); ?>" method="post" accept-charset="utf-8" id="acceptForm">
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" name="password" id="password" class="form-control">
			</div>
			<button type="submit" class="btn btn-info">Save</button>
		</form>
	</div>
</section>
<script type="text/javascript">
	$("#acceptForm").submit(function(e) {
		var url = $(this).attr('action');
		// alert(url);
		$.ajax({
			type: "POST",
			url: url,
			data: $("#acceptForm").serialize(),
			beforeSend: function(data) {
				$(".ajax-loader").css('display', 'block');
			},
			success: function(data) {
				response = $.parseJSON(data);
				$.each(response, function(k, v) {
					if (k == 'error') {
						$("#formResponse-del").html('<div class="alert alert-danger">' + v + '</div>');
					}
					if (k == 'success') {
						jQuery('#modal_ajax').modal('hide');
						location.reload();
					}
				});
			}
		});

		e.preventDefault();
	});
</script>