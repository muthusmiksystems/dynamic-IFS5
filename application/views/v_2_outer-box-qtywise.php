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
               <div class="row screen-only">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-file"></i> Outer Box Qty Wise</h3>
                        </header>
                        <div class="panel-body" id="sample-box">
                        </div>
                     </section>
                  </div>
               </div>
               <div class="row screen-only">
                  <div class="col-lg-12">
                  <?php
                  if($this->session->flashdata('warning'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-warning fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                           </button>
                           <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }                                            if($this->session->flashdata('error'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-block alert-danger fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                           <i class="icon-remove"></i>
                           </button>
                           <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }
                  if($this->session->flashdata('success'))
                  {
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
                           <p><?=$this->session->flashdata('success'); ?></p>
                        </div>
                     </header>
                  </section>
                  <?php
                  }
                  ?>
                  </div>
               </div>
               <?php
               $items = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
               $uoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
               $staffs = $this->m_masters->getactivemaster('bud_users', 'user_status');
               if(isset($previous_box))
               {
                $result = $this->m_masters->getmasterdetails('bud_te_outerboxes','box_no', $previous_box);
                foreach ($result as $row) {
                  $item_name = $row['packing_innerbox_items'];
                  $item_uom = $row['item_uom'];
                  $party_name = $row['packing_customer'];//inclusion of party name in outerbox qtywise
                  $packing_by = $row['packing_by'];
                  $packing_stock_room = $row['packing_stock_room'];
                  $packing_stock_place = $row['packing_stock_place'];
                  $remark =  $row['remark'];
                }
               }
               else
               {
                $item_name = null;                        $item_uom = null;   
                $party_name = null;//inclusion of party name in outerbox qtywise                     $packing_by = null; 
                $packing_stock_room = null;
                $packing_stock_place = null;  
                $remark = null;                    }
               ?>
               <form class="cmxform form-horizontal tasi-form screen-only" autocomplete="off" role="form" id="commentForm" method="post" action="<?=base_url()?>production/saveOuterBoxQty_2">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Box No
                              <span class="label label-danger" style="font-size:14px;">M - <?=$new_box_no; ?></span>
                           </header>
                           <div class="panel-body">
                            <!--inclusion of party name in outerbox qtywise-->
                            <div class="form-group col-lg-3">
                                 <label for="packing_customer">Party Name</label>
                                 <select class="form-control select2" id="packing_customer" name="packing_customer">
                                    <option value="">Select Party Name</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>"<?=($customer['cust_id'] == $party_name)?'selected="selected"':''; ?>><?=$customer['cust_name'].'/'.$customer['cust_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <!--end of inclusion of party name in outerbox qtywise-->
                              <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="get_item_detail form-control select2" id="item_name" name="item_name" required>
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                       ?>
                                       <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $item_name)?'selected="selected"':''; ?>><?=$item['item_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_code">Item Code</label>
                                 <select class="get_item_detail form-control select2" id="item_code" name="item_code" required>
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                       ?>
                                       <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $item_name)?'selected="selected"':''; ?>><?=$item['item_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="no_rolls">No of Rolls</label>
                                 <input type="text" class="total_qty form-control" id="no_rolls" name="no_rolls" required>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="qty_per_roll">Qty Per Roll</label>
                                 <input type="text" class="total_qty form-control" id="qty_per_roll" name="qty_per_roll" required>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_uom">UOM</label>
                                 <select class="form-control select2" id="item_uom" name="item_uom" required>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($uoms as $row) {
                                       ?>
                                       <option value="<?=$row['uom_id'];?>" <?=($row['uom_id'] == $item_uom)?'selected="selected"':''; ?>><?=$row['uom_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="total_qty">Total Qty</label>
                                 <input type="text" class="form-control" id="total_qty" name="total_qty" required>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="gross_weight">Gross Weight (Kgs)</label>
                                 <input type="text" class="form-control" id="gross_weight" name="gross_weight" required>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label>Dyed Lot No</label>
                                 <input type="text" class="form-control" id="dyed_lot_no" name="dyed_lot_no">
                              </div>
                              <div class="form-group col-lg-3">
				    <label for="packing_by">Packed by</label>
				     <select class="select2 form-control" data-placeholder="Select Operator" readonly="readonly" tabindex="11" name="packing_by" id="packing_by" required >                                     
				     <?php
				     foreach ($staffs as $staff) {
				     		if($this->session->userdata('display_name') == $staff['display_name'])
				     		{
				       ?>
				       <option value="<?=$staff['ID']; ?>" ><?=$staff['display_name']; ?></option>
				       <?php
				       }
				     }
				     ?>
				   </select>
				  
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
					<textarea name="remark" class="form-control" style="resize: vertical;" required="required"></textarea>
				  </div>
				

                              <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                 <button class="btn btn-danger" onclick="return submitForm('commentForm')" type="submit" id="save" name="save">Save</button>
                                 <!-- <button class="btn btn-primary" onclick="reload();" type="button">New</button> -->
                              </div>                                                </div>
                        </section>
                     </div> 
                  </div>
                </form>
                <div class="col-lg-12">
                  <section class="panel">
                      <header class="panel-heading">
                          Outer Boxes
                      </header>
                      <div class="panel-body">
                         <table id="sample_1" class="table table-bordered table-striped table-condensed">
                         <thead>
                            <tr>
                               <th>#</th>
                               <th>Date</th>
                               <th>Party Name</th>
                               <th>Outer Box No</th>
                               <th>Item</th>
                               <th>Lot No</th>
                               <th>Total Meters</th>                                                     <th>Stock Room </th>
		               <th>Remarks</th>
		               <th>Packing By</th>
                               <th></th>
                            </tr>
                         </thead>
                         <tbody>
                            <?php
                            $sno = 1;
                            foreach ($outerboxes as $outerbox) {
                              $net_weight = '';
                              if($outerbox['packing_net_weight'] > 0)
                              {
                                $net_weight = number_format($outerbox['packing_net_weight'], 3, '.', '');                                                      }
                               ?>
                               <tr>
                                  <td><?=$sno; ?></td>
                                  <td><?php echo date('d-m-y',strtotime($outerbox['packing_date']))."<br>".$outerbox['packing_time']; ?></td>
                                  <td>
                                    <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $outerbox['packing_customer'], 'cust_name'); ?>
                                  </td>
                                  <td><?=$outerbox['box_no']; ?></td>
                                  <td>
                                    <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $outerbox['packing_innerbox_items'], 'item_name'); ?>
                                  </td>                                                                 <td>
                                    <?=$outerbox['dyed_lot_no']; ?>
                                  </td>
                                  <td>
                                    <?=$outerbox['total_meters']; ?>
                                  </td>
                                                                   <td>
                                    <?php
                                    	$this->db->select('*');
                                    	$this->db->from('bud_stock_rooms');
                                    	$this->db->where('stock_room_id',$outerbox['packing_stock_room']);
                                    	$q = $this->db->get();
                                    	$a  = $q->result_array();
                                    	foreach($a as $b)
                                    	{
                                    		echo "<b>".$b['stock_room_name']."</b><br>".$outerbox['packing_stock_place'];
                                    	}
                                    ?>
                              </td>   
                              <td><?=$outerbox['remark']; ?></td>
                               <th>
                                    <?php
                                    	$this->db->select('*');
                                    	$this->db->from('bud_users');
                                    	$this->db->where('ID',$outerbox['packing_by']);
                                    	$q = $this->db->get();
                                    	$a  = $q->result_array();
                                    	foreach($a as $b)
                                    	{
                                    		echo $b['user_login'];
                                    	}
                                    ?>
                              </th> 

                                  <td>
                                     <a href="<?=base_url(); ?>production/print_out_pack_slip/<?=$outerbox['box_no']; ?>" target="_blank" data-placement="top" data-original-title="Print" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips">Print</a>
                                      <a href="#<?=$outerbox['box_no']; ?>" data-toggle="modal" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips">Delete</a>
                                      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?=$outerbox['box_no']; ?>" class="modal fade">                                                                           <div class="modal-dialog">
                                            <div class="modal-content">
                                               <div class="modal-header">
                                                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                  <h4 class="modal-title">Remarks</h4>
                                               </div>
                                               <div class="modal-body">
                                                  <form role="form" method="post" action="<?=base_url(); ?>production/delete_box_2">
                                                     <input type="hidden" name="box_no" value="<?=$outerbox['box_no']; ?>">
                                                     <input type="hidden" name="function_name" value="outerBoxQtyWise_2">
                                                     <div class="form-group col-lg-12" style="margin-bottom: 15px;">
                                                        <textarea class="form-control" name="remarks" required style="width:100%;"></textarea>
                                                     </div>
                                                     <div style="clear:both;"></div>
                                                     <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                                  </form>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                  </td>
                               </tr>
                               <?php
                               $sno++;
                            }
                            ?>
                         </tbody>
                         </table>
                      </div>
                  </section>
               </div>                                                                                            <div class="pageloader"></div>                          <!-- page end-->
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

      $(".get_item_detail").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());
        var packing_item = $(this).val();
         var url = "<?=base_url()?>production/getpack_itemData/"+packing_item;
         var postData = 'packing_item='+packing_item;
         $.ajax({
             type: "POST",
             url: url,
             // data: postData,
             success: function(result)
             {
                 var dataArray = result.split(',');
                 $("#sample-box").html('');
                 if(dataArray[1] != '')
                 {
                     $("#sample-box").html('<img src="<?=base_url(); ?>uploads/itemsamples/'+dataArray[1]+'" style="width:auto;height:70px;max-width:100%;">');                           }
             }
         });      return false;
      });

      $(".total_qty").keyup(function(){       var no_rolls = $("#no_rolls").val();
        var qty_per_roll = $("#qty_per_roll").val();
        var total_qty = parseFloat(no_rolls) * parseFloat(qty_per_roll);
        $("#total_qty").val(total_qty);
      });

      function reload()
      {
        window.location.reload();
      }
      </script>
   </body>
</html>
