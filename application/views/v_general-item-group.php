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
                <h3><i class="icon-user"></i> General Item Group</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <?php
            if (isset($group_id)) {
              $result = $this->m_masters->getmasterdetails('bud_general_item_groups', 'group_id', $group_id);
              foreach ($result as $row) {
                $group_name = $row['group_name'];
                $is_active = $row['is_active'];
              }
            } else {
              $group_id = '';
              $group_name = '';
              $is_active = '';
            }
            ?>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/generalItemGroupSave">
              <section class="panel">
                <header class="panel-heading">
                  Group Details
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
                  <input type="hidden" name="group_id" value="<?= $group_id; ?>">
                  <div class="form-group col-lg-4">
                    <label for="group_name">Group Name</label>
                    <input class="form-control" id="group_name" name="group_name" value="<?= $group_name; ?>" type="text" required>
                  </div>
                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-4">
                    <label for="is_active">Active</label>
                    <input type="checkbox" style="width: 20px;" <?= ($is_active == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="is_active" name="is_active" />
                  </div>
                </div>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit"><?= ($group_id != '') ? 'Update' : 'Save'; ?></button>
                  <button class="btn btn-default" type="button">Cancel</button>
                </header>
              </section>
            </form>
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
            <!-- Start Talbe List  -->
            <section class="panel">
              <header class="panel-heading">
                General Item Groups
              </header>
              <script>
                var data = [];
              </script>



              <table class="table table-striped border-top" id="sample_1x">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Group Name</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <?php
                $sno = 1;
                foreach ($itemgroups as $row) {
                  $category_names = array();
                  $group_id = $row['group_id'];
                  $group_name = $row['group_name'];
                  $is_active = $row['is_active'];

                  $status = '<span class="' . (($is_active == 1) ? 'label label-success' : 'label label-danger') . '">' . (($row['is_active'] == 1) ? 'Active' : 'Inactive') . '</span>';
                ?>

                  <script>
                    data.push(['<?= $sno; ?>', '<?= $group_name; ?>', '<?= $status; ?>', '<a href="<?= base_url(); ?>general/generalItemGroup/<?= $group_id; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a><a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>']);
                  </script>

                <?php
                  $sno++;
                }
                ?>
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
      $('#sample_1x').DataTable({
        'data': data,
        'deferRender': true,
        'processing': true,
        'language': {
          'loadingRecords': '&nbsp;',
          'processing': 'Loading...'
        },
        "order": [
          [0, "desc"]
        ]
      });
      jQuery('.dataTables_filter input').addClass("form-control");
      jQuery('.dataTables_filter').parent().addClass('col-sm-6');
      jQuery('.dataTables_length select').addClass("form-control");
      jQuery('.dataTables_length').parent().addClass('col-sm-6');

    });

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

    $("#add").click(function() {
      var $tableBody = $('#tbl').find("tbody"),
        $trFirst = $tableBody.find("tr:first"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trFirst.clone(true);
      $trLast.after($trNew);
      $trNew.find("input").val("");
      return false;
    });
    $('.remove-row').live('click', function() {
      $(this).closest('tr').remove();
    });
  </script>

</body>

</html>