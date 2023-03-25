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
                                Sale Tax Email
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
                                ?>                                                    <form class="cmxform form-horizontal tasi-form" role="form" method="post" action="<?=base_url('request_form/send_tax_email_te');?>">
                                                                <div class="form-group col-lg-3">
                                        <label for="cust_id">Select Customer</label>
                                        <select class="form-control select2" name="cust_id" id="cust_id" placeholder="Select Customer">
                                          <option value="">Select</option>
                                          <?php
                                          foreach ($customers as $row) {
                                            ?>
                                            <option value="<?=$row->cust_id; ?>"><?=$row->cust_name; ?></option>
                                            <?php
                                          }
                                          ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="invoice_id">Select Invoice</label>
                                        <select class="form-control select2" name="invoice_id" id="invoice_id" required placeholder="Select Invoice">
                                          <option value="">Select</option>
                                          <?php
                                          foreach ($invoices as $row) {
                                            ?>
                                            <option value="<?=$row->invoice_id; ?>"><?=$row->invoice_no; ?></option>
                                            <?php
                                          }
                                          ?>
                                        </select>
                                    </div>

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
                                    <div class="form-group col-lg-8">
                                        <label for="other_emails">Other Emails</label>
                                        <input class="form-control" name="other_emails" id="other_emails" placeholder="Email 1, Email 2">                                                                      </div>
                                    <div style="clear:both"></div>
                                    <div class="form-group">
                                        <div class="col-lg-10">
                                            <button class="btn btn-danger" type="submit" name="send" value="send">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
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
        $("#cust_id").change(function () {
            var cust_id = $('#cust_id').val();
            var url = "<?=base_url()?>request_form/get_cust_invoice_te/"+cust_id;
            var postData = 'cust_id='+cust_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    var result = $.parseJSON(result);
                    $("invoice_id").select2("destroy");
                    $("#invoice_id").html('');
                    var invoiceData = '';
                    $.each(result.invoices, function(invoice_id,invoice_no){
                        invoiceData += '<option value="'+invoice_id+'">'+invoice_no+'</option>';
                        $("#invoice_id").html(invoiceData);
                    });

                    $("#invoice_id").select2();
                    // console.log(result);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#invoice_id").change(function () {
            var invoice_id = $('#invoice_id').val();
            var url = "<?=base_url()?>request_form/get_invoice_cust_te/"+invoice_id;
            var postData = 'invoice_id='+invoice_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    console.log(result);
                    var result = $.parseJSON(result);
                    $.each(result.customer, function(customer_id,customer_name){
                      $("#cust_id").select2("val", customer_id);
                    });
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
