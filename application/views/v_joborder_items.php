<thead>
<tr>
    <th>#</th>
    <th>Item Group</th>
    <th>Item Name</th>
    <th class="">Shade No</th>
    <th class="">Lot No</th>
    <th class="">Quantity</th>
    <th class="">Job Quantity</th>
    <th class="">Uom</th>
</tr>
</thead>
<tbody>
<?php
$sno = 1;
foreach ($items as $item) {
  ?>
  <tr>
      <td><?=$sno; ?></td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $item['enq_itemgroup'], 'group_name'); ?>
      </td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item['enq_item'], 'item_name'); ?>
      </td>
      <td class="">
        <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name'); ?>
      </td>
      <td class="">
        <?=$this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $item['enq_lot_no'], 'lot_no'); ?>
      </td>
      <td><?=$item['enq_required_qty']; ?></td>
      <td>
        <input class="form-control" style="width:150px;" name="job_quantity[<?=$item['enq_item_id']; ?>]" required>
      </td>
      <td class="">
        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_itemuom'], 'uom_name'); ?>
      </td>
      
  </tr>
  <?php
  $sno++;
}
?>                            
</tbody>