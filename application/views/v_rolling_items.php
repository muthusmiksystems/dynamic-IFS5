<thead>
<tr>
    <th>#</th>
    <th>Item Name</th>
    <th >Item Code</th>
    <th class="">No of Roll</th>
    <th class="">Meter / Roll</th>
    <th class="">Total Meters</th>
    <th class=""></th>
</tr>
</thead>
<tbody>
<?php
$sno = 1;
$total_rolls = 0;
$total_meters = 0;
foreach ($this->cart->contents() as $items) {
  $total_rolls += $items['qty'];
  $total_meters += $items['subtotal'];
  ?>
  <tr>
      <td><?=$sno; ?></td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $items['name'], 'item_name'); ?>
      </td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $items['name'], 'item_id'); ?>
      </td>
      <td><?=$items['qty']; ?></td>
      <td><?=$items['price']; ?></td>
      <td><?=$items['subtotal']; ?></td>
      <td>
        <a href="#" id="<?=$items['rowid']; ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user removecart"><i class="icon-trash "></i></a>
      </td>
  </tr>
  <?php
  $sno++;
}
?>
  <tr>
    <td></td>
    <td></td>
    <td>Total</td>
    <td><?=$total_rolls; ?></td>
    <td></td>
    <td><?=$total_meters; ?></td>
    <td></td>
  </tr>                             
</tbody>