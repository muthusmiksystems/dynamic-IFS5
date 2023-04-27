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
                            </script>

                            <form id="form-selection" action="" method="post">

                                <table class="table table-striped border-top display select" id="sample_1x">
                                    <thead>
                                        <tr>
                                            <th colspan="10"></th>
                                            <th>Tot. Qty<br>
                                                <div class="tot_qty">0</div>
                                            </th>
                                            <th>Bal. Qty<br>
                                                <div class="bal_qty">0</div>
                                            </th>
                                            <th colspan="4"></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>Flag</th>
                                            <th>Sno</th>
                                            <th>EPO No</th>
                                            <th>EPO Date</th>
                                            <th>Select Product</th>
                                            <th>Item name</th>
                                            <th>Customer Item Name</th>
                                            <th>Customer Colour Name</th>
                                            <th>Colour Name / Code / No</th>
                                            <th>PO Qty / UOM</th>
                                            <th>PO Bal. Qty</th>
                                            <th>Cust. Remarks</th>
                                            <th>Factory Remarks</th>
                                            <th>Accepted By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php

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

                                        $vc = @$row['shade_id'];
                                        $current = @current(array_filter($shades, function ($e) use ($vc) {
                                            return $e['shade_id'] == $vc;
                                        }));
                                        $color_name = @$current['shade_name'] . ' / ' . @$current['shade_code'] . ' / ' . $vc;

                                        $vu = @$row['po_uom'];
                                        $current = @current(array_filter($uoms, function ($e) use ($vu) {
                                            return $e['uom_id'] == $vu;
                                        }));
                                        $uom_name = $row['po_qty'] . ' / ' . @$current['uom_name'];

                                        $duplicate_detail = '<a href="' . base_url() . 'customer_purchase_order/po_from_customers_enquiry_details/' . $row['poeno'] . '" class="btn btn-xs btn-warning" title="Details" onclick="event.cancelBubble=true;"><i class="icon-eye-open"></i></a>';

                                        $flag = '<a class="btn btn-xs btn-' . ((@$row['s_status'] == 3) ? 'success' : ((@$row['s_option'] > 0 && @$row['s_status'] == 1) ? 'warning' : ((@$row['s_status'] == 1 && @$row['s_option'] == 0) ? 'danger' : ((@$row['s_status'] == 2) ? 'primary' : ((@$row['s_status'] == 4) ? 'successblue' : ''))))) . '"><b>S</b></a>';
                                    ?>
                                        <script>
                                            data.push([
                                                '<?= $row['poeno']; ?>',
                                                '<?= $flag; ?>',
                                                '<?= $sno; ?>',
                                                'EPO/<?= $row['poeno']; ?>',
                                                '<?= date("d-F-Y H:i:s", strtotime($row['date']));; ?>',
                                                '<?= $module_name; ?>',
                                                '<?= $item_name; ?>',
                                                '<?= $row['cust_item_name']; ?>',
                                                '<?= $row['cust_color_name']; ?>',
                                                '<?= $color_name; ?>',
                                                '<?= $uom_name; ?>',
                                                '<?= ($row['po_qty'] - $row['po_bal_qty']); ?>',
                                                '<?= $row['remarks']; ?>',
                                                '<?= $row['remarkstocust']; ?>',
                                                '<?= $row['a_user']; ?>',
                                                '<?= $duplicate_detail; ?>'
                                            ]);
                                        </script>
                                    <?php
                                        $sno++;
                                    }
                                    ?>
                                    <tfoot>
                                        <tr class="tfilterrow">
                                            <th colspan="6"></th>
                                            <th>Item name</th>
                                            <th colspan="2"></th>
                                            <th>Colour Name / Code / No</th>
                                            <th colspan="6"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="10"></th>
                                            <th>Tot. Qty<br>
                                                <div class="tot_qty">0</div>
                                            </th>
                                            <th>Bal. Qty<br>
                                                <div class="bal_qty">0</div>
                                            </th>
                                            <th colspan="4"></th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <section class="panel">
                                    <div class="panel-body">
                                        <button disabled class="btn btn-danger dprodplan">Add to List</button>
                                    </div>
                                </section>

                            </form>

                            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>customer_purchase_order/add_dyeing_plan">

                                <table class="table table-striped border-top display select" id="sample_2x">
                                    <thead>
                                        <tr>
                                            <th colspan="8"></th>
                                            <th>Tot. Qty<br>
                                                <div class="tot_qty">0</div>
                                            </th>
                                            <th>Bal. Qty<br>
                                                <div class="gbal_qty">0</div>
                                            </th>
                                            <th>Fill. Qty<br>
                                                <div class="gfill_qty">0</div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Flag</th>
                                            <th>Sno</th>
                                            <th>EPO No</th>
                                            <th>EPO Date</th>
                                            <th>Select Product</th>
                                            <th>Item name</th>
                                            <th>Customer Item Name</th>
                                            <th>Customer Colour Name</th>
                                            <th>Colour Name / Code / No</th>
                                            <th>PO Qty / UOM</th>
                                            <th>Fill Lot Qty</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="8"></th>
                                            <th>Tot. Qty<br>
                                                <div class="tot_qty">0</div>
                                            </th>
                                            <th>Bal. Qty<br>
                                                <div class="gbal_qty">0</div>
                                            </th>
                                            <th>Fill. Qty<br>
                                                <div class="gfill_qty">0</div>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <section class="panel">
                                    <div class="panel-body">

                                        <div class="form-group col-lg-3">
                                            <label for="gpo_machine_name">Machine Name</label>
                                            <input type="text" class="form-control" name="gpo_machine_name" id="gpo_machine_name" required>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="gpo_plan_date">Dyeing Plan Date</label>
                                            <input type="text" class="form-control datepluginmin" name="gpo_plan_date" id="gpo_plan_date" value="<?= date("d-m-Y", strtotime("+1 day")); ?>" required>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="gpo_remarks">Remarks From D Production Incharge</label>
                                            <textarea class="form-control" rows="3" name="gpo_remarks" id="gpo_remarks" required></textarea>
                                        </div>

                                        <div style="clear:both;"></div>

                                        <div class="form-group col-lg-12">
                                            <input type="submit" class="btn btn-danger dprodplan" name="save" value="Save in D Production Plan" disabled />
                                        </div>
                                    </div>

                                </section>
                            </form>

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

            $('#sample_1x tfoot .tfilterrow th').each(function() {
                var title = $(this).text();
                if (title != '')
                    $(this).html('<input type="text" placeholder="' + title + '" />');
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
                'columnDefs': [{
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }],
                'select': {
                    'style': 'multi'
                },
                'order': [
                    [0, "desc"]
                ]
            });

            // Apply the search
            table.columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table2 = $('#sample_2x').DataTable({
                'deferRender': true,
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

            // Handle form submission event 
            $('#form-selection').on('click', function(e) {
                var form = this;

                var rows_selected = table.column(0).checkboxes.selected();

                // Iterate over all selected checkboxes
                $.each(rows_selected, function(index, rowId) {
                    // Create a hidden element 
                    $(form).append(
                        $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'id[]')
                        .val(rowId)
                    );
                });

                var rows = table.rows({
                    selected: true
                }).data();

                table2.clear();
                var tot = 0;
                var bal = 0;
                var itemid = '';
                $.each(rows, function(index, value) {
                    var itot = parseFloat(value[10].split("/")[0].trim());
                    tot += itot;

                    var ibal = parseFloat(value[11].split("/")[0].trim());
                    bal += ibal;
                    value[12] = '<input type="number" max="' + itot + '" name="fill_qty[' + value[0] + ']" id="fill_qty" class="fill_qty" readonly="true" value="' + itot + '">';

                    if (value[6] != itemid && itemid != '') {
                        alert("Don't select different Item No.!!!");
                        return false;
                    }
                    itemid = value[6];

                    var newVal = [value[1], value[2], value[3], value[4], value[5], value[6], value[7], value[8], value[9], value[10], value[12]];
                    table2.row.add(newVal);

                    $('.dprodplan').prop('disabled', false);
                });
                table2.draw();

                if (tot == 0) {
                    $('.dprodplan').prop('disabled', true);
                }

                $('.tot_qty').text(tot);
                $('.bal_qty').text(bal);
                $('.gfill_qty').text(tot);

                // FOR DEMONSTRATION ONLY
                // The code below is not needed in production

                // Output form data to a console     
                $('#example-console-rows').text(rows_selected.join(","));

                // Output form data to a console     
                $('#example-console-form').text($(form).serialize());

                // Remove added elements
                $('input[name="id\[\]"]', form).remove();

                // Prevent actual form submission
                e.preventDefault();
            });

            jQuery(".po_reject_no").on('change', function() {
                var id = $(this).val();
                if (id == '4') {
                    jQuery(".po_reject_remarks").show();
                } else {
                    jQuery(".po_reject_remarks").hide();
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