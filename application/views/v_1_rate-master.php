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
                           <h3><i class="icon-dropbox"></i> Rate Confirmation</h3>
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
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>admin/save_rate_master_1">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Item Retes                                          </header>
                           <div class="panel-body">                                                    <div class="form-group col-lg-2">
                                 <label for="customer">Customer Name</label>
                                 <select class="customer form-control select2" id="customer" name="customer" required>
                                    <option value="">Select Party</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>"><?=$customer['cust_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="customer_code">Customer Code</label>
                                 <select class="customer form-control select2" id="customer_code" name="customer_code" required>
                                    <option value="">Select Party</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                       ?>
                                       <option value="<?=$customer['cust_id'];?>"><?=$customer['cust_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_code">Item Code</label>
                                 <select class="form-control select2 items" id="item_code" name="item_code" required>
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                       ?>
                                       <option value="<?=$item['item_id'];?>"><?=$item['item_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_name">Item Name</label>
                                 <select class="form-control select2 items" id="item_name" name="item_name" required>
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
							  <div class="form-group col-lg-2">
                                 <label for="item_code">Shade No</label>
                                 <select class="form-control select2 shades" id="shade_id" name="shade_id" required>
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($shades as $row) {
                                       ?>
                                       <option value="<?=$row['shade_id'];?>"><?=$row['shade_code'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="shade_id">Shade Name</label>
                                 <select class="form-control select2 shades" id="shade_name" name="shade_name" required>
                                    <option value="">Select Shade</option>
                                    <?php
                                    foreach ($shades as $row) {
                                       ?>
                                       <option value="<?=$row['shade_id'];?>"><?=$row['shade_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                                                                                   <div class="clear"></div>
                           </div>
                        </section>
                     </div>                    

                     <div class="col-lg-12" id="result-data">

                     </div>

                     <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Update</button>
                                <button class="btn btn-default" type="button">Cancel</button>
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

      $(".shades").change(function(){
        
		$("#shade_code").select2("val", $(this).val());
        $("#shade_name").select2("val", $(this).val());
		  
		var customer = $("#customer").val();
        var shade_id = $("#shade_name").val();
        var item_name = $("#item_name").val();
        var url = "<?=base_url()?>admin/getItemRetes_1";
        var postData = 'search=1&customer='+customer+'&item_name='+item_name+'&shade_id='+shade_id;
        $.ajax({
           type: "POST",
           url: url,
           data: postData,
           success: function(result)
           {
              if(result == 'error')
              {
                  $("#result-data").html('Select First Party Name');
                  $("#item_name").select2("val", '');
                  $("#item_code").select2("val", '');
                  $("#shade_code").select2("val", '');
                  $("#shade_id").select2("val", '');
              }
              else
              {
                  $("#result-data").html(result);
                  console.log(result);
                  // $("#result-data").css("height", $("#result-data").height());
              }
           }
        });
        return false;
      });

      $(".customer").change(function(){
          $("#customer").select2("val", $(this).val());
          $("#customer_code").select2("val", $(this).val());
          $("#item_name").select2("val", '');
          $("#item_code").select2("val", '');
          $("#shade_code").select2("val", '');
		  $("#shade_name").select2("val", '');
         $("#result-data").html('');
      });

      $(".items").change(function(){
          $("#item_name").select2("val", $(this).val());
          $("#item_code").select2("val", $(this).val());
          $("#shade_code").select2("val", '');
		  $("#shade_name").select2("val", '');
         $("#result-data").html('');
      });
      </script>
   </body>
</html>
