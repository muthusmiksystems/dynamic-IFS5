<?php
$cart_items = $this->m_production->labelCartItems($this->session->userdata('user_id'));
?>
<table class="table table-striped border-top">
 <thead>
    <tr>
    <tr>
       <th>#</th>
       <th>Outer Box No</th>
       <th>Item</th>
       <th>Item Code</th>
       <th>Bal Qty</th>
       <th>Total Net Weight</th>
       <th>Delivery Qty</th>
       <th><a class="removeAll btn btn-danger btn-xs">Remove All</a></th>
    </tr>
 </thead>
 <tbody>
    <?php
    $sno = 1;
    foreach ($cart_items as $row){ 
      $packing_gr_weight = ($row['packing_gr_weight'] != '')?$row['packing_gr_weight']:0;
        $delivered_qty=$this->m_production->boxDeliveredQty($row['box_no']);
       ?>
       <tr>
          <td width="5%"><?=$sno; ?></td>
          <td width="10%"><?=$row['box_prefix']?> - <?=$row['box_no']; ?></td>
          <td width="20%"><?=$row['item_name']; ?></td>
          <td width="5%"><?=$row['item_id']; ?></td>                           <td width="5%"><?=round($row['SUM(`total_qty`)'])-round($delivered_qty); ?></td>
          <td width="5%"><?=$packing_gr_weight; ?></td>
          <td width="30%" class='itemSize'>
            <?php
              $box_items=$this->m_masters->getmasterdetails('bud_lbl_outerbox_items', 'box_no', $row['box_no']);
              foreach ($box_items as $box_item) {
                $item_size_dqty=$this->m_production->boxDeliveredQty($row['box_no'],null,$box_item['item_size']);
                ?>
                <label class="col-xs-2"><?=$box_item['item_size'];?></label>
                <input class="col-xs-2" name="p_delivery_qty[]" value="<?=$box_item['total_qty']-$item_size_dqty;?>">
                <input type="hidden" class="col-xs-2" name="item_size[]" value="<?=$row['box_no'].','.$row['item_id'].','.$box_item['item_size'];?>">
                <?php
              }
            ?>
          </td>
          <td width="10%">
             <input type="hidden" name="p_delivery_boxes[]" value="<?=$row['box_no']; ?>">
             <a id="<?=$row['rowid']; ?>" class="remove btn btn-danger btn-xs">Remove</a>
          </td>
       </tr>
       <?php
       $sno++;
    }
    ?>
 </tbody>
 </table>