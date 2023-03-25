<?php include APPPATH.'views/html/header.php'; ?>
    <style type="text/css">
        @media print{
            @page{
                margin: 3mm;
            }
            .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td
            {
                border: 1px solid #403d3d !important;
            }
      }
    </style>
    <?php
     $prepared_by = $this->session->userdata('user_id');
    ?>
	<section id="main-content">
		<section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Job work Invoice
                        </header>
                                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered invoice-table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center" align="center">
                                            <h3 style="margin:0px;">Jobwork Invoice</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" valign="top" style="width:50%;vertical-align:top;">
                                                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->concern_name; ?></strong><br>
                                            <?php echo $invoice->concern_address; ?><br>
                                            GST: <?php echo $invoice->concern_gst; ?><!--ER-07-18#-11-->
                                        </th>
                                        <th colspan="3" valign="top" style="width:50%;vertical-align:top;">
                                            <strong>To:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;"><?php echo $invoice->cust_name; ?></strong><br>
                                            <?php echo $invoice->cust_address; ?>
                                            <?php echo $invoice->cust_city; ?><br>
                                            GST: <?php echo $invoice->cust_gst; ?><!--ER-07-18#-11-->
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">
                                            <!-- CASH INV NO: <span style="font-size:18px;">SH/CS-<?php echo $invoice->invoice_id; ?></span> -->
                                            INVOICE NO: <span style="font-size:18px;"><?php echo $invoice->jwi_invoice_no; ?></span>
                                        </th>
                                        <th colspan="3" class="text-right" align="right">
                                            <?php echo date("d-m-Y", strtotime($invoice->jwi_created_on)); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Particular</th>
                                        <th>Note</th>
                                        <th>Qty</th>
                                        <th>Rate</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <?php
                                $sno = 1;
                                $total_amount = 0;
                                $items = $this->jwi_model->get_jobwork_inv_items($jwi_id);
                                ?>                                                        <tbody>
                                    <?php if(sizeof($items) > 0): ?>
                                        <?php foreach($items as $row): ?>
                                            <?php
                                            $total_amount += $row->jwi_detail_amount;
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo $row->jwi_detail_particular; ?></td>
                                                <td><?php echo $row->jwi_detail_note; ?></td>
                                                <td><?php echo $row->jwi_detail_quantity; ?></td>
                                                <td><?php echo $row->jwi_detail_rate; ?></td>
                                                <td align="right"><?php echo $row->jwi_detail_amount; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <tr>
                                        <td colspan="5" align="right"><strong>Total</strong></td>
                                        <td colspan="5" align="right"><strong><?php echo $invoice->sub_total; ?></strong></td>
                                    </tr>
                                    <?php
                                    $tax_amounts = explode(",", $invoice->tax_amounts);
                                    $tax_names = explode(",", $invoice->tax_names);
                                    $tax_values = explode(",", $invoice->tax_values);
                                    if(count($tax_amounts) > 0)
                                    {
                                        foreach ($tax_amounts as $key => $value) {
                                           if($value > 0)
                                           {
                                           $tax_description = $this->m_masters->getTaxDesc($tax_names[$key], $tax_values[$key]);
                                           ?>
                                           <tr>
                                              <td align="right" colspan="5"><strong><?=$tax_names[$key]; ?> @ <?=$tax_values[$key]; ?> % </strong></td>
                                              <td align="right"><strong><?=number_format($value, 2, '.', ''); ?></strong></td>
                                           </tr>
                                           <?php
                                           }
                                        }                                                                    }
                                    ?>
                                    <tr>
                                        <td align="right" colspan="5"><strong>Grand Total</strong></td>
                                        <td align="right"><strong><?php echo $invoice->grand_total; ?></strong></td>
                                    </tr>
                                     <?php
                                    if($invoice->grand_total >= 0)
                                    {
                                    ?>
                                    <tr>
                                       <td colspan="12">
                                          <strong style="text-transform:capitalize;">Rupees : <?=no_to_words($invoice->grand_total); ?> Only.</strong>
                                       </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                     <tr>
                                       <td colspan="12">
                                          <div class="col-lg-12">
                                             <div class="print-div col-lg-3">
                                                <strong>Received By</strong>
                                                <br/>
                                                <br/>
                                             </div>
                                             <div class="print-div col-lg-3" style="border-right:none;">
                                                <strong> Prepared By</strong>
                                                <br/>
                                                <br/>
                                                <br/>
                                                <br/>
                                           	 <?=$this->m_masters->getmasterIDvalue('bud_users', 'ID', $invoice->added_user, 'user_login'); ?>
                                             </div>
                                             <div class="print-div col-lg-3" style="border-right:none;">
                                                <strong>Checked By</strong>
                                                <br/>
                                                <br/>
                                             </div>
                                             <div class="print-div right-align col-lg-3">
                                                <strong>For  <?php echo $invoice->concern_name; ?>
                                               </strong>
                                                <br/>
                                                <br/>
                                                <br/>
                                                <br/>
                                                Auth.Signatury
                                             </div>
                                          </div>
                                       </td>
                                    </tr>   
                                </tbody>
                                             </table>
                            <button class="btn btn-primary hidden-print" onclick="window.print()" type="button">Print</button>
                        </div>
                    </section>
                </div>
            </div>
		</section>
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
                     $value1=1000;                    while($no>=100)    {
                        if(($value <= $no) &&($no  < $value1))    {
                           $novalue=$words["$value"];
                           $highno = (int)($no/$value);
                           $remainno = $no % $value;
                           break;
                        }
                        $value= $value1;
                        $value1 = $value * 100;
                     }                    if(array_key_exists("$highno",$words))
                     return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
                     else {
                        $unit=$highno%10;
                        $ten =(int)($highno/10)*10;                            return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
                     }
                  }
               }
          ?>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });
</script>
</body>
</html>