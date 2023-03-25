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
            $logged_user_id = $this->session->userdata('user_id');
            ?>

            <?php
            foreach ($cust_details as $cust_detail) {
              $cust_id = $cust_detail['cust_id'];
              $cust_username = $cust_detail['cust_username'];
              $cust_password = $cust_detail['cust_password'];
            }
            ?>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>users/update_cust_password">
              <section class="panel">
                <header class="panel-heading">
                  Login Details
                </header>

                <div class="panel-body">
                  <input type="hidden" name="cust_id" value="<?= $cust_id; ?>">
                  <div class="form-group col-lg-12">
                    <label for="cust_username" class="control-label col-lg-2">User Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_username" name="cust_username" value="<?= $cust_username; ?>" type="text" required placeholder="Username" disabled="disabled">
                    </div>
                  </div>
                  <div class="form-group col-lg-12">
                    <label for="cust_password" class="control-label col-lg-2">Password</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_password" name="cust_password" value="<?= $cust_password; ?>" type="text" required placeholder="Password">
                    </div>
                  </div>
                </div>
                <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit" <?= ($cust_id != '') ? 'name="update"' : 'save'; ?>><?= ($cust_id != '') ? 'Update' : 'Save'; ?></button>
                  <button class="btn btn-default" type="button">Cancel</button>
                </header>
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
  <script type="text/javascript">
    $(".select2").select2();
  </script>
</body>

</html>