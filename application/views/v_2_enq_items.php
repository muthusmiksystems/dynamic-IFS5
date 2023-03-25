<thead>
<tr>
    <th>#</th>
    <th>Item Group</th>
    <th>Item Name</th>
    <th>Quantity</th>
    <th>Uom</th>
    <th></th>
</tr>
</thead>
<tbody>
<?php
$sno = 1;
foreach ($this->cart->contents() as $items) {
  ?>
  <tr>
      <td><?=$sno; ?></td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_te_itemgroups', 'group_id', $items['name'], 'group_name'); ?>
      </td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $items['id'], 'item_name'); ?>
      </td>
      <td><?=$items['qty']?></td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $items['enq_itemuom'], 'uom_name'); ?>
      </td>
      <td>
        <a href="#" id="<?=$items['rowid']; ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user removecart"><i class="icon-trash "></i></a>
      </td>
  </tr>
  <?php
  $sno++;
}
?>                              
</tbody>