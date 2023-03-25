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
                                <h3><i class="icon-user"></i> Recipe Master</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">                      
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/recipemaster_save">
                        <section class="panel">
                            <header class="panel-heading">
                                Recipe No : <label class="btn btn-danger"><strong><?=$nextshade; ?></strong></label><br>
                                <!-- Recipe Details -->
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
                                }                                  
                                if($this->session->flashdata('error'))
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
                                    <select class="select2 form-control" name="shade_family" id="shade_family" required>
                                      <option value="">Select Family</option>
                                      <?php
                                      $colors = $this->m_masters->getactivemaster('bud_color_families', 'family_status');
                                      foreach ($colors as $color) {
                                        ?>
                                        <option value="<?=$color['family_id']; ?>" ><?=$color['family_name']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="shade_name">Shade Name</label>
                                    <select class="select2 form-control" name="shade_name" id="shade_name" required>
                                      <option value="">Select Shade</option>
                                      <?php
                                      $shades = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
                                      foreach ($shades as $shade) {
                                        ?>
                                        <option value="<?=$shade['shade_id']; ?>"><?=$shade['shade_name']; ?> / <?=$shade['shade_id']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="shade_code">Shade Code</label>
                                    <select class="select2 form-control" name="shade_code" id="shade_code" required>
                                      <option value="">Select Code</option>
                                      <?php
                                      $shades = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
                                      foreach ($shades as $shade) {
                                        ?>
                                        <option value="<?=$shade['shade_id']; ?>"><?=$shade['shade_code']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="shade_denier">Denier</label>
                                    <select class="select2 form-control" name="shade_denier" id="shade_denier" required>
                                      <option value="">Select Denier</option>
                                      <?php
                                      $deniers = $this->m_masters->getactivemaster('bud_deniermaster', 'denier_status');
                                      foreach ($deniers as $denier) {
                                        ?>
                                        <option value="<?=$denier['denier_id']; ?>"><?=$denier['denier_name']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="shade_poy_lot">POY Lot No</label>
                                    <select class="select2 form-control" name="shade_poy_lot" id="shade_poy_lot" required>
                                      <option value="">Select POY Lot</option>
                                      <?php
                                      $poy_lots = $this->m_masters->getactivemaster('bud_poy_lots', 'poy_status');
                                      foreach ($poy_lots as $poy_lot) {
                                        ?>
                                        <option value="<?=$poy_lot['poy_lot_id']; ?>"><?=$poy_lot['poy_lot_name']; ?></option>
                                        <?php
                                      }
                                      ?>  
                                    </select>
                                </div>                               
                            </div>                            
                        </section>
                        <!-- Start Color Recipes -->
                        <section class="panel">
                          <header class="panel-heading">
                            Chemicals
                          </header>
                          <div class="panel-body">
                            <!-- Loaded Recipe Data -->
                            <?php
                            $dyes_chemicals = $this->m_masters->getactivemaster('bud_dyes_chemicals', 'dyes_chem_status');
                            $uoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
                            ?>
                            <div class="form-group col-lg-3">
                                <label for="shade_chemicals">Chemicals</label>
                                <select class="select2 form-control" name="shade_chemicals" id="shade_chemicals">
                                  <option value="">Select Chemical</option>
                                  <?php
                                  foreach ($dyes_chemicals as $dyes_chemical) {
                                    ?>
                                    <option value="<?=$dyes_chemical['dyes_chem_id']; ?>"><?=$dyes_chemical['dyes_chem_name']; ?></option>
                                    <?php
                                  }
                                  ?>  
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="shade_chemicals_value">Value</label>
                                <input type="text" class="form-control" name="shade_chemicals_value" id="shade_chemicals_value">
                            </div>
                            <div class="form-group col-lg-2">
                                <label>UOM</label>
                                <select class="select2 form-control" name="shade_chemicals_uoms" id="shade_chemicals_uoms">
                                  <option value="">Select UOM</option>
                                  <?php                                  
                                  foreach ($uoms as $uom) {
                                    ?>
                                    <option value="<?=$uom['uom_id']; ?>"><?=$uom['uom_name']; ?></option>
                                    <?php
                                  }
                                  ?>  
                                </select>
                            </div>
                            <div class="form-group col-lg-1">
                              <label for="shade_chemicals">&nbsp;</label>
                              <button type="button" class="form-control btn btn-primary addchemicals"><i class="icon-plus"></i> Add</button>
                            </div>

                            <div class="col-lg-6" id="chemicalsdata">
                              <?php
                              $data['shade_id'] = $nextshade;
                              $this->load->view('v_chemicalsdata.php', $data);
                              ?>
                            </div>                            
                          </div>
                        </section>

                        <section class="panel">
                          <header class="panel-heading">
                            Dyes
                          </header>
                          <div class="panel-body" id="recipedata">
                            <!-- Loaded Recipe Data -->                            
                            <div class="form-group col-lg-3">
                                <label for="shade_dyes">Dyes</label>
                                <select class="select2 form-control" name="shade_dyes" id="shade_dyes">
                                  <option value="">Select Dyes</option>
                                  <?php
                                  foreach ($dyes_chemicals as $dyes_chemical) {
                                    ?>
                                    <option value="<?=$dyes_chemical['dyes_chem_id']; ?>"><?=$dyes_chemical['dyes_chem_name']; ?></option>
                                    <?php
                                  }
                                  ?>  
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="shade_dyes_value">Value</label>
                                <input type="text" class="form-control" name="shade_dyes_value" id="shade_dyes_value">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="shade_dyes">UOM</label>
                                <select class="select2 form-control" name="shade_dyes_uoms" id="shade_dyes_uoms">
                                  <option value="">Select UOM</option>
                                  <?php                                  
                                  foreach ($uoms as $uom) {
                                    ?>
                                    <option value="<?=$uom['uom_id']; ?>"><?=$uom['uom_name']; ?></option>
                                    <?php
                                  }
                                  ?>  
                                </select>
                            </div>
                            <div class="form-group col-lg-1">
                              <label for="shade_chemicals">&nbsp;</label>
                              <button type="button" class="form-control btn btn-primary adddyes"><i class="icon-plus"></i> Add</button>
                            </div>
                            <div class="col-lg-6" id="dyesdata">
                              <?php
                              $this->load->view('v_dyesdata.php', $data);
                              ?>
                            </div>
                          </div>
                        </section>
                        <!-- End Color Recipes -->
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Update</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form>
                      <!-- Loading -->
                      <div class="pageloader"></div>
                      <!-- End Loading -->
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
        $("#shade_name").change(function () {
            var shade_name = $('#shade_name').val();
            var url = "<?=base_url()?>masters/recipedata/"+shade_name;
            var postData = 'shade_name='+shade_name;
            $("#shade_code").val(shade_name);
            $("#shade_code").select2("val", shade_name); //set the value
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    // $('#recipedata').load('<?=base_url();?>masters/recipedata/'+shade_name);
                    $('#chemicalsdata').load('<?=base_url();?>masters/chemicalsdata/'+shade_name);
                    $('#dyesdata').load('<?=base_url();?>masters/dyesdata/'+shade_name);
                }
            });
            return false;
        });
      });
      $(function(){
        $("#shade_code").change(function () {
            var shade_code = $('#shade_code').val();
            var url = "<?=base_url()?>masters/recipedata/"+shade_code;
            var postData = 'shade_code='+shade_code;
            $("#shade_name").val(shade_code);
            $("#shade_name").select2("val", shade_code); //set the value
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                    // $('#recipedata').load('<?=base_url();?>masters/recipedata/'+shade_code);
                    $('#chemicalsdata').load('<?=base_url();?>masters/chemicalsdata/'+shade_code);
                    $('#dyesdata').load('<?=base_url();?>masters/dyesdata/'+shade_code);
                }
            });
            return false;
        });
      });

      $(function(){
        $("#shade_family").change(function () {
            var shade_family = $('#shade_family').val();
            var url = "<?=base_url()?>masters/getfamilydata/"+shade_family;
            var postData = 'shade_family='+shade_family;
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

      $(function(){
        $(".addchemicals").click(function () {
            var shade_code = $('#shade_code').val();
            var shade_chemicals = $('#shade_chemicals').val();
            var shade_chemicals_value = $('#shade_chemicals_value').val();
            var shade_chemicals_uoms = $('#shade_chemicals_uoms').val();
            var url = "<?=base_url()?>masters/addchemicals";
            var postData = 'nextshade='+shade_code+'&shade_chemicals='+shade_chemicals+'&shade_chemicals_value='+shade_chemicals_value+'&shade_chemicals_uoms='+shade_chemicals_uoms;            
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function(result)
                {
                    $('#chemicalsdata').load('<?=base_url();?>masters/chemicalsdata/'+shade_code);
                }
            });
            return false;
        });
      });

      $(".delete-chemical").live('click', function(){
        var chemical_id = $(this).attr('id');
        var shade_code = $('#shade_code').val();
        var url = "<?=base_url()?>masters/deletechemical/"+chemical_id;
        // var postData = 'chemical_id='+chemical_id;
        $.ajax({
            type: "POST",
            url: url,
            // data: postData,
            success: function(result)
            {
                $('#chemicalsdata').load('<?=base_url();?>masters/chemicalsdata/'+shade_code);
            }
        });

        return false;
      });

      $(function(){
        $(".adddyes").click(function () {
            var shade_code = $('#shade_code').val();
            var shade_dyes = $('#shade_dyes').val();
            var shade_dyes_value = $('#shade_dyes_value').val();
            var shade_dyes_uoms = $('#shade_dyes_uoms').val();
            var url = "<?=base_url()?>masters/adddyes";
            var postData = 'nextshade='+shade_code+'&shade_dyes='+shade_dyes+'&shade_dyes_value='+shade_dyes_value+'&shade_dyes_uoms='+shade_dyes_uoms;            
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function(result)
                {
                    $('#dyesdata').load('<?=base_url();?>masters/dyesdata/'+shade_code);
                }
            });
            return false;
        });
      });
      $(".delete-dyes").live('click', function(){
        var chemical_id = $(this).attr('id');
        var shade_code = $('#shade_code').val();
        var url = "<?=base_url()?>masters/deletedyes/"+chemical_id;
        // var postData = 'chemical_id='+chemical_id;
        $.ajax({
            type: "POST",
            url: url,
            // data: postData,
            success: function(result)
            {
                $('#dyesdata').load('<?=base_url();?>masters/dyesdata/'+shade_code);
            }
        });

        return false;
      });
  </script>

  </body>
</html>
