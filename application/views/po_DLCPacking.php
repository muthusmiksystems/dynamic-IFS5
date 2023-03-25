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
                                <h3>Dyed Loose Cone Packing Entry</h3>
                            </header>
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
                            }                                                      if($this->session->flashdata('error'))
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
                        </section>
                    </div>
                </div>
                <form class="cmxform tasi-form" role="form" id="commentForm" method="post" action="<?=base_url('purchase_order/po_DLCPacking/'.$id);?>">
                  <div class="row">
                    <div class="col-md-12">                                      <section class="panel">                                                <header class="panel-heading">
                                <div class="form-group col-md-12">
                                   <label >No : </label>
                                   <span class="label label-danger" style="padding: 0 1em;font-size:24px;" id="box" value="<?=$next; ?>">DLCP<?=$next; ?></span>
                                </div>
                            </header>                                                <div class="panel-body">
                              <div class="row">
                              <div class="form-group col-md-3">
                                <label for="from_dept_id">From Dept</label>
                                <select class="form-control select2" id="from_dept_id" name="from_dept_id" placeholder="From Dept">
                                  <option value="">Select Dept</option>
                                  <?php
                                  foreach ($departments as $row) {
                                    ?>
                                    <option value="<?=$row['dept_id']; ?>" <?=($row['dept_id'] == $from_dept_id)?'selected="selected"':''; ?>><?=$row['dept_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group col-md-3">
                                <label for="to_dept_id">To Dept</label>
                                <select class="form-control select2" id="to_dept_id" name="to_dept_id" placeholder="From Dept">
                                  <option value="">Select Dept</option>
                                  <?php
                                  foreach ($departments as $row) {
                                    ?>
                                    <option value="<?=$row['dept_id']; ?>" <?=($row['dept_id'] == $to_dept_id)?'selected="selected"':''; ?>><?=$row['dept_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group col-md-3">
                                <label for="from_user_id">From Staff</label>
                                <select class="form-control select2" id="from_user_id" name="from_user_id" placeholder="From Staff">
                                  <option value="">Select Staff</option>
                                  <?php
                                  foreach ($users as $row) {
                                    ?>
                                    <option value="<?=$row['ID']; ?>" <?=($row['ID'] == $from_user_id)?'selected="selected"':''; ?>><?=$row['display_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group col-md-3">
                                <label for="to_user_id">To Staff</label>
                                <select class="form-control select2" id="to_user_id" name="to_user_id" placeholder="To Staff">
                                  <option value="">Select Staff</option>
                                  <?php
                                  foreach ($users as $row) {
                                    ?>
                                    <option value="<?=$row['ID']; ?>" <?=($row['ID'] == $to_user_id)?'selected="selected"':''; ?>><?=$row['display_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              </div>
                              <div class="row">
                                <div class="form-group col-md-2">
                                  <label for="lot_id">Lot Number</label>
                                  <select class="form-control select2" id="lot_id">
                                    <option value="">Select Lot</option>
                                    <?php
                                    foreach ($lots as $row) {
                                      ?>
                                      <option value="<?=$row->lot_id; ?>"><?=$row->lot_no; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                  <label>Item Name/Code</label><br>
                                  <span id="item_name"></span>
                                </div>
                                <div class="form-group col-md-2">
                                  <label>Shade Name/Code</label><br>
                                  <span id="shade_name"></span>
                                </div>
                                <div class="form-group col-md-2">
                                  <label>Shade No</label><br>
                                  <span id="shade_code"></span>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group col-md-2">
                                  <label for="no_springs"># Springs</label>
                                  <input class="form-control" id="no_springs" type="text" readonly="">
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="no_springs_hold"># Springs Hold</label>
                                  <input class="form-control" id="no_springs_hold" type="text">
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="net_weight">Nt.Weight</label>
                                  <input class="form-control" id="net_weight" type="text" readonly="">
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="net_weight_hold">Nt.Weight Hold</label>
                                  <input class="form-control" id="net_weight_hold" type="text">
                                </div>
                                <div class="form-group col-md-2">
                                  <label>&nbsp; </label><br>
                                  <button type="button" id="add_row" class="btn btn-primary">Add</button>
                                </div>
                              </div>

                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Lot No</th>
                                    <th>Item Name</th>
                                    <th>Shade Name</th>
                                    <th>Shade No</th>
                                    <th># Springs Hold</th>
                                    <th>Net Weight Hold</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody id="dlcp_data">
                                  <?php
                                  /*echo "<pre>";
                                  print_r($packing_items);
                                  echo "</pre>";*/
                                  $row_count = 1;
                                  if(count($packing_items) > 0)
                                  {
                                    foreach ($packing_items as $row) {
                                      $item_name = $row->item_name.'/'.$row->lot_item_id;
                                      $shade_name = $row->shade_name.'/'.$row->lot_shade_no;
                                      $shade_code = $row->shade_code;

                                      add_row($row_count, $row->lot_id, $row->lot_no, $row->no_springs_hold, $row->net_weight_hold, $item_name, $shade_name, $shade_code);
                                    }                                                              }
                                  function add_row($row_count, $lot_id, $lot_no, $no_springs_hold, $net_weight_hold, $item_name, $shade_name, $shade_code)
                                  {
                                      ob_start();
                                      ?>
                                      <tr>
                                          <td>
                                            <input type="hidden" name="packing_items[<?=$row_count; ?>][lot_id]" value="<?=$lot_id; ?>">
                                            <input type="hidden" name="packing_items[<?=$row_count; ?>][no_springs_hold]" value="<?=$no_springs_hold; ?>">
                                            <input type="hidden" name="packing_items[<?=$row_count; ?>][net_weight_hold]" value="<?=$net_weight_hold; ?>">
                                              <?=$lot_no; ?>
                                          </td>
                                          <td><?=$item_name; ?></td>
                                          <td><?=$shade_name; ?></td>
                                          <td><?=$shade_code; ?></td>
                                          <td><?=$no_springs_hold; ?></td>
                                          <td><?=$net_weight_hold; ?></td>
                                          <td>
                                              <a href="#" class="delete-chemical_row btn btn-xs btn-danger">Delete</a>
                                          </td>
                                      </tr>
                                      <?php
                                      $stuff = ob_get_contents();
                                      ob_end_clean();
                                      echo replace_newline($stuff);
                                  }

                                  function replace_newline($string) {
                                      return trim((string)str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string));
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <div class="form-group col-md-4">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks"><?=$remarks; ?></textarea>
                              </div>
                              <div class="form-group col-md-4">
                                <label for="sent_through">Goods Sent Through</label>
                                <input class="form-control" id="sent_through" name="sent_through" value="<?=$sent_through; ?>" type="text">
                              </div>
                              <div class="form-group col-md-4">
                                <label for="vehicle_no">Vehicle No</label>
                                <input class="form-control" id="vehicle_no" name="vehicle_no" value="<?=$vehicle_no; ?>" type="text">
                              </div>
                              <input type="hidden" id="packed_by" name="packed_by" value="<?=$this->session->userdata('display_name'); ?>">							  
                            </div>
                        </section>

                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" name="save" value="save">Save</button>
                            </header>
                        </section>                                    </div>
                  </div>
                </form>
                <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
                <!-- page end-->
				
            </section>
            <section class="panel">
              <header class="panel-heading">
                  Summary
              </header>
              <div class="panel-body">
                <table class="table datatable table-bordered" id="example">
                  <thead>
                    <tr>
                        <th>S.No</th>
                        <th>DLCP No</th>
                        <th>Date</th><!--Inclusion of DLC Date-->
                        <th>Lot No</th>
                        <th>Shade Name</th>
                        <th>Shade No</th>
                        <th>Hold # Springs</th>
                        <th>Hold Nt.Weight</th>
                        <th># Of Springs</th>
                        <th>Net Weight</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    /*echo "<pre>";
                    print_r($register);
                    echo "</pre>";*/
                    $sno = 1;
                    foreach ($register as $box) {
                      $items = $this->m_purchase->get_dlc_packing_item_reg($box->id);
                      $id_display = false;
                      $action_display = false;
                      foreach ($items as $row) {
                        ?>
                        <tr>
                          <?php
                          if($id_display == false)
                          {
                            $id_display = true;
                            ?>
                            <td><?=$sno; ?></td>
                            <td><?=$box->id; ?></td>
                            <td><?=date('d-M-y h:i a',strtotime($box->packed_date)); ?></td><!--Inclusion of DLC Date-->
                            <?php
                          }
                          else
                          {
                            ?>
                            <td></td>
                            <td></td>
                            <td></td><!--Inclusion of DLC Date-->
                            <?php
                          }
                          ?>
                          <td><?=$row->lot_no; ?></td>
                          <td><?=$row->shade_name; ?>/<?=$row->shade_id; ?></td>
                          <td><?=$row->shade_code; ?></td>
                          <td><?=$row->no_springs_hold; ?></td>
                          <td><?=$row->net_weight_hold; ?></td>
                          <td><?=$row->no_springs; ?></td>
                          <td><?=$row->net_weight; ?></td>
                          <?php
                          if($action_display == false)
                          {
                            $action_display = true;
                            ?>
                            <td>
                              <a href="<?=base_url('purchase_order/po_DLCPacking/'.$box->id); ?>" class="btn btn-xs btn-primary">Edit</a>
                              <a href="" class="btn btn-xs btn-warning">Print</a>
                            </td>
                            <?php
                          }
                          else
                          {
                            ?>
                            <td></td>
                            <?php
                          }
                          ?>
                        </tr>
                        <?php
                      }
                      $sno++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
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

          $('.datatable').dataTable({
            // "sDom": "<'row'<'col-sm-6'f>r>",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "bSort": false,
            "bPaginate": false,
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });
        jQuery('#example_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
        jQuery('#example_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown
        });

      //custom select box
      $(function(){
          $('select.styled').customSelect();
      });

      $(document).ajaxStart(function() {
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

    $(function(){
      $("#lot_id").change(function () {
          var lot_id = $('#lot_id').val();
          var url = "<?=base_url()?>purchase_order/get_lot_qty/"+lot_id;
          var postData = 'lot_id='+lot_id;
          $.ajax({
              type: "POST",
              url: url,
              // data: postData,
              success: function(result)
              {
                  console.log(result);
                            var result = $.parseJSON(result);
                  $("#no_springs").val(result.no_springs);
                  $("#net_weight").val(result.lot_qty);
                  $("#item_name").text(result.item_name);
                  $("#shade_name").text(result.shade_name);
                  $("#shade_code").text(result.shade_code);
                        }
          });
          return false;
      });
    });


    $("#add_row").click(function(){
      var rowCount = $('#dlcp_data tr').length;
    var lot_id = $("#lot_id").val();
      var lot_no = $("#lot_id option:selected").text();
      var no_springs_hold = $("#no_springs_hold").val();
      var net_weight_hold = $("#net_weight_hold").val();
      var item_name = $("#item_name").text();
      var shade_name = $("#shade_name").text();
      var shade_code = $("#shade_code").text();

      var row = '<?php add_row("'+rowCount+'","'+lot_id+'","'+lot_no+'", "'+no_springs_hold+'", "'+net_weight_hold+'", "'+item_name+'", "'+shade_name+'", "'+shade_code+'");?>';
      $("#dlcp_data").append(row);
      // Clear All Data
      $("#lot_id").select2('val', '');
      $("#no_springs_hold").val('');
      $("#net_weight_hold").val('');
    });

    $('body').on('click', '.delete-chemical_row', function(){
        if(confirm('Do you want to delete'))
        {
            $(this).closest("tr").remove();
        }
        return false;
    });
	  
	  
	  
      $(function(){
			$("#submit").click(function(event){
				if( $("#nt_wt").val() != "" )
				{
					var lot = $("#lot_no").val();
					var no_of_springs = $("#sp_no").val();
					var gross = $("#g_wt").val();
					var net = $("#nt_wt").val();
					var form_by = "<?=$this->session->userdata('display_name'); ?>";
									$.ajax({
									type : "POST",
									url  : "<?=base_url(); ?>purchase_order/po_DLCPacking_save/"+lot+"/"+no_of_springs+"/"+gross+"/"+net+"/"+form_by,
									success: function(e){
										if(e == "success")
										{
											alert("successfully updated");
											var box = $("#box").attr("value");
											++box;
											$("#box").html("DLCP"+box);
											
										}
									}
									});					
				}
				else
				{
					alert("check all the fields are filled");
				}
			})
      });

  </script>

  </body>
</html>
