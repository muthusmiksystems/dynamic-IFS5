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
                <h3><i class="icon-map-marker"></i> Item Size Master</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Item Group Details
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
                if (isset($item_id)) {
                  $item_sizes = explode(",", $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $item_id, 'item_sizes'));
                } else {
                  $item_id = '';
                  $item_sizes = array();
                }
                ?> <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/save_item_size_3">
                  <div class="form-group col-lg-3">
                    <label for="item_name">Item Name</label>
                    <select class="get_outerboxes form-control select2" id="item_name" name="item_name">
                      <option value="">Select Item</option>
                      <?php
                      foreach ($items as $row) {
                      ?>
                        <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="item_code">Item Code</label>
                    <select class="get_outerboxes form-control select2" id="item_code" name="item_code">
                      <option value="">Select Item</option>
                      <?php
                      foreach ($items as $row) {
                      ?>
                        <option value="<?= $row['item_id']; ?>" <?= ($row['item_id'] == $item_id) ? 'selected="selected"' : ''; ?>><?= $row['item_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div style="clear:both;"></div>
                  <div>
                    <h4 class="text-danger">Dear User, please NOTE : Decimal (.) is Not Allowed in the size master. You can use (-) instead of Decimal.</h4>
                  </div>
                  <!--ER-07-18#-52-->
                  <div class="form-group col-lg-11" id="contacts">
                    <?php
                    foreach ($item_sizes as $key => $value) {
                    ?>
                      <div class="form-group col-lg-12 contactsrow">
                        <div class="col-lg-3">
                          <input class="form-control" value="<?= $value; ?>" name="item_sizes[]" type="text">
                        </div>
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
                    <?php
                    }
                    ?>
                  </div>
                  <!-- <div class="form-group col-lg-6">
                                       <label for="item_code">Item Sizes</label>
                                       <input name="item_sizes" id="item_sizes" class="form-control" value="<?= $item_sizes; ?>" />
                                    </div> -->
                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-12">
                    <div>
                      <button class="btn btn-danger" type="submit">Update</button>
                      <button class="btn btn-default" type="button">Cancel</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>

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

    $(".get_outerboxes").change(function() {
      window.location = "<?= base_url(); ?>masters/item_size_3/" + $(this).val();
    });

    $(function() {
      var scntDiv = $('#contacts');
      var i = $('#contacts .contactsrow').size() + 1;
      $(".addrow").live("click", function() {
        var nextrow = '<div class="form-group col-lg-12 contactsrow"><div class="col-lg-3"><input class="form-control"  name="item_sizes[]" type="text"></div><div class="col-lg-3"><button type="button" class="btn btn-danger removerow"><i class="icon-minus"></i> Remove</button></div></div>';
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
  </script>

</body>

</html>