<?php
$r = $this->user->get_table_data('tbl_sales', null, 'id', $this->uri->segment(3), null);
$sale = $this->user->get_table_data('tbl_sales_list', null, 'purchase_id', $r[0]['id'], null);
$concern = $this->user->get_table_data('tbl_branch', null, 'id', $r[0]['branch'], null);
$cust = $this->user->get_table_data('tbl_vendor', null, 'id', $r[0]['cust_id'], null);
$add = array();
?>
<title> Print Invoive </title>
<!-- Bootstrap -->
<link href="<?php echo base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
<!-- Font Awesome -->
<link href="<?php echo base_url('assets/vendors/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
<style>
  .table {
    background-color: #fff !important;
    margin-bottom: 1px;
  }
</style>
<style>
  .table-bordered>tbody>tr>td,
  .table-bordered>tbody>tr>th,
  .table-bordered>tfoot>tr>td,
  .table-bordered>tfoot>tr>th,
  .table-bordered>thead>tr>td,
  .table-bordered>thead>tr>th {
    border: thin solid black;

  }

  .table-bordered {
    margin-bottom: 2px;
  }

  .table>thead>tr>th,
  .table>tbody>tr>th,
  .table>tfoot>tr>th,
  .table>thead>tr>td,
  .table>tbody>tr>td,
  .table>tfoot>tr>td {
    border-top: thin solid black !important;
  }

  html,
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 14px;
  }

  img {
    padding-top: 5%;
    vertical-align: middle;
  }

  body {
    padding: 1em;
  }
</style>
<style>
  p {
    margin-bottom: 0px;
  }

  h4,
  h3 {
    font-size: 15px;
    font-weight: bolder;
    line-height: 0.5em;
  }
</style>
<style>


</style>

<?php
//error_reporting(E_WARNING);
function no_to_words($no)
{
  $words = array('0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fouteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty', '30' => 'thirty', '40' => 'fourty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninty', '100' => 'hundred &', '1000' => 'thousand', '100000' => 'lakh', '10000000' => 'crore');
  if ($no == 0)
    return ' ';
  else {
    $novalue = '';
    $highno = $no;
    $remainno = 0;
    $value = 100;
    $value1 = 1000;
    while ($no >= 100) {
      if (($value <= $no) && ($no  < $value1)) {
        $novalue = $words["$value"];
        $highno = (int) ($no / $value);
        $remainno = $no % $value;
        break;
      }
      $value = $value1;
      $value1 = $value * 100;
    }
    if (array_key_exists("$highno", $words))
      return $words["$highno"] . " " . $novalue . " " . no_to_words($remainno);
    else {
      $unit = $highno % 10;
      $ten = (int) ($highno / 10) * 10;
      return $words["$ten"] . " " . $words["$unit"] . " " . $novalue . " " . no_to_words($remainno);
    }
  }
}
?>
<!-- page content -->

