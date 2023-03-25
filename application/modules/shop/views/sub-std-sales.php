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
                            Sub Standard Sales
                        </header>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Quotation No</th>
                                        <th>Date</th>
                                        <th>Concern Name</th>
                                        <th>Party Name</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Amount</th>
                                        <th>
                                            <label>
                                                <input type="checkbox" id="select_all">
                                                Select All
                                            </label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($quotations) > 0): ?>
                                        <?php foreach($quotations as $quotation): ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td>QUOT NO-<?php echo $quotation->quotation_id; ?></td>
                                                <td><?php echo date("d-m-Y g:i A", strtotime($quotation->quotation_date)); ?></td>
                                                <td><?php echo $quotation->concern_name; ?></td>
                                                <td><?php echo $quotation->cust_name; ?></td>
                                                <td><?php echo $quotation->name; ?></td>
                                                <td><?php echo $quotation->mobile_no; ?></td>
                                                <td><?php echo $quotation->quotation_amt; ?></td>
                                                <td>
                                                    <input type="checkbox" class="chkBoxId" value="<?php echo $quotation->quotation_id; ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <input type="hidden" name="selected_ids" id="selected_ids">

                            <button class="btn btn-danger" onclick="addToCart()">Add to List</button>

                            <div class="row">
                                <div class="col-md-12" id="cart_items">
                                    
                                </div>
                            </div>

                            <div id="formResponse-2"></div>

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Concern Name</label>
                                    <select class="select2 form-control" id="concern_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($concerns) > 0): ?>
                                            <?php foreach($concerns as $row): ?>
                                                <option value="<?php echo $row->concern_id; ?>" <?php echo ($row->concern_id == $concern_id)?'selected="selected"':''; ?>><?php echo $row->concern_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Party Name</label>
                                    <select class="select2 form-control" id="customer_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>" <?php echo ($row->cust_id == $customer_id)?'selected="selected"':''; ?>><?php echo $row->cust_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Delivery Address</label>
                                    <select class="select2 form-control" id="delivery_to">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>" <?php echo ($row->cust_id == $delivery_to)?'selected="selected"':''; ?>><?php echo $row->cust_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="name" value="<?php echo $name; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks" id=""></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="save_invoice()" class="btn btn-danger">SAVE</button>
                                </div>
                            </div>
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

    var index = $(".dataTables").find('th:last').index();
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
        var checkedcollection = oTable01.$(".chkBoxId:checked", { "page": "all" });
        checkedcollection.each(function (index, elem) {
            matches.push($(elem).val());
            /*cart_boxes++;
            cart_gr_wt += parseFloat($(elem).closest('tr').find('td.box-gr-wt').text());
            cart_nt_wt += parseFloat($(elem).closest('tr').find('td.box-nt-wt').text());*/
        });
        $("#selected_ids").val(matches);
        /*$(".cart-boxes").text(cart_boxes);
        $(".cart-gr-wt").text(cart_gr_wt.toFixed(3));
        $(".cart-nt-wt").text(cart_nt_wt.toFixed(3));*/
        // alert(matches);
    });

    function addToCart() {
        var selected_ids = $("#selected_ids").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/scrapsales/add_to_cart'); ?>",
            data: {'selected_ids':selected_ids},
            failure: function(errMsg) {
                console.error("error:",errMsg);
            },
            success: function(response)
            {
                load_cart_items();
                // load_packing_list();
            }
        });
    }

     $(document).on('click', ".remove-cart-item", function(e){
        var row_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('shop/scrapsales/remove_to_cart'); ?>",
                data: {'row_id':row_id},
                failure: function(errMsg) {
                    console.error("error:",errMsg);
                },
                success: function(response)
                {
                    // console.log(response);
                    load_cart_items();
                }
            });
        }
        else{
            return false;
        }
    });

    function load_cart_items() {
        $.ajax({
            url: "<?php echo base_url('shop/scrapsales/scr_sales_temp_items'); ?>",
            success: function(response)
            {
                jQuery('#cart_items').html(response);
            }
        });
    }

    function save_invoice() {
        var quotation_ids = $('input[name="quotation_ids[]"]').map(function(){ 
            return this.value; 
        }).get();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/scrapsales/scrapsales_action'); ?>",
            data: {
                'concern_id':$("#concern_id").val(),
                'customer_id':$("#customer_id").val(),
                'delivery_to':$("#delivery_to").val(),
                'name':$("#name").val(),
                'mobile_no':$("#mobile_no").val(),
                'remarks':$("#remarks").val(),
                'quotation_ids[]':quotation_ids
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
                    if(k == 'success')
                    {
                        window.location.href = "<?php echo base_url('shop/scrapsales/scrapsales_form'); ?>";
                    }
                });
                // console.log(response);
            }
        });
    }
</script>
</body>
</html>