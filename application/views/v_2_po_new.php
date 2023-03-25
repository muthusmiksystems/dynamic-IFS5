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
                           <h3><i class="icon-map-marker"></i> Purchase Order Entry</h3>
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
               <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>purchase/new_po_2_save">
                  <input type="hidden" name="po_category" value="<?=$this->session->userdata('user_viewed'); ?>">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Details
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-4">
                                 <label for="po_date">Date</label>
                                 <input class="form-control dateplugin" id="po_date" name="po_date" type="text" required>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="po_item">Item Name</label>
                                 <select class="form-control select2" id="po_item" name="po_item" type="text">
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
                              <div class="clear"></div>
                           </div>
                        </section>
                     </div>
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              Add Item
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="po_denier">Denier</label>
                                 <input class="form-control" id="po_denier" name="po_denier" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="po_color">Color</label>
                                 <select class="form-control select2" name="po_color" id="po_color">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                       ?>
                                       <option value="<?=$shade['shade_id'];?>"><?=$shade['shade_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="po_qty">Qty</label>
                                 <input class="form-control" id="po_qty" name="po_qty" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="enq_required_qty">&nbsp;</label>
                                <button type="button" class="form-control btn btn-primary addtocart"><i class="icon-plus"></i> Add</button>
                              </div>                                                         <div class="clear"></div>
                           </div>
                        </section>
                     </div>

                     <div class="col-lg-12">
                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Items
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="cartdata">                                                        <?php $this->load->view('v_2_po_items.php'); ?>
                              </table>
                            </div>
                        </section>
                        <!-- End Item List -->

                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
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

      $(function(){
        $(".addtocart").click(function() {
            var po_denier = $('#po_denier').val();
            var po_color = $('#po_color').val();
            var po_qty = $('#po_qty').val();
            var url = "<?=base_url()?>purchase/add_po_2_item";
            var postData = 'po_denier='+po_denier+'&po_color='+po_color+'&po_qty='+po_qty;
            $.ajax({
               type: "POST",
               url: url,
               data: postData,
               success: function(result)
               {
                  // console.log(result);
                  $('#cartdata').load('<?=base_url();?>purchase/po_2_items');                          }
            });
            return false;
        });
      });

      $(function(){
        $( "a.removecart" ).live( "click", function() {
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>purchase/remove_po_2_item/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#cartdata').load('<?=base_url();?>purchase/po_2_items');                           }
            });
            return false;
        });
      });
      </script>
   </body>
</html>
