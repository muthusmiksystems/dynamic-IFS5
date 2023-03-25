    <html lang="en" style="background: #fff;">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Quotation ERP </title>
        <link rel="icon" href="<?= base_url('assets/images'); ?>/top_logo.png">

        <!-- Bootstrap core CSS -->
        <!--  Fremwork -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://codeseven.github.io/toastr/build/toastr.min.css">
        <link href="<?= base_url('assets/select'); ?>/select2.css" rel="stylesheet">


        <style>
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>
        <style>
            body {
                background: white;
            }
        </style>
        <style>
            .select2-results__option {
                padding: 12px;

            }

            .table {

                margin-bottom: 3px;
            }

            .table {
                border: thin solid black;
            }

            .table-bordered>thead>tr>th,
            .table-bordered>tbody>tr>th,
            .table-bordered>tfoot>tr>th,
            .table-bordered>thead>tr>td,
            .table-bordered>tbody>tr>td,
            .table-bordered>tfoot>tr>td {
                border: thin solid black;
            }

            .table>tbody>tr>td,
            .table>tbody>tr>th,
            .table>tfoot>tr>td,
            .table>tfoot>tr>th,
            .table>thead>tr>td,
            .table>thead>tr>th {
                padding: 5px;
                line-height: 1.42857143;
                vertical-align: top;

            }

            body {
                line-height: 0px;
            }
        </style>

        <style>
            #country-list {
                float: left;
                list-style: none;
                margin-top: 0;
                padding: 0;
                width: 300px;
                position: absolute;
                overflow-y: auto;
                max-height: 350px;
                z-index: 1;
                display: block;
            }

            #country-list li {
                padding: 5px;
                background: #fff;
                border-bottom: #bbb9b9 1px solid;
                position: relative;
                z-index: 1;
            }

            #country-list li:hover {
                background: #ece3d2;
                cursor: pointer;
            }

            .suggesstion-box {}
        </style>

    </head>

    <body style=" margin: 11px;">


        <?php

        $x = 1;
        $data = $purchase_list = $concern = $vendor = $deliver = $total = array();
        $data[0] = array();
        $submit_btn = " Save";
        $quote_action = '';

        if (!empty(@$this->uri->segment(3))) {

            $quote_id = $this->uri->segment(3);
            $submit_btn = " Edit";
            $quote_action = '/' . $this->uri->segment(3);
            if (@$this->uri->segment(4) == 'duplicate') {
                $quote_id = ($this->uri->segment(3) + 1);
                $submit_btn = " Save";
                $quote_action = '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4);
            }

            $data = $this->user->get_table_data('tbl_quote', null, 'id', $this->uri->segment(3), null);
            if (!empty($data)) {

                $purchase_list = $this->user->get_table_data('tbl_quote_list', null, 'purchase_id', @$data[0]['id'], null);
                $concern = $this->user->get_table_data('bud_concern_master', null, 'concern_id', @$data[0]['branch'], null);

                $vendor = $this->user->get_table_data('bud_customers', null, 'cust_id', @$data[0]['cust_id'], null);
                $deliver = $this->user->get_table_data('bud_customers', null, 'cust_id', @$data[0]['cust_id'], null);

                $total = $this->db->select('count(*) as total')->where('purchase_id', @$data[0]['id'])->get('tbl_quote_list')->result_array();
            }
        }
        extract($data[0]);
        //echo '<pre>'; //print_r($data[0]); //echo '</pre>';
        ?>

        <div class="col-lg-12">
            <form action="<?= base_url('quote/sale_outward'); ?><?= $quote_action; ?>" method="post" id="stock_inward">
                <table class=" table table-bordered order-list">
                    <thead>
                        <tr style="background:orange;font-weight:bolder;color:white">

                            <td align="center" colspan="10">Quotation Master</td>

                        </tr>

                    </thead>
                    <tbody style="background:white;">
                        <tr>
                            <td colspan="2">
                                <select name="branch" style="border:solid thin black" id="branch" class="form-control" tabindex="1">
                                    <option value="">Choose Concern</option>
                                    <?php
                                    $concerndata = $this->user->get_table_data_concern_active('bud_concern_master', null, 'module', $this->session->userdata('user_viewed'), null);
                                    foreach ($concerndata as $row) {
                                    ?>
                                        <option value="<?= $row['concern_id']; ?>" <?= (@$branch == $row['concern_id']) ? 'selected="selected"' : ''; ?>><?= $row['concern_name']; ?></option>

                                    <?php

                                    }
                                    ?>
                                </select>
                            </td>

                            <td colspan="1">
                                <input type="text" style="color:red;font-size:14px;font-weight:bolder;height: 38px" readonly="" id="bill_no" name="bill_no" tabindex="-1" value="<?= @$bill_no; ?>" placeholder="Bill No" class="form-control"="" />
                            </td>
                            <td>
                                <select name="custom_type" style="border:solid thin black" id="c_type" class="form-control" tabindex="2">
                                    <option value="1" <?= (@$cust_type == 1) ? 'selected="selected"' : ''; ?>>Direct Customer</option>
                                    <option value="2" <?= (@$cust_type == 2) ? 'selected="selected"' : ''; ?>>New Customer</option>
                                </select>
                            </td>

                            <td>
                                <select name="cname" style="border:solid thin black" id="vendor" class="form-control" tabindex="2">
                                    <option value="">Choose Customer</option>
                                    <?php if (@$cust_id != "") { ?>
                                        <option value="<?= @$cust_id; ?>" selected="selected"><?= @$cname; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-md" tabindex="-1" data-toggle="modal" data-target="#myModal"><i class="fa fa-users"></i> New Customer </button>
                                <?php
                                $user_viewed = $this->session->userdata('user_viewed');
                                if ($user_viewed == 1) {
                                    //$tbl =  'bud_quote_yarn_item';
                                    $tbl =  'bud_items';
                                } else if ($user_viewed == 2) {
                                    $tbl =  'bud_te_items';
                                } else if ($user_viewed == 3) {
                                    $tbl =  'bud_lbl_items';
                                } else {
                                    $tbl = null;
                                }
                                ?>

                            </td>

                        </tr>

                        <tr>


                            <td colspan="2">
                                <input type="text" id="cash_mode" name="cash_mode" tabindex="-1" value="<?= @$cash_mode; ?>" placeholder="Cash Mode" class="form-control" />
                            </td>
                            <td colspan="2">
                                <input type="text" id="request_by" name="request_by" tabindex="-1" value="<?= @$request_by; ?>" placeholder="Requested By" class="form-control" />
                            </td>

                            <td colspan="2">
                                <input type="date" id="deliver_date" name="deliver_date" tabindex="-1" value="<?= @$deliver_date; ?>" placeholder="Date" class="form-control" />
                            </td>

                        </tr>
                    </tbody>
                </table>
                <div>
                    <table id="myTable" class=" table table-bordered order-list">
                        <thead style="background:yellow;font-weight:bolder;color:blue">
                            <tr>
                                <th align="center">#</th>
                                <td align="center" width="35%">Code/Name</td>
                                <td align="center">HSN Code</td>
                                <td align="center">Tax</td>
                                <td align="center">Rate</td>
                                <td align="center">Qty</td>
                                <td align="center">Amount</td>
                                <td> <i class="fa fa-trash"></i></td>
                            </tr>
                        </thead>
                        <tbody style="background:white;">
                            <?php {
                                $i = 1;
                                $j = 1;
                                $tot_price = 0;
                                if (count($purchase_list) > 0) {
                                    foreach ($purchase_list as $row) {
                            ?>
                                        <tr>
                                            <td><strong><?= $j; ?></strong></td>
                                            <td>
                                                <input type="text" name="name[]" class="form-control" id="textbox<?= $j; ?>" autocomplete="off" name="job" onfocus="load_product(this,<?= $j; ?>)" onkeyup="load_product(this,<?= $j; ?>)" data-value="<?= $j; ?>" data-row="<?= $j; ?>" data-table="<?= $tbl; ?>" data-load="1" data-search="item_name" data-column="item_id as id,item_name as name,item_sample" placeholder="Type Item Name" value="<?= $row['name']; ?>">

                                                <div class="suggesstion-box" id="suggesstion-box<?= $j; ?>"></div>

                                                <input value="<?= $row['id']; ?>" type="hidden" name="id[]" id="id<?= $j; ?>">
                                                <input value="<?= $row['p_id']; ?>" type="hidden" name="p_id[]" id="p_id<?= $j; ?>">
                                                <input value="<?= $row['image']; ?>" type="hidden" name="image[]" id="image<?= $j; ?>">
                                                <input value="<?= $row['umo_i']; ?>" type="hidden" name="umo_id[]" id="umoi<?= $j; ?>">

                                            </td>
                                            <td>
                                                <input value="<?= $row['hsn']; ?>" type="number" name="hsn[]" step="0.01" value="0" tabindex="-1" data-value="<?= $j; ?>" id="hsn<?= $j; ?>" class="form-control" />
                                            </td>
                                            <td>
                                                <input value="<?= $row['tax']; ?>" type="number" name="tax[]" step="0.01" value="0" tabindex="" data-value="<?= $j; ?>" id="tax<?= $j; ?>" class="form-control" />
                                            </td>
                                            <td>
                                                <input value="<?= $row['rate']; ?>" type="number" name="rate[]" step="0.01" value="0" onkeyup="load_amount(this)" tabindex="-1" data-value="<?= $j; ?>" id="rate<?= $j; ?>" class="form-control" />
                                                <input value="<?= $row['umo_n']; ?>" type="text" readonly class="form-control" name="umo_name[]" id="umon<?= $j; ?>">
                                            </td>
                                            <td>
                                                <input value="<?= $row['qty']; ?>" type="number" min="0" step="0" name="qty[]" onkeyup="load_amount(this)" value="0" data-value="<?= $j; ?>" id="qty<?= $j; ?>" class="form-control" />
                                            </td>
                                            <?php $tot_price = $tot_price + ($row['qty'] * $row['rate']); ?>
                                            <td>
                                                <input value="<?= ($row['qty'] * $row['rate']); ?>" type="number" readonly min="0" tabindex="" step="0.01" name="amount[]" data-value="<?= $j; ?>" id="amount<?= $j; ?>" value="0" class="form-control" />
                                            </td>
                                            <td>
                                                <button type="button" tabindex="-1" class="ibtnDel btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                        $j++;
                                    }
                                }
                                $tot = (10 - count($purchase_list));
                                while ($i <= $tot) {
                                    ?>
                                    <tr>
                                        <td><strong><?= $j; ?></strong></td>
                                        <td>
                                            <input type="text" name="name[]" class="form-control" id="textbox<?= $j; ?>" autocomplete="off" name="job" onfocus="load_product(this,<?= $j; ?>)" onkeyup="load_product(this,<?= $j; ?>)" data-value="<?= $j; ?>" data-row="<?= $j; ?>" data-table="<?= $tbl; ?>" data-load="1" data-search="item_name" data-column="item_id as id,item_name as name,item_sample" placeholder="Type Item Name">
                                            <div class="suggesstion-box" id="suggesstion-box<?= $j; ?>"></div>

                                            <input value="" type="hidden" name="id[]" id="id<?= $j; ?>">
                                            <input value="" type="hidden" name="p_id[]" id="p_id<?= $j; ?>">
                                            <input value="" type="hidden" name="image[]" id="image<?= $j; ?>">
                                            <input value="" type="hidden" name="umo_id[]" id="umoi<?= $j; ?>">

                                        </td>
                                        <td>
                                            <input type="number" name="hsn[]" step="0.01" value="0" tabindex="-1" data-value="<?= $j; ?>" id="hsn<?= $j; ?>" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="number" name="tax[]" step="0.01" value="0" tabindex="" data-value="<?= $j; ?>" id="tax<?= $j; ?>" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="number" name="rate[]" step="0.01" value="0" onkeyup="load_amount(this)" tabindex="-1" data-value="<?= $j; ?>" id="rate<?= $j; ?>" class="form-control" />
                                            <input type="text" readonly class="form-control" name="umo_name[]" value="" id="umon<?= $j; ?>">
                                        </td>
                                        <td>
                                            <input type="number" min="0" step="0" name="qty[]" onkeyup="load_amount(this)" value="0" data-value="<?= $j; ?>" id="qty<?= $j; ?>" class="form-control" />
                                        </td>

                                        <td>
                                            <input type="number" readonly min="0" tabindex="" step="0.01" name="amount[]" data-value="<?= $j; ?>" id="amount<?= $j; ?>" value="0" class="form-control" />
                                        </td>
                                        <td>
                                            <button type="button" tabindex="-1" class="ibtnDel btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                            <?php
                                    $j++;
                                    $i++;
                                }
                            }
                            ?>

                        </tbody>
                        <!--
                <tfoot>
                    <tr>
                        <td colspan="10" style="text-align: left;">
                            <button type="button" class="btn btn-md btn-info btn-block addrow " id="addrow" >
                                <i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp; Add Row
                            </button>
                        </td>
                    </tr>
                                <tr>
                    </tr>
                </tfoot>
                --!-->
                    </table>
                </div>
                <table class=" table table-bordered order-list">
                    <thead>
                        <tr style="background:orange;font-weight:bolder;color:white">

                            <td align="center" colspan="6">Remarks</td>

                        </tr>

                    </thead>
                    <tbody style="background:white;">
                        <tr>
                            <td colspan="6">
                                <textarea name="remarks" style="border: none;font-size: 11px;padding:0px;margin: 0;height: 110px;overflow: hidden;" class="form-control"><?= @$remarks; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label> General Terms </label>
                                <textarea name="general" style="border: none;font-size: 11px;padding:0px;margin: 0;height: 110px;overflow: hidden;" class="form-control"><?= (@$general != '') ? @$general : '1) All Subject to TIRUPUR jurisdictions.
2) Please pay by A/C Payee Cheque/Draft Only 
3) Goods Once sold will not be taken back 
4) if Not paid within duw date, interest will be charged @ 14 p.a'; ?></textarea>
                            </td>
                            <td colspan="2">
                                <label> Payment Terms </label>
                                <textarea name="payment" style="border: none;font-size: 11px;padding:0px;margin: 0;height: 110px;overflow: hidden;" class="form-control"><?= (@$payment != '') ? @$payment : '1) All Subject to TIRUPUR jurisdictions.
