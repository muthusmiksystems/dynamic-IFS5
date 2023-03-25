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
                                <h3><i class="icon-bar-chart"></i> Sales Budget - <span style="color:red;"><?=date('F Y')?></span></h3>
                            </header>
                        </section>
                    </div>
                </div>                        <div class="row">
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
                            ?>
                            <div class="form-group col-lg-3">
                               <label for="party_name">Party Name</label>
                               <select class="form-control select2" id="party_name" name="party_name">
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
                               <label for="item_name">Item Name</label>
                               <select class="get_outerboxes form-control select2" id="item_name" name="item_name">
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
                               <label for="item_code">Item Code</label>
                               <select class="get_outerboxes form-control select2" id="item_code" name="item_code">
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
                               <label for="item_qty">Qty</label>
                               <input class="form-control" id="item_qty" name="item_qty" type="text">
                            </div>
                            <div class="form-group col-lg-1">
                               <label>&nbsp;</label>
                               <button type="button" id="addtocart" class="form-control btn btn-primary"><i class="icon-plus"></i> Add</button>
                            </div>
                          </div>
                        </section>
                        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>marketing/updateSalesBudget">
                        <section class="panel">
                          <div class="panel-body">                                             <table class="table table-bordered table-striped table-condensed">
                            <thead>                                                    <!-- <tr>
                                <th colspan="4"> <strong style="color:red">Grand Total</strong></th>
                                <th><strong style="color:red;float:right;"><?=number_format($total_amount, 2, '.', ''); ?></strong></th>
                                <th><strong id="total_target" style="color:red;float:right;"><?=number_format($total_target, 2, '.', ''); ?></strong></th>
                                <th><strong style="color:red"><?=number_format($total_collect, 2, '.', ''); ?></strong></th>
                                <th><strong style="color:red"><?=number_format($total_debit, 2, '.', ''); ?></strong></th>
                                <th><strong style="color:red"><?=$total_selected; ?></strong></th>
                              </tr> -->
                              <tr>
                                <th>#</th>
                                <th>Party Name</th>
                                <th>Item Name</th>
                                <th style="text-align:right;">Qty</th>
                                <th style="text-align:right;">Rate</th>
                                <th style="text-align:right;">Amount</th>
                                <th style="text-align:right;">Actual Qty</th>
                                <th style="text-align:right;">Actual Amount</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sno = 1;
                            foreach ($salesItems as $row) {
                              $id = $row['id'];
                              $party_name = $row['party_name'];
                              $item_name = $row['item_name'];
                              $item_qty = $row['item_qty'];
                              $item_rate = $row['item_rate'];
                              $actual_qty = $row['actual_qty'];
                              $actual_amt = $actual_qty * $item_rate;
                              ?>
                              <tr>
                                <td><?=$sno; ?></td>
                                <td><?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $party_name, 'cust_name'); ?></td>
                                <td><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item_name, 'item_name'); ?></td>
                                <td align="right"><?=$item_qty; ?></td>
                                <td align="right"><?=$item_rate; ?></td>
                                <td align="right"><?=number_format(($item_qty*$item_rate), 2, '.', ''); ?></td>
                                <td align="right">
                                  <input size="15" type="text" name="actual_qty[<?=$id; ?>]" value="<?=$actual_qty; ?>">
                                </td>
                                <td align="right"><?=number_format($actual_amt, 2, '.', ''); ?></td>
                                <td>
                                  <a href="<?=base_url();?>masters/deletemaster/bud_mark_sales_budget/id/<?=$id; ?>/marketing/salesBudget" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
                                </td>
                              </tr>
                              <?php
                              $sno++;
                            }
                            ?>
                            </tbody>
                            </table>

                        </div>
                    </section>                              <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit">Update</button>
                        </header>
                    </section>
                    </form>
                    <!-- Loading -->
                    <div class="pageloader"></div>
                    <!-- End Loading -->
                </div>
              </div>           <!-- page end-->
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

      $(".get_outerboxes").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());       return false;
      });

      $(function(){
        $("#addtocart").click(function() {
            var party_name = $('#party_name').val();
            var item_name = $('#item_name').val();
            var item_qty = $('#item_qty').val();

            var url = "<?=base_url()?>marketing/addSalesBudget";
            var postData = 'party_name='+party_name+'&item_name='+item_name+'&item_qty='+item_qty;
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function(result)
                {
                   location.reload(true);
                }
            });
            return false;
        });
      });
  </script>

  </body>
</html>
