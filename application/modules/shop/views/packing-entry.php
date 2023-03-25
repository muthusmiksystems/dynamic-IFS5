<?php include APPPATH . 'views/html/header.php'; ?>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Shop Packing Entry
                    </header>
                    <div class="panel-body">

                        <div id="formResponse"></div>

                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/packing/packing_save'); ?>">
                            <input type="hidden" name="box_no" id="box_no" value="<?php echo $box_no; ?>">
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    Box No <label class="label label-danger" style="font-size:14px;">SH - <span id="next_box_no"><?php echo $new_box_no; ?></span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Supplier Name/Code</label>
                                    <select class="form-control select2" name="supplier_id" id="supplier_id">
                                        <option value="">Select</option>
                                        <?php if (sizeof($suppliers_list) > 0) : ?>
                                            <?php foreach ($suppliers_list as $row) : ?>
                                                <option value="<?php echo $row->sup_id; ?>"><?php echo $row->sup_name; ?> / <?php echo $row->sup_id; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Supplier DC No</label>
                                    <input type="text" name="supplier_dc_no" id="supplier_dc_no" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Item Group</label>
                                    <select class="form-control select2" name="item_group_id" id="item_group_id">
                                        <option value="">Select</option>
                                        <?php if (sizeof($item_groups) > 0) : ?>
                                            <?php foreach ($item_groups as $row) : ?>
                                                <option value="<?php echo $row->group_id; ?>"><?php echo $row->group_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Item Code</label>
                                    <select class="items form-control select2" id="item_code">
                                        <option value="">Select</option>
                                        <?php if (sizeof($items) > 0) : ?>
                                            <?php foreach ($items as $row) : ?>
                                                <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_id; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Item Name</label>
                                    <select class="items form-control select2" name="item_id" id="item_id">
                                        <option value="">Select</option>
                                        <?php if (sizeof($items) > 0) : ?>
                                            <?php foreach ($items as $row) : ?>
                                                <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Shade Name</label>
                                    <select class="shade-select form-control select2" name="shade_id" id="shade_id">
                                        <option value="">Select</option>
                                        <?php if (sizeof($shades) > 0) : ?>
                                            <?php foreach ($shades as $row) : ?>
                                                <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_name; ?> / <?php echo $row->shade_id; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Shade No</label>
                                    <select class="shade-select form-control select2" id="shade_code">
                                        <option value="">Select</option>
                                        <?php if (sizeof($shades) > 0) : ?>
                                            <?php foreach ($shades as $row) : ?>
                                                <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_code; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label>Lot No</label>
                                    <input type="text" name="lot_no" id="lot_no" class="form-control">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>No of box</label>
                                    <input type="text" name="no_boxes" id="no_boxes" class="form-control">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>No of cones</label>
                                    <input type="text" name="no_cones" id="no_cones" class="form-control">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>Gross weight</label>
                                    <input type="text" name="gr_weight" id="gr_weight" class="form-control">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label>Net weight</label>
                                    <input type="text" name="nt_weight" id="nt_weight" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>UOM</label>
                                    <select class="form-control select2" name="uom_id" id="uom_id">
                                        <option value="">Select</option>
                                        <?php if (sizeof($uoms) > 0) : ?>
                                            <?php foreach ($uoms as $row) : ?>
                                                <option value="<?php echo $row->uom_id; ?>"><?php echo $row->uom_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Concern</label>
                                    <select class="form-control select2" id="concern_id">
                                        <option value="">Select</option>
                                        <?php if (sizeof($concerns) > 0) : ?>
                                            <?php foreach ($concerns as $row) : ?>
                                                <option value="<?php echo $row->concern_id; ?>"><?php echo $row->concern_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Stock Room</label>
                                    <select class="form-control select2" name="stock_room_id" id="stock_room_id">
                                        <option value="">Select</option>
                                        <?php if (sizeof($stock_rooms) > 0) : ?>
                                            <?php foreach ($stock_rooms as $row) : ?>
                                                <option value="<?php echo $row->stock_room_id; ?>"><?php echo $row->stock_room_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks" id="remarks"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <button type="button" class="ajax-submit btn btn-primary" name="submit" id="save" value="save">Save</button>
                                    <button type="button" class="ajax-submit btn btn-primary" name="submit" id="save_continue" value="save_continue">Save &amp; Continue</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Shop Packing List
                    </header>
                    <div class="panel-body" id="tableItems">

                    </div>
                </section>
            </div>
        </div>

    </section>
