</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>themes/default/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/select2.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/bootstrap-switch.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/jquery.tagsinput.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/jquery.sparkline.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/jquery.customSelect.min.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/bootstrap-daterangepicker/date.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/data-tables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo base_url('themes/default/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js'); ?>"></script>
<!--common script for all pages-->
<script src="<?php echo base_url(); ?>themes/default/js/common-scripts.js"></script>
<!--script for this page-->
<script src="<?php echo base_url(); ?>themes/default/js/form-validation-script.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/form-component.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/dynamic-table.js"></script>
<script src="<?php echo base_url(); ?>themes/default/js/jQuery.print.js"></script>
<script type="text/javascript">
	$(document).ajaxStop(function() {
		$('#loading').modal('hide');
	});
	$(document).ajaxStart(function() {
		$('#loading').modal('show');
	});
</script>