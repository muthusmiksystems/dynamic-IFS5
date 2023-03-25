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
                <h3><i class="icon-map-marker"></i> Item Group Master</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Item Group Details
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
                <?php
                if (isset($group_id)) {
                  $editgroups = $this->m_masters->getmasterdetails('bud_lbl_itemgroups', 'group_id', $group_id);
                  foreach ($editgroups as $group) {
                    $group_id = $group['group_id'];
                    $group_category = $group['group_category'];
                    $group_name = $group['group_name'];
                    $group_second_name = $group['group_second_name'];
                    $group_status = $group['group_status'];
                  }
                } else {
                  $group_id = '';
                  $group_category = '';
                  $group_name = '';
                  $group_second_name = '';
                  $group_status = '';
                }
                ?>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/save_itemgroups_3">
                  <input type="hidden" name="group_id" value="<?= $group_id; ?>">
                  <div class="form-group col-lg-12">
                    <label for="group_name" class="control-label col-lg-2">Group Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="group_name" name="formData[group_name]" value="<?= $group_name; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-12">
                    <label for="group_second_name" class="control-label col-lg-2">Group Second Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="group_second_name" name="formData[group_second_name]" value="<?= $group_second_name; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-12">
                    <label for="group_status" class="control-label col-lg-2">Active</label>
                    <div class="col-lg-10">
                      <input type="checkbox" style="width: 20px;float:left;" <?= ($group_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="group_status" name="formData[group_status]" />
                    </div>
                  </div>
                  <div class="clear"></div>
                  <div class="form-group col-lg-12">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button class="btn btn-danger" type="submit"><?= ($group_id != '') ? 'Update' : 'Save'; ?></button>
                      <button class="btn btn-default" type="button">Cancel</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>

            <!-- Start Talbe List  -->
            <section class="panel">
              <header class="panel-heading">
                Summery
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <th>Group No</th>
                    <th>Group Name</th>
                    <th>Group Second Name</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  /*echo '<pre>';
                              print_r($itemgroups);
                              echo '</pre>';*/
                  $sno = 1;
                  foreach ($itemgroups as $itemgroup) {
                  ?>
                    <tr class="odd gradeX">
                      <td><?= $sno; ?></td>
                      <td><?= $itemgroup['group_name']; ?></td>
                      <td><?= $itemgroup['group_second_name']; ?></td>
                      <td>
                        <span class="<?= ($itemgroup['group_status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($itemgroup['group_status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                      </td>
                      <td>
                        <a href="<?= base_url(); ?>masters/itemgroups_3/<?= $itemgroup['group_id'] ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                        <a href="<?= base_url(); ?>masters/deletemaster/bud_lbl_itemgroups/group_id/<?= $itemgroup['group_id'] ?>/itemgroups_3" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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
  </script>

</body>

</html>