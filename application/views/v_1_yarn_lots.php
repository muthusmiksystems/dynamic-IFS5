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
                <h3><i class="icon-user"></i> SDS Yarn Lot No Master (By Chandren)</h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <?php
            if (isset($yarn_lot_id)) {
              $editpoylots = $this->m_masters->getmasterdetails('bud_yarn_lots', 'yarn_lot_id', $yarn_lot_id);
              foreach ($editpoylots as $yarn_lot) {
                $yarn_denier = $yarn_lot['yarn_denier'];
                $yarn_lot_name = $yarn_lot['yarn_lot_name'];
                $yarn_lot_no = $yarn_lot['yarn_lot_no'];
                $yarn_reorder = $yarn_lot['yarn_reorder'];
                $yarn_lot_uom = $yarn_lot['yarn_lot_uom'];
                $yarn_status = $yarn_lot['yarn_status'];
                $poy_denier_id = $yarn_lot['poy_denier_id'];

                $yarn_lot_machinespeed = $yarn_lot['yarn_lot_machinespeed'];
                $yarn_lot_dy = $yarn_lot['yarn_lot_dy'];
                $yarn_lot_draw = $yarn_lot['yarn_lot_draw'];
                $yarn_lot_sos = $yarn_lot['yarn_lot_sos'];
                $yarn_lot_takeuphardwind = $yarn_lot['yarn_lot_takeuphardwind'];
                $yarn_lot_takeupsoftwind = $yarn_lot['yarn_lot_takeupsoftwind'];
                $yarn_lot_primarytemp = $yarn_lot['yarn_lot_primarytemp'];
                $yarn_lot_secondarytemp = $yarn_lot['yarn_lot_secondarytemp'];
                $yarn_lot_cpmhardwind = $yarn_lot['yarn_lot_cpmhardwind'];
                $yarn_lot_cpmsoftwind = $yarn_lot['yarn_lot_cpmsoftwind'];
                $yarn_lot_rottopresher = $yarn_lot['yarn_lot_rottopresher'];
                $yarn_lot_remarks = $yarn_lot['yarn_lot_remarks'];
                $yarn_lot_poyinwardno = $yarn_lot['yarn_lot_poyinwardno'];
              }
            } else {
              $yarn_lot_id = '';
              $yarn_denier = '';
              $yarn_lot_name = '';
              $yarn_lot_no = '';
              $yarn_reorder = '';
              $yarn_lot_uom = '';
              $yarn_status = '';
              $poy_denier_id = '';

              $yarn_lot_machinespeed = '0';
              $yarn_lot_dy = '0';
              $yarn_lot_draw = '0.000';
              $yarn_lot_sos = '0';
              $yarn_lot_takeuphardwind = '0';
              $yarn_lot_takeupsoftwind = '0';
              $yarn_lot_primarytemp = '0';
              $yarn_lot_secondarytemp = '0';
              $yarn_lot_cpmhardwind = '0';
              $yarn_lot_cpmsoftwind = '0';
              $yarn_lot_rottopresher = '0';
              $yarn_lot_remarks = '';
              $yarn_lot_poyinwardno = '';
            }
            $yarn_deniers = $this->m_masters->getmasterdetails('bud_yt_yarndeniers', 'denier_status', '1');
            ?>
            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>poy/yarn_lots_save">
              <section class="panel">

                <header class="panel-heading">
                  Yarn Lot Details
                </header>

                <header class="panel-heading">
                  <div class="form-group col-lg-4">
                    <label>Yarn Lot No : </label>
                    <?php
                    $box_no = sizeof($yarn_lots) + 1;
                    if (isset($yarn_lot_id) && $yarn_lot_id != '') {
                      if (@$this->uri->segment(4) == 'edit') {
                        $box_no = $yarn_lot_id;
                      }
                    }
                    ?>
                    <span class="label label-danger" style="padding: 0 1em;font-size:24px;">CL<?= $box_no; ?></span>
                  </div>
                  <div class="form-group col-lg-8">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-danger">Supplier Name</th>
                          <th class="text-danger">Poy Denier</th>
                          <th class="text-danger">Poy Lot No</th>
                          <th class="text-danger">Inward Qty.</th>
                          <th class="text-danger">Tot. Packed Qty.</th>
                          <th class="text-danger">Tot. Balancd Qty.</th>
                          <th class="text-danger">Tot. Wastage Qty.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span class="supplier_name"></span></td>
                          <td><span class="poy_denier"></span></td>
                          <td><span class="poy_lot_no"></span></td>
                          <td><span class="inward_qty"></span></td>
                          <td><span class="tot_packed_qty"></span></td>
                          <td><span class="tot_balancd_qty"></span></td>
                          <td><span class="tot_wastage_qty"></span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
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
                  <input type="hidden" name="yarn_lot_id_new" value="<?= $box_no; ?>">
                  <input type="hidden" name="yarn_lot_id" value="<?= $box_no; ?>">

                  <div class="form-group col-lg-4">
                    <label for="poy_lot_no" class="control-label col-lg-4">Chandren Yarn Lot No</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_no" name="yarn_lot_no" value="<?= $yarn_lot_no; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="poy_denier_id" class="control-label col-lg-4">POY Denier</label>
                    <div class="col-lg-8">
                      <select class="select2 form-control" id="poy_denier_id" name="poy_denier_id" required>
                        <option value="">Select POY Denier</option>
                        <?php if (sizeof($poy_deniers) > 0) : ?>
                          <?php foreach ($poy_deniers as $poy_denier) : ?>
                            <option value="<?php echo $poy_denier->denier_id; ?>" <?php echo ($poy_denier->denier_id == $poy_denier_id) ? 'selected="selected"' : ''; ?>><?php echo $poy_denier->denier_name; ?> / <?php echo $poy_denier->denier_id; ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_poyinwardno" class="control-label col-lg-4">Poy Inward No</label>
                    <div class="col-lg-8">
                      <select class="form-control select2" name="yarn_lot_poyinwardno" id="yarn_lot_poyinwardno">
                        <option value="">Select</option>
                        <?php if (sizeof($poy_inwards) > 0) : ?>
                          <?php foreach ($poy_inwards as $row) { ?>
                            <option value="<?= $row->po_no; ?>" <?= ($row->po_no == @$yarn_lot_poyinwardno) ? 'selected="selected"' : ''; ?>><?= $row->po_no; ?></option>
                          <?php } ?>
                        <?php endif; ?>
                      </select>
                    </div>
                  </div>

                  <div style="clear:both"></div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_machinespeed" class="control-label col-lg-4">Machine Speed @Hz</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_machinespeed" name="yarn_lot_machinespeed" value="<?= $yarn_lot_machinespeed; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_dy" class="control-label col-lg-4">DY</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_dy" name="yarn_lot_dy" value="<?= @$yarn_lot_dy; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_draw" class="control-label col-lg-4">Draw</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_draw" name="yarn_lot_draw" value="<?= $yarn_lot_draw; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_sos" class="control-label col-lg-4">SOS</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_sos" name="yarn_lot_sos" value="<?= @$yarn_lot_sos; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_takeuphardwind" class="control-label col-lg-4">Take Up Hard Wind</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_takeuphardwind" name="yarn_lot_takeuphardwind" value="<?= @$yarn_lot_takeuphardwind; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_takeupsoftwind" class="control-label col-lg-4">Take Up Soft Wind</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_takeupsoftwind" name="yarn_lot_takeupsoftwind" value="<?= @$yarn_lot_takeupsoftwind; ?>" type="text" required>
                    </div>
                  </div>


                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_primarytemp" class="control-label col-lg-4">Primary Temp.</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_primarytemp" name="yarn_lot_primarytemp" value="<?= $yarn_lot_primarytemp; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_secondarytemp" class="control-label col-lg-4">Secondary Temp.</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_secondarytemp" name="yarn_lot_secondarytemp" value="<?= $yarn_lot_secondarytemp; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_cpmhardwind" class="control-label col-lg-4">CPM (Hard Wind)</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_cpmhardwind" name="yarn_lot_cpmhardwind" value="<?= @$yarn_lot_cpmhardwind; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_cpmsoftwind" class="control-label col-lg-4">CPM (Soft Wind)</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_cpmsoftwind" name="yarn_lot_cpmsoftwind" value="<?= @$yarn_lot_cpmsoftwind; ?>" type="text" required>
                    </div>
                  </div>

                  <div class="form-group col-lg-4">
                    <label for="yarn_lot_rottopresher" class="control-label col-lg-4">Rotto Presser</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_lot_rottopresher" name="yarn_lot_rottopresher" value="<?= @$yarn_lot_rottopresher; ?>" type="text" required>
                    </div>
                  </div>

                  <div style="clear:both"></div>

                  <div class="form-group col-lg-4">
                    <label for="poy_denier" class="control-label col-lg-4">Final Yarn Denier</label>
                    <div class="col-lg-8">
                      <input class="form-control" id="yarn_denier" name="yarn_denier" value="<?= @$yarn_denier; ?>" type="text" required>
                      <?php /* <select class="select2 form-control" id="yarn_denier" name="yarn_denier" required>
                        <?php
                        foreach ($yarn_deniers as $row) {
                        ?>
                          <option value="<?= $row['denier_id']; ?>" <?= ($row['denier_id'] == $yarn_denier) ? 'selected="selected"' : ''; ?>><?= $row['denier_name']; ?> / <?= $row['denier_id']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      */ ?>
                    </div>
                  </div>

                  <div style="clear:both"></div>

                  <div class="form-group col-lg-8">
                    <label for="yarn_lot_remarks" class="control-label col-lg-2">Remarks</label>
                    <div class="col-lg-10">
                      <textarea name="yarn_lot_remarks" id="yarn_lot_remarks" class="form-control" style="resize: vertical;" required="required"><?= $yarn_lot_remarks; ?></textarea>
                    </div>
                  </div>

                  <div style="clear:both"></div>

                  <?php
                  /* <div class="form-group col-lg-12">
                      <label for="poy_reorder" class="control-label col-lg-2">Re-order Level</label>
                      <div class="col-lg-10">
                        <input class="form-control" id="yarn_reorder" name="yarn_reorder" value="<?= $yarn_reorder; ?>" type="text" required>
                      </div>
                  </div> 
                  <div class="form-group col-lg-12">
                      <label for="yarn_lot_uom" class="control-label col-lg-2">UOM</label>
                      <div class="col-lg-10">
                        <select class="select2 form-control" id="yarn_lot_uom" name="yarn_lot_uom" required>
                          <option value="">Select UOM</option>
                          <?php
                          foreach ($uoms as $uom) {
                            ?>
                            <option value="<?=$uom['uom_id']; ?>" <?=($uom['uom_id'] == $yarn_lot_uom)?'selected="selected"':''; ?>><?=$uom['uom_name']; ?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                  </div> */
                  ?>

                  <div class="form-group col-lg-8">
                    <label for="poy_status" class="control-label col-lg-2">Active</label>
                    <div class="col-lg-10">
                      <input type="checkbox" style="width: 20px;float:left;" <?= ($yarn_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="yarn_status" name="yarn_status" />
                    </div>
                  </div>
                </div>
                <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
              </section>
              <section class="panel">
                <header class="panel-heading">
                  <?php if (@$this->uri->segment(4) == 'edit') { ?>
                    <input class="btn btn-danger" type="submit" name="update" value="Update">
                  <?php } else { ?>
                    <input class="btn btn-danger" type="submit" name="save" value="Save" />
                    <input class="btn btn-warning" type="submit" name="save_continue" value="Save &amp; Continue">
                  <?php } ?>
                  <button class="btn btn-default" type="button">Cancel</button>
                </header>
              </section>
            </form>
            <!-- Start Talbe List  -->
            <section class="panel">
              <header class="panel-heading">
                Shades
              </header>
              <script>
                var data = [];
              </script>
              <table class="table table-striped border-top" id="sample_1x">
                <thead>
                  <tr>
                    <th>Sno</th>
                    <th>Final Yarn Denier</th>
                    <th>Date</th>
                    <th>Y.Lot No</th>
                    <th>POY Denier / Inward</th>
                    <th>Machine Speed @Hz</th>
                    <th>DY</th>
                    <th>Draw</th>
                    <th>SOS</th>
                    <th>Take Up Hard Wind</th>
                    <th>Take Up Soft Wind</th>
                    <th>Prim. Temp.</th>
                    <th>Second. Temp.</th>
                    <th>CPM (Hard Wind)</th>
                    <th>CPM (Soft Wind)</th>
                    <th>Rotto Presser</th>
                    <th>Remarks</th>
                    <th>User</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <?php
                $sno = 1;
                ?>
                <?php if (sizeof($yarn_lots) > 0) : ?>
                  <?php foreach ($yarn_lots as $yarn_lot) : ?>
                    <?php
                    $v = $yarn_lot->poy_denier_name;
                    $current = current(array_filter($poy_deniers, function ($e) use ($v) {
                      return $e->denier_name == $v;
                    }));
                    $pdenier_name =  $v . '/' . @$current->denier_id;

                    $v = $yarn_lot->yarn_denier;
                    $current = current(array_filter($yarn_deniers, function ($e) use ($v) {
                      return $e['denier_id'] == $v;
                    }));
                    $ydenier_name = @$current['denier_name'] . '/' . $v;
                    ?>

                    <script>
                      data.push(['<?= $sno++; ?>', '<?= $ydenier_name; ?>', '<?= ($yarn_lot->date != '') ? date("d-m-Y H:i:s", strtotime($yarn_lot->date)) : ''; ?>', '<?= $yarn_lot->yarn_lot_no; ?>/ CL<?= $yarn_lot->yarn_lot_id; ?>', '<?= $pdenier_name; ?><br>Inward : <?= ($yarn_lot->yarn_lot_poyinwardno) ? $yarn_lot->yarn_lot_poyinwardno : 'N/A'; ?>', '<?= $yarn_lot->yarn_lot_machinespeed; ?>', '<?= $yarn_lot->yarn_lot_dy; ?>', '<?= $yarn_lot->yarn_lot_draw; ?>', '<?= $yarn_lot->yarn_lot_sos; ?>', '<?= $yarn_lot->yarn_lot_takeuphardwind; ?>', '<?= $yarn_lot->yarn_lot_takeupsoftwind; ?>', '<?= $yarn_lot->yarn_lot_primarytemp; ?>', '<?= $yarn_lot->yarn_lot_secondarytemp; ?>', '<?= $yarn_lot->yarn_lot_cpmhardwind; ?>', '<?= $yarn_lot->yarn_lot_cpmsoftwind; ?>', '<?= $yarn_lot->yarn_lot_rottopresher; ?>', '<?= $yarn_lot->yarn_lot_remarks; ?>', '<?= @$this->m_users->getuserdetails($yarn_lot->user_id)[0]['user_login']; ?>', '<div class="hidden-phone"><span class="<?= ($yarn_lot->yarn_status == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($yarn_lot->yarn_status == 1) ? 'Active' : 'Inactive'; ?></span></div>', '<a href="<?= base_url('poy/print_yarn_lots/' . $yarn_lot->yarn_lot_id . '/'); ?>" data-placement="top" data-original-title="Print" data-toggle="tooltip" class="btn btn-warning btn-xs tooltips"><i class="icon-print"></i></a><a href="<?= base_url('poy/yarn_lots/' . $yarn_lot->yarn_lot_id . '/edit'); ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a><a href="<?= base_url('poy/yarn_lots/' . $yarn_lot->yarn_lot_id); ?>" data-placement="top" data-original-title="Duplicate" data-toggle="tooltip" class="btn btn-success btn-xs tooltips"><i class="icon-copy"></i></a><a href="#<?= $yarn_lot->yarn_lot_id; ?>" data-toggle="modal" class="btn btn-xs btn-danger" title="Delete"><i class="icon-trash"></i></a><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?= $yarn_lot->yarn_lot_id; ?>" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">Remarks</h4></div><div class="modal-body"><form role="form" method="post" action="<?= base_url(); ?>store/delete_packing_box/<?= $yarn_lot->yarn_lot_id; ?>/yarn_lots"><input type="hidden" name="yarn_lot_id" value="<?= $yarn_lot->yarn_lot_id; ?>"><input type="hidden" name="function_name" value="gray_yarn_soft"><div class="form-group col-lg-12" style="margin-bottom: 15px;"><textarea class="form-control" name="remarks" required style="width:100%;"></textarea></div><div style="clear:both;"></div><button type="submit" class="btn btn-danger" name="delete">Delete</button></form></div></div></div></div>']);
                    </script>

                  <?php endforeach; ?>
                <?php endif; ?>

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
      $('#sample_1x').DataTable({
        'data': data,
        'deferRender': true,
        'processing': true,
        'language': {
          'loadingRecords': '&nbsp;',
          'processing': 'Loading...'
        },
        "order": [
          [2, "desc"]
        ]
      });
      jQuery('.dataTables_filter input').addClass("form-control");
      jQuery('.dataTables_filter').parent().addClass('col-sm-6');
      jQuery('.dataTables_length select').addClass("form-control");
      jQuery('.dataTables_length').parent().addClass('col-sm-6');
    });

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
      $("#yarn_lot_poyinwardno").on('change', function() {
        var poy_inward_no = $('#yarn_lot_poyinwardno').val();
        var url = "<?= base_url() ?>store/get_poy_inward_qty/" + poy_inward_no;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            // console.log(result);
            var result = $.parseJSON(result);
            $(".inward_qty").text(result.inward_qty);
            $(".tot_packed_qty").text(result.tot_packed_qty);
            $(".tot_balancd_qty").text(result.tot_balancd_qty);
            $(".tot_wastage_qty").text(result.tot_wastage_qty);
            $(".supplier_name").text(result.supplier_name);
            $(".poy_denier").text(result.denier_name);
            $(".poy_lot_no").text(result.poy_lot_no);
          }
        });
        return false;
      });
    });

    $(function() {
      $("#sup_group_id").change(function() {
        var sup_group_id = $('#sup_group_id').val();
        var url = "<?= base_url() ?>poy/getsuppliers/" + sup_group_id;
        var postData = 'sup_group_id=' + sup_group_id;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            $("#supplier_id").html('');
            $("#poy_denier").html('');
            $("#supplier_id").select2("val", '');
            $("#poy_denier").select2("val", '');
            $("#supplier_id").html(result);
          }
        });
        return false;
      });
    });
    $(function() {
      $("#supplier_id").change(function() {
        var supplier_id = $('#supplier_id').val();
        var url = "<?= base_url() ?>poy/getsupplierDeniers/" + supplier_id;
        var postData = 'supplier_id=' + supplier_id;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            $("#poy_denier").html('');
            $("#poy_denier").select2("val", '');
            $("#poy_denier").html(result);
          }
        });
        return false;
      });

      $("#poy_denier_id").on('change', function() {
        var poy_inward_no_2 = $(this).val();
        var url = "<?= base_url() ?>store/get_poy_po_no/" + poy_inward_no_2;
        var postData = 'id=' + poy_inward_no_2;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result) {
            $("#yarn_lot_poyinwardno").select2('destroy');
            $("#yarn_lot_poyinwardno").html(result);
            $("#yarn_lot_poyinwardno").select2();

          }
        });
        return false;
      });
    });
  </script>

</body>

</html>