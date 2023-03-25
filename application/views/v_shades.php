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
                                <h3><i class="icon-user"></i> Add New Shade</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <?php
                      if(isset($shade_id))
                      {
                        $editshades = $this->m_masters->getmasterdetails('bud_shades','shade_id', $shade_id);
                        foreach ($editshades as $shade) {
                          $shade_name = $shade['shade_name'];
                          $shade_second_name = $shade['shade_second_name'];
                          $shade_third_name = $shade['shade_third_name'];
                          $shade_fourth_name = $shade['shade_fourth_name'];
                          $shade_code = $shade['shade_code'];
                          $shade_status = $shade['shade_status'];
                          $shade_family = explode(",", $shade['shade_family']);
                          $shade_customers = explode(",", $shade['shade_customers']);
                        }
                        $action = 'updateshades';
                      }
                      else
                      {
                        $shade_id = '';
                        $shade_name = '';
                        $shade_second_name = '';
                        $shade_third_name = '';
                        $shade_fourth_name = '';
                        $shade_code = '';
                        $shade_family = array();
                        $shade_customers = array();
                        $shade_status = '';
                        $action = 'saveshades';
                      }
                      ?> 
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/<?=$action; ?>">
                        <section class="panel">
                            <header class="panel-heading">
                                Shade Details
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
                                <input type="hidden" name="shade_id" value="<?=$shade_id; ?>">                                                                                                                        <div class="form-group col-lg-4">
                                    <label for="shade_family">Color Family</label>
                                    <select class="select2 form-control" multiple="multiple" name="shade_family[]" required>
                                      <?php
                                      $colors = $this->m_masters->getactivemaster('bud_color_families', 'family_status');
                                      foreach ($colors as $color) {
                                        ?>
                                        <option value="<?=$color['family_id']; ?>" <?=(in_array($color['family_id'], $shade_family))?'selected="selected"':''; ?> ><?=$color['family_name']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="shade_name">Color Name</label>
                                   <input class="form-control" id="shade_name" name="shade_name" value="<?=$shade_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="shade_second_name">Second Name</label>
                                   <input class="form-control" id="shade_second_name" name="shade_second_name" value="<?=$shade_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="shade_third_name">Third Name</label>
                                   <input class="form-control" id="shade_third_name" name="shade_third_name" value="<?=$shade_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="shade_fourth_name">Fourth Name</label>
                                   <input class="form-control" id="shade_fourth_name" name="shade_fourth_name" value="<?=$shade_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="shade_code">Shade Code</label>
                                   <input class="form-control" id="shade_code" name="shade_code" value="<?=$shade_code; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="shade_code">Customers</label>
                                   <select class="select2 form-control" name="shade_customers[]" multiple="multiple">
                                   <?php
                                   $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
                                   foreach ($customers as $customer) {
                                     ?>
                                     <option value="<?=$customer['cust_id'];?>" <?=(in_array($customer['cust_id'], $shade_customers))?'selected="selected"':''; ?>><?=$customer['cust_name'];?></option>
                                     <?php
                                   }
                                   ?>
                                   </select>
                                </div>                                                        <div class="form-group col-lg-4">
                                    <label for="shade_status">Active</label>
                                    <input  type="checkbox" style="width: 20px;" <?=($shade_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="shade_status" name="shade_status" />                                                            </div>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit"><?=($shade_id != '')?'Update':'Save'; ?></button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form>
                      <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            Shades
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                                <th>Sno</th>
                                <th>Name 1</th>
                                <th>Name 2</th>
                                <th>Name 3</th>
                                <th>Name 4</th>
                                <th>Code</th>
                                <th>Costomers</th>
                                <th>Status</th>
                                <th class="hidden-phone"></th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($shades as $shade) {
                              $shade_customers = explode(",", $shade['shade_customers']);
                              $customer_data = array();
                              foreach ($shade_customers as $key => $value) {
                                $customer_data[] = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $value, 'cust_name');
                              }
                              ?>
                              <tr class="odd gradeX">
                                  <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                                  <td><?=$sno; ?></td>
                                  <td><?=$shade['shade_name']?></td>
                                  <td><?=$shade['shade_second_name']?></td>
                                  <td><?=$shade['shade_third_name']?></td>
                                  <td><?=$shade['shade_fourth_name']?></td>
                                  <td><?=$shade['shade_code']?></td>                                                              <td><?=implode(",", $customer_data); ?></td>                                                           <td class="hidden-phone">
                                    <span class="<?=($shade['shade_status']==1)?'label label-success':'label label-danger'; ?>"><?=($shade['shade_status']==1)?'Active':'Inactive'; ?></span>
                                  </td>
                                  <td>
                                    <a href="<?=base_url();?>masters/shades/<?=$shade['shade_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });
      $(function(){
        $("#shade_category").change(function () {
            var shade_category = $('#shade_category').val();
            var url = "<?=base_url()?>masters/getshadesdatas/"+shade_category;
            var postData = 'shade_category='+shade_category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(shades)
                {
                    var dataArray = shades.split(',');
                    $("#shade_family").html(dataArray[0]);
                    $(".shade_uoms").html(dataArray[1]);
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
