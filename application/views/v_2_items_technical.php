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
                                <h3><i class="icon-map-marker"></i> Item Technical Data</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                  <?php
                  if($this->session->flashdata('warning'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-warning fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                           </button>
                           <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }                                            if($this->session->flashdata('error'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-block alert-danger fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                           <i class="icon-remove"></i>
                           </button>
                           <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }
                  if($this->session->flashdata('success'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
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
                     </header>
                  </section>
                  <?php
                  }
                  ?>
                  </div>
               </div>
               <?php
               foreach ($items as $item) {
                  $item_id = $item['item_id'];
                  $item_category = $item['item_category'];
                  $item_group = $item['item_group'];
                  $item_name = $item['item_name'];
                  $item_width = $item['item_width'];
                  $item_weight_mtr = $item['item_weight_mtr'];
                  $item_design_code = $item['item_design_code'];
                  $item_design_weave = $item['item_design_weave'];
                  $item_weave_remarks = $item['item_weave_remarks'];
                  $item_pick_density = $item['item_pick_density'];
                  $item_sample = $item['item_sample'];
                  $item_status = $item['item_status'];
                }
               ?>
               <form action="<?=base_url();?>masters/<?=($combo_id == '')?'items_2_technical_save':'items_2_technical_update'; ?>" class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="item_id" value="<?=$item_id; ?>">
                <div class="row">
                   <div class="col-lg-12">
                      <section class="panel">                                             <header class="panel-heading">
                            Details
                         </header>
                         <div class="panel-body">
                            <div class="form-group col-lg-12">
                                <label for="item_name" class="control-label col-lg-2">Item Code No / Art No:</label>
                                <div class="col-lg-10">
                                  <span class="label label-danger" style="font-size:24px;"><?=$item_id; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-9">
                              <div class="form-group col-lg-4">
                                 <label for="item_group">Item Group</label>
                                 <select class="form-control select2" name="item_group" id="item_group" required>
                                    <option value="">Select Group</option>
                                    <?php
                                    foreach ($itemgroups as $group) {
                                      ?>
                                      <option value="<?=$group['group_id']; ?>" <?=($group['group_id'] == $item_group)?'selected="selected"':''; ?>><?=$group['group_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                              </div>
                              <div class="form-group col-lg-4">
                                 <label for="item_name">Item Name</label>
                                 <?php
                                $items = $this->m_masters->getactiveCdatas('bud_te_items', 'item_status', 'item_group', $item_group);
                                ?>
                                <select class="select2 form-control" name="item_name" id="item_name">
                                  <option value="">Select Item</option> 
                                  <?php
                                  foreach ($items as $item) {
                                    ?>
                                    <option value="<?=$item['item_id']; ?>" <?=($item['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$item['item_name']; ?></option>
                                    <?php
                                  }
                                  ?>                                                                  </select>
                              </div>
                              <div class="form-group col-lg-4">
                                 <label for="item_code">Item Code</label>
                                 <input class="form-control" id="item_code" name="item_code" type="text" value="<?=$item_id; ?>">
                              </div>
                              <div class="form-group col-lg-4">
                                 <label for="item_width">Item Width</label>
                                 <input class="form-control" id="item_width" name="item_width" value="<?=$item_width; ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                 <label for="item_weight_mtr">Weight/Meter</label>
                                 <input class="form-control" id="item_weight_mtr" name="item_weight_mtr" value="<?=$item_weight_mtr; ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                 <label for="item_pick_density">Pick Density</label>
                                 <input class="form-control" id="item_pick_density" name="item_pick_density" value="<?=$item_pick_density; ?>" type="text">
                              </div>
                              <div class="form-group col-lg-4">
                                 <label for="sample_file">Sample</label>
                                 <input type="hidden" name="old_item_sample" value="<?=$item_sample; ?>">
                                 <input class="form-control" id="sample_file" name="sample_file" type="file">
                              </div>
                              <div class="form-group col-lg-4">
                                  <label for="item_design_code">Design Code</label>
                                  <input class="form-control" id="item_design_code" name="item_design_code" value="<?=$item_design_code; ?>" type="text">                                                       </div>
                              <div class="form-group col-lg-4">
                                  <label for="item_design_weave">Design Weave</label>
                                  <?php
                                  $weaves = $this->m_masters->getallmaster('bud_te_weaves');
                                  ?>
                                  <select class="form-control" id="item_design_weave" name="item_design_weave">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $item_design_weave)?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                              </div>
                              <div class="form-group col-lg-10">
                                  <label for="item_weave_remarks">Weave Remarks</label>
                                  <textarea class="form-control" id="item_weave_remarks" name="item_weave_remarks"><?=$item_weave_remarks; ?></textarea>
                              </div>                                                      </div>
                            <div class="col-lg-3">
                              <?php
                              if($item_sample != '')
                              {
                                ?>
                                <a class="fancybox" rel="group" href="<?=base_url(); ?>uploads/itemsamples/<?=$item_sample; ?>">
                                  <img src="<?=base_url(); ?>uploads/itemsamples/<?=$item_sample; ?>" style="max-width:100%;">
                                </a>
                                <?php
                              }
                              ?>
                            </div>
                            <div class="clear"></div>
                         </div>
                      </section>
                   </div>
                  <?php
                  if($combo_id != '')
                  {
                    foreach ($colorcombo as $row) {
                      $shade_name = explode(",", $row['shade_name']);
                      $editdenier = explode(",", $row['denier']);
                      $no_ends = explode(",", $row['no_ends']);
                      $ends_heald = explode(",", $row['ends_heald']);
                      $healds_dent = explode(",", $row['healds_dent']);
                      $design_weave = explode(",", $row['design_weave']);
                      $net_weight = explode(",", $row['net_weight']);
                      $percentage = explode(",", $row['percentage']);
                    }
                  }
                  else
                  {
                    $combo_id = '';
                    $shade_name = array('', '', '', '', '','', '', '', '', '');
                    $editdenier = array('', '', '', '', '','', '', '', '', '');
                    $no_ends = array('', '', '', '', '','', '', '', '', '');
                    $ends_heald = array('', '', '', '', '','', '', '', '', '');
                    $healds_dent = array('', '', '', '', '','', '', '', '', '');
                    $design_weave = array('', '', '', '', '','', '', '', '', '');
                    $net_weight = array('', '', '', '', '','', '', '', '', '');
                    $percentage = array('', '', '', '', '','', '', '', '', '');
                  }
                  for ($i=0; $i < 10; $i++) { 
                    $percentage[$i] = (array_key_exists($i, $percentage) && $percentage[$i] != '')?$percentage[$i]:'12';                                $net_weight[$i] = (isset($net_weight[$i]))?$net_weight[$i]:'';
                    $no_ends[$i] = (array_key_exists($i, $no_ends) && $no_ends[$i] != '')?$no_ends[$i]:'0';
                    $ends_heald[$i] = (array_key_exists($i, $ends_heald) && $ends_heald[$i] != '')?$ends_heald[$i]:'0';
                    $healds_dent[$i] = (array_key_exists($i, $healds_dent) && $healds_dent[$i] != '')?$healds_dent[$i]:'0';
                    $design_weave[$i] = (array_key_exists($i, $design_weave) && $design_weave[$i] != '')?$design_weave[$i]:'0';
                  }
                  $shade_name[4] = (isset($shade_name[4]))?$shade_name[4]:'';
                  $editdenier[4] = (isset($editdenier[4]))?$editdenier[4]:'';
                  $no_ends[4] = (isset($no_ends[4]))?$no_ends[4]:'';
                  ?>
                  <input type="hidden" name="combo_id" value="<?=$combo_id; ?>">
                  <div class="col-lg-12">
                    <section class="panel">
                      <header class="panel-heading">
                        Add Color Combos
                      </header>
                      <div class="panel-body">
                        <section id="unseen" class="table-wrapper">
                          <table id="table" class="table table-bordered table-striped table-condensed">
                            <thead>
                              <tr>
                                <th width="3%">Sno</th>
                                <th width="7%">WARP</th>
                                <th width="15%">Shade Name</th>
                                <th width="10%">Shade No</th>
                                <th width="10%">Denier / Guage</th>
                                <th width="5%"># of Ends</th>
                                <th width="5%"># Ends / Heald</th>
                                <th width="5%"># Heald / Dent</th>
                                <th width="10%">Weave</th>
                                <th width="5%">Net Weight</th>
                                <th width="5%">%</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="data">
                                <td>1</td>
                                <td>Warp 1</td>
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
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[0])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[0]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[0]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[0]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[0])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
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
                              <tr>
                                <td>2</td>
                                <td>Warp 2</td>
                                <td>
                                  <select class="select2 warp_2_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[1])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_2_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[1])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[1])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[1]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[1]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[1]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[1])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[1]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[1]; ?>" style="width:99%;">
                                </td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Warp 3</td>
                                <td>
                                  <select class="select2 warp_3_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[2])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_3_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[2])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[2])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[2]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[2]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[2]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[3])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[2]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[2]; ?>" style="width:99%;">
                                </td>
                              </tr>

                              <!-- 4th Row -->
                              <tr>
                                <td>4</td>
                                <td>Warp 4</td>
                                <td>
                                  <select class="select2 warp_4_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[3])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_4_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[3])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[3])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[3]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[3]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[3]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[3])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[3]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[3]; ?>" style="width:99%;">
                                </td>
                              </tr>

                              <!-- 5th Row -->
                              <tr>
                                <td>5</td>
                                <td>Warp 5</td>
                                <td>
                                  <select class="select2 warp_5_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[4])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_5_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[4])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[4])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[4]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[4]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[4]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[4])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[4]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[4]; ?>" style="width:99%;">
                                </td>
                              </tr>

                              <!-- 6th Row -->
                              <tr>
                                <td>6</td>
                                <td>Warp 6</td>
                                <td>
                                  <select class="select2 warp_6_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[5])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_6_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[5])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[5])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[5]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[5]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[5]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[5])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[5]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[5]; ?>" style="width:99%;">
                                </td>
                              </tr>

                              <!-- 7th Row -->
                              <tr>
                                <td>7</td>
                                <td>Warp7</td>
                                <td>
                                  <select class="select2 warp_7_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[6])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_7_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[6])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[6])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[6]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[6]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[6]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[6])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[6]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[6]; ?>" style="width:99%;">
                                </td>
                              </tr>

                              <!-- 8th Row -->
                              <tr>
                                <td>8</td>
                                <td>Warp 8</td>
                                <td>
                                  <select class="select2 warp_8_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[7])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_8_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[7])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[7])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[7]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[7]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[7]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[7])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[7]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[7]; ?>" style="width:99%;">
                                </td>
                              </tr>

                              <!-- 9th Row -->
                              <style type="text/css">
                                .color-red td
                                {
                                  background:#EF5555 !important; color:#fff;
                                }
                              </style>
                              <tr class="color-red">
                                <td>9</td>
                                <td>WEFT</td>
                                <td>
                                  <select class="select2 warp_9_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[8])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_9_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[8])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[8])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[8]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[8]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[8]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[8])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[8]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[8]; ?>" style="width:99%;">
                                </td>
                              </tr>
                              <tr class="color-red">
                                <td>10</td>
                                <td>RUBBER</td>
                                <td>
                                  <select class="select2 warp_10_shade" name="shade_name[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[9])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2 warp_10_shade" name="shade_code[]" style="width:99%;">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($shades as $shade) {
                                      ?>
                                      <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id'] == $shade_name[9])?'selected="selected"':''; ?>><?=$shade['shade_code'];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="select2" name="denier[]" style="width:99%;">
                                    <option value="">Select Denier</option>
                                    <?php
                                    foreach ($deniers as $denier) {
                                      ?>
                                      <option value="<?=$denier['denier_id']; ?>" <?=($denier['denier_id'] == $editdenier[9])?'selected="selected"':''; ?>><?=$denier['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="no_ends[]" value="<?=$no_ends[9]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="ends_heald[]" value="<?=$ends_heald[9]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <input type="text" name="healds_dent[]" value="<?=$healds_dent[9]; ?>" style="width:99%;">
                                </td>
                                <td>
                                  <select class="select2 form-control" name="design_weave[]">
                                    <option value="">Select Weave</option>
                                    <?php
                                    foreach ($weaves as $weave) {
                                      ?>
                                      <option value="<?=$weave['weave_id']; ?>" <?=($weave['weave_id'] == $design_weave[9])?'selected="selected"':''; ?>><?=$weave['weave_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" name="net_weight[]" value="<?=$net_weight[9]; ?>" style="width:99%;" readonly="readonly">
                                </td>
                                <td>
                                  <input type="text" name="percentage[]" value="<?=$percentage[9]; ?>" style="width:99%;">
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </section>
                      </div>
                    </section>
                    <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit" name="<?=($combo_id == '')?'save':'update'; ?>"><?=($combo_id == '')?'Save':'Update'; ?></button>
                            <button class="btn btn-default" type="button">Cancel</button>
                        </header>
                    </section>
                  </div>
                  </div>
                  </form>
                  <div class="row">
                   <div class="col-lg-12">
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

                              /*echo "<pre>";
                              print_r($shade_name);
                              echo "</pre>";*/

                              for ($i=0; $i < 10; $i++) {
                                $percentage[$i] = (array_key_exists($i, $percentage) && $percentage[$i] != '')?$percentage[$i]:'12';                                            $net_weight[$i] = (isset($net_weight[$i]))?$net_weight[$i]:'';
                                $no_beams[$i] = (array_key_exists($i, $no_beams) && $no_beams[$i] != '')?$no_beams[$i]:'1';
                                $ends_heald[$i] = (array_key_exists($i, $ends_heald) && $ends_heald[$i] != '')?$ends_heald[$i]:'0';
                                $healds_dent[$i] = (array_key_exists($i, $healds_dent) && $healds_dent[$i] != '')?$healds_dent[$i]:'0';
                                $design_weave[$i] = (array_key_exists($i, $design_weave) && $design_weave[$i] != '')?$design_weave[$i]:'0';
                              }

                              ?>
                              <form method="post" action="<?=base_url();?>masters/tech_advanced">
                              <a href="<?=base_url()?>masters/items_2_technical/<?=$item_id; ?>/<?=$colorcombo['combo_id']; ?>" class="btn btn-primary"><i class="icon-pencil"></i> Edit</a>
                              <a href="<?=base_url()?>masters/items_2_technical_delete/<?=$item_id; ?>/<?=$colorcombo['combo_id']; ?>" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>
                              <a href="<?=base_url()?>masters/items_2_technical_copy/<?=$item_id; ?>/<?=$colorcombo['combo_id']; ?>" class="btn btn-success"><i class="icon-copy"></i> Duplicate</a>
                              <button class="btn btn-default" type="submit" name="save">Beam Break up Settings</button>
                              <input type="hidden" name="combo_id" value="<?=$colorcombo['combo_id']; ?>">
                              <input type="hidden" name="item_id" value="<?=$item_id; ?>">
                              <div class="clear"></div> 
                              <h3>Color Combo <?=$combono; ?> - <?=$item_name; ?> - <?=$item_id; ?></h3>
                              <table id="table" class="table table-bordered table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th width="3%">Sno</th>
                                  <th width="7%">WARP</th>
                                  <th width="10%">Shade Name</th>
                                  <th width="5%">Shade No</th>
                                  <th width="5%">Denier / Guage</th>
                                  <th width="5%"># of Ends</th>
                                  <th width="3%"># Beams</th>
                                  <th width="3%"># Ends / Heald</th>
                                  <th width="5%"># Heald / Dent</th>
                                  <th width="14%">Weave</th>
                                  <th width="5%">Net Weight</th>
                                  <th width="5%">%</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $rowtitle = array('Warp 1', 'Warp 2', 'Warp 3', 'Warp 4', 'Warp 5', 'Warp 6', 'Warp 7', 'Warp 8', 'WEFT', 'RUBBER');
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
                                    <td>
                                      <input type="text" name="no_beams[]" style="width:100%;" value="<?=$no_beams[$key]; ?>">
                                    </td>
                                    <td><?=$ends_heald[$key]; ?></td>
                                    <td><?=$healds_dent[$key]; ?></td>
                                    <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_te_weaves', 'weave_id', $design_weave[$key], 'weave_name'); ?>
                                    </td>
                                    <td><?=$net_weight[$key]; ?></td>
                                    <td><?=$percentage[$key]; ?></td>
                                  </tr>
                                  <?php
                                }
                                ?>
                              </tbody>
                              </table>
                              </form>
                              <?php
                              $combono++;
                            }
                            ?>
                          </div>
                      </section>
                   </div>
                   <?php
                   ?>
                </div>                       <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading --> 
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

      <?php
      for ($i = 1; $i <= 10; $i++) {
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
    $(document).ajaxStart(function() {
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });


      $(function(){
      $("#item_group").change(function () {
          var item_group = $('#item_group').val();
          // alert(item_group);
          var url = "<?=base_url()?>purchase/getItems_2_datas/"+item_group;
          var postData = 'item_group='+item_group;
          $.ajax({
              type: "POST",
              url: url,
              // data: postData,
              success: function(groups)
              {
                  var dataArray = groups.split(',');
                  $('#item_name').html(dataArray[0]);
              }
          });
          return false;
      });
    }); 

    $(function(){
      $("#item_name").change(function () {
          var item_name = $('#item_name').val();
          window.location = '<?=base_url()?>masters/items_2_technical/'+item_name;
      });
    });

    $(function(){
      $("#item_code").blur(function () {
          var item_code = $('#item_code').val();
          window.location = '<?=base_url()?>masters/items_2_technical/'+item_code;
      });
    });

    $(function() {
        //    fancybox
          jQuery(".fancybox").fancybox();
      });
  </script>

  </body>
</html>
