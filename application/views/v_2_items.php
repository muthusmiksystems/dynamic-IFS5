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
                                ?>                                                                                      <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/items_2_save">
                                    <input type="hidden" name="item_category" value="<?=$this->session->userdata('user_viewed'); ?>">                                                                <div class="form-group col-lg-12">
                                        <label for="item_name" class="control-label col-lg-2">Item Code No / Art No:</label>
                                        <div class="col-lg-10">
                                          <span class="label label-danger" style="font-size:24px;"><?=$item_code; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_created_on" class="control-label col-lg-2">Date</label>
                                        <div class="col-lg-10">
                                          <input class="dateplugin form-control" value="<?=date('d-m-Y'); ?>" id="item_created_on" name="item_created_on" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_group" class="control-label col-lg-2">Group Name</label>
                                        <div class="col-lg-10">
                                          <select class="form-control select2" name="item_group" id="item_group" >
                                            <option value="">Select Group</option>
                                            <?php
                                            foreach ($itemgroups as $group) {
                                              ?>
                                              <option value="<?=$group['group_id']; ?>"><?=$group['group_name']; ?></option>
                                              <?php
                                            }
                                            ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_name" class="control-label col-lg-2">Item Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_name" name="item_name" type="text" >                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_second_name" class="control-label col-lg-2">Item Second Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_second_name" name="item_second_name" type="text" >                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_third_name" class="control-label col-lg-2">Item Third Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_third_name" name="item_third_name" type="text" >                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_third_name" class="control-label col-lg-2">Item Tax</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_tax" name="item_tax" type="text" >                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_third_name" class="control-label col-lg-2">Item Rate</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_rate" name="item_rate" type="text" >                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_third_name" class="control-label col-lg-2">HSN Code</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="hsn" name="hsn" type="number"  pattern="([1-9])+(?:-?\d){8,8}">                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_uom" class="control-label col-lg-2">UOM</label>
                                        <div class="col-lg-10">
                                          <select class="select2 form-control" name="item_umo" id="item_umo" >
                                            <option value="">Select Uom</option>
                                            <?php
                                            $itemuoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
                                              foreach ($itemuoms as $itemuom) {
                                                ?>
                                                <option value="<?=$itemuom['uom_id']; ?>" ><?=$itemuom['uom_name']; ?></option>
                                                <?php
                                              }
                                            ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_width" class="control-label col-lg-2">Item Width</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_width" name="item_width" type="text" >                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="total_metrs" class="control-label col-lg-2">Total Meters</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="total_metrs" name="total_metrs" type="text" >                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="total_weight" class="control-label col-lg-2">Total Weight (grams)</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="total_weight" name="total_weight" type="text" >                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_weight_mtr" class="control-label col-lg-2">Weight/Meter (grams)</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_weight_mtr" name="item_weight_mtr" type="text" >                                                                                                                     </div>
                                    </div>                                                                <div class="form-group col-lg-12">
                                        <label for="item_status" class="control-label col-lg-2">Active</label>
                                        <div class="col-lg-10">
                                            <input  type="checkbox" style="width: 20px;float:left;" checked="ckecked" class="checkbox form-control" value="1" id="item_status" name="item_status" />
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4">
                                       <label for="sample_file">Sample</label>
                                       <input class="form-control" id="sample_file" name="sample_file" type="file">
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="form-group col-lg-12">
                                        <div class="col-lg-10">
                                            <button class="btn btn-danger" type="submit">Save</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="itemlist">
                            <thead>
                              <tr>
                                  <th width="5%">#</th>
                                  <th width="10%">Date</th>
                                  <th width="15%">Group Name</th>
                                  <th width="5%">Item Code</th>
                                  <th width="15%">Item Name</th>
                                  <th width="10%">Second Name</th>
                                  <th width="10%">Third Name</th>
                                  <th width="10%"> HSN Code</th>
                                  <th width="5%">Width</th>
                                  <th width="10%">Wt/Meter</th>
                                  <th width="5%">Combos</th>
                                  <th width="10%">Status</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($items as $item) {
                                $ed = explode("-", $item['item_created_on']);
                                $item_created_on = $ed[2].'-'.$ed[1].'-'.$ed[0];
                                $colorcombos = $this->m_masters->getmasterdetails('bud_te_color_combos', 'item_id', $item['item_id']);
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$item_created_on; ?></td>                                                                <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_te_itemgroups', 'group_id', $item['item_group'], 'group_name'); ?>
                                    </td>
                                    <td><?=$item['item_id']; ?></td>                                                                <td><?=$item['item_name']; ?></td>                                                                <td><?=$item['item_second_name']; ?></td>                                                                <td><?=$item['item_third_name']; ?></td>  
                                    <td><?=$item['hsn_code']; ?></td>                                                           <td><?=$item['item_width']; ?></td>                                                                <td><?=$item['item_weight_mtr']; ?></td>                                                                <td><?=sizeof($colorcombos); ?></td>                                                                <td>
                                      <span class="<?=($item['item_status']==1)?'label label-success':'label label-danger'; ?>"><?=($item['item_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td>
                                      <a href="<?=base_url();?>masters/items_2_technical/<?=$item['item_id']?>" data-placement="top" data-original-title="Update Technical Data" data-toggle="tooltip" class="btn btn-success btn-xs tooltips"><i class="icon-table"></i></a>
                                      <a href="<?=base_url();?>masters/edititems_2/<?=$item['item_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <a href="<?=base_url();?>masters/deletemaster/bud_te_items/item_id/<?=$item['item_id']?>/masters/itemgroups_2" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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

      $(".col-sm-6.right").append('<div class="dataTables_filter col-sm-6" style="float:left;"><label>Search Item Code: <input type="text" class="form-control" id="itemcode_search" style="width:50%;"></label></div>');

      
  </script>

  </body>
</html>
