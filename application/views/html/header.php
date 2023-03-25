<?php
if ($this->session->flashdata('message')) {
    $message    = $this->session->flashdata('message');
}

if ($this->session->flashdata('error')) {
    $error  = $this->session->flashdata('error');
}

if (function_exists('validation_errors') && validation_errors() != '') {
    $error  = validation_errors();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="BUDNET">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="img/favicon.html">
    <title><?php echo $page_title; ?> | INDOFILA SYNTHETICS</title>

    <link href="<?php echo base_url(); ?>themes/default/css/invoice-style.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>themes/default/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/whirly.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/select2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/style-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet">
    <link href="<?php echo base_url('themes/default/assets/bootstrap-colorpicker/css/colorpicker.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/default/css/invoice-print.css" rel="stylesheet" media="print">
    <style type="text/css">
        #loading {
            top: 40%;
            overflow: hidden;
        }

        #loading .modal-content {
            background-color: transparent;
        }
    </style>
</head>

<body>

    <div class="modal fade" id="loading">
        <div class="modal-dialog" style="width:100px;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="whirly-loader">
                        Loading…
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="container" class="">
        <?php include 'v_header.php'; ?>
        <?php include 'v_sidebar.php'; ?>