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
                            <table class="table table-striped border-top" id="sample_1x">
                                <thead>
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
                                        <th>Cust. Remarks</th>
                                        <th>Factory Remarks</th>
                                        <th>Accepted By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php

                                $po_accept_option_arr = $this->ak->dost_po_accept_option();


                                $po_reject_option_arr = $this->ak->dost_po_reject_option();


                                $po_sampling_option_arr = $this->ak->dost_po_sampling_option();


                                $po_sample_option_arr = $this->ak->dost_po_sample_complete_option();


                                $po_sample_final_option_arr = $this->ak->dost_po_sample_final_option();


                                $data1 = $this->m_masters->get_items_array('bud_items');

                                $data2 = $this->m_masters->getallmaster('bud_te_items');

                                $data3 = $this->m_masters->getallmaster('bud_lbl_items');

                                $sno = 1;
                                foreach ($table as $row) {
                                    $v = $row['module_id'];
                                    $current = current(array_filter($categories, function ($e) use ($v) {
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

                                    if (is_array($datax)) {
                                        $current = current(array_filter($datax, function ($e) use ($vi) {
                                            return $e['item_id'] == $vi;
                                        }));
                                        // rest of your code here
                                    }
                                    // elseif (is_string($datax)) {
                                    //     // Convert the string into an array
                                    //     $dataArray = explode(',', $datax);
                                    
                                    //     // Filter the array
                                    //     $current = current(array_filter($dataArray, function ($e) use ($vi) {
                                    //         return $e['item_id'] == $vi;
                                    //     }));
                                    //     // rest of your code here
                                    // }

                                   /* $current = current(array_filter($datax, function ($e) use ($vi) {
                                        return $e['item_id'] == $vi;
                                    }));*/
                                    $item_name = @$current['item_name'] . ' / ' . $vi;

                                    $vc = @$row['shade_id'];
                                    $current = current(array_filter($shades, function ($e) use ($vc) {
                                        return $e['shade_id'] == $vc;
                                    }));
                                    $color_name = @$current['shade_name'] . ' / ' . @$current['shade_code'] . ' / ' . $vc;

                                    $vu = @$row['po_uom'];
                                    $current = current(array_filter($uoms, function ($e) use ($vu) {
                                        return $e['uom_id'] == $vu;
                                    }));
                                    $uom_name = $row['po_qty'] . ' / ' . @$current['uom_name'];

                                    $duplicate_detail = '<a href="' . base_url() . 'customer_purchase_order/po_from_customers_enquiry_details/' . $row['poeno'] . '" class="btn btn-xs btn-warning" title="Details"><i class="icon-eye-open"></i></a>';

                                    $flag = '<a class="btn btn-xs btn-' . ((@$row['s_status'] == 3) ? 'success' : ((@$row['s_option'] > 0 && @$row['s_status'] == 1) ? 'warning' : ((@$row['s_status'] == 1 && @$row['s_option'] == 0) ? 'danger' : ((@$row['s_status'] == 2) ? 'primary' : ((@$row['s_status'] == 4) ? 'successblue' : ''))))) . '"><b>S</b></a>';

                                ?>
                                    <script>
                                        data.push([
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
                                            '<?= $row['remarks']; ?>',
                                            '<?= $row['remarkstocust'] . '<br>' . @$po_sample_option_arr[@$row['s_option'] - 1]['option']; ?>',
                                            '<?= $row['a_user']; ?>',
                                            '<?= $duplicate_detail; ?>'
                                        ]);
                                    </script>
                                <?php
                                    $sno++;
                                }
                                ?>
                            </table>
                        </section>
                    </div>
                    <p style="text-align:right;font-size:4px;margin-right:10px">application\views\po_from_customers_enquiry_stock_list.php</p>
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
                "order": [
                    [3, "desc"]
                ]
            });

            jQuery('.dataTables_filter input').addClass("form-control");
            jQuery('.dataTables_filter').parent().addClass('col-sm-6');
            jQuery('.dataTables_length select').addClass("form-control");
            jQuery('.dataTables_length').parent().addClass('col-sm-6');

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