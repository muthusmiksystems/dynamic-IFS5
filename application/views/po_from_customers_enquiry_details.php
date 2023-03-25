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

                <?php
                $podata = $table[0];

                $secretInfo = false;
                $user_category = @$this->session->userdata('user_category');
                if ($user_category == 9 || $user_category == 10 || $user_category == 11 || $user_category == 12 || $user_category == 20 || $user_category == 4) {
                    $secretInfo = true;
                }
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <?= $page_heading; ?>
                            </header>
                            <div class="panel-body">
                                <?php
                                if ($this->session->flashdata('warning')) {
                                ?>
                                    <div class="alert alert-warning fade in">
                                        <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="icon-remove"></i>
                                        </button>
                                        <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                                    </div>
                                <?php
                                }
                                if ($this->session->flashdata('error')) {
                                ?>
                                    <div class="alert alert-block alert-danger fade in">
                                        <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="icon-remove"></i>
                                        </button>
                                        <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                                    </div>
                                <?php
                                }
                                if ($this->session->flashdata('success')) {
                                ?>
                                    <div class="alert alert-success alert-block fade in">
                                        <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="icon-remove"></i>
                                        </button>
                                        <h4>
                                            <i class="icon-ok-sign"></i>
                                            Thank You!
                                        </h4>
                                        <p><?= $this->session->flashdata('success'); ?></p>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="form-group col-lg-12">
                                    <a onclick="window.history.back();" class="btn btn-danger">Back</a>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label>PO Enquiry No : </label>
                                    EPO/<?= @$podata['poeno']; ?> / <?= date("d-F-Y", strtotime(@$podata['date']));; ?>
                                </div>

                                <?php if ($secretInfo) { ?>
                                    <div class="form-group col-lg-4">
                                        <label for="sales_to">Customer : </label>
                                        <?php
                                        foreach ($customers as $cust) {
                                        ?>
                                            <?= (@$podata['cust_id'] == $cust['cust_id']) ? $cust['cust_name'] : ''; ?>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php } ?>

                                <div class="form-group col-lg-4">
                                    <label for="module_id">Selected Product : </label>
                                    <?php
                                    foreach ($categories as $category) {
                                    ?>
                                        <?= (@$podata['module_id'] == $category['category_id']) ? $category['category_name'] . ' / ' . $category['category_id'] : ''; ?>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <?php
                                $data1 = $this->m_masters->get_items_array('bud_items');

                                $data2 = $this->m_masters->getallmaster('bud_te_items');

                                $data3 = $this->m_masters->getallmaster('bud_lbl_items');

                                $items = '';
                                if (@$podata['module_id'] == 1) {
                                    $items = $data1;
                                } else if (@$podata['module_id'] == 2) {
                                    $items = $data2;
                                } else if (@$podata['module_id'] == 3) {
                                    $items = $data3;
                                } else if (@$podata['module_id'] == 4) {
                                    $items = $data2;
                                }
                                ?>

                                <div class="form-group col-lg-4">
                                    <label for="item_id">Item name : </label>
                                    <?php
                                   if ((is_array($items) || is_object($items))&& !empty($items))
                                   {
                                    foreach ($items as $row) {
                                       
                                    ?>
                                        <?= (@$podata['item_id'] == $row['item_id']) ? $row['item_name'] . ' - ' . $row['item_id'] : ''; ?>
                                    <?php
                                    }
                                   }
                                  
                                    ?>
                                </div>

                                <div style="clear:both;"></div>

                                <div class="form-group col-lg-4">
                                    <label for="cust_item_name">Customer Item Name : </label>
                                    <?= @$podata['cust_item_name']; ?>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="cust_color_name">Customer Colour Name : </label>
                                    <?= @$podata['cust_color_name']; ?>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="shade_id">Colour Name/Code/No : </label>
                                    <?php
                                    if (sizeof($shades) > 0) :
                                        foreach ($shades as $row) :
                                            if (@$podata['shade_id'] == $row['shade_id']) {
                                                echo $row['shade_name'] . '/' . $row['shade_code'] . '/' . $row['shade_id'];
                                            }
                                        endforeach;
                                    endif; ?>
                                </div>

                                <div style="clear:both;"></div>

                                <?php if ($secretInfo) { ?>
                                    <div class="form-group col-lg-4">
                                        <label for="po_price">Price Before GST : </label>
                                        <?= @$podata['po_price']; ?>
                                    </div>
                                <?php } ?>

                                <div class="form-group col-lg-4">
                                    <label for="po_qty">PO Qty / UOM : </label>
                                    <?= @$podata['po_qty']; ?> /
                                    <?php
                                    foreach ($uoms as $row) {
                                    ?>
                                        <?= (@$podata['po_uom'] == $row['uom_id']) ? $row['uom_name'] : ''; ?>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="po_need_date">Need Date : </label>
                                    <?= date("d-F-Y", strtotime(@$podata['po_need_date'])); ?>
                                </div>

                                <div style="clear:both;"></div>

                                <div class="form-group col-lg-12">
                                    <label for="remarks">Remarks : </label>
                                    <?= @$podata['remarks']; ?>
                                </div>

                                <?php if ($secretInfo) { ?>
                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-12">
                                        <label for="item_uom" class="text-danger">PO Enquiry Sent By Staff on Behalf of Customer : </label>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-4">
                                        <label for="cust_staff_name">Name : </label>
                                        <?= @$podata['cust_staff_name']; ?>
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="cust_staff_mobile">Mobile : </label>
                                        <?= @$podata['cust_staff_mobile']; ?>
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="cust_staff_email">E-Mail ID : </label>
                                        <?= @$podata['cust_staff_email']; ?>
                                    </div>
                                <?php } ?>

                                <div style="clear:both;"></div>
                                <hr>

                                <div class="form-group col-lg-12">
                                    <label for="remarkstocust">Message From Factory : </label>
                                    <?= @$podata['remarkstocust']; ?>
                                </div>

                                <div style="clear:both;"></div>

                                <?php if ($this->session->userdata('logged_as') == 'user') { ?>

                                    <?php

                                    $po_accept_option_arr = $this->ak->dost_po_accept_option();

                                    $po_reject_option_arr = $this->ak->dost_po_reject_option();

                                    $po_sampling_option_arr = $this->ak->dost_po_sampling_option();

                                    $po_sample_option_arr = $this->ak->dost_po_sample_complete_option();

                                    $po_sample_final_option_arr = $this->ak->dost_po_sample_final_option();

                                    $adata = $this->ak->get_cust_po_accept(@$podata['poeno']);

                                    if (count($adata) > 0) {
                                        echo '<table class="table table-striped border-top no-footer">
                                            <tr>
                                                <th colspan="8">
                                                    <div class="form-group col-lg-12">
                                                        <label for="item_uom" class="text-danger">Accept Details (' . count($adata) . ')</label>
                                                    </div>
                                                </th>
                                            </tr>';

                                        echo '<tr>
                                                <td>ID</td>
                                                <td>Status</td>
                                                <td>Option</td>
                                                <td>Remarks</td>
                                                <td>User</td>
                                                <td>Date</td>
                                            </tr>';
                                        $x = 1;
                                        foreach ($adata as $row) {

                                            $flag = '<a class="btn btn-xs btn-' . (($x == 1) ? 'success' : 'danger') . '"><b>S</b></a>';

                                            echo '<tr>
                                                <td>' . $row['a_id'] . '</td>
                                                <td>' . $flag . '</td>
                                                <td>' . @$po_accept_option_arr[@$row['a_option'] - 1]['option'] . '</td>
                                                <td>' . $row['a_remarks'] . '</td>
                                                <td>' . $row['a_user'] . '</td>
                                                <td>' . date("d-F-Y", strtotime($row['a_date'])) . '</td>
                                            </tr>';
                                            $x++;
                                        }
                                        echo '</table><div style="clear:both;"></div>';
                                    }

                                    $sdata = $this->ak->get_cust_po_sample(@$podata['poeno']);

                                    if (count($sdata) > 0) {
                                        echo '<table class="table table-striped border-top no-footer">
                                            <tr>
                                                <th colspan="8">
                                                    <div class="form-group col-lg-12">
                                                        <label for="item_uom" class="text-danger">Sample Details (' . count($sdata) . ')</label>
                                                    </div>
                                                </th>
                                            </tr>';

                                        echo '<tr>
                                                <td>ID</td>
                                                <td>Status</td>
                                                <td>Option</td>
                                                <td>Remarks</td>
                                                <td>Final Remarks</td>
                                                <td>User</td>
                                                <td>Date</td>
                                            </tr>';
                                        foreach ($sdata as $row) {

                                            $flag = '<a class="btn btn-xs btn-' . ((@$row['s_status'] == 3) ? 'success' : ((@$row['s_option'] > 0 && @$row['s_status'] == 1) ? 'warning' : ((@$row['s_status'] == 1 && @$row['s_option'] == 0) ? 'danger' : ((@$row['s_status'] == 2) ? 'primary' : ((@$row['s_status'] == 4) ? 'successblue' : 'danger'))))) . '"><b>S</b></a>';

                                            echo '<tr>
                                                <td>' . $row['s_id'] . '</td>
                                                <td>' . $flag . '</td>
                                                <td>' . @$po_sample_option_arr[@$row['s_option'] - 1]['option'] . '</td>
                                                <td>' . $row['s_remarks'] . '</td>
                                                <td>' . $row['s_final_remarks'] . '</td>
                                                <td>' . $row['s_user'] . '</td>
                                                <td>' . date("d-F-Y", strtotime($row['s_date'])) . '</td>
                                            </tr>';
                                        }
                                        echo '</table><div style="clear:both;"></div>';
                                    }

                                    $rdata = $this->ak->get_cust_po_reject(@$podata['poeno']);

                                    if (count($rdata) > 0) {
                                        echo '<table class="table table-striped border-top no-footer">
                                            <tr>
                                                <th colspan="8">
                                                    <div class="form-group col-lg-12">
                                                        <label for="item_uom" class="text-danger">Reject Details (' . count($rdata) . ')</label>
                                                    </div>
                                                </th>
                                            </tr>';

                                        echo '<tr>
                                                <td>ID</td>
                                                <td>Status</td>
                                                <td>Option</td>
                                                <td>Remarks</td>
                                                <td>User</td>
                                                <td>Date</td>
                                            </tr>';
                                        foreach ($rdata as $row) {

                                            echo '<tr>
                                                <td>' . $row['r_id'] . '</td>
                                                <td><a class="btn btn-xs btn-danger"><i class="icon-flag"></i></a></td>
                                                <td>' . @$po_reject_option_arr[@$row['r_option'] - 1]['option'] . '</td>
                                                <td>' . $row['r_remarks'] . '</td>
                                                <td>' . $row['r_user'] . '</td>
                                                <td>' . date("d-F-Y", strtotime($row['r_date'])) . '</td>
                                            </tr>';
                                        }
                                        echo '</table><div style="clear:both;"></div>';
                                    }

                                    ?>

                                    <div class="form-group col-lg-12">
                                        <label for="item_uom" class="text-danger">Sampling Status : </label>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-3">
                                        <label>Sample Sent Date : </label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Remarks : </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Status : </label> Pending
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-12">
                                        <label for="item_uom" class="text-danger">Processing Status : </label>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-3">
                                        <label>Date : </label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Remarks : </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Status : </label> Pending
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-12">
                                        <label for="item_uom" class="text-danger">Finishing, Checking & Packing Status : </label>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-3">
                                        <label>Date : </label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Remarks : </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Status : </label> Pending
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-12">
                                        <label for="item_uom" class="text-danger">Invoice & Payment Status : </label>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-3">
                                        <label>Invoice No. : </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Date : </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Item Qty. : </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Invoice Amt. in Rs. : </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Payment Recd. in Rs. : </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Payment Status : </label> Pending
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-12">
                                        <a onclick="window.history.back();" class="btn btn-danger">Back</a>
                                        <a href="<?= base_url(); ?>#" class="btn btn-danger">Send Mail</a>
                                    </div>

                                <?php } ?>

                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
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

    <script>
        //owl carousel

        $(document).ready(function() {
            $("#owl-demo").owlCarousel({
                navigation: true,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true
            });

            jQuery(".shade-select").on('change', function() {
                jQuery("#shade_id").select2("val", jQuery(this).val());
                jQuery("#shade_code").select2("val", jQuery(this).val());
                return false;
            });

            function getModuleItems(id) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>customer_purchase_order/po_from_customers_items_by_module/" + id,
                    success: function(res) {
                        //console.log(data);
                        var data = JSON.parse(res);
                        var options = '<option value="">Select</option>';
                        $.each(data, function(i, item) {
                            //alert(data[i].PageName);
                            var sel = '';
                            <?php if (@$podata['item_id']) { ?>
                                sel = (data[i].item_id == <?= @$podata['item_id']; ?>) ? ' selected="true" ' : '';
                            <?php } ?>
                            options += '<option value="' + data[i].item_id + '" ' + sel + '>' + data[i].item_name + ' - ' + data[i].item_id + '</option>';
                            //console.log(data[i]);
                        });

                        $("#item_id").select2('destroy');
                        $("#item_id").html(options);
                        $("#item_id").select2();
                    }
                });
            }

            var ids = jQuery("#module_id").val();
            if (ids != null) {
                getModuleItems(ids);
            }

            jQuery("#module_id").on('change', function() {
                var id = $(this).val();
                //console.log(id);
                if (id == 'null') {
                    alert('Dear Customer,\n\nYou are not authorised to use this module. If you want to place order in this product,\n\nPlease contact our admin or send message at +91-98432-40123 or send email at mahesh.dynamic@gmail.com, purohit.dynamic@gmail.com');
                } else {
                    getModuleItems(id);
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

    <style>
        .form-group {
            font-size: 18px;
        }

        .form-group label {
            font-size: 15px;
        }
    </style>

</body>

</html>