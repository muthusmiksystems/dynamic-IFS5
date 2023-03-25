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
                                <h3><i class="icon-book"></i> Production Entry - Item &amp; Machine wise</h3>
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
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>production/production_e_item_2_save">                                     <section class="panel">
                        <header class="panel-heading">
                            Entry
                        </header>
                        <div class="panel-body">
                          <div class="form-group col-lg-4">
                            <label for="entry_date">Date</label>
                            <input class="datepicker form-control" id="entry_date" name="entry_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                          </div>
                          <div class="form-group col-lg-4">
                            <label for="entry_shift_day">Shift</label>
                            <div style="clear:both;"></div>
                            <label class="radio-inline">
                                <input type="radio" name="entry_shift" id="entry_shift_day" value="1"> Day
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="entry_shift" id="entry_shift_night" value="2"> Night
                            </label>
                          </div>
                        </div>
                        <table class="table table-striped border-top" id="tbl">
                          <thead>
                          <tr>
                              <th>Machine No</th>
                              <th>Operator Name</th>
                              <th>Item Name</th>
                              <th>Weight/Box</th>
                              <th>No of Box</th>
                              <th>Tare Weight</th>
                              <th>Net Weight</th>
                              <th><a href="#" id="add" class="btn btn-primary"><i class="icon-plus"></i> Add</a></th>
                          </tr>
                          </thead>
                          <tbody>
                            <tr id="firstrow">
                              <td>
                                <select class="select2 form-control" data-placeholder="Select Machine" name="machine_no[]" required>
                                  <option value="">Select Machine</option>
                                  <?php
                                  foreach ($machines as $machine) {
                                    ?>
                                    <option value="<?=$machine['machine_id'];?>"><?=$machine['machine_name'];?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                <select class="select2 form-control" data-placeholder="Select Operator" name="operator_name[]" required>
                                  <option value="">Select Operator</option>
                                  <?php
                                  foreach ($staffs as $staff) {
                                    ?>
                                    <option value="<?=$staff['ID']; ?>"><?=$staff['display_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                <select class="select2 form-control" data-placeholder="Select Operator" name="items[]" required>
                                  <option value="">Select Item</option>
                                  <?php
                                  foreach ($items as $item) {
                                    ?>
                                    <option value="<?=$item['item_id']; ?>"><?=$item['item_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                <input type="text" class="weight_box textboxes form-control" name="weight_box[]">
                              </td>
                              <td>
                                <input type="text" class="no_boxes textboxes form-control" name="no_boxes[]">
                              </td>
                              <td>
                                <input type="text" class="tare_weight textboxes form-control" name="tare_weight[]">
                              </td>
                              <td>
                                <input type="text" class="net_weight textboxes form-control" name="net_weight[]">
                              </td>
                              <td>
                                                      </td>
                            </tr>                                              </tbody>
                        </table>
                    </section>
                    <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit">Save</button>
                            <button class="btn btn-default" type="button">Cancel</button>
                        </header>
                    </section>
                    </form>
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


          /*$(".textboxes").each(function (index)
          {               $(this).keyup(function(){ 
                alert(index);
              });
          });*/
      });
    $("input.textboxes").live('keyup', function ()
      {   
        var n = $('input[name="weight_box[]"]').length;
        var weight_box = [];
        $('input[name="weight_box[]"]').each(function() {
            weight_box.push($(this).val());
        });

        var no_boxes = [];
        $('input[name="no_boxes[]"]').each(function() {
            no_boxes.push($(this).val());
        });

        var tare_weight = [];
        $('input[name="tare_weight[]"]').each(function() {
            tare_weight.push($(this).val());
        });

        /*var net_weight = [];
        $('input[name="net_weight[]"]').each(function() {
            net_weight.push($(this).val());
        });*/
        var elems = $('#commentForm').find('.net_weight');
        for (var i = 0; i < n; i++) {
          elems[i].value = parseInt(tare_weight[i]) + parseInt(weight_box[i] * no_boxes[i]);          };
        console.log(elems[0].value);
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });


      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });     

  </script>

  </body>
</html>
