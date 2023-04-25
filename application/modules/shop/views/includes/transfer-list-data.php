<div class="table-responsive">
    <table class="table table-bordered" id="dataTable">
        <thead>
            <tr>
                <th>S.No</th>
                <th>DC no</th>
                <th>Date</th>
                <th>From Concern</th>
                <th>From Stock Room</th>
                <th>From Staff</th>
                <th>To Concern</th>
                <th>To Stock Room</th>
                <th>To Stock Staff</th>
                <th>Boxes</th>
                <!-- <th>Status</th> -->
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
        				<td><?php echo $row->from_stock_room_name; ?></td>
        				<td><?php echo $row->from_staff_name; ?></td>
        				<td><?php echo $row->to_concern_name; ?></td>
        				<td><?php echo $row->to_stock_room_name; ?></td>
        				<td><?php echo implode(",", $to_users); ?></td>
        				<td><?php echo count($selected_boxes); ?></td>
        				<!-- <td>
        					<?php if($row->transfer_status == 0): ?>
        						<a href="#" class="btn btn-xs btn-warning">Transfer Pending</a>
        					<?php endif; ?>
        				</td> -->
        				<td>
        					<a href="<?php echo base_url('shop/stocktrans/print_shop_dc/'.$row->id); ?>" target="_blank" class="btn btn-xs btn-primary">Print DC</a>
                            <?php if($row->accepted_by == ''): ?>
                                <button type="button" class="btn btn-xs btn-danger remove-dc" id="<?php echo $row->id; ?>">Remove</button>
                            <?php endif; ?>
        				</td>
        			</tr>
        		<?php endforeach; ?>
        	<?php endif; ?>
        </tbody>
    </table>
</div>