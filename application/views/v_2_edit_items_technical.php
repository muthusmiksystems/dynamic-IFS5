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
                                <h3><i class="icon-map-marker"></i> Item Master</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Item Details
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
                                foreach ($items as $item) {
                                  $item_id = $item['item_id'];
                                  $item_category = $item['item_category'];
                                  $item_group = $item['item_group'];
                                  $item_name = $item['item_name'];
                                  $item_width = $item['item_width'];
                                  $item_shade = explode("|", $item['item_shade']);
                                  $item_no_of_ends = explode("|", $item['item_no_of_ends']);
                                  $item_denier = explode("|", $item['item_denier']);
                                  $item_binder_shade = explode("|", $item['item_binder_shade']);
                                  $item_binder_no_of_ends = explode("|", $item['item_binder_no_of_ends']);
                                  $item_binder_denier = explode("|", $item['item_binder_denier']);
                                  $item_status = $item['item_status'];
                                }
                                foreach ($item_shade as $key => $value) {
                                  $item_shades[$key] = explode(",", $value);
                                }
                                foreach ($item_no_of_ends as $key => $value) {
                                  $no_of_ends[$key] = explode(",", $value);
                                }
                                foreach ($item_denier as $key => $value) {
                                  $deniers[$key] = explode(",", $value);
                                }
                                ?>
                                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/items_2_update">                                                                <input type="hidden" name="item_id" value="<?=$item_id; ?>">                                                                <input type="hidden" name="item_category" value="<?=$item_category; ?>">                                                                                            <div class="form-group col-lg-12">
                                        <label for="item_group" class="control-label col-lg-2">Group Name</label>
                                        <div class="col-lg-10">
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
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_name" class="control-label col-lg-2">Item Name</label>
                                        <div class="col-lg-10">
                                          <?php
                                          $items = $this->m_masters->getactiveCdatas('bud_te_items', 'item_status', 'item_group', $group_id);
                                          ?>
                                          <select class="select2 form-control" name="item_name" id="item_name">
                                            <option value="">Select Item</option> 
                                            <?php
                                            foreach ($items as $item) {
                                              ?>
                                              <option value="<?=$item['item_id']; ?>" <?=($item['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$item['item_name']; ?></option>
                                              <?php
                                            }
                                            ?>                                                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_width" class="control-label col-lg-2">Item Width</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_width" name="item_width" value="<?=$item_width; ?>" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="control-label col-lg-2">Color Data 1</label>
                                        <div class="col-lg-10">
                                          <div class="form-group col-lg-2">
                                            <label>Col - 1</label>
                                            &nbsp;
                                            <!-- <input class="form-control"  type="text" placeholder=""> -->                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="shade[1][1]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_shades[0][0])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>                                                                </div>                                                                            <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="no_of_ends[1][1]" value="<?=$no_of_ends[0][0]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="denier[1][1]" value="<?=$deniers[0][0]; ?>" type="text" placeholder="">                                                                  </div>

                                          <div style="clear:both;"></div>

                                          <div class="form-group col-lg-2">
                                            <label>Col - 2</label>
                                            &nbsp;                                                              </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="shade[1][2]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_shades[0][1])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>
                                          </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="no_of_ends[1][2]" value="<?=$no_of_ends[0][1]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="denier[1][2]" value="<?=$deniers[0][1]; ?>" type="text" placeholder="">                                                                  </div>

                                          <div style="clear:both;"></div>

                                          <div class="form-group col-lg-2">
                                            <label>Col - 3</label>
                                            &nbsp;                                                              </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="shade[1][3]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_shades[0][2])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="no_of_ends[1][3]" value="<?=$no_of_ends[0][2]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="denier[1][3]" value="<?=$deniers[0][2]; ?>" type="text" placeholder="">                                                                  </div>

                                          <div style="clear:both;"></div>

                                          <div class="form-group col-lg-2">
                                            <label>Col - 4</label>
                                            &nbsp;                                                              </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="shade[1][4]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_shades[0][3])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="no_of_ends[1][4]" value="<?=$no_of_ends[0][3]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="denier[1][4]" value="<?=$deniers[0][3]; ?>" type="text" placeholder="">                                                                  </div>

                                          <div style="clear:both;"></div>

                                          <div class="form-group col-lg-2">
                                            <label>Binder</label>
                                            &nbsp;                                                              </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="binder_shade[1]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_binder_shade[0])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>
                                          </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="binder_no_of_ends[1]" value="<?=$item_binder_no_of_ends[0]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="binder_denier[1]" value="<?=$item_binder_denier[0]; ?>" type="text" placeholder="">                                                                  </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label class="control-label col-lg-2">Color Data 2</label>
                                        <div class="col-lg-10">
                                          <div class="form-group col-lg-2">
                                            <label>Col - 1</label>
                                            &nbsp;
                                            <!-- <input class="form-control"  type="text" placeholder=""> -->                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="shade[2][1]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_shades[1][0])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="no_of_ends[2][1]" value="<?=$no_of_ends[1][0]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="denier[2][1]" value="<?=$deniers[1][0]; ?>" type="text" placeholder="">                                                                  </div>

                                          <div style="clear:both;"></div>

                                          <div class="form-group col-lg-2">
                                            <label>Col - 2</label>
                                            &nbsp;                                                              </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="shade[2][2]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_shades[1][1])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="no_of_ends[2][2]" value="<?=$no_of_ends[1][1]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="denier[2][2]" value="<?=$deniers[1][1]; ?>" type="text" placeholder="">                                                                  </div>

                                          <div style="clear:both;"></div>

                                          <div class="form-group col-lg-2">
                                            <label>Col - 3</label>
                                            &nbsp;                                                              </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="shade[2][3]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_shades[1][2])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="no_of_ends[2][3]" value="<?=$no_of_ends[1][2]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="denier[2][3]" value="<?=$deniers[1][2]; ?>" type="text" placeholder="">                                                                  </div>

                                          <div style="clear:both;"></div>

                                          <div class="form-group col-lg-2">
                                            <label>Col - 4</label>
                                            &nbsp;                                                              </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="shade[2][4]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_shades[1][3])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>                                                                 </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="no_of_ends[2][4]" value="<?=$no_of_ends[1][3]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="denier[2][4]" value="<?=$deniers[1][3]; ?>" type="text" placeholder="">                                                                  </div>

                                          <div style="clear:both;"></div>

                                          <div class="form-group col-lg-2">
                                            <label>Binder</label>
                                            &nbsp;                                                              </div>
                                          <div class="form-group col-lg-3">
                                            <label>Shade</label>
                                            <select class="form-control select2"  name="binder_shade[2]" type="text" placeholder="">
                                              <option value="">Select</option>
                                              <?php
                                              foreach ($shades as $shade) {
                                                ?>
                                                <option value="<?=$shade['shade_id'];?>" <?=($shade['shade_id']==$item_binder_shade[1])?'selected="selected"':''; ?>><?=$shade['shade_name'];?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>                                                                </div>
                                          <div class="form-group col-lg-3">
                                            <label>No of Ends</label>
                                            <input class="form-control"  name="binder_no_of_ends[2]" value="<?=$item_binder_no_of_ends[1]; ?>" type="text" placeholder="">                                                                  </div>
                                          <div class="form-group col-lg-3">
                                            <label>Denier</label>
                                            <input class="form-control"  name="binder_denier[2]" value="<?=$item_binder_denier[1]; ?>" type="text" placeholder="">                                                                  </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="group_status" class="control-label col-lg-2">Active</label>
                                        <div class="col-lg-10">
                                            <input  type="checkbox" style="width: 20px;float:left;" checked="ckecked" class="checkbox form-control" value="1" id="group_status" name="group_status" />
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-lg-12">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" type="submit">Save</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <!-- End Form Section -->
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
