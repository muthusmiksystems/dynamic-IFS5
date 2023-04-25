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
                            Predelivery Boxes
                        </header>
                        <?php
                        /*echo "<pre>";
                        print_r($predc_boxes);
                        echo "</pre>";*/
                        ?>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Box no</th>
                                        <th>Pre DC No</th>
                                        <th>Date</th>
                                        <th>Item name/code</th>
                                        <th>Shade name/code</th>
                                        <th>Shade number</th>
                                        <th>Lot no</th>
                                        <th>#Boxes</th>
                                        <th>#Cones</th>
                                        <th>Gr.Wt</th>
                                        <th>Nt.Wt</th>
                                    </tr>
                                </thead>
                                <?php
                                $sno = 1;
                                ?>
                                <tbody>
                                    <?php if(sizeof($predc_boxes) > 0): ?>
                                        <?php foreach($predc_boxes as $box): ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                                                <td><?php echo $box->p_delivery_id; ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($box->p_delivery_date)); ?></td>
                                                <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
                                                <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
                                                <td><?php echo $box->shade_code; ?></td>
                                                <td><?php echo $box->lot_no; ?></td>
                                                <td><?php echo $box->no_boxes; ?></td>
                                                <td><?php echo $box->no_cones; ?></td>
                                                <td><?php echo $box->gr_weight; ?></td>
                                                <td><?php echo $box->nt_weight; ?></td>
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