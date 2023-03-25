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
                                <h3>Customer Payment</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body">
                              <?php
                              if($this->session->flashdata('error'))        {
                                  $error  = $this->session->flashdata('error');
                              }                                                    if(function_exists('validation_errors') && validation_errors() != '')
                              {
                                  $error  = validation_errors();
                              }

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
                              }                                                        if($error)
                              {
                                ?>
                                <div class="alert alert-block alert-danger fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="icon-remove"></i>
                                  </button>
                                  <strong>Oops sorry!</strong> <?=$error; ?>
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
                              ?>
                              <form class="cmxform tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url('accounts/cust_payment_yt/'.$payment_id);?>">
                                <div class="row">
                                  <div class="form-group col-lg-2">
                                    <label for="customer_id">Customer Id</label>
                                    <select class="select2 form-control customer" name="customer_id" id="customer_id" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($customers as $row) {
                                        ?>
                                        <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer_id)?'selected="selected"':''; ?>><?=$row['cust_id']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-lg-4">
                                    <label for="customer_name">Customer Name</label>
                                    <select class="select2 form-control customer" id="customer_name" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($customers as $row) {
                                        ?>
                                        <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer_id)?'selected="selected"':''; ?>><?=$row['cust_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-lg-2">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" name="amount" id="amount" required value="<?=$amount; ?>">
                                  </div>
                                  <div class="form-group col-lg-4">
                                    <label for="payment_mode_cash">Payment Mode</label>
                                    <div style="clear:both;"></div>
                                    <label class="radio-inline">
                                        <input type="radio" name="payment_mode" class="payment_mode" id="payment_mode_cash" value="cash" <?=($payment_mode == 'cash')?'checked="checked"':''; ?>> Cash
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="payment_mode" class="payment_mode" id="payment_mode_cheque" value="cheque" <?=($payment_mode == 'cheque')?'checked="checked"':''; ?>> Cheque
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="payment_mode" class="payment_mode" id="payment_mode_dd" value="dd" <?=($payment_mode == 'dd')?'checked="checked"':''; ?>> DD
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="form-group col-md-2">
                                    <label class="control-label">Cheque / DD No</label><br/>
                                    <input class="form-control" name="cheque_dd_no" id="cheque_dd_no" <?=($payment_mode == 'cash')?'disabled=""':''; ?> value="<?=$cheque_dd_no; ?>" />
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label class="control-label">Bank Name</label><br/>
                                    <input class="form-control" name="bank_name" id="bank_name" <?=($payment_mode == 'cash')?'disabled=""':''; ?> value="<?=$bank_name; ?>" />
                                  </div>
                                  <div class="form-group col-md-3">
                                    <label class="control-label">Date</label><br/>
                                    <input class="form-control dateplugin" name="payment_date" id="payment_date" value="<?=$payment_date; ?>" />
                                  </div>
                                </div>
                                <div style="clear:both;"></div>
                                  <div class="row">
                                    <div class="form-group col-lg-12">
                                        <div class="">
                                            <button class="btn btn-danger" type="submit">Save</button>
                                        </div>
                                    </div>
                                  </div>
                              </form>                                                                                 </div>
                        </section>
                        <!-- End Form Section -->
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

      $(".customer").change(function(){
        $("#customer_name").select2("val", $(this).val());
        $("#customer_id").select2("val", $(this).val());
      });

      $(".payment_mode").click(function(){
        var payment_mode = $(this).val();
        if(payment_mode == 'cheque' || payment_mode == 'dd')
        {
          $("#bank_name").attr("disabled", false);
          $("#cheque_dd_no").attr("disabled", false);
        }
        else
        {
          $("#bank_name").attr("disabled", true);
          $("#cheque_dd_no").attr("disabled", true);
        }
      });
  });
  </script>

  </body>
</html>
