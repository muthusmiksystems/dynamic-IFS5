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
                        Shop Cash quotation Cash Transfer Pending List
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered datatables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transfer No</th>
                                    <th>Date</th>
                                    <th>From Staff</th>
                                    <th>To Staff</th>
                                    <th>Remarks</th>
                                    <th>quotation Nos</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                ?>
                                <?php if(sizeof($transfer_list) > 0): ?>
                                    <?php foreach($transfer_list as $row): ?>
                                        <?php
                                        $quotation_nos = array();
                                        $quotation_amt = 0;
                                        $quotation_ids = explode(",", $row->quotation_ids);
                                        if(count($quotation_ids) > 0)
                                        {
                                            foreach ($quotation_ids as $quotation_id) {
                                                $quotation = $this->Sales_model->get_quotation($quotation_id);
                                                if($quotation)
                                                {
                                                    $quotation_nos[] = 'QUOT NO-'.$quotation->quotation_id;
                                                    $quotation_amt += $quotation->quotation_amt;
                                                }
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $row->id; ?></td>
                                            <td><?php echo date("d-m-Y g:i A", strtotime($row->transfer_date)); ?></td>
                                            <td><?php echo $row->from_staff_name; ?></td>
                                            <td><?php echo $row->to_staff_name; ?></td>
                                            <td><?php echo $row->remarks; ?></td>
                                            <td><?php echo implode(", ", $quotation_nos); ?></td>
                                            <td><?php echo number_format($quotation_amt, 2, '.', ''); ?></td>
                                            <td>
                                                <?php if($row->accepted_by == '' && $row->transfer_to != $this->session->userdata('user_id')): ?>
                                                    <label class="badge bg-warning">Accept Pending</label>
                                                <?php elseif($row->accepted_by == '' && $row->transfer_to == $this->session->userdata('user_id')): ?>
                                                    <a href="<?php echo base_url('shop/quotation/accept_cash_trans/'.$row->id); ?>" class="btn btn-xs btn-danger">Click Accept</a>
                                                <?php else: ?>
                                                    <label class="badge bg-success">Accepted</label>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
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