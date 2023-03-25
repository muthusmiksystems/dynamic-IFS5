<?php
foreach ($shades as $shade) {
  $shade_holding = $shade['shade_holding'];
  $shade_dyes = explode(',', $shade['shade_dyes']);
  $shade_chemicals = explode(',', $shade['shade_chemicals']);
  $shade_chemical_uoms = explode(',', $shade['shade_chemical_uoms']);
  $shade_temperatures = explode(',', $shade['shade_temperatures']);
}
?>
<div class="form-group col-lg-4">
  <label for="primary_contactno">Dyes</label>
  <div class="input-group">
  <input class="form-control"  name="dyes[]" value="<?=(isset($shade_dyes[0]))?$shade_dyes[0]:''; ?>" type="text" placeholder="Dyes 1">
  <span class="input-group-addon">%</span>
  </div>
  </div>
  <div class="form-group col-lg-4">
  <label for="primary_contactno">Dyes</label>
  <div class="input-group">
  <input class="form-control"  name="dyes[]" value="<?=(isset($shade_dyes[1]))?$shade_dyes[1]:''; ?>" type="text" placeholder="Dyes 1">
  <span class="input-group-addon">%</span>
  </div>
  </div>
  <div class="form-group col-lg-4">
  <label for="primary_contactno">Dyes</label>
  <div class="input-group">
  <input class="form-control"  name="dyes[]" value="<?=(isset($shade_dyes[2]))?$shade_dyes[2]:''; ?>" type="text" placeholder="Dyes 1">
  <span class="input-group-addon">%</span>
  </div>
  </div>
  <div class="form-group col-lg-4">
  <label for="primary_contactno">Chemical 1</label>
  <div class="input-group">
  <input class="form-control"  name="chemicals[]" value="<?=(isset($shade_chemicals[0]))?$shade_chemicals[0]:''; ?>" type="text" placeholder="Chemical 1">
  <span class="input-group-addon">
    <select class="shade_uoms" name="chemical_uoms[]">
    <option value="">Unit</option>
    <?php
    if($shade_id != '')
    {
      $itemuoms = $this->m_masters->getactiveCdatas('bud_uoms', 'uom_status', 'uom_category', $shade_category);
      foreach ($itemuoms as $itemuom) {
        ?>
        <option value="<?=$itemuom['uom_id']; ?>" <?=(isset($shade_chemical_uoms[0]) && $shade_chemical_uoms[0] == $itemuom['uom_id'])?'selected="selected"':''; ?> ><?=$itemuom['uom_name']; ?></option>
        <?php
      }
    }
    ?>
    </select>
  </span>
  </div>                                           
  </div>
  <div class="form-group col-lg-4">
  <label for="primary_contactno">Chemical 2</label>
  <div class="input-group">
  <input class="form-control"  name="chemicals[]" value="<?=(isset($shade_chemicals[1]))?$shade_chemicals[1]:''; ?>" type="text" placeholder="Chemical 2">
  <span class="input-group-addon">
    <select class="shade_uoms" name="chemical_uoms[]">
    <option value="">Unit</option>
    <?php
    if($shade_id != '')
    {
      $itemuoms = $this->m_masters->getactiveCdatas('bud_uoms', 'uom_status', 'uom_category', $shade_category);
      foreach ($itemuoms as $itemuom) {
        ?>
        <option value="<?=$itemuom['uom_id']; ?>" <?=(isset($shade_chemical_uoms[1]) && $shade_chemical_uoms[1] == $itemuom['uom_id'])?'selected="selected"':''; ?> ><?=$itemuom['uom_name']; ?></option>
        <?php
      }
    }
    ?>
    </select>
  </span>
  </div>
  </div>
  <div class="form-group col-lg-4">
  <label for="primary_contactno">Chemical 3</label>
  <div class="input-group">
  <input class="form-control"  name="chemicals[]" value="<?=(isset($shade_chemicals[2]))?$shade_chemicals[2]:''; ?>" type="text" placeholder="Chemical 3">
  <span class="input-group-addon">
    <select class="shade_uoms" name="chemical_uoms[]">
    <option value="">Unit</option>
    <?php
    if($shade_id != '')
    {
      $itemuoms = $this->m_masters->getactiveCdatas('bud_uoms', 'uom_status', 'uom_category', $shade_category);
      foreach ($itemuoms as $itemuom) {
        ?>
        <option value="<?=$itemuom['uom_id']; ?>" <?=(isset($shade_chemical_uoms[2]) && $shade_chemical_uoms[2] == $itemuom['uom_id'])?'selected="selected"':''; ?> ><?=$itemuom['uom_name']; ?></option>
        <?php
      }
    }
    ?>
    </select>
  </span>
  </div>
  </div>
  <div class="form-group col-lg-4">
  <label for="primary_contactno">Temperature (40&deg; - 90&deg;)</label>
  <div class="input-group">
  <input class="form-control"  name="temperatures[]" value="<?=(isset($shade_temperatures[0]))?$shade_temperatures[0]:''; ?>" type="text" placeholder="">
  <span class="input-group-addon">Min</span>
  </div>
  </div>
  <div class="form-group col-lg-4">
  <label for="primary_contactno">Temperature (90&deg; - 110&deg;)</label>
  <div class="input-group">
  <input class="form-control"  name="temperatures[]" value="<?=(isset($shade_temperatures[1]))?$shade_temperatures[1]:''; ?>" type="text" placeholder="">
  <span class="input-group-addon">Min</span>
  </div>
  </div>
  <div class="form-group col-lg-4">
  <label for="primary_contactno">Temperature (110&deg; - 130&deg;)</label>
  <div class="input-group">
  <input class="form-control"  name="temperatures[]" value="<?=(isset($shade_temperatures[2]))?$shade_temperatures[2]:''; ?>" type="text" placeholder="">
  <span class="input-group-addon">Min</span>
  </div>
  </div>
  <div class="form-group col-lg-4">
  <label for="shade_holding">Holding</label>
  <div class="input-group">
    <input class="form-control"  name="shade_holding" id="shade_holding" value="<?=$shade_holding; ?>" type="text" placeholder="">
    <span class="input-group-addon">Min</span>
  </div>
</div>