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
                <h3><i class="icon-user"></i> Add New Supplier</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Supplier Details
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
                if (isset($sup_id)) {
                  $editcustomer = $this->m_masters->getsupplierdetails($sup_id);
                  foreach ($editcustomer as $customer) {
                    $sup_group = $customer['sup_group'];
                    $sup_category = $customer['sup_category'];
                    $sup_name = $customer['sup_name'];
                    $sup_address = $customer['sup_address'];
                    $sup_city = $customer['sup_city'];
                    $sup_pincode = $customer['sup_pincode'];
                    $sup_phone = $customer['sup_phone'];
                    $sup_fax = $customer['sup_fax'];
                    $sup_email = $customer['sup_email'];
                    $sup_tinno = $customer['sup_tinno'];
                    $sup_cst = $customer['sup_cst'];
                    $sup_ob = $customer['sup_ob'];
                    $sup_agent = @explode(",", $customer['sup_agent']);
                    $sup_status = $customer['sup_status'];
                    $sup_contacts = $customer['sup_contacts'];
                  }
                  $action = 'updatesuppliers';
                } else {
                  $sup_id = '';
                  $sup_group = '';
                  $sup_category = '';
                  $sup_name = '';
                  $sup_address = '';
                  $sup_city = '';
                  $sup_pincode = '';
                  $sup_phone = '';
                  $sup_fax = '';
                  $sup_email = '';
                  $sup_tinno = '';
                  $sup_cst = '';
                  $sup_ob = '';
                  $sup_agent = array();
                  $sup_status = '';
                  $sup_contacts = '';
                  $action = 'savesuppliers';
                }
                ?> <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/<?= $action; ?>">
                  <input type="hidden" name="sup_id" value="<?= $sup_id; ?>">
                  <input type="hidden" name="sup_category" value="<?= $user_viewed = $this->session->userdata('user_viewed');; ?>">
                  <div class="form-group col-lg-6">
                    <label for="sup_name" class="control-label col-lg-2">Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_name" name="sup_name" value="<?= $sup_name; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_group" class="control-label col-lg-2">Group</label>
                    <div class="col-lg-10">
                      <select class="select2 form-control m-bot15" name="sup_group" id="sup_group" required>
                        <option value="">Select Group</option>
                        <?php
                        foreach ($supplier_groups as $row) {
                        ?>
                          <option value="<?= $row['group_id']; ?>" <?= ($sup_group == $row['group_id']) ? 'selected="selected"' : ''; ?>><?= $row['group_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="category_status" class="control-label col-lg-2">Address</label>
                    <div class="col-lg-10">
                      <textarea class="form-control " id="sup_address" name="sup_address"><?= $sup_address; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_city" class="control-label col-lg-2">City</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_city" name="sup_city" value="<?= $sup_city; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_pincode" class="control-label col-lg-2">Pincode</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_pincode" name="sup_pincode" value="<?= $sup_pincode; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_phone" class="control-label col-lg-2">Phone</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_phone" name="sup_phone" value="<?= $sup_phone; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_fax" class="control-label col-lg-2">Fax</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_fax" name="sup_fax" value="<?= $sup_fax; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_email" class="control-label col-lg-2">Email</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_email" name="sup_email" value="<?= $sup_email; ?>" type="email" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_tinno" class="control-label col-lg-2">Tin No</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_tinno" name="sup_tinno" value="<?= $sup_tinno; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_cst" class="control-label col-lg-2">CST</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_cst" name="sup_cst" type="text" value="<?= $sup_cst; ?>" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_ob" class="control-label col-lg-2">OB</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="sup_ob" name="sup_ob" type="text" value="<?= $sup_ob; ?>" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_agent" class="control-label col-lg-2">Communication From Agent Master</label>
                    <div class="col-lg-10">
                      <select class="form-control select2 m-bot15" multiple="multiple" name="sup_agent[]" id="sup_agent" required>
                        <?php
                        $agents = $this->m_masters->getactivemaster('bud_agents', 'agent_status');
                        foreach ($agents as $agent) {
                        ?>
                          <option value="<?= $agent['agent_id']; ?>" <?= (in_array($agent['agent_id'], $sup_agent)) ? 'selected="selected"' : ''; ?>><?= $agent['agent_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="sup_status" class="control-label col-lg-6">Active</label>
                    <div class="col-lg-10">
                      <input type="checkbox" style="width: 20px;float:left;" <?= ($sup_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="sup_status" name="sup_status" />
                    </div>
                  </div>
                  <div class="clear"></div>
                  <div class="form-group col-lg-11" id="contacts">
                    <header class="panel-heading">
                      Contact Persions
                    </header>
                    <?php
                    if ($sup_contacts != '') {
                      $sup_contacts = explode("|", $sup_contacts);
                      if (sizeof($sup_contacts) > 0) {
                        $rowno = 1;
                        foreach ($sup_contacts as $key => $value) {
                          $contacts = explode("##", $value);
                    ?>
                          <div class="form-group col-lg-12 contactsrow">
                            <div class="col-lg-3">
                              <input class="form-control" name="sup_names[]" value="<?= $contacts[0]; ?>" type="text" placeholder="Name">
                            </div>
                            <div class="col-lg-3">
                              <input class="form-control" name="sup_contactnos[]" value="<?= $contacts[1]; ?>" type="text" placeholder="Contact No">
                            </div>
                            <div class="col-lg-3">
                              <input class="form-control" name="sup_emails[]" value="<?= $contacts[2]; ?>" type="text" placeholder="Email">
                            </div>
                            <div class="col-lg-3">
                              <?php
                              if ($key == 0) {
                              ?>
                                <button type="button" class="btn btn-primary addrow"><i class="icon-plus"></i> Add</button>
                              <?php
                              } else {
                              ?>
                                <button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button>
                              <?php
                              }
                              ?>
                            </div>
                          </div>
                      <?php
                        }
                      }
                    } else {
                      ?>
                      <div class="form-group col-lg-12 contactsrow">
                        <div class="col-lg-3">
                          <input class="form-control" name="sup_names[]" type="text" placeholder="Name">
                        </div>
                        <div class="col-lg-3">
                          <input class="form-control" name="sup_contactnos[]" type="text" placeholder="Contact No">
                        </div>
                        <div class="col-lg-3">
                          <input class="form-control" name="sup_emails[]" type="text" placeholder="Email">
                        </div>
                        <div class="col-lg-3">
                          <button type="button" class="btn btn-primary addrow"><i class="icon-plus"></i> Add</button>
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                  </div>
                  <div class="clear"></div>
                  <div class="form-group col-lg-6">
                    <div class="col-lg-10">
                      <button class="btn btn-danger" type="submit"><?= ($sup_id != '') ? 'Update' : 'Save'; ?></button>
                      <button class="btn btn-default" type="button">Cancel</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- Loading -->
              <div class="pageloader"></div>
              <!-- End Loading -->
            </section>

            <!-- Start Talbe List  -->
            <section class="panel">
              <header class="panel-heading">
                Suppliers
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Name</th>
                    <th>Group</th>
                    <th>email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th class="hidden-phone"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($suppliers as $supplier) {
                    $group_name = $this->m_masters->getmasterIDvalue('bud_yt_supplier_groups', 'group_id', $supplier['sup_group'], 'group_name');
                  ?>
                    <tr class="odd gradeX">
                      <td><?= $sno; ?></td>
                      <td><?= $supplier['sup_name']; ?></td>
                      <td><?= $group_name; ?></td>
                      <td><a href="mailto:<?= $supplier['sup_email'] ?>"><?= $supplier['sup_email'] ?></a></td>
                      <td><?= $supplier['sup_phone'] ?></td>
                      <td class="hidden-phone">
                        <span class="<?= ($supplier['sup_status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($supplier['sup_status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                      </td>
                      <td>
                        <a href="<?= base_url(); ?>masters/suppliers/<?= $supplier['sup_id'] ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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

    // Add Row
    $(function() {
      var scntDiv = $('#contacts');
      var i = $('#contacts .contactsrow').size() + 1;
      $(".addrow").live("click", function() {
        var nextrow = '<div class="form-group col-lg-12 contactsrow"><div class="col-lg-3"><input class="form-control"  name="sup_names[]" type="text" placeholder="Name"></div><div class="col-lg-3"><input class="form-control"  name="sup_contactnos[]" type="text" placeholder="Contact No"></div><div class="col-lg-3"><input class="form-control"  name="sup_emails[]" type="text" placeholder="Email"></div><div class="col-lg-3"><button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button></div></div>';
        $(nextrow).appendTo(scntDiv);
        i++;
        return false;
        alert(i); // jQuery 1.3+
      });
      $('.removerow').live('click', function() {
        if (i > 2) {
          $(this).parents('#contacts .contactsrow').remove();
          i--;
        }
        return false;
      });
    });
    $(document).ajaxStart(function() {
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });
    /*$(function(){
        $("#sup_category").change(function () {
            var sup_category = $('#sup_category').val();
            // alert(sup_category);
            var url = "<?= base_url() ?>masters/getsupplierdatas/"+sup_category;
            var postData = 'sup_category='+sup_category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(shades)
                {
                    $("#sup_agent").html(shades);
                }
            });
            return false;
        });
      });*/
  </script>

</body>

</html>