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
                                <h3><i class="icon-map-marker"></i> Beam Break Up Settings</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">                                                <div class="panel-body">
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
                            </div>
                        </section>
                    </div>
                </div>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/tech_advanced_save">
                <input type="hidden" name="combo_id" value="<?=$combo_id; ?>">
                <input type="hidden" name="item_id" value="<?=$item_id; ?>">
                <div class="row">
                    <div class="col-lg-12">
                    <?php
                    foreach ($colorcombo as $row) {
                      $shade_name = explode(",", $row['shade_name']);
                      $editdenier = explode(",", $row['denier']);
                      $no_ends = explode(",", $row['no_ends']);
                      $ends_heald = explode(",", $row['ends_heald']);
                      $healds_dent = explode(",", $row['healds_dent']);
                      $design_weave = explode(",", $row['design_weave']);
                      $net_weight = explode(",", $row['net_weight']);
                      $percentage = explode(",", $row['percentage']);
                      $old_no_beams = explode(",", $row['no_beams']);
                      $beams_qty = explode("|", $row['beams_qty']);
                    }
                                for ($i=0; $i < 10; $i++) {
                      $no_beams[$i] = (array_key_exists($i, $no_beams) && $no_beams[$i] != '')?$no_beams[$i]:'0';
                      if(array_key_exists($i, $beams_qty) && $beams_qty[$i] != '')
                      {
                        $beams_qty[$i] = $beams_qty[$i];
                      }
                      else
                      {
                        $temp_array = array();
                        for ($j=0; $j < $no_beams[$i]; $j++) { 
                          $temp_array[$j] = '0';
                        }
                        $beams_qty[$i] = implode(",", $temp_array);
                      }
                    }
                    foreach ($beams_qty as $key => $value) {
                      $beams_qty[$key] = explode(",", $value);
                    }
                    $maxbeam = max($no_beams);
                    ?>
                    <table id="table" class="table table-bordered table-striped table-condensed">                                  <thead>
                      <tr>
                        <th>Color</th>
                        <th># Ends</th>
                        <?php
                        for ($i=0; $i < $maxbeam; $i++) { 
                          ?>
                          <th>Beam <?=$i+1; ?></th>
                          <?php
                        }
                        ?>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($no_beams as $key => $value) {
                      $beams = $no_beams[$key];                                    ?>
                      <tr>
                        <td>
                          <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $shade_name[$key], 'shade_name'); ?>
                        </td>
                        <td>
                          <?=$no_ends[$key]; ?>
                        </td>
                        <?php
                        if($beams > 0)
                            {
                              $remaining_beam = $maxbeam;
                              for ($i=0; $i < $beams; $i++)
                              {
                                $beams_qty[$key][$i] = (array_key_exists($i, $beams_qty[$key]) && $beams_qty[$key][$i] != '')?$beams_qty[$key][$i]:'0';
                                ?>
                                <td>                                                                  <input name="beams_qty[<?=$key; ?>][]" value="<?=$beams_qty[$key][$i]; ?>" type="text" style="width:100px;">
                                </td>
                                <?php
                                $remaining_beam--;  
                              }
                              for ($i=0; $i < $remaining_beam; $i++) { 
                                ?>
                                <td>-</td>
                                <?php
                              }
                            }
                            else
                            {
                              ?>
                              <td>                                                                <input name="beams_qty[<?=$key; ?>][]" type="text" value="0" style="width:100px;">
                              </td>
                              <?php
                            }
                        ?>
                      </tr>                                   <?php
                    }
                    ?>
                    </tbody>
                    </table>
                    <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit">Save</button>
                            <button class="btn btn-default" type="button">Cancel</button>
                        </header>
                    </section>
                    </div>
                </div>  
                </form>   
                <!-- page end-->
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
