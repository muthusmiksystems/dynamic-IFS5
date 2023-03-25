<?php
$cart_items = $this->m_masters->getmasterdetails('bud_cart_items','user_id', $this->session->userdata('user_id'));
?>
<table class="table table-striped border-top">
 <thead>
    <tr>
    <tr>
       <th>#</th>
       <th>Party Name</th>
       <th>Outer Box No</th>
       <th>Item</th>
       <th>Item Code</th>
       <th>Total Meters</th>
       <th>Total Net Weight</th>
       <th></th>
    </tr>
 </thead>
 <tbody>
    <?php
    $sno = 1;
    foreach ($cart_items as $items){
    // foreach ($p_delivery_boxes as $box_no) {
      $outerboxes = $this->m_masters->getmasterdetails('bud_te_outerboxes','box_no', $items['item_id']);
      foreach ($outerboxes as $outerbox) {      ?>
         <tr>
            <td><?=$sno; ?></td>
            <td>
              <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $outerbox['packing_customer'], 'cust_name'); ?>
            </td>
            <td><?=$outerbox['box_no']; ?></td>
            <td>
              <?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $outerbox['packing_innerbox_items'], 'item_name'); ?>
            </td>
            <td><?=$outerbox['packing_innerbox_items']; ?></td>                                          <td>
              <?=round($outerbox['total_meters']); ?>
            </td>
            <td>
              <?=$outerbox['packing_net_weight']; ?>
            </td>
            <td>
               <input type="hidden" name="p_delivery_boxes[]" value="<?=$outerbox['box_no']; ?>">
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