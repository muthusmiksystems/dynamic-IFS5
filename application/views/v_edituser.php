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
                                <h3><i class="icon-map-marker"></i> Add New User</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Employee Details
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

                                $form_action = 'updateuser';
                                $form_button = 'Update';
                                $field_active = true;
                                if ($this->uri->segment(4) !== false) {
                                    $form_action = 'saveuser';
                                    $form_button = 'Save';
                                    $field_active = false;
                                }

                                foreach ($users as $user) {
                                    $ID = $user['ID'];
                                    $user_category = $user['user_category'];
                                    $user_login = $user['user_login'];
                                    $user_pass = $user['user_pass'];
                                    $user_nicename = $user['user_nicename'];
                                    $user_email = $user['user_email'];
                                    $user_registered = $user['user_registered'];
                                    $user_status = $user['user_status'];
                                    $display_name = $user['display_name'];
                                    $user_address = $user['user_address'];
                                    $user_city = $user['user_city'];
                                    $user_pincode = $user['user_pincode'];
                                    $user_phone = $user['user_phone'];
                                    $user_mobile = $user['user_mobile'];
                                    $user_dateofjoin = $user['user_dateofjoin'];
                                    $user_dateofbirth = $user['user_dateofbirth'];
                                    $user_photo = $user['user_photo'];
                                }
                                $dj = explode("-", $user_dateofjoin);
                                $user_dateofjoin = $dj[2] . '-' . $dj[1] . '-' . $dj[0];
                                $db = explode("-", $user_dateofbirth);
                                $user_dateofbirth = $db[2] . '-' . $db[1] . '-' . $db[0];

                                $categories = $this->m_masters->getallmaster('bud_user_category');
                                asort($categories);
                                ?>
                                <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?= base_url(); ?>users/<?= $form_action; ?>">
                                    <input type="hidden" name="ID" value="<?= $ID; ?>">
                                    <?php
                                    if (!$field_active) {
                                    ?>
                                        <input type="hidden" name="dupUID" value="<?= $ID; ?>">
                                    <?php
                                    }
                                    if ($user_photo != '') {
                                    ?>
                                        <div class="form-group col-lg-12">
                                            <img src="<?= base_url(); ?>uploads/users/<?= $user_photo; ?>" width="140" height="140">
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="form-group col-lg-6">
                                        <label for="user_category" class="control-label col-lg-2">Category</label>
                                        <div class="col-lg-10">
                                            <select class="form-control select2" id="user_category" name="user_category" required>
                                                <option>Select Category</option>
                                                <?php
                                                foreach ($categories as $row) {
                                                ?>
                                                    <option value="<?= $row['category_id']; ?>" <?= ($row['category_id'] == $user_category) ? 'selected="selected"' : ''; ?>><?= $row['category_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select> </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="display_name" class="control-label col-lg-2">Name</label>
                                        <div class="col-lg-10">
                                            <input class="form-control" id="display_name" name="display_name" value="<?= $display_name; ?>" type="text" required> </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_nicename" class="control-label col-lg-2">Nicename</label>
                                        <div class="col-lg-10">
                                            <input class="form-control" id="user_nicename" name="user_nicename" value="<?= $user_nicename; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_login" class="control-label col-lg-2">Username</label>
                                        <div class="col-lg-10">
                                            <div class="input-group m-bot15">
                                                <span class="input-group-addon"><i class=" icon-user"></i></span>
                                                <input type="hidden" name="old_user_login" value="<?= $user_login; ?>">
                                                <input class="form-control" id="user_login" name="user_login" type="text" value="<?= ($field_active) ? $user_login : ''; ?>" autocomplete="off" required> </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_pass" class="control-label col-lg-2">Password</label>
                                        <div class="col-lg-10">
                                            <div class="input-group m-bot15">
                                                <span class="input-group-addon"><i class="icon-key"></i></span>
                                                <input class="form-control" id="user_pass" name="user_pass" value="<?= ($field_active) ? $this->encrypt->decode($user_pass) : ''; ?>" type="password" autocomplete="off" required> </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="user_email" class="control-label col-lg-2">Email</label>
                                        <div class="col-lg-10">
                                            <div class="input-group m-bot15">
                                                <span class="input-group-addon"><i class="icon-envelope-alt"></i></span>
                                                <input type="hidden" name="old_user_email" value="<?= $user_email; ?>">
                                                <input class="form-control" id="user_email" name="user_email" value="<?= ($field_active) ? $user_email : ''; ?>" type="email" required> </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="user_address" class="control-label col-lg-2">Address</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control " id="user_address" name="user_address"><?= $user_address; ?></textarea> </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_city" class="control-label col-lg-2">City</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="user_city" name="user_city" value="<?= $user_city; ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_pincode" class="control-label col-lg-2">Pincode</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="user_pincode" name="user_pincode" value="<?= $user_pincode; ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_phone" class="control-label col-lg-2">Phone No</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="user_phone" name="user_phone" value="<?= $user_phone; ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_mobile" class="control-label col-lg-2">Mobile No</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="user_mobile" name="user_mobile" value="<?= $user_mobile; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_dateofjoin" class="control-label col-lg-2">Date of join</label>
                                        <div class="col-lg-10">
                                            <input class="datepicker form-control" id="user_dateofjoin" name="user_dateofjoin" value="<?= $user_dateofjoin; ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_dateofbirth" class="control-label col-lg-2">Date of bith</label>
                                        <div class="col-lg-10">
                                            <input class="datepicker form-control" id="user_dateofbirth" name="user_dateofbirth" value="<?= $user_dateofbirth; ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="user_status" class="control-label col-lg-2">Active</label>
                                        <div class="">
                                            <input type="checkbox" style="width: 20px;float:left;" <?= ($user_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="user_status" name="user_status" />
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="user_photo">Photo</label>
                                        <input type="hidden" name="old_user_photo" value="<?= $user_photo; ?>">
                                        <input class="form-control" id="user_photo" name="user_photo" type="file">
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-lg-6">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" type="submit"><?= $form_button; ?></button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
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
    </script>

</body>

</html>