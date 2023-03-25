<?php include APPPATH.'views/html/header.php'; ?>
<style type="text/css">
    @media print{
        @page{
            margin: 3mm;
        }
        .table-bordered>tbody>tr>td.no-border-right
        {
            border-right: 0px !important;
        }
        .table-bordered>tbody>tr>td.no-border-left
        {
            border-left: 0px !important;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td
        {
            border: 1px solid #000 !important;
        }
    }
</style>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Shop Cheque Receipt
                    </header>
                    <div class="panel-body" id="transfer_dc">
                        <table class="table voucher-table table-bordered invoice-table">
                            <thead>
                                <tr style="height: 0px;" class="no-padding no-border">
                                    <th style="padding: 0px;border-width: 0px;" width="37%"></th>
                                    <th style="padding: 0px;border-width: 0px;" width="18%"></th>
                                    <th style="padding: 0px;border-width: 0px;" width="20%"></th>
                                    <th style="padding: 0px;border-width: 0px;" width="25%"></th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-left" style="vertical-align: top;">
                                        <span class="concern-name"><?php echo $receipt->concern_name; ?></span>
                                    </th>
                                    <th colspan="2" class="text-right">
                                        <span class="voucher-name">Credit Voucher</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="vertical-align: top">
                                        <span class="concern-address"><?php echo $receipt->cust_address; ?> <?php echo $receipt->cust_city; ?> <?php echo $receipt->cust_pincode; ?>.</span>
                                    </th>
                                    <th colspan="2" class="text-center">
                                        <span class="voucher-amount">Rs. <?php echo round($receipt->amount); ?></span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="left" colspan="2">
                                        No: <span class="voucher-no">SHOP Credit Note-<?php echo $receipt->receipt_id; ?></span>
                                    </td>
                                    <td align="right" colspan="2">Date: <?php echo date("d-m-Y g:i A", strtotime($receipt->receipt_date)); ?></td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        We are crediting your account name:
                                    </td>
                                    <td colspan="3"><?php echo $receipt->cust_name; ?></td>
                                </tr>
                                    <td align="right">For Amount:</td>
                                    <td colspan="3">
                                        <span style="text-transform: capitalize;">
                                        <?php echo $this->Sales_model->amount_words(round($receipt->amount)); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Towards:</td>
                                    <td colspan="3"><?php echo $receipt->purpose; ?></td>
                                </tr>
                                <tr>
                                    <td class="no-border-right">
                                        <h5>Voucher sent through.</h5>
                                        <br>
                                        <br>
                                        Mr. <?php echo $receipt->name; ?>
                                        Mobile: <?php echo $receipt->mobile_no; ?>                                        
                                    </td>
                                    <td align="center" class="no-border-left no-border-right">
                                        <strong>Prepared By</strong>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <?php echo $receipt->display_name; ?>
                                    </td>
                                    <td align="right" class="no-border-left" colspan="2">
                                        <strong>For <?php echo $receipt->concern_name; ?></strong>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        Auth.Sign.
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
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });
</script>
</body>
</html>