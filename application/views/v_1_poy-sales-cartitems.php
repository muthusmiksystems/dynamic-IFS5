<?php
$mycart = $this->m_mycart->poySalesCartItems();
?>
<table class="table table-striped border-top">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Item Name</th>
      <th>Item Code</th>
      <th>POY Denier</th>
      <th>Yarn Denier</th>
      <th>POY Qty</th>
      <th>UOM</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sno = 1;
    foreach ($mycart as $row) {
      ?>
      <tr>
        <td><?=$sno; ?></td>
        <td><?=$row['item_name']; ?></td>
        <td><?=$row['item_id']; ?></td>
        <td><?=$row['denier_name']; ?></td>
        <td><?=$row['yarn_denier']; ?></td>
        <td><?=$row['qty']; ?></td>
        <td><?=$row['uom_name']; ?></td>
        <td>
          <a id="<?=$row['id']; ?>" class="removetocart btn btn-danger btn-xs">Remove</a>
        </td>
      </tr>
      <?php
      $sno++;
    }
    ?>
  </tbody>
</table>