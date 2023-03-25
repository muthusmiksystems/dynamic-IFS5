<?php include APPPATH.'views/html/header.php'; ?>
	<section id="main-content">
		<section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading text-center">
                            <strong>Stock Transfer Acceptance Form</strong>

                            <a href="<?php echo base_url('shop/stocktrans/accept_dc'); ?>" class="btn btn-xs btn-primary pull-right">View All</a>
                        </header>
                        <div class="panel-body" id="transfer_list">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>DC no</th>
                                            <th>Date</th>
                                            <th>From Concern</th>
                                            <th>From Staff</th>
                                            <th>To Concern</th>
                                            <th>To Staff</th>
                                            <th>Items</th>
                                            <th>Shade Name</th>
                                            <th>Shade No</th>
                                            <th>Boxes</th>
                                            <th>Tot.Nt.Wt</th>
                                            <th>Date Time</th>
                                            <th>Accepted By</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sno = 1;
                                        ?>
                                        <?php if(sizeof($dc_list) > 0): ?>
                                            <?php foreach($dc_list as $row): ?>
                                                <?php
                                                $selected_boxes = explode(",", $row->selected_boxes);
                                                $items = array();
                                                $shade_names = array();
                                                $shade_codes = array();
                                                $tot_net_weight = 0;
                                                if(count($selected_boxes) > 0)
                                                {
                                                    foreach($selected_boxes as $box_id)
                                                    {
                                                        $box = $this->Stocktrans_model->getPackingBox($box_id);
                                                        if($box)
                                                        {
                                                            $items[$box->item_id] = $box->item_name;
                                                            $shade_names[$box->shade_id] = $box->shade_name;
                                                            $shade_codes[$box->shade_id] = $box->shade_code;
                                                            $tot_net_weight += $box->net_weight;
                                                        }
                                                    }
                                                }

                                                $to_users = array();
                                                $to_user_ids = explode(",", $row->to_user_id);
                                                if(count($to_user_ids) > 0)
                                                {
                                                    foreach ($to_user_ids as $user_id) {
                                                        $user = $this->Stocktrans_model->get_user($user_id);
                                                        if($user)
                                                        {
                                                            $to_users[$user->ID] = $user->display_name;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $sno++; ?></td>
                                                    <td><?php echo $row->id; ?></td>
                                                    <td><?php echo date("d-m-Y H:i", strtotime($row->transfer_date)); ?></td>
                                                    <td><?php echo $row->from_concern_name; ?></td>
                                                    <td><?php echo $row->from_staff_name; ?></td>
                                                    <td><?php echo $row->to_concern_name; ?></td>
                                                    <td><?php echo implode(",", $to_users); ?></td>
                                                    <td><?php echo implode(",<br>", $items); ?></td>
                                                    <td><?php echo implode(",<br>", $shade_names); ?></td>
                                                    <td><?php echo implode(",<br>", $shade_codes); ?></td>
                                                    <td><?php echo count($selected_boxes); ?></td>
                                                    <td><?php echo number_format($tot_net_weight, 3, '.', ''); ?></td>
                                                    <?php if(strtotime($row->recieved_date) > 0): ?>
                                                        <td><?php echo date("d-m-Y H:i", strtotime($row->recieved_date)); ?></td>
                                                    <?php else: ?>
                                                        <td>00:00:000</td>
                                                    <?php endif; ?>
                                                    <td><?php echo $row->accepted_name; ?></td>
                                                    <td><?php echo $row->recieved_remarks; ?></td>
                                                    <td>
                                                        <?php if($row->transfer_status == 1 && in_array($this->session->userdata('user_id'), $to_user_ids)): ?>
                                                            <button onclick="showAjaxModal('<?php echo base_url('shop/stocktrans/accept_dc_form/'.$row->id); ?>')" class="btn btn-xs btn-warning">Accept</button>
                                                        <?php elseif($row->transfer_status == 1): ?>
                                                            <label class="label label-danger">Accept Pending</label><br>
                                                        <?php elseif($row->transfer_status == 2): ?>
                                                            <a href="<?php echo base_url('shop/stocktrans/print_shop_dc/'.$row->id); ?>" target="_blank" class="btn btn-xs btn-primary">Print DC</a>
                                                            <button onclick="showAjaxModal('<?php echo base_url('shop/stocktrans/update_dc_form/'.$row->id); ?>')" class="btn btn-xs btn-success">Update stock room</button>
                                                        <?php endif; ?>
                                                        <a href="<?php echo base_url('shop/stocktrans/print_shop_dc/'.$row->id); ?>" target="_blank" class="btn btn-xs btn-default">View</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>

    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content">                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Accept DC</h4>
                </div>
                
                <div class="modal-body" style="height:500px; overflow:auto;">
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    function showAjaxModal(url)
    {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url('themes/admin/img/preloader.gif') ?>" /></div>');
        
        // LOADING THE AJAX MODAL
        jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
        
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response)
            {
                jQuery('#modal_ajax .modal-body').html(response);

                $(function(){
                    $('.default-date-picker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true
                    });
                });

                $(".select2").select2();
            }
        });
    }

    $('#transfer_list table').dataTable({
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
    jQuery('.dataTables_wrapper .dataTables_filter input').addClass("form-control");
    jQuery('.dataTables_wrapper .dataTables_length select').addClass("form-control");
</script>
</body>
</html>