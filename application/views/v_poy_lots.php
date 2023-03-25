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
                                <h3><i class="icon-user"></i> POY Lot Master</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <?php
                      if(isset($poy_lot_id))
                      {
                        $editpoylots = $this->m_masters->getmasterdetails('bud_poy_lots','poy_lot_id', $poy_lot_id);
                        foreach ($editpoylots as $poy_lot) {
                          $poy_lot_name = $poy_lot['poy_lot_name'];
                          $poy_lot_no = $poy_lot['poy_lot_no'];
                          $poy_reorder = $poy_lot['poy_reorder'];
                          $poy_lot_uom = $poy_lot['poy_lot_uom'];
                          $poy_status = $poy_lot['poy_status'];
                        }
                      }
                      else
                      {
                        $poy_lot_id = '';
                        $poy_lot_name = '';
                        $poy_lot_no = '';
                        $poy_reorder = '';
                        $poy_lot_uom = '';
                        $poy_status = '';
                      }
                      ?> 
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/poy_lots_save">
                        <section class="panel">
                            <header class="panel-heading">
                                POY Lot Details
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
                                <input type="hidden" name="poy_lot_id" value="<?=$poy_lot_id; ?>">                                                                                                                        <div class="form-group col-lg-12">
                                    <label for="poy_lot_name" class="control-label col-lg-2">POY Lot Name</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" id="poy_lot_name" name="poy_lot_name" value="<?=$poy_lot_name; ?>" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="poy_lot_no" class="control-label col-lg-2">POY Lot No</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" id="poy_lot_no" name="poy_lot_no" value="<?=$poy_lot_no; ?>" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="poy_reorder" class="control-label col-lg-2">Re-order Level</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" id="poy_reorder" name="poy_reorder" value="<?=$poy_reorder; ?>" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="poy_lot_uom" class="control-label col-lg-2">UOM</label>
                                    <div class="col-lg-10">
                                      <select class="select2 form-control" id="poy_lot_uom" name="poy_lot_uom" required>
                                        <option value="">Select UOM</option>
                                        <?php
                                        foreach ($uoms as $uom) {
                                          ?>
                                          <option value="<?=$uom['uom_id']; ?>" <?=($uom['uom_id'] == $poy_lot_uom)?'selected="selected"':''; ?>><?=$uom['uom_name']; ?></option>
                                          <?php
                                        }
                                        ?>
                                      </select>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label for="poy_status" class="control-label col-lg-2">Active</label>
                                    <div class="">
                                        <input  type="checkbox" style="width: 20px;float:left;" <?=($poy_status == 1)?'checked="ckecked"':''; ?> class="checkbox form-control" value="1" id="poy_status" name="poy_status" />
                                    </div>
                                </div>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" <?=($poy_lot_id != '')?'name="update"':'save'; ?>><?=($poy_lot_id != '')?'Update':'Save'; ?></button>
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
                                <th>Lot Name</th>
                                <th>Lot No</th>
                                <th>Reorder</th>
                                <th>Uom</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($poy_lots as $poy_lot) {
                              ?>
                              <tr class="odd gradeX">
                                  <td><?=$sno; ?></td>
                                  <td><?=$poy_lot['poy_lot_name']; ?></td>                                                           <td><?=$poy_lot['poy_lot_no']; ?></td>                                                           <td><?=$poy_lot['poy_reorder']; ?></td>                                                           <td><?=$poy_lot['poy_lot_uom']; ?></td>                                                           <td class="hidden-phone">
                                    <span class="<?=($poy_lot['poy_status']==1)?'label label-success':'label label-danger'; ?>"><?=($poy_lot['poy_status']==1)?'Active':'Inactive'; ?></span>
                                  </td>
                                  <td>
                                    <a href="<?=base_url();?>masters/poy_lots/<?=$poy_lot['poy_lot_id']; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
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
