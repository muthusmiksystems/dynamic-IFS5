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
                        Shop general Rate Master
                    </header>
                    <div class="panel-body">
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/sales/gen_rate_master_save'); ?>">                            
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Item Code</label>
                                    <select class="items select2 form-control" id="item_code">
                                        <option value="">Select</option>
                                        <?php if(sizeof($items) > 0): ?>
                                            <?php foreach($items as $row): ?>
                                                <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_id; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Item Name</label>
                                    <select class="items select2 form-control" name="item_id" id="item_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($items) > 0): ?>
                                            <?php foreach($items as $row): ?>
                                                <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Color Category</label>
                                    <select class="select2 form-control" name="category_id" id="category_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($color_categories) > 0): ?>
                                            <?php foreach($color_categories as $row): ?>
                                                <option value="<?php echo $row->category_id; ?>"><?php echo $row->color_category; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6" id="result-data">
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="button" name="submit" value="submit" class="ajax-submit btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="panel">
                    <header class="panel-heading">
                        Shop Rate Master
                    </header>
                    <div class="panel-body" id="transfer_dc">
                        <table class="table table-bordered dataTables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name/Code</th>
                                    <th>Color Category</th>
                                    <th>Qty From</th>
                                    <th>Qty To</th>
                                    <th>Item Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sno = 1; ?>
                                <?php if(sizeof($rate_list) > 0): ?>
                                    <?php foreach($rate_list as $row): ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $row->item_name; ?>/<?php echo $row->item_id; ?></td>
                                            <td><?php echo $row->color_category; ?></td>
                                            <td><?php echo $row->qty_from; ?></td>
                                            <td><?php echo $row->qty_to; ?></td>
                                            <td><?php echo $row->item_rate; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>       
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });

    oTable01 = $('.dataTables').dataTable({
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
    

    $(".items").change(function(){
        $("#item_id").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());
        $("#shade_code").select2("val", '');
        $("#shade_id").select2("val", '');
        $("#result-data").html('');
    });


    $("#category_id").change(function(e) {
        // alert(data);
       $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/sales/gen_item_rates_data'); ?>",
            data: {
                item_id: $("#item_id").val(),
                category_id: $("#category_id").val(),
            },
            success: function(response)
            {
                // response = $.parseJSON(data);
                // console.log(response);
                $("#result-data").html(response);
            }
        });
        e.preventDefault();
    });

    var i=2;
    $(document).on('click', ".add-row", function(e){
        var table_row = '<tr>';
        table_row += '<td><input type="text" name="qty_from[]" class="form-control input-sm"></td>';
        table_row += '<td><input type="text" name="qty_to[]" class="form-control input-sm"></td>';
        table_row += '<td><input type="text" name="item_rate[]" class="form-control input-sm"></td>';
        table_row += '<td><button class="remove-row btn btn-xs btn-danger">Remove</button></td>';
        table_row += '</tr>';
        $('#result-data table').append(table_row);
        i++;
    });
    
    $(document).on('click', ".remove-row", function(e){
        $(this).closest('tr').remove();
    });

    $(".ajax-submit").click(function(e) {
        var url =  $("#ajaxForm").attr('action');
        var data = $("#ajaxForm").serialize();
        data +=  '&submit=' + $(this).val();

       $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response)
            {
                response = $.parseJSON(response);
                $.each(response, function(k, v) {
                    if(k=='error')
                    {
                        $("#result-data").html('<div class="alert alert-danger">'+v+'</div>');
                    }
                    if(k=='success')
                    {
                        // $('#modal_ajax').modal('hide');
                        $("#result-data").html('<div class="alert alert-success">'+v+'</div>');
                        $("#item_id").select2("val", '');
                        $("#item_code").select2("val", '');
                        $("#category_id").select2("val", '');
                    }
                });
            }
        });
        e.preventDefault();
    });
</script>
</body>
</html>