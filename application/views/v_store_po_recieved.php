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
                                <h3><i class="icon-book"></i> Job card received</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Action Messages -->
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
                          }                                                    if($this->session->flashdata('error'))
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
                      <!-- End Action Messages -->
                      <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            Summery
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                          <tr>
                              <th>Job No</th>
                              <th>Date</th>
                              <th>Category</th>
                              <th>Customer</th>
                              <th>Item</th>
                              <th>Quantity</th>
                              <th>Status</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          $sno = 1;
                          $jobcard_issued_qty = '';
                          foreach ($purchaseorders as $order) {
                            $jobcard_issued_qty = $order['jobcard_issued_qty'];
                            $jobcard_item = $order['jobcard_item'];
                            $items = $this->m_purchase->getDatas('bud_enquiry_items', 'enq_item_id', $jobcard_item);
                            foreach ($items as $item) {
                              $enq_item = $item['enq_item'];
                              $enq_itemcolor = $item['enq_itemcolor'];
                            }
                            ?>
                            <tr>
                                <td><?=$order['jobcard_id']; ?></td>
                                <td>
                                  <?=$order['jobcard_date']; ?>
                                </td>
                                <td>
                                  <?=$this->m_masters->getmasterIDvalue('bud_categories', 'category_id', $order['jobcard_category'], 'category_name'); ?>
                                </td>
                                <td class="">
                                  <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $order['jobcard_customer'], 'cust_name'); ?>
                                </td>
                                <td>
                                  <?=$this->m_masters->getmasterIDvalue('bud_items', 'item_id', $enq_item, 'item_name'); ?>/<?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $enq_itemcolor, 'shade_name'); ?>/<?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $enq_itemcolor, 'shade_code'); ?>
                                </td>
                                <td class=""><?=$order['jobcard_qty']; ?></td>
                                <td>
                                  <span class="<?=($jobcard_issued_qty > 0)?'label label-success':'label label-danger'; ?>"><?=($jobcard_issued_qty > 0)?'Stock Issued':'Wait for Stock'; ?></span>                                                          </td>
                            </tr>
                            <?php
                            $sno++;
                          }
                          ?>                                                </tbody>
                        </table>
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
        $("#shade_category").change(function () {
            var shade_category = $('#shade_category').val();
            var url = "<?=base_url()?>masters/getshadesdatas/"+shade_category;
            var postData = 'shade_category='+shade_category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(shades)
                {
                    var dataArray = shades.split(',');
                    $("#shade_family").html(dataArray[0]);
                    $(".shade_uoms").html(dataArray[1]);
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
