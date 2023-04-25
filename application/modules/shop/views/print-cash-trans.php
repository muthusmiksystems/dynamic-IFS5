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
                        Print Shop Cash Receipt Cash Transfer
                    </header>
                    <div class="panel-body">
                        <?php if($transfer): ?>
                            <?php
                            $receipt_amt = 0;
                            $receipt_ids = explode(",", $transfer->receipt_ids);                            
                            ?>
                            <table class="table table-bordered invoice-table">
                                <thead>
                                    <tr>
                                        <th colspan="10" class="text-center">
                                            <strong><?php echo strtoupper('Cash Receipt Cash Transfer'); ?></strong>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">From : <?php echo $transfer->from_staff_name; ?></th>
                                        <th colspan="3">To : <?php echo $transfer->to_staff_name; ?></th>
                                        <th colspan="3">Date: <?php echo date("d-m-Y g:i A", strtotime($transfer->transfer_date)); ?></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Receipt No</th>
                                        <th>Date</th>
                                        <th>Concern Name</th>
                                        <th>Party Name</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Purpose</th>
                                        <th>Paid By</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    if(count($receipt_ids) > 0):
                                        foreach ($receipt_ids as $receipt_id):
                                            $receipt = $this->Sales_model->get_cash_receipt($receipt_id);
                                            if($receipt):
                                                $receipt_nos[] = 'SHOP-'.$receipt->receipt_id;
                                                $receipt_amt += $receipt->amount;
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td>SHOP-<?php echo $receipt->receipt_id; ?></td>
                                                <td><?php echo date("d-m-Y g:i A", strtotime($receipt->receipt_date)); ?></td>
                                                <td><?php echo $receipt->concern_name; ?></td>
                                                <td><?php echo $receipt->cust_name; ?></td>
                                                <td><?php echo $receipt->name; ?></td>
                                                <td><?php echo $receipt->mobile_no; ?></td>
                                                <td><?php echo $receipt->purpose; ?></td>
                                                <td><?php echo $receipt->display_name; ?></td>
                                                <td><?php echo $receipt->amount; ?></td>
                                            </tr>
                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="9"><strong>Total</strong></td>
                                        <td><strong><?php echo number_format($receipt_amt, 2, '.', ''); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">
                                            <div class="print-div col-lg-3">
                                                <strong>Received By</strong>
                                                <br/>
                                                <br/>
                                                <br/>
                                                <br/>
                                                <?php echo $transfer->to_staff_name; ?>
                                            </div>
                                            <div class="print-div col-md-offset-6 col-lg-3 text-right" style="border-right:none;">
                                                <strong>Prepared By</strong>
                                                <br/>
                                                <br/>
                                                <br/>
                                                <br/>
                                                <?php echo $transfer->from_staff_name; ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button class="btn btn-sm btn-primary hidden-print" onclick="window.print()">Print</button>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    oTable01 = $('.datatables').dataTable({
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        }
    });
    jQuery('.dataTables_filter input').addClass("form-control");
    jQuery('.dataTables_length select').addClass("form-control");
</script>
</body>
</html>