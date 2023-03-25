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
                            Export Invoice
                        </header>
                        <div class="panel-body">
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Concern Name/Code</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Type</th>
                                        <th>Customer Name/Code</th>
                                        <th>Item Name/Code</th>
                                        <th>Qty</th>
                                        <th>UOM</th>
                                        <th>Rate</th>
                                        <th>Basic Amount</th>
                                        <th>Tax Type</th>
                                        <th>Tax Amount</th>
                                        <th>Transport Charge</th>
                                        <th>Discount</th>
                                        <th>Final In Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sno = 1; ?>
                                    <?php if(sizeof($invoices) > 0): ?>
                                        <?php foreach($invoices as $row): ?>
                                            <?php
                                            $deduction_amounts = explode(",", $row->deduction_amounts);
                                            $deduction_values = explode(",", $row->deduction_values);
                                            $deduction_units = explode(",", $row->deduction_units);
                                            $tax_names = explode(",", $row->tax_names);
                                            $tax_values = explode(",", $row->tax_values);
                                            $tax_amounts = explode(",", $row->tax_amounts);
                                            $addtions_values = explode(",", $row->addtions_values);
                                            $addtions_units = explode(",", $row->addtions_units);
                                            $addtions_amounts = explode(",", $row->addtions_amounts);
                                            $item_rates = explode(",", $row->item_rate);
                                            $item_names = array();
                                            $item_uoms = array();
                                            $net_weights = array();
                                            $boxes = explode(",", $row->boxes_array);
                                            foreach ($boxes as $key => $box_id) {
                                                $box = $this->ak->yt_packing_box($box_id);
                                                if($box)
                                                {
                                                    $item_rate = $item_rates[$key];
                                                    $net_weights[$box_id] = $box->net_weight;
                                                    $item_amount = $item_rate * $box->net_weight;

                                                    $item_sub_tot = $item_amount;
                                                    $deduction_amt = 0;
                                                    if(count($deduction_values) > 0)
                                                    {
                                                        foreach ($deduction_values as $ded_key => $value) {
                                                            $deduction = 0;
                                                            if(isset($deduction_units[$key]) == '%')
                                                            {
                                                                $deduction = ($item_sub_tot * $value) / 100;
                                                            }
                                                            else
                                                            {
                                                                $deduction = $value;
                                                            }
                                                            $deduction_amt += $deduction;
                                                            $item_sub_tot = $item_sub_tot - $deduction;
                                                        }
                                                    }

                                                    $tax_amt = 0;
                                                    if(count($tax_values) > 0)
                                                    {
                                                        foreach ($tax_values as $tax_key => $tax) {
                                                            if($tax > 0)
                                                            {
                                                                $tax_value = ($item_sub_tot * $tax) / 100;
                                                                $tax_amt += $tax_value;
                                                                $item_sub_tot = $item_sub_tot + $tax_value;
                                                            }
                                                        }
                                                    }

                                                    $addition_amt = 0;
                                                    if(count($addtions_values) > 0)
                                                    {
                                                        foreach ($addtions_values as $add_key => $value) {
                                                            $addition = 0;
                                                            if(isset($addtions_units[$key]) == '%')
                                                            {
                                                                $addition = ($item_sub_tot * $value) / 100;
                                                            }
                                                            else
                                                            {
                                                                $addition = $value;
                                                            }
                                                            $addition_amt += $addition;
                                                            $item_sub_tot = $item_sub_tot + $addition;
                                                        }
                                                    }
                                                    $item_value = $item_amount - $deduction_amt;
                                                    $item_value += $tax_amt;
                                                    $item_value += $addition_amt;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sno++; ?></td>
                                                        <td><?php echo $row->concern_name; ?>/<?php echo $row->concern_id; ?></td>
                                                        <td><?php echo $row->invoice_no; ?></td>
                                                        <td><?php echo date("d-m-Y", strtotime($row->invoice_date)); ?></td>
                                                        <td>Credit</td>
                                                        <td><?php echo $row->cust_name; ?>/<?php echo $row->customer; ?></td>
                                                        <td><?php echo $box->item_name.'/'.$box->item_id; ?></td>
                                                        <td><?php echo $box->net_weight; ?></td>
                                                        <td><?php echo 'Kg'; ?></td>
                                                        <td><?php echo $item_rate; ?></td>
                                                        <td><?php echo number_format($item_amount, 2, '.', ''); ?></td>
                                                        <td><?php echo implode(",", $tax_names); ?></td>
                                                        <td><?php echo number_format($tax_amt, 4, '.', ''); ?></td>
                                                        <td><?php echo number_format($addition_amt, 4, '.', ''); ?></td>
                                                        <td><?php echo number_format($deduction_amt, 4, '.', ''); ?></td>
                                                        <td><?php echo number_format($item_value, 2, '.', ''); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
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
<script type="text/javascript" language="javascript" src="<?php echo base_url('themes/default'); ?>/assets/advanced-datatable/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('themes/default'); ?>/assets/advanced-datatable/media/js/jquery.dataTables.delay.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('themes/default'); ?>/assets/advanced-datatable/extras/TableTools/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('themes/default'); ?>/assets/advanced-datatable/extras/TableTools/media/js/TableTools.js"></script>
<script type="text/javascript">
    TableTools.DEFAULTS.sSwfPath = "<?php echo base_url('themes/default'); ?>/assets/advanced-datatable/extras/TableTools/media/swf/copy_csv_xls_pdf.swf";
    TableTools.DEFAULTS.aButtons = [ "xls" ];
    var index = $(".dataTables").find('th:last').index();
    oTable01 = $('.dataTables').dataTable({
        // "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "sDom": 'T<"clear">lfrtip',
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