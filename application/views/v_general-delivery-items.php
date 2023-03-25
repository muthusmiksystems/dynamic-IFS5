<thead>
<tr>
    <th>#</th>
    <th>Item Code</th>
    <th>Item Name</th>
    <th>Supplier</th>
    <th>Quantity</th>
    <th>Uom</th>
    <th>Rate</th>
    <th></th>
</tr>
</thead>
<tbody>
<?php
// print_r($this->cart->contents());
$sno = 1;
foreach ($this->cart->contents() as $items) {
  ?>
  <tr>
      <td><?=$sno; ?></td>
      <td><?=$items['id']; ?></td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $items['id'], 'item_name'); ?>
      </td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_general_customers', 'company_id', $items['supplier'], 'company_name'); ?>
      </td>
      <td><?=$items['qty']?></td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $items['item_uom'], 'uom_name'); ?>
      </td>
      <td><?=$items['price']; ?></td>
      <td>
        <a href="#" id="<?=$items['rowid']; ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user removecart"><i class="icon-trash "></i></a>
      </td>
  </tr>
  <?php
  $sno++;
}
?>                              
</tbody>