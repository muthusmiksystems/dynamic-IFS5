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
                <h3><i class="icon-user"></i> Stock Room Master</h3>
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
            if (isset($stock_room_id)) {
              $editstock_rooms = $this->m_masters->getmasterdetails('bud_stock_rooms', 'stock_room_id', $stock_room_id);
              foreach ($editstock_rooms as $room) {
                $stock_room_name = $room['stock_room_name'];
                $stock_room_status = $room['stock_room_status'];
                $concern_id = $room['concern_id'];
              }
            } else {
              $stock_room_id = '';
              $stock_room_name = '';
              $stock_room_status = '';
              $concern_id = '';
            }
            ?>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/stockrooms_2_save">
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
                    <label for="stock_room_name" class="control-label col-lg-2">Godown Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="stock_room_name" name="stock_room_name" value="<?= $stock_room_name; ?>" type="text" required>
                    </div>
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
                Stock Rooms
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Concern</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  $modules_array = array(
                    '1' => 'Yarn & Thread',
                    '2' => 'Tapes & Elastic',
                    '3' => 'Labels',
                    '4' => 'Madical Tape',
                  );
                  foreach ($stock_rooms as $room) {
                    $module_id = $room['module_id'];
                  ?>
                    <tr class="odd gradeX">
                      <td><?= $sno; ?></td>
                      <td><?= $room['stock_room_name'] ?></td>
                      <td><?= $modules_array[$module_id]; ?></td>
                      <td>
                        <?php
                        $concern_name = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $room['concern_id'], 'concern_name');
                        echo $concern_name;
                        ?>
                      </td>
                      <td class="hidden-phone">
                        <span class="<?= ($room['stock_room_status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($room['stock_room_status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                      </td>
                      <td>
                        <a href="<?= base_url(); ?>masters/stockrooms_2/<?= $room['stock_room_id']; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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
  </script>

</body>

</html>