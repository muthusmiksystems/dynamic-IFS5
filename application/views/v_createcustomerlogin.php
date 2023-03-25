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
                      }                                                if($this->session->flashdata('error'))
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
                      $logged_user_id = $this->session->userdata('user_id');
                      ?>                     

                      <?php
                      if(isset($cust_login_id))
                      {
                        $editcolors = $this->m_masters->getmasterdetails('bud_cust_logins','cust_login_id', $cust_login_id);
                        foreach ($editcolors as $color) {
                          $cust_id = $color['cust_id'];
                          $cust_username = $color['cust_username'];
                          $cust_password = $color['cust_password'];
                        }
                      }
                      else
                      {
                        $cust_login_id = '';
                        $cust_id = '';
                        $cust_username = '';
                        $cust_password = '';
                      }
                      ?> 
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>users/createcustlogin_save">
                        <section class="panel">
                            <header class="panel-heading">
                                Shade Details
                            </header>
                                                <div class="panel-body">                                                        <input type="hidden" name="cust_login_id" value="<?=$cust_login_id; ?>">
                                                        <div class="form-group col-lg-12">
                                    <label for="customer_id" class="control-label col-lg-2">Customer Name</label>
                                    <div class="col-lg-10">
                                      <select class="select2 form-control" name="customer_id" id="customer_id" required>
                                        <option value="">Select Customer</option>
                                        <?php
                                        foreach ($customers as $customer) {
                                          ?>
                                          <option value="<?=$customer['cust_id']; ?>" <?=($customer['cust_id'] == $cust_id)?'selected="selected"':''; ?>><?=$customer['cust_name']; ?></option>
                                          <?php
                                        }
                                        ?>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="cust_username" class="control-label col-lg-2">User Name</label>
                                    <div class="col-lg-10">
                                      <input type="hidden" name="old_cust_username" value="<?=$cust_username; ?>">
                                      <input class="form-control" id="cust_username" name="cust_username" value="<?=$cust_username; ?>" type="text" required placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="cust_password" class="control-label col-lg-2">Password</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" id="cust_password" name="cust_password" value="<?=$cust_password; ?>" type="password" required placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" <?=($cust_login_id != '')?'name="update"':'save'; ?>><?=($cust_login_id != '')?'Update':'Save'; ?></button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form>

                      <section class="panel">
                          <header class="panel-heading">
                              Users
                          </header>
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <th>Sno</th>
                                  <th>Customer Name</th>
                                  <th>Username</th>
                                  <th>Password</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($cust_logins as $cust_login) {
                                ?>
                                <tr class="odd gradeX">
                                    <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                                    <td><?=$sno; ?></td>
                                    <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $cust_login['cust_id'], 'cust_name'); ?>
                                    </td>
                                    <td><?=$cust_login['cust_username']; ?></td>
                                    <td><?=$cust_login['cust_password']; ?></td>
                                    <td>
                                      <?php
                                      $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
                                      if($is_admin)
                                      {
                                        ?>
                                        <!-- <a href="<?=base_url();?>users/manage_user_privileges/<?=$user['ID']?>" data-placement="top" data-original-title="Manage User Privileges" data-toggle="tooltip" class="btn btn-success btn-xs tooltips"><i class="icon-key"></i></a> -->
                                        <a href="<?=base_url();?>users/createcustomerlogin/<?=$cust_login['cust_login_id']; ?>" data-placement="top" data-original-title="Edit Profile" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                        <a href="<?=base_url();?>users/deletecustlogin/<?=$cust_login['cust_login_id']; ?>" data-placement="top" data-original-title="Delete Profile" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
                                        <?php
                                      }
                                      else
                                      {
                                        $is_edit_privileged = $this->m_users->is_privileged('edit', 'upriv_function', $logged_user_id);
                                        if($is_edit_privileged)
                                        {
                                          ?>
                                          <a href="<?=base_url();?>users/edit/<?=$user['ID']?>" data-placement="top" data-original-title="Edit Profile" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                          <?php
                                        }
                                        $is_delete_privileged = $this->m_users->is_privileged('delete', 'upriv_function', $logged_user_id);
                                        if($is_delete_privileged)
                                        {
                                          ?>
                                          <a href="<?=base_url();?>users/delete/<?=$user['ID']?>" data-placement="top" data-original-title="Delete Profile" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
                                          <?php
                                        }
                                      }
                                      ?>
                                    </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>
                            </tbody>
                          </table>
                          <!-- Modal -->
                          <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title">Modal Tittle</h4>
                                      </div>
                                      <div class="modal-body">

                                          Body goes here...

                                      </div>
                                      <div class="modal-footer">
                                          <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                          <button class="btn btn-warning" type="button"> Confirm</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- modal -->
                      </section>
                  </div>
              </div>
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
    <script type="text/javascript">
       $(".select2").select2();
    </script>
  </body>
</html>
