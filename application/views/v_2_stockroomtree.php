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
                                <h3><i class="icon-user"></i> Stock Room Building Tree</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $concern_id = '';
                        $stock_room_name = '';
                        $stock_room_status = '';
                        $editstock_roomblock = array();
                        if (isset($stock_room_id)) {
                            $editstock_rooms = $this->m_masters->getmasterdetails('dost_stock_room_manager', 'id', $stock_room_id);
                            foreach ($editstock_rooms as $room) {
                                $stock_room_name = $room['building_name'];
                                $stock_room_status = $room['status'];
                                $concern_id = $room['concern_id'];
                            }
                            $editstock_roomblock = $this->m_masters->getmasterdetails('dost_stock_block', 'stock_room_id', $stock_room_id);
                        } else {
                            $stock_room_id = '';
                        }
                        ?>

                        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/stockroomtreemanager">
                            <section class="panel">
                                <header class="panel-heading">
                                    Stock Room Building Tree
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
                                                Success!
                                            </h4>
                                            <p><?= $this->session->flashdata('success'); ?></p>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <input type="hidden" name="stock_room_id" value="<?= $stock_room_id; ?>">

                                    <div class="form-group">
                                        <label for="building_name" class="control-label col-lg-2">Building</label>
                                        <div class="col-lg-10">
                                            <select class="form-control select2" name="building_name" id="building_name">
                                                <option value="">Select</option>
                                                <?php if (sizeof($stock_rooms) > 0) : ?>
                                                    <?php foreach ($stock_rooms as $row) : ?>
                                                        <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $stock_room_id) ? 'selected="selected"' : ''; ?>><?php echo $row['building_name']; ?> - <?= $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $row['concern_id'], 'concern_name'); ?></option>
                                                    <?php endforeach ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                    $classglobal = 'col-lg-';
                                    $t = 0;
                                    if ($editstock_roomblock) {
                                        foreach ($editstock_roomblock as $block) {
                                            if ($block['status'] == false) {
                                                continue;
                                            }
                                            $t++;
                                        }
                                    }
                                    ?>
                                    <div class="form-group <?= $classglobal; ?>">
                                        <div class="<?= $classglobal; ?>11">
                                            <?= $stock_room_name; ?> - <?= $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_id, 'concern_name'); ?>
                                        </div>
                                        <div class="<?= $classglobal; ?>1">
                                            Blocks <?= $t; ?>
                                        </div>
                                    </div>
                                    <?php
                                    if ($editstock_roomblock) {
                                        foreach ($editstock_roomblock as $block) {
                                            if ($block['status'] == false) {
                                                continue;
                                            }

                                            $roomracks = $this->m_masters->getmasterdetails('dost_stock_rack', 'block_id', $block['id']);
                                    ?>
                                            <div class="form-group <?= $classglobal; ?>">
                                                <div class="<?= $classglobal; ?>1">
                                                    <?= $block['block_name']; ?>
                                                </div>
                                                <div class="<?= $classglobal; ?>11">
                                                    <?php
                                                    $k = 0;
                                                    if ($roomracks) {
                                                        foreach ($roomracks as $rack) {
                                                            if ($rack['status'] == false) {
                                                                continue;
                                                            }
                                                            $k++;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="<?= $classglobal; ?>11">
                                                        &nbsp;
                                                    </div>
                                                    <div class="<?= $classglobal; ?>1">
                                                        Rack <?= ($k) ? $k : 1; ?>
                                                    </div>
                                                    <?php
                                                    if ($roomracks) {
                                                        foreach ($roomracks as $rack) {
                                                            if ($rack['status'] == false) {
                                                                continue;
                                                            }
                                                            $aroomracks = $this->m_masters->getmasterdetails('dost_stock_room_box', 'rack_id', $rack['id']);
                                                    ?>
                                                            <div class="<?= $classglobal; ?>11">
                                                                <?= $rack['rack_name']; ?>
                                                            </div>
                                                            <div class="<?= $classglobal; ?>1">
                                                                Free Cell <?= $rack['rack_capacity'] - count($aroomracks); ?>
                                                            </div>
                                                            <div class="<?= $classglobal; ?>12">
                                                                <?php

                                                                if ($rack['rack_capacity']) {
                                                                    for ($i = 1; $i <= $rack['rack_capacity']; $i++) {
                                                                        $boxStatus = 'success';
                                                                        if ($i <= count($aroomracks)) {
                                                                            $boxStatus = 'danger';
                                                                        }
                                                                ?>
                                                                        <button class="btn btn-lg btn-<?= $boxStatus; ?>">&nbsp;<?= $i; ?>&nbsp;</button>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                </div>
                                <!-- Loading -->
                                <div class="pageloader"></div>
                                <!-- End Loading -->
                            </section>
                        </form>
                    </div>
                </div> <!-- page end-->
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


        $(document).ajaxStart(function() {
            $('.pageloader').show();
        });
        $(document).ajaxStop(function() {
            $('.pageloader').hide();
        });

        $(document).on("change", '#building_name', function() {
            var id = $(this).val();
            var url = window.location.origin + "/masters/stockroomtree/" + id;
            document.location = url;
        });
    </script>

</body>

</html>