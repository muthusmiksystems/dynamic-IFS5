<?php include APPPATH.'views/html/header.php'; ?>
<style type="text/css">
    @media print{
        @page{
            margin: 3mm;
        }
    }
</style>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Direct Lot Entry
                    </header>
                    <div class="panel-body">
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('directpack/lot_save/'.$lot_id); ?>">
                            <!-- <div class="row">
                                <div class="form-group col-lg-3">
                                    Receipt No <label class="label label-danger" style="font-size:14px;">SHOP - <span id="receipt_no">1</span></label>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Select Machine</label>
                                    <select class="select2 form-control" name="machine_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($machines) > 0): ?>
                                            <?php foreach($machines as $row): ?>
                                                <option value="<?php echo $row->machine_id; ?>"><?php echo $row->machine_prefix; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Item Name</label>
                                    <select class="select2 item-select form-control" name="item_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($items) > 0): ?>
                                            <?php foreach($items as $row): ?>
                                                <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Item Code</label>
                                    <select class="select2 item-select form-control">
                                        <option value="">Select</option>
                                        <?php if(sizeof($items) > 0): ?>
                                            <?php foreach($items as $row): ?>
                                                <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_id; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Shade Name</label>
                                    <select class="select2 shade-select form-control" name="shade_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($shades) > 0): ?>
                                            <?php foreach($shades as $row): ?>
                                                <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Shade Code</label>
                                    <select class="select2 shade-select form-control">
                                        <option value="">Select</option>
                                        <?php if(sizeof($shades) > 0): ?>
                                            <?php foreach($shades as $row): ?>
                                                <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_code; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Oil Required</label>
                                    <input type="text" name="oil_required" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label># Springs</label>
                                    <input type="text" name="no_springs" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Lot Qty</label>
                                    <input type="text" name="lot_qty" class="form-control">
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="submit" name="submit" value="submit" class="ajax-submit btn btn-primary">Save</button>
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
                        Direct Lot Entry List
                    </header>
                    <div class="panel-body" id="lot_list_data">
                        
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">   
    load_lot_list();
    $("#ajaxForm").submit(function(e) {
        var url = $(this).attr('action');
        // alert(url);
        $.ajax({
            type: "POST",
            url: url,
            data: $("#ajaxForm").serialize(),
            beforeSend: function(response)
            {
                $(".ajax-loader").css('display', 'block');
            },
            success: function(response)
            {
                // console.log(response);
                var response = $.parseJSON(response);
                $.each(response, function(k, v) {
                    if(k=='error')
                    {
                        $("#formResponse").html('<div class="alert alert-danger">'+v+'</div>');
                    }
                    if(k == 'success')
                    {
                        $("#formResponse").html('<div class="alert alert-success">'+v+'</div>');
                        load_lot_list();
                    }
                });
            }
        });

        e.preventDefault();
    });

    $('.item-select').change(function() {
        $(".item-select").select2('val', $(this).val());
    });
    $('.shade-select').change(function() {
        $(".shade-select").select2('val', $(this).val());
    });

    function load_lot_list() {
        $.ajax({
            url: "<?php echo base_url('directpack/lot_list_data'); ?>",
            success: function(response)
            {
                jQuery('#lot_list_data').html(response);
                oTable01 = $('.datatables').dataTable({
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
                jQuery('.dataTables_filter input').addClass("form-control");
                jQuery('.dataTables_length select').addClass("form-control");
            }
        });
    }
</script>
</body>
</html>