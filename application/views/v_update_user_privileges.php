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
                <h3><i class="icon-key"></i> Manage User Privileges</h3>
              </header>
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <?php
            // print_r($this->session->all_userdata());
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

        <div class="row">
          <div class="col-lg-12">
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url() ?>users/update_user_privileges/<?= $user_id; ?>">
              <!-- <input type="hidden" name="user_id" value="<?= $user_id; ?>"> -->
              <section class="panel">
                <header class="panel-heading">
                  Update Module Privileges
                  <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                    <a class="fa fa-times" href="javascript:;"></a>
                  </span>
                </header>
                <div class="panel-body" style="display: block;">
                  <?php
                  $requsers = $this->m_purchase->getDatas('bud_users', 'ID', $user_id);
                  foreach ($requsers as $user) {
                    $user_access_modules = $user['user_access_modules'];
                  }
                  $access_modules = explode(",", $user_access_modules);
                  ?>
                  <div class="form-group col-lg-6">
                    <label class="control-label col-lg-2">Modules</label>
                    <div class="">
                      <label class="checkbox-inline">
                        <input type="checkbox" name="user_access_modules[]" <?= (in_array(1, $access_modules)) ? 'checked="checked"' : ''; ?> id="module1" value="1"> Yarn &amp; Thread
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="user_access_modules[]" <?= (in_array(2, $access_modules)) ? 'checked="checked"' : ''; ?> id="module2" value="2"> Tapes &amp; Elastic
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="user_access_modules[]" <?= (in_array(3, $access_modules)) ? 'checked="checked"' : ''; ?> id="module3" value="3"> Label
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="user_access_modules[]" <?= (in_array(4, $access_modules)) ? 'checked="checked"' : ''; ?> id="module4" value="4"> Medicle Tapes
                      </label>
                    </div>
                  </div>
                </div>
              </section>

              <section class="panel">
                <header class="panel-heading">
                  Update User Privileges
                  <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                    <a class="fa fa-times" href="javascript:;"></a>
                  </span>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" id="selecctall"> Select All
                  </label>
                </header>
                <?php
                $thead = '<thead>
                        <tr>
                          <th>Privilege Name</th>
                          <th>View Only</th>
                          <th>Add/Edit/Duplicate</th>
                          <th>Delete</th>
                        </tr>
                      </thead>';

                function get_privileges_actions($upriv_id, $upriv_description, $exist, $existadd, $existdel)
                {
                  $actionContent = '<tr>
                      <td>
                        <input type="hidden" name="update[' . $upriv_id . '][id]" value="' . $upriv_id . '" />
                        ' . $upriv_description . '
                      </td>
                      <td>
                        <input type="hidden" name="update[' . $upriv_id . '][current_status]" value="' . (($exist) ? '1' : '0') . '">
                        <input type="hidden" name="update[' . $upriv_id . '][new_status]" value="0">
                        <input class="form-control" type="checkbox" name="update[' . $upriv_id . '][new_status]" value="1" ' . (($exist) ? 'checked="checked"' : '') . '>
                      </td>
                      <td>
                        <input type="hidden" name="update[' . $upriv_id . '][current_status_add]" value="' . (($existadd) ? '1' : '0') . '">
                        <input type="hidden" name="update[' . $upriv_id . '][new_status_add]" value="0">
                        <input class="form-control" type="checkbox" name="update[' . $upriv_id . '][new_status_add]" value="1" ' . (($existadd) ? 'checked="checked"' : '') . '>
                      </td>
                      <td>
                        <input type="hidden" name="update[' . $upriv_id . '][current_status_del]" value="' . (($existdel) ? '1' : '0') . '">
                        <input type="hidden" name="update[' . $upriv_id . '][new_status_del]" value="0">
                        <input class="form-control" type="checkbox" name="update[' . $upriv_id . '][new_status_del]" value="1" ' . (($existdel) ? 'checked="checked"' : '') . '>
                      </td>
                    </tr>';
                  return $actionContent;
                }
                ?>
                <div class="panel-body" style="display: block;">
                  <ul id="nav-accordion" class="accordion">

                    <?php

                    $endHtml = '</tbody></table></li></ul></li>';

                    $privileges = $this->m_users->get_all_privileges();
                    $i = 0;
                    $lp = '';
                    foreach ($privileges as $privilege) {
                      if ($privilege['upriv_group'] == '') {
                        continue;
                      }
                      $start = false;
                      $end = false;
                      if ($lp == '' || $privilege['upriv_group'] != $lp) {
                        $lp = $privilege['upriv_group'];
                        $end = true;
                        $start = true;
                      }
                      if ($end == true && $i != 0) {
                        echo $endHtml;
                      }
                      if ($start == true) {
                        echo '<li class="sub-menu dcjq-parent-li">
                          <a href="javascript:;" class="dcjq-parent">
                            <i class="fa fa-book"></i>
                            <span>' . $privilege['upriv_group'] . '</span>
                            <span class="dcjq-icon"></span>
                          </a>
                          <ul class="sub" style="display: none;">
                            <li>
                              <table class="table">
                                ' . $thead . '
                                <tbody>';
                        $i = 1;
                        $end = false;
                      }

                      $upriv_id = $privilege['upriv_id'];
                      $exist = $this->m_users->is_upriv_exit($user_id, $upriv_id);
                      $existadd = $this->m_users->is_upriv_add_action_exit($user_id, $upriv_id);
                      $existdel = $this->m_users->is_upriv_del_action_exit($user_id, $upriv_id);
                      echo get_privileges_actions($upriv_id, $privilege['upriv_description'] . ' <b>(' . $privilege['upriv_modules'] . ')</b>', $exist, $existadd, $existdel);

                      $i++;
                    }
                    echo $endHtml;
                    ?>

                  </ul>
                </div>
              </section>

              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit">Update</button>
                  <button class="btn btn-default" type="button">Cancel</button>
                </header>
              </section>
            </form>
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
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
  <script class="include" type="text/javascript" src="<?= base_url(); ?>themes/default/js/jquery.dcjqaccordion.2.7.js"></script>
  <script type="text/javascript">
    /*---LEFT BAR ACCORDION----*/
    $(function() {
      $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
        //        cookie: 'dcjq-accordion-1',
        classExpand: 'dcjq-current-parent'
      });
    });
  </script>

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
      // alert('Start');
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });

    // Add Row
    $(function() {
      var scntDiv = $('#packingcones');
      var i = $('#packingcones .conesrow').size() + 1;
      $(".addrow").live("click", function() {
        var nextrow = '<div class="clear"></div><div class="conesrow" style="width:100%;float:left"><div class="form-group col-lg-3"><input class="form-control" name="cones_type[]" type="text" required></div><div class="form-group col-lg-3"><input class="form-control" name="cones_count[]" type="text" required></div><div class="form-group col-lg-3"><input class="form-control" name="cones_weight[]" type="text" required></div><div class="form-group col-lg-2"><button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button></div></div>';
        $(nextrow).appendTo(scntDiv);
        i++;
        return false;
        alert(i); // jQuery 1.3+
      });
      $('.removerow').live('click', function() {
        if (i > 2) {
          $(this).parents('#packingcones .conesrow').remove();
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

    $(function() {
      $("#packing_category").change(function() {
        var packing_category = $('#packing_category').val();
        // alert(packing_category);
        var url = "<?= base_url() ?>masters/getcustomerdatas/" + packing_category;
        var postData = 'packing_category=' + packing_category;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(customers) {
            $("#customer_id").html(customers);
          }
        });
        return false;
      });
    });
    $(function() {
      $("#customer_id").change(function() {
        var customer_id = $('#customer_id').val();
        var url = "<?= base_url() ?>sales/getcustomerDC/" + customer_id;
        var postData = 'customer_id=' + customer_id;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            console.log(result);
            $("#sales_dc_no").html(result);
          }
        });
        return false;
      });
    });

    $(function() {
      $("#sales_dc_no").change(function() {
        var sales_dc_no = $('#sales_dc_no').val();
        var url = "<?= base_url() ?>sales/getDCItems/" + sales_dc_no;
        var postData = 'sales_dc_no=' + sales_dc_no;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            console.log(result);
            $("#itemsdata").html(result);
          }
        });
        return false;
      });
    });

    $('#selecctall').click(function(event) { //on click 
      var checkboxes = $(this).closest('form').find(':checkbox');
      if ($(this).is(':checked')) {
        checkboxes.attr('checked', 'checked');
      } else {
        checkboxes.removeAttr('checked');
      }
    });
  </script>

</body>

</html>