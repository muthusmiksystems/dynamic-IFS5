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
                                <h3><i class="icon-signal"></i> Tax Master</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Tax Details
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
                                if(isset($tax_id))
                                {
                                  $edittax = $this->m_masters->getmasterdetails('bud_tax','tax_id', $tax_id);
                                  foreach ($edittax as $tax) {
                                    $tax_category = $tax['tax_category'];
                                    $tax_name = $tax['tax_name'];
                                    $tax_value = $tax['tax_value'];
                                    $tax_description = $tax['tax_description'];
                                    $tax_status = $tax['tax_status'];
                                  }
                                  $action = 'updatetax';
                                }
                                else
                                {
                                  $tax_id = '';
                                  $tax_category = '';
                                  $tax_name = '';
                                  $tax_value = '';
                                  $tax_description = '';
                                  $tax_status = '';
                                  $action = 'savetax';
                                }
                                ?>                                                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/<?=$action; ?>">
                                    <input type="hidden" name="tax_id" value="<?=$tax_id; ?>">                                                                                                    <div class="form-group col-lg-6">
                                        <label for="tax_category" class="control-label col-lg-2">Category</label>
                                        <div class="col-lg-10">
                                          <select class="form-control" name="tax_category" id="tax_category" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($categories as $category) {
                                              ?>
                                              <option value="<?=$category['category_id']; ?>" <?=($tax_category == $category['category_id'])?'selected="selected"':''; ?> ><?=$category['category_name']; ?></option>
                                              <?php
                                            }
                                            ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="tax_name" class="control-label col-lg-2">Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="tax_name" name="tax_name" value="<?=$tax_name; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="tax_value" class="control-label col-lg-2">Tax</label>
                                        <div class="col-lg-10">
                                          <div class="input-group">
                                                <input type="text" class="form-control" name="tax_value" id="tax_value" value="<?=$tax_value; ?>" required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="tax_description" class="control-label col-lg-2">Description</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="tax_description" name="tax_description" value="<?=$tax_description; ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="tax_status" class="control-label col-lg-2">Active</label>
                                        <div class="">
                                            <input  type="checkbox" style="width: 20px;float:left;" <?=($tax_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="tax_status" name="tax_status" />
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-lg-6">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" type="submit"><?=($tax_id != '')?'Update':'Save'; ?></button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Tax List
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                                  <th>Sno</th>
                                  <th>Name</th>
                                  <th>Percentage</th>
                                  <th>Description</th>
                                  <th>Category</th>
                                  <th>Status</th>
                                  <th class="hidden-phone"></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($taxlist as $taxrow) {
                                ?>
                                <tr class="odd gradeX">
                                    <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                                    <td><?=$sno; ?></td>
                                    <td><?=$taxrow['tax_name']?></td>
                                    <td><?=$taxrow['tax_value']?> % </td>
                                    <td><?=$taxrow['tax_description']?></td>
                                    <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_categories', 'category_id', $taxrow['tax_category'], 'category_name'); ?>
                                    </td>                                                                <td class="hidden-phone">
                                      <span class="<?=($taxrow['tax_status']==1)?'label label-success':'label label-danger'; ?>"><?=($taxrow['tax_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td>
                                      <a href="<?=base_url();?>masters/tax/<?=$taxrow['tax_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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

  </script>

  </body>
</html>