</section>

<!-- (Ajax Modal)-->
<div class="modal fade" id="modal_ajax">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirm Delete</h4>
            </div>

            <div class="modal-body" style="height:500px; overflow:auto;">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include APPPATH . 'views/html/footer.php'; ?>
<script type="text/javascript">
    load_packing_list();
    get_next_box_no();

    $(".shade-select").change(function() {
        $("#shade_id").select2("val", $(this).val());
        $("#shade_code").select2("val", $(this).val());
    });
    $(".items").change(function() {
        $("#item_id").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());
    });

    $("#concern_id").change(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/packing/get_stock_rooms'); ?>",
            data: {
                'concern_id': $(this).val()
            },
            success: function(response) {
                // console.log(response);
                var response = $.parseJSON(response);
                $("#stock_room_id").html('');
                $("#stock_room_id").select2('destroy');
                $("#stock_room_id").html(response.stock_rooms);
                $("#stock_room_id").select2();
            }
        });
    });

    $(".ajax-submit").click(function(e) {
        var url = $("#ajaxForm").attr('action');
        var data = $("#ajaxForm").serialize();
        data += '&submit=' + $(this).val();
        // alert(data);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            beforeSend: function() {
                $(".ajax-submit").attr('disabled', true);
            },
            success: function(data) {
                response = $.parseJSON(data);
                $.each(response, function(k, v) {
                    if (k == 'error') {
                        $("#formResponse").html('<div class="alert alert-danger">' + v + '</div>');
                    }
                    if (k == 'success') {
                        // $('#modal_ajax').modal('hide');
                        $("#formResponse").html('<div class="alert alert-success">' + v + '</div>');
                    }
                    if (k == 'submit') {
                        if (v == 'save') {
                            location.reload();
                        }
                        if (v == 'save_continue') {
                            $("#gr_weight").val('');
                            $("#nt_weight").val('');
                        }
                    }
                });

                load_packing_list();
                get_next_box_no();
                $('.ajax-submit').attr('disabled', false);
            }
        });
        e.preventDefault();
    });

    function load_packing_list() {
        $.ajax({
            url: "<?php echo base_url('shop/packing/packing_list_data'); ?>",
            success: function(response) {
                jQuery('#tableItems').html(response);

                $('#dataTable').dataTable({
                    "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ records per page",
                        "oPaginate": {
                            "sPrevious": "Prev",
                            "sNext": "Next"
                        }
                    }
                });
                jQuery('#dataTable_wrapper .dataTables_filter input').addClass("form-control");
                jQuery('#dataTable_wrapper .dataTables_length select').addClass("form-control");
            }
        });
    }

    function get_next_box_no() {
        $.ajax({
            url: "<?php echo base_url('shop/packing/get_next_box_no'); ?>",
            success: function(response) {
                $("#box_no").val(response);
                $("#next_box_no").html(response);
            }
        });
    }

    function showAjaxModal(url) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url('themes/admin/img/preloader.gif') ?>" /></div>');

        // LOADING THE AJAX MODAL
        jQuery('#modal_ajax').modal('show', {
            backdrop: 'true'
        });

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response) {
                jQuery('#modal_ajax .modal-body').html(response);
            }
        });
    }

    /*$(document).on('click', 'a.delete-box', function () {
        if(confirm("Are you sure you want to delete this?")){
            var box_id = $(this).attr('id');
            alert(box_id);
            // $(this).closest('tr').remove();
        }
        else
        {
            return false;  
        }
    });*/
</script>
</body>

</html>