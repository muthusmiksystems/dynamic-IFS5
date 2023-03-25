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
                                <h3><i class="icon-signal"></i> Tare Weight Master</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Tare Weight Details
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
                                if(isset($tareweight_id))
                                {
                                  $edittareweights = $this->m_masters->getmasterdetails('bud_tareweights','tareweight_id', $tareweight_id);
                                  foreach ($edittareweights as $tareweight) {
                                    $tereweight_category = $tareweight['tereweight_category'];
                                    $tareweight_name = $tareweight['tareweight_name'];
                                    $tareweight_value = $tareweight['tareweight_value'];
                                    $tareweight_status = $tareweight['tareweight_status'];
                                  }
                                  $action = 'updatetareweights';
                                }
                                else
                                {
                                  $tareweight_id = '';
                                  $tereweight_category = '';
                                  $tareweight_name = '';
                                  $tareweight_value = '';
                                  $tareweight_status = '';
                                  $action = 'savetareweights';
                                }
                                ?>                                                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/<?=$action; ?>">
                                    <input type="hidden" name="tareweight_id" value="<?=$tareweight_id; ?>">                                                                                                                                        <div class="form-group">
                                        <label for="tareweight_name" class="control-label col-lg-2">Packing Meterial Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="tareweight_name" name="tareweight_name" value="<?=$tareweight_name; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tareweight_value" class="control-label col-lg-2">Weight</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="tareweight_value" name="tareweight_value" value="<?=$tareweight_value; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tareweight_status" class="control-label col-lg-2">Active</label>
                                        <div class="">
                                            <input  type="checkbox" style="width: 20px;float:left;" <?=($tareweight_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="tareweight_status" name="tareweight_status" />
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-lg-6">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" type="submit"><?=($tareweight_id != '')?'Update':'Save'; ?></button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Tare Weight List
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                                  <th>Sno</th>
                                  <th>Packing Meterial</th>
                                  <th>Weight</th>
                                  <th>Status</th>
                                  <th class="hidden-phone"></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($tareweights as $listrow) {
                                ?>
                                <tr class="odd gradeX">
                                    <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                                    <td><?=$sno; ?></td>
                                    <td><?=$listrow['tareweight_name']; ?></td>
                                    <td><?=$listrow['tareweight_value']; ?></td>
                                    <td class="hidden-phone">
                                      <span class="<?=($listrow['tareweight_status']==1)?'label label-success':'label label-danger'; ?>"><?=($listrow['tareweight_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td>
                                      <a href="<?=base_url(); ?>masters/tareweights/<?=$listrow['tareweight_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <a href="<?=base_url(); ?>masters/delete_tareweight/<?=$listrow['tareweight_id']?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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
