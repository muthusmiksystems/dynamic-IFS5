<thead>
<tr>
    <th>#</th>
    <th>Denier</th>
    <th>Color Name</th>
    <th>Color Code</th>
    <th>Qty</th>
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
      <td><?=$items['id']; ?></td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_te_shades', 'shade_id', $items['name'], 'shade_name'); ?>
      </td>
      <td>
        <?=$this->m_masters->getmasterIDvalue('bud_te_shades', 'shade_id', $items['name'], 'shade_code'); ?>
      </td>
      <td><?=$items['qty']; ?></td>
      <td>
        <a href="#" id="<?=$items['rowid']; ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user removecart"><i class="icon-trash "></i></a>
      </td>
  </tr>
  <?php
  $sno++;
}
?>                            
</tbody>