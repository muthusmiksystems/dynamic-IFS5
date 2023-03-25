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
                                <h3><i class="icon-book"></i> Packing Items</h3>
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
                              <th>Box No</th>
                              <th>Date</th>
                              <th>Category</th>
                              <th>Customer</th>
                              <th>Item</th>
                              <th>Gross Weight</th>
                              <th>Tare Weight</th>
                              <th>Net Weight</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          $sno = 1;
                          foreach ($boxes as $box) {
                            $lotname = '';
                            $box_id = $box['box_id'];
                            $box_date = $box['box_date'];
                            $box_category = $box['box_category'];
                            $box_customer = $box['box_customer'];
                            $box_item = $box['box_item'];
                            $box_itemcolor = $box['box_itemcolor'];
                            $box_item_lot_no = $box['box_item_lot_no'];
                            $box_grossweight = $box['box_grossweight'];
                            $box_tareweight = $box['box_tareweight'];
                            $box_netweight = $box['box_netweight'];

                            $machine_id = $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $box_item_lot_no, 'lot_prefix');
                            $lotname .= $this->m_masters->getmasterIDvalue('bud_machines', 'machine_id', $machine_id, 'machine_prefix');
                            $lotname .= $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $box_item_lot_no, 'lot_no');

                            $enq_item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $box_item, 'item_code');
                            $enq_item_name .= '/'.$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $box_itemcolor, 'shade_code');
                            $enq_item_name .= '/'.$lotname;
                            $box_category_name = $this->m_masters->getmasterIDvalue('bud_categories', 'category_id', $box_category, 'category_name');
                            $box_customer_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $box_customer, 'cust_name');
                            ?>
                            <tr>
                                <td><?=$box_id; ?></td>                                                        <td><?=$box_date; ?></td>                                                        <td><?=$box_category_name; ?></td>                                                        <td><?=$box_customer_name; ?></td>                                                        <td><?=$enq_item_name; ?></td>                                                        <td><?=$box_grossweight; ?></td>                                                        <td><?=$box_tareweight; ?></td>                                                        <td><?=$box_netweight; ?></td>                                                    </tr>
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
