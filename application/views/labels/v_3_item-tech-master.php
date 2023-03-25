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
                                <h3><i class="icon-map-marker"></i> Item Technical Master</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/update_item_technical_3">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Item Group Details
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
                                if(isset($item_id))
                                {
                                  $result = $this->m_masters->getmasterdetails('bud_lbl_items', 'item_id', $item_id);
                                  foreach ($result as $row) {
                                    $item_id = $row['item_id'];
                                    $item_category = $row['item_category'];
                                    $item_group = $row['item_group'];
                                    $item_name = $row['item_name'];
                                    $item_second_name = $row['item_second_name'];
                                    $item_third_name = $row['item_third_name'];
                                    $item_width = $row['item_width'];                                                              $item_height = $row['item_height'];                                                              $item_status = $row['item_status'];
                                    $item_sample = $row['item_sample'];
                                    $item_created_on = $row['item_created_on'];
                                    $tot_warp_ends = $row['tot_warp_ends'];
                                    $total_wefts = $row['total_wefts'];
                                    $weight_100_pcs = $row['weight_100_pcs'];
                                    $item_pick_density = $row['item_pick_density'];
                                    $item_design_code = $row['item_design_code'];
                                    $demask_length = $row['demask_length'];
                                    $demask_picks = $row['demask_picks'];
                                    $default_repeats = $row['default_repeats'];
                                  }
                                  $date = explode("-",  $item_created_on);
                                  $item_created_on = $date[2].'-'.$date[1].'-'.$date[0];
                                }
                                else
                                {
                                  $item_id = '';
                                  $item_category = '';
                                  $item_group = '';
                                  $item_name = '';
                                  $item_second_name = '';
                                  $item_third_name = '';
                                  $item_width = '';
                                  $item_height = '';
                                  $item_status = '';
                                  $item_created_on = date("d-m-Y");
                                  $item_sample = '';
                                  $tot_warp_ends = '';
                                  $total_wefts = '';
                                  $weight_100_pcs = '';
                                  $item_pick_density = '';
                                  $item_design_code = '';
                                  $demask_length = '';
                                  $demask_picks = '';
                                  $default_repeats = '';
                                }
                                ?>                                                                           <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="get_outerboxes form-control select2" id="item_name" name="item_name">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_code">Label Art No</label>
                                 <select class="get_outerboxes form-control select2" id="item_code" name="item_code">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_width">Width(mm)</label>
                                 <input class="form-control" value="<?=$item_width; ?>" name="formData[item_width]" id="item_width" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_height">Total Length(mm)</label>
                                 <input class="form-control" value="<?=$item_height; ?>" name="formData[item_height]" id="item_height" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="demask_length">Demask Length(mm)</label>
                                 <input class="form-control" value="<?=$demask_length; ?>" name="formData[demask_length]" id="demask_length" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="weight_100_pcs">Weight / 100 pcs</label>
                                 <input class="form-control" value="<?=$weight_100_pcs; ?>" name="formData[weight_100_pcs]" id="weight_100_pcs" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_pick_density">Pick Density</label>
                                 <input class="form-control" value="<?=$item_pick_density; ?>" name="formData[item_pick_density]" id="item_pick_density" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="tot_warp_ends">Total Warp End</label>
                                 <input class="form-control" value="<?=$tot_warp_ends; ?>" name="formData[tot_warp_ends]" id="tot_warp_ends" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="total_wefts">Total Picks</label>
                                 <input class="form-control" value="<?=$total_wefts; ?>" name="formData[total_wefts]" id="total_wefts" type="text">
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="demask_picks">D. Ground Picks</label>
                                 <input class="form-control" value="<?=$demask_picks; ?>" name="formData[demask_picks]" id="demask_picks" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_design_code">Design Code</label>
                                 <input class="form-control" value="<?=$item_design_code; ?>" name="formData[item_design_code]" id="item_design_code" type="text">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="default_repeats">Default Repeats</label>
                                 <input class="form-control" value="<?=$default_repeats; ?>" name="formData[default_repeats]" id="default_repeats" type="text">
                              </div>                                                       </div>
                        </section>
                                  </div>
                </div>
                <?php
                if(isset($item_id))
                {
                  $colorcombos = $this->m_masters->getmasterdetails('bud_lbl_color_combos', 'item_id', $item_id);
                }
                else
                {
                  $colorcombos = null;
                }
                if(sizeof($colorcombos) > 0)
                {
                            foreach ($colorcombos as $row) {
                    $combo_id = $row['combo_id'];
                    $shade_name = explode(",", $row['shade_name']);
                    $denier = explode(",", $row['denier']);
                    $no_ends = explode(",", $row['no_ends']);
                    $design_weave = explode(",", $row['design_weave']);
                    $net_weight = explode(",", $row['net_weight']);
                    $percentage = explode(",", $row['percentage']);

                    for ($i=0; $i < 8; $i++) { 
                      $percentage[$i] = (array_key_exists($i, $percentage) && $percentage[$i] != '')?$percentage[$i]:'12';                                  $net_weight[$i] = (isset($net_weight[$i]))?$net_weight[$i]:'';
                      $design_weave[$i] = (array_key_exists($i, $design_weave) && $design_weave[$i] != '')?$design_weave[$i]:'0';
                    }
                  }
                }
                else
                {
                  $combo_id = '';
                  $shade_name = array(null,null,null,null,null,null,null,null,null);
                  $no_ends = array(null,null,null,null,null,null,null,null,null);
                  $denier = array(null,null,null,null,null,null,null,null,null);
                  $design_weave = array(null,null,null,null,null,null,null,null,null);
                  $net_weight = array(null,null,null,null,null,null,null,null,null);
                  $percentage = array('12','12','12','12','12','12','12','12','12','12');
                }
                // print_r($shade_name);
                ?>
                <input type="hidden" name="combo_id" value="<?=$combo_id; ?>">
                <div class="row">
                  <div class="col-lg-12">
                    <section class="panel">
                      <header class="panel-heading">
                          Color Combos
                      </header>
                                    <div class="panel-body">
                        <table id="table" class="table table-bordered table-striped table-condensed">
                          <thead>
                            <tr>
                              <th width="3%">Sno</th>
                              <th width="10%">WARP</th>
                              <th width="20%">Shade Name</th>
                              <th width="15%">Shade No</th>
                              <th width="12%">Denier</th>
                              <th width="10%">Warp/Picks</th>
                              <th width="10%">Weave</th>
                              <th width="15%">Net Weight(grms)</th>
                              <th width="5%">%</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="data">
                              <td>1</td>
                              <td>WARP 1</td>
                              <td>
                                <select class="select2 warp_1_shade" name="shade_name[]" style="width:99%;">
                                  <option value="">Select</option>
                                  <?php
                                  foreach ($shades as $shade) {
                                    ?>
                                    <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[0])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                  <select class="select2 warp_1_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[0])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                <select class="select2" name="denier[]" style="width:99%;">
                                  <option value="">Select Denier</option>
                                  <?php
                                  foreach ($deniers as $row) {
                                    ?>
                                    <option value="<?=$row['denier_id']; ?>" <?=($row['denier_id'] == $denier[0])?'selected="selected"':''; ?>><?=$row['denier_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                <input type="text" name="no_ends[]" value="<?=$no_ends[0]; ?>" style="width:99%;">
                              </td>
                              <td>
                                <select class="select2 form-control" name="design_weave[]">
                                  <option value="">Select Weave</option>
                                  <?php
                                  foreach ($weaves as $row) {
                                    ?>
                                    <option value="<?=$row['weave_id']; ?>" <?=($row['weave_id'] == $design_weave[0])?'selected="selected"':''; ?>><?=$row['weave_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                <input type="text" name="net_weight[]" value="<?=$net_weight[0]; ?>" style="width:99%;" readonly="readonly">
                              </td>
                              <td>
                                <input type="text" name="percentage[]" value="<?=$percentage[0]; ?>" style="width:99%;">
                              </td>
                            </tr>
                            <?php
                            for ($i=0; $i < 8 ; $i++) { 
                              $key = $i+1;
                              ?>
                              <tr class="data">
                              <td><?=$i+2; ?></td>
                              <td>WEFT <?=$i; ?></td>
                              <td>
                                <select class="select2 warp_<?=($i+2)?>_shade" name="shade_name[]" style="width:99%;">
                                  <option value="">Select</option>
                                  <?php
                                  foreach ($shades as $shade) {
                                    ?>
                                    <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[$key])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                  <select class="select2 warp_<?=($i+2)?>_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[$key])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                <select class="select2" name="denier[]" style="width:99%;">
                                  <option value="">Select Denier</option>
                                  <?php
                                  foreach ($deniers as $row) {
                                    ?>
                                    <option value="<?=$row['denier_id']; ?>" <?=($row['denier_id'] == $denier[$key])?'selected="selected"':''; ?>><?=$row['denier_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                <input type="text" name="no_ends[]" value="<?=$no_ends[$key]; ?>" style="width:99%;">
                              </td>
                              <td>
                                <select class="select2 form-control" name="design_weave[]">
                                  <option value="">Select Weave</option>
                                  <?php
                                  foreach ($weaves as $row) {
                                    ?>
                                    <option value="<?=$row['weave_id']; ?>" <?=($row['weave_id'] == $design_weave[$key])?'selected="selected"':''; ?>><?=$row['weave_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td>
                                <input type="text" name="net_weight[]" value="<?=$net_weight[$key]; ?>" style="width:99%;" readonly="readonly">
                              </td>
                              <td>
                                <input type="text" name="percentage[]" value="<?=$percentage[$key]; ?>" style="width:99%;">
                              </td>
                            </tr>
                              <?php
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </section>
                  </div>                              </div>
                <div class="row">
                  <div class="col-lg-12">
                    <section class="panel">
                      <div class="panel-body">
                        <div>
                            <button class="btn btn-danger" type="submit">Update</button>
                            <button class="btn btn-default" type="button">Cancel</button>
                        </div>
                      </div>
                    </section>
                  </div>                              </div>
              </form>            <!-- page end-->
            </section>
            <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="itemlist">
                            <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Item Name</th>
                                  <th>Item Code</th>
                                  <th>Design Code</th>
                                  <th>Total Width</th>
                                  <th>Total Length</th>
                                  <th>Total Weight(gms)</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($items as $item) {
                                $ed = explode("-", $item['item_created_on']);
                                $item_created_on = $ed[2].'-'.$ed[1].'-'.$ed[0];
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td> 
                                    <td><?=$item['item_name']; ?></td>                                                                <td><?=$item['item_id']; ?></td>                                                         <td><?=$item['item_design_code']; ?></td>                                                         <td><?=$item['item_width']; ?></td>                                                                <td><?=$item['item_height']; ?></td>
                                    <td><?=$item['weight_100_pcs']; ?></td>
                                    <td>
                                      <a href="<?=base_url();?>masters/item_technical_3/<?=$item['item_id']?>" data-placement="top" data-original-title="Update Technical Data" data-toggle="tooltip" class="btn btn-success btn-xs tooltips"><i class="icon-table"></i></a>
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

      $(".get_outerboxes").change(function(){
        window.location = "<?=base_url(); ?>masters/item_technical_3/"+$(this).val();
      });

      <?php
      for ($i = 1; $i <= 9; $i++) {
        ?>
      $(function(){
        $( ".warp_<?=$i; ?>_shade" ).live( "change", function() {
            var shade = $(this).val();
            $( ".warp_<?=$i; ?>_shade" ).select2("val", shade); //set the value
        });
      });
        <?php
      };
      ?>
  </script>

  </body>
</html>
