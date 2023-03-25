<?php
foreach ($colorcombos as $colorcombo) {
  $shade_name = explode(",", $colorcombo['shade_name']);
  $denier = explode(",", $colorcombo['denier']);
  $no_ends = explode(",", $colorcombo['no_ends']);
  $no_beams = explode(",", $colorcombo['no_beams']);
  $beams_qty = explode("|", $colorcombo['beams_qty']);
  $ends_heald = explode(",", $colorcombo['ends_heald']);
  $healds_dent = explode(",", $colorcombo['healds_dent']);
  $design_weave = explode(",", $colorcombo['design_weave']);
  $net_weight = explode(",", $colorcombo['net_weight']);
  $percentage = explode(",", $colorcombo['percentage']);

  for ($i=0; $i < 5; $i++) { 
    $percentage[$i] = (array_key_exists($i, $percentage) && $percentage[$i] != '')?$percentage[$i]:'12';                $net_weight[$i] = (isset($net_weight[$i]))?$net_weight[$i]:'';
    $no_beams[$i] = (array_key_exists($i, $no_beams) && $no_beams[$i] != '')?$no_beams[$i]:'1';
    $ends_heald[$i] = (array_key_exists($i, $ends_heald) && $ends_heald[$i] != '')?$ends_heald[$i]:'0';
    $healds_dent[$i] = (array_key_exists($i, $healds_dent) && $healds_dent[$i] != '')?$healds_dent[$i]:'0';
    $design_weave[$i] = (array_key_exists($i, $design_weave) && $design_weave[$i] != '')?$design_weave[$i]:'0';
  }
}
?>
<h3>Color Combo - Warp Plan</h3>
<table class="table table-striped border-top" id="tbl">
  <thead>
  <tr>
      <th>Sno</th>
      <th>Color &amp; # of Ends</th>
      <th>Shade No</th>
      <th>Denier</th>
      <th>Beam Break up</th>
      <th>Total Meters Req</th>
      <th># of Tapes</th>
      <th>Maters</th>
      <th># of Beams</th>
      <th>Yarn Consumed</th>
      <th>Yarn in Stock</th>
      <th>Bal.Stock</th>
  </tr>
  </thead>
  <tbody>
    <?php
    foreach ($shade_name as $key => $value) {
      for ($i=0; $i < $no_beams[$key]; $i++) {
        $beams_qty_arr = explode(",", $beams_qty[$key]);
        if($i < 1)
        {
          ?>
          <tr>
            <td><?=$key+1; ?></td>
            <td>
              <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $value, 'shade_name'); ?>(<?=$no_ends[$key]; ?>)
            </td>
            <td>
              <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $value, 'shade_code'); ?>
            </td>
            <td>
              <?=$this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $denier[$key], 'denier_name'); ?>
            </td>
            <td><?=$beams_qty_arr[$i]; ?></td>
            <td><?=$job_warping_qty; ?></td>
            <td><span class="job_no_tapes"><?=$job_no_tapes; ?></span></td>
            <td><?=$job_warping_qty; ?></td>
            <td><span class="job_no_tapes"><?=$job_no_tapes; ?></span></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <?php
        }
        else
        {
          ?>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?=$beams_qty_arr[$i]; ?></td>
            <td><?=$job_warping_qty; ?></td>
            <td><span class="job_no_tapes"><?=$job_no_tapes; ?></span></td>
            <td><?=$job_warping_qty; ?></td>
            <td><span class="job_no_tapes"><?=$job_no_tapes; ?></span></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <?php
        }      }
    }
    ?>                       
  </tbody>
</table>