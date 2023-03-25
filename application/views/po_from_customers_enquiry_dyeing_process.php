<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title><?= $page_title; ?> | INDOFILA SYNTHETICS</title>

    <!-- Bootstrap core CSS -->
    <?php
    foreach ($css as $path) {
    ?>
        <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
    <?php
    }
    ?>

    <style>
        .dt-checkboxes-select-all input {
            display: none;
        }

        .parent-row td,
        .danger-cust {
            color: red;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <section id="container" class="">
        <!--header start-->
        <?php $this->load->view('html/v_header.php'); ?>
        <!--header end-->
        <!--sidebar start-->
        <?php $this->load->view('html/v_sidebar.php'); ?>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <h3><i class="icon-truck"></i> <?= $page_heading; ?></h3>
                            </header>
                        </section>
                    </div>
                </div>

                <?php $this->load->view('po_from_customers_filter.php'); ?>

                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        // echo '<pre>';
                        // print_r($table);
                        // echo '</pre>';
                        ?>
                        <section class="panel">
                            <header class="panel-heading">
                                <?= $page_heading; ?>
                            </header>
                            <script>
                                var data = [];
                                var dataChild = [];
                            </script>

                            <table class="table table-striped border-top display select" id="sample_1x">
                                <thead>
                                    <tr>
                                        <th>Flag</th>
                                        <th>Sno</th>
                                        <th>GPO No</th>
                                        <th>GPO Plan Date</th>
                                        <th>Select Product</th>
                                        <th>Item name</th>
                                        <th>Colour Name / Code / No</th>
                                        <th>GPO Plan Qty.</th>
                                        <th>GPO Bal Qty.</th>
                                        <th>GPO T.Prod. Qty.</th>
                                        <th>Remarks</th>
                                        <th>Accepted By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php

                                //$machines
                                $mc_arr = array();
                                foreach ($machines as $key => $value) {
                                    $mc_arr[$value['machine_id']] = $value['machine_name'];
                                }

                                $data1 = $this->m_masters->get_items_array('bud_items');

                                $data2 = $this->m_masters->getallmaster('bud_te_items');

                                $data3 = $this->m_masters->getallmaster('bud_lbl_items');

                                $sno = 1;
                                foreach ($table as $row) {
                                    //echo "<pre>";print_r($row);die;
                                    $v = $row['module_id'];
                                    $current = @current(array_filter($categories, function ($e) use ($v) {
                                        return $e['category_id'] == $v;
                                    }));
                                    $module_name = @$current['category_name'] . ' / M' . $v;

                                    $datax = '';
                                    if ($row['module_id'] == 1) {
                                        $datax = $data1;
                                    } else if ($row['module_id'] == 2) {
                                        $datax = $data2;
                                    } else if ($row['module_id'] == 3) {
                                        $datax = $data3;
                                    } else if ($row['module_id'] == 4) {
                                        $datax = $data2;
                                    }

                                    $vi = @$row['item_id'];
                                    $current = @current(array_filter($datax, function ($e) use ($vi) {
                                        return $e['item_id'] == $vi;
                                    }));
                                    $item_name = @$current['item_name'] . ' / ' . $vi;

                                    $vc = @$row['gpo_shade_id'];
                                    $current = @current(array_filter($shades, function ($e) use ($vc) {
                                        return $e['shade_id'] == $vc;
                                    }));
                                    $color_name = @$current['shade_name'] . ' / ' . @$current['shade_code'] . ' / ' . $vc;

                                    $vu = @$row['po_uom'];
                                    $current = @current(array_filter($uoms, function ($e) use ($vu) {
                                        return $e['uom_id'] == $vu;
                                    }));
                                    $uom_name = $row['po_qty'] . ' / ' . @$current['uom_name'];

                                    $duplicate_detail = '<a href="' . base_url() . 'customer_purchase_order/gpo_details/' . $row['gpono'] . '" class="btn btn-xs btn-warning" title="Details" onclick="event.cancelBubble=true;"><i class="icon-eye-open"></i></a>';

                                    $gpo_totsum = $this->ak->get_cust_gpo_totsum($row['gpono']);
                                    $gpo_prodsum = $this->ak->get_cust_gpo_prodsum($row['gpono']);

                                    $flag = '<a class="btn btn-xs btn-' . ((@$row['s_status'] == 3) ? 'success' : ((@$row['s_option'] > 0 && @$row['s_status'] == 1) ? 'warning' : ((@$row['s_status'] == 1 && @$row['s_option'] == 0) ? 'danger' : ((@$row['s_status'] == 2) ? 'primary' : ((@$row['s_status'] == 4) ? 'successblue' : ''))))) . '"><b>S</b></a>';

                                    $gpo_bal = ($gpo_totsum - $gpo_prodsum);

                                    $flag .= '<br><a class="btn btn-xs btn-' . (($gpo_bal == 0) ? 'success' : 'danger') . '"><b>G</b></a>';

                                    $shadeupdate = '<a href="#shadeupdate" gpono="' . $row['gpono'] . '" data-toggle="modal" class="btn btn-xs btn-primary shadeupdateclick" title="Shade Update"><i class="icon-beaker"></i></a>';

                                    $lotsarr = $this->ak->get_cust_gpo_prod_dyelot($row['gpono']);
                                    $alotsarr = array();
                                    foreach ($lotsarr as $key => $value) {

                                        $approvalbool = false;
                                        $user_category = @$this->session->userdata('user_category');
                                        if ($user_category == 9 || $user_category == 10 || $user_category == 11 || $user_category == 12 || $user_category == 13 || $user_category == 20) {
                                            $approvalbool = true;
                                        }

                                        $approvalflag1 = '';
                                        $approvalflag2 = '';
                                        $approvalitems = '';
                                        $approvalitems2 = '';
                                        $first_column = true;
                                        $lotsstatus = $this->ak->dost_customers_po_dyelotstatus($value['dyl_id']);
                                        if ($lotsstatus) {
                                            $approvalitems .= '<br>';
                                            $approvalitems2 .= '';
                                            foreach ($lotsstatus as $keyls => $lstatus) {

                                                if ($lstatus['dyla_status'] == 4 || $first_column == false) {
                                                    $first_column = false;
                                                    $approvalitems2 .= '<dl><dt><b>' . @$lstatus['dyla_user'] . '</b></dt><dd>' . @$this->ak->dost_lot_status_option($lstatus['dyla_status'])[0]['option'] . @$this->ak->dost_lot_final_approval($lstatus['dyla_status'])[0]['option'] . ', ' . @$this->ak->dost_lot_final_option($lstatus['dyla_option'])[0]['option'] . '</dd><dd>' . @$lstatus['dyla_remarks'] . '</dd><dd>' . date("d-F-Y H:i:s", strtotime($lstatus['dyla_date'])) . '</dd></dl>';
                                                } else {
                                                    if ($first_column) {
                                                        $approvalitems .= '<dl><dt><b>' . @$lstatus['dyla_user'] . '</b></dt><dd>' . @$this->ak->dost_lot_status_option($lstatus['dyla_status'])[0]['option'] . @$this->ak->dost_lot_final_approval($lstatus['dyla_status'])[0]['option'] . ', ' . @$this->ak->dost_lot_final_option($lstatus['dyla_option'])[0]['option'] . '</dd><dd>' . @$lstatus['dyla_remarks'] . '</dd><dd>' . date("d-F-Y H:i:s", strtotime($lstatus['dyla_date'])) . '</dd></dl>';
                                                    }
                                                }

                                                if ($lstatus['dyla_status'] == 1 && $lstatus['dyla_loop'] == 0) {
                                                    $userstatus = $this->m_users->getuserdetails($lstatus['dyla_userid']);
                                                    if ($userstatus) {
                                                        foreach ($userstatus as $key => $userarr) {
                                                            if ($userarr['user_category'] == 9) {
                                                                $approvalflag1 = '<br><a class="btn btn-xs btn-primary" title="Admin"><i class="icon-user"></i></a>';
                                                            } else if ($userarr['user_category'] == 10) {
                                                                $approvalflag1 = '<br><a class="btn btn-xs btn-primary" title="Director"><i class="icon-user"></i></a>';
                                                            } else if ($userarr['user_category'] == 11) {
                                                                $approvalflag1 = '<br><a class="btn btn-xs btn-primary" title="Genral Manager"><i class="icon-user"></i></a>';
                                                            } else if ($userarr['user_category'] == 12) {
                                                                $approvalflag2 = '<br><a class="btn btn-xs btn-primary" title="Production Manager"><i class="icon-user"></i></a>';
                                                            } else if ($userarr['user_category'] == 20) {
                                                                $approvalflag2 = '<br><a class="btn btn-xs btn-primary" title="Production Assistant Manager"><i class="icon-user"></i></a>';
                                                            } else if ($userarr['user_category'] == 13) {
                                                                $approvalflag1 = '<br><a class="btn btn-xs btn-warning" title="Supervisor"><i class="icon-user"></i></a>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $regFlag = '';
                                        if (!$first_column) {
                                            $regFlag = '<br><a class="btn btn-xs btn-danger" title="Rejected">R</a><br>';
                                        }

                                        $value[0] = $regFlag . '<a class="btn btn-xs btn-' . (($value['dyl_status'] == 1) ? 'danger' : (($value['dyl_status'] == 2) ? 'warning' : (($value['dyl_status'] == 3) ? 'success' : ''))) . '"><b>P</b></a>' . $approvalflag1 . $approvalflag2;

                                        $value[1] = 'M' . $value['dyl_machine_name'] . '-LOT' . $value['dyl_id'];

                                        $value['dyl_remark'] = $value['dyl_remarks'] . $approvalitems;
                                        $value['dyl_recorrect'] = '<div class="danger-cust">' . $approvalitems2 . '</div>';

                                        $value['dyl_users'] = $value['dyl_user'] . '<br>' . date("d-F-Y H:i:s", strtotime($value['dyl_date']));

                                        $value['dyl_machine_name'] = $mc_arr[$value['dyl_machine_name']];

                                        $value['dyl_action'] = (($approvalbool) ? '<a href="#lotapprove" lotno="' . $value['dyl_id'] . '" data-toggle="modal" class="btn btn-xs btn-primary lotapproveclick" title="Lot Approve"><i class="icon-comment"></i></a>' : '') . '<br><a href="#" class="btn btn-xs btn-danger" title="Print Recipe">Print Recipe</a>';

                                        unset($value['dyl_id']);
                                        unset($value['dyl_gpono']);
                                        unset($value['dyl_poeno']);
                                        unset($value['dyl_date']);
                                        unset($value['dyl_status']);
                                        unset($value['dyl_remarks']);
                                        unset($value['dyl_user']);

                                        $alotsarr[] = $value;
                                    }

                                    if (count($alotsarr) == 0) {
                                        continue;
                                    }

                                    $lots_json = json_encode($alotsarr);
                                ?>
                                    <script>
                                        data.push([
                                            '<?= $flag; ?>',
                                            '<?= $sno; ?>',
                                            'GPO/<?= $row['gpono']; ?>',
                                            '<?= date("d-F-Y H:i:s", strtotime($row['gpo_plan_date'])); ?>',
                                            '<?= $module_name; ?>',
                                            '<?= $item_name; ?>',
                                            '<?= $color_name; ?>',
                                            '<?= $gpo_totsum; ?>',
                                            '<?= number_format((float) ($gpo_totsum - $gpo_prodsum), 3, '.', ''); ?>',
                                            '<?= number_format((float) $gpo_prodsum, 3, '.', ''); ?>',
                                            '<?= $row['gpo_remarks']; ?>',
                                            '<?= $row['gpo_user']; ?><br><?= date("d-F-Y H:i:s", strtotime($row['gpo_date'])); ?>',
                                            '<?= $duplicate_detail; ?><br><?= $shadeupdate; ?>'
                                        ]);

                                        dataChild[<?= $row['gpono']; ?>] = <?= $lots_json; ?>;
                                    </script>
                                <?php
                                    $sno++;
                                }
                                ?>

                            </table>

                        </section>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
    </section>

    <?php
    $shade_ids = '';
    $shade_code = '';
    if (sizeof($shades) > 0) :
        foreach ($shades as $row) :
            $selectop = ' ';
            $shade_ids .= '<option value="' . $row['shade_id'] . '" ' . $selectop . '>' . $row['shade_name'] . '/' . $row['shade_id'] . '</option>';
            $shade_code .= '<option value="' . $row['shade_id'] . '" ' . $selectop . '>' . $row['shade_code'] . '</option>';
        endforeach;
    endif;
    ?>

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="shadeupdate" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Shade Update</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="<?= base_url(); ?>customer_purchase_order/po_gpo_shade_edit/">
                        <div class="form-group col-lg-12" style="margin-bottom: 15px;">
                            <p class="text-right"><a target="_blank" href="<?= base_url(); ?>" class="text-danger">Add Shade Master</a></p>
                            <div class="form-group">
                                <label for="filter_shade_id2">Colour Name/Code</label>
                                <select class="select2 filter-shade-select2 itemsselects form-control filter_shade_id2" name="filter_shade_id" id="filter_shade_id2">
                                    <option value="">Select</option>
                                    <?= $shade_ids; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="filter_shade_code2">Colour No</label>
                                <select class="select2 filter-shade-select2 itemsselects form-control filter_shade_code2" id="filter_shade_code2">
                                    <option value="">Select</option>
                                    <?= $shade_code; ?>
                                </select>
                            </div>
                            <br><br>
                            <button type="submit" class="btn btn-danger" name="shadeupdate">Shade Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="lotapprove" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Lot Approve</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="<?= base_url(); ?>customer_purchase_order/po_gpo_lot_approve/">
                        <div class="form-group col-lg-12" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <?php
                                $dost_lot_status_option = $this->ak->dost_lot_status_option();
                                foreach ($dost_lot_status_option as $key => $option) {
                                    echo '<label for="lot_status_option' . $option['id'] . '" class="radio-inline"><input type="radio" name="lot_status_option" id="lot_status_option' . $option['id'] . '" class="lot_status_option" value="' . $option['id'] . '" required>' . $option['option'] . '</label>';
                                }
                                ?>
                            </div>
                            <div class="form-group lot-group" style="display: none;">
                                <?php
                                $dost_lot_final_option = $this->ak->dost_lot_final_option();
                                foreach ($dost_lot_final_option as $key => $option) {
                                    echo '<label for="lot_final_option' . $option['id'] . '" class="radio-inline"><input type="radio" name="lot_final_option" id="lot_final_option' . $option['id'] . '" class="lot_final_option" value="' . $option['id'] . '">' . $option['option'] . '</label><br>';
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="lot_final_remarks">Remarks</label>
                                <textarea class="form-control" rows="3" name="lot_final_remarks" id="lot_final_remarks" required></textarea>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-danger lotapprovebtn" name="lotapprove">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php
    foreach ($js as $path) {
    ?>
        <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
    <?php
    }
    ?>

    <!--common script for all pages-->
    <?php
    foreach ($js_common as $path) {
    ?>
        <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
    <?php
    }
    ?>

    <!--script for this page-->
    <?php
    foreach ($js_thispage as $path) {
    ?>
        <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
    <?php
    }
    ?>

    <?php $this->load->view('html/filter.php'); ?>

    <script>
        //owl carousel

        $(document).ready(function() {

            $("#owl-demo").owlCarousel({
                navigation: true,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true
            });

            // DataTable
            var table = $('#sample_1x').DataTable({
                'data': data,
                'deferRender': true,
                'createdRow': function(row, data, dataIndex) {
                    $(row).addClass('parent-row');
                },
                'processing': true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },
                'order': [
                    [3, "desc"]
                ]
            });

            jQuery('.dataTables_filter input').addClass("form-control");
            jQuery('.dataTables_filter').parent().addClass('col-sm-6');
            jQuery('.dataTables_length select').addClass("form-control");
            jQuery('.dataTables_length').parent().addClass('col-sm-6');

            function CreateTableFromJSON(childJson) {

                if (childJson.length > 0) {

                    var col = [];
                    for (var i = 0; i < childJson.length; i++) {
                        for (var key in childJson[i]) {
                            if (col.indexOf(key) === -1) {
                                col.push(key);
                            }
                        }
                    }

                    var table = document.createElement("table");

                    table.className = "table table-striped dataTable no-footer";

                    var tr = table.insertRow(-1);

                    tr.innerHTML = '<th>Flag</th><th>Prod. Lot No.</th><th>Fill Lot Qty</th><th>Mannual Lot No</th><th>Machine Name</th><th>Remarks</th><th>Lot Re-Correction</th><th>Lot Production Date</th><th>Action</th>';

                    /*for (var i = 0; i < col.length; i++) {
                        var th = document.createElement("th");
                        th.innerHTML = col[i];
                        tr.appendChild(th);
                    }*/

                    for (var i = 0; i < childJson.length; i++) {

                        tr = table.insertRow(-1);

                        for (var j = 0; j < col.length; j++) {
                            var tabCell = tr.insertCell(-1);
                            tabCell.innerHTML = childJson[i][col[j]];
                        }
                    }

                    return table;

                }
            }

            table.rows().every(function() {
                var gpono = parseFloat(this.data()[2].split("/")[1].trim());
                //console.log(dataChild[gpono]);
                this.child(CreateTableFromJSON(dataChild[gpono]));
                var child = table.row(this).child;
                child.show();
            });

            /*$('#sample_1x tbody').on('click', 'tr', function(e) {
                var child = table.row(this).child;

                if (child.isShown()) {
                    child.hide();
                } else {
                    child.show();
                }
                e.preventDefault();
            });*/

            $(".filter-shade-select2").change(function() {
                $(".filter_shade_id2").select2("val", $(this).val());
                $(".filter_shade_code2").select2("val", $(this).val());
                return false;
            });

            jQuery(".shadeupdateclick").on('click', function(e) {
                var gpono = $(this).attr('gpono');
                action = "<?= base_url(); ?>customer_purchase_order/po_gpo_shade_edit/";
                $("#shadeupdate form").attr('action', action + gpono);
                $("form").trigger("reset");
                e.preventDefault();
            });

            jQuery(".lotapproveclick").on('click', function(e) {
                var lotno = $(this).attr('lotno');
                action = "<?= base_url(); ?>customer_purchase_order/po_gpo_lot_approve/";
                $("#lotapprove form").attr('action', action + lotno);
                $("form").trigger("reset");
                e.preventDefault();
            });

            jQuery(".lot_status_option").on('click', function(e) {
                var lot_status_option = $(this).val();
                jQuery(".lot-group").hide();
                if (lot_status_option == 2) {
                    jQuery(".lot-group").show();
                }
            });

            jQuery(".lotapprovebtn").on('click', function(e) {
                return confirm('Dear User,\n\nNOTE: After you click save button, This Lot will be shifted to next form "D PROD. CUST. APPR." IF Lot approved by Supervisor & Production Head both!.\n');
                e.preventDefault();
            });

        });

        //custom select box

        $(function() {
            $('select.styled').customSelect();
        });

        $(document).ajaxStart(function() {
            $('.pageloader').show();
        });
        $(document).ajaxStop(function() {
            $('.pageloader').hide();
        });
    </script>

</body>

</html>