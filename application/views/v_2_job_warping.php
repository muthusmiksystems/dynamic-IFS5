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
                                <h3><i class="icon-book"></i> Job Sheet - Warping</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Action Messages -->
                      <section class="panel">
                          <header class="panel-heading">
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
                          }                                                    if($this->session->flashdata('error'))
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
                          </header>
                      </section>
                      <!-- End Action Messages -->
                      <!-- Start Talbe List  -->
                      <?php
                      $next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_job_warping'");
                      $next = $next->row(0);
                      $job_no = $next->Auto_increment;

                      $machines = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
                      $items = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
                      $shades = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
                      $deniers = $this->m_masters->getactivemaster('bud_deniermaster', 'denier_status');
                      $staffs = $this->m_masters->getactivemaster('bud_users', 'user_status');
                      $uoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
                      ?>
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>production/jobsheet_warping_save">                                     <section class="panel">
                        <header class="panel-heading">
                            Job No
                            <span class="label label-danger" style="font-size:14px;">W-<?=$job_no; ?></span>
                        </header>
                        <div class="panel-body">
                          <div class="form-group col-lg-3">
                            <label for="job_machine">Machine</label>
                            <select class="select2 form-control" data-placeholder="Select Machine" name="job_machine" id="job_machine">
                              <option value="">Select Machine</option>
                              <?php
                              foreach ($machines as $machine) {
                                ?>
                                <option value="<?=$machine['machine_id'];?>"><?=$machine['machine_name'];?></option>
                                <?php
                              }
                              ?>
                            </select>
                            <input type="hidden" name="machine_speed" id="machine_speed" value="0">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_date">Date</label>
                            <input class="form-control dateplugin" name="job_date" id="job_date" value="<?=date("d-m-Y"); ?>">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_artno">Art No</label>
                            <select class="select2 form-control" name="job_artno" id="job_artno">
                              <option value="">Select Item</option> 
                              <?php
                              foreach ($items as $item) {
                                ?>
                                <option value="<?=$item['item_id']; ?>"><?=$item['item_id']; ?></option>
                                <?php
                              }
                              ?>                                                              </select>
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_item">Item Name</label>
                            <select class="select2 form-control" name="job_item" id="job_item">
                              <option value="">Select Item</option> 
                              <?php
                              foreach ($items as $item) {
                                ?>
                                <option value="<?=$item['item_id']; ?>"><?=$item['item_name']; ?></option>
                                <?php
                              }
                              ?>                                                              </select>
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="job_qty">Total Qty</label>
                            <input class="form-control" name="job_qty" id="job_qty">
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="job_qty_uom">Uom</label>
                            <select class="select2 form-control" data-placeholder="Select Uom" name="job_qty_uom" id="job_qty_uom">
                              <option value="">Select Uom</option>
                              <?php
                              foreach ($uoms as $uom) {
                                ?>
                                <option value="<?=$uom['uom_id'];?>"><?=$uom['uom_name'];?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="job_warping_qty">Warping Qty</label>
                            <input class="form-control" name="job_warping_qty" id="job_warping_qty">
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="job_warping_uom">Uom</label>
                            <select class="select2 form-control" data-placeholder="Select Uom" name="job_warping_uom" id="job_warping_uom">
                              <option value="">Select Uom</option>
                              <?php
                              foreach ($uoms as $uom) {
                                ?>
                                <option value="<?=$uom['uom_id'];?>"><?=$uom['uom_name'];?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="job_no_tapes">No of Tapes</label>
                            <input class="form-control" name="job_no_tapes" id="job_no_tapes">
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="job_po_ref">P.O.Ref</label>
                            <input class="form-control" name="job_po_ref" id="job_po_ref">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_design_code">Design Code</label>
                            <input class="form-control" name="job_design_code" id="job_design_code">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="beams_madeby">Made By</label>
                            <select class="select2 form-control" data-placeholder="Select Operator" name="beams_madeby" id="beams_madeby">
                              <option value="">Select Operator</option>
                              <?php
                              foreach ($staffs as $staff) {
                                ?>
                                <option value="<?=$staff['ID']; ?>"><?=$staff['display_name']; ?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_shift_day">Shift</label>
                            <div style="clear:both;"></div>
                            <label class="radio-inline">
                                <input type="radio" name="job_shift" id="job_shift_day" value="1" checked="checked"> Day
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="job_shift" id="job_shift_night" value="2"> Night
                            </label>
                          </div>
                          <!-- <div style="clear:both;"></div> -->
                          <div class="form-group col-lg-3">
                            <label for="job_time">Time Required for this job</label>
                            <input type="text" class="form-control" name="job_time" id="job_time" readonly="readonly" value="0">
                          </div>
                          <div class="form-group col-lg-3">
                              <label for="combo_id">Select Combo</label>
                              <select class="select2 form-control" data-placeholder="Select Combo" name="combo_id" id="combo_id">
                                <option value="">Select Combo</option>                                                    </select>
                          </div>
                        </div>
                                        <div class="col-lg-12" id="combo_data">
                                          </div>
                                    </section>
                    <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit">Save</button>
                            <button class="btn btn-default" type="button">Cancel</button>
                        </header>
                    </section>
                    </form>
                  </div>
                </div>             <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
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
          $("#tbl").find("select").select2();
          $("#add").click(function () {

            $( "select" ).each(function( i ) {                      $( this ).select2("destroy");
            });

            var $tableBody = $('#tbl').find("tbody"),
            $trFirst = $tableBody.find("tr:first"),
            $trLast = $tableBody.find("tr:last"),
            $trNew = $trFirst.clone();
            $trLast.after($trNew);

            $( "select" ).each(function( i ) {                      $( this ).select2();
            });

            return false;
          });
      });

      //custom select box
      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });
    $(function(){
        $("#job_machine").change(function () {
            var job_machine = $('#job_machine').val();
            var url = "<?=base_url()?>production/get_machine_speed/"+job_machine;
            var postData = 'job_machine='+job_machine;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {                                $('#machine_speed').val(result);
                    var machine_speed = $('#machine_speed').val();
                    var job_warping_qty = $('#job_warping_qty').val();
                    var time = parseInt(job_warping_qty / machine_speed) / parseInt(60);
                    $("#job_time").val(time.toFixed(2));
                }
            });
            return false;
        });
      });

      $(function(){
        $("#job_artno").change(function () {
            var job_artno = $('#job_artno').val();
            $("#job_item").select2("val", job_artno);
            var url = "<?=base_url()?>production/get_color_combos/"+job_artno;
            var postData = 'job_artno='+job_artno;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {                                $('#combo_id').html(result);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#job_item").change(function () {
            var job_item = $('#job_item').val();
            $("#job_artno").select2("val", job_item);
            var url = "<?=base_url()?>production/get_color_combos/"+job_item;
            var postData = 'job_item='+job_item;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {                                $('#combo_id').html(result);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#combo_id").change(function () {
            var combo_id = $('#combo_id').val();
            var job_no_tapes = $('#job_no_tapes').val();
            var job_warping_qty = $('#job_warping_qty').val();
            var url = "<?=base_url()?>production/combo_warping_data/"+combo_id+"/"+job_no_tapes+"/"+job_warping_qty;
            // var postData = 'combo_id='+combo_id+'&job_no_tapes='+job_no_tapes;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    $("#combo_data").load("<?=base_url()?>production/combo_warping_data/"+combo_id+"/"+job_no_tapes+"/"+job_warping_qty);
                }
            });
        });
      });


      $(function(){
        $("#job_warping_qty").keyup(function () {
            var job_warping_qty = $('#job_warping_qty').val();
            var machine_speed = $('#machine_speed').val();
            var time = parseInt(job_warping_qty / machine_speed) / parseInt(60);
            $("#job_time").val(time.toFixed(2));
        });
      });

      $(function(){
        $("#job_no_tapes").keyup(function () {
            var job_no_tapes = $('#job_no_tapes').val();
            $("span.job_no_tapes").html(job_no_tapes);
        });
      });

      $(function(){
          $('select.styled').customSelect();
      });

      //timepicker start
      $('.timepicker-default').timepicker();      

  </script>

  </body>
</html>
