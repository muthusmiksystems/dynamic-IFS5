<!DOCTYPE html><!--//ER-10-18#-68-->
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
                        <section class="panel">                            
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
                                }                                  
                                if($this->session->flashdata('error'))
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
                                <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>reports/roll_entry_report_3">
                                    
                                    <div class="form-group col-lg-3">
                                       <label for="date">From Date</label>
                                       <input class="form-control" type="date" value="<?=$f_date; ?>" id="date" name="from_date" >
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="date">To Date</label>
                                       <input class="form-control" type="date" value="<?=$t_date;?>" id="date" name="to_date" >
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="item_id">Item Code</label>
                                       <select class="selects_items form-control select2" id="item_id" name="item_id">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($items as $row) {
                                             ?>
                                             <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="item_name">Item Name</label>
                                       <select class="selects_items form-control select2" id="item_name" name="item_">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($items as $row) {
                                             ?>
                                             <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="operator_name">Operator Name</label>
                                       <select class="selects_operator form-control select2" id="operator_name" name="operator_name">
                                          <option value="">Select Operator Name</option>
                                          <?php
                                          foreach ($operators as $row) {
                                             ?>
                                             <option value="<?=$row['ID'];?>" <?=($row['ID'] == $operator_id)?'selected="selected"':''; ?>><?=$row['display_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="operator_id">Operator Code</label>
                                       <select class="selects_operator form-control select2" id="operator_id" name="operator_id">
                                          <option value="">Select Operator Code</option>
                                          <?php
                                          foreach ($operators as $row) {
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
                                          <option value="" <?=($shift == '')?'selected="selected"':''; ?>>All</option>
                                          <option value="Day" <?=($shift == 'Day')?'selected="selected"':''; ?>>Day</option>    
                                          <option value="Night" <?=($shift == 'Night')?'selected="selected"':''; ?>>Night</option>
                                       </select>
                                    </div>
                                    
                                    <div style="clear:both;"></div>
                                    <div class="col-lg-3">
                                      <button class="btn btn-danger" type="submit" name="search">search</button>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <!-- Start Talbe List  -->                        
                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="itemlist">
                            <thead>
                              <tr>
                                  <td>#</td>
                                  <td>Date</td>
                                  <td>Operator Name</td>
                                  <td>Item Name</td>
                                  <td>Machine</td>
                                  <td>Shift</td>
                                  <td>Total Sizes</td>
                                  <td>Labels / Tape</td>
                                  <td>Total Tapes</td>
                                  <td>Total Qty</td>
                              </tr>
                              </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                foreach ($entries as $row) {
                                  $no_labels_tape = explode(",", $row->no_labels_tape);
                                  $no_tape = explode(",", $row->no_tape);
                                  $label_sizes = explode(",", $row->label_sizes);
                                  $tot_tape=array();
                                  foreach ($no_labels_tape as $key => $value) {
                                    if(array_key_exists($key,$no_tape)){
                                      $tot_tape[]=$no_tape[$key]*$value;
                                    }
                                  }
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=date('d-M-y',strtotime($row->date)); ?></td>
                                    <td><?=$row->display_name.'/'.$row->operator_id; ?></td>
                                    <td><?=$row->item_name.'/'.$row->item_id; ?></td>
                                    <td><?=$row->machine_name; ?></td>
                                    <td><?=$row->shift; ?></td>
                                    <td><?=implode(', ',$label_sizes); ?></td>
                                    <td><?=implode(', ',$no_labels_tape); ?></td>
                                    <td><?=implode(', ',$no_tape); ?></td>
                                    <td><?=array_sum($tot_tape); ?></td>
                                  </tr>
                                  <?php
                                  $sno++;
                                }
                                ?>
                            </tbody>
                          </table>
                          <!--<a href="#" class="btn btn-primary">Print</a>-->
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
          $("#item_id").select2("val", $(this).val());
          $("#item_name").select2("val", $(this).val());
      });
  </script>

  </body>
</html>
