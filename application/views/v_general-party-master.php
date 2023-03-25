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
                <h3><i class="icon-user"></i> General party master</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <?php
            if (isset($company_id)) {
              $result = $this->m_masters->getmasterdetails('bud_general_customers', 'company_id', $company_id);
              foreach ($result as $row) {
                $company_name = $row['company_name'];
                $company_address = $row['company_address'];
                $is_active = $row['is_active'];
              }
            } else {
              $company_id = '';
              $company_name = '';
              $company_address = '';
              $is_active = '';
            }
            $contacts = $this->m_masters->getmasterdetails('bud_general_cust_contacts', 'company_id_ref', $company_id);
            ?>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/generalPartySave">
              <section class="panel">
                <header class="panel-heading">
                  Company Details
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
                  <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                  <div class="form-group col-lg-4">
                    <label for="company_name">Company Name</label>
                    <input class="form-control" id="company_name" name="company_name" value="<?= $company_name; ?>" type="text" required>
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="company_address">Company Address</label>
                    <textarea class="form-control" id="company_address" name="company_address" required><?php echo $company_address; ?></textarea>
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="is_active">Active</label>
                    <input type="checkbox" style="width: 20px;" <?= ($is_active == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="is_active" name="is_active" />
                  </div>
                </div>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  Contact Persions
                </header>
                <div class="panel-body">
                  <table class="table table-striped border-top" id="tbl">
                    <thead>
                      <tr>
                        <th>Contact Name</th>
                        <th>Mobile No</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th><a href="#" id="add" class="btn btn-primary"><i class="icon-plus"></i> Add</a></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($contacts) {
                        foreach ($contacts as $contact) {
                          $id = $contact['id'];
                          $contact_name = $contact['contact_name'];
                          $mobile_no = $contact['mobile_no'];
                          $email_id = $contact['email_id'];
                          $designation = $contact['designation'];
                      ?>
                          <tr>
                            <td>
                              <input type="text" name="contact_name[<?= $id; ?>]" value="<?= $contact_name; ?>">
                            </td>
                            <td>
                              <input type="text" name="mobile_no[<?= $id; ?>]" value="<?= $mobile_no; ?>">
                            </td>
                            <td>
                              <input type="text" name="email[<?= $id; ?>]" value="<?= $email_id; ?>">
                            </td>
                            <td>
                              <input type="text" name="designation[<?= $id; ?>]" value="<?= $designation; ?>">
                            </td>
                            <td>
                              <!-- <a href="#" class="btn btn-primary remove-row"><i class="icon-minus"></i> Remove</a> -->
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                        <tr>
                          <td>
                            <input type="text" name="contact_name_new[]">
                          </td>
                          <td>
                            <input type="text" name="mobile_no_new[]">
                          </td>
                          <td>
                            <input type="text" name="email_new[]">
                          </td>
                          <td>
                            <input type="text" name="designation_new[]">
                          </td>
                          <td>
                            <!-- <a href="#" class="btn btn-primary remove-row"><i class="icon-minus"></i> Remove</a> -->
                          </td>
                        </tr>
                      <?php
                      } else {
                      ?>
                        <tr>
                          <td>
                            <input type="text" name="contact_name[]">
                          </td>
                          <td>
                            <input type="text" name="mobile_no[]">
                          </td>
                          <td>
                            <input type="text" name="email[]">
                          </td>
                          <td>
                            <input type="text" name="designation[]">
                          </td>
                          <td>
                            <!-- <a href="#" class="btn btn-primary remove-row"><i class="icon-minus"></i> Remove</a> -->
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit"><?= ($company_id != '') ? 'Update' : 'Save'; ?></button>
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
                General Customers
              </header>
              <script>
                var data = [];
              </script>
              <table class="table table-striped border-top" id="sample_1x">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>Contact Name</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <?php
                $sno = 1;
                foreach ($customers as $row) {
                  $display_com_name = false;
                  $company_id_ref = $row['company_id'];
                  $company_name = $row['company_name'];
                  $company_address = $row['company_address'];
                  $is_active = $row['is_active'];
                  $contacts = $this->m_masters->getmasterdetails('bud_general_cust_contacts', 'company_id_ref', $company_id_ref);
                  foreach ($contacts as $contact) {

                    if ($display_com_name == false) :
                      $display_com_name = true;
                      $company_name;
                      $company_address;
                    else :
                      $company_name = '';
                      $company_address = '';
                    endif;

                    $status = '<span class="' . (($is_active == 1) ? 'label label-success' : 'label label-danger') . '">' . (($row['is_active'] == 1) ? 'Active' : 'Inactive') . '</span>';

                ?>
                    <script>
                      data.push(['<?= $sno; ?>', '<?= $company_name; ?>', '<?= $company_address; ?>', '<?= $contact['contact_name']; ?>', '<?= $contact['mobile_no']; ?>', '<?= $contact['email_id']; ?>', '<?= $contact['designation']; ?>', '<?= $status; ?>', '<a href="<?= base_url(); ?>general/generalPartyMaster/<?= $row['company_id']; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a><a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>']);
                    </script>

                <?php
                    $sno++;
                  }
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

    $("#add").on('click', function() {
      var $tableBody = $('#tbl').find("tbody"),
        $trFirst = $tableBody.find("tr:first"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trFirst.clone(true);
      $trLast.after($trNew);
      $trNew.find("input").val("");
      return false;
    });
    $('.remove-row').on('click', function() {
      $(this).closest('tr').remove();
    });
  </script>

</body>

</html>