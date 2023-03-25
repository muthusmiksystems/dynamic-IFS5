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
    <link href='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css' type='text/css' rel='stylesheet'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js' type='text/javascript'></script>

    <style>
        .contentx {
            width: 100%;
            padding: 5px;
            margin: 0 auto;
            height: 100px;
            border: 1px red;
        }

        .contentx span {
            width: 250px;
        }

        .dz-message {
            text-align: center;
            font-size: 28px;
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

                <?php
                $podata = [];
                $sublink = 'po_from_customers_enquiry_save';
                $remarks_status = ' ';
                $remarks2_status = false;
                if (!empty($this->uri->segment(3))) {
                    $podata = $this->ak->get_cust_po_enquiry($this->uri->segment(3));
                    $podata = $podata[0];
                }
                if (!empty($this->uri->segment(4))) {
                    if (@$this->uri->segment(4) == 'edit') {
                        $sublink = 'po_from_customers_enquiry_update/' . @$podata['poeno'];
                        $next = @$podata['poeno'];
                        if ($this->session->userdata('logged_as') == 'user') {
                            $remarks_status = ' readonly ';
                        }
                        $remarks2_status = true;
                    }
                }

                $secretInfo = false;
                $user_category = @$this->session->userdata('user_category');
                if ($user_category == 9 || $user_category == 10 || $user_category == 11 || $user_category == 12) {
                    $secretInfo = true;
                }
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <form class="cmxform form-horizontal tasi-form dropzone" role="form" id="commentForm" method="post" action="<?= base_url(); ?>customer_purchase_order/<?= $sublink; ?>">
                            <section class="panel">
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
                                        <label>PO Enquiry No:</label>
                                        <span class="label label-danger" style="padding: 0 1em;font-size:24px;"><?= $next; ?></span>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_name"><i class="text-danger">* These are required fields.</i></label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="sales_to">Customer</label>
                                        <input type="hidden" name="cust_id" value="<?= (@$podata['cust_id'] != '') ? @$podata['cust_id'] : (($secretInfo) ? '570' : $this->session->userdata('user_id')); ?>">
                                        <input type="text" class="form-control" id="customer" readonly="true" value="<?= (@$podata['cust_name'] != '') ? @$podata['cust_name'] : (($secretInfo) ? 'Company Stock' : $this->session->userdata('display_name')); ?>">
                                    </div>

                                    <?php
                                    $cuid = (@$podata['cust_id'] != '') ? @$podata['cust_id'] : (($secretInfo) ? '570' : $this->session->userdata('user_id'));
                                    $customerArr = $this->m_masters->getcustomerdetails($cuid);
                                    $cust_category = @explode(",", $customerArr[0]['cust_category']);
                                    ?>

                                    <div class="form-group col-lg-3">
                                        <label for="module_id">Select Product <i class="text-danger">*</i></label>
                                        <select class="form-control select2" required name="module_id" id="module_id" required>
                                            <option value="">Select</option>
                                            <?php
                                            $x = 1;
                                            foreach ($categories as $category) {
                                                //if (in_array($category['category_id'], $cust_category)) {
                                            ?>
                                                <option value="<?= (in_array($category['category_id'], $cust_category)) ? $category['category_id'] : 'd' . $x; ?>" <?= (@$podata['module_id'] == $category['category_id']) ? 'selected="true"' : ''; ?>><?= $category['category_name']; ?>/ M<?= $category['category_id']; ?></option>
                                            <?php
                                                //}
                                                $x++;
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="item_id">Item name <i class="text-danger">(opt. for repeat orders)</i></label>
                                        <select class="select2 form-control itemsselects" name="item_id" id="item_id">
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($items as $row) {
                                            ?>
                                                <option value="<?= $row['item_id']; ?>"><?= $row['item_name'] . " - " . $row['item_id']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-3">
                                        <label for="cust_item_name">Customer Item Name <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" name="cust_item_name" id="cust_item_name" value="<?= @$podata['cust_item_name']; ?>" required>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="cust_color_name">Customer Colour Name <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" name="cust_color_name" id="cust_color_name" value="<?= @$podata['cust_color_name']; ?>" required>
                                    </div>
                                  
                                    
                    <?php
                    $shades = $this->m_masters->getallmaster('bud_shades');
                    $shade_ids = '';
                    $shade_code = '';
                    if (sizeof($shades) > 0) :
                        foreach ($shades as $row) :
                            $selectop = ' ';
                            if (@$filter['filter_shade_id'] == $row['shade_id']) {
                                $selectop = ' selected="true" ';
                            }
                            $shade_ids .= '<option value="' . $row['shade_id'] . '" ' . $selectop . '>' . $row['shade_name'] . '/' . $row['shade_id'] . '</option>';
                            $shade_code .= '<option value="' . $row['shade_id'] . '" ' . $selectop . '>' . $row['shade_code'] . '</option>';
                        endforeach;
                    endif; ?>

                    <div class="form-group col-lg-3">
                        <label for="filter_shade_id">Colour Name/Code <i class="text-danger">(opt. for repeat orders)</i></label>
                        <select class="select2 filter-shade-select itemsselects form-control" name="shade_id" id="filter_shade_id">
                            <option value="">Select</option>
                            <?php echo $shade_ids; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="filter_shade_code">Colour No <i class="text-danger">(opt. for repeat orders)</i></label>
                        <select class="select2 filter-shade-select itemsselects form-control"  name="color_no" id="filter_shade_code">
                            <option value="">Select</option>
                            <?php echo $shade_code; ?>
                        </select>
                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-2">
                                        <label for="po_price">Price Before GST <i class="text-danger">(opt.)</i></label>
                                        <input type="text" class="form-control" name="po_price" id="po_price" style="font-size: 20px" value="<?= @$podata['po_price']; ?>">
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="po_qty">PO Qty <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" name="po_qty" id="po_qty" style="font-size: 20px" value="<?= @$podata['po_qty']; ?>" required>
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="po_uom">UOM <i class="text-danger">*</i></label>
                                        <select class="select2 form-control" name="po_uom" id="po_uom" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($uoms as $row) {
                                            ?>
                                                <option value="<?= $row['uom_id']; ?>" <?= (@$podata['po_uom'] == $row['uom_id']) ? 'selected="true"' : ''; ?>><?= $row['uom_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="po_need_date">Need Date <i class="text-danger">(opt.)</i></label>
                                        <input type="text" class="form-control datepluginmin" name="po_need_date" id="po_need_date" style="font-size: 20px" value="<?= (@$podata['po_need_date'] != '') ? date("d-m-Y", strtotime(@$podata['po_need_date'])) : date("d-m-Y", strtotime("+10 day")); ?>">
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-4">
                                        <label for="remarks">Remarks <i class="text-danger">(opt.)</i></label>
                                        <textarea class="form-control" rows="3" name="remarks" id="remarks" <?= $remarks_status; ?>><?= ($secretInfo && @$podata['remarks'] == '') ? 'PO For Factory Stock Only' : @$podata['remarks']; ?></textarea>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-3">
                                        <label for="item_uom" class="text-danger">
                                            <?= ($secretInfo) ? 'Factory PO Sent By Staff:' : 'PO Enquiry Sent By Staff on Behalf of Customer:'; ?>
                                        </label>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-3">
                                        <label for="cust_staff_name">Name <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" placeholder="Mahesh Bhardwaj, Purchase Dept." name="cust_staff_name" id="cust_staff_name" value="<?= @$podata['cust_staff_name']; ?>" required>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="cust_staff_mobile">Mobile <i class="text-danger">*</i></label>
                                        <input type="text" placeholder="9843240123" class="form-control" name="cust_staff_mobile" id="cust_staff_mobile" value="<?= @$podata['cust_staff_mobile']; ?>" required>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="cust_staff_email">E-Mail ID <i class="text-danger">(opt.)</i></label>
                                        <input type="text" class="form-control" placeholder="mahesh@dynamicdost.com" name="cust_staff_email" id="cust_staff_email" value="<?= @$podata['cust_staff_email']; ?>">
                                    </div>

                                    <div style="clear:both;"></div>

                                    <?php if ($remarks2_status) { ?>
                                        <?php if ($this->session->userdata('logged_as') == 'user') { ?>
                                            <div class="form-group col-lg-4">
                                                <label for="remarkstocust">Message From Factory <i class="text-danger">(opt.)</i></label>
                                                <textarea class="form-control" rows="3" name="remarkstocust" id="remarkstocust"><?= @$podata['remarkstocust']; ?></textarea>
                                            </div>
                                            <div style="clear:both;"></div>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if ($secretInfo && @$podata['company_stock_active'] == 1) { ?>
                                        <div class="form-group col-lg-4">
                                            <label for="remarkstocust">Production For Company Stock<br>Active <i class="text-danger">(opt.)</i></label>
                                            <input type="checkbox" name="company_stock_active" id="company_stock_active" value="1" />
                                        </div>
                                        <div style="clear:both;"></div>
                                    <?php } ?>

                                    <div class='form-group col-lg-12'>
                                        <div class="fallback">
                                            <input name="file" type="file" id="fileUpload" accept="image/*" />
                                        </div>
                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="form-group col-lg-12">
                                        <input type="submit" class="btn btn-danger" name="save" value="Save" />
                                    </div>

                                </div>
                                <!-- Loading -->
                                <div class="pageloader"></div>
                                <!-- End Loading -->
                            </section>
                        </form>
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

            $("#fileUpload").dropzone({
                acceptedFiles: 'image/*',
                maxFilesize: 2
            });

            $("#owl-demo").owlCarousel({
                navigation: true,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true
            });

            jQuery(".shade-select").change(function() {
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
            if (ids != '') {
                getModuleItems(ids);
            }

            jQuery("#module_id").on('change', function() {
                var id = $(this).val();
                var options = '<option value="">Select</option>';
                $("#item_id").select2('destroy');
                $("#item_id").html(options);
                $("#item_id").select2();

                if (id == 'd1' || id == 'd2' || id == 'd3' || id == 'd4') {

                    alert('Dear Customer,\n\nYou are not authorised to use this module. If you want to place order in this product,\n\nPlease contact our admin or send message at +91-98432-40123 or send email at mahesh.dynamic@gmail.com, purohit.dynamic@gmail.com');

                    return false;
                } else {
                    getModuleItems(id);
                }
            });

            // jQuery("#po_need_date").on('click', function() {
            //     var TodayDate = new Date();
            //     var endDate = new Date(Date.parse($(this).val()));

            //     if (endDate < TodayDate) {
            //         alert("Date should be greater than today.!!!");
            //     }
            // });
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