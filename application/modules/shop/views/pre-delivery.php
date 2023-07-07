<?php include APPPATH.'views/html/header.php'; ?>
    <?php
    $dc_active = false;
    $cash_inv_active = false;
    $credit_inv_active = false;
    $quote_active = false;
    $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
    $shop_active = $this->m_users->is_privileged('shop', 'upriv_controller', $logged_user_id);

    $is_privileged = $this->m_users->is_privileged('delivery', 'upriv_function', $this->session->userdata('user_id'));
    if($is_admin || ($shop_active && $is_privileged))
    {
        $dc_active = true;
    }

    $is_privileged = $this->m_users->is_privileged('cash_invoice', 'upriv_function', $this->session->userdata('user_id'));
    if($is_admin || ($shop_active && $is_privileged))
    {
        $cash_inv_active = true;
    }

    $is_privileged = $this->m_users->is_privileged('credit_invoice', 'upriv_function', $this->session->userdata('user_id'));
    if($is_admin || ($shop_active && $is_privileged))
    {
        $credit_inv_active = true;
    }

    $is_privileged = $this->m_users->is_privileged('quotation', 'upriv_function', $this->session->userdata('user_id'));
    if($is_admin || ($shop_active && $is_privileged))
    {
        $quote_active = true;
    }
    ?>
	<section id="main-content">
		<section class="wrapper sh_delivery">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Shop Pre Delivery
                            <label class="label label-danger" style="font-size:14px;">SPDC - <span id="pre_dc_no"><?php echo $pre_dc_no; ?></span></label>
                        </header>
                        <div class="panel-body">
                            <div id="formResponse"></div>

                            <form action="<?php echo base_url('shop/predelivery/add_predc_row'); ?>" id="barcodeSearch" method="post">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="dc_no" class="control-label">Read Barcode</label>
                                        <div class="input-group input-group-sm">
                                            <input name="barcode_no" id="barcode_no" onmouseover="this.focus();" class="form-control input-sm" type="text">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary" name="search" value="search">Search</button>                                        
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/predelivery/packing_list_search'); ?>">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label class="text-large">From</label>
                                        <input class="dateplugin form-control" id="from_date" value="<?php echo $from_date; ?>" name="from_date" type="text" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="text-large">To</label>
                                        <input class="dateplugin form-control" id="from_date" value="<?php echo $to_date; ?>" name="from_date" type="text" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="text-large">Item Group</label>
                                        <select class="select2 form-control" name="item_group_id" id="item_group_id">
                                            <option value="">Select</option>
                                            <?php if(sizeof($item_groups) > 0): ?>
                                                <?php foreach($item_groups as $row): ?>
                                                    <option value="<?php echo $row->group_id; ?>"><?php echo $row->group_name; ?>/<?php echo $row->group_id; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="text-large">Item Name</label>
                                        <select class="select2 item-select form-control" id="item_id" name="item_id">
                                            <option value="">Select</option>
                                            <?php if(sizeof($items) > 0): ?>
                                                <?php foreach($items as $row): ?>
                                                    <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="text-large">Item Code</label>
                                        <select class="select2 item-select form-control" id="item_code">
                                            <option value="">Select</option>
                                            <?php if(sizeof($items) > 0): ?>
                                                <?php foreach($items as $row): ?>
                                                    <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_id; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="text-large">Shade Name/Code</label>
                                        <select class="select2 shade-select form-control" name="shade_id" id="shade_id">
                                            <option value="">Select</option>
                                            <?php if(sizeof($shades) > 0): ?>
                                                <?php foreach($shades as $row): ?>
                                                    <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_name; ?>/<?php echo $row->shade_id; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="text-large">Shade No</label>
                                        <select class="select2 shade-select form-control" id="shade_code">
                                            <option value="">Select</option>
                                            <?php if(sizeof($shades) > 0): ?>
                                                <?php foreach($shades as $row): ?>
                                                    <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_code; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="text-large">Concern</label>
                                        <select class="select2 form-control" name="concern_id" id="concern_id">
                                            <option value="">Select</option>
                                            <?php if(sizeof($concerns) > 0): ?>
                                                <?php foreach($concerns as $row): ?>
                                                    <option value="<?php echo $row->concern_id; ?>"><?php echo $row->concern_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="text-large">Stock Room</label>
                                        <select class="select2 form-control" name="stock_room_id" id="stock_room_id">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-danger" type="submit" name="search" value="search">Search</button>
                                    </div>
                                </div>
                            </form>

                            <?php
                            
                            ?>

                            <div id="packing-list">
                                
                            </div>
                            
                            <input type="hidden" id="selected_boxes">

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-danger" onclick="addToCart()">Add to List</button>
                                </div>
                            </div>

                            <hr>

                            <h4>Selected Boxes</h4>
                            <div id="formResponse-2"></div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Concern Name</label>
                                    <select class="select2 form-control" id="p_concern_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($concerns) > 0): ?>
                                            <?php foreach($concerns as $row): ?>
                                                <option value="<?php echo $row->concern_id; ?>" <?php echo ($row->concern_id == $p_concern_id)?'selected="selected"':''; ?>><?php echo $row->concern_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Party Name</label>
                                    <select class="select2 form-control" id="p_customer_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>" <?php echo ($row->cust_id == $p_customer_id)?'selected="selected"':''; ?>><?php echo $row->cust_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Delivery Address</label>
                                    <select class="select2 form-control" id="p_delivery_to">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>" <?php echo ($row->cust_id == $p_delivery_to)?'selected="selected"':''; ?>><?php echo $row->cust_name; ?></option>
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


                            <div id="cart_items">
                                
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Remarks</label>
                                    <textarea class="form-control" id="remarks"><?php echo $remarks; ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="save_predc()" class="btn-submit btn btn-danger">SAVE AS SPDC</button>
                                    
                                    <?php if($dc_active): ?>
                                        <button type="button" onclick="save_delivery()" class="btn-submit btn btn-danger">SAVE AS SDC</button>
                                    <?php endif; ?>

                                    <?php if($cash_inv_active): ?>
                                        <button type="button" onclick="save_cash_invoice()" class="btn-submit btn btn-danger">SAVE AS CASH INVOICE</button>
                                    <?php endif; ?>

                                    <?php if($credit_inv_active): ?>
                                        <button type="button" onclick="save_credit_invoice()" class="btn-submit btn btn-danger">SAVE AS CREDIT INVOICE</button>
                                    <?php endif; ?>
                                    
                                    <?php if($quote_active): ?>
                                        <button type="button" onclick="save_quotation()" class="btn-submit btn btn-danger">GIVE ENQUIRY ONLY</button>
                                    <?php endif; ?>
                                    
                                    <p class="text-danger">
                                        <strong>(DC And Credit Invoice)</strong><br>
                                        In credit invoice if total outstanding amount(Old Pending + This Credit Invoice Amount) is more than the credit limit (than give a popup window : Attenstion username this customer name invoice can't be generate becouse it will exceed the credit limit alloted by the management, Please collect the old payment to make this Invoice possible.
                                        Thanks Mahesh Bhardwaj)
                                    </p>

                                    <p class="text-danger">
                                        <strong>(Cash Invoice , Cash Receipt)</strong><br>
                                        These entries will go to another table called pending cash delivery. All the cash invoice and cash receipt shown in the uner table with the button select all transfer the selected invoices print one cash invoice delivery voucher will be generated.
                                    </p>
                                </div>
                            </div>

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
                    <h4 class="modal-title">Update Stock Room</h4>
                </div>
                
                <div class="modal-body" style="height:500px; overflow:auto;">
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    load_packing_list();
    load_cart_items();
    get_next_pdc_no();

    $(".item-select").change(function(){
        $("#item_id").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());
        return false;
    });
    $(".shade-select").change(function(){
        $("#shade_id").select2("val", $(this).val());
        $("#shade_code").select2("val", $(this).val());
        return false;
    });


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
                jQuery('#packing-list').html(response);
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
                    },
                    "aoColumnDefs": [
                        {
                          "bSortable": false, 
                          "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                        },
                        { 
                            "sWidth": "300",
                            "aTargets": [  13 ] 
                        },
                    ],
                    "aaSorting": [
                        [index, "desc"]
                    ]
                });
                jQuery('.dataTables_filter input').addClass("form-control");
                jQuery('.dataTables_length select').addClass("form-control");
            }
        });

        e.preventDefault();
    });

    var oTable01 = '';
    function load_packing_list() {
        $.ajax({
            url: "<?php echo base_url('shop/predelivery/packing_list_data'); ?>",
            dataType:"html",
            success: function(response)
            {
                jQuery('#packing-list').html(response);
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
                    },
                    "aoColumnDefs": [
                        {
                          "bSortable": false, 
                          "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                        },
                        { 
                            "sWidth": "300",
                            "aTargets": [  13 ] 
                        },
                    ],
                    "aaSorting": [
                        [index, "desc"]
                    ]
                });
                jQuery('.dataTables_filter input').addClass("form-control");
                jQuery('.dataTables_length select').addClass("form-control");
            }
        });
    }

    $("#concern_id").change(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/packing/get_stock_rooms'); ?>",
            data: {'concern_id':$(this).val()},
            success: function(response)
            {
                // console.log(response);
                var response = $.parseJSON(response);
                $("#stock_room_id").html('');
                $("#stock_room_id").select2('destroy');
                $("#stock_room_id").html(response.stock_rooms);
                $("#stock_room_id").select2();
            }
        });
    });

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
            cart_boxes++;
            cart_gr_wt += parseFloat($(elem).closest('tr').find('td.box-gr-wt').text());
            cart_nt_wt += parseFloat($(elem).closest('tr').find('td.box-nt-wt').text());
        });
        $("#selected_boxes").val(matches);
        $(".cart-boxes").text(cart_boxes);
        $(".cart-gr-wt").text(cart_gr_wt.toFixed(3));
        $(".cart-nt-wt").text(cart_nt_wt.toFixed(3));
        // alert(matches);
    });

    function addToCart() {
        var selected_boxes = $("#selected_boxes").val();
       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/predelivery/add_to_cart'); ?>",
            data: {'selected_boxes':selected_boxes},
            failure: function(errMsg) {
                console.error("error:",errMsg);
            },
            success: function(response)
            {
                
                load_cart_items();
                load_packing_list();
            }
        });
    }

    function load_cart_items() {
        $.ajax({
            url: "<?php echo base_url('shop/predelivery/cart_temp_items/'.$p_delivery_id); ?>",
            dataType:"html",
            success: function(response)
            {
                jQuery('#cart_items').html(response);
            }
        });
    }

    $(document).on('click', ".remove-cart-item", function(e){
        var row_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('shop/predelivery/remove_to_cart'); ?>",
                data: {'row_id':row_id},
                failure: function(errMsg) {
                    console.error("error:",errMsg);
                },
                success: function(response)
                {
                    load_cart_items();
                    load_packing_list();
                }
            });
        }
        else{
            return false;
        }
    });

    $(document).on('click', 'button.remove-pdc-item', function () {
        if(confirm("Are you sure you want to delete this?")){
            $(this).closest('tr').remove();
        }
        else
        {
            return false;  
        }
    });

    function update_cart_item(qty_input, row_id, nt_weight) {
        var delivery_qty = $(qty_input).val();
        /*if(delivery_qty <= nt_weight)
        {*/
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('shop/predelivery/update_cart_item'); ?>",
                data: {'row_id':row_id,'delivery_qty':delivery_qty},
                failure: function(errMsg) {
                    console.error("error:",errMsg);
                },
                success: function(response)
                {
                    load_cart_items();
                    load_packing_list();
                }
            });
        /*}
        else
        {
            alert("Deliver qty do not exceed the netweight");
            $(qty_input).val('0');
        }*/
    }

    function save_predc() {
        $('.btn-submit').attr('disabled', true);
        var predc_items = $('input[name="predc_items[]"]').map(function(){ 
            return this.value; 
        }).get();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/predelivery/save_predelivery/'.$p_delivery_id); ?>",
            data: {
                'p_concern_id':$("#p_concern_id").val(),
                'p_customer_id':$("#p_customer_id").val(),
                'p_delivery_to':$("#p_delivery_to").val(),
                'name':$("#name").val(),
                'mobile_no':$("#mobile_no").val(),
                'remarks':$("#remarks").val(),
                'predc_items[]':predc_items
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
                    if(k == 'p_delivery_id')
                    {
                        // window.open("<?php echo base_url('shop/predelivery/print_predelivery'); ?>/"+v);
                        window.location.href = "<?php echo base_url('shop/predelivery/print_predelivery'); ?>/"+v;
                        load_cart_items();
                        load_packing_list();
                        get_next_pdc_no();
                    }
                });

                $('.btn-submit').attr('disabled', false);
                // console.log(response);
            }
        });
        // window.open("<?php echo base_url('shop/predelivery/print_predelivery'); ?>");
        // alert("hi");
        // return false;
    }
    function save_delivery() {
        $('.btn-submit').attr('disabled', true);
        var predc_items = $('input[name="predc_items[]"]').map(function(){ 
            return this.value; 
        }).get();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/delivery/save_delivery/'.$p_delivery_id); ?>",
            data: {
                'p_concern_id':$("#p_concern_id").val(),
                'p_customer_id':$("#p_customer_id").val(),
                'p_delivery_to':$("#p_delivery_to").val(),
                'name':$("#name").val(),
                'mobile_no':$("#mobile_no").val(),
                'remarks':$("#remarks").val(),
                'predc_items[]':predc_items
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
                    if(k == 'delivery_id')
                    {
                        // window.open("<?php echo base_url('shop/delivery/print_delivery'); ?>/"+v);
                        window.location.href = "<?php echo base_url('shop/delivery/print_delivery'); ?>/"+v;
                        load_cart_items();
                        load_packing_list();
                        get_next_pdc_no();
                    }
                });

                $('.btn-submit').attr('disabled', false);
                // console.log(response);
            }
        });
    }

    function save_cash_invoice() {
        $('.btn-submit').attr('disabled', true);
        var predc_items = $('input[name="predc_items[]"]').map(function(){ 
            return this.value; 
        }).get();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/sales/cash_invoice_action/'.$p_delivery_id); ?>",
            data: {
                'p_concern_id':$("#p_concern_id").val(),
                'p_customer_id':$("#p_customer_id").val(),
                'p_delivery_to':$("#p_delivery_to").val(),
                'name':$("#name").val(),
                'mobile_no':$("#mobile_no").val(),
                'remarks':$("#remarks").val(),
                'predc_items[]':predc_items
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
                        window.location.href = "<?php echo base_url('shop/sales/cash_invoice_form/'.$p_delivery_id); ?>";
                    }
                });

                $('.btn-submit').attr('disabled', false);
            }
        });
    }

    function save_credit_invoice() {
        $('.btn-submit').attr('disabled', true);
        var predc_items = $('input[name="predc_items[]"]').map(function(){ 
            return this.value; 
        }).get();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/sales/credit_invoice_action/'.$p_delivery_id); ?>",
            data: {
                'p_concern_id':$("#p_concern_id").val(),
                'p_customer_id':$("#p_customer_id").val(),
                'p_delivery_to':$("#p_delivery_to").val(),
                'name':$("#name").val(),
                'mobile_no':$("#mobile_no").val(),
                'remarks':$("#remarks").val(),
                'predc_items[]':predc_items
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
                        window.location.href = "<?php echo base_url('shop/sales/credit_invoice_form/'.$p_delivery_id); ?>";
                    }
                });

                $('.btn-submit').attr('disabled', false);
            }
        });
    }

    function save_quotation() {
        $('.btn-submit').attr('disabled', true);
        var predc_items = $('input[name="predc_items[]"]').map(function(){ 
            return this.value; 
        }).get();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/sales/quotation_action/'.$p_delivery_id); ?>",
            data: {
                'p_concern_id':$("#p_concern_id").val(),
                'p_customer_id':$("#p_customer_id").val(),
                'p_delivery_to':$("#p_delivery_to").val(),
                'name':$("#name").val(),
                'mobile_no':$("#mobile_no").val(),
                'remarks':$("#remarks").val(),
                'predc_items[]':predc_items
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
                        window.location.href = "<?php echo base_url('shop/sales/quotation_form/'.$p_delivery_id); ?>";
                    }
                });

                $('.btn-submit').attr('disabled', false);
            }
        });
    }

    $(document).bind('keydown', '', function(e) {
        // e.preventDefault();
        if ( e.ctrlKey && e.altKey && e.keyCode == 83) {
            alert("hi");
        }
    });

    $("#p_customer_id").change(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/predelivery/get_costomer'); ?>",
            data: {
                'p_customer_id':$("#p_customer_id").val()
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

    function get_next_pdc_no() {
        $.ajax({
            url: "<?php echo base_url('shop/predelivery/get_next_pdc_no/'.$p_delivery_id); ?>",
            success: function(response)
            {
                $("#pre_dc_no").html(response);
            }
        });
    }

    function showAjaxModal(url)
    {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url('themes/admin/img/preloader.gif') ?>" /></div>');
        
        // LOADING THE AJAX MODAL
        jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
        
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response)
            {
                jQuery('#modal_ajax .modal-body').html(response);
                
                $("#edit_stock_room_id").select2();
            }
        });
    }

    function cartRemoveAll() {
        if(confirm("Are you sure you want to delete all items?")){
            $.ajax({
                url: "<?php echo base_url('shop/predelivery/remove_all_item'); ?>",
                success: function(response)
                {
                    load_cart_items();
                    load_packing_list();
                }
            });
        }
        else
        {
            return false;  
        }
    }

    $('#barcodeSearch').on('submit', function(event){
        event.preventDefault();

        var formData = $('#barcodeSearch').serializeArray();
        // formData.push({name: 'order_id', value: order_id});
        // alert(formData);
        // console.log(formData);
        $.post($(this).attr('action'), formData, function(data){
            // console.log(data);
            $("#barcode_no").val('');
            load_cart_items();
            load_packing_list();
        });
    });


    /*$.ajax({
       type: "POST",
       url: 'names/update',
       data: {'data' : updateArray },
       failure: function(errMsg) {
        console.error("error:",errMsg);
       },
       success:function(data){
        //do something
       }
    });*/
</script>
</body>
</html>