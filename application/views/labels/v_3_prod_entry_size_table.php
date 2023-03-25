<?php
if(!empty($item_sizes)&&!empty($machine_repeats)){
?>
<table class="form-group">
<thead>
  <td><label>Item Size</label></td>
  <td><label># TAPES </br>STANDERD</label></td>
  <td>
    <label># TAPES </br>RUNNING TODAY</label>
  </td>
  <td>
    <label>METER OP. Reading</label>
  </td>
  <td>
    <label>METER Closing Reading</label>
  </td>
  <td>
    <label>Tot. Physical Prod.</label>
  </td>
</thead>
<?php
//ER-09-18#-54
$mac_repeat=0;
$mac_op_time='';
if ($latest_data) {
  foreach ($latest_data as $lat_data) {
    //ER-09-18#-62
    /*if($lat_data['item_id']!=$item_id)
    {
      continue;
    }*/
    $mac_repeat=($mac_repeat!=$lat_data['no_repts'])?$mac_repeat+$lat_data['no_repts']:$mac_repeat;
  }
}
$machine_repeat=(($machine_repeats-$mac_repeat)<=0)?'':$machine_repeats-$mac_repeat;
//ER-09-18#-54
foreach ($item_sizes as $key => $value) {
  ?>
  <tr>
    <td><strong style="font-size:22px;" name='sizes[]'><?=$value; ?></strong></td>
    <td><strong style="font-size:22px;"><?=$machine_repeats;?></strong></td>
    <td><input class="form-control" id="repts<?=$value;?>" name="no_repts[<?=$value; ?>]" type="text" value="<?=$machine_repeat;?>" required  <?=($machine_repeat)?'':'readonly'?>></td><!--//ER-09-18#-54-->
    <td><input class="form-control opTime" id="op_time<?=$value;?>" name="op_time[<?=$value; ?>]" type="text" length='8' value='<?=$max_mac_cl_time;?>' placeholder="99999.99" required ></td><!--//ER-09-18#-54-->
    <td><input class="form-control opTime" id="cl_time<?=$value;?>"  name="cl_time[<?=$value; ?>]" type="text" length='8' value='<?=$max_mac_cl_time;?>'required placeholder="99999.99"></td><!--//ER-09-18#-54-->
    <td><input class="form-control 
      "  name="pdtn[<?=$value; ?>]" type="text" length='8' value=''required placeholder="99999.999"></td><!--//ER-09-18#-62-->
  </tr>
  <?php
}
}
?>
</table>