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
                                if(isset($item_id))
                                {
                                  $result = $this->m_masters->getmasterdetails('bud_quote_items', 'item_id', $item_id);
                                  foreach ($result as $row) {
                                    $item_id = $row['item_id'];
                                    $item_category = $row['item_category'];
                                    $item_group = $row['item_group'];
                                    $item_name = $row['item_name'];
                                    $item_second_name = $row['item_second_name'];
                                    $item_third_name = $row['item_third_name'];
                                    $item_width = $row['item_width'];                                                              $item_status = $row['item_status'];
                                    $item_sample = $row['item_sample'];
                                    $item_created_on = $row['item_created_on'];
                                    $hsn_code = $row['hsn_code'];
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
                                  $item_status = '';
                                  $item_created_on = date("d-m-Y");
                                  $item_sample = '';
                                  $hsn_code = '';
                                }
                                ?>                                                                                      <form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/save_item_4">
                                    <input type="hidden" name="item_id" value="<?=$item_id; ?>">                                                                <div class="form-group col-lg-12">
                                        <label for="item_name" class="control-label col-lg-2">Item Code No / Art No:</label>
                                        <div class="col-lg-10">
                                          <span class="label label-danger" style="font-size:24px;"><?=$item_code; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_created_on" class="control-label col-lg-2">Date</label>
                                        <div class="col-lg-10">
                                          <input class="dateplugin form-control" value="<?=$item_created_on; ?>" id="item_created_on" name="formData[item_created_on]" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_group" class="control-label col-lg-2">Group Name</label>
                                        <div class="col-lg-10">
                                          <select class="form-control select2" name="formData[item_group]" id="item_group" required>
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
                                          <input class="form-control" value="<?=$item_name; ?>" id="item_name" name="formData[item_name]" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_second_name" class="control-label col-lg-2">Item Second Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" value="<?=$item_second_name; ?>" id="item_second_name" name="formData[item_second_name]" type="text" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_third_name" class="control-label col-lg-2">Item Third Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" value="<?=$item_third_name; ?>" id="item_third_name" name="formData[item_third_name]" type="text" required>                                                                                                                     </div>
                                    </div>
                                      <div class="form-group col-lg-12">
                                        <label for="item_third_name" class="control-label col-lg-2">HSN Code</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" value="<?=$hsn_code; ?>" id="hsn_code" name="formData[hsn_code]" type="number" required>                                                                                                                     </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="item_width" class="control-label col-lg-2">Item Width</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" value="<?=$item_width; ?>" id="item_width" name="formData[item_width]" type="text" required>                                                                                                                     </div>
                                    </div>                                                              <div class="form-group col-lg-12">
                                        <label for="item_status" class="control-label col-lg-2">Active</label>
                                        <div class="col-lg-10">
                                            <input  type="checkbox" style="width: 20px;float:left;" checked="ckecked" class="checkbox form-control" <?=($item_status == 1)?'checked="ckecked"':''; ?> value="1" id="item_status" name="formData[item_status]" />
                                        </div>
                                    </div>
                                    <div style="clear:both;" class="clear"></div>
                                    <div class="form-group col-lg-4">
                                       <label for="sample_file">Sample</label>
                                       <input type="hidden" name="old_item_sample" value="<?=$item_sample; ?>">
                                       <input class="form-control" id="sample_file" name="sample_file" type="file">
                                    </div>
                                    <?php
                                    if($item_sample != '')
                                    {
                                      ?>
                                      <div class="form-group col-lg-8">
                                        <img src="<?=base_url(); ?>uploads/quote/<?=$item_sample; ?>" style="width:auto;height:100px;max-width:100%;">
                                      </div>
                                      <?php
                                    }
                                    ?>
                                    <div style="clear:both;" class="clear"></div>
                                    <div class="form-group col-lg-12">
                                        <div class="col-lg-offset-2 col-lg-10">
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
                                  <th width="10%">HSN Code</th>
                                  <th width="5%">Width</th>
                                  <th width="10%">Wt/100 Pcs</th>
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
                                      <?=$this->m_masters->getmasterIDvalue('bud_lbl_itemgroups', 'group_id', $item['item_group'], 'group_name'); ?>
                                    </td>
                                    <td><?=$item['item_id']; ?></td>                                                                <td><?=$item['item_name']; ?></td>                                                                <td><?=$item['item_second_name']; ?></td>                                                                <td><?=$item['item_third_name']; ?></td>  
                                    <td><?=$item['hsn_code']; ?></td>                                                         <td><?=$item['item_width']; ?></td>                                                                <td><?=$item['weight_100_pcs']; ?></td>                                                                <td><?=sizeof($colorcombos); ?></td>                                                                <td>
                                      <span class="<?=($item['item_status']==1)?'label label-success':'label label-danger'; ?>"><?=($item['item_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td>
                                      <a href="<?=base_url();?>masters/items_2_technical/<?=$item['item_id']?>" data-placement="top" data-original-title="Update Technical Data" data-toggle="tooltip" class="btn btn-success btn-xs tooltips"><i class="icon-table"></i></a>
                                      <a href="<?=base_url();?>masters/items_4/<?=$item['item_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <a href="<?=base_url();?>masters/deletemaster/bud_te_items/item_id/<?=$item['item_id']?>/itemgroups_2" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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
