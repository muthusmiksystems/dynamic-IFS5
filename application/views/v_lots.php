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
                <h3><i class="icon-user"></i> Print Lot Slip Machine Wise</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Lot Details
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
                if (isset($lot_id)) {
                  $editlots = $this->m_masters->getmasterdetails('bud_lots', 'lot_id', $lot_id);
                  foreach ($editlots as $lot) {
                    $lot_category = $lot['category'];
                    $lot_prefix = $lot['lot_prefix'];
                    $lot_no = $lot['lot_no'];
                    $lot_shade_no = $lot['lot_shade_no'];
                    $lot_oil_required = $lot['lot_oil_required'];
                    $lot_qty = $lot['lot_qty'];
                    $lot_actual_qty = $lot['lot_actual_qty'];
                    $lot_status = $lot['lot_status'];
                  }
                  $action = 'updatelots';
                } else {
                  $lot_id = '';
                  $lot_category = '';
                  $lot_prefix = '';
                  $lot_no = '';
                  $lot_shade_no = '';
                  $lot_oil_required = '';
                  $lot_qty = '';
                  $lot_actual_qty = '';
                  $lot_status = '';
                  $action = 'savelots';
                }
                ?>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/lots/<?= $lot_id; ?>">
                  <input type="hidden" name="lot_id" value="<?= $lot_id; ?>">
                  <input type="hidden" name="lot_no" value="<?= $lot_no; ?>">
                  <div class="form-group col-lg-12">
                    <h2>Lot No : <span style="color:red"><?= $nextlot; ?></span></h2>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="lot_prefix">Machine</label>
                    <select name="lot_prefix" class="form-control">
                      <?php
                      foreach ($machines as $machine) {
                      ?>
                        <option value="<?= $machine['machine_id']; ?>" <?= ($machine['machine_id'] == $lot_prefix) ? 'selected="selected"' : ''; ?>><?= $machine['machine_prefix']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="shade_name">Shade Name / No</label>
                    <select class="select2 form-control shade" name="lot_shade_no" id="shade_name" required>
                      <option value="">Select Shade</option>
                      <?php
                      foreach ($shades as $shade) {
                      ?>
                        <option value="<?= $shade['shade_id']; ?>" <?= ($shade['shade_id'] == $lot_shade_no) ? 'selected="selected"' : ''; ?>><?= $shade['shade_name']; ?> / <?= $shade['shade_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="shade_code">Shade Code</label>
                    <select class="select2 form-control shade" id="shade_code" required>
                      <option value="">Select Code</option>
                      <?php
                      foreach ($shades as $shade) {
                      ?>
                        <option value="<?= $shade['shade_id']; ?>" <?= ($shade['shade_id'] == $lot_shade_no) ? 'selected="selected"' : ''; ?>><?= $shade['shade_code']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="shade_code">Oil Required</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="lot_oil_required" id="lot_oil_required" value="<?= $lot_oil_required; ?>" required>
                      <span class="input-group-addon">%</span>
                    </div>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="recipe_category">Recipe Category</label>
                    <select class="select2 form-control" name="recipe_category" id="recipe_category">
                      <option value="">Select Category</option>
                      <?php
                      foreach (@$categorymasters as $item) {
                      ?>
                        <option value="<?= $item->category_id; ?>"><?= $item->category_name; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="recipe_master_id">Recipe Master</label>
                    <select class="select2 form-control" name="recipe_master_id" id="recipe_master_id">
                      <option value="">Select Recipe</option>
                      <?php
                      foreach (@$recipe_list as $recipeitem) {
                      ?>
                        <option value="<?= $recipeitem->recipe_id; ?>">RCP<?= $recipeitem->recipe_id; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="lot_qty">Lot Qty</label>
                    <input type="text" class="form-control" name="lot_qty" id="lot_qty" value="<?= $lot_qty; ?>" required>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="lot_status">Status</label>
                    <label class="checkbox">
                      <input type="checkbox" <?= ($lot_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox" value="1" id="lot_status" name="lot_status" />
                      Active
                    </label>
                  </div>

                  <div class="form-group col-lg-3">
                    <a class="btn btn-danger" href="<?= base_url() ?>masters/recipemaster">Recipe Master</a>
                  </div>

                  <div class="clear"></div>

                  <div class="">
                    <div class="col-lg-10">
                      <button class="btn btn-danger" type="submit" name="submit" value="submit">Save</button>
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
                Lots
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Lot No</th>
                    <th>Color Name</th>
                    <th>Color Code</th>
                    <th>Shade Code</th>
                    <th>Lot Qty</th>
                    <th>Oil Required</th>
                    <th>Target Qty</th>
                    <th>Packed Qty</th>
                    <th>Diff</th>
                    <th>Status</th>
                    <th class="hidden-phone"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  $key = 'lot-qty';
                  foreach ($lots as $lot) {
                    $lot_id = $lot->lot_id;
                    $lot_shade_no = $lot->lot_shade_no;
                    $lot_qty_text = $lot->lot_qty;
                    // $lot_qty_text = $encrypted_string = $this->encrypt->encode($lot->lot_qty, $key);
                  ?>
                    <tr>
                      <td><?= $sno; ?></td>
                      <td>
                        <?= $lot->lot_no; ?>
                      </td>
                      <td><?= $lot->shade_name; ?></td>
                      <td><?= $lot->lot_shade_no; ?></td>
                      <td><?= $lot->shade_code; ?></td>
                      <td><?= $lot->lot_qty; ?></td>
                      <td><?= $lot->lot_oil_required; ?> %</td>
                      <td><?= $lot->lot_actual_qty; ?></td>
                      <td>0</td>
                      <td></td>
                      <td class="hidden-phone">
                        <span class="<?= ($lot->lot_status == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($lot->lot_status == 1) ? 'Active' : 'Inactive'; ?></span>
                      </td>
                      <td>
                        <a href="<?= base_url('masters/recipe_print/null/' . $lot_shade_no . '/' . $lot_qty_text . '/' . $lot->lot_id); ?>" class="btn btn-xs btn-warning">Print Recipe</a>
                        <a href="<?= base_url(); ?>masters/lots/<?= $lot->lot_id ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                        <!-- <a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a> -->
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
      $("#category").change(function() {
        var category = $('#category').val();
        // alert(category);
        var url = "<?= base_url() ?>masters/getLotscategorydatas/" + category;
        var postData = 'category=' + category;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(shades) {
            $("#lot_shade_no").html(shades);
          }
        });
        return false;
      });
    });

    $(".shade").change(function() {
      $("#shade_name").select2("val", $(this).val());
      $("#shade_code").select2("val", $(this).val());
    });
  </script>

</body>

</html>