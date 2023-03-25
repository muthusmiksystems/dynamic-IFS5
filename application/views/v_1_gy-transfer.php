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
                                <!-- <h3><i class="icon-user"></i> Gray Yarn Stock Transfer</h3> -->
                                <h3><i class="icon-user"></i> Stock Transfer</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>stock/gy_transfer_save">
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
                                if(!isset($stock_room_id))
                                {
                                  $stock_room_id = '';
                                }
                                ?>
                                <!-- <div class="form-group col-lg-12">
                                   <label>Transfer No:</label>
                                   <span class="label label-danger" style="font-size:24px;">1</span>
                                </div> -->
                                <div class="form-group col-lg-3">
                                   <label for="from_stock_room">From Stock Room</label>
                                   <select class="select2 form-control" id="from_stock_room" name="from_stock_room" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($stock_rooms as $row) {
                                        ?>
                                        <option value="<?=$row['stock_room_id']; ?>" <?=($row['stock_room_id'] == $stock_room_id)?'selected="selected"':''; ?>><?=$row['stock_room_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="to_stock_room">To Stock Room</label>
                                   <select class="select2 form-control" id="to_stock_room" name="to_stock_room" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($stock_rooms as $row) {
                                        ?>
                                        <option value="<?=$row['stock_room_id']; ?>"><?=$row['stock_room_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="received_by">Received by</label>
                                   <select class="select2 form-control" id="received_by" name="received_by" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($users as $row) {
                                        ?>
                                        <option value="<?=$row['ID']; ?>"><?=$row['user_nicename']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                  <label for="transfer_date">Transfer Date</label>
                                  <input type="text" class="dateplugin form-control" name="transfer_date" id="transfer_date" value="<?=date("d-m-Y"); ?>">
                                </div>                                                </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
                        <?php
                        // print_r($gray_yarn_packing);
                        ?>
                        <section class="panel">
                          <div class="panel-body">
                            <table id="example" class="table table-bordered table-striped table-condensed cf packing-register">
                              <thead>
                                <tr>
                                    <th>Sno</th>
                                    <th>Date</th>
                                    <th>Box No</th>
                                    <th>Item Name</th>
                                    <th>Shade Name</th>
                                    <th>Shade No</th>
                                    <th>POY Denier</th>
                                    <th>Gr.Weight</th>
                                    <th>Net Weight</th>
                                    <th>Packed By</th>
                                    <th>
                                      <label class="checkbox-inline">
                                        <input type="checkbox" id="selecctall">
                                        <b>Select All</b>
                                      </label>
                                    </th>
                                </tr>
                                </thead>
                              <tbody>
                                <?php
                                if(isset($gray_yarn_packing))
                                {
                                  $sno = 1;
                                  foreach ($gray_yarn_packing as $row) {
                                      $stock_room_id = $row['stock_room_id'];
                                      ?>
                                      <tr class="odd gradeX">
                                          <td><?=$sno; ?></td>
                                          <td><?=$row['packed_date']; ?></td>                                               <td><?=$row['box_prefix']; ?><?=$row['box_no']; ?></td>                                                                   <td><?=$row['item_name']; ?></td>                                                <td><?=$row['shade_name']; ?></td>                                          <td><?=$row['shade_code']; ?></td>
                                          <td><?=$row['poy_denier_name']; ?></td>
                                          <td><?=$row['gross_weight']; ?></td>
                                          <td><?=number_format($row['net_weight'], 3, '.', ''); ?></td>
                                          <td><?=$row['packed_by']; ?></td>
                                          <td>
                                            <input type="checkbox" class="checkbox" name="selected_boxes[]" value="<?=$row['box_id']; ?>">
                                          </td>
                                      </tr>
                                      <?php                                                            $sno++;                                                            }
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form>                               </div>
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


      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

      $(function(){
        $("#from_stock_room").change(function () {
            var from_stock_room = $('#from_stock_room').val();
            window.location = '<?=base_url()?>stock/gy_transfer/'+from_stock_room;
        });
      });

      $(function(){
        $("#sup_group_id").change(function () {
            var sup_group_id = $('#sup_group_id').val();
            var url = "<?=base_url()?>poy/getsuppliers/"+sup_group_id;
            var postData = 'sup_group_id='+sup_group_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                  $("#supplier_id").html('<option value="">Select</option>');
                  $("#poy_lot").html('<option value="">Select</option>');
                  $("#poy_denier").html('<option value="">Select</option>');
                  $("#supplier_id").select2("val", '');
                  $("#poy_lot").select2("val", '');
                  $("#poy_denier").select2("val", '');
                  $("#supplier_id").html(result);
                }
            });
            return false;
        });
      });
    $('#selecctall').click(function(event) {  //on click
          var no_boxes = 0;
          var net_weight = 0;
          var total_meters = 0;
          if(this.checked) { // check select status
              $('.checkbox').each(function() { //loop through each checkbox
                  this.checked = true;
                  /*var selected = $(this).val();
                  net_weight += parseFloat($("#wt_"+selected).val());
                  total_meters += parseFloat($("#mtr_"+selected).val());
                  no_boxes++;
                  $("#no_boxes").text(no_boxes+" Boxes");
                  $("#total_meters").text(total_meters);
                  $("#net_weight").text(net_weight.toFixed(4));*/
              });
          }else{
              $('.checkbox').each(function() { //loop through each checkbox
                  this.checked = false; //deselect all checkboxes with class "checkbox1"
                  /*$("#no_boxes").text(0+" Boxes");
                  $("#total_meters").text("0");                                $("#net_weight").text("0"); */                           });           }
      });
  </script>

  </body>
</html>
