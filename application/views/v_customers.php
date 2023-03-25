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
                <h3><i class="icon-user"></i> Add New Customer/Vender</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Unique Code
                <span class="label label-danger" style="font-size:14px;"><?= $customer_code; ?></span>
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
                if (isset($cust_id)) {
                  $editcustomer = $this->m_masters->getcustomerdetails($cust_id);
                  foreach ($editcustomer as $customer) {
                    $cust_group = $customer['cust_group'];
                    $cust_type = $customer['cust_type'];
                    $cust_name = $customer['cust_name'];
                    $cust_address = $customer['cust_address'];
                    $cust_city = $customer['cust_city'];
                    $cust_pincode = $customer['cust_pincode'];
                    $cust_phone = $customer['cust_phone'];
                    $cust_fax = $customer['cust_fax'];
                    $cust_email = $customer['cust_email'];

                    $cust_gst = $customer['cust_gst'];
                    $cust_ob = $customer['cust_ob'];
                    $cust_agent = @explode(",", $customer['cust_agent']);
                    $cust_balance_req = $customer['cust_balance_req'];
                    $cust_pricelist = $customer['cust_pricelist'];
                    $cust_status = $customer['cust_status'];
                    $cust_contacts = $customer['cust_contacts'];
                    $cust_credit_limit = $customer['cust_credit_limit'];
                    $cust_merit = $customer['cust_merit'];
                    $sms_active = $customer['sms_active'];
                    $email_active = $customer['email_active'];
                    $password = $this->encrypt->decode($customer['password']);
                  }
                  $action = 'updatecustomers';
                  $credit_limit = explode(",", $cust_credit_limit);
                  if (count($credit_limit) < 2) {
                    $credit_limit = array(0, 0);
                  }
                } else {
                  $cust_id = '';
                  $cust_group = '';
                  $cust_type = '';
                  $cust_name = '';
                  $cust_address = '';
                  $cust_city = '';
                  $cust_pincode = '';
                  $cust_phone = '';
                  $cust_fax = '';
                  $cust_email = '';

                  $cust_gst = '';
                  $cust_ob = '';
                  $cust_agent = array();
                  $cust_balance_req = '';
                  $cust_pricelist = '';
                  $cust_status = '';
                  $cust_contacts = '';
                  $cust_merit = '';
                  $sms_active = '';
                  $email_active = '';
                  $password = '';
                  $credit_limit = array(0, 0);
                  $action = 'savecustomers';
                }
                ?>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/<?= $action; ?>">
                  <input type="hidden" name="cust_id" value="<?= $cust_id; ?>">
                  <div class="form-group col-lg-6">
                    <label for="cust_name" class="control-label col-lg-2">Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_name" name="cust_name" value="<?= $cust_name; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="cust_type" class="control-label col-lg-2">Category</label>
                    <div class="col-lg-10">
                      <?php $cust_type = @$cust_type; ?>
                      <?= ($cust_type == 'c') ? ' <h3>This is a Customer a/c.</h3>' : ''; ?>
                      <?= ($cust_type == 'v') ? ' <h3>This is a Vender a/c.</h3>' : ''; ?>
                      <input type="hidden" name="cust_type" value="<?= $cust_type; ?>" />
                      <label class="radio-inline <?= ($cust_type != '') ? ' hide' : ''; ?>">
                        <input type="radio" id="c" <?= ($cust_type != '') ? 'checked="checked"' : 'name="cust_type"'; ?> value="c" <?= ($cust_type != '') ? 'disabled="true"' : ''; ?>> Customer
                      </label>
                      <label class="radio-inline <?= ($cust_type != '') ? ' hide' : ''; ?>">
                        <input type="radio" id="v" <?= ($cust_type != '') ? 'checked="checked"' : ''; ?> value="v" <?= ($cust_type != '') ? 'disabled="true"' : 'name="cust_type"'; ?>> Vender
                      </label>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="cust_group" class="control-label col-lg-2">Group</label>
                    <div class="col-lg-10">
                      <select class="form-control m-bot15 select2" name="cust_group" id="cust_group">
                        <option value="0">Select</option>
                        <?php
                        foreach ($cust_groups as $row) {
                        ?>
                          <option value="<?= $row['group_id']; ?>" <?= ($cust_group == $row['group_id']) ? 'selected="selected"' : ''; ?>><?= $row['group_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="category_status" class="control-label col-lg-2">Address</label>
                    <div class="col-lg-10">
                      <textarea class="form-control " id="cust_address" name="cust_address"><?= $cust_address; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="cust_city" class="control-label col-lg-2">City</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_city" name="cust_city" value="<?= $cust_city; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="cust_pincode" class="control-label col-lg-2">Pincode</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_pincode" name="cust_pincode" value="<?= $cust_pincode; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="cust_phone" class="control-label col-lg-2">Phone</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_phone" name="cust_phone" value="<?= $cust_phone; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="cust_fax" class="control-label col-lg-2">MD Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_fax" name="cust_fax" value="<?= $cust_fax; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="cust_email" class="control-label col-lg-2">Email</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_email" name="cust_email" value="<?= $cust_email; ?>" type="email" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="password" class="control-label col-lg-2">Password</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="password" name="password" value="<?= (@$password != '') ? @$password : '12345'; ?>" type="password" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="cust_cst" class="control-label col-lg-2">GST</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_gst" name="cust_gst" type="text" value="<?= $cust_gst; ?>" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="cust_ob" class="control-label col-lg-2">OB</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="cust_ob" name="cust_ob" type="text" value="<?= $cust_ob; ?>" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label class="control-label col-lg-2">Credit Limit</label>
                    <div class="col-lg-5">
                      <input class="form-control" placeholder="From" name="cust_credit_limit[]" value="<?= $credit_limit[0]; ?>" type="text" required>
                    </div>
                    <div class="col-lg-5">
                      <input class="form-control" placeholder="To" name="cust_credit_limit[]" value="<?= $credit_limit[1]; ?>" type="text" required>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label class="control-label col-lg-2">Status</label>
                    <div class="">
                      <label class="radio-inline">
                        <input type="radio" name="cust_merit" id="cust_merit1" <?= ($cust_merit == 1) ? 'checked="checked"' : ''; ?> value="1"> Poor
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="cust_merit" id="cust_merit2" <?= ($cust_merit == 2) ? 'checked="checked"' : ''; ?> value="2"> Good
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="cust_merit" id="cust_merit3" <?= ($cust_merit == 3) ? 'checked="checked"' : ''; ?> value="3"> V. Good
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="cust_merit" id="cust_merit4" <?= ($cust_merit == 4) ? 'checked="checked"' : ''; ?> value="4"> Excelent
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="cust_merit" id="cust_merit5" <?= ($cust_merit == 5) ? 'checked="checked"' : ''; ?> value="5"> Golden
                      </label>
                    </div>
                  </div>
                  <div class="clear" style="clear:both;"></div>
                  <div class="form-group col-lg-6">
                    <label for="cust_agent" class="control-label col-lg-2">Communication Staff</label>
                    <div class="col-lg-10">
                      <select class="select2 form-control" multiple="multiple" name="cust_agent[]" required>
                        <?php
                        $agents = $this->m_masters->getactivemaster('bud_users', 'user_status');
                        foreach ($agents as $agent) {
                        ?>
                          <option value="<?= $agent['ID']; ?>" <?= (in_array($agent['ID'], $cust_agent)) ? 'selected="selected"' : ''; ?>><?= $agent['user_login']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <label class="control-label col-lg-2">Communication Options</label>
                    <div class="col-lg-10">
                      <label class="checkbox-inline">
                        <input type="checkbox" name="sms_active" id="sms_active" <?= ($sms_active == 1) ? 'checked="checked"' : ''; ?> value="1"> Notifications
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="email_active" id="email_active" <?= ($email_active == 1) ? 'checked="checked"' : ''; ?> value="1"> Email
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" <?= ($cust_balance_req == 1) ? 'checked="ckecked"' : ''; ?> value="1" id="cust_balance_req" name="cust_balance_req" /> Balance Required
                      </label>
                    </div>
                  </div>
                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-6">
                    <label for="cust_status" class="control-label col-lg-6">Active</label>
                    <div class="col-lg-10">
                      <input type="checkbox" style="width: 20px;float:left;" <?= ($cust_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="cust_status" name="cust_status" />
                    </div>
                  </div>
                  <div class="clear"></div>
                  <div class="form-group col-lg-11" id="contacts">
                    <header class="panel-heading">
                      Contact Persons
                    </header>
                    <?php
                    if ($cust_contacts != '') {
                      $cust_contacts = explode("|", $cust_contacts);
                      if (sizeof($cust_contacts) > 0) {
                        $rowno = 1;
                        foreach ($cust_contacts as $key => $value) {
                          $contacts = explode("##", $value);
                    ?>
                          <div class="form-group col-lg-12 contactsrow">
                            <div class="col-lg-3">
                              <input class="form-control" name="cust_names[]" value="<?= $contacts[0]; ?>" type="text" placeholder="Name, Designation">
                            </div>
                            <div class="col-lg-3">
                              <input class="form-control" name="cust_contactnos[]" value="<?= $contacts[1]; ?>" type="text" placeholder="Contact No">
                            </div>
                            <div class="col-lg-3">
                              <input class="form-control" name="cust_emails[]" value="<?= $contacts[2]; ?>" type="text" placeholder="Email">
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
                          <input class="form-control" name="cust_names[]" type="text" placeholder="Name, Designation">
                        </div>
                        <div class="col-lg-3">
                          <input class="form-control" name="cust_contactnos[]" type="text" placeholder="Contact No">
                        </div>
                        <div class="col-lg-3">
                          <input class="form-control" name="cust_emails[]" type="text" placeholder="Email">
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
                      <button class="btn btn-danger" type="submit"><?= ($cust_id != '') ? 'Update' : 'Save'; ?></button>
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
                Customers
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Cust. Code</th>
                    <th>Customer Name</th>
                    <th>email</th>
                    <th>Phone</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th class="hidden-phone"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($customers as $customer) {
                  ?>
                    <tr class="odd gradeX">
                      <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                      <td><?= $sno; ?></td>
                      <td><?= $customer['cust_id']; ?></td>
                      <td><?= $customer['cust_name']; ?></td>
                      <td><a href="mailto:<?= $customer['cust_email'] ?>"><?= $customer['cust_email'] ?></a></td>
                      <td><?= $customer['cust_phone'] ?></td>
                      <td><?= (@$customer['cust_type'] == 'v')?'Ven':'Cus' ?></td>
                      <td class="hidden-phone">
                        <span class="<?= ($customer['cust_status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($customer['cust_status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                      </td>
                      <td>
                        <a href="<?= base_url(); ?>masters/customers/<?= $customer['cust_id'] ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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

    // Add Row
    $(function() {
      var scntDiv = $('#contacts');
      var i = $('#contacts .contactsrow').size() + 1;
      $(".addrow").live("click", function() {
        var nextrow = '<div class="form-group col-lg-12 contactsrow"><div class="col-lg-3"><input class="form-control"  name="cust_names[]" type="text" placeholder="Name, Designation"></div><div class="col-lg-3"><input class="form-control"  name="cust_contactnos[]" type="text" placeholder="Contact No"></div><div class="col-lg-3"><input class="form-control"  name="cust_emails[]" type="text" placeholder="Email"></div><div class="col-lg-3"><button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button></div></div>';
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
  </script>

</body>

</html>