<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title><?=$page_title; ?> | INDOFILA SYNTHETICS</title>

    <!-- Bootstrap core CSS -->
    <?php
    foreach ($css as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet">
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
                                Machine Details
                            </header>
                                                <div class="panel-body">
                                <?php
                                if($this->session->flashdata('warning'))
                                {
                                  ?>
                                  <div class="alert alert-warning fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                                  </div>
                                  <?php
                                }                                                          if($this->session->flashdata('error'))
                                {
                                  ?>
                                  <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                                </div>
                                  <?php
                                }
                                if($this->session->flashdata('success'))
                                {
                                  ?>
                                  <div class="alert alert-success alert-block fade in">
                                      <button data-dismiss="alert" class="close close-sm" type="button">
                                          <i class="icon-remove"></i>
                                      </button>
                                      <h4>
                                          <i class="icon-ok-sign"></i>
                                          Success!
                                      </h4>
                                      <p><?=$this->session->flashdata('success'); ?></p>
                                  </div>
                                  <?php
                                }
                                ?>
                                <?php
                                if(isset($machine_id))
                                {
                                  $editmachine = $this->m_masters->getmasterdetails('bud_te_machines', 'machine_id', $machine_id);
                                  foreach ($editmachine as $machine) {
                                    $machine_id = $machine['machine_id'];
                                    $machine_type = $machine['machine_type'];
                                    $machine_name = $machine['machine_name'];
                                    $machine_second_name = $machine['machine_second_name'];
                                    $machine_no_tapes = $machine['machine_no_tapes'];
                                    $machine_no_tapes_act = $machine['machine_no_tapes_act'];
                                    $machine_rpm = $machine['machine_rpm'];
                                    $machine_speed = $machine['machine_speed'];
                                    $machine_production = $machine['machine_production'];
                                    $machine_pick_density = $machine['machine_pick_density'];
                                    $default_picks_shift = $machine['default_picks_shift'];
                                    $machine_status = $machine['machine_status'];
                                    $machine_rpm_day = $machine['machine_rpm_day'];;//ER-09-18#-62
                                    $machine_rpm_night =$machine['machine_rpm_night'];;//ER-09-18#-62
                                  }
                                  $action = 'machines_2_update';
                                }
                                else
                                {
                                  $machine_id = '';
                                  $machine_type = 1;
                                  $machine_name = '';
                                  $machine_second_name = '';
                                  $machine_no_tapes = '';
                                  $machine_no_tapes_act = '';
                                  $machine_rpm = '';
                                  $machine_rpm_day = '';//ER-09-18#-62
                                  $machine_rpm_night = '';//ER-09-18#-62
                                  $machine_speed = '';
                                  $machine_production = '';
                                  $machine_pick_density = '';
                                  $default_picks_shift = '';
                                  $machine_status = '';
                                  $action = 'machines_2_save';
                                }
                                ?>                                                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/<?=$action; ?>">                                                                <input type="hidden" name="machine_id" value="<?=$machine_id; ?>">                                                                <div class="form-group col-lg-4">
                                      <label for="machine_type">Machine Type</label>
                                      <div style="clear:both;"></div>
                                      <label class="radio-inline">
                                        <input class="" name="machine_type" type="radio" value="1" <?=($machine_type == 1)?'checked="checked"':''; ?> required> Main                                                                     </label>
                                      <label class="radio-inline">
                                        <input class="" name="machine_type" type="radio" value="2" <?=($machine_type == 2)?'checked="checked"':''; ?> required> Accessory                                                                     </label>                                                                    </div>
                                    <div class="form-group col-lg-4">
                                      <label for="machine_name">Machine Name</label>                                                                      <input class="form-control" id="machine_name" name="machine_name" value="<?=$machine_name; ?>" type="text" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                      <label for="machine_second_name">Machine Second Name</label>                                                                        <input class="form-control" id="machine_second_name" name="machine_second_name" value="<?=$machine_second_name; ?>" type="text" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="machine_no_tapes">No of 8 inch Tapes</label>
                                        <input class="form-control" id="machine_no_tapes" name="machine_no_tapes" value="<?=$machine_no_tapes; ?>" type="text" required>                                                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="machine_no_tapes_act">Width of 1 Master Tape</label>
                                        <input class="form-control" id="machine_no_tapes_act" name="machine_no_tapes_act" value="<?=$machine_no_tapes_act; ?>" type="text" required>                                                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="machine_rpm" >Machine RPM</label>
                                        <input class="form-control" id="machine_rpm" name="machine_rpm" value="<?=$machine_rpm; ?>" type="text" required>                                                                    </div>
                                    <!--//ER-09-18#-62-->
                                    <div class="form-group col-lg-4">
                                        <label for="machine_rpm_day" >Machine RPM Day</label>
                                        <input class="form-control" id="machine_rpm_day" name="machine_rpm_day" value="<?=$machine_rpm_day; ?>" type="text" required>                                                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="machine_rpm_night" >Machine RPM Night</label>
                                        <input class="form-control" id="machine_rpm_night" name="machine_rpm_night" value="<?=$machine_rpm_night; ?>" type="text" required>                                                                    </div>
                                    <!--//ER-09-18#-62-->
                                    <div class="form-group col-lg-4">
                                        <label for="machine_speed" >Machine Speed in meter/min</label>
                                        <input class="form-control" id="machine_speed" name="machine_speed" value="<?=$machine_speed; ?>" type="text" required>                                                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="machine_production" >Machine Production in Kgs/min</label>
                                        <input class="form-control" id="machine_production" name="machine_production" value="<?=$machine_production; ?>" type="text" required>                                                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="machine_pick_density">Default Pick Density</label>
                                        <input class="form-control" id="machine_pick_density" name="machine_pick_density" value="<?=$machine_pick_density; ?>" type="text" required>                                                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="machine_pick_density">Default Picks / Shift</label>
                                        <input class="form-control" id="machine_pick_density" name="machine_pick_density" value="<?=$default_picks_shift; ?>" type="text" required>                                                                    </div>                                                           <div class="form-group col-lg-4">
                                        <label for="machine_status" class="control-label col-lg-2">Active</label>
                                        <input  type="checkbox" style="width: 20px;float:left;" <?=($machine_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="machine_status" name="machine_status" />                                                                    </div>
                                    <div class="clear" style="clear:both;"></div>
                                    <div class="form-group col-lg-4">
                                      <button class="btn btn-danger" type="submit"><?=($machine_id != '')?'Update':'Save'; ?></button>
                                      <button class="btn btn-default" type="button">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Machine No</th>
                                  <th>Machine Name</th>
                                  <th>Second Name</th>
                                  <th>No of Tapes</th>
                                  <th>RPM</th>
                                  <th>RPM Day</th><!--//ER-09-18#-62-->
                                  <th>RPM Night</th><!--//ER-09-18#-62-->
                                  <th>Status</th>
                                  <th class="hidden-phone"></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($machines as $machine) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$machine['machine_id']?></td>
                                    <td><?=$machine['machine_name']?></td>
                                    <td><?=$machine['machine_second_name']?></td>
                                    <td><?=$machine['machine_no_tapes']?></td>
                                    <td><?=$machine['machine_rpm']?></td>
                                    <td><?=$machine['machine_rpm_day']?></td><!--//ER-09-18#-62-->
                                    <td><?=$machine['machine_rpm_night']?></td><!--//ER-09-18#-62-->
                                    <td>
                                      <span class="<?=($machine['machine_status']==1)?'label label-success':'label label-danger'; ?>"><?=($machine['machine_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td>
                                      <a href="<?=base_url();?>masters/machines_2/<?=$machine['machine_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <a href="<?=base_url();?>masters/deletemaster/bud_te_machines/machine_id/<?=$machine['machine_id']?>/machines_2" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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
                </div>             <!-- page end-->
            </section>
      </section>
      <!--main content end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php
    foreach ($js as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>    

    <!--common script for all pages-->
    <?php
    foreach ($js_common as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

    <!--script for this page-->
    <?php
    foreach ($js_thispage as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
