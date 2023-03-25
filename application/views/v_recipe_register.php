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
    


      <?php
      foreach ($js_IE as $path) {
        ?>
        <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
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
                                <h3><i class="icon-user"></i> Recipe Register</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">                                    <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>reports/recipe_register">
                        <section class="panel">
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
                                <div class="form-group col-lg-4">
                                    <label for="shade_family">Shade Family</label>
                                    <select class="select2 form-control" name="family_id" id="shade_family">
                                      <option value="">Select Family</option>
                                      <?php
                                      $colors = $this->m_masters->getactivemaster('bud_color_families', 'family_status');
                                      foreach ($colors as $color) {
                                        ?>
                                        <option value="<?=$color['family_id']; ?>" <?=($color['family_id'] == $family_id)?'selected="selected"':''; ?>><?=$color['family_name']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="shade_name">Shade Name</label>
                                    <select class="select2 form-control shade" name="shade_id" id="shade_name">
                                      <option value="">Select Shade</option>
                                      <?php                                                                    foreach ($shades as $shade) {
                                        ?>
                                        <option value="<?=$shade['shade_id']; ?>" <?=($shade['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$shade['shade_name']; ?> / <?=$shade['shade_id']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="shade_code">Shade Code</label>
                                    <select class="select2 form-control shade" name="shade_code" id="shade_code">
                                      <option value="">Select Code</option>
                                      <?php
                                      foreach ($shades as $shade) {
                                        ?>
                                        <option value="<?=$shade['shade_id']; ?>" <?=($shade['shade_id'] == $shade_id)?'selected="selected"':''; ?>><?=$shade['shade_code']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>                                                </div>                                            </section>

                                        <!-- End Color Recipes -->
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" name="search" value="search">Search</button>
                            </header>
                        </section>
                      </form>

                      <section class="panel">
                          <header class="panel-heading">
                              Recipe Master
                          </header>
                          <div class="panel-body">
                            <table class="table table-striped border-top" id="sample_1">
                              <thead>
                                <tr>
                                  <th>Recipe No</th>
                                  <th>Date Time</th>
                                  <th>Color Name</th>
                                  <th>Color Code</th>
                                  <th>Shade Code</th>
                                  <th>Dyes</th>
                                  <th>Chemicals</th>
                                  <th>Username</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                /*echo "<pre>";
                                print_r($recipe_list);
                                echo "</pre>";*/
                                foreach ($recipe_list as $row) {
                                  ?>
                                  <tr>
                                    <td><?=$row->recipe_id; ?></td>
                                    <td><?=date("d-m-Y H:i:s", strtotime($row->date)); ?></td>
                                    <td><?=$row->shade_name; ?></td>
                                    <td><?=$row->shade_id; ?></td>
                                    <td><?=$row->shade_code; ?></td>
                                    <td>
                                      <?php
                                      $shade_chemicals = json_decode($row->shade_chemicals);
                                      if(count($shade_chemicals) > 0)
                                      {
                                        foreach ($shade_chemicals as $chemical) {
                                          echo $chemical->chemical_name." - ".$chemical->chemical_value." ".$chemical->chemical_uom_name."<br>";
                                        }
                                      }
                                      ?>
                                    </td>
                                    <td>
                                      <?php
                                      $shade_dyes = json_decode($row->shade_dyes);
                                      if(count($shade_dyes) > 0)
                                      {
                                        foreach ($shade_dyes as $dyes) {
                                          echo $dyes->dyes_name." - ".$dyes->dyes_value." ".$dyes->dyes_uom_name."<br>";
                                        }
                                      }
                                      ?>
                                    </td>
                                    <td><?=$row->username; ?></td>
                                    <td>
                                      <a href="<?=base_url();?>masters/recipe_print/<?=$row->recipe_id; ?>" class="btn btn-warning btn-xs" target="_blank">Print</a>
                                      <a href="<?=base_url();?>masters/recipemaster/<?=$row->recipe_id; ?>" class="btn btn-primary btn-xs">Edit</a>
                                      <a href="<?=base_url();?>masters/deleterecipe/<?=$row->recipe_id; ?>" class="btn btn-danger btn-xs">Delete</a>
                                    </td>
                                  </tr>
                                  <?php
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                      </section>
                      <!-- Loading -->
                      <div class="pageloader"></div>
                      <!-- End Loading -->
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
        $("#shade_family").change(function () {
            var shade_family = $('#shade_family').val();
            var url = "<?=base_url(); ?>masters/getfamilydata/"+shade_family;
            // var postData = 'shade_family='+shade_family;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    $("shade_name").select2('destroy');
                    $("shade_code").select2('destroy');

                    var dataArray = result.split(',');
                    var select_text = '<option>Select</option>';
                    $("#shade_name").html(select_text+dataArray[0]);
                    $("#shade_code").html(select_text+dataArray[1]);

                    $("shade_name").select2();
                    $("shade_code").select2();
                    $("#shade_name").select2("val", ''); //set the value
                    $("#shade_code").select2("val", ''); //set the value
                }
            });
            return false;
        });
      });

      $(".shade").change(function(){
        $("#shade_name").select2("val", $(this).val());
        $("#shade_code").select2("val", $(this).val());
      });

  </script>

  </body>
</html>
