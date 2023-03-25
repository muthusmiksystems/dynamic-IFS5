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

            <section class="panel">
              <header class="panel-heading">
                Users
              </header>
              <script>
                var data = [];
              </script>
              <table class="table table-striped border-top" id="sample_1x">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($users as $user) {
                    $actions = '';
                    $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
                    $delconfirm = "return confirm()";
                    if ($is_admin) {
                      $actions = '<a href="' . base_url() . 'users/manage_user_privileges/' . $user['ID'] . '" data-placement="top" data-original-title="Manage User Privileges" data-toggle="tooltip" class="btn btn-success btn-xs tooltips"><i class="icon-key"></i></a><a href="' . base_url() . 'users/edit/' . $user['ID'] . '" data-placement="top" data-original-title="Edit Profile" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a><a href="' . base_url() . 'users/edit/' . $user['ID'] . '/duplicate" data-placement="top" data-original-title="Duplicate Profile" data-toggle="tooltip" class="btn btn-warning btn-xs tooltips"><i class="icon-copy"></i></a><a href="' . base_url() . 'users/delete/' . $user['ID'] . '" data-placement="top" data-original-title="Delete Profile" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user" onclick="' . $delconfirm . '"><i class="icon-trash "></i></a>';
                    } else {
                      $is_edit_privileged = $this->m_users->is_privileged('edit', 'upriv_function', $logged_user_id);
                      if ($is_edit_privileged) {
                        $actions = '<a href="' . base_url() . 'users/edit/' . $user['ID'] . '" data-placement="top" data-original-title="Edit Profile" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>';
                      }
                      $is_delete_privileged = $this->m_users->is_privileged('delete', 'upriv_function', $logged_user_id);
                      if ($is_delete_privileged) {
                        $actions .= '<a href="' . base_url() . 'users/delete/' . $user['ID'] . '" data-placement="top" data-original-title="Delete Profile" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user" onclick="' . $delconfirm . '"><i class="icon-trash "></i></a>';
                      }
                    }
                    $img = '';
                    if ($user['user_photo'] != '') {
                      $img = '<a href="javascript:;" class="inbox-avatar"><img width="30" height="30" src="' . base_url() . 'uploads/users/' . $user['user_photo'] . '" alt=""></a>';
                    }
                  ?>

                    <script>
                      data.push(['<?= $sno; ?>', '<?= $img; ?>', '<?= $user['display_name'] ?>', '<?= $user['user_login'] ?>', '<a href="mailto:<?= $user['user_email'] ?>"><?= $user['user_email'] ?></a>', '<div class="center"><?= $user['user_dateofjoin']; ?></div>', '<div class="center"><?= $user['category_name']; ?></div>', '<span class="<?= ($user['user_status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($user['user_status'] == 1) ? 'Active' : 'Inactive'; ?></span>', '<?= $actions; ?>']);
                    </script>

                  <?php
                    $sno++;
                  }
                  ?>
                </tbody>
              </table>
              <!-- Modal -->
              <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Modal Tittle</h4>
                    </div>
                    <div class="modal-body">

                      Body goes here...

                    </div>
                    <div class="modal-footer">
                      <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                      <button class="btn btn-warning" type="button"> Confirm</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- modal -->
            </section>
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
  </script>
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
          [0, "asc"]
        ]
      });
      jQuery('.dataTables_filter input').addClass("form-control");
      jQuery('.dataTables_filter').parent().addClass('col-sm-6');
      jQuery('.dataTables_length select').addClass("form-control");
      jQuery('.dataTables_length').parent().addClass('col-sm-6');

    });
  </script>
</body>

</html>