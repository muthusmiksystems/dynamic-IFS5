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
      <section class="wrapper sh_delivery">
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                <h3><i class=" icon-truck"></i> Pre Delivery</h3>
              </header>
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <?php
            if ($this->session->flashdata('warning')) {
            ?>
              <section class="panel">
                <header class="panel-heading">
                  <div class="alert alert-warning fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="icon-remove"></i>
                    </button>
                    <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                  </div>
                </header>
              </section>
            <?php
            }
            if ($this->session->flashdata('error')) {
            ?>
              <section class="panel">
                <header class="panel-heading">
                  <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="icon-remove"></i>
                    </button>
                    <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                  </div>
                </header>
              </section>
            <?php
            }
            if ($this->session->flashdata('success')) {
            ?>
              <section class="panel">
                <header class="panel-heading">
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
                </header>
              </section>
            <?php
            }
            ?>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Read Barcode
              </header>
              <div class="panel-body">
                <div id="formResponse"></div>
                <form action="<?php echo base_url('delivery/barcode_predel_add_item'); ?>" id="barcodeSearch" method="post">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <div class="input-group input-group-sm">
                        <input name="barcode_no" id="barcode_no" onmouseover="this.focus();" class="form-control input-sm" type="text">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-primary" name="search" value="search">Search</button>
                        </span>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>
        </div>

        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>delivery/predelivery">
          <input type="hidden" name="packing_category" value="<?= $this->session->userdata('user_viewed'); ?>">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  Pre Delivery
                  <span class="label label-danger" style="font-size:14px;"><?= $next_p_del_id; ?></span>
                </header>
                <div class="panel-body">
                  <div class="form-group col-md-2">
                    <label for="from_date" class="text-large">From</label>
                    <input class="dateplugin form-control" id="from_date" value="<?= $from_date; ?>" name="from_date" type="text" required>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="to_date" class="text-large">To</label>
                    <input class="dateplugin form-control" id="to_date" value="<?= $to_date; ?>" name="to_date" type="text" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label class="text-large">Item Group</label>
                    <select class="select2 form-control" name="item_group_id" id="item_group_id">
                      <option value="">Select</option>
                      <?php if (sizeof($item_groups) > 0) : ?>
                        <?php foreach ($item_groups as $row) : ?>
                          <option value="<?php echo $row->group_id; ?>" <?php echo ($row->group_id == $item_group_id) ? 'selected=""selected' : ''; ?>><?php echo $row->group_name; ?>/<?php echo $row->group_id; ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="item_name" class="text-large">Item Name</label>
                    <select class="get_outerboxes form-control select2" id="item_name" name="item_name">
                      <option value="">Select Item</option>
                      <?php
                      foreach ($items as $item) {
                      ?>
                        <option value="<?= $item['item_id']; ?>" <?= ($item['item_id'] == $item_name) ? 'selected="selected"' : ''; ?>><?= $item['item_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="item_code" class="text-large">Item Code</label>
                    <select class="get_outerboxes form-control select2" id="item_code" name="item_code">
                      <option value="">Select Item</option>
                      <?php
                      foreach ($items as $item) {
                      ?>
                        <option value="<?= $item['item_id']; ?>" <?= ($item['item_id'] == $item_name) ? 'selected="selected"' : ''; ?>><?= $item['item_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div style="clear:both"></div>
                  <div class="form-group col-lg-3">
                    <button class="btn btn-danger" type="submit" name="search">Search</button>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </form>
        <?php
        $tot_boxes = 0;
        $tot_gr_weight = 0;
        $tot_nt_weight = 0;
        foreach ($d_outerboxes as $row) {
          $tot_boxes++;
          $tot_gr_weight += $row['gross_weight'];
          $tot_nt_weight += $row['net_weight'];
        }
        ?>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <div class="panel-body">
                <div class="responsive">
                  <table class="table table-bordered packing-boxes" id="predelivery_boxes" style="width: 750px;">
                    <thead>
                      <tr class="total-row">
                        <th></th>
                        <th><?php echo $tot_boxes; ?></th>
                        <th>Boxes</th>
                        <th colspan="2" class="text-center">Total Qty</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?php echo $tot_gr_weight; ?></th>
                        <th><?php echo $tot_nt_weight; ?></th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr class="total-row">
                        <th></th>
                        <th><label id="no_boxes">0</label></th>
                        <th>Boxes</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><label id="total_meters">0</label></th>
                        <th><label id="net_weight">0</label></th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr>
                        <th>#</th>
                        <th>Box No</th>
                        <th>Group</th>
                        <th>Item</th>
                        <th>Item Code</th>
                        <th>Shade Name</th>
                        <th>Shade No</th>
                        <th>S.Lot No</th>
                        <th>M.Lot No</th>
                        <th># of Cones</th>
                        <th>Gr.Weight</th>
                        <th>Nt.Weight</th>
                        <th>Stock Room</th>
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
                      $sno = 1;
                      foreach ($d_outerboxes as $row) {
                        $no_of_cones = $row['no_of_cones'];
                        if ($row['box_prefix'] == 'G' || $row['box_prefix'] == 'S') {
                          $lot_no = $row['poy_lot_no'];
                        } else {
                          $lot_no = $row['lot_no'];
                        }
                        $color_code = $row['color_code'];
                        $inner_boxes = json_decode($row['inner_boxes']);
                      ?>
                        <tr>
                          <td><?= $sno; ?></td>
                          <td><?= $row['box_prefix']; ?><?= $row['box_no']; ?></td>
                          <td>
                            $i<?php echo $row['item_group']; ?>
                          </td>
                          <?php if (sizeof($inner_boxes) > 0) : ?>
                            <?php
                            $item_names = array();
                            $item_codes = array();
                            $shade_names = array();
                            $shade_nos = array();
                            $lot_nos = array();
                            foreach ($inner_boxes as $inner_box_id => $inner_box) {
                              $i_box = $this->ak->thread_inner_box_details($inner_box_id);
                              if ($i_box) {
                                $item_names[$i_box->item_id] = $i_box->item_name;
                                $item_codes[] = $i_box->no_of_cones;
                                $shade_names[$i_box->shade_id] = $i_box->shade_name;
                                $shade_nos[$i_box->shade_id] = $i_box->shade_id;
                                $lot_nos[$i_box->lot_id] = $i_box->lot_no;
                              }

                              $no_of_cones = array_sum($item_codes);
                            }
                            /*echo "<pre>";
                                                  print_r($inner_boxes);
                                                  echo "</pre>";*/
                            ?>
                            <td><?php echo implode(",", $item_names); ?></td>
                            <td><?php echo implode(",", $item_codes); ?></td>
                            <td><?php echo implode(",", $shade_names); ?></td>
                            <td><?php echo implode(",", $shade_nos); ?></td>
                            <td><?php echo implode(",", $lot_nos); ?></td>
                          <?php else : ?>
                            <td><?= $row['item_name']; ?></td>
                            <td><?= $row['item_id']; ?></td>
                            <td class="text-danger"><?= $row['shade_name']; ?></td>
                            <td><?= $row['shade_id']; ?></td>
                            <td><?php echo $lot_no; ?></td>
                          <?php endif; ?>
                          <td><?php echo $row['manual_lot_no']; ?></td>
                          <td><?= $no_of_cones; ?></td>
                          <td>
                            <?= $row['gross_weight']; ?>
                            <input type="hidden" class="grant_wt" id="mtr_<?= $row['box_id']; ?>" value="<?= $row['gross_weight']; ?>">
                          </td>
                          <td>
                            <?= $row['net_weight']; ?>
                            <input type="hidden" class="net_weight" id="wt_<?= $row['box_id']; ?>" value="<?= $row['net_weight']; ?>" style="width: 20px;">
                          </td>
                          <td class="text-danger"><?php echo $row['stock_room_name']; ?></td>
                          <td style="<?php echo ($color_code != '') ? 'background-color:' . $color_code : ''; ?>">
                            <?php
                            if ($row['predelivery_status'] == 1) {
                            ?>
                              <input type="checkbox" name="outer_boxes[]" class="checkbox" value="<?= $row['box_id']; ?>">
                              <?php
                            } else {
                              //Dynamic Dost 3.0 
                              if ($row['delivered_in_group'] == 1) {
                              ?>
                                <label class="btn btn-primary btn-xs btn-danger">In Transit</label>
                              <?php
                              } else {
                                //end of Dunamic 3.0
                              ?>
                                <label class="btn btn-primary btn-xs">Reserved</label>
                            <?php
                              } //dynamic dost 3.0
                            }
                            ?>
                          </td>
                        </tr>
                      <?php
                        $sno++;
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr class="total-row">
                        <th></th>
                        <th><?php echo $tot_boxes; ?></th>
                        <th>Boxes</th>
                        <th colspan="2" class="text-center">Total Qty</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?php echo $tot_gr_weight; ?></th>
                        <th><?php echo $tot_nt_weight; ?></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </section>
          </div>

          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                <button class="btn btn-danger" type="button" id="addtolist">Add to List</button>
              </header>
            </section>
          </div>
        </div>
        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>delivery/predelivery_1_save">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  Selected Boxes
                  <div style="clear:both;"></div>
                  <div class="form-group col-lg-3">
                    <label for="concern_name">Concern Name</label>
                    <select class="form-control select2" id="concern_name" name="concern_name" required>
                      <option value="">Select Concern</option>
                      <?php
                      foreach ($concerns as $row) {
                      ?>
                        <option value="<?= $row['concern_id']; ?>"><?= $row['concern_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="p_delivery_cust">Party Name</label>
                    <select class="form-control select2" id="p_delivery_cust" name="p_delivery_cust">
                      <option value="">Select Party Name</option>
                      <?php
                      foreach ($customers as $customer) {
                      ?>
                        <option value="<?= $customer['cust_id']; ?>"><?= $customer['cust_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <!-- <div class="form-group col-lg-3">
                                   <label for="">Delivery To Party</label>
                                   <select class="form-control select2"></select>
                                </div> -->
                </header>
                <div class="panel-body" id="selected_items">

                </div>
              </section>
            </div>
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit" name="save_as_predel">Save as Predelivery</button>
                  <button class="btn btn-danger" type="submit" name="save_as_del">Save as Delivery</button>
                </header>
              </section>
            </div>
          </div>
        </form>

        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
  </section>

  <div class="pageloader"></div>

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

    // begin first table
    /*$('#predelivery_boxes').dataTable({
      "bInfo" : false,
      "bPaginate": false
    });*/

    oTable01 = $('#predelivery_boxes').dataTable({

      "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
      "sPaginationType": "bootstrap",
      "oLanguage": {
        "sLengthMenu": "_MENU_ records per page",
        "oPaginate": {
          "sPrevious": "Prev",
          "sNext": "Next"
        }
      },


    });
    jQuery('.dataTables_filter input').addClass("form-control");
    jQuery('.dataTables_length select').addClass("form-control");

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

    $(document).on('click', '#selecctall', function(e) {
      if (this.checked) {
        $('tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else {
        $('tbody input[type="checkbox"]:checked').trigger('click');
      }
      e.stopPropagation();
    });

    net_weights_arr = $(".net_weight");
    total_meters_arr = $(".total_meters");

    // $('#selecctall').click(function(event) {  //on click
    /*$(document).on('click', "input[type='checkbox']", function(){
          var no_boxes = 0;
          var net_weight = 0;
          var total_meters = 0;
          if(this.checked) { // check select status
              $('.checkbox').each(function() { //loop through each checkbox
                  this.checked = true;
                  var selected = $(this).val();
                  net_weight += parseFloat($("#wt_"+selected).val());
                  total_meters += parseFloat($("#mtr_"+selected).val());
                  no_boxes++;
                  $("#no_boxes").text(no_boxes);
                  $("#total_meters").text(total_meters);
                  $("#net_weight").text(net_weight.toFixed(4));
              });
          }else{
              $('.checkbox').each(function() { //loop through each checkbox
                  this.checked = false; //deselect all checkboxes with class "checkbox1"
                  $("#no_boxes").text(0);
                  $("#total_meters").text("0");                      
                  $("#net_weight").text("0");                      
              });         
          }
      });*/

    $(document).on('click', "input[type='checkbox']", function() {
      var no_boxes = 0;
      var net_weight = 0;
      var total_meters = 0;
      $('.checkbox').each(function() {
        // var key = $(this).index(".checkbox");
        if (this.checked) {
          var selected = $(this).val();
          net_weight += parseFloat($("#wt_" + selected).val());
          total_meters += parseFloat($("#mtr_" + selected).val());
          no_boxes++;
        }
      });
      $("#no_boxes").text(no_boxes);
      $("#total_meters").text(total_meters);
      $("#net_weight").text(net_weight.toFixed(4));
    });

    $(".get_outerboxes").change(function() {
      $("#item_name").select2("val", $(this).val());
      $("#item_code").select2("val", $(this).val());
      return false;
    });

    $('#selected_items').load('<?= base_url(); ?>delivery/selectedboxes');

    $(function() {
      $("#addtolist").click(function() {
        var checkeditems = $('input:checkbox[name="outer_boxes[]"]:checked')
          .map(function() {
            return $(this).val()
          })
          .get()
          .join(",");
        // alert(checkeditems);
        var url = "<?= base_url() ?>delivery/predel_add_item";
        var postData = 'checkeditems=' + checkeditems;
        $.ajax({
          type: "POST",
          url: url,
          data: postData,
          success: function(result) {
            $('#selected_items').load('<?= base_url(); ?>delivery/selectedboxes');
            // $('#selected_items').html(result);
            // console.log(result);
          }
        });
        return false;
      });
    });
    $(function() {
      $("a.remove").live("click", function() {
        var row_id = $(this).attr('id');
        var url = "<?= base_url() ?>delivery/predel_remove_item/" + row_id;
        var postData = 'row_id=' + row_id;
        $.ajax({
          type: "POST",
          url: url,
          success: function(msg) {
            $('#selected_items').load('<?= base_url(); ?>delivery/selectedboxes');
          }
        });
        return false;
      });
    });

    $(".customer").change(function() {
      $("#party_name").select2("val", $(this).val());
      $("#customer_code").select2("val", $(this).val());
    });

    $('#barcodeSearch').on('submit', function(event) {
      event.preventDefault();

      var formData = $('#barcodeSearch').serializeArray();
      // formData.push({name: 'order_id', value: order_id});
      // alert(formData);
      // console.log(formData);
      $.post($(this).attr('action'), formData, function(data) {
        // console.log(data);
        $("#barcode_no").val('');
        $('#selected_items').load('<?= base_url(); ?>delivery/selectedboxes');
      });
    });
  </script>
</body>

</html>