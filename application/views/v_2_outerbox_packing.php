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
                           <h3><i class="icon-dropbox"></i> Outer Box Packing (With Inner)</h3>
                        </header>
                        <div class="panel-body" id="sample-box">
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
               </div>
               <form class="cmxform form-horizontal tasi-form packing-form" role="form" id="commentForm" method="post" action="<?=base_url();?>production/outerbox_packing_save">
                  <input type="hidden" name="packing_category" value="<?=$this->session->userdata('user_viewed'); ?>">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Box No
                              <span class="label label-danger" style="font-size:14px;">M - <?=$new_box_no; ?></span>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="packing_date">Date</label>
                                 <input class="form-control dateplugin" id="packing_date" value="<?=date('d-m-Y');?>" name="packing_date" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="packing_customer">Party Name</label>
                                 <select class="form-control select2" id="packing_customer" name="packing_customer">
                                    <option value="">Select Party Name</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>"><?=$customer['cust_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                  <label for="packing_item">Item Name</label>
                                  <select class="get_innerboxes form-control select2" id="packing_item" name="packing_item" type="text" required>
                                     <option value="">Select Item</option>
                                     <?php
                                     foreach ($items as $item) {
                                        ?>
                                        <option value="<?=$item['item_id'];?>"><?=$item['item_name'];?></option>
                                        <?php
                                     }
                                     ?>
                                  </select>
                               </div>
                               <div class="form-group col-lg-3">
                                  <label for="packing_item_code">Item Code</label>
                                  <select class="get_innerboxes form-control select2" id="packing_item_code" name="packing_item_code" type="text" required>
                                     <option value="">Select Item</option>
                                     <?php
                                     foreach ($items as $item) {
                                        ?>
                                        <option value="<?=$item['item_id'];?>"><?=$item['item_id'];?></option>
                                        <?php
                                     }
                                     ?>
                                  </select>
                               </div>                                                     <div class="form-group col-lg-3">
                                <label for="packing_box_weight">Box Name</label>
                                <select class="weight form-control select2" id="packing_box_weight" name="packing_box_weight" tabindex="5">
                                   <option value="0">Select Box</option>
                                   <?php
                                   foreach ($tareweights as $tareweight) {
                                      ?>
                                      <option value="<?=$tareweight['tareweight_value']; ?>"><?=$tareweight['tareweight_name']; ?></option>
                                      <?php
                                   }
                                   ?>
                                </select>
                             </div>
                             <div class="form-group col-lg-3">
                                <label for="packing_no_boxes">No of Box</label>
                                <input class="weight form-control" id="packing_no_boxes" name="packing_no_boxes" tabindex="6" value="1" type="text">
                             </div>
                             <div class="form-group col-lg-3">
                                <label for="packing_bag_weight">Poly Bag</label>
                                <select class="weight form-control select2" id="packing_bag_weight" tabindex="7" name="packing_bag_weight">
                                   <option value="0">Select Box</option>
                                   <?php
                                   foreach ($tareweights as $tareweight) {
                                      ?>
                                      <option value="<?=$tareweight['tareweight_value']; ?>"><?=$tareweight['tareweight_name']; ?></option>
                                      <?php
                                   }
                                   ?>
                                </select>
                             </div>
                             <div class="form-group col-lg-3">
                                <label for="packing_no_bags">No of Bags</label>
                                <input class="weight form-control" id="packing_no_bags" tabindex="8" name="packing_no_bags" value="0" type="text">
                             </div>
                                           <div class="form-group col-lg-3">
                                <label for="packing_othr_wt">Other Merial Weight</label>
                                <input class="weight form-control" id="packing_othr_wt" tabindex="9" name="packing_othr_wt" type="text" value="0">
                             </div>                                                </div>
                        </section>
                     </div>                    

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Inner Boxes
                            </header>
                            <div class="panel-body" id="innerboxdata">
                                                   </div>
                        </section>
                     </div>

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                     </div>

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Outer Boxes
                            </header>
                            <div class="panel-body">
                               <table class="table table-striped border-top" id="sample_1">
                               <thead>
                                  <tr>
                                     <th>#</th>
                                     <th>Date</th>
                                     <th>Party Name</th>
                                     <th>Outer Box No</th>
                                     <th>Item</th>
                                     <th>Total Meters</th>
                                     <th>Total Net Weight</th>                                     			     
				     <th>Packing By</th>
                                     <th></th>
                                  </tr>
                               </thead>
                               <tbody>
                                  <?php
                                  $sno = 1;
                                  foreach ($outerboxes as $outerbox) {                                                                  ?>
                                     <tr>
                                        <td><?=$sno; ?></td>
                                        <td><?php echo date('d-m-y',strtotime($outerbox['packing_date']))."<br>".$outerbox['packing_time']; ?></td>
                                        <td>
                                          <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $outerbox['packing_customer'], 'cust_name'); ?>
                                        </td>
                                        <td><?=$outerbox['box_no']; ?></td>
                                        <td>
                                          <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $outerbox['packing_innerbox_items'], 'item_name'); ?>
                                        </td>                                                                       <td>
                                          <?=$outerbox['total_meters']; ?>
                                        </td>
                                                                        <td ><?php if(!empty($outerbox['packing_net_weight'])){echo number_format($outerbox['packing_net_weight'], 3, '.', ',');} ?></td>

                                         
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
                                           <a href="<?=base_url(); ?>production/delete_box_2/<?=$outerbox['box_no']; ?>/outerbox_packing" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips">Delete</a>
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
                     </div>
                  </div>
               </form>
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
    $("#innerboxdata").load('<?=base_url(); ?>production/getinnerboxes');

      $("#packing_customer").change(function(){
        var packing_customer = $("#packing_customer").val();
        var packing_item = $("#packing_item").val();
        var packing_item_code = $("#packing_item_code").val();
        var url = "<?=base_url()?>production/getinnerboxes";
        var postData = 'search=1&packing_customer='+packing_customer+'&packing_item='+packing_item+'&packing_item_code='+packing_item_code;
        $.ajax({
           type: "POST",
           url: url,
           data: postData,
           success: function(result)
           {
              $("#innerboxdata").html(result);
           }
        });
        return false;
      });

      $(".get_innerboxes").change(function(){
        var packing_customer = $("#packing_customer").val();
        $("#packing_item").select2("val", $(this).val());
        $("#packing_item_code").select2("val", $(this).val());
        var packing_item = $(this).val();
        var url = "<?=base_url()?>production/getinnerboxes";
        var postData = 'search=1&packing_customer='+packing_customer+'&packing_item='+packing_item;
        $.ajax({
           type: "POST",
           url: url,
           data: postData,
           success: function(result)
           {
              $("#innerboxdata").html(result);
           }
        });
        return false;
      });

      $(".get_innerboxes").change(function(){
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
         });
         return false;
      });

      </script>
   </body>
</html>
