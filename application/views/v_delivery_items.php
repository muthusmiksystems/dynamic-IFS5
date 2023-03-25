<thead>
<tr>
    <th>#</th>
    <th>Box No</th>
    <th>Item</th>
    <th class="">Gross Weight</th>
    <th class="">Tare Weight</th>
    <th class="">Net Weight</th>
</tr>
</thead>
<tbody>
<?php
$sno = 1;
foreach ($items as $item) {
  $boxes = $this->m_purchase->getDatas('bud_boxes', 'box_id', $item);
  foreach ($boxes as $box) {
  $lotname = '';
  $box_id = $box['box_id'];
  $box_date = $box['box_date'];
  $box_category = $box['box_category'];
  $box_customer = $box['box_customer'];
  $box_item = $box['box_item'];
  $box_itemcolor = $box['box_itemcolor'];
  $box_item_lot_no = $box['box_item_lot_no'];
  $box_grossweight = $box['box_grossweight'];
  $box_tareweight = $box['box_tareweight'];
  $box_netweight = $box['box_netweight'];

  $machine_id = $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $box_item_lot_no, 'lot_prefix');
  $lotname .= $this->m_masters->getmasterIDvalue('bud_machines', 'machine_id', $machine_id, 'machine_prefix');
  $lotname .= $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $box_item_lot_no, 'lot_no');

  $enq_item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $box_item, 'item_code');
  $enq_item_name .= '/'.$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $box_itemcolor, 'shade_code');
  $enq_item_name .= '/'.$lotname;
  $box_category_name = $this->m_masters->getmasterIDvalue('bud_categories', 'category_id', $box_category, 'category_name');
  $box_customer_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $box_customer, 'cust_name');
  ?>
  <tr>
      <td><input type="checkbox" name="selected_boxes[]" value="<?=$box_id; ?>"></td>                            <td><?=$box_id; ?></td>                            <td><?=$enq_item_name; ?></td>                              <td><?=$box_grossweight; ?></td>                              <td><?=$box_tareweight; ?></td>                              <td><?=$box_netweight; ?></td>                                
  </tr>
  <?php
  $sno++;
  }
}
?>                       
</tbody>