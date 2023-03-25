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
                <h3><i class="icon-user"></i> Raw Material & POY Denier Master</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <?php
            if (isset($denier_id)) {
              $editdeniers = $this->m_masters->getmasterdetails('bud_yt_poydeniers', 'denier_id', $denier_id);
              foreach ($editdeniers as $color) {
                $sup_group_id = $color['sup_group_id'];
                $supplier_id = $color['supplier_id'];
                $denier_name = $color['denier_name'];
                $denier_tech = $color['denier_tech'];
                $denier_status = $color['denier_status'];
              }
            } else {
              $denier_id = '';
              $sup_group_id = '';
              $supplier_id = '';
              $denier_name = '';
              $denier_tech = '';
              $denier_status = '';
            }
            $suppliers = $this->m_masters->getmasterdetails('bud_suppliers', 'sup_group', $sup_group_id, $this->session->userdata('user_viewed'));
            ?>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>poy/poydenier_save">
              <section class="panel">
                <header class="panel-heading">
                  Details
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
                  <input type="hidden" name="denier_id" value="<?= $denier_id; ?>">
                  
                  <div class="form-group col-lg-12">
                    <label for="sup_group_id" class="control-label col-lg-2">Raw Material Supplier Group</label>
                    <div class="col-lg-10">
                      <select class="select2 form-control" id="sup_group_id" name="sup_group_id" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($supplier_groups as $row) {
                        ?>
                          <option value="<?= $row['group_id']; ?>" <?= ($row['group_id'] == $sup_group_id) ? 'selected="selected"' : ''; ?>><?= $row['group_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-12">
                    <label for="supplier_id" class="control-label col-lg-2">Raw Material Supplier</label>
                    <div class="col-lg-10">
                      <select class="select2 form-control" id="supplier_id" name="supplier_id" required>
                        <?php
                        foreach ($suppliers as $row) {
                        ?>
                          <option value="<?= $row['sup_id']; ?>" <?= ($row['sup_id'] == $supplier_id) ? 'selected="selected"' : ''; ?>><?= $row['sup_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-12">
                    <label for="denier_name" class="control-label col-lg-2">Raw Material & POY Denier Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="denier_name" name="denier_name" value="<?= @explode(' / ', $denier_name)[0]; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-12">
                    <label for="denier_tech" class="control-label col-lg-2">Raw Material Description & POY Technical Denier</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="denier_tech" name="denier_tech" value="<?= $denier_tech; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-12">
                    <label for="denier_postfix" class="control-label col-lg-2">Postfix (Supplier)</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="denier_postfix" name="denier_postfix" value="<?= @explode(' / ', $denier_name)[1]; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-12">
                    <label for="denier_status" class="control-label col-lg-2">Active</label>
                    <div class="">
                      <input type="checkbox" style="width: 20px;float:left;" <?= ($denier_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="denier_status" name="denier_status" />
                    </div>
                  </div>
                </div>
                <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit" <?= ($denier_id != '') ? 'name="update"' : 'save'; ?>><?= ($denier_id != '') ? 'Update' : 'Save'; ?></button>
                  <button class="btn btn-default" type="button">Cancel</button>
                </header>
              </section>
            </form>
            <!-- Start Talbe List  -->
            <section class="panel">
              <header class="panel-heading">
                Deniers
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>Raw Material<br>POY Denier / Supplier Postfix</th>
                    <th>Raw Material Description<br>POY Technical Dn</th>
                    <?php /*
                    <th>Group</th>
                    <th>Supplier</th>
                    */ ?>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($poydeniers as $denier) {
                  ?>
                    <tr class="odd gradeX">
                      <td><?= $sno; ?></td>
                      <td><?= $denier['denier_name']; ?></td>
                      <td><?= $denier['denier_tech']; ?></td>
                      <td><?= $denier['group_name']; ?></td>
                      <td><?= $denier['sup_name']; ?></td>
                      <td class="hidden-phone">
                        <span class="<?= ($denier['denier_status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($denier['denier_status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                      </td>
                      <td>
                        <a href="<?= base_url(); ?>poy/poydenier/<?= $denier['denier_id']; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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


    $(document).ajaxStart(function() {
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });

    $(function() {
      $("#sup_group_id").change(function() {
        var sup_group_id = $('#sup_group_id').val();
        var url = "<?= base_url() ?>poy/getsuppliers/" + sup_group_id;
        var postData = 'sup_group_id=' + sup_group_id;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            $("#supplier_id").html('');
            $("#supplier_id").select2("val", '');
            $("#supplier_id").html(result);
          }
        });
        return false;
      });
    });
  </script>

</body>

</html>