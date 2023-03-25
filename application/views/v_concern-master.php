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
                        <h3><i class="icon-file-text"></i> Concern Master</h3>
                     </header>
                  </section>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <?php
                  if ($this->session->flashdata('warning')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-warning fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  if ($this->session->flashdata('error')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
                           <div class="alert alert-block alert-danger fade in">
                              <button data-dismiss="alert" class="close close-sm" type="button">
                                 <i class="icon-remove"></i>
                              </button>
                              <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                           </div>
                        </header>
                     </section>
                  <?php
                  }
                  if ($this->session->flashdata('success')) {
                  ?>
                     <section class="panel">
                        <header class="panel-heading">
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
                        </header>
                     </section>
                  <?php
                  }
                  ?>
               </div>
            </div>
            <?php
            if (isset($concern_id)) {
               $result = $this->m_masters->getmasterdetails('bud_concern_master', 'concern_id', $concern_id);
               foreach ($result as $row) {
                  $module = @$row['module'];
                  $concern_name = @$row['concern_name'];
                  $concern_second_name = @$row['concern_second_name'];
                  $concern_prefix = @$row['concern_prefix'];
                  $concern_address = @$row['concern_address'];
                  $concern_gst = @$row['concern_gst'];
                  $concern_active = @$row['concern_active'];
               }
            } else {
               $concern_id = '';
               $concern_name = '';
               $concern_second_name = '';
               $concern_prefix = '';
               $concern_address = '';
               $concern_gst = '';
               $concern_active = '';
            }
            ?>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>admin/saveConcernMaster">
               <input type="hidden" name="module_id" value="<?= $this->session->userdata('user_viewed'); ?>">
               <input type="hidden" name="concern_id" value="<?= $concern_id; ?>">
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Concern Details
                        </header>
                        <div class="panel-body">
                           <div class="form-group col-lg-12">
                              <input type="hidden" name="old_concern_name" value="<?= $concern_name; ?>">
                              <label for="concern_name">Concern Name</label>
                              <input class="form-control" value="<?= $concern_name; ?>" id="concern_name" name="concern_name" required>
                           </div>
                           <div class="form-group col-lg-12">
                              <label for="concern_second_name">Concern Second Name</label>
                              <input class="form-control" value="<?= $concern_second_name; ?>" id="concern_second_name" name="concern_second_name" required>
                           </div>
                           <div class="form-group col-lg-12">
                              <label for="concern_prefix">Prefix</label>
                              <input class="form-control" value="<?= $concern_prefix; ?>" id="concern_prefix" name="concern_prefix" required maxlength="4">
                           </div>
                           <div class="form-group col-lg-12">
                              <label for="concern_address">Address</label>
                              <textarea class="form-control" id="concern_address" name="concern_address"><?= $concern_address; ?></textarea>
                           </div>
                           <div class="form-group col-lg-12">
                              <label for="concern_tin">GST No</label>
                              <input class="form-control" value="<?= $concern_gst; ?>" id="concern_gst" name="concern_gst">
                           </div>
                           <div class="row">
                              <div class="form-group col-md-3">
                                 <label for="concern_active">Active</label>
                                 <input class="form-control checkbox" <?= (@$concern_active == 1) ? 'checked="ckecked"' : ''; ?> value="1" id="concern_active" name="concern_active" type="checkbox">
                              </div>
                           </div>

                           <div class="clear"></div>
                        </div>
                     </section>
                  </div>
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <button class="btn btn-danger" type="submit">Update</button>
                           <button class="btn btn-default" type="button">Cancel</button>
                        </header>
                     </section>
                  </div>
               </div>
            </form>
            <!-- Start Talbe List  -->
            <section class="panel">
               <header class="panel-heading">
                  Summery
               </header>
               <script>
                  var data = [];
               </script>
               <table class="table table-striped border-top itemlistx" id="itemlistx">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Concern Name</th>
                        <th>Second Name</th>
                        <th>Prefix</th>
                        <th>Address</th>
                        <th>GST No</th>
                        <th>Status</th>
                        <th>User</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <?php
                  $sno = 1;
                  foreach ($concerns as $row) {
                     $concern_id = $row['concern_id'];
                     $concern_name = $row['concern_name'];
                     $concern_second_name = $row['concern_second_name'];
                     $concern_prefix = $row['concern_prefix'];
                     $concern_address = trim(preg_replace('/\s+/', ' ', $row['concern_address']));
                     $concern_gst = $row['concern_gst'];
                     $econcern_edit = '<a href="' . base_url() . 'admin/concernMaster/' . $concern_id . '" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>';
                     /*
                          <!-- <a href="<?=base_url();?>admin/deletemaster/bud_concern_master/concern_id/<?=$concern_id; ?>/admin/concernMaster" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a> -->
                          */

                     $statusdata = '<span class="' . (($row['concern_active'] != '' && $row['concern_active'] != 0) ? 'label label-success' : 'label label-danger') . '">' . (($row['concern_active'] != '' && $row['concern_active'] != 0) ? 'Active' : 'Inactive') . '</span>';

                     $user_date = $row['user'] . '<br>' . $row['date'];
                  ?>
                     <script>
                        data.push(['<?= $sno; ?>', '<?= $concern_name; ?>', '<?= $concern_second_name; ?>', '<?= $concern_prefix; ?>', '<?= $concern_address; ?>', '<?= $concern_gst; ?>', '<?= $statusdata; ?>', '<?= $user_date; ?>', '<?= $econcern_edit; ?>']);
                     </script>

                  <?php
                     $sno++;
                  }
                  ?>
               </table>
            </section>
            <!-- End Talbe List  -->
            <div class="pageloader"></div>
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

         $('.itemlistx').DataTable({
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