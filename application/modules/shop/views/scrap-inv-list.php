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
                            Print Scrap Invoice
                        </header>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Invoice ID</th>
                                        <th>Date</th>
                                        <th>Concern</th>
                                        <th>Customer</th>
                                        <th>Delivery To</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sno = 1; ?>
                                    <?php if(sizeof($invoices) > 0): ?>
                                        <?php foreach($invoices as $row): ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo $row->invoice_no; ?></td>
                                                <td><?php echo $row->invoice_id; ?></td>
                                                <td><?php echo date("d-m-Y g:i a", strtotime($row->invoice_date)); ?></td>
                                                <td><?php echo $row->concern_name; ?></td>
                                                <td><?php echo $row->cust_name; ?></td>
                                                <td><?php echo $row->del_cust_name; ?></td>
                                                <td><?php echo $row->name; ?></td>
                                                <td><?php echo $row->mobile_no; ?></td>
                                                <td><?php echo $row->invoice_amt; ?></td>
                                                <td>
                                                    <a target="_blank" href="<?php echo base_url('shop/scrapsales/print_scrap_invoice/'.$row->invoice_id); ?>" class="btn btn-xs btn-primary">Print</a>
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
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });

    var index = $(".dataTables").find('th:last').index();
    oTable01 = $('.dataTables').dataTable({
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