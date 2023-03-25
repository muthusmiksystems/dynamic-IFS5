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
                                <h3><i class="icon-signal"></i> Agents Master</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Agent Details
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
                                if(isset($agent_id))
                                {
                                  $editagents = $this->m_masters->getmasterdetails('bud_agents','agent_id', $agent_id);
                                  foreach ($editagents as $tareweight) {
                                    $agent_category = $tareweight['agent_category'];
                                    $agent_name = $tareweight['agent_name'];
                                    $agent_address = $tareweight['agent_address'];
                                    $agent_city = $tareweight['agent_city'];
                                    $agent_pincode = $tareweight['agent_pincode'];
                                    $agent_phone = $tareweight['agent_phone'];
                                    $agent_fax = $tareweight['agent_fax'];
                                    $agent_email = $tareweight['agent_email'];
                                    $agent_status = $tareweight['agent_status'];
                                  }
                                  $action = 'updateagents';
                                }
                                else
                                {
                                  $agent_id = '';
                                  $agent_category = '';
                                  $agent_name = '';
                                  $agent_address = '';
                                  $agent_city = '';
                                  $agent_pincode = '';
                                  $agent_phone = '';
                                  $agent_fax = '';
                                  $agent_email = '';
                                  $agent_status = '';
                                  $action = 'saveagents';
                                }
                                ?>                                                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/<?=$action; ?>">
                                    <input type="hidden" name="agent_id" value="<?=$agent_id; ?>">                                                                                                    <div class="form-group col-lg-6">
                                        <label for="agent_category" class="control-label col-lg-2">Category</label>
                                        <div class="col-lg-10">
                                          <select class="form-control" name="agent_category" id="agent_category" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($categories as $category) {
                                              ?>
                                              <option value="<?=$category['category_id']; ?>" <?=($agent_category == $category['category_id'])?'selected="selected"':''; ?> ><?=$category['category_name']; ?></option>
                                              <?php
                                            }
                                            ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="agent_name" class="control-label col-lg-2">Name</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="agent_name" name="agent_name" value="<?=$agent_name; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="agent_address" class="control-label col-lg-2">Address</label>
                                        <div class="col-lg-10">
                                          <textarea class="form-control " id="agent_address" name="agent_address"><?=$agent_address; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="agent_city" class="control-label col-lg-2">City</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="agent_city" name="agent_city" value="<?=$agent_city; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="agent_pincode" class="control-label col-lg-2">Pincode</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="agent_pincode" name="agent_pincode" value="<?=$agent_pincode; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="agent_phone" class="control-label col-lg-2">Phone</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="agent_phone" name="agent_phone" value="<?=$agent_phone; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="agent_fax" class="control-label col-lg-2">Fax</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="agent_fax" name="agent_fax" value="<?=$agent_fax; ?>" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="agent_email" class="control-label col-lg-2">Email</label>
                                        <div class="col-lg-10">
                                          <input class="form-control" id="agent_email" name="agent_email" value="<?=$agent_email; ?>" type="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="agent_status" class="control-label col-lg-2">Active</label>
                                        <div class="">
                                            <input  type="checkbox" style="width: 20px;float:left;" <?=($agent_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="agent_status" name="agent_status" />
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="form-group col-lg-6">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-danger" type="submit"><?=($agent_id != '')?'Update':'Save'; ?></button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Agents List
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                                  <th>Sno</th>
                                  <th>Name</th>
                                  <th>Address</th>
                                  <th>Phone</th>
                                  <th>Email</th>
                                  <th>Category</th>
                                  <th>Status</th>
                                  <th class="hidden-phone"></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($agents as $agent) {
                                ?>
                                <tr class="odd gradeX">
                                    <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                                    <td><?=$sno; ?></td>
                                    <td><?=$agent['agent_name']; ?></td>
                                    <td><?=$agent['agent_address']; ?></td>                                                                <td><?=$agent['agent_phone']; ?></td>                                                                <td><a href="mailto:<?=$agent['agent_email']; ?>"><?=$agent['agent_email']; ?></a></td>                                                                <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_categories', 'category_id', $agent['agent_category'], 'category_name'); ?>
                                    </td>                                                                <td>
                                      <span class="<?=($agent['agent_status']==1)?'label label-success':'label label-danger'; ?>"><?=($agent['agent_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td class="hidden-phone">
                                      <a href="<?=base_url(); ?>masters/agents/<?=$agent['agent_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <a href="<?=base_url(); ?>masters/delete_agents/<?=$agent['agent_id']?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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
