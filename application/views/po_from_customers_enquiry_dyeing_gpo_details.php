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

                            <div class="form-group col-lg-12">
                                <a onclick="window.history.back();" class="btn btn-danger">Back</a>
                            </div>

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

                                    $gpo_totsum = $this->ak->get_cust_gpo_totsum($row['gpono']);
                                    $gpo_prodsum = $this->ak->get_cust_gpo_prodsum($row['gpono']);

                                    $flag = '<a class="btn btn-xs btn-' . ((@$row['s_status'] == 3) ? 'success' : ((@$row['s_option'] > 0 && @$row['s_status'] == 1) ? 'warning' : ((@$row['s_status'] == 1 && @$row['s_option'] == 0) ? 'danger' : ((@$row['s_status'] == 2) ? 'primary' : ((@$row['s_status'] == 4) ? 'successblue' : ''))))) . '"><b>S</b></a>';

                                    $gpo_bal = ($gpo_totsum - $gpo_prodsum);

                                    $flag .= '<br><a class="btn btn-xs btn-' . (($gpo_bal == 0) ? 'success' : 'danger') . '"><b>G</b></a>';

                                    $lotsarr = $this->ak->get_cust_gpo_prod_dyelot($row['gpono'], 3);
                                    $alotsarr = array();
                                    foreach ($lotsarr as $key => $value) {

                                        $approvalitems = '';
                                        $lotsstatus = $this->ak->dost_customers_po_dyelotstatus($value['dyl_id']);
                                        if ($lotsstatus) {
                                            $approvalitems .= '<br>';
                                            foreach ($lotsstatus as $keyls => $lstatus) {
                                                $approvalitems .= '<dl><dt><b>' . @$lstatus['dyla_user'] . '</b></dt><dd>' . @$this->ak->dost_lot_status_option($lstatus['dyla_status'])[0]['option'] . @$this->ak->dost_lot_final_approval($lstatus['dyla_status'])[0]['option'] . ', ' . @$this->ak->dost_lot_final_option($lstatus['dyla_option'])[0]['option'] . '</dd><dd>' . @$lstatus['dyla_remarks'] . '</dd></dl>';
                                            }
                                        }

                                        $value[0] = '<a class="btn btn-xs btn-' . (($value['dyl_status'] == 1) ? 'danger' : (($value['dyl_status'] == 2) ? 'warning' : (($value['dyl_status'] == 3) ? 'success' : ''))) . '"><b>P</b></a>';

                                        $value[1] = 'M' . $value['dyl_machine_name'] . '-LOT' . $value['dyl_id'];

                                        $value['dyl_remark'] = $value['dyl_remarks'] . $approvalitems;

                                        $value['dyl_users'] = $value['dyl_user'] . '<br>' . date("d-F-Y H:i:s", strtotime($value['dyl_date']));

                                        $value['dyl_machine_name'] = $mc_arr[$value['dyl_machine_name']];

                                        unset($value['dyl_id']);
                                        unset($value['dyl_gpono']);
                                        unset($value['dyl_poeno']);
                                        unset($value['dyl_date']);
                                        unset($value['dyl_status']);
                                        unset($value['dyl_remarks']);
                                        unset($value['dyl_user']);

                                        $alotsarr[] = $value;
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
                                            '<?= ($gpo_totsum - $gpo_prodsum); ?>',
                                            '<?= $gpo_prodsum; ?>',
                                            '<?= $row['gpo_remarks']; ?>',
                                            '<?= $row['gpo_user']; ?><br><?= date("d-F-Y H:i:s", strtotime($row['gpo_date'])); ?>'
                                        ]);

                                        dataChild[<?= $row['gpono']; ?>] = <?= $lots_json; ?>;
                                    </script>
                                <?php
                                    $sno++;
                                }
                                ?>

                            </table>

                            <div class="form-group col-lg-12">
                                <a onclick="window.history.back();" class="btn btn-danger">Back</a>
                            </div>

                        </section>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
    </section>

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
                'processing': true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },
                'order': [
                    [1, "desc"]
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

                    tr.innerHTML = '<th>Flag</th><th>Prod. Lot No.</th><th>Fill Lot Qty</th><th>Mannual Lot No</th><th>Machine Name</th><th>Remarks</th><th>Accepted By</th>';

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