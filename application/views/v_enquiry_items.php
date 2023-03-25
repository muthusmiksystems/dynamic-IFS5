<thead>
<tr>
    <th>#</th>
    <th>Item Group</th>
    <th >Item Name</th>
    <th class="">Color</th>
    <th class="">Uom</th>
    <th class="">Quantity</th>
    <th class=""></th>
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
        <?=$this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $items['enq_itemgroup'], 'group_name'); ?>
      </td>
      <td class="hidden-phone">
        <?=$this->m_masters->getmasterIDvalue('bud_items', 'item_id', $items['enq_item'], 'item_name'); ?>
      </td>
      <td class="">
        <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $items['enq_itemcolor'], 'shade_name'); ?>
      </td>
      <td class="">
        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $items['enq_itemuom'], 'uom_name'); ?>
      </td>
      <td><?=$items['qty']?></td>
      <td>
        <a href="#" id="<?=$items['rowid']; ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user removecart"><i class="icon-trash "></i></a>
      </td>
  </tr>
  <?php
  $sno++;
}
?>                              
</tbody>