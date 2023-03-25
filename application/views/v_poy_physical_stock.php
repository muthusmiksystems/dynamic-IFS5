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
                    <div class="col-lg-12">                                    <form class="cmxform tasi-form" role="form" id="commentForm" method="post" action="<?=base_url('store/poy_physical_stock'.$id); ?>">
                        <section class="panel">
                            <header class="panel-heading">
                                Update POY Physical Stock
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
                                <div class="form-group col-lg-3">
                                   <label for="denier_id">POY Denier</label>
                                    <select class="select2 form-control" id="denier_id" name="denier_id" required placeholder="Select Denier">
                                    <option value=""></option>
                                      <?php
                                      foreach ($poydeniers as $row) {
                                        ?>
                                        <option value="<?=$row['denier_id']; ?>"><?=$row['denier_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="poy_lot_id">POY Lot</label>
                                    <select class="select2 form-control" id="poy_lot_id" name="poy_lot_id" required placeholder="Select Poy Lot">
                                    <option value=""></option>
                                      <?php
                                      foreach ($poy_lots as $row) {
                                        ?>
                                        <option value="<?=$row['poy_lot_id']; ?>"><?=$row['poy_lot_no']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="closing_stock">Closing Stock</label>
                                    <input class="form-control" id="closing_stock" name="closing_stock" required>                                                            </div>
                                <div class="form-group col-lg-3">
                                   <label for="uom_id">POY Lot</label>
                                    <select class="select2 form-control" id="uom_id" name="uom_id" required placeholder="Select Uom">
                                    <option value=""></option>
                                      <?php
                                      foreach ($uoms as $row) {
                                        ?>
                                        <option value="<?=$row['uom_id']; ?>"><?=$row['uom_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                   <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                </div>
                            </div>
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" name="submit" value="submit">Save</button>
                            </header>
                        </section>
                      </form>
                      <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            Stock List
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Poy Denier</th>
                                <th>Poy Lot</th>
                                <th>Closing Stock</th>
                                <th>Uom</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            foreach ($stock_list as $row) {
                              ?>
                              <tr>
                                <td><?=$row->id; ?></td>
                                <td><?=$row->denier_name; ?></td>
                                <td><?=$row->poy_lot_no; ?></td>
                                <td><?=$row->closing_stock; ?></td>
                                <td><?=$row->uom_name; ?></td>
                                <td><?=$row->remarks; ?></td>
                                <td>
                                  <a href="<?=base_url('store/print_physical_stock/'.$row->id); ?>" class="btn btn-xs btn-primary" title="Print" target="_blank">Print</a>
                                </td>
                              </tr>
                              <?php
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
