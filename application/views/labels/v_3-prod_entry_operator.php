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
                    <div class="col-lg-12"><!--//ER-09-18#-54-->
                        <section class="panel">
                            <header class="panel-heading">
                                <h3><i class="icon-map-marker"></i> Production Entry - Operator</h3>
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
                                if(isset($duplicate_id))
                                {
                                  $result = $this->m_masters->getmasterdetails('bud_lbl_prod_entry_operator', 'id', $duplicate_id);
                                  foreach ($result as $row) {
                                    $operator_id = $row['operator_id'];
                                    $item_id = $row['item_id'];
                                    $prod_date = $row['prod_date'];//ER-09-18#-59
                                    $shift = $row['shift'];
                                    $machine_id = $row['machine_id'];
                                    $sample=$row['sample'];
                                  }
                                }
                                else{
                                  $operator_id = '';
                                  $item_id = '';
                                  $prod_date = date("Y-m-d");
                                  $shift = '';
                                  $machine_id = '';
                                  $sample='2';
                                }
                                ?>                                                                                    <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>production/save_operator_entry">
                                    <div class="form-group col-lg-2">
                                       <label for="form">Select Product</label>
                                       <select class="form-control formselect" id="formselect" name="shift" required>
                                          <option value="label" <?=($formselect=='label')?'selected="selected"':''; ?>>Labels</option>
                                          <option value="tapezip" <?=($formselect=='tapezip')?'selected="selected"':''; ?>>Tapes for Zip</option>   
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                       <label for="date">Prod. Date</label><!--ER-07-18#-52-->
                                       <input class="form-control sizeTab" type="date" value="<?=$prod_date; ?>" id="pDate" name="prod_date" required><!--ER-07-18#-52-->
                                    </div>
                                    <!--ER-09-18#-62-->
                                    <div class="form-group col-lg-2">
                                       <label for="machine_id">Machine</label>
                                       <select class="form-control select2 sizeTab" id="machine_id" name="machine_id" required>
                                          <option value="">Select Machine</option>
                                          <?php
                                          foreach ($machines as $row) {
                                             ?>
                                             <option value="<?=$row['machine_id'];?>" <?=($row['machine_id'] == $machine_id)?'selected="selected"':''; ?>><?=$row['machine_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <!--ER-09-18#-62-->
                                    <div class="form-group col-lg-3">
                                       <label for="operator_name">Operator Name</label>
                                       <select class="selects_operator form-control select2" id="operator_name" name="operator_name" required>
                                          <option value="">Select Operator Name</option>
                                          <?php
                                          foreach ($operators as $row) {
                                             ?>
                                             <option value="<?=$row['operator_id'];?>" <?=($row['operator_id'] == $operator_id)?'selected="selected"':''; ?>><?=$row['op_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                       <label for="operator_id">Operator Code</label>
                                       <select class="selects_operator form-control select2" id="operator_id" name="operator_id" required>
                                          <option value="">Select Operator Code</option>
                                          <?php
                                          foreach ($operators as $row) {
                                             ?>
                                             <option value="<?=$row['operator_id'];?>" <?=($row['operator_id'] == $operator_id)?'selected="selected"':''; ?>><?=$row['operator_id'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                       <label for="shift">Shift</label>
                                       <select class="form-control sizeTab" id="shift" name="shift" required>
                                          <option value="Day" <?=($shift == 'Day')?'selected="selected"':''; ?>>Day</option>                                                                            <option value="Night" <?=($shift == 'Night')?'selected="selected"':''; ?>>Night</option>                                                                         </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                       <label for="sample">Sample / Production</label>
                                       <select class="form-control" id="sample" name="sample" required>
                                          <option value="2" <?=($sample == '2')?'selected="selected"':''; ?>>Production</option>
                                          <option value="1" <?=($sample == '1')?'selected="selected"':''; ?>>Sample</option>
                                                                                                                   </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                       <label for="item_id">Item Code</label>
                                       <select class="selects_items form-control select2 sizeTab" id="item_id" name="item_id" required>
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
                                       <select class="selects_items form-control select2 sizeTab" id="item_name" name="item_name" required>
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
                                    <div style="clear:both;"></div>
                                    <div class="col-lg-12" id='size_table'></div>
                                    <div class="col-lg-12"><p class="text-danger">Note for User :</br><b>Note 1: In this form Do not miss any field, you must enter data in right sequence from top to bottom  one by one. other wise you will not get correct results.
                                    </br>
                                    Note 2: IF THE BOX "# OF TAPES RUNNING TODAY IS FREEZED , IT MEANS ENTRY OF THIS MACHINE IS ALREADY DONE. SO CHANGE THE MACHINE NUMBER, SHIFT OR DATE." </b></p></div>
                                    <div class="col-lg-12">
                                      <button class="btn btn-danger save" type="submit" name='save'>Save</button>
                                      <button class="btn btn-success save" type="submit" name="save_continue">Save & continue</button>
                                      <button class="btn btn-info" type="reset">Cancel</button>
                                      <a class="btn-danger btn" target="_blank" href="<?=base_url();?>production/prod_entry_operator_reg_3">Register</a><!--//ER-09-18#-56--><!--//ER-09-18-62-->

                                    </div>
                                </form>
                            </div>
                        </section>
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
        var machine_id=$("#machine_id").val();
        var item_id=$("#item_id").val();
        var shift = $("#shift").val();//ER-09-18#-54
        var p_date = $("#pDate").val();//ER-09-18#-54
        $('#size_table').load('<?=base_url();?>production/get_repeats/'+machine_id+'/'+item_id+'/'+p_date+'/'+shift);//ER-09-18#-54
      });
      /**/
      $(".selects_operator").change(function(){
          $("#operator_name").select2("val", $(this).val());
          $("#operator_id").select2("val", $(this).val());
      });
      $(".selects_items").change(function(){
        $("#item_id").select2("val", $(this).val());
        $("#item_name").select2("val", $(this).val());
      });
      //ER-09-18#-54
      $(".sizeTab").change(function(){
          var machine_id = $("#machine_id").val();
          var item_id = $("#item_id").val();
          var shift = $("#shift").val();
          var p_date = $("#pDate").val();
          $('#size_table').load('<?=base_url();?>production/get_repeats/'+machine_id+'/'+item_id+'/'+p_date+'/'+shift);
      });
      //ER-09-18#-54
    </script>
    <!--<script type="text/javascript">
      //ER-09-18-62
       $(".save").click(function(){
        var sizes=$("input[name='op_time[]']")
              .map(function(){return $(this).val();}).get();
      });
       //ER-09-18-62
    </script>-->
  </body>
</html>

