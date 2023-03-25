<?php
$mycart = $this->m_mycart->viewPoInwCartYt();
?>
<table class="table table-striped border-top">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Item Name</th>
      <th>Item Code</th>
      <th>Supplier</th>
      <th>R.Mat<br>POY dn.</th>
      <th>R.Mat<br>POY Lot</th>
      <th>R.Mat<br>POY Qty</th>
      <th>R.Mat<br>POY Rate</th><!--inclusion of poy item rate-->
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
        <td><?=$row['sup_name']; ?></td>
        <td><?=$row['denier_name']; ?></td>
        <td><?=$row['poy_lot_no']; ?></td>
        <td><?=$row['po_qty']; ?></td>
        <td><?=$row['po_item_rate']; ?></td><!--inclusion of poy item rate-->
        <td><?=$row['uom_name']; ?></td>
        <td>
          <a id="<?=$row['rowid']; ?>" class="removetocart btn btn-danger btn-xs">Remove</a>
        </td>
      </tr>
      <?php
      $sno++;
    }
    ?>
  </tbody>
</table>