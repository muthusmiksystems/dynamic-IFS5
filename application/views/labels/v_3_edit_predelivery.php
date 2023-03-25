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
                           <h3><i class="icon-map-marker"></i> Edit Pre Delivery</h3>
                        </header>
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
               <?php
               foreach ($delivery_details as $row) {
                  $p_delivery_boxes = explode(",", $row['p_delivery_boxes']);
                  $p_delivery_cust = $row['p_delivery_cust'];
                }
                foreach ($p_delivery_boxes as $key => $value) {
                  $if_exist = $this->m_masters->check_exist('bud_lbl_cart_items', 'item_id', $value);
                  $data = array(
                             'user_id'      => $this->session->userdata('user_id'),
                             'item_id'     => $value
                          );
                  if(!$if_exist)
                  {
                    $this->m_mycart->insertCartLbl($data);                 }
                }
               ?>
               <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>production/predelivery_3_edit">
                  <input type="hidden" name="packing_category" value="<?=$this->session->userdata('user_viewed'); ?>">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Pre Delivery
                              <span class="label label-danger" style="font-size:14px;"><?=$p_delivery_id; ?></span>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="search_date">Date</label>
                                 <input class="form-control" id="search_date" value="<?=date('d-m-Y');?>" name="search_date" type="text" required readonly="readonly">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="get_outerboxes form-control select2" id="item_name" name="item_name">
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
                                 <select class="get_outerboxes form-control select2" id="item_code" name="item_code">
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
                              <!-- <div class="form-group col-lg-3">
                                 <label for="party_name">Party Name</label>
                                 <select class="form-control select2" id="party_name" name="party_name">
                                    <option value="">Select Party Name</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>" <?=($customer['cust_id'] == $party_name)?'selected="selected"':''; ?>><?=$customer['cust_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div> -->
                              <div style="clear:both"></div>
                              <div class="form-group col-lg-3">
                                <button class="btn btn-danger" type="submit" name="search">Search</button>
                              </div>                                               </div>
                        </section>
                     </div> 
                  </div>
                  </form>                                              <?php
                  $outerboxes = $this->m_production->labelwiseOuterboxes($item_name);
                  ?>
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Outer Boxes
                            </header>
                            <div class="panel-body">
                               <table class="table table-striped border-top">
                               <thead>
                                  <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><label id="total_meters">0</label></th>
                                    <th><label id="net_weight">0</label></th>
                                    <th><label id="no_boxes">0 Boxes</label></th>
                                  </tr>
                                  <tr>
                                     <th>#</th>
                                     <th>Outer Box No</th>
                                     <th>Item</th>
                                     <th>Item Code</th>
                                     <th>Total Qty</th>
                                     <th>Gr.Weight</th>
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
                                  foreach ($outerboxes as $row) {
                                     $packing_gr_weight = ($row['packing_gr_weight'] != '')?$row['packing_gr_weight']:0;
                                     ?>
                                     <tr>
                                        <td><?=$sno; ?></td>
                                        <td><?=$row['box_prefix']?> - <?=$row['box_no']; ?></td>
                                        <td><?=$row['item_name']; ?></td>                                                                      <td><?=$row['item_id']; ?></td> 
                                        <td>
                                          <?=round($row['SUM(`total_qty`)']); ?>
                                          <input type="hidden" class="total_meters" id="mtr_<?=$row['box_no']; ?>" value="<?=round($row['SUM(`total_qty`)']); ?>">
                                        </td>
                                        <td>
                                          <?=$packing_gr_weight; ?>
                                          <input type="hidden" class="net_weight" id="wt_<?=$row['box_no']; ?>" value="<?=$packing_gr_weight; ?>">
                                        </td>
                                        <td>
                                           <?php
                                           if($row['predelivery_status'] == 1)
                                           {
                                            ?>
                                            <input type="checkbox" name="outer_boxes[]" class="checkbox" value="<?=$row['box_no']; ?>">
                                            <?php
                                           }
                                           else
                                           {
                                              ?>
                                              <label class="btn btn-primary btn-xs">Reserved</label>
                                              <?php
                                           }
                                           ?>
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

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="button" id="addtolist">Add to List</button>
                            </header>
                        </section>
                     </div>
                  </div>
                  <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>production/predelivery_3_update">
                  <input type="hidden" name="p_delivery_id" value="<?=$p_delivery_id; ?>">
                  <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Selected Boxes
                                <div style="clear:both;"></div>
                                <div class="form-group col-lg-3">
                                   <label for="p_delivery_cust">Party Name</label>
                                   <select class="form-control select2" id="p_delivery_cust" name="p_delivery_cust">
                                      <option value="">Select Party Name</option>
                                      <?php
                                      foreach ($customers as $customer) {
                                         ?>
                                         <option value="<?=$customer['cust_id'];?>" <?=($customer['cust_id'] == $p_delivery_cust)?'selected="selected"':'';?>><?=$customer['cust_name'];?></option>
                                         <?php
                                      }
                                      ?>
                                   </select>
                                </div>
                            </header>
                            <div class="panel-body" id="selected_items">
                                                  </div>
                        </section>
                     </div>
                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                            </header>
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
    net_weights_arr = $(".net_weight");
      total_meters_arr = $(".total_meters");

      $('#selecctall').click(function(event) {  //on click
          var no_boxes = 0;
          var net_weight = 0;
          var total_meters = 0;
          if(this.checked) { // check select status
              $('.checkbox').each(function() { //loop through each checkbox
                  var key = $(this).index(".checkbox"); 
                  this.checked = true;  //select all checkboxes with class "checkbox1"
                  net_weight += parseFloat((net_weights_arr[key]).value);
                  total_meters += parseFloat((total_meters_arr[key]).value);
                  no_boxes++;
                  $("#no_boxes").text(no_boxes+" Boxes");
                  $("#total_meters").text(total_meters.toFixed(4));
                  $("#net_weight").text(net_weight.toFixed(4));
              });
          }else{
              $('.checkbox').each(function() { //loop through each checkbox
                  this.checked = false; //deselect all checkboxes with class "checkbox1"
                  $("#no_boxes").text(0+" Boxes");
                  $("#total_meters").text("0");                                $("#net_weight").text("0");                            });           }
      });

      $(".checkbox").click(function(){
        var no_boxes = 0;
        var net_weight = 0;
        var total_meters = 0;
        $('.checkbox').each(function() {
          var key = $(this).index(".checkbox");
          if(this.checked)
          {
            total_meters += parseFloat((total_meters_arr[key]).value);
            net_weight += parseFloat((net_weights_arr[key]).value);
            no_boxes++;
          }
        });
        $("#no_boxes").text(no_boxes+" Boxes");
        $("#total_meters").text(total_meters.toFixed(4));
        $("#net_weight").text(net_weight.toFixed(4));
      });

      $(".get_outerboxes").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());       return false;
      });

      $('#selected_items').load('<?=base_url();?>production/selectedboxes_labels');

      $(function(){
        $("#addtolist").click(function() {
            var checkeditems = $('input:checkbox[name="outer_boxes[]"]:checked')
                       .map(function() { return $(this).val() })
                       .get()
                       .join(",");

            var url = "<?=base_url()?>production/predelivery_3_add";
            var postData = 'checkeditems='+checkeditems;
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function(result)
                {
                   $('#selected_items').load('<?=base_url();?>production/selectedboxes_labels');
                   // $('#selected_items').html(result);
                   // console.log(result);
                }
            });
            return false;
        });
      });
      $(function(){
        $( "a.remove" ).live( "click", function() {
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>production/predelivery_3_remove/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#selected_items').load('<?=base_url();?>production/selectedboxes_labels');
                }
            });
            return false;
        });
      });
      </script>
   </body>
</html>
