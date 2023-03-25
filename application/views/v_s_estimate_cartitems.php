<?php
$mycart = $this->m_shop->viewEstimateCart();
?>
<table class="table table-striped border-top">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Item Name</th>
      <th>Item Code</th>
      <th>Shade Name</th>
      <th>Shade Code</th>
      <th>Qty</th>
      <th>Uom</th>
      <th>Rate</th>
      <th>Amount</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sno = 1;
    foreach ($mycart as $row) {
      $amount = $row['qty'] * $row['rate'];
      ?>
      <tr>
        <td><?=$sno; ?></td>
        <td><?=$row['item_name']; ?></td>
        <td><?=$row['item_id']; ?></td>
        <td><?=$row['shade_name']; ?></td>
        <td><?=$row['shade_id']; ?></td>
        <td><?=$row['qty']; ?></td>
        <td><?=$row['uom']; ?></td>
        <td><?=$row['rate']; ?></td>
        <td><?=$amount; ?></td>
        <td>
          <a id="<?=$row['row_id']; ?>" class="removetocart btn btn-danger btn-xs">Remove</a>
        </td>
      </tr>
      <?php
      $sno++;
    }
    ?>
  </tbody>
</table>