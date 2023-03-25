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
                                <h3><i class="icon-map-marker"></i> Final Packing Entry</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Update Gross Weight
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
                                if(isset($selected_box))
                                {
                                  $result = $this->m_masters->getmasterdetails('bud_lbl_outerboxes', 'box_no', $selected_box);
                                  foreach ($result as $row) {
                                    $packing_gr_weight = $row['packing_gr_weight'];
                                  }
                                }
                                else
                                {
                                  $packing_gr_weight = null;
                                }
                                ?>                                                                                    <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>production/update_final_packing_3">
                                   <div class="form-group col-lg-3">
                                       <label for="box_no">Box No</label>
                                       <select class="form-control select2" id="box_no" name="box_no" required>
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($boxes as $row) {
                                             ?>
                                             <option value="<?=$row['box_no'];?>" <?=($row['box_no'] == $selected_box)?'selected="selected"':''; ?>><?=$row['box_no'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>                                                                <div class="form-group col-lg-3">
                                       <label for="packing_gr_weight">Gross Weight</label>
                                       <input class="form-control" value="<?=$packing_gr_weight; ?>" id="packing_gr_weight" name="packing_gr_weight" type="text" required>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="col-lg-3">
                                      <button class="btn btn-danger" type="submit">Save</button>
                                      <button class="btn btn-default" type="button">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <!-- Start Talbe List  --> 
                        <section class="panel">
                          <header class="panel-heading">
                              Search
                          </header>
                          <div class="panel-body">
                              <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>production/final_packing_entry_3">
                                <div class="col-lg-12">
                                  <div class="form-group col-lg-4">
                                     <label for="from_date">From</label>
                                     <input class="form-control datepicker" value="<?=date("d-m-Y"); ?>" id="from_date" name="from_date" type="text" required>
                                  </div>
                                  <div class="form-group col-lg-4">
                                     <label for="to_date">To</label>
                                     <input class="form-control datepicker" value="<?=date("d-m-Y"); ?>" id="to_date" name="to_date" type="text" required>
                                  </div>
                                  <div class="form-group col-lg-4">
                                    <label>&emsp;</label>
                                    <div class="clear:both;"></div>
                                    <button class="btn btn-primary" type="submit" name="search">Search</button>                                                              </div>
                                </div>
                              </form>
                            </div>
                        </section>                                       <section class="panel">
                          <header class="panel-heading">
                              Result
                          </header>
                          <table class="table table-striped border-top" id="itemlist">
                            <thead>
                              <tr>
                                  <td>#</td>
                                  <td>Box No</td>
                                  <td>Date</td>
                                  <td>Item Code</td>
                                  <td>Item Name</td>
                                  <td>Total Qty</td>
                                  <td>Gr. Weight</td>
                                  <td></td>
                              </tr>
                              </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                foreach ($outerboxes as $row) {
                                  $box_prefix = $row['box_prefix'];
                                  $box_no = $row['box_no'];
                                  $item_id = $row['item_id'];
                                  $item_name = $row['item_name'];
                                  $date_time = $row['date_time'];
                                  $packing_gr_weight = $row['packing_gr_weight'];
                                  $predelivery_status = $row['predelivery_status'];
                                  $delivery_status = $row['delivery_status'];
                                  $total_qty = $row['SUM(`total_qty`)'];
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$box_prefix; ?>-<?=$box_no; ?></td>
                                    <td><?=$date_time; ?></td>
                                    <td><?=$item_id; ?></td>
                                    <td><?=$item_name; ?></td>
                                    <td><?=$total_qty; ?></td>
                                    <td><?=$packing_gr_weight; ?></td>
                                    <td>
                                      <?php
                                      if($packing_gr_weight > 0)
                                      {
                                        ?>
                                        <a href="<?=base_url(); ?>production/final_packing_entry_3/<?=$box_no; ?>" class="btn btn-danger">Select</a>
                                        <?php
                                      }
                                      else
                                      {
                                        ?>
                                        <a href="<?=base_url(); ?>production/final_packing_entry_3/<?=$box_no; ?>" class="btn btn-success">Select</a>
                                        <?php
                                      }
                                      ?>
                                        <a target="_blank" href="<?=base_url(); ?>production/print_final_pack_slip_3/<?=$box_no; ?>" class="btn btn-danger">Print</a>
                                      <?php
                                      $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
                                      if($is_admin && $predelivery_status != 0 && $delivery_status != 0)
                                      {
                                        ?>
                                        <a href="<?=base_url(); ?>production/delete_box_3/<?=$box_no; ?>" class="btn btn-danger">Delete</a>
                                        <?php
                                      }
                                      ?>
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
      $(".col-sm-6.right").append('<div class="dataTables_filter col-sm-6" style="float:left;"><label>Search Item Code: <input type="text" class="form-control" id="itemcode_search" style="width:50%;"></label></div>');
      $(".selects_operator").change(function(){
          $("#operator_name").select2("val", $(this).val());
          $("#operator_id").select2("val", $(this).val());
      });
      $(".selects_items").change(function(){
          window.location = "<?=base_url(); ?>production/prod_entry_operator_3/"+$(this).val();
          /*$("#item_name").select2("val", $(this).val());
          $("#item_id").select2("val", $(this).val());*/
      });
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      // $(".col-sm-6.right").append('<div class="dataTables_filter col-sm-6" style="float:left;"><label>Search Item Code: <input type="text" class="form-control" id="itemcode_search" style="width:50%;"></label></div>');

      
  </script>

  </body>
</html>
