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
                                <h3>Dyes and Chemicals Inward Entry</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url('purchase_order/dyes_chem_inward/'.$inward_no.'/'.$new); ?>">
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
								
                                <div class="form-group col-lg-12">
                                   <label >R PO No : </label>
                                   <span class="label label-danger" style="padding: 0 1em;font-size:24px;"><?=$next; ?></span>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="dc_family_id">Item Family</label>
                                     <select class="select2 form-control" id="dc_family_id" name="dc_family_id" required placeholder="Select Family">
                                      <option value=""></option>
                                      <?php
                                      foreach ($dyes_chem_families as $row) {
                                        ?>
                                        <option value="<?=$row['dc_family_id']; ?>" <?=($row['dc_family_id'] == $dc_family_id)?'selected="selected"':''; ?>><?=$row['dc_family_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="dyes_chem_id">Item Name</label>
                                     <select class="select2 form-control" id="dyes_chem_id" name="dyes_chem_id" required placeholder="Select Item">
                                        <option value=""></option>
                                        <?php
                                        foreach ($dyes_chems as $dyes_chem => $dyes_chem_name) {
                                          ?>
                                          <option value="<?=$dyes_chem; ?>" <?=($dyes_chem == $dyes_chem_id)?'selected="selected"':''; ?>><?=$dyes_chem_name; ?></option>
                                          <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="sup_id">Supplier Name / No</label>
                                     <select class="select2 form-control" id="sup_id" name="sup_id" required placeholder="Select Supplier">
                                        <option value=""></option>
                                        <?php
                                        foreach ($suppliers as $row) {
                                          ?>
                                          <option value="<?=$row['sup_id']; ?>" <?=($row['sup_id'] == $sup_id)?'selected="selected"':''; ?>><?=$row['sup_name']; ?> / <?=$row['sup_id']; ?></option>
                                          <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="sup_dc_no">Sup Dc No</label>
                                   <input type="text" class="form-control" id="sup_dc_no" name="sup_dc_no" value="<?=$sup_dc_no; ?>" required>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="qty_received">Qty Received</label>
                                   <input type="text" class="form-control" id="qty_received" name="qty_received" value="<?=$qty_received; ?>" required>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="uom_id">UOM</label>
                                     <select class="select2 form-control" id="uom_id" name="uom_id" required placeholder="Select UOM">
                                        <option value=""></option>
                                        <?php
                                        foreach ($uoms as $row) {
                                          ?>
                                          <option value="<?=$row['uom_id']; ?>" <?=($row['uom_id'] == $uom_id)?'selected="selected"':''; ?>><?=$row['uom_name']; ?></option>
                                          <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="item_rate">Rate</label>
                                   <input type="text" class="form-control" id="item_rate" name="item_rate" value="<?=$item_rate; ?>" required>
                                </div>
                            </div>
                        </section>
                                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" name="save" value="save">Save</button>
                            </header>
                        </section>
                      </form>

                      <section class="panel">
                        <header class="panel-heading">
                            Summary
                        </header>
                        <div class="panel-body">
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                <th>S.No</th>
                                <th>Inw.No</th>
                                <th>Date</th>
                                <th>Item Name</th>
                                <th>Supplier</th>
                                <th>Qty Received</th>
                                <th>UOM</th>
                                <th>Rate</th>
                                <th>Username</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($register as $row) {
                                ?>
                                <tr>
                                  <td><?=$sno; ?></td>
                                  <td><?=$row->inward_no; ?></td>
                                  <td><?=$row->inward_date; ?></td>
                                  <td><?=$row->dyes_chem_name; ?>/<?=$row->dyes_chem_code; ?></td>
                                  <td><?=$row->sup_name; ?></td>
                                  <td><?=$row->qty_received; ?></td>
                                  <td><?=$row->uom_name; ?></td>
                                  <td><?=$row->item_rate; ?></td>
                                  <td><?=$row->inward_by; ?></td>
                                  <td>
                                    <a href="<?=base_url('purchase_order/dyes_chem_inward/'.$row->inward_no); ?>" class="btn btn-xs btn-primary">Edit</a>
                                    <a href="<?=base_url('purchase_order/dyes_chem_inward/'.$row->inward_no.'/new'); ?>" class="btn btn-xs btn-warning">New Po</a>
                                  </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </section>
                    <!-- End Talbe List  -->                               </div>
                </div>             <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
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

    $('#dc_family_id').change(function(){
        $.post("<?php echo base_url('purchase_order/get_dyes_chem');?>",
        {
            dc_family_id:$('#dc_family_id').val()
        }, function(data) {
            var data = $.parseJSON(data);

            $("#dyes_chem_id").html('');
            $("#dyes_chem_id").select2('destroy');
            var dyes_chem = data.dyes_chem;
            var resultData = '';
            $.each(data.dyes_chem, function(dyes_chem_id,dyes_chem_name){
                resultData += '<option value="'+dyes_chem_id+'">'+dyes_chem_name+'</option>';
                $("#dyes_chem_id").html(resultData);
            });
            $("#dyes_chem_id").select2();
            // console.log(data);
        });        });

  </script>

  </body>
</html>
