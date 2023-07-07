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
                        Shop Rate Master
                    </header>
                    <div class="panel-body">
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/sales/rate_master_save'); ?>">                            
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Customer Name</label>
                                    <select class="customer select2 form-control" name="customer_id" id="customer_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>"><?php echo $row->cust_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Customer Code</label>
                                    <select class="customer select2 form-control" id="customer_code">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>"><?php echo $row->cust_id; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
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

                                <div class="form-group col-md-2">
                                    <label>Color Code</label>
                                    <select class="shades select2 form-control" id="shade_code">
                                        <option value="">Select</option>
                                        <?php if(sizeof($shades) > 0): ?>
                                            <?php foreach($shades as $row): ?>
                                                <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_code; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Color Name</label>
                                    <select class="shades select2 form-control" name="shade_id" id="shade_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($shades) > 0): ?>
                                            <?php foreach($shades as $row): ?>
                                                <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_name; ?>  \  <?php echo $row->shade_id; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12" id="result-data">
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
                                    <th>Customer</th>
                                    <th>Item Name/Code</th>
                                    <th>Shade Name/Code</th>
                                    <th>Shade No</th>
                                    <th>Item Rates</th>
                                    <th>Current Rate</th>
                                    <th>Changed On</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sno = 1; ?>
                                <?php if(sizeof($rate_list) > 0): ?>
                                    <?php foreach($rate_list as $row): ?>
                                        <?php
                                        $item_rates = explode(",", $row->item_rates);
                                        $rate_changed_on = explode(",", $row->rate_changed_on);
                                        $description = explode(",", $row->description);
                                        $item_rate_active = $row->item_rate_active;
                                        ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $row->cust_name; ?></td>
                                            <td><?php echo $row->item_name; ?>/<?php echo $row->item_id; ?></td>
                                            <td><?php echo $row->shade_name; ?>/<?php echo $row->shade_id; ?></td>
                                            <td><?php echo $row->shade_code; ?></td>
                                            <td><?php echo implode("<br>", $item_rates); ?></td>
                                            <td><?php echo $item_rates[$item_rate_active]; ?></td>
                                            <td><?php echo implode("<br>", $rate_changed_on); ?></td>
                                            <td><?php echo implode("<br>", $description); ?></td>
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

    $(".customer").change(function(){
        $("#customer").select2("val", $(this).val());
        $("#customer_code").select2("val", $(this).val());
        $("#item_id").select2("val", '');
        $("#item_code").select2("val", '');
        $("#shade_code").select2("val", '');
        $("#shade_id").select2("val", '');
        $("#result-data").html('');
    });

    $(".items").change(function(){
        $("#item_id").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());
        $("#shade_code").select2("val", '');
        $("#shade_id").select2("val", '');
        $("#result-data").html('');
    });


    $(".shades").change(function(e) {
        $("#shade_code").select2("val", $(this).val());
        $("#shade_id").select2("val", $(this).val());
        // alert(data);
       $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/sales/item_rates_data'); ?>",
            data: {
                customer_id: $("#customer_id").val(),
                item_id: $("#item_id").val(),
                shade_id: $("#shade_id").val(),
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
                        $("#customer_id").select2("val", '');
                        $("#customer_code").select2("val", '');
                        $("#item_id").select2("val", '');
                        $("#item_code").select2("val", '');
                        $("#shade_id").select2("val", '');
                        $("#shade_code").select2("val", '');
                    }
                });
            }
        });
        e.preventDefault();
    });
</script>
</body>
</html>