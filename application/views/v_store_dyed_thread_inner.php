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
                                <h3><i class="icon-book"></i> Thread inner Box Packing Entry</h3>
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
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url('store/dyed_thread_inner/'.$inner_box_id); ?>">
                  <div class="row">
                      <div class="col-lg-12">
                          <?php
                          $item_name = '';
                          $item_id = '';
                          $cust_name = '';
                          $customer_id = '';
                          $shade_code = '';
                          $shade_name = '';


                          $lot_qty = 0.000;
                          $tot_packed_qty = 0.000;
                          $tot_balancd_qty = 0.000;

                          $lot_qty = 0.000;
                          $tot_packed_qty = 0.000;
                          $tot_balancd_qty = 0.000;
                          $shade = '';
                          $percentage = 0;
                          if(!empty($lot_id))
                          {
                            // $lot_id = $lot_no;
                            $lot_id = $lot_id;
                            if(!empty($lot_id))
                            {
                              $lot = $this->m_masters->get_lot($lot_id);
                              if($lot)
                              {
                                $dlc_items = $this->m_purchase->get_dlc_lot_qty($lot_id);
                                if(sizeof($dlc_items) > 0)
                                {
                                  foreach ($dlc_items as $item) {
                                    $lot_qty += $item->net_weight;
                                  }
                                }
                                // $lot_qty = $lot->lot_actual_qty;
                                $shade = $lot->lot_shade_no;
                              }

                              $pack_qty = $this->m_masters->get_lot_pack_qty($lot_id);
                              if($pack_qty)
                              {
                                if($pack_qty->tot_packed_qty > 0)
                                {
                                  $tot_packed_qty = $pack_qty->tot_packed_qty;                                  }
                              }
                            }
                            $tot_balancd_qty = $lot_qty - $tot_packed_qty;

                            $lot_qty = number_format($lot_qty, 3, '.', '');
                            $tot_packed_qty = number_format($tot_packed_qty, 3, '.', '');
                            $tot_balancd_qty = number_format($tot_balancd_qty, 3, '.', '');

                            $lot = $this->m_masters->get_lot_details($lot_id);
                            // print_r($lot);
                            if($lot)
                            {
                              $item_name = $lot->item_name;
                              $item_id = $lot->item_id;
                              $cust_name = $lot->cust_name;
                              $customer_id = $lot->bud_customers;
                              $shade_code = $lot->shade_code;
                              $shade_name = $lot->shade_name;
                            }
                          }

                          /*if(!empty($lot_id))
                          {
                            if(!empty($lot_id))
                            {
                              $lot = $this->m_masters->get_lot($lot_id);
                              if($lot)
                              {
                                $dlc_items = $this->m_purchase->get_dlc_lot_qty($lot_id);
                                if(sizeof($dlc_items) > 0)
                                {
                                  foreach ($dlc_items as $item) {
                                    $lot_qty += $item->net_weight;
                                  }
                                }
                                // $lot_qty = $lot->lot_actual_qty;
                                $lot_shade_no = $lot->lot_shade_no;
                              }

                              $pack_qty = $this->m_masters->get_lot_pack_qty($lot_id);
                              if($pack_qty)
                              {
                                if($pack_qty->tot_packed_qty > 0)
                                {
                                  $tot_packed_qty = $pack_qty->tot_packed_qty;                                  }
                              }
                            }
                            $tot_balancd_qty = $lot_qty - $tot_packed_qty;

                            $lot_qty = number_format($lot_qty, 3, '.', '');
                            $tot_packed_qty = number_format($tot_packed_qty, 3, '.', '');
                            $tot_balancd_qty = number_format($tot_balancd_qty, 3, '.', '');
                          }*/
                          ?>
                          <section class="panel">                                                  <header class="panel-heading">
                                  <div class="form-group col-lg-12">
                                     <label >Box No : </label>
                                     <span class="label label-danger" style="padding: 0 1em;font-size:24px;">I <?=$box_no ?></span>
                                  </div>
                              </header>                                                  <div class="panel-body">
                                <div class="form-group col-lg-3">
                                  <label for="po_category">Lot No</label>
                                  <select class="form-control select2" name="lot_id" id="lot_id" required>
                                    <option value="">Select LOT</option>
                                    <?php
                                    foreach ($lots as $row) {
                                      ?>
                                      <option value="<?=$row->lot_id; ?>" <?=($row->lot_id == $lot_id)?'selected="selected"':''; ?>><?=$row->lot_no; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                                <div class="form-group col-lg-2">
                                  <label for="po_date">Total Lot Prod Qnty</label>
                                  <span class="label label-primary" id="lable_lot_qty" style="padding: 0 1em;font-size:24px;"><?=$lot_qty; ?></span>
                                </div>
                                <div class="form-group col-lg-2">
                                  <label for="po_date">Total Lot Packed Qty</label>
                                  <span class="label label-warning" id="lable_pack_qty" style="padding: 0 1em;font-size:24px;"><?=$tot_packed_qty; ?></span>
                                </div>
                                <div class="form-group col-lg-2">
                                  <label for="po_date">Balance Lot Qty</label>
                                  <span class="label label-danger" id="lable_bal_qty" style="padding: 0 1em;font-size:24px;"><?=$tot_balancd_qty; ?></span>
                                </div>

                                <div style="clear:both;"></div>
                                <div class="row">
                                  <div class="col-md-8">
                                    <table class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th class="text-danger">Customer</th>
                                          <th class="text-danger">Item Name</th>
                                          <th class="text-danger">Color Name</th>
                                          <th class="text-danger">Color Code</th>
                                          <th class="text-danger">Qty</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td id="lbl_cust_name"><?php echo $cust_name; ?></td>
                                          <td id="lbl_item_name"><?php echo $item_name; ?></td>
                                          <td id="lbl_shade_name"><?php echo $shade_name; ?></td>
                                          <td id="lbl_shade_code"><?php echo $shade_code; ?></td>
                                          <td id="lbl_lot_qty"><?php echo $lot_qty; ?></td>
                                        </tr>
                                      </tbody>
                                    </table>                                                            </div>

                                  <div class="form-group col-md-3">
                                     <label for="customer_id">Customer</label>
                                     <select class="search-term form-control select2" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                          <?php foreach ($customers as $customer): ?>
                                             <option value="<?php echo $customer->cust_id; ?>" <?php echo ($customer->cust_id == $customer_id)?'selected="selected"':''; ?>><?php echo $customer->cust_name; ?></option>
                                          <?php endforeach; ?>
                                        <?php endif; ?>
                                     </select>
                                  </div>

                                </div>

                                <div class="form-group col-lg-3">
                                   <label for="item_name">Item Name</label>
                                   <select class="search-term item-select form-control select2" id="item_name">
                                      <option value="">Select Item</option>
                                      <?php
                                      foreach ($items as $item) {
                                         ?>
                                         <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$item['item_name'];?></option>
                                         <?php
                                      }
                                      ?>
                                   </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="item_id">Item Code</label>
                                   <select class="search-term item-select form-control select2" id="item_id" name="item_id">
                                      <option value="">Select Item</option>
                                      <?php
                                      foreach ($items as $item) {
                                         ?>
                                         <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$item['item_id'];?></option>
                                         <?php
                                      }
                                      ?>
                                   </select>
                                </div>

                                <!-- 2nd Row -->
                                <div class="form-group col-lg-3">
                                  <label for="shade_id">Colour Name</label>
                                  <select class="search-term form-control select2 shade-select" name="shade_id" id="shade_id" required>
                                    <option value="">Select colour</option>
                                    <?php
                                    foreach ($shades as $row) {
                                      ?>
                                      <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$row['shade_name']." / ".$row['shade_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                                <div class="form-group col-lg-3">
                                  <label for="shade_code">Colour Code</label>
                                  <select class="search-term form-control select2 shade-select" id="shade_code" required>
                                    <option value="">Select colour</option>
                                    <?php
                                    foreach ($shades as $row) {
                                      ?>
                                      <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$row['shade_code']; ?></option> -->
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </div>

  							                <div class="form-group col-lg-3">
                                  <label for="gross_weight">Gross Wt</label>
                                  <input class="form-control" id="gross_weight" name="gross_weight" value="<?=$gross_weight; ?>" type="text" required>
                                </div>							  

  							                <div class="form-group col-lg-3">
                                  <label for="po_date">No of Cones</label>
                                  <input class="form-control" id="no_of_cones" name="no_of_cones" value="<?=$no_of_cones; ?>" type="text" required onkeyup="calculate()">
                                </div>
  							                <div class="form-group col-lg-3">
                                  <label for="po_date">Net Wt per cone</label>
                                  <input class="form-control" id="cone_wt" name="nt_weight_cone" type="text" value="<?=$nt_weight_cone; ?>" required onkeyup="calculate()">
                                </div>							  
  							                <div class="form-group col-lg-3">
                                  <label for="po_date">Meter Per cone</label>
                                  <input class="form-control" id="cone_meter" name="meter_cone" value="<?=$meter_cone; ?>" type="text" required>
                                </div>
  							                <div class="form-group col-lg-3">
                                  <label for="po_date">Net Weight</label>
                                  <input class="form-control" id="nt_wt" name="net_weight" value="<?=$net_weight; ?>" type="text" required readonly>
                                </div>		
                                <input type="hidden" id="packed_by" name="packed_by" value="<?=$this->session->userdata('display_name'); ?>">                                       <input type="hidden" id="packed_date" name="packed_date" value="<?=date("Y-m-d H:i:s"); ?>">							  
                              </div>
                          </section>

                          <section class="panel">
                              <header class="panel-heading">
                                  <button class="btn btn-danger" type="submit" name="save" value="save">Save</button>
                                  <button class="btn btn-warning" type="submit" name="save_continue" value="save_continue">Save &amp; Continue</button>
                              </header>
                          </section>
                                    </div>
                  </div>
                </form>
                <!-- page end-->
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
				
				    <section class="panel">
                        <header class="panel-heading">
                            Summery
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Date</th>
                                <th>Box No</th>
                                <th>Lot No</th>
                                <th>Item name/code</th>
                                <th>Colour name/code</th>
                                <th>Gross Weight</th>
                                <th>Net Weight</th>
                                <th>Packed By</th>
                                <td>Action</td>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($inner_boxes as $row) {
                              ?>
                              <tr>
                                <td><?=$sno; ?></td>
                                <td><?=date("d-m-Y H:i:s", strtotime($row->packed_date)); ?></td>
                                <td>I<?=$row->inner_box_id; ?></td>
                                <td><?=$row->lot_no; ?></td>
                                <td><?=$row->item_name; ?>/<?=$row->item_id; ?></td>
                                <td><?=$row->shade_name; ?>/<?=$row->shade_id; ?></td>
                                <td><?=$row->gross_weight; ?></td>
                                <td><?=$row->net_weight; ?></td>
                                <td><?=$row->packed_by; ?></td>
                                <td>
                                  <a href="<?=base_url('store/dyed_thread_inner/'.$row->inner_box_id.'/edit'); ?>" class="btn btn-xs btn-primary">Edit</a>
                                  <a href="<?=base_url('store/dyed_thread_inner/'.$row->inner_box_id); ?>" class="btn btn-xs btn-success">Duplicate</a>
                                  <a href="<?=base_url('store/delete_thread_inner/'.$row->inner_box_id); ?>" class="btn btn-xs btn-danger">Delete</a>
                                </td>
                              </tr>
                              <?php
                              $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
                    </section>
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
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

	  
	  function total_box()
	  {
		$("#t_bx").val( $("#b_wt").val() * $("#n_bx").val()  );
	  }
	  function total_bag()
	  {
		$("#t_bg").val( $("#p_wt").val() * $("#n_bg").val()  );
	  }

	  function calculate()
	  {
			$("#nt_wt").val( $("#no_of_cones").val() * $("#cone_wt").val() );
	  }
	  
	  
		
    $(".item-select").change(function(){
      $("#item_name").select2("val", $(this).val());
      $("#item_id").select2("val", $(this).val());
    });

    $(".shade-select").change(function(){
      $("#shade_id").select2("val", $(this).val());
      $("#shade_code").select2("val", $(this).val());
    });

		$(function(){
        $("#lot_id").change(function () {
            var lot_no = $('#lot_id').val();
            var url = "<?=base_url()?>store/get_lot_qty/"+lot_no;
            var postData = 'lot_no='+lot_no;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    // console.log(result);
                    var result = $.parseJSON(result);
                    $("#lable_lot_qty").text(result.lot_qty);
                    $("#lable_pack_qty").text(result.tot_packed_qty);
                    $("#lable_bal_qty").text(result.tot_balancd_qty);

                    $("#customer_id").select2("val", result.customer_id);
                    $("#item_name").select2("val", result.item_id);
                    $("#item_id").select2("val", result.item_id);
                    $("#shade_id").select2("val", result.lot_shade_no);
                    $("#shade_code").select2("val", result.lot_shade_no);

                    $("#lbl_cust_name").html(result.cust_name);
                    $("#lbl_item_name").html(result.item_name);
                    $("#lbl_shade_code").html(result.shade_code);
                    $("#lbl_shade_name").html(result.shade_name);
                    $("#lbl_lot_qty").html(result.lot_qty);
                }
            });
            return false;
        });
      });

      $(".search-term").change(function() {
        var customer_id = $("#customer_id").val();
        // alert($("#colour_code").val());
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('store/get_lot_list'); ?>",
            data: { 
              customer_id: customer_id,
              shade_id: $("#shade_id").val(),
              item_id: $("#item_id").val()
            },
            beforeSend: function(data)
            {
                // $(".ajax-loader").css('display', 'block');
            },
            success: function(data)
            {
              // console.log(data);
              $("#lot_id").select2('destroy'); 
              $("#lot_id").html(data);
              $("#lot_id").select2(); 
            }
        });
      });
	  
  </script>

  </body>
</html>
