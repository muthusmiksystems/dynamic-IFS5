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
                                <h3><i class="icon-user"></i> Dyes &amp; Chemicals</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <?php
                      if(isset($dyes_chem_id))
                      {
                        $edit_dyes_chemicals = $this->m_masters->getmasterdetails('bud_dyes_chemicals','dyes_chem_id', $dyes_chem_id);
                        foreach ($edit_dyes_chemicals as $dyes_chemical) {
                          $dyes_chem_family = $dyes_chemical['dyes_chem_family'];
                          $dyes_chem_name = $dyes_chemical['dyes_chem_name'];
                          $dyes_chem_code = $dyes_chemical['dyes_chem_code'];
                          $dyes_chem_reorder = $dyes_chemical['dyes_chem_reorder'];
                          $dyes_open_stock = $dyes_chemical['dyes_open_stock'];
                          $dyes_rate = $dyes_chemical['dyes_rate'];
                          $dyes_chem_status = $dyes_chemical['dyes_chem_status'];
                        }
                      }
                      else
                      {
                        $dyes_chem_id = '';
                        $dyes_chem_family = '';
                        $dyes_chem_name = '';
                        $dyes_chem_code = '';
                        $dyes_chem_reorder = '';
                        $dyes_open_stock = '';
                        $dyes_rate = '';
                        $dyes_chem_status = '';
                      }
                      ?> 
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/dyes_chemicals_save">
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
                                <input type="hidden" name="dyes_chem_id" value="<?=$dyes_chem_id; ?>">                                                                                                                        <div class="form-group col-lg-4">
                                    <label for="dyes_chem_family">Family Name</label>
                                    <select class="select2 form-control" name="dyes_chem_family" required>
                                      <option value="">Select Family</option>
                                      <?php
                                      $dc_families = $this->m_masters->getactivemaster('bud_dyes_chem_families', 'dc_family_status');
                                      foreach ($dc_families as $dc_family) {
                                        ?>
                                        <option value="<?=$dc_family['dc_family_id']; ?>" <?=($dc_family['dc_family_id'] == $dyes_chem_family)?'selected="selected"':''; ?> ><?=$dc_family['dc_family_name']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="dyes_chem_name">Dyes (or) Chemical Name</label>
                                   <input class="form-control" id="dyes_chem_name" name="dyes_chem_name" value="<?=$dyes_chem_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="dyes_chem_code">Code No</label>
                                   <input class="form-control" id="dyes_chem_code" name="dyes_chem_code" value="<?=$dyes_chem_code; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="dyes_chem_reorder">Reorder Level</label>
                                   <input class="form-control" id="dyes_chem_reorder" name="dyes_chem_reorder" value="<?=$dyes_chem_reorder; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="dyes_open_stock">Opening Stock</label>
                                   <input class="form-control" id="dyes_open_stock" name="dyes_open_stock" value="<?=$dyes_open_stock; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="dyes_rate">Rate</label>
                                   <input class="form-control" id="dyes_rate" name="dyes_rate" value="<?=$dyes_rate; ?>" type="text" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="dyes_chem_status">Active</label>
                                    <input  type="checkbox" style="width: 20px;" <?=($dyes_chem_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="dyes_chem_status" name="dyes_chem_status" />
                                                            </div>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" <?=($dyes_chem_id != '')?'name="update"':'save'; ?>><?=($dyes_chem_id != '')?'Update':'Save'; ?></button>
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
                                <th>Dyes or Chemical</th>
                                <th>Family</th>
                                <th>Code No</th>
                                <th>Reorder Level</th>
                                <th>Opening Stock</th>
                                <th>Rate</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($dyes_chemicals as $dyes_chemical) {
                              ?>
                              <tr class="odd gradeX">
                                  <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
                                  <td><?=$sno; ?></td>
                                  <td><?=$dyes_chemical['dyes_chem_name']; ?></td>                                                        <td><?=$dyes_chemical['dyes_chem_family']; ?></td>                                                        <td><?=$dyes_chemical['dyes_chem_code']; ?></td>                                                        <td><?=$dyes_chemical['dyes_chem_reorder']; ?></td>                                                        <td><?=$dyes_chemical['dyes_open_stock']; ?></td>                                                        <td><?=$dyes_chemical['dyes_rate']; ?></td>                                                        <td class="hidden-phone">
                                    <span class="<?=($dyes_chemical['dyes_chem_status']==1)?'label label-success':'label label-danger'; ?>"><?=($dyes_chemical['dyes_chem_status']==1)?'Active':'Inactive'; ?></span>
                                  </td>
                                  <td>
                                    <a href="<?=base_url();?>masters/dyes_chemicals/<?=$dyes_chemical['dyes_chem_id']; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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