<?php $x = 1; ?>
<div class="x_content" id="content">
  <table class="table-bordered" width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <h3>QUOTATION</h3>
      </td>
    </tr>
  </table>
  <table class="table-bordered" width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td width="60%" valign="top">
        <table width="100%" cellpadding="10" cellspacing="10px" style="line-height:0.5em;font-size:14px">
          <tr style="border-bottom:solid thin #000;">
            <td width="60%">

              <h4><?= $concern[0]['bname']; ?></h4>
              <p style="line-height:1em"><?= $concern[0]['address']; ?><br>
                PHN : <?= $concern[0]['phone']; ?><br>
                GST : <?= $concern[0]['gst']; ?></p>
            </td>
            <td width="40%" valign="top">

            </td>
          </tr>
          <tr style="border-bottom:solid thin #000;">

          </tr>
          <tr style="border-bottom:none;">
            <td colspan="2">

              <h3> BILLED TO </h3>
              <h4><?= $cust[0]['cname']; ?></h4>
              <p style="line-height:1em"><?= nl2br($cust[0]['caddress']); ?><br>
                PHN : <?= $cust[0]['phn_no']; ?><br>
                GST : <?= $cust[0]['gst_no']; ?><br>
                STATE CODE : <?= substr($cust[0]['gst_no'], 0, 2); ?></p>

            </td>
          </tr>

        </table>
      </td>
      <td wdith="40%" valign="top">
        <br>
        Quote No.
        <b> <?= $r[0]['bill_no']; ?> </b><br><br>
        <hr>
        Dated.


        <b> <?= date("d-M-Y", strtotime($r[0]['bill_date'])) ?> </b>


      </td>
    </tr>

  </table>




  <table class="table-bordered" width="100%" style="line-height:1.5em;font-size:14px">
    <thead>
      <tr>
        <td colspan="8" style="color:orange;font-weight:bolder;font-size:14px"> Product Details </td>
      </tr>
      <tr>
        <th>#</th>
        <th style="text-align: center;">Description of Goods</th>
        <th style="text-align: center;">HSN CODE</th>
        <th style="text-align: center;">Qty</th>
        <th style="text-align: center;">Rate</th>
        <th style="text-align: center;">Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $a = 1;
      $l = 1;
      $tamt = 0;
      $tqty = 0;
      $tpcs = 0;
      $x = 30;
      //$tax = 0;


      foreach ($sale as $row) {
        $tamt += $row['qty'] * $row['rate'];
        $tqty += $row['qty'];
        $hsn[] = $row['hsn'];
        $amt[] = $row['qty'] * $row['rate'];
        $h = $this->user->get_table_data('tbl_hsn', null, 'hsn', $row['hsn'], null);
        if (count($h) > 0) {
          $h = $h[0]['tax'];
        } else {
          $h = 0;
        }
        $tax[] = $h;
      ?>
        <tr>
          <td><?php echo $a; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td align="center"><?php echo $row['hsn']; ?></td>
          <td align="center"><?php echo $row['qty']; ?></td>
          <td align="right"><?php echo number_format($row['rate'], 2); ?></td>
          <td align="right"><?php echo number_format(($row['qty'] * $row['rate']), 2); ?></td>
        </tr>
        <?php

        if (($l % $x) == 0) {
          $x = 30;
          $l = 1;
        ?>
          <tr>
            <td colspan="8" align="center"> TO be Continued....</td>

          </tr>

          <tr>
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="8">&nbsp;</td>
          </tr>
      <?php
        }
        $l++;
        $a++;
      }






      $i = 0;
      $total = array();
      $tax_amt = array();
      while (count($hsn) > $i) {
        $t = ($tax[$i] / 100);
        if (array_key_exists($hsn[$i], $total)) {
          $tax_amt[$hsn[$i]] += $amt[$i] * $t;
          $total[$hsn[$i]] += $amt[$i];
        } else {
          $tax_amt[$hsn[$i]] = $amt[$i] * $t;
          $total[$hsn[$i]] = $amt[$i];
        }
        $i++;
      }

      $total_amount = $tamt + array_sum($tax_amt);
      $ta_amt = array_sum($tax_amt);

      ?>
      <tr>
        <th></th>
        <th style="text-align: right">Total </th>
        <td></td>
        <th style="color:red;text-align: center"><?php echo $tqty; ?></th>
        <th></th>

        <th style="color:red;text-align: right"><?php echo number_format(($tamt), 2); ?></th>
      </tr>
      <?php if (substr($cust[0]['gst_no'], 0, 2) == 33) { ?>
        <tr>
          <th></th>
          <th style="text-align: right">CGST </th>
          <td></td>
          <th style="color:red"></th>
          <th></th>

          <th style="color:red;text-align: right"><?php echo number_format(($ta_amt / 2), 2); ?></th>
        </tr>
        <tr>
          <th></th>
          <th style="text-align: right">SGST </th>
          <td></td>
          <th style="color:red"></th>
          <th></th>

          <th style="color:red;text-align: right"><?php echo number_format(($ta_amt / 2), 2); ?></th>
        </tr>

      <?php } else { ?>
        <tr>
          <th></th>
          <th style="text-align: right">IGST </th>
          <td></td>
          <th style="color:red"></th>
          <th></th>

          <th style="color:red;text-align: right"><?php echo number_format(($ta_amt), 2); ?></th>
        </tr>
      <?php } ?>

      <tr>
        <th></th>
        <th style="text-align: right;">Grand Total </th>
        <td></td>
        <th style="color:red;text-align: center"><?php echo $tqty; ?></th>
        <th></th>



        <th style="color:red;text-align: right">
          <?php
          echo number_format(round(($total_amount)), 2); ?>

        </th>
      </tr>



    </tbody>
  </table>
  <table class="table-bordered" width="100%" style="line-height:1.5em;font-size:14px">
    <tr>
      <td><b> Amount in Words : </b> <i class="fa fa-inr"></i> <?= strtoupper(no_to_words(round($total_amount))); ?> RUPEES ONLY /-</td>
    </tr>
  </table>
  <?php if (substr($cust[0]['gst_no'], 0, 2) == 33) { ?>
    <table class="table-bordered" width="100%" style="line-height:1.5em;font-size:14px">
      <tr>
        <td colspan="7" style="color:orange;font-weight:bolder"> HSN Details </td>
      </tr>
      <tr>
        <th style="text-align: center;">HSN/ASC</th>
        <th style="text-align: center;">Taxable Value</th>
        <th style="text-align: center;">CGST</th>
        <th style="text-align: center;">Amount</th>
        <th style="text-align: center;">SGST</th>
        <th style="text-align: center;">Amount</th>
        <th style="text-align: center;">Total</th>

      </tr>
      <?php
      var_dump($hsn);

      $hsn = array_unique($hsn);
      $data = array_unique($hsn);
      var_dump($data);
      $i = 0;
      while (count($total) > $i) {
        echo $i;
      ?>
        <tr>
          <th>
            <?php echo $hsn[$i]; ?>
          </th>
          <td style="text-align: right"><?php echo number_format($total[$hsn[$i]], 2); ?></td>
          <td align="center"><?= ($tax[$i] / 2) . '%'; ?></td>
          <td align="right"><?php echo number_format(($tax_amt[$hsn[$i]] / 2), 2); ?></td>
          <td align="center"><?= ($tax[$i] / 2) . '%'; ?></td>
          <td align="right"><?php echo number_format(($tax_amt[$hsn[$i]] / 2), 2); ?></td>
          <td align="right"><?php echo number_format($tax_amt[$hsn[$i]], 2); ?></td>

        </tr>
      <?php
        $i++;
      }
      ?>
      <tr>
        <th>Total</th>
        <th style="text-align: right"><?= number_format(array_sum($total), 2); ?></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th style="text-align: right"><?= number_format(array_sum($tax_amt), 2); ?></th>

      </tr>

    </table>
  <?php } else { ?>
    <table class="table-bordered" width="100%" style="line-height:1.5em;font-size:14px">
      <tr>
        <td colspan="4" style="color:orange;font-weight:bolder"> HSN Details </td>
      </tr>
      <tr>
        <th style="text-align: center;">HSN/ASC</th>
        <th style="text-align: center;">Taxable Value</th>
        <th style="text-align: center;">IGST</th>
        <th style="text-align: center;">Amount</th>

      </tr>
      <?php
      $hsn = array_unique($hsn);

      $i = 0;
      while (count($total) > $i) {
      ?>
        <tr>
          <th>
            <?php echo $hsn[$i]; ?>
          </th>
          <td style="text-align: right"><?php echo $total[$hsn[$i]]; ?></td>
          <td><?= $tax[$i] . '%'; ?></td>
          <td style="text-align: right"><?php echo number_format($tax_amt[$hsn[$i]], 2); ?></td>

        </tr>
      <?php
        $i++;
      }
      ?>
      <tr>
        <th>Total</th>
        <th style="text-align: right"><?= number_format(array_sum($total), 2); ?></th>
        <th></th>
        <th style="text-align: right"><?= number_format(array_sum($tax_amt), 2); ?></th>

      </tr>

    </table>
  <?php } ?>

  <table class="table-bordered" width="100%" style="line-height:1.5em;font-size:14px">
    <tr>
      <td width="50%" valign="top">


        <u><b>TERMS </b></u><br>
        <p align="justify">PAYMENT WITHIN 2 DAYS.</p>

        <u><b>IMPORATANT </b></u>
        <p align="justify">ALL CLAIMS OF DEGFECTIVE MERCHANDISE MUST BE MADE WITH IN 2 DAYS OF INVOICE. ANY CLAIM AFTER 7 DAYS WILL NOT BE ACCEPTED</p>

        <u><b>Declaration </b></u>
        <p> Subject to Tirupur Jurisdiction.</p>


      </td>

      <td width="25%" align="center" valign="bottom">

        <p>For <?= $concern[0]['bname']; ?> </p>
        <br><br><br> Authorised Signatory
      </td>
    </tr>
  </table>

