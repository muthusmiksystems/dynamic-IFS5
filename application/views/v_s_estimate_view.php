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
    @media print
    {
      @page { margin: 2.5mm }
      h2
      {
        margin: 0px;
      }
      .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
        padding: 3px;
      }
      .table thead > tr > th
      {
        font-weight: normal;
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
                                <h3>Estimate Details</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body" id="print_content">
                                <?php
                                $row = $estimate;
                                $estimate_id = $row['estimate_id'];
                                $customer_name = $row['customer_name'];
                                $customer_mobile = $row['customer_mobile'];
                                $estimate_date = $row['estimate_date'];
                                $remarks = $row['remarks'];
                                $estimate_items = $this->m_shop->getEstimateItems($estimate_id);
                                ?>
                                <table class="table table-bordered table-striped table-condensed invoice-table">
                                  <thead>
                                    <tr>
                                      <th colspan="7" class="text-center"><h4>Estimate</h4></th>
                                    </tr>
                                    <tr>
                                      <th colspan="4">To : <?=$customer_name; ?></th>
                                      <th colspan="3" class="text-right">Estimate No: <?=$estimate_id; ?></th>
                                    </tr>
                                    <tr>
                                      <th colspan="4">Mobile: <?=$customer_mobile; ?></th>
                                      <th colspan="3" class="text-right">Date : <?=$estimate_date; ?></th>
                                    </tr>
                                    <tr>
                                      <th>S.No</th>
                                      <th>Item Name / Code</th>
                                      <th>Shade Name / Code</th>
                                      <th class="text-right">Qty</th>
                                      <th>Uom</th>
                                      <th class="text-right">Rate</th>
                                      <th class="text-right">Amount</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $sno = 1;
                                    $total_amount = 0;
                                    $total_qty = 0;
                                    foreach ($estimate_items as $row) {
                                      $total_amount += $row['amount'];
                                      $total_qty += $row['qty'];
                                      ?>
                                      <tr>
                                        <td><?=$sno; ?></td>
                                        <td><?=$row['item_name']; ?> / <?=$row['item_id']; ?></td>
                                        <td><?=$row['shade_name']; ?> / <?=$row['shade_id']; ?></td>
                                        <td class="text-right"><?=$row['qty']; ?></td>
                                        <td><?=$row['uom']; ?></td>
                                        <td class="text-right"><?=$row['rate']; ?></td>
                                        <td class="text-right"><?=$row['amount']; ?></td>
                                      </tr>
                                      <?php
                                      $sno++;
                                    }
                                    ?>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <td colspan="3" class="text-right"><strong>Total</strong></td>
                                      <td class="text-right"><strong><?=number_format($total_qty, 2, '.', ''); ?></strong></td>
                                      <td></td>
                                      <td></td>
                                      <td class="text-right"><strong><?=number_format($total_amount, 2, '.', ''); ?></strong></td>
                                    </tr>
                                    <tr>
                                       <td colspan="7">
                                          <span style="text-transform:capitalize;">Rupees : <?=$this->m_shop->no_to_words($total_amount); ?> Only.</span>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="7">
                                          <span style="text-transform:capitalize;"><strong>Please Note : "Taxes like VAT or CST will be charged extra as applicable ."</strong></span>
                                       </td>
                                    </tr>
                                    <tr>
                                      <td colspan="4" class="text-left">
                                        <strong>Remarks :</strong> <?=$remarks; ?>
                                      </td>
                                      <td colspan="3" class="text-right">
                                        <br>
                                        <br>
                                        <br>
                                        Signature
                                      </td>
                                    </tr>
                                  </tfoot>
                                </table>
                            </div>

                            <div class="visible-print" id="print_content_2"></div>
                        </section>
                        <!-- End Form Section -->
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-primary" type="button" onclick="window.print()">Print</button>
                            </header>
                        </section>
                        <?php
                         function no_to_words($no)
                         {   
                            $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred &','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
                            if($no == 0)
                            return ' ';
                            else {
                               $novalue='';
                               $highno=$no;
                               $remainno=0;
                               $value=100;
                               $value1=1000;                              while($no>=100)    {
                                  if(($value <= $no) &&($no  < $value1))    {
                                     $novalue=$words["$value"];
                                     $highno = (int)($no/$value);
                                     $remainno = $no % $value;
                                     break;
                                  }
                                  $value= $value1;
                                  $value1 = $value * 100;
                               }                              if(array_key_exists("$highno",$words))
                               return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
                               else {
                                  $unit=$highno%10;
                                  $ten =(int)($highno/10)*10;                                      return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
                               }
                            }
                         }
                         ?>
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

      $("#print_content_2").html($("#print_content").html());
  });
  </script>

  </body>
</html>
