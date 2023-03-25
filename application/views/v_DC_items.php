<thead>
<tr>
    <th>Box No</th>
    <th>Item</th>
    <th class="">PO Qty</th>
    <th class="">Bill Qty</th>
    <th class="">PO Rate</th>
    <th class="">Bill Rate</th>
    <th class="">Tax %</th>
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
  $box_enq_item = $box['box_enq_item'];
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
  
  $POitems = $this->m_purchase->getDatas('bud_enquiry_items', 'enq_item_id', $box_enq_item);
  foreach ($POitems as $POitem) {
    $enq_required_qty = $POitem['enq_required_qty'];
    $enq_item_rate = $POitem['enq_item_rate'];
  }
  ?>
  <tr>                            <td><?=$box_id; ?></td>                            <td><?=$enq_item_name; ?></td>                              <td><?=$enq_required_qty; ?></td>                              <td><?=$box_netweight; ?></td>                              <td><?=number_format($enq_item_rate, 2, '.', ''); ?></td>                              <td>
        <input type="hidden" name="box_enq_item[]" value="<?=$box_enq_item; ?>">
        <input type="hidden" name="sales_boxes[]" value="<?=$box_id; ?>">
        <input type="text" name="billrate[<?=$box_enq_item; ?>]">
      </td>                              <td><input type="text" name="billtax[<?=$box_enq_item; ?>]"></td>                             
  </tr>
  <?php
  $sno++;
  }
}
?>                       
</tbody>