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
                                <h3><i class="icon-map-marker"></i> Roll Entry</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">                                                <div class="panel-body">
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
                                if(isset($duplicate_id))
                                {
                                  $result = $this->m_masters->getmasterdetails('bud_lbl_rollentry', 'id', $duplicate_id);
                                  foreach ($result as $row) {
                                    $item_id = $row['item_id'];
                                    $operator_id = $row['operator_id'];
                                    $machine_no = $row['machine_no'];
                                    $date = $row['date'];
                                    $shift = $row['shift'];
                                  }
                                }
                                else
                                {
                                  $duplicate_id = '';
                                  $item_id = '';
                                  $operator_id = '';
                                  $item_id = '';
                                  $machine_no = '';
                                  $date = '';
                                  $shift = '';
                                }

                                if(isset($view_item_id))
                                {
                                  $item_sizes = explode(",", $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $view_item_id, 'item_sizes'));
                                  $item_width = $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $view_item_id, 'item_width');
                                }
                                else
                                {
                                  $item_id = '';
                                  $item_width = 0;
                                  $item_sizes = array();
                                }
                                ?>                                                                                    <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>production/save_roll_entry_3">
                                                                <div class="form-group col-lg-3">
                                       <label for="date">Date</label>
                                       <input class="form-control" value="<?=date("d-m-Y"); ?>" id="date" name="date" readonly="">
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="item_id">Item Code</label>
                                       <select class="selects_items form-control select2" id="item_id" name="item_id">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($items as $row) {
                                             ?>
                                             <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $view_item_id)?'selected="selected"':''; ?>><?=$row['item_id'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="item_name">Item Name</label>
                                       <select class="selects_items form-control select2" id="item_name" name="item_name">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($items as $row) {
                                             ?>
                                             <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $view_item_id)?'selected="selected"':''; ?>><?=$row['item_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="operator_name">Packing Staff Name</label>
                                       <select class="selects_operator form-control select2" id="operator_name" name="operator_name">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($staffs as $row) {
                                             ?>
                                             <option value="<?=$row['ID'];?>" <?=($row['ID'] == $operator_id)?'selected="selected"':''; ?>><?=$row['display_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="operator_id">Packing Staff Code</label>
                                       <select class="selects_operator form-control select2" id="operator_id" name="operator_id">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($staffs as $row) {
                                             ?>
                                             <option value="<?=$row['ID'];?>" <?=($row['ID'] == $operator_id)?'selected="selected"':''; ?>><?=$row['ID'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="machine_no">Machine </label>
                                       <select class="form-control select2" id="machine_no" name="machine_no">
                                          <option value="">Select</option>
                                          <?php
                                          foreach ($machines as $row) {
                                             ?>
                                             <option value="<?=$row['machine_id']; ?>" <?=($row['machine_id'] == $machine_no)?'selected="selected"':''; ?>><?=$row['machine_name']; ?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="shift">Shift</label>
                                       <select class="form-control" id="shift" name="shift">
                                          <option value="Day" <?=($shift == 'Day')?'selected="selected"':''; ?>>Day</option>                                                                            <option value="Night" <?=($shift == 'Night')?'selected="selected"':''; ?>>Night</option>                                                                         </select>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="form-group col-lg-6">
                                      <table class="table table-bordered table-condensed">
                                        <tr>
                                          <td><label>Size</label></td>
                                          <td></td>
                                          <td>
                                            <label style="color:red;font-size:18px;">No of Labels<br>in each tape</label>                                                                             </td>
                                          <td><label>Total Number<br>of Tapes</label></td>
                                          <td><label>Total Production<br>Qty(Pcs)</label></td>
                                          <td><label>Machine Run Time<br>(Hrs)</label></td>
                                        </tr>
                                        <?php
                                        foreach ($item_sizes as $key => $value) {
                                          ?>
                                          <tr>
                                            <td><strong style="font-size:22px;"><?=$value; ?></strong></td>
                                            <td><strong style="font-size:22px;">=</strong></td>
                                            <td><input class="form-control" name="no_labels_tape[<?=$value; ?>]" type="text"></td>
                                            <td><input class="form-control" value="" name="no_tape[<?=$value; ?>]" type="text"></td>
                                            <td></td>
                                            <td></td>
                                          </tr>
                                          <?php
                                        }
                                        ?>
                                      </table>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="col-lg-3">
                                      <button class="btn btn-danger" type="submit">Save</button>
                                      <button class="btn btn-default" type="button">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="itemlist">
                            <thead>
                              <tr>
                                  <td></td>
                                  <td>#</td>
                                  <td>Date</td>
                                  <td>Operator Name</td>
                                  <td>Operator Code</td>
                                  <td>Item Name</td>
                                  <td>Item Code</td>
                                  <td>Shift</td>
                                  <td>Total Sizes</td>
                                  <td>Labels / Tape</td>
                                  <td>Total Tapes</td>
                                  <td>Total Qty</td>
                                  <td>Machine Run<br>Time(Hrs)</td>
                                  <td></td>
                              </tr>
                              </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                foreach ($today_rolls as $row) {
                                  $no_labels_tape = explode(",", $row['no_labels_tape']);
                                  $no_tape = explode(",", $row['no_tape']);
                                  $label_sizes = explode(",", $row['label_sizes']);
                                  ?>
                                  <tr>
                                    <td><input type="checkbox"></td>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['date']; ?></td>
                                    <td><?=$row['display_name']; ?></td>
                                    <td><?=$row['operator_id']; ?></td>
                                    <td><?=$row['item_name']; ?></td>
                                    <td><?=$row['item_id']; ?></td>
                                    <td><?=$row['shift']; ?></td>
                                    <td><?=sizeof($label_sizes); ?></td>
                                    <td><?=implode(",", $no_labels_tape); ?></td>
                                    <td><?=$no_tape[0]; ?></td>
                                    <td><?=(array_sum($no_labels_tape) * $no_tape[0]); ?></td>
                                    <td></td>
                                    <td>
                                      <a href="<?=base_url(); ?>production/roll_entry_3/<?=$row['item_id']; ?>/<?=$row['id']; ?>" class="btn btn-danger">Duplicate</a>
                                    </td>
                                  </tr>
                                  <?php
                                  $sno++;
                                }
                                ?>
                            </tbody>
                          </table>
                          <a href="#" class="btn btn-primary">Print</a>
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
      $(".selects_operator").change(function(){
          $("#operator_name").select2("val", $(this).val());
          $("#operator_id").select2("val", $(this).val());
      });
      $(".selects_items").change(function(){
          window.location = "<?=base_url(); ?>production/roll_entry_3/"+$(this).val();
          /*$("#item_name").select2("val", $(this).val());
          $("#item_id").select2("val", $(this).val());*/
      });
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      $(".col-sm-6.right").append('<div class="dataTables_filter col-sm-6" style="float:left;"><label>Search Item Code: <input type="text" class="form-control" id="itemcode_search" style="width:50%;"></label></div>');

      
  </script>

  </body>
</html>
