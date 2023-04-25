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
                        Print Enquiry Cash Transfer
                    </header>
                    <div class="panel-body">
                        <?php if($transfer): ?>
                            <?php
                            $quotation_amt = 0;
                            $quotation_ids = explode(",", $transfer->quotation_ids);                            
                            ?>
                            <table class="table table-bordered invoice-table">
                                <thead>
                                    <tr>
                                        <th colspan="8" class="text-center">
                                            <strong><?php echo strtoupper('Enquiry Transfer To Admin'); ?></strong>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">From : <?php echo $transfer->from_staff_name; ?></th>
                                        <th colspan="2">To : <?php echo $transfer->to_staff_name; ?></th>
                                        <th colspan="3">Date: <?php echo date("d-m-Y g:i A", strtotime($transfer->transfer_date)); ?></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Enquiry No</th>
                                        <th>Date</th>
                                        <th>Concern Name</th>
                                        <th>Party Name</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    if(count($quotation_ids) > 0):
                                        foreach ($quotation_ids as $quotation_id):
                                            $quotation = $this->Sales_model->get_quotation($quotation_id);
                                            if($quotation):
                                                // $quotation_nos[] = 'QUOT NO-'.$quotation->quotation_id;
                                                $quotation_nos[] = 'QUOT NO-'.$quotation->quotation_no;
                                                $quotation_amt += $quotation->quotation_amt;
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td>QUOT NO-<?php echo $quotation->quotation_no; ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($quotation->quotation_date)); ?></td>
                                                <td><?php echo $quotation->concern_name; ?></td>
                                                <td><?php echo $quotation->cust_name; ?></td>
                                                <td><?php echo $quotation->name; ?></td>
                                                <td><?php echo $quotation->mobile_no; ?></td>
                                                <td><?php echo $quotation->quotation_amt; ?></td>
                                            </tr>
                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7"><strong>Total</strong></td>
                                        <td><strong><?php echo number_format($quotation_amt, 2, '.', ''); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
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