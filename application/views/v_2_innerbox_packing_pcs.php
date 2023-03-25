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
               <?php
               if(isset($box_no))
               {
                  $box_details = $this->m_masters->getmasterdetails('bud_te_innerboxes', 'box_no', $box_no);
                  foreach ($box_details as $row) {
                     $packing_date = $row['packing_date'];
                     $packing_cust = $row['packing_cust'];
                     $packing_item = $row['packing_item'];
                     $packing_rolls = $row['packing_rolls'];
                     $packing_wt_mtr = $row['packing_wt_mtr'];
                     $packing_wt_mtr_new = $row['packing_wt_mtr_new'];
                     $packing_tot_mtr = $row['packing_tot_mtr'];
                     $packing_gr_weight = $row['packing_gr_weight'];
                     $packing_box_weight = $row['packing_box_weight'];
                     $packing_no_boxes = $row['packing_no_boxes'];
                     $packing_bag_weight = $row['packing_bag_weight'];
                     $packing_no_bags = $row['packing_no_bags'];
                     $packing_othr_wt = $row['packing_othr_wt'];
                     $packing_net_weight = $row['packing_net_weight'];
                     $packing_by = $row['packing_by'];
                     $packing_stock_room = $row['packing_stock_room'];
                     $packing_stock_place = $row['packing_stock_place'];
                     $remark = $row['remark'];
                  }
               }
               else
               {
                  $remark = '';
                  $packing_cust = '';
                  $packing_item = '';
                  $packing_rolls = '';
                  $packing_wt_mtr = '';
                  $packing_wt_mtr_new = '';
                  $packing_tot_mtr = '';
                  $packing_gr_weight = 0;
                  $packing_box_weight = '';
                  $packing_no_boxes = 1;
                  $packing_bag_weight = '';
                  $packing_no_bags = 1;
                  $packing_othr_wt = 0;
                  $packing_by = '';
                  $packing_stock_room = '';
                  $packing_stock_place = '';
               }
               $item_sample = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $packing_item, 'item_sample');
               ?>
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class="icon-dropbox"></i> Inner Box Packing (Pcs)</h3>
                        </header>
                        <div class="panel-body" id="sample-box">
                           <?php
                           if($item_sample != '')
                           {
                              ?>
                              <img src="<?=base_url(); ?>uploads/itemsamples/<?=$item_sample; ?>" style="width:auto;height:70px;max-width:100%;">
                              <?php
                           }
                           ?>
                        </div>
                     </section>
                  </div>
               </div>
               <div class="row">
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
               </div>                      <form class="cmxform form-horizontal tasi-form packing-form" role="form" id="commentForm" method="post" action="<?=base_url();?>production/innerbox_packing_save">                            <input type="hidden" name="packing_type" value="pcs">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Box No
                              <span class="label label-danger" style="font-size:14px;">S - <?=$new_box_no; ?></span>
                           </header>
                           <div class="panel-body">

                              <div class="col-lg-5">
                                 <div class="form-group">
                                    <label for="packing_date">Date</label>
                                    <input class="form-control dateplugin" id="packing_date" value="<?=date('d-m-Y');?>" name="packing_date" type="text" required>
                                 </div>
                                 <div class="form-group col-lg-8 no-padding">
                                    <label for="packing_item">Item</label>
                                    <select class="getitemdata form-control select2" id="packing_item" name="packing_item" type="text" tabindex="2">
                                       <option value="">Select Item</option>
                                       <?php
                                       foreach ($items as $item) {
                                          ?>
                                          <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $packing_item)?'selected="selected"':''; ?>><?=$item['item_name'];?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                 </div>
                                 <div class="form-group col-lg-4" style="float:right;">
                                    <label for="packing_item_code">Code</label>
                                    <select class="getitemdata form-control select2" id="packing_item_code" name="packing_item_code" type="text" tabindex="2">
                                       <option value="">Code</option>
                                       <?php
                                       foreach ($items as $item) {
                                          ?>
                                          <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $packing_item)?'selected="selected"':''; ?>><?=$item['item_id'];?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                 </div>
                                 <div style="clear:both;"></div>
                                 <div class="form-group">
                                    <label for="packing_rolls">Pcs</label>
                                    <input class="rolls form-control" id="packing_rolls" name="packing_rolls" type="text" tabindex="3" value="<?=$packing_rolls; ?>">
                                 </div>
                                 <div class="form-group col-lg-6 no-padding">
                                    <label for="packing_wt_mtr">Wt / Mtr (Default)</label>
                                    <input class="rolls form-control" id="packing_wt_mtr" name="packing_wt_mtr" type="text" value="<?=$packing_wt_mtr; ?>" readonly="readonly" tabindex="-1">
                                 </div>
                                 <div class="form-group col-lg-6 no-padding right">
                                    <label for="packing_wt_mtr_new">Wt / Mtr (New)</label>
                                    <input class="rolls form-control" id="packing_wt_mtr_new" name="packing_wt_mtr_new" tabindex="4" value="<?=$packing_wt_mtr_new; ?>" type="text">
                                 </div>
                                 <div class="form-group">
                                    <label for="packing_tot_mtr">Total Meters</label>
                                    <input class="form-control" id="packing_tot_mtr" name="packing_tot_mtr" type="text" readonly="readonly" value="0" tabindex="-1">
                                 </div>
                              </div>
                              <div class="col-lg-4">
                                 <div class="form-group">
                                    <label for="packing_gr_weight">Gross Weight</label>
                                    <input onclick='javascript: this.value = ""' class="weight form-control" id="packing_gr_weight" name="packing_gr_weight" type="number" autofocus tabindex="1" style="font-size:26px;padding: 0px 12px;">
                                 </div>                                                       <div class="form-group col-lg-6 no-padding">
                                    <label for="packing_box_weight">Box Name</label>
                                    <select class="weight form-control select2" id="packing_box_weight" name="packing_box_weight" tabindex="5">
                                       <option value="0">Select Box</option>
                                       <?php
                                       foreach ($tareweights as $tareweight) {
                                          ?>
                                          <option value="<?=$tareweight['tareweight_value']; ?>" <?=($tareweight['tareweight_value'] == $packing_box_weight)?'selected="selected"':''; ?>><?=$tareweight['tareweight_name']; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                 </div>
                                 <div class="form-group col-lg-6">
                                    <label for="packing_no_boxes">No of Box</label>
                                    <input class="weight form-control" id="packing_no_boxes" name="packing_no_boxes" tabindex="6" value="<?=$packing_no_boxes; ?>" type="text">
                                 </div>
                                 <div class="form-group col-lg-6 no-padding">
                                    <label for="packing_bag_weight">Poly Bag</label>
                                    <select class="weight form-control select2" id="packing_bag_weight" tabindex="7" name="packing_bag_weight">
                                       <option value="0">Select Box</option>
                                       <?php
                                       foreach ($tareweights as $tareweight) {
                                          ?>
                                          <option value="<?=$tareweight['tareweight_value']; ?>" <?=($tareweight['tareweight_value'] == $packing_bag_weight)?'selected="selected"':''; ?>><?=$tareweight['tareweight_name']; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                 </div>
                                 <div class="form-group col-lg-6">
                                    <label for="packing_no_bags">No of Bags</label>
                                    <input class="weight form-control" id="packing_no_bags" tabindex="8" name="packing_no_bags" value="<?=$packing_no_bags; ?>" type="text">
                                 </div>
                                 <div class="form-group">
                                    <label for="packing_othr_wt">Other Merial Weight</label>
                                    <input class="weight form-control" id="packing_othr_wt" tabindex="9" name="packing_othr_wt" type="text" value="<?=$packing_othr_wt; ?>">
                                 </div>
                                 <div class="form-group">
                                    <label for="packing_net_weight">Net Weight</label>
                                    <input class="form-control" id="packing_net_weight" name="packing_net_weight" value="0" type="text" tabindex="-1" readonly="readonly">
                                 </div>
                                                       </div>
                              <div class="col-lg-3">
                                 <div class="form-group">
                                    <label for="packing_cust">Party Name</label>
                                    <select class="select2 form-control" data-placeholder="Select Operator" name="packing_cust" id="packing_cust" tabindex="10">
                                     <option value="">Select Party</option>
                                     <?php
                                     foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id']; ?>" <?=($customer['cust_id'] == $packing_cust)?'selected="selected"':''; ?>><?=$customer['cust_name']; ?></option>
                                       <?php
                                     }
                                     ?>
                                   </select>
                                 </div>
                                 <div class="form-group">
				    <label for="packing_by">Packed by</label>
				     <select class="select2 form-control" data-placeholder="Select Operator" readonly="readonly" tabindex="11" 
                                    name="packing_by" id="packing_by" required >                                     
				     <?php
				     foreach ($staffs as $staff) {
				     		if($this->session->userdata('display_name') == $staff['display_name'])
				     		{
				       ?>
				       <option value="<?=$staff['ID']; ?>" <?=($staff['ID'] == $packing_by)?'selected="selected"':''; ?>>
				       <?=$staff['display_name']; ?></option>
				       <?php
				       }
				     }
				     ?>
				   </select>
				 </div>

                                 <div class="form-group">
                                    <label for="packing_stock_place">Stock Place</label>
                                    <input class="form-control" id="packing_stock_place" name="packing_stock_place" tabindex="13" type="text" value="<?=$packing_stock_place; ?>">
                                 </div>
                                 <div class="form-group">
					<label for="po_date">Remarks : </label>                               
					<textarea name="remark" class="form-control" style="resize: vertical;" required="required"><?=$remark; ?></textarea>
			         </div>
                              </div>
                                                                                                           <div class="clear"></div>
                           </div>
                        </section>
                     </div>                    

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" tabindex="14" type="submit">Print &amp; New</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                     </div>
                  </div>
               </form>
               <section class="panel">
                  <header class="panel-heading">
                     Inner Boxes
                  </header>
                  <table class="table table-striped border-top" id="sample_1">
                     <thead>
                        <tr>
                           <th>Sno</th>
                           <th>Date</th>
                           <th>Pary Name</th>
                           <th>Inner Box No</th>
                           <th>Item Code</th>
                           <th>Item Name</th>
                           <th>Qty in Meter</th>
                           <th>Gr. Weight</th>
                           <th>Net Weight</th>
                           <th>Stock Room </th>
		           <th>Remarks</th>
		           <th>Packing By</th>

                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $sno = 1;
                        foreach ($innerboxes as $innerbox) {
                           ?>
                           <tr>
                              <td><?=$sno; ?></td>
                              <td><?php echo date('d-m-y',strtotime($innerbox['packing_date']))."<br>".$innerbox['packing_time']; ?></td>
                              <td>
                                 <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $innerbox['packing_cust'], 'cust_name'); ?>
                              </td>
                              <td>S-<?=$innerbox['box_no']; ?></td>
                              <td><?=$innerbox['packing_item']; ?></td>
                              <td>
                                 <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $innerbox['packing_item'], 'item_name'); ?>
                              </td>
                              <td align="right"><?=number_format($innerbox['packing_tot_mtr'], 2, '.', ''); ?></td>
                              <td align="right"><?=$innerbox['packing_gr_weight']; ?></td>
                              <td ><?=number_format($innerbox['packing_net_weight'], 3, '.', ','); ?></td>
                                          <td>
                                    <?php
                                    	$this->db->select('*');
                                    	$this->db->from('bud_stock_rooms');
                                    	$this->db->where('stock_room_id',$innerbox['packing_stock_room']);
                                    	$q = $this->db->get();
                                    	$a  = $q->result_array();
                                    	foreach($a as $b)
                                    	{
                                    		echo "<b>".$b['stock_room_name']."</b><br>".$innerbox['packing_stock_place'];
                                    	}
                                    ?>
                              </td>   
                              <td><?=$innerbox['remark']; ?></td>
                               <th>
                                    <?php
                                    	$this->db->select('*');
                                    	$this->db->from('bud_users');
                                    	$this->db->where('ID',$innerbox['packing_by']);
                                    	$q = $this->db->get();
                                    	$a  = $q->result_array();
                                    	foreach($a as $b)
                                    	{
                                    		echo $b['user_login'];
                                    	}
                                    ?>
                              </th> 

                              <td>
                                 <a href="<?=base_url(); ?>production/innerbox_packing/<?=$innerbox['box_no']; ?>" data-placement="top" data-original-
                                 title="Duplicate" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Duplicate</a>
                                 <a href="<?=base_url(); ?>production/print_i_packing_slip/<?=$innerbox['box_no']; ?>" target="_blank" data-placement="top" 
                                 data-original-title="Print" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips">Print</a>
                               </td>
                           </tr>
                           <?php
                           $sno++;
                        }
                        ?>
                     </tbody>
                  </table>
              </section>
               <div class="pageloader"></div>                          <!-- page end-->
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
      $(".getitemdata").change(function(){
         $("#packing_item").select2("val", $(this).val());
         $("#packing_item_code").select2("val", $(this).val());
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
                 $("#packing_wt_mtr").val(dataArray[0]);
                 $("#sample-box").html('');
                 if(dataArray[1] != '')
                 {
                     $("#sample-box").html('<img src="<?=base_url(); ?>uploads/itemsamples/'+dataArray[1]+'" style="width:auto;height:70px;max-width:100%;">');                           }
                 var packing_net_weight = $("#packing_net_weight").val();
                 $("#packing_tot_mtr").val((packing_net_weight / dataArray[0]).toFixed(2));
             }
         });
         return false;
      });

      $("#packing_wt_mtr_new").live('keyup', function ()
      {
         var packing_net_weight = $("#packing_net_weight").val();
         if($(this).val() > 0)
         {
            $("#packing_tot_mtr").val((packing_net_weight / $(this).val()).toFixed(2));
         }
         else
         {
            var packing_wt_mtr = $("#packing_wt_mtr").val();
            $("#packing_tot_mtr").val((packing_net_weight / packing_wt_mtr).toFixed(2));
         }
      });

      $("input.weight").live('keyup', function ()
      {
         if($(this).val() >= 0)
         {
            var packing_gr_weight = $("#packing_gr_weight").val();
            var packing_box_weight = $("#packing_box_weight").val();
            var packing_no_boxes = $("#packing_no_boxes").val();
            var packing_bag_weight = $("#packing_bag_weight").val();
            var packing_no_bags = $("#packing_no_bags").val();
            var packing_othr_wt = $("#packing_othr_wt").val();
            var packing_wt_mtr = $("#packing_wt_mtr").val();
            var packing_wt_mtr_new = $("#packing_wt_mtr_new").val();
            var box_weight = parseFloat(packing_box_weight) * parseFloat(packing_no_boxes);
            var bag_weight = parseFloat(packing_bag_weight) * parseFloat(packing_no_bags);
            var tareweight = parseFloat(box_weight) + parseFloat(bag_weight) + parseFloat(packing_othr_wt);
            var netweight = packing_gr_weight - tareweight;
            if(packing_wt_mtr_new > 0)
            {
               var total_meters = netweight / packing_wt_mtr_new;
            }
            else
            {
               var total_meters = netweight / packing_wt_mtr;                   }
            $("#packing_tot_mtr").val(total_meters.toFixed(2));
            $("#packing_net_weight").val(netweight);
         }
      });

      $("select.weight").live('change', function ()
      {
         if($(this).val() >= 0)
         {
            var packing_gr_weight = $("#packing_gr_weight").val();
            var packing_box_weight = $("#packing_box_weight").val();
            var packing_no_boxes = $("#packing_no_boxes").val();
            var packing_bag_weight = $("#packing_bag_weight").val();
            var packing_no_bags = $("#packing_no_bags").val();
            var packing_othr_wt = $("#packing_othr_wt").val();
            var packing_wt_mtr = $("#packing_wt_mtr").val();
            var packing_wt_mtr_new = $("#packing_wt_mtr_new").val();
            var box_weight = parseFloat(packing_box_weight) * parseFloat(packing_no_boxes);
            var bag_weight = parseFloat(packing_bag_weight) * parseFloat(packing_no_bags);
            var tareweight = parseFloat(box_weight) + parseFloat(bag_weight) + parseFloat(packing_othr_wt);
            var netweight = packing_gr_weight - tareweight;
            if(packing_wt_mtr_new > 0)
            {
               var total_meters = netweight / packing_wt_mtr_new;
            }
            else
            {
               var total_meters = netweight / packing_wt_mtr;                   }
            $("#packing_tot_mtr").val(total_meters.toFixed(2));
            $("#packing_net_weight").val(netweight);
         }
      });
      $("#packing_gr_weight").on('blur', function(evt) {
	   if ($(this).val().trim()) {
	     var txt = $(this).val().replace(/\s/g, '');
	     var n = parseFloat(txt, 10);
	     var formatted = n.toLocaleString('en', {
	        minimumFractionDigits: 3,
	       maximumFractionDigits: 3
	     }).replace(/,/g, ' ');
	     $(this).val(formatted);
	   }
	 });
	 $('#packing_gr_weight').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
      </script>
   </body>
</html>
