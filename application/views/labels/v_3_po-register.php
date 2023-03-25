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
                                <h3>PO Register</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">                                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="itemlist">
                            <thead>
                              <tr>
                                  <th>#</th>
                                  <th>PO No</th>
                                  <th>Party</th>
                                  <th>Item Name</th>
                                  <th>Item Code</th>
                                  <th>Qty in<br>each size</th>
                                  <th>Production<br>Time(Hrs)</th>
                                  <th>Total Po Qty</th>
                                  <th>Total Production<br> Time(Hrs)</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($purchaseorders as $row) {
                                $po_status = $row['po_status'];
                                $po_items = $this->m_masters->getmasterdetails('bud_lbl_po_items', 'po_no', $row['po_no']);
                                $po_items_qty = array();
                                $total_po_qty = 0;
                                foreach ($po_items as $item) {
                                  $po_items_qty[] = $item['po_item_size'].'-'.$item['po_qty'];
                                  $total_po_qty += $item['po_qty'];
                                }
                                ?>
                                <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['po_no']; ?></td>
                                    <td><?=$row['cust_name']; ?></td>
                                    <td><?=$row['item_name']; ?></td>
                                    <td><?=$row['item_code']; ?></td>
                                    <td><?=implode("<br>", $po_items_qty); ?></td>
                                    <td></td>
                                    <td><?=$total_po_qty; ?></td>
                                    <td></td>
                                    <td>
                                      <?php
                                      if($po_status == 1)
                                      {
                                        ?>
                                        <a href="#" class="btn btn-primary btn-xs">P.S Pending</a>
                                        <a href="<?=base_url(); ?>production/print_ps_3/<?=$row['po_no']; ?>" class="btn btn-success btn-xs">Print</a>
                                        <?php 
                                      }
                                      else
                                      {
                                        ?>
                                        <a href="#" class="btn btn-success btn-xs">P.S. Issued</a>
                                        <a href="<?=base_url(); ?>production/print_ps_3/<?=$row['po_no']; ?>" class="btn btn-success btn-xs">Print</a>
                                        <?php
                                      }
                                      $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
                                      if($is_admin)
                                      {
                                        ?>
                                        <a href="<?=base_url(); ?>purchase/po_edit_3/<?=$row['po_no']; ?>" class="btn btn-danger btn-xs">Edit</a>
                                        <?php
                                      }
                                      ?>
                                    </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>
                            </tbody>
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

      $(".get_outerboxes").change(function(){
        window.location = "<?=base_url(); ?>purchase/po_received_3/"+$(this).val();
      });
      $(".selects_customers").change(function(){
          $("#customer_name").select2("val", $(this).val());
          $("#customer_id").select2("val", $(this).val());
      });     

  </script>

  </body>
</html>
