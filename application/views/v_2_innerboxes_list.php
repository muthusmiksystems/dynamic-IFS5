<?php
$innerboxes = $this->m_production->get_innerboxes_list($packing_customer, $packing_item);  
?>
<table class="table table-striped border-top">
 <thead>
    <tr>
       <th>Sno</th>
       <th>Party Name</th>
       <th>Inner Box No</th>
       <th>Item Code</th>
       <th>Item Name</th>
       <th>Qty in Meter</th>
       <th>Net Weight</th>
       <th>Select</th>
    </tr>
 </thead>
 <tbody>
    <?php
    $sno = 1;
    foreach ($innerboxes as $innerbox) {
       ?>
       <tr>
          <td><?=$sno; ?></td>
          <td>
             <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $innerbox['packing_cust'], 'cust_name'); ?>
          </td>
          <td>S-<?=$innerbox['box_no']; ?></td>
          <td><?=$innerbox['packing_item']; ?></td>
          <td>
             <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $innerbox['packing_item'], 'item_name'); ?>
          </td>
          <td><?=number_format($innerbox['packing_tot_mtr'], 2, '.', ''); ?></td>
          <td><?=number_format($innerbox['packing_net_weight'], 2, '.', ''); ?></td>
          <td>
             <input type="checkbox" name="inner_boxes[]" value="<?=$innerbox['box_no']; ?>">
          </td>
       </tr>
       <?php
       $sno++;
    }
    ?>
 </tbody>
 </table>