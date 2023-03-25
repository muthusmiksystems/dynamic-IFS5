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
                                Request Form Master
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
                                ?>                                                    <form class="cmxform form-horizontal tasi-form" role="form" method="post" action="<?=base_url('request_form/send_req_email');?>">
                                                                <div class="form-group col-lg-4">
                                        <label for="cust_merit">Select Customer Type</label>
                                        <select class="form-control" name="cust_merit" id="cust_merit" required>
                                          <option value="">Select</option>
                                          <option value="1">Poor</option>
                                          <option value="2">Good</option>
                                          <option value="3">Very Good</option>
                                          <option value="4">Excelent</option>
                                          <option value="5">Golden</option>
                                        </select>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="form-group">
                                        <div class="col-lg-10">
                                            <button class="btn btn-danger" type="submit" name="search" value="search">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>

                        <!-- Start Talbe List  --> 
                        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url('request_form/req_email_send');?>">                       

                          <section class="panel">
                            <header class="panel-heading">
                                Customers
                            </header>
                            <div class="panel-body">
                              <div class="form-group col-lg-6">
                                  <label for="id">Select Subject</label>
                                  <select class="form-control select2" name="id" id="id" required placeholder="Select Mail Subject">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($request_forms as $row) {
                                      ?>
                                      <option value="<?=$row->id; ?>"><?=$row->subject; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                <label>&nbsp;</label>
                                <br>
                                <button class="btn btn-danger" type="submit" name="send" value="send">Send</button>
                              </div>

                              <div style="clear:both;"></div>
                              <table class="table table-bordered table-striped table-condensed" id="sample_1">
                                <thead>
                                  <tr>
                                      <th>S.No</th>
                                      <th>Cust ID</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>
                                        <input type="checkbox" id="selectall">
                                      </th>
                                  </tr>
                                  </thead>
                                <tbody>
                                  <?php
                                  $sno = 1;
                                  foreach ($customers as $row) {
                                    ?>
                                    <tr>
                                      <td><?=$sno; ?></td>
                                      <td><?=$row->cust_id; ?></td>
                                      <td><?=$row->cust_name; ?></td>
                                      <td><?=$row->cust_email; ?></td>
                                      <td>
                                        <input type="checkbox" class="checkbox1" name="selected_email[<?=$row->cust_id; ?>]" value="<?=$row->cust_email; ?>">
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
                      </form>
                      <!-- End Talbe List  -->
                    </div>
                </div>             <!-- page end-->
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
        $("#category").change(function () {
            var category = $('#category').val();
            // alert(category);
            var url = "<?=base_url()?>masters/getLotscategorydatas/"+category;
            var postData = 'category='+category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(shades)
                {
                    $("#lot_shade_no").html(shades);
                }
            });
            return false;
        });
      });

      $(".shade").change(function(){
        $("#shade_name").select2("val", $(this).val());
        $("#shade_code").select2("val", $(this).val());
      });

      $('#selectall').click(function(event) {  //on click 
          if(this.checked) { // check select status
              $('.checkbox1').each(function() { //loop through each checkbox
                  this.checked = true;  //select all checkboxes with class "checkbox1"                     });
          }else{
              $('.checkbox1').each(function() { //loop through each checkbox
                  this.checked = false; //deselect all checkboxes with class "checkbox1"                             });           }
      });

  </script>

  </body>
</html>
