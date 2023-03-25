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
                <h3><i class="icon-map-marker"></i> Machine Master</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Category Details
              </header>

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
                <?php
                if (isset($machine_id)) {
                  $editmachine = $this->m_masters->getmasterdetails('bud_machines', 'machine_id', $machine_id);
                  foreach ($editmachine as $machine) {
                    $machine_id = $machine['machine_id'];
                    $machine_category = $machine['machine_category'];
                    $machine_prefix = $machine['machine_prefix'];
                    $machine_status = $machine['machine_status'];
                    $machine_name = @$machine['machine_name'];
                    $machine_production_capacity = @$machine['machine_production_capacity'];
                    $machine_water_capacity = @$machine['machine_water_capacity'];
                    $dyeing_machine_program_nos = @$machine['dyeing_machine_program_nos'];
                    $for_dyeing = @$machine['for_dyeing'];
                    $for_r_c = @$machine['for_r_c'];
                    $for_softner = @$machine['for_softner'];
                    $for_washing = @$machine['for_washing'];
                    $for_redyeing = @$machine['for_redyeing'];
                    $for_special_process = @$machine['for_special_process'];
                    $machine_production_capacity_lots = @$machine['machine_production_capacity_lots'];
                    $machine_production_capacity_kgs = @$machine['machine_production_capacity_kgs'];
                    $spindels_per_machine = @$machine['spindels_per_machine'];
                    $remarks = @$machine['remarks'];
                  }
                  $action = 'updatemachine';
                } else {
                  $machine_id = '';
                  $machine_category = '';
                  $machine_prefix = '';
                  $machine_status = '';
                  $machine_name = '';
                  $machine_production_capacity = '';
                  $machine_water_capacity = '';
                  $action = 'savemachine';
                  $dyeing_machine_program_nos = '';
                  $for_dyeing = '';
                  $for_r_c = '';
                  $for_softner = '';
                  $for_washing = '';
                  $for_redyeing = '';
                  $for_special_process = '';
                  $machine_production_capacity_lots = '';
                  $machine_production_capacity_kgs = '';
                  $spindels_per_machine = '';
                  $remarks = '';
                }
                ?>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>masters/<?= $action; ?>">
                  <input type="hidden" name="machine_id" value="<?= $machine_id; ?>">

                  <div class="row">

                    <div class="form-group col-lg-3">
                      <div class="col-lg-12">
                        <label for="machine_category">Select Machine Department</label><br>
                        <select class="form-control m-bot15" name="machine_category" id="machine_category">
                          <option value="0">Select Category</option>
                          <?php
                          foreach ($departments as $department) {
                          ?>
                            <option value="<?= $department['dept_id']; ?>" <?= ($machine_category == $department['dept_id']) ? 'selected="selected"' : ''; ?>><?= $department['dept_name']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group col-lg-3">
                      <div class="col-lg-12">
                        <label for="machine_prefix">Machine Prefix</label><br>
                        <input class="form-control" id="machine_prefix" name="machine_prefix" value="<?= $machine_prefix; ?>" type="text" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-3">
                      <div class="col-lg-12">
                        <label for="machine_name">Machine Name</label><br>
                        <input class="form-control" id="machine_name" name="machine_name" value="<?= @$machine_name; ?>" type="text" required>
                      </div>
                    </div>

                  </div>
                  <div class="row">

                    <div class="form-group col-lg-4">
                      <div class="col-lg-12">
                        <label for="machine_production_capacity">Machine Production Capacity 100% in Kgs.</label><br>
                        <input class="form-control" id="machine_production_capacity" name="machine_production_capacity" value="<?= @$machine_production_capacity; ?>" type="number" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-4">
                      <div class="col-lg-12">
                        <label for="machine_water_capacity">Machine Water Capacity 100% in Ltrs.</label><br>
                        <input class="form-control" id="machine_water_capacity" name="machine_water_capacity" value="<?= @$machine_water_capacity; ?>" type="number" required>
                      </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                      <div class="col-lg-12">
                        <label for="dyeing_machine_program_nos">Dyeing Machine Program Nos.</label><br>
                      </div>
                    </div>
                  </div>
                  <div class="row">

                    <div class="form-group col-lg-2">
                      <div class="col-lg-12">
                        <label for="for_dyeing">For Dyeing</label><br>
                        <input class="form-control" id="for_dyeing" name="for_dyeing" value="<?= @$for_dyeing; ?>" type="number" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-2">
                      <div class="col-lg-12">
                        <label for="for_r_c">For R/C</label><br>
                        <input class="form-control" id="for_r_c" name="for_r_c" value="<?= @$for_r_c; ?>" type="number" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-2">
                      <div class="col-lg-12">
                        <label for="for_softner">For Softner</label><br>
                        <input class="form-control" id="for_softner" name="for_softner" value="<?= @$for_softner; ?>" type="number" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-2">
                      <div class="col-lg-12">
                        <label for="for_washing">For Washing</label><br>
                        <input class="form-control" id="for_washing" name="for_washing" value="<?= @$for_washing; ?>" type="number" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-2">
                      <div class="col-lg-12">
                        <label for="for_redyeing">For ReDyeing</label><br>
                        <input class="form-control" id="for_redyeing" name="for_redyeing" value="<?= @$for_redyeing; ?>" type="number" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-2">
                      <div class="col-lg-12">
                        <label for="for_special_process">For Special Process</label><br>
                        <input class="form-control" id="for_special_process" name="for_special_process" value="<?= @$for_special_process; ?>" type="number" required>
                      </div>
                    </div>

                  </div>
                  <div class="row">

                    <div class="form-group col-lg-3">
                      <div class="col-lg-12">
                        <label for="machine_production_capacity_lots">Machine Production Capacity In # LOTS</label><br>
                        <input class="form-control" id="machine_production_capacity_lots" name="machine_production_capacity_lots" value="<?= @$machine_production_capacity_lots; ?>" type="number" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-3">
                      <div class="col-lg-12">
                        <label for="machine_production_capacity_kgs">Machine Production Capacity In KGS</label><br>
                        <input class="form-control" id="machine_production_capacity_kgs" name="machine_production_capacity_kgs" value="<?= @$machine_production_capacity_kgs; ?>" type="number" required>
                      </div>
                    </div>

                    <div class="form-group col-lg-2">
                      <div class="col-lg-12">
                        <label for="spindels_per_machine"># Spindels Per Machine</label><br>
                        <input class="form-control" id="spindels_per_machine" name="spindels_per_machine" value="<?= @$spindels_per_machine; ?>" type="number" required>
                      </div>
                    </div>

                  </div>
                  <div class="row">

                    <div class="form-group col-lg-6">
                      <div class="col-lg-12">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks"><?= @$remarks; ?></textarea>
                      </div>
                    </div>

                  </div>
                  <div class="row">

                    <div class="form-group col-lg-6">
                      <label for="machine_status" class="control-label col-lg-3">Active</label>
                      <div class="col-lg-3">
                        <input type="checkbox" style="width: 20px;float:left;" <?= ($machine_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="machine_status" name="machine_status" />
                      </div>
                    </div>

                  </div>

                  <div class="clear"></div>

                  <div class="row">

                    <div class="form-group col-lg-12">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-danger" type="submit"><?= ($machine_id != '') ? 'Update' : 'Save'; ?></button>
                        <button class="btn btn-default" type="button">Cancel</button>
                      </div>
                    </div>

                  </div>

                </form>
              </div>
            </section>

            <!-- Start Talbe List  -->
            <section class="panel">
              <header class="panel-heading">
                Categories
              </header>
              <table class="table table-striped border-top" id="sample_1">
                <thead>
                  <tr>
                    <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                    <th>Sno</th>
                    <th>Dept.</th>
                    <th>Machine Prefix</th>
                    <th>Machine Name</th>
                    <th>Dyeing Mach. Program Nos.</th>
                    <th>M/C PRODC. in Lots in one Shift</th>
                    <th>M/C PRODC. in Kgs in one Shift</th>
                    <th># Spindels Per M/C</th>
                    <th>M/C Max. PRODC. Capacity in Kgs.</th>
                    <th>M/C Max. Water Capacity in Ltrs.</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th class="hidden-phone"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno = 1;
                  foreach ($machines as $machine) {

                    $v = $machine['machine_category'];
                    $current = current(array_filter($departments, function ($e) use ($v) {
                      return $e['dept_id'] == $v;
                    }));
                    $dept_name = @$current['dept_name'];

                  ?>
                    <tr class="odd gradeX">
                      <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                      <td><?= $sno; ?></td>
                      <td><?= $dept_name ?></td>
                      <td><?= $machine['machine_prefix'] ?></td>
                      <td><?= $machine['machine_name'] ?></td>
                      <td><?= $machine['for_dyeing']; ?> / <?= $machine['for_r_c']; ?> / <?= $machine['for_softner']; ?> / <?= $machine['for_washing']; ?> / <?= $machine['for_redyeing']; ?> / <?= $machine['for_special_process']; ?></td>
                      <td><?= $machine['machine_production_capacity_lots'] ?></td>
                      <td><?= $machine['machine_production_capacity_kgs'] ?></td>
                      <td><?= $machine['spindels_per_machine'] ?></td>
                      <td><?= $machine['machine_production_capacity'] ?></td>
                      <td><?= $machine['machine_water_capacity'] ?></td>
                      <td><?= $machine['remarks'] ?></td>
                      <td class="hidden-phone">
                        <span class="<?= ($machine['machine_status'] == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($machine['machine_status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                      </td>
                      <td>
                        <a href="<?= base_url(); ?>masters/machines/<?= $machine['machine_id'] ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                        <a href="<?= base_url(); ?>masters/deletemachine/<?= $machine['machine_id'] ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
                      </td>
                    </tr>
                  <?php
                    $sno++;
                  }
                  ?>
                </tbody>
              </table>
            </section>
            <!-- End Talbe List  -->
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
  </script>

</body>

</html>