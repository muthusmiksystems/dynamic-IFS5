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
    


  
    <style type="text/css">
    #items_row td input
    {
      width: 100%;
    }
    #items_row td textarea
    {
      width: 100%;
    }
    </style>
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
                                <h3><i class="icon-bar-chart"></i> Collection Budget - <span style="color:red;"><?=date('F Y')?></span></h3>
                            </header>
                        </section>
                    </div>
                </div>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>marketing/saveCollecBudget">
                <div class="row">
                    <div class="col-lg-12">
                      <section class="panel">                                          <div class="panel-body">
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
                            $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
                            if($is_admin)
                            {
                              ?>
                              <div class="form-group col-lg-3">
                                 <label for="marketing_staff">Marketing Staff</label>
                                 <select class="customer customer form-control select2" id="marketing_staff" name="marketing_staff">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($users as $row) {
                                       ?>
                                       <option value="<?=$row['ID'];?>" <?=($row['ID'] == $staff_id)?'selected="selected"':''; ?>><?=$row['user_login']; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <?php
                            }
                            ?>
                            <?php
                            $invoices = array();
                            $invoices = $this->m_marketing->getInvoices($staff_id);
                            $total_amount = 0;
                            $invoice_id_array = array();
                            foreach ($invoices as $row) {
                              $total_amount += $row['net_amount'];
                              $invoice_id_array[] = $row['invoice_id'];
                            }
                            $collections = $this->m_marketing->getCollecBudget(date("Y-m"), $staff_id);
                            $amounts = array();
                            $physical_collection = array();
                            $selected_invoices = array();
                            foreach ($collections as $row) {
                              $selected_invoices = explode(",", $row['selected_invoices']);
                              $amounts = explode(",", $row['amounts']);
                              $physical_collection = explode(",", $row['physical_collection']);
                            }

                            $collected_amts = array();
                            $debit_amts = array();
                            foreach ($selected_invoices as $key => $value) {
                              $collected_amts[$value] = $physical_collection[$key];
                              $debit_amts[$value] = $amounts[$key] - $physical_collection[$key];
                            }
                            $total_target = array_sum($amounts);
                            $total_collect = array_sum($collected_amts);
                            $total_debit = array_sum($debit_amts);
                            $total_selected = sizeof($selected_invoices);
                            ?>
                            <table class="table table-bordered table-striped table-condensed">
                            <thead>
                              <tr>
                                <th colspan="4"> <strong style="color:red">Grand Total</strong></th>
                                <th><strong style="color:red;float:right;"><?=number_format($total_amount, 2, '.', ''); ?></strong></th>
                                <th><strong id="total_target" style="color:red;float:right;"><?=number_format($total_target, 2, '.', ''); ?></strong></th>
                                <th><strong style="color:red"><?=number_format($total_collect, 2, '.', ''); ?></strong></th>
                                <th><strong style="color:red"><?=number_format($total_debit, 2, '.', ''); ?></strong></th>
                                <th><strong style="color:red"><?=$total_selected; ?></strong></th>
                              </tr>
                              <tr>
                                <th>#</th>
                                <th>Party Name</th>
                                <th>Inv.No</th>
                                <th>Date</th>
                                <th style="text-align:right;">Amount</th>
                                <th style="text-align:right;">Terget Collection</th>
                                <th>Physical Collection</th>
                                <th>Debit</th>
                                <th>Select</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php                                                $sno = 1;
                            foreach ($invoices as $row) {
                              $customer = $row['customer'];
                              $invoice_id = $row['invoice_id'];
                              $invoice_date = $row['invoice_date'];
                              $net_amount = $row['net_amount'];
                              $ed = explode("-", $invoice_date);
                              $invoice_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
                              ?>
                              <tr>
                                <td><?=$sno; ?></td>
                                <td><?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer, 'cust_name'); ?></td>
                                <td><?=$invoice_id; ?></td>
                                <td><?=$invoice_date; ?></td>
                                <td align="right">
                                  <?=number_format($net_amount, 2, '.', ''); ?>
                                  <input type="hidden" name="amounts[<?=$invoice_id; ?>]" value="<?=$net_amount; ?>">
                                </td>
                                <td align="right">
                                  <?=number_format($net_amount, 2, '.', ''); ?>
                                  <input type="hidden" class="terget_collec" id="terget_collec_<?=$invoice_id; ?>" name="terget_collec_<?=$invoice_id; ?>" value="<?=$net_amount; ?>">
                                </td>
                                <td>
                                  <input type="text" name="physical_collection[<?=$invoice_id; ?>]" value="<?=(array_key_exists ( $invoice_id , $collected_amts ))?$collected_amts[$invoice_id]:''; ?>">
                                </td>
                                <td>
                                  <?php //echo (array_key_exists ( $invoice_id , $debit_amts ))?$debit_amts[$invoice_id]:''; ?>
                                </td>
                                <td>
                                  <input type="checkbox" class="checkbox" name="selected_invoices[]" <?=(in_array($invoice_id, $selected_invoices))?'checked="checked"':'';?> value="<?=$invoice_id; ?>">
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
                    <?php
                    if(!$is_admin)
                    {
                      ?>
                      <section class="panel">
                          <header class="panel-heading">
                              <button class="btn btn-danger" type="submit">Update</button>
                          </header>
                      </section>
                      <?php
                    }
                    ?>                             <!-- Loading -->
                    <div class="pageloader"></div>
                    <!-- End Loading -->
                </div>
              </div>           </form>
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
      var no_boxes = 0;
      terget_collec = $(".terget_collec");
      $(".checkbox").click(function(){
        var total_target = 0;
        $('.checkbox').each(function() {
          var key = $(this).index(".checkbox");
          if(this.checked)
          {
            total_target += parseFloat((terget_collec[key]).value);
            no_boxes++;
          }
        });
        $("#total_target").text(total_target.toFixed(2));
      });

      $("#marketing_staff").change(function(){
        window.location.href = "<?=base_url(); ?>marketing/targetSalesReceipt/"+$(this).val();
      });
  </script>

  </body>
</html>
