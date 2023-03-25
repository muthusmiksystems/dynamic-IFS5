<?php include APPPATH.'views/html/header.php'; ?>
    <style type="text/css">
        @media print{
          @page{
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
                            <table class="table table-bordered invoice-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="11" class="text-center" align="center">
                                            <h3 style="margin:0px;">Cash Invoice</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" valign="top" style="vertical-align:top;">
                                            <strong>From:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;">Indofilla</strong><br>
                                            TIN: CST:
                                        </th>
                                        <th colspan="5" valign="top" style="vertical-align:top;">
                                            <strong>To:&emsp;</strong>
                                            <strong style="text-transform:uppercase;font-size:14px;">Shive Tapes</strong><br>
                                            TIN: CST:
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6">
                                            CASH INV NO: SHCI/<span style="font-size:18px;">001</span>
                                        </th>
                                        <th colspan="5" class="text-right" align="right">
                                            <?php echo date("d-m-Y g:i a"); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th># Boxes</th>
                                        <th>Item Name/Code</th>
                                        <th>Shade Name/No</th>
                                        <th># Lots</th>
                                        <th>#Cones</th>
                                        <th>Gr.Wt</th>
                                        <th>Nt.Wt</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>150 dn yarn/2</td>
                                        <td>Blood Red/1010</td>
                                        <td>1</td>
                                        <td>15</td>
                                        <td>51.000</td>
                                        <td>50.000</td>
                                        <td>12</td>
                                        <td>1200</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>1</td>
                                        <td>150 dn yarn/2</td>
                                        <td>Blue/1014</td>
                                        <td>1</td>
                                        <td>15</td>
                                        <td>51.000</td>
                                        <td>50.000</td>
                                        <td>12</td>
                                        <td>1200</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>3</td>
                                        <td>150 dn yarn/2</td>
                                        <td>Green/1011</td>
                                        <td>2</td>
                                        <td>15</td>
                                        <td>51.000</td>
                                        <td>50.000</td>
                                        <td>12</td>
                                        <td>1200</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><strong>Grand Total</strong></td>
                                        <td><strong>6 Boxes</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <strong>Delivery Address:</strong>
                                        </td>
                                        <td align="right" colspan="3">
                                            <strong>Discount:</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <strong>Transport Mode:</strong>
                                        </td>
                                        <td align="right" colspan="3">
                                            <strong>VAT:</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <strong>Rupees:</strong>
                                        </td>
                                        <td align="right" colspan="3">
                                            <strong>Net Amount (Round off):</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="11">
                                            <div class="col-lg-12">
                                                <div class="print-div col-lg-3">
                                                    <strong>Received By</strong>
                                                    <br/>
                                                    <br/>
                                                    Party Name/Mobile No
                                                </div>
                                                <div class="print-div col-lg-3" style="border-right:none;">
                                                    <strong>Prepared By</strong>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <?php echo $this->session->userdata('display_name'); ?>
                                                </div>
                                                <div class="print-div col-lg-3" style="border-right:none;">
                                                    <strong>Checked By</strong>
                                                    <br/>
                                                    <br/>
                                                </div>
                                                <div class="print-div right-align col-lg-3">
                                                    <strong>For Concern Name.</strong>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    Auth.Signatury
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button class="btn btn-primary hidden-print" onclick="window.print()" type="button">Print</button>
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });
</script>
</body>
</html>