<?php include APPPATH . 'views/html/header.php'; ?>
<style type="text/css">
   @media print {
      @page {
         margin: 3mm;
      }
   }
</style>
<section id="main-content">
   <section class="wrapper">
      <div class="row">
         <div class="col-lg-12">
            <section class="panel">
               <header class="panel-heading">
                  Shop Cash Invoice
               </header>
               <div class="panel-body" id="transfer_dc">
                  <table class="table table-bordered table-striped table-condensed invoice-table">
                     <tbody>
                        <tr class="no-padding no-border">
                           <td width="5%"></td>
                           <td width="10%"></td>
                           <td width="15%"></td>
                           <td width="8%"></td>
                           <td width="5%"></td>
                           <td width="10%"></td>
                           <td width="10%"></td>
                           <td width="5%"></td>
                           <td width="7%"></td>
                           <td width="15%"></td>
                           <td width="10%"></td>
                           <td width="15%"></td>
                        </tr>
                        <tr class="first-row">
                           <td colspan="12" align="center" style="text-align:center;">
                              <h3 style="margin:0px;">Credit Invoice</h3>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="6">
                              <strong>FROM:</strong><br>
                              <strong style="font-size:14px;">DYNAMIC CREATIONS</strong><br>
                              18-A, ASHER NAGAR,
                              3rd STREET, GANDHI NAGAR.
                              TIRUPUR - 641603.<br>
                              TIN: 1455789956632<br>
                              CST: 4584541215745<br>
                           </td>
                           <td colspan="6">
                              <strong>TO:</strong><br>
                              <strong style="text-transform:uppercase;font-size:14px;">INDOFILA SHOP</strong><br>
                              18-A,ASHER NAGAR 3RD STREET,
                              GANDHI NAGAR PO, TIRUPUR.641603
                              <br>
                              Tin No : 33302303143
                           </td>
                        </tr>
                        <tr>
                           <td colspan="7">
                              <strong style="font-size:18px;">Invoice No</strong> 
                              <span><strong style="font-size:18px;">:</strong> <strong style="font-size:24px;">IFS-104</strong></span>
                           </td>
                           <td colspan="5" align="right"><strong>Date: 02-06-2015</strong></td>
                        </tr>
                        <tr>
                           <th>#</th>
                           <th>Box No</th>
                           <th>Item <br>Name/Code</th>
                           <th>Shade Name/Code</th>
                           <th>Shade No</th>
                           <th style="text-align:right;">Lot No</th>
                           <th style="text-align:right;"># of Cones</th>
                           <th style="text-align:right;">Gr. Weight</th>
                           <th style="text-align:right;">Net Weight</th>
                           <th style="text-align:right;">Lotwise Nt.Weight</th>
                           <th align="right">Rate</th>
                           <th align="right">Amount</th>
                        </tr>
                        <tr>
                           <td>1</td>
                           <td>G4</td>
                           <td>ak item/4</td>
                           <td>GREEN/13</td>
                           <td>5004</td>
                           <td align="right"></td>
                           <td align="right">2</td>
                           <td align="right">345</td>
                           <td align="right">319.527</td>
                           <td>319.527</td>
                           <td>
                              15.00 <input type="hidden" name="item_rate[]" value="15">
                           </td>
                           <td>4792.91</td>
                        </tr>
                        <tr>
                           <td>2</td>
                           <td>TH2</td>
                           <td>150 dn yarn/2</td>
                           <td>BLACK/8</td>
                           <td>BK 99</td>
                           <td align="right">9</td>
                           <td align="right">10</td>
                           <td align="right">10</td>
                           <td align="right">9.783</td>
                           <td>9.783</td>
                           <td>
                              10.00 <input type="hidden" name="item_rate[]" value="10">
                           </td>
                           <td>100.00</td>
                        </tr>
                        <tr>
                           <td colspan="4" align="center"><strong>Total   :</strong></td>
                           <td><strong>2</strong></td>
                           <td>Boxes</td>
                           <td></td>
                           <td align="right"><strong>355</strong></td>
                           <td align="right"><strong>329.31</strong></td>
                           <td></td>
                           <td></td>
                           <td align="right"><strong>4891.00</strong></td>
                        </tr>
                        <tr>
                           <!-- <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td> -->
                           <td colspan="7">
                              <p>
                                 <strong>Goods Sent through PROFESSIONAL COURIER as per LRNO:1005864659 - 23/05/2015</strong>
                              </p>
                           </td>
                           <td align="right"></td>
                           <td colspan="3"><strong>VAT @ 5.00 % </strong></td>
                           <td colspan="1" align="right"><strong>244.55</strong></td>
                        </tr>
                        <tr>
                           <td colspan="8" rowspan="2">
                              <strong><u>Spl. Instruction</u></strong>: <span class="hidden-print">Total outstanding = Rs.1,00,000.50(including this Invoice).</span>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="3"><strong>Transport Charge</strong></td>
                           <td colspan="1" align="right"><strong>4891.00</strong></td>
                        </tr>

                        <tr>
                           <td colspan="8" rowspan="2">
                              <strong style="text-transform:capitalize;">Rupees : Ten thousand twenty seven Only.</strong>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="3"><strong>Net Amount</strong></td>
                           <td colspan="1" align="right"><strong>10027.00</strong></td>
                        </tr>

                        <tr>
                           <td colspan="12">
                              <strong>OUR DC NO: DC-15-16/9</strong>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="12">
                              <div class="col-lg-12">
                                 <div class="print-div col-lg-3">
                                    <strong>Received By</strong>
                                    <br>
                                    <br>
                                 </div>
                                 <div class="print-div col-lg-3" style="border-right:none;">
                                    <strong>Prepared By</strong>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    admin
                                 </div>
                                 <div class="print-div col-lg-3" style="border-right:none;">
                                    <strong>Checked By</strong>
                                    <br>
                                    <br>
                                 </div>
                                 <div class="print-div right-align col-lg-3">
                                    <strong>For DYNAMIC CREATIONS.</strong>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    Auth.Signatory
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
<?php include APPPATH . 'views/html/footer.php'; ?>
<script type="text/javascript">
   $("#transfer_dc").find('.print').on('click', function() {
      $.print("#transfer_dc");
      return false;
   });
</script>
</body>

</html>