<?php
if($POitems != '')
{
  $req_items = explode("|", $POitems);
  ?>
  <thead>
  <tr>
      <th>#</th>
      <th>Item Group</th>
      <th>Item Name</th>
      <th class="">Shade No</th>
      <th class="">Lot No</th>
      <th class="">Quantity</th>
      <th class="">Job Quantity</th>
      <th class="">Uom</th>
  </tr>
  </thead>
  <tbody>
  <?php
  foreach ($req_items as $req_item) {
    $items = $this->m_purchase->getDatas('bud_enquiry_items', 'enq_item_id', $req_item);
    $sno = 1;
    foreach ($items as $item) {
      ?>
      <tr>
          <td><?=$sno; ?></td>
          <td>
            <?=$this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $item['enq_itemgroup'], 'group_name'); ?>
          </td>
          <td>
            <?=$this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item['enq_item'], 'item_name'); ?>
          </td>
          <td class="">
            <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name'); ?>
          </td>
          <td class="">
              <select name="itemlotno[<?=$item['enq_item_id']; ?>]" class="form-control select2">
                <?php
                foreach ($lots as $lot) {
                  $lot_no = $this->m_masters->getmasterIDvalue('bud_machines', 'machine_id', $lot['lot_prefix'], 'machine_prefix').$lot['lot_no'];
                  ?>
                  <option><?=$lot_no; ?></option>
                  <?php
                }
                ?>
              </select>
          </td>
          <td><?=$item['enq_required_qty']; ?></td>
          <td>
            <input class="form-control" style="width:150px;" name="job_quantity[<?=$item['enq_item_id']; ?>]" value="<?=$item['enq_process_qty']; ?>">
          </td>
          <td class="">
            <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_itemuom'], 'uom_name'); ?>
          </td>
        </tr>
      <?php
      $sno++;
    }
  }
  ?>                            
  </tbody>
<?php
}
?>