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
                                <h3><i class="icon-book"></i> Job Sheet - Production Sheet for Tapes &amp; Elastic</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Action Messages -->
                      <section class="panel">
                          <header class="panel-heading">
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
                          }                                                    if($this->session->flashdata('error'))
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
                          </header>
                      </section>
                      <!-- End Action Messages -->
                      <!-- Start Talbe List  -->
                      <?php
                      $jobcards = $this->m_masters->getmasterdetails('bud_te_jabcards', 'jobcard_no', $jobcard_no);
                      foreach ($jobcards as $jobcard) {
                        $jobcard_date = $jobcard['jobcard_date'];
                        $jobcard_item = $jobcard['jobcard_item'];
                        $jobcard_po = $jobcard['jobcard_po'];
                        $jobcard_qty = $jobcard['jobcard_qty'];
                        $jobcard_item_uom = $jobcard['jobcard_item_uom'];
                      }
                      $qd = explode("-", $jobcard_date);
                      $jobcard_date = $qd[2].'-'.$qd[1].'-'.$qd[0];
                      $item_name = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $jobcard_item, 'item_name');
                      $item_width = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $jobcard_item, 'item_width');
                      $item_uom = $this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $jobcard_item_uom, 'uom_name');
                      $item_design_code = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $jobcard_item, 'item_design_code');
                      $staffs = $this->m_masters->getactivemaster('bud_users', 'user_status');
                      ?>
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="">                                     <section class="panel">
                        <header class="panel-heading">
                            P.S. No
                            <span class="label label-danger" style="font-size:14px;">P.S - <?=$jobcard_no; ?></span>
                        </header>
                        <div class="panel-body">                                            <div class="form-group col-lg-3">
                            <label for="job_date">Date</label>
                            <input class="form-control" name="job_date" id="job_date" value="<?=$jobcard_date; ?>" readonly="readonly">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_artno">Art No</label>
                            <input type="text" class="form-control" value="<?=$jobcard_item; ?>" readonly="readonly">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_item">Item Name</label>
                            <input type="text" class="form-control" value="<?=$item_name; ?>" readonly="readonly">                                              </div>
                          <div class="form-group col-lg-3">
                            <label for="job_item_width">Width</label>
                            <input type="text" class="form-control" value="<?=$item_width; ?>" readonly="readonly">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_design_code">Design Code</label>
                            <input type="text" class="form-control" value="<?=$item_design_code; ?>" readonly="readonly">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_po_ref">P.O.Ref</label>
                            <input type="text" class="form-control" value="<?=$jobcard_po; ?>" readonly="readonly">
                          </div>
                          <div class="form-group col-lg-3">
                            <label for="job_operator">Operator</label>
                            <select class="select2 form-control" data-placeholder="Select Operator" name="job_operator" id="job_operator">
                              <option value="">Select Operator</option>
                              <?php
                              foreach ($staffs as $staff) {
                                ?>
                                <option value="<?=$staff['ID']; ?>"><?=$staff['display_name']; ?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>                                    </section>
                    <section class="panel">
                        <header class="panel-heading">
                          Combos
                        </header>
                        <div class="panel-body">
                          <?php
                          $colorcombos = $this->m_masters->getmasterdetails('bud_te_color_combos', 'item_id', $jobcard_item);
                          ?>
                          <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Combos</th>
                                <th>Combo Names</th>
                                <th>Total Po Qty</th>
                                <th>No of Tapes</th>
                                <th>Qty / Tape</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                foreach ($colorcombos as $colorcombo) {
                                  $shade_name = explode(",", $colorcombo['shade_name']);
                                  $combo_names = array();
                                  foreach ($shade_name as $value) {
                                    $combo_names[] = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $value, 'shade_name');
                                  }
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td>Combo <?=$sno; ?></td>
                                    <td><?=implode(", ", $combo_names); ?></td>
                                    <td><?=$jobcard_qty; ?> <?=$item_uom; ?></td>
                                    <td></td>
                                    <td></td>
                                  </tr>                                                <?php
                                  $sno++;
                                }
                                ?>
                            </tbody>
                          </table>
                        </div>
                    </section>

                    <section class="panel">
                        <header class="panel-heading">
                            Color Combos
                        </header>
                        <div class="panel-body">
                          <?php
                          $combono = 1;
                          foreach ($colorcombos as $colorcombo) {
                            $shade_name = explode(",", $colorcombo['shade_name']);
                            $denier = explode(",", $colorcombo['denier']);
                            $no_ends = explode(",", $colorcombo['no_ends']);
                            $no_beams = explode(",", $colorcombo['no_beams']);
                            $ends_heald = explode(",", $colorcombo['ends_heald']);
                            $healds_dent = explode(",", $colorcombo['healds_dent']);
                            $design_weave = explode(",", $colorcombo['design_weave']);
                            $net_weight = explode(",", $colorcombo['net_weight']);
                            $percentage = explode(",", $colorcombo['percentage']);

                            for ($i=0; $i < 5; $i++) { 
                              $percentage[$i] = (array_key_exists($i, $percentage) && $percentage[$i] != '')?$percentage[$i]:'12';                                          $net_weight[$i] = (isset($net_weight[$i]))?$net_weight[$i]:'';
                              $no_beams[$i] = (array_key_exists($i, $no_beams) && $no_beams[$i] != '')?$no_beams[$i]:'1';
                              $ends_heald[$i] = (array_key_exists($i, $ends_heald) && $ends_heald[$i] != '')?$ends_heald[$i]:'0';
                              $healds_dent[$i] = (array_key_exists($i, $healds_dent) && $healds_dent[$i] != '')?$healds_dent[$i]:'0';
                              $design_weave[$i] = (array_key_exists($i, $design_weave) && $design_weave[$i] != '')?$design_weave[$i]:'0';
                            }

                            ?>                                                 <h3>Color Combo <?=$combono; ?></h3>
                            <table id="table" class="table table-bordered table-striped table-condensed">
                            <thead>
                              <tr>
                                <th width="3%">Sno</th>
                                <th width="7%">WARP</th>
                                <th width="10%">Shade Name</th>
                                <th width="5%">Shade No</th>
                                <th width="5%">Denier / Guage</th>
                                <th width="5%"># of Ends</th>
                                <th width="3%"># Ends / Heald</th>
                                <th width="5%"># Heald / Dent</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $rowtitle = array('Warp 1', 'Warp 2', 'Warp 3', 'WEFT', 'RUBBER');
                              foreach ($shade_name as $key => $value) {
                                ?>
                                <tr>
                                  <td><?=$key+1; ?></td>
                                  <td><?=$rowtitle[$key]; ?></td>
                                  <td>
                                    <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $value, 'shade_name'); ?>
                                  </td>
                                  <td>
                                    <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $value, 'shade_code'); ?>
                                  </td>
                                  <td>
                                    <?=$this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $denier[$key], 'denier_name'); ?>
                                  </td>
                                  <td>
                                    <?=$no_ends[$key]; ?>
                                  </td>
                                  <td><?=$ends_heald[$key]; ?></td>
                                  <td><?=$healds_dent[$key]; ?></td>
                                </tr>
                                <?php
                              }
                              ?>
                            </tbody>
                            </table>
                            <?php
                            $combono++;
                          }
                          ?>
                        </div>
                    </section>

                    <section class="panel">
                        <header class="panel-heading">
                            <!-- <button class="btn btn-danger" type="submit">Save</button> -->
                            <button class="btn btn-default" type="button">Print</button>
                        </header>
                    </section>
                    </form>
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
          $("#tbl").find("select").select2();
          $("#add").click(function () {

            $( "select" ).each(function( i ) {                      $( this ).select2("destroy");
            });

            var $tableBody = $('#tbl').find("tbody"),
            $trFirst = $tableBody.find("tr:first"),
            $trLast = $tableBody.find("tr:last"),
            $trNew = $trFirst.clone();
            $trLast.after($trNew);

            $( "select" ).each(function( i ) {                      $( this ).select2();
            });

            return false;
          });
      });

      //custom select box

      $(function(){
        $("#job_artno").change(function () {
            var job_artno = $('#job_artno').val();
            $("#job_item").select2("val", job_artno);
        });
      });
      $(function(){
        $("#job_item").change(function () {
            var job_item = $('#job_item').val();
            $("#job_artno").select2("val", job_item);
        });
      });


      /*$(function(){
        // $("select.colors").live("change", function () {
        $('select[name="colors[]"]').live("change", function () {
            var colors = $(this).val();
            alert($(this).index());
        });
      });*/

      $(function(){
          $('select.styled').customSelect();
      });


      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });     

      //timepicker start
      $('.timepicker-default').timepicker();      

  </script>

  </body>
</html>
