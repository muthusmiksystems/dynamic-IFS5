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
    foreach ($css_print as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet" media="print">
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
                    <div class="col-lg-12">                                    <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            POY Gain Report
                        </header>
                        <h2 class="print-only">POY Gain Report</h2>
                        <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                          <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Item Name/Code</th>
                                <th>POY Inw.No</th>
                                <th>POY Lot.No</th>
                                <th>POY Opening Stock</th>
                                <th>Gray Delivery</th>
                                <th>Soft Delivery</th>
                                <th>Wastage</th>
                                <th>System Stock</th>
                                <th>Physical Stock</th>
                                <th>Gain/Loss</th>
                                <th>Wastage %</th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            $gr_poy_open_stock = 0;
                            $gr_gray_delivery = 0;
                            $gr_soft_delivery = 0;
                            $gr_wastage = 0;
                            $gr_system_stock = 0;
                            $gr_physical_stock = 0;
                            /*echo "<pre>";
                            print_r($poy_lots);
                            echo "</pre>";*/
                            foreach ($poy_lots as $row) {
                              $from_date = "0000:00:00";
                              $system_stock = 0.000;
                              $opening_stock = 0.000;
                              $closing_stock = 0.000;
                              $gray_delivery = 0.000;
                              $soft_delivery = 0.000;
                              $tot_lot_wastage = 0.000;
                              $tot_gray_packing = 0.000;
                              $tot_soft_packing = 0.000;
                              $tot_packing = 0.000;
                              $tot_sales_qty = 0.000;
                              $poy_lot_id = $row['poy_lot_id'];
                              $stock = $this->m_reports->get_poy_opening_stock($poy_lot_id);
                              if($stock)
                              {
                                $from_date = $stock->updated_date;                                                        $opening_stock = $stock->closing_stock;
                              }
                              $to_date = date("Y-m-d");

                              $inward_qty = $this->m_reports->get_poy_inw_qty($poy_lot_id, $from_date, $to_date);
                              $opening_stock += $inward_qty->tot_inw_qty;

                              $boxes = $this->m_delivery->soft_delivery_item_list($from_date, $to_date, $poy_lot_id);                                                    /*echo "<pre>";
                              print_r($boxes);
                              echo "</pre>";*/
                              $items_array = array();
                              foreach ($boxes as $box) {
                                $box_prefix = $box->box_prefix;
                                $items_array[] = $box->item_name.' / ' .$box->item_id;
                                if($box_prefix == 'G')
                                {
                                  $gray_delivery += $box->net_weight;
                                }
                                if($box_prefix == 'S')
                                {
                                  $soft_delivery += $box->net_weight;
                                }

                                $tot_lot_wastage += $box->lot_wastage;
                              }

                              $gray_packing = $this->m_reports->get_total_yarn_pack_qty($poy_lot_id, $from_date, $to_date, 'G');
                              $tot_gray_packing = $gray_packing->total_pack_qty;
                                                    $soft_packing = $this->m_reports->get_total_yarn_pack_qty($poy_lot_id, $from_date, $to_date, 'S');
                              $tot_soft_packing = $soft_packing->total_pack_qty;

                              $tot_packing = $tot_gray_packing + $tot_soft_packing;

                              $poy_sales = $this->m_reports->get_poy_sales_qty($poy_lot_id, $from_date, $to_date);
                              $tot_sales_qty = $poy_sales->tot_sales_qty;

                              $system_stock = ($opening_stock + $gray_delivery + $soft_delivery) - ($tot_gray_packing + $tot_soft_packing + $tot_sales_qty + $tot_lot_wastage);
                                                    $result_stock = $this->m_reports->get_poy_closing_stock($poy_lot_id);
                              if($result_stock)
                              {                                                    $closing_stock = $result_stock->closing_stock;
                              }

                              $gr_poy_open_stock += $opening_stock;
                              $gr_gray_delivery += $gray_delivery;
                              $gr_soft_delivery += $soft_delivery;
                              $gr_wastage += $tot_lot_wastage;
                              $gr_system_stock += $system_stock;
                              $gr_physical_stock += $closing_stock;
                              /*echo "<pre>";
                              print_r($closing_stock);
                              echo "</pre>";*/
                              ?>
                              <tr>
                                <td><?=$sno; ?></td>
                                <td><?php echo implode(",", $items_array); ?></td>
                                <td></td>
                                <td><?=$row['poy_lot_no']; ?></td>
                                <td><?=number_format($opening_stock, 3, '.', ''); ?></td>
                                <td><?=number_format($gray_delivery, 3, '.', ''); ?></td>
                                <td><?=number_format($soft_delivery, 3, '.', ''); ?></td>
                                <td><?=number_format($tot_lot_wastage, 3, '.', ''); ?></td>
                                <td><?=number_format($system_stock, 3, '.', ''); ?></td>
                                <td><?=number_format($closing_stock, 3, '.', ''); ?></td>
                                <td><?=$closing_stock - $system_stock; ?></td>
                                <td></td>
                              </tr>
                              <?php
                              $sno++;
                            }
                            ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="4"><strong>Total</strong></td>
                              <td><?=number_format($gr_poy_open_stock, 3, '.', ''); ?></td>
                              <td><?=number_format($gr_gray_delivery, 3, '.', ''); ?></td>
                              <td><?=number_format($gr_soft_delivery, 3, '.', ''); ?></td>
                              <td><?=number_format($gr_wastage, 3, '.', ''); ?></td>
                              <td><?=number_format($gr_system_stock, 3, '.', ''); ?></td>
                              <td><?=number_format($gr_physical_stock, 3, '.', ''); ?></td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tfoot>
                        </table>
                        <br/>
                        <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
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
