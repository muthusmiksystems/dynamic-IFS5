<?php
$cart_items = $this->m_masters->getmasterdetails('bud_yt_cart_items','user_id', $this->session->userdata('user_id'));
$tot_boxes = 0;
$tot_gr_weight = 0;
$tot_nt_weight = 0;
foreach ($cart_items as $items) {
  $outerboxes = $this->m_delivery->getPackingBoxDetails($items['item_id']);
  $tot_boxes++;
  foreach ($outerboxes as $row) {
    $tot_gr_weight += $row['gross_weight'];
    $tot_nt_weight += $row['net_weight'];        
  }
}
?>
<table class="table table-bordered">
 <thead>
    <tr class="total-row" style="font-size:14px; background-color: #d8050d; color: #fff;">
        <th></th>
        <th><?php echo $tot_boxes; ?></th>
        <th>Boxes</th>
        <th colspan="2" class="text-center">Total Qty</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><?php echo $tot_gr_weight; ?></th>
        <th><?php echo $tot_nt_weight; ?></th>
        <th></th>
        <th></th>
    </tr>
    <tr>
    <th>#</th>
    <th>Box No</th>
    <th>Item</th>
    <th>Item Code</th>
    <th>Shade Name</th>
    <th>Shade No</th>
    <th>S.Lot No</th>
    <th>M.Lot No</th>
    <th># of Cones</th>
    <th>Gr.Weight</th>
    <th>Nt.Weight</th>
    <th>Stock Room</th>
    <th></th>
    </tr>
 </thead>
 <tbody>
    <?php
    $sno = 1;
    foreach ($cart_items as $items){
    // foreach ($p_delivery_boxes as $id) {
      $outerboxes = $this->m_delivery->getPackingBoxDetails($items['item_id']);
      foreach ($outerboxes as $row) {
        $no_of_cones = $row['no_of_cones'];
        $net_wt = (!empty($row['net_weight']))?$row['net_weight']:0;
        ?>
        <tr>
          <td><?=$sno; ?></td>
          <td><?=$row['box_prefix']; ?><?=$row['box_no']; ?></td>
          <td><?=$row['item_name']; ?></td>
          <td><?=$row['item_id']; ?></td>
          <td><?=$row['shade_name']; ?></td>
          <td><?=$row['shade_no']; ?></td>
          <td><?=$row['lot_no']; ?></td>
          <td><?=$row['manual_lot_no']; ?></td>
          <td><?=$no_of_cones; ?></td>
          <td>
            <?=$row['gross_weight']; ?>
          </td>
          <td>
            <?=$row['net_weight']; ?>
          </td>
          <td><?php echo $row['stock_room_name']; ?></td>
          <td>
            <input type="hidden" name="p_delivery_boxes[]" value="<?=$row['box_id']; ?>">
            <a id="<?=$items['rowid']; ?>" class="remove btn btn-danger btn-xs">Remove</a>
          </td>
        </tr>
        <?php
        $sno++;
      }
    }
    ?>
 </tbody>
 </table>