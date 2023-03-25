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
                <h3><i class="icon-user"></i> General Item Master</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <?php
            if (isset($item_id)) {
              $result = $this->m_masters->getmasterdetails('bud_general_items', 'item_id', $item_id);
              foreach ($result as $row) {
                $group_name = $row['group_name'];
                $item_name = $row['item_name'];
                $item_remarks = $row['item_remarks'];
                $item_categories = explode(",", $row['item_categories']);
                $opening_stock = $row['opening_stock'];
                $concern_id = $row['concern_id'];
                $stockroom_id = $row['stockroom_id'];
                $custody_of = $row['custody_of'];
                $item_sample = $row['item_sample'];
                $is_active = $row['is_active'];
                $hsn_code = $row['hsn_code'];
              }
            } else {
              $item_id = '';
              $group_name = '';
              $item_name = '';
              $opening_stock = '0';
              $concern_id = '';
              $stockroom_id = '';
              $custody_of = '';
              $is_active = '';
              $item_sample = '';
              $item_remarks = '';
              $hsn_code = '';
              $item_categories = array();
            }
            if (isset($duplicate)) {
              $duplicate = $duplicate;
            } else {
              $duplicate = '';
            }
            ?>
            <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/generalItemSave">
              <input type="hidden" name="duplicate" value="<?= $duplicate; ?>">
              <section class="panel">
                <header class="panel-heading">
                  Item Code
                  <span class="label label-danger" style="font-size:14px;"><?= ($item_id == '') ? $next_item : $item_id; ?></span>
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
                  <input type="hidden" name="item_id" value="<?= $item_id; ?>">
                  <div class="form-group col-lg-3">
                    <label for="group_name">Group Name</label>
                    <select class="form-control select2" id="group_name" name="group_name" required>
                      <option value="">Select Group</option>
                      <?php
                      foreach ($itemgroups as $row) {
                      ?>
                        <option value="<?= $row['group_id']; ?>" <?= ($row['group_id'] == $group_name) ? 'selected="selected"' : ''; ?>><?= $row['group_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="item_name">Item Name</label>
                    <input type="text" class="form-control" value="<?= $item_name; ?>" name="item_name" id="item_name" required>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="item_name">HSN Code</label>
                    <input type="number" class="form-control" value="<?= $hsn_code; ?>" name="hsn_code" id="hsn_code" required>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="opening_stock">Opening Stock</label>
                    <input type="text" class="form-control" value="<?= $opening_stock; ?>" name="opening_stock" id="opening_stock">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="concern_id">Concern Name</label>
                    <select class="form-control select2" id="concern_id" name="concern_id">
                      <option>Select Concern</option>
                      <?php
                      foreach ($concerns as $row) {
                      ?>
                        <option value="<?= $row['concern_id']; ?>" <?= ($row['concern_id'] == $concern_id) ? 'selected="selected"' : ''; ?>><?= $row['concern_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="stockroom_id">Stock Room</label>
                    <select class="form-control select2" id="stockroom_id" name="stockroom_id">
                      <option>Select</option>
                      <?php
                      foreach ($stockrooms as $row) {
                      ?>
                        <option value="<?= $row['stock_room_id']; ?>" <?= ($row['stock_room_id'] == $stockroom_id) ? 'selected="selected"' : ''; ?>><?= $row['stock_room_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="custody_of">Custody Of</label>
                    <select class="form-control select2" id="custody_of" name="custody_of">
                      <option value="">Select</option>
                      <?php
                      foreach ($users as $row) {
                      ?>
                        <option value="<?= $row['ID']; ?>" <?= ($row['ID'] == $custody_of) ? 'selected="selected"' : ''; ?>><?= $row['user_login']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="item_remarks">Remarks</label>
                    <textarea class="form-control" name="item_remarks" id="item_remarks" required><?= $item_remarks; ?></textarea>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="is_active">Active</label>
                    <input type="checkbox" style="width: 20px;" <?= ($is_active == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="is_active" name="is_active" />
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="sample_file">Sample</label>
                    <input type="hidden" name="old_item_sample" value="<?= $item_sample; ?>">
                    <input class="form-control" id="sample_file" name="sample_file" type="file">
                  </div>
                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-12">
                    <label>Category</label>
                    <div style="clear:both;"></div>
                    <?php
                    asort($categories);
                    foreach ($categories as $row) {
                    ?>
                      <label class="checkbox-inline">
                        <input name="item_categories[]" <?= (in_array($row['category_id'], $item_categories)) ? 'checked="checked"' : ''; ?> type="checkbox" required value="<?= $row['category_id']; ?>"> <?= $row['category_name']; ?>
                      </label>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit"><?= ($item_id != '') ? 'Update' : 'Save'; ?></button>
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
                General Items
              </header>
              <script>
                var data = [];
              </script>



              <table class="table table-bordered" id="sample_1x">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Group</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>HSN Code</th>
                    <th>Categories</th>
                    <th>Remarks</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <?php
                $sno = 1;
                foreach ($items as $row) {
                  $category_names = array();
                  $item_id = $row['item_id'];
                  $group_name = $row['group_name'];
                  $item_name = $row['item_name'];
                  $hsn_code = $row['hsn_code'];
                  $item_sample = $row['item_sample'];
                  $item_remarks = $row['item_remarks'];
                  $item_categories = explode(",", $row['item_categories']);
                  $is_active = $row['is_active'];
                  foreach ($categories as $row) {
                    if (in_array($row['category_id'], $item_categories)) {
                      $category_names[] = $row['category_name'];
                    }
                  }

                  $img = '';
                  if ($item_sample != '') :
                    $img = '<img src="' . base_url('uploads/itemsamples/general/' . $item_sample) . '" height="50">';
                  endif;

                  $status = '<span class="' . (($is_active == 1) ? 'label label-success' : 'label label-danger') . '">' . (($row['is_active'] == 1) ? 'Active' : 'Inactive') . '</span>';
                ?>

                  <script>
                    data.push(['<?= $sno; ?>', '<?= $this->m_masters->getmasterIDvalue('bud_general_item_groups', 'group_id', $group_name, 'group_name'); ?>', '<?= $item_id; ?>', '<?= $item_name; ?>', '<?= $hsn_code; ?>', '<?= implode(",", $category_names); ?>', '<?= $item_remarks; ?>', '<?= $img; ?>', '<?= $status; ?>', '<a href="<?= base_url(); ?>general/generalItemMaster/<?= $item_id; ?>/duplicate" data-placement="top" data-original-title="Duplicate" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Duplicate</a><a href="<?= base_url(); ?>general/generalItemMaster/<?= $item_id; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a><a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>']);
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