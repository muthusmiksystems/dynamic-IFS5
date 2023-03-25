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
                <!-- page start-->                        <?php
                if(isset($duplicate_id))
                {
                  $result = $this->m_masters->getmasterdetails('bud_lbl_outerboxes', 'box_no', $duplicate_id);
                  foreach ($result as $row) {
                    $operator_id = $row['operator_id'];
                    $item_id = $row['item_id'];
                    $packing_uom = $row['packing_uom'];
                    $packing_stock_room = $row['packing_stock_room'];
                    $packing_stock_place = $row['packing_stock_place'];
                    $remark =  $row['remark'];
                  }
                }
                else
                {
                  $duplicate_id = '';
                  $operator_id = '';
                  $item_id = '';
                  $packing_uom = '';
                  $packing_stock_room = '';
                  $packing_stock_place = '';
                  $remark =  '';
                }

                if(isset($view_item_id))
                {
                  $productionStock = $this->m_production->productionStock($view_item_id);
                  $item_sizes = explode(",", $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $view_item_id, 'item_sizes'));
                  $item_sample = $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $view_item_id, 'item_sample');
                          }
                else
                {
                  $item_id = '';
                  $item_sample = '';
                  $item_sizes = array();
                }
                $labels_each_tape = array();
                $no_tapes = array();
                $sizes_array = array();
                $production_closed = array();
                if(isset($productionStock))
                {
                  /*echo '<pre>';
                  print_r($productionStock);
                  echo '</pre>';*/
                  $p_closed = 1;
                  $total_balance = array();
                  $label_qty = array();
                  $tapes_qty = array();
                  $total_qty = array();
                  foreach ($productionStock as $row) {
                    $prod_closed = explode(",", $row['production_closed']);
                    $no_labels_tape = explode(",", $row['no_labels_tape']);
                    $no_tape = explode(",", $row['no_tape']);
                    $label_sizes = explode(",", $row['label_sizes']);
                    foreach ($label_sizes as $key => $value) {
                      if($prod_closed[$key] == 1)
                      {
                        $sizes_array[$value][] = $no_labels_tape[$key];
                        $p_closed = 1;
                      }
                      else
                      {
                        $sizes_array[$value][] = 0;
                        // $no_tapes[$value][] = 0;
                        $p_closed = 0;
                      }
                      $no_tapes[$value][] = $no_tape[$key];

                      $label_qty[$value] = (array_key_exists($value, $sizes_array))?array_sum($sizes_array[$value]):0;
                      $tapes_qty[$value] = (array_key_exists($value, $no_tapes))?$no_tapes[$value][0]:0;
                      $total_qty[$value] = ($label_qty[$value] * $tapes_qty[$value]) * $p_closed;
                      $packed_qty = $this->m_production->labelTotalPackQty($view_item_id, $value);
                      if($total_qty[$value] > 0)
                      {
                        $total_balance[$value] = ($total_qty[$value] - $packed_qty);
                      }
                      else
                      {
                        $total_balance[$value] = 0;
                      }
                    }
                  }
                }
                /*echo '<pre>';
                print_r($total_qty);
                print_r($label_qty);
                print_r($tapes_qty);
                echo '</pre>';*/
                ?>
                <div class="row">
                    <div class="col-lg-6">
                        <section class="panel">
                            <header class="panel-heading">
                                <h3><i class="icon-dropbox"></i> Packing Entry</h3>
                            </header>
                        </section>
                    </div>
                    <div class="col-lg-6">
                        <section class="panel">
                            <header class="panel-heading">
                            <?php
                            if($item_sample != '')
                            {
                              ?>
                              <a href="<?=base_url(); ?>uploads/itemsamples/labels/<?=$item_sample; ?>" target="_blank"><img height="60" src="<?=base_url(); ?>uploads/itemsamples/labels/<?=$item_sample; ?>" alt="Packing Item"></a>
                              <?php
                            }
                            else
                            {
                              ?>
                              <h3>Item Sample</h3>
                              <?php
                            }
                            ?>
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Box No
                                <span class="label label-danger" style="font-size:24px;"><?=$new_box_no; ?></span>
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
                                ?>                                                                                    <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>production/save_packing_entry_3">
                                                                <div class="form-group col-lg-3">
                                       <label for="date">Date</label>
                                       <input class="form-control" value="<?=date("d-m-Y H:i:s"); ?>" id="date" name="date" readonly="">
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="item_id">Item Code</label>
                                       <select class="selects_items form-control select2" id="item_id" name="item_id" required>
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
                                       <select class="selects_items form-control select2" id="item_name" name="item_name" required>
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
                                       <select class="selects_operator form-control select2" id="operator_name" name="operator_name" required>
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
                                       <select class="selects_operator form-control select2" id="operator_id" name="operator_id" required>
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
                                       <label for="packing_uom">UOM (Pcs/Meters)</label>
                                       <select class="form-control select2" id="packing_uom" name="packing_uom" required>
                                          <option value="">Select</option>
                                          <?php
                                          foreach ($uoms as $row) {
                                             ?>
                                             <option value="<?=$row['uom_id'];?>" <?=($row['uom_id'] == $packing_uom)?'selected="selected"':''; ?>><?=$row['uom_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <!-- <div class="form-group col-lg-3">
                                       <label for="packing_gr_weight">Gross Weight</label>
                                       <input class="form-control" id="packing_gr_weight" value="0" name="packing_gr_weight" required>
                                    </div> -->
                                    <div class="form-group col-lg-3">
                                       <label for="packing_contact">Contact</label>
                                       <input class="form-control" id="packing_contact" name="packing_contact" value="98432 40123" required>
                                    </div>                                                               <div style="clear:both;"></div>
                                    <div class="form-group col-lg-12">
                                      <table class="table table-bordered table-condensed">
                                        <tr>
                                          <td width="50%" colspan="5" align="center" style="border-right:2px solid #000;"><label>Roll Entry Information</label></td>
                                          <td width="50%" colspan="5" align="center" style="color:green;"><label>Packing Entry</label></td>
                                        </tr>
                                        <tr>
                                          <td width="5%"><label>Production<br>Stoped</label></td>
                                          <td><label>Size</label></td>
                                          <td>
                                            <label>Labels in<br>each tape</label>                                                                             </td>
                                          <td><label># of Tapes</label></td>
                                          <td style="border-right:2px solid #000;"><label>Total Qty<br>Produced</label></td>
                                          <td align="center" style="color:green;"><label>Packed<br>Roll Qty</label></td>
                                          <td align="center" style="color:green;"><label># of<br>Rolls</label></td>
                                          <td align="center" style="color:green;"><label>Total Qty<br>Packed</label></td>
                                          <td align="center" style="color:green;"><label>Total Qty<br>Demaged</label></td>
                                          <td align="center" style="color:green;"><label>Balance/Shortage<br>Qty<label style="color:red;font-size:24px;">***</label></label></td>
                                        </tr>
                                        <?php
                                        /*$total_qty = 0;
                                        $label_qty = 0;
                                        $tapes_qty = 0;
                                        $packed_qty = 0;*/
                                        $lbl_qty = 0;
                                        $tap_qty = 0;
                                        $tot_qty = 0;
                                        foreach ($item_sizes as $key => $value) {
                                          /*$label_qty = (array_key_exists($value, $sizes_array))?array_sum($sizes_array[$value]):0;
                                          $tapes_qty = (array_key_exists($value, $no_tapes))?$no_tapes[$value][0]:0;
                                          $total_qty = $label_qty * $tapes_qty;
                                          $packed_qty = $this->m_production->labelTotalPackQty($view_item_id, $value);*/
                                          $lbl_qty = (array_key_exists($value, $label_qty))?$label_qty[$value]:0;
                                          $tap_qty = (array_key_exists($value, $tapes_qty))?$tapes_qty[$value]:0;
                                          $tot_qty = (array_key_exists($value, $total_qty))?$total_qty[$value]:0;
                                          $tot_bal = (array_key_exists($value, $total_balance))?$total_balance[$value]:0;
                                          $packed_qty = $this->m_production->labelTotalPackQty($view_item_id, $value);
                                          ?>
                                          <tr>
                                            <td align="center"><input type="checkbox" value="1" name="production_closed[<?=$value?>]"></td>
                                            <td><strong style="font-size:22px;"><?=$value; ?></strong></td>
                                            <td><?=$lbl_qty; ?></td>
                                            <td><?=$tap_qty; ?></td>
                                            <td style="border-right:2px solid #000;"><?=$tot_qty; ?></td>
                                            <td><input type="text" class="form-control" name="packed_roll_qty[<?=$value; ?>][]" placeholder="0"></td>
                                            <td><input type="text" class="form-control" name="packed_no_rolls[<?=$value; ?>][]" placeholder="0"></td>
                                            <td>0</td>
                                            <td><input type="text" class="form-control" name="total_qty_damaged[<?=$value; ?>][]" placeholder="0"></td>
                                            <td><?=$tot_qty-$packed_qty; ?></td>
                                          </tr>
                                          <?php
                                          for ($i=0; $i < 2; $i++) {
                                            ?>
                                            <tr>
                                            <td align="center"></td>
                                            <td></strong></td>
                                            <td></td>
                                            <td></td>
                                            <td style="border-right:2px solid #000;"></td>
                                            <td><input type="text" class="form-control" name="packed_roll_qty[<?=$value; ?>][]"></td>
                                            <td><input type="text" class="form-control" name="packed_no_rolls[<?=$value; ?>][]"></td>
                                            <td>0</td>
                                            <td><input type="text" class="form-control" name="total_qty_damaged[<?=$value; ?>][]"></td>
                                            <td></td>
                                          </tr>
                                            <?php
                                          }
                                        }
                                        ?>
                                      </table>
                                    </div>
                                    <div class="form-group col-lg-4">
                                    <label for="packing_stock_room">Stock Room</label>
                                    <select tabindex="12" class="select2 form-control" id="packing_stock_room" name="packing_stock_room">
                                       <option value="">Select Srock Room</option>
                                       <?php
                                       foreach ($stock_rooms as $stock_room) {
                                          ?>
                                          <option value="<?=$stock_room['stock_room_id']; ?>" <?=($stock_room['stock_room_id'] == $packing_stock_room)?'selected="selected"':''; ?> ><?=$stock_room['stock_room_name']; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                 </div>
                                 <div class="form-group col-lg-4">
                                    <label for="packing_stock_place">Stock Place</label>
                                    <input tabindex="13" class="form-control" id="packing_stock_place" name="packing_stock_place" value="<?=$packing_stock_place; ?>" type="text">
                                 </div>
				  
				    
				     
				   <div class="form-group col-lg-4">
					<label for="po_date">Remarks : </label>                               
					<textarea name="remark" class="form-control" style="resize: vertical;" required="required"><?=$remark;?></textarea>
				  </div>
                                    <div style="clear:both;"></div>
                                    <div class="col-lg-3">
                                      <button class="btn btn-danger" type="submit">Save</button>
                                      <button class="btn btn-default" type="button">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <?php
                        /*echo "<pre>";
                        print_r($outerboxes);
                        echo "</pre>";*/
                        ?>
                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <td>#</td>
                                  <td>Date</td>
                                  <td>Box No</td>                                                           <td>Item Code</td>
                                  <td>Item Name</td>
                                  <td>Total Qty</td>
                                  <td>Stock Room</rd>
                                  <td>Remark</td>
                                  <td>Packed By </td>
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
                                  $total_qty = $row['SUM(`total_qty`)'];
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?php echo date('d-m-y h:i:s',strtotime($date_time));?></td>
                                    <td><?=$box_prefix; ?>-<?=$box_no; ?></td>                                                               <td><?=$item_id; ?></td>
                                    <td><?=$item_name; ?></td>
                                    <td><?=$total_qty; ?></td>
                                     <td>
                                    <?php
                                    	$this->db->select('*');
                                    	$this->db->from('bud_stock_rooms');
                                    	$this->db->where('stock_room_id',$row['packing_stock_room']);
                                    	$q = $this->db->get();
                                    	$a  = $q->result_array();
                                    	foreach($a as $b)
                                    	{
                                    		echo "<b>".$b['stock_room_name']."</b><br>".$row['packing_stock_place'];
                                    	}
                                    ?>
	                              </td>   
	                              <td><?=$row['remark']; ?></td>
	                               <th>
	                                    <?php
	                                    	$this->db->select('*');
	                                    	$this->db->from('bud_users');
	                                    	$this->db->where('ID',$row['operator_id']);
	                                    	$q = $this->db->get();
	                                    	$a  = $q->result_array();
	                                    	foreach($a as $b)
	                                    	{
	                                    		echo $b['user_login'];
	                                    	}
	                                    ?>
	                              </th>                                                             <td>
                                      <a href="<?=base_url(); ?>production/packing_entry_3/<?=$item_id; ?>/<?=$box_no; ?>" class="btn btn-danger">Duplicate</a>
                                      <a target="_blank" href="<?=base_url(); ?>production/print_out_pack_slip_3/<?=$box_no; ?>" class="btn btn-danger">Print</a>
                                      <a href="<?=base_url(); ?>production/packing_entry_3/<?=$item_id; ?>/<?=$box_no; ?>" class="btn btn-danger">View</a>
                  									  <?php if($row['is_deleted']) { ?>
                  									  <a href="<?=base_url(); ?>production/rollback_entry_3/<?=$item_id; ?>/<?=$box_no; ?>" class="btn btn-info">Roll Back</a>
                  									  <?php } 
                                      else { 
                                        //include delete Option Packing
                                        $status=$this->m_reports->get_box_status($box_no);
                                        if(!($status['inv_no']||$status['pdc_no']||$status['dc_no'])){
                                        ?>
                    									  <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updateBoxId(<?=$box_no?>)">Delete
                                        </button>
                    									  <?php }
                                        //include delete Option Packing
                                      } ?>
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
  <!--//include delete Option Packing-->
  <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete Box</h4>
          </div>
          <form>
          <div class="modal-body">
            <input type="text" name="box_no" id="boxNo" value="" hidden>
            <label>Remarks:</label>
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" value="Production Cancelled">Production Cancelled</label>
            </div>           <div class="radio">
              <label><input type="radio" name="remarks" class="remarks"  value="Wrong Qty">Wrong Qty</label>
            </div>
            <div class="radio">
              <label><input type="radio" name="remarks" id='others' value="others">Others</label>
            </div>
            <div class="form-group" id="otherRemarks">
              <label for="comment">Comment:</label>
              <textarea class="form-control" rows="5" name="others" id="otherRemarkValue"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" onclick="deletebox()">Delete</button>
          </div>
        </form>
        </div><!-- /.modal-content -->
        <!--//include delete Option Packing-->
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
          window.location = "<?=base_url(); ?>production/packing_entry_3/"+$(this).val();
      });
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      $(".col-sm-6.right").append('<div class="dataTables_filter col-sm-6" style="float:left;"><label>Search Item Code: <input type="text" class="form-control" id="itemcode_search" style="width:50%;"></label></div>');      
  </script>
  <!--//include delete Option Packing-->
  <script >
        $('#otherRemarks').hide();
        $('#others').click(function(event) {
        if(this.checked) { // check select status
          $('#otherRemarks').show();
        }
        else
        {
          $('#otherRemarks').hide();
        }
        });
        $('.remarks').click(function(event) {
        $('#otherRemarks').hide();
        });
        function updateBoxId(box_no){
          $('#boxNo').val(box_no);
        }
        function deletebox(){
          var remarks = $( "input:checked" ).val();
          if(remarks=="others")
          {
            remarks=$('#otherRemarkValue').val();
          }
          var box_no=$('#boxNo').val();
          var url = "<?php echo base_url('production/delete_entry_3')?>";
          //alert(remarks+box_no+url);
          $.ajax({
              type: "POST",
              url: url,
              data:  {
              "box_no": box_no,
              "remarks": remarks
              },
              success: function(result)
              {
                alert(result);
                location.reload(true);
              }
            });
        }
      </script>
      <!--//include delete Option Packing-->
  </body>
</html>
