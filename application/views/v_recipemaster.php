<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Mosaddek">
  <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <link rel="shortcut icon" href="img/favicon.html">

  <title><?= $page_title; ?> | INDOFILA SYNTHETICS</title>

  <!-- Bootstrap core CSS -->
  <?php
  foreach ($css as $path) {
  ?>
    <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
  <?php
  }
  ?>


  
  
      <?php
      foreach ($js_IE as $path) {
      ?>
        <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
        <?php
      }
        ?>
    
</head>

<body>

  <section id="container" class="">
    <!--header start-->
    <?php $this->load->view('html/v_header.php'); ?>
    <!--header end-->
    <!--sidebar start-->
    <?php $this->load->view('html/v_sidebar.php'); ?>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                <h3><i class="icon-user"></i> Recipe Master</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/recipemaster/<?= $recipe_id; ?>">
              <section class="panel">
                <header class="panel-heading">
                  Recipe No : <label class="btn btn-danger"><strong>RCP<?= $next_recipe; ?></strong></label><br>
                  <!-- Recipe Details -->
                </header>
                <input type="hidden" name="recipe_id" value="<?= $next_recipe; ?>" />
                <div class="panel-body">
                  <?php
                  if ($this->session->flashdata('warning')) {
                  ?>
                    <div class="alert alert-warning fade in">
                      <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="icon-remove"></i>
                      </button>
                      <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                    </div>
                  <?php
                  }
                  if ($this->session->flashdata('error')) {
                  ?>
                    <div class="alert alert-block alert-danger fade in">
                      <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="icon-remove"></i>
                      </button>
                      <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                    </div>
                  <?php
                  }
                  if ($this->session->flashdata('success')) {
                  ?>
                    <div class="alert alert-success alert-block fade in">
                      <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="icon-remove"></i>
                      </button>
                      <h4>
                        <i class="icon-ok-sign"></i>
                        Success!
                      </h4>
                      <p><?= $this->session->flashdata('success'); ?></p>
                    </div>
                  <?php
                  }
                  ?>
                  <div class="form-group col-lg-3">
                    <label for="recipe_category">Recipe Category</label>
                    <select class="select2 form-control" name="recipe_category" id="recipe_category" required>
                      <option value="">Select Category</option>
                      <?php
                      foreach (@$categorymasters as $item) {
                      ?>
                        <option value="<?= $item->category_id; ?>" <?= ($item->category_id == @$recipe_category) ? 'selected="selected"' : ''; ?>><?= $item->category_name; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="shade_name">Shade Name / No</label>
                    <select class="select2 form-control shade" name="shade_id" id="shade_name" required>
                      <option value="">Select Shade</option>
                      <?php
                      foreach ($shades as $shade) {
                      ?>
                        <option value="<?= $shade['shade_id']; ?>" <?= ($shade['shade_id'] == $shade_id) ? 'selected="selected"' : ''; ?>><?= $shade['shade_name']; ?> / <?= $shade['shade_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="shade_code">Shade Code</label>
                    <select class="select2 form-control shade" name="shade_code" id="shade_code" required>
                      <option value="">Select Code</option>
                      <?php
                      foreach ($shades as $shade) {
                      ?>
                        <option value="<?= $shade['shade_id']; ?>" <?= ($shade['shade_id'] == $shade_id) ? 'selected="selected"' : ''; ?>><?= $shade['shade_code']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="shade_denier">Select Item</label>
                    <select class="select2 form-control" name="denier_id" id="shade_denier" required>
                      <option value="">Select From Item Master</option>
                      <?php
                      //$deniers = $this->m_masters->getactivemaster('bud_deniermaster', 'denier_status');
                      foreach ($itemsmaster as $itemm) {
                      ?>
                        <option value="<?= $itemm['item_id']; ?>" <?= ($itemm['item_id'] == $denier_id) ? 'selected="selected"' : ''; ?>><?= $itemm['item_name']; ?> / <?= $itemm['item_id']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="shade_poy_lot">Chandren Yarn Lot No</label>
                    <select class="select2 form-control" name="poy_lot_id" id="shade_poy_lot" required>
                      <option value="">Select Lot No</option>
                      <?php
                      //$poy_lots = $this->m_masters->getactivemaster('bud_poy_lots', 'poy_status');
                      foreach ($clyarn_lots as $cllot) {
                      ?>
                        <option value="<?= $cllot->yarn_lot_id; ?>" <?= ($cllot->yarn_lot_id == $poy_lot_id) ? 'selected="selected"' : ''; ?>><?= $cllot->yarn_lot_no; ?> / <?= $cllot->poy_denier_name; ?> / <?= $cllot->yarn_lot_poyinwardno; ?> / <?= $cllot->yarn_denier; ?> / CL<?= $cllot->yarn_lot_id; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-11">
                    <label for="remarks">SPECIAL INSTRUCTIONS : DEAR OPERATOR : BEFORE STARTING LOT, USE CORRECT MACHINE "PROGRAM NUMBER". IF ANY DOUBT ASK YOUR SUPERVISER</label>
                    <textarea class="form-control" name="remarks" id="remarks"><?= ($remarks) ? $remarks : 'SPECIAL INSTRUCTIONS : DEAR OPERATOR : BEFORE STARTING LOT, USE CORRECT MACHINE "PROGRAM NUMBER". IF ANY DOUBT ASK YOUR SUPERVISER'; ?></textarea>
                  </div>
                </div>
              </section>
              <!-- Start Color Recipes -->
              <section class="panel">
                <header class="panel-heading">
                  <b>Stage 1: START LOT & ADD CHEMICALS</b>
                </header>
                <div class="panel-body">
                  <!-- Loaded Recipe Data -->
                  <?php
                  $dyes_chemicals = $this->m_masters->getactivemaster('bud_dyes_chemicals', 'dyes_chem_status');
                  $uoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
                  ?>
                  <div class="form-group col-lg-3">
                    <label for="chemical_id">Chemicals</label>
                    <select class="select2 form-control" name="chemical_id" id="chemical_id">
                      <option value="">Select Chemical</option>
                      <?php
                      foreach ($dyes_chemicals as $dyes_chemical) {
                      ?>
                        <option value="<?= $dyes_chemical['dyes_chem_id']; ?>"><?= $dyes_chemical['dyes_chem_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="chemical_value">Value</label>
                    <input type="text" class="form-control" name="chemical_value" id="chemical_value">
                  </div>
                  <div class="form-group col-lg-2">
                    <label>UOM</label>
                    <select class="select2 form-control" name="chemical_uom" id="chemical_uom">
                      <option value="">Select UOM</option>
                      <?php
                      foreach ($uoms as $uom) {
                      ?>
                        <option value="<?= $uom['uom_id']; ?>"><?= $uom['uom_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-1">
                    <label for="shade_chemicals">&nbsp;</label>
                    <button type="button" class="form-control btn btn-primary" id="add_chemicals"><i class="icon-plus"></i> Add</button>
                  </div>

                  <div class="col-lg-6">
                    <table class="table table-striped border-top" id="chemicals_Data">
                      <thead>
                        <tr>
                          <th>Chemical</th>
                          <th>Value</th>
                          <th>Uom</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($shade_chemicals) && count($shade_chemicals) > 0) {
                          $row_count = 1;
                          foreach ($shade_chemicals as $chemical) {
                            if (!empty($chemical)) {
                              add_chemicals($row_count, $chemical->chemical_id, $chemical->chemical_name, $chemical->chemical_value, $chemical->chemical_uom, $chemical->chemical_uom_name);
                              $row_count++;
                            }
                          }
                        }
                        function add_chemicals($row_count, $chemical_id, $chemical_name, $chemical_value, $chemical_uom, $chemical_uom_name)
                        {
                          ob_start();
                        ?>
                          <tr>
                            <td>
                              <input type="hidden" name="shade_chemicals[<?= $row_count; ?>][chemical_id]" value="<?= $chemical_id; ?>">
                              <input type="hidden" name="shade_chemicals[<?= $row_count; ?>][chemical_name]" value="<?= $chemical_name; ?>">
                              <input type="hidden" name="shade_chemicals[<?= $row_count; ?>][chemical_value]" value="<?= $chemical_value; ?>">
                              <input type="hidden" name="shade_chemicals[<?= $row_count; ?>][chemical_uom]" value="<?= $chemical_uom; ?>">
                              <input type="hidden" name="shade_chemicals[<?= $row_count; ?>][chemical_uom_name]" value="<?= $chemical_uom_name; ?>">
                              <?= $chemical_name; ?>
                            </td>
                            <td><?= $chemical_value; ?></td>
                            <td><?= $chemical_uom_name; ?></td>
                            <td>
                              <a href="#" class="delete-chemical_row btn btn-xs btn-danger">Delete</a>
                            </td>
                          </tr>
                        <?php
                          $stuff = ob_get_contents();
                          ob_end_clean();
                          echo replace_newline($stuff);
                        }

                        function replace_newline($string)
                        {
                          return trim((string) str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string));
                        }
                        ?>
                      </tbody>
                    </table>
                    <div class="form-group">
                      <label>Temp Setting</label>
                      <input type="text" name="stage1_temp" class="form-control" value="<?= (@$stage1_temp != '') ? @$stage1_temp : 'SELECT CORRECT PROGRAME NO. ADD WATER, UPTO 90° -> 3°/MIN ADD DYES @ 70°'; ?>" />
                    </div>
                    <div class="form-group">
                      <label>Stage1 Instructions To Operator</label>
                      <textarea name="stage1_remarks" class="form-control"><?= $stage1_remarks; ?></textarea>
                    </div>
                  </div>
                </div>
              </section>

              <section class="panel">
                <header class="panel-heading">
                  <b>Stage 2 : Main Dyeing Process</b>
                </header>
                <div class="panel-body" id="recipedata">
                  <!-- Loaded Recipe Data -->
                  <div class="form-group col-lg-3">
                    <label for="dyes_id">ADD DYES</label>
                    <select class="select2 form-control" name="dyes_id" id="dyes_id">
                      <option value="">Select Dyes</option>
                      <?php
                      foreach ($dyes_chemicals as $dyes_chemical) {
                      ?>
                        <option value="<?= $dyes_chemical['dyes_chem_id']; ?>"><?= $dyes_chemical['dyes_chem_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="dyes_value">Value</label>
                    <input type="text" class="form-control" name="dyes_value" id="dyes_value">
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="dyes_uom">UOM</label>
                    <select class="select2 form-control" name="dyes_uom" id="dyes_uom">
                      <option value="">Select UOM</option>
                      <?php
                      foreach ($uoms as $uom) {
                      ?>
                        <option value="<?= $uom['uom_id']; ?>"><?= $uom['uom_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-1">
                    <label for="shade_chemicals">&nbsp;</label>
                    <button type="button" class="form-control btn btn-primary" id="add_dyes"><i class="icon-plus"></i> Add</button>
                  </div>
                  <div class="col-lg-6" id="dyesdata">
                    <table class="table table-striped border-top" id="dyes_Data">
                      <thead>
                        <tr>
                          <th>DYES Name</th>
                          <th>Value</th>
                          <th>Uom</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (count($shade_dyes) > 0) {
                          $row_count = 1;
                          foreach ($shade_dyes as $dyes) {
                            if (!empty($dyes)) {
                              add_dyes($row_count, $dyes->dyes_id, $dyes->dyes_name, $dyes->dyes_value, $dyes->dyes_uom, $dyes->dyes_uom_name);
                              $row_count++;
                            }
                          }
                        }
                        function add_dyes($row_count, $dyes_id, $dyes_name, $dyes_value, $dyes_uom, $dyes_uom_name)
                        {
                          ob_start();
                        ?>
                          <tr>
                            <td>
                              <input type="hidden" name="shade_dyes[<?= $row_count; ?>][dyes_id]" value="<?= $dyes_id; ?>">
                              <input type="hidden" name="shade_dyes[<?= $row_count; ?>][dyes_name]" value="<?= $dyes_name; ?>">
                              <input type="hidden" name="shade_dyes[<?= $row_count; ?>][dyes_value]" value="<?= $dyes_value; ?>">
                              <input type="hidden" name="shade_dyes[<?= $row_count; ?>][dyes_uom]" value="<?= $dyes_uom; ?>">
                              <input type="hidden" name="shade_dyes[<?= $row_count; ?>][dyes_uom_name]" value="<?= $dyes_uom_name; ?>">
                              <?= $dyes_name; ?>
                            </td>
                            <td><?= $dyes_value; ?></td>
                            <td><?= $dyes_uom_name; ?></td>
                            <td>
                              <a href="#" class="delete-dyes_row btn btn-xs btn-danger">Delete</a>
                            </td>
                          </tr>
                        <?php
                          $stuff = ob_get_contents();
                          ob_end_clean();
                          echo replace_newline($stuff);
                        }
                        ?>
                      </tbody>
                    </table>
                    <div class="form-group">
                      <label>Temp Setting</label>
                      <input type="text" name="stage2_temp" class="form-control" value="<?= (@$stage2_temp != '') ? @$stage2_temp : 'UP TO 90° -> 3°/MIN -> HOLD-10 MIN'; ?>" /><br>
                      <input type="text" name="stage2_temp1" class="form-control" value="<?= (@$stage2_temp1 != '') ? @$stage2_temp1 : '90° TO 110° -> 2.5°/MIN -> HOLD-10 MIN'; ?>" /><br>
                      <input type="text" name="stage2_temp2" class="form-control" value="<?= (@$stage2_temp2 != '') ? @$stage2_temp2 : '110° TO 130° -> 2°/MIN -> HOLD-30 MIN'; ?>" /><br>
                    </div>
                    <div class="form-group">
                      <label>SPECIAL INSTRUCTION: DEAR OPERATOR, CHECK THE LOT SAMPLE AFTER 10 MINUTES OF HOLDING, IF THERE IS A RING ON OUTER LAYER OF SPRING, THEN INCREASE HOLD TIME BY 10 MINUTES, SHOW SAMPLE TO YOUR SUPERVISOR, IF APPROVED BY HIM, THEN DRAIN OUT, OTHERWISE ASK FOR ADDITION.</label>
                      <textarea name="stage2_remarks" class="form-control"><?= ($stage2_remarks) ? $stage2_remarks : 'SPECIAL INSTRUCTION: DEAR OPERATOR, CHECK THE LOT SAMPLE AFTER 10 MINUTES OF HOLDING, IF THERE IS A RING ON OUTER LAYER OF SPRING, THEN INCREASE HOLD TIME BY 10 MINUTES, SHOW SAMPLE TO YOUR SUPERVISOR, IF APPROVED BY HIM, THEN DRAIN OUT, OTHERWISE ASK FOR ADDITION.'; ?></textarea>
                    </div>
                  </div>
                </div>
              </section>

              <section class="panel">
                <header class="panel-heading">
                  <b>Stage 3 : R/C Washing</b>
                </header>
                <div class="panel-body" id="recipedata">
                  <!-- Loaded Recipe Data -->
                  <div class="form-group col-lg-3">
                    <label for="stage3_id">RC. Chemicals</label>
                    <select class="select2 form-control" name="stage3_id" id="stage3_id">
                      <option value="">Select Dyes</option>
                      <?php
                      foreach ($dyes_chemicals as $dyes_chemical) {
                      ?>
                        <option value="<?= $dyes_chemical['dyes_chem_id']; ?>"><?= $dyes_chemical['dyes_chem_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="stage3_value">Value</label>
                    <input type="text" class="form-control" name="stage3_value" id="stage3_value">
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="stage3_uom">UOM</label>
                    <select class="select2 form-control" name="stage3_uom" id="stage3_uom">
                      <option value="">Select UOM</option>
                      <?php
                      foreach ($uoms as $uom) {
                      ?>
                        <option value="<?= $uom['uom_id']; ?>"><?= $uom['uom_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-1">
                    <label>&nbsp;</label>
                    <button type="button" class="form-control btn btn-primary" id="add_stage3_row"><i class="icon-plus"></i> Add</button>
                  </div>
                  <div class="col-lg-6" id="dyesdata">
                    <table class="table table-striped border-top" id="stage3_Data">
                      <thead>
                        <tr>
                          <th>Chemical</th>
                          <th>Value</th>
                          <th>Uom</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (count($stage3) > 0) {
                          $row_count = 1;
                          foreach ($stage3 as $dyes) {
                            if (!empty($dyes)) {
                              add_stage3_row($row_count, $dyes->dyes_id, $dyes->dyes_name, $dyes->dyes_value, $dyes->dyes_uom, $dyes->dyes_uom_name);
                              $row_count++;
                            }
                          }
                        }
                        function add_stage3_row($row_count, $dyes_id, $dyes_name, $dyes_value, $dyes_uom, $dyes_uom_name)
                        {
                          ob_start();
                        ?>
                          <tr>
                            <td>
                              <input type="hidden" name="stage3[<?= $row_count; ?>][dyes_id]" value="<?= $dyes_id; ?>">
                              <input type="hidden" name="stage3[<?= $row_count; ?>][dyes_name]" value="<?= $dyes_name; ?>">
                              <input type="hidden" name="stage3[<?= $row_count; ?>][dyes_value]" value="<?= $dyes_value; ?>">
                              <input type="hidden" name="stage3[<?= $row_count; ?>][dyes_uom]" value="<?= $dyes_uom; ?>">
                              <input type="hidden" name="stage3[<?= $row_count; ?>][dyes_uom_name]" value="<?= $dyes_uom_name; ?>">
                              <?= $dyes_name; ?>
                            </td>
                            <td><?= $dyes_value; ?></td>
                            <td><?= $dyes_uom_name; ?></td>
                            <td>
                              <a href="#" class="delete-dyes_row btn btn-xs btn-danger">Delete</a>
                            </td>
                          </tr>
                        <?php
                          $stuff = ob_get_contents();
                          ob_end_clean();
                          echo replace_newline($stuff);
                        }
                        ?>
                      </tbody>
                    </table>
                    <div class="form-group">
                      <label>Washing Note</label>
                      <input type="text" name="stage3_temp" class="form-control" value="<?= (@$stage3_temp != '') ? @$stage3_temp : 'ADD CHEMICAL @ 50° TEMP SPEED @ 3°/MIN WASH UPTO 85° HOLD TIME FOR DARK COLOUR=10 MIN.  FOR LIGHT COLOUR HOLD = 0 MIN'; ?>" />
                    </div>
                    <div class="form-group">
                      <label>Washing Instructions</label>
                      <textarea name="stage3_remarks" class="form-control"><?= $stage3_remarks; ?></textarea>
                    </div>
                  </div>
                </div>
              </section>

              <section class="panel">
                <header class="panel-heading">
                  <b>Stage 4 : Add Softner & Washing</b>
                </header>
                <div class="panel-body" id="recipedata">
                  <!-- Loaded Recipe Data -->
                  <div class="form-group col-lg-3">
                    <label for="stage4_id">ADD SOFTNER</label>
                    <select class="select2 form-control" name="stage4_id" id="stage4_id">
                      <option value="">Select Dyes</option>
                      <?php
                      foreach ($dyes_chemicals as $dyes_chemical) {
                      ?>
                        <option value="<?= $dyes_chemical['dyes_chem_id']; ?>"><?= $dyes_chemical['dyes_chem_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="stage4_value">Value</label>
                    <input type="text" class="form-control" name="stage4_value" id="stage4_value">
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="stage4_uom">UOM</label>
                    <select class="select2 form-control" name="stage4_uom" id="stage4_uom">
                      <option value="">Select UOM</option>
                      <?php
                      foreach ($uoms as $uom) {
                      ?>
                        <option value="<?= $uom['uom_id']; ?>"><?= $uom['uom_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-1">
                    <label>&nbsp;</label>
                    <button type="button" class="form-control btn btn-primary" id="add_stage4_row"><i class="icon-plus"></i> Add</button>
                  </div>
                  <div class="col-lg-6" id="dyesdata">
                    <table class="table table-striped border-top" id="stage4_Data">
                      <thead>
                        <tr>
                          <th>Chemical</th>
                          <th>Value</th>
                          <th>Uom</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (count($stage4) > 0) {
                          $row_count = 1;
                          foreach ($stage4 as $dyes) {
                            if (!empty($dyes)) {
                              add_stage4_row($row_count, $dyes->dyes_id, $dyes->dyes_name, $dyes->dyes_value, $dyes->dyes_uom, $dyes->dyes_uom_name);
                              $row_count++;
                            }
                          }
                        }
                        function add_stage4_row($row_count, $dyes_id, $dyes_name, $dyes_value, $dyes_uom, $dyes_uom_name)
                        {
                          ob_start();
                        ?>
                          <tr>
                            <td>
                              <input type="hidden" name="stage4[<?= $row_count; ?>][dyes_id]" value="<?= $dyes_id; ?>">
                              <input type="hidden" name="stage4[<?= $row_count; ?>][dyes_name]" value="<?= $dyes_name; ?>">
                              <input type="hidden" name="stage4[<?= $row_count; ?>][dyes_value]" value="<?= $dyes_value; ?>">
                              <input type="hidden" name="stage4[<?= $row_count; ?>][dyes_uom]" value="<?= $dyes_uom; ?>">
                              <input type="hidden" name="stage4[<?= $row_count; ?>][dyes_uom_name]" value="<?= $dyes_uom_name; ?>">
                              <?= $dyes_name; ?>
                            </td>
                            <td><?= $dyes_value; ?></td>
                            <td><?= $dyes_uom_name; ?></td>
                            <td>
                              <a href="#" class="delete-dyes_row btn btn-xs btn-danger">Delete</a>
                            </td>
                          </tr>
                        <?php
                          $stuff = ob_get_contents();
                          ob_end_clean();
                          echo replace_newline($stuff);
                        }
                        ?>
                      </tbody>
                    </table>
                    <div class="form-group">
                      <label>Softner Note</label>
                      <input type="text" name="stage4_temp" class="form-control" value="<?= (@$stage4_temp != '') ? @$stage4_temp : 'ADD WATER, ADD SOFT CHEMICAL @ 50° AND WASH UP TO TEMP = 70° FOR ZIP, 65° FOR YARN. TEMP SPEED 3°/MIN'; ?>" />
                    </div>
                    <div class="form-group">
                      <label>SOFTNER TREATMENT, ONLY AFTER SPECIAL INSTRUCTIONS</label>
                      <textarea name="stage4_remarks" class="form-control"><?= $stage4_remarks; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="recipe_status">Active</label>
                      <input class="checkbox" <?= (@$recipe_status == 1) ? 'checked="ckecked"' : ''; ?> value="1" id="recipe_status" name="recipe_status" type="checkbox">
                    </div>
                  </div>
                </div>
              </section>
              <!-- End Color Recipes -->
              <section class="panel">
                <header class="panel-heading">
                  <button class="btn btn-danger" type="submit" name="sumbit" value="sumbit"><?= (@$this->uri->segment(4) == 'duplicate' || @$this->uri->segment(3) == '') ? 'Save' : 'Update'; ?></button>
                  <button class="btn btn-default" type="button">Cancel</button>
                </header>
              </section>
            </form>

            <section class="panel">
              <header class="panel-heading">
                Recipe Master
              </header>
              <div class="panel-body">
                <table class="table table-striped border-top" id="sample_1">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Recipe No</th>
                      <th>Recipe Category</th>
                      <th>Item Name</th>
                      <th>Chandren Yarn Lot No.</th>
                      <th>Color Name / Color ID / Shade Code</th>
                      <th>Chemicals&nbsp;and&nbsp;Temprature</th>
                      <th>Dyes&nbsp;Recipe&nbsp;and&nbsp;Temprature</th>
                      <th>R/C (GPL) / Softner (%)</th>
                      <th>Status</th>
                      <th>Username</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    /*echo "<pre>";
                                print_r($recipe_list);
                                echo "</pre>";*/
                    $sno = 1;
                    foreach ($recipe_list as $row) {
                      $v = @$row->recipe_category;
                      $current = current(array_filter($categorymasters, function ($e) use ($v) {
                        return $e->category_id == $v;
                      }));
                      $category_name = @$current->category_name . ' / ' . $v;
                      $category_prefix = @$current->category_prefix;

                      $x = @$row->denier_id;
                      $currentx = current(array_filter($itemsmaster, function ($e) use ($x) {
                        return $e['item_id'] == $x;
                      }));
                      $itemdata = @$currentx['item_name'] . ' / ' . @$currentx['item_id'];

                      $y = @$row->poy_lot_id;
                      $currenty = current(array_filter($clyarn_lots, function ($e) use ($y) {
                        return $e->yarn_lot_id == $y;
                      }));
                      $lotdata = 'CL' . @$cllot->yarn_lot_id . '<br>' . @$cllot->yarn_lot_no . ' / ' . @$cllot->poy_denier_name . ' / ' . @$cllot->yarn_lot_poyinwardno . ' / ' . @$cllot->yarn_denier;
                    ?>
                      <tr>
                        <td><?= $sno; ?></td>
                        <td>RCP<?= $row->recipe_id; ?> / <?= $category_prefix; ?></td>
                        <td><?= (@$row->recipe_category) ? $category_name : ''; ?><br><br><?= date("d-m-Y H:i:s", strtotime($row->date)); ?></td>
                        <td><?= $itemdata; ?></td>
                        <td>CL<?= $row->poy_lot_id; ?></td>
                        <td><?= $row->shade_name; ?> / <?= $row->shade_id; ?> / <?= $row->shade_code; ?></td>
                        <td>
                          <?php
                          $boxActive = false;
                          $shade_chemicals = @json_decode($row->shade_chemicals);
                          if (!empty($shade_chemicals) && count($shade_chemicals) > 0) {
                            foreach ($shade_chemicals as $chemical) {
                              if (!empty($chemical)) {
                                $boxActive = true;
                                echo $chemical->chemical_name . " - " . $chemical->chemical_value . " " . $chemical->chemical_uom_name . "<br>";
                              }
                            }
                            echo '<br>';
                          }
                          if ($boxActive) {
                          ?>
                            <b>Temp Setting:</b><br>
                            <?= $row->stage1_temp; ?><br><br>
                            <b>CHEMICALS Remarks:</b><br>
                            <?= $row->stage1_remarks; ?>
                          <?php } ?>
                        </td>
                        <td>
                          <div style="font-size: 14px;">
                            <?php
                            $boxActive = false;
                            $shade_dyes = @json_decode($row->shade_dyes);
                            if (!empty($shade_dyes) && count($shade_dyes) > 0) {
                              foreach ($shade_dyes as $dyes) {
                                if (!empty($dyes)) {
                                  $boxActive = true;
                                  echo $dyes->dyes_name . " - " . number_format((float) $dyes->dyes_value, 6, '.', '') . " " . $dyes->dyes_uom_name . "<br>";
                                }
                              }
                              echo '<br>';
                            }
                            if ($boxActive) {
                            ?>
                              <b>Temp Setting:</b><br>
                              <?= $row->stage2_temp; ?><br>
                              <?= $row->stage2_temp1; ?><br>
                              <?= $row->stage2_temp2; ?><br><br>
                              <b>Dyes Remarks:</b><br>
                              <?= $row->stage2_remarks; ?>
                            <?php } ?>
                          </div>
                        </td>
                        <td>
                          <b>R/C:</b>
                          <?php
                          $boxActive = false;
                          $rc_dyes = @json_decode($row->stage3);
                          if (!empty($rc_dyes) && count($rc_dyes) > 0) {
                            foreach ($rc_dyes as $dyes) {
                              if (!empty($dyes)) {
                                $boxActive = true;
                                echo $dyes->dyes_name . " - " . $dyes->dyes_value . " " . $dyes->dyes_uom_name . "<br>";
                              }
                            }
                            echo '<br>';
                          }
                          if ($boxActive) {
                          ?>
                            <b>Washing <i class="icon-pencil"></i>:</b><br>
                            <?= $row->stage3_temp; ?><br>
                            <b>Washing Remarks:</b><br>
                            <?= $row->stage3_remarks; ?>
                            <hr>
                          <?php } ?>
                          <b>Softner:</b>
                          <?php
                          $boxActive = false;
                          $sof_dyes = @json_decode($row->stage4);
                          if (!empty($sof_dyes) && count($sof_dyes) > 0) {
                            foreach ($sof_dyes as $dyes) {
                              if (!empty($dyes)) {
                                $boxActive = true;
                                echo $dyes->dyes_name . " - " . $dyes->dyes_value . " " . $dyes->dyes_uom_name . "<br>";
                              }
                            }
                            echo '<br>';
                          }
                          if ($boxActive) {
                          ?>
                            <b>Softner <i class="icon-pencil"></i>:</b><br>
                            <?= $row->stage4_temp; ?><br>
                            <b>Softner Remarks:</b><br>
                            <?= $row->stage4_remarks; ?>
                          <?php } ?>
                          <?= ($row->remarks != '') ? '<hr>
                          <b>General Remarks:</b><br>' . $row->remarks : ''; ?>
                        </td>
                        <td class="hidden-phone">
                          <span class="<?= ($row->recipe_status == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($row->recipe_status == 1) ? 'On' : 'Off'; ?></span>
                        </td>
                        <td><?= $row->username; ?></td>
                        <td>
                          <a href="<?= base_url(); ?>masters/recipe_print/<?= $row->recipe_id; ?>" class="btn btn-warning btn-xs" target="_blank"><i class="icon-print"></i></a>
                          <a href="<?= base_url(); ?>masters/recipemaster/<?= $row->recipe_id; ?>" class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>
                          <a href="<?= base_url(); ?>masters/recipemaster/<?= $row->recipe_id; ?>/duplicate" class="btn btn-success btn-xs"><i class="icon-copy"></i></a>
                          <a href="<?= base_url(); ?>masters/deleterecipe/<?= $row->recipe_id; ?>" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
                        </td>
                      </tr>
                    <?php
                      $sno++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </section>
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
  </section>

  <!-- js placed at the end of the document so the pages load faster -->
  <?php
  foreach ($js as $path) {
  ?>
    <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
  <?php
  }
  ?>

  <!--common script for all pages-->
  <?php
  foreach ($js_common as $path) {
  ?>
    <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
  <?php
  }
  ?>

  <!--script for this page-->
  <?php
  foreach ($js_thispage as $path) {
  ?>
    <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
  <?php
  }
  ?>

  <script>
    //owl carousel

    $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        navigation: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true

      });
    });

    //custom select box

    $(function() {
      $('select.styled').customSelect();
    });


    $(document).ajaxStart(function() {
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });


    $(function() {
      $("#shade_family").change(function() {
        var shade_family = $('#shade_family').val();
        var url = "<?= base_url(); ?>masters/getfamilydata/" + shade_family;
        // var postData = 'shade_family='+shade_family;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            $("shade_name").select2('destroy');
            $("shade_code").select2('destroy');

            var dataArray = result.split(',');
            var select_text = '<option>Select</option>';
            $("#shade_name").html(select_text + dataArray[0]);
            $("#shade_code").html(select_text + dataArray[1]);

            $("shade_name").select2();
            $("shade_code").select2();
            $("#shade_name").select2("val", ''); //set the value
            $("#shade_code").select2("val", ''); //set the value
          }
        });
        return false;
      });
    });

    $("#add_chemicals").click(function() {
      var rowCount = $('#chemicals_Data tr').length;

      var chemical_id = $("#chemical_id").val();
      var chemical_name = $("#chemical_id option:selected").text();
      var chemical_value = $("#chemical_value").val();
      var chemical_uom = $("#chemical_uom").val();
      var chemical_uom_name = $("#chemical_uom option:selected").text();

      var chemicals_row = '<?php add_chemicals("'+rowCount+'", "'+chemical_id+'", "'+chemical_name+'", "'+chemical_value+'", "'+chemical_uom+'", "'+chemical_uom_name+'"); ?>';
      $("#chemicals_Data").append(chemicals_row);
      // Clear All Data
      $("#chemical_id").select2('val', '');
      $("#chemical_value").val('');
      $("#chemical_uom").select2('val', '');
    });

    $('body').on('click', '.delete-chemical_row', function() {
      if (confirm('Do you want to delete')) {
        $(this).closest("tr").remove();
      }
      return false;
    });

    $("#add_dyes").click(function() {
      var rowCount = $('#dyes_Data tr').length;

      var dyes_id = $("#dyes_id").val();
      var dyes_name = $("#dyes_id option:selected").text();
      var dyes_value = $("#dyes_value").val();
      var dyes_uom = $("#dyes_uom").val();
      var dyes_uom_name = $("#dyes_uom option:selected").text();

      var dyes_row = '<?php add_dyes("'+rowCount+'", "'+dyes_id+'", "'+dyes_name+'", "'+dyes_value+'", "'+dyes_uom+'", "'+dyes_uom_name+'"); ?>';
      $("#dyes_Data").append(dyes_row);

      // Clear Data
      $("#dyes_id").select2('val', '');
      $("#dyes_value").val('');
      $("#dyes_uom").select2('val', '');
    });

    $("#add_stage3_row").click(function() {
      var rowCount = $('#stage3_Data tr').length;

      var dyes_id = $("#stage3_id").val();
      var dyes_name = $("#stage3_id option:selected").text();
      var dyes_value = $("#stage3_value").val();
      var dyes_uom = $("#stage3_uom").val();
      var dyes_uom_name = $("#stage3_uom option:selected").text();

      var dyes_row = '<?php add_stage3_row("'+rowCount+'", "'+dyes_id+'", "'+dyes_name+'", "'+dyes_value+'", "'+dyes_uom+'", "'+dyes_uom_name+'"); ?>';
      $("#stage3_Data").append(dyes_row);

      // Clear Data
      $("#stage3_id").select2('val', '');
      $("#stage3_value").val('');
      $("#stage3_uom").select2('val', '');
    });

    $("#add_stage4_row").click(function() {
      var rowCount = $('#stage4_Data tr').length;

      var dyes_id = $("#stage4_id").val();
      var dyes_name = $("#stage4_id option:selected").text();
      var dyes_value = $("#stage4_value").val();
      var dyes_uom = $("#stage4_uom").val();
      var dyes_uom_name = $("#stage4_uom option:selected").text();

      var dyes_row = '<?php add_stage4_row("'+rowCount+'", "'+dyes_id+'", "'+dyes_name+'", "'+dyes_value+'", "'+dyes_uom+'", "'+dyes_uom_name+'"); ?>';
      $("#stage4_Data").append(dyes_row);

      // Clear Data
      $("#stage4_id").select2('val', '');
      $("#stage4_value").val('');
      $("#stage4_uom").select2('val', '');
    });

    $('body').on('click', '.delete-dyes_row', function() {
      if (confirm('Do you want to delete')) {
        $(this).closest("tr").remove();
      }
      return false;
    });

    $(".shade").change(function() {
      $("#shade_name").select2("val", $(this).val());
      $("#shade_code").select2("val", $(this).val());
    });
  </script>

</body>

</html>