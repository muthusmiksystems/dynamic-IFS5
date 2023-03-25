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
                        Shop Discount Voucher
                    </header>
                    <div class="panel-body" id="transfer_dc">
                        <table class="table voucher-table table-bordered invoice-table">
                            <thead>
                                <tr style="height: 0px;" class="no-padding no-border">
                                    <th style="padding: 0px;border-width: 0px;" width="30%"></th>
                                    <th style="padding: 0px;border-width: 0px;" width="25%"></th>
                                    <th style="padding: 0px;border-width: 0px;" width="20%"></th>
                                    <th style="padding: 0px;border-width: 0px;" width="25%"></th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-left" style="vertical-align: top;">
                                        <span class="concern-name">Concern Name</span>
                                    </th>
                                    <th colspan="2" class="text-right">
                                        <span class="voucher-name">Debit Voucher</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="vertical-align: top">
                                        <span class="concern-address">18-A, ASHER NAGAR, 3rd STREET, GANDHI NAGAR. TIRUPUR - 641603.</span>
                                    </th>
                                    <th colspan="2" class="text-center">
                                        <span class="voucher-amount">Rs. 25000</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="right">No:</td>
                                    <td><span class="voucher-no">IFS Debit.Note-001</span></td>
                                    <td align="right">Date:</td>
                                    <td><?php echo date("d-m-Y"); ?></td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        We are debiting your account name:
                                    </td>
                                    <td colspan="3"></td>
                                </tr>
                                    <td align="right">For Amount:</td>
                                    <td colspan="3">Twenty five thousand only.</td>
                                </tr>
                                <tr>
                                    <td align="right">Towards:</td>
                                    <td colspan="3"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Voucher sent through.</h5>
                                        <br>
                                        <br>
                                        Mr: Mahesh
                                        Mobile: 123444556
                                    </td>
                                    <td align="center">
                                        <strong>Prepared By</strong>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        admin
                                    </td>
                                    <td align="right" colspan="2">
                                        <strong>For Concern Name</strong>
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