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
                        Shop Cash Receipt
                    </header>
                    <div class="panel-body">
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/sales/cash_receipt_save'); ?>">
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    Receipt No <label class="label label-danger" style="font-size:14px;">SHOP - <span id="receipt_no">1</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Concern Name</label>
                                    <select class="select2 form-control" name="concern_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($concerns) > 0): ?>
                                            <?php foreach($concerns as $row): ?>
                                                <option value="<?php echo $row->concern_id; ?>"><?php echo $row->concern_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Party Name</label>
                                    <select class="select2 form-control" name="customer_id" id="customer_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>"><?php echo $row->cust_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Name</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Mobile No</label>
                                    <input type="text" name="mobile_no" id="mobile_no" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Amount</label>
                                    <input type="text" name="amount" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Purpose</label>
                                    <textarea name="purpose" class="form-control"></textarea>
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
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Shop Cash Receipt List
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered datatables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Receipt No</th>
                                    <th>Date</th>
                                    <th>Concern Name</th>
                                    <th>Party Name</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>Amount</th>
                                    <th>Purpose</th>
                                    <th>Received By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                ?>
                                <?php if(sizeof($receipt_list) > 0): ?>
                                    <?php foreach($receipt_list as $row): ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td>SHOP-<?php echo $row->receipt_id; ?></td>
                                            <td><?php echo $row->receipt_date; ?></td>
                                            <td><?php echo $row->concern_name; ?></td>
                                            <td><?php echo $row->cust_name; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->mobile_no; ?></td>
                                            <td><?php echo $row->amount; ?></td>
                                            <td><?php echo $row->purpose; ?></td>
                                            <td><?php echo $row->display_name; ?></td>
                                            <th>
                                                <a href="<?php echo base_url('shop/sales/print_cash_receipt/'.$row->receipt_id); ?>" target="_blank" class="btn btn-xs btn-primary">Print</a>
                                            </th>
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

    get_cash_receipt_no();

    $(".ajax-submit").click(function(e) {
        var url =  $("#ajaxForm").attr('action');
        var data = $("#ajaxForm").serialize();
        data +=  '&submit=' + $(this).val();
        // alert(data);
       $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data)
            {
                response = $.parseJSON(data);
                $.each(response, function(k, v) {
                    if(k=='error')
                    {
                        $("#formResponse").html('<div class="alert alert-danger">'+v+'</div>');
                    }
                    if(k=='receipt_id')
                    {
                        // $('#modal_ajax').modal('hide');
                        // $("#formResponse").html('<div class="alert alert-success">'+v+'</div>');
                        window.location.href = "<?php echo base_url('shop/sales/print_cash_receipt'); ?>/"+v;
                    }
                });
                get_cash_receipt_no();
            }
        });
        e.preventDefault();
    });

    function get_cash_receipt_no() {
        $.ajax({
            url: "<?php echo base_url('shop/sales/get_cash_receipt_no'); ?>",
            success: function(response)
            {
                $("#receipt_no").html(response);
            }
        });
    }

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

    $("#customer_id").change(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/predelivery/get_costomer'); ?>",
            data: {
                'p_customer_id':$("#customer_id").val()
            },
            failure: function(errMsg) {
                console.error("error:",errMsg);
            },
            success: function(response)
            {
                var response = $.parseJSON(response);
                $("#name").val(response.name);
                $("#mobile_no").val(response.mobile_no);
                // console.log(response);
            }
        });
    });
</script>
</body>
</html>