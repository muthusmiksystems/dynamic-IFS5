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
                                <h3><i class="icon-map-marker"></i> Item Technical Data</h3>
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
               </div>                      <form action="<?=base_url();?>masters/<?=($combo_id == '')?'items_2_technical_save':'items_2_technical_update'; ?>" class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" enctype="multipart/form-data">                        <div class="row">
                   <div class="col-lg-12">
                      <section class="panel">                                             <header class="panel-heading">
                            Details
                         </header>
                         <div class="panel-body">
                            <div class="form-group col-lg-4">
                               <label for="item_group">Item Group</label>
                               <select class="form-control select2" name="item_group" id="item_group" required>
                                  <option value="">Select Group</option>
                                  <?php
                                  foreach ($itemgroups as $group) {
                                    ?>
                                    <option value="<?=$group['group_id']; ?>"><?=$group['group_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                               <label for="item_name">Item Name</label>
                               <select class="select2 form-control" name="item_name" id="item_name">
                                  <option value="">Select Item</option>
                                                         </select>
                            </div>
                            <div class="form-group col-lg-4">
                               <label for="item_code">Item Code</label>
                               <input class="form-control" id="item_code" name="item_code" type="text">
                            </div>                                                                                  <div class="clear"></div>
                         </div>
                      </section>
                   </div>
                   <!-- <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <button class="btn btn-danger" type="submit" name="<?=($combo_id == '')?'save':'update'; ?>"><?=($combo_id == '')?'Save':'Update'; ?></button>
                              <button class="btn btn-default" type="button">Cancel</button>
                          </header>
                      </section>
                   </div> -->                           </div>
               </form>
                <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
                <!-- page end-->
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

      <?php
      for ($i = 1; $i <= 5; $i++) {
        ?>
      $(function(){
        $( ".warp_<?=$i; ?>_shade" ).live( "change", function() {
            var shade = $(this).val();
            $( ".warp_<?=$i; ?>_shade" ).select2("val", shade); //set the value
        });
      });
        <?php
      };
      ?>
   $(document).ajaxStart(function() {
        // alert('Start');
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });
    
   $(function(){
      $("#item_group").change(function () {
          var item_group = $('#item_group').val();
          // alert(item_group);
          var url = "<?=base_url()?>purchase/getItems_2_datas/"+item_group;
          var postData = 'item_group='+item_group;
          $.ajax({
              type: "POST",
              url: url,
              // data: postData,
              success: function(groups)
              {
                  var dataArray = groups.split(',');
                  $('#item_name').html(dataArray[0]);
              }
          });
          return false;
      });
    }); 

    $(function(){
      $("#item_name").change(function () {
          var item_name = $('#item_name').val();
          window.location = '<?=base_url()?>masters/items_2_technical/'+item_name;
      });
    });

    $(function(){
      $("#item_code").blur(function () {
          var item_code = $('#item_code').val();
          window.location = '<?=base_url()?>masters/items_2_technical/'+item_code;
      });
    });
     
  </script>

  </body>
</html>
