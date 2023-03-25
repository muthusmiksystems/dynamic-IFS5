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
                                <h3><i class="icon-map-marker"></i> Add New Category</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Category Details
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
                                if(isset($category_id))
                                {
                                  $editcategory = $this->m_masters->getcategorydetails($category_id);
                                  foreach ($editcategory as $category) {
                                    $category_parent = $category['category_parent'];
                                    $category_name = $category['category_name'];
                                    $category_parent = $category['category_parent'];
                                    $category_status = $category['category_status'];
                                  }
                                  $action = 'updatecategory';
                                }
                                else
                                {
                                  $category_id = '';
                                  $category_parent = '';
                                  $category_name = '';
                                  $category_status = '';
                                  $action = 'savecategory';
                                }
                                ?>                                                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/<?=$action; ?>">
                                    <input type="hidden" name="category_id" value="<?=$category_id; ?>">
                                    <div class="form-group col-lg-12">
                                        <label for="category_parent" class="control-label col-lg-2">Category Parent</label>
                                        <div class="col-lg-10">
                                          <select class="form-control m-bot15" name="category_parent" id="category_parent">
                                            <option value="0">Select Parent</option>
                                            <?php
                                            foreach ($categories as $category) {
                                              ?>
                                              <option value="<?=$category['category_id']; ?>" <?=($category_parent == $category['category_id'])?'selected="selected"':''; ?>><?=$category['category_name']; ?></option>
                                              <?php
                                            }
                                            ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="category_name" class="control-label col-lg-2">Category Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="category_name" name="category_name" value="<?=$category_name; ?>" type="text" required>                                                                                                                     </div>
                                    </div>                                                                <div class="form-group col-lg-12">
                                        <label for="category_status" class="control-label col-lg-2">Active</label>
                                        <div class="col-lg-10">
                                            <input  type="checkbox" style="width: 20px;float:left;" <?=($category_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="category_status" name="category_status" />
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-lg-12">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" type="submit"><?=($category_id != '')?'Update':'Save'; ?></button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Categories
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                                  <th>Sno</th>
                                  <th>Category Name</th>
                                  <th>Status</th>
                                  <th class="hidden-phone"></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($categories as $category) {
                                ?>
                                <tr class="odd gradeX">
                                    <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                                    <td><?=$sno; ?></td>
                                    <td><?=$category['category_name']?></td>                                                                <td class="hidden-phone">
                                      <span class="<?=($category['category_status']==1)?'label label-success':'label label-danger'; ?>"><?=($category['category_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td>
                                      <a href="<?=base_url();?>masters/categories/<?=$category['category_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <a href="<?=base_url();?>masters/deletecategory/<?=$category['category_id']?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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
