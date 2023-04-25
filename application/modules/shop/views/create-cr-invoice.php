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
                            Create Credit Invoice
                        </header>
                        <div class="panel-body" id="transfer_dc">
                            <?php if($this->session->flashdata('error')): ?>
                                  <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/sales/cr_invoice_preview'); ?>">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Concern Name</label>
                                    <select class="select2 form-control" id="concern_id" name="concern_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($concerns) > 0): ?>
                                            <?php foreach($concerns as $row): ?>
                                                <option value="<?php echo $row->concern_id; ?>" <?php echo ($row->concern_id == $concern_id)?'selected="selected"':''; ?>><?php echo $row->concern_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Party Name</label>
                                    <select class="select2 form-control" id="customer_id" name="customer_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>" <?php echo ($row->cust_id == $customer_id)?'selected="selected"':''; ?>><?php echo $row->cust_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Delivery Address</label>
                                    <select class="select2 form-control" id="delivery_to" name="delivery_to">
                                        <option value="">Select</option>
                                        <?php if(sizeof($customers) > 0): ?>
                                            <?php foreach($customers as $row): ?>
                                                <option value="<?php echo $row->cust_id; ?>" <?php echo ($row->cust_id == $delivery_to)?'selected="selected"':''; ?>><?php echo $row->cust_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no; ?>">
                                </div>
                            </div>


                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>SDC No</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Boxes</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($delivery_list) > 0): ?>
                                        <?php foreach($delivery_list as $row): ?>
                                            <?php
                                            $item_names = array();
                                            $item_boxes = array();
                                            $delivery_items = $this->Delivery_model->get_delivery_items($row->delivery_id);
                                            if(sizeof($delivery_items) > 0)
                                            {
                                                foreach ($delivery_items as $item) {
                                                    $item_names[$item->item_id] = $item->item_name;
                                                    $item_boxes[$item->box_id] = $item->box_prefix.$item->box_no;
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo date("d-m-Y g:i A", strtotime($row->delivery_date)); ?></td>
                                                <td><?php echo $row->delivery_id; ?></td>
                                                <td><?php echo $row->cust_name; ?></td>
                                                <td><?php echo implode(",", $item_names); ?></td>
                                                <td><?php echo implode(",", $item_boxes); ?></td>
                                                <td>
                                                    <input type="checkbox" class="chkDcId" value="<?php echo $row->delivery_id; ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <input type="hidden" name="selected_boxes" id="selected_boxes">

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Create Invoice</button>
                                </div>
                            </div>
                            </form>
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

    $(document).on('click', "input[type='checkbox']", function(){
        var matches = [];
        var cart_boxes = 0;
        var cart_gr_wt = 0;
        var cart_nt_wt = 0;
        var checkedcollection = oTable01.$(".chkDcId:checked", { "page": "all" });
        checkedcollection.each(function (index, elem) {
            matches.push($(elem).val());
        });
        $("#selected_boxes").val(matches);
        // alert(matches);
    });
</script>
</body>
</html>