2) Please pay by A/C Payee Cheque/Draft Only 
3) Goods Once sold will not be taken back 
4) if Not paid within duw date, interest will be charged @ 14 p.a'; ?></textarea>
                            </td>

                            <td colspan="2">
                                <label> Delivery Terms </label>
                                <textarea name="delivery" style="border: none;font-size: 11px;padding:0px;margin: 0;height: 110px;overflow: hidden;" class="form-control"><?= (@$delivery != '') ? @$delivery : '1) All Subject to TIRUPUR jurisdictions.
2) Please pay by A/C Payee Cheque/Draft Only 
3) Goods Once sold will not be taken back 
4) if Not paid within duw date, interest will be charged @ 14 p.a'; ?></textarea>
                            </td>

                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table" style="background:#f2f2f2;border:solid thin #000">
                    <tbody style="background:#f2f2f2;">
                        <tr>

                            <td width="30%" align="right">
                                <br>
                                Total Qty : <input type="number" name="total_qty" min="0" style="color:red;font-weight:bolder;width:180px" readonly id="total_qty" step="any" tabindex="-1" value="<?= @$total_qty; ?>"> <br>
                            </td>
                            <td width="70%" style="padding-left:5%" cellpadding="0" cellspacing="0">
                                <table width="100%">
                                    <tr>
                                        <td width="35%">
                                            <h1 style="font-size:45px;color:red" id="total_amount"><?= @$tot_price; ?></h1>
                                        </td>

                                    </tr>
                                </table>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                <i class="fa fa-inr"></i> &nbsp; <span style="text-transform: uppercase;font-weight:bolder;font-size:22px;color:blue" id="textAmount">zero rupees only /-</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <a href="<?= base_url(); ?>" class="btn btn-info"> <i class="fa fa-home"></i> Home </a>
                            </td>
                            <td align="right">

                                <button type="submit" id="btn_hide" class="btn btn-success btn-md"> <i class="fa fa-plus"></i> <?= $submit_btn; ?></button>
                            </td>
                        </tr>

                    </tbody>

                </table>
                </i>
                </td>
            </form>
        </div>


    </body>

    </html>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Customer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <form id="add_user" method="post" action="#">

                        <div class="row">

                            <div class="form-group form-float col-md-12">
                                <div class="form-line">

                                    <input type="text" class="form-control" style="border:solid thin black;height:38px" name="cname" placeholder="Name">
                                </div>
                            </div>


                            <div class="form-group form-float col-md-12">
                                <div class="form-line">

                                    <input type="email" class="form-control" name="email" style="border:solid thin black;height:38px" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group form-float col-md-12">
                                <div class="form-line">

                                    <input type="text" class="form-control" style="border:solid thin black;height:38px" maxlength="10" class="form-control" maxlength="10" name="phn_no" placeholder="Phone No">
                                </div>
                            </div>

                        </div>
                        <div class="row">


                            <div class="form-group form-float col-md-12">
                                <div class="form-line">

                                    <input type="text" class="form-control" style="border:solid thin black;height:38px" name="gst_no" placeholder="GST No" style="height:38px">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group form-float col-md-12">
                                <div class="form-line">

                                    <textarea name="caddress" style="border:solid thin black;height:100px" cols="30" rows="5" class="form-control no-resize" style="resize: vertical;" placeholder="Address"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group form-float col-md-12">
                                <div class="form-line">
                                    <button class="btn btn-success btn-lg waves-effect pull-right" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>

            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="<?= base_url('assets/select'); ?>/select2.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://codeseven.github.io/toastr/build/toastr.min.js"></script>
    <script>
        function sugHide() {
            $(".suggesstion-box").hide();
        }

        function selectValue(Obj) {
            var id = Obj.id;
            var value = $(Obj).attr('data-value');
            var id = $(Obj).attr('data-id');
            var d_val = $(Obj).attr('data-row');


            $("#textbox" + d_val).val(value);
            $(".suggesstion-box").hide();


            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('quote/load_item_detail'); ?>',
                data: 'id=' + id,
                success: function(response) {
                    if (response == 0) {

                    } else {
                        var data = response.split("&&");
                        $("#rate" + d_val).val(data[1]);
                        $("#p_id" + d_val).val(data[0]);
                        $("#hsn" + d_val).val(data[2]);
                        $("#image" + d_val).val(data[3]);
                        $("#tax" + d_val).val(data[4]);
                        $("#umoi" + d_val).val(data[5]);
                        $("#umon" + d_val).val(data[6]);
                    }
                }
            });

        }

        function load_product(Obj, key) {
            var id = Obj.id;
            var value = $("#" + id).attr('data-value');
            var text = $("#" + id).val();
            var tbl = $("#" + id).attr('data-table');
            var column = $("#" + id).attr('data-column');
            var load = $("#" + id).attr('data-load');
            var row = $("#" + id).attr('data-row');
            var search = $("#" + id).attr('data-search');
            var salary = $("#emp_type").val();
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>quote/load_result",
                data: 'keyword=' + text + '&&value=' + value + '&&table=' + tbl + '&&column=' + column + '&&row=' + row + '&&search=' + search + '&&load=' + load + '&&salary=' + salary,
                beforeSend: function() {
                    $("#textbox" + key).css("background", "#FFF url(<?= base_url('theme/images/LoaderIcon.gif'); ?>) no-repeat 165px");
                },
                success: function(data) {
                    $("#suggesstion-box" + key).show();
                    $("#suggesstion-box" + key).html(data);
                    $("#textbox" + key).css("background", "#FFF");
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('select').select2();
            $('#addrow').trigger('click');
            $('#addrow').click();
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "rtl": false,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            load_cust();
            $("#c_type").change(function() {
                load_cust();
            });
            /*
                $("#stock_inward").submit(function(e){
                      $("#btn_hide").attr('disabled','true');
                      var data = $(this).serialize();
                      $.ajax({
                        type: 'POST',
                        url: '<?= base_url('quote/sale_outward'); ?>',
                        data:data,
                        success: function(response){
                             toastr.success('Inward Succssfully...!!!!');
                             //location.assign("<?= base_url('quote'); ?>");
                                              location.assign("<?= base_url('quote/print_quote'); ?>/"+response);
                          }
                    }); 
                      e.preventDefault();
                });
            */
            setInterval('updateClock()', 1000);

            $("#branch").focus();
            $("#branch").change(function() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('quote/find_dc'); ?>',
                    data: 'id=' + $(this).val(),
                    success: function(response) {
                        $('#bill_no').val(response);
                    }
                });
            });
            $("#cname").change(function() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('sales/find_address'); ?>',
                    data: 'id=' + $(this).val(),
                    success: function(response) {
                        $('#caddress').html(response);
                    }
                });
            });

            var counter = 11;
            var count = 20000;
            $("#rec_amt").keyup(function() {
                var val = $("#total_amount").html();
                val = Math.round(val);
                var bal = parseFloat($(this).val()) - parseFloat(val);
                $("#bal_amount").val(bal.toFixed(2));

            });
            $("#total_dis").keyup(function() {
                var amount = 0;
                var values = $('input[name="amount[]"]').map(function() {
                    amount = parseFloat(amount) + parseFloat(this.value);
                }).get();

                var round = Math.round(amount);


                var val = round;


                var dis = parseFloat($(this).val()) / parseFloat(100);

                var bal = parseFloat(dis) * parseFloat(val);

                $("#dis_amt").val(bal.toFixed(2));

                var amt = parseFloat(val) - parseFloat(bal);
                var round = Math.round(amt);
                $("#total_amount").html(round.toFixed(2));


                var diff = parseFloat(round) - parseFloat(amt);
                $("#round_val").val(diff.toFixed(2));

                var text = toWords(round) + ' Rupees Only /-';


                $("#textAmount").html(text);
            });
            $(".radio_click").click(function() {
                var amount = 0;
                var values = $('input[name="amount[]"]').map(function() {
                    amount = parseFloat(amount) + parseFloat(this.value);
                }).get();

                var round = Math.round(amount);

                var val = round;
                var dis = parseFloat($("#total_dis").val()) / parseFloat(100);

                var bal = parseFloat(dis) * parseFloat(val);


                var amt = parseFloat(val) - parseFloat(bal);
                var round = Math.round(amt);
                var text = toWords(round) + ' Rupees Only /-';

                var val = round;

                $("#total_amount").html(round.toFixed(2));
                $("#textAmount").html(text);

                if ($(this).val() != 0) {
                    var dis = parseFloat(5) / parseFloat(100);

                    var bal = parseFloat(val) * parseFloat(0.05);

                    $("#total_tax").val(bal.toFixed(2));

                    var amt = parseFloat(val) + parseFloat(bal);
                    var round = Math.round(amt);
                    $("#total_amount").html(round.toFixed(2));


                    var diff = parseFloat(round) - parseFloat(amt);
                    $("#round_val").val(diff.toFixed(2));

                    var text = toWords(round) + ' Rupees Only /-';


                    $("#textAmount").html(text);
                }
            });
            $("#add_user").submit(function(e) {

                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('quote/add_cust'); ?>',
                    data: data,
                    success: function(response) {
                        toastr.success("Insert Succeessfully...");
                        load_cust();
                        $('#myModal').modal('hide');
                    }
                });
                $(this).closest('form').find("input[type=text],input[type=number], textarea").val("");
                e.preventDefault();
            });
            $("#add_address").submit(function(e) {

                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('sales/add_cust_add'); ?>',
                    data: data,
                    success: function(response) {
                        toastr.success("Insert Succeessfully...");
                        load_cust();
                        $('#myModalAdd').modal('hide');
                    }
                });
                $(this).closest('form').find("input[type=text],input[type=number], textarea").val("");
                e.preventDefault();
            });

            $(".addrow").on("click", function() {
                var i = 1;
                while (i < 10) {

                    var newRow = $("<tr>");
                    var cols = "";

                    cols += '<td><strong></strong></td><td><input type="hidden" name="id[]" value="" id="id' + counter + '"><input type="hidden" name="p_id[]" value="" id="p_id' + counter + '"><input type="hidden" name="image[]" value="" id="image' + counter + '"><input type="text" class="form-control box" onblur="load_detail(this)" id="box' + counter + '" data-value="' + counter + '" name="name[]"/></td>';
                    cols += '<td><input type="number" class="form-control" value="0"  tabindex="-1" name="hsn[]" id="hsn' + counter + '" data-value="' + counter + '" /></td>';
                    cols += '<td><input type="number" class="form-control" value="0"  tabindex="-1" name="tax[]" id="tax' + counter + '" data-value="' + counter + '" /></td>';
                    cols += '<td><input type="number" class="form-control" value="0" onkeyup="load_amount(this)" tabindex="-1" name="rate[]" id="rate' + counter + '" data-value="' + counter + '" /></td>';
                    cols += '<td><input type="number" class="form-control" value="0" onkeyup="load_amount(this)" name="qty[]" id="qty' + counter + '" data-value="' + counter + '"/></td>';

                    cols += '<td><input type="number" class="form-control" tabindex="-1" value="0" readonly onkeyup="load_amount(this)" name="amount[]" id="amount' + counter + '" data-value="' + counter + '"/></td>';

                    cols += '<td> <button type="button" class="ibtnDel btn btn-sm btn-danger "><i class="fa fa-trash"></i></button></td>';
                    newRow.append(cols);
                    $("#myTable.order-list").append(newRow);
                    $("#box" + counter).autocomplete({
                        source: availableTags
                    });
                    $("#box" + counter).focus();
                    counter++;
                    var renum = 1;
                    $("#myTable tr td strong").each(function() {
                        $(this).text(renum);
                        renum++;
                    });
                    i++;
                }

            });





            $("table.order-list").on("click", ".ibtnDel", function(event) {
                $(this).closest("tr").remove();
                var renum = 1;
                $("#myTable tr td strong").each(function() {
                    $(this).text(renum);
                    renum++;
                });
                //counter -= 1
            });
        });

        function load_cust() {
            if ($("#c_type").val() == 1) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('quote/load_cust'); ?>',

                    success: function(response) {
                        //$("#cname").html(response);
                        <?php if (@$cname != "") { ?>
                            response = response + '<option value = "<?= @$cust_id; ?>" selected = "selected" > <?= @$cname; ?></option>';
                        <?php } ?>
                        $("#vendor").html(response);
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('quote/load_cust2'); ?>',

                    success: function(response) {
                        //$("#cname").html(response);
                        <?php if (@$cname != "") { ?>
                            response = response + '<option value = "<?= @$cust_id; ?>" selected = "selected" > <?= @$cname; ?></option>';
                        <?php } ?>
                        $("#vendor").html(response);
                    }
                });
            }

        }

        function load_detail(Obj) {
            var id = Obj.id;
            var val = $("#" + id).val();
            var d_val = $("#" + id).attr('data-value');
            //toastr.success(d_val);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('quote/load_item_detail'); ?>',
                data: 'id=' + val,
                success: function(response) {
                    if (response == 0) {
                        //toastr.error("Stock Not Availble");
                        //$("#"+id).val('');
                    } else {
                        var data = response.split("&&");
                        $("#rate" + d_val).val(data[1]);
                        $("#p_id" + d_val).val(data[0]);
                        $("#hsn" + d_val).val(data[2]);
                        $("#tax" + d_val).val(data[3]);
                        $("#image" + d_val).val(data[4]);
                    }
                }
            });

        }

        function load_amount(Obj) {
            var id = Obj.id;

            var data_val = $("#" + id).attr('data-value');
            var val = $("#rate" + data_val).val();

            var tax = $("#tax" + data_val).val();
            var dis = $("#dis" + data_val).val();
            var qty = $("#qty" + data_val).val();

            var total_price = parseFloat(val) * parseFloat(qty);

            $("#amount" + data_val).val(total_price.toFixed(2));

            var qty = 0;
            var values = $('input[name="qty[]"]').map(function() {
                qty = parseFloat(qty) + parseFloat(this.value);
            }).get();
            $("#total_qty").val(qty);

            var amount = 0;
            var values = $('input[name="amount[]"]').map(function() {
                amount = parseFloat(amount) + parseFloat(this.value);
            }).get();

            var round = Math.round(amount);
            var diff = parseFloat(round) - parseFloat(amount);
            $("#round_val").val(diff.toFixed(2));
            $("#total_amount").html(round.toFixed(2));


            var text = toWords(round) + ' Rupees Only /-';


            $("#textAmount").html(text);


        }

        function updateClock() {
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output =
                (('' + day).length < 2 ? '0' : '') + day + '-' +
                (('' + month).length < 2 ? '0' : '') + month + '-' +
                d.getFullYear();



            var currentTime = new Date();
            var currentHours = currentTime.getHours();
            var currentMinutes = currentTime.getMinutes();
            var currentSeconds = currentTime.getSeconds();

            // Pad the minutes and seconds with leading zeros, if 
            currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
            currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

            // Choose either "AM" or "PM" as appropriate
            var timeOfDay = (currentHours < 12) ? "AM" : "PM";

            // Convert the hours component to 12-hour format if needed
            currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;

            // Convert an hours component of "0" to "12"
            currentHours = (currentHours == 0) ? 12 : currentHours;

            // Compose the string for display
            var currentTimeString = output + " - " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;


            $("#clock").html(currentTimeString);
        }
    </script>
    <script>
        function calculateRow(row) {
            var price = +row.find('input[name^="price"]').val();

        }

        function calculateGrandTotal() {
            var grandTotal = 0;
            $("table.order-list").find('input[name^="price"]').each(function() {
                grandTotal += +$(this).val();
            });
            $("#grandtotal").text(grandTotal.toFixed(2));
        }
    </script>

    <script>
        // American Numbering System
        var th = ['', 'thousand', 'million', 'billion', 'trillion'];
        // uncomment this line for English Number System
        // var th = ['','thousand','million', 'milliard','billion'];

        var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
        var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        function toWords(s) {
            s = s.toString();
            s = s.replace(/[\, ]/g, '');
            if (s != parseFloat(s)) return 'not a number';
            var x = s.indexOf('.');
            if (x == -1) x = s.length;
            if (x > 15) return 'too big';
            var n = s.split('');
            var str = '';
            var sk = 0;
            for (var i = 0; i < x; i++) {
                if ((x - i) % 3 == 2) {
                    if (n[i] == '1') {
                        str += tn[Number(n[i + 1])] + ' ';
                        i++;
                        sk = 1;
                    } else if (n[i] != 0) {
                        str += tw[n[i] - 2] + ' ';
                        sk = 1;
                    }
                } else if (n[i] != 0) {
                    str += dg[n[i]] + ' ';
                    if ((x - i) % 3 == 0) str += 'hundred ';
                    sk = 1;
                }
                if ((x - i) % 3 == 1) {
                    if (sk) str += th[(x - i - 1) / 3] + ' ';
                    sk = 0;
                }
            }
            if (x != s.length) {
                var y = s.length;
                str += 'point ';
                for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
            }
            return str.replace(/\s+/g, ' ');
        }
    </script>
    <script>
        /* Get into full screen */
        function GoInFullscreen(element) {
            if (element.requestFullscreen)
                element.requestFullscreen();
            else if (element.mozRequestFullScreen)
                element.mozRequestFullScreen();
            else if (element.webkitRequestFullscreen)
                element.webkitRequestFullscreen();
            else if (element.msRequestFullscreen)
                element.msRequestFullscreen();
        }

        /* Get out of full screen */
        function GoOutFullscreen() {
            if (document.exitFullscreen)
                document.exitFullscreen();
            else if (document.mozCancelFullScreen)
                document.mozCancelFullScreen();
            else if (document.webkitExitFullscreen)
                document.webkitExitFullscreen();
            else if (document.msExitFullscreen)
                document.msExitFullscreen();
        }

        /* Is currently in full screen or not */
        function IsFullScreenCurrently() {
            var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;

            // If no element is in full-screen
            if (full_screen_element === null)
                return false;
            else
                return true;
        }

        $("#go-button").on('click', function() {
            if (IsFullScreenCurrently())
                GoOutFullscreen();
            else
                GoInFullscreen($("#element").get(0));
        });

        $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
            if (IsFullScreenCurrently()) {
                $("#element span").text('Full Screen Mode Enabled');
                $("#go-button").text('Disable Full Screen');
            } else {
                $("#element span").text('Full Screen Mode Disabled');
                $("#go-button").text('Enable Full Screen');
            }
        });
    </script>