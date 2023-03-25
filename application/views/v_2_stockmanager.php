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
                                <h3><i class="icon-user"></i> Stock Room Manager</h3>
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

                        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/stockroommanager_save">
                            <section class="panel">
                                <header class="panel-heading">
                                    Stock Room Details
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

                                    <div class="form-group col-lg-12">
                                        <label for="concern_id" class="control-label col-lg-2">Concern Name</label>
                                        <div class="col-lg-10">
                                            <select class="form-control select2" name="concern_id" id="concern_id">
                                                <option value="">Select</option>
                                                <?php if (sizeof($concerns) > 0) : ?>
                                                    <?php foreach ($concerns as $row) : ?>
                                                        <option value="<?php echo $row['concern_id']; ?>" <?php echo ($row['concern_id'] == $concern_id) ? 'selected="selected"' : ''; ?>><?php echo $row['concern_name']; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="stock_room_name" class="control-label col-lg-2">Building Name</label>
                                        <div class="col-lg-10">
                                            <input class="form-control" id="stock_room_name" name="stock_room_name" value="<?= $stock_room_name; ?>" type="text" required>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12 contacts">

                                        <div class="form-group col-lg-12">
                                            <div class="col-lg-9">
                                                <button type="button" class="btn btn-primary addrow"><i class="icon-plus"></i> Add</button>
                                            </div>
                                            <div class="col-lg-3">
                                                Blocks <label class="countBlocks"><?= count($editstock_roomblock); ?></label>
                                            </div>
                                        </div>
                                        <?php
                                        if ($editstock_roomblock) {
                                            foreach ($editstock_roomblock as $block) {
                                                if ($block['status'] == false) {
                                                    continue;
                                                }
                                        ?>
                                                <div class="form-group col-lg-12 contactsrow">
                                                    <div class="col-lg-3">
                                                        <input class="form-control" value="<?= $block['block_name']; ?>" name="blocks[<?= $block['id']; ?>]" type="text">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="form-group col-lg-12 contactsrow">
                                                <div class="col-lg-3">
                                                    <input class="form-control" value="Block" name="blocks[]" type="text">
                                                </div>
                                                <div class="col-lg-3">
                                                    <button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="stock_room_status" class="control-label col-lg-2">Active</label>
                                        <div class="">
                                            <input type="checkbox" style="width: 20px;float:left;" <?= ($stock_room_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="stock_room_status" name="stock_room_status" />
                                        </div>
                                    </div>

                                </div>
                                <!-- Loading -->
                                <div class="pageloader"></div>
                                <!-- End Loading -->
                            </section>
                            <section class="panel">
                                <header class="panel-heading">
                                    <button class="btn btn-danger" type="submit" <?= ($stock_room_id != '') ? 'name="update"' : 'save'; ?>><?= ($stock_room_id != '') ? 'Update' : 'Save'; ?></button>
                                    <button class="btn btn-default" type="button">Cancel</button>
                                </header>
                            </section>
                        </form>
                        <!-- Start Talbe List  -->
                        <section class="panel">
                            <header class="panel-heading">
                                Stock Room Manager
                            </header>
                            <table class="table table-striped border-top" id="sample_1">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Building Name</th>
                                        <th>Block Counts</th>
                                        <th>Concern</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    $sno = 1;
                                    foreach ($stock_rooms as $room) {
                                        $roomblocks = $this->m_masters->getmasterdetails('dost_stock_block', 'stock_room_id', $room['id']);
                                        $s = 0;
                                        if ($roomblocks) {
                                            foreach ($roomblocks as $block) {
                                                if ($block['status'] == false) {
                                                    continue;
                                                }
                                                $s++;
                                            }
                                        }
                                    ?>
                                        <tr class="odd gradeX">
                                            <td><?= $sno; ?></td>
                                            <td><?= $room['building_name'] ?></td>
                                            <td><?= $s; ?></td>
                                            <td>
                                                <?php
                                                $concern_name = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $room['concern_id'], 'concern_name');
                                                echo $concern_name;
                                                ?>
                                            </td>
                                            <td class="hidden-phone">
                                                <span class="<?= ($room['status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($room['status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url(); ?>masters/stockroommanager/<?= $room['id']; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                                <a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
                                            </td>
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

        $(document).ready(function() {
            $(document).on("click", '.addrow', function() {
                var nextrow = '<div class="form-group col-lg-12 contactsrow"><div class="col-lg-3"><input class="form-control" value="Block" name="blocks[]" type="text"></div><div class="col-lg-3"><button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button></div></div>';
                var scntDiv = $(this).closest('.contacts');
                $(scntDiv).append(nextrow);
                $(".countBlocks").text($(this).closest('.contacts').find('.contactsrow').size());
                return false;
            });
            $(document).on("click", '.removerow', function() {
                var i = $(this).closest('.contacts').find('.contactsrow').size();
                if (i > 1) {
                    $(this).closest('.contactsrow').remove();
                    $(".countBlocks").text(i - 1);
                }
                return false;
            });
        });
    </script>

</body>

</html>