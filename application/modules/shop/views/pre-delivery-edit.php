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
                            Shop Edit Pre Deliveries
                        </header>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>SPDC No</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Boxes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($predc_list) > 0): ?>
                                        <?php foreach($predc_list as $row): ?>
                                            <?php
                                            $item_names = array();
                                            $item_boxes = array();
                                            $predc_items = $this->Predelivery_model->get_predc_items($row->p_delivery_id);
                                            if(sizeof($predc_items) > 0)
                                            {
                                                foreach ($predc_items as $item) {
                                                    $item_names[$item->item_id] = $item->item_name;
                                                    $item_boxes[$item->box_id] = $item->box_prefix.$item->box_no;
                                                }
                                            }
                                            ?>

                                            <?php if($row->p_delivery_status != 1): ?>
                                                <tr>
                                                    <td><?php echo $sno++; ?></td>
                                                    <td><?php echo date("d-m-Y g:i A", strtotime($row->p_delivery_date)); ?></td>
                                                    <td><?php echo $row->p_delivery_id; ?></td>
                                                    <td><?php echo $row->cust_name; ?></td>
                                                    <td><?php echo implode(",", $item_names); ?></td>
                                                    <td><?php echo implode(",", $item_boxes); ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('shop/predelivery/index/'.$row->p_delivery_id); ?>" target="_blank" class="btn btn-xs btn-primary">Edit Pre DC</a>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
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