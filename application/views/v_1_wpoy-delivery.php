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
                                <h3><i class="icon-truck"></i> Wastage POY Delivery</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post">
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
                                <!-- 
                                <div class="form-group col-lg-12">
                                   <label >Issue No : </label>
                                   <span class="label label-danger" style="padding: 0 1em;font-size:24px;"><? ?></span>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="delivery_from">Delivery From</label>
                                   <select class="select2 form-control" id="delivery_from" name="delivery_from" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($departments as $row) {
                                        ?>
                                        <option value="<?=$row['dept_id']; ?>"><?=$row['dept_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="delivery_to">Delivery To</label>
                                   <select class="select2 form-control" id="delivery_to" name="delivery_to" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($departments as $row) {
                                        ?>
                                        <option value="<?=$row['dept_id']; ?>"><?=$row['dept_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div style="clear:both;"></div>
                                <div class="form-group col-lg-2">
                                   <label for="item_name">Item Name</label>
                                   <select class="select2 form-control itemsselects" id="item_name" name="item_name" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($items as $row) {
                                        ?>
                                        <option value="<?=$row['item_id']; ?>"><?=$row['item_name']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2">
                                   <label for="item_id">Item Code</label>
                                   <select class="select2 form-control itemsselects" id="item_id" name="item_id" required>
                                      <option value="">Select</option>
                                      <?php
                                      foreach ($items as $row) {
                                        ?>
                                        <option value="<?=$row['item_id']; ?>"><?=$row['item_id']; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2">
                                   <label for="poy_denier">POY Denier</label>
                                   <select class="select2 form-control" id="poy_denier" name="poy_denier">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($poy_deniers as $row) {
                                      ?>
                                      <option value="<?=$row['denier_id']; ?>"><?=$row['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2">
                                   <label for="yarn_denier">Yarn Denier</label>
                                   <select class="select2 form-control" id="yarn_denier" name="yarn_denier">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($yarn_deniers as $row) {
                                      ?>
                                      <option value="<?=$row['denier_id']; ?>"><?=$row['denier_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2">
                                   <label for="po_qty">Qty</label>
                                   <input type="text" class="form-control" id="po_qty" name="po_qty">
                                </div>
                                <div class="form-group col-lg-2">
                                   <label for="item_uom">UOM</label>
                                   <select class="select2 form-control" id="item_uom" name="item_uom">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($uoms as $row) {
                                      ?>
                                      <option value="<?=$row['uom_id']; ?>"><?=$row['uom_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-1">
                                   <label>&nbsp;</label>
                                   <div style="clear:both;"></div>
                                   <button class="btn btn-primary" type="button" id="addtocart">Add</button>
                                </div>
                            </div> -->
                            <!-- Loading -->
                                                    <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                           <!-- <th>Issue To</th>
                                <th>Supplier Group</th>
                                <th>Supplier</th>  -->
                                <th>POY Denier</th>
                                <th>POY Lot</th>
                                <th>Qty</th>
                                <th>Uom</th>
                                <th>Date</th>
                                <th>Wastage</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($poy_issue as $row) {
                              $id = $row['id'];
                              $is_accepted = $row['is_accepted'];
                              if($id != '' && $is_accepted==1 && $row['wpoy_status'] != "2" )
                              {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['item_name']; ?></td>                                                             <td><?=$row['item_id']; ?></td>                                                        <!-- <td><?=$row['dept_name']; ?></td>                                                             <td><?=$row['group_name']; ?></td>                                                              <td><?=$row['sup_name']; ?></td> -->
                                    <td><?=$row['denier_name']; ?></td>
                                    <td><?=$row['poy_lot_name']; ?></td>
                                    <td><?=$row['qty']; ?></td>
                                    <td><?=$row['uom_name']; ?></td>
                                    <td><?=$row['issue_datetime']; ?></td>
                                    <td><input type="text" id="waste<?=$row['issue_no'];?>" <?php echo ($row['wpoy_status'] != 0)?'disabled':''; ?> value="<?=$row['wastage_kg']; ?>"></td>
                                    <td>
                                      <span <?php if($row['wpoy_status'] == 0 ) { ?> onclick="complete_send(<?=$row['issue_no'];?>)"<?php } ?> class="<?=($row['wpoy_status']!=0)?'label label-success':'label label-danger'; ?>"><?=($row['wpoy_status']==0)?'save':'waiting'; ?></span>
                                    </td>
                                </tr>
                                <?php                                                      }
                              $sno++;
                            }
                            ?>
                          </tbody>
                        </table>

                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>

                      </form> 
                                         <!-- End Talbe List  -->                               </div>
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


      function complete_send(id)
      {
        var weight = $("#waste"+id).val();
        if( weight != "" )
        {
          $.ajax({
            type : "POST",
            url  : "<?=base_url(); ?>poy/wpoy_dele/"+id+"/"+weight,
            success: function(ele){
              location.reload();
            }
          })
        }
        else
        {
          alert("enter weight");
        }
      }
  </script>

  </body>
</html>
