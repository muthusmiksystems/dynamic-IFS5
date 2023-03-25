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
                        I Owe You Voucher
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
                                        <span class="concern-name"><?php echo $voucher->concern_name; ?></span>
                                    </th>
                                    <th colspan="2" class="text-right">
                                        <span class="voucher-name">Voucher No: <?php echo $voucher->iou_voucher_no; ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="vertical-align: top">
                                        <span class="concern-address"><?php echo $voucher->concern_address; ?>.</span>
                                    </th>
                                    <th colspan="2" class="text-right">
                                        DATE: <?php echo date("d-m-Y", strtotime($voucher->date_time)); ?>
                                        <!-- <span class="voucher-amount">Rs. 25000</span> -->
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Item Name</th>
                                                    <th class="text-right">Qty</th>
                                                    <th class="text-right">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sno = 1;
                                                $total_amount = 0;
                                                ?>
                                                <?php if(sizeof($voucher_items) > 0): ?>
                                                    <?php foreach($voucher_items as $row): ?>
                                                        <?php
                                                        $total_amount += $row->amt_required;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sno++; ?></td>
                                                            <td><?php echo $row->item_name; ?></td>
                                                            <td align="right"><?php echo $row->qty_required; ?></td>
                                                            <td align="right"><?php echo $row->amt_required; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td align="right" colspan="3"><strong>Total</strong></td>
                                                    <td align="right"><strong><?php echo $total_amount; ?></strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <strong>Signature of the person</strong>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    </td>
                                    <td align="center">
                                        <strong>Prepared By</strong>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <?php echo $voucher->user_nicename; ?>
                                    </td>
                                    <td align="center">
                                        <strong>A/C DEPT</strong>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    </td>
                                    <td align="right">
                                        <strong>Passed By</strong>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
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