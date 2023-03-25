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
                        Shop Cash Receipt Cash Transfer
                    </header>
                    <div class="panel-body">
                        <div id="formResponse"></div>
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    Cash Transfer No <label class="label label-danger" style="font-size:14px;"><?php echo $transfer_id; ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12" id="recpt_list">
                                    
                                </div>
                            </div>

                            
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="#">
                            <div class="row">
                                <div class="form-group col-md-12" id="temp_list">
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>To Staff</label>
                                    <select class="select2 form-control" name="transfer_to" id="transfer_to">
                                        <option value="">Select</option>
                                        <?php if(sizeof($users) > 0): ?>
                                            <?php foreach($users as $row): ?>
                                                <option value="<?php echo $row->ID; ?>"><?php echo $row->display_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="formResponse-2"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="button" name="submit" value="submit" class="ajax-submit btn btn-primary">Save</button>
                                    <!-- <button type="button" name="submit" value="submit" class="ajax-submit btn btn-primary">Print</button> -->
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
                        Shop Cash Receipt Cash Transfer List
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transfer No</th>
                                    <th>Date</th>
                                    <th>From Staff</th>
                                    <th>To Staff</th>
                                    <th>Remarks</th>
                                    <th>Receipt Nos</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                ?>
                                <?php if(sizeof($transfer_list) > 0): ?>
                                    <?php foreach($transfer_list as $row): ?>
                                        <?php
                                        $receipt_nos = array();
                                        $receipt_amt = 0;
                                        $receipt_ids = explode(",", $row->receipt_ids);
                                        if(count($receipt_ids) > 0)
                                        {
                                            foreach ($receipt_ids as $receipt_id) {
                                                $receipt = $this->Sales_model->get_cash_receipt($receipt_id);
                                                if($receipt)
                                                {
                                                    $receipt_nos[] = 'SHOP-'.$receipt->receipt_id;
                                                    $receipt_amt += $receipt->amount;
                                                }
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $row->id; ?></td>
                                            <td><?php echo date("d-m-Y g:i A", strtotime($row->transfer_date)); ?></td>
                                            <td><?php echo $row->from_staff_name; ?></td>
                                            <td><?php echo $row->to_staff_name; ?></td>
                                            <td><?php echo $row->remarks; ?></td>
                                            <td><?php echo implode(", ", $receipt_nos); ?></td>
                                            <td><?php echo number_format($receipt_amt, 2, '.', ''); ?></td>
                                            <td>
                                                <?php if($row->accepted_by == '' && $row->transfer_to != $this->session->userdata('user_id')): ?>
                                                    <label class="badge bg-warning">Accept Pending</label>
                                                <?php else: ?>
                                                    <label class="badge bg-success">Accepted</label>
                                                <?php endif; ?>
                                                <a href="<?php echo base_url('shop/cashreceipts/print_cash_trans/'.$row->id); ?>" target="_blank" class="btn btn-xs btn-primary">Print</a>
                                            </td>
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

    load_cart_items();
    load_receipts();

    function get_cash_receipt_no() {
        $.ajax({
            url: "<?php echo base_url('shop/sales/get_cash_receipt_no'); ?>",
            success: function(response)
            {
                $("#receipt_no").html(response);
            }
        });
    }

    var oTable01;


    $(document).on('click', '#select_all', function(e){
        if(this.checked){
            $('tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $('tbody input[type="checkbox"]:checked').trigger('click');
        }
        e.stopPropagation();
    });

    $(document).on('click', "input[type='checkbox']", function(){
        var matches = [];
        var cart_boxes = 0;
        var cart_gr_wt = 0;
        var cart_nt_wt = 0;
        var checkedcollection = oTable01.$(".receipt-id:checked", { "page": "all" });
        checkedcollection.each(function (index, elem) {
            matches.push($(elem).val());
        });
        $("#selected_ids").val(matches);
    });

    function addToCart() {
        var selected_ids = $("#selected_ids").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/cashreceipts/add_to_list'); ?>",
            data: {'selected_ids':selected_ids},
            failure: function(errMsg) {
                console.error("error:",errMsg);
            },
            success: function(response)
            {
                // console.log(response);
                load_cart_items();
                load_receipts();
            }
        });
    }

    $(document).on('click', ".remove-cart-item", function(e){
        var row_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('shop/cashreceipts/remove_to_list'); ?>",
                data: {'row_id':row_id},
                failure: function(errMsg) {
                    console.error("error:",errMsg);
                },
                success: function(response)
                {
                    // console.log(response);
                    load_cart_items();
                    load_receipts();
                }
            });
        }
        else{
            return false;
        }
    });

    function load_cart_items() {
        $.ajax({
            url: "<?php echo base_url('shop/cashreceipts/cart_temp_items'); ?>",
            success: function(response)
            {
                jQuery('#temp_list').html(response);
            }
        });
    }
    function load_receipts() {
        $.ajax({
            url: "<?php echo base_url('shop/cashreceipts/cash_recpt_list'); ?>",
            success: function(response)
            {
                jQuery('#recpt_list').html(response);
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

    $(document).on('click', ".ajax-submit", function(e){
        var receipt_ids = $('input[name="receipt_ids[]"]').map(function(){ 
            return this.value; 
        }).get();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/cashreceipts/cash_recpt_trans'); ?>",
            data: {
                'transfer_to': $("#transfer_to").val(),
                'remarks': $("#remarks").val(),
                'receipt_ids[]': receipt_ids
            },
            failure: function(errMsg) {
                console.error("error:",errMsg);
            },
            success: function(response)
            {
                var response = $.parseJSON(response);
                $.each(response, function(k, v) {
                    if(k=='error')
                    {
                        $("#formResponse-2").html('<div class="alert alert-danger">'+v+'</div>');
                    }
                    if(k == 'id')
                    {
                        window.location.href = "<?php echo base_url('shop/cashreceipts/print_cash_trans'); ?>/"+v;
                        load_cart_items();
                        load_receipts();
                        // load_packing_list();
                        // get_next_pdc_no();
                    }
                });
            }
        });
    });
</script>
</body>
</html>