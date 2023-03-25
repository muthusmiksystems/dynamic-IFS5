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


  <link href='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css' type='text/css' rel='stylesheet'>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js' type='text/javascript'></script>

  <style>
    .contentx {
      width: 100%;
      padding: 5px;
      margin: 0 auto;
      height: 100px;
      border: 1px red;
    }

    .contentx span {
      width: 250px;
    }

    .dz-message {
      text-align: center;
      font-size: 28px;
    }
  </style>


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
                <h3><i class="icon-signal"></i> Items Master</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Item Details
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
                if (isset($item_id)) {
                  $edititems = $this->m_masters->getmasterdetails('bud_items', 'item_id', $item_id, $this->session->userdata('user_viewed'));
                  foreach ($edititems as $item) {
                    $item_category = $item['item_category'];
                    $item_name = $item['item_name'];
                    $item_group = $item['item_group'];
                    $item_code = $item['item_code'];
                    $item_uom = $item['item_uom'];
                    $item_tax = $item['item_tax'];
                    $item_reorder_level = $item['item_reorder_level'];
                    $item_status = $item['item_status'];
                    $hsn_code = $item['hsn_code'];
                    $rate  = $item['direct_sales_rate'];
                    $item_sample = $item['item_sample'];

                    $denier_name = $item['denier_name'];
                    $item_description = $item['item_description'];
                    $item_second_name = $item['item_second_name'];
                    $item_third_name = $item['item_third_name'];
                    $item_width = $item['item_width'];
                    $item_gpm = $item['item_gpm'];

                    $item_customers = @explode(",", $item['item_customers']);
                  }
                  $action = 'updateitems';
                } else {
                  $item_id = '';
                  $item_category = '';
                  $item_name = '';
                  $item_group = '';
                  $item_code = '';
                  $item_uom = '';
                  $item_tax = '';
                  $rate = '';
                  $item_reorder_level = '';
                  $item_status = '';
                  $action = 'saveitems';
                  $hsn_code = '';
                  $item_sample = '';
                  $denier_name = '';
                  $item_description = '';
                  $item_second_name = '';
                  $item_third_name = '';
                  $item_width = '';
                  $item_gpm = '';

                  $item_customers = array();
                }
                if (@$this->uri->segment(4) == 'duplicate') {
                  $action = 'saveitems';
                }
                ?>

                <form class="cmxform form-horizontal tasi-form dropzone" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/<?= $action; ?>">
                  <input type="hidden" name="item_id" value="<?= $item_id; ?>">
                  <input type="hidden" name="item_category" value="<?= $item_category; ?>">

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_name" class="control-label">Item Name</label>
                      <input class="form-control" id="item_name" name="item_name" value="<?= $item_name; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_second_name" class="control-label">Item Second Name (Invoice Name)</label>
                      <input class="form-control" id="item_second_name" name="item_second_name" value="<?= $item_second_name; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_third_name" class="control-label">Item Third Name (Transport Invoice Name)</label>
                      <input class="form-control" id="item_third_name" name="item_third_name" value="<?= $item_third_name; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_group" class="control-label">Group</label>
                      <select class="select2 form-control" name="item_group" id="item_group">
                        <option value="">Select Group</option>
                        <?php
                        $itemgroups = $this->m_masters->getactivemaster('bud_itemgroups', 'group_status', $this->session->userdata('user_viewed'));
                        foreach ($itemgroups as $itemgroup) {
                        ?>
                          <option value="<?= $itemgroup['group_id']; ?>" <?= ($item_group == $itemgroup['group_id']) ? 'selected="selected"' : ''; ?>><?= $itemgroup['group_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="denier_name" class="control-label">Clasification / Denier</label>
                      <select class="select2 form-control" name="denier_name" id="denier_name">
                        <option value="">Select Denier</option>
                        <?php
                        foreach ($deniers as $denier) {
                        ?>
                          <option value="<?= $denier['denier_id']; ?>" <?= ($denier_name == $denier['denier_id']) ? 'selected="selected"' : ''; ?>><?= $denier['denier_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_uom" class="control-label">UOM</label>
                      <select class="select2 form-control" name="item_uom" id="item_uom">
                        <option value="">Select Uom</option>
                        <?php
                        $itemuoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
                        foreach ($itemuoms as $itemuom) {
                        ?>
                          <option value="<?= $itemuom['uom_id']; ?>" <?= ($item_uom == $itemuom['uom_id']) ? 'selected="selected"' : ''; ?>><?= $itemuom['uom_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_tax" class="control-label">Rate</label>
                      <input class="form-control" id="item_rate" name="item_rate" value="<?= $rate; ?>" type="number">
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_width" class="control-label">Tape Width (in MM)</label>
                      <input class="form-control" id="item_width" name="item_width" value="<?= $item_width; ?>" type="text">
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_gpm" class="control-label">Tape GPM</label>
                      <input class="form-control" id="item_gpm" name="item_gpm" value="<?= $item_gpm; ?>" type="text">
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_reorder_level" class="control-label">Minimum Stock Level</label>
                      <input class="form-control" id="item_reorder_level" name="item_reorder_level" value="<?= $item_reorder_level; ?>" type="text">
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_reorder_level" class="control-label">HSN Code</label>
                      <input class="form-control" id="hsn_code" name="hsn_code" value="<?= $hsn_code; ?>" type="number">
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_description" class="control-label">Item Description</label>
                      <textarea class="form-control" id="item_description" name="item_description"><?= $item_description; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <div class="col-lg-12">
                      <label for="item_customers">Customers</label>
                      <select class="select2 form-control" name="item_customers[]" multiple="multiple">
                        <?php
                        $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status', $this->session->userdata('user_viewed'));
                        foreach ($customers as $customer) {
                        ?>
                          <option value="<?= $customer['cust_id']; ?>" <?= (in_array($customer['cust_id'], $item_customers)) ? 'selected="selected"' : ''; ?>><?= $customer['cust_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="item_status" class="control-label col-lg-2">Active</label>
                    <div class="">
                      <input type="checkbox" style="width: 20px;float:left;" <?= ($item_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="item_status" name="item_status" />
                    </div>
                  </div>

                  <?php
                  if ($item_sample != '') {
                  ?>
                    <div class="form-group col-lg-8">
                      <img src="<?= base_url(); ?>uploads/itemsamples/<?= $item_sample; ?>" style="width:auto;height:100px;max-width:100%;">
                    </div>
                  <?php
                  }
                  ?>
                  <?php
                  /* <div class="form-group col-lg-4">
                    <label for="sample_file">Sample</label>
                    <input class="form-control" id="sample_file" name="sample_file" type="file">
                  </div> */
                  ?>
                  <div style="clear:both;"></div>
                  <div class="clear"></div>
                  <div class="form-group col-lg-12">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button class="btn btn-danger" type="submit"><?= (@$this->uri->segment(4) == 'duplicate' || $item_id == '') ? 'Save' : 'Update'; ?></button>
                      <button class="btn btn-default" type="button">Cancel</button>
                    </div>
                  </div>

                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-12">
                    <div class="fallback">
                      <input name="file" type="file" id="fileUpload" accept="image/*" />
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
                Items
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Group</th>
                    <th>Item Name /<br>2nd Name /<br>3rd Name</th>
                    <th>Code</th>
                    <th>Item Description</th>
                    <th>Clasification / Denier</th>
                    <th>Tape Width (in MM)</th>
                    <th>Tape GPM</th>
                    <th>HSN Code </th>
                    <th>UOM</th>
                    <th>Tax</th>
                    <th>Minimum Stock Level</th>
                    <th>Customers</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($items as $item) {
                   
                    $vi = @$item['denier_name'];
                    $current = @current(array_filter($deniers, function ($e) use ($vi) {
                      return $e['denier_id'] == $vi;
                    }));
                    $denier_name = @$current['denier_name'] . ' / ' . $vi;

                    $item_customers = @explode(",", $item['item_customers']);
                    $customer_data = array();
                    foreach ($item_customers as $key => $value) {
                      $customer_data[] = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $value, 'cust_name');
                    }
                  ?>
                    <tr class="odd gradeX">
                      <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                      <td><?= $sno; ?></td>
                      <td>
                        <?= $this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $item['item_group'], 'group_name'); ?>
                      </td>
                      <td><?= $item['item_name']; ?><br><?= $item['item_second_name']; ?><br><?= $item['item_third_name']; ?></td>
                      <td><?= $item['item_id']; ?></td>
                      <td><?= $item['item_description']; ?></td>
                      <td><?= $denier_name; ?></td>
                      <td><?= $item['item_width']; ?></td>
                      <td><?= $item['item_gpm']; ?></td>
                      <?php /* <td>
                        <?= $this->m_masters->getmasterIDvalue('bud_categories', 'category_id', $item['item_category'], 'category_name'); ?>
                        </td> */ ?>
                      <td><?= $item['hsn_code']; ?></td>
                      <td>
                        <?= $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['item_uom'], 'uom_name'); ?>
                      </td>
                      <td>
                        <?= $item['item_tax']; ?>
                      </td>
                      <td><?= $item['item_reorder_level']; ?></td>
                      <td><?= implode(", ", $customer_data); ?></td>
                      <td>
                        <span class="<?= ($item['item_status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($item['item_status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                      </td>
                      <td>
                        <a href="<?= base_url(); ?>masters/items/<?= $item['item_id'] ?>/duplicate" data-placement="top" data-original-title="Duplicate" data-toggle="tooltip" class="btn btn-success btn-xs tooltips"><i class="icon-copy"></i></a>
                        <a href="<?= base_url(); ?>masters/items/<?= $item['item_id'] ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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
      $("#fileUpload").dropzone({
        acceptedFiles: 'image/*',
        maxFilesize: 2
      });
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
  </script>

</body>

</html>