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
                                <h3><i class="icon-user"></i> Color Family Master</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <?php
                      if(isset($family_id))
                      {
                        $editcolors = $this->m_masters->getmasterdetails('bud_color_families','family_id', $family_id);
                        foreach ($editcolors as $color) {
                          $family_name = $color['family_name'];
                          $family_status = $color['family_status'];
                        }
                      }
                      else
                      {
                        $family_id = '';
                        $family_name = '';
                        $family_status = '';
                      }
                      ?> 
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/colorfamily_save">
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
                                <input type="hidden" name="family_id" value="<?=$family_id; ?>">                                                                                                                        <div class="form-group col-lg-12">
                                    <label for="family_name" class="control-label col-lg-2">Family Name</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" id="family_name" name="family_name" value="<?=$family_name; ?>" type="text" required>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label class="control-label col-lg-2">Color Category</label>
                                    <div class="col-lg-10">
                                      Masrer Link
                                    </div>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label for="family_status" class="control-label col-lg-2">Active</label>
                                    <div class="">
                                        <input  type="checkbox" style="width: 20px;float:left;" <?=($family_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="family_status" name="family_status" />
                                    </div>
                                </div>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" <?=($family_id != '')?'name="update"':'save'; ?>><?=($family_id != '')?'Update':'Save'; ?></button>
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
                                <th>Sno</th>
                                <th>Family Name</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($colors as $color) {
                              ?>
                              <tr class="odd gradeX">
                                  <td><?=$sno; ?></td>
                                  <td><?=$color['family_name']?></td>                                                           <td class="hidden-phone">
                                    <span class="<?=($color['family_status']==1)?'label label-success':'label label-danger'; ?>"><?=($color['family_status']==1)?'Active':'Inactive'; ?></span>
                                  </td>
                                  <td>
                                    <a href="<?=base_url();?>masters/colorfamily/<?=$color['family_id']; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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
