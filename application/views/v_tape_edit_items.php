<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title><?=$page_title; ?> | INDOFILA SYNTHETICS</title>

    <!-- Bootstrap core CSS -->
    <?php
    foreach ($css as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet">
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
                                <h3><i class="icon-map-marker"></i> Item Master</h3>
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
                                if($this->session->flashdata('warning'))
                                {
                                  ?>
                                  <div class="alert alert-warning fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                                  </div>
                                  <?php
                                }                                                          if($this->session->flashdata('error'))
                                {
                                  ?>
                                  <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                                </div>
                                  <?php
                                }
                                if($this->session->flashdata('success'))
                                {
                                  ?>
                                  <div class="alert alert-success alert-block fade in">
                                      <button data-dismiss="alert" class="close close-sm" type="button">
                                          <i class="icon-remove"></i>
                                      </button>
                                      <h4>
                                          <i class="icon-ok-sign"></i>
                                          Success!
                                      </h4>
                                      <p><?=$this->session->flashdata('success'); ?></p>
                                  </div>
                                  <?php
                                }
                                ?>
                                <?php
                                foreach ($items as $item) {
                                  $item_id = $item['item_id'];
                                  $item_category = $item['item_category'];
                                  $item_group = $item['item_group'];
                                  $item_name = $item['item_name'];
                                  $item_second_name = $item['item_second_name'];
                                  $item_third_name = $item['item_third_name'];
                                  $item_width = $item['item_width'];                                                            $total_metrs = $item['total_metrs'];                                                            $total_weight = $item['total_weight'];                                                            $item_weight_mtr = $item['item_weight_mtr'];                                                            $item_status = $item['item_status'];
                                  $item_sample = $item['item_sample'];
                                  $hsn = $item['hsn_code'];
                                }
                                ?>
                                <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/items_tape_update">                                                                <input type="hidden" name="item_id" value="<?=$item_id; ?>">                                                                <input type="hidden" name="item_category" value="<?=$item_category; ?>">                                                                <div class="form-group col-lg-12">
                                        <label for="item_name" class="control-label col-lg-2">Item Code No / Art No:</label>
                                        <div class="col-lg-10">
                                          <span class="label label-danger" style="font-size:24px;"><?=$item_id; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_created_on" class="control-label col-lg-2">Date</label>
                                        <div class="col-lg-10">
                                          <input class="dateplugin form-control" value="<?=date('d-m-Y'); ?>" id="item_created_on" name="item_created_on" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_group" class="control-label col-lg-2">Group Name</label>
                                        <div class="col-lg-10">
                                          <select class="form-control select2" name="item_group" id="item_group" required>
                                            <option value="">Select Group</option>
                                            <?php
                                            foreach ($itemgroups as $group) {
                                              ?>
                                              <option value="<?=$group['group_id']; ?>" <?=($group['group_id'] == $item_group)?'selected="selected"':''; ?>><?=$group['group_name']; ?></option>
                                              <?php
                                            }
                                            ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_name" class="control-label col-lg-2">Item Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_name" name="item_name" value="<?=$item_name; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_second_name" class="control-label col-lg-2">Item Second Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_second_name" name="item_second_name" value="<?=$item_second_name; ?>" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_third_name" class="control-label col-lg-2">Item Third Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_third_name" name="item_third_name" value="<?=$item_third_name; ?>" type="text" required>                                                                                                                     </div>
                                    </div>
                                     <div class="form-group col-lg-12">
                                        <label for="item_third_name" class="control-label col-lg-2">HSN Code</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="hsn" name="hsn" value="<?=$hsn; ?>" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_width" class="control-label col-lg-2">Item Width</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_width" name="item_width" value="<?=$item_width; ?>" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="total_metrs" class="control-label col-lg-2">Total Meters</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" value="<?=$total_metrs; ?>" id="total_metrs" name="total_metrs" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="total_weight" class="control-label col-lg-2">Total Weight (grams)</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" value="<?=$total_weight; ?>" id="total_weight" name="total_weight" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_weight_mtr" class="control-label col-lg-2">Weight/Meter (grams)</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_weight_mtr" name="item_weight_mtr" value="<?=$item_weight_mtr; ?>" type="text" required>                                                                                                                     </div>
                                    </div>                                                            <div class="form-group col-lg-12">
                                        <label for="item_status" class="control-label col-lg-2">Active</label>
                                        <div class="col-lg-10">
                                            <input  type="checkbox" style="width: 20px;float:left;" class="checkbox form-control" <?=($item_status == 1)?'checked="ckecked"':''; ?> value="1" id="item_status" name="item_status" />
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="sample_file" class="control-label col-lg-2">Sample</label>
                                        <div class="col-lg-10">
                                            <input type="hidden" name="old_item_sample" value="<?=$item_sample; ?>">
                                            <input  id="sample_file" name="sample_file" type="file">
                                        </div>
                                    </div>
                                    <?php
                                    if($item_sample != '')
                                    {
                                      ?>
                                      <div class="form-group col-lg-12">
                                        <img src="<?=base_url(); ?>uploads/quote/<?=$item_sample; ?>" style="width:auto;height:100px;max-width:100%;">
                                      </div>
                                      <?php
                                    }
                                    ?>
                                    <div style="clear:both;"></div>
                                    <div class="clear"></div>
                                    <div class="form-group col-lg-12">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" type="submit">Update</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <!-- End Form Section -->
                    </div>
                </div>             <!-- page end-->
            </section>
      </section>
      <!--main content end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php
    foreach ($js as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>    

    <!--common script for all pages-->
    <?php
    foreach ($js_common as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

    <!--script for this page-->
    <?php
    foreach ($js_thispage as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
