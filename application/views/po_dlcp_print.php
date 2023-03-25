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
    


  
    <style type="text/css">
      @media print{
        @page{
          margin: 3mm;
        }
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
                                <h3>Dyed Loose Cone Delivery</h3>
                            </header> 
                            <div class="panel-body">
                              <table class="table table-bordered table-striped table-condensed invoice-table">
                                <tr>
                                  <td colspan="4" align="center"><h3>DLC Delivery</h3></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left">DLCD No: <strong><?=$id; ?></strong></td>
                                  <td colspan="2" align="right">Date: <strong><?=date("d-m-Y H:i:s"); ?></strong></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left">From: <strong><?=$from_dept_name; ?></strong></td>
                                  <td colspan="2" align="right">To: <strong><?=$to_dept_name; ?></strong></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left">From Staf: <strong><?=$from_user_name; ?></strong></td>
                                  <td colspan="2" align="right">To Staff: <strong><?=$to_user_name; ?></strong></td>
                                </tr>
                                <tr>
                                  <td colspan="4">
                                    <table class="table table-bordered table-striped table-condensed invoice-table">
                                      <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>PO No</th>
                                            <th>Customer</th>
                                            <th>Item Name / Code</th>
                                            <th>Shade Name / Code</th>
                                            <th>Shade No</th>
                                            <th>Lot No</th>
                                            <th class="text-right">Hold # Springs</th>
                                            <th class="text-right">Hold Nt.Weight</th>
                                            <th class="text-right"># Of Springs</th>
                                            <th class="text-right">Net Weight</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        $total_springs_hold = 0;
                                        $total_weight_hold = 0;
                                        $total_springs = 0;
                                        $total_net_weight = 0;
                                        $sno = 1;
                                        $items = $this->m_purchase->get_dlc_packing_item_reg($id);
                                        /*echo "<pre>";
                                        print_r($items);
                                        echo "</pre>";*/
                                        foreach ($items as $row) {
                                          $total_springs_hold += $row->no_springs_hold;
                                          $total_weight_hold += $row->net_weight_hold;
                                          $total_springs += $row->no_springs;
                                          $total_net_weight += $row->net_weight;
                                          ?>
                                          <tr>
                                            <td><?=$sno; ?></td>
                                            <td><?=$row->po_no; ?></td>
                                            <td><?=$row->cust_name; ?></td>
                                            <td><?=$row->item_name; ?> / <?=$row->item_id; ?></td>
                                            <td><?=$row->shade_name; ?>/<?=$row->shade_id; ?></td>
                                            <td><?=$row->shade_code; ?></td>
                                            <td><?=$row->lot_no; ?></td>
                                            <td class="text-right"><?=$row->no_springs_hold; ?></td>
                                            <td class="text-right"><?=$row->net_weight_hold; ?></td>
                                            <td class="text-right"><?=$row->no_springs; ?></td>
                                            <td class="text-right"><?=$row->net_weight; ?></td>
                                          </tr>
                                          <?php
                                          $sno++;
                                        }
                                        ?>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <td colspan="7">Total</td>
                                          <td class="text-right"><strong><?=$total_springs_hold; ?></strong></td>
                                          <td class="text-right"><strong><?=number_format($total_weight_hold, 3, '.', ''); ?></strong></td>
                                          <td class="text-right"><strong><?=$total_springs; ?></strong></td>
                                          <td class="text-right"><strong><?=number_format($total_net_weight, 3, '.', ''); ?></strong></td>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="4">
                                    <strong>Remarks:</strong><br>
                                    <?=$remarks?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="4">
                                    <strong>Goods sent trough:</strong><br>
                                    <?=$sent_through; ?> <?=$vehicle_no; ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <br><br>
                                    Received by
                                  </td>
                                  <td>
                                    <br>
                                    <?=$this->session->userdata('display_name'); ?>
                                    <br>
                                    Prepared By
                                  </td>
                                  <td>
                                    <br><br>
                                    Auth. Sign
                                  </td>
                                </tr>
                              </table>
                            </div>
                            <button class="btn btn-default hidden-print" type="button" onclick="window.print()">Print</button>
                        </section>
                    </div>
                </div>				
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

  </script>

  </body>
</html>
