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
                        
                        $secretInfo = false;
                        $user_category = @$this->session->userdata('user_category');
                        if ($user_category == 9 || $user_category == 10 || $user_category == 11 || $user_category == 12 || $user_category == 20 || $user_category == 4) {
                            $secretInfo = true;
                        }
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
                                        <th>Customer</th>
                                        <th>Select Product</th>
                                        
                                        <th>Item name</th>
                                        <th>Customer Item Name</th>
                                        <th>Customer Colour Name</th>
                                        <th>Colour Name / Code / No</th>
                                        <th>PO Qty / UOM</th>
                                        <th>Price Before GST</th>
                                        <th>Filled By</th>
                                        <th>Cust. Remarks</th>
                                        <th>Factory Remarks</th>
                                        <th>Accepted By</th>
                                        <th>Action</th>
                                       
                                    </tr>
                                </thead>
                                <?php

                                $po_accept_option_arr = $this->ak->dost_po_accept_option();
                                $po_accept_option_data = '';
                                foreach ($po_accept_option_arr as $option) {
                                    $po_accept_option_data .= '<option value="' . $option['id'] . '">' . $option['option'] . '</option>';
                                }

                                $po_reject_option_arr = $this->ak->dost_po_reject_option();
                                $po_reject_option_data = '';
                                foreach ($po_reject_option_arr as $option) {
                                    $po_reject_option_data .= '<option value="' . $option['id'] . '">' . $option['option'] . '</option>';
                                }

                                $po_sampling_option_arr = $this->ak->dost_po_sampling_option();
                                $po_sampling_option_data = '';
                                $po_sampling_option_data1 = '';
                                $po_sampling_option_data2 = '';
                                foreach ($po_sampling_option_arr as $option) {
                                    $po_sampling_option_data .= '<option value="' . $option['id'] . '">' . $option['option'] . '</option>';
                                    if ($option['id'] != 1) {
                                        $po_sampling_option_data1 .= '<option value="' . $option['id'] . '">' . $option['option'] . '</option>';
                                    }
                                    if ($option['id'] != 4) {
                                        $po_sampling_option_data2 .= '<option value="' . $option['id'] . '">' . $option['option'] . '</option>';
                                    }
                                }

                                $po_sample_option_arr = $this->ak->dost_po_sample_complete_option();
                                $po_sample_option_data = '';
                                foreach ($po_sample_option_arr as $option) {
                                    $po_sample_option_data .= '<option value="' . $option['id'] . '">' . $option['option'] . '</option>';
                                }

                                $po_sample_final_option_arr = $this->ak->dost_po_sample_final_option();
                                $po_sample_final_option_data = '';
                                foreach ($po_sample_final_option_arr as $option) {
                                    $po_sample_final_option_data .= '<option value="' . $option['id'] . '">' . $option['option'] . '</option>';
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

                                    $duplicate_detail = '<a href="' . base_url() . 'customer_purchase_order/po_from_customers_enquiry/' . $row['poeno'] . '" class="btn btn-xs btn-success" title="Duplicate"><i class="icon-copy"></i></a><br><a href="' . base_url() . 'customer_purchase_order/po_from_customers_enquiry_details/' . $row['poeno'] . '" class="btn btn-xs btn-warning" title="Details"><i class="icon-eye-open"></i></a>';

                                    $edit_detail = '<a href="' . base_url() . 'customer_purchase_order/po_from_customers_enquiry/' . $row['poeno'] . '/edit" class="btn btn-xs btn-danger" title="Complete"><i class="icon-pencil"></i></a><br>';

                                    $accept = '<a href="#acc' . $row['poeno'] . '" data-toggle="modal" class="btn btn-xs btn-primary" title="Accept"><i class="icon-book"></i></a><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="acc' . $row['poeno'] . '" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">Accept</h4></div><div class="modal-body"><form role="form" method="post" action="' . base_url() . 'customer_purchase_order/po_accept_no/' . $row['poeno'] . '"><div class="form-group col-lg-12" style="margin-bottom: 15px;"><select name="po_accept_no" class="form-control po_accept_no" required>' . $po_accept_option_data . '</select><br><br><select name="po_sample_no" class="form-control po_sample_no" required>' . $po_sampling_option_data1 . '</select><br><br><textarea name="remarkstocust" class="form-control remarkstocust" placeholder="Add Remarks"></textarea><br><br><button type="submit" class="btn btn-danger" name="accept">Accept</button></div></form></div></div></div></div>';

                                    $reject = '<a href="#reg' . $row['poeno'] . '" data-toggle="modal" class="btn btn-xs btn-primary" title="Reject"><i class="icon-ban-circle"></i></a><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="reg' . $row['poeno'] . '" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">Reject</h4></div><div class="modal-body"><form role="form" method="post" action="' . base_url() . 'customer_purchase_order/po_reject_no/' . $row['poeno'] . '"><div class="form-group col-lg-12" style="margin-bottom: 15px;"><select name="po_reject_no" class="form-control po_reject_no" required>' . $po_reject_option_data . '</select><br><br><textarea name="po_reject_remarks" class="form-control po_reject_remarks" placeholder="Add Remarks" style="display: none;"></textarea><br><br><button type="submit" class="btn btn-danger" name="accept">Accept</button></div></form></div></div></div></div>';

                                    if (@$row['item_id'] == '' || @$row['shade_id'] == '') {
                                        $accept = '<a href="#acc' . $row['poeno'] . '" data-toggle="modal" class="btn btn-xs btn-primary" title="Accept"><i class="icon-book"></i></a><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="acc' . $row['poeno'] . '" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">Accept</h4></div><div class="modal-body">Complete the missing fields PO first, Then try again!!!.</div></div></div></div>';
                                    }

                                    if ($row['po_accept_no'] != 0) {
                                        $accept = '<a href="#acc' . $row['poeno'] . '" data-toggle="modal" class="btn btn-xs btn-danger" title="Accepted"><i class="icon-ban-circle"></i></a><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="acc' . $row['poeno'] . '" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">In Progress</h4></div><div class="modal-body">' . @$po_accept_option_arr[@$row['a_option'] - 1]['option'] . '</div></div></div></div>';
                                        $edit_detail = '';
                                    }

                                    if ($row['po_reject_no'] != 0) {
                                        $reject = '<a href="#reg' . $row['poeno'] . '" data-toggle="modal" class="btn btn-xs btn-primary" title="Rejected"><i class="icon-ban-circle"></i></a><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="reg' . $row['poeno'] . '" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">Rejected</h4></div><div class="modal-body">' . @$po_reject_option_arr[@$row['r_option'] - 1]['option'] . ' ' . @$row['po_reject_remarks'] . '</div></div></div></div>';
                                    }

                                    $flag = '<a class="btn btn-xs btn-' . ((@$row['s_status'] == 3) ? 'success' : ((@$row['s_option'] > 0 && @$row['s_status'] == 1) ? 'warning' : ((@$row['s_status'] == 1 && @$row['s_option'] == 0) ? 'danger' : ((@$row['s_status'] == 2) ? 'primary' : ((@$row['s_status'] == 4) ? 'successblue' : ''))))) . '"><b>S</b></a><br><br><a class="btn btn-xs btn-danger"><b>P</b></a>';

                                    $flag .= (@$row['company_stock_active'] == 1)?'<br><a class="btn btn-xs btn-success"><b>F</b></a><br>':'';

                                ?>
                                    <script>
                                        <?php if ($this->session->userdata('logged_as') == 'customer') { ?>
                                            data.push([
                                                '<?= $flag; ?>',
                                                '<?= $sno; ?>',
                                                'EPO/<?= $row['poeno']; ?>',
                                                '<?= date("d-F-Y H:i:s", strtotime($row['date']));; ?>',
                                                '<?= $row['cust_name']; ?>',
                                                '<?= $module_name; ?>',
                                                '<?= $item_name; ?>',
                                                '<?= $row['cust_item_name']; ?>',
                                                '<?= $row['cust_color_name']; ?>',
                                                '<?= $color_name; ?>',
                                                '<?= $uom_name; ?>',
                                                '<?= $row['po_price']; ?>',
                                                '<?= $row['cust_staff_name']; ?><br><?= $row['cust_staff_mobile']; ?><br><?= $row['cust_staff_email']; ?>',
                                                '<?= $row['remarks']; ?>',
                                                '<?= $row['remarkstocust']; ?>',
                                                '<?= $row['a_user']; ?>',
                                                '<?= $duplicate_detail; ?>'
                                            ]);
                                        <?php } else { ?>
                                            data.push([
                                                '<?= $flag; ?>',
                                                '<?= $sno; ?>',
                                                'EPO/<?= $row['poeno']; ?>',
                                                '<?= date("d-F-Y H:i:s", strtotime($row['date']));; ?>',
                                                '<?= ($secretInfo) ? $row['cust_name'] : '-'; ?>',
                                                '<?= $module_name; ?>',
                                                '<?= $item_name; ?>',
                                                '<?= $row['cust_item_name']; ?>',
                                                '<?= $row['cust_color_name']; ?>',
                                                '<?= $color_name; ?>',
                                                '<?= $uom_name; ?>',
                                                '<?= ($secretInfo) ? $row['po_price'] : '-'; ?>',
                                                '<?= ($secretInfo) ? $row['cust_staff_name'] . '<br>' . $row['cust_staff_mobile'] . '<br>' . $row['cust_staff_email'] : '-'; ?>',
                                                '<?= $row['remarks']; ?>',
                                                '<?= $row['remarkstocust']; ?>',
                                                '<?= $row['a_user']; ?>',
                                                '<?= $accept; ?><br><?= $edit_detail; ?><?= $duplicate_detail; ?><br><?= $reject; ?>'
                                            ]);
                                        <?php } ?>
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

            // $('#sample_1x tfoot th').each(function() {
            //     var title = $(this).text();
            //     $(this).html('<input type="text" placeholder="' + title + '" />');
            // });

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

            // Apply the search
            // table.columns().every(function() {
            //     var that = this;

            //     $('input', this.footer()).on('keyup change clear', function() {
            //         if (that.search() !== this.value) {
            //             that
            //                 .search(this.value)
            //                 .draw();
            //         }
            //     });
            // });

            jQuery(".po_reject_no").on('change', function(e) {
                var id = $(this).val();
                if (id == '4') {
                    jQuery(".po_reject_remarks").show();
                } else {
                    jQuery(".po_reject_remarks").hide();
                }
            });

            jQuery(".po_accept_no").on('change', function(e) {
                var id = $(this).val();
                var afid = $(this).closest('.modal').attr('id');
                if (id == '1') {
                    jQuery("#" + afid + " .po_sample_no").html('<?= $po_sampling_option_data1; ?>');
                } else {
                    jQuery("#" + afid + " .po_sample_no").html('<?= $po_sampling_option_data2; ?>');
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
            $('.pageloader').show();
        });
    </script>

<!-- <script>
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

            jQuery(".po_sample_option").on('change', function() {
                var id = $(this).val();
                if (id == '4') {
                    jQuery(".po_sample_remarks").show();
                } else {
                    jQuery(".po_sample_remarks").hide();
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
    </script> -->


</body>

</html>