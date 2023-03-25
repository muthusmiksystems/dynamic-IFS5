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
                                            Success!
                                        </h4>
                                        <p><?= $this->session->flashdata('success'); ?></p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>

                        <!-- Start Talbe List  -->
                        <section class="panel">
                            <header class="panel-heading">
                                Customers
                            </header>
                            <table class="table table-striped border-top" id="sample_1">
                                <thead>
                                    <tr>
                                        <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                                        <th>Sno</th>
                                        <th>Cust. Code</th>
                                        <th>Customer Name</th>
                                        <th>email</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    foreach ($customers as $customer) {
                                        $u_modules = '';
                                        $c_modules = '';
                                        $g = '';
                                        $user_id = @$this->session->userdata('user_id');
                                        if ($user_id) {
                                            $userData = $this->m_users->getuserdetails($user_id);
                                            if ($userData) {
                                                $u_modules = explode(',', $userData[0]['user_access_modules']);
                                                $c_modules = explode(',', $customer['cust_category']);

                                                $result = array_intersect($u_modules, $c_modules);
                                                if (!$result) {
                                                    continue;
                                                }
                                            }
                                        }
                                    ?>
                                        <tr class="odd gradeX">
                                            <td><?= $sno; ?><br><?= $g; ?></td>
                                            <td><?= $customer['cust_id']; ?></td>
                                            <td><?= $customer['cust_name']; ?></td>
                                            <td><a href="mailto:<?= $customer['cust_email'] ?>"><?= $customer['cust_email'] ?></a></td>
                                            <td><?= $customer['cust_phone'] ?></td>
                                        </tr>
                                    <?php
                                        $sno++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </section>
                        <!-- End Talbe List  -->
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
        });

        //custom select box

        $(function() {
            $('select.styled').customSelect();
        });

        // Add Row
        $(function() {
            var scntDiv = $('#contacts');
            var i = $('#contacts .contactsrow').size() + 1;
            $(".addrow").live("click", function() {
                var nextrow = '<div class="form-group col-lg-12 contactsrow"><div class="col-lg-3"><input class="form-control"  name="cust_names[]" type="text" placeholder="Name, Designation"></div><div class="col-lg-3"><input class="form-control"  name="cust_contactnos[]" type="text" placeholder="Contact No"></div><div class="col-lg-3"><input class="form-control"  name="cust_emails[]" type="text" placeholder="Email"></div><div class="col-lg-3"><button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button></div></div>';
                $(nextrow).appendTo(scntDiv);
                i++;
                return false;
                alert(i); // jQuery 1.3+
            });
            $('.removerow').live('click', function() {
                if (i > 2) {
                    $(this).parents('#contacts .contactsrow').remove();
                    i--;
                }
                return false;
            });
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