</div>
<div id="editor"></div>

<div>
  <br>
  <a href="<?= base_url('quote'); ?>" class="btn btn-info" id="anchor"> <i class="fa fa-arrow-left"></i> &nbsp; Back </a> <button class="btn btn-default pull-right" id="printpagebutton" onclick='printpage()'><i class="fa fa-print"></i> Print</button>

</div>

<!-- /page content -->


<script type="text/javascript">
  function printpage() {
    //Get the print button and put it into a variable
    var printButton = document.getElementById("printpagebutton");
    //Set the print button visibility to 'hidden' 
    printButton.style.visibility = 'hidden';

    var anchor = document.getElementById("anchor");
    //Set the print button visibility to 'hidden' 
    anchor.style.visibility = 'hidden';

    //Print the page content
    window.print()
    //Set the print button to 'visible' again 
    //[Delete this line if you want it to stay hidden after printing]
    printButton.style.visibility = 'visible';
    anchor.style.visibility = 'visible';

  }
</script>
<!-- jQuery -->
<script src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js'); ?>"></script>
<!-- MAke PDF --!>
    <script src="<?php echo base_url('assets/make_pdf/jspdf.debug.js'); ?>"></script>

<script>
var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {
    doc.fromHTML($('#content').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('sample-file.pdf');
});
</script>
<script>
function PrintElem()
{
    var mywindow = window.open('', '', 'height=800,width=1100');

    mywindow.document.write('<html><head><title> Invoice </title>');
    mywindow.document.write('');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('content').innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>