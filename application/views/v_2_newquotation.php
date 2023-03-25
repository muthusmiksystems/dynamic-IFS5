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
                                <h3><i class="icon-book"></i> New Quotation</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
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
                            }                                                      if($this->session->flashdata('error'))
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
                            ?>   
                            </header>
                        </section>
                    </div>
                </div>
                <?php
                foreach ($enquiries as $enquiry) {
                    $enq_id = $enquiry['enq_id'];
                    $enq_customer = $enquiry['enq_customer'];
                    $enq_lead_time = $enquiry['enq_lead_time'];
                    $enq_reference = $enquiry['enq_reference'];
                    $enq_item_remarks = $enquiry['enq_item_remarks'];
                    $enq_remarks = $enquiry['enq_remarks'];
                    $enq_status = $enquiry['enq_status'];

                    $enq_customer_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $enquiry['enq_customer'], 'cust_name');
                }
                $quote_id = $this->m_masters->getmasterIDvalue('bud_te_quotations', 'quote_enq_id', $enq_id, 'quote_id');
                ?>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>purchase/savequotation_2">
                        <input type="hidden" name="enq_id" value="<?=$enq_id; ?>">
                        <input type="hidden" name="quote_id" value="<?=$quote_id; ?>">
                        <section class="panel">                                                <header class="panel-heading">
                                Quotation Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-6">
                                <label for="quote_date">Date</label>
                                <input class="datepicker form-control" id="quote_date" name="quote_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="quote_customer">Customer Name</label>
                                <input type="hidden" name="enq_customer" value="<?=$enq_customer; ?>">
                                <input class="form-control" id="quote_customer" name="quote_customer" value="<?=$enq_customer_name; ?>" required>
                              </div> 
                            </div>
                        </section>
                                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Items
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="cartdata">                                                        <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Group</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Uom</th>
                                    <th>Rate</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sno = 1;
                                foreach ($items as $item) {
                                  $enq_item_rates = explode(",", $item['enq_item_rate']);
                                  ?>
                                  <tr>
                                      <td><?=$sno; ?></td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $item['enq_item_group'], 'group_name'); ?>
                                      </td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item['enq_item'], 'item_name'); ?>
                                      </td>
                                      <td><?=$item['enq_req_qty']; ?></td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_item_uom'], 'uom_name'); ?>
                                      </td>
                                      <td>
                                          <?php
                                          foreach ($enq_item_rates as $key => $enq_item_rate) {
                                            ?>
                                            <div class="input-group" style="width:150px;">
                                              <input class="form-control" style="width:150px;" name="enq_item_rate[<?=$item['enq_item_id']; ?>][]" value="<?=$enq_item_rate; ?>" required>
                                              <span class="input-group-addon">
                                                <input type="radio" value="<?=$key; ?>" name="quote_rate_id[<?=$item['enq_item']; ?>]; ">                                                                                                                                    </span>
                                            </div>
                                            <?php
                                          }
                                          ?>
                                          <div class="input-group" style="width:150px;">
                                            <input class="form-control" style="width:150px;" name="enq_item_rate[<?=$item['enq_item_id']; ?>][]">
                                            <span class="input-group-addon">
                                              <input type="radio" value="<?=sizeof($enq_item_rates); ?>" name="quote_rate_id[<?=$item['enq_item']; ?>]; " checked="checked">                                                                                                                                  </span>
                                          </div>
                                      </td>
                                  </tr>
                                  <?php
                                  $sno++;
                                }
                                ?>                                                      </tbody>
                              </table>
                            </div>
                        </section>
                        <!-- End Item List -->

                                        <!-- Start Remarks -->
                        <section class="panel">                                                <header class="panel-heading">
                                Other Details
                            </header>                                              <div class="panel-body">
                              <div class="form-group col-lg-6">
                                <label for="quote_lead_time">Lead Time</label>
                                <div class="input-group">
                                  <input class="form-control"  name="quote_lead_time" id="quote_lead_time" value="<?=$enq_lead_time; ?>" type="text" placeholder="No of days">
                                  <span class="input-group-addon">Days</span>
                                </div>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="quote_reference">Reference</label>
                                <input class="form-control"  name="quote_reference" id="quote_reference" value="<?=$enq_reference; ?>" type="text" placeholder="">                                                      </div>
                              <div class="form-group col-lg-6">
                                <label for="quote_item_remarks">Item Remarks</label>
                                <textarea class="form-control" name="quote_item_remarks" id="quote_item_remarks"><?=$enq_item_remarks; ?></textarea>
                              </div>
                              <div class="form-group col-lg-6">
                                <label for="quote_remarks">Remarks</label>
                                <textarea class="form-control" name="quote_remarks" id="quote_remarks"><?=$enq_remarks; ?></textarea>
                              </div> 
                              <div class="form-group col-lg-6">
                                <label for="quote_payment_terms">Payment Terms</label>
                                <textarea class="form-control" name="quote_payment_terms" id="quote_payment_terms" placeholder=""></textarea>
                              </div>
                            </div>
                        </section>
                        <!-- End Remarks -->
                          <section class="panel">
                              <header class="panel-heading">
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="quote_revised" value="1" name="quote_revised" checked="checked"> Quote Revised
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="email" value="1" name="email"> Email
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="sms" value="1" name="sms"> SMS
                                  </label>
                              </header>
                              <div class="panel-body">
                                <button class="btn btn-danger" type="submit">Send</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                              </div>
                          </section>
                      </form>
                      <!-- Loading -->
                      <div class="pageloader"></div>
                      <!-- End Loading -->
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
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

      /*$(function(){
        $( "a.removecart" ).live( "click", function() {
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>purchase/deleteenquiryItem/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#cartdata').fadeOut('slow').load('<?=base_url();?>purchase/enquiry_items').fadeIn("slow");                           }
            });
            return false;
        });
      });*/

  </script>

  </body>
</html>
