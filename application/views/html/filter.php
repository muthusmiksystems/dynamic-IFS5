<script>
    jQuery(document).ready(function() {
        function getModuleItems(id) {
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>customer_purchase_order/po_from_customers_items_by_module/" + id,
                success: function(res) {
                    var data = JSON.parse(res);
                    var options = '<option value="">Select</option>';
                    jQuery.each(data, function(i, item) {
                        var sel = '';
                        <?php if (@$filter['filter_item_id']) { ?>
                            sel = (data[i].item_id == <?= @$filter['filter_item_id']; ?>) ? ' selected="true" ' : '';
                        <?php } ?>
                        options += '<option value="' + data[i].item_id + '" ' + sel + '>' + data[i].item_name + ' - ' + data[i].item_id + '</option>';
                    });

                    jQuery("#filter_item_id").select2('destroy');
                    jQuery("#filter_item_id").html(options);
                    jQuery("#filter_item_id").select2();
                }
            });
        }

        var ids = jQuery("#filter_module_id").val();
        if (ids != '') {
            getModuleItems(ids);
        }

        jQuery("#filter_module_id").on('change', function() {
            var id = $(this).val();
            var options = '<option value="">Select</option>';
            jQuery("#filter_item_id").select2('destroy');
            jQuery("#filter_item_id").html(options);
            jQuery("#filter_item_id").select2();

            if (id != '') {
                getModuleItems(id);
            }
        });
    });
</script>