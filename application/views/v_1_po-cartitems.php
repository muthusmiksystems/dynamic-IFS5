<?php
$mycart = $this->m_mycart->viewPoCartYt();
?>
<table class="table table-striped border-top">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Item Name</th>
      <th>Item Code</th>
      <th>Shade Name/Code</th>
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
        <td><?=$row['shade_name']; ?>/<?=$row['shade_id']; ?></td>
        <td><?=$row['po_qty']; ?></td>
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