<thead>
<!-- <tr>
    <th>Balance</th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
</tr> -->
<tr>
    <th>#</th>
    <th>Reference</th>
    <th>Date</th>
    <th>Debit/Credit</th>
    <th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$sno = 1;
$balance = 0;
foreach ($payments as $payment) {
  if($payment['payment_type'] == '+')
  {
    $balance += $payment['payment_amount'];
  }
  else
  {
    $balance -= $payment['payment_amount'];
  }
  ?>
  <tr>
    <td><?=$sno; ?></td>
    <td><?=$payment['payment_reference']; ?></td>
    <td><?=$payment['payment_date']; ?></td>
    <td><?=($payment['payment_type'] == '+')?'Credit':'Debit'; ?></td>
    <td><?=$payment['payment_amount']; ?></td>
  </tr>
  <?php
  $sno++;
}
?>
<tr>
  <td></td>
  <td></td>
  <td></td>
  <td><strong>Balance</strong></td>
  <td><strong><?=$balance; ?></strong></td>
</tr>                          
</tbody>