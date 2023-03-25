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
                                <h3><i class="icon-signal"></i> Items Master</h3>
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
                                if(isset($item_id))
                                {
                                  $edititems = $this->m_masters->getmasterdetails('bud_quote_yarn_item','item_id', $item_id);
                                  foreach ($edititems as $item) {
                                    $item_category = $item['item_category'];
                                    $item_name = $item['item_name'];
                                    $item_group = $item['item_group'];
                                    $item_code = $item['item_code'];
                                    $item_uom = $item['item_uom'];
                                    $item_tax = $item['item_tax'];
                                    $item_reorder_level = $item['item_reorder_level'];
                                    $item_status = $item['item_status'];
                                    $hsn_code = $item['hsn_code'];
                                    $item_sample= $item['item_sample'];
                                  }
                                  $action = 'updateitems_yarn';
                                }
                                else
                                {
                                  $item_id = '';
                                  $item_category = '';
                                  $item_name = '';
                                  $item_group = '';
                                  $item_code = '';
                                  $item_uom = '';
                                  $item_tax = '';
                                  $item_reorder_level = '';
                                  $item_status = '';
                                  $item_sample= '';
                                  $action = 'saveitems_yarn';
                                  $hsn_code ='';
                                }
                                ?>                                                      <form class="cmxform form-horizontal tasi-form"  enctype="multipart/form-data" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/<?=$action; ?>">
                                    <input type="hidden" name="item_id" value="<?=$item_id; ?>">                                                                                                                                        <input type="hidden" name="item_category" value="<?=$item_category; ?>">                                                                                                                                        <div class="form-group col-lg-6">
                                        <label for="item_name" class="control-label col-lg-2">Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="item_name" name="item_name" value="<?=$item_name; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="item_group" class="control-label col-lg-2">Group</label>
                                        <div class="col-lg-10">
                                          <select class="select2 form-control" name="item_group" id="item_group" required>
                                            <option value="">Select Group</option>
                                            <?php
                                            $itemgroups = $this->m_masters->getactivemaster('bud_itemgroups', 'group_status');
                                            foreach ($itemgroups as $itemgroup) {
                                              ?>
                                              <option value="<?=$itemgroup['group_id']; ?>" <?=($item_group == $itemgroup['group_id'])?'selected="selected"':''; ?> ><?=$itemgroup['group_name']; ?></option>
                                              <?php
                                            }
                                            ?>                                                                           </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="denier_name" class="control-label col-lg-2">Denier</label>
                                        <div class="col-lg-10">
                                          <select class="select2 form-control" name="denier_name" id="denier_name" required>
                                            <option value="">Select Denier</option>
                                            <?php
                                              foreach ($deniers as $denier) {
                                                ?>
                                                <option value="<?=$denier['denier_id']; ?>" <?=($item_group == $denier['denier_id'])?'selected="selected"':''; ?> ><?=$denier['denier_name']; ?></option>
                                                <?php
                                              }
                                            ?>                                                                           </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="item_uom" class="control-label col-lg-2">UOM</label>
                                        <div class="col-lg-10">
                                          <select class="select2 form-control" name="item_uom" id="item_uom" required>
                                            <option value="">Select Uom</option>
                                            <?php
                                            $itemuoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
                                              foreach ($itemuoms as $itemuom) {
                                                ?>
                                                <option value="<?=$itemuom['uom_id']; ?>" <?=($item_uom == $itemuom['uom_id'])?'selected="selected"':''; ?> ><?=$itemuom['uom_name']; ?></option>
                                                <?php
                                              }
                                            ?>
                                          </select>
                                        </div>
                                    </div>
                                                                  <div class="form-group col-lg-6">
                                        <label for="item_reorder_level" class="control-label col-lg-2">HSN Code</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="hsn_code" name="hsn_code" value="<?=$hsn_code; ?>" type="number" required>
                                        </div>
                                    </div>                                                                                <div class="form-group col-lg-6">
                                        <label for="item_reorder_level" class="control-label col-lg-2">Item Sample </label>
                                        <div class="col-lg-10">
                                          <input class="form-control"  name="item_sample" type="file" required>
                                        </div>
                                    </div>  
                                    <div class="form-group col-lg-6">
                                        <label for="item_status" class="control-label col-lg-2">Active</label>
                                        <div class="">
                                            <input  type="checkbox" style="width: 20px;float:left;" <?=($item_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="item_status" name="item_status" />
                                        </div>
                                    </div>
                                    <?php
                                    if($item_sample != '')
                                    {
                                    	?>
                                    	<div class="form-group col-lg-6">
                                        <label for="item_status" class="control-label col-lg-2">Sample Image</label>
                                        <div class="">
                                           <img src="<?=base_url('uploads/quote').'/'.$item_sample;?>" height="100" width="100">
                                        </div>
                                    </div>
                                    	<?php
                                    }
                                    ?>
                                    <div class="clear"></div>
                                    <div class="form-group col-lg-6">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" type="submit"><?=($item_id != '')?'Update':'Save'; ?></button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>

                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Items
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                                  <th>Sno</th>
                                  <th>Name</th>
                                  <th>Code</th>
                                  <th>Group</th>
                                  <!-- <th>Category</th> -->
                                  <th>HSN Code </th>
                                  <th>UOM</th>
                                  <th>Tax</th>
                                  <th>Reorder</th>
                                  <th>Status</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($items as $item) {
                                ?>
                                <tr class="odd gradeX">
                                    <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                                    <td><?=$sno; ?></td>
                                    <td><?=$item['item_name']; ?></td>
                                    <td><?=$item['item_id']; ?></td>                                                                <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $item['item_group'], 'group_name'); ?>
                                    </td>
                                    <!-- <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_categories', 'category_id', $item['item_category'], 'category_name'); ?>
                                    </td> -->
                                    <td><?=$item['hsn_code']; ?></td>  
                                    <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['item_uom'], 'uom_name'); ?>
                                    </td>                                                               <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_tax', 'tax_id', $item['item_tax'], 'tax_name'); ?>
                                    </td>                                                             <td><?=$item['item_reorder_level']; ?></td>                                                               <td>
                                      <span class="<?=($item['item_status']==1)?'label label-success':'label label-danger'; ?>"><?=($item['item_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td>
                                      <a href="<?=base_url();?>masters/items_yarn/<?=$item['item_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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

      $(document).ajaxStart(function() {
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });
  </script>

  </body>
</html